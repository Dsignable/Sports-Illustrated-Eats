document.addEventListener('DOMContentLoaded', function() {
    const menuButtons = document.querySelectorAll('.menu-btn');
    const menuContainers = document.querySelectorAll('.menu-image-container');
    
    // Make sure all elements are visible initially
    document.querySelectorAll('.menu-image-container').forEach(container => {
        if (container.classList.contains('active')) {
            container.style.display = 'flex';
            container.style.opacity = '1';
        } else {
            container.style.display = 'none';
        }
    });

    function switchMenu(menuType) {
        console.log('Switching to menu:', menuType);
        
        // Update button states
        menuButtons.forEach(button => {
            button.classList.remove('active');
            if (button.dataset.menu === menuType) {
                button.classList.add('active');
            }
        });

        // Update container visibility
        menuContainers.forEach(container => {
            if (container.dataset.menu === menuType) {
                container.style.display = 'flex';
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
        const url = new URL(window.location);
        
        // Check if we're using page_id parameter
        if (url.searchParams.has('page_id')) {
            // Keep the page_id parameter and update the menu parameter
            const pageId = url.searchParams.get('page_id');
            url.searchParams.set('menu', menuType);
            window.history.pushState({}, '', url);
        } else {
            // We're using the pretty permalink structure
            url.searchParams.set('menu', menuType);
            window.history.pushState({}, '', url);
        }
    }

    // Add click handlers to buttons
    menuButtons.forEach(button => {
        button.addEventListener('click', function() {
            const menuType = this.dataset.menu;
            switchMenu(menuType);
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