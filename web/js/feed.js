feed = (function () {
    "use strict";

    /**
     * @param $el
     * @param $search classes to be removed
     * @param $replacement classes to be added
     */
    function replaceClass($el, $search, $replacement) {
        $el.removeClass($search);
        $el.addClass($replacement);
    }

    /**
     * initialize hover event of likes
     */
    function hoverLikes($feed)
    {
        // like hover event
        $feed.find(".likes").hover(function() {
            replaceClass($(this).find("i"), "fa-heart-o text-default", "fa-heart text-danger");
        }, function() {
            replaceClass($(this).find("i"), "fa-heart text-danger", "fa-heart-o text-default");
        });
    }

    /**
     * initialize hover event of comments
     */
    function hoverComments($feed) {
        $feed.find(".comments").hover(function() {
            var $icon = $(this).find("i");
            if ($icon.hasClass("fa-comment-o")) {
                replaceClass($(this).find("i"), "fa-comment-o text-default", "fa-comment text-primary");
            }
            if ($icon.hasClass("fa-comments-o")) {
                replaceClass($(this).find("i"), "fa-comments-o text-default", "fa-comments text-primary");
            }
        }, function() {
            var $icon = $(this).find("i");
            if ($icon.hasClass("fa-comment")) {
                replaceClass($(this).find("i"), "fa-comment text-primary", "fa-comment-o text-primary");
            }
            if ($icon.hasClass("fa-comments")) {
                replaceClass($(this).find("i"), "fa-comments text-primary", "fa-comments-o text-primary");
            }
        });
    }

    /**
     * bind click event to comment icon
     * @param $comments
     */
    function bindCommentsClick($comments) {
        $comments.on("click", function() {
            var $currentStatus = $(this).parent().parent().parent(),
                $commentsPanel = $currentStatus.find("#" + $currentStatus.attr("id") + "_comments_panel");

            if ($commentsPanel.hasClass("hidden")) {
                $commentsPanel.removeClass("hidden");
            } else {
                $commentsPanel.addClass("hidden");
            }
        })
    }

    /**
     * expose public variables and functions
     */
    return {
        config: {
            el: ""
        },

        init: function () {
            var $feed = $(".feed");

            hoverLikes($feed);
            hoverComments($feed);
            bindCommentsClick($(".comments"));
        }
    };
}());