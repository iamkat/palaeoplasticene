<?php
session_start();
// -----------------------------------------------

function queryViews() {
    $sql = "SELECT View FROM ppc_taphonomy_views";

    try {
        require 'credentials.php';
    
        $queryViews = $dbConnection->prepare($sql);
        $queryViews->execute();
        $viewsData = $queryViews->fetchAll(PDO::FETCH_COLUMN);

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    } 

    return $viewsData;
}

$views = queryViews();

if (!empty($views)) {
    if ($_POST['js']) {
        exit(json_encode($views));
    } else {
        $_SESSION['views'] = $views;
    }
}
?>