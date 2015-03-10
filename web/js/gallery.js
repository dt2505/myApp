$(window).load(function() {
    // init
    $('#card-container').isotope({
        // options
        itemSelector: '.card',
        stamp: '.stamp'
    })
});

$(document).ready(function() {
    dropfile.init("#form-image-dropzone", "#image-preview-zone", true, "/dummy-url");

    $(".cover-menu > li > a").on("click", function() {
        if ($(this).attr("id") != "upload-photos") {
            $ul = $(this).parent().parent();
            $ul.find("li").each(function(){
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                }
            });

            $(this).parent().addClass("active");
        }
    });

    $('#upload-photos').on('click', function() {
        var $cardContainer = $('#card-container');
        $cardContainer.find(".stamp").toggleClass("hidden");
        $cardContainer.isotope('layout');
    });

    // initialize feed
    likesAndComments.init($(".card > .img-wrapper > .img-caption"), "text-white", function () {
        //TODO: show comments
    });
});