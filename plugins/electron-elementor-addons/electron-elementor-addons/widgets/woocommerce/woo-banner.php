<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Banner extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-banner';
    }
    public function get_title() {
        return 'Banner';
    }
    public function get_icon() {
        return 'eicon-icon-box';
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
        $this->add_control( 'baner_style',
            [
                'label' => esc_html__( 'Banner Type', 'electron' ),
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
        $this->add_control( 'baner_type',
            [
                'label' => esc_html__( 'Banner Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'multiple' => false,
                'options' => [
                    'style1'  => esc_html__( 'Style 1 - Light', 'electron' ),
                    'style2'  => esc_html__( 'Style 2 - Light Without Padding', 'electron' ),
                    'style3'  => esc_html__( 'Style 3 - BG Gray', 'electron' ),
                    'style4'  => esc_html__( 'Style 4 - Border', 'electron' ),
                    'style5'  => esc_html__( 'Style 5 - BG Primary', 'electron' )
                ],
                'default' => 'style1'
            ]
        );
        $this->add_control( 'baner_radius',
            [
                'label' => esc_html__( 'Banner Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'multiple' => false,
                'options' => [
                    'square'  => esc_html__( 'Square', 'electron' ),
                    'radius-soft'  => esc_html__( 'Radius - Soft', 'electron' ),
                    'radius'  => esc_html__( 'Radius', 'electron' )
                ],
                'default' => 'square'
            ]
        );
        $this->add_control( 'item_link_heading',
            [
                'label' => esc_html__( 'LINK', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'link_type',
            [
                'label' => esc_html__( 'Link Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'cat',
                'options' => [
                    'cat' => esc_html__( 'Product Category', 'electron' ),
                    'tag' => esc_html__( 'Product Tag', 'electron' ),
                    'custom' => esc_html__( 'Curstom link', 'electron' )
                ]
            ]
        );
        $this->add_control( 'category',
            [
                'label' => esc_html__( 'Select Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'condition' => ['link_type' => 'cat']
            ]
        );
        $this->add_control( 'ptag',
            [
                'label' => esc_html__( 'Select Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_cpt_taxonomies('product_tag'),
                'condition' => ['link_type' => 'tag']
            ]
        );
        $this->add_control( 'link',
            [
                'label' => esc_html__( 'Custom Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => ''
                ],
                'show_external' => true,
                'condition' => ['link_type' => 'custom']
            ]
        );
        $this->add_control( 'link_title',
            [
                'label' => esc_html__( 'Category/Link Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Best Products',
                'label_block' => true,
                'condition' => ['link_type' => 'custom']
            ]
        );
        $this->add_control( 'link_aria',
            [
                'label' => esc_html__( 'Link Aria Label (SEO))', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'See More Products',
                'label_block' => true
            ]
        );
        $this->add_control( 'img_bg_type_heading',
            [
                'label' => esc_html__( 'BACKGROUND TYPE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'banner_bg_type',
            [
                'label' => esc_html__( 'Select Bacground Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__( 'Image', 'electron' ),
                    'bg' => esc_html__( 'BG Image/Color', 'electron' ),
                    'youtube' => esc_html__( 'YouTube Video', 'electron' ),
                    'vimeo' => esc_html__( 'Vimeo Video', 'electron' ),
                    'local' => esc_html__( 'Local Video', 'electron' ),
                    'iframe' => esc_html__( 'Custom Iframe Embed', 'electron' )
                ]
            ]
        );
        $this->add_responsive_control( 'fit_size2',
            [
                'label' => esc_html__( 'Min Box Height (px)', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 2000,
                'step' => 1,
                'default' => 200,
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper' => 'min-height:{{SIZE}}px;' ],
                'condition' => ['banner_bg_type' => 'bg']
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-woo-banner-wrapper',
                'condition' => ['banner_bg_type' => 'bg']
            ]
        );
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => ''],
                'condition' => ['banner_bg_type' => 'image']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'thumbnail',
                'condition' => ['banner_bg_type' => 'image']
            ]
        );
        $this->add_control( 'mobile_image',
            [
                'label' => esc_html__( 'Mobile Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => ''],
                'condition' => ['banner_bg_type' => 'image']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'mob_thumbnail',
            'default' => 'woocommerce_thumbnail',
            'condition' => ['banner_bg_type' => 'image']
            ]
        );
        $this->add_responsive_control( 'fit_size',
            [
                'label' => esc_html__( 'Min Image Box Height (px)', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 2000,
                'step' => 1,
                'default' => 200,
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper .electron-banner-image' => 'min-height:{{SIZE}}px;padding-top:0;' ],
                'condition' => ['banner_bg_type' => 'image']
            ]
        );
        $this->add_control('img_bottom_position',
            [
                'label' => esc_html__( 'Image Custom Vertical Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-woo-banner-wrapper .electron-banner-image img' => 'bottom: {{SIZE}}px;top: auto;'],
                'condition' => ['banner_bg_type' => 'image']
            ]
        );
        $this->add_control('img_left_position',
            [
                'label' => esc_html__( 'Image Custom Horizontal Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-woo-banner-wrapper .electron-banner-image img' => 'left: {{SIZE}}px;right: auto;'],
                'condition' => ['banner_bg_type' => 'image']
            ]
        );
        $this->add_control( 'iframe_embed',
            [
                'label' => esc_html__( 'Custom Iframe Embed Code', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
                'condition' => ['banner_bg_type' => 'iframe']
            ]
        );
        $this->add_control( 'loacal_video_url',
            [
                'label' => esc_html__( 'Local Video URL', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
                'condition' => ['banner_bg_type' => 'local']
            ]
        );
        $this->add_control( 'video_id',
            [
                'label' => esc_html__( 'Video ID', 'electron' ),
                'placeholder' => '',
                'description' => esc_html__( 'YouTube/Vimeo video ID.', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [ 'name' => 'banner_bg_type','operator' => '==','value' => 'youtube' ],
                        [ 'name' => 'banner_bg_type','operator' => '==','value' => 'vimeo' ]
                    ]
                ]
            ]
        );
        $this->add_control( 'video_loop',
            [
                'label' => esc_html__( 'Loop', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ]
                    ]
                ]
            ]
        );
        $this->add_control( 'video_start',
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
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ]
                    ]
                ]
            ]
        );
        $this->add_control( 'video_end',
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
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ]
                    ]
                ]
            ]
        );
        $this->add_control( 'auto_calculate',
            [
                'label' => esc_html__( 'Auto Calculate Video Size', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ]
                    ]
                ]
            ]
        );
        $this->add_control( 'aspect_ratio',
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
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ]
                    ]
                ]
            ]
        );
        $this->add_responsive_control( 'video_box_size',
            [
                'label' => esc_html__( 'Video Box Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4000,
                'step' => 1,
                'default' => 100,
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-wrapper' => 'height:{{SIZE}}px;' ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ]
                    ]
                ]
            ]
        );
        $this->add_responsive_control( 'video_width',
            [
                'label' => esc_html__( 'Custom Video Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4000,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-iframe-wrapper iframe,{{WRAPPER}} .electron-woo-banner-iframe-wrapper video' => 'width:{{SIZE}}px;max-width:none;' ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ],
                        [ 'name' => 'auto_calculate','operator' => '!=','value' => 'yes' ]
                    ]
                ]
            ]
        );
        $this->add_responsive_control( 'video_height',
            [
                'label' => esc_html__( 'Custom Video Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4000,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-woo-banner-iframe-wrapper iframe,{{WRAPPER}} .electron-woo-banner-iframe-wrapper video' => 'height:{{SIZE}}px;max-width:none;' ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '!=','value' => 'bg' ],
                        [ 'name' => 'auto_calculate','operator' => '!=','value' => 'yes' ]
                    ]
                ]
            ]
        );
        $this->add_control( 'full_height',
            [
                'label' => esc_html__( 'Full Height', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [ 'name' => 'banner_bg_type','operator' => '==','value' => 'image' ],
                        [ 'name' => 'banner_bg_type','operator' => '==','value' => 'bg' ]
                    ]
                ]
            ]
        );
        $this->add_control( 'banner_text_heading',
            [
                'label' => esc_html__( 'TEXT', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Custom Title/Text', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Free Shipping On Over $199',
                'label_block' => true,
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
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Short Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet',
                'label_block' => true
            ]
        );
        $this->add_control( 'price',
            [
                'label' => esc_html__( 'Price Label', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '$199',
                'label_block' => true
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
        $this->add_control( 'banner_button_heading',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
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
        $this->add_control( 'add_icon',
            [
                'label' => esc_html__( 'Button Icon', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'icon',
            [
                'label' => esc_html__( 'Button Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ],
                'separator' => 'before',
                'condition' => ['add_icon' => 'yes']
            ]
        );
        $this->add_control( 'icon_pos',
            [
                'label' => esc_html__( 'Icon Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => esc_html__( 'Before', 'electron' ),
                    'after' => esc_html__( 'After', 'electron' )
                ],
                'condition' => ['add_icon' => 'yes']
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
                ],
                'condition' => ['add_icon' => 'yes']
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
                ],
                'condition' => ['add_icon' => 'yes']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'item_content_layout_section',
            [
                'label' => esc_html__( 'CONTENT ORDER', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
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
                    'price' => esc_html__( 'Price', 'electron' ),
                    'count' => esc_html__( 'Count', 'electron' ),
                    'button' => esc_html__( 'Button', 'electron' )
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
                    'bottom' => esc_html__( 'Bottom', 'electron' )
                ],
                'default' => 'top'
            ]
        );
        $this->add_control('content_orders',
            [
                'label' => esc_html__( 'Content Items Order', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_order' => 'cat',
                        'item_position' => 'top'
                    ],
                    [
                        'item_order' => 'title',
                        'item_position' => 'top'
                    ],
                    [
                        'item_order' => 'button',
                        'item_position' => 'bottom'
                    ]
                ],
                'title_field' => '{{{item_order}}} - {{{item_position}}}',
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label' => esc_html__( 'STYLE', 'electron' ),
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
                'default' => 'left'
            ]
        );
        $this->add_control( 'cat_divider',
            [
                'label' => esc_html__( 'CATEGORY', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'bg_type',
            [
                'label' => esc_html__( 'Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'label-trans',
                'options' => [
                    'label-trans' => esc_html__( 'Transparent', 'electron' ),
                    'label-border' => esc_html__( 'Bordered', 'electron' ),
                    'label-solid' => esc_html__( 'Solid', 'electron' ),
                ]
            ]
        );
        $this->add_control( 'color_type',
            [
                'label' => esc_html__( 'Color Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-label-yellow',
                'options' => [
                    'electron-label-primary' => esc_html__( 'Primary', 'electron' ),
                    'electron-label-dark' => esc_html__( 'Black', 'electron' ),
                    'electron-label-gray' => esc_html__( 'Gray', 'electron' ),
                    'electron-label-gray-soft' => esc_html__( 'Gray Soft', 'electron' ),
                    'electron-label-green' => esc_html__( 'Green', 'electron' ),
                    'electron-label-green-soft' => esc_html__( 'Green Soft', 'electron' ),
                    'electron-label-brown' => esc_html__( 'Brown', 'electron' ),
                    'electron-label-red' => esc_html__( 'Red', 'electron' ),
                    'electron-label-blue' => esc_html__( 'Blue', 'electron' ),
                    'electron-label-blue-dark' => esc_html__( 'Blue Dark', 'electron' ),
                    'electron-label-blue-soft' => esc_html__( 'Blue Soft', 'electron' ),
                    'electron-label-purple' => esc_html__( 'Purple', 'electron' ),
                    'electron-label-purple-soft' => esc_html__( 'Purple Soft', 'electron' ),
                    'electron-label-yellow' => esc_html__( 'Yellow', 'electron' ),
                    'electron-label-yellow-soft' => esc_html__( 'Yellow Soft', 'electron' )
                ]
            ]
        );
        $this->add_control( 'radius_type',
            [
                'label' => esc_html__( 'Radius Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'label-square',
                'options' => [
                    'label-radius' => esc_html__( 'Radius', 'electron' ),
                    'label-square' => esc_html__( 'Square', 'electron' ),
                ]
            ]
        );
        $this->add_control( 'size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'label-small',
                'options' => [
                    'label-large' => esc_html__( 'Large', 'electron' ),
                    'label-medium' => esc_html__( 'Medium', 'electron' ),
                    'label-small' => esc_html__( 'Small', 'electron' )
                ]
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
        $this->add_control( 'price_divider',
            [
                'label' => esc_html__( 'PRICE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'price_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-price' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'price_color',
            [
                'label' => esc_html__( 'Price Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-content .electron-banner-price' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'price_border',
                'selector' => '{{WRAPPER}} .electron-banner-content .electron-banner-price'
            ]
        );
        $this->add_responsive_control( 'price_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}']
            ]
        );
        $this->add_responsive_control( 'price_padding',
            [
                'label' => esc_html__( 'Button Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
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
        $this->add_responsive_control( 'btn_padding',
            [
                'label' => esc_html__( 'Button Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    public function item_order($col) {

        $settings = $this->get_settings_for_display();

        $html = $name = $count = $btn_icon = '';

        $count_text = $settings['count_text'] ? ' '.$settings['count_text'] : '';
        $type       = $settings['link_type'];
        $icon_pos   = 'yes' == $settings['add_icon'] ? ' has-icon icon-'.$settings['icon_pos'] : '';

        if ( 'yes' == $settings['add_icon'] && !empty( $settings['icon']['value'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
            $btn_icon = ob_get_clean();
        }

        $hicon = 'yes' == $settings['add_icon'] ? '<svg class="svgRight" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>' : '';
        $hicon = $btn_icon ? $btn_icon : $hicon;

        if ( 'custom' == $type && $settings['link_title'] ) {

            $name = $settings['link_title'];

        } elseif ( 'cat' == $type && !empty( $settings['category'] ) ) {

            $term  = get_term( $settings['category'], 'product_cat' );
            $name  = !empty( $term ) && !is_wp_error($term) ? $term->name : '';
            $count = !empty( $term ) && !is_wp_error($term) ? $term->count : '';

        } elseif ( 'tag' == $type && !empty( $settings['ptag'] ) ) {

            $term  = get_term( $settings['ptag'], 'product_tag' );
            $name  = !empty( $term ) && !is_wp_error($term) ? $term->name : '';
            $count = !empty( $term ) && !is_wp_error($term) ? $term->count : '';
        }

        $label_class = $settings['bg_type'].' '.$settings['radius_type'].' '.$settings['size'].' '.$settings['color_type'];

        foreach (  $settings['content_orders'] as $item ) {
            if ( $name && $item['item_order'] == 'cat' && $item['item_position'] == $col ) {
                $html .= '<span class="electron-banner-catname banner-content-item electron-widget-label '.$label_class.'">'.$name.'</span>';
            }
            if ( $name && $item['item_order'] == 'count' && $item['item_position'] == $col ) {
                $html .= '<span class="electron-banner-catcount banner-content-item">'.$count.$count_text.'</span>';
            }
            if ( $settings['title'] && $item['item_order'] == 'title' && $item['item_position'] == $col ) {
                $html .= '<'.$settings['tag'].' class="electron-banner-title banner-content-item">'.$settings['title'].'</'.$settings['tag'].'>';
            }
            if ( $settings['desc'] && $item['item_order'] == 'desc' && $item['item_position'] == $col ) {
                $html .= '<span class="electron-banner-desc banner-content-item">'.$settings['desc'].'</span>';
            }
            if ( $settings['price'] && $item['item_order'] == 'price' && $item['item_position'] == $col ) {
                $html .= '<span class="electron-banner-price banner-content-item">'.$settings['price'].'</span>';
            }
            if ( $settings['btn_title'] && $item['item_order'] == 'button' && $item['item_position'] == $col ) {

                $html .= '<span class="electron-banner-button banner-content-item'.$icon_pos.'"><span class="btn-text" data-hover="'.$settings['btn_title'].'"></span>'.$hicon.'</span>';
            }
        }

        return $html ? '<div class="electron-banner-content-'.$col.'">'.$html.'</div>' : '';
    }

    protected function render() {

        if ( ! class_exists('WooCommerce') ) {
            return;
        }

        $settings  = $this->get_settings_for_display();

        $html = '';

        if ( 'custom' == $settings['link_type'] && !empty( $settings['link']['url'] ) ) {

            $link  = ' href="'.$settings['link']['url'].'"';
            $link .= !empty( $settings['link']['is_external'] ) ? ' target="_blank"' : '';
            $link .= !empty( $settings['link']['nofollow'] ) ? ' rel="nofollow"' : '';
            $link .= $settings['link_aria'] ? ' title="'.$settings['link_aria'].'"' : '';

            $html .= '<a class="electron-banner-link"'.$link.'></a>';

        } elseif ( 'cat' == $settings['link_type'] && !empty( $settings['category'] ) ) {

            $link  = ' href="'.get_category_link( $settings['category'] ).'"';
            $link .= $settings['link_aria'] ? ' title="'.$settings['link_aria'].'"' : '';

            $html .= '<a class="electron-banner-link"'.$link.'></a>';

        } elseif ( 'tag' == $settings['link_type'] && !empty( $settings['ptag'] ) ) {

            $link  = ' href="'.get_category_link( $settings['ptag'] ).'"';
            $link .= $settings['link_aria'] ? ' title="'.$settings['link_aria'].'"' : '';

            $html .= '<a class="electron-banner-link"'.$link.'></a>';
        }


        $bg = $settings['banner_bg_type'];

        $class  = ' type-'.$bg;
        $class .= ' banner-style-'.$settings['baner_style'];
        $class .= ' banner-'.$settings['baner_type'];
        $class .= ' banner-'.$settings['baner_radius'];
        $class .= $settings['full_height'] ? ' full-height' : '';

        if ( $bg == 'image' && !empty( $settings['image']['id'] ) ) {

            $size  = wp_is_mobile() ? 'mob_thumbnail' : 'thumbnail';
            $imgId = wp_is_mobile() && !empty( $settings['mobile_image']['id'] ) ? 'mobile_image' : 'image';
            $html .= '<div class="electron-banner-image">';
                $html .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, $size, $imgId );
            $html .= '</div>';

        } elseif ( $bg == 'bg' ) {
            $html .= '';
        } else {

            $vid      = $settings['video_id'];
            $as_ratio = $settings['aspect_ratio'] ? $settings['aspect_ratio'] : '16:9';
            $start    = $settings['video_start'] ? '&start='.$settings['video_start'] : '';
            $end      = $settings['video_end'] ? '&end='.$settings['video_end'] : '';
            $vstart   = $settings['video_start'] ? $settings['video_start'].',' : '';
            $vend     = $settings['video_end'] ? $settings['video_end'] : '';
            $vtime    = $vstart || $vend ? '#t='.$vstart.$vend : '';
            $playlist = $settings['video_loop'] ? 'playlist='.$vid : '';
            $loop     = $settings['video_loop'] ? 1 : 0;
            $autocalc = $settings['auto_calculate'] == 'yes' ? ' electron-video-calculate' : '';

            $html .= '<div class="electron-woo-banner-iframe-wrapper electron-video-'.$bg.$autocalc.'" data-electron-bg-video="'.$vid.'">';

                if ( $bg == 'vimeo' && $vid ) {

                    $html .= '<iframe data-bg-aspect-ratio="'.$as_ratio.'" class="lazy" loading="lazy" src="https://player.vimeo.com/video/'.$vid.'?autoplay=1&loop='.$loop.'&title=0&byline=0&portrait=0&sidedock=0&controls=0&playsinline=1&muted=1" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';

                } elseif ( $bg == 'youtube' && $vid ) {

                    $html .= '<iframe data-bg-aspect-ratio="'.$as_ratio.'" class="lazy" loading="lazy" src="https://www.youtube.com/embed/'.$vid.'?'.$playlist.'&modestbranding=0&rel=0&controls=0&autoplay=1&enablejsapi=1&showinfo=0&mute=1&loop='.$loop.$start.$end.'" allow="autoplay; fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

                } elseif ( $bg == 'iframe' && $settings['iframe_embed'] ) {

                    echo do_shortcode( $settings['iframe_embed'] );

                } elseif ( $bg == 'local' && $settings['loacal_video_url'] ) {

                    $html .= '<video data-bg-aspect-ratio="'.$as_ratio.'" class="lazy" loading="lazy" controls="0" autoplay="true" loop="true" muted="true" playsinline="true" src="'.$settings['loacal_video_url'].$vtime.'"></video>';
                }

            $html .= '</div>';
        }

        $has_cols  = '' == $this->item_order('top') && '' == $this->item_order('bottom')  && $this->item_order('center') ? ' has-center' : '';
        $has_cols .= '' == $this->item_order('top') && '' == $this->item_order('center') && $this->item_order('bottom') ? ' has-bottom' : '';
        $html .= '<div class="electron-banner-content'.$has_cols.'">';
            $html .= $this->item_order('top');
            $html .= $this->item_order('center');
            $html .= $this->item_order('bottom');
        $html .= '</div>';

        // final output html
        echo '<div class="electron-woo-banner-wrapper'.$class.'">'.$html.'</div>';
    }
}
