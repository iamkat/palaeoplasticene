'use-strict'

// -----------------------------------------------------------------
// CONSTANTS AND VARIABLES

// All h2 Headings
const secondHeadings = document.querySelectorAll('h2');
// Login link
const loginLink = document.getElementById("loginLink");
// Logout button
const logoutBtn = document.getElementById("logoutBtn");

// -----------------------------------------------------------------
// FUNCTIONS

function createSections(headings) {
    for (let i = 0; i < headings.length; i++) {
        // Create a constant with a section element
        const contentSection = createSection();
        // Put a section before each h2 Heading
        headings[i].parentNode.insertBefore(contentSection, headings[i].previousSibling);
    
        while (((headings[i].nextSibling != null) && headings[i].nextSibling.tagName !== 'H2')) {
            contentSection.appendChild(headings[i].nextSibling);
        }

        contentSection.prepend(headings[i]);
    }
}

// Logout function
function ppcLogout() {
    sessionStorage.clear();
    window.location.href = "./index.php";
    return true;
}

// -----------------------------------------------------------------
// EVENT LISTENERS

// Create Content Sections
if (secondHeadings) {
    document.addEventListener('load', createSections(secondHeadings), false);
}

// Event listener for Logout Button
if (logoutBtn) {
    logoutBtn.addEventListener("click", ppcLogout, false);
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