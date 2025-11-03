document.addEventListener('DOMContentLoaded', function () {
    // Mobile Menu Elements
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileToggleBottom = document.querySelector('.mobile-menu-toggle-bottom');
    const navContainer = document.querySelector('.nav-container');
    const mobileMenuClose = document.querySelector('.mobile-menu-close');
    const body = document.body;

    // Create overlay for mobile menu
    const overlay = document.createElement('div');
    overlay.className = 'nav-overlay';
    document.body.appendChild(overlay);

    // Search Elements
    const searchToggle = document.querySelector('.search-toggle');
    const mobileSearchToggle = document.querySelector('.mobile-search-toggle');
    const headerSearch = document.getElementById('header-search');
    const searchClose = document.querySelector('.search-close');

    // Mobile Menu Toggle Function
    function openMobileMenu() {
        navContainer.classList.add('active');
        overlay.classList.add('active');
        body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        navContainer.classList.remove('active');
        overlay.classList.remove('active');
        body.style.overflow = '';
    }

    // Desktop Mobile Menu Toggle
    if (mobileToggle) {
        mobileToggle.addEventListener('click', openMobileMenu);
    }

    // Mobile Bottom Menu Toggle
    if (mobileToggleBottom) {
        mobileToggleBottom.addEventListener('click', openMobileMenu);
    }

    // Mobile Menu Close
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    // Close mobile menu when clicking overlay
    overlay.addEventListener('click', closeMobileMenu);

    // Search Toggle Functions
    function openSearch() {
        headerSearch.classList.add('active');
        body.style.overflow = 'hidden';
    }

    function closeSearch() {
        headerSearch.classList.remove('active');
        body.style.overflow = '';
    }

    // Search Toggle (Desktop)
    if (searchToggle) {
        searchToggle.addEventListener('click', openSearch);
    }

    // Mobile Search Toggle
    if (mobileSearchToggle) {
        mobileSearchToggle.addEventListener('click', openSearch);
    }

    // Search Close
    if (searchClose) {
        searchClose.addEventListener('click', closeSearch);
    }

    // Close search when clicking outside
    if (headerSearch) {
        headerSearch.addEventListener('click', function (e) {
            if (e.target === this) {
                closeSearch();
            }
        });
    }

    // Close all menus on resize
    window.addEventListener('resize', function () {
        if (window.innerWidth > 991) {
            closeMobileMenu();
            closeSearch();
        }
    });

    // Close mobile menu when clicking on menu links
    const menuLinks = document.querySelectorAll('.primary-menu a');
    menuLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
});


// Scroll animation function
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');

    // Create intersection observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');

                // If it's a category container, add individual delay
                if (entry.target.classList.contains('cat-container')) {
                    const index = Array.from(entry.target.parentElement.children).indexOf(entry.target);
                    entry.target.style.transitionDelay = `${(index * 0.1) + 0.2}s`;
                }
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all animated elements
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

// Initialize when document is loaded
document.addEventListener('DOMContentLoaded', initScrollAnimations);

// Re-initialize on page transitions (for SPAs)
if (typeof wp !== 'undefined' && wp.hooks) {
    wp.hooks.addAction('pageTransitionEnd', 'theme/scrollAnimations', initScrollAnimations);
}
