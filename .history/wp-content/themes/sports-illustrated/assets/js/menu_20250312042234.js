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
        // Check if we're using the path format or query parameter format
        const currentPath = window.location.pathname;
        const isPathFormat = currentPath.match(/\/menu\/[^\/]+\/?$/);
        
        if (isPathFormat) {
            // If we're using path format (/menu/drink/), update the path
            const basePath = currentPath.replace(/\/menu\/[^\/]+\/?$/, '/menu/');
            const newPath = basePath + menuType + '/';
            window.history.pushState({}, '', newPath);
        } else {
            // Otherwise use the query parameter format (/menu/?menu=drink)
            const url = new URL(window.location);
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

    // Check URL parameters or path on load
    const urlParams = new URLSearchParams(window.location.search);
    const menuParam = urlParams.get('menu');
    
    // Check if we have a menu parameter in the URL
    if (menuParam) {
        switchMenu(menuParam);
    } else {
        // Check if we have a menu type in the path
        const currentPath = window.location.pathname;
        const pathMatch = currentPath.match(/\/menu\/([^\/]+)\/?$/);
        if (pathMatch && pathMatch[1]) {
            switchMenu(pathMatch[1]);
        }
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const menuParam = urlParams.get('menu');
        
        if (menuParam) {
            switchMenu(menuParam);
        } else {
            // Check if we have a menu type in the path
            const currentPath = window.location.pathname;
            const pathMatch = currentPath.match(/\/menu\/([^\/]+)\/?$/);
            if (pathMatch && pathMatch[1]) {
                switchMenu(pathMatch[1]);
            } else {
                // Default to full menu
                switchMenu('full');
            }
        }
    });
}); 