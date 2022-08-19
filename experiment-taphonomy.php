<?php
// Page header
require 'header.php';

// Login Check (with a custom function)
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

// Check
if ($_SESSION['experimentData']) {
    $experimentData = $_SESSION['experimentData'][0];
}

if ($_SESSION['experimentCategory']) {
    $categorySlug = $_SESSION['experimentCategory'];
}

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
                <?php // TODO: Fetch images at the beginning to calculate experiment stats and display image gallery further down?>
            </fieldset>
            <fieldset class="formControls">
                <button type="button" id="cancelExperiment" class="formBtn">Cancel</button>
                <button type="submit" id="saveExperiment" class="formBtn">Save</button>
            </fieldset>
        </form>
    </section>
    <section class="experimentResult">
            <?php // TODO: Image gallery ?>
    </section>
</main>

<?php
// Page footer
require 'footer.php';
?>