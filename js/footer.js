'use-strict'

// ------------------------------------------------------------------
// INFRASTRUCTURE

// Logout button
const logoutBtn = document.getElementById("logoutBtn");

// ------------------------------------------------------------------
// FUNCTIONS

async function ppcLogout() {
    try {
        const request = await fetch('./data/queries/tryLogout.php');
        return await request.text();
    } catch (error) {
        console.log(error);
    }
}

// ------------------------------------------------------------------
// EVENT LISTENERS

if (logoutBtn) {
    logoutBtn.addEventListener('click', async function() {
        const response = await ppcLogout();
    
        if (response === 'failed') {
            alert('Something went awefully wrong. We recommend to close the window and visit our page again.');
        } else {
            window.location.href = './';
        }
    }, false);
}

// ------------------------------------------------------------------
// CLEANUP