<footer>

    <?php 
    if ($_SESSION['authentication'] == true) {
        ?>
        <button id="logoutBtn" type="button" title="Logout">Logout</button>
        <?php 
    } else if (basename($_SERVER['REQUEST_URI']) !== 'login') {
        ?>
        <a id="loginLink" href="./login" target="_self" title="Login">Login</a>
        <?php
    }
    ?>

<?php 
// SCRIPT AREA with the core functionalities (own small library) for other scripts to use, a switch to load page specific funtionalities according to the current page and basic page/template scripts (e. g. header functionalities)
?>

<script src="./js/create.js" type="text/javascript"></script>
<script src="./js/header.js" type="text/javascript"></script>
<script src="./js/footer.js" type="text/javascript"></script>

<?php
    switch ($_SERVER["REQUEST_URI"]) {
        case '/':
        case '/index':
            ppcScript('index');
            break;
        case '/login':
            ppcScript('login');
            break;
        case '/denied':
            ppcScript('denied');
            break;
        case '/profile':
            ppcScript('profile');
            break;
        case '/overview':
            ppcScript('overview');
            break;
        case '/taphonomy':
        case '/crystals':
        case '/sounds':
        case '/incidentaltaphonomy':
        case '/fiction':
            ppcScript('parsedown');
            break;
        case '/experiment-taphonomy':
            ppcScript('taphonomy');
            break;
    }
?>

</footer>
</body>
</html>