<?php
// Page Header
require('header.php');
?>

<!-- Script Tag for Login Check -->
<script>
    <?php
    // Check for logged in user
    require('./js/ppcLoginCheck.js');
    ?>
</script>

<!-- Page Content -->
<main class="ppcMain">
    <article class="ppcContent">
        <h2>Experiment Overview</h2>
        <section id="ppcExpListWrap">
            <ul>
                <li>
                    Experiment data (duration, location, surroundings)
                    <button type="button" class="ppcControl">Edit</button>
                    <button type="button" class="ppcControl">Delete</button>
                </li>
                <li>
                    Experiment data (duration, location, surroundings)
                    <button type="button" class="ppcControl">Edit</button>
                    <button type="button" class="ppcControl">Delete</button>
                </li>
                <li>
                    Experiment data (duration, location, surroundings)
                    <button type="button" class="ppcControl">Edit</button>
                    <button type="button" class="ppcControl">Delete</button>
                </li>
                <li>
                    Experiment data (duration, location, surroundings)
                    <button type="button" class="ppcControl">Edit</button>
                    <button type="button" class="ppcControl">Delete</button>
                </li>
                <li>
                    Experiment data (duration, location, surroundings)
                    <button type="button" class="ppcControl">Edit</button>
                    <button type="button" class="ppcControl">Delete</button>
                </li>
            </ul>
        </section>
    </article>
    <article class="ppcContent">
        <button type="button" class="ppcControl" id="ppcNewExpBtn">New experiment</button>
    </article>
</main>

<?php
// Footer
require('footer.php');
?>