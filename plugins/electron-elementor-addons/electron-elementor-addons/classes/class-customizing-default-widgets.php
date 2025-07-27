<?php

namespace Elementor;

if( !defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use Elementor\Core\Base\Module as BaseModule;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Element_Base;
use Elementor\Core\DocumentTypes\PageBase as PageBase;
use Elementor\Modules\Library\Documents\Page as LibraryPageDocument;

class Electron_Customizing_Default_Widgets {
    use Electron_Helper;
    private static $instance = null;

    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new Electron_Customizing_Default_Widgets();
        }
        return self::$instance;
    }

    public function __construct(){
        add_action( 'elementor/element/heading/section_title/after_section_end', [ $this, 'electron_add_transform_to_heading' ] );
        add_action( 'elementor/element/spacer/section_spacer/before_section_end', [ $this, 'electron_add_rotate_to_spacer' ] );
        add_action( 'elementor/element/icon/section_icon/before_section_end', [ $this, 'electron_add_action_to_icon' ] );
        //add_action( 'elementor/element/image/section_image/after_section_end', [ $this, 'electron_add_custom_controls_to_image' ] );
        add_action( 'elementor/frontend/widget/before_render',[ $this, 'electron_add_custom_attr_to_widget' ], 10 );
        //add_action( 'elementor/frontend/widget/after_render',[ $this, 'electron_after_render_widget' ], 10 );
        /*
        $tiltelements = array(
            'image-box' => 'section_image',
        );
        foreach ( $tiltelements as $el => $section ) {
            add_action( 'elementor/element/'.$el.'/'.$section.'/after_section_end', [ $this,'electron_add_tilt_effect_to_element']);
        }
        */

    }

    public function electron_add_action_to_icon( $widget )
    {
        $widget->add_control( 'electron_icon_popup_switcher',
            [
                'label' => esc_html__( 'Enable Popup Action', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-icon-popup icon-has-popup-',
            ]
        );
        $widget->add_control( 'electron_icon_popup_content',
            [
                'label' => esc_html__( 'Select Popup Template', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'default' => '',
                'multiple' => false,
                'options' => $this->electron_get_popup_templates(),
                'condition' => [ 'electron_icon_popup_switcher' => 'yes' ]
            ]
        );
    }
    public function electron_add_rotate_to_spacer( $widget )
    {
        $widget->add_control( 'electron_spacer_rotate',
            [
                'label' => esc_html__( 'Rotate', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 360,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .elementor-widget-container' => '-webkit-transform: rotate({{VALUE}}deg);transform: rotate({{VALUE}}deg);'],
            ]
        );
    }


    public function electron_add_tilt_effect_to_element( $widget )
    {
        $widget->start_controls_section( 'electron_tilt_effect_section',
            [
                'label' => esc_html__( 'Electron Tilt Effect', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $widget->add_control( 'electron_tilt_effect_switcher',
            [
                'label' => esc_html__( 'Enable Tilt Effect', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $widget->add_control( 'electron_tilt_effect_maxtilt',
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
        $widget->add_control( 'electron_tilt_effect_perspective',
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
        $widget->add_control( 'electron_tilt_effect_easing',
            [
                'label' => esc_html__( 'Custom Easing', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'cubic-bezier(.03,.98,.52,.99)',
                'label_block' => true,
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_tilt_effect_scale',
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
        $widget->add_control( 'electron_tilt_effect_speed',
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
        $widget->add_control( 'electron_tilt_effect_transition',
            [
                'label' => esc_html__( 'Transition', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Set a transition on enter/exit.', 'electron' ),
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_tilt_effect_disableaxis',
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
        $widget->add_control( 'electron_tilt_effect_reset',
            [
                'label' => esc_html__( 'Reset', 'electron' ),
                'description' => esc_html__( 'If the tilt effect has to be reset on exit.', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_tilt_effect_glare',
            [
                'label' => esc_html__( 'Glare Effect', 'electron' ),
                'description' => esc_html__( 'Enables glare effect', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_tilt_effect_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_tilt_effect_maxglare',
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
        $widget->add_group_control(
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
        $widget->end_controls_section();
    }

    public function electron_add_transform_to_heading( $widget )
    {
        $widget->start_controls_section( 'heading_css_transform_controls_section',
            [
                'label' => esc_html__( 'Electron CSS Transform', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $widget->add_control( 'heading_css_transform_type',
            [
                'label' => esc_html__( 'Transform Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'translate',
                'options' => [
                    'translate' => esc_html__( 'translate', 'electron' ),
                    'scale' => esc_html__( 'scale', 'electron' ),
                    'rotate' => esc_html__( 'rotate', 'electron' ),
                    'skew' => esc_html__( 'skew', 'electron' ),
                    'custom' => esc_html__( 'custom', 'electron' ),
                ],
                'prefix_class' => 'electron-transform transform-type-',
            ]
        );
        $widget->add_control( 'heading_css_transform_translate_heading',
            [
                'label' => esc_html__( 'Translate', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'heading_css_transform_type' => 'translate' ]
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_translate_xy',
            [
                'label' => esc_html__( 'Translate 2D ( X,Y )', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Xpx,Ypx',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-translate .elementor-heading-title' => 'transform:translate( {{VALUE}} );'],
                'condition' => [ 'heading_css_transform_type' => 'translate' ]
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_translate_xyz',
            [
                'label' => esc_html__( 'Translate 3D ( X,Y,Z )', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Xpx,Ypx,Zpx',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-translate.has-translate-xyz .elementor-heading-title' => 'transform:translate3d( {{VALUE}} );'],
                'prefix_class' => 'has-translate-xyz translate-xyz-',
                'condition' => [ 'heading_css_transform_type' => 'translate' ]
            ]
        );
        // Scale
        $widget->add_control( 'heading_css_transform_scale_heading',
            [
                'label' => esc_html__( 'Scale', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [ 'heading_css_transform_type' => 'scale' ],
                'separator' => 'before'
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_scale_xy',
            [
                'label' => esc_html__( 'Scale 2D ( X,Y )', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Xpx,Ypx',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-translate .elementor-heading-title' => 'transform:scale( {{VALUE}} );'],
                'condition' => [ 'heading_css_transform_type' => 'scale' ]
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_scale_xyz',
            [
                'label' => esc_html__( 'Scale 3D ( X,Y,Z )', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Xpx,Ypx,Zpx',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-scale.has-scale-xyz .elementor-heading-title' => 'transform:scale3d( {{VALUE}} );'],
                'prefix_class' => 'has-scale-xyz scale-xyz-',
                'condition' => [ 'heading_css_transform_type' => 'scale' ]
            ]
        );
        // Rotate
        $widget->add_control( 'heading_css_transform_rotate_heading',
            [
                'label' => esc_html__( 'Rotate', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [ 'heading_css_transform_type' => 'rotate' ],
                'separator' => 'before'
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_rotate_xy',
            [
                'label' => esc_html__( 'Rotate 2D ( X,Y )', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Xdeg,Ydeg',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-rotate .elementor-heading-title' => 'transform:rotate( {{VALUE}} );'],
                'condition' => [ 'heading_css_transform_type' => 'rotate' ]
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_rotate_xyz',
            [
                'label' => esc_html__( 'Rotate 3D ( X,Y,Z )', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '0,0,0',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-rotate.has-rotate-xyz .elementor-heading-title' => 'transform:translate3d( {{VALUE}}deg );'],
                'prefix_class' => 'has-rotate-xyz rotate-xyz-',
                'condition' => [ 'heading_css_transform_type' => 'rotate' ]
            ]
        );
        // Skew
        $widget->add_control( 'heading_css_transform_skew_heading',
            [
                'label' => esc_html__( 'Skew', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'heading_css_transform_type' => 'skew' ]
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_skew_xy',
            [
                'label' => esc_html__( 'Skew 2D ( X,Y )', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Xdeg,Ydeg',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-skew .elementor-heading-title' => 'transform:skew( {{VALUE}} );'],
                'condition' => [ 'heading_css_transform_type' => 'skew' ]
            ]
        );
        // Custom
        $widget->add_control( 'heading_css_transform_custom_heading',
            [
                'label' => esc_html__( 'Custom Transform', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'heading_css_transform_type' => 'custom' ]
            ]
        );
        $widget->add_responsive_control( 'heading_css_transform_custom_xy',
            [
                'label' => esc_html__( 'Transform', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => 'rotate(Xdeg,Ydeg) translate(Xpx,Ypx) scale(X,Y)',
                'selectors' => [ '{{WRAPPER}}.electron-transform.transform-type-custom .elementor-heading-title' => 'transform:( {{VALUE}} );'],
                'condition' => [ 'heading_css_transform_type' => 'custom' ]
            ]
        );
        $widget->end_controls_section();

        $widget->start_controls_section( 'electron_heading_css_stroke_controls_section',
            [
                'label' => esc_html__( 'Electron CSS Stroke', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $widget->add_control( 'electron_heading_css_stroke_switcher',
            [
                'label' => esc_html__( 'Enable Stroke', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-stroke electron-has-stroke-',
            ]
        );
        $widget->add_control( 'electron_heading_css_stroke_type',
            [
                'label' => esc_html__( 'Stroke Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => [
                    'full' => esc_html__( 'Full Text', 'electron' ),
                    'part' => esc_html__( 'Part of Text', 'electron' ),
                ],
                'prefix_class' => 'electron-has-stroke-type stroke-type-',
                'condition' => ['electron_heading_css_stroke_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_heading_css_stroke_note',
            [
                'label' => esc_html__( 'Important Note', 'electron' ),
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__( 'Please add part of text in <b> your text </b>', 'electron' ),
                'content_classes' => 'electron-message',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'electron_heading_css_stroke_switcher',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'electron_heading_css_stroke_type',
                            'operator' => '==',
                            'value' => 'part'
                        ]
                    ]
                ]
            ]
        );
        $widget->add_control( 'electron_heading_css_stroke_width',
            [
                'label' => esc_html__( 'Stroke Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 20,
                'step' => 1,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}}.electron-stroke.stroke-type-full .elementor-heading-title' => '-webkit-text-stroke-width: {{SIZE}}px;color:transparent;',
                    '{{WRAPPER}}.electron-stroke.stroke-type-part .elementor-heading-title b' => '-webkit-text-stroke-width: {{SIZE}}px;color:transparent;',
                ],
                'condition' => ['electron_heading_css_stroke_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_heading_css_stroke_color',
            [
                'label' => esc_html__( 'Stroke Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}}.electron-stroke.stroke-type-full .elementor-heading-title' => '-webkit-text-stroke-color: {{VALUE}};',
                    '{{WRAPPER}}.electron-stroke.stroke-type-part .elementor-heading-title b' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
                'condition' => ['electron_heading_css_stroke_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_heading_css_stroke_fill_color',
            [
                'label' => esc_html__( 'Fill Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'transparent',
                'selectors' => [
                    '{{WRAPPER}}.electron-stroke.stroke-type-full .elementor-heading-title' => '-webkit-text-fill-color: {{VALUE}};',
                    '{{WRAPPER}}.electron-stroke.stroke-type-part .elementor-heading-title b' => '-webkit-text-fill-color: {{VALUE}};',
                ],
                'condition' => ['electron_heading_css_stroke_switcher' => 'yes']
            ]
        );
        $widget->end_controls_section();
        
        $widget->start_controls_section( 'electron_heading_css_marquee_controls_section',
            [
                'label' => esc_html__( 'Electron CSS Marquee', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $widget->add_control( 'electron_heading_css_marquee_switcher',
            [
                'label' => esc_html__( 'Enable Marquee Animation', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-text-marquee electron-has-marquee-',
            ]
        );
        $widget->add_control( 'electron_heading_css_marquee_note',
            [
                'label' => esc_html__( 'Important Note', 'electron' ),
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__( 'Please add part of text in <span> your text </span> <span> your text </span> <span> your text </span>', 'electron' ),
                'content_classes' => 'electron-message',
                'condition' => ['electron_heading_css_marquee_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_heading_css_marquee_speed',
            [
                'label' => esc_html__( 'Animation Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 0.1,
                'default' => 3,
                'selectors' => ['{{WRAPPER}}.electron-text-marquee .elementor-heading-title span' => '-webkit-animation-duration: {{SIZE}}s;animation-duration: {{SIZE}}s;' ],
                'condition' => ['electron_heading_css_marquee_switcher' => 'yes']
            ]
        );
        $widget->end_controls_section();
        
        /*
        $template = basename( get_page_template() );


        $widget->start_controls_section( 'electron_heading_split_controls_section',
            [
                'label' => esc_html__( 'Electron Split Text', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $widget->add_control( 'electron_heading_split_switcher',
            [
                'label' => esc_html__( 'Enable Split', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-headig-split heading-has-split-',
            ]
        );
        $widget->add_control( 'electron_heading_split_type',
            [
                'label' => esc_html__( 'Split Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'chars',
                'options' => [
                    'chars' => esc_html__( 'Chars', 'electron' ),
                    'words' => esc_html__( 'Words', 'electron' ),
                ],
                'condition' => ['electron_heading_split_switcher' => 'yes'],
            ]
        );
        $widget->add_control( 'electron_heading_split_entrance_animation',
            [
                'label' => esc_html__( 'Entrance Animation', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fadeInUp2',
                'options' => [
                    'fadeIn2' => esc_html__( 'fadeIn', 'electron' ),
                    'fadeInUp2' => esc_html__( 'fadeInUp', 'electron' ),
                    'fadeInRight2' => esc_html__( 'fadeInRight', 'electron' ),
                    'fadeInLeft2' => esc_html__( 'fadeInLeft', 'electron' ),
                    'fadeInDown2' => esc_html__( 'fadeInDown', 'electron' ),
                    'bounceIn2' => esc_html__( 'bounceIn', 'electron' ),
                    'bounceInUp2' => esc_html__( 'bounceInUp', 'electron' ),
                    'bounceInRight2' => esc_html__( 'bounceInRight', 'electron' ),
                    'bounceInLeft2' => esc_html__( 'bounceInLeft', 'electron' ),
                    'bounceInDown2' => esc_html__( 'bounceInDown', 'electron' ),
                    'slideIn' => esc_html__( 'slideIn', 'electron' ),
                    'slideInDown' => esc_html__( 'slideInDown', 'electron' ),
                    'slideInUp' => esc_html__( 'slideInUp', 'electron' ),
                    'slideInLeft' => esc_html__( 'slideInLeft', 'electron' ),
                    'slideInRight' => esc_html__( 'slideInRight', 'electron' ),
                    'zoomIn' => esc_html__( 'zoomIn', 'electron' ),
                    'zoomInDown' => esc_html__( 'zoomInDown', 'electron' ),
                    'zoomInUp' => esc_html__( 'zoomInUp', 'electron' ),
                    'zoomInLeft' => esc_html__( 'zoomInLeft', 'electron' ),
                    'zoomInRight' => esc_html__( 'zoomInRight', 'electron' ),
                    'rotateIn' => esc_html__( 'rotateIn', 'electron' ),
                    'rotateInDownRight' => esc_html__( 'rotateInDownRight', 'electron' ),
                    'rotateInUpLeft' => esc_html__( 'rotateInUpLeft', 'electron' ),
                    'rotateInUpRight' => esc_html__( 'rotateInUpRight', 'electron' ),
                ],
                'condition' => ['electron_heading_split_switcher' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title.animated .char' => '-webkit-animation: {{VALUE}} 0.4s cubic-bezier(0.3, 0, 0.7, 1) both; animation: {{VALUE}} 0.4s cubic-bezier(0.3, 0, 0.7, 1) both;',
                    '{{WRAPPER}} .elementor-heading-title.animated .word' => '-webkit-animation: {{VALUE}} 0.4s cubic-bezier(0.3, 0, 0.7, 1) both; animation: {{VALUE}} 0.4s cubic-bezier(0.3, 0, 0.7, 1) both;',
                ]
            ]
        );
        $widget->add_control( 'electron_heading_split_delay',
            [
                'label' => esc_html__( 'Delay', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'step' => 1,
                'default' => 30,
                'description'=> esc_html__( 'the delay is in millisecond', 'electron' ),
                'condition' => ['electron_heading_split_switcher' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title.animated .char' => '-webkit-animation-delay: calc({{VALUE}}ms * var(--char-index)); animation-delay: calc({{VALUE}}ms * var(--char-index));',
                    '{{WRAPPER}} .elementor-heading-title.animated .word' => '-webkit-animation-delay: calc({{VALUE}}ms * var(--word-index)); animation-delay: calc({{VALUE}}ms * var(--word-index));',
                ]
            ]
        );
        $widget->add_control( 'electron_heading_split_space',
            [
                'label' => esc_html__( 'Space Between Word', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 50,
                'step' => 1,
                'default' => 10,
                'condition' => ['electron_heading_split_switcher' => 'yes'],
                'selectors' => ['{{WRAPPER}} .elementor-heading-title.splitting .whitespace' => 'width:{{VALUE}}px;']
            ]
        );

        $widget->end_controls_section();
        */
    }

    public function electron_add_custom_controls_to_image( $widget )
    {
        // parallax image
        $widget->start_controls_section( 'electron_image_parallax_controls_section',
            [
                'label' => esc_html__( 'Electron Parallax', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'image[url]!' => '' ],
            ]
        );
        $widget->add_control( 'electron_image_parallax_switcher',
            [
                'label' => esc_html__( 'Enable Parallax', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-image-parallax image-has-parallax-',
            ]
        );
        $widget->add_control( 'electron_image_parallax_overflow',
            [
                'label' => esc_html__( 'Overflow', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_image_parallax_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_image_parallax_orientation',
            [
                'label' => esc_html__( 'Orientation', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'up',
                'options' => [
                    'up' => esc_html__( 'up', 'electron' ),
                    'right' => esc_html__( 'right', 'electron' ),
                    'down' => esc_html__( 'down', 'electron' ),
                    'left' => esc_html__( 'left', 'electron' ),
                    'up left' => esc_html__( 'up left', 'electron' ),
                    'up right' => esc_html__( 'up right', 'electron' ),
                    'down left' => esc_html__( 'down left', 'electron' ),
                    'left right' => esc_html__( 'left right', 'electron' ),
                ],
                'condition' => ['electron_image_parallax_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_image_parallax_scale',
            [
                'label' => esc_html__( 'Scale', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 0.1,
                'default' => 1.2,
                'description'=> esc_html__( 'need to be above 1.0', 'electron' ),
                'condition' => ['electron_image_parallax_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_image_parallax_delay',
            [
                'label' => esc_html__( 'Delay', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 0.1,
                'default' => 0.4,
                'description'=> esc_html__( 'the delay is in second', 'electron' ),
                'condition' => ['electron_image_parallax_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_image_parallax_maxtransition',
            [
                'label' => esc_html__( 'Max Transition ( % )', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 99,
                'step' => 1,
                'default' => 0,
                'description'=> esc_html__( 'it should be a percentage between 1 and 99', 'electron' ),
                'condition' => ['electron_image_parallax_switcher' => 'yes']
            ]
        );
        $widget->end_controls_section();

        // reveal effects
        $widget->start_controls_section( 'electron_image_reveal_effects_controls_section',
            [
                'label' => esc_html__( 'Reveal Effects', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'image[url]!' => '' ],
            ]
        );
        $widget->add_control( 'electron_image_reveal_switcher',
            [
                'label' => esc_html__( 'Enable Reveal', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'electron-image-reveal image-has-reveal-',
            ]
        );
        $widget->add_control( 'electron_image_reveal_orientation',
            [
                'label' => esc_html__( 'Orientation', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'top' => esc_html__( 'up', 'electron' ),
                    'right' => esc_html__( 'right', 'electron' ),
                    'bottom' => esc_html__( 'down', 'electron' ),
                    'left' => esc_html__( 'left', 'electron' ),
                ],
                'condition' => ['electron_image_reveal_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_image_reveal_delay',
            [
                'label' => esc_html__( 'Delay ( ms )', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10000,
                'step' => 1,
                'default' => '',
                'description' => esc_html__( 'the delay is in second', 'electron' ),
                'condition' => ['electron_image_reveal_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_image_reveal_offset',
            [
                'label' => esc_html__( 'Offset ( px )', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -1000,
                'max' => 1000,
                'step' => 1,
                'default' => '',
                'condition' => ['electron_image_reveal_switcher' => 'yes']
            ]
        );
        $widget->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'electron_image_reveal_color',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .reveal-holder .reveal-block::before',
                'separator' => 'before',
                'condition' => ['electron_image_reveal_switcher' => 'yes']
            ]
        );
        $widget->add_control( 'electron_image_reveal_once',
            [
                'label' => esc_html__( 'Animate Once?', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['electron_image_reveal_switcher' => 'yes']
            ]
        );
        $widget->end_controls_section();
    }

    public function electron_after_render_widget( $widget )
    {
        $tilt_elements_attr = array(
            'image-box',
            'electron-team-member',
            'electron-services-item',
        );
        foreach ( $tilt_elements_attr as $w ) {
            if ( $w === $widget->get_name() && 'yes' === $widget->get_settings('electron_tilt_effect_switcher') ) {
                wp_enqueue_script( 'tilt' );
            }
        }
        if ( 'image' === $widget->get_name() && 'yes' == $widget->get_settings('electron_image_parallax_switcher') ) {
            wp_enqueue_script( 'simple-parallax' );
        }
        if ( 'image' === $widget->get_name() && 'yes' == $widget->get_settings('electron_image_reveal_switcher') ) {
            wp_enqueue_style( 'aos' );
            wp_enqueue_script( 'aos' );
        }
        if ( 'heading' === $widget->get_name() && 'yes' == $widget->get_settings('electron_heading_split_switcher') ) {
            wp_enqueue_style( 'splitting' );
            wp_enqueue_style( 'splitting-cells' );
            wp_enqueue_script( 'splitting' );
            wp_enqueue_script( 'wow' );
        }
        if ( 'electron-woo-taxonomy-list' === $widget->get_name() ) {
            wp_enqueue_style( 'electron-taxonomy-list' );
        }
    }
    public function electron_add_custom_attr_to_widget( $widget )
    {
        $template = basename( get_page_template() );

        if ( 'icon' === $widget->get_name() ) {
            $option_id = $widget->get_settings('electron_icon_popup_content');
            if ( 'yes' === $widget->get_settings('electron_icon_popup_switcher') && !empty( $option_id ) ) {
                $widget->add_render_attribute( '_wrapper', 'data-electron-popup', 'electron-popup-'.$option_id );
            }
        }
        
        if ( 'electron-woo-taxonomy-list' === $widget->get_name() ) {
            //wp_enqueue_style( 'electron-taxonomy-list' );
        }
    }

}
Electron_Customizing_Default_Widgets::get_instance();
