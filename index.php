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
    // Configurable things
    $extensions = "jpg,jpeg,png,gif"; // Supported image file extensions
    $thumbsPerPage = 60; // Number of thumbnails to display per page

    // Get a list of image files in the current folder
    $imageFiles = glob('*.{' . $extensions . '}', GLOB_BRACE);

    // Determine the number of pages needed to display the thumbnails, based on thumbsPerPage above
    $numPages = ceil(count($imageFiles) / $thumbsPerPage);
    $thisPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    // Determine which image is the first and last image for the current page
    $firstThumb = ($thisPage - 1) * $thumbsPerPage;
    $lastThumb = min($firstThumb + $thumbsPerPage - 1, count($imageFiles) - 1);
    
    // Generate the paging links
    echo '<div class="paging">';
    for ($i = 1; $i <= $numPages; $i++) {
        $activePage = ($i === $thisPage) ? 'active' : '';
        echo '<a href="?page=' . $i . '" class="' . $activePage . '">' . $i . '</a>';
    }
    echo '</div>';

    // Generate the gallery HTML
    echo '<div class="gallery">';
    for ($i = $firstThumb; $i <= $lastThumb; $i++) {
        $thisImage = $imageFiles[$i];
        $imageName = basename($thisImage);
        echo '<img src="' . $thisImage . '" alt="' . $imageName . '" class="thumbnail">';
    }
    echo '</div>';

    ?>

        <script defer src="gallery.js"></script>
    </body>

</html>