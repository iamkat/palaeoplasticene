'use-strict'

// ------------------------------------------------------------------
// INFRASTRUCTURE

let imageCheckboxes;
let imageData;
let imageEdits = {};

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
    let newDate = new Date(date);
    newDate = newDate.toISOString().substring(0,16);
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

function registerImageEdits(inputName, inputValue) {
    imageEdits[inputName] = inputValue;
    // DEBUG
    console.log(imageEdits);
}

function validateTextInputs(inputText) {
    let cleanText = inputText.trim();
    cleanText = cleanText.replace(/[^0-9a-zA-Z\n\s\r.!?_()-]/g, '');
    cleanText = cleanText.replace(/\n/g, ' ');
    cleanText = cleanText.replace(/\r/g, '');
    cleanText = cleanText.replace(/\s{2,}/g, ' ');
    cleanText = cleanText.replace(/\s(?=[.!?])/g, '');
    return cleanText;
}

function validateDateInputs(inputValue) {
    let newDate = new Date(inputValue);
    return Date.parse(newDate);
}

async function saveImageEdits(edits, imgId) {
    if (Object.keys(edits).length == 0) {
        return 'Nothing to update.';
    } else {
        const helperForm = new FormData();
        helperForm.append('edits', JSON.stringify(edits));
        helperForm.append('imageId', imgId);

        const request = await fetch('./queries/editTaphonomyImage.php', {
            method: 'POST',
            body: helperForm,
        });

        return await request.text();
    }
}

async function uploadImages(formdata, imageCount) {
    const helperForm = new FormData(formdata);
    helperForm.append('imageCount', imageCount);
    console.log(helperForm);
    
    const request = await fetch('./queries/uploadTaphonomyImages.php', {
        method: 'POST',
        body: helperForm,
    });

    return await request.text();
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
    const imageId = document.getElementById('imageId');
    const experimentCancelBtn = document.getElementById('cancelExperiment');
    const uploadFile = document.getElementById('fileUpload');
    const editImage = document.getElementById('editImage');
    const uploadCancelBtn = document.getElementById('cancelUpload');
    const uploadBtn = document.getElementById('uploadImages');
    const imageCancelBtn = document.getElementById('cancelImage');
    const imageSaveBtn = document.getElementById('saveImage');
    const maxFileSize = 9216000;

    // Functions
    function cancelEdit() {
        editModal.style.display = 'none';

        if (Object.keys(imageEdits).length != 0) {
            for (let entry in imageEdits) {
                delete imageEdits[entry];
            }
        }
        
        imageSaveBtn.disabled = true;
        
        editImage.src = '';
        editForm.reset();
    }

    // Hide the modals for the edit form and the upload form and reset initially
    editModal.style.display = 'none';
    editForm.reset();
    uploadModal.style.display = 'none';
    uploadForm.reset();

    // Style the save button of the edit form
    imageSaveBtn.disabled = true;
    
    // Activate the Filter
    viewFilter.addEventListener('change', function() {
        filterView(this.value);
    }, false);

    // Cancel experiment
    experimentCancelBtn.addEventListener('click', cancelExperiment, false);

    // Upload images button functionality
    uploadFile.addEventListener('change', async function() {
        let uploadFiles = this.files;
        let imageViews = await getViews();

        // Create the fieldsets for the upload form
        for (let i = 0; i < uploadFiles.length; i++) {
            if (uploadFiles[i].size > maxFileSize) {
                alert(`Sorry the image file ${uploadFiles[i].name} exceeds the maximum file size and will not be uploaded. Please resize this image and try again.`);
            } else {
                uploadForm.prepend(createUploadFieldset(i + 1, URL.createObjectURL(uploadFiles[i]), imageViews));
            }
        }

        let fileInputs = document.querySelectorAll('.uplFileInput');

        // Reactive preview images
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                let labelFigure = this.previousElementSibling.firstChild;
                labelFigure.firstChild.src = URL.createObjectURL(this.files[0]);
            }, false);
        });

        // Reactive reject buttons
        let rejectBtns = document.querySelectorAll('.rejectImage');

        rejectBtns.forEach(element => {
            element.addEventListener('click', function() {
                let image = element.getAttribute('data-image');
                let fieldset = document.getElementById(image);
                fieldset.remove();

                let fieldsets = document.querySelectorAll('.imageFieldset');
                // DEBUG
                console.log(fieldsets);
                if (fieldsets.length == 0) {
                    uploadModal.style.display = 'none';
                    uploadForm.reset();
                }
            }, false);
        });
        
        uploadModal.style.display = 'flex';
        
        // DEBUG
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

    // Upload Images
    uploadBtn.addEventListener('click', async function() {
        const imageFieldsets = document.querySelectorAll('.imageFieldset');
        console.log(imageFieldsets.length);
        const response = await uploadImages(uploadForm, imageFieldsets.length);
        console.log(response);
    }, false);

    // Cancel image edit
    imageCancelBtn.addEventListener('click', cancelEdit, false);

    // Save image edit
    imageSaveBtn.addEventListener('click', async function(event) {
        event.preventDefault();
        
        const response = await saveImageEdits(imageEdits, imageId.value);        
        alert(response);
        
        cancelEdit();
        window.location.reload();
    }, false);
}, false);

// Populate the image gallery on load
document.addEventListener('DOMContentLoaded', async function() {
    // Infrastructure
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const imageContainer = document.querySelector('.images');
    
    const response = await getImages();
    
    // DEBUG
    console.log(response);

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

    // Add editing after finishing the population
    imageCheckboxes = document.querySelectorAll('.imageCheckbox');
    imageCheckboxes.forEach(element => {
        element.addEventListener('click', function() {
            // Infrastructure
            editForm.reset();

            const editImage = document.getElementById('editImage');
            const formInputs = document.querySelectorAll('.formInput');
            const imageFile = document.getElementById('imageFile');
            const imageCaption = document.querySelector('#editForm figcaption');
            const imageDate = document.getElementById('imageDate');
            const imageConditions = document.getElementById('imageConditions');
            const imageView = document.querySelectorAll('.editViews');
            const imageNotes = document.getElementById('imageNotes');
            const uploadDate = document.getElementById('uploadDate');
            const imageId = document.getElementById('imageId');
            const imageKey = element.getAttribute('data-key');
            const imageSaveBtn = document.getElementById('saveImage');
            const dataSet = response[imageKey];

            // Work
            // Set the image attributes
            editImage.src = './uploads/' + response.user + '/taphonomy/' + response.experimentId + '/' + element.value;
            imageCaption.innerHTML = element.value;
            
            // Reactivity for the file upload if a new image is selected
            imageFile.addEventListener('change', function() {
                editImage.src = URL.createObjectURL(this.files[0]);
                imageCaption.innerHTML = this.files[0].name;
            }, false);

            // Set the date value
            imageDate.value = formatDate(response[imageKey].Date);

            // Set the conditions value
            imageConditions.value = response[imageKey].Conditions;

            // Set the view value
            imageView.forEach(option => {
                if (option.value === response[imageKey].View) {
                    option.selected = true;
                }
            });

            // Set the notes value
            imageNotes.value = response[imageKey].Notes;

            // Set the upload date value
            uploadDate.value = formatDate(response[imageKey].Upload);

            // Set the id value for the hidden input
            imageId.value = element.id;

            // Show the modal
            editModal.style.display = 'flex';

            // Reactivity for the edit form inputs
            formInputs.forEach(element => {
                element.addEventListener('change', function(event) {
                    let inputName = this.getAttribute('data-input-name');

                    if (this.files[0].name !== dataSet[inputName] || this.value !== dataSet[inputName]) {
                        imageSaveBtn.disabled = false;

                        if (inputName === 'Filename') {
                            registerImageEdits(inputName, validateTextInputs(this.files[0].name));
                        } else if (inputName === 'Date') {
                            registerImageEdits(inputName, validateDateInputs(this.value));
                        } else {
                            registerImageEdits(inputName, validateTextInputs(this.value));
                        }
                    } else {
                        if (imageEdits[inputName]) {
                            delete imageEdits[inputName];

                            if (Object.keys(imageEdits).length == 0) {
                                imageSaveBtn.disabled = true;
                            }
                        }
                    }

                    // Some bugfix because of multiple event firing after canceling an image edit and editing images afterwards
                    event.stopImmediatePropagation();
                }, false);
            });
            
        }, false);
    });

}, false);