# Simplistic Thumbnail Gallery
An image thumbnail gallery app utilizing PHP, CSS, JavaScript and HTML.

This project is essentially a practice coding project for me, used as a vehicle for learning and improving my own web development skills.

The project contains a utility script that will read full sized image files and generate properly scaled thumbnail images for each file.
The page will display the smaller versions of the images when viewing the gallery page, but will display the full sized image in a new
window when a gallery thumbnail is clicked.

The utility script has been tested by generating thumbnails for 1480+ PNG files, all with a maximum size of 1920x1080. It worked well, and
generated thumbnails for all 1480 images but I DO NOT recommend that the script be used to generate thumbnails for any more than 100 images!

The gallery supports PNG, JPG, JPEG, and GIF files.  Images with transparent sections and animated images are NOT supported. They may work
fine after being resized, but I have not tested it. 

Copyright 2024 F. Adams
