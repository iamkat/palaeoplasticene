<footer id="ppcFooter">
    <a id="ppcLoginLink" class="ppcLink" href="./login.php" target="_self" title="Login">Login</a>
    <button id="ppcLogoutBtn" type="button">Logout</button>
<!-- Script Area -->
<script>
<?php
// Logout Button Script
require('./js/ppcLogoutBtn.js');
// Script for Experiment Create Site
if($_SERVER['REQUEST_URI'] == '/experiment.php') {
    require('./js/ppcExp.js');
}
?>
</script>
<!-- General JS file -->
<script src="./js/mechanics.js" type="text/javascript"></script>

</footer>
</body>
</html>