/**
 * Start interactive tabs widget script
 */

 (function($, elementor) {

    'use strict';

    var widgetInteractiveTabs = function($scope, $) {

        var $slider = $scope.find('.bdt-content-wrap'),
            $tabs   = $scope.find('.bdt-interactive-tabs');

        if (!$slider.length) {
            return;
        }

        var $sliderContainer = $slider.find('.swiper-container'),
            $settings = $slider.data('settings'),
            $swiperId = $($settings.id).find('.swiper-container');

            const Swiper = elementorFrontend.utils.swiper;
            initSwiper();
            async function initSwiper() {
                var swiper = await new Swiper($swiperId, $settings);
                if ($settings.pauseOnHover) {
                    $($sliderContainer).hover(function () {
                        (this).swiper.autoplay.stop();
                    }, function () {
                        (this).swiper.autoplay.start();
                    });
                }
                // start video stop
                var stopVideos = function () {
                    var videos = document.querySelectorAll($settings.id + ' .bdt-i-tabs-iframe');
                    //console.log(videos);
                    Array.prototype.forEach.call(videos, function (video) {
                        var src = video.src;
                        // video.src = src.replace("?autoplay=1", "");
                        // video.src = src.replace("autoplay=1", "");
                        video.src = src;
                    });
                };
                // end video stop

                $tabs.find('.bdt-tabs-item').eq(swiper.realIndex).addClass('bdt-active');
                swiper.on('slideChange', function () {
                    $tabs.find('.bdt-tabs-item').removeClass('bdt-active');
                    $tabs.find('.bdt-tabs-item').eq(swiper.realIndex).addClass('bdt-active');
                    //console.log('changed today'); 


                    stopVideos();



                });

                $tabs.find('.bdt-tabs-wrap .bdt-tabs-item[data-slide]').on('click', function (e) {
                    e.preventDefault();
                    var slideno = $(this).data('slide');
                    swiper.slideTo(slideno + 1);
                });
            };


    };

  


    jQuery(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/bdt-interactive-tabs.default', widgetInteractiveTabs);
    });

}(jQuery, window.elementorFrontend));

/**
 * End interactive tabs widget script
 */

