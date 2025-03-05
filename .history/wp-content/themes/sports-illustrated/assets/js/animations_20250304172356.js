document.addEventListener('DOMContentLoaded', () => {
    // Wait for loading screen to complete
    setTimeout(() => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    // Optional: Unobserve after animation is triggered
                    // observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2 // Trigger when 20% of the element is visible
        });

        // Elements to observe
        const animatedElements = document.querySelectorAll(
            '.hero-section, .menu-items, .monthly-events, .experience-card, .sports-highlights, .locations-section'
        );

        animatedElements.forEach(element => {
            element.classList.add('will-animate');
            observer.observe(element);
        });
    }, 2000); // Adjust this timing to match your loading screen duration
}); 