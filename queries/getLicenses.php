<?php
session_start();
// -----------------------------------------------

function queryLicenses() {
    $sql = "SELECT license FROM ppc_licenses";

    try {
        require 'credentials.php';
    
        $queryLicense = $dbConnection->prepare($sql);
        $queryLicense->execute();
        $licensesData = $queryLicense->fetchAll(PDO::FETCH_COLUMN);

        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    } 

    return $licensesData;
}

$licenses = queryLicenses();

if (!empty($licenses)) {
    $_SESSION['licenses'] = $licenses;
}
?>