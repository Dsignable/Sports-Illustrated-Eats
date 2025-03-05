document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation script loaded');
    alert('Navigation script loaded');
    
    // Get elements
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const body = document.body;

    console.log('Elements found:', {
        hamburger: hamburger ? 'yes' : 'no',
        mobileMenu: mobileMenu ? 'yes' : 'no'
    });

    if (hamburger && mobileMenu) {
        // Toggle menu on hamburger click
        hamburger.addEventListener('click', function(e) {
            console.log('Hamburger clicked');
            e.preventDefault();
            e.stopPropagation();
            
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            body.classList.toggle('menu-open');
            
            const isExpanded = this.classList.contains('active');
            this.setAttribute('aria-expanded', isExpanded);
            mobileMenu.setAttribute('aria-hidden', !isExpanded);
            
            console.log('Menu state:', {
                hamburgerActive: this.classList.contains('active'),
                menuActive: mobileMenu.classList.contains('active'),
                bodyMenuOpen: body.classList.contains('menu-open')
            });
        });

        // Close menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                console.log('Menu link clicked');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('active');
                mobileMenu.setAttribute('aria-hidden', 'true');
                body.classList.remove('menu-open');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.mobile-menu') && 
                !e.target.closest('.hamburger') && 
                mobileMenu.classList.contains('active')) {
                console.log('Clicked outside menu');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('active');
                mobileMenu.setAttribute('aria-hidden', 'true');
                body.classList.remove('menu-open');
            }
        });

        // Handle escape key
        document.addEventListener('keyup', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                console.log('Escape key pressed');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('active');
                mobileMenu.setAttribute('aria-hidden', 'true');
                body.classList.remove('menu-open');
            }
        });
    }

    // Scroll handling for header
    const header = document.querySelector('.site-header');
    let lastScroll = 0;
    let scrollTimer;

    window.addEventListener('scroll', function() {
        if (scrollTimer) {
            clearTimeout(scrollTimer);
        }

        scrollTimer = setTimeout(function() {
            const currentScroll = window.scrollY;

            if (currentScroll > lastScroll && currentScroll > 100) {
                // Scrolling down & past header
                header.classList.add('header-hidden');
            } else {
                // Scrolling up
                header.classList.remove('header-hidden');
            }

            lastScroll = currentScroll;
        }, 50);
    });
}); 