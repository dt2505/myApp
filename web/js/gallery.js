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