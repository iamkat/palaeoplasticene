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

function createEditFieldset(imgId) {
    let imgFieldset = document.createElement('fieldset');
    imgFieldset.classList.add('imageFieldset');



    return imgFieldset;
}