<?php
// Page Header
require 'header.php';

// Login Check (with a custom function from infrastructure.php)
checkLogin();

// Clean up
require 'queries/clearCache.php';

// Array for errors
$errors = array();

// Function to query experiments according to their category
function queryExperiments($user, $category) {
    // Create the table name
    $experimentsTable = sprintf('ppc_%s_experiments', $category);
    $sql = "SELECT * FROM $experimentsTable WHERE ppc_usr_id = $user";

    try {
        require 'queries/credentials.php';

        $experimentsQuery = $dbConnection->prepare($sql);
        $experimentsQuery->execute();
        $data = $experimentsQuery->fetchAll(PDO::FETCH_ASSOC);
    
        $dbConnection = null;
    } catch (PDOException $error) {
        $errors[] = $error->getMessage();
    }

    return $data;
}

// Get user ID from username stored in the session global during login
try {
    // Database Login
    require 'queries/credentials.php';

    // Query
    $userIdQuery = $dbConnection->prepare('SELECT ppc_user_id FROM ppc_users WHERE ppc_username = :username');
    $userIdQuery->bindParam(':username', $_SESSION['user']);
    $userIdQuery->execute();
    $userId = $userIdQuery->fetchAll(PDO::FETCH_COLUMN);
    $_SESSION['userID'] = $userId[0];

    // Database logout
    $dbConnection = null;
} catch (PDOException $error) {
    $errors[] = $error->getMessage();
}

// Check if categories have already been queried
if (!$_SESSION['categories']) {
    try {
        require 'queries/credentials.php';
      
        $categoriesQuery = $dbConnection->prepare('SELECT ppc_category FROM ppc_categories');
        $categoriesQuery->execute();
        $categoriesData = $categoriesQuery->fetchAll(PDO::FETCH_COLUMN);

        $dbConnection = null;

        foreach ($categoriesData as $value) {    
          $_SESSION['categories'][categorySlug($value)] = $value;
        }
      } catch (PDOException $error) {
        $errors[] = $error->getMessage();
      }
}
?>

<main>
    <h1>Overview</h1>

    <?php
    // Begin of the loop to create the overview menu with the experiments for each category
    foreach ($_SESSION['categories'] as $slug => $name) {
        ?>
        <div class="overviewTitle">
            <img class="overviewIcon" src="./assets/img/<?php print($slug); ?>.png" alt="<?php print($name); ?>">
            <h2><?php print($name); ?> Experiments</h2>
        </div>
        <section class="categoryExperiments">
        
        <?php
        $experiments = queryExperiments($_SESSION['userID'], $slug);
        foreach ($experiments as $exp) {
            ?>
            <div class="overviewExperiment">
                <h3><?php print($exp['Name']); ?></h3>
                <?php
                    foreach ($exp as $key => $value) {
                        if ($key == 'ppc_exp_id' || $key == 'Name' || $key == 'ppc_usr_id') {
                            continue;
                        }
                        ?>
                        <p class="expMeta"><strong><?php print($key); ?>:</strong> <?php print($value); ?></p>
                        <?php
                    }
                ?>
                <div>
                    <button type="button" class="editBtn" data-category="<?php print($slug); ?>" data-experiment-id="<?php print($exp['ppc_exp_id']) ?>">Edit</button>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="newExperiment">
            <button type="button" class="newBtn" data-category="<?php print($slug); ?>">New Experiment</button>
        </div>
        </section>
        <?php
        // End of the loop to create the overview menu
    }

    // Create an error section if errors exist
    if (!empty($errors)) {
        ?>
        <section class="phpErrors">
        <?php
            foreach ($errors as $error) {
            ?>
                <p class="errorMsg"><?php print($error); ?></p>
            <?php
            }
            ?>
        </section>
    <?php
    }
    ?>
</main>

<?php
// Footer
require 'footer.php';
?>