// FILTERS
$(document).ready(() => {
    $('button[data-collapse]').click(function (e) {
        let dataCollapse = $(this).attr("data-collapse");
        $(this).children('i').toggleClass('active');
        $('#'+dataCollapse).slideToggle('100', 'swing');
    })
})

// FAV
function toggleActive(e) {
    $(e).toggleClass('active');
}