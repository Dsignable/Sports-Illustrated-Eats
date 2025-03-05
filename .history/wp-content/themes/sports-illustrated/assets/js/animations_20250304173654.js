document.addEventListener('DOMContentLoaded', () => {
    // Wait for the loading screen to finish
    const loadingScreen = document.querySelector('.loading-screen');
    if (loadingScreen) {
        loadingScreen.addEventListener('transitionend', initializeAnimations);
    } else {
        initializeAnimations();
    }
});

function initializeAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Determine animation direction based on position or data attribute
                const rect = entry.target.getBoundingClientRect();
                const windowWidth = window.innerWidth;
                let isLeftSide = rect.left < windowWidth / 2;

                // Override direction if data-animation attribute exists
                if (entry.target.dataset.animation === 'left') {
                    isLeftSide = true;
                } else if (entry.target.dataset.animation === 'right') {
                    isLeftSide = false;
                }

                // Apply appropriate animation class
                if (entry.target.classList.contains('gallery-item')) {
                    entry.target.classList.add('animate-in-up');
                } else {
                    entry.target.classList.add(isLeftSide ? 'animate-in' : 'animate-in-right');
                }
                
                // Stop observing after animation is triggered
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2,
        rootMargin: '0px'
    });

    // Elements to animate on all pages
    const commonElements = `
        .menu-card,
        .experience-card .brand-header,
        .experience-card .content-title,
        .experience-card .description,
        .experience-card .description-secondary,
        .experience-card .gallery-button,
        .experience-photo-top,
        .experience-photo-bottom,
        .sports-highlights .main-heading,
        .sports-highlights .description,
        .sports-highlights .left-image,
        .sports-highlights .right-image,
        .locations-section .location-card,
        .locations-section .locations-title,
        .monthly-events-title,
        .event-card,
        .contact-form-section,
        .contact-image-section,
        .news-card,
        .news-header-content,
        .careers-header-content,
        .job-card,
        .gift-cards-header-content,
        .reservations-header-content,
        .menu-button,
        .image-wrapper,
        .gallery-page .gallery-container,
        .gallery-item
    `;

    // Get all elements to animate
    const animatedElements = document.querySelectorAll(commonElements);

    // Start observing each element
    animatedElements.forEach((element, index) => {
        // Add stagger delay based on index for grid items
        if (element.classList.contains('event-card') || 
            element.classList.contains('news-card') || 
            element.classList.contains('job-card') ||
            element.classList.contains('gallery-item')) {
            element.style.animationDelay = `${index * 0.1}s`;
        }
        
        // Set initial opacity
        element.style.opacity = '0';
        
        observer.observe(element);
    });

    // Special handling for menu buttons to stagger their animation
    const menuButtons = document.querySelectorAll('.menu-button');
    menuButtons.forEach((button, index) => {
        button.style.opacity = '0';
        button.style.animationDelay = `${index * 0.1}s`;
        observer.observe(button);
    });

    // Special handling for gallery items to create a masonry-style animation
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach((item, index) => {
        const row = Math.floor(index / 3); // Assuming 3 columns
        const col = index % 3;
        const delay = (row + col) * 0.1; // Diagonal stagger effect
        item.style.opacity = '0';
        item.style.animationDelay = `${delay}s`;
        observer.observe(item);
    });
} 