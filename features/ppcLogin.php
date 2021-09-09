<?php 
try {
   // Database login
   require('../credentials.php');
   // Activate error messages
   $ppcDBLogin->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // Prepare DB statement
   $ppcAccountStmt = $ppcDBLogin->prepare("SELECT ppc_user_pw FROM ppc_users WHERE ppc_username = :ppcUsername");
   $ppcAccountStmt->bindParam(':ppcUsername', $_POST['ppcUsername']);
   // Execute prepared statement
   $ppcAccountStmt->execute();
   // Queried data to array
   $ppcAccountData = $ppcAccountStmt->fetch(PDO::FETCH_NUM);
   // Close connection to database
   $ppcDBLogin = null;
}
catch(PDOException $error) {
   echo('Error: ') . $error->getMessage();
}

// Check if username exists
if(empty($ppcAccountData)) {
   die('Sorry, the username does not exist. Please try logging in again or contact us to register.');
} else if($_POST['ppcUserpass'] !== $ppcAccountData[0]) {
   die('Sorry, the password is incorrect. Please try logging in again or contact us to register.');
} else {
   die(json_encode(1));
}
?>