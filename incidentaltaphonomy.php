<?php
// Page Header
require 'header.php';
?>

<main>

<?php 
// Prepare Parsedown
$htmlContent = new Parsedown();
// Parse the markdown content if the category exists (The variables $categoryName and $currentFilename are defined inside the header.php)
if (in_array($categoryName, $_SESSION['categories'])) {
    print $htmlContent->text(file_get_contents('content/' . $currentFilename . '.md'));
}
?>

</main>

<?php 
// Page Footer
require 'footer.php' ; 
?>