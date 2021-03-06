$(window).load(function() {
    // init
    $('#card-container').isotope({
        // options
        itemSelector: '.card',
        stamp: '.stamp'
    })
});

$(document).ready(function() {
    // initialize image preview before it gets uploaded
    dropfile.init("#status-preview", "#status-preview", "#sf-add-photo", "/dummy-url");

    // initialize feed
    likesAndComments.init($(".card > .panel-footer"));

    //$('.mainnav-toggle').on("click", function() {
    //    $.niftyAside('hide');
    //});
});
