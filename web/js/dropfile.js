Dropzone.autoDiscover = false;

dropfile = (function () {
    "use strict";

    return {
        instance: undefined,
        // public variables
        config: {
            el: ""
        },
        // public functions
        dismiss: function($cardContainer, $card, $clickableDismissElement, $toggleElement) {
            $clickableDismissElement.on("click", function() {
                $card.addClass("animated fadeOut");
                setTimeout(function(){
                    $card.addClass("hidden");
                    $cardContainer.isotope('layout');
                }, 500);
            });

            $toggleElement.on("click", function() {
                if ($card.hasClass("hidden")) {
                    $card.removeClass("hidden fadeOut");
                    $cardContainer.isotope('layout');
                    $card.addClass("animated fadeIn");
                } else {
                    $clickableDismissElement.trigger('click');
                }
            });
        },
        bind: function ($clickable, $fileInput) {
            $clickable.on("click", function() {
                $fileInput.on("change", function (event) {
                    var file, files, index, len;
                    files = event.target.files;
                    if (files.length) {
                        for (index = 0, len = files.length; index < len; index++) {
                            file = files[index];
                            dropfile.instance.addFile(file);
                        }
                    }

                    // reset file input
                    $fileInput.replaceWith($fileInput.val('').clone(true));
                });
                $fileInput.click();
            });
        },
        init: function (dropArea, previewContainer, clickableEl, url, tw, th , mfs) {
            var $previewNode = $(previewContainer),
                thumbnailW = tw || 60,
                thumbnailH = th || 60,
                maxFiles = mfs || 1;
                $(previewContainer).find(".dz-preview > .dz-image").each(function() {
                    $(this).css("width", thumbnailW);
                    $(this).css("height", thumbnailH);
                });
            var previewTemple = $previewNode.html();
            $previewNode.empty();

            $(dropArea).dropzone({
                url: url, // Set the url
                thumbnailWidth: thumbnailW,
                thumbnailHeight: thumbnailH,
                maxFilesize: maxFiles * 2, // in MB
                maxFiles: maxFiles,
                previewTemplate: previewTemple,
                autoProcessQueue: false,
                autoQueue: false, // Make sure the files aren't queued until manually added
                previewsContainer: previewContainer, // Define the container to display the previews
                clickable: clickableEl||true, // Define the element that should be used as click trigger to select files.
                init: function() {
                    var $dropzone = this;

                    this.on("thumbnail", function(file, dataUrl) {
                        // refresh the masonry cards when image gets previewed
                        $('#card-container').isotope('layout');

                        $('.dz-remove').on('click', function() {
                            // refresh the masonry cards when image gets removed
                            $('#card-container').isotope('layout');
                        });
                    });

                    this.on("addedfile", function(file) {
                        $(dropArea).find("div.dz-default").addClass("hidden");
                    });

                    this.on("removedfile", function(file) {
                        if ($dropzone.files.length < 1) {
                            $(dropArea).find("div.dz-default").removeClass("hidden");
                        }
                    });
                }
            });

            dropfile.instance = Dropzone.instances.length > 0 ? Dropzone.instances[0] : undefined;

            dropfile.bind($("#btn-new-photo"), $("#hidden-file"));


            return dropfile.instance;
        }
    };
}());

//dropfile.init("#photo-dropzone", "#image-preview-zone", true, "/dummy-url", 110, 110);
//dropfile.bind($("#btn-new-photo"), $("#hidden-file"));
//dropfile.dismiss($('#card-container'), $('#upload-photo-panel'), $("#upload-photo-dismiss"), $("#upload-photos"));