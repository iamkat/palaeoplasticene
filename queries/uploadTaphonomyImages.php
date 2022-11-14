<?php
session_start();

// Set up variables
$user = $_SESSION['user'];
$experimentId = $_SESSION['experimentId'];
$errors = [];
$imgData = array(
    'Filename' => '',
    'Date' => NULL,
    'Conditions' => '',
    'View' => '',
    'Notes' => "",
    'ppc_exp_id' => $experimentId,
    'ppc_usr_id' => $user,
);

// Upload directories
$directory = printf('../uploads/%s/Taphonomy/%s', $user, $experimentId);
$thumbDirectory = printf('%s/thumbs', $directory);

// -----------------------------------------------
// WORK

// Check if upload paths exist
if (!file_exists($directory)) {
    mkdir($directory, 0777, true);
} else if (!file_exists($thumbDirectory)) {
    mkdir($thumbDirectory, 0777, true);
}

// Get the image count if exists
if ($_POST['imageCount']) {
    $imgCount = $_POST['imageCount'];
} else {
    exit('Something went awefully wrong. We recommend you to logout, reload the page and try again. Feel free to contact us.');
}

// Loop over the uploaded images
for ($i = 1; $i <= $imgCount; $i++) {
    // File Validation
    if ($_FILES['imageFile' . $i]['size'] > 9216000) {
        $errors[] = 'Sorry, the image file ' . $_FILES['imageFile' . $i]['name'] . ' exceeds the maximum file size and will not be uploaded. Please resize this image and try again.';
        continue;
    } else if ($_FILES['imageFile' . $i]['type'] != 'image/jpeg' || $_FILES['imageFile' . $i]['type'] != 'image/png') {
        $errors[] = 'Only .jpg or .png file formats are supported. The following image cannot be uploaded: ' . $_FILES['imageFile' . $i]['name'];
        continue;
        // Image View Validation
    } else if (!in_array($_POST['imageView' . $i], $_SESSION['views'])) {
        $errors[] = 'Something went awefully wrong with the selection of the view for the following image: ' . $_FILES['imageFile' . $i]['name'] . '. Please try again or contact us for further questions.';
        continue;
    } else {
        $imgFile = $_FILES['imageFile' . $i];

        // Text input sanitization
        $imgConditions = sanitizeTextInputs($_POST['imageConditions' . $i]);
        $imgNotes = sanitizeTextInputs($_POST['imageNotes' . $i]);

        // Fill the image data array
        $imgData['Filename'] = $imgFile['name'];
        $imgData['Date'] = $_POST['imageDate' . $i];
        $imgData['Conditions'] = $imgConditions;
        $imgData['View'] = $_POST['imageView' . $i];
        $imgData['Notes'] = $imgNotes;

        // Check if file exists in database
        if (checkFileExists($imgFile['name'])) {
            $imgFile['name'] = printf('%s_%s', date('Ymd_His'), $imgFile['name']);
        }

        // Upload file with error fallback
        if (!move_uploaded_file($imgFile['tmp_name'], printf('%s/%s', $directory, $imgFile['name']))) {
            $errors[] = 'Failed to upload the following file: ' . $imgFile['name'] . '. Please try again or contact us for further questions.';
        }

        // Create and upload the thumbnail
        if (!createThumbnail(printf('%s/%s', $directory, $imgFile['name']), printf('%s/%s', $thumbDirectory, $imgFile['name']))) {
            $errors[] = 'Failed to create and upload a thumbnail for the following image file: ' . $imgFile['name'] . '. Please try again or contact us for further questions.';
        }

        // Save image data with fallback
        if (saveImageData($imgData) != "Success") {
            $errors[] = 'Failed to save the image data for the following image file: ' . $imgFile['name'] . '. Please try again or contact us for further questions.';
        }
    }
}

if (empty($errors)) {
    exit('Images and data have been successfully uploaded.');
} else {
    exit(json_encode($errors));
}

// -----------------------------------------------
// FUNCTIONS

function sanitizeTextInputs($text) {
    $text = trim($text);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = preg_replace('/\W/', '', $text);
    return $text;
}

function checkFileExists($filename) {
    $sql = "SELECT * FROM ppc_taphonomy_images WHERE `Filename` = $filename";

    try {
        require './credentials.php';

        $queryFilename = $dbConnection->prepare($sql);
        $queryFilename->execute();
        $queryData = $queryFilename->fetch();

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    }

    return empty($queryData) ? false : true;
}

function createThumbnail($imageFilePath, $thumbnailPath) {
    // Get the orientation from the EXIF data
    $metaData = exif_read_data($imageFilePath, 0, false);
    $orientation = $metaData['Orientation'];

    // Create the image
    if (mime_content_type($imageFilePath) == 'image/jpeg') {
        $gdImage = imagecreatefromjpeg($imageFilePath);
    } else {
        $gdImage = imagecreatefrompng($imageFilePath);
    }

    // Scale the image
    $thumbnail = imagescale($gdImage, 100, -1, IMG_BICUBIC);

    // Rotate and flip the image according to its orientation value
    switch ($orientation) {
        case 2:
            $thumbnail = imageflip($thumbnail, IMG_FLIP_HORIZONTAL);
            break;
        case 3:
            $thumbnail = imagerotate($thumbnail, 180, 0);
            break;
        case 4:
            $thumbnail = imageflip($thumbnail, IMG_FLIP_VERTICAL);
            break;
        case 5:
            $thumbnail = imagerotate($thumbnail, -90, 0);
            $thumbnail = imageflip($thumbnail, IMG_FLIP_HORIZONTAL);
            break;
        case 6:
            $thumbnail = imagerotate($thumbnail, -90, 0);
            break;
        case 7:
            $thumbnail = imagerotate($thumbnail, 90, 0);
            $thumbnail = imageflip($thumbnail, IMG_FLIP_HORIZONTAL);
            break;
        case 8:
            $thumbnail = imagerotate($thumbnail, 90, 0);
            break;
        default:
            break;
    }

    // Save the thumbnail with fallback
    if (mime_content_type($imageFilePath) == 'image/jpeg') {
        if (!imagejpeg($thumbnail, $thumbnailPath, 100)) {
            return false;
        }
    } else if (mime_content_type($imageFilePath == 'image/png')) {
        if (!imagepng($thumbnail, $thumbnailPath, 0, -1)) {
            return false;
        }
    }

    imagedestroy($thumbnail);
    imagedestroy($gdimage);

    return true;
}

function saveImageData($data) {
    $sql = "INSERT INTO ppc_taphonomy_images (`Filename`, `Date`, Conditions, View, Notes, ppc_exp_id, ppc_usr_id, Upload) VALUES (" . $data['Filename'] . ", " . $data['Date'] . ", " . $data['Conditions'] . ", " . $data['View'] . ", " . $data['Notes'] . ", " . $data['ppc_exp_id'] . ", " . $data['ppc_usr_id'] . ")";

    try {
        require './credentials.php';

        $insertImage = $dbConnection->prepare($sql);
        $insertImage->execute();

        $dbConnection = NULL;
    } catch (PDOException $error) {
        exit($error->getMessage());
    }

    return 'Success';
}
?>