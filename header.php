<?php 
session_set_cookie_params([
    "lifetime"=>"0",
    "path"=>"/",
    "domain"=>$_SERVER["HTTP_HOST"],
    "secure"=>true,
    "httponly"=>true,
    "samesite"=>"strict"
]);
session_start();
?>

<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="Palaeoplasticene, Kat Austen" />
        <meta name="description" content="Website for the Palaeoplasticene project" />
        <meta name="author" content="Andreas Baudisch, Kat Austen" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <title>Palaeoplasticene</title>
        <base href="https://palaeoplasticene.katausten.com" target="_blank" />
        <link rel="canonical" href="<?php
            $ppcProtocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $ppcUrl = $ppcProtocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            print_r($ppcUrl); ?>" />
        <link rel="icon" type="image/x-icon" href="favicon.png">
        <link rel="stylesheet" href="./css/font.css" media="all" />
        <link rel="stylesheet" href="./css/style.css" media="all" />
        <link rel="stylesheet" href="./css/header.css" media="all" />
        <link rel="stylesheet" href="./css/construction.css" media="all" />

        <?php
        // Function to print style link
        function ppcStyle($styleName) {
            printf('<link rel="stylesheet" href="./css/%s.css" media="all" />', $styleName);
        }

        // Switch to print style links for the different sites
        switch ($_SERVER["REQUEST_URI"]) {
            case '/':
                ppcStyle('index');
                break;
            case "/index.php":
                ppcStyle("index");
                break;
            case "/login.php":
                ppcStyle("login");
                break;
            case "/profile.php":
                ppcStyle("profile");
                break;
            case "/overview.php":
                ppcStyle("overview");
                break;
            case "/experiment-taphonomy.php":
                ppcStyle("experimentTaphonomy");
                break;
        }
        ?>

    </head>
    <body>
    <header>
        <a id="homeLink" class="ppcLink" href="<?php print_r($ppcProtocol . $_SERVER['HTTP_HOST']); ?>" target="_self">Palaeoplasticene</a>
        <nav id="iconDisplay">
        
        <?php 
        // Check if the categories have been queried and exist as a session variable
        if ($_SESSION['categories']) {
            // Condition to render the navbar with icon display
            if ($_SERVER['REQUEST_URI'] !== '/' && $_SERVER['REQUEST_URI'] !== '/index.php' && $_SERVER['REQUEST_URI'] !== '/overview.php') {
                for ($i = 0; $i < sizeof($_SESSION['categories']); $i++) {
                    // Manipulate each category title and store it to a variable
                    $categoryTitle = trim($_SESSION['categories'][$i]);
                    $categoryTitle = preg_replace('/\s+/', '', $categoryTitle);
                    $categoryTitle = strtolower($categoryTitle);
                ?>
                    <a class="ppcLink iconLink" href="./<?php print($categoryTitle); ?>.php" target="_self" title="<?php print($_SESSION['categories'][$i]); ?>"><img class="expIcon" src="./assets/img/<?php print($categoryTitle); ?>.png" alt="<?php print($_SESSION['categories'][$i]); ?>" /></a>
                <?php
                }
            }
        }

        // Include Parsedown
        include 'vendor/Parsedown.php';

        // Create Category Name out of current file name
        $currentFilename = basename($_SERVER['SCRIPT_FILENAME'], '.php');
        $categoryName = ucfirst($currentFilename);

        // Exceptions with two words as a category name
        switch ($categoryName) {
            case 'Incidentaltaphonomy':
            $categoryName = 'Incidental Taphonomy';
            break;
        }
        ?>

        </nav>
    </header>