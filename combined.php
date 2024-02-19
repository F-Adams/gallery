<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Image Gallery</title>
        <meta name="description" content="Very basic image gallery">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="gallery.css">

        <style>
            /* Configurable things */
            :root {
                /* Maximum width of thumbnail images */
                --max-thumb-width: 250px;
                /* Page background color */
                --bg-color: #151515;
                /* Paging link border color */
                --paging-border-color: #b5b5b5;
                /* Paging link text color */
                --paging-link-color: #fff;
                /* Paging link hover color */
                --paging-hover-color: #00f;
                /* Active page link background color */
                --paging-active-page: #00f;

            }

            * {
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
            }

            body {
                background-color: var(--bg-color);
                color: #fff;
                overflow-y: scroll;
            }

            .gallery {
                width: 75%;
                margin: 20px auto;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(var(--max-thumb-width), 1fr));
                grid-gap: 10px;
            }

            .thumbnail {
                width: 100%;
                height: auto;
                object-fit: cover;
                cursor: pointer;
            }

            .paging {
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 10px auto;
            }

            .paging a,
            .paging span {
                font-size: 14px;
                padding: 1px 10px;
                color: var(--paging-link-color);
                text-decoration: none;
                border: 1px solid var(--paging-border-color);
            }

            .paging a:hover {
                background-color: var(--paging-hover-color);
            }

            .active {
                font-weight: bold;
                background-color: var(--paging-active-page);
            }
        </style>
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
    
    // Gnerate the truncated paging links
    $firstPageLink = max(1, $page - floor($numLinks / 2));
    $lastPageLink = min($numPages, $firstPageLink + $numLinks - 1);

    echo '<div class="paging">';
    if ($thisPage > 1) {
        echo '<a href="?page=' . ($thisPage - 1) . '">Previous</a>';
    } else {
        echo '<span>Previous</span>';
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

    // // Generate the paging links
    // echo '<div class="paging">';
    // for ($i = 1; $i <= $numPages; $i++) {
    //     $activePage = ($i === $thisPage) ? 'active' : '';
    //     echo '<a href="?page=' . $i . '" class="' . $activePage . '">' . $i . '</a>';
    // }
    // echo '</div>';

    // Generate the gallery HTML
    echo '<div class="gallery">';
    for ($i = $firstThumb; $i <= $lastThumb; $i++) {
        $thisImage = $imageFiles[$i];
        $imageName = basename($thisImage);
        echo '<img src="' . $thisImage . '" alt="' . $imageName . '" class="thumbnail">';
    }
    echo '</div>';

    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function () {
                    const imagePath = this.src;
                    const imageName = this.alt;
                    window.open(imagePath, "", "width=1024, height=768");   // Display full-size image in a new window
                });
            });
        });
    </script>

    </body>

</html>