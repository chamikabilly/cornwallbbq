const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    autoplay: {
        delay: 5000,
    },
    effect: 'fade',
    duration: '1000',

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true,
    },

});