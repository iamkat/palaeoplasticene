<?php
session_start();
// -----------------------------------------------

if ($_POST['imageId']) {
    $imgId = $_POST['imageId'];
} else {
    exit('Something went awefully wrong. We recommend you to logout, reload the page and try again. Feel free to contact us.');
}

if ($_POST['edits']) {
    $edits = json_decode($_POST['edits']);
    foreach ($edits as $key => $value) {
        if (!updateImage($imgId, $key, $value)) {
            exit('Something went awefully wrong. We recommend you to logout, reload the page and try again. Feel free to contact us.');
        }
    }

    exit('Image data successfully updated.');
} else {
    exit('Something went awefully wrong. We recommend you to logout, reload the page and try again. Feel free to contact us.');
}

function updateImage($id, $column, $data) {
    $sql = "UPDATE ppc_taphonomy_images SET $column = '$data' WHERE ppc_img_id = $id";

    try {
        require 'credentials.php';
    
        $editImageData = $dbConnection->prepare($sql);
        $response = $editImageData->execute();

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    } 

    return $response;
}
?>