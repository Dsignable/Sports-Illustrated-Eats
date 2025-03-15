document.addEventListener('DOMContentLoaded', function() {
    const menuButtons = document.querySelectorAll('.menu-btn');
    const menuPdfs = document.querySelectorAll('.menu-pdf');

    function switchMenu(menuType) {
        // Update button states
        menuButtons.forEach(button => {
            button.classList.remove('active');
            if (button.dataset.menu === menuType) {
                button.classList.add('active');
            }
        });

        // Update PDF states
        menuPdfs.forEach(pdf => {
            pdf.classList.remove('active');
            if (pdf.dataset.menu === menuType) {
                pdf.classList.add('active');
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