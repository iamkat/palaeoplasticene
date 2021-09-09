// INFRASTRUCTURE SETUP

// Getting the form
const ppcCreateForm = document.getElementById('ppcExpForm');
// Getting the form inputs for the Experiment Data
const ppcExpCat = document.getElementById('ppcExpCat');
const ppcExpUser = document.getElementById('ppcExpUser');
const ppcExpName = document.getElementById('ppcExpName');
const ppcExpLoc = document.getElementById('ppcExpLoc');
const ppcExpSurr = document.getElementById('ppcExpSurr');
// Setting the value for the hidden User input from the Username in the session storage
ppcExpUser.value = sessionStorage.getItem('ppcUser');
// Getting the file inputs for all images
const ppcExpImg = document.getElementsByClassName('ppcExpImg');
// Getting the form inputs for the Experiment Images
const ppcImgDatePicker = document.getElementById('ppcImgDate');
const ppcImgCond = document.getElementById('ppcImgCond');
// Limiting the datepicker for the image date to today
ppcImgDatePicker.max = new Date().toISOString().split("T")[0];
// Get the Form Submit Button
const ppcExpSubmitBtn = document.getElementById('ppcExpSubmit');

// -----------------------------------------------------------------

// Fill the Experiment Category according to Experiment Choice
// Get Experiment Category input value

// Function to set the input value
function expCatInput() {
    switch (expChoice) {
        case 'ppcTaphonomy':
            ppcExpCat.value = 'Taphonomy';
            break;
        case 'ppcCrystals':
            ppcExpCat.value = 'Crystals';
            break;
    }
}
// Event listener to load at the end
if(ppcExpCat) {
    document.addEventListener('DOMContentLoaded', expCatInput, false);
}

// -----------------------------------------------------------------

// FUNCTION TO CREATE A NEW EXPERIMENT

// Submitting the form
ppcExpForm.onsubmit = async (e) => {
    // Prevent usual behaviour for clicking on the submit button
    e.preventDefault();

    let response = await fetch('./features/ppcExp.php', {
        method: 'POST',
        body: new FormData(ppcExpForm)
    });

    let result = await response.text();

    alert(result);
    window.location.href = './experiment-overview.php';
}

/* OLD CODE
// Getting the form data and files
let ppcExpFormData = new FormData(ppcCreateForm);
// Appending the files to the form
// ppcExpFormData.append();

async function ppcExpCreate() {
    // Feedback mechanism
    if(!ppcInputFeedback(ppcExpName)) {
        console.log('Please enter a name for the experiment.');
    } else if(!ppcInputFeedback(ppcExpLoc)) {
        console.log('Please enter a location for the experiment.');
    } else if(!ppcInputFeedback(ppcExpSurr)) {
        console.log('Please enter a description of the experiment surroundings.');
    } else {
        Create a new XMLHttpRequest Object for communication with the database
        const ppcExpCreateConnect = new XMLHttpRequest();
        // Callback function for the login
        ppcExpCreateConnect.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                window.location.href = './experiment-overview.php';
            }
        }
        // Sending the Request
        ppcExpCreateConnect.open('POST', './features/ppcExpCreate.php', true);
        ppcExpCreateConnect.send(ppcExpFormData);

        // The request to send the form data to the server
        const ppcResponse = await fetch('./features/ppcExpCreate.php', {
            method: 'POST',
            cache: 'no-cache',
            referrerPolicy: 'no-referrer',
            body: ppcExpFormData
        })
        // Deal with the response
        if (ppcResponse.ok) {
            let ppcResponseMessage = await ppcResponse.text();
            alert(ppcResponseMessage);
        } else {
            alert('HTTP-Error: ' + ppcResponse.status);
        }
    }


};

// Event Listener for Submit Button of the Experiment form
if(ppcExpSubmitBtn) {
    ppcExpSubmitBtn.addEventListener('click', ppcExpCreate, false);
}*/

// -----------------------------------------------------------------