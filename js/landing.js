const leftArrow = document.querySelector('.left-arrow');
const rightArrow = document.querySelector('.right-arrow');
const carousel = document.querySelector('.priorities-carousel');

let scrollAmount = 0;
const scrollPerClick = 220; // Width of one card + gap

rightArrow.addEventListener('click', () => {
    scrollAmount += scrollPerClick;
    if(scrollAmount > carousel.scrollWidth - carousel.clientWidth) {
        scrollAmount = carousel.scrollWidth - carousel.clientWidth;
    }
    carousel.style.transform = `translateX(-${scrollAmount}px)`;
});

leftArrow.addEventListener('click', () => {
    scrollAmount -= scrollPerClick;
    if(scrollAmount < 0) scrollAmount = 0;
    carousel.style.transform = `translateX(-${scrollAmount}px)`;
});


// Top Modal Script
window.addEventListener('load', () => {
    const modal = document.getElementById('topModal');
    const closeBtn = document.querySelector('.top-modal .close-btn');

    // Show popup
    setTimeout(() => {
        modal.classList.add('active');
    }, 300);

    // Close modal on X click
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // Optional: auto-close after 5 seconds
    setTimeout(() => {
        modal.classList.remove('active');
    }, 5000);
});

