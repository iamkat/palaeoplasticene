<?php

function queryLicenses() {
    $sql = "SELECT license FROM ppc_licenses";

    try {
        require 'data/credentials.php';
    
        $queryLicense = $dbConnection->prepare($sql);
        $queryLicense->execute();
        $licensesData = $queryLicense->fetchAll(PDO::FETCH_COLUMN);

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    } 

    if (empty($licensesData)) {
        return;
    } else {
        return $licensesData;
    }
}

$licenses = queryLicenses();

if (!empty($licenses)) {
    $_SESSION['licenses'] = $licenses;
}
?>