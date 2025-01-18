let timer; // Debounce timer
let currentPage = 1;

function fetchResults(query, page = 1) {
    $.ajax({
        url: 'search.php',
        type: 'GET',
        data: { query, page },
        success: function (data) {
            const response = JSON.parse(data);
            $('#results').html(response.results);
            $('#pagination').html(response.pagination);
        }
    });
}

$(document).ready(function () {
    $('#search').on('input', function () {
        const query = $(this).val();
        clearTimeout(timer); // Clear the timer
        timer = setTimeout(() => {
            currentPage = 1; // Reset to the first page
            fetchResults(query);
        }, 300); // Delay of 300ms
    });

    // Handle pagination
    $(document).on('click', '.pagination button', function () {
        const query = $('#search').val();
        currentPage = $(this).data('page');
        fetchResults(query, currentPage);
    });
});