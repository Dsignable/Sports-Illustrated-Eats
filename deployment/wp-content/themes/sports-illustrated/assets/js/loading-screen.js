document.addEventListener('DOMContentLoaded', function() {
    // Get the loading screen element
    const loadingScreen = document.querySelector('.loading-screen');
    
    if (loadingScreen) {
        // Force the loading screen to be visible initially
        loadingScreen.style.display = 'flex';
        loadingScreen.style.opacity = '1';
        
        // Add a timeout to ensure the loading screen is removed
        setTimeout(function() {
            // Add the loaded class to trigger the CSS transition
            loadingScreen.classList.add('loaded');
            
            // After the transition is complete, hide the loading screen completely
            setTimeout(function() {
                loadingScreen.style.display = 'none';
            }, 1000); // Wait for the transition to complete (adjust if needed)
        }, 1000); // Show loading screen for 1 second (adjust if needed)
    }
}); 