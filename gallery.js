document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            const imagePath = this.src;
            const imageName = this.alt;
            // Display full-size image in a new window
            window.open(imagePath, "", "width=1024, height=768");
        });
    });
});