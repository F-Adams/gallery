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
    $numLinks = 10; // Number of pagination links to show

    // Get a list of image files in the current folder
    $imageFiles = glob('*.{' . $extensions . '}', GLOB_BRACE);

    // Determine the number of pages needed to display the thumbnails, based on thumbsPerPage above
    $numPages = ceil(count($imageFiles) / $thumbsPerPage);
    $thisPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    // Determine which image is the first and last image for the current page
    $firstThumb = ($thisPage - 1) * $thumbsPerPage;
    $lastThumb = min($firstThumb + $thumbsPerPage - 1, count($imageFiles) - 1);
    
    // // Gnerate the truncated paging links
    // $firstPageLink = max(1, $page - floor($numLinks / 2));
    // $lastPageLink = min($numPages, $firstPageLink + $numLinks - 1);

    echo '<div class="paging">';
    if ($thisPage > 1) {
        echo '<a href="?page=' . ($thisPage - 1) . '">Previous</a>';
    } else {
        echo '<span>Previous</span>';
    }

    $linkRange = floor($numLinks / 2);
    $firstPageLink = max(1, $thisPage - $linkRange);
    $lastPageLink = min($numPages, $firstPageLink + $numLinks - 1);

    // Adjust firstPageLink and lastPageLink if they're near the beginning or end of the paging range
    if ($lastPageLink - $firstPageLink + 1 < $numLinks) {
        $firstPageLink = max(1, $lastPageLink - $numLinks + 1);
    }
    if ($lastPageLink - $firstPageLink + 1 < $numLinks) {
        $lastPageLink = min($numPages, $firstPageLink + $numLinks - 1);
    }

    for ($i = $firstPageLink; $i <= $lastPageLink; $i++) {
        $activePage = ($i === $thisPage) ? 'active' : '';
        echo '<a href="?page=' . $i . '" class="' . $activePage . '">' . $i . '</a>';
    }

    if ($thisPage < $numPages) {
        echo '<a href="?page=' . ($thisPage + 1) . '">Next</a>';
    } else {
        echo '<span>Next</span>';
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