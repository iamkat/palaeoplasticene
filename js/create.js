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
    return ppcImage;
}

// Overview Elements

// HR
function createHr() {
    let ppcHr = document.createElement("hr");
    ppcHr.classList.add("ppcHrLine");
    ppcHr.setAttribute("id", "ppcExpOverviewLine");
    return ppcHr;
}