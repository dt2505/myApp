likesAndComments = (function () {
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
    function hoverLikes($likeContainer, color)
    {
        // like hover event
        $likeContainer.find(".likes").hover(function() {
            replaceClass($(this).find("i"), "fa-heart-o " + color, "fa-heart text-danger");
        }, function() {
            replaceClass($(this).find("i"), "fa-heart text-danger", "fa-heart-o " + color);
        });
    }

    /**
     * initialize hover event of comments
     */
    function hoverComments($commentContainer, color) {
        $commentContainer.find(".comments").hover(function() {
            var $icon = $(this).find("i");
            if ($icon.hasClass("fa-comment-o")) {
                replaceClass($(this).find("i"), "fa-comment-o " + color, "fa-comment text-primary");
            }
            if ($icon.hasClass("fa-comments-o")) {
                replaceClass($(this).find("i"), "fa-comments-o " + color, "fa-comments text-primary");
            }
        }, function() {
            var $icon = $(this).find("i");
            if ($icon.hasClass("fa-comment")) {
                replaceClass($(this).find("i"), "fa-comment text-primary", "fa-comment-o " + color);
            }
            if ($icon.hasClass("fa-comments")) {
                replaceClass($(this).find("i"), "fa-comments text-primary", "fa-comments-o " + color);
            }
        });
    }

    /**
     * bind click event to comment icon
     * @param $comments
     * @param callbackCommentsClick
     */
    function bindCommentsClick($comments, callbackCommentsClick) {

        //$comments.on("click", callbackCommentsClick);

        $comments.on("click", callbackCommentsClick || function() {
            var $currentStatus = findCurrentStatusCardContainer($(this), "card"),
                statusId = $currentStatus.data('id'),
                commentCount = $currentStatus.data("comment-count"),
                $commentsPanel = commentCount > 0 ? $("#" + statusId + "_comments_panel") : $("#" + statusId + "_comment_form");

            $commentsPanel.toggleClass("hidden");
            $('#card-container').isotope('layout');
        })
    }

    /**
     * @param $current
     * @param className
     * @returns {*}
     */
    function findCurrentStatusCardContainer($current, className) {
        var $statusCardContainer = $current;

        while(!$statusCardContainer.hasClass(className)) {
            $statusCardContainer = $statusCardContainer.parent();
        }

        return $statusCardContainer;
    }

    /**
     * expose public variables and functions
     */
    return {
        config: {
            el: ""
        },

        init: function ($lcContainer, color, callbackCommentsClick) {
            hoverLikes($lcContainer, color||"text-default");
            hoverComments($lcContainer, color||"text-default");

            bindCommentsClick($(".comments"), callbackCommentsClick);
        }
    };
}());