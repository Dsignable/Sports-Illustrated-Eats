document.addEventListener('DOMContentLoaded', function() {
    // Options for the intersection observer
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // Reduced threshold to trigger earlier
    };

    // Create the observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add visible class to the section immediately
                entry.target.classList.add('visible');
                
                // If it's a menu section, animate the cards
                if (entry.target.classList.contains('menu-items')) {
                    const cards = entry.target.querySelectorAll('.menu-card');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('visible');
                        }, 100 * (index + 1)); // Reduced delay between cards
                    });
                }
            }
        });
    }, options);

    // Function to handle scroll animations
    function handleScrollAnimations() {
        const menuSection = document.querySelector('.menu-items');
        if (menuSection) {
            const rect = menuSection.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom >= 0;
            
            if (isVisible) {
                menuSection.classList.add('visible');
                const cards = menuSection.querySelectorAll('.menu-card');
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('visible');
                    }, 100 * (index + 1));
                });
            }
        }
    }

    // Observe menu section
    const menuSection = document.querySelector('.menu-items');
    if (menuSection) {
        observer.observe(menuSection);
        
        // Also trigger on scroll for redundancy
        window.addEventListener('scroll', () => {
            requestAnimationFrame(handleScrollAnimations);
        });
        
        // Initial check
        handleScrollAnimations();
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
                    const speed = 0.3; // Reduced speed for smoother effect
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
                
                ticking = false;
            });
            ticking = true;
        }
    });
}); 