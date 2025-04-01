/**
 * Menu pages functionality for Sports Illustrated theme
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Menu pages script loaded');
    
    // Handle menu page specific functionality
    const menuPage = document.querySelector('.menu-page');
    if (menuPage) {
        console.log('Menu page detected');
        
        // Initialize menu carousel if it exists
        initMenuCarousel();
        
        // Add smooth scrolling to menu sections
        const menuLinks = document.querySelectorAll('.menu-section-link');
        menuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Handle menu filtering if available
        const filterButtons = document.querySelectorAll('.menu-filter-btn');
        const menuItems = document.querySelectorAll('.menu-item');
        
        if (filterButtons.length > 0 && menuItems.length > 0) {
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;
                    
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filter menu items
                    if (filter === 'all') {
                        menuItems.forEach(item => item.style.display = 'block');
                    } else {
                        menuItems.forEach(item => {
                            if (item.classList.contains(filter)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    }
                });
            });
        }
    }
});

/**
 * Initialize the menu carousel
 */
function initMenuCarousel() {
    const carouselContainer = document.querySelector('.menu-carousel-container');
    if (!carouselContainer) return;
    
    const carousel = document.querySelector('.menu-carousel');
    const slides = document.querySelectorAll('.menu-carousel-slide');
    
    if (!carousel || slides.length < 2) return;
    
    let currentSlide = 0;
    const speed = parseInt(carouselContainer.dataset.speed) || 5000;
    
    // Set slide heights based on customizer setting
    const slideHeight = parseInt(carouselContainer.dataset.height) || 500;
    slides.forEach(slide => {
        slide.style.height = `${slideHeight}px`;
    });
    
    // Function to move to the next slide
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateCarousel();
    }
    
    // Function to update the carousel position
    function updateCarousel() {
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    
    // Start auto-rotation
    let interval = setInterval(nextSlide, speed);
    
    // Pause on hover
    carouselContainer.addEventListener('mouseenter', () => {
        clearInterval(interval);
    });
    
    // Resume on mouse leave
    carouselContainer.addEventListener('mouseleave', () => {
        interval = setInterval(nextSlide, speed);
    });
} 