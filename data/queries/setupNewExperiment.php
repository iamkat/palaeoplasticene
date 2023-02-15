<?php
header('Content-Type: text/plain; charset=utf-8');
session_start();
// -----------------------------------------------

// Get POST variables
$category = $_POST['category'];

if (empty($category)) {
    exit();
} else {
    $_SESSION['experimentCategory'] = $category;
    exit('confirm');
}

?>