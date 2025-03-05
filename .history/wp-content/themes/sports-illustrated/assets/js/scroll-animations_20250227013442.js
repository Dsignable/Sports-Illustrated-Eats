document.addEventListener('DOMContentLoaded', function() {
    // Function to animate menu cards
    function animateMenuCards(menuSection) {
        menuSection.classList.add('visible');
        const cards = menuSection.querySelectorAll('.menu-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('visible');
            }, 100 * (index + 1));
        });
    }

    // Function to handle scroll animations
    function handleScrollAnimations() {
        const menuSection = document.querySelector('.menu-items');
        if (menuSection) {
            const rect = menuSection.getBoundingClientRect();
            if (rect.top < window.innerHeight) {
                animateMenuCards(menuSection);
            }
        }
    }

    // Initial animation trigger
    const menuSection = document.querySelector('.menu-items');
    if (menuSection) {
        // Trigger animation immediately if menu section is in viewport
        handleScrollAnimations();

        // Add scroll listener for subsequent animations
        window.addEventListener('scroll', () => {
            requestAnimationFrame(handleScrollAnimations);
        });
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

    // Add scroll event listener for parallax effect
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.menu-image');
                
                parallaxElements.forEach(element => {
                    const speed = 0.3;
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
                
                ticking = false;
            });
            ticking = true;
        }
    });
}); 