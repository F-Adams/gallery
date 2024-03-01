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
                /* Header and footer background color */
                --nav-bg-color: #2b2b2b;
                /* Paging link border color */
                --paging-border-color: #b5b5b5;
                /* Paging link text color */
                --paging-link-color: #ffffff;
                /* Paging link hover color */
                --paging-hover-color: #00f;
                /* Active page link background color */
                --paging-active-page: #00b;
                /* Inactive page link background color */
                --paging-inactive-page: #151515;
                /* Tooltip background color */
                --tooltip-background: #ffface;
                /* Tooltip text color */
                --tooltip-text-color: #000;
                /* Tooltip border color */
                --tooltip-border-color: #000;
            }

            * {
                box-sizing: border-box;
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
                margin: 50px auto 30px;
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

            header {
                position: fixed;
                top: 0;
                width: 100%;
                text-align: center;
                padding: 5px 0;
                background-color: var(--nav-bg-color);
            }

            .paging {
                list-style: none;
                padding: 0;
                margin: 0;
                display: inline-block;
            }

            .paging li {
                display: inline-block;
                margin-right: 5px;
                width: 30px;
                background-color: var(--paging-inactive-page);
                border: 1px solid var(--paging-border-color);
            }

            .paging li a {
                display: block;
                padding: 5px 0;
                width: 100%;
                text-decoration: none;
                color: var(--paging-link-color);

            }

            .paging li a:hover {
                background-color: var(--paging-hover-color);
            }

            .active {
                font-weight: bold;
                background-color: var(--paging-active-page);
            }

            .first,
            .next,
            .previous,
            .last {
                padding: 5px 0;
                width: 10px;
            }

            .tip {
                position: relative;
                display: inline-block;
            }

            .tip .tipText {
                visibility: hidden;
                width: 70px;
                top: 100%;
                left: 25%;
                margin-top: 10px;
                margin-left: -35px;
                background-color: var(--tooltip-background);
                color: var(--tooltip-text-color);
                text-align: center;
                border: 1px solid var(--tooltip-border-color);
                border-radius: 5px;
                position: absolute;
                z-index: 1;
                opacity: 0;
                transition: opacity .5s;
            }

            .tip:hover .tipText {
                visibility: visible;
                opacity: 1;
                padding: 2px 0 3px;
            }

            footer {
                font-weight: 700;
                width: 100%;
                position: fixed;
                bottom: 0;
                text-align: center;
                background-color: var(--nav-bg-color);
            }

            /* Media Queries */
            @media screen and (max-width: 600px) {
                .gallery {
                    margin: 40px auto 30px;
                }

                .paging {
                    font-size: .75rem;
                }

                .paging li {
                    width: 25px;
                }

                .paging li a {
                    padding: 3px 0;
                }

                .first,
                .next,
                .previous,
                .last {
                    padding: 3px 0;
                }

                .paging li.responsive {
                    display: none;
                }
            }
        </style>
    </head>

    <body>

    <?php
        // Configurable things
        $extensions = "jpg,jpeg,png,gif";       // Supported image file extensions
        $thumbsPerPage = 50;                    // Number of thumbnails to display per page
        $maxLinks = 10;                         // Number of pagination links to show
        $imageFolder = "images";                // Folder containing full sized image files
        $thumbFolder = "thumbs";                // Folder containing scaled thumbnail images
        $thumbPrefix = "thumbnail_";            // Prefix added to thumbnail image file names

        // Get a list of thumbnail files in the folder
        $imageFiles = glob($thumbFolder . '/*.{' . $extensions . '}', GLOB_BRACE);

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
            echo '<li class="tip"><span class="tipText">First</span><a href="?page=1">&laquo;&laquo;</a></li>';
        } else {
            echo '<li class="first">&laquo;&laquo;</li>';
        }
        
        if ($thisPage > 1) {
            echo '<li class="tip responsive"><span class="tipText">Previous</span><a href="?page=' . ($thisPage - 1) . '">&laquo;</a></li>';
        } else {
            echo '<li class="responsive previous">&laquo;</li>';
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
            echo '<li class="tip responsive"><span class="tipText">Next</span><a href="?page=' . ($thisPage + 1) . '">&raquo;</a></li>';
        } else {
            echo '<li class="responsive next">&raquo;</li>';
        }

        if ($thisPage < $lastPage) {
            echo '<li class="tip"><span class="tipText">Last</span><a href="?page='. $numPages . '">&raquo;&raquo;</a></li>';
        } else {
            echo '<li class="last">&raquo;&raquo;</li>';
        }

        echo '</ul></nav></header>';

        // Generate the gallery HTML
        echo '<section class="gallery">';
        for ($i = $firstThumb; $i <= $lastThumb; $i++) {
            $thisImage = $imageFiles[$i];

            // The ALT attribute in the HTML <img> tag is used to send the name and path
            // of the full sized image to the JavaScript 'window.open' function. This is
            // probably not an ideal solution but it works!
            // Determine the filename of this thumbnail
            $thumbName = basename($thisImage);

            // Strip the prefix that was added to the file name
            $imageName = str_replace($thumbPrefix, '', $thumbName);

            // Build the path to the fullsize image
            $imagePath = $imageFolder . '/' . $imageName;

            echo '<img src="' . $thisImage . '" alt="' . $imagePath . '" class="thumbnail">';
        }
        echo '</section><footer>- ' . $thisPage . ' -</footer>';
    ?>

    <script>
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
    </script>

    </body>

</html>