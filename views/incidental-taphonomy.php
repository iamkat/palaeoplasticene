<?php
// Page Header
require 'parts/header.php';
?>

<main>

<?php 
// Prepare Parsedown
$htmlContent = new Parsedown();
// Parse the markdown content if the category exists (The variable $currentPath is defined inside the header.php)
if ($_SESSION['categories'][$currentPath]) {
    print $htmlContent->text(file_get_contents('content/' . $currentPath . '.md'));
}
?>

</main>

<?php 
// Page Footer
require 'parts/footer.php' ; 
?>