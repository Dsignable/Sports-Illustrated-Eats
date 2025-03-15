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
                    // Add specific animation classes based on data attributes
                    if (entry.target.hasAttribute('data-animation')) {
                        entry.target.classList.add(entry.target.getAttribute('data-animation'));
                    }
                    entry.target.classList.add('animate-in');
                    
                    // Animate children with data-child-animation
                    const animatedChildren = entry.target.querySelectorAll('[data-child-animation]');
                    animatedChildren.forEach((child, index) => {
                        setTimeout(() => {
                            child.classList.add('animate-in');
                            child.classList.add(child.getAttribute('data-child-animation'));
                        }, index * 200); // Stagger child animations
                    });
                    
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Add animation classes to elements
        const setupAnimations = () => {
            // Hero content
            const heroContent = document.querySelector('.hero-content');
            if (heroContent) {
                heroContent.setAttribute('data-animation', 'slide-up');
            }

            // Menu cards
            document.querySelectorAll('.menu-card').forEach((card, index) => {
                card.setAttribute('data-animation', index % 2 === 0 ? 'slide-right' : 'slide-left');
            });

            // Experience section
            const experienceCard = document.querySelector('.experience-card');
            if (experienceCard) {
                experienceCard.setAttribute('data-animation', 'fade-in');
                const header = experienceCard.querySelector('.brand-header');
                const title = experienceCard.querySelector('.content-title');
                const body = experienceCard.querySelector('.content-body');
                const photos = experienceCard.querySelectorAll('.experience-photo-top, .experience-photo-bottom');
                
                if (header) header.setAttribute('data-child-animation', 'slide-right');
                if (title) title.setAttribute('data-child-animation', 'slide-left');
                if (body) body.setAttribute('data-child-animation', 'slide-up');
                photos.forEach(photo => photo.setAttribute('data-child-animation', 'slide-in-fade'));
            }

            // Sports highlights
            const highlights = document.querySelector('.sports-highlights');
            if (highlights) {
                highlights.setAttribute('data-animation', 'fade-in');
                const leftImage = highlights.querySelector('.left-image');
                const rightImage = highlights.querySelector('.right-image');
                const textContent = highlights.querySelectorAll('.text-content');
                
                if (leftImage) leftImage.setAttribute('data-child-animation', 'slide-right');
                if (rightImage) rightImage.setAttribute('data-child-animation', 'slide-left');
                textContent.forEach(content => content.setAttribute('data-child-animation', 'slide-up'));
            }

            // Locations section
            const locations = document.querySelector('.locations-section');
            if (locations) {
                locations.setAttribute('data-animation', 'fade-in');
                const cards = locations.querySelectorAll('.location-card');
                cards.forEach((card, index) => {
                    card.setAttribute('data-child-animation', index % 2 === 0 ? 'slide-right' : 'slide-left');
                });
            }

            // Monthly events
            const events = document.querySelector('.monthly-events');
            if (events) {
                events.setAttribute('data-animation', 'fade-in');
                const eventCards = events.querySelectorAll('.event-card');
                eventCards.forEach((card, index) => {
                    card.setAttribute('data-child-animation', index % 2 === 0 ? 'slide-right' : 'slide-left');
                });
            }

            // Footer
            const footer = document.querySelector('.site-footer');
            if (footer) {
                footer.setAttribute('data-animation', 'slide-up');
            }
        };

        setupAnimations();

        // Observe all elements with animations
        document.querySelectorAll('[data-animation], [data-child-animation]').forEach(element => {
            element.classList.add('will-animate');
            observer.observe(element);
        });
    }, 2000); // Adjust timing based on your loading screen duration
}); 