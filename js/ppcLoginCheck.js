// Check for logged in user
let ppcUserCheck = sessionStorage.getItem('ppcUser');
if(!ppcUserCheck) {
    alert('You have no rights to access this page. Try to login first or contact us to create an user account.');
    window.location.href = './index.php';
}