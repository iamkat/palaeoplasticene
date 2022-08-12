'use-strict'

// -----------------------------------------------------------------
// CONSTANTS AND VARIABLES

// All h2 Headings
const secondHeadings = document.querySelectorAll('h2');

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

// -----------------------------------------------------------------
// EVENT LISTENERS

// Create Content Sections
if (secondHeadings) {
    document.addEventListener('load', createSections(secondHeadings), false);
}