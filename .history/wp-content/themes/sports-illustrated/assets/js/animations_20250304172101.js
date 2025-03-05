document.addEventListener('DOMContentLoaded', () => {
    // Wait for loading screen to complete
    const loadingScreen = document.querySelector('.loading-screen');
    
    // Function to initialize animations after loading
    const initializeAnimations = () => {
        // Create intersection observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add animation classes when element is in view
                    entry.target.classList.add('animate');
                    // Remove observer after animation is triggered
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2 // Trigger when 20% of element is visible
        });

        // Observe elements with animation classes
        document.querySelectorAll('[data-animation]').forEach(element => {
            observer.observe(element);
            // Add animation type class based on data attribute
            const animationType = element.dataset.animation;
            element.classList.add(animationType);
            
            // Add delay if specified
            if (element.dataset.delay) {
                element.classList.add(`delay-${element.dataset.delay}`);
            }
        });
    };

    // Initialize animations after loading screen is complete
    if (loadingScreen) {
        loadingScreen.addEventListener('transitionend', () => {
            if (loadingScreen.classList.contains('loaded')) {
                initializeAnimations();
            }
        });
    } else {
        initializeAnimations();
    }
}); 