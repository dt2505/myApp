$(document).ready(function() {
    // Initialize chosen
    // -----------------------------------------------------------------
    $('#category').chosen({width:'100%'});

    // Click event
    // -----------------------------------------------------------------
    var $menuPublic = $(".dropdown-menu-public"),
        $menuPrivate = $(".dropdown-menu-private"),
        $emailPrivacy = $("#email-privacy");

    // email will be opened to public
    $menuPublic.on("click", function() {
        var $i = $(this).find("i")

        if ($i.hasClass("fa-square-o")) {
            $i.removeClass("fa-square-o");
            $i.addClass("fa-check-square-o");
            $emailPrivacy.val("public");

            $menuPrivate.find("i").removeClass("fa-check-square-o").addClass("fa-square-o");
        }
    });

    // email will not be opened to public
    $menuPrivate.on("click", function() {
        var $i = $(this).find("i");

        if ($i.hasClass("fa-square-o")) {
            $i.removeClass("fa-square-o");
            $i.addClass("fa-check-square-o");
            $emailPrivacy.val("");

            $menuPublic.find("i").removeClass("fa-check-square-o").addClass("fa-square-o");
        }
    });
});