<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="Palaeoplasticene, Kat Austen" />
        <meta name="description" content="Website for the Palaeoplasticene project" />
        <meta name="author" content="Andreas Baudisch, Kat Austen" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="canonical" href="<?php
            $ppcProtocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $ppcUrl = $ppcProtocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            print_r($ppcUrl); ?>" />
        <title>Palaeoplasticene</title>
        <base href="https://palaeoplasticene.katausten.com" target="_blank" />
        <link rel="stylesheet" href="./css/style.css" media="all" />
        <link rel="stylesheet" href="./css/font.css" media="all" />
        <link rel="stylesheet" href="./css/forms.css" media="all" />
    </head>
    <body>
    <header id="ppcHeader">
        <nav id="ppcNav">
            <button id="ppcPrevious" class="ppcNavButton" type="button" name="ppcPrevious"><img id="ppcArrowLeft" class="ppcArrow" src="./assets/img/ppc_arrow.png" alt="arrow" /></button>
            <label for="ppcPrevious" class="ppcNavButtonLabel">Back</label>
            <img id="ppcTaphonomyIcon" class="ppcExpIcon" src="./assets/img/ppc_taphonomyIcon.png" alt="Taphonomy" />
            <a id="ppcHomeLink" class="ppcLink" href="<?php print_r($ppcProtocol . $_SERVER['HTTP_HOST']); ?>/index.php" target="_self"><h1 class="ppcHeading">Palaeoplasticene</h1></a>
            <img id="ppcCrystalsIcon" class="ppcExpIcon" src="./assets/img/ppc_crystalsIcon.png" alt="Crystals" />
            <label for="ppcNext" class="ppcNavButtonLabel">Next</label>
            <button id="ppcNext" class="ppcNavButton" type="button" name="ppcNext"><img id="ppcArrowRight" class="ppcArrow" src="./assets/img/ppc_arrow.png" alt="arrow" /></button>
        </nav>
    </header>
