<?php
// Load infrastructure
require 'infrastructure.php';

// Begin or continue a Session
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
        <!--base href="https://palaeoplasticene.katausten.com" target="_blank" /-->
        <link rel="canonical" href="<?php
            $ppcProtocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $ppcUrl = $ppcProtocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            print_r($ppcUrl); ?>" />
        <link rel="icon" type="image/x-icon" href="favicon.png">
        <link rel="stylesheet" href="./css/font.css" media="all" />
        <link rel="stylesheet" href="./css/style.css" media="all" />
        <link rel="stylesheet" href="./css/header.css" media="all" />
        <link rel="stylesheet" href="./css/footer.css" media="all" />
        <link rel="stylesheet" href="./css/construction.css" media="all" />

        <?php
        // Switch to print style links for the different sites with custom function (infrastructure.php)
        switch ($_SERVER["REQUEST_URI"]) {
            case '/':
            case '/index':
                ppcStyle('index');
                break;
            case '/login':
                ppcStyle('login');
                break;
            case '/profile':
                ppcStyle('profile');
                break;
            case '/overview':
                ppcStyle('overview');
                break;
            case '/experiment-taphonomy':
                ppcStyle('experiment');
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
        if (!empty($_SESSION['categories'])) {
            // Add category pages to custom global array of pages where not to display the icons (infrastructure.php)
            foreach ($_SESSION['categories'] as $key => $value) {
                array_push($noIconsPages, '/experiment-' . $key);
            }
            
            // Conditionally render the navbar with icon display
            if (!in_array($_SERVER['REQUEST_URI'], $noIconsPages)) {
                foreach ($_SESSION['categories'] as $key => $value) {
                    ?>
                        <a class="ppcLink iconLink" href="./<?php print($key); ?>" target="_self" title="<?php print($value); ?>"><img class="expIcon" src="./assets/img/<?php print($key); ?>.png" alt="<?php print($value); ?>" /></a>
                    <?php
                }
            }
        }

        // Include Parsedown
        include 'vendor/Parsedown.php';

        // Get the current path
        $currentPath = basename($_SERVER['REQUEST_URI']);
        ?>

        </nav>
    </header>