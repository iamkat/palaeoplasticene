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

async function getViews() {
    const helperForm = new FormData();
    helperForm.append('js', 1);

    const request = await fetch('./queries/getTaphonomyViews.php', {
        method: 'POST',
        body: helperForm,
    });

    return await request.json();
}

function formatDate(date) {
    const newDate = date.substring(0,16).replace(/\s/, 'T');
    return newDate;
}

async function cancelExperiment() {
    let response = await clearCache();

    if (response.statusText === 'OK') {
        window.location.href = './overview.php';
    } else {
        alert('Something went awefully wrong. We recommend you to logout, reload the page and try again.');
    }
}

// ------------------------------------------------------------------
// WORK

// Setup the main page functions
document.addEventListener('DOMContentLoaded', function() {
    // Infrastructure
    const editModal = document.getElementById('editModal');
    const uploadModal = document.getElementById('uploadModal');
    const editForm = document.getElementById('editForm');
    const uploadForm = document.getElementById('uploadForm');
    const viewFilter = document.getElementById('viewFilter');
    const experimentCancelBtn = document.getElementById('cancelExperiment');
    const uploadImages = document.getElementById('fileUpload');
    const editImage = document.getElementById('editImage');
    const uploadCancelBtn = document.getElementById('cancelUpload');
    const imageCancelBtn = document.getElementById('cancelImage');

    // Hide the edit form and the upload form
    editModal.style.display = 'none';
    uploadModal.style.display = 'none';
    
    // Activate the Filter
    viewFilter.addEventListener('change', function() {
        filterView(this.value);
    }, false);

    // Cancel experiment
    experimentCancelBtn.addEventListener('click', cancelExperiment, false);

    // Upload button functionality
    uploadImages.addEventListener('change', async function() {
        let uploadFiles = this.files;
        let imageViews = await getViews();

        for (let i = 0; i < uploadFiles.length; i++) {
            uploadForm.prepend(createUploadFieldset(i + 1, URL.createObjectURL(uploadFiles[i]), imageViews));
        }

        let fileInputs = document.querySelectorAll('.uplFileInput');

        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                let labelFigure = this.previousElementSibling.firstChild;
                labelFigure.firstChild.src = URL.createObjectURL(this.files[0]);
            }, false);
        });

        let rejectBtns = document.querySelectorAll('.rejectImage');

        rejectBtns.forEach(element => {
            element.addEventListener('click', function() {
                let image = element.getAttribute('data-image');
                let fieldset = document.getElementById(image);
                fieldset.remove();

                let fieldsets = document.querySelectorAll('.imageFieldset');
                console.log(fieldsets);
                if (fieldsets.length == 0) {
                    uploadModal.style.display = 'none';
                    uploadForm.reset();
                }
            }, false);
        });
        
        uploadModal.style.display = 'flex';
        
        console.log(this.files);
    }, false);

    // Cancel image upload
    uploadCancelBtn.addEventListener('click', function() {
        uploadModal.style.display = 'none';
        uploadForm.reset();
        const imageFieldsets = document.querySelectorAll('.imageFieldset');
        imageFieldsets.forEach(element => {
            element.remove();
        });
    }, false);

    // Cancel image edit
    imageCancelBtn.addEventListener('click', function() {
        editModal.style.display = 'none';
        editImage.src = '';
        editForm.reset();
    }, false);
}, false);

// Populate the image gallery on load
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