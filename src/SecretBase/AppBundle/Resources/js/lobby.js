$(window).load(function() {
    // init
    $('#card-container').isotope({
        // options
        itemSelector: '.card',
        stamp: ".stamp"
    });
});

$(document).ready(function() {
    // initialize image preview before it gets uploaded
    dropfile.init("#status-preview", "#status-preview", "#sf-add-photo", "/dummy-url");

    likesAndComments.init($(".card > .panel-footer"));

    $('.write-status').on('click', function() {
        $('#status-form-container').toggleClass("hidden");
        $('#card-container').isotope('layout');
    })
});