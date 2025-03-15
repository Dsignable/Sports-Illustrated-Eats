document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation script loaded and running');
    
    // Get elements
    const header = document.querySelector('.site-header');
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const body = document.body;
    const mainContent = document.querySelector('.site-main');
    const hasSnapScrolling = mainContent?.classList.contains('snap-scroll');

    // Variables for scroll handling
    let lastScroll = 0;
    let lastScrollTimestamp = 0;
    let isScrolling = false;
    let scrollTimeout;
    let mouseAtTop = false;

    // Debug element finding
    console.log('Elements found:', {
        header: header ? 'Found header' : 'No header found',
        hamburger: hamburger ? 'Found hamburger button' : 'No hamburger button found',
        mobileMenu: mobileMenu ? 'Found mobile menu' : 'No mobile menu found',
        hasSnapScrolling: hasSnapScrolling
    });

    if (!hamburger || !mobileMenu || !header) {
        console.error('Required elements not found. Menu functionality will not work.');
        return;
    }

    // Function to handle header visibility
    function handleHeaderVisibility(forceShow = false) {
        const currentScroll = window.scrollY;
        const currentTime = Date.now();
        const scrollSpeed = Math.abs(currentScroll - lastScroll) / (currentTime - lastScrollTimestamp);
        
        // Always show header if mouse is at top or if forced
        if (mouseAtTop || forceShow || currentScroll <= 0) {
            header.classList.remove('header-hidden');
            return;
        }

        // Handle header visibility based on scroll direction and speed
        if (hasSnapScrolling) {
            // For snap scrolling pages, use scroll speed to determine visibility
            if (scrollSpeed > 1) { // Threshold for snap scrolling speed
                if (currentScroll > lastScroll) {
                    header.classList.add('header-hidden');
                } else {
                    header.classList.remove('header-hidden');
                }
            }
        } else {
            // Normal scroll behavior
            if (currentScroll > lastScroll && currentScroll > 100) {
                header.classList.add('header-hidden');
            } else {
                header.classList.remove('header-hidden');
            }
        }

        lastScroll = currentScroll;
        lastScrollTimestamp = currentTime;
    }

    // Mouse position tracking
    document.addEventListener('mousemove', function(e) {
        mouseAtTop = e.clientY < 100;
        if (mouseAtTop) {
            handleHeaderVisibility(true);
        }
    });

    // Enhanced scroll event handler
    let scrollEndTimeout;
    window.addEventListener('scroll', function() {
        if (!isScrolling) {
            isScrolling = true;
            lastScrollTimestamp = Date.now();
        }

        handleHeaderVisibility();

        // Clear existing timeouts
        clearTimeout(scrollTimeout);
        clearTimeout(scrollEndTimeout);

        // Set new timeouts
        scrollTimeout = setTimeout(() => {
            isScrolling = false;
        }, 66); // ~15fps

        // Handle scroll end
        scrollEndTimeout = setTimeout(() => {
            // Show header if we're at section boundaries
            const viewportHeight = window.innerHeight;
            const scrollPosition = window.scrollY;
            const isAtSectionBoundary = scrollPosition % viewportHeight < 50 || 
                                      (viewportHeight - (scrollPosition % viewportHeight)) < 50;
            
            if (isAtSectionBoundary) {
                handleHeaderVisibility(true);
            }
        }, 150); // Adjust this value based on your snap scrolling animation duration
    }, { passive: true });

    // Wheel event for more precise snap scroll detection
    window.addEventListener('wheel', function(e) {
        if (hasSnapScrolling) {
            clearTimeout(scrollTimeout);
            const direction = e.deltaY > 0 ? 'down' : 'up';
            
            if (direction === 'down') {
                header.classList.add('header-hidden');
            } else {
                header.classList.remove('header-hidden');
            }

            scrollTimeout = setTimeout(() => {
                // Check if we're at a section boundary
                const viewportHeight = window.innerHeight;
                const scrollPosition = window.scrollY;
                const isAtSectionBoundary = scrollPosition % viewportHeight < 50 || 
                                          (viewportHeight - (scrollPosition % viewportHeight)) < 50;
                
                if (isAtSectionBoundary) {
                    handleHeaderVisibility(true);
                }
            }, 100);
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