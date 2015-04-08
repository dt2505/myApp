CalendarEventModal = (function() {
    "use strict";

    var $modal,
        $btnOk,
        btnOkClicked,
        $btnCancel,
        $btnRemove,
        doneCallback,
        details,
        $targetEl; // which element should have the focus

    /**
     * @param event
     */
    function initializeEvent(event) {
        $.each(event, function(key, value){
            var $el = $modal.find(value["selector"]),
                val = value["value"] || '';

            if (value["focus"]) {
                $targetEl = $el;
            }

            if (value["inputType"] == "chosen") {
                $el.val(value["value"]);
                $el.trigger("chosen:updated"); // update chosen
            }

            if (value["showEmpty"] === true || val) {
                $el.val(val);
            }
        });
    }

    /**
     * @returns {*}
     */
    function getDetails()
    {
        var eventDetail = null;

        if (details) {
            eventDetail = [];

            $.each(details, function(key, value){
                eventDetail[value["key"]] = $modal.find(value["selector"]).val();
            });
            return eventDetail;
        }

        return eventDetail;
    }

    /**
     * reset all variables
     */
    function reset() {
        $modal = null;
        btnOkClicked = false;
        $btnOk = null;
        $btnCancel = null;
        details = null;
        doneCallback = null;
        $targetEl = null;
    }

    return {
        init: function(opt) {

            btnOkClicked = false;
            $modal = $(opt["modalId"]);
            $btnOk = $(opt["btnOk"]);
            $btnCancel = $(opt["btnCancel"]);
            $btnRemove = $(opt["btnRemove"]);
            details = opt["details"];
            doneCallback = opt["done"];

            initializeEvent(details);

            if (opt["showRemove"]) {
                $btnRemove.removeClass("hidden");
                $btnRemove.on("click", function () {
                    $modal.modal("hide");
                    opt["remove"]();
                })
            }

            $btnOk.on("click", function() {
                $modal.modal("hide");
                btnOkClicked = true;
            });

            $modal.on('hidden.bs.modal', function (event) {
                if (btnOkClicked) {
                    doneCallback(getDetails());
                }

                reset();
            });

            return this;
        },
        modal: function(opt) {
            $modal.modal(opt);
        }
    };
}());