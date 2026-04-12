/**
 * LTD - Lycée Technologie de Diffa
 * Main JavaScript Application Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('LTD Pure Static System Initialized');
    
    // Check if user is "logged in" (simplified for static demo)
    const initApp = () => {
        setupNavigation();
        setupDropdowns();
    };

    const setupNavigation = () => {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const navLinks = document.querySelector('.nav-links-wrapper');

        if (mobileToggle && navLinks) {
            mobileToggle.addEventListener('click', () => {
                mobileToggle.classList.toggle('active');
                navLinks.classList.toggle('active');
            });
        }
    };

    const setupDropdowns = () => {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('.nav-link');
            if (window.innerWidth <= 992) {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    dropdown.classList.toggle('active');
                });
            }
        });
    };

    initApp();
});
