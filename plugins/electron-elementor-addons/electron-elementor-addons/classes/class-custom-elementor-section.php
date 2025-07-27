<?php

if( !defined( 'ABSPATH' ) ) exit;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Element_Base;
use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Responsive\Responsive;
use Elementor\Widget_Base;
use Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;

class Electron_Section_Parallax {

    private static $instance = null;

    public function __construct(){
        // section register settings
        add_action('elementor/element/section/section_structure/after_section_end',array($this,'lazyload_background_controls'), 10 );
        add_action('elementor/element/container/section_layout_container/after_section_end',array($this,'lazyload_background_controls'), 10 );
        
        add_action('elementor/element/column/layout/after_section_end',array($this,'column_lazyload_background_controls'), 10 );
        
        add_action('elementor/element/section/section_structure/after_section_end',array($this,'section_parallax_controls'), 10 );
        add_action('elementor/element/container/section_layout_container/after_section_end',array($this,'section_parallax_controls'), 10 );
        
        //add_action('elementor/element/section/section_structure/after_section_end',array($this,'electron_add_particle_effect_to_section'), 10 );
        //add_action('elementor/element/container/section_layout_container/after_section_end',array($this,'electron_add_particle_effect_to_section'), 10 );
        
        //add_action('elementor/element/section/section_structure/after_section_end',array($this,'electron_add_vegas_slider_to_section'), 10 );
        //add_action('elementor/element/container/section_layout_container/after_section_end',array($this,'electron_add_vegas_slider_to_section'), 10 );
        
        add_action('elementor/element/section/section_layout/before_section_end',array($this,'register_change_section_indent_structure'), 10 );
        add_action('elementor/element/container/section_layout_container/before_section_end',array($this,'register_change_section_indent_structure'), 10 );
        
        //add_action('elementor/element/section/section_background_overlay/before_section_end',array($this,'register_add_section_overlay_width'), 10 );
        
        //add_action('elementor/frontend/section/before_render',array($this,'electron_custom_attr_to_section'), 10);
        //add_action('elementor/frontend/container/before_render',array($this,'electron_custom_attr_to_section'), 10);
        //add_action('elementor/frontend/column/before_render',array($this,'electron_custom_attr_to_column'), 10);

        // column register settings and before render column functions
        //add_action('elementor/element/column/layout/after_section_end',array($this,'add_tilt_effect_to_column'), 10 );
    }
    /*****   START PARALLAX CONTROLS   ******/
    public function lazyload_background_controls( $element ) {
        
        $element->start_controls_section( 'electron_lazyload_section',
            [
                'label' => esc_html__( 'Electron LazyLoad Background', 'electron' ),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );
        $element->add_responsive_control( 'electron_lazy_bg_image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'electron_lazy_bg',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => ['classic'],
                'exclude' => ['image']
            ]
        );
        $element->end_controls_section();
    }
    public function column_lazyload_background_controls( $element ) {
        
		$is_dome_optimization_active = \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		$main_selector_element = $is_dome_optimization_active ? 'widget' : 'column';
        
        $element->start_controls_section( 'electron_lazyload_section',
            [
                'label' => esc_html__( 'Electron LazyLoad Background', 'electron' ),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );
        $element->add_responsive_control( 'electron_lazy_bg_image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'electron_lazy_bg',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => ['classic'],
                'exclude' => ['image'],
				'selector' => '{{WRAPPER}}:not(.elementor-motion-effects-element-type-background) > .elementor-' . $main_selector_element . '-wrap, {{WRAPPER}} > .elementor-' . $main_selector_element . '-wrap > .elementor-motion-effects-container > .elementor-motion-effects-layer',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
            ]
        );
        $element->end_controls_section();
    }

    /*****   START PARALLAX CONTROLS   ******/
    public function section_parallax_controls( $element ) {
        
        $template = basename( get_page_template() );

        $element->start_controls_section( 'electron_parallax_section',
            [
                'label' => esc_html__( 'Electron Parallax', 'electron' ),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );
        $element->add_control( 'electron_parallax_switcher',
            [
                'label' => esc_html__( 'Enable Parallax', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-parallax jarallax parallax-',
            ]
        );
        $element->add_control( 'electron_parallax_update',
            [
                'label' => '<div class="elementor-update-preview" style="background-color: var(--electron-light);display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">Update changes to pages</div></div>',
                'type' => Controls_Manager::RAW_HTML,
                'condition' => ['electron_parallax_switcher' => 'yes'],
            ]
        );
        $element->add_control( 'electron_parallax_type',
            [
                'label' => esc_html__( 'Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => 'true',
                'condition' => ['electron_parallax_switcher' => 'yes'],
                'default' => 'scroll',
                'options' => [
                    'scroll' => esc_html__( 'Scroll', 'electron' ),
                    'scroll-opacity' => esc_html__( 'Scroll with Opacity', 'electron' ),
                    'opacity' => esc_html__( 'Fade', 'electron' ),
                    'scale' => esc_html__( 'Zoom', 'electron' ),
                    'scale-opacity' => esc_html__( 'Zoom with Fade', 'electron' )
                ]
            ]
        );
        $element->add_control( 'electron_parallax_bg_size',
            [
                'label' => esc_html__( 'Image Size', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'auto',
                'condition' => ['electron_parallax_switcher' => 'yes'],
                'options' => [
                    'auto' => esc_html__( 'Auto', 'electron' ),
                    'cover' => esc_html__( 'Cover', 'electron' ),
                    'contain' => esc_html__( 'Contain', 'electron' )
                ]
            ]
        );
        $element->add_control( 'electron_parallax_speed',
            [
                'label' => esc_html__( 'Parallax Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -1,
                'max' => 2,
                'step' => 0.1,
                'default' => 0.2,
                'condition' => ['electron_parallax_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_parallax_mobile_support',
            [
                'label' => esc_html__( 'Parallax on Mobile Devices', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-mobile-parallax-',
                'condition' => ['electron_parallax_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_add_parallax_video',
            [
                'label' => esc_html__( 'Use Background Video', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-parallax-video-',
                'condition' => ['electron_parallax_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_local_video_format',
            [
                'label' => esc_html__( 'Video Format', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => 'true',
                'default' => 'external',
                'options' => [
                    'external' => esc_html__( 'External (Youtube,Vimeo)', 'electron' ),
                    'mp4' => esc_html__( 'Local MP4', 'electron' ),
                    'webm' => esc_html__( 'Local Webm', 'electron' ),
                    'ogv' => esc_html__( 'Local Ogv', 'electron' ),
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_parallax_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_add_parallax_video',
                            'operator' => '==', // it accepts:  =,==, !=,!==,  in, !in etc.
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_parallax_video_url',
            [
                'label' => esc_html__( 'Video URL', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => 'https://www.youtube.com/watch?v=AeeE6PyU-dQ',
                'description' => esc_html__( 'YouTube/Vimeo link, or link to video file (mp4 is recommended).', 'electron' ),
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_parallax_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_add_parallax_video',
                            'operator' => '==', // it accepts:  =,==, !=,!==,  in, !in etc.
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_parallax_video_start_time',
            [
                'label' => esc_html__( 'Start Time', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'placeholder' => '10',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_parallax_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_add_parallax_video',
                            'operator' => '==', // it accepts:  =,==, !=,!==,  in, !in etc.
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_parallax_video_end_time',
            [
                'label' => esc_html__( 'End Time', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'placeholder' => '70',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_parallax_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_add_parallax_video',
                            'operator' => '==', // it accepts:  =,==, !=,!==,  in, !in etc.
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_parallax_video_volume',
            [
                'label' => esc_html__( 'Video Volume', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'placeholder' => '0',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_parallax_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_add_parallax_video',
                            'operator' => '==', // it accepts:  =,==, !=,!==,  in, !in etc.
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_parallax_video_play_once',
            [
                'label' => esc_html__( 'Play Once', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'electron' ),
                'label_off' => esc_html__( 'No', 'electron' ),
                'return_value' => 'yes',
                'default' => 'no',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_parallax_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_add_parallax_video',
                            'operator' => '==', // it accepts:  =,==, !=,!==,  in, !in etc.
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->end_controls_section();
    }

    /*****   START COLUMN CONTROLS   ******/
    public function add_tilt_effect_to_column( $element ) {
        $element->start_controls_section( 'electron_tilt_effect_section',
            [
                'label' => esc_html__( 'Electron Tilt Effect', 'electron' ),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $element->add_control( 'electron_tilt_effect_switcher',
            [
                'label' => esc_html__( 'Enable Tilt Effect', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'You can use this option if you want to use tilt effect for the elementor heading and image in the column when the mouse is over the column.', 'electron' ),
            ]
        );
        $element->add_control( 'electron_tilt_effect_maxtilt',
            [
                'label' => esc_html__( 'Max Tilt', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'step' => 1,
                'default' => 20,
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_perspective',
            [
                'label' => esc_html__( 'Perspective', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10000,
                'step' => 100,
                'default' => 1000,
                'description' => esc_html__( 'Transform perspective, the lower the more extreme the tilt gets.', 'electron' ),
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_easing',
            [
                'label' => esc_html__( 'Custom Easing', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'cubic-bezier(.03,.98,.52,.99)',
                'label_block' => true,
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_scale',
            [
                'label' => esc_html__( 'Scale', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 1,
                'description' => esc_html__( '2 = 200%, 1.5 = 150%, etc..', 'electron' ),
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_speed',
            [
                'label' => esc_html__( 'Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5000,
                'step' => 10,
                'default' => 300,
                'description' => esc_html__( 'Speed of the enter/exit transition.', 'electron' ),
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_transition',
            [
                'label' => esc_html__( 'Transition', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Set a transition on enter/exit.', 'electron' ),
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_disableaxis',
            [
                'label' => esc_html__( 'Disable Axis', 'electron' ),
                'description' => esc_html__( 'What axis should be disabled. Can be X or Y.', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'None', 'electron' ),
                    'vertical' => esc_html__( 'X Axis', 'electron' ),
                    'horizontal' => esc_html__( 'Y Axis', 'electron' ),
                ],
                'condition' => [ 'electron_tilt_effect_switcher' => 'yes' ],
            ]
        );
        $element->add_control( 'electron_tilt_effect_reset',
            [
                'label' => esc_html__( 'Reset', 'electron' ),
                'description' => esc_html__( 'If the tilt effect has to be reset on exit.', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_glare',
            [
                'label' => esc_html__( 'Glare Effect', 'electron' ),
                'description' => esc_html__( 'Enables glare effect', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_tilt_effect_maxglare',
            [
                'label' => esc_html__( 'Max Glare', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => 1,
                'description' => esc_html__( 'From 0 - 1.', 'electron' ),
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_tilt_effect_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_tilt_effect_glare',
                            'operator' => '==',
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'electron_tilt_effect_glareclr',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .js-tilt-glare-inner',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_tilt_effect_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_tilt_effect_glare',
                            'operator' => '==',
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->end_controls_section();
    }
    /*****   END COLUMN CONTROLS   ******/

    /*****   START CONTROLS SECTION   ******/
    public function register_change_section_indent_structure( $element ) {
        $element->add_control( 'electron_make_fixed_section_switcher',
            [
                'label' => esc_html__( 'Make Fixed On Scroll', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'prefix_class' => 'electron-section-fixed-',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'html_tag',
                            'operator' => '==',
                            'value' => 'nav'
                        ],
                        [
                            'name' => 'html_tag',
                            'operator' => '=',
                            'value' => 'header'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_fixed_section_bgcolor',
            [
                'label' => esc_html__( 'On Scroll BG Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    'body .section-fixed-active{{WRAPPER}}' => 'background-color:{{VALUE}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'html_tag',
                            'operator' => '==',
                            'value' => 'nav'
                        ],
                        [
                            'name' => 'html_tag',
                            'operator' => '=',
                            'value' => 'header'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_fixed_section_heading_color',
            [
                'label' => esc_html__( 'On Scroll Text Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    'body .section-fixed-active{{WRAPPER}} .elementor-widget-wrap .elementor-element .elementor-widget-container .elementor-heading-title' => 'color:{{VALUE}};',
                    'body .section-fixed-active{{WRAPPER}} .elementor-widget-wrap .elementor-element .elementor-widget-container .elementor-icon' => 'color:{{VALUE}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'html_tag',
                            'operator' => '==',
                            'value' => 'nav'
                        ],
                        [
                            'name' => 'html_tag',
                            'operator' => '=',
                            'value' => 'header'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_fixed_section_link_color',
            [
                'label' => esc_html__( 'On Scroll Link Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    'body .section-fixed-active{{WRAPPER}} .elementor-widget-wrap .elementor-element .elementor-widget-container a' => 'color: {{VALUE}} !important;',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'html_tag',
                            'operator' => '==',
                            'value' => 'nav'
                        ],
                        [
                            'name' => 'html_tag',
                            'operator' => '=',
                            'value' => 'header'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_fixed_section_link_hvrcolor',
            [
                'label' => esc_html__( 'On Scroll Link Hover', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    'body .section-fixed-active{{WRAPPER}} .elementor-widget-wrap .elementor-element .elementor-widget-container a:hover' => 'color: {{VALUE}} !important;',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'html_tag',
                            'operator' => '==',
                            'value' => 'nav'
                        ],
                        [
                            'name' => 'html_tag',
                            'operator' => '=',
                            'value' => 'header'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_section_indent',
            [
                'label' => esc_html__( 'Section Indent', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => 'true',
                'default' => '',
                'prefix_class' => 'nt-section ',
                'separator' => 'before',
                'options' => [
                    '' => esc_html__( 'Default', 'electron' ),
                    'section-padding' => esc_html__( 'Indent Top and Bottom', 'electron' ),
                    'section-padding pt-0' => esc_html__( 'Indent Bottom No Top', 'electron' ),
                    'section-padding pb-0' => esc_html__( 'Indent Top No Bottom', 'electron' ),
                ]
            ]
        );
    }


    /*****   START CONTROLS SECTION   ******/
    public function register_add_section_overlay_width( $element )
    {
        $element->add_responsive_control( 'electron_section_overlay_width',
            [
                'label' => esc_html__( 'Electron Overlay Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 4000,
                        'step' => 5
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-background-overlay' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $element->add_responsive_control( 'electron_section_overlay_height',
            [
                'label' => esc_html__( 'Electron Overlay Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 4000,
                        'step' => 5
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-background-overlay' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
    }

    // Registering Controls
    public function electron_add_particle_effect_to_section( $element ) {
        $element->start_controls_section('electron_particles_settings',
            [
                'label' => esc_html__( 'Electron Particles Effect', 'electron' ),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $element->add_control( 'electron_particles_type',
            [
                'label' => esc_html__( 'Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__( 'None', 'electron' ),
                    'default' => esc_html__( 'default', 'electron' ),
                    'nasa' => esc_html__( 'nasa', 'electron' ),
                    'bubble' => esc_html__( 'bubble', 'electron' ),
                    'snow' => esc_html__( 'snow', 'electron' ),
                ]
            ]
        );
        $element->add_control( 'electron_particles_options_heading',
            [
                'label' => esc_html__( 'Particles Options', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['electron_particles_type!' => 'none']
            ]
        );

        $element->add_control( 'electron_particles_shape',
            [
                'label' => esc_html__( 'Shape Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'circle',
                'options' => [
                    'circle' => esc_html__( 'circle', 'electron' ),
                    'edge' => esc_html__( 'edge', 'electron' ),
                    'triangle' => esc_html__( 'triangle', 'electron' ),
                    'polygon' => esc_html__( 'polygon', 'electron' ),
                    'star' => esc_html__( 'star', 'electron' ),
                ],
                'condition' => ['electron_particles_type!' => 'none']
            ]
        );
        $element->add_control( 'electron_particles_number',
            [
                'label' => esc_html__( 'Number', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 60,
                'condition' => ['electron_particles_type!' => 'none']
            ]
        );
        $element->add_control( 'electron_particles_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'condition' => ['electron_particles_type!' => 'none']
            ]
        );
        $element->add_control( 'electron_particles_opacity',
            [
                'label' => esc_html__( 'Opacity', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 1,
                'step' => 0.1,
                'default' => 0.4,
                'condition' => ['electron_particles_type!' => 'none']
            ]
        );
        $element->add_control( 'electron_particles_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 6,
                'condition' => ['electron_particles_type!' => 'none']
            ]
        );
        $element->end_controls_section();
    }

    // Registering Controls
    public function electron_add_vegas_slider_to_section( $element ) {
        $element->start_controls_section('electron_vegas_settings',
            [
                'label' => esc_html__( 'Electron Vegas Slider', 'electron' ),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $element->add_control( 'electron_vegas_switcher',
            [
                'label' => esc_html__( 'Enable Background Slider', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $element->add_control( 'electron_vegas_images',
            [
                'label' => __( 'Add Images', 'electron' ),
                'type' => Controls_Manager::GALLERY,
                'default' => [],
                'condition' => ['electron_vegas_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_vegas_options_heading',
            [
                'label' => esc_html__( 'Slider Options', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['electron_vegas_images!' => '']
            ]
        );
        $element->add_control( 'electron_vegas_animation_type',
            [
                'label' => esc_html__( 'Animation Type', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => ['kenburns'],
                'options' => [
                    'kenburns' => esc_html__( 'kenburns', 'electron' ),
                    'kenburnsUp' => esc_html__( 'kenburnsUp', 'electron' ),
                    'kenburnsDown' => esc_html__( 'kenburnsDown', 'electron' ),
                    'kenburnsLeft' => esc_html__( 'kenburnsLeft', 'electron' ),
                    'kenburnsRight' => esc_html__( 'kenburnsRight', 'electron' ),
                    'kenburnsUpLeft' => esc_html__( 'kenburnsUpLeft', 'electron' ),
                    'kenburnsUpRight' => esc_html__( 'kenburnsUpRight', 'electron' ),
                    'kenburnsDownLeft' => esc_html__( 'kenburnsDownLeft', 'electron' ),
                    'kenburnsDownRight' => esc_html__( 'kenburnsDownRight', 'electron' ),
                ],
                'condition' => ['electron_vegas_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_vegas_transition_type',
            [
                'label' => esc_html__( 'Transition Type', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => ['zoomIn','slideLeft','slideRight'],
                'options' => [
                    'fade' => esc_html__( 'fade', 'electron' ),
                    'fade2' => esc_html__( 'fade2', 'electron' ),
                    'slideLeft' => esc_html__( 'slideLeft', 'electron' ),
                    'slideLeft2' => esc_html__( 'slideLeft2', 'electron' ),
                    'slideRight' => esc_html__( 'slideRight', 'electron' ),
                    'slideRight2' => esc_html__( 'slideRight2', 'electron' ),
                    'slideUp' => esc_html__( 'slideUp', 'electron' ),
                    'slideUp2' => esc_html__( 'slideUp2', 'electron' ),
                    'slideDown' => esc_html__( 'slideDown', 'electron' ),
                    'slideDown2' => esc_html__( 'slideDown2', 'electron' ),
                    'zoomIn' => esc_html__( 'zoomIn', 'electron' ),
                    'zoomIn2' => esc_html__( 'zoomIn2', 'electron' ),
                    'zoomOut' => esc_html__( 'zoomOut', 'electron' ),
                    'zoomOut2' => esc_html__( 'zoomOut2', 'electron' ),
                    'swirlLeft' => esc_html__( 'swirlLeft', 'electron' ),
                    'swirlLeft2' => esc_html__( 'swirlLeft2', 'electron' ),
                    'swirlRight' => esc_html__( 'swirlRight', 'electron' ),
                    'swirlRight2' => esc_html__( 'swirlRight2', 'electron' ),
                    'burn' => esc_html__( 'burn', 'electron' ),
                    'burn2' => esc_html__( 'burn2', 'electron' ),
                    'blur' => esc_html__( 'blur', 'electron' ),
                    'blur2' => esc_html__( 'blur2', 'electron' ),
                    'flash' => esc_html__( 'flash', 'electron' ),
                    'flash2' => esc_html__( 'flash2', 'electron' ),
                ],
                'condition' => ['electron_vegas_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_vegas_overlay_type',
            [
                'label' => esc_html__( 'Overlay Image Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'prefix_class' => 'electron-vegas-overlay vegas-overlay-',
                'options' => [
                    'none' => esc_html__( 'None', 'electron' ),
                    '01' => esc_html__( 'Overlay 1', 'electron' ),
                    '02' => esc_html__( 'Overlay 2', 'electron' ),
                    '03' => esc_html__( 'Overlay 3', 'electron' ),
                    '04' => esc_html__( 'Overlay 4', 'electron' ),
                    '05' => esc_html__( 'Overlay 5', 'electron' ),
                    '06' => esc_html__( 'Overlay 6', 'electron' ),
                    '07' => esc_html__( 'Overlay 7', 'electron' ),
                    '08' => esc_html__( 'Overlay 8', 'electron' ),
                    '09' => esc_html__( 'Overlay 9', 'electron' ),
                ],
                'condition' => ['electron_vegas_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_vegas_delay',
            [
                'label' => esc_html__( 'Delay', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 7000,
                'condition' => ['electron_vegas_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_vegas_duration',
            [
                'label' => esc_html__( 'Transition Duration', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 2000,
                'condition' => ['electron_vegas_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_vegas_shuffle',
            [
                'label' => esc_html__( 'Enable Shuffle', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_vegas_switcher' => 'yes']
            ]
        );
        $element->add_control( 'electron_vegas_timer',
            [
                'label' => esc_html__( 'Enable Timer', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_vegas_switcher' => 'yes'],
                'selectors' => ['{{WRAPPER}} .vegas-timer' => 'display:block!important;'],
            ]
        );
        $element->add_control( 'electron_vegas_timer_size',
            [
                'label' => esc_html__( 'Timer Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 5,
                'selectors' => ['{{WRAPPER}} .vegas-timer' => 'height:{{VALUE}};'],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_vegas_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_vegas_timer',
                            'operator' => '==',
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->add_control( 'electron_vegas_timer_color',
            [
                'label' => esc_html__( 'Timer Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => ['{{WRAPPER}} .vegas-timer-progress' => 'background-color:{{VALUE}};'],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_vegas_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_vegas_timer',
                            'operator' => '==',
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $element->end_controls_section();
    }

    public function electron_custom_attr_to_column( $element ) {
        $data     = $element->get_data();
        $type     = $data['elType'];
        $settings = $data['settings'];
        $isInner  = $data['isInner'];// inner section
        
		$is_dom_optimization_active = \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		$wrapper_attribute_string = $is_dom_optimization_active ? '_widget_wrapper' : '_inner_wrapper';
        
        // Section LazyLoad Bg image
        $wrapper = 'column' === $type ? '_widget_wrapper' : '_wrapper';
        $deskbg = $element->get_settings('electron_lazy_bg_image');

        if ( !empty( $deskbg['url'] ) ) {
            
            $element->add_render_attribute( $wrapper_attribute_string, 'data-bg', $deskbg['url']);
        }
        
        $breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
        if ( !empty( $breakpoints ) ) {
            $breakpoints = array_reverse($breakpoints);
            if ( !empty( $deskbg['url'] ) ) {
                $databg['desktop'] = $deskbg['url'];
            }
            foreach ( $breakpoints as $point ) {
                $label = strtolower( $point->get_label() );
                $resbg = $element->get_settings('electron_lazy_bg_image_'.$label);
                if ( !empty( $resbg['url'] ) ) {
                    $databg[$label] = $resbg['url'];
                }
            }
            if ( !empty( $databg ) ) {
                $element->add_render_attribute( '_widget_wrapper', 'data-bg-responsive', json_encode($databg));
            }
        }
    }

    public function electron_custom_attr_to_section( $element ) {
        $data     = $element->get_data();
        $type     = $data['elType'];
        $settings = $data['settings'];
        $isInner  = $data['isInner'];// inner section

        $template = basename( get_page_template() );

        if ( 'section' === $element->get_name() || 'container' === $type ) {
            // Section LazyLoad Bg image
            $wrapper = 'column' === $type ? ' _widget_wrapper' : '_wrapper';
            $deskbg = $element->get_settings('electron_lazy_bg_image');

            if ( !empty( $deskbg['url'] ) ) {
                $element->add_render_attribute( $wrapper, 'data-bg', $deskbg['url']);
            }
            
            $breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
            if ( !empty( $breakpoints ) ) {
                $breakpoints = array_reverse($breakpoints);
                if ( !empty( $deskbg['url'] ) ) {
                    $databg['desktop'] = $deskbg['url'];
                }
                foreach ( $breakpoints as $point ) {
                    $label = strtolower( $point->get_label() );
                    $resbg = $element->get_settings('electron_lazy_bg_image_'.$label);
                    if ( !empty( $resbg['url'] ) ) {
                        $databg[$label] = $resbg['url'];
                    }
                }
                if ( !empty( $databg ) ) {
                    $element->add_render_attribute( $wrapper, 'data-bg-responsive', json_encode($databg));
                }
            }

            //$gap = $element->get_settings('gap');
            //$element->add_render_attribute( 'wrapper', 'class', $element->get_settings('electron_section_indent') );
            //$element->add_render_attribute( '_wrapper', 'class', 'gap-'.$gap );
            
            /*
            // Particles
            if ( 'none' != $element->get_settings('electron_particles_type') ) {
                wp_enqueue_script( 'particles');
            }
            
            // Vegas Slider Options
            if ( 'yes' === $element->get_settings('electron_vegas_switcher') ) {
                
                wp_enqueue_style( 'vegas');
                wp_enqueue_script( 'vegas');
                
                $delay = $element->get_settings('electron_vegas_delay');
                $duration = $element->get_settings('electron_vegas_duration');
                $timer = $element->get_settings('electron_vegas_timer');
                $shuffle = $element->get_settings('electron_vegas_shuffle');
                $overlay = $element->get_settings('electron_vegas_overlay_type');
                $images = $element->get_settings('electron_vegas_images');

                $transitions = $element->get_settings('electron_vegas_transition_type');
                $transition = array();
                foreach ( $transitions as $trans ) {
                    $transition[] =  '"'.$trans.'"';
                }
                $transition = implode(',', $transition);

                $animations = $element->get_settings('electron_vegas_animation_type');
                $animation = array();
                foreach ( $animations as $anim ) {
                    $animation[] =  '"'.$anim.'"';
                }
                $animation = implode(',', $animation);

                $slides = array();
                foreach ( $images as $image ) {
                    $slides[] =  '{"src":"'.$image['url'].'"}';
                }

                $element->add_render_attribute( '_wrapper', 'data-vegas-settings',  '{"slides":['.implode(',', $slides).'],"animation":['.$animation.'],"transition":['.$transition.'],"delay":'.$delay.',"duration":'.$duration.',"timer":"'.$timer.'","shuffle":"'.$shuffle.'","overlay":"'.$overlay.'"}' );

                $element->add_render_attribute( '_wrapper', 'data-vegas-id', $data['id'] );
            }
            */
            
            // Parallax Effect Options
            if ( 'yes' === $element->get_settings('electron_parallax_switcher')  ) {
                wp_enqueue_script( 'jarallax');
                
                // Parallax attr
                $type   = $element->get_settings('electron_parallax_type');
                $speed  = $element->get_settings('electron_parallax_speed');
                $bgsize = $element->get_settings('electron_parallax_bg_size');
                $mobile = $element->get_settings('electron_parallax_mobile_support');
                $bgimg  = $element->get_settings('background_image');
                $bgimg  = $bgimg['url'];

                if ( 'yes' === $element->get_settings('electron_add_parallax_video') && $element->get_settings('electron_parallax_video_url') ) {

                    if ( 'mp4' === $element->get_settings('electron_local_video_format')) {
                        $videosrc = 'mp4:'.$element->get_settings('electron_parallax_video_url');
                    } elseif ( 'webm' === $element->get_settings('electron_local_video_format')) {
                        $videosrc = 'webm:'.$element->get_settings('electron_parallax_video_url');
                    } elseif ( 'ogv' === $element->get_settings('electron_local_video_format')) {
                        $videosrc = 'ogv:'.$element->get_settings('electron_parallax_video_url');
                    } else {
                        //$settings['background_video_link'] // elementor background video link
                        $videosrc = $element->get_settings('electron_parallax_video_url');
                    }

                    $element->add_render_attribute( '_wrapper', 'data-jarallax data-video-src', $videosrc);

                    if ( $element->get_settings('electron_parallax_video_start_time') ) {
                        $element->add_render_attribute( '_wrapper', 'data-video-start-time', $element->get_settings('electron_parallax_video_start_time'));
                    }
                    if ( $element->get_settings('electron_parallax_video_end_time') ) {
                        $element->add_render_attribute( '_wrapper', 'data-video-end-time', $element->get_settings('electron_parallax_video_end_time'));
                    }
                    if ( 'yes' === $element->get_settings('electron_parallax_video_play_once') ) {
                        $element->add_render_attribute( '_wrapper', 'data-jarallax-video-loop', 'false' );
                    }
                    if ( $element->get_settings('electron_parallax_video_volume') ) {
                        $element->add_render_attribute( '_wrapper', 'data-video-volume', $element->get_settings('electron_parallax_video_volume') );
                    }

                } else {
                    $parallaxattr = '{"type":"'.$type.'","speed":"'.$speed.'","imgsize":"'.$bgsize.'","imgsrc":"'.$bgimg.'","mobile":"'.$mobile.'"}';
                    $element->add_render_attribute( '_wrapper', 'data-electron-parallax', $parallaxattr);
                }
            }

        } // end if section
    }

    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
Electron_Section_Parallax::get_instance();
