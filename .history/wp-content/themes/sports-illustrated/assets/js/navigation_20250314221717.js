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

    // Function to handle header visibility
    function handleHeaderVisibility(forceShow = false) {
        if (isHomePage && snapContainer) {
            const currentSnapIndex = getCurrentSnapIndex();
            const scrollingDown = currentSnapIndex > lastSnapIndex;
            const scrollingUp = currentSnapIndex < lastSnapIndex;
            
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

            lastScroll = currentScroll;
        }
    }

    // Function to get current snap section index
    function getCurrentSnapIndex() {
        if (!snapContainer) return 0;
        const sections = snapContainer.querySelectorAll('.snap-section');
        const containerTop = snapContainer.scrollTop;
        const viewportHeight = window.innerHeight;
        return Math.round(containerTop / viewportHeight);
    }

    // Function to toggle mobile menu
    function toggleMobileMenu(show = null) {
        const isActive = show !== null ? show : !hamburger.classList.contains('active');
        
        if (isActive) {
            hamburger.classList.add('active');
            mobileMenu.classList.add('active');
            body.classList.add('menu-open');
            hamburger.setAttribute('aria-expanded', 'true');
            mobileMenu.setAttribute('aria-hidden', 'false');
        } else {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            body.classList.remove('menu-open');
            hamburger.setAttribute('aria-expanded', 'false');
            mobileMenu.setAttribute('aria-hidden', 'true');
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
        toggleMobileMenu();
    });

    // Close menu when clicking a link
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            console.log('Menu link clicked');
            toggleMobileMenu(false);
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.mobile-menu') && 
            !e.target.closest('.hamburger') && 
            mobileMenu.classList.contains('active')) {
            console.log('Clicked outside menu');
            toggleMobileMenu(false);
        }
    });

    // Handle escape key
    document.addEventListener('keyup', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            console.log('Escape key pressed');
            toggleMobileMenu(false);
        }
    });

    // Menu Dropdown Functionality
    const menuDropdowns = document.querySelectorAll('.menu-dropdown-wrapper');
    
    // For touch devices, toggle dropdown on click
    if ('ontouchstart' in window || navigator.maxTouchPoints) {
        menuDropdowns.forEach(dropdown => {
            const menuButton = dropdown.querySelector('.has-dropdown');
            const dropdownMenu = dropdown.querySelector('.menu-dropdown');
            
            if (menuButton && dropdownMenu) {
                menuButton.addEventListener('click', function(e) {
                    // If dropdown is not visible, prevent navigation and show dropdown
                    if (dropdownMenu.style.visibility !== 'visible') {
                        e.preventDefault();
                        
                        // Close all other dropdowns
                        document.querySelectorAll('.menu-dropdown').forEach(menu => {
                            if (menu !== dropdownMenu) {
                                menu.style.visibility = 'hidden';
                                menu.style.opacity = '0';
                                menu.style.transform = 'translateX(-50%) translateY(10px)';
                            }
                        });
                        
                        // Show this dropdown
                        dropdownMenu.style.visibility = 'visible';
                        dropdownMenu.style.opacity = '1';
                        dropdownMenu.style.transform = 'translateX(-50%) translateY(0)';
                    }
                });
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.menu-dropdown-wrapper')) {
                document.querySelectorAll('.menu-dropdown').forEach(menu => {
                    menu.style.visibility = '';
                    menu.style.opacity = '';
                    menu.style.transform = '';
                });
            }
        });
    }
    
    // Handle keyboard navigation
    menuDropdowns.forEach(dropdown => {
        const menuButton = dropdown.querySelector('.has-dropdown');
        const dropdownMenu = dropdown.querySelector('.menu-dropdown');
        const dropdownItems = dropdown.querySelectorAll('.dropdown-item');
        
        if (menuButton && dropdownMenu && dropdownItems.length) {
            // Add keyboard navigation
            menuButton.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    dropdownMenu.style.visibility = 'visible';
                    dropdownMenu.style.opacity = '1';
                    dropdownMenu.style.transform = 'translateX(-50%) translateY(0)';
                    dropdownItems[0].focus();
                }
            });
            
            // Add keyboard navigation within dropdown
            dropdownItems.forEach((item, index) => {
                item.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (index < dropdownItems.length - 1) {
                            dropdownItems[index + 1].focus();
                        }
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (index > 0) {
                            dropdownItems[index - 1].focus();
                        } else {
                            menuButton.focus();
                            dropdownMenu.style.visibility = '';
                            dropdownMenu.style.opacity = '';
                            dropdownMenu.style.transform = '';
                        }
                    } else if (e.key === 'Escape') {
                        e.preventDefault();
                        menuButton.focus();
                        dropdownMenu.style.visibility = '';
                        dropdownMenu.style.opacity = '';
                        dropdownMenu.style.transform = '';
                    }
                });
            });
        }
    });
}); 