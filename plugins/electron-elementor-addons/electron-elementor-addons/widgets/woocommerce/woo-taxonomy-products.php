<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Taxonomy_Products extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-taxonomy-products';
    }
    public function get_title() {
        return 'Products By Category';
    }
    public function get_icon() {
        return 'eicon-post-list';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'cat', 'wc', 'woo', 'product', 'list', 'tax' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'general_settings',
            [
                'label' => esc_html__('TAXONOMY LIST', 'electron'),
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
        $this->add_control( 'style',
            [
                'label' => esc_html__( 'Taxonomy List Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'electron' ),
                    'style-2' => esc_html__( 'Style 2', 'electron' ),
                    'style-3' => esc_html__( 'Style 3', 'electron' ),
                    'style-4' => esc_html__( 'Style 4', 'electron' )
                ]
            ]
        );
        $this->add_control( 'taxonomy',
            [
                'label' => esc_html__( 'Taxonomy', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'cat',
                'options' => [
                    'cat'   => esc_html__( 'Product Category', 'electron' ),
                    'tag'   => esc_html__( 'Product Tag', 'electron' ),
                    'brand' => esc_html__( 'Product Brands', 'electron' ),
                ]
            ]
        );
        $this->add_control( 'cats',
            [
                'label' => esc_html__( 'Select Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s) to Exclude',
                'condition' => ['taxonomy' => 'cat']
            ]
        );
        $this->add_control( 'tags',
            [
                'label' => esc_html__( 'Select Tag', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_tag'),
                'description' => 'Select Tag(s) to Exclude',
                'condition' => ['taxonomy' => 'tag']
            ]
        );
        $electronOptions = get_option('electron');
        $brands1 = taxonomy_exists('electron_product_brands') ? $this->electron_cpt_taxonomies('electron_product_brands') : array();
        $brands2 = taxonomy_exists('product_brand') ? $this->electron_cpt_taxonomies('product_brand') : array();
        $brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == 'yes' ? $brands1 : $brands2;
        $this->add_control( 'brands',
            [
                'label' => esc_html__( 'Select Brand', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $brandsTax,
                'description' => 'Select Brand(s) to Exclude',
                'condition' => ['taxonomy' => 'brand']
            ]
        );
        $this->add_control( 'filter_type',
            [
                'label' => esc_html__( 'Taxonomy Filter Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'include',
                'options' => [
                    'include' => esc_html__( 'Include', 'electron' ),
                    'exclude' => esc_html__( 'Exclude', 'electron' )
                ]
            ]
        );
        $this->add_control( 'order',
            [
                'label' => esc_html__( 'Select Order', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'electron' ),
                    'DESC' => esc_html__( 'Descending', 'electron' )
                ],
                'default' => 'ASC'
            ]
        );
        $this->add_control( 'orderby',
            [
                'label' => esc_html__( 'Order By', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'id' => esc_html__( 'Post ID', 'electron' ),
                    'menu_order' => esc_html__( 'Menu Order', 'electron' ),
                    'rand' => esc_html__( 'Random', 'electron' ),
                    'date' => esc_html__( 'Date', 'electron' ),
                    'title' => esc_html__( 'Title', 'electron' ),
                ],
                'default' => 'id',
            ]
        );
        $this->add_responsive_control('min_width',
            [
                'label' => __( 'Container Min Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-taxonomy-list' => 'min-width: {{SIZE}}px;']
            ]
        );
        $this->add_responsive_control('min_height',
            [
                'label' => __( 'List Item Min Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .taxonomy-item' => 'min-height: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'show_image',
            [
                'label' => esc_html__( 'Image Display', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes'
            ]
        );
        $this->add_control( 'img_type',
            [
                'label' => esc_html__( 'Image Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'thumb',
                'options' => [
                    'thumb' => esc_html__( 'Thumbnail', 'electron' ),
                    'img'   => esc_html__( 'Custom Image', 'electron' ),
                    'icon'  => esc_html__( 'Custom Icon', 'electron' ),
                ],
                'condition' => ['show_image' => 'yes']
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'icon',
            [
                'label' => esc_html__( 'Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ]
            ]
        );
        $repeater->add_control( 'icon_color2',
            [
                'label' => esc_html__( 'Custom Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.taxonomy-item i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.taxonomy-item svg' => 'fill: {{VALUE}};'
                ],
                'default' => '',
            ]
        );
        $this->add_control( 'icons',
            [
                'label' => esc_html__( 'Add Icons', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '#Icon',
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
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
                    '{{WRAPPER}} .taxonomy-item i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .taxonomy-item svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35
                ],
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
            ]
        );
        $this->add_control( 'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-item i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .taxonomy-item svg' => 'fill: {{VALUE}};'
                ],
                'default' => '',
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
            ]
        );
        $this->add_control( 'icon_hvrcolor',
            [
                'label' => esc_html__( 'Hover Icon Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-item:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .taxonomy-item:hover svg' => 'fill: {{VALUE}};'
                ],
                'default' => '',
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
            ]
        );
        $repeater2 = new Repeater();
        $repeater2->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $this->add_control( 'images',
            [
                'label' => esc_html__( 'Add Images', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater2->get_controls(),
                'title_field' => '#Image',
                'condition' => [ 'show_image' => 'yes','img_type' => 'img' ]
            ]
        );
        $this->add_responsive_control( 'image_size',
            [
                'label' => esc_html__( 'Image Max Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 200
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .taxonomy-thumb img' => 'max-width: {{SIZE}}px;'],
                'default' => [],
                'condition' => ['show_image' => 'yes','img_type!' => 'icon']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'thumbnail',
                'condition' => ['show_image' => 'yes']
            ]
        );
        $this->add_control( 'count',
            [
                'label' => esc_html__( 'Taxonomy Item Count', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Taxonomy Item Description', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'desc_position',
            [
                'label' => esc_html__( 'Description Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'top' => esc_html__( 'Top', 'electron' ),
                    'bottom' => esc_html__( 'Bottom', 'electron' ),
                    'right'   => esc_html__( 'Right', 'electron' ),
                    'left'  => esc_html__( 'Left', 'electron' ),
                ],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->add_responsive_control( 'desc_size',
            [
                'label' => esc_html__( 'Description Max Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-taxonomy-list .taxonomy-details' => 'max-width: {{SIZE}}px;'],
                'default' => [],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'products_layout_section',
            [
                'label'=> esc_html__( 'PRODUCTS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grid' => esc_html__( 'Grid', 'electron' ),
                    'slider' => esc_html__( 'Slider', 'electron' ),
                ],
                'default' => 'slider'
            ]
        );
        $this->add_control( 'grid_style',
            [
                'label' => esc_html__( 'Product Grid Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-default' => esc_html__( 'Bordered inside', 'electron' ),
                    'style-border-outside' => esc_html__( 'Bordered outside', 'electron' ),
                    'style-boxshadow' => esc_html__( 'Box shadow', 'electron' ),
                    'style-bgcolor' => esc_html__( 'Background color', 'electron' ),
                    'style-bgcolor-outside' => esc_html__( 'Background color outside', 'electron' ),
                ],
                'default' => 'style-default'
            ]
        );
        $this->add_control( 'limit',
            [
                'label' => esc_html__( 'Posts Per Page', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 20
            ]
        );
        $this->add_control( 'order2',
            [
                'label' => esc_html__( 'Select Order', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'electron' ),
                    'DESC' => esc_html__( 'Descending', 'electron' )
                ],
                'default' => 'DESC'
            ]
        );
        $this->add_control( 'orderby2',
            [
                'label' => esc_html__( 'Order By', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'id' => esc_html__( 'Post ID', 'electron' ),
                    'menu_order' => esc_html__( 'Menu Order', 'electron' ),
                    'rand' => esc_html__( 'Random', 'electron' ),
                    'date' => esc_html__( 'Date', 'electron' ),
                    'title' => esc_html__( 'Title', 'electron' ),
                ],
                'default' => 'id',
            ]
        );
        $this->add_control( 'paginate',
            [
                'label' => esc_html__( 'Pagination', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail2',
                'default' => 'woocommerce_thumbnail'
            ]
        );
        $this->add_control( 'mob_img_size_heading',
            [
                'label' => esc_html__( 'Mobile Image Size', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'mob_thumbnail2',
            'default' => 'woocommerce_thumbnail'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'taxonomy_style_section',
            [
                'label'=> esc_html__( 'TAXONOMY LIST STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'bg_color',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-item' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'bg_hvrcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-item:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'brd_color',
            [
                'label' => esc_html__( 'Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-taxonomy-list' => 'border-color:{{VALUE}};',
                    '{{WRAPPER}} .taxonomy-item + .taxonomy-item' => 'border-top-color:{{VALUE}};',
                ]
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-title' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'title_hvrcolor',
            [
                'label' => esc_html__( 'Hover Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-item:hover .taxonomy-title' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'count_bgcolor',
            [
                'label' => esc_html__( 'Count Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-count' => 'background-color:{{VALUE}};' ],
                'condition' => ['count' => 'yes']
            ]
        );
        $this->add_control( 'count_color',
            [
                'label' => esc_html__( 'Count Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-count' => 'color:{{VALUE}};' ],
                'condition' => ['count' => 'yes']
            ]
        );
        $this->add_control( 'desc_bgcolor',
            [
                'label' => esc_html__( 'Description Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details' => 'background-color:{{VALUE}};',
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details:before' => 'background-color:{{VALUE}};'
                ],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->add_control( 'desc_brdcolor',
            [
                'label' => esc_html__( 'Description Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details' => 'border-color:{{VALUE}};',
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details:before' => 'border-color:{{VALUE}};'
                ],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-desc' => 'color:{{VALUE}};' ],
                'condition' => ['desc' => 'yes']
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
        $this->add_control( 'mobcentermode',
            [
                'label' => esc_html__( 'Mobile Center Mode', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [ 'centermode' => 'yes' ]
            ]
        );
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Navigation', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
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
                'label' => esc_html__( 'Gap', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 10
            ]
        );
        $this->add_control( 'mobspace',
            [
                'label' => esc_html__( 'Mobile Gap', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 10
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
                'max' => 12,
                'step' => 1,
                'default' => 4
            ]
        );
        $this->add_control( 'smitems',
            [
                'label' => esc_html__( 'Items Tablet', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 8,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'xsitems',
            [
                'label' => esc_html__( 'Items Phone', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('product_style_section',
            [
                'label'=> esc_html__( 'PRODUCT STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control( 'item_style',
            [
                'label' => esc_html__( 'Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-bordered' => esc_html__( 'Bordered', 'electron' ),
                    'style-default' => esc_html__( 'Default', 'electron' ),
                ],
                'default' => 'style-default'
            ]
        );
        $this->add_responsive_control( 'ptitle_color',
            [
                'label' => esc_html__( 'Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-product-name,
                    {{WRAPPER}} .electron-product-cart' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'addto_color',
            [
                'label' => esc_html__( 'Add to Cart Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-product .electron-btn-small,
                    {{WRAPPER}} .electron-has-hidden-cart .electron-btn-small,
                    {{WRAPPER}} .electron-product-cart,
                    {{WRAPPER}} .electron-product-cart a:hover,
                    {{WRAPPER}} .electron-block-right .electron-btn-small' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'price_color',
            [
                'label' => esc_html__( 'Price Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-price,
                    {{WRAPPER}} .woocommerce-variation-price .price span.del>span,
                    {{WRAPPER}} .electron-price span.del>span' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'stars_color',
            [
                'label' => esc_html__( 'Star Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .star-rating::before' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'stars_rated_color',
            [
                'label' => esc_html__( 'Star Rated Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .star-rating>span::before' => 'color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('widget_wrapper_style_section',
            [
                'label' => esc_html__( 'CONTAINER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control( 'container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-banners-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'container_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-banners-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'container_bgcolor',
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
                'name' => 'container_border',
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
        $this->add_control( 'header_style_heading',
            [
                'label' => esc_html__( 'CONTAINER', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_responsive_control( 'header_container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'header_container_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'header_container_bgcolor',
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
                'name' => 'header_container_border',
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

    public function customImages($index) {
        $settings = $this->get_settings_for_display();

        $images = array();
        $type   = $settings['img_type'];
        $items  = 'icon' == $type ? $settings['icons'] : $settings['images'];
        $count  = 0;

        if ( 'icon' == $type ) {

            foreach ( $items as $item ) {
                if ( !empty( $item['icon']['value'] ) ) {
                    ob_start();
                    Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
                    $icon = ob_get_clean();
                    $images[$count] = '<span class="taxonomy-thumb elementor-repeater-item-'.$item['_id'].'">'.$icon.'</span>';
                }
                $icon = '';
                $count++;
            }

        } else {

            $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : 'thumbnail';
            if ( 'custom' == $size ) {
                $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
                $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
                $size  = [ $sizew, $sizeh ];
            }

            foreach ( $items as $item ) {
                if ( !empty( $item['image']['id'] ) ) {
                    $image = wp_get_attachment_image( $item['image']['id'], $size, false );
                    $images[$count] = '<div class="taxonomy-thumb">'.$image.'</div>';
                }
                $image = '';
                $count++;
            }
        }
        return !empty($images) && isset($images[$index]) ? $images[$index] : null;
    }

    public function imgSize() {
        $settings = $this->get_settings_for_display();
        $mobsize  = wp_is_mobile() ? 'mob_' : '';
        $size     = $settings[$mobsize.'thumbnail2_size'] ? $settings[$mobsize.'thumbnail2_size'] : 'woocommerce_thumbnail';
        if ( 'custom' == $size ) {
            return 'custom';
        }
        return $size;
    }

    public function imgCustomSize() {
        $settings = $this->get_settings_for_display();
        $mobsize  = wp_is_mobile() ? 'mob_' : '';

        $sizew = $settings[$mobsize.'thumbnail2_custom_dimension']['width'];
        $sizeh = $settings[$mobsize.'thumbnail2_custom_dimension']['height'];
        $size  = [ $sizew, $sizeh ];

        return $size;
    }

    protected function render() {

        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();
        $editmode   = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id: '';
        $tax        = $settings['taxonomy'];
        $filter     = $settings['filter_type'];
        $show_image = $settings['show_image'];
        $img_type   = $settings['img_type'];
        $show_count = $settings['count'];
        $limit      = $settings['limit'];
        $shoplink   = wc_get_page_permalink( 'shop' );

        if ( $show_image == 'yes' ) {
            $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : 'thumbnail';
            if ( 'custom' == $size ) {
                $sizew = $settings['thumbnail_custom_dimension']['width'];
                $sizeh = $settings['thumbnail_custom_dimension']['height'];
                $size  = [ $sizew, $sizeh ];
            }
        }

		$electronOptions = get_option('electron');
		$brands1 = taxonomy_exists('electron_product_brands') ? 'electron_product_brands' : '';
		$brands2 = taxonomy_exists('product_brand') ? 'product_brand' : '';
		$brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == 'yes' ? $brands1 : $brands2;

        if ( $tax == 'cat' ) {
            $taxonomy = array( 'taxonomy' => 'product_cat',$filter => $settings['cats']);
        } elseif ( $tax == 'tag' ) {
            $taxonomy = array( 'taxonomy' => 'product_tag',$filter => $settings['tags']);
        } elseif ( $tax == 'brand' ) {
            $taxonomy = array( 'taxonomy' => $brandsTax,$filter => $settings['brands']);
        }

        $taxonomy['order']   = $settings['order'];
        $taxonomy['orderby'] = $settings['orderby'];
        $terms  = get_terms($taxonomy);
        $termId = !empty($terms[0]) ? $terms[0]->term_id : '';

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $limit,
            'order'          => $settings['order2'],
            'orderby'        => $settings['orderby2']
        );

        if ( 'yes' == $settings['paginate'] ) {
            if ( get_query_var('paged') ) {
                $paged = get_query_var('paged');
            } elseif ( get_query_var('page') ) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
            $args['paged'] = $paged;
        }

        if ( $tax == 'cat' ) {
            $taxo   = 'product_cat';
            $pterms = $settings['cats'];
        } elseif ( $tax == 'tag' ) {
            $taxo   = 'product_tag';
            $pterms = $settings['tags'];
        } elseif ( $tax == 'brand' ) {
            $taxo   = $brandsTax;
            $pterms = $settings['brands'];
        }

        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxo,
                'field'    => 'id',
                'terms'    => $termId,
                'operator' => $filter == 'include' ? 'IN' : 'NOT IN'
            )
        );

        $hideoutstock = get_option('woocommerce_hide_out_of_stock_items');
        if ($hideoutstock == 'yes' ) {
            $args['meta_query'][] = array(
                'key'       => '_stock_status',
                'compare'   => '=',
                'value'     => 'instock'
            );
        }

        wp_enqueue_script( 'pjax' );

        $the_query = new \WP_Query( $args );

        $hhtml = $tax_html = $phtml = '';

        if ( 'yes' == $settings['header_display'] ) {
            $hhtml .= '<div class="electron-widget-header">';
                if ( $settings['header_title'] ) {
                    $hhtml .= '<'.$settings['title_tag'].' class="electron-header-title">'.$settings['header_title'].'</'.$settings['title_tag'].'>';
                }
                if ( $settings['button_title'] ) {
                    $btn_attr  = $settings['link']['url'] ? 'href="'.$settings['link']['url'].'"' : 'href="#0"';
                    $btn_attr .= $settings['link']['is_external'] ? ' target="_blank"' : '';
                    $btn_attr .= $settings['link']['nofollow'] ? ' rel="nofollow"' : '';

                    $class  = 'electron-btn';
                    $class .= 'electron-gradient' == $settings['bg_type'] ? ' '.$settings['gradient_type'] : ' '.$settings['color_type'];
                    $class .= ' '.$settings['bg_type'];
                    $class .= ' '.$settings['radius_type'];
                    $class .= 'yes' == $settings['add_icon'] ? ' has-icon icon-'.$settings['header_btn_icon_pos'] : '';
                    $hicon  = $btn_icon = '';

                    if ( 'yes' == $settings['add_icon'] && !empty( $settings['header_btn_icon']['value'] ) ) {
                        ob_start();
                        Icons_Manager::render_icon( $settings['header_btn_icon'], [ 'aria-hidden' => 'true' ] );
                        $btn_icon = ob_get_clean();
                    }

                    $hicon = 'yes' == $settings['add_icon'] ? '<svg class="svgRight" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>' : '';
                    $hicon = $btn_icon ? $btn_icon : $hicon;

                    $hhtml .= '<a class="electron-header-button '.$class.'" '.$btn_attr.'>'.$hicon.'<span class="btn-text" data-hover="'.$settings['button_title'].'"></span></a>';
                }
            $hhtml .= '</div>';
        }

        if ( !empty( $terms ) ) {
            $tax_html .= '<div class="taxonomy-col-wrapper '.$settings['style'].' img-type-'.$settings['img_type'].'">';
                $tax_html .= '<div class="electron-taxonomy-list">';
                    $count = 0;
                    foreach ( $terms as $term ) {
                        if ( !empty( $term ) && !is_wp_error($term) && $term->count>0 ) {
                            $term_id    = $term->term_id;
                            $name       = $term->name;
                            $tcount     = $term->count;
                            $desc       = $term->description;
                            $count_html = 'yes' == $show_count && $tcount > 0 ? '<span class="taxonomy-count">'.$tcount.'</span>' : '';
                            $active     = 0 == $count && $tcount > 0 ? ' active' : '';
                            $loaded     = 0 == $count && $tcount > 0 ? ' loaded' : '';

                            $tax_html .= '<div class="taxonomy-item'.$active.'">';
                                $qarg = esc_url( add_query_arg( 'per_page',wc_clean( wp_unslash( $limit ) ),esc_url( get_term_link( $term ) ) ) );
                                $tax_html .= '<a class="taxonomy-link" href="'.$qarg.'" rel="nofollow" aria-label="'.$name.'" data-tax="'.$term_id.'">';
                                    if ( $show_image == 'yes' ) {
                                        if ( $img_type == 'thumb' ) {
                                            $imgid = get_term_meta( $term_id, 'thumbnail_id', true );
                                            if ( $tax == 'brand' ) {
                                                if ( $brandsTax == 'electron_product_brands' ) {
                                                    $meta = get_option( "taxonomy_$term_id" );
                                                    $imgid  = !empty($meta['brand_thumbnail_id']) ? absint( $meta['brand_thumbnail_id'] ) : '';
                                                }
                                            }
                                            $image = $imgid ? wp_get_attachment_image( $imgid, $size, false ) : wc_placeholder_img('thumbnail');
                                            $tax_html .= '<div class="taxonomy-thumb">'.$image.'</div>';
                                        } elseif ( $img_type == 'img' || $img_type == 'icon' ) {
                                            $tax_html .= $this->customImages($count);
                                        }
                                    }
                                    $tax_html .= '<span class="taxonomy-title" data-hover="'.$name.'"></span>';
                                    $tax_html .= $count_html;
                                $tax_html .= '</a>';

                                if ( $desc && 'yes' == $settings['desc'] ) {
                                    $tax_html .= '<div class="taxonomy-details position-'.$settings['desc_position'].'"><p class="taxonomy-desc">'.$desc.'</p></div>';
                                }
                            $tax_html .= '</div>';
                            $count++;
                        }
                    }
                $tax_html .= '</div>';
            $tax_html .= '</div>';
        }

        if ( $this->imgSize() == 'custom' ) {
            add_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            add_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            add_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        //if ( $the_query->have_posts() ) {

        $style    = $settings['grid_style'];
        $space    = 'style-bgcolor-outside' == $style || 'style-border-outside' == $style ? 0 : $settings['space'];
        $mobspace = $settings['mobspace'] ? $settings['mobspace'] : $settings['space'];
        $mobspace = 'style-bgcolor-outside' == $style || 'style-border-outside' == $style ? 0 : $mobspace;

        $slider_options = json_encode( array(
            "slidesPerView" => 1,
            "loop"          => 'yes' == $settings['loop'] ? true: false,
            "autoHeight"    => false,
            "rewind"        => true,
            "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
            "wrapperClass"  => "electron-swiper-wrapper",
            "watchSlidesProgress"=> true,
            "speed"         => $settings['speed'],
            "spaceBetween"  => $space,
            "navigation" => [
                "nextEl" => ".slide-next-$id",
                "prevEl" => ".slide-prev-$id"
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
        ));

        $operator = 'include'== $filter ? 'IN' : 'NOT IN';

        $sattr  = 'limit="'.$settings['limit'].'" hide_empty="0"';
        $sattr .= ' order="'.$settings['order2'].'"';
        $sattr .= ' orderby="'.$settings['orderby2'].'"';
        $sattr .= $tax == 'cat' ? ' cat_operator="'.$operator.'"' : '';
        $sattr .= $tax == 'tag' ? ' tag_operator="'.$operator.'"' : '';
        $sattr .= $tax == 'cat' && is_array($settings['cats']) ? ' category="'.$termId.'"' : '';
        $sattr .= $tax == 'cat' && is_array($settings['tags']) ? ' tag="'.$termId.'"' : '';
        $pagina = '';
        if ( 'yes'== $settings['paginate'] ) {
            $total = $the_query->max_num_pages;
            if ( $total > 1 ){
                $current = max(1, get_query_var('paged'));
                $url = esc_url( get_term_link( $terms[0] ) );
                $pagina = '<nav class="electron-woocommerce-pagination active loaded" data-max="'.$total.'" data-current="'.$current.'">';
                    $pagina .= paginate_links(array(
                        'base'      => $url . '%_%' . '&per_page='.$limit,
                        'format'    => 'page/%#%/?per_page='.$limit,
                        'current'   => $current,
                        'total'     => $total,
                        'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                        'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                        'type'      => 'list',
                        'end_size'  => 3,
                        'mid_size'  => 3
                    ));
                $pagina .= '</nav>';
            }
        }

        $nav = '';

        if ( 'yes' == $settings['nav'] ) {
            $nav .= '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
            $nav .= '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
        }

        $phtml .= '<div class="products-col-wrapper">';
            $phtml .= '<div class="slider-wrapper" data-tax="'.$termId.'">';
                $phtml .= do_shortcode('[products '.$sattr.' visibility="visible"]');
                $phtml .= $pagina.$nav;
            $phtml .= '</div>';
        $phtml .= '</div>';

        if ( $this->imgSize() == 'custom' ) {
            remove_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            remove_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            remove_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        $slideropt = $settings['layout_type'] == 'slider' ? ' data-swiper-options=\''.$slider_options.'\'' : '';

        $class  = ' layout-'.$settings['layout_type'];
        $class .= 'yes'== $settings['paginate'] ? ' has-pagination' : '';
        $class .= 'style-bgcolor-outside' == $style ? ' style-bgcolor style-border-outside' : ' '.$style;

        // final html
        echo '<div class="electron-tab-taxonomy'.$class.'" data-id="'.$id.'"'.$slideropt.'>'.$hhtml.'<div class="electron-widget-taxonomy-inner">'.$tax_html.$phtml.'</div></div>';

        ?>
        <script>
            jQuery(document).ready(function($){

                var wrapper = $('.electron-tab-taxonomy[data-id="<?php echo $id; ?>"]');
                var href    = $('.electron-tab-taxonomy[data-id="<?php echo $id; ?>"] .electron-taxonomy-list .taxonomy-item:first-child a').attr('href');
                var slider  = '.electron-tab-taxonomy[data-id="<?php echo $id; ?>"] .electron-swiper-container';
                var options = wrapper.data('swiper-options');

                wrapper.find('.products-col-wrapper .slider-wrapper>.woocommerce')
                .removeClass('woocommerce columns-4')
                .addClass('electron-swiper-container nav-vertical-centered active')
                .attr('data-href',href);

                wrapper.find('.electron-products').removeClass('electron-products products').addClass('electron-swiper-wrapper');

                wrapper.find('.electron-loop-product').each(function(){
                    $(this).addClass('swiper-slide');
                });

                const mySlider = new NTSwiper('.electron-tab-taxonomy[data-id="<?php echo $id; ?>"] .electron-swiper-container',options);
            });

        </script>
        <?php
    }
}
