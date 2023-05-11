<?php
// Page header
require 'parts/header.php';

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
if (!empty($_SESSION['experimentData'])) {
    $experimentData = $_SESSION['experimentData'][0];
}

if (!empty($_SESSION['experimentCategory'])) {
    $categorySlug = $_SESSION['experimentCategory'];
}

// Get images view categories
include 'data/queries/getTaphonomyViews.php';

// Get images data
include 'data/queries/getTaphonomyImages.php';

// Get Licenses
include 'data/queries/getLicenses.php';
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
                // The session cookie with the array of queried experiment images is set during the experiment query (getTaphonomyImages.php)
                if ($_SESSION['taphonomyImages']) {
                    // Preparation for date calculations
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
                <label for="fileUpload" class="formBtn">Upload Images</label>
                <input type="file" id="fileUpload" name="fileUpload[]" accept="image/jpeg, image/png" multiple form="uploadForm">
                <button type="button" id="cancelExperiment" class="formBtn cancelBtn">Cancel</button>
                <button type="submit" id="saveExperiment" class="formBtn saveBtn" form="dataForm">Save</button>
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
                    // The session cookie with the array of experiment views is set during the query for existing views (getTaphonomyViews.php)
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
            <form id="editForm" name="editForm" enctype="multipart/form-data">
                <fieldset class="imageData" form="editForm">
                    <div class="imageInput">
                        <label for="imageFile">
                            <figure class="imagePreview">
                                <img src="" id="editImage" alt=""></label>
                                <figcaption class="imageCaption"></figcaption> 
                            </figure>
                        <input type="file" id="imageFile" name="imageFile" class="formInput" data-input-name="Filename" form="editForm">
                    </div>
                </fieldset>
                <fieldset class="imageData" form="editForm">
                    <div class="imageInput">
                        <label for="imageView">View</label>
                        <select id="imageView" name="imageView" class="formInput" data-input-name="View" form="editForm" required>
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
                        <input type="datetime-local" id="imageDate" name="imageDate" class="formInput" data-input-name="Date" form="editForm" value="" required>
                    </div>
                    <div class="imageInput">
                        <label for="uploadDate">Upload date</label>
                        <input type="datetime-local" id="uploadDate" name="uploadDate" form="editForm" value="" readonly>
                    </div>
                </fieldset>
                <fieldset class="imageData" form="editForm">
                    <div class="imageInput">
                        <label for="imageConditions">Conditions</label>
                        <textarea id="imageConditions" name="imageConditions" class="formInput" data-input-name="Conditions" form="editForm" value=""></textarea>
                    </div>
                    <div class="imageInput">
                        <label for="imageNotes">Notes</label>
                        <textarea id="imageNotes" name="imageNotes" class="formInput" data-input-name="Notes" form="editForm" value=""></textarea>
                    </div>
                        
                    <input type="hidden" id="imageId" name="imageId" form="editForm" value="" readonly>
                </fieldset>
                <fieldset class="formControls" id="editControls" form="editForm">
                    <button type="button" id="deleteImage" class="formBtn" form="editForm">Delete</button>
                    <button type="button" id="cancelImage" class="formBtn cancelBtn" form="editForm">Cancel</button>
                    <button type="submit" id="saveImage" class="formBtn saveBtn" form="editForm">Save</button>
                </fieldset>
            </form>
        </section>
    </div>

    <div class="modal" id="uploadModal">
        <section id="uploadSection">
            <form id="uploadForm" name="uploadForm" enctype="multipart/form-data">
                <?php // one fieldset per image ?>
                <fieldset class="formControls" id="uploadControls" form="uploadForm">
                    <button type="button" id="cancelUpload" class="formBtn cancelBtn" form="uploadForm">Cancel</button>
                    <button type="submit" id="uploadImages" class="formBtn saveBtn" form="uploadForm">Upload</button>
                </fieldset>
            </form>
        </section>
    </div>

</main>

<?php
// Page footer
require 'parts/footer.php';
?>