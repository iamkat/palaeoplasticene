// Check for logged in user to display logout button
if(sessionStorage.getItem('ppcUser')) {
    document.getElementById('ppcLoginLink').style.display = "none";
    document.getElementById('ppcLogoutBtn').style.display = "block";
} else {
    document.getElementById('ppcLoginLink').style.display = "block";
    document.getElementById('ppcLogoutBtn').style.display = "none";
}