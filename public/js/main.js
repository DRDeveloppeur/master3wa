// FLASH
$(document).ready(() => {
    $('.alert').css("right", "0");

    $('.alert').click(() => {
        $('.alert').css("right", "100%").then(() => {
            $('.alert').remove();
        });
    })
    setTimeout(() => {
        $('.alert').css("right", "100%").then(() => {
            $('.alert').remove();
        });
    }, 10000);
})