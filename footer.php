<footer>
    <a class="ppcLink ppcFooterLink" href="./participate.php" target="_self" title="Participate with Palaeoplasticene Project">Participate</a>
    <a id="loginLink" class="ppcLink ppcFooterLink" href="./login.php" target="_self" title="Login">Login</a>
    <button id="logoutBtn" class="ppcFooterLink" type="button">Logout</button>

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
        case '/':
            ppcScript('index');
            break;
        case "/index.php":
            ppcScript("index");
            break;
        case "/login.php":
            ppcScript("login");
            break;
        case "/profile.php":
            ppcScript("profile");
            break;
        case "/overview.php":
            ppcScript("overview");
            break;
        case "/experiment-taphonomy.php":
            ppcScript("experimentTaphonomy");
            break;
    }
?>

<script src="./js/header.js" type="text/javascript"></script>
<script src="./js/mechanics.js" type="text/javascript"></script>

</footer>
</body>
</html>