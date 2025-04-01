/**
 * Menu pages functionality for Sports Illustrated theme
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Menu pages script loaded');
    
    // Handle menu page specific functionality
    const menuPage = document.querySelector('.menu-page');
    if (menuPage) {
        console.log('Menu page detected');
        
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