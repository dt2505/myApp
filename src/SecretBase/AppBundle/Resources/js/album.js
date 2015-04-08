$(window).load(function() {
    // init
    $('#card-container').isotope({
        // options
        itemSelector: '.card',
        stamp: '.stamp'
    })
});

$(document).ready(function() {
    dropfile.init("#photo-dropzone", "#image-preview-zone", true, "/dummy-url", 110, 110, 3);
    dropfile.dismiss($('#card-container'), $('#upload-photo-panel'), $("#upload-photo-dismiss"), $("#add-album"));

    $("#add-album-sm").on("click", function() {
        $("#add-album").trigger("click");
    });
});