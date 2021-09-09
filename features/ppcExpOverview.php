<?php
header('Content-Type: text/plain; charset=utf-8');

// FETCHING EXISTING USER'S EXPERIMENTS
try {
    // Database login
    require('../credentials.php');
    
    // Activate error messages
    $ppcDBLogin->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the statement
    $ppcUserExpStmt = $ppcDBLogin->prepare('SELECT * FROM ppc_experiments WHERE ppc_');
}
catch(PDOException $overviewPDOError) {
    echo('Error: ') . $overviewPDOError->getMessage();
}
catch(RuntimeException $overviewRuntimeError) {
    echo('Error: ') . $overviewRuntimeError->getMessage();
}
?>