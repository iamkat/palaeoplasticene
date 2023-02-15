<?php
if (!empty($_SESSION['experimentData'])) {
    unset($_SESSION['experimentData']);
}

if (!empty($_SESSION['taphonomyImages'])) {
    unset($_SESSION['taphonomyImages']);
}

if (!empty($_SESSION['experimentId'])) {
    unset($_SESSION['experimentId']);
}

?>