// JavaScript for Carousel
let currentIndex = 0;
const images = document.querySelectorAll('#carousel img');

setInterval(() => {
    images[currentIndex].style.opacity = 0;
    currentIndex = (currentIndex + 1) % images.length;
    images[currentIndex].style.opacity = 1;
}, 5000);

