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
const errorUser = 'Usernames cannot be empty and have to be composed out of minimum 3 lower or upper case characters or numbers. Please try again.';
// Error message for password input
const errorPassword = 'Passwords cannot be empty and have to be composed out of minimum 8 characters with at least one lower and one upper case character as well as one number. Please try again.';

// -----------------------------------------------------------------
// FUNCTIONS

// Login Function
async function ppcLogin(formData) {
    try {
        const request = await fetch('./queries/tryLogin.php', {
            method: 'POST',
            body: new FormData(formData),
        });
        return await request.text();
    } catch (error) {
        console.log(error);
    }

}

// Function for input validation
function validateInput(input, message) {
    if (input.value === '' || !input.checkValidity() || input.validity.patternMismatch) {
        input.setCustomValidity(message);
        return input.validationMessage;
    } else {
        return true;
    }
}

// -----------------------------------------------------------------
// EVENT LISTENERS

if (loginSubmit && userName && passWord) {
    loginSubmit.addEventListener('click', async function() {

        // Validate Inputs
        let usernameValidation = validateInput(userName, errorUser);
        let passwordValidation = validateInput(passWord, errorPassword);

        // Validatoin checks
        if (usernameValidation !== true) {
            loginError.innerHTML = usernameValidation;
        } else if (passwordValidation !== true) {
            loginError.innerHTML = passwordValidation;
        } else {
            const response = await ppcLogin(loginForm);

            if (response !== '') {
                loginError.innerHTML = response;
            } else {
                // Redirect to overview page
                window.location.href = './overview.php';
            }
        }
    }, false);
}