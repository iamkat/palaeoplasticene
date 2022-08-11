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
        return await request.json();
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

// Function to store security values in the session storage
function setSecurityValues(name, value) {
    sessionStorage.setItem(name, value);
}

// -----------------------------------------------------------------
// EVENT LISTENERS

if (loginSubmit && userName && passWord) {
    loginSubmit.addEventListener('click', async function() {
        // Validate Inputs
        let usernameValidation = validateInput(userName, errorUser);
        let passwordValidation = validateInput(passWord, errorPassword);

        if (usernameValidation !== true) {
            console.log(usernameValidation);
        } else if (passwordValidation !== true) {
            console.log(passwordValidation);
        } else {
            const response = await ppcLogin(loginForm);

            if (response.error !== '') {
                console.log(response.error);
            } else {
                // Remove error value from array
                delete response.error;
                
                for (var key in response) {
                    setSecurityValues(key, response[key]);
                }

                // Redirect to overview page
                window.location.href = './overview.php';
            }
        }
    }, false);
}