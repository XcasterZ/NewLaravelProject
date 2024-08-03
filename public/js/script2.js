
document.addEventListener('DOMContentLoaded', function () {
    const otherImages = document.querySelectorAll('.other_img');
    const mainContent = document.querySelector('.main_content');

    otherImages.forEach(otherImage => {
        otherImage.addEventListener('click', function () {
            const content = this.innerHTML;
            mainContent.innerHTML = content;
            resizeMedia(mainContent);
        });
    });

    function resizeMedia(container) {
        const media = container.querySelector('img, video');
        if (media) {
            media.style.maxWidth = '100%';
            media.style.maxHeight = '100%';
        }
    }

});

// const addWishBtn = document.querySelectorAll('.addWish');
// const heartIcon = addWishBtn.querySelector('i');


// addWishBtn.addEventListener('click', function() {
//     heartIcon.classList.toggle('fas');
//     heartIcon.classList.toggle('far');
// });

