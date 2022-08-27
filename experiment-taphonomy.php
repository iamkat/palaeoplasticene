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

// Get Licenses
include './queries/getLicenses.php';
?>

<main>

    <div class="experimentTitle">
        <img class="experimentIcon" src="./assets/img/taphonomy.png" alt="Taphonomy">
        <h2>Taphonomy Experiment</h2>
    </div>

    <section id="experimentData">

        <form id="dataForm" name="dataForm">

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

            <fieldset class="dataStats">
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

            <fieldset class="formControls" id="experimentControls">
                <button type="button" id="addImage" class="formBtn">Upload Images</button>
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
            </div>

            <div class="images"></div>

        </div>
    </section>

    <div class="modal" id="editModal">
        <section id="editSection">
            <form id="editForm" name="editForm">
                <fieldset class="imageData">
                    <div class="imageInput">
                        <label for="imageFile">
                            <figure class="imagePreview">
                                <img src="" id="editImage" alt=""></label>
                                <figcaption class="imageCaption"></figcaption> 
                            </figure>
                        <input type="file" id="imageFile" name="imageFile" form="editForm">
                    </div>
                </fieldset>
                <fieldset class="imageData">
                    <div class="imageInput">
                        <label for="imageView">View</label>
                        <select id="imageView" name="imageView" form="editForm" required>
                            <?php 
                            foreach ($_SESSION['views'] as $value) {
                                ?>
                                <option class="editViews" value="<?php print($value); ?>"><?php print($value); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="imageInput">
                        <label for="imageDate">Date</label>
                        <input type="datetime-local" id="imageDate" name="imageDate" form="editForm" value="" required>
                    </div>
                    <div class="imageInput">
                        <label for="uploadDate">Upload date</label>
                        <input type="datetime-local" id="uploadDate" name="uploadDate" form="editForm" value="" readonly>
                    </div>
                </fieldset>
                <fieldset class="imageData">
                    <div class="imageInput">
                        <label for="imageConditions">Conditions</label>
                        <textarea id="imageConditions" name="imageConditions" form="editForm"></textarea>
                    </div>
                    <div class="imageInput">
                        <label for="imageNotes">Notes</label>
                        <textarea id="imageNotes" name="imageNotes" form="editForm"></textarea>
                    </div>
                        
                    <input type="hidden" id="imageId" name="imageId" form="editForm" value="" readonly>
                </fieldset>
                <fieldset class="formControls" id="editControls">
                    <button type="button" id="cancelImage" class="formBtn">Cancel</button>
                    <button type="submit" id="saveImage" class="formBtn">Save</button>
                </fieldset>
            </form>
        </section>
    </div>

    <form id="uploadForm" name="uploadForm">
        <div class="uploads"></div>
        <?php // one fieldset per image ?>
        <fieldset class="formControls" id="uploadControls"></fieldset>
    </form>

</main>

<?php
// Page footer
require 'footer.php';
?>