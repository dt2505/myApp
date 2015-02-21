dropfile = (function () {
    "use strict";

    return {
        // public variables
        config: {
            el: ""
        },

        // public functions
        init: function () {
            var $previewNode = $("#status-preview"),
                previewTemple = $previewNode.html();
            $previewNode.empty();

            Dropzone.autoDiscover = false;
            $previewNode.dropzone({
                url: "/dummy-url", // Set the url
                thumbnailWidth: 60,
                thumbnailHeight: 60,
                parallelUploads: 3,
                previewTemplate: previewTemple,
                autoQueue: false, // Make sure the files aren't queued until manually added
                previewsContainer: "#status-preview", // Define the container to display the previews
                clickable: "#sf-add-photo" // Define the element that should be used as click trigger to select files.
            });
        }
    };
}());