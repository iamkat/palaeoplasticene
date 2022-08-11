'use-strict'

//----------------------------------------------------------------------------------------
// VARIABLES AND CONSTANTS

// Navbar Links
const iconLinks = document.querySelectorAll('.iconLink');

// Navbar Icons
const categoryIcons = document.querySelectorAll('.expIcon');

// -----------------------------------------------------------------
// FUNCTIONS

// Function to highlight the icon in the navbar depending on experiment choice
function highlightIcon(icons) {
  for (let i = 0; i < icons.length; i++) {
      if (sessionStorage.getItem('Category') == icons[i].getAttribute('alt')) {
        icons[i].style.opacity = 1;
      }
  }
}

// -----------------------------------------------------------------
// EVENT LISTENERS

// Highlight category icon in navbar
if (categoryIcons) {
  document.addEventListener('load', highlightIcon(categoryIcons), false);
}

// Store chosen category inside the session storage on icon link click
if (iconLinks) {
  for (let i = 0; i < iconLinks.length; i++) {
    iconLinks[i].addEventListener('click', function() {
      sessionStorage.setItem('Category', this.getAttribute('title'));
    }, false);
  }
}