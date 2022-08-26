<?php 
// Header
require 'header.php'; 
?>

<main>

<?php
try {
  // Database Login
  require 'queries/credentials.php';

  // Query
  $categoriesQuery = $dbConnection->prepare('SELECT ppc_category FROM ppc_categories');
  $categoriesQuery->execute();
  $categoriesData = $categoriesQuery->fetchAll(PDO::FETCH_COLUMN);

  $dbConnection = null;

  foreach ($categoriesData as $value) {    
    $_SESSION['categories'][categorySlug($value)] = $value;
  }
}
catch(PDOException $error) {
  $categoriesData = $error->getMessage();
}
?>

<nav id="frontMenu">

    <?php
    // Begin of the loop to create the frontpage menu from the categories constant created in the header
    foreach ($_SESSION['categories'] as $key => $value) {
      ?>
        <div class="frontMenuItem">
            <a class="ppcLink navLink" href="./<?php print($key); ?>.php" title="<?php print($value); ?> Experiment" target="_self" data-category="<?php print($value); ?>"><div class="ppcCircle"><img class="expLogo" src="./assets/img/<?php print($key); ?>.png" alt="Palaeoplastiscene <?php print($value); ?>" decoding="async" loading="lazy" /></div></a>
            <p class="frontMenuItemCaption"><?php print($value); ?></p>
        </div>
      <?php
    }
    ?>

</nav>

</main>

<?php
// Footer
require 'footer.php';
?>