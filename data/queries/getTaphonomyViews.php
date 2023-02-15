<?php

function queryViews() {
    $sql = "SELECT View FROM ppc_taphonomy_views";

    try {
        require 'data/credentials.php';
    
        $queryViews = $dbConnection->prepare($sql);
        $queryViews->execute();
        $viewsData = $queryViews->fetchAll(PDO::FETCH_COLUMN);

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    } 

    if (empty($viewsData)) {
        return;
    } else {
        return $viewsData;
    }
}

$views = queryViews();

if (!empty($views)) {
    if (!empty($_POST['js'])) {
        exit(json_encode($views));
    } else {
        $_SESSION['views'] = $views;
    }
}
?>