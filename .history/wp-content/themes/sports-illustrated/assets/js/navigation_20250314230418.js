document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation script loaded and running');
    
    // Get elements
    const header = document.querySelector('.site-header');
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const body = document.body;
    const dropdownWrappers = document.querySelectorAll('.menu-dropdown-wrapper');
    
    // Debug element finding
    console.log('Elements found:', {
        header: header ? 'Found header' : 'No header found',
        hamburger: hamburger ? 'Found hamburger button' : 'No hamburger button found',
        mobileMenu: mobileMenu ? 'Found mobile menu' : 'No mobile menu found',
        dropdowns: dropdownWrappers.length + ' dropdowns found'
    });

    if (!hamburger || !mobileMenu || !header) {
        console.error('Required elements not found. Menu functionality will not work.');
        return;
    }

    // Toggle menu on hamburger click with debounce
    let isProcessingClick = false;
    hamburger.addEventListener('click', function(e) {
        if (isProcessingClick) return;
        isProcessingClick = true;
        
        e.preventDefault();
        e.stopPropagation();
        
        requestAnimationFrame(() => {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            body.classList.toggle('menu-open');
            
            const isExpanded = this.classList.contains('active');
            this.setAttribute('aria-expanded', isExpanded);
            mobileMenu.setAttribute('aria-hidden', !isExpanded);
            
            setTimeout(() => {
                isProcessingClick = false;
            }, 100);
        });
    });

    // Handle dropdowns
    dropdownWrappers.forEach(wrapper => {
        const trigger = wrapper.querySelector('.has-dropdown');
        const dropdown = wrapper.querySelector('.menu-dropdown');
        
        if (!trigger || !dropdown) return;
        
        // For mobile
        if (window.innerWidth <= 991) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const isActive = dropdown.classList.contains('active');
                
                // Close all other dropdowns
                document.querySelectorAll('.menu-dropdown.active').forEach(d => {
                    if (d !== dropdown) d.classList.remove('active');
                });
                
                dropdown.classList.toggle('active');
                this.setAttribute('aria-expanded', !isActive);
            });
        }
    });

    // Close menu when clicking a link
    const menuLinks = mobileMenu.querySelectorAll('a:not(.has-dropdown)');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            requestAnimationFrame(() => {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
                body.classList.remove('menu-open');
                hamburger.setAttribute('aria-expanded', 'false');
                mobileMenu.setAttribute('aria-hidden', 'true');
            });
        });
    });

    // Close menu when clicking outside - with optimization
    let closeMenuTimeout;
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.mobile-menu') && 
            !e.target.closest('.hamburger') && 
            mobileMenu.classList.contains('active')) {
            
            clearTimeout(closeMenuTimeout);
            closeMenuTimeout = setTimeout(() => {
                requestAnimationFrame(() => {
                    hamburger.classList.remove('active');
                    mobileMenu.classList.remove('active');
                    body.classList.remove('menu-open');
                    hamburger.setAttribute('aria-expanded', 'false');
                    mobileMenu.setAttribute('aria-hidden', 'true');
                });
            }, 50);
        }
    });

    // Handle escape key
    document.addEventListener('keyup', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            requestAnimationFrame(() => {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
                body.classList.remove('menu-open');
                hamburger.setAttribute('aria-expanded', 'false');
                mobileMenu.setAttribute('aria-hidden', 'true');
            });
        }
    });

    // Optimize scroll performance
    let ticking = false;
    let lastScrollY = window.scrollY;
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(() => {
                const currentScrollY = window.scrollY;
                header.classList.toggle('scrolled', currentScrollY > 50);
                header.classList.toggle('header-hidden', currentScrollY > lastScrollY && currentScrollY > 100);
                lastScrollY = currentScrollY;
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
}); 