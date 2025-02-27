document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    const productSwiper = new Swiper('.product-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: '.product-slider-button-next',
            prevEl: '.product-slider-button-prev',
        },
        breakpoints: {
            640: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        }
    });

    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => 
        new bootstrap.Tooltip(tooltipTriggerEl)
    );
});