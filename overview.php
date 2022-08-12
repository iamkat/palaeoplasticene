<?php
// Page Header
require 'header.php';

// Login Check
if (!$_SESSION['user']) {
    header('Location: denied.php');
}

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
        $_SESSION['categories'] = $categoriesQuery->fetchAll(PDO::FETCH_COLUMN);

        $dbConnection = null;
      } catch (PDOException $error) {
        $errors[] = $error->getMessage();
      }
}
?>

<main>
    <h1>Overview</h1>

    <?php
        // Begin of the loop to create the overview menu with the experiments for each category
        for ($i = 0; $i < sizeof($_SESSION['categories']); $i++) {
            // Manipulate each category name and store it to a variable
            $categoryTitle = trim($_SESSION['categories'][$i]);
            $categoryTitle = preg_replace('/\s+/', '', $categoryTitle);
            $categoryTitle = strtolower($categoryTitle);
    ?>
        <div class="overviewTitle">
            <img class="overviewIcon" src="./assets/img/<?php print($categoryTitle); ?>.png" alt="<?php print($_SESSION['categories'][$i]); ?>">
            <h2><?php print($_SESSION['categories'][$i]); ?> Experiments</h2>
        </div>
        <section>
            
            <?php
            $experiments = queryExperiments($_SESSION['userID'], $categoryTitle);

            foreach ($experiments as $value) {
                ?>
                <div class="overviewExperiment">
                    <h3><?php print($value['ppc_exp_name']); ?></h3>
                    <p class="expMeta"><strong>Location:</strong> <?php print($value['ppc_exp_loc']); ?></p>
                    <p class="expMeta"><strong>Surroundings:</strong> <?php print($value['ppc_exp_surr']); ?></p>
                    <p class="expMeta"><strong>License:</strong> <?php print($value['ppc_license']); ?></p>
                    <div>
                        <button type="button" class="editBtn" data-experimentId="<?php print($value['ppc_exp_id']) ?>">Edit</button>
                    </div>
                </div>
                <?php
            }
            ?>

            <button type="button" class="newBtn" data-category="<?php print($categoryTitle); ?>">New Experiment</button>
        </section>
    <?php
    // End of the loop to create the overview menu
        }
    ?>
</main>

<?php
// Footer
require 'footer.php';
?>