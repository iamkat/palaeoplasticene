'use-strict'

// ------------------------------------------------------------------
// INFRASTRUCTURE

const cancelExperiment = document.getElementById('cancelExperiment');
const images = document.querySelectorAll('.experimentImage');
//const thumbnails = document.querySelectorAll('.thumbnail');
const imageCheckboxes = document.querySelectorAll('.imageCheckbox');
const viewFilter = document.getElementById('viewFilter');

// ------------------------------------------------------------------
// FUNCTIONS

async function clearCache() {
    const request = await fetch('./queries/clearCache.php');
    return await request;
}

function selectImage(checkbox) {
    if (checkbox.checked == true) {
        checkbox.previousElementSibling.style.opacity = 1;
    } else {
        checkbox.previousElementSibling.style.opacity = 0.8;
    }
}

function filterView(option) {
    if (option === 'All') {
        images.forEach(element => {
            element.style.display = 'block';
        });
    } else {
        images.forEach(element => {
            if (element.getAttribute('data-view') === option) {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        });
    }
}

// ------------------------------------------------------------------
// WORK

// ------------------------------------------------------------------
// EVENT LISTENERS

if (cancelExperiment) {
    cancelExperiment.addEventListener('click', async function() {
        const response = await clearCache();

        if (response.statusText === 'OK') {
            window.location.href = './overview.php';
        } else {
            alert('Something went awefully wrong. We recommend you to logout, reload the page and try again.');
        }
    }, false);
}

if (imageCheckboxes) {
    imageCheckboxes.forEach(element => {
        selectImage(element);
        element.addEventListener('click', function() {
            selectImage(this);
        }, false);
    });
}

if (viewFilter) {
    viewFilter.addEventListener('change', function() {
        filterView(this.value);
    }, false);
}