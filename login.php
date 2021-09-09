<?php
// Header
require('header.php');
?>
<main class="ppcMain">
    <article id="ppcLoginWrap" class="ppcContent">
        <h2>User login</h2>
        <form id="ppcLoginForm" name="ppcLoginForm">
            <section class="ppcLoginFormPart">
                <label for="ppcUsername">username</label>
                <input type="text" id="ppcUsername" class="ppcLoginInput" name="ppcUsername" minlength="1" maxlength="32" size="10" />
                <label for="ppcUserpass">password</label>
                <input type="password" id="ppcUserpass" class="ppcLoginInput" name="ppcUserpass" minlength="8" maxlength="32" size="10" />
            </section>
            <section class="ppcLoginFormPart">
                <button type="button" id="ppcLoginSubmit" class="ppcControl">Login</button>
            </section>
        </form>
    </article>
</main>
<?php require('footer.php'); ?>