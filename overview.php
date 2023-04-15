<?php
// Page Header
require 'header.php';

// Login Check (with a custom function from infrastructure.php)
checkLogin();

// Clean up
include 'data/queries/clearCache.php';

// Array for errors
$errors = array();

// Function to query experiments according to their category
function queryExperiments($user, $category) {
    // Create the table name
    $experimentsTable = sprintf('ppc_%s_experiments', $category);
    $sql = "SELECT * FROM $experimentsTable WHERE user_id = '$user'";

    try {
        require 'data/credentials.php';

        $experimentsQuery = $dbConnection->prepare($sql);
        $experimentsQuery->execute();
        $data = $experimentsQuery->fetchAll(PDO::FETCH_ASSOC);

        $dbConnection = null;
    } catch (PDOException $error) {
        $errors[] = $error->getMessage();
    }

    if (empty($data)) {
        return "There are no experiments yet.";
    } else {
        return $data;
    }
}

// Check if categories have already been queried
if (empty($_SESSION['categories'])) {
    // Query for categories with a custom function (infrastructure.php) and store each category inside a session cookie
    foreach (queryCategories() as $value) {    
        $_SESSION['categories'][$value['cat_slug']] = $value['cat_name'];
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
        $experiments = queryExperiments($_SESSION['user']->get_id(), $slug);

        if (!empty($experiments)) {

            // Create a session variable for categorie's experiments
            $_SESSION[$slug . 'Experiments'] = array();

            foreach ($experiments as $exp) {
                // Create a dynamic class name
                $className = ucfirst($slug);

                // Create Experiment Objects and put them in the session storage
                $_SESSION[$slug . 'Experiments'][] = new $className(
                    $exp['experiment_id'], // Experiment id
                    $exp['Name'], // Experiment name
                    $slug, // Experiment category slug
                    $exp['user_id'], // Experiment user id
                    $exp['License'], // Experiment license
                );

                // HOW TO DYNAMICALLY CREATE THE SUBCLASS?
                ?>
                <div class="overviewExperiment">
                    <h3><?php print($exp['Name']); ?></h3>
                    <?php
                        foreach ($exp as $key => $value) {
                            if ($key == 'experiment_id' || $key == 'Name' || $key == 'user_id') {
                                continue;
                            }
                            ?>
                            <p class="expMeta"><strong><?php print($key); ?>:</strong> <?php print($value); ?></p>
                            <?php
                        }
                    ?>
                    <div>
                        <button type="button" class="editBtn" data-category="<?php print($slug); ?>" data-experiment-id="<?php print($exp['experiment_id']) ?>">Edit</button>
                    </div>
                </div>
                <?php
            }
            
        }
        ?>
        <div class="newExperiment">
            <button type="button" class="newBtn" data-category="<?php print($slug); ?>">New Experiment</button>
        </div>
        </section>
        <?php
    // End of the loop to create the overview menu
    print_r($_SESSION[$slug . 'Experiments']);
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