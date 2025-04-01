document.addEventListener('DOMContentLoaded', function() {
    // Menu switching functionality
    const menuButtons = document.querySelectorAll('.menu-button');
    const menuContainers = document.querySelectorAll('.menu-image-container');

    // Show the first menu by default
    if (menuContainers.length > 0) {
        menuContainers[0].style.display = 'block';
        menuButtons[0]?.classList.add('active');
    }

    menuButtons.forEach(button => {
        button.addEventListener('click', function() {
            const menuType = this.dataset.menu;
            
            // Hide all menus
            menuContainers.forEach(container => {
                container.style.display = 'none';
            });
            
            // Remove active class from all buttons
            menuButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected menu and activate button
            document.getElementById(`menu-${menuType}`).style.display = 'block';
            this.classList.add('active');
        });
    });

    // Gallery functionality
    if (typeof siMenuGallery !== 'undefined' && siMenuGallery.images.length > 0) {
        let currentSlide = 0;
        const galleryContainer = document.querySelector('.menu-gallery');
        
        // Create slides
        siMenuGallery.images.forEach((image, index) => {
            const slide = document.createElement('div');
            slide.className = `menu-gallery-slide${index === 0 ? ' active' : ''}`;
            slide.style.backgroundImage = `url(${image})`;
            galleryContainer.appendChild(slide);
        });
        
        const slides = galleryContainer.querySelectorAll('.menu-gallery-slide');
        
        // Rotate slides
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, siMenuGallery.speed);
    }
}); 