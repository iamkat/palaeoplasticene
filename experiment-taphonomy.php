<?php
// Page header
require 'header.php';

// Login Check (with a custom function from infrastructure.php)
checkLogin();

// Array for errors
$errors = array();

$categorySlug = '';
$experimentData = [
    'ppc_exp_id' => '',
    'Name' => '',
    'Location' => '',
    'Surroundings' => '',
    'ppc_usr_id' => '',
    'License' => ''
];

// Checks
if ($_SESSION['experimentData']) {
    $experimentData = $_SESSION['experimentData'][0];
}

if ($_SESSION['experimentCategory']) {
    $categorySlug = $_SESSION['experimentCategory'];
}

// Get images view categories
include 'queries/getTaphonomyViews.php';

// Get images data
include 'queries/getTaphonomyImages.php';
?>

<main>
    <div class="experimentTitle">
        <img class="experimentIcon" src="./assets/img/taphonomy.png" alt="Taphonomy">
        <h2>Taphonomy Experiment</h2>
    </div>
    <section id="experimentData">
        <form id="dataForm">
            <fieldset class="dataFields">
            <?php 
            foreach ($experimentData as $key => $value) {
                if ($key == 'ppc_exp_id' || $key == 'ppc_usr_id') {
                    continue;
                } elseif ($key == 'License') {
                    ?>
                    <div class="dataInput">
                        <label for="experiment<?php print($key); ?>"><?php print($key); ?></label>
                        <select id="experiment<?php print($key); ?>" name="experiment<?php print($key); ?>">
                            <?php 
                            include './queries/getLicenses.php';

                            foreach ($_SESSION['licenses'] as $license) {
                                ?>
                                <option value="<?php print($license); ?>"<?php $value == $license ? print(' selected') : ''; ?>><?php print($license); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="dataInput">
                        <label for="experiment<?php print($key); ?>"><?php print($key); ?></label>
                        <input type="text" id="experiment<?php print($key); ?>" name="experiment<?php print($key); ?>" value="<?php print($value); ?>">
                    </div>
                <?php
                }
            }
            ?>
            </fieldset>
            <fieldset>
                <?php
                if ($_SESSION['taphonomyImages']) {
                    // Stats calculation
                    foreach ($_SESSION['taphonomyImages'] as $image) {
                        $imageDates[] = $image['Date'];    
                    }

                    // Date calculations
                    $startDate = date_create(min($imageDates));
                    $lastDate = date_create(max($imageDates));
                    $duration = date_diff($startDate, $lastDate, TRUE);

                    $stats['Days'] = $duration->days;
                    $stats['Images'] = sizeof($_SESSION['taphonomyImages']);

                    foreach ($stats as $name => $value) {
                        ?>
                        <p class="stats"><?php print($name); ?>: <?php print($value); ?></p>
                        <?php
                    }
                } 
                ?>
                
            </fieldset>
            <fieldset class="formControls">
                <button type="button" id="cancelExperiment" class="formBtn">Cancel</button>
                <button type="submit" id="saveExperiment" class="formBtn">Save</button>
            </fieldset>
        </form>
    </section>

    <section class="experimentResult">
        <div class="imageGallery">
            <div class="imageFilter">
                <label for="viewFilter">Filter by View</label>
                <select id="viewFilter" name="viewFilter">
                    <option value="All">All</option>
                    <?php 
                    foreach ($_SESSION['views'] as $value) {
                        ?>
                        <option value="<?php print($value); ?>"><?php print($value); ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php
                
                ?>
            </div>
            <?php 
            if ($_SESSION['taphonomyImages']) {
                // Image path
                $imagePath = './uploads/' . $_SESSION['user'] . '/' . $categorySlug . '/' . $_SESSION['experimentId'];

                foreach ($_SESSION['taphonomyImages'] as $image) {
                    ?>
                    <div class="experimentImage" data-view="<?php print($image['View']); ?>">
                        <label for="<?php print($image['ppc_img_id']); ?>"><img class="thumbnail" src="<?php print($imagePath); ?>/thumbs/<?php print($image['Filename']); ?>" alt="<?php print($image['Filename']); ?>" loading="lazy"></label>
                        <input type="checkbox" class="imageCheckbox" id="<?php print($image['ppc_img_id']); ?>" name="<?php print($image['ppc_img_id']); ?>" value="<?php print($image['Filename']); ?>">
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
</main>

<?php
// Page footer
require 'footer.php';
?>