<?php
session_start();
// -----------------------------------------------

function queryTaphonomyImages($experimentId) {
    $sql = "SELECT * FROM ppc_taphonomy_images WHERE ppc_exp_id = $experimentId";

    try {
        require 'credentials.php';
    
        $queryTaphonomyImages = $dbConnection->prepare($sql);
        $queryTaphonomyImages->execute();
        $taphonomyImagesData = $queryTaphonomyImages->fetchAll(PDO::FETCH_ASSOC);

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    } 

    return $taphonomyImagesData;
}

if ($_SESSION['experimentId']) {
    $taphonomyImages = queryTaphonomyImages($_SESSION['experimentId']);
}

if (!empty($taphonomyImages)) {
    if ($_POST['js']) {
        $taphonomyImages['experimentId'] = $_SESSION['experimentId'];
        $taphonomyImages['user'] = $_SESSION['user'];
        exit(json_encode($taphonomyImages));
    } else {
        $_SESSION['taphonomyImages'] = $taphonomyImages;
    }
}
?>