$(document).ready( function($) {

    "use strict";

    function electronSlider(el) {

        var self         = $( el ),
            myPSlider    = self,
            myData       = self.data( 'slider-settings' ),
            myInvisible  = self.find( '.elementor-invisible' ),
            myPage       = self.find( '[data-elementor-type="section"]' ),
            mySlide      = myPage.find( '> .e-container' ),
            myWrapper    = self.find( '.swiper-wrapper.electron-template-slider-wrapper' ),
            myElSecId    = myPage.data('data-elementor-id'),
            myPageClass  = myPage.attr( 'class' ),
            myParallaxSlider,
            myVideoMuteYoutube,
            myVideoMuteVimeo,
            myVideoHtml,
            windowWidth  = window.innerWidth;

        var checkVideo = function() {
            if ( self.hasClass('video-unmute') ) {
                myVideoMuteYoutube = 'mute=0';
                myVideoMuteVimeo   = 'muted=0';
                myVideoHtml        = 'muted';
            } else {
                myVideoMuteYoutube = 'mute=1';
                myVideoMuteVimeo   = 'muted=1';
            }

            mySlide.each( function () {
                var $this = $( this );
                $this.addClass( 'swiper-slide onepage-slide-item' ).prependTo( myWrapper );

                $this.find( 'div[data-settings]').each(function () {
                    var $thiss = $( this );
                    var $anim = $thiss.data('settings');

                    if ( typeof $anim._animation != 'undefined' ) {
                       $thiss.removeClass( 'elementor-invisible' );
                    }
                });

                var htmlVideo,
                    video          = $this.data('electron-bg-video'),
                    provider       = video ? video.provider : '',
                    videoId        = video ? video.video_id : '',
                    videoContainer = $this.find('.elementor-background-video-container'),
                    videoEl        = $this.find('.elementor-widget-video'),
                    videoElCont    = videoEl.find('.elementor-video'),
                    vSettings      = videoEl.data('settings'),
                    videoType      = vSettings ? vSettings.video_type : '',
                    videoUrl       = vSettings ? vSettings.youtube_url : '';

                if ( typeof videoEl != 'undefined' ) {
                    if ( 'vimeo' == videoType ) {
                        var videoIDParts = videoUrl.match(/^(?:https?:\/\/)?(?:www|player\.)?(?:vimeo\.com\/)?(?:video\/|external\/)?(\d+)([^.?&#"'>]?)/);
                        htmlVideo = '<iframe class="elementor-background-embed-video vimeo-video" title="vimeo Video Player" src="https://player.vimeo.com/video/'+videoIDParts[1]+'?autoplay=1&loop=1&autopause=0&'+self.myVideoMuteVimeo+'" allow="autoplay; fullscreen" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" data-ready="true" width="640" height="360"></iframe>';
                    }
                    if ( 'youtube' == videoType ) {
                        var videoIDParts = videoUrl.match(/^(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^?&"'>]+)/);
                            htmlVideo    = '<iframe class="elementor-background-embed-video youtube-video" title="youtube Video Player" src="https://www.youtube.com/embed/'+videoIDParts[1]+'?controls=0&rel=0&autoplay=1&playsinline=1&enablejsapi=1&version=3&playerapiid=ytplayer&'+self.myVideoMuteYoutube+'" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" width="640" height="360"></iframe>';
                    }
                    if ( 'hosted' == videoType ) {
                        videoEl.find('video:first-child').remove();
                        htmlVideo = '<video class="elementor-background-video-hosted elementor-html5-video video-hosted" autoplay '+self.myVideoHtml+' playsinline loop src="'+video.video_id+'"></video>';
                    }
                    videoElCont.prepend( htmlVideo );
                }

                if ( typeof videoId != 'undefined') {
                    videoContainer.find('div.elementor-background-video-embed').remove();
                    if ( 'vimeo' == provider ) {
                        htmlVideo = '<iframe class="elementor-background-embed-video vimeo-video" title="vimeo Video Player" src="https://player.vimeo.com/video/'+video.video_id+'?autoplay=1&loop=1&autopause=0&'+self.myVideoMuteVimeo+'" allow="autoplay; fullscreen" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" data-ready="true" width="640" height="360"></iframe>';
                    }
                    if ( 'youtube' == provider ) {
                        htmlVideo = '<iframe class="elementor-background-embed-video youtube-video" title="youtube Video Player" src="https://www.youtube.com/embed/'+video.video_id+'?controls=0&rel=0&autoplay=1&playsinline=1&enablejsapi=1&version=3&playerapiid=ytplayer&'+self.myVideoMuteYoutube+'" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" width="640" height="360"></iframe>';
                    }
                    if ( 'hosted' == provider ) {
                        videoContainer.find('video:first-child').remove();
                        htmlVideo = '<video class="elementor-background-video-hosted elementor-html5-video video-hosted" autoplay '+self.myVideoHtml+' playsinline loop src="'+video.video_id+'"></video>';
                    }
                    videoContainer.prepend( htmlVideo );
                }
            });
        };

        var createSlider = function() {

            self.addClass( myPageClass );

            checkVideo();

            myData["on"] = {
                init: function (swiper) {

                    setTimeout(function(){
                        self.find( '.swiper-slide:not(:first-child)' ).each(function () {

                            var iframe = $( this ).find('iframe');
                            var vid = $( this ).find('.video-hosted');
                            if ( iframe.size() && iframe.hasClass('youtube-video') ) {
                                iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                            }
                            if ( iframe.size() && iframe.hasClass('vimeo-video') ) {
                                iframe[0].contentWindow.postMessage('{"method":"pause"}', '*');
                            }
                            if ( vid.size() ) {
                                vid.get(0).pause();
                            }
                        });
                    }, 2000);
                },
                transitionEnd : function ( swiper ) {
                    var  active = swiper.realIndex;
                    $( '.swiper-slide:not([data-swiper-slide-index="'+active+'"])' ).find( 'div[data-settings]' ).each(function () {
                        var $this    = $( this ),
                            animData = $this.data('settings'),
                            anim     = animData._animation;
                        if ( 'undefined' === typeof animData._animation ) {
                            anim = animData.animation;
                        }

                        $this.addClass( 'elementor-invisible' ).removeClass( 'animated ' + anim );

                    });
                },
                slideChange : function ( swiper ) {
                    var  active = swiper.realIndex;

                    $( '.swiper-slide[data-swiper-slide-index="'+active+'"]' ).find( 'div[data-settings]' ).each(function () {
                        var $this    = $( this ),
                            animData = $this.data( 'settings' ),
                            anim     = animData._animation,
                            delay    = animData._animation_delay;
                        if ( 'undefined' === typeof animData._animation ) {
                            anim = animData.animation;
                        }
                        setTimeout(function() {
                            $this.addClass( 'animated ' + anim ).removeClass( 'elementor-invisible' );
                        }, delay, $this);

                    });

                    $( '.swiper-slide:not(.swiper-slide-active)' ).each(function () {

                        var iframe = $( this ).find('iframe');
                        var vid    = $( this ).find('.video-hosted');
                        if ( iframe.size() && iframe.hasClass('youtube-video') ) {
                            iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                        }
                        if ( iframe.size() && iframe.hasClass('vimeo-video') ) {
                            iframe[0].contentWindow.postMessage('{"method":"pause"}', '*');
                        }
                        if ( vid.size() ) {
                            vid.get(0).pause();
                        }

                    });

                    $( '.swiper-slide-active' ).each(function () {

                        var iframe2 = $( this ).find('iframe');
                        var vid     = $( this ).find('.video-hosted');
                        if ( iframe2.size() && iframe2.hasClass('youtube-video') ) {
                            iframe2[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
                        }
                        if ( iframe2.size() && iframe2.hasClass('vimeo-video') ) {
                            iframe2[0].contentWindow.postMessage('{"method":"play"}', '*');
                        }
                        if ( vid.size() ) {
                            vid.get(0).play();
                        }
                    });

                },
                resize : function (swiper) {
                    swiper.update();
                }
            };
        };

        createSlider();
    }

    $('.slider-home-onepage .swiper-container').each( function() {
        var $this = $(this).attr('id');
        electronSlider('#'+$this);
    });

});
