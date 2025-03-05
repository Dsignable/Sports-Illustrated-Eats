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
    }

    // Add click handlers to buttons
    menuButtons.forEach(button => {
        button.addEventListener('click', function() {
            const menuType = this.dataset.menu;
            switchMenu(menuType);
        });
    });
}); 