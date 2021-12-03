// FLASH
$(document).ready(() => {
    $('.alert').css("right", "0");

    $('.alert').click(() => {
        $('.alert').css("right", "100%").then(() => {
            $('.alert').remove();
        });
    })
    setTimeout(() => {
        $('.alert').css("right", "100%");
    }, 10000);

    // MODAL
    var btnOpenModal = document.querySelectorAll("[data-toggle=modal]");
    var close = document.querySelectorAll("[data-dismiss=modal]");

    btnOpenModal.forEach(btnOpen => {
        btnOpen.onclick = function(e) {
            let dataTarget = e.currentTarget.getAttribute("data-target");
            modal = document.querySelector("#"+dataTarget);
            modal.style.display = "block";
        }
    });

    close.forEach(btn => {
        btn.onclick = function() {
            modal.style.display = "none";
        }
    });

    window.onclick = function(e) {
        if (typeof modal !== "undefined" && e.target == modal) {
            modal.style.display = "none";
        }
    }
})