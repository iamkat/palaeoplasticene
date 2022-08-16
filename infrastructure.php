<?php
// -----------------------------------------------
// FUNCTIONS
// -----------------------------------------------

// Function to check if a user is logged in
function checkLogin() {
    // Both session variables will be set only after a user has logged in
    if (!$_SESSION['user'] || !$_SESSION['token']) {
        header('Location: denied.php');
    } elseif (!password_verify($_SESSION['user'], $_SESSION['token'])) {
        header('Locatoin: denied.php');
    }
}

// Function to generate a shortname (slug) from a string (e. g. catgeory title)
function categorySlug($name) {
    $slug = trim($name);
    $slug = preg_replace('/\s+/', '', $slug);
    $slug = strtolower($slug);
    return $slug;
}
?>