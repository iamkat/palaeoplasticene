'use-strict'

// ------------------------------------------------------------------
// INFRASTRUCTURE

const editBtns = document.querySelectorAll('.editBtn');
const newBtns = document.querySelectorAll('.newBtn');

// ------------------------------------------------------------------
// FUNCTIONS

async function editExperiment(category, id) {
    const helperForm = new FormData();
    helperForm.append('category', category);
    helperForm.append('experimentId', id);

    const request = await fetch('./data/queries/getExperimentData.php', {
        method: 'POST',
        body: helperForm,
    });

    return await request.text();
}

async function newExperiment(category) {
    const helperForm = new FormData();
    helperForm.append('category', category);

    const request = await fetch('./data/queries/setupNewExperiment.php', {
        method: 'POST',
        body: helperForm,
    });

    return await request.text();
}

// ------------------------------------------------------------------
// WORK

// ------------------------------------------------------------------
// EVENT LISTENERS

if (editBtns) {
    for (let i = 0; i < editBtns.length; i++) {
        editBtns[i].addEventListener('click', async function() {
            const response = await editExperiment(this.getAttribute('data-category'), this.getAttribute('data-experiment-id'));

            if (response !== 'confirm') {
                alert('Something went awefully wrong. We recommend you to logout, reload the page and try again.');
            } else {
                window.location.href = './experiment-' + this.getAttribute('data-category') + '.php';
            }
        }, false);
    }
}

if (newBtns) {
    for (let i = 0; i < newBtns.length; i++) {
        newBtns[i].addEventListener('click', async function() {
            const response = await newExperiment(this.getAttribute('data-category'));

            if (response !== 'confirm') {
                alert('Something went awefully wrong. We recommend you to logout, reload the page and try again.');
            } else {
                window.location.href = './experiment-' + this.getAttribute('data-category') + '.php';
            }
        }, false);
    }
}
// ------------------------------------------------------------------
// CLEANUP
sessionStorage.removeItem('Category');