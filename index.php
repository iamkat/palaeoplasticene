<?php 
// Header
require 'header.php'; 
?>

<main>

<?php
try {
  // Database Login
  require('./assets/credentials.php');

  // Query
  $categoriesQuery = $ppcDBLogin->prepare('SELECT ppc_category FROM ppc_categories');
  $categoriesQuery->execute();
  $_SESSION['categories'] = $categoriesQuery->fetchAll(PDO::FETCH_COLUMN);
}
catch(PDOException $error) {
  $_SESSION['categories'] = $error->getMessage();
}
?>

<nav id="frontMenu">

    <?php
    // Begin of the loop to create the frontpage menu from the categories constant created in the header
    for ($i = 0; $i < sizeof($_SESSION['categories']); $i++) {
        // Manipulate each category name and store it to a variable
        $categoryTitle = trim($_SESSION['categories'][$i]);
        $categoryTitle = preg_replace('/\s+/', '', $categoryTitle);
        $categoryTitle = strtolower($categoryTitle);
        ?>
        <div class="frontMenuItem">
            <a class="ppcLink navLink" href="./<?php print($categoryTitle); ?>.php" title="<?php print($_SESSION['categories'][$i]); ?> Experiment" target="_self" data-category="<?php print($_SESSION['categories'][$i]); ?>"><div class="ppcCircle"><img class="expLogo" src="./assets/img/<?php print($categoryTitle); ?>.png" alt="Palaeoplastiscene <?php print($_SESSION['categories'][$i]); ?>" decoding="async" loading="lazy" /></div></a>
            <p class="frontMenuItemCaption"><?php print($_SESSION['categories'][$i]); ?></p>
        </div>
    <?php
    // End of the loop to create the frontpage menu
    }
    ?>

</nav>

</main>

<?php
// Footer
require 'footer.php';
?>