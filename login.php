<?php
// Page Header
require 'header.php';
?>

<main>
    <section id="loginSection">
        <h2>User login</h2>

        <form id="loginForm" name="loginForm">
            <fieldset id="loginInputs">
                <label for="ppcUsername">Username</label>
                <input type="text" id="ppcUsername" class="loginInput" name="ppcUsername" minlength="3" maxlength="32" size="10" required pattern="\w{3,32}" title="Usernames cannot be empty and have to be composed out of minimum 3 lower or upper case characters or numbers. Please try again." />

                <label for="ppcUserpass">Password</label>
                <input type="password" id="ppcUserpass" class="loginInput" name="ppcUserpass" minlength="8" maxlength="32" size="10" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" title="The password must contain at least one lowercase letter, one uppercase letter, one number and one punctuation mark, and at least 8 or up to 32 characters." />
            </fieldset>

            <fieldset class="formControls">
                <button type="submit" id="loginSubmit" class="formBtn" disabled>Login</button>
            </fieldset>
        </form>

        <p id="loginError"></p>
    </section>
</main>

<?php
// Page Footer
require 'footer.php';
?>