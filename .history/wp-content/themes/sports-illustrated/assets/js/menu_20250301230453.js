document.addEventListener('DOMContentLoaded', function() {
    const menuButtons = document.querySelectorAll('.menu-btn');
    const menuImages = document.querySelectorAll('.menu-image');

    function switchMenu(menuType) {
        // Update button states
        menuButtons.forEach(button => {
            button.classList.remove('active');
            if (button.dataset.menu === menuType) {
                button.classList.add('active');
            }
        });

        // Update image visibility
        menuImages.forEach(img => {
            if (img.dataset.menu === menuType) {
                img.style.display = 'block';
                img.classList.add('active');
                // Add fade-in animation
                img.style.opacity = '0';
                setTimeout(() => {
                    img.style.opacity = '1';
                }, 50);
            } else {
                img.classList.remove('active');
                img.style.display = 'none';
            }
        });

        // Update URL without reloading the page
        const url = new URL(window.location);
        url.searchParams.set('menu', menuType);
        window.history.pushState({}, '', url);
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