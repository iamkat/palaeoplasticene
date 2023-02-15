<?php
// Session Preparation 
session_set_cookie_params([
  "lifetime"=>"0",
  "path"=>"/",
  "domain"=>$_SERVER["HTTP_HOST"],
  "secure"=>true,
  "httponly"=>true,
  "samesite"=>"strict"
]);

// Begin a Session
session_start();

// Load infrastructure
require 'infrastructure.php';

// Query for categories with a custom function (infrastructure.php) and store each category inside a session cookie
foreach (queryCategories() as $value) {    
  $_SESSION['categories'][categorySlug($value)] = $value;
}

// Set the initial authentication status as a session cookie
$_SESSION['authentication'] = false;

// Header
require 'header.php';
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
              href="./<?php print($key); ?>.php" 
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
// Footer
require 'footer.php';
?>