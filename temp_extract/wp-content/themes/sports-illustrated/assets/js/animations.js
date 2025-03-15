document.addEventListener('DOMContentLoaded', () => {
    // Wait for the loading screen to finish
    const loadingScreen = document.querySelector('.loading-screen');
    if (loadingScreen) {
        // Add a timeout to ensure animations start even if transition doesn't complete
        setTimeout(() => {
            loadingScreen.classList.add('loaded');
            initializeAnimations();
        }, 2000); // 2 second fallback
        
        loadingScreen.addEventListener('transitionend', initializeAnimations);
    } else {
        initializeAnimations();
    }
});

function initializeAnimations() {
    // Ensure elements are visible even if animations don't trigger
    document.querySelectorAll('.animate-hidden').forEach(el => {
        el.style.opacity = '1';
    });
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Special handling for experience photos - they already have their own animation classes
                if (entry.target.classList.contains('experience-photo-top') ||
                    entry.target.classList.contains('experience-photo-bottom')) {
                    entry.target.classList.add('animate-in');
                } else {
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
                    if (entry.target.dataset.animation === 'up') {
                        entry.target.classList.add('animate-in-up');
                    } else {
                        entry.target.classList.add(isLeftSide ? 'animate-in' : 'animate-in-right');
                    }
                }
                
                // Ensure element is visible
                entry.target.style.opacity = '1';
                
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
        .gallery-page .gallery-item,
        .gallery-header-content
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
            // Set data-animation="up" for gallery items
            if (element.classList.contains('gallery-item')) {
                element.dataset.animation = 'up';
            }
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
} 