document.addEventListener('DOMContentLoaded', function() {
    // Function to animate menu cards
    function animateMenuCards(menuSection) {
        const cards = menuSection.querySelectorAll('.menu-card');
        
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.transform = 'translateY(0)';
                card.style.opacity = '1';
            }, 100 * (index + 1));
        });
    }

    // Function to check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.bottom >= 0
        );
    }

    // Function to handle scroll animations
    function handleScrollAnimations() {
        const menuSection = document.querySelector('.menu-items');
        if (menuSection && isInViewport(menuSection)) {
            animateMenuCards(menuSection);
            // Remove scroll listener once animation is triggered
            window.removeEventListener('scroll', scrollHandler);
        }
    }

    // Debounced scroll handler
    let scrollTimeout;
    function scrollHandler() {
        if (scrollTimeout) {
            window.cancelAnimationFrame(scrollTimeout);
        }
        scrollTimeout = window.requestAnimationFrame(() => {
            handleScrollAnimations();
        });
    }

    // Initial setup
    const menuSection = document.querySelector('.menu-items');
    if (menuSection) {
        // Set initial state with opacity 1
        const cards = menuSection.querySelectorAll('.menu-card');
        cards.forEach(card => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1'; // Set to 1 by default
            card.style.transform = 'translateY(0)'; // No initial transform
        });

        // Add scroll listener for subtle animations
        window.addEventListener('scroll', scrollHandler);
    }

    // Handle smooth scrolling for navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add parallax effect
    window.addEventListener('scroll', () => {
        requestAnimationFrame(() => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.menu-image');
            
            parallaxElements.forEach(element => {
                const speed = 0.3;
                const yPos = -(scrolled * speed);
                element.style.transform = `scale(1.1) translateY(${yPos}px)`;
            });
        });
    });

    // Sports Highlights Section Animation
    const sportsHighlights = document.querySelector('.sports-highlights');
    if (sportsHighlights) {
        const highlightsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    // Optional: remove observer after animation
                    // highlightsObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2 // Start animation when 20% of the section is visible
        });

        highlightsObserver.observe(sportsHighlights);
    }
}); 