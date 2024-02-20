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
                --paging-link-color: #fff;
                /* Paging link hover color */
                --paging-hover-color: #00f;
                /* Active page link background color */
                --paging-active-page: #00b;
                /* Inactive page link background color */
                --paging-inactive-page: #151515;

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
            echo '<li class="responsive"><a href="?page=' . ($thisPage - 1) . '">&laquo;</a></li>';
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
            echo '<li class="responsive"><a href="?page=' . ($thisPage + 1) . '">&raquo;</a></li>';
        } else {
            echo '<li class="responsive next">&raquo;</li>';
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