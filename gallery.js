document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const popupWidth = 1280;
    const popupHeight = 720;

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            const imagePath = this.src;
            const imageName = this.alt;
            window.open(imagePath, imageName, `width=${popupWidth}, height=${popupHeight}`);
        });
    });
});