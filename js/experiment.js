'use-strict'

// ------------------------------------------------------------------
// INFRASTRUCTURE

const cancelExperiment = document.getElementById('cancelExperiment');

// ------------------------------------------------------------------
// FUNCTIONS

async function clearCache() {
    const request = await fetch('./queries/clearCache.php');
    return await request.text();
}

// ------------------------------------------------------------------
// WORK

// ------------------------------------------------------------------
// EVENT LISTENERS

if (cancelExperiment) {
    cancelExperiment.addEventListener('click', async function() {
        const response = await clearCache();

        if (response === 'confirm') {
            window.location.href = './overview.php';
        } else {
            alert('Something went awefully wrong. We recommend you to logout, reload the page and try again.');
        }
    }, false);
}