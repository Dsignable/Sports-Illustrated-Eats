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
                // Determine animation direction based on position
                const rect = entry.target.getBoundingClientRect();
                const windowWidth = window.innerWidth;
                const isLeftSide = rect.left < windowWidth / 2;

                // Apply appropriate animation class
                entry.target.classList.add(isLeftSide ? 'animate-in' : 'animate-in-right');
                
                // Stop observing after animation is triggered
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2,
        rootMargin: '0px'
    });

    // Elements to animate
    const animatedElements = document.querySelectorAll(`
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
        .locations-section .locations-title
    `);

    // Start observing each element
    animatedElements.forEach(element => {
        observer.observe(element);
    });
} 