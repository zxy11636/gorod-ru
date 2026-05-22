// Theme Toggle JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const sunIcon = themeToggle.querySelector('.sun-icon');
    const moonIcon = themeToggle.querySelector('.moon-icon');

    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Apply saved theme
    if (currentTheme === 'dark') {
        html.classList.add('dark');
        sunIcon.classList.add('hidden');
        moonIcon.classList.remove('hidden');
    } else {
        html.classList.remove('dark');
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
    }

    // Theme toggle functionality
    themeToggle.addEventListener('click', function() {
        if (html.classList.contains('dark')) {
            // Switch to light mode
            html.classList.remove('dark');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
            localStorage.setItem('theme', 'light');
        } else {
            // Switch to dark mode
            html.classList.add('dark');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
            localStorage.setItem('theme', 'dark');
        }
    });

    // Add keyboard accessibility
    themeToggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            themeToggle.click();
        }
    });

    // Add theme toggle to mobile menu as well
    const mobileMenuFooter = document.querySelector('.mobile-menu-footer');
    if (mobileMenuFooter && !document.getElementById('themeToggleMobile')) {
        const mobileThemeToggle = themeToggle.cloneNode(true);
        mobileThemeToggle.id = 'themeToggleMobile';
        mobileThemeToggle.classList.add('mobile-theme-toggle');
        
        // Insert before the logout form in mobile menu
        const mobileLogoutForm = mobileMenuFooter.querySelector('.mobile-logout-form');
        if (mobileLogoutForm) {
            mobileMenuFooter.insertBefore(mobileThemeToggle, mobileLogoutForm);
        } else {
            mobileMenuFooter.appendChild(mobileThemeToggle);
        }
    }
});