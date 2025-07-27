<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Brands extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-brands';
    }
    public function get_title() {
        return 'Product Brands';
    }
    public function get_icon() {
        return 'eicon-carousel';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_script_depends() {
        return [ 'electron-swiper' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'items_settings',
            [
                'label' => esc_html__('BRANDS', 'electron'),
                'tab' => Controls_Manager::TAB_CONTENT,
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
        $this->add_control( 'type',
            [
                'label' => esc_html__( 'Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__( 'Grid', 'electron' ),
                    'slider' => esc_html__( 'Slider', 'electron' )
                ]
            ]
        );
        $this->add_control( 'grid_style',
            [
                'label' => esc_html__( 'Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'electron' ),
                    'style-2' => esc_html__( 'Style 2', 'electron' ),
                    'style-3' => esc_html__( 'Style 3', 'electron' ),
                    'style-4' => esc_html__( 'Style 4', 'electron' ),
                ],
                'default' => 'style-1'
            ]
        );
        $this->add_control( 'post_per_page',
            [
                'label' => esc_html__( 'Per Page', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 10,
            ]
        );
        $this->add_responsive_control( 'column',
            [
                'label' => esc_html__( 'Column Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'step' => 1,
                'default' => 3,
                'selectors' => [ '{{WRAPPER}} .electron-brands-grid' => 'grid-template-columns: repeat({{VALUE}},1fr);'],
                'condition' => ['type' => 'grid']
            ]
        );
        $this->add_responsive_control( 'item_space',
            [
                'label' => esc_html__( 'Gap', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 20,
                'selectors' => ['{{WRAPPER}} .electron-brands-grid' => 'gap: {{VALUE}}px;'],
                'condition' => ['type' => 'grid']
            ]
        );
        $electronOptions = get_option('electron');
        $brands1   = taxonomy_exists('electron_product_brands') ? $this->electron_cpt_taxonomies('electron_product_brands') : array();
        $brands2   = taxonomy_exists('product_brand') ? $this->electron_cpt_taxonomies('product_brand') : array();
        $brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == '1' ? $brands1 : $brands2;
        $this->add_control( 'brands_exclude',
            [
                'label' => esc_html__( 'Exclude Brands', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $brandsTax,
                'description' => 'Select brands(s) to Exclude'
            ]
        );
        $this->add_control( 'hide_empty',
            [
                'label' => esc_html__( 'Hide Empty', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'no'
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
        $this->add_control( 'brand_desc',
            [
                'label' => esc_html__( 'Brands Description', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'thumbnail',
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'tab_header_section',
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
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'type' => 'slider' ]
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
        $this->add_control( 'item_opacity',
            [
                'label' => esc_html__( 'Inactive Item Opacity', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.01,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-slide:not(.swiper-slide-active)' => 'opacity:{{SIZE}};' ],
                'condition' => ['centermode' => 'yes']
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
                'default' => 20
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
                'default' => 3
            ]
        );
        $this->add_control( 'smitems',
            [
                'label' => esc_html__( 'Items Tablet', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 8,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->add_control( 'xsitems',
            [
                'label' => esc_html__( 'Items Phone', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 1
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('brands_container_style_section',
            [
                'label' => esc_html__( 'CONTAINER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'header_display' => 'yes' ]
            ]
        );
        $this->add_responsive_control( 'brands_container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-brands-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'brands_container_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-brands-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'brands_container_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-widget-brands-wrapper' => 'background-color: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'brands_container_border',
                'selector' => '{{WRAPPER}} .electron-widget-brands-wrapper'
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
                'label'=> esc_html__( 'BRAND STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'image_sdivider',
            [
                'label' => esc_html__( 'ITEM BOX', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Text Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-brand-item-inner,
                    {{WRAPPER}} .electron-brand-title,
                    {{WRAPPER}} .electron-brand-description' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_control( 'box_content_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-brand-item-inner' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_responsive_control( 'post_item_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-brand-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'post_item_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-brand-item-inner',
            ]
        );
        $this->add_responsive_control( 'post_item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-brand-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-brand-item-inner'
            ]
        );
        $this->add_control( 'text_content_sdivider',
            [
                'label' => esc_html__( 'TEXT CONTENT', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'text_content_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-brand-content' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_responsive_control( 'text_content_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-brand-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'text_sdivider',
            [
                'label' => esc_html__( 'DESCRIPTION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['brand_desc' => 'yes']
            ]
        );
        $this->add_control( 'text_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-brand-description' => 'color:{{VALUE}};' ],
                'condition' => ['brand_desc' => 'yes']
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-brand-description',
                'condition' => ['brand_desc' => 'yes']
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
                'selectors' => ['{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:after' => 'font-size:{{SIZE}}px;' ]
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
        $this->add_control( 'navs_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:hover,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:hover' => 'background-color:{{VALUE}};' ]
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
                'selectors' => [ '{{WRAPPER}} .electron-swiper-theme-style .swiper-pagination-bullets' => 'margin-top:{{SIZE}}px;' ]
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
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();

        $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : [100,100];
        if ( 'custom' == $size ) {
            $sizew = $settings['thumbnail_custom_dimension']['width'];
            $sizeh = $settings['thumbnail_custom_dimension']['height'];
            $size  = [ $sizew, $sizeh ];
        }
        $editmode = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id: '';

		$electronOptions = get_option('electron');
		$brands1 = taxonomy_exists('electron_product_brands') ? 'electron_product_brands' : '';
		$brands2 = taxonomy_exists('product_brand') ? 'product_brand' : '';
		$brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == '1' ? $brands1 : $brands2;

        $args = array(
			'taxonomy' => $brandsTax,
			'number'   => $settings['post_per_page'],
			'order'    => $settings['order'],
			'orderby'  => $settings['orderby'],
			'exclude'  => $settings['brands_exclude'],
			'hide_empty' => $settings['hide_empty'] == 'yes' ? true : false
		);

        $brands = get_terms($args);

        $html = '';
        $brand_html = '';

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

        if ( !empty( $brands ) ) {
            foreach ( $brands as $brand ) {
				if (!empty($brand->term_id) && !is_wp_error($brand)) {
					$image_id = '';
					if ( $brandsTax == 'electron_product_brands' ) {
						$term_meta = get_option( "taxonomy_$brand->term_id" );
						$image_id  = !empty($term_meta['brand_thumbnail_id']) ? absint( $term_meta['brand_thumbnail_id'] ) : '';
					} else {
						$image_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
					}

					$termlink  = !is_wp_error(get_term_link( $brand )) ? esc_url( get_term_link( $brand ) ) : '';
					$brand_html .= '<div class="electron-brand-item swiper-slide">';
						$brand_html .= '<div class="electron-brand-item-inner">';
							$brand_html .= $termlink ? '<a href="'.$termlink.'" title="'.$brand->name.'">' : '';
								$brand_html .= '<div class="electron-brand-thumb">';
									if ( $image_id ) {
										$brand_html .= wp_get_attachment_image( $image_id, $size, false, ['class'=>'electron-brands-item-image'] );
									} else {
										$brand_html .= wc_placeholder_img('thumbnail');
									}
								$brand_html .= '</div>';
								if ( !empty($brand->description) && 'yes' == $settings['brand_desc'] ) {
									$brand_html .= '<div class="electron-brand-content">';
										$brand_html .= '<p class="electron-brand-description">'.$brand->description.'</p>';
									$brand_html .= '</div>';
								}
							$brand_html .= $termlink ? '</a>' : '';
						$brand_html .= '</div>';
					$brand_html .= '</div>';
				}
            }
        }

        if ( 'slider' == $settings['type'] ) {
            $slider_options = json_encode( array(
                "slidesPerView" => 1,
                "touchRatio"    => 2,
                "loop"          => 'yes' == $settings['loop'] ? true: false,
                "autoHeight"    => false,
                "rewind"        => true,
                "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                "wrapperClass"  => "electron-swiper-wrapper",
                "speed"         => $settings['speed'],
                "spaceBetween"  => $settings['space'] ? $settings['space'] : 20,
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
            ));

            $html .= '<div class="electron-brands-slider electron-swiper-container electron-swiper-slider'.$editmode.' nav-vertical-centered" data-swiper-options=\''.$slider_options.'\'>';
                $html .= '<div class="electron-swiper-wrapper">'.$brand_html.'</div>';
                if ( 'yes' == $settings['dots'] ) {
                    $html .= '<div class="electron-swiper-pagination electron-pagination-'.$id.' position-relative"></div>';
                }
                if ( 'yes' == $settings['nav'] ) {
                    $html .= '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
                    $html .= '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
                }
            $html .= '</div>';

            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
                <script>
                jQuery( document ).ready( function($) {
                    var options =  $('.electron-swiper-slider-<?php echo $id ?>').data('swiper-options');
                    const mySlider<?php echo $id ?> = new NTSwiper('.electron-swiper-slider-<?php echo $id ?>', options);
                });
                </script>
                <?php
            }

        } else {

            $html .= '<div class="electron-brands-grid">'.$brand_html.'</div>';
        }

        // Final HTML
        echo '<div class="electron-widget-brands-wrapper '.$settings['grid_style'].'">'.$html.'</div>';
    }
}
