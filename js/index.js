'use-strict'

//----------------------------------------------------------------------------------------
// VARIABLES AND CONSTANTS

// Nav links to chose an experiment category
const navLinks = document.querySelectorAll('.navLink');

//----------------------------------------------------------------------------------------
// FUNCTIONS

// Cleanup
sessionStorage.removeItem('Category');
sessionStorage.removeItem('Experiment ID');

//----------------------------------------------------------------------------------------
// EVENT LISTENERS

// Store chosen category inside the session storage on nav link click
if (navLinks) {
    for (let i = 0; i < navLinks.length; i++) {
      navLinks[i].addEventListener('click', function() {
        sessionStorage.setItem('Category', this.getAttribute('data-category'));
      }, false);
    }
  }