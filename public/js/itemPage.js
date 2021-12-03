$(document).ready(function() {
    $('.carousel-item').flexslider({
        animation: "fade",
        slideshow: false,
        controlNav: "thumbnails",
        // directionNav: false
        customDirectionNav: $(".flex-navigation .slick-arrow")
    });

    $("[data-fancybox]").fancybox({
        loop: true,
        infobar: false,
        protect: true,
        buttons: [
            "close"
        ],
    });
});