$(document).ready(function() {

    var dateFormat = "YYYY-MM-DD",
        $opt = {
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        timeFormat: 'H:mm',
        selectable: true,
        editable: true,
        droppable: false, // this allows things to be dropped onto the calendar
        select: function(start, end, jsEvent, view) {
            CalendarEventModal.init({
                modalId: "#new-event-modal",
                btnOk: "#modal-ok",
                btnCancel: "#modal-cancel",
                details: [
                    {
                        selector: "#event-title",
                        key: "title",
                        showEmpty: true
                    },
                    {
                        selector: "#start-date",
                        value: start.format(dateFormat),
                        key: "startDate"
                    },
                    {
                        selector: "#end-date",
                        value: end.subtract(1, "d").format(dateFormat),
                        key: "endDate"
                    },
                    {
                        selector: "#event-color",
                        key: "className",
                        value: "purple",
                        inputType: "chosen"
                    }
                ],
                done: function (result) {
                    var endDate = result["endDate"] ? moment(result["endDate"], dateFormat) : end,
                        option = {
                            editable: true,
                            title: result["title"],
                            start: result["startDate"],
                            end: endDate.add(1, "d"),
                            className: result["className"],
                            allDay: true
                        };

                    //TODO: add event from database with ajax
                    $("#calendar").fullCalendar('renderEvent', option, true);
                }
            }).modal();
        },
        eventClick: function(calEvent, jsEvent, view) {
            CalendarEventModal.init({
                modalId: "#new-event-modal",
                btnOk: "#modal-ok",
                btnCancel: "#modal-cancel",
                btnRemove: "#modal-remove",
                showRemove: true,
                details: [
                    {
                        selector: "#event-title",
                        value: calEvent.title,
                        key: "title",
                        focus: true
                    },
                    {
                        selector: "#start-date",
                        value: calEvent.start.format(dateFormat),
                        key: "startDate"
                    },
                    {
                        selector: "#end-date",
                        value: calEvent.end.subtract(1, "d").format(dateFormat),
                        key: "endDate"
                    },
                    {
                        selector: "#event-color",
                        value: calEvent.className,
                        key: "className",
                        inputType: "chosen"
                    }
                ],
                done: function (result) {
                    var endDate = result["endDate"] ? moment(result["endDate"], dateFormat) : end;

                    calEvent.title = result["title"];
                    calEvent.start = result["startDate"];
                    calEvent.end = endDate.add(1, "d");
                    calEvent.className = result["className"];

                    //TODO: update event from database with ajax

                    $("#calendar").fullCalendar('updateEvent', calEvent);
                },
                remove: function() {
                    //TODO: remove event from database with ajax
                    $("#calendar").fullCalendar('removeEvents', calEvent._id);
                }
            }).modal();
            //console.log(calEvent);
        },
        defaultDate: moment(), // giving an incorrect date format like '2015-01-1' will cause an issue not to display calendar in firefox, but it works in chrome
        eventLimit: true, // allow "more" link when too many events
        events: "/calendar/events"
    };
    // Initialize calendar
    // -----------------------------------------------------------------
    $("#calendar").fullCalendar($opt);

    // Initialize chosen
    // -----------------------------------------------------------------
    $('#acceptable-clients').chosen({width:'100%'});
    $('#group').chosen({width:'100%'});
    $('#event-color').chosen({width:'100%'});

    // Initailize image slider
    // -----------------------------------------------------------------
    ImageSlider.init('detail-photo-preview-container');

    // Initailize calendar event start and end date picker
    // -----------------------------------------------------------------
    $('#dp-start-date').find(".date").datepicker({autoclose:true, format: 'yyyy-mm-dd', todayHighlight: true});
    $('#dp-end-date').find(".date").datepicker({autoclose:true, format: 'yyyy-mm-dd', todayHighlight: true, todayBtn: "linked"});

    // Initialize click event
    // -----------------------------------------------------------------
    var $servicesPanelGroup = $('#services-panel-group'),
        $serviceCurrencyUl = $servicesPanelGroup.find(".up-currency-dropdown-menu"),
        $unitUl = $servicesPanelGroup.find(".up-unit-dropdown-menu"),
        $optionsPanelGroup = $('#acceptable-opt-panel-group'),
        $optionCurrencyUl = $optionsPanelGroup.find(".up-currency-dropdown-menu"),
        onCurrencyClick = function() {
            var $self = $(this),
                selectedText = $self.data("short-name"),
                selectedSymbol = $self.data("symbol"),
                selectedId = $self.data("id"),
                currencyId = $self.data("currency-id"),
                $inputGrpBtn = $("#input-grp-" + currencyId),
                $hiddeninput = $('#hidden-input-' + currencyId),
                $btnDropDownCurrency = $('#btn-dropdown-' + currencyId),
                currentCurrency = $btnDropDownCurrency.text().trim();

            $btnDropDownCurrency.html($btnDropDownCurrency.html().trim().replace(currentCurrency, selectedText + selectedSymbol));
            $hiddeninput.val(selectedId);

            $self.parent().parent().find("li.active").removeClass("active");
            $self.parent().addClass("active");
            $inputGrpBtn.toggleClass("open");

            return false;
        },
        onUnitClick = function() {
            var $self = $(this),
                selectedText = $self.data("name"),
                selectedId = $self.data("id"),
                unitId = $self.data("unit-id"),
                $inputGrpBtn = $("#input-grp-" + unitId),
                $hiddeninput = $('#hidden-input-' + unitId),
                $btnDropDownCurrency = $('#btn-dropdown-' + unitId),
                currentUnit = $btnDropDownCurrency.text().trim();

            $btnDropDownCurrency.html($btnDropDownCurrency.html().trim().replace(currentUnit, selectedText));
            $hiddeninput.val(selectedId);

            $unitUl.find("li.active").removeClass("active");
            $(this).parent().addClass("active");
            $inputGrpBtn.toggleClass("open");

            return false;
        };

    // currency dropdown click
    $optionCurrencyUl.find("li a").on("click", onCurrencyClick);
    $serviceCurrencyUl.find("li a").on("click", onCurrencyClick);

    // unit dropdown click
    $unitUl.find("li a").on("click", onUnitClick);

    // save button click event - loading overlay
    var $itemSaveBtn = $('.item-save'),
        overlay = function($el, process) {
            var relTime;
            $el.niftyOverlay('show');
            $el.parent().find("a").each(function() {
                $(this).addClass("disabled");
            });

            process($el);

            // Hide the screen overlay
            $el.niftyOverlay('hide');
            $el.parent().find("a").each(function() {
                $(this).removeClass("disabled");
            });

            //relTime = setInterval(function(){
            //    // Hide the screen overlay
            //    $el.niftyOverlay('hide');
            //
            //    clearInterval(relTime);
            //    $el.parent().find("a").each(function() {
            //        $(this).removeClass("disabled");
            //    });
            //}, 1000);
        },
        getItems = function ($itemBody) {
            var items = [];
            $itemBody.find("input[type=checkbox]").each(function(index){
                var $el = $(this),
                    itemId = $el.data("item-id"),
                    prefix = $el.data("prefix"),
                    hasUnit = $el.data("has-unit"),
                    hasDesc = $el.data("has-desc"),
                    unitValue = hasUnit ? $('#' + prefix + "-input-unit-value-" + itemId).val() : null,
                    selectedUnit = hasUnit ? $('#' + prefix + "-input-selected-unit-" + itemId).val() : null,
                    price = $('#' + prefix + "-input-price-" + itemId).val(),
                    selectedCurrency = $('#' + prefix + "-input-selected-currency-" + itemId).val(),
                    desc = hasDesc ? $('#' + prefix + "-textarea-desc-" + itemId).val() : null,
                    optItemName = $('#' + prefix + "-input-opt-item-name-" + itemId).val();

                items[index] = {
                    id: itemId,
                    optItemName: optItemName,
                    unit: {
                        value: unitValue,
                        selected: selectedUnit
                    },
                    price: {
                        value: price,
                        currency: selectedCurrency
                    },
                    desc: desc
                }
            });

            return items;
        };

    // click "Save item" in both service panel and option panel
    $itemSaveBtn.niftyOverlay().on('click', function(){
        var items;

        overlay($(this), function($el) {
            items = getItems($($el.data("item-body")));
        });

        console.log(items);

        //TODO: make an ajax call to server for persisting data

        $.niftyNoty({
            type: "dark",
            container : "floating",
            html : "Successfully saved",
            timer : 3000
        });
    });

    // click "Save services" or "Save options"
    $(".service-save, .option-save").niftyOverlay().on('click', function(){

        overlay($(this), function ($el) {
            var $target = $($el.data("target")),
                itemIdentifier = $el.data("item-identifier"),
                items = [];

            $target.find("." + itemIdentifier + "-item-checkbox").each(function(index){
                var $el = $(this),
                    $itemBody = $($el.data("item-body")),
                    $itemId = $el.data("item-id");

                items[index] = {id: $itemId, items: getItems($itemBody)};
            });

            console.log(items);
            //TODO: make an ajax call to server for persisting data

            $.niftyNoty({
                type: "dark",
                container : "floating",
                html : "Successfully saved",
                timer : 3000
            });
        });
    });
    //end save button click event

    // add and remove click event
    var processAddingItem = function ($el){
            var $itemBody = $($el.data("item-body")),
                expended = $itemBody.parent().hasClass("collapse in"),
                hasChildren = $itemBody.find("input[type=checkbox]").length > 0,
                itemId = $el.data("item-id"),
                itemType = $el.data("item-type"),
                itemTemplate = $el.data("item-template"),
                $firstPanel = $itemBody.find("div.panel:first");

            if (!expended) {
                $el.parent().find(".collapse-expand").trigger("click");
            }

            if (hasChildren) {
                $.get("/empty/item", { itemId: itemId, itemType: itemType, itemTemplate: itemTemplate } )
                    .done(function( data ) {
                        var html = data.trim(),
                            $panel = $(html),
                            $checkboxLabel = $panel.find(".form-checkbox");

                        $panel.find(".up-currency-dropdown-menu li a").on("click", onCurrencyClick);
                        $panel.find(".up-unit-dropdown-menu li a").on("click", onUnitClick);
                        if($checkboxLabel.length) $checkboxLabel.niftyCheck();

                        $panel.addClass(itemType + "-removable-new-item-panel-" + itemId);
                        $firstPanel.before($panel);

                        $("#" + itemType + "-remove-new-item-only-" + itemId).removeClass("hidden");
                    });
            } else {
                console.log("no children");
            }
        },
        processRemovingNewItems = function ($el){
            var itemId = $el.data("item-id"),
                itemType = $el.data("item-type");

            $("." + itemType + "-removable-new-item-panel-" + itemId).remove();
            $el.addClass("hidden");
        },
        processRemovingSelectedItems = function ($el) {
            var $itemBody = $($el.data("item-body")),
                allItems = $itemBody.find("input[type=checkbox]");

            if (allItems.length > 0) {
                var selectedItems = $itemBody.find("input[type=checkbox]:checked"),
                    removingAll = selectedItems.length == allItems.length,
                    expended = $itemBody.parent().hasClass("collapse in"),
                    itemId = $el.data("item-id"),
                    itemType = $el.data("item-type"),
                    emptyInfoMarkup = $el.data("empty-info-markup"),
                    selectedItemIds = [],
                    selectedPanels = [];

                selectedItems.each(function(index) {
                    var $el = $(this),
                        prefix = $el.data("prefix"),
                        itemId = $el.data("item-id");

                    selectedPanels[index] = "#" + prefix + "-panel-" + itemId;
                    selectedItemIds[index] = $(this).data("item-id");
                });

                if (!expended) {
                    $el.parent().find(".collapse-expand").trigger("click");
                }

                $.ajax({
                    method: "DELETE",
                    url: "/items/remove",
                    data: {itemId: itemId, itemType: itemType, subitems: selectedItemIds}
                }).done(function (response) {
                    var $panels = $(selectedPanels.join());

                    console.log(response);

                    $panels.remove();
                    if (removingAll) {
                        $itemBody.append($(emptyInfoMarkup));
                    }
                    // uncomment animation if wanted
                    //$panels.addClass("animated fadeOut");
                    //$panels.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                    //    $panels.remove();
                    //    if (removingAll) {
                    //        $itemBody.append($(emptyInfoMarkup).addClass("animated fadeIn"));
                    //    }
                    //});

                    $.niftyNoty({
                        type: "dark",
                        container : "floating",
                        html : "Successfully removed",
                        timer : 3000
                    });
                });
            } else {
                console.log("no children");
            }
        };

    // click "Add new item"
    $(".item-add").niftyOverlay().on("click", function() {
        overlay($(this), processAddingItem);
    });

    // click "Remove new item only"
    $(".remove-new-item-only").niftyOverlay().on('click', function() {
        overlay($(this), processRemovingNewItems);
    });

    // click "Remove item"
    $(".item-remove").niftyOverlay().on("click", function(){
        overlay($(this), processRemovingSelectedItems);
    });
    // add and remove click event - end

    // click on girl's photo
    $('.profile-img-link').on("click", function() {
        var $el = $(this),
            target = $el.data("target-modal");

        if (target) {
            var $modal = $("#" + target),
                $modalBody = $modal.find(".modal-body"),
                $img = $el.find(".profile-img");

            $modalBody.find("img").attr("src", $img.attr("src"));
            $modal.modal();
        }

        return false;
    });

    // click save calendar
    $("a.save-calendar").on("click", function () {
        var clientEvents = $('#calendar').fullCalendar("clientEvents"),
            events = [];

        $.each(clientEvents, function(index, eventObj) {

            if (eventObj.end) {
                events[index] = {
                    allDay:eventObj.allDay,
                    title: eventObj.title,
                    start: eventObj.start.format(),
                    end: eventObj.end.format(),
                    className: eventObj.className,
                    url: eventObj.url
                };
            } else {
                events[index] = {
                    allDay:eventObj.allDay,
                    title: eventObj.title,
                    start: eventObj.start.format(),
                    className: eventObj.className,
                    url: eventObj.url
                };
            }
        });

        $.ajax({
            method: "POST",
            url: "/calendars/save",
            data: {data: events}
        }).done(function (response) {
            console.log(response);
        });
    });

    // click save profile
    $("a.save-profile").on("click", function () {
        console.log("profile");
    });
});
