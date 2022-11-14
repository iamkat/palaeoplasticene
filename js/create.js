'use-strict'

// General Elements

// Heading
function createHeading(number, content) {
    let ppcHeading = document.createElement("h" + number);
    ppcHeading.innerHTML = content;
    return ppcHeading;
}

// DIV
function createDiv(className) {
    let ppcDiv = document.createElement("div");
    ppcDiv.classList.add(className);
    return ppcDiv;
}

// Section
function createSection() {
    let ppcSection = document.createElement('section');
    return ppcSection;
}

// Paragraph
function createParagraph(className, content) {
    let ppcParagraph = document.createElement("p");
    ppcParagraph.classList.add(className);
    ppcParagraph.innerHTML = content;
    return ppcParagraph;
}

// List Items
function createListItem(className) {
    let ppcListItem = document.createElement("li");
    ppcListItem.classList.add(className);
    return ppcListItem;
}

// Buttons
function createButton(className, content) {
    let ppcButton = document.createElement("button");
    ppcButton.type = "button";
    ppcButton.classList.add("ppcControl");
    ppcButton.classList.add(className);
    ppcButton.innerHTML = content;
    return ppcButton;
}

function createNewExperimentButton() {
    let ppcButton = document.createElement("button");
    ppcButton.type = "button";
    ppcButton.classList.add("ppcControl");
    ppcButton.setAttribute("id", "ppcNewExpBtn");
    ppcButton.innerHTML = "New Experiment";
    return ppcButton;
}

// Images
function createImage(source, className, altText) {
    let ppcImage = document.createElement("img");
    ppcImage.src = source;
    ppcImage.classList.add(className);
    ppcImage.alt = altText;
    ppcImage.loading = 'lazy';
    return ppcImage;
}

// Labels
function createLabel(forValue, content) {
    let ppcLabel = document.createElement('label');
    ppcLabel.setAttribute('for', forValue);
    ppcLabel.innerHTML = content;
    return ppcLabel;
}

// Inputs
function createInput(typeValue, className, idValue, nameValue, valueAttr, formName) {
    let ppcInput = document.createElement('input');
    ppcInput.type = typeValue;
    ppcInput.classList.add(className);
    ppcInput.id = idValue;
    ppcInput.name = nameValue;
    ppcInput.value = valueAttr;
    ppcInput.form = formName;
    return ppcInput;
}

// Overview Elements

// HR
function createHr() {
    let ppcHr = document.createElement("hr");
    ppcHr.classList.add("ppcHrLine");
    ppcHr.setAttribute("id", "ppcExpOverviewLine");
    return ppcHr;
}

// Taphonomy Experiment Elements

function createImgLabel(forValue, content) {
    let ppcLabel = document.createElement('label');
    ppcLabel.setAttribute('for', forValue);
    ppcLabel.appendChild(content);
    return ppcLabel;
}

function createImgCheckbox(imgId, nameValue, filename) {
    let imgCheckbox = document.createElement('input');
    imgCheckbox.type = 'checkbox';
    imgCheckbox.classList.add('imageCheckbox');
    imgCheckbox.id = imgId;
    imgCheckbox.name = nameValue;
    imgCheckbox.value = filename;
    return imgCheckbox;
}

function createTaphonomyImage(user, expId, imgId, filename, view, key) {
    let imgPath = './uploads/' + user + '/taphonomy/' + expId + '/thumbs/' + filename;
    
    let imgDiv = createDiv('experimentImage');
    imgDiv.setAttribute('data-view', view);

    let imgLabel = createImgLabel(imgId, createImage(imgPath, 'thumbnail', filename));
    let imgInput = createImgCheckbox(imgId, imgId, filename);
    imgInput.setAttribute('data-key', key);

    imgDiv.appendChild(imgLabel);
    imgDiv.appendChild(imgInput);

    return imgDiv;
}

function createUplImageData(imageInputs) {
    const dataColumn = document.createElement('div');
    dataColumn.classList.add('imageData');
    imageInputs.forEach(element => {
        dataColumn.appendChild(element);
    });
    return dataColumn;
}

function createRejectBtnDiv(element) {
    const uplImageControls = document.createElement('div');
    uplImageControls.classList.add('uploadImageControls');
    uplImageControls.appendChild(element);
    return uplImageControls;
}

function createImageInput(label, element) {
    const imgInput = document.createElement('div');
    imgInput.classList.add('imageInput');
    imgInput.appendChild(label);
    imgInput.appendChild(element);
    return imgInput;
}

function createUploadFieldset(imgId, imgSrc, views) {
    // Setup of fieldset elements
    const imgFieldset = document.createElement('fieldset');
    imgFieldset.id = 'image' + imgId;
    imgFieldset.classList.add('imageFieldset');
    imgFieldset.form = 'uploadForm';

    const fileLabel = document.createElement('label');
    fileLabel.setAttribute('for', 'imageFile' + imgId);

    const fileFigure = document.createElement('figure');
    fileFigure.classList.add('imagePreview');

    const fileImage = document.createElement('img');
    fileImage.src = imgSrc;
    fileImage.id = 'uploadImage' + imgId;
    fileImage.classList.add('uploadImage');
    fileImage.alt = 'Upload Image No. ' + imgId;

    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.id = 'imageFile' + imgId;
    fileInput.name = 'imageFile' + imgId;
    fileInput.classList.add('uplFileInput');
    fileInput.required = true;
    fileInput.accept = 'image/jpeg,image/png';
    fileInput.capture = 'environment';
    fileInput.form = 'uploadForm';

    const viewLabel = createLabel('imageView' + imgId, 'View');
    const viewSelect = document.createElement('select');
    viewSelect.id = 'imageView' + imgId;
    viewSelect.name = 'imageView' + imgId;
    viewSelect.required = true;
    viewSelect.form = 'uploadForm';

    views.forEach(element => {
        const viewSelectOption = document.createElement('option');
        viewSelectOption.classList.add('uploadView');
        viewSelectOption.innerHTML = element;

        viewSelect.appendChild(viewSelectOption);
    });

    const dateLabel = createLabel('imageDate' + imgId, 'Date');
    const dateInput = document.createElement('input');
    dateInput.type = 'datetime-local';
    dateInput.id = 'imageDate' + imgId;
    dateInput.name = 'imageDate' + imgId;
    dateInput.required = true;
    dateInput.form = 'uploadForm';

    const conditionsLabel = createLabel('imageConditions' + imgId, 'Conditions');
    const conditions = document.createElement('textarea');
    conditions.id = 'imageConditions' + imgId;
    conditions.name = 'imageConditions' + imgId;
    conditions.form = 'uploadForm';

    const notesLabel = createLabel('imageNotes' + imgId, 'Notes');
    const notes = document.createElement('textarea');
    notes.id = 'imageNotes' + imgId;
    notes.name = 'imageNotes' + imgId;
    notes.form = 'uploadForm';

    const rejectBtn = document.createElement('button');
    rejectBtn.type = 'button';
    rejectBtn.classList.add('rejectImage');
    rejectBtn.setAttribute('data-image', 'image' + imgId);
    rejectBtn.innerHTML = 'Reject';

    // Build the fieldset element

    // Preview figure
    fileFigure.appendChild(fileImage);
    fileLabel.appendChild(fileFigure);

    // Helper Array for the first column
    let firstColumn = [
        createImageInput(fileLabel, fileInput),
    ];

    imgFieldset.appendChild(createUplImageData(firstColumn));

    // Helper Array for the second fieldset column
    let secondColumn = [
        createImageInput(viewLabel, viewSelect),
        createImageInput(dateLabel, dateInput),
    ];
    
    imgFieldset.appendChild(createUplImageData(secondColumn));

    // Helper Array for the third fieldset column
    let thirdColumn = [
        createImageInput(conditionsLabel, conditions),
        createImageInput(notesLabel, notes),
    ];

    imgFieldset.appendChild(createUplImageData(thirdColumn));

    imgFieldset.appendChild(createRejectBtnDiv(rejectBtn));

    return imgFieldset;
}