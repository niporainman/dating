document.addEventListener('DOMContentLoaded', function () {
    const previewPane = document.getElementById('previewPane');

    function loadPreviews() {
        fetch('load_previews.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then(html => {
                if (previewPane) {
                    previewPane.innerHTML = html;
                }
            })
            .catch(error => {
                console.error('Failed to load previews:', error);
            });
    }

    // Initial load and auto refresh every 5 seconds
    loadPreviews();
    setInterval(loadPreviews, 5000);
});


