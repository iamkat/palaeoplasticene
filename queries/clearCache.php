<?php
session_start();
// -----------------------------------------------

if ($_SESSION['experimentData']) {
    unset($_SESSION['experimentData']);    
}

exit('confirm');

?>