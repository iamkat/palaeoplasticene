<?php
header('Content-Type: text/plain; charset=utf-8');
// -----------------------------------------------
// INFRASTRUCTURE

// SETTING UP THE VARIABLES FOR THE INPUT VALUES
// Getting the input values from the POST method
$expCat = $_POST['ppcExpCat'];
$expUser = $_POST['ppcExpUser'];
$expName = $_POST['ppcExpName'];
$expLoc = $_POST['ppcExpLoc'];
$expSurr = $_POST['ppcExpSurr'];

// STILL TO DO: Validating and sanitizing the inputs on the server site
// Checking the Experiment Category
if(($expCat !== 'Taphonomy') && ($expCat !== 'Crystals') ) {
    die('Sorry, something went terribly wrong. Please contact us for help.');
}

// Getting the Experiment Images
$expImg = $_FILES['ppcExpImg0001'];
$expImgDate = $_POST['ppcImgDate'];
$expImgCond = $_POST['ppcImgCond'];
$expImgView = $_POST['ppcExpImgView'];

// Checking the Experiment Image inputs

// Array with feedback messages
$ppcExpMessages = array();

// -----------------------------------------------
// FORM HANDLING

// INTERACTION WITH THE DATABASE AND THE SERVER FOR FILE UPLOAD
try {
    // Database login
    require('../credentials.php');
    
    // Activate error messages
    $ppcDBLogin->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // STATEMENT TO FETCH THE CORRECT USER ID FROM THE USERNAME IN THE SESSION STORAGE
    // Prepare and execute statement for fetching the User ID
    $ppcExpUserStmt = $ppcDBLogin->prepare('SELECT ppc_user_id FROM ppc_users WHERE ppc_username = :ppcUsername');
    $ppcExpUserStmt->bindParam(':ppcUsername', $expUser);
    $ppcExpUserStmt->execute();
    // Fetching the query result
    $ppcExpUserData = $ppcExpUserStmt->fetch(PDO::FETCH_NUM);
    // Get the User ID
    $ppcExpUserID = $ppcExpUserData[0];

    // STATEMENT TO INSERT THE EXPERIMENT DATA INTO THE DATABASE
    // Checking if experiment name already exists
    // Preparing and executing the query
    $ppcCheckExpStmt = $ppcDBLogin->prepare('SELECT * FROM ppc_experiments WHERE ppc_exp_name = :ppcExpname');
    $ppcCheckExpStmt->bindParam(':ppcExpname', $expName);
    $ppcCheckExpStmt->execute();
    // Fetching the query result
    $ppcCheckExp = $ppcCheckExpStmt->fetchAll();
    // If the experiment does not exist create a new entry otherwise continue with the file upload
    if(empty($ppcCheckExpStmt)) {
        // Prepare and execute statement for inserting the Experiment Data
        $ppcExperimentStmt = $ppcDBLogin->prepare('INSERT INTO ppc_experiments (ppc_exp_cat, ppc_exp_name, ppc_exp_loc, ppc_exp_surr, ppc_usr_id) VALUES (:ppc_exp_cat, :ppc_exp_name, :ppc_exp_loc, :ppc_exp_surr, :ppc_usr_id)');
        $ppcExperimentStmt->bindParam(':ppc_exp_cat', $expCat);
        $ppcExperimentStmt->bindParam(':ppc_exp_name', $expName);
        $ppcExperimentStmt->bindParam(':ppc_exp_loc', $expLoc);
        $ppcExperimentStmt->bindParam(':ppc_exp_surr', $expSurr);
        $ppcExperimentStmt->bindParam(':ppc_usr_id', $ppcExpUserID);
        $ppcExperimentStmt->execute();
        $ppcExpMessages[] = 'New experiment data has been saved. ';
        }

    // Check the MIME Type of the file
    $ppcFileInfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ppcFileExt = array_search(
        $ppcFileInfo->file($expImg['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
            ),
            true
        )) {
            throw new RuntimeException('Invalid file format.');
        }

    // STATEMENT TO GET THE INFO NEEDED TO GENERATE THE FILE NAME
    // Query to fetch the necessary parts to rename the upload file
    $ppcExpDataStmt = $ppcDBLogin->prepare('SELECT ppc_usr_id, ppc_exp_cat, ppc_exp_id FROM ppc_experiments WHERE ppc_exp_name = :ppcExpname');
    $ppcExpDataStmt->bindParam(':ppcExpname', $expName);
    // Execute prepared statement
    $ppcExpDataStmt->execute();
    // Queried data to array
    $ppcFileNameData = $ppcExpDataStmt->fetch(PDO::FETCH_NUM);
    // Extract current Experiment ID
    $ppcExpID = $ppcFileNameData[2];
    // Create the file name according to the pattern: UserID_ExpCat_ExpID_Viewpoint####
    $ppcExpUplFileName = sprintf('%u_%s_%u_%s%u', $ppcFileNameData[0], $ppcFileNameData[1], $ppcExpID, $expImgView, 1);
    
    // CHECK THE UPLOAD PATH AND CREATE SPECIFIC FOLDER IF NOT EXIST
    // Create a variable with the desired upload path
    $ppcExpUplDir = sprintf('../uploads/%s/%s/%s', $expUser, $expCat, $ppcFileNameData[2]);
    // Create the path if not existing
    if(!file_exists($ppcExpUplDir)) {
        mkdir($ppcExpUplDir, 0777, true);
    }

    // DEALING WITH THE IMAGE FILE
    // Check if there is an image input
    if($expImg) {
        // Create the image path and file name
        $expImgFile = sprintf('%s.%s', $ppcExpUplFileName, $ppcFileExt);
        // Check if file already exists
        if(file_exists(sprintf('%s/%s', $ppcExpUplDir, $expImgFile))) {
            // Append the input date to the filename
            $expImgFile = sprintf('%s_%s.%s', $ppcExpUplFileName, $expImgDate, $ppcFileExt);
        }
        // Final file name and path
        $expImgFilePath = sprintf('%s/%s', $ppcExpUplDir, $expImgFile);
        // Renaming and moving the file with fallback
        if(!move_uploaded_file(
            $expImg['tmp_name'], $expImgFilePath
        )) {
            throw new RuntimeException('Failed to upload the file. Please try again or contact us.');
        }
    }

    // STATEMENT TO INSERT IMAGE FILE INFO INTO THE DATABASE
    // Prepare the statement
    $ppcExpImgStmt = $ppcDBLogin->prepare('INSERT INTO ppc_images (ppc_img_file, ppc_img_date, ppc_img_cond, ppc_img_view, ppc_exp_id, ppc_usr_id, ppc_img_upldate) VALUES (:ppc_imgFile, :ppc_imgDate, :ppc_imgCond, :ppc_imgView, :ppc_expID, :ppc_usrID, :ppc_imgUpldate)');
    $ppcExpImgStmt->bindParam(':ppc_imgFile', $expImgFile);
    $ppcExpImgStmt->bindParam(':ppc_imgDate', $expImgDate);
    $ppcExpImgStmt->bindParam(':ppc_imgCond', $expImgCond);
    $ppcExpImgStmt->bindParam(':ppc_imgView', $expImgView);
    $ppcExpImgStmt->bindParam(':ppc_expID', $ppcExpID);
    $ppcExpImgStmt->bindParam(':ppc_usrID', $ppcExpUserID);
    $ppcExpImgStmt->bindParam(':ppc_imgUpldate', date("Y-m-d H:i:s"));
    // Execute prepared statement
    $ppcExpImgStmt->execute();
    $ppcExpMessages[] = 'Image data has been saved. ';
    
    // Close connection to database
    $ppcDBLogin = null;
    // die($ppcExpMessages[0]);
    $ppcExpMessages[] = 'Data and file upload successful.';
    die($ppcExpMessages[0] . $ppcExpMessages[1] . $ppcExpMessages[2] . $ppcExpMessages[3]);
}
catch(PDOException $expPDOError) {
    echo('Error: ') . $expPDOError->getMessage();
}
catch(RuntimeException $expRuntimeError) {
    echo('Error: ') . $expRuntimeError->getMessage();
}
?>