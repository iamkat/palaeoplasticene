// CONSTANTS
// Array with pages numbered from 0 to n
const ppcPageOrder = ['/index.php', '/experiment-setup.php', '/experiment-overview.php', '/experiment.php', '/experiment-upload.php', '/experiment-participate.php'];
// Choice links from homepage
const taphonomyLink = document.getElementById('ppcTaphonomy');
const crystalsLink = document.getElementById('ppcCrystals');
// Experiment Choice
const expChoice = sessionStorage.getItem('ppcExpChoice');
// Home Link
const ppcHomeLink = document.getElementById('ppcHomeLink');
// Previous and Next Button
const ppcPreviousBtn = document.getElementById('ppcPrevious');
const ppcNextBtn = document.getElementById('ppcNext');
// Login Button
const ppcLoginSubmitBtn = document.getElementById('ppcLoginSubmit');
// Logout button
const logoutBtn = document.getElementById('ppcLogoutBtn');
// Participate Button
const ppcParticipateBtn = document.getElementById('ppcParticipateBtn');
// New Experiment Button
const ppcNewExpBtn = document.getElementById('ppcNewExpBtn');

// -----------------------------------------------------------------

// VARIABLES
// Variable for the current page's filename (with trailing slash first)
let ppcCurrentPage = window.location.pathname;
// Variable to get the current page's number
let ppcPageNumber = ppcPageOrder.indexOf(ppcCurrentPage);

// -----------------------------------------------------------------

// WEBSITE'S PAGE ORDER AND COUNTER
// Treat domain as index page
if(ppcCurrentPage == '/') {
    ppcCurrentPage = '/index.php';
}
// Function to store the page number
function pageNumber () {
    sessionStorage.setItem('ppcPage', ppcPageNumber);
}
// Invoke the function
document.addEventListener('DOMContentLoaded', pageNumber, false);

// -----------------------------------------------------------------

// FUNCTION TO STORE TAPHONOMY OR CRYSTALS CHOICE
function ppcExpChoice() {
    let choiceLinkId = this.getAttribute('id');
    sessionStorage.setItem('ppcExpChoice', choiceLinkId);
}

// Event listeners for choice links
if(taphonomyLink) {
    taphonomyLink.addEventListener('click', ppcExpChoice, false);
}
if(crystalsLink) {
    crystalsLink.addEventListener('click', ppcExpChoice, false);
}
// Display chosen experiment header icon
switch(expChoice) {
    case 'ppcTaphonomy':
        document.getElementById('ppcTaphonomyIcon').style.visibility = 'visible';
        document.getElementById('ppcCrystalsIcon').style.visibility = 'hidden';
        break;
    case 'ppcCrystals':
        document.getElementById('ppcTaphonomyIcon').style.visibility = 'hidden';
        document.getElementById('ppcCrystalsIcon').style.visibility = 'visible';
}

// -----------------------------------------------------------------

// RESET CHOICE ON HOME LINK FUNCTION
function expChoiceReset () {
  if(expChoice) {
    sessionStorage.removeItem('ppcExpChoice');
  }
}

// Event Listener for Home Link
if(ppcHomeLink) {
  ppcHomeLink.addEventListener('click', expChoiceReset, false);
}

// -----------------------------------------------------------------

// NEXT/PREVIOUS CONTROLS
// Display Previous button on all pages except the index
if(ppcPageNumber > 0 && ppcPageNumber < 4) {
    if(ppcPreviousBtn) {
        ppcPreviousBtn.style.visibility = 'visible';
    }
}

// Display Next on all pages except the index if logged in
if(ppcPageNumber > 0 && ppcPageNumber < 3 && sessionStorage.getItem('ppcUser')) {
    if(ppcNextBtn) {
        ppcNextBtn.style.visibility = 'visible';
    }
}

// Hover Effects for the Nav Button's labels
function ppcLabelOn() {
    let ppcLabel = this.nextElementSibling ? this.nextElementSibling : this.previousElementSibling;
    ppcLabel.style.visibility = 'visible';
    ppcLabel.style.opacity = '1';
}

function ppcLabelOff() {
    let ppcLabel = this.nextElementSibling ? this.nextElementSibling : this.previousElementSibling;
    ppcLabel.style.visibility = 'hidden';
    ppcLabel.style.opacity = '0';
}

// Function to move through site with controls
function ppcPageControl(step) {
    let ppcPageTurn = ppcPageNumber + step;
    window.location.pathname = ppcPageOrder[ppcPageTurn];
}

// Event listeners for next/previous controls
if(ppcPreviousBtn) {
    ppcPreviousBtn.addEventListener('mouseover', ppcLabelOn, false);
    ppcPreviousBtn.addEventListener('mouseout', ppcLabelOff, false);
    ppcPreviousBtn.addEventListener('click', function() {
        ppcPageControl(-1);
    }, false);
}

if(ppcNextBtn) {
    ppcNextBtn.addEventListener('mouseover', ppcLabelOn, false);
    ppcNextBtn.addEventListener('mouseout', ppcLabelOff, false);
    ppcNextBtn.addEventListener('click', function() {
        ppcPageControl(1);
    }, false);
}

// -----------------------------------------------------------------

// FEEDBACK FUNCTION FOR EMPTY INPUTS
function ppcInputFeedback(ppcInput) {
    if(ppcInput.value === '') {
        ppcInput.classList.add('ppcInputError');
        return false;
    } else {
        ppcInput.classList.remove('ppcInputError');
        return true;
    }
}

// LOGIN FUNCTION
function ppcLogin() {
    // Fetching the form
    let ppcLoginForm = document.getElementById('ppcLoginForm');
    // Fetching the inputs
    let ppcUsername = document.getElementById('ppcUsername');
    let ppcPassword = document.getElementById('ppcUserpass');
    // Feedback mechanism
    if(!ppcInputFeedback(ppcUsername)) {
        console.log('Please enter a username.');
    } else if(!ppcInputFeedback(ppcPassword)) {
        console.log('Please enter a password.');
    } else {
        // STILL TO DO: Sanitizing the inputs !!!
        // Create a new XMLHttpRequest Object for communication with the database
        const ppcLoginConnect = new XMLHttpRequest();
        // Callback function for the login
        ppcLoginConnect.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                if(this.responseText == 1) {
                    sessionStorage.setItem('ppcUser', ppcUsername.value);
                    window.location.href = './experiment-overview.php';
                } else {
                    console.log(this.responseText);
                }
            }
        }
        // Sending the Request
        ppcLoginConnect.open('POST', './features/ppcLogin.php', true);
        ppcLoginConnect.send(new FormData(ppcLoginForm));
    }
}

// Event Listener for Login Button
if(ppcLoginSubmitBtn) {
    ppcLoginSubmitBtn.addEventListener('click', ppcLogin, false);
}

// -----------------------------------------------------------------

// LOGOUT FUNCTION
function ppcLogout() {
    sessionStorage.clear();
    window.location.href = 'https://palaeoplasticene.katausten.com';
    return true;
}

// Event Listener for Logout Button
if(logoutBtn) {
    logoutBtn.addEventListener('click', ppcLogout, false);
}

// -----------------------------------------------------------------

// PARTICIPATE LINK FOR PARTICIPATE BUTTON
if(ppcParticipateBtn) {
    ppcParticipateBtn.addEventListener('click', function() {
        window.location.pathname = '/experiment-participate.php';
    }, false);
}

// -----------------------------------------------------------------

// CREATE NEW EXPERIMENT FUNCTION
// Button functionality on Experiment Overview
if(ppcNewExpBtn) {
    ppcNewExpBtn.addEventListener('click', function() {
        window.location.pathname = '/experiment.php';
    }, false);
}