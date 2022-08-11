<?php 
// Page Header
require 'header.php';
?>

<main>

<?php
// Prepare Parsedown
$htmlContent = new Parsedown();

// Parse the 404.md
print $htmlContent->text(file_get_contents('content/404.md'));
?>

</main>

<?php 
// Page Footer
require 'footer.php'; 
?>