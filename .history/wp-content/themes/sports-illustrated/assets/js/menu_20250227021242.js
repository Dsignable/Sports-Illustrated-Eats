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

        // Update image states
        menuImages.forEach(image => {
            image.classList.remove('active');
            if (image.dataset.menu === menuType) {
                image.classList.add('active');
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
}); 