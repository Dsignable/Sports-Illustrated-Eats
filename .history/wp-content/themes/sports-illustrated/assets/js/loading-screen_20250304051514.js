document.addEventListener('DOMContentLoaded', function() {
    const loadingScreen = document.getElementById('loading-screen');
    if (!loadingScreen) return;

    // Get the duration from WordPress customizer
    const duration = parseInt(loadingScreen.dataset.duration) || 3000;

    // Function to hide loading screen
    const hideLoadingScreen = () => {
        loadingScreen.classList.add('loaded');
        // Remove from DOM after animation completes
        setTimeout(() => {
            loadingScreen.remove();
        }, 1000);
    };

    // Hide loading screen when all content is loaded
    window.addEventListener('load', () => {
        setTimeout(hideLoadingScreen, duration);
    });

    // Fallback: Hide loading screen after maximum duration
    setTimeout(hideLoadingScreen, duration + 2000);
}); 