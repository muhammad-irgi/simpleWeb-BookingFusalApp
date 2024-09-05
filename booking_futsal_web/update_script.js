// Get the current URL parameter value
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

// Check the current page parameter and apply styles
function highlightActivePage() {
    var currentPage = getParameterByName('page');
    var lapanganA = document.getElementById('lapanganA');
    var lapanganB = document.getElementById('lapanganB');
    var anchorA = document.getElementById('anchorA');
    var anchorB = document.getElementById('anchorB');

    // Check if the elements exist before manipulating them
    if (lapanganA && lapanganB) {
        // Apply styles based on the current page
        lapanganA.classList.remove('active');
        lapanganB.classList.remove('active');
        anchorA.classList.remove('active');
        anchorB.classList.remove('active');

        if (currentPage === 'Lapangan-A') {
            lapanganA.classList.add('active');
            anchorA.classList.add('active');
        } else if (currentPage === 'Lapangan-B') {
            lapanganB.classList.add('active');
            anchorB.classList.add('active');
        }
    }
}

// Call the function when the page loads
window.onload = highlightActivePage;