$(document).ready(function() {
    // Calendar
    // =================================================================
    // Require Full Calendar
    // -----------------------------------------------------------------
    // http://fullcalendar.io/
    // =================================================================

    // initialize the external events
    // -----------------------------------------------------------------
    //$('#demo-external-events .fc-event').each(function() {
    //    // store data so the calendar knows to render an event upon drop
    //    $(this).data('event', {
    //        title: $.trim($(this).text()), // use the element's text as the event title
    //        stick: true, // maintain when user navigates (see docs on the renderEvent method)
    //        className : $(this).data('class')
    //    });
    //
    //
    //    // make the event draggable using jQuery UI
    //    $(this).draggable({ // this requires jquery-ui.custom.min.js
    //        zIndex: 99999,
    //        revert: true,      // will cause the event to go back to its
    //        revertDuration: 0  //  original position after the drag
    //    });
    //});

    var $opt = {
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        dayClick: function(date, jsEvent, view) {

            alert('Clicked on: ' + date.format());

            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

            alert('Current view: ' + view.name);

            // change the day's background color just for fun
            $(this).css('background-color', 'red');
        },
        eventClick: function(calEvent, jsEvent, view) {

            alert('Event: ' + calEvent.title);
            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            alert('View: ' + view.name);

            // change the border color just for fun
            $(this).css('border-color', 'red');

        },
        defaultDate: '2015-02-01', // giving an incorrect date format like '2015-01-1' will cause an issue not to display calendar in firefox, but it works in chrome
        eventLimit: true, // allow "more" link when too many events
        events: [
            {
                title: 'Happy Hour',
                start: '2015-01-05',
                end: '2015-01-07',
                className: 'purple'
            },
            {
                title: 'Birthday Party',
                start: '2015-01-15',
                end: '2015-01-17',
                className: 'mint'
            },
            {
                title: 'All Day Event',
                start: '2015-01-15',
                className: 'warning'
            },
            {
                title: 'Meeting',
                start: '2015-01-20T10:30:00',
                end: '2015-01-20T12:30:00',
                className: 'danger'
            },
            {
                title: 'All Day Event',
                start: '2015-02-01',
                className: 'warning'
            },
            {
                title: 'Long Event',
                start: '2015-02-07',
                end: '2015-02-10',
                className: 'purple'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2015-02-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2015-02-16T16:00:00',
                className: 'success'
            },
            {
                title: 'Conference',
                start: '2015-02-11',
                end: '2015-02-13',
                className: 'dark'
            },
            {
                title: 'Meeting',
                start: '2015-02-12T10:30:00',
                end: '2015-02-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2015-02-12T12:00:00',
                className: 'pink'
            },
            {
                title: 'Meeting',
                start: '2015-02-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2015-02-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2015-02-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2015-02-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2015-02-28'
            }
        ]
    };

    // Initialize the calendar
    // -----------------------------------------------------------------
    $('#calendar').fullCalendar($opt);

    // Initialize chosen
    // -----------------------------------------------------------------
    $('#acceptable-clients').chosen({width:'100%'});

    // Initailize image slider
    // -----------------------------------------------------------------
    ImageSlider.init('detail-photo-preview-container');

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
        };

    // currency dropdown click
    $optionCurrencyUl.find("li a").on("click", onCurrencyClick);
    $serviceCurrencyUl.find("li a").on("click", onCurrencyClick);

    // unit dropdown click
    $unitUl.find("li a").on("click", function(){
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
    });

    // save btn click - loading overlay
    var $itemSaveBtn = $('.item-save'),
        overlay = function($el, process) {
            var relTime;
            $el.niftyOverlay('show');

            process($el);

            relTime = setInterval(function(){
                // Hide the screen overlay
                $el.niftyOverlay('hide');

                clearInterval(relTime);
            }, 2000);
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
                    desc = hasDesc ? $('#' + prefix + "-textarea-desc-" + itemId).val() : null;

                items[index] = {
                    id: itemId,
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

    // save item details(services and options)
    $itemSaveBtn.niftyOverlay().on('click', function(){
        var items;

        overlay($(this), function($el) {
            items = getItems($($el.data("item-body")));
        });

        console.log(items);
        //TODO: make an ajax call to server for persisting data
    });

    // save all services and options
    $(".service-save, .option-save").niftyOverlay().on('click', function(){

        overlay($(this), function ($el) {
            var $target = $($el.data("target")),
                itemIdentifier = $el.data("item-identifier"),
                items = [];

            $target.find("." + itemIdentifier + "-item-checkbox").each(function(index){
                var $el = $(this),
                    $itemBody = $($el.data("item-body")),
                    $itemId = $el.data("item-id"),
                    $itemName = $el.data("item-name");

                items[index] = {id: $itemId, name: $itemName, items: getItems($itemBody)};
            });

            console.log(items);
            //TODO: make an ajax call to server for persisting data
        });
    });
});
