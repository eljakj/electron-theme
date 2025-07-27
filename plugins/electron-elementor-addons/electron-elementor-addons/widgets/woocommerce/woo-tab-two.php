<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Tab_Two extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-tab-two';
    }
    public function get_title() {
        return 'Advanced Products';
    }
    public function get_icon() {
        return 'eicon-gallery-grid';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'cat', 'product', 'wc' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('tab_layout_section',
            [
                'label' => esc_html__( 'LAYOUT', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
         $this->add_control( 'tab_style',
            [
                'label' => esc_html__( 'Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__( 'style-1', 'electron' ),
                    'style-2' => esc_html__( 'style-2', 'electron' ),
                    'style-3' => esc_html__( 'style-3', 'electron' ),
                    'style-4' => esc_html__( 'style-4', 'electron' ),
                    'style-5' => esc_html__( 'style-5', 'electron' ),
                    'style-6' => esc_html__( 'style-6', 'electron' )
                ]
            ]
        );
        $this->add_control( 'layout_type',
            [
                'label' => esc_html__( 'Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'slider' => esc_html__( 'Slider', 'electron' ),
                    'grid' => esc_html__( 'Grid', 'electron' )
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
        $this->add_control( 'banner_display',
            [
                'label' => esc_html__( 'Banner Display', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'footer_display',
            [
                'label' => esc_html__( 'Footer Links Display', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'layout_products_divider',
            [
                'label' => esc_html__( 'PRODUCTS && BANNER', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control('layout_gap',
            [
                'label' => __( 'Columns Gap', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
                'selectors' => ['{{WRAPPER}} .electron-tab-content.has-banner' => 'gap: {{SIZE}}px;--gap: {{SIZE}}px;'],
            ]
        );
        $this->add_responsive_control( 'content_direction',
            [
                'label' => esc_html__( 'Content Direction', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => [
                    '{{WRAPPER}} .electron-tab-content.has-banner' => 'flex-direction: {{VALUE}};--flex-direction:{{VALUE}};width:var(--flex-direction);',
                    '{{WRAPPER}} .layout-slider .has-banner .electron-tab-products' => 'width:var(--flex-direction);'
                ],
                'options' => [
                    'row' => [
                        'title' => esc_html__( 'Row - horizontal', 'electron' ),
                        'icon' => 'eicon-arrow-right'
                    ],
                    'column' => [
                        'title' => esc_html__( 'Column - vertical', 'electron' ),
                        'icon' => 'eicon-arrow-down'
                    ],
                    'row-reverse' => [
                        'title' => esc_html__( 'Row - reversed', 'electron' ),
                        'icon' => 'eicon-arrow-left'
                    ],
                    'column-reverse' => [
                        'title' => esc_html__( 'Column - reversed', 'electron' ),
                        'icon' => 'eicon-arrow-up'
                    ]
                ],
                'toggle' => true,
                'default' => 'row'
            ]
        );
        $this->add_control( 'auto_col',
            [
                'label' => esc_html__( 'Products Auto Column', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['layout_type' => 'grid']
            ]
        );
        $this->add_responsive_control( 'col',
            [
                'label' => esc_html__( 'Products Column', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 8,
                'default' => 6,
                'selectors' => ['{{WRAPPER}} .electron-products' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
                'condition' => ['auto_col!' => 'yes','layout_type' => 'grid']
            ]
        );
        $this->add_responsive_control('auto_col_width',
            [
                'label' => __( 'Products Min Column Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-products' => 'grid-template-columns: repeat(auto-fit, minmax({{SIZE}}px, 1fr));'],
                'condition' => ['auto_col' => 'yes','layout_type' => 'grid']
            ]
        );
        $this->add_responsive_control('column_gap',
            [
                'label' => __( 'Columns Gap', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-products' => 'gap: {{SIZE}}px;'],
                'condition' => ['layout_type' => 'grid']
            ]
        );
        $this->add_control( 'layout_banner_divider',
            [
                'label' => esc_html__( 'BANNER ', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'banner_display' => 'yes' ]
            ]
        );
        $this->add_responsive_control('banner_col_min_width',
            [
                'label' => __( 'Banner Image Min Column Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
					'%' => [
						'min' => 0,
						'max' => 100
					],
                ],
				'default' => [
					'unit' => 'px',
					'size' => 320,
				],
                'selectors' => [
                    '{{WRAPPER}} .has-banner .electron-tab-banner' => 'flex: 0 0 var(--banner-w);--banner-w:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .layout-slider .has-banner .electron-tab-products' => 'flex: 0 0 auto;width: calc(100% - (var(--banner-w) + var(--gap)));--banner-w:{{SIZE}}{{UNIT}};'
                ],
                'condition' => [ 'banner_display' => 'yes','content_direction!' => ['column','column-reverse'] ]
            ]
        );
        $this->add_responsive_control('banner_min_height',
            [
                'label' => __( 'Min Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner' => 'min-height: {{SIZE}}px;'],
                'condition' => [ 'banner_display' => 'yes' ]
            ]
        );
        $this->add_responsive_control( 'banner_col_radius',
            [
                'label' => esc_html__( 'Radius', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner' => 'border-radius: {{SIZE}}px;'],
                'condition' => [ 'banner_display' => 'yes' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
       /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('slider_options_section',
            [
                'label'=> esc_html__( 'SLIDER OPTIONS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'layout_type' => 'slider' ]
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
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Navigation', 'electron' ),
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
        $this->add_control( 'header_menu_divider',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'MENU', 'electron' ),
                'separator' => 'before',
            ]
        );
        $this->add_control( 'all_products',
            [
                'label' => esc_html__( 'All Products Menu Title Display', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'all_products_title',
            [
                'label' => esc_html__( 'All Products Menu Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'All Products',
                'condition' => [ 'all_products' => 'yes' ]
            ]
        );
        $this->add_control( 'tab_menu',
            [
                'label' => esc_html__( 'Tab Menu', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'category',
                'options' => [
                    'cat' => esc_html__( 'Category', 'electron' ),
                    'tag' => esc_html__( 'Tags', 'electron' ),
                    'fast' => esc_html__( 'Fast Filters', 'electron' ),
                    'attr' => esc_html__( 'Attributes', 'electron' ),
                    'custom' => esc_html__( 'Custom Links', 'electron' ),
                ]
            ]
        );
        $attributes = new Repeater();
        $attributes->add_control( 'mattr',
            [
                'label' => esc_html__( 'Select Attribute', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_woo_attributes(),
                'description' => 'Select Attribute(s)'
            ]
        );
        $attributes->add_control( 'mattr_terms',
            [
                'label' => esc_html__( 'Select Attribute Terms', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_woo_attributes_taxonomies(),
                'description' => 'Select Attribute(s)'
            ]
        );
        $this->add_control( 'attribute_menu',
            [
                'label' => esc_html__( 'Attribute Menu Items', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $attributes->get_controls(),
                'title_field' => '{{mattr}}',
                'condition' => [ 'tab_menu' => 'attr' ]
            ]
        );
        $this->add_control( 'tab_cat_include',
            [
                'label' => esc_html__( 'Include Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s) to Exclude',
                'condition' => [ 'tab_menu' => 'cat' ]
            ]
        );
        $this->add_control( 'tab_tag_include',
            [
                'label' => esc_html__( 'Include Tag', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_tag'),
                'description' => 'Select Category(s) to Exclude',
                'condition' => [ 'tab_menu' => 'tag' ]
            ]
        );
        $this->add_control( 'tab_order',
            [
                'label' => esc_html__( 'Select Order', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'electron' ),
                    'DESC' => esc_html__( 'Descending', 'electron' )
                ],
                'default' => 'ASC',
                'condition' => [ 'tab_menu' => ['tag','cat'] ]
            ]
        );
        $this->add_control( 'tab_orderby',
            [
                'label' => esc_html__( 'Order By', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'id' => esc_html__( 'ID', 'electron' ),
                    'menu_order' => esc_html__( 'Menu Order', 'electron' ),
                    'rand' => esc_html__( 'Random', 'electron' ),
                    'date' => esc_html__( 'Date', 'electron' ),
                    'title' => esc_html__( 'Title', 'electron' ),
                ],
                'default' => 'id',
                'condition' => [ 'tab_menu' => ['tag','cat'] ]
            ]
        );
        $this->add_control( 'header_custom_menu_divider',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'CUSTOM MENU', 'electron' ),
                'separator' => 'before',
                'condition' => [ 'tab_menu' => 'custom' ]
            ]
        );
        $this->add_responsive_control('tab_menu_item_spacing',
            [
                'label' => esc_html__( 'Menu Item Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-tab-menu' => 'gap: calc({{SIZE}}px / 2);',
                    '{{WRAPPER}} .electron-tab-menu.fast-filters' => 'gap: {{SIZE}}px;',
                    '{{WRAPPER}} .electron-tab-menu:not(.fast-filters) a:not(:last-child)' => 'padding-right: calc({{SIZE}}px / 2);'
                ]
            ]
        );
        $this->add_control( 'tab_menu_item_style',
            [
                'label' => esc_html__( 'Menu Item Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__( 'Default', 'electron' ),
                    'bordered' => esc_html__( 'Bordered', 'electron' ),
                ],
                'default' => 'default'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tab_menu_item_border',
                'selector' => '{{WRAPPER}} .electron-tab-wrapper .electron-tab-menu a',
                'condition' => [ 'tab_menu_item_style' => 'bordered' ]
            ]
        );
        $this->add_control( 'add_icon',
            [
                'label' => esc_html__( 'Add Icon', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'condition' => [
                    'tab_menu!' => ['fast','custom']
                ]
            ]
        );
        $menu_icon = new Repeater();
        $menu_icon->add_control( 'menu_icon',
            [
                'label' => esc_html__( 'Menu Item Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ]
            ]
        );
        $this->add_control( 'menu_icons',
            [
                'label' => esc_html__( 'Menu Icon', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $menu_icon->get_controls(),
                'title_field' => esc_html__( 'Icon', 'electron' ),
                'condition' => [
                    'add_icon' => 'yes',
                    'tab_menu!' => ['fast','custom']
                ]
            ]
        );
        $this->add_responsive_control( 'menu_icons_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 30
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-menu a' => 'gap: {{SIZE}}px;' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'condition' => [
                    'add_icon' => 'yes',
                    'tab_menu!' => ['fast','custom']
                ]
            ]
        );
        $custom_menu = new Repeater();
        $custom_menu->add_control( 'custom_menu_title',
            [
                'label' => esc_html__( 'Title', 'electron' ),
                'type' => Controls_Manager::TEXT
            ]
        );
        $custom_menu->add_control( 'custom_menu_link',
            [
                'label' => esc_html__( 'Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => ''
                ],
                'show_external' => true
            ]
        );
        $custom_menu->add_control( 'custom_menu_icon',
            [
                'label' => esc_html__( 'Menu Item Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ]
            ]
        );
        $this->add_control( 'custom_menu',
            [
                'label' => esc_html__( 'Custom Menu Items', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $custom_menu->get_controls(),
                'title_field' => '{{custom_menu_title}}',
                'condition' => [ 'tab_menu' => 'custom' ]
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
        $this->add_control( 'use_icon',
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
                'condition' => ['header_btn_display' => 'yes','use_icon' => 'yes']
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
                'condition' => [ 'header_btn_display' => 'yes','use_icon' => 'yes' ]
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
                'selectors' => ['{{WRAPPER}} .electron-tab-header .electron-btn' => 'gap: {{SIZE}}px;' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14
                ],
                'condition' => [ 'header_btn_display' => 'yes','use_icon' => 'yes' ]
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
                    '{{WRAPPER}} .electron-tab-header .electron-btn i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .electron-tab-header .electron-btn svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16
                ],
                'condition' => [ 'header_btn_display' => 'yes','use_icon' => 'yes' ]
            ]
        );
        $this->add_control( 'bg_type',
            [
                'label' => esc_html__( 'Background Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-solid',
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
                'default' => 'electron-btn-primary',
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
                'default' => 'electron-square',
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
        $this->start_controls_section( 'tab_query_scenario_section',
            [
                'label' => esc_html__( 'PRODUCTS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'query_type',
            [
                'label' => esc_html__( 'Products Query Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'theme' => esc_html__( 'Theme Custom Query', 'electron' ),
                    'woo' => esc_html__( 'WooCommerce Shortcode', 'electron' ),
                ],
                'default' => 'woo'
            ]
        );
        $this->add_control( 'scenario',
            [
                'label' => esc_html__( 'Select Scenerio', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'newest' => esc_html__( 'Newest', 'electron' ),
                    'featured' => esc_html__( 'Featured', 'electron' ),
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                    'best' => esc_html__( 'Best Selling', 'electron' ),
                    'attr' => esc_html__( 'Attribute Display', 'electron' ),
                    'custom_cat' => esc_html__( 'Specific Categories', 'electron' ),
                    'rated' => esc_html__( 'Top Rated', 'electron' ),
                ],
                'default' => 'newest'
            ]
        );
        $this->add_control( 'limit',
            [
                'label' => esc_html__( 'Products Per Page', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => count( get_posts( array('post_type' => 'product', 'post_status' => 'publish', 'fields' => 'ids', 'posts_per_page' => '-1') ) ),
                'default' => 12
            ]
        );
        $this->add_control( 'paginate',
            [
                'label' => esc_html__( 'Pagination', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'grid_style',
            [
                'label' => esc_html__( 'Products Style', 'electron' ),
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
        $this->add_control( 'hr0',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [ 'scenario' => 'attr' ]
            ]
        );
        $this->add_control( 'attribute',
            [
                'label' => esc_html__( 'Select Attribute', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_woo_attributes(),
                'description' => 'Select Attribute',
                'condition' => [ 'scenario' => 'attr' ]
            ]
        );
        $this->add_control( 'attr_terms',
            [
                'label' => esc_html__( 'Select Attribute Terms', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_woo_attributes_taxonomies(),
                'description' => 'Select Attribute Terms(s)',
                'condition' => [ 'scenario' => 'attr' ]
            ]
        );
        $this->add_control( 'hr1',['type' => Controls_Manager::DIVIDER]);

        $this->add_control( 'cat_filter',
            [
                'label' => esc_html__( 'Filter Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat','name'),
                'description' => 'Select Category(s)',
            ]
        );
        $this->add_control( 'cat_operator',
            [
                'label' => esc_html__( 'Category Operator', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'AND' => esc_html__( 'display all of the chosen categories', 'electron' ),
                    'IN' => esc_html__( 'display electron-products within the chosen category', 'electron' ),
                    'NOT IN' => esc_html__( 'display electron-products that are not in the chosen category.', 'electron' ),
                ],
                'default' => 'AND'
            ]
        );

        $this->add_control( 'hr2',['type' => Controls_Manager::DIVIDER]);

        $this->add_control( 'tag_filter',
            [
                'label' => esc_html__( 'Filter Tag(s)', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_tag','name'),
                'description' => 'Select Tag(s)',
            ]
        );
        $this->add_control( 'tag_operator',
            [
                'label' => esc_html__( 'Tags Operator', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'AND' => esc_html__( 'display all of the chosen tags', 'electron' ),
                    'IN' => esc_html__( 'display electron-products within the chosen tags', 'electron' ),
                    'NOT IN' => esc_html__( 'display electron-products that are not in the chosen tags.', 'electron' ),
                ],
                'default' => 'AND',
            ]
        );

        $this->add_control( 'hr3',['type' => Controls_Manager::DIVIDER]);

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
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                    'rand' => esc_html__( 'Random', 'electron' ),
                    'rating' => esc_html__( 'Rating', 'electron' ),
                    'date' => esc_html__( 'Date', 'electron' ),
                    'title' => esc_html__( 'Title', 'electron' ),
                ],
                'default' => 'id'
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
        $this->start_controls_section('tab_banner_section',
            [
                'label' => esc_html__( 'BANNER IMAGE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'banner_display' => 'yes' ]
            ]
        );
        $this->add_control( 'use_video',
            [
                'label' => esc_html__( 'Use Video', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'video_source',
            [
                'label' => esc_html__( 'Select Bacground Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'youtube' => esc_html__( 'YouTube Video', 'electron' ),
                    'vimeo' => esc_html__( 'Vimeo Video', 'electron' ),
                    'local' => esc_html__( 'Local Video', 'electron' ),
                    'iframe' => esc_html__( 'Custom Iframe Embed', 'electron' )
                ],
                'condition' => [ 'use_video' => 'yes' ]
            ]
        );
        $this->add_control( 'video_url',
            [
                'label' => esc_html__( 'Video ID / Local Video URL', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [ 'use_video' => 'yes','video_source!' => 'iframe' ]
            ]
        );
        $this->add_control( 'video_embed',
            [
                'label' => esc_html__( 'Iframe Embed/HTML 5 Video', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'condition' => [ 'use_video' => 'yes','video_source' => 'iframe' ]
            ]
        );
        $this->add_responsive_control('video_width',
            [
                'label' => esc_html__( 'Video Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 300
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner iframe,{{WRAPPER}} .electron-tab-banner video' => 'width: {{SIZE}}%;'],
                'condition' => [ 'use_video' => 'yes' ]
            ]
        );
        $this->add_responsive_control('video_height',
            [
                'label' => esc_html__( 'Video Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 300
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner iframe,{{WRAPPER}} .electron-tab-banner video' => 'height: {{SIZE}}%;'],
                'condition' => [ 'use_video' => 'yes' ]
            ]
        );
        $this->add_responsive_control('video_left',
            [
                'label' => esc_html__( 'Video Left Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner iframe,{{WRAPPER}} .electron-tab-banner video' => 'left: {{SIZE}}px;'],
                'condition' => [ 'use_video' => 'yes' ]
            ]
        );
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => '']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'banner_thumbnail',
                'default' => 'thumbnail',
            ]
        );
        $this->add_control( 'mobile_image',
            [
                'label' => esc_html__( 'Mobile Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => '']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'banner_mob_thumbnail',
            'default' => 'woocommerce_thumbnail',
            ]
        );
        $this->add_control( 'fit_image',
            [
                'label' => esc_html__( 'Fit Image', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_responsive_control('img_bottom_position',
            [
                'label' => esc_html__( 'Image Custom Vertical Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner.fit_image img' => 'bottom: {{SIZE}}px;top: auto;'],
                'condition' => ['fit_image' => 'yes']
            ]
        );
        $this->add_responsive_control('img_left_position',
            [
                'label' => esc_html__( 'Image Custom Horizontal Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner.fit_image img' => 'left: {{SIZE}}px;right: auto;'],
                'condition' => ['fit_image' => 'yes']
            ]
        );
        $this->add_control( 'banner_text_divider',
            [
                'label' => esc_html__( 'BANNER TEXT', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'banner_text_horz_alignment',
            [
                'label' => esc_html__( 'Horizontal Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .electron-tab-banner-content' => 'align-items: {{VALUE}};'],
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
                'default' => 'flex-start'
            ]
        );
        $this->add_responsive_control( 'banner_text_vert_alignment',
            [
                'label' => esc_html__( 'Vertical Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .electron-tab-banner-content' => 'justify-content: {{VALUE}};'],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-v-align-top'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-v-align-bottom'
                    ]
                ],
                'toggle' => true,
                'default' => 'flex-start'
            ]
        );
        $this->add_responsive_control('banner_text_vert_gap',
            [
                'label' => esc_html__( 'Gap', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner.fit_image img' => 'gap: {{SIZE}}px;'],
                'condition' => ['fit_image' => 'yes']
            ]
        );
        $this->add_control( 'banner_subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'SMART MONITOR',
                'label_block' => true
            ]
        );
        $this->add_control( 'banner_title',
            [
                'label' => esc_html__( 'Title', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Free Shipping On Over $199',
                'label_block' => true,
            ]
        );
        $this->add_control( 'banner_tag',
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
        $this->add_control( 'banner_desc',
            [
                'label' => esc_html__( 'Short Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet',
                'label_block' => true
            ]
        );
        $this->add_control( 'banner_btn_title',
            [
                'label' => esc_html__( 'Button Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'See More Products',
                'label_block' => true
            ]
        );
        $this->add_control( 'banner_btn_icon',
            [
                'label' => esc_html__( 'Button Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ]
            ]
        );
        $this->add_control( 'banner_btn_icon_pos',
            [
                'label' => esc_html__( 'Icon Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => esc_html__( 'Before', 'electron' ),
                    'after' => esc_html__( 'After', 'electron' ),
                ]
            ]
        );
        $this->add_responsive_control( 'banner_icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-banner-content .electron-banner-button.has-icon' => 'gap: {{SIZE}}px;']
            ]
        );
        $this->add_responsive_control( 'banner_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-banner-content .has-icon i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .electron-banner-content .has-icon svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ]
            ]
        );
        $this->add_control( 'banner_link',
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
        $this->add_control( 'banner_link_aria',
            [
                'label' => esc_html__( 'Link Aria Label (SEO))', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'See More Products',
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('tab_footer_section',
            [
                'label' => esc_html__( 'FOOTER LINKS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'footer_display' => 'yes' ]
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'footer_title',
            [
                'label' => esc_html__( 'Link Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Tab Title',
                'label_block' => true,
            ]
        );
        $repeater->add_control( 'footer_link',
            [
                'label' => esc_html__( 'Title Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => ''
                ],
                'show_external' => true,
            ]
        );
        $repeater->add_control( 'footer_icon',
            [
                'label' => esc_html__( 'Link Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ]
            ]
        );
        $this->add_control( 'footer_links',
            [
                'label' => esc_html__( 'Tabs', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{footer_title}}',
            ]
        );
        $this->add_control( 'footer_style_heading',
            [
                'label' => esc_html__( 'STYLE', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_responsive_control( 'footer_item_gap',
            [
                'label' => esc_html__( 'Gap', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-footer' => 'gap: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'footer_title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-footer-link' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'footer_icon_pos',
            [
                'label' => esc_html__( 'Icon Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => esc_html__( 'Before', 'electron' ),
                    'after' => esc_html__( 'After', 'electron' ),
                ],
                'condition' => [ 'header_btn_display' => 'yes' ]
            ]
        );
        $this->add_responsive_control( 'footer_icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-footer-link.has-icon' => 'gap: {{SIZE}}px;']
            ]
        );
        $this->add_responsive_control( 'footer_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-tab-footer .has-icon i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .electron-tab-footer .has-icon svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('tab_container_style_section',
            [
                'label' => esc_html__( 'CONTAINER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'banner_container_border',
                'selector' => '{{WRAPPER}} .electron-tab-wrapper'
            ]
        );
        $this->add_responsive_control( 'tab_container_brdrad',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-wrapper' => 'border-radius: {{SIZE}}px;']
            ]
        );
        $this->add_responsive_control( 'tab_container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-tab-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'tab_container_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-tab-wrapper' => 'background-color: {{VALUE}};' ]
            ]
        );

        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('tab_header_style_section',
            [
                'label' => esc_html__( 'HEADER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'selectors' => ['{{WRAPPER}} .electron-tab-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'container_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-tab-header' => 'background-color: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'header_border',
                'selector' => '{{WRAPPER}} .electron-tab-header',
            ]
        );
        $this->add_responsive_control( 'header_border_brdrad',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-header' => 'border-radius: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'header_bottom_spacing',
            [
                'label' => esc_html__( 'Header Bottom Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 200
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-header' => 'margin-bottom: {{SIZE}}px;'],
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
                'selectors' => ['{{WRAPPER}} .electron-tab-title' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_menu_style_heading',
            [
                'label' => esc_html__( 'MENU', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'header_menu_title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-menu a' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_menu_title_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-menu a:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_menu_title_brdcolor',
            [
                'label' => esc_html__( 'Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-menu a, {{WRAPPER}} .electron-tab-menu .attr-wrapper' => 'border-color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_menu_title_brdwidth',
            [
                'label' => esc_html__( 'Border Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-menu a, {{WRAPPER}} .electron-tab-menu .attr-wrapper' => 'border-width: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'header_menu_title_brdrad',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-tab-menu a, {{WRAPPER}} .electron-tab-menu .attr-wrapper' => 'border-radius: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'header_button_style_heading',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'header_button_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-header .electron-tab-button' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_button_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-header .electron-tab-button:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_button_bgcolor',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-header .electron-tab-button' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_control( 'header_button_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-header .electron-tab-button:hover' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'header_button_border',
                'selector' => '{{WRAPPER}} .electron-tab-header .electron-tab-button'
            ]
        );
        $this->add_control( 'header_button_hvrbrdcolor',
            [
                'label' => esc_html__( 'Hover Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-tab-header .electron-tab-button:hover' => 'border-color: {{VALUE}};']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('products_banner_style_section',
            [
                'label' => esc_html__( 'PRODUCTS CONTAINER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'products_container_style_heading',
            [
                'label' => esc_html__( 'PRODUCTS/BANNER CONTAINER', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_responsive_control( 'products_container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-tab-wrapper .electron-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('tab_banner_style_section',
            [
                'label' => esc_html__( 'BANNER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'banner_container_style_heading',
            [
                'label' => esc_html__( 'CONTAINER', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_responsive_control( 'banner_container_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-tab-banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'banner_container_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-tab-banner-content' => 'background-color: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'banner_content_border',
                'selector' => '{{WRAPPER}} .electron-tab-banner-content'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'banner_container_box_shadow',
                'selector' => '{{WRAPPER}} .electron-tab-banner-content'
            ]
        );
        $this->add_control( 'banner_subtitle_style_heading',
            [
                'label' => esc_html__( 'SUBTITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'banner_subtitle_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-banner-subtitle' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'banner_title_style_heading',
            [
                'label' => esc_html__( 'TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'banner_title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-banner-title' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'banner_desc_style_heading',
            [
                'label' => esc_html__( 'DESCRIPTION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'banner_desc_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-banner-desc' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'banner_btn_style_heading',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'banner_btn_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-banner-button' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'banner_btn_bgcolor',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-banner-button' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'banner_btn_border',
                'selector' => '{{WRAPPER}} .electron-banner-button'
            ]
        );
        $this->add_responsive_control( 'banner_btn_brdrad',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-banner-button' => 'border-radius: {{SIZE}}px;']
            ]
        );
        $this->add_responsive_control( 'banner_btn_margin',
            [
                'label' => esc_html__( 'Button Margin Top', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-banner-button' => 'margin-top: {{SIZE}}px;']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('tab_style_section',
            [
                'label' => esc_html__( 'PRODUCT STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'selector' => '{{WRAPPER}} .electron-loop-product'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item_box_shadow',
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
                'label' => esc_html__( 'Regular Price Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .product-price,{{WRAPPER}} .electron-loop-product .product-price del' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'price_color2',
            [
                'label' => esc_html__( 'Sale Price Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .product-price ins > span' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'addtocart_heading',
            [
                'label' => esc_html__( 'ADD TO CART BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'addtocart_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .electron-product-cart' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'addtocart_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .electron-product-cart:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'addtocart_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .electron-product-cart' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_control( 'addtocart_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-loop-product .electron-product-cart:hover' => 'background-color: {{VALUE}};']
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

    public function banner_image() {
        $settings  = $this->get_settings_for_display();
        $html = '';
        if ( 'yes' == $settings['banner_display'] && !empty( $settings['image']['id'] ) ) {
            $size      = wp_is_mobile() && !empty( $settings['mobile_image']['id'] ) ? 'banner_mob_thumbnail' : 'banner_thumbnail';
            $imgId     = wp_is_mobile() && !empty( $settings['mobile_image']['id'] ) ? 'mobile_image' : 'image';
            $fit_image = 'yes' == $settings['fit_image'] ? ' fit_image' : '';
            $has_icon  = !empty( $settings['banner_btn_icon']['value'] ) ? ' has-icon icon-'.$settings['banner_btn_icon_pos'] : '';
            $icon      =  '';

            if ( !empty( $settings['banner_link']['url'] ) ) {
                $btn_attr  = $settings['banner_link']['url'] ? 'href="'.$settings['banner_link']['url'].'"' : 'href="#0"';
                $btn_attr .= $settings['banner_link']['is_external'] ? ' target="_blank"' : '';
                $btn_attr .= $settings['banner_link']['nofollow'] ? ' rel="nofollow"' : '';
                $btn_attr .= $settings['banner_link_aria'] ? ' title="'.$settings['banner_link_aria'].'"' : '';

                $html .= '<a class="electron-banner-link" '.$btn_attr.'></a>';
            }
            if ( 'yes' == $settings['use_video'] && !empty( $settings['video_url'] ) ) {
                //$html .= '<div class="electron-banner-video-wrapper">';
                if ( 'vimeo' == $settings['video_source'] ) {

                    $html .= '<iframe class="lazy" loading="lazy" src="https://player.vimeo.com/video/'.$settings['video_url'].'?autoplay=1&loop=1&title=0&byline=0&portrait=0&sidedock=0&controls=0&playsinline=1&muted=1" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';

                } elseif ( 'youtube' == $settings['video_source'] ) {

                    $html .= '<iframe class="lazy" loading="lazy" src="https://www.youtube.com/embed/'.$settings['video_url'].'?&modestbranding=0&rel=0&controls=0&autoplay=1&enablejsapi=1&showinfo=0&mute=1&loop=1" allow="autoplay; fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

                } elseif ( 'iframe' == $settings['video_source'] ) {

                    echo do_shortcode( $settings['video_embed'] );

                } elseif ( 'local' == $settings['video_source'] ) {

                    $html .= '<video class="lazy" loading="lazy" controls="0" autoplay="true" loop="true" muted="true" playsinline="true" src="'.$settings['video_url'].'"></video>';
                }
                //$html .= '</div>';
            } else {
                $html .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, $size, $imgId );
            }
            $html .= '<div class="electron-tab-banner-content">';
                if ( $settings['banner_subtitle'] ) {
                    $html .= '<span class="electron-banner-subtitle">'.$settings['banner_subtitle'].'</span>';
                }
                if ( $settings['banner_title'] ) {
                    $html .= '<'.$settings['banner_tag'].' class="electron-banner-title">'.$settings['banner_title'].'</'.$settings['banner_tag'].'>';
                }
                if ( $settings['banner_desc'] ) {
                    $html .= '<span class="electron-banner-desc">'.$settings['banner_desc'].'</span>';
                }

                if ( $settings['banner_btn_title']  ) {
                    $html .= '<span class="electron-banner-button'.$has_icon.'"><span class="btn-text">'.$settings['banner_btn_title'].'</span>';
                    if ( !empty( $settings['banner_btn_icon']['value'] ) ) {
                        ob_start();
                        Icons_Manager::render_icon( $settings['banner_btn_icon'], [ 'aria-hidden' => 'true' ] );
                        $icon = ob_get_clean();
                    }
                    $html .= $icon.'</span>';
                }
            $html .= '</div>';

            return '<div class="electron-tab-banner'.$fit_image.'">'.$html.'</div>';
        }
    }

    public function get_custom_query() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }

        $settings  = $this->get_settings_for_display();
        $id        = $this->get_id();
        $html      = '';

        $args = array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'posts_per_page'      => $settings['limit'],
            'order'               => $settings['order']
        );

        if ( 'featured' == $settings['scenario'] ) {
           $args['tax_query'] = array(
                array(
                    'taxonomy'         => 'product_visibility',
                    'field'            => 'name',
                    'terms'            => 'featured',
                    'operator'         => 'IN',
                    'include_children' => false
                )
            );

        } elseif ( 'popularity' == $settings['scenario'] ) {

            $args['orderby'] = 'popularity';

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

        } elseif ( 'newest' == $settings['scenario'] ) {

            $args['orderby']  = $settings['orderby'];

        } elseif ( 'best' == $settings['scenario'] ) {

            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = 'total_sales';

        } elseif ( 'rated' == $settings['scenario'] ) {

            $args['meta_key'] = '_wc_average_rating';
            $args['order']    = 'DESC';
            $args['orderby']  = 'meta_value_num';

        } elseif ( 'attr' == $settings['scenario'] && !empty($settings['attribute']) ) {

            $args['tax_query'] = array(
                array(
                    'taxonomy' => $settings['attribute'],
                    'field'    => 'term_id',
                    'terms'    => $settings['attr_terms'],
                    'operator' => 'IN'
                )
            );

        } else {

            $args['orderby'] = $settings['orderby'];

        }

        if ( $settings['cat_filter'] ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $settings['cat_filter'],
                    'operator' => $settings['cat_operator'],
                    'include_children' => 'AND' === $settings['cat_operator'] ? false : true
                )
            );
        }

        if ( $settings['tag_filter'] ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_tag',
                    'field'    => 'slug',
                    'terms'    => $settings['tag_filter'],
                    'operator' => $settings['tag_operator']
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

        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {

            if ( 'slider' == $settings['layout_type'] ) {
                $html .= '<div class="electron-swiper-container default theme-query">';
                    $html .= '<div class="electron-swiper-wrapper">';

                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            global $product;
                            $html .= '<div class="swiper-slide">';
                                ob_start();
                                wc_get_template_part( 'content', 'product' );
                                $html .= ob_get_clean();
                            $html .= '</div>';
                        }

                    $html .= '</div>';
                    $html .= '<div class="electron-swiper-prev slide-prev-'.$id.'"></div><div class="electron-swiper-next slide-next-'.$id.'"></div>';
                $html .= '</div>';

            } else {

                $html .= '<div class="electron-products theme-query">';
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        global $product;
                        ob_start();
                        wc_get_template_part( 'content', 'product' );
                        $html .= ob_get_clean();
                    }
                $html .= '</div>';
            }

            wp_reset_postdata();

            $total = $the_query->max_num_pages;

            if ( $total > 1 && 'yes' == $settings['paginate'] ){
                $current = max(1, $paged);

                $html .= '<nav class="electron-woocommerce-pagination theme-query">';
                    $html .= paginate_links(array(
                        'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, true ) ) ) ),
                        'current'   => $current,
                        'total'     => $total,
                        'add_args'  => false,
                        'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                        'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                        'type'      => 'list',
                        'end_size'  => 3,
                        'mid_size'  => 3
                    ));
                $html .= '</nav>';
            }
        }
        return $html;
    }

    protected function render() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }

        $settings  = $this->get_settings_for_display();
        $id        = $this->get_id();

        $limit          = 'limit="'.$settings['limit'].'"';
        $order          = $settings['order'] ? ' order="'.$settings['order'].'"' : '';
        $orderby        = ' orderby="'.$settings['orderby'].'"';
        $paginate       = 'yes'== $settings['paginate'] ? ' paginate="true"' : '';
        $operator       = ' cat_operator="'.$settings['cat_operator'].'"';
        $tag_operator   = ' tag_operator="'.$settings['tag_operator'].'"';
        $cat_filter     = is_array($settings['cat_filter']) ? ' category="'.implode(', ',$settings['cat_filter']).'"' : '';
        $tag_filter     = is_array($settings['tag_filter']) ? ' tag="'.implode(', ',$settings['tag_filter']).'"' : '';
        $attr_filter    = is_array($settings['attribute']) ? ' attribute="'.implode(', ',$settings['attribute']).'"' : '';
        $attr_terms     = is_array($settings['attr_terms']) ? ' terms="'.implode(', ',$settings['attr_terms']).'"' : '';

        $auto_col       = 'yes' == $settings['auto_col'] ? ' auto_col' : '';
        $taxonomy       = 'tag' == $settings['tab_menu'] ? 'product_tag' : 'product_cat';
        $include        = 'tag' == $settings['tab_menu'] ? $settings['tab_tag_include'] : $settings['tab_cat_include'];
        $has_banner     = 'yes' == $settings['banner_display'] && !empty( $settings['image']['id'] ) ? ' has-banner' : ' banner-none';
        $menu_icons     = array();
        $shoplink       = wc_get_page_permalink( 'shop' );
        $filtericon     = electron_svg_lists( 'filter', 'electron-svg-icon' );
        $terms          = array();
        $style          = $settings['grid_style'];
        $menu_style     = 'bordered' == $settings['tab_menu_item_style'] ? ' menu-bordered' : '';

        if ('tag' == $settings['tab_menu'] || 'cat' == $settings['tab_menu'] ) {
            $terms = get_terms(
                array(
                    'taxonomy' => $taxonomy,
                    'order'    => $settings['tab_order'],
                    'orderby'  => $settings['tab_orderby'],
                    'include'  => $include
                )
            );
        }
        if ( 'custom' != $settings['tab_menu'] ) {
            wp_enqueue_script( 'pjax' );
        }

        if ( $this->imgSize() == 'custom' ) {
            add_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            add_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            add_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        $qarg1 = esc_url( add_query_arg( array('per_page'=>$settings['limit']),$shoplink ) );
        $all_tab = '';
        if ( 'yes' == $settings['all_products'] ) {
            $all = $settings['all_products_title'];
            if ( 'theme' == $settings['query_type'] ) {
                $all_tab = '<a class="filter-shop-all active" href="'.$qarg1.'" rel="nofollow" title="'.$all.'" data-filter="pagination-1">'.$all.'</a>';
            } else {
                $all_tab = '<a class="filter-shop-all active" href="'.$qarg1.'" rel="nofollow" title="'.$all.'" data-filter="filter-shop-all">'.$all.'</a>';
            }
        }
        $html = '';
        if ( 'yes' == $settings['header_display'] ) {
            $html .= '<div class="electron-tab-header">';
                if ( $settings['header_title'] ) {
                    $html .= '<'.$settings['title_tag'].' class="electron-tab-title">'.$settings['header_title'].'</'.$settings['title_tag'].'>';
                }
                if ( ('tag' == $settings['tab_menu'] || 'cat' == $settings['tab_menu'] ) && !empty($terms) ) {
                    $mtax  = $settings['tab_menu'];
                    $html .= '<div class="fast-filters-trigger">'.esc_html__('Filter', 'electron').$filtericon.'</div>';
                    $html .= '<div class="electron-tab-menu taxonomy-links'.$menu_style.'">';
                        if ( 'yes' == $settings['add_icon'] && !empty($settings['menu_icons']) ) {
                            foreach ( $settings['menu_icons'] as $icon ) {
                                if ( !empty( $icon['menu_icon']['value'] ) ) {
                                    ob_start();
                                    Icons_Manager::render_icon( $icon['menu_icon'], [ 'aria-hidden' => 'true' ] );
                                    $ic = ob_get_clean();
                                    array_push($menu_icons, $ic);
                                }
                            }
                        }
                        $count = 0;
                        $html .= $all_tab;
                        foreach ( $terms as $term ) {
                            if ( !empty($term) ) {
                                $icon = !empty($menu_icons) && isset($menu_icons[$count]) ? $menu_icons[$count] : '';
                                $qarg = esc_url( add_query_arg( 'per_page',wc_clean( wp_unslash( $settings['limit'] ) ),esc_url( get_term_link( $term ) ) ) );
                                $html .= '<a class="tax-link" href="'.$qarg.'" rel="nofollow" title="'.$term->name.'" data-filter="filter-'.$mtax.'-'.$term->slug.'-'.$id.'">'.$icon.$term->name.'</a>';
                            }
                            $count++;
                        }
                    $html .= '</div>';
                }
                if ( 'fast' == $settings['tab_menu'] ) {
                    $titles = [
                        'featured'   => esc_html__('Featured', 'electron'),
                        'bestseller' => esc_html__('Best sellers', 'electron'),
                        'toprated'   => esc_html__('Top rated', 'electron'),
                        'onsale'     => esc_html__('On Sale', 'electron'),
                        'instock'    => esc_html__('In Stock', 'electron')
                    ];

                    $ficon         = electron_svg_lists( 'featured', 'electron-svg-icon' );
                    $besticon      = electron_svg_lists( 'best-seller', 'electron-svg-icon' );
                    $topicon       = electron_svg_lists( 'top-rated', 'electron-svg-icon' );
                    $onsaleicon    = electron_svg_lists( 'onsale', 'electron-svg-icon' );
                    $instockicon   = electron_svg_lists( 'instock-2', 'electron-svg-icon' );
                    $featured_link = esc_url( add_query_arg( array('featured'=>'yes','per_page'=>$settings['limit']),$shoplink ) );
                    $best_link     = esc_url( add_query_arg( array('best_seller'=>'yes','per_page'=>$settings['limit']),$shoplink ) );
                    $rating_link   = esc_url( add_query_arg( array('rating_filter'=>'5','per_page'=>$settings['limit']),$shoplink ) );
                    $onsale_link   = esc_url( add_query_arg( array('on_sale'=>'onsale','per_page'=>$settings['limit']),$shoplink ) );
                    $instock_link  = esc_url( add_query_arg( array('stock_status'=>'instock','per_page'=>$settings['limit']),$shoplink ) );

                    $html .= '<div class="fast-filters-trigger">'.esc_html__('Filter', 'electron').$filtericon.'</div>';
                    $html .= '<div class="electron-tab-menu fast-filters'.$menu_style.'">';
                        $html .= $all_tab;
                        $html .= '<a class="fast-link" href="'.$featured_link.'" rel="nofollow noreferrer" data-name="featured" title="'.$titles['featured'].'" data-filter="filter-featured-'.$id.'">'.$ficon.'<span class="title">'.$titles['featured'].'</span></a>';
                        $html .= '<a class="fast-link" href="'.$best_link.'" rel="nofollow noreferrer" data-name="bestseller" title="'.$titles['bestseller'].'" data-filter="filter-bestseller-'.$id.'">'.$besticon.'<span class="title">'.$titles['bestseller'].'</span></a>';
                        $html .= '<a class="fast-link" href="'.$rating_link.'" rel="nofollow noreferrer" data-name="rating" title="'.$titles['toprated'].'" data-filter="filter-toprated-'.$id.'">'.$topicon.'<span class="title">'.$titles['toprated'].'</span></a>';
                        $html .= '<a class="fast-link" href="'.$onsale_link.'" rel="nofollow noreferrer" data-name="onsale" title="'.$titles['onsale'].'" data-filter="filter-onsale-'.$id.'">'.$onsaleicon.'<span class="title">'.$titles['onsale'].'</span></a>';
                        $html .= '<a class="fast-link" href="'.$instock_link.'" rel="nofollow noreferrer" data-name="instock" title="'.$titles['instock'].'" data-filter="filter-instock-'.$id.'">'.$instockicon.'<span class="title">'.$titles['instock'].'</span></a>';
                    $html .= '</div>';
                }

                if ( 'custom' == $settings['tab_menu'] ) {
                    $html .= '<div class="fast-filters-trigger">'.esc_html__('Filter', 'electron').$filtericon.'</div>';
                    $html .= '<div class="electron-tab-menu custom-links'.$menu_style.'">';
                        foreach ( $settings['custom_menu'] as $menu ) {
                            $menu_attr  = !empty($menu['custom_menu_link']['url']) ? 'href="'.esc_url($menu['custom_menu_link']['url']).'"' : 'href="#0"';
                            $menu_attr .= !empty($menu['custom_menu_link']['is_external']) ? ' target="_blank"' : '';
                            $menu_attr .= !empty($menu['custom_menu_link']['nofollow']) ? ' rel="nofollow"' : '';
                            $menu_icon  = '';
                            if ( !empty( $menu['custom_menu_icon']['value'] ) ) {
                                ob_start();
                                Icons_Manager::render_icon( $menu['custom_menu_icon'], [ 'aria-hidden' => 'true' ] );
                                $menu_icon = ob_get_clean();
                            }
                            if ( !empty( $menu['custom_menu_title'] ) ) {
                                $menu_title = $menu['custom_menu_title'];
                                $html .= '<a class="custom-link" title="'.$menu_title.'" '.$menu_attr.'>'.$menu_icon.$menu_title.'</a>';
                            }
                        }
                    $html .= '</div>';
                }

                if ( 'attr' == $settings['tab_menu'] ) {
                    $html .= '<div class="fast-filters-trigger">'.esc_html__('Filter', 'electron').$filtericon.'</div>';
                    $html .= '<div class="electron-tab-menu attribute-links'.$menu_style.'">';
                    $html .= $all_tab;
                    foreach ( $settings['attribute_menu'] as $attr ) {
                        if ( !empty( $attr['mattr'] ) ) {
                            $tax = $attr['mattr'];
                            $mattr_terms = $attr['mattr_terms'];
                            $attr_label  = wc_attribute_label( 'pa_'.$tax );
                            $html .= '<div class="attr-wrapper">';
                                $html .= '<span class="attr-title">'.$attr_label.':</span>';
                                $html .= '<div class="terms-menu">';
                                    foreach ( $mattr_terms as $attr_term ) {
                                        $term_name = get_term_by( 'name', $attr_term, 'pa_'.$tax );
                                        if (!empty( $term_name )){
                                            $color    = get_term_meta( $term_name->term_id, 'electron_swatches_'.$tax, true ) ? : '';
                                            $is_white = $color == '#fff' || $color == '#FFF' || $color == '#ffffff' || $color == '#FFFFFF' ? ' is_white' : '';
                                            $name     = $tax == 'color' && !empty( $color ) ? '<span class="term-color'.$is_white.'" style="background-color:'.esc_attr( $color ).';"></span>' : $term_name->name;
                                            $term_link = esc_url( add_query_arg( array('filter_'.$tax=>$term_name->slug,'per_page'=>$settings['limit']),$shoplink ) );
                                            $html .= '<a class="term-link" href="'.$term_link.'" rel="nofollow noreferrer" data-name="'.$term_name->slug.'" title="'.$term_name->slug.'" data-filter="filter-'.$term_name->slug.'-'.$id.'">'.$name.'</a>';
                                        }
                                    }
                                $html .= '</div>';
                            $html .= '</div>';
                        }
                    }
                    $html .= '</div>';
                }

                if ( $settings['button_title'] ) {
                    $btn_attr  = $settings['link']['url'] ? 'href="'.$settings['link']['url'].'"' : 'href="#0"';
                    $btn_attr .= $settings['link']['is_external'] ? ' target="_blank"' : '';
                    $btn_attr .= $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
                    $btn_attr .= $settings['link']['nofollow'] ? ' title="'.$settings['button_title'].'"' : '';

                    $class  = 'electron-btn';
                    $class .= 'electron-gradient' == $settings['bg_type'] ? ' '.$settings['gradient_type'] : ' '.$settings['color_type'];
                    $class .= ' '.$settings['bg_type'];
                    $class .= ' '.$settings['radius_type'];
                    $class .= 'yes' == $settings['use_icon'] ? ' has-icon icon-'.$settings['header_btn_icon_pos'] : '';
                    $hicon  = $btn_icon = '';

                    if ( 'yes' == $settings['use_icon'] && !empty( $settings['header_btn_icon']['value'] ) ) {
                        ob_start();
                        Icons_Manager::render_icon( $settings['header_btn_icon'], [ 'aria-hidden' => 'true' ] );
                        $btn_icon = ob_get_clean();
                    }

                    $hicon = 'yes' == $settings['use_icon'] ? '<svg class="svgRight" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>' : '';
                    $hicon = $btn_icon ? $btn_icon : $hicon;

                    $html .= '<a class="electron-tab-button '.$class.'" '.$btn_attr.'>'.$hicon.'<span class="btn-text" data-hover="'.$settings['button_title'].'"></span></a>';
                }
            $html .= '</div>';
        }
        $content_direction = isset($settings['content_direction']) ? $settings['content_direction'] : 'default_value';
        $html .= '<div class="electron-tab-content direction-'.$content_direction.$has_banner.$auto_col.'">';

            $html .= $this->banner_image();

            if ( 'theme' == $settings['query_type'] ) {
                $pagi = 'yes' == $settings['paginate'] ? ' data-filter="pagination-1"' : ' data-filter="pagination-1"';
                $html .= '<div class="electron-tab-products theme-query active"'.$pagi.'>';
                    $html .= $this->get_custom_query();
                $html .= '</div>';
            } else {
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
                $html .= '<div class="electron-tab-products tab-default theme-query active" data-filter="pagination-1">';
                if ( 'newest' == $settings['scenario'] ) {
                    $html .= do_shortcode('[products '.$limit.$orderby.$order.$tag_filter.$paginate.' visibility="visible"]');
                } elseif ( 'featured' == $settings['scenario'] ) {
                    $html .= do_shortcode('[products '.$limit.$orderby.$order.$tag_filter.$paginate.' visibility="featured"]');
                } elseif ( 'popularity' == $settings['scenario'] ) {
                    $html .= do_shortcode('[products '.$limit.$order.$tag_filter.$paginate.' orderby="popularity" on_sale="true"]');
                } elseif ( 'best' == $settings['scenario'] ) {
                    $html .= do_shortcode('[products '.$limit.$orderby.$order.$cat_filter.$operator.$tag_filter.$paginate.' best_selling="true"]');
                } elseif ( 'custom_cat' == $settings['scenario'] ) {
                    $html .= do_shortcode('[products '.$limit.$orderby.$order.$cat_filter.$operator.$tag_filter.$paginate.']');
                } elseif ( 'attr' == $settings['scenario'] ) {
                    $html .= do_shortcode('[products '.$limit.$attr_filter.$attr_terms.$limit.$orderby.$order.$paginate.']');
                } elseif ( 'rated' == $settings['scenario'] ) {
                    $html .= do_shortcode('[top_rated_products '.$limit.$cat_filter.$tag_filter.$operator.$tag_operator.$order.$paginate.']');
                } else {
                    $html .= do_shortcode('[products '.$limit.$orderby.$order.$tag_filter.$operator.$paginate.' visibility="visible"]');
                }
                $html .= '</div>';
            }

        $html .= '</div>';

        if ( 'yes' == $settings['footer_display'] && !empty($settings['footer_links']) ) {
            $footer_icon = '';
            $fhas_icon = '';
            $html .= '<div class="electron-tab-footer">';
            foreach ( $settings['footer_links'] as $link ) {
                $fbtn_attr  = !empty($link['footer_link']['url']) ? 'href="'.$link['footer_link']['url'].'"' : 'href="#0"';
                $fbtn_attr .= !empty($link['footer_link']['is_external']) ? ' target="_blank"' : '';
                $fbtn_attr .= !empty($link['footer_link']['nofollow']) ? ' rel="nofollow"' : '';
                if ( !empty($link['footer_title']) ) {
                    if ( !empty( $link['footer_icon']['value'] ) ) {
                        ob_start();
                        Icons_Manager::render_icon( $link['footer_icon'], [ 'aria-hidden' => 'true' ] );
                        $footer_icon = ob_get_clean();
                        $fhas_icon = ' has-icon icon-'.$settings['footer_icon_pos'];
                    }
                    $html .= '<a class="electron-footer-link'.$fhas_icon.'" '.$fbtn_attr.'>'.$footer_icon.'<span class="link-text">'.$link['footer_title'].'</span></a>';
                }
            }
            $html .= '</div>';
        }

        if ( $settings['layout_type'] == 'slider' ) {

            $space = 'style-bgcolor-outside' == $style || 'style-border-outside' == $style ? 0 : $settings['space'];

            $slider_options = json_encode( array(
                    "slidesPerView" => 1,
                    "loop"          => 'yes' == $settings['loop'] ? true : false,
                    "autoHeight"    => false,
                    "rewind"        => false,
                    "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                    "wrapperClass"  => "electron-swiper-wrapper",
                    "watchSlidesProgress" => true,
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
                )
            );
        }

        $slideropt = $settings['layout_type'] == 'slider' ? ' data-swiper-options=\''.$slider_options.'\'' : '';

        $class  = ' layout-'.$settings['layout_type'];
        $class .= ' '.$settings['tab_style'];
        $class .= 'yes'== $settings['paginate'] ? ' has-pagination' : '';
        $class .= 'style-bgcolor-outside' == $style ? ' style-bgcolor style-border-outside' : ' '.$style;

        echo '<div class="electron-tab-wrapper'.$class.'" data-id="'.$id.'"'.$slideropt.'>'.$html.'</div>';

        if ( $settings['layout_type'] == 'slider' ) {
            if ( $settings['query_type'] == 'woo' ) {
                ?>
                <script>
                    jQuery(document).ready(function($){
                        var wrapper = $('.electron-tab-wrapper[data-id="<?php echo $id; ?>"]');
                        var options = wrapper.data('swiper-options');
                        var activePagin = 1;
                        if ( wrapper.find('.electron-woocommerce-pagination').length>0) {
                            activePagin = wrapper.find('.electron-woocommerce-pagination .current').html();
                        }
                        wrapper.find('.electron-tab-products').addClass('theme-query active').attr('data-filter','pagination-'+activePagin+'');
                        wrapper.find('.electron-tab-products>.woocommerce').removeClass('woocommerce columns-4').addClass('default electron-swiper-container');
                        wrapper.find('.electron-woocommerce-pagination').appendTo('.electron-tab-wrapper[data-id="<?php echo $id; ?>"] .electron-tab-products[data-filter="pagination-'+activePagin+'"]');

                        wrapper.find('.electron-products').removeClass('electron-products products').addClass('electron-swiper-wrapper');
                        $('<div class="electron-swiper-prev slide-prev-<?php echo $id; ?>"></div><div class="electron-swiper-next slide-next-<?php echo $id; ?>"></div>').appendTo('.electron-tab-wrapper[data-id="<?php echo $id; ?>"] .electron-swiper-container');
                        wrapper.find('.electron-loop-product').each(function(){
                            $(this).addClass('swiper-slide');
                        });
                        const mySlider = new NTSwiper('.electron-tab-wrapper[data-id="<?php echo $id; ?>"] .electron-swiper-container',options);

                        jQuery('.electron-tab-wrapper .electron-swiper-container').each(function(){
                            jQuery(this).css('height','auto');
                            var height = jQuery(this).css('height');
                            jQuery(this).css('height',height);
                        });

                        jQuery(window).resize(function(){
                            jQuery('.electron-tab-wrapper .electron-swiper-container').each(function(){
                                jQuery(this).css('height','auto');
                                var height = jQuery(this).css('height');
                                jQuery(this).css('height',height);
                            });
                        });
                    });

                </script>
                <?php
            } else {
                ?>
                <script>
                    jQuery(document).ready(function($){
                        var wrapper = $('.electron-tab-wrapper[data-id="<?php echo $id; ?>"]');
                        var options = wrapper.data('swiper-options');
                        const mySlider = new NTSwiper('.electron-tab-wrapper[data-id="<?php echo $id; ?>"] .electron-swiper-container',options);
                    });
                </script>
                <?php
            }
        }
        if ( $this->imgSize() == 'custom' ) {
            remove_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            remove_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            remove_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }
    }
}
