<?php
// Page Header
require 'header.php';
?>

<main>
    <h2>User login</h2>
    
    <form id="loginForm" name="loginForm">
        <fieldset>
            <label for="ppcUsername">Username</label>
            <input type="text" id="ppcUsername" class="loginInput" name="ppcUsername" minlength="3" maxlength="32" size="10" required pattern="[a-zA-Z0-9].{3,32}" />
                
            <label for="ppcUserpass">Password</label>
            <input type="password" id="ppcUserpass" class="loginInput" name="ppcUserpass" minlength="8" maxlength="32" size="10" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" title="The password must contain at least one lowercase letter, one uppercase letter, one number and one punctuation mark, and at least 8 or up to 32 characters." />
        </fieldset>
        
        <fieldset class="formControls">
            <button type="button" id="loginSubmit" class="formBtn">Login</button>
        </fieldset>
    </form>
    
</main>

<?php
// Page Footer
require 'footer.php';
?>