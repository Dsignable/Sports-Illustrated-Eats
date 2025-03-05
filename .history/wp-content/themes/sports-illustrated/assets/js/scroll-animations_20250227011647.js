document.addEventListener('DOMContentLoaded', function() {
    const options = {
        root: null,
        rootMargin: '-20% 0px',
        threshold: [0, 0.3, 0.6]
    };

    let animationFrame;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // Cancel any existing animation frame
            if (animationFrame) {
                cancelAnimationFrame(animationFrame);
            }

            // Schedule the animation
            animationFrame = requestAnimationFrame(() => {
                if (entry.isIntersecting && entry.intersectionRatio > 0.3) {
                    // Add visible class to the section
                    entry.target.classList.add('visible');
                    
                    // If it's a menu section, animate the cards
                    if (entry.target.classList.contains('menu-items')) {
                        const cards = entry.target.querySelectorAll('.menu-card');
                        cards.forEach((card, index) => {
                            setTimeout(() => {
                                card.classList.add('visible');
                            }, 200 * (index + 1));
                        });
                    }
                } else if (!entry.isIntersecting && entry.intersectionRatio === 0) {
                    // Remove visible classes when completely out of view
                    entry.target.classList.remove('visible');
                    
                    if (entry.target.classList.contains('menu-items')) {
                        const cards = entry.target.querySelectorAll('.menu-card');
                        cards.forEach(card => {
                            card.classList.remove('visible');
                        });
                    }
                }
            });
        });
    }, options);

    // Observe menu section
    const menuSection = document.querySelector('.menu-items');
    if (menuSection) {
        observer.observe(menuSection);
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
            window.requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.menu-image');
                
                parallaxElements.forEach(element => {
                    const speed = 0.5;
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
                
                ticking = false;
            });
            ticking = true;
        }
    });
}); 