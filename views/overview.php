<?php
use Palaeoplasticene\Taphonomy;

// Page Header
require 'parts/header.php';

// Login Check (with a custom function from infrastructure.php)
checkLogin();

// Clean up
include 'data/queries/clearCache.php';

// Array for errors
$errors = array();

// Function to query taphonomy experiments
function queryTaphonomyExperiments($user) {
    $sql = "SELECT * FROM ppc_taphonomy_experiments WHERE user_id = '$user'";

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

// Get Taphonomy experiments
$taphonomy_experiments = queryTaphonomyExperiments($_SESSION['user']->get_id());

// Store Taphonomy Experiments as Objects inside the Session Storage
if ( !empty($taphonomy_experiments) ) {
    // Create a session variable for categorie's experiments
    $_SESSION['taphonomyExperiments'] = array();

    foreach ($taphonomy_experiments as $exp) {
        $_SESSION['taphonomyExperiments'][] = new Taphonomy(
            $exp['experiment_id'], // Experiment ID
            $exp['taph_exp_name'], // Experiment Name
            $exp['user_id'], // User ID
            $exp['taph_exp_license'], // Experiment License
            $exp['taph_exp_location'], // Experiment Location
            $exp['taph_exp_surroundings'], // Experiment Surroundings
            array()
        );
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

    <div class="overviewTitle">
        <img class="overviewIcon" src="./assets/img/taphonomy.png" alt="Taphonomy">
        <h2>Taphonomy Experiments</h2>
    </div>
    
    <section class="categoryExperiments">

        <?php 
        foreach ($_SESSION['taphonomyExperiments'] as $exp) {
            printf(
                '<div class="overviewExperiment">
                <h3>%s</h3>
                <p class="expMeta"><strong>Location: </strong>%s</p>
                <p class="expMeta"><strong>Surroundings: </strong>%s</p>
                <p class="expMeta"><strong>License: </strong>%s</p>
                <button type="button" class="editBtn" data-category="taphonomy" data-experiment-id="%s">Edit</button>
                </div>',
                $exp->get_name(),
                $exp->get_location(),
                $exp->get_surroundings(),
                $exp->get_license(),
                $exp->get_id()
            );
        }
        ?>

        <div class="newExperiment">
            <button type="button" class="newBtn" data-category="taphonomy">New Experiment</button>
        </div>

    </section>

    <?php
    // Create an error section if errors exist
    if ( !empty( $errors ) ) {
        print('<section class="phpErrors">');

        foreach ( $errors as $error ) {
            printf(
                '<p class="errorMsg">%s</p>',
                $error
            );
        }

        print('</section>');
    }
    ?>

</main>

<?php
// Footer
require 'parts/footer.php';
?>