<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Slider extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-slider';
    }
    public function get_title() {
        return 'Products Carousel';
    }
    public function get_icon() {
        return 'eicon-slider-push';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    // Registering Controls
    protected function register_controls() {

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'post_query_section',
            [
                'label' => esc_html__( 'QUERY', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
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
        $this->add_control( 'grid_style',
            [
                'label' => esc_html__( 'Style', 'electron' ),
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
        $this->add_control( 'scenario',
            [
                'label' => esc_html__( 'Select Scenario', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Newest', 'electron' ),
                    'featured' => esc_html__( 'Featured', 'electron' ),
                    'on-sale' => esc_html__( 'On Sale', 'electron' ),
                    'best' => esc_html__( 'Best Selling', 'electron' ),
                    'custom' => esc_html__( 'Specific Categories', 'electron' ),
                ],
                'default' => ''
            ]
        );
        $this->add_control( 'post_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 20
            ]
        );
        $this->add_control( 'category_filter_heading',
            [
                'label' => esc_html__( 'Category Filter', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_control( 'category_include',
            [
                'label' => esc_html__( 'Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)',
                'condition' => [ 'scenario' => 'custom' ]
            ]
        );
        $this->add_control( 'category_exclude',
            [
                'label' => esc_html__( 'Exclude Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s) to Exclude',
            ]
        );
        $this->add_control( 'post_filter_heading',
            [
                'label' => esc_html__( 'Post Filter', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            $this->add_control( 'post_include2',
                [
                    'label' => esc_html__( 'Specific Product(s) by IDs', 'electron' ),
                    'description' => esc_html__( 'Separate each id with comma', 'electron' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'condition' => [ 'scenario' => 'custom' ]
                ]
            );
            $this->add_control( 'post_exclude2',
                [
                    'label' => esc_html__( 'Exclude Product(s) by IDs', 'electron' ),
                    'description' => esc_html__( 'Separate each id with comma', 'electron' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'separator' => 'after',
                ]
            );
        } else {
            $this->add_control( 'post_include',
                [
                    'label' => esc_html__( 'Specific Product(s)', 'electron' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $this->get_all_posts_by_type('product'),
                    'description' => 'Select Specific Product(s)',
                    'condition' => [ 'scenario' => 'custom' ]
                ]
            );
            $this->add_control( 'post_exclude',
                [
                    'label' => esc_html__( 'Exclude Product', 'electron' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $this->get_all_posts_by_type('product'),
                    'description' => 'Select Post(s) to Exclude',
                    'separator' => 'after',
                ]
            );
        }
        $this->add_control( 'post_other_heading',
            [
                'label' => esc_html__( 'Other Filter', 'electron' ),
                'type' => Controls_Manager::HEADING
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
                'default' => 'DESC'
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
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
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
            'name' => 'mob_thumbnail',
            'default' => 'woocommerce_thumbnail'
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
                'default' => 5
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
        $this->add_responsive_control( 'title_color',
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

    public function imgSize() {
        $settings = $this->get_settings_for_display();
        $mobsize  = wp_is_mobile() ? 'mob_' : '';
        $size     = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'woocommerce_thumbnail';
        if ( 'custom' == $size ) {
            return 'custom';
        }
        return $size;
    }

    public function imgCustomSize() {
        $settings = $this->get_settings_for_display();
        $mobsize  = wp_is_mobile() ? 'mob_' : '';

        $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
        $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
        $size  = [ $sizew, $sizeh ];

        return $size;
    }

    protected function render() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }

        $settings = $this->get_settings_for_display();

        $id = $this->get_id();

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $settings['post_per_page'],
            'order'          => $settings['order']
        );

        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            if ( !empty($settings['post_include2']) ) {
                $products = str_replace(' ', '', trim($settings['post_include2']) );
                $include  = !empty($products) ? explode(',',$products) : '';
                $args['post__in'] = !empty($include) ? implode(',',$include) : '';
            }
            if ( !empty($settings['post_exclude2']) ) {
                $eproducts = str_replace(' ', '', trim($settings['post_exclude2']) );
                $exclude   = !empty($eproducts) ? explode(',',$eproducts) : '';
                $args['post__in'] = !empty($exclude) ? implode(',',$exclude) : '';
            }
        } else {
            $args['post__in'] = !empty($settings['post_include']) ? $settings['post_include'] : '';
            $args['post__not_in'] = !empty($settings['post_exclude']) ? $settings['post_exclude'] : '';
        }


        if ( 'featured' == $settings['scenario'] ) {
           $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'featured'
                )
            );

        } elseif('on-sale' == $settings['scenario']) {

            $args['meta_query'] = array(
                'relation' => 'OR',
                array( // Simple products type
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                ),
                array( // Variable products type
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                )
            );

        } elseif('best' == $settings['scenario']) {

            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'total_sales';

        } else {

            $args['orderby'] = $settings['orderby'];

        }

        if ( $settings['category_include'] ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $settings['category_include'],
                    'operator' => 'IN'
                )
            );
        }
        if ( $settings['category_exclude'] ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $settings['category_exclude'],
                    'operator' => 'NOT IN'
                )
            );
        }

        $hideoutstock = get_option('woocommerce_hide_out_of_stock_items');
        if ($hideoutstock == 'yes' ) {
            if ( 'on-sale' == $settings['scenario'] ) {
                $args['meta_query'] = array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array( // Simple products type
                            'key' => '_sale_price',
                            'value' => 0,
                            'compare' => '>',
                            'type' => 'numeric'
                        ),
                        array( // Variable products type
                            'key' => '_min_variation_sale_price',
                            'value' => 0,
                            'compare' => '>',
                            'type' => 'numeric'
                        )
                    ),
                    array(
                        'key'       => '_stock_status',
                        'compare'   => '=',
                        'value'     => 'instock'
                    )
                );
            } else {
                $args['meta_query'][] = array(
                    'key'       => '_stock_status',
                    'compare'   => '=',
                    'value'     => 'instock'
                );
            }
        }

        $editmode = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id: '';

        $style    = $settings['grid_style'];
        $space    = 'style-bgcolor-outside' == $style || 'style-border-outside' == $style ? 0 : $settings['space'];
        $mobspace = $settings['mobspace'] ? $settings['mobspace'] : $settings['space'];
        $mobspace = 'style-bgcolor-outside' == $style || 'style-border-outside' == $style ? 0 : $mobspace;

        $slider_options = json_encode( array(
            "slidesPerView" => 1,
            "loop"          => 'yes' == $settings['loop'] || 'yes' == $settings['centermode'] ? true: false,
            "autoHeight"    => false,
            "rewind"        => false,
            "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
            "wrapperClass"  => "electron-swiper-wrapper",
            "centeredSlides"=> 'yes' == $settings['centermode'] ? true : false,
            "centeredSlidesBounds"=> 'yes' == $settings['centermode'] ? true : false,
            "watchSlidesProgress"=> true,
            "speed"         => $settings['speed'],
            "spaceBetween"  => $space,
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
                    "slidesPerGroup" => $settings['xsitems'],
                    "spaceBetween"   => $mobspace,
                    "centeredSlides" => 'yes' == $settings['mobcentermode'] ? true: false
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

        if ( $this->imgSize() == 'custom' ) {
            add_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            add_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            add_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        $html = $hhtml = '';

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

        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {

            $html .= '<div class="electron-swiper-wrapper">';
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $product = new \WC_Product(get_the_ID());
                    if ( !empty( $product ) && $product->is_visible() ) {
                        $html .= '<div class="swiper-slide product_item '.$settings['item_style'].'">';
                            ob_start();
                            wc_get_template_part( 'content', 'product' );
                            $html .= ob_get_clean();
                        $html .= '</div>';
                    }
                }
            $html .= '</div>';

            if ( 'yes' == $settings['dots'] ) {
                $html .= '<div class="electron-swiper-pagination electron-pagination-'.$id.' position-relative"></div>';
            }

            if ( 'yes' == $settings['nav'] ) {
                $html .= '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
                $html .= '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
            }

            $class  = 'electron-products-widget-slider electron-swiper-container has-height-container electron-swiper-slider'.$editmode.' nav-vertical-centered';
            $class .= 'style-bgcolor-outside' == $style ? ' style-bgcolor style-border-outside' : ' '.$style;
            $class .= 'yes' == $settings['centermode'] ? ' centermode' : ' ';

            echo '<div class="electron-slider-wrapper">'.$hhtml.'<div class="'.$class.'" data-swiper-options=\''.$slider_options.'\'>'.$html.'</div></div>';
        } else {
            echo '<p class="electron-not-found-info">' . esc_html__( 'No post found!', 'electron' ) . '</p>';
        }
        wp_reset_postdata();

        if ( $this->imgSize() == 'custom' ) {
            remove_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            remove_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            remove_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

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
