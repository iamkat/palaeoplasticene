'use-strict'

// -----------------------------------------------------------------
// CONSTANTS AND VARIABLES

// Login link
const loginLink = document.getElementById("loginLink");
// Logout button
const logoutBtn = document.getElementById("logoutBtn");

// -----------------------------------------------------------------
// FUNCTIONS

// Logout function
function ppcLogout() {
    sessionStorage.clear();
    window.location.href = "./index.php";
    return true;
}

// Event listener for Logout Button
if (logoutBtn) {
    logoutBtn.addEventListener('click', ppcLogout, false);
}

/*
// Check for logged in user to display logout button
if (sessionStorage.getItem("User")) {
    loginLink.style.display = "none";
    logoutBtn.style.display = "block";
} else {
    loginLink.style.display = "block";
    logoutBtn.style.display = "none";
}
*/