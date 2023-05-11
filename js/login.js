'use-strict'

// -----------------------------------------------------------------
// VARIABLES AND CONSTANTS

// Login form
const loginForm = document.getElementById('loginForm');
// Login form inputs
const userName = document.getElementById('ppcUsername');
const passWord = document.getElementById('ppcUserpass');
// Submit Button
const loginSubmit = document.getElementById('loginSubmit');
// Login error message area
const loginError = document.getElementById('loginError');
// Error message for username input
const errorUser = "Usernames cannot be empty and have to be composed out of minimum 3 lower or upper case characters or numbers. Please try again.\n";
// Error message for password input
const errorPassword = "Passwords cannot be empty and have to be composed out of minimum 8 characters with at least one lower and one upper case character as well as one number. Please try again.\n";

// -----------------------------------------------------------------
// FUNCTIONS

// Login Function
async function ppcLogin(formData) {
    try {
        const request = await fetch('./data/queries/tryLogin.php', {
            method: 'POST',
            body: new FormData(formData),
        });
        return await request.text();
    } catch (error) {
        console.log(error);
    }

}

function validateInput(input) {
    if (!input.checkValidity()) {
        loginError.innerHTML = input.validationMessage;
        return false;
    } else {
        loginError.innerHTML = '';
        return true;
    }
}

// -----------------------------------------------------------------
// EVENT LISTENERS

// Create user input feedback
if (userName && passWord) {
    userName.addEventListener('keyup', function(event) {
        if (validateInput(event.target) && validateInput(passWord)) {
            loginSubmit.disabled = false;
        };
    }, false);

    passWord.addEventListener('keyup', function(event) {
        validateInput(event.target);

        if (validateInput(event.target) && validateInput(userName)) {
            loginSubmit.disabled = false;
        };
    }, false);
}

// Submit button functionality
if (loginSubmit && userName && passWord) {
    loginSubmit.addEventListener('click', async function(event) {

        // Again validation checks
        if (!userName.checkValidity()) {
            return loginError.innerHTML = userName.validationMessage;
        } else if (!passWord.checkValidity()) {
            return loginError.innerHTML = passWord.validationMessage;
        } else {
            event.preventDefault();
            const response = await ppcLogin(loginForm);

            if (response !== '') {
                loginError.innerHTML = response;
            } else {
                // Redirect to overview page
                window.location.href = './overview';
            }
        }
    }, false);
}