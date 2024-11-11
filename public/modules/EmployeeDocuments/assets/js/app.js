// Define constants for URL and jQuery elements
const documents_url = $('#documents_url').val();
const $page = $("#page");
const $entries = $('#entries');
const $search = $('#search');
const $dateRangeFrom = __date_range['from'];
const $dateRangeTo = __date_range['to'];

// Function to build the query string
function buildQueryString() {
    const queryParams = [];

    // Append parameters conditionally
    if ($entries.val()) {
        queryParams.push('entries=' + $entries.val());
    }
    if ($search.val()) {
        queryParams.push('search=' + $search.val());
    }
    if ($dateRangeFrom) {
        queryParams.push('from=' + $dateRangeFrom);
    }
    if ($dateRangeTo) {
        queryParams.push('to=' + $dateRangeTo);
    }

    // Always include 'page' parameter
    queryParams.push('page=' + $page.val());

    // Join the query parameters with '&'
    return queryParams.join('&');
}

// Function to update the user document
function updateUserDocument() {
    const queryString = buildQueryString();

    // Construct the complete URL
    const current_url = `${documents_url}?${queryString}`;

    updateTbody(current_url);
}

// Function to update the table body via AJAX
function updateTbody(current_url) {
    $.ajax({
        url: current_url,
        method: 'GET',
        success: function (data) {
            console.log(data);
            $('._ajaxData').empty().html(data.view);
        },
        error: function (error) {
            console.error(error);
        }
    });
}



// Function for pagination
function ModulePagination(page) {
    $page.val(page);
    updateUserDocument();
}
// Initial call to updateUserDocument
updateUserDocument();