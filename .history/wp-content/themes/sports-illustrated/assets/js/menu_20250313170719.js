document.addEventListener('DOMContentLoaded', function() {
    const menuButtons = document.querySelectorAll('.menu-btn');
    const menuContainers = document.querySelectorAll('.menu-image-container, .written-menu-wrapper, .image-section');
    
    // Make sure all elements are visible initially
    document.querySelectorAll('.menu-image-container, .written-menu-wrapper, .image-section').forEach(container => {
        if (container.classList.contains('active')) {
            container.style.display = container.classList.contains('menu-image-container') || container.classList.contains('image-section') ? 'flex' : 'block';
            container.style.opacity = '1';
        } else {
            container.style.display = 'none';
        }
    });

    function switchMenu(menuType, button) {
        console.log('Switching to menu:', menuType);
        
        // Update button states
        menuButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Find the button for this menu type and activate it
        let activeButton = button;
        if (!activeButton) {
            menuButtons.forEach(btn => {
                if (btn.dataset.menu === menuType) {
                    activeButton = btn;
                    btn.classList.add('active');
                }
            });
        } else {
            activeButton.classList.add('active');
        }

        // Update container visibility
        menuContainers.forEach(container => {
            if (container.dataset.menu === menuType) {
                // Set appropriate display type based on container type
                if (container.classList.contains('menu-image-container') || container.classList.contains('image-section')) {
                    container.style.display = 'flex';
                } else {
                    container.style.display = 'block';
                }
                container.classList.add('active');
                // Add fade-in animation
                container.style.opacity = '0';
                setTimeout(() => {
                    container.style.opacity = '1';
                }, 50);
            } else {
                container.classList.remove('active');
                container.style.display = 'none';
            }
        });

        // Update URL without reloading the page
        if (activeButton && activeButton.dataset.url) {
            // Use the pre-generated URL from the button
            window.history.pushState({}, '', activeButton.dataset.url);
        } else {
            // Fallback to the old method
            const url = new URL(window.location);
            
            // Check if we're using page_id parameter
            if (url.searchParams.has('page_id')) {
                // Keep the page_id parameter and update the menu parameter
                url.searchParams.set('menu', menuType);
                window.history.pushState({}, '', url);
            } else {
                // We're using the pretty permalink structure
                url.searchParams.set('menu', menuType);
                window.history.pushState({}, '', url);
            }
        }
    }

    // Add click handlers to buttons
    menuButtons.forEach(button => {
        button.addEventListener('click', function() {
            const menuType = this.dataset.menu;
            switchMenu(menuType, this);
        });
    });

    // Check URL parameters on load
    const urlParams = new URLSearchParams(window.location.search);
    const menuParam = urlParams.get('menu');
    if (menuParam) {
        switchMenu(menuParam);
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const menuParam = urlParams.get('menu') || 'full';
        switchMenu(menuParam);
    });
}); 