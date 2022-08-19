<?php
header('Content-Type: text/plain; charset=utf-8');
session_start();
// -----------------------------------------------

// Experiment variables
$category = $_POST['category'];
$experimentId = $_POST['experimentId'];

// Function to query an experiment with its ID
function queryExperiment($id, $category) {
    // Create the table name
    $experimentsTable = sprintf('ppc_%s_experiments', $category);
    $sql = "SELECT * FROM $experimentsTable WHERE ppc_exp_id = $id";

    try {
        require 'credentials.php';

        $experimentsQuery = $dbConnection->prepare($sql);
        $experimentsQuery->execute();
        $data = $experimentsQuery->fetchAll(PDO::FETCH_ASSOC);
    
        $dbConnection = null;
    } catch (PDOException $error) {
        exit($error->getMessage());
    }

    return $data;
}

// Check for experiment
$experiment = queryExperiment($experimentId, $category);

if (empty($experiment)) {
    exit();
} else {
    $_SESSION['experimentData'] = $experiment;
    exit('confirm');
}
?>