document.addEventListener('DOMContentLoaded', function() {
    // Function to check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        const buffer = 100; // Add buffer for earlier animation trigger
        return (
            rect.top <= (window.innerHeight || document.documentElement.clientHeight) + buffer &&
            rect.bottom >= 0
        );
    }

    // Function to animate menu cards
    function animateMenuCards() {
        const menuSection = document.querySelector('.menu-items');
        const menuCards = document.querySelectorAll('.menu-card');
        
        if (menuSection && isInViewport(menuSection)) {
            menuSection.classList.add('visible');
            
            menuCards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('visible');
                }, 200 * (index + 1));
            });
        }
    }

    // Debounced scroll handler
    let scrollTimeout;
    function scrollHandler() {
        if (scrollTimeout) {
            window.cancelAnimationFrame(scrollTimeout);
        }
        scrollTimeout = window.requestAnimationFrame(() => {
            animateMenuCards();
        });
    }

    // Initial check
    animateMenuCards();

    // Add scroll listener
    window.addEventListener('scroll', scrollHandler, { passive: true });

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
}); 