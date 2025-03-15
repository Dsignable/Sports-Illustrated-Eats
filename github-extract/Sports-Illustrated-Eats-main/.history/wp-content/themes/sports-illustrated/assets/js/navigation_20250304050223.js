document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation script loaded and running');
    
    // Get elements
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const header = document.querySelector('.site-header');
    const body = document.body;

    // Debug element finding
    console.log('Elements found:', {
        hamburger: hamburger ? 'Found hamburger button' : 'No hamburger button found',
        mobileMenu: mobileMenu ? 'Found mobile menu' : 'No mobile menu found',
        header: header ? 'Found header' : 'No header found'
    });

    if (!hamburger || !mobileMenu || !header) {
        console.error('Required elements not found. Menu functionality will not work.');
        return;
    }

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

    // Variables for scroll handling
    let lastScroll = 0;
    let isScrolling = false;
    let scrollTimeout;
    let mouseNearTop = false;

    // Handle mouse movement
    document.addEventListener('mousemove', function(e) {
        mouseNearTop = e.clientY <= 150;
        if (mouseNearTop && header.classList.contains('header-hidden')) {
            header.classList.remove('header-hidden');
        }
    });

    // Improved scroll handling with debouncing and snap scroll detection
    window.addEventListener('scroll', function() {
        if (!isScrolling) {
            requestAnimationFrame(function() {
                const currentScroll = window.scrollY;
                const scrollDelta = currentScroll - lastScroll;
                
                // Clear any existing scroll timeout
                if (scrollTimeout) {
                    clearTimeout(scrollTimeout);
                }

                // Don't hide header if mouse is near top
                if (mouseNearTop) {
                    header.classList.remove('header-hidden');
                    lastScroll = currentScroll;
                    isScrolling = false;
                    return;
                }

                // Handle normal scroll behavior
                if (Math.abs(scrollDelta) > 5) { // Threshold to prevent tiny movements
                    if (scrollDelta > 0 && currentScroll > 100) {
                        // Scrolling down & past header
                        header.classList.add('header-hidden');
                    } else {
                        // Scrolling up
                        header.classList.remove('header-hidden');
                    }
                }

                // Set a timeout to handle the end of scrolling
                scrollTimeout = setTimeout(function() {
                    isScrolling = false;
                    // If mouse is near top at end of scroll, show header
                    if (mouseNearTop) {
                        header.classList.remove('header-hidden');
                    }
                }, 150); // Adjust timeout as needed

                lastScroll = currentScroll;
                isScrolling = false;
            });
        }
        isScrolling = true;
    }, { passive: true });

    // Handle scroll end for snap scrolling
    document.addEventListener('scrollend', function() {
        if (mouseNearTop) {
            header.classList.remove('header-hidden');
        }
    });
}); 