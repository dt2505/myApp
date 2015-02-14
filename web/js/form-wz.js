$(document).ready(function() {
    $regwz = $('#reg-wz');

    // upload avatar and cover
    $("#btn-upload-avatar").on("click", function() {
        $("#avatar").trigger("click");
    });

    $("#btn-upload-cover").on("click", function() {
        $("#cover").trigger("click");
    });

    // skip step
    $regwz.find(".skip").on("click", function() {
        $('#reg-wz').find('.next').trigger("click");
    });

    $regwz.bootstrapWizard({
        tabClass: 'wz-steps',
        nextSelector: '.next',
        previousSelector: '.previous',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onInit : function(){
            $('#reg-wz').find('.finish').hide().prop('disabled', true);
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = (index/$total) * 100;
            var margin = (100/$total)/2;
            $regwz.find('.progress-bar').css({width:$percent+'%', 'margin': 0 + 'px ' + margin + '%'});

            navigation.find('li:eq('+index+') a').trigger('focus');


            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $regwz.find('.next').hide();
                $regwz.find('.finish').show();
                $regwz.find('.finish').prop('disabled', false);
                $regwz.find('.skip').hide();
            } else {
                $regwz.find('.next').show();
                $regwz.find('.skip').show();
                $regwz.find('.finish').hide().prop('disabled', true);
            }
        },
        onNext: function(){
        }
    });
});
