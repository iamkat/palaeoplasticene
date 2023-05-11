<?php
// Require instead of include the Header because it's part of every pages layout
require 'parts/header.php';

// Query for categories with a custom function (infrastructure.php) and store each category inside a session cookie
foreach (queryCategories() as $value) {    
  $_SESSION['categories'][$value['cat_slug']] = $value['cat_name'];
}

// Set the initial authentication status as a session cookie
if ( empty($_SESSION['authentication']) ) {
  $_SESSION['authentication'] = false;
}
?>

<main>

<nav id="frontMenu">

    <?php
    // Begin of the loop to create the frontpage menu from the categories constant created in the header
    foreach ($_SESSION['categories'] as $key => $value) {
      ?>
        <div class="frontMenuItem">
            <a 
              class="ppcLink navLink" 
              href="./<?php print($key); ?>" 
              title="<?php print($value); ?> Experiment" 
              target="_self" data-category="<?php print($value); ?>">
                <div class="ppcCircle">
                    <img class="expLogo" src="./assets/img/<?php print($key); ?>.png" alt="Palaeoplastiscene <?php print($value); ?>" decoding="async" loading="lazy" />
                </div>
            </a>
            <p class="frontMenuItemCaption"><?php print($value); ?></p>
        </div>
      <?php
    }
    ?>

</nav>

</main>

<?php
// Require instead of include the Footer because it's part of every pages layout
require 'parts/footer.php';
?>