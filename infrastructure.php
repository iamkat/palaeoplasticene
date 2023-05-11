<?php
// Autoload classes
spl_autoload_register(function ($class_name) {
    $classPath = str_replace('\\', '/', $class_name);
    $file = 'classes/' . $classPath . '.php';
    if (file_exists($file)) {
       include $file;
    }
 });

// -----------------------------------------------
// CUSTOM GLOBAL VARIABLES
// -----------------------------------------------

$noIconsPages = ['/', '/index', '/overview'];

// -----------------------------------------------
// CUSTOM FUNCTIONS
// -----------------------------------------------

// Function to check if a user is logged in
function checkLogin() {
    // The variable will be set after a user has successfully logged in
    if (!$_SESSION['user']) {
        header('Location: denied');
    } elseif (!password_verify($_SESSION['user']->get_name(), $_SESSION['user']->get_token())) {
        header('Location: denied');
    } else {
        $_SESSION['authentication'] = true;
    }
}

// Function to generate a shortname (slug) from a string (e. g. catgeory title)
function categorySlug($name) {
    $slug = trim($name);
    $slug = preg_replace('/\s+/', '', $slug);
    $slug = strtolower($slug);
    return $slug;
}

// Function to print style link
function ppcStyle($styleName) {
    printf('<link rel="stylesheet" href="./css/%s.css" media="all" />', $styleName);
}

// Scripts for different sites
function ppcScript($scriptName) {
    printf('<script src="./js/%s.js" type="text/javascript"></script>', $scriptName);
}

// Function to query for existing categories in the database
function queryCategories() {
    $sql = "SELECT cat_name, cat_slug FROM ppc_categories";
  
    try {
      // Database Login
      require 'data/credentials.php';
    
      // Query
      $categoriesQuery = $dbConnection->prepare($sql);
      $categoriesQuery->execute();
      $categoriesData = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);
    
      $dbConnection = null;
    }
    catch(PDOException $error) {
      $categoriesData = $error->getMessage();
    }
  
    return $categoriesData;
  }
?>