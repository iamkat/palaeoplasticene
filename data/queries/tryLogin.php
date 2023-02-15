<?php
header('Content-Type: text/plain; charset=utf-8');
session_start();
// -----------------------------------------------

// Prepare input variables
$userName = '';
$passWord = '';

// Prepare query variables
$accountData = '';
$errorMsg = '';

// Store form input values if validated
if (preg_match("/([a-zA-Z0-9]){3,}/", $_POST['ppcUsername']) == 1) {
   $userName = $_POST['ppcUsername'];
} else {
   $errorMsg = 'Usernames cannot be empty and have to be composed out of minimum 3 lower or upper case characters or numbers. Please try again.';
   exit($errorMsg);
}

if (preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]){8,}/", $_POST["ppcUserpass"]) == 1) {
   $passWord = $_POST['ppcUserpass'];
} else {
   $errorMsg = 'Passwords cannot be empty and have to be composed out of minimum 8 characters with at least one lower and one upper case character as well as one number. Please try again.';
   exit($errorMsg);
}

// Database interaction
try {
   // Database login
   require '../credentials.php';
   
   // Query
   $queryAccount = $dbConnection->prepare('SELECT ppc_user_pw FROM ppc_users WHERE ppc_username = :ppcUsername');
   $queryAccount->bindParam(':ppcUsername', $userName);
   $queryAccount->execute();
   $accountData = $queryAccount->fetch(PDO::FETCH_COLUMN);
   
   // Close connection to database
   $dbConnection = null;
}
catch (PDOException $error) {
   $errorMsg = $error->getMessage();
   exit($errorMsg);
}

// Check if username exists
if (empty($accountData)) {
   $errorMsg = 'Sorry, the username does not exist. Please contact us to register or for further help.';
} else if (!password_verify($passWord, $accountData)) {
   $errorMsg = 'Sorry, the password is incorrect. Try again or set a new password.';
} else {
   $_SESSION['user'] = $userName;
   $_SESSION['token'] = password_hash($userName, PASSWORD_DEFAULT);
}

// Output of response
print($errorMsg);
?>