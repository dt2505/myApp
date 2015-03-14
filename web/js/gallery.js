$(window).load(function() {
    // init
    $('#card-container').isotope({
        // options
        itemSelector: '.card',
        stamp: '.stamp'
    })
});

$(document).ready(function() {
    dropfile.init("#photo-dropzone", "#image-preview-zone", true, "/dummy-url", 110, 110);
    dropfile.dismiss($('#card-container'), $('#upload-photo-panel'), $("#upload-photo-dismiss"), $("#upload-photos"));

    // in mobile size
    $('#upload-photos-sm').on('click', function() {
        $('#upload-photos').trigger("click");
    });

    // initialize feed
    likesAndComments.init($(".card > .img-wrapper > .img-caption"), "text-white", function () {
        //TODO: show comments
    });
});