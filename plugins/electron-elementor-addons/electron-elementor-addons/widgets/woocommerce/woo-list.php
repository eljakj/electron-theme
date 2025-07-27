<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Products_List extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-products-list';
    }
    public function get_title() {
        return 'Products List';
    }
    public function get_icon() {
        return 'eicon-post-list';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_style_depends() {
        return [ 'electron-product-list' ];
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
        $this->add_control( 'type',
            [
                'label' => esc_html__( 'Layout Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'type1',
                'options' => [
                    'type1' => esc_html__( 'Type 1', 'electron' ),
                    'type2' => esc_html__( 'Type 2', 'electron' ),
                    'type3' => esc_html__( 'Type 3', 'electron' ),
                    'type4' => esc_html__( 'Type 4', 'electron' ),
                ]
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
                'label' => esc_html__( 'Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__( 'Bordered inside', 'electron' ),
                    'style-2' => esc_html__( 'Bordered outside', 'electron' ),
                    'style-3' => esc_html__( 'Bordered Space', 'electron' ),
                    'style-4' => esc_html__( 'Without Border', 'electron' ),
                ],
                'default' => 'style-1'
            ]
        );
        $this->add_control( 'scenario',
            [
                'label' => esc_html__( 'Select Scenario', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'featured' => esc_html__( 'Featured', 'electron' ),
                    'on-sale' => esc_html__( 'On Sale', 'electron' ),
                    'best' => esc_html__( 'Best Selling', 'electron' ),
                    'custom' => esc_html__( 'Specific Categories', 'electron' )
                ],
                'default' => 'custom'
            ]
        );
        $this->add_control( 'post_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 2
            ]
        );
        $this->add_control( 'category_filter_heading',
            [
                'label' => esc_html__( 'CATEGORY', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'category_filter_type',
            [
                'label' => esc_html__( 'Category Filter Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'exclude' => esc_html__( 'Exclude', 'electron' ),
                    'include' => esc_html__( 'Include', 'electron' ),
                ],
                'default' => 'include'
            ]
        );
        $this->add_control( 'category_filter',
            [
                'label' => esc_html__( 'Select Category(s)', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
            ]
        );
        $this->add_control( 'post_other_heading',
            [
                'label' => esc_html__( 'OTHER FILTER', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
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
            'default' => 'thumbnail'
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
            'default' => 'thumbnail'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('post_section',
            [
                'label'=> esc_html__( 'POST', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_responsive_control( 'spacing',
            [
                'label' => esc_html__( 'Space Between Items', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => [ '{{WRAPPER}} .product-list-item + .product-list-item' => 'margin-top: {{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'All Products',
                'label_block' => true
            ]
        );
        $this->add_control( 'cart',
            [
                'label' => esc_html__( 'Add to cart', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'price',
            [
                'label' => esc_html__( 'Price', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'stock',
            [
                'label' => esc_html__( 'Stock Status', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'rating',
            [
                'label' => esc_html__( 'Rating', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'timer',
            [
                'label' => esc_html__( 'Timer', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'timer_date',
            [
                'label' => esc_html__( 'Timer Date', 'electron' ),
                'type' => Controls_Manager::DATE_TIME,
                'label_block' => true,
                'picker_options' => array( 'enableTime'=>false ),
                'default' => date( 'Y/m/d' ),
                'condition' => [ 'timer' => 'yes' ]
            ]
        );
        $this->add_control( 'expired',
            [
                'label' => esc_html__( 'Timer Expired Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Expired',
                'condition' => [ 'timer' => 'yes' ]
            ]
        );
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Timer Short Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Remains until the end of the offer'
            ]
        );
        $this->add_control( 'update_date',
            [
                'label' => esc_html__( 'Update When Date Expires', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'timer' => 'yes' ]
            ]
        );
        $this->add_control( 'new_time',
            [
                'label' => esc_html__( 'Update for each day', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => '7',
                'condition' => [ 'timer' => 'yes','update_date' => 'yes' ]
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
        $this->start_controls_section('widget_wrapper_style_section',
            [
                'label' => esc_html__( 'CONTAINER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control( 'widget_wrapper_container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-banners-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'widget_wrapper_container_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-banners-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'widget_wrapper_container_bgcolor',
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
                'name' => 'widget_wrapper_container_border',
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
        $this->start_controls_section('style_section',
            [
                'label'=> esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control( 'box_sdivider',
            [
                'label' => esc_html__( 'ITEM BOX', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'box_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .product-list-item' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'box_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .product-list-item:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'box_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .product-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .product-list-item'
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .product-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_bxshodow',
                'label' => esc_html__( 'Box Shadow', 'electron' ),
                'selector' => '{{WRAPPER}} .product-list-item'
            ]
        );
        $this->add_control( 'boximg_sdivider',
            [
                'label' => esc_html__( 'IMAGE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'img_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-widget-product-list-wrapper img'
            ]
        );
        $this->add_responsive_control( 'img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}}  .electron-widget-product-list-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_control( 'img_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-widget-product-list-wrapper img' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'boxtitle_sdivider',
            [
                'label' => esc_html__( 'TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'boxtitle_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .list-heading .title' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .list-heading .title'
            ]
        );
        $this->add_control( 'toplink_sdivider',
            [
                'label' => esc_html__( 'LINK', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'toplink_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .list-heading .view-all' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'toplink_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .list-heading .view-all:hover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'toplink_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .list-heading .view-all'
            ]
        );
        $this->add_control( 'title_sdivider',
            [
                'label' => esc_html__( 'ITEM TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .product-list-details .title a' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'title_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .product-list-details .title a:hover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .product-list-details .title a'
            ]
        );
        $this->add_control( 'stars_heading',
            [
                'label' => esc_html__( 'STARS', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'stars_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-list-details .rating i' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control( 'price_heading',
            [
                'label' => esc_html__( 'PRICE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'price_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-list-details .list-price' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control( 'sale_price_color',
            [
                'label' => esc_html__( 'Price Color 2', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-list-details .list-price .del' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'timer_style_section',
            [
                'label'=> esc_html__( 'TIMER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'time_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count'
            ]
        );
        $this->add_responsive_control( 'time_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_responsive_control( 'time_last_color',
            [
                'label' => esc_html__( 'Last Item Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count:last-child' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'hide_sep',
            [
                'label' => esc_html__( 'Hide Separator', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'time_sep',
            [
                'label' => esc_html__( 'Seperator', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => ':',
                'condition' => ['hide_sep' => 'no']
            ]
        );
        $this->add_responsive_control( 'time_sep_color',
            [
                'label' => esc_html__( 'Seperator Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .separator' => 'color:{{VALUE}};' ],
                'condition' => ['hide_sep' => 'no']
            ]
        );
        $this->add_responsive_control( 'time_sep_size',
            [
                'label' => esc_html__( 'Seperator Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 15,
                'selectors' => ['{{WRAPPER}} .electron-coming-time .separator' => 'font-size:{{SIZE}}px;' ],
                'condition' => ['hide_sep' => 'no']
            ]
        );
        $this->add_responsive_control( 'time_min_width',
            [
                'label' => esc_html__( 'Item Min Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'min-width:{{SIZE}}px;' ],
            ]
        );
        $this->add_responsive_control( 'time_min_height',
            [
                'label' => esc_html__( 'Item Min height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'min-height:{{SIZE}}px;' ],
            ]
        );
        $this->add_responsive_control( 'time_sep_space',
            [
                'label' => esc_html__( 'Space Between Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-coming-time .separator' => 'margin:0 {{SIZE}}px;',
                    '{{WRAPPER}} .electron-coming-time.separator-none .time-count + .time-count' => 'margin-left:{{SIZE}}px;'
                ]
            ]
        );
        $this->add_responsive_control( 'time_padding',
            [
                'label' => esc_html__( 'Item Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'time_bgcolor',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count'
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'time_last_bgcolor',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count:last-child'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'time_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count'
            ]
        );
        $this->add_responsive_control( 'time_last_brdcolor',
            [
                'label' => esc_html__( 'Last Item Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count:last-child' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'time_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-coming-time .time-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }

        $settings  = $this->get_settings_for_display();
        $elementid = $this->get_id();

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $settings['post_per_page'],
            'order'          => $settings['order']
        );

        if ( 'featured' == $settings['scenario'] ) {
           $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured'
                )
            );

        } elseif ( 'on-sale' == $settings['scenario'] ) {

            $args['meta_query'] = array(
                'relation' => 'OR',
                array( // Simple products type
                    'key'     => '_sale_price',
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'numeric'
                ),
                array( // Variable products type
                    'key'     => '_min_variation_sale_price',
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'numeric'
                )
            );

        } elseif ( 'best' == $settings['scenario'] ) {

            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = 'total_sales';

        } else {

            $args['orderby'] = $settings['orderby'];

        }

        if ( $settings['category_filter'] ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'id',
                    'terms'    => $settings['category_filter'],
                    'operator' => 'include' == $settings['category_filter_type'] ? 'IN' : 'NOT IN'
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

        $mobsize = wp_is_mobile() ? 'mob_' : '';
        $size = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'thumbnail';
        if ( 'custom' == $size ) {
            $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
            $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
            $size = [ $sizew, $sizeh ];
        }

        $html = '';
        $cat_html = '';

        if ( 'yes' == $settings['header_display'] ) {
            $html .= '<div class="electron-widget-header">';
                if ( $settings['header_title'] ) {
                    $html .= '<'.$settings['title_tag'].' class="electron-header-title">'.$settings['header_title'].'</'.$settings['title_tag'].'>';
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

                    $html .= '<a class="electron-header-button '.$class.'" '.$btn_attr.'>'.$hicon.'<span class="btn-text" data-hover="'.$settings['button_title'].'"></span></a>';
                }
            $html .= '</div>';
        }

        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {
            $html .= '<div class="electron-product-list">';
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    global $product;
                    $pid     = $product->get_id();
                    $name    = $product->get_name();
                    $price   = $product->get_price_html();
                    $count   = $product->get_rating_count();
                    $rating  = $product->get_average_rating();
					$upsells = $product->get_upsell_ids();
                    $link    = get_permalink($pid);
                    $text    = get_post_meta( $pid, 'electron_countdown_text', true);
                    $desc    = $settings['desc'] ? $settings['desc'] : $text;
                    $time    = $settings['timer_date'];
					$class   = !empty($upsells) && is_array($upsells) ? ' has-upsell' : '';

                    if ( !empty( $product ) && $product->is_visible() ) {
                        $html .= '<div class="woocommerce product-list-item parent-loading product-inner'.$class.'" data-id="'.$pid.'">';
                            $html .= '<div class="product-list-inner">';
                                $html .= '<div class="thumb-wrapper">';
                                    $html .= electron_product_badge(false);
                                    $html .= '<a class="product-thumb" href="'.$link.'" title="'.$name.'">';
                                        $html .= has_post_thumbnail() ? get_the_post_thumbnail( $pid, $size ) : wc_placeholder_img('thumbnail');
                                    $html .= '</a>';
                                $html .= '</div>';

                                $html .= '<div class="product-list-details">';
                                    if ( 'yes' == $settings['rating'] || 'yes' == $settings['stock'] ) {
                                        $html .= '<div class="stock-rating list-part">';
                                            if ( 'yes' == $settings['stock'] ) {
                                                $html .= electron_loop_product_stock_status();
                                            }
                                            if ( 'yes' == $settings['rating'] ) {
                                                $html .= electron_star_rating_html( 1, $rating, $count );
                                            }
                                        $html .= '</div>';
                                    }
                                    $html .= '<h6 class="title list-part"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></h6>';
                                    if ( 'yes' == $settings['price'] ) {
                                        $html .= '<p class="list-price list-part">'.$price.'</p>';
                                    }
                                    if ( 'yes' == $settings['cart'] ) {
                                        $html .= '<div class="list-buttons list-part">';
                                        if ( 'type1' == $settings['type'] ) {
                                            $html .= electron_add_to_cart('text');
                                        } else {
                                            $html .= electron_add_to_cart('icon');
                                        }
                                        $html .= '</div>';
                                    }

                            // type 1 container
                            if ( 'type1' == $settings['type'] ) {
                                $html .= '</div>';
                                $html .= '</div>';
                            }

                            if ( $time ) {

                                $current_time = date( 'Y/m/d' );

                                if ( ( $current_time == $time || $time < $current_time ) && 'yes' == $settings['update_date'] ) {
                                    $next_time = $settings['new_time'];
                                    $time      = date('Y/m/d', strtotime($time. ' + '.$next_time.' days'));
                                }
                                $html .= '<div class="product-list-timer">';
                                    $sep = 'yes' == $settings['hide_sep'] ? ' separator-none' : '';
                                    $time_data = '"date":"'.$time.'","expired":"'.$settings['expired'].'"';
                                    $html .= '<div class="electron-coming-time coming-time-mini'.$sep.'"  data-countdown=\'{'.$time_data.'}\'>';
                                        $html .= '<div class="time-count days"></div>';
                                        $html .= '<span class="separator">:</span>';
                                        $html .= '<div class="time-count hours"></div>';
                                        $html .= '<span class="separator">:</span>';
                                        $html .= '<div class="time-count minutes"></div>';
                                        $html .= '<span class="separator">:</span>';
                                        $html .= '<div class="time-count second"></div>';
                                    $html .= '</div>';
                                    if ( $desc ) {
                                        $html .= '<p class="timer-description">'.$desc.'</p>';
                                    }
                                $html .= '</div>';
                            }

                        $html .= '</div>';
                        // type 2 container
                        if ( 'type2' == $settings['type'] || 'type3' == $settings['type'] || 'type4' == $settings['type'] ) {
                            $html .= '</div>';
                            $html .= '</div>';
                        }
                    }
                }
            $html .= '</div>';
        } else {
            $html .= '<p>No product found</p>';
        }
        wp_reset_postdata();

        echo '<div class="electron-widget-product-list-wrapper '.$settings['style'].' '.$settings['type'].'">'.$html.'</div>';

        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
                <script>
                jQuery(document).ready(function($){

                    $('[data-countdown]').each(function () {
                        var self      = $(this),
                            data      = self.data('countdown'),
                            countDate = data.date,
                            expired   = data.expired;

                        let countDownDate = new Date( countDate ).getTime();

                        const d = self.find( '.days' );
                        const h = self.find( '.hours' );
                        const m = self.find( '.minutes' );
                        const s = self.find( '.second' );

                        var x = setInterval(function() {

                            var now      = new Date().getTime();
                            var distance = countDownDate - now;
                            var days     = ('0' + Math.floor(distance / (1000 * 60 * 60 * 24))).slice(-2);
                            var hours    = ('0' + Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).slice(-2);
                            var minutes  = ('0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).slice(-2);
                            var seconds  = ('0' + Math.floor((distance % (1000 * 60)) / 1000)).slice(-2);

                            d.text( days );
                            h.text( hours );
                            m.text( minutes );
                            s.text( seconds );

                            if (distance < 0) {
                                clearInterval(x);
                                self.html('<div class="expired">' + expired + '</div>');
                            }
                        }, 1000);
                    });
                });
                </script>
            <?php
        }
    }
}
