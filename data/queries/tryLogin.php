<?php
use Palaeoplasticene\User;

// Autoload classes
spl_autoload_register(function ($class_name) {
   $classPath = str_replace('\\', '/', $class_name);
   $file = '../../classes/' . $classPath . '.php';
   if (file_exists($file)) {
      include $file;
   }
});

session_start();
// -----------------------------------------------

// Prepare input variables
$userName = '';
$passWord = '';

// Prepare query variables
$accountData = '';
$errorMsg = '';

// Store form input values if validated
if (preg_match("/(\w){3,}/", $_POST['ppcUsername']) == 1) {
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
   
   // SQL statement
   $sql = "SELECT * FROM ppc_users WHERE user_name = :ppcUsername";

   // Query
   $queryAccount = $dbConnection->prepare($sql);
   $queryAccount->bindParam(':ppcUsername', $userName);
   $queryAccount->execute();
   $accountData = $queryAccount->fetch(PDO::FETCH_ASSOC);
   
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
} else if (!password_verify($passWord, $accountData['user_pw'])) {
   $errorMsg = 'Sorry, the password is incorrect. Try again or set a new password.';
} else {
   $_SESSION['user'] = new User(
      $accountData['user_id'],
      $accountData['user_pw'],
      $accountData['user_fname'],
      $accountData['user_sname'],
      $accountData['user_name'],
      $accountData['user_email'],
      $accountData['created'],
      $accountData['last_modified'],
      password_hash($accountData['user_name'], PASSWORD_DEFAULT)
   );
}

// Output of response
print($errorMsg);
?>