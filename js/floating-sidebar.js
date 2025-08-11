document.addEventListener('DOMContentLoaded', function() {
    const floatingSidebar = document.querySelector('.floating-sidebar');
    // Define the scroll point where the sidebar should appear.
    // 75vh means 75% of the viewport height.
    const scrollThreshold = window.innerHeight * 0.50; // Approximately 75vh

    if (floatingSidebar) {
        /**
         * Checks the scroll position and toggles the 'is-visible' class.
         */
        function handleScrollVisibility() {
            if (window.scrollY > scrollThreshold) {
                floatingSidebar.classList.add('is-visible');
            } else {
                floatingSidebar.classList.remove('is-visible');
            }
        }

        // Add the scroll event listener
        window.addEventListener('scroll', handleScrollVisibility);

        // Call it once on page load in case the user loads the page already scrolled down
        handleScrollVisibility();
    }
});