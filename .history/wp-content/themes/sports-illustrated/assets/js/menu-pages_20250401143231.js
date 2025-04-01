/**
 * Menu pages functionality for Sports Illustrated theme
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Menu pages script loaded');
    
    // Handle menu page specific functionality
    const menuPage = document.querySelector('.menu-page');
    if (menuPage) {
        console.log('Menu page detected');
        
        // Initialize menu gallery if it exists
        initMenuGallery();
        
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
    
    // Initialize the menu gallery
    function initMenuGallery() {
        const gallery = document.querySelector('.menu-gallery');
        if (!gallery) return;
        
        const container = gallery.querySelector('.menu-gallery-container');
        const slides = gallery.querySelectorAll('.menu-gallery-slide');
        const dots = gallery.querySelectorAll('.menu-gallery-dot');
        const slideCount = slides.length;
        
        if (slideCount <= 1) return;
        
        let currentSlide = 0;
        let slideInterval;
        const slideSpeed = parseInt(gallery.dataset.speed) || 5000;
        
        // Start automatic slideshow
        startSlideshow();
        
        // Click on dots to navigate
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                goToSlide(index);
                resetInterval();
            });
        });
        
        // Pause on hover
        gallery.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });
        
        gallery.addEventListener('mouseleave', () => {
            startSlideshow();
        });
        
        // Functions
        function startSlideshow() {
            slideInterval = setInterval(() => {
                nextSlide();
            }, slideSpeed);
        }
        
        function resetInterval() {
            clearInterval(slideInterval);
            startSlideshow();
        }
        
        function nextSlide() {
            goToSlide((currentSlide + 1) % slideCount);
        }
        
        function goToSlide(n) {
            // Update container transform
            container.style.transform = `translateX(-${n * 100}%)`;
            
            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === n);
            });
            
            currentSlide = n;
        }
    }
}); 