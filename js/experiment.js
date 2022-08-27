'use-strict'

// ------------------------------------------------------------------
// INFRASTRUCTURE

let imageCheckboxes;
let imageData;

// ------------------------------------------------------------------
// FUNCTIONS

async function clearCache() {
    const request = await fetch('./queries/clearCache.php');
    return await request;
}

function filterView(option) {
    const images = document.querySelectorAll('.experimentImage');

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

async function getImages() {
    const helperForm = new FormData();
    helperForm.append('js', 1);

    const request = await fetch('./queries/getTaphonomyImages.php', {
        method: 'POST',
        body: helperForm,
    });

    return await request.json();
}

function formatDate(date) {
    const newDate = date.substring(0,16).replace(/\s/, 'T');
    return newDate;
}

// ------------------------------------------------------------------
// WORK

// ------------------------------------------------------------------
// EVENT LISTENERS

document.addEventListener('DOMContentLoaded', function() {
    // Infrastructure
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const viewFilter = document.getElementById('viewFilter');
    const cancelExperiment = document.getElementById('cancelExperiment');
    const cancelEdit = document.getElementById('cancelImage');

    // Hide the edit form
    editModal.style.display = 'none';
    
    // Activate the Filter
    viewFilter.addEventListener('change', function() {
        filterView(this.value);
    }, false);

    // Cancel experiment
    cancelExperiment.addEventListener('click', async function() {
        let response = await clearCache();

        if (response.statusText === 'OK') {
            window.location.href = './overview.php';
        } else {
            alert('Something went awefully wrong. We recommend you to logout, reload the page and try again.');
        }
    }, false);

    // Cancel image edit
    cancelEdit.addEventListener('click', function() {
        editModal.style.display = 'none';
        editForm.reset();
    }, false);
}, false);

// Populate the image gellery on load
document.addEventListener('DOMContentLoaded', async function() {
    // Infrastructure
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const imageContainer = document.querySelector('.images');
    
    const response = await getImages();

    if (response) {
        imageData = response;

        let username = response['user']
        let expId = response['experimentId'];

        for (let key in response) {
            if (key == 'experimentId') {
                continue;
            } else if (key == 'user') {
                continue;
            } else {
                imageContainer.appendChild(createTaphonomyImage(username, expId, response[key]['ppc_img_id'], response[key]['Filename'], response[key]['View'], key));
            }
        }
    }

    // Add reactivity after finishing the population
    imageCheckboxes = document.querySelectorAll('.imageCheckbox');
    imageCheckboxes.forEach(element => {
        element.addEventListener('click', function() {
            // Infrastructure
            const editSection = document.getElementById('editSection');
            editForm.reset();

            const editImage = document.getElementById('editImage');
            const imageCaption = document.querySelector('#editForm figcaption');
            const imageDate = document.getElementById('imageDate');
            const imageConditions = document.getElementById('imageConditions');
            const imageView = document.querySelectorAll('.editViews');
            const imageNotes = document.getElementById('imageNotes');
            const uploadDate = document.getElementById('uploadDate');
            const imageId = document.getElementById('imageId');
            const imageKey = element.getAttribute('data-key');

            editImage.src = './uploads/' + response.user + '/taphonomy/' + response.experimentId + '/' + element.value;
            imageCaption.innerHTML = element.value;
            imageDate.value = formatDate(response[imageKey].Date);
            imageConditions.innerHTML = response[imageKey].Conditions;
            imageView.forEach(option => {
                if (option.value === response[imageKey].View) {
                    option.selected = true;
                }
            });
            imageNotes.innerHTML = response[imageKey].Notes;
            uploadDate.value = formatDate(response[imageKey].Upload);
            imageId.value = element.id;

            editModal.style.display = 'flex';
            
        }, false);
    });

}, false);