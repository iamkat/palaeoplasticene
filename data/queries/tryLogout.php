<?php
header('Content-Type: text/plain; charset=utf-8');
// -----------------------------------------------

// Resume the current session
session_start();

// Destroy the session variables
if (session_destroy()) {
    exit();
} else {
    exit('failed');
}

?>