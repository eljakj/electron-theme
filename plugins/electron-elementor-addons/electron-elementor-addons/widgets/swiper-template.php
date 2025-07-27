<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Template_Slider extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-template-slider';
    }
    public function get_title() {
        return 'Template Slider';
    }
    public function get_icon() {
        return 'eicon-slider-push';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   END CONTROLS SECTION   ******/
        $this->start_controls_section( 'home_slider_content_section',
            [
                'label' => esc_html__( 'Content', 'wavo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'content',
            [
                'label' => esc_html__( 'Content', 'elementories' ),
                'type' => Controls_Manager::SELECT2,
                'default' => '',
                'multiple' => false,
                'options' => $this->electron_get_elementor_templates()
            ]
        );
        $this->add_responsive_control( 'content_maxwidth',
            [
                'label' => esc_html__( 'Slide Item Container Max Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4000,
                'step' => 1,
                'default' => 1140,
                'selectors' => [ '{{WRAPPER}} .elementor-section.swiper-slide>.elementor-container' => 'max-width:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'bg_video_mute',
            [
                'label' => esc_html__( 'Background Video Sound?', 'wavo' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        $this->start_controls_section( 'home_slider_section',
            [
                'label' => esc_html__( 'Slider Options', 'wavo' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'wavo' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5000,
                'step' => 100,
                'default' => 1000,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'dots',
            [
                'label' => esc_html__( 'Dots', 'wavo' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Navigation', 'wavo' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'mousewheel',
            [
                'label' => esc_html__( 'Mousewheel', 'wavo' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'wavo' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'loop',
            [
                'label' => esc_html__( 'Loop', 'wavo' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('dots_style_section',
            [
                'label'=> esc_html__( 'SLIDER DOTS STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'dots' => 'yes' ]
            ]
        );
        $this->add_control( 'dots_top_offset',
            [
                'label' => esc_html__( 'Bottom Offset', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-theme-style .swiper-pagination-bullets' => 'bottom:{{SIZE}}px;' ]
            ]
        );
        $this->add_responsive_control( 'dots_alignment',
            [
                'label' => esc_html__( 'Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-h-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-h-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-h-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-theme-style .swiper-pagination-bullets' => 'text-align:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'dots_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet:before' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'dots_space',
            [
                'label' => esc_html__( 'Space', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet + .swiper-pagination-bullet' => 'margin: 0;margin-left: {{SIZE}}px;',
                    '{{WRAPPER}} .swiper-pagination-horizontal.swiper-pagination-bullets .swiper-pagination-bullet + .swiper-pagination-bullet' => 'margin: 0;margin-left: {{SIZE}}px;',
                ]
            ]
        );
        $this->start_controls_tabs( 'dots_nav_tabs');
        $this->start_controls_tab( 'dots_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'electron' ) ]
        );
        $this->add_control( 'dots_bgcolor',
            [
                'label' => esc_html__( 'Background', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet',
            ]
        );
        $this->add_responsive_control( 'dots_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet:before,{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'dots_hover_tab',
            [ 'label' => esc_html__( 'Active', 'electron' ) ]
        );
        $this->add_control( 'dots_hvrbgcolor',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_hvrborder',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active'
            ]
        );
        $this->add_responsive_control( 'dots_hvrborder_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active:before,{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('navs_style_section',
            [
                'label'=> esc_html__( 'SLIDER NAV STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'nav' => 'yes' ]
            ]
        );
        $this->add_control( 'navs_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:after' => 'font-size:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:hover:after,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:hover:after' => 'color:{{VALUE}};' ]
            ]
        );

        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $id = $this->get_id();

        $speed      = $settings['speed'] ? $settings['speed'] : 1000;
        $loop       = 'yes' == $settings['loop'] ? 'true' : 'false';
        $autoplay   = 'yes' == $settings['autoplay'] ? 'true' : 'false';
        //$parallax   = 'yes' == $settings['parallax'] ? 'true' : 'false';
        $mousewheel = 'yes' == $settings['mousewheel'] ? 'true' : 'false';
        $is_edit    = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id : '';
        $slider_options = json_encode( array(
            "slidesPerView"  => 1,
            "loop"           => 'yes' == $settings['loop'] ? true: false,
            "autoplay"       => 'yes' == $settings['autoplay'] ? true: false,
            "mousewheel"     => 'yes' == $settings['mousewheel'] ? true: false,
            "releaseOnEdges" =>  true,
            "allowTouchMove" =>  true,
            "touchRatio"     =>  2,
            //"watchSlidesVisibility" =>  true,
            "speed"         => $settings['speed'],
            "spaceBetween"  => 0,
            "direction"     => "horizontal",
            "navigation" => [
                "nextEl" => ".electron-swiper-theme-style .slide-next-{$id}",
                "prevEl" => ".electron-swiper-theme-style .slide-prev-{$id}"
            ],
            "pagination" => [
                "el" => ".electron-swiper-theme-style .electron-pagination-$id",
                "type" => "bullets",
                "clickable" => true
            ]
        ));

        echo '<div class="slider-home-onepage'.$is_edit.' electron-swiper-theme-style electron-swiper-onepage-style">';
            echo '<div id="slider-'.$id.'" class="swiper-container parallax-slider-two" data-slider-settings=\''.$slider_options.'\'>';
                echo '<div class="swiper-wrapper electron-template-slider-wrapper">';
                    if ( !empty( $settings[ 'content' ] ) && isset($settings[ 'content' ]) != '' ) {
                        $template = $settings[ 'content' ];
                        $content = new Frontend;
                        $css = ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) ? true : false;
                        echo $content->get_builder_content_for_display( $template, false );
                    }
                echo '</div>';
                if ( 'yes' == $settings[ 'dots' ] ) {
                    echo '<div class="swiper-pagination electron-swiper-pagination electron-pagination-'.$id.'"></div>';
                }
                if ( 'yes' == $settings['nav'] ) {
                    if ( is_rtl() ) {
                        echo '<div class="swiper-button-next slide-next-'.$id.'"></div>';
                        echo '<div class="swiper-button-prev slide-prev-'.$id.'"></div>';
                    } else {
                        echo '<div class="swiper-button-prev slide-prev-'.$id.'"></div>';
                        echo '<div class="swiper-button-next slide-next-'.$id.'"></div>';
                    }
                }
            echo '</div>';
        echo '</div>';
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
            <script>
            jQuery( document ).ready( function($) {
                electronSlider('.slider-home-onepage-<?php echo $id ?> .swiper-container');

                function electronSlider(el) {

                    var self         = $( el ),
                        myPSlider    = self,
                        myInvisible  = self.find( '.elementor-invisible' ),
                        mySlide      = self.find( '.elementor-top-section' ),
                        myWrapper    = self.find( '.swiper-wrapper.electron-template-slider-wrapper' ),
                        myPage       = self.find( '[data-elementor-type="section"]' ),
                        myElSecId    = myPage.data('data-elementor-id'),
                        myPageClass  = myPage.attr( 'class' ),
                        myData       = self.data( 'slider-settings' ),
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
                            $this.addClass( 'swiper-slide' ).prependTo( myWrapper );

                            $this.find( 'div[data-settings]').each(function () {
                                var $thiss = $( this );
                                var $anim = $thiss.data('settings');

                                if ( $anim._animation.length ) {
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

                            if ( videoEl.length ) {
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

                            if ( videoId.length ) {
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

                        myPage.remove();

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
                        myParallaxSlider = new NTSwiper( el, myData );

                    };

                    createSlider();
                }
            });
            </script>
            <?php
        }

    }
}
