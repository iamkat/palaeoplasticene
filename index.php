<?php
/**
 * Set up a simple router as a switch to compare against the requested URI
 */

// Requested URI
$request = $_SERVER['REQUEST_URI'];

// Path to the page templates
$viewDir = '/views/';

switch ( $request ) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;

    case '/taphonomy':
        require __DIR__ . $viewDir . 'taphonomy.php';
        break;

    case '/crystals':
        require __DIR__ . $viewDir . 'crystals.php';
        break;

    case '/sounds':
        require __DIR__ . $viewDir . 'sounds.php';
        break;

    case '/incidental-taphonomy':
        require __DIR__ . $viewDir . 'incidental-taphonomy.php';
        break;

    case '/fiction':
        require __DIR__ . $viewDir . 'fiction.php';
        break;

    case '/login':
        require __DIR__ . $viewDir . 'login.php';
        break;

    case '/overview':
        require __DIR__ . $viewDir . 'overview.php';
        break;

    case '/denied':
        require __DIR__ . $viewDir . 'denied.php';
        break;

    case '/experiment-taphonomy':
        require __DIR__ . $viewDir . 'experiment-taphonomy.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
?>