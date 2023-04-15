<?php

function queryTaphonomyImages($experimentId) {
    $sql = "SELECT * FROM ppc_taphonomy_images WHERE ppc_exp_id = :expId";

    try {
        require 'data/credentials.php';
    
        $queryTaphonomyImages = $dbConnection->prepare($sql);
        $queryTaphonomyImages->bindParam(':expId', $experimentId);
        $queryTaphonomyImages->execute();
        $taphonomyImagesData = $queryTaphonomyImages->fetchAll(PDO::FETCH_ASSOC);

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    } 

    if (empty($taphonomyImagesData)) {
        return;
    } else {
        return $taphonomyImagesData;
    }
}

if (!empty($_SESSION['experimentId'])) {
    $taphonomyImages = queryTaphonomyImages($_SESSION['experimentId']);
} else {
    exit(json_encode('bla'));
}

if (!empty($taphonomyImages)) {
    if (!empty($_POST['js'])) {
        $taphonomyImages['experimentId'] = $_SESSION['experimentId'];
        $taphonomyImages['user'] = $_SESSION['user'];
        exit(json_encode($taphonomyImages));
    } else {
        $_SESSION['taphonomyImages'] = $taphonomyImages;
    }
}
?>