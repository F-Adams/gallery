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
        $thumbsPerPage = 50; // Number of thumbnails to display per page
        $maxLinks = 10; // Number of pagination links to show

        // Get a list of image files in the current folder
        $imageFiles = glob('*.{' . $extensions . '}', GLOB_BRACE);

        // Determine the number of pages needed to display the thumbnails, based on thumbsPerPage above
        $numPages = ceil(count($imageFiles) / $thumbsPerPage);
        $thisPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        // Make sure the page number is valid
        if ($thisPage < 1 || $thisPage > $numPages) {
            $thisPage = 1;
        }

        // Determine which image is the first and last image for the current page
        $firstThumb = ($thisPage - 1) * $thumbsPerPage;
        $lastThumb = min($firstThumb + $thumbsPerPage - 1, count($imageFiles) - 1);
    
        // Build the page navigation bar
        echo '<header><nav><ul class="paging">';

        if ($thisPage !== 1) {
            echo '<li><a href="?page=1">&laquo;&laquo;</a></li>';
        } else {
            echo '<li class="first">&laquo;&laquo;</li>';
        }
        
        if ($thisPage > 1) {
            echo '<li><a href="?page=' . ($thisPage - 1) . '">&laquo;</a></li>';
        } else {
            echo '<li class="previous">&laquo;</li>';
        }

        $linkRange = floor($maxLinks / 2);
        $firstPage = max(1, $thisPage - $linkRange);
        $lastPage = min($numPages, $firstPage + $maxLinks - 1);

        // Determine the page range to show in the navbar
        if ($lastPage - $firstPage + 1 < $maxLinks) {
            $firstPage = max(1, $lastPage - $maxLinks + 1);
        }
        if ($lastPage - $firstPage + 1 < $maxLinks) {
            $lastPage = min($numPages, $firstPage + $maxLinks - 1);
        }

        // Build the links to each page
        for ($i = $firstPage; $i <= $lastPage; $i++) {
            $activePage = (intVal($i) === $thisPage) ? 'active' : '';
            echo '<li><a href="?page=' . $i . '" class="' . $activePage . '">' . $i . '</a></li>';
        }

        if ($thisPage < $numPages) {
            echo '<li><a href="?page=' . ($thisPage + 1) . '">&raquo;</a></li>';
        } else {
            echo '<li class="next">&raquo;</li>';
        }

        if ($thisPage < $lastPage) {
            echo '<li><a href="?page='. $numPages . '">&raquo;&raquo;</a></li>';
        } else {
            echo '<li class="last">&raquo;&raquo;</li>';
        }

        echo '</ul></nav></header>';

        // Generate the gallery HTML
        echo '<section class="gallery">';
        for ($i = $firstThumb; $i <= $lastThumb; $i++) {
            $thisImage = $imageFiles[$i];
            $imageName = basename($thisImage);
            echo '<img src="' . $thisImage . '" alt="' . $imageName . '" class="thumbnail">';
        }
        echo '</section><footer>- ' . $thisPage . ' -</footer>';
    ?>

        <script defer src="gallery.js"></script>
    </body>

</html>