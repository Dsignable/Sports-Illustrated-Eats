document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation script loaded and running');
    
    // Get elements
    const header = document.querySelector('.site-header');
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const body = document.body;
    const mainContent = document.querySelector('.site-main');

    // Variables for scroll handling
    let lastScroll = 0;
    let isScrolling = false;
    let scrollTimeout;
    let isSnapScrolling = false;
    let mouseAtTop = false;

    // Debug element finding
    console.log('Elements found:', {
        header: header ? 'Found header' : 'No header found',
        hamburger: hamburger ? 'Found hamburger button' : 'No hamburger button found',
        mobileMenu: mobileMenu ? 'Found mobile menu' : 'No mobile menu found'
    });

    if (!hamburger || !mobileMenu || !header) {
        console.error('Required elements not found. Menu functionality will not work.');
        return;
    }

    // Function to handle header visibility
    function handleHeaderVisibility(forceShow = false) {
        const currentScroll = window.scrollY;
        
        // Always show header if mouse is at top or if forced
        if (mouseAtTop || forceShow) {
            header.classList.remove('header-hidden');
            return;
        }

        // Don't hide header if at top of page
        if (currentScroll <= 0) {
            header.classList.remove('header-hidden');
            return;
        }

        // Handle header visibility based on scroll direction
        if (currentScroll > lastScroll && currentScroll > 100) {
            // Scrolling down & past header
            header.classList.add('header-hidden');
        } else {
            // Scrolling up
            header.classList.remove('header-hidden');
        }

        lastScroll = currentScroll;
    }

    // Mouse position tracking
    document.addEventListener('mousemove', function(e) {
        mouseAtTop = e.clientY < 100;
        if (mouseAtTop) {
            handleHeaderVisibility(true);
        }
    });

    // Intersection Observer for snap sections
    const snapSections = document.querySelectorAll('.snap-section');
    if (snapSections.length) {
        const observerOptions = {
            threshold: [0, 0.1, 0.9, 1]
        };

        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    isSnapScrolling = true;
                    clearTimeout(scrollTimeout);
                    
                    // Update header visibility based on which section is visible
                    const sectionIndex = Array.from(snapSections).indexOf(entry.target);
                    handleHeaderVisibility(sectionIndex === 0);
                    
                    scrollTimeout = setTimeout(() => {
                        isSnapScrolling = false;
                    }, 100);
                }
            });
        }, observerOptions);

        snapSections.forEach(section => {
            sectionObserver.observe(section);
        });
    }

    // Scroll event handler with debouncing
    window.addEventListener('scroll', function() {
        if (!isSnapScrolling) {
            if (!isScrolling) {
                isScrolling = true;
                handleHeaderVisibility();
            }

            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                isScrolling = false;
                handleHeaderVisibility();
            }, 66); // ~15fps
        }
    }, { passive: true });

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
}); 