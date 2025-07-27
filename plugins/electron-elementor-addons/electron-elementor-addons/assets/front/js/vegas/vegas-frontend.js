/*=================================*/
/* Section Vegas Slider
/*=================================*/

!(function ($) {

    var NtVegasHandler = function ($scope, $) {
        var target = $scope,
            sectionId = target.data("id"),
            settings = false,
            editMode = elementorFrontend.isEditMode();

        if (editMode) {
            settings = generateEditorSettings(sectionId);
        }

        if (!editMode || !settings) {
            //return false;
        }

        if(settings[1]){
            $('<div id="vegas-js_' + sectionId + '" class="electron-vegas-effect"></div>').prependTo(target);
            generateVegas();
        }

        function generateEditorSettings(targetId) {
            var editorElements = null,
                sectionData = {},
                sectionMultiData = {},
                settings = [];

            if (!window.elementor.hasOwnProperty("elements")) {
                return false;
            }

            editorElements = window.elementor.elements;

            if (!editorElements.models) {
                return false;
            }

            $.each(editorElements.models, function(index, elem) {

                if (targetId == elem.id) {

                    sectionData = elem.attributes.settings.attributes;
                } else if ( elem.id == target.closest(".elementor-top-section").data("id") ) {

                    $.each(elem.attributes.elements.models, function(index, col) {
                        $.each(col.attributes.elements.models, function(index,subSec) {
                            sectionData = subSec.attributes.settings.attributes;
                        });
                    });
                }
            });

            if (!sectionData.hasOwnProperty("electron_vegas_animation_type") || "" == sectionData["electron_vegas_animation_type"]) {
                return false;
            }

            settings.push(sectionData["electron_vegas_switcher"]);  // settings[0]
            settings.push(sectionData["electron_vegas_images"]);    // settings[1]
            settings.push(sectionData["electron_vegas_animation_type"]);      // settings[2]
            settings.push(sectionData["electron_vegas_transition_type"]);     // settings[3]
            settings.push(sectionData["electron_vegas_overlay_type"]);    // settings[4]
            settings.push(sectionData["electron_vegas_delay"]);     // settings[5]
            settings.push(sectionData["electron_vegas_duration"]);   // settings[6]
            settings.push(sectionData["electron_vegas_shuffle"]);   // settings[7]
            settings.push(sectionData["electron_vegas_timer"]);   // settings[8]

            if (0 !== settings.length) {
                return settings;
            }

            return false;
        }

        function generateVegas() {

            var vegas_animation  = settings[2] ? Object.values(settings[2]) : 'kenburns';
            var vegas_transition = settings[3] ? Object.values(settings[3]) : 'slideLeft';
            var vegas_delay      = settings[5] ? settings[5] : 7000;
            var vegas_duration   = settings[6] ? settings[6] : 2000;
            var vegas_shuffle    = 'yes' == settings[7] ? true : false;
            var vegas_timer      = 'yes' == settings[8] ? true : false;
            var vegas_overlay    = 'none' != settings[4] ? true : false;

            var images = [];
            for(i = 0; i<settings[1].length; i++){
                images.push({ src: settings[1][i]['url'] });
            }

            setTimeout(function() {

                if(settings[1].length){
                    $('#vegas-js_' + sectionId).vegas({
                        delay: vegas_delay,
                        timer: vegas_timer,
                        shuffle: vegas_shuffle,
                        animation: vegas_animation,
                        transition: vegas_transition,
                        transitionDuration: vegas_duration,
                        overlay: vegas_overlay,
                        slides: images
                    });
                }
            }, 500);
        }
    }

    // NtVegas Preview function
    function NtVegas() {

        $(".elementor-section[data-vegas-settings]").each(function (i, el) {
            var myVegas = jQuery(el);
            var myVegasId = myVegas.data('vegas-id');
            var myElementType = myVegas.data('element_type');
            if ( myElementType == 'section' ) {

                $('<div id="vegas-js_' + myVegasId + '" class="electron-vegas-effect"></div>').prependTo(myVegas);

                var settings = myVegas.data('vegas-settings');

                if(settings.slides.length) {

                    var vegas_animation  = settings.animation ? settings.animation : 'kenburns';
                    var vegas_transition = settings.transition ? settings.transition : 'slideLeft';
                    var vegas_delay      = settings.delay ? settings.delay : 7000;
                    var vegas_duration   = settings.duration ? settings.duration : 2000;
                    var vegas_shuffle    = 'yes' == settings.shuffle ? true : false;
                    var vegas_timer      = 'yes' == settings.timer ? true : false;
                    var vegas_overlay    = 'none' != settings.overlay ? true : false;

                    $( '#vegas-js_' + myVegasId ).vegas({
                        delay: vegas_delay,
                        timer: vegas_timer,
                        shuffle: vegas_shuffle,
                        animation: vegas_animation,
                        transition: vegas_transition,
                        transitionDuration: vegas_duration,
                        overlay: vegas_overlay,
                       slides: settings.slides
                    });
                }
            }
        });
    }

    jQuery(window).on("elementor/frontend/init", function() {
        var editMode = elementorFrontend.isEditMode();
        if (editMode) {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', NtVegasHandler);
        } else {
            NtVegas();
        }
    });
})(jQuery);
