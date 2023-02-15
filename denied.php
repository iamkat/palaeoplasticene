<?php
// Continue the Session
session_start();

// Load infrastructure
require 'infrastructure.php';

// Page Header
require 'header.php';
?>

<main>
    <h1>Access denied</h1>
    <p>You will be redirected to our <a href="./" title="Palaeoplasticene Frontpage" target="_self">frontpage</a> in a few seconds.</p>
</main>

<?php
// Footer
require 'footer.php';
?>