$('#searchForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        method: 'POST',
        url: 'ajax/search_results.php',
        data: $(this).serialize(),
        success: function (html) {
            $('#searchResults').html(html);
            feather.replace(); // Re-render icons if needed
        },
        error: function () {
            Swal.fire('Error', 'Failed to fetch results', 'error');
        }
    });
});