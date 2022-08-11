<?php
// Page Header
require('header.php');
?>

<!-- Script for Login Check -->
<script>
    <?php
    // Check for logged in user
    // require('./js/ppcLoginCheck.js');
    ?>
</script>

<!-- Page Content -->
<main class="ppcMain">
    <h2 class="ppcHeading">Overview</h2>
    <div class="ppcOverviewSectionWrapper">
        <div class="ppcOverviewSectionTitle">
            <img class="ppcExpIcon" src="./assets/img/ppcTaphonomy.jpg" alt="Taphonomy" />
            <h3 class="ppcHeading">Taphonomy Experiments</h3>
        </div>
        <section class="ppcContent">
            <ul id="ppcTaphExpList">
            </ul>
        </section>
    </div>
</main>

<?php
// Footer
require('footer.php');
?>