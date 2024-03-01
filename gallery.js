document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const popupWidth = 1280;
    const popupHeight = 720;

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            const imageToView = this.alt;
            window.open(imageToView, '', `width=${popupWidth}, height=${popupHeight}`);
        });
    });
});