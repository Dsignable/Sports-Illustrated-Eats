document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation script loaded and running');
    
    // Get elements
    const header = document.querySelector('.site-header');
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const body = document.body;
    const mainContent = document.querySelector('.site-main');
    const snapContainer = document.querySelector('.snap-scroll');
    const isHomePage = document.querySelector('.home-page') !== null;

    // Variables for scroll handling
    let lastScroll = 0;
    let lastScrollTimestamp = Date.now();
    let isScrolling = false;
    let scrollTimeout;
    let mouseAtTop = false;
    let lastSnapIndex = 0;
    let scrollDirection = 'none';

    // Debug element finding
    console.log('Elements found:', {
        header: header ? 'Found header' : 'No header found',
        hamburger: hamburger ? 'Found hamburger button' : 'No hamburger button found',
        mobileMenu: mobileMenu ? 'Found mobile menu' : 'No mobile menu found',
        snapContainer: snapContainer ? 'Found snap container' : 'No snap container found',
        isHomePage: isHomePage
    });

    if (!hamburger || !mobileMenu || !header) {
        console.error('Required elements not found. Menu functionality will not work.');
        return;
    }

    // Function to get current snap section index
    function getCurrentSnapIndex() {
        if (!snapContainer) return 0;
        const sections = snapContainer.querySelectorAll('.snap-section');
        const containerTop = snapContainer.scrollTop;
        const viewportHeight = window.innerHeight;
        return Math.round(containerTop / viewportHeight);
    }

    // Function to handle header visibility
    function handleHeaderVisibility(forceShow = false) {
        if (isHomePage && snapContainer) {
            const currentSnapIndex = getCurrentSnapIndex();
            const scrollingDown = currentSnapIndex > lastSnapIndex;
            const scrollingUp = currentSnapIndex < lastSnapIndex;
            
            console.log('Snap scroll:', {
                current: currentSnapIndex,
                last: lastSnapIndex,
                down: scrollingDown,
                up: scrollingUp
            });

            if (forceShow || mouseAtTop || currentSnapIndex === 0 || scrollingUp) {
                header.classList.remove('header-hidden');
            } else if (scrollingDown) {
                header.classList.add('header-hidden');
            }

            lastSnapIndex = currentSnapIndex;
        } else {
            // Regular scroll behavior for non-home pages
            const currentScroll = window.scrollY;
            const scrollDelta = currentScroll - lastScroll;
            
            // Only show header if explicitly scrolling up or forced
            if (forceShow || mouseAtTop || currentScroll <= 0) {
                header.classList.remove('header-hidden');
            } else if (Math.abs(scrollDelta) > 2) { // Add small threshold to prevent micro-movements
                if (scrollDelta > 0) {
                    // Scrolling down
                    header.classList.add('header-hidden');
                    scrollDirection = 'down';
                } else {
                    // Scrolling up
                    header.classList.remove('header-hidden');
                    scrollDirection = 'up';
                }
            }
            // When scrolling stops, maintain the last scroll direction state
            // Don't change header visibility when scrolling stops

            lastScroll = currentScroll;
        }
    }

    // Mouse position tracking
    document.addEventListener('mousemove', function(e) {
        mouseAtTop = e.clientY < 100;
        if (mouseAtTop) {
            handleHeaderVisibility(true);
        }
    });

    // Enhanced scroll event handler
    const scrollElement = isHomePage ? snapContainer : window;
    if (scrollElement) {
        scrollElement.addEventListener('scroll', function() {
            if (!isScrolling) {
                isScrolling = true;
                lastScrollTimestamp = Date.now();
            }

            handleHeaderVisibility();

            // Clear existing timeout
            clearTimeout(scrollTimeout);

            // Set new timeout
            scrollTimeout = setTimeout(() => {
                isScrolling = false;
                // Don't call handleHeaderVisibility here to maintain last state
            }, 150);
        }, { passive: true });
    }

    // Wheel event for more precise snap scroll detection
    if (isHomePage && snapContainer) {
        snapContainer.addEventListener('wheel', function(e) {
            clearTimeout(scrollTimeout);
            handleHeaderVisibility();
        }, { passive: true });
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
}); 