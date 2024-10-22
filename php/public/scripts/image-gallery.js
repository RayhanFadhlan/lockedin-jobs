const mainImage = document.querySelector('.main-image');
const thumbnails = document.querySelectorAll('.thumbnail img');


thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('click', function() {
  
        mainImage.src = thumbnail.src;
    });
});