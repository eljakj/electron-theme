<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Banner_Slider extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-banner-slider';
    }
    public function get_title() {
        return 'Banner Carousel';
    }
    public function get_icon() {
        return 'eicon-slider-push';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_style_depends() {
        return [ 'electron-banner' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'general_section',
            [
                'label'=> esc_html__( 'BANNER', 'electron' ),
                'tab'=> Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'header_display',
            [
                'label' => esc_html__( 'Header Display', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes'
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'category',
            [
                'label' => esc_html__( 'Select Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_cpt_taxonomies('product_cat')
            ]
        );
        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => '']
            ]
        );
        $repeater->add_control( 'mobile_image',
            [
                'label' => esc_html__( 'Mobile Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => '']
            ]
        );
        $repeater->add_control( 'use_video',
            [
                'label' => esc_html__( 'Use Background Video', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );
        $repeater->add_control( 'video_provider',
            [
                'label' => esc_html__( 'Video Source', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__( 'YouTube', 'electron' ),
                    'vimeo' => esc_html__( 'Vimeo', 'electron' ),
                    'local' => esc_html__( 'Local', 'electron' ),
                    'iframe' => esc_html__( 'Custom Iframe Embed', 'electron' ),
                ],
                'condition' => ['use_video' => 'yes']
            ]
        );
        $repeater->add_control( 'iframe_embed',
            [
                'label' => esc_html__( 'Custom Iframe Embed Code', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'video_provider','operator' => '==','value' => 'iframe' ]
                    ]
                ]
            ]
        );
        $repeater->add_control( 'loacal_video_url',
            [
                'label' => esc_html__( 'Loacal Video URL', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'video_provider','operator' => '==','value' => 'local' ]
                    ]
                ]
            ]
        );
        $repeater->add_control( 'video_id',
            [
                'label' => esc_html__( 'Video ID', 'electron' ),
                'placeholder' => '',
                'description' => esc_html__( 'YouTube/Vimeo video ID.', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'video_provider','operator' => '!=','value' => 'iframe' ],
                        [ 'name' => 'video_provider','operator' => '!=','value' => 'local' ]
                    ]
                ]
            ]
        );
        $repeater->add_control( 'video_start',
            [
                'label' => esc_html__( 'Video Start', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10000,
                'step' => 1,
                'default' => '',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'video_provider','operator' => '!=','value' => 'iframe' ]
                    ]
                ]
            ]
        );
        $repeater->add_control( 'video_end',
            [
                'label' => esc_html__( 'Video Start', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10000,
                'step' => 1,
                'default' => '',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'video_provider','operator' => '!=','value' => 'iframe' ]
                    ]
                ]
            ]
        );
        $repeater->add_control( 'auto_calculate',
            [
                'label' => esc_html__( 'Auto Calculate Video Size', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_control( 'aspect_ratio',
            [
                'label' => esc_html__( 'Aspect Ratio', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '16:9' => esc_html__( '16:9 ( Standard Video )', 'electron' ),
                    '9:16' => esc_html__( '9:16 ( for vertical video )', 'electron' ),
                    '1:1' =>esc_html__( '1:1', 'electron' ),
                    '4:3' => esc_html__( '4:3', 'electron' ),
                    '3:2' => esc_html__( '3:2', 'electron' ),
                    '21:9' => esc_html__( '21:9', 'electron' ),
                ],
                'default' => '16:9',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'auto_calculate','operator' => '==','value' => 'yes' ]
                    ]
                ]
            ]
        );
        $repeater->add_responsive_control( 'video_width',
            [
                'label' => esc_html__( 'Custom Video Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4000,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-iframe-wrapper iframe' => 'width:{{SIZE}}px;max-width:none;' ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'auto_calculate','operator' => '!=','value' => 'yes' ]
                    ]
                ]
            ]
        );
        $repeater->add_responsive_control( 'video_height',
            [
                'label' => esc_html__( 'Custom Video Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4000,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-iframe-wrapper iframe' => 'height:{{SIZE}}px;max-width:none;' ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'use_video','operator' => '==','value' => 'yes' ],
                        [ 'name' => 'auto_calculate','operator' => '!=','value' => 'yes' ]
                    ]
                ]
            ]
        );
        $repeater->add_control( 'title',
            [
                'label' => esc_html__( 'Custom Title/Text', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
                'separator' => 'before'
            ]
        );
        $repeater->add_control( 'desc',
            [
                'label' => esc_html__( 'Short Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true
            ]
        );
        $repeater->add_control( 'link',
            [
                'label' => esc_html__( 'Custom Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => ''
                ],
                'show_external' => true
            ]
        );
        $this->add_control('all_cats',
            [
                'label' => esc_html__( 'All Categories', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => "Category - {{{ category }}}",
            ]
        );
        $this->add_responsive_control( 'box_height',
            [
                'label' => esc_html__( 'Box Height', 'electron' ),
                'description' => esc_html__( 'if you are using a background image calculate your height as a percentage ( % ), if you are using a video then calculate it in pixels ( px )', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4000,
                'step' => 1,
                'default' => 100,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .electron-woo-banner-wrapper.has-video' => 'height:{{SIZE}}px;',
                    '{{WRAPPER}} .electron-woo-banner-wrapper.has-image .electron-banner-image' => 'padding-top:{{SIZE}}%;',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'thumbnail',
            ]
        );
        $this->add_control( 'tag',
            [
                'label' => esc_html__( 'Title Tag', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h6',
                'options' => [
                    'h1' => esc_html__( 'H1', 'electron' ),
                    'h2' => esc_html__( 'H2', 'electron' ),
                    'h3' => esc_html__( 'H3', 'electron' ),
                    'h4' => esc_html__( 'H4', 'electron' ),
                    'h5' => esc_html__( 'H5', 'electron' ),
                    'h6' => esc_html__( 'H6', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' )
                ]
            ]
        );
        $this->add_control( 'count_text',
            [
                'label' => esc_html__( 'After Count Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Products',
                'label_block' => true
            ]
        );
        $this->add_control( 'btn_title',
            [
                'label' => esc_html__( 'Button Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'See More Products',
                'label_block' => true
            ]
        );
        $this->add_control( 'icon',
            [
                'label' => esc_html__( 'Button Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ]
            ]
        );
        $this->add_control( 'icon_pos',
            [
                'label' => esc_html__( 'Icon Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => esc_html__( 'Before', 'electron' ),
                    'after' => esc_html__( 'After', 'electron' ),
                ]
            ]
        );
        $this->add_responsive_control( 'icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 30
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-banner-button.has-icon' => 'gap: {{SIZE}}px;' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14
                ]
            ]
        );
        $this->add_responsive_control( 'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-banner-button.has-icon i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .electron-banner-button.has-icon svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16
                ]
            ]
        );
        $this->add_control( 'video_loop',
            [
                'label' => esc_html__( 'Video Loop', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'baner_style',
            [
                'label' => esc_html__( 'Banner Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'multiple' => false,
                'options' => [
                    'card'  => esc_html__( 'Card', 'electron' ),
                    'card-hover'  => esc_html__( 'Card Hover', 'electron' ),
                    'classic' => esc_html__( 'Classic', 'electron' )
                ],
                'default' => 'card'
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'item_order',
            [
                'label' => esc_html__( 'Content Item order', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'multiple' => false,
                'options' => [
                    'cat'  => esc_html__( 'Category', 'electron' ),
                    'title'  => esc_html__( 'Title', 'electron' ),
                    'desc' => esc_html__( 'Description', 'electron' ),
                    'count' => esc_html__( 'Count', 'electron' ),
                    'button' => esc_html__( 'Button', 'electron' ),
                ],
                'default' => 'cat',
            ]
        );
        $repeater->add_control( 'item_position',
            [
                'label' => esc_html__( 'Select Item Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'multiple' => false,
                'options' => [
                    'top'  => esc_html__( 'Top', 'electron' ),
                    'center'  => esc_html__( 'Center', 'electron' ),
                    'bottom' => esc_html__( 'Bottom', 'electron' ),
                ],
                'default' => 'top',
            ]
        );
        $this->add_control('content_orders',
            [
                'label' => esc_html__( 'Content Items Order', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'separator' => 'before',
                'default' => [
                    [
                        'item_order' => 'cat',
                        'item_position' => 'top'
                    ],
                    [
                        'item_order' => 'title',
                        'item_position' => 'top'
                    ],
                ],
                'title_field' => '{{{item_order}}} - {{{item_position}}}',
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'widget_header_section',
            [
                'label' => esc_html__( 'HEADER', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'header_display' => 'yes' ]
            ]
        );
        $this->add_control( 'header_title_divider',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'TITLE', 'electron' ),
            ]
        );
        $this->add_control( 'header_title',
            [
                'label' => esc_html__( 'Header Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Header Title'
            ]
        );
        $this->add_control( 'title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => [
                    'h1' => esc_html__( 'H1', 'electron' ),
                    'h2' => esc_html__( 'H2', 'electron' ),
                    'h3' => esc_html__( 'H3', 'electron' ),
                    'h4' => esc_html__( 'H4', 'electron' ),
                    'h5' => esc_html__( 'H5', 'electron' ),
                    'h6' => esc_html__( 'H6', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' )
                ],
                'condition' => [ 'header_title!' => '' ]
            ]
        );
        $this->add_control( 'header_button_divider',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'separator' => 'before',
            ]
        );
        $this->add_control( 'header_btn_display',
            [
                'label' => esc_html__( 'Button', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'button_title',
            [
                'label' => esc_html__( 'Button Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Button Title',
                'condition' => [ 'header_btn_display' => 'yes' ]
            ]
        );
        $this->add_control( 'link',
            [
                'label' => esc_html__( 'Button Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => ''
                ],
                'show_external' => true,
                'condition' => [ 'header_btn_display' => 'yes' ]
            ]
        );
        $this->add_control( 'add_icon',
            [
                'label' => esc_html__( 'Button Icon', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'header_btn_icon',
            [
                'label' => esc_html__( 'Button Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ],
                'separator' => 'before',
                'condition' => ['header_btn_display' => 'yes','add_icon' => 'yes']
            ]
        );
        $this->add_control( 'header_btn_icon_pos',
            [
                'label' => esc_html__( 'Icon Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => esc_html__( 'Before', 'electron' ),
                    'after' => esc_html__( 'After', 'electron' ),
                ],
                'condition' => [ 'header_btn_display' => 'yes','add_icon' => 'yes' ]
            ]
        );
        $this->add_responsive_control( 'header_btn_icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 30
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-widget-header .electron-btn' => 'gap: {{SIZE}}px;' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14
                ],
                'condition' => [ 'header_btn_display' => 'yes','add_icon' => 'yes' ]
            ]
        );
        $this->add_responsive_control( 'header_btn_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-widget-header .electron-btn i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .electron-widget-header .electron-btn svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16
                ],
                'condition' => [ 'header_btn_display' => 'yes','add_icon' => 'yes' ]
            ]
        );
        $this->add_control( 'bg_type',
            [
                'label' => esc_html__( 'Background Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-bordered',
                'options' => [
                    'electron-bordered' => esc_html__( 'Bordered Transparent', 'electron' ),
                    'electron-solid' => esc_html__( 'Solid BG', 'electron' ),
                    'electron-gradient' => esc_html__( 'Gradient BG', 'electron' ),
                    'electron-btn-text' => esc_html__( 'Simple Text', 'electron' )
                ],
                'condition' => [ 'header_btn_display' => 'yes' ]
            ]
        );
        $this->add_control( 'gradient_type',
            [
                'label' => esc_html__( 'Gradient Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-grad-blue',
                'options' => [
                    'electron-grad-green' => esc_html__( 'Green', 'electron' ),
                    'electron-grad-blue' => esc_html__( 'Blue', 'electron' ),
                    'electron-grad-purple' => esc_html__( 'Purple', 'electron' ),
                    'electron-grad-orange' => esc_html__( 'Orange', 'electron' ),
                    'electron-grad-red' => esc_html__( 'Red', 'electron' ),
                    'electron-grad-dark' => esc_html__( 'Dark', 'electron' ),
                ],
                'condition' => [
                    'bg_type' => 'electron-gradient',
                    'header_btn_display' => 'yes'
                ]
            ]
        );
        $this->add_control( 'color_type',
            [
                'label' => esc_html__( 'Color Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-btn-gray',
                'options' => [
                    'electron-btn-primary' => esc_html__( 'Primary', 'electron' ),
                    'electron-btn-secondary' => esc_html__( 'Secondary', 'electron' ),
                    'electron-btn-success' => esc_html__( 'Success', 'electron' ),
                    'electron-btn-dark' => esc_html__( 'Black', 'electron' ),
                    'electron-btn-dark-soft' => esc_html__( 'Black Soft', 'electron' ),
                    'electron-btn-light' => esc_html__( 'White', 'electron' ),
                    'electron-btn-light-soft' => esc_html__( 'White Soft', 'electron' ),
                    'electron-btn-brown' => esc_html__( 'Brown', 'electron' ),
                    'electron-btn-cream' => esc_html__( 'Cream', 'electron' ),
                    'electron-btn-red' => esc_html__( 'Red', 'electron' ),
                    'electron-btn-red-dark' => esc_html__( 'Red Dark', 'electron' ),
                    'electron-btn-red-soft' => esc_html__( 'Red Soft', 'electron' ),
                    'electron-btn-gray' => esc_html__( 'Gray', 'electron' ),
                    'electron-btn-gray-soft' => esc_html__( 'Gray Soft', 'electron' ),
                    'electron-btn-gray-dark' => esc_html__( 'Gray Dark', 'electron' ),
                    'electron-btn-green' => esc_html__( 'Green', 'electron' ),
                    'electron-btn-green-soft' => esc_html__( 'Green Soft', 'electron' ),
                    'electron-btn-green-bg' => esc_html__( 'Green BG', 'electron' ),
                    'electron-btn-blue' => esc_html__( 'Blue', 'electron' ),
                    'electron-btn-blue-dark' => esc_html__( 'Blue Dark', 'electron' ),
                    'electron-btn-blue-soft' => esc_html__( 'Blue Soft', 'electron' ),
                    'electron-btn-blue-bg' => esc_html__( 'Blue BG', 'electron' ),
                    'electron-btn-purple' => esc_html__( 'Purple', 'electron' ),
                    'electron-btn-purple-soft' => esc_html__( 'Purple Soft', 'electron' ),
                    'electron-btn-purple-bg' => esc_html__( 'Purple BG', 'electron' ),
                    'electron-btn-yellow' => esc_html__( 'Yellow', 'electron' ),
                    'electron-btn-yellow-soft' => esc_html__( 'Yellow Soft', 'electron' ),
                    'electron-btn-yellow-bg' => esc_html__( 'Yellow BG', 'electron' ),
                ],
                'condition' => [
                    'bg_type!' => 'electron-gradient',
                    'header_btn_display' => 'yes'
                ]
            ]
        );
        $this->add_control( 'radius_type',
            [
                'label' => esc_html__( 'Radius Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-radius',
                'options' => [
                    'electron-radius' => esc_html__( 'Radius', 'electron' ),
                    'electron-radius-soft' => esc_html__( 'Radius Soft', 'electron' ),
                    'electron-square' => esc_html__( 'Square', 'electron' ),
                ],
                'condition' => [ 'header_btn_display' => 'yes' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
       /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('slider_options_section',
            [
                'label'=> esc_html__( 'SLIDER OPTIONS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'loop',
            [
                'label' => esc_html__( 'Infinite', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'centermode',
            [
                'label' => esc_html__( 'Center Mode', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Navigation', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'dots',
            [
                'label' => esc_html__( 'Dots', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'space',
            [
                'label' => esc_html__( 'Space Between Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 30
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 10000,
                'step' => 100,
                'default' => 1000
            ]
        );
        $this->add_control( 'mditems',
            [
                'label' => esc_html__( 'Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 8,
                'step' => 1,
                'default' => 5
            ]
        );
        $this->add_control( 'smitems',
            [
                'label' => esc_html__( 'Items Tablet', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'xsitems',
            [
                'label' => esc_html__( 'Items Phone', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 2,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('widget_wrapper_style_section',
            [
                'label' => esc_html__( 'CONTAINER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'header_display' => 'yes' ]
            ]
        );
        $this->add_responsive_control( 'banner_container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-banners-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'banner_container_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-banners-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'banner_container_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-widget-banners-wrapper' => 'background-color: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'banner_container_border',
                'selector' => '{{WRAPPER}} .electron-widget-banners-wrapper'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('widget_header_style_section',
            [
                'label' => esc_html__( 'HEADER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'header_display' => 'yes' ]
            ]
        );
        $this->add_control( 'container_style_heading',
            [
                'label' => esc_html__( 'CONTAINER', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_responsive_control( 'container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'container_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'container_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-widget-header' => 'background-color: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .electron-widget-header'
            ]
        );
        $this->add_control( 'header_title_style_heading',
            [
                'label' => esc_html__( 'TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'header_title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-header-title' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_btn_style_heading',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'header_btn_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-header-button' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_btn_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-header-button:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_btn_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-header-button' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_btn_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-header-button:hover' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'header_btn_border',
                'selector' => '{{WRAPPER}} .electron-header-button'
            ]
        );
        $this->add_control( 'header_btn_hvrbrdcolor',
            [
                'label' => esc_html__( 'Hover Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-header-button:hover' => 'border-color: {{VALUE}};']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label' => esc_html__( 'BANNER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control( 'box_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'box_padding',
            [
                'label' => esc_html__( 'Box Content Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-woo-banner-wrapper .electron-banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .electron-woo-banner-wrapper'
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Box Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-woo-banner-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}']
            ]
        );
        $this->add_responsive_control( 'overlay_color',
            [
                'label' => esc_html__( 'Overlay Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-woo-banner-wrapper:not(.banner-style-classic):before,
                    {{WRAPPER}} .electron-woo-banner-wrapper.banner-style-classic .electron-banner-image:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'overlay_hvrcolor',
            [
                'label' => esc_html__( 'Hover Overlay Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-woo-banner-wrapper:not(.banner-style-classic):hover::before,
                    {{WRAPPER}} .electron-woo-banner-wrapper.banner-style-classic .electron-banner-image:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'text_hvrcolor',
            [
                'label' => esc_html__( 'Hover Text Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper:hover .electron-banner-content .electron-banner-title,{{WRAPPER}} .electron-woo-banner-wrapper:hover .electron-banner-content ' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'image_hvrscale',
            [
                'label' => esc_html__( 'Hover Image Scale', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 2,
                'step' => 0.1,
                'default' => 1.2,
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper:hover .electron-banner-image img' => 'transform: scale( {{SIZE}} );' ],
            ]
        );
        $this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Text Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .electron-woo-banner-wrapper .electron-banner-content' => 'text-align: {{VALUE}};'],
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
                'default' => 'flex-start'
            ]
        );
        $this->add_control( 'cat_divider',
            [
                'label' => esc_html__( 'CATEGORY', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'cat_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-catname' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'cat_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-catname' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-catname'
            ]
        );
        $this->add_responsive_control( 'cat_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-catname' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'cat_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-catname' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'cat_border',
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-catname'
            ]
        );
        $this->add_responsive_control( 'cat_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-catname' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}']
            ]
        );
        $this->add_control( 'catcount_divider',
            [
                'label' => esc_html__( 'CATEGORY COUNT', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'catcount_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-catcount' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'catcount_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-catcount' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'catcount_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-catcount'
            ]
        );
        $this->add_responsive_control( 'catcount_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-catcount' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'catcount_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-catcount' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'catcount_border',
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-catcount'
            ]
        );
        $this->add_responsive_control( 'catcount_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-catcount' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}']
            ]
        );
        $this->add_control( 'title_divider',
            [
                'label' => esc_html__( 'TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-title' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-title'
            ]
        );
        $this->add_responsive_control( 'title_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'title_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'desc_divider',
            [
                'label' => esc_html__( 'DESCRIPTION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-desc' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-desc'
            ]
        );
        $this->add_responsive_control( 'desc_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'desc_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'btn_divider',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'btn_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-button' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'btn_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper:hover .electron-banner-content .electron-banner-button' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'btn_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-button' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'btn_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper:hover .electron-banner-content .electron-banner-button' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-button'
            ]
        );
        $this->add_responsive_control( 'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'btn_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-button'
            ]
        );
        $this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('navs_style_section',
            [
                'label'=> esc_html__( 'SLIDER NAV STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['type' => 'slider','nav' => 'yes']
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
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-container .swiper-button-next:after' => 'font-size:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-container .swiper-button-next:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:hover:after,{{WRAPPER}} .electron-swiper-container .swiper-button-next:hover:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev,{{WRAPPER}} .electron-swiper-container .swiper-button-next' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:hover,{{WRAPPER}} .electron-swiper-container .swiper-button-next:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('dots_style_section',
            [
                'label'=> esc_html__( 'SLIDER DOTS STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['type' => 'slider','dots' => 'yes']
            ]
        );
        $this->add_control( 'dots_top_offset',
            [
                'label' => esc_html__( 'Top Offset', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -300,
                'max' => 300,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-container .swiper-pagination-bullets' => 'margin-top:{{SIZE}}px;' ]
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
                'selectors' => [ '{{WRAPPER}} .electron-swiper-container .swiper-pagination-bullets' => 'text-align:{{VALUE}};' ]
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
    }

    protected function render() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        $editmode = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id: '';
        $size     = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : 'full';

        if ( 'custom' == $size ) {
            $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
            $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
            $size  = [ $sizew, $sizeh ];
        }

        $slider_options = json_encode( array(
                "slidesPerView" => 1,
                "touchRatio"    => 2,
                "loop"          => 'yes' == $settings['loop'] || 'yes' == $settings['centermode'] ? true: false,
                "autoHeight"    => false,
                "rewind"        => true,
                "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                "wrapperClass"  => "electron-swiper-wrapper",
                "centeredSlides"=> 'yes' == $settings['centermode'] ? true: false,
                "speed"         => $settings['speed'],
                "spaceBetween"  => $settings['space'] ? $settings['space'] : 30,
                "direction"     => "horizontal",
                "navigation" => [
                    "nextEl" => ".slide-next-$id",
                    "prevEl" => ".slide-prev-$id"
                ],
                "pagination" => [
                    "el"                => ".electron-pagination-$id",
                    "bulletClass"       => "electron-swiper-bullet",
                    "bulletActiveClass" => "active",
                    "type"              => "bullets",
                    "clickable"         => true
                ],
                "breakpoints" => [
                    "0" => [
                        "slidesPerView"  => $settings['xsitems'],
                        "slidesPerGroup" => $settings['xsitems']
                    ],
                    "768" => [
                        "slidesPerView"  => $settings['smitems'],
                        "slidesPerGroup" => $settings['smitems']
                    ],
                    "1024" => [
                        "freeMode"       => false,
                        "slidesPerView"  => $settings['mditems'],
                        "slidesPerGroup" => $settings['mditems']
                    ]
                ]
            )
        );

        $btn_icon = '';
        $mditems  = $settings['mditems'];

        $icon_pos = !empty( $settings['icon']['value'] ) ? ' has-icon icon-'.$settings['icon_pos'] : '';
        if ( !empty( $settings['icon']['value'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
            $btn_icon = ob_get_clean();
        }

        $html = '';

        if ( 'yes' == $settings['header_display'] ) {
            $html .= '<div class="electron-widget-header">';
                if ( $settings['header_title'] ) {
                    $html .= '<'.$settings['title_tag'].' class="electron-header-title">'.$settings['header_title'].'</'.$settings['title_tag'].'>';
                }
                if ( $settings['button_title'] ) {
                    $btn_attr  = $settings['link']['url'] ? 'href="'.$settings['link']['url'].'"' : 'href="#0"';
                    $btn_attr .= $settings['link']['is_external'] ? ' target="_blank"' : '';
                    $btn_attr .= $settings['link']['nofollow'] ? ' rel="nofollow"' : '';

                    $bclass  = 'electron-btn';
                    $bclass .= 'electron-gradient' == $settings['bg_type'] ? ' '.$settings['gradient_type'] : ' '.$settings['color_type'];
                    $bclass .= ' '.$settings['bg_type'];
                    $bclass .= ' '.$settings['radius_type'];
                    $bclass .= 'yes' == $settings['add_icon'] ? ' has-icon icon-'.$settings['header_btn_icon_pos'] : '';
                    $hicon  = $btn_icon2 = '';

                    if ( 'yes' == $settings['add_icon'] && !empty( $settings['header_btn_icon']['value'] ) ) {
                        ob_start();
                        Icons_Manager::render_icon( $settings['header_btn_icon'], [ 'aria-hidden' => 'true' ] );
                        $btn_icon2 = ob_get_clean();
                    }

                    $hicon = 'yes' == $settings['add_icon'] ? '<svg class="svgRight" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>' : '';
                    $hicon = $btn_icon2 ? $btn_icon2 : $hicon;

                    $html .= '<a class="electron-header-button '.$bclass.'" '.$btn_attr.'>'.$hicon.'<span class="btn-text" data-hover="'.$settings['button_title'].'"></span></a>';
                }
            $html .= '</div>';
        }
        $class = 'electron-products-widget-slider electron-swiper-container electron-swiper-slider'.$editmode.' nav-vertical-centered';
        $html .= '<div class="'.$class.'" data-swiper-options=\''.$slider_options.'\'>';
            $html .= '<div class="electron-swiper-wrapper">';
                foreach ( $settings['all_cats'] as $cat ) {

                    $term   = get_term( $cat['category'], 'product_cat' );
                    $name   = !is_wp_error($term) && !empty( $term ) ? $term->name : '';
                    $count  = !is_wp_error($term) && !empty( $term ) && !empty( $term->count ) ? $term->count : '';
                    $title  = !empty( $cat['title'] ) ? $cat['title'] : '';
                    $desc   = !empty( $cat['desc'] ) ? $cat['desc'] : '';
                    $is_img = $cat['use_video'] == 'yes' ? ' has-video' : ' has-image';
                    $html .= '<div class="electron-slide-item swiper-slide">';

                        $html .= '<div class="electron-woo-banner-wrapper banner-style-'.$settings['baner_style'].$is_img.'">';
                            if ( !empty( $cat['link']['url'] ) ) {
                                $target = !empty( $settings['link']['is_external'] ) ? ' target="_blank"' : '';
                                $rel = !empty( $settings['link']['nofollow'] ) ? ' rel="nofollow"' : '';
                                $html .= '<a class="electron-banner-link" href="'.$cat['link']['url'].'" title="'.$name.'"'.$target.$rel.'></a>';
                            } else {
                                $html .= '<a class="electron-banner-link" href="'.get_category_link( $cat['category'] ).'" title="'.$name.'"></a>';
                            }
                            $count_text = $settings['count_text'] ? ' '.$settings['count_text'] : '';

                            if ( $cat['use_video'] == 'yes' ) {

                                $vid      = $cat['video_id'];
                                $as_ratio = !empty( $cat['aspect_ratio'] ) ? $cat['aspect_ratio'] : '16:9';
                                $provider = !empty( $cat['video_provider'] ) ? $cat['video_provider'] : 'youtube';
                                $start    = !empty( $cat['video_start'] ) ? '&start='.$cat['video_start'] : '';
                                $end      = !empty( $cat['video_end'] ) ? '&end='.$cat['video_end'] : '';
                                $vstart   = !empty( $cat['video_start'] ) ? $cat['video_start'].',' : '';
                                $vend     = !empty( $cat['video_end'] ) ? $cat['video_end'] : '';
                                $vtime    = $vstart || $vend ? '#t='.$vstart.$vend : '';
                                $playlist = $settings['video_loop'] == 'yes' ? 'playlist='.$vid : '';
                                $loop     = $settings['video_loop'] == 'yes' ? 1 : 0;
                                $autocalc = $cat['auto_calculate'] == 'yes' ? ' electron-video-calculate' : '';

                                $html .= '<div class="electron-woo-banner-iframe-wrapper electron-video-'.$provider.$autocalc.'" data-electron-bg-video="'.$vid.'">';
                                    if ( $provider == 'vimeo' && $vid ) {
                                        wp_enqueue_script( 'vimeo-player' );
                                        $html .= '<iframe data-bg-aspect-ratio="'.$as_ratio.'" class="lazy" loading="lazy" data-src="https://player.vimeo.com/video/'.$vid.'?autoplay=1&loop='.$loop.'&title=0&byline=0&portrait=0&sidedock=0&controls=0&playsinline=1&muted=1" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
                                    } elseif ( $provider == 'youtube' && $vid ) {
                                        $html .= '<iframe data-bg-aspect-ratio="'.$as_ratio.'" class="lazy" loading="lazy" data-src="https://www.youtube.com/embed/'.$vid.'?'.$playlist.'&modestbranding=0&rel=0&controls=0&autoplay=1&enablejsapi=1&showinfo=0&mute=1&loop='.$loop.$start.$end.'" allow="autoplay; fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                    } elseif ( $provider == 'iframe' && !empty( $cat['iframe_embed'] ) ) {
                                        echo do_shortcode( $cat['iframe_embed'] );
                                    } elseif ( $provider == 'local' && !empty( $cat['loacal_video_url'] ) ) {
                                        $html .= '<video  data-bg-aspect-ratio="'.$as_ratio.'" class="lazy" controls="0" autoplay="true" loop="true" muted="true" playsinline="true" data-src="'.$cat['loacal_video_url'].$vtime.'"></video>';
                                    }
                                $html .= '</div>';
                            } else {
                                if ( !empty( $cat['image']['id'] ) ) {
                                    $imgId = wp_is_mobile() && !empty( $cat['mobile_image']['id'] ) ? $cat['mobile_image']['id'] : $cat['image']['id'];
                                    $html .= '<div class="electron-banner-image">';
                                        $html .= wp_get_attachment_image( $imgId, $size, false, ['class'=>'electron-category-item-image'] );
                                    $html .= '</div>';
                                }
                            }

                            $html .= '<div class="electron-banner-content">';
                                $html .= '<div class="electron-banner-content-top">';
                                    foreach ( $settings['content_orders'] as $item ) {
                                        if ( $name && $item['item_order'] == 'cat' && $item['item_position'] == 'top' ) {
                                            $html .= '<span class="electron-banner-catname banner-content-item">'.$name.'</span>';
                                        }
                                        if ( $name && $item['item_order'] == 'count' && $item['item_position'] == 'top' ) {
                                            $html .= '<span class="electron-banner-catcount banner-content-item">'.$count.$count_text.'</span>';
                                        }
                                        if ( $title && $item['item_order'] == 'title' && $item['item_position'] == 'top' ) {
                                            $html .= '<'.$settings['tag'].' class="electron-banner-title banner-content-item">'.$title.'</'.$settings['tag'].'>';
                                        }
                                        if ( $desc && $item['item_order'] == 'desc' && $item['item_position'] == 'top' ) {
                                            $html .= '<span class="electron-banner-desc banner-content-item">'.$desc.'</span>';
                                        }
                                        if ( $settings['btn_title'] && $item['item_order'] == 'button' && $item['item_position'] == 'top' ) {
                                            $html .= '<span class="electron-banner-button banner-content-item'.$icon_pos.'"><span class="btn-text">'.$settings['btn_title'].'</span>'.$btn_icon.'</span>';
                                        }
                                    }
                                $html .= '</div>';
                                $html .= '<div class="electron-banner-content-center">';
                                    foreach ( $settings['content_orders'] as $item ) {
                                        if ( $name && $item['item_order'] == 'cat' && $item['item_position'] == 'center' ) {
                                            $html .= '<span class="electron-banner-catname banner-content-item">'.$name.'</span>';
                                        }
                                        if ( $name && $item['item_order'] == 'count' && $item['item_position'] == 'center' ) {
                                            $html .= '<span class="electron-banner-catcount banner-content-item">'.$count.$count_text.'</span>';
                                        }
                                        if ( $title && $item['item_order'] == 'title' && $item['item_position'] == 'center' ) {
                                            $html .= '<'.$settings['tag'].' class="electron-banner-title banner-content-item">'.$title.'</'.$settings['tag'].'>';
                                        }
                                        if ( $desc && $item['item_order'] == 'desc' && $item['item_position'] == 'center' ) {
                                            $html .= '<span class="electron-banner-desc banner-content-item">'.$desc.'</span>';
                                        }
                                        if ( $settings['btn_title'] && $item['item_order'] == 'button' && $item['item_position'] == 'center' ) {
                                            $html .= '<span class="electron-banner-button banner-content-item'.$icon_pos.'"><span class="btn-text">'.$settings['btn_title'].'</span>'.$btn_icon.'</span>';
                                        }
                                    }
                                $html .= '</div>';
                                $html .= '<div class="electron-banner-content-bottom">';
                                    foreach ( $settings['content_orders'] as $item ) {
                                        if ( $name && $item['item_order'] == 'cat' && $item['item_position'] == 'bottom' ) {
                                            $html .= '<span class="electron-banner-catname banner-content-item">'.$name.'</span>';
                                        }
                                        if ( $name && $item['item_order'] == 'count' && $item['item_position'] == 'bottom' ) {
                                            $html .= '<span class="electron-banner-catcount banner-content-item">'.$count.$count_text.'</span>';
                                        }
                                        if ( $title && $item['item_order'] == 'title' && $item['item_position'] == 'bottom' ) {
                                            $html .= '<'.$settings['tag'].' class="electron-banner-title banner-content-item">'.$title.'</'.$settings['tag'].'>';
                                        }
                                        if ( $desc && $item['item_order'] == 'desc' && $item['item_position'] == 'bottom' ) {
                                            $html .= '<span class="electron-banner-desc banner-content-item">'.$desc.'</span>';
                                        }
                                        if ( $settings['btn_title'] && $item['item_order'] == 'button' && $item['item_position'] == 'bottom' ) {
                                            $html .= '<span class="electron-banner-button banner-content-item'.$icon_pos.'"><span class="btn-text">'.$settings['btn_title'].'</span>'.$btn_icon.'</span>';
                                        }
                                    }
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            $html .= '</div>';

            if ( 'yes' == $settings['dots'] ) {
                $html .= '<div class="electron-swiper-pagination electron-pagination-'.$id.' position-relative"></div>';
            }

            if ( 'yes' == $settings['nav'] ) {
                $html .= '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
                $html .= '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
            }
        $html .= '</div>';

        echo '<div class="electron-widget-banners-wrapper">'.$html.'</div>';
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
            <script>
            jQuery( document ).ready( function($) {
                const mySlider = new NTSwiper('.electron-swiper-slider-<?php echo $id; ?>', $('.electron-swiper-slider-<?php echo $id; ?>').data('swiper-options'));
            });
            </script>
            <?php
        }
    }
}
