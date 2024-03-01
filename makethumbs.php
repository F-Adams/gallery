<?php
// Configurable things
$imagesFolder = 'images';               // Source folder containing original images
$thumbsFolder = 'thumbs';               // Destination folder for thumbnail images
$extensions = "jpg,jpeg,png,gif";       // Supported image file extensions
$maxThumbWidth = 250;                   // Maximum thumbnail width, in pixels
$thumbPrefix = "thumbnail_";            // Prefix to add to thumbnail image file names
set_time_limit(300);                    // Set the execution time limit for this script to 5 minutes

// Get list of image files in the source folder
$imageFiles = glob($imagesFolder . '/*.{' . $extensions . '}', GLOB_BRACE);

// Generate thumbnails for each image file
foreach ($imageFiles as $orgImage) {
    // Get the original image details
    $orgInfo = getimagesize($orgImage);
    $orgWidth = $orgInfo[0];
    $orgHeight = $orgInfo[1];
    $orgType = $orgInfo['mime'];

    // Create image resource based on file type
    switch ($orgType) {
        case 'image/jpeg':
            $srcImage = imagecreatefromjpeg($orgImage);
            break;
        case 'image/png':
            $srcImage = imagecreatefrompng($orgImage);
            break;
        case 'image/gif':
            $srcImage = imagecreatefromgif($orgImage);
            break;
        default:
            continue 2; // Skip unsupported file formats
    }

    // Calcualte the aspect ratio of the original image
    $orgRatio = $orgWidth / $orgHeight;

    // Calculate the thumbnail height based on the desired width, while maintaining aspect ratio
    $thumbHeight = $maxThumbWidth / $orgRatio;

    // Create a thumbnail image
    $thumbImage = imagecreatetruecolor($maxThumbWidth, $thumbHeight);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $maxThumbWidth, $thumbHeight, $orgWidth, $orgHeight);

    // Save the thumbnail image to the destination folder
    $thumbnail = $thumbsFolder . '/' . $thumbPrefix . basename($orgImage);
    imagejpeg($thumbImage, $thumbnail);

    // Free up memory
    imagedestroy($srcImage);
    imagedestroy($thumbImage);
}
echo("<br>Thumbnail generation complete!");
?>
