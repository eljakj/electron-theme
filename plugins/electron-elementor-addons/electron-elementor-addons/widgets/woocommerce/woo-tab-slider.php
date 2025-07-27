<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Ajax_Tab_Slider extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-tab-slider';
    }
    public function get_title() {
        return 'Tab Slider';
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
        $this->add_control( 'slider_title',
            [
                'label' => esc_html__( 'Slider Title', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'separator' => 'before'
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
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_control( 'title_position',
            [
                'label' => esc_html__( 'Title Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => esc_html__( 'Before Tabs', 'electron' ),
                    'after' => esc_html__( 'After Tabs', 'electron' ),
                    'block' => esc_html__( 'Top', 'electron' ),
                ],
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'title',
            [
                'label' => esc_html__( 'Tab Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Tab Title',
                'label_block' => true,
            ]
        );
        $repeater->add_control( 'category',
            [
                'label' => esc_html__( 'Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => esc_html__( 'Select Category', 'electron' ),
            ]
        );
        $repeater->add_control( 'post_per_page',
            [
                'label' => esc_html__( 'Posts Per Page for This Tab', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 10,
                'separator' => 'before'

            ]
        );
        $repeater->add_control( 'order',
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
        $repeater->add_control( 'orderby',
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
                'default' => 'id'
            ]
        );
        $this->add_control( 'tabs',
            [
                'label' => esc_html__( 'Tabs', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{title}}',
                //'default' => ['']
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
        $this->start_controls_section( 'slider_settings_section',
            [
                'label' => esc_html__( 'SLIDER OPTIONS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'perview',
            [
                'label' => esc_html__( 'Per View ( Desktop )', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 6,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'mdperview',
            [
                'label' => esc_html__( 'Per View ( Tablet )', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->add_control( 'smperview',
            [
                'label' => esc_html__( 'Per View  ( Mobile )', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 1
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5000,
                'step' => 100,
                'default' => 1000,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'navs',
            [
                'label' => esc_html__( 'Nav', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'dots',
            [
                'label' => esc_html__( 'Dots', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
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
                'max' => 300,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-prev,{{WRAPPER}} .electron-swiper-next' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_arrow_size',
            [
                'label' => esc_html__( 'Arrow Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-prev:after,{{WRAPPER}} .electron-swiper-next:after' => 'font-size:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_color',
            [
                'label' => esc_html__( 'Arrow Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-prev:after,{{WRAPPER}} .electron-swiper-next:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrcolor',
            [
                'label' => esc_html__( 'Hover Arrow Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-prev:hover:after,{{WRAPPER}} .electron-swiper-next:hover:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-nav-bg' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-nav-bg:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'navs_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-nav-bg',
            ]
        );
        $this->add_control( 'navs_hvrbrdcolor',
            [
                'label' => esc_html__( 'Hover Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-nav-bg:hover' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'navs_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-nav-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
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
                'label' => esc_html__( 'Top Offset', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets' => 'margin-top:{{SIZE}}px;' ]
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
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets' => 'text-align:{{VALUE}};' ]
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
                'selectors' => [ '{{WRAPPER}} .electron-swiper-bullet:before' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
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
                    '{{WRAPPER}} .electron-swiper-bullet + .electron-swiper-bullet' => 'margin: 0;margin-left: {{SIZE}}px;',
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
                'selectors' => ['{{WRAPPER}} .electron-swiper-bullet:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-swiper-bullet',
            ]
        );
        $this->add_responsive_control( 'dots_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-swiper-bullet:before,
                    {{WRAPPER}} .electron-swiper-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                'selectors' => [ '{{WRAPPER}} .electron-swiper-bullet.active:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_hvrborder',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-swiper-bullet.active'
            ]
        );
        $this->add_responsive_control( 'dots_hvrborder_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-swiper-bullet.active:before,
                    {{WRAPPER}} .electron-swiper-bullet.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('tab_style_section',
            [
                'label'=> esc_html__( 'TAB STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_responsive_control( 'section_title_divider',
            [
                'label' => esc_html__( 'SECTION TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'selectors' => ['{{WRAPPER}} .electron-tab-nav' => 'justify-content: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'slider_title_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-section-title',
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_control( 'slider_title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-section-title' => 'color:{{VALUE}};' ],
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_responsive_control( 'title_spacing',
            [
                'label' => esc_html__( 'Title Spacing ( px )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 300]
                ],
				'default' => [
					'unit' => 'px',
					'size' => 30
				],
                'selectors' => [
                    '{{WRAPPER}} .electron-section-title-wrapper.title-top' => 'margin-bottom: {{SIZE}}px;'
                ],
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_responsive_control( 'title_alignment',
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
                'selectors' => [ '{{WRAPPER}} .electron-section-title-wrapper.title-top' => 'text-align: {{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'tabs_nav_divider',
            [
                'label' => esc_html__( 'TABS STYLE', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .electron-tab-nav' => 'justify-content: {{VALUE}};'],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-h-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-h-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-h-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => ''
            ]
        );
        $this->add_responsive_control( 'tab_clr',
           [
               'label' => esc_html__( 'Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .electron-tab-nav-item' => 'color: {{VALUE}};']
            ]
        );
        $this->add_responsive_control( 'tab_hvrclr',
           [
               'label' => esc_html__( 'Hover/Active Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => [
                   '{{WRAPPER}} .electron-tab-nav-item:hover,{{WRAPPER}} .electron-tab-nav-item.is-active ' => 'color: {{VALUE}};',
                   '{{WRAPPER}} .electron-tab-nav-item:after' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        $this->add_responsive_control( 'tab_spacing',
            [
                'label' => esc_html__( 'Space', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-nav-item + .electron-tab-nav-item' => 'margin-left: {{SIZE}}px;']
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-tab-nav-item'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('post_style_section',
            [
                'label' => esc_html__( 'POST STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_responsive_control( 'post_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-loop-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'post_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-loop-product' => 'background-color: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'post_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-loop-product'
            ]
        );
        $this->add_control( 'title_heading',
            [
                'label' => esc_html__( 'TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-loop-product .electron-product-name'
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .electron-product-name' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'price_heading',
            [
                'label' => esc_html__( 'PRICE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'price_color',
            [
                'label' => esc_html__( 'Price Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product span.del > span' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'price_color2',
            [
                'label' => esc_html__( 'Price Color 2', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .electron-price' => 'color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-loop-product .electron-price'
            ]
        );
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
        $settings  = $this->get_settings_for_display();
        $elementid = $this->get_id();

        $speed     = $settings['speed'] ? $settings['speed'] : 1000;
        $perview   = $settings['perview'] ? $settings['perview'] : 3;
        $mdperview = $settings['mdperview'] ? $settings['mdperview'] : 3;
        $smperview = $settings['smperview'] ? $settings['smperview'] : 2;
        $space     = $settings['space'] ? $settings['space'] : 15;
        $id        = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-edit-mode' : '';
        $count     = 1;
        $counttwo  = 1;

        if ( $this->imgSize() == 'custom' ) {
            add_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            add_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            add_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        $html = '';

    	if ( $settings['slider_title'] && 'block' == $settings['title_position'] ) {
			$html .= '<div class="electron-section-title-wrapper title-top">';
                $html .= '<'.$settings['title_tag'].' class="electron-section-title">'.$settings['slider_title'].'</'.$settings['title_tag'].'>';
            $html .= '</div>';
    	}
        $html .= '<div class="electron-tabs-wrapper">';
            if ( $settings['tabs'] ) {

                $html .= '<div class="electron-tab-nav-wrapper title-'.$settings['title_position'].'">';
                	if ( $settings['slider_title'] && 'before' == $settings['title_position'] ) {
        				$html .= '<div class="electron-section-title-wrapper">';
        	                $html .= '<'.$settings['title_tag'].' class="electron-section-title">'.$settings['slider_title'].'</'.$settings['title_tag'].'>';
        	            $html .= '</div>';
                	}
                    $html .= '<div class="electron-tab-nav">';
                        foreach ( $settings['tabs'] as $tab ) {
                            $terms = json_encode(
                                array(
                                    'ajaxurl'  => admin_url( 'admin-ajax.php' ),
                                    'id'       => $tab['category'],
                                    'per_page' => $tab['post_per_page'],
                                    'order'    => $tab['order'],
                                    'orderby'  => $tab['orderby'],
                                    'imgsize'  => $this->imgSize()
                                )
                            );
                            $is_active = 1 == $count ? ' is-active loaded' : '';
                            if ( $tab['title'] ) {
                                $html .= '<span class="electron-tab-nav-item'.$is_active.'" data-tab-terms=\''.$terms.'\'>'.$tab['title'].'</span>';
                            }
                            $count++;
                        }
                    $html .= '</div>';

                	if ( $settings['slider_title'] && 'after' == $settings['title_position'] ) {
        				$html .= '<div class="electron-section-title-wrapper">';
        	                $html .= '<'.$settings['title_tag'].' class="electron-section-title">'.$settings['slider_title'].'</'.$settings['title_tag'].'>';
        	            $html .= '</div>';
                	}

                $html .= '</div>';
            }

            foreach ( $settings['tabs'] as $tab ) {
                $cat = $tab['category'];
                $slider_options = json_encode(array(
                    "autoHeight"    => true,
                    "slidesPerView" => 1,
                    "spaceBetween"  => $space,
                    "speed"         => $speed,
                    "loop"          => false,
                    "rewind"        => true,
                    "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                    "wrapperClass"  => "electron-swiper-wrapper",
                    "navigation"    => [
                        "nextEl" => ".slide-prev-$cat",
                        "prevEl" => ".slide-next-$cat"
                    ],
                    "pagination" => [
                        "el"                => ".electron-pagination-$cat",
                        "bulletClass"       => "electron-swiper-bullet",
                        "bulletActiveClass" => "active",
                        "type"              => "bullets",
                        "clickable"         => true
                    ],
                    "breakpoints" => [
                        "0" => [
                            "slidesPerView"  => $smperview,
                            "slidesPerGroup" => $smperview
                        ],
                        "768" => [
                            "slidesPerView"  => $mdperview,
                            "slidesPerGroup" => $mdperview
                        ],
                        "1024" => [
                            "slidesPerView"  => $perview,
                            "slidesPerGroup" => $perview
                        ]
                    ]
                ));

                $is_active = 1 == $counttwo ? ' is-active loaded' : '';
                $html .= '<div class="electron-tab-slider electron-tab-page'.$is_active.'" data-cat-id="'.$cat.'">';
                    $html .= '<div class="thm-tab-slider electron-swiper-slider electron-swiper-container nav-vertical-centered" data-swiper-options=\''.$slider_options.'\'>';
                        $html .= '<div class="electron-swiper-wrapper">';
                            $args = array(
                                'post_type'      => 'product',
                                'posts_per_page' => $tab['post_per_page'],
                                'order'          => $tab['order'],
                                'orderby'        => $tab['orderby'],
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'id',
                                        'terms' => $cat
                                    )
                                )
                            );

                            $the_query = new \WP_Query( $args );
                            if ( $the_query->have_posts() && 1 == $counttwo ) {
                                while ( $the_query->have_posts() ) {
                                    $the_query->the_post();
                                    $product = new \WC_Product(get_the_ID());
                                    if ( $product->is_visible() ) {
                                        $html .= '<div class="swiper-slide product_item">';
                                        ob_start();
                                        wc_get_template_part( 'content', 'product' );
                                        $producthtml = ob_get_clean();
                                        $html .= $producthtml.'</div>';
                                    }
                                }
                            }
                            wp_reset_postdata();
                        $html .= '</div>';

                        if ( 'yes' == $settings['dots'] ) {
                            $html .= '<div class="electron-swiper-pagination electron-pagination-'.$cat.' position-relative"></div>';
                        }

                        if ( 'yes' == $settings['navs'] ) {
                            $html .= '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$cat.'"></div>';
                            $html .= '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$cat.'"></div>';
                        }

                    $html .= '</div>';
                    $html .= '<div class="loading-wrapper"><span class="ajax-loading"></span></div>';
                $html .= '</div>';
                $counttwo++;
            }
        $html .= '</div>';

        echo '<div class="electron-wc-tab-slider'.$id.' electron-swiper-slider-wrapper">'.$html.'</div>';

        if ( $this->imgSize() == 'custom' ) {
            remove_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            remove_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            remove_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
            <script>
                jQuery(document).ready(function($) {
                    $('.electron-wc-tab-slider-edit-mode').each(function () {
                        var myWrapper = $( this ),
                            ajaxTab   = myWrapper.find('.electron-tab-nav-item:not(.loaded)'),
                            loadedTab = myWrapper.find('.electron-tab-nav-item');

                        myWrapper.find('.electron-tab-slider.is-active .thm-tab-slider').each(function (el,i) {
                            let mySwiper = new NTSwiper(this, JSON.parse(this.dataset.swiperOptions));
                        });

                        loadedTab.on('click', function(event){
                            var $this = $(this),
                                terms = $this.data('tab-terms'),
                                id    = terms.id;
                            myWrapper.find('.electron-tab-nav-item').removeClass('is-active');
                            $this.addClass('is-active');
                            $('.electron-tab-slider:not([data-cat-id="'+id+'"])').removeClass('is-active');
                            $('.electron-tab-slider[data-cat-id="'+id+'"]').addClass('is-active');
                        });

                        var height = myWrapper.find('.electron-tabs-wrapper .thm-tab-slider').height();

                        ajaxTab.on('click', function(event){
                            var $this    = $(this),
                                terms    = $this.data('tab-terms'),
                                cat_id   = terms.id,
                                per_page = terms.per_page,
                                order    = terms.order,
                                orderby  = terms.orderby,
                                imgsize  = terms.imgsize,
                                ajaxurl  = terms.ajaxurl,
                                data     = {
                                    action     : 'electron_ajax_tab_slider',
                                    cat_id     : cat_id,
                                    per_page   : per_page,
                                    order      : order,
                                    orderby    : orderby,
                                    img_size   : imgsize,
                                    beforeSend : function() {
                                        $('.electron-tab-slider[data-cat-id="'+cat_id+'"]').css('min-height', height ).addClass('tab-loading');
                                        myWrapper.find('.electron-tab-nav-item').removeClass('is-active');
                                        $this.addClass('is-active');
                                    }
                                };

                            if ( !$this.hasClass('loaded') && $('.electron-tab-slider:not([data-cat-id="'+cat_id+'"])').length ) {

                                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                                $.post(ajaxurl, data, function(response) {

                                    $('.electron-tab-slider:not([data-cat-id="'+cat_id+'"])').removeClass('is-active');
                                    $('.electron-tab-slider[data-cat-id="'+cat_id+'"]').addClass('is-active loaded');
                                    $('.electron-tab-slider[data-cat-id="'+cat_id+'"] .electron-swiper-wrapper').append(response);

                                    $this.addClass('loaded');

                                    $('.electron-tab-slider[data-cat-id="'+cat_id+'"] .thm-tab-slider').each(function () {
                                        const options = JSON.parse(this.dataset.swiperOptions);
                                        var mySwiper  = new NTSwiper( this, options );
                                        $('body').trigger('electron_lazy_load');
                                    });

                                    $('.electron-tab-slider[data-cat-id="'+cat_id+'"] .variations_form').each(function () {
                                        $(this).wc_variation_form();
                                    });

                                    $('.electron-tab-slider[data-cat-id="'+cat_id+'"]').removeClass('tab-loading');

                                    $(document.body).trigger('electron_quick_shop');
                                    $('body').trigger('electron_quick_init');
                                    $(document.body).trigger('electron_variations_init');
                                });
                            }
                        });
                    });
                });
            </script>
            <?php
        }

    }
}
