<footer>

    <?php 
    if ($_SESSION['authentication'] == true) {
        ?>
        <button id="logoutBtn" type="button" title="Logout">Logout</button>
        <?php 
    } else {
        ?>
        <a id="loginLink" href="./login.php" target="_self" title="Login">Login</a>
        <?php
    }
    ?>

<?php 
// SCRIPT AREA with the core functionalities (own small library) for other scripts to use, a switch to load page specific funtionalities according to the current page and basic page/template scripts (e. g. header functionalities)
?>

<script src="./js/create.js" type="text/javascript"></script>

<?php
    // Scripts for different sites
    function ppcScript($scriptName) {
      printf('<script src="./js/%s.js" type="text/javascript"></script>', $scriptName);
    }

    switch ($_SERVER["REQUEST_URI"]) {
        case '/';
        case '/index.php';
            ppcScript('index');
            break;
        case '/login.php':
            ppcScript('login');
            break;
        case '/denied.php':
            ppcScript('denied');
            break;
        case '/profile.php':
            ppcScript('profile');
            break;
        case '/overview.php':
            ppcScript('overview');
            break;
        case '/taphonomy.php';
        case '/crystals.php';
        case '/sounds.php';
        case '/incidentaltaphonomy.php';
        case '/fiction.php';
            ppcScript('parsedown');
            break;
        case '/experiment-taphonomy.php':
            ppcScript('experiment');
            break;
    }
?>

<script src="./js/header.js" type="text/javascript"></script>
<script src="./js/footer.js" type="text/javascript"></script>

</footer>
</body>
</html>