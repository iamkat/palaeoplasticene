<?php
session_start();
// -----------------------------------------------

if ($_SESSION['experimentData']) {
    unset($_SESSION['experimentData']);
}

if ($_SESSION['taphonomyImages']) {
    unset($_SESSION['taphonomyImages']);
}

if ($_SESSION['experimentId']) {
    unset($_SESSION['experimentId']);
}

?>