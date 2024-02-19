<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Image Gallery</title>
        <meta name="description" content="Very basic image gallery">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="gallery.css">
    </head>

    <body>

    <?php
    // Get a list of image files in the current folder
    $imageFiles = glob('*.{jpg,jpeg,png,gif}', GLOB_BRACE);

    // Generate HTML for the thumbnail gallery
    echo '<div class="gallery">';
    foreach ($imageFiles as $imageFile) {
        $imageName = basename($imageFile);
        echo '<img src="' . $imageFile . '" alt="' . $imageName . '" class="thumbnail">';
    }
    echo '</div>';
    ?>

        <script defer src="gallery.js"></script>
    </body>

</html>