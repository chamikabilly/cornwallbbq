document.addEventListener('DOMContentLoaded', function () {
    // Hero Swiper
    const heroSwiper = new Swiper('.hero_swiper', {
        direction: 'horizontal',
        loop: true,
        autoplay: {
            delay: 5000,
        },
        effect: 'fade',
        speed: 1000, // Changed from duration to speed

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
    });

    // Testimonials Swiper - Fixed selector
    const testimonialsSwiper = new Swiper('.testimonials-swiper', {
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        spaceBetween: 50,
        speed: 1000,
        effect: 'slide',
        autoplay: {
            delay: 5000,
        },

        // Responsive breakpoints
        breakpoints: {
            500: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 50
            }
        },

        // If we need pagination
        pagination: {
            el: '.testimonials-pagination',
            clickable: true,
        },
    });
});