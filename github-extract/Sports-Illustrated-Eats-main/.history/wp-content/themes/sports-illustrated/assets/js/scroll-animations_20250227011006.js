document.addEventListener('DOMContentLoaded', function() {
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.3
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // If it's a menu section, add visible class to all cards with delay
                if (entry.target.classList.contains('menu-items')) {
                    const cards = entry.target.querySelectorAll('.menu-card');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('visible');
                        }, 200 * (index + 1));
                    });
                }
            } else {
                entry.target.classList.remove('visible');
                
                // Remove visible class from cards when section is not visible
                if (entry.target.classList.contains('menu-items')) {
                    const cards = entry.target.querySelectorAll('.menu-card');
                    cards.forEach(card => {
                        card.classList.remove('visible');
                    });
                }
            }
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
                    behavior: 'smooth'
                });
            }
        });
    });
}); 