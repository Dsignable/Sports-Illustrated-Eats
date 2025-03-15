document.addEventListener('DOMContentLoaded', () => {
    // Wait for loading screen to complete
    setTimeout(() => {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.2
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    // Optional: Unobserve after animation
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Elements to observe
        const animatedElements = document.querySelectorAll(
            '.hero-content, .menu-card, .experience-card, ' +
            '.sports-highlights, .locations-section, ' +
            '.monthly-events, .site-footer'
        );

        animatedElements.forEach(element => {
            element.classList.add('will-animate');
            observer.observe(element);
        });
    }, 2000); // Adjust timing based on your loading screen duration
}); 