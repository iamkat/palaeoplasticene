<?php
header('Content-Type: text/plain; charset=utf-8');
session_start();
// -----------------------------------------------

// PREPARE INPUT VARIABLES
$userName = '';
$passWord = '';

// PREPARE QUERY VARIABLE
$accountData = array();

// PREPARE RESPONSE ARRAY
$loginResponse = array(
   "error" => "",
   "user" => "",
   "sessionID" => "",
   "loginToken" => "",
   "sessionToken" => ""
);

// SET FORM VARIABLES IF VALIDATED
if (preg_match("/([a-zA-Z0-9]){3,}/", $_POST['ppcUsername']) == 1) {
   $userName = $_POST['ppcUsername'];
} else {
   $loginResponse['error'] = 'Usernames cannot be empty and have to be composed out of minimum 3 lower or upper case characters or numbers. Please try again.';
   exit(json_encode($loginResponse));
}

if (preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]){8,}/", $_POST["ppcUserpass"])) {
   $passWord = $_POST['ppcUserpass'];
} else {
   $loginResponse['error'] = 'Passwords cannot be empty and have to be composed out of minimum 8 characters with at least one lower and one upper case character as well as one number. Please try again.';
   exit(json_encode($loginResponse));
}

// Database interaction
try {
   // Database login
   require 'credentials.php';
   
   // Query
   $queryAccount = $dbConnection->prepare('SELECT ppc_user_pw FROM ppc_users WHERE ppc_username = :ppcUsername');
   $queryAccount->bindParam(':ppcUsername', $userName);
   $queryAccount->execute();
   $accountData = $queryAccount->fetch(PDO::FETCH_COLUMN);
   
   // Close connection to database
   $dbConnection = null;
}
catch (PDOException $error) {
   $loginResponse['error'] = $error->getMessage();
   exit(json_encode($loginResponse));
}

// Check if username exists
if (empty($accountData)) {
   $loginResponse['error'] = 'Sorry, the username does not exist. Please contact us to register or for further help.';
} else if (!password_verify($passWord, $accountData)) {
   $loginResponse['error'] = 'Sorry, the password is incorrect. Try again or set a new password.';
} else {
   $loginResponse['user'] = $userName;
   $loginResponse['sessionID'] = session_id();
   
   // Store generated login and session token to the response
   $loginResponse['loginToken'] = password_hash($userName, PASSWORD_DEFAULT);
   $loginResponse["sessionToken"] = password_hash(session_id(), PASSWORD_DEFAULT);
}

// Output of JSON encoded Response
print(json_encode($loginResponse));
?>