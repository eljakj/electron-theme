<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Custom_Reviews extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-custom-reviews';
    }
    public function get_title() {
        return 'Reviews Grid & Slider';
    }
    public function get_icon() {
        return 'eicon-site-search';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'cat', 'wc', 'woo', 'product', 'search' ];
    }
    public function get_style_depends() {
        return [ 'electron-swiper','electron-wc-custom-reviews-slider' ];
    }
    public function get_script_depends() {
        return [ 'electron-swiper' ];
    }

    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'general_section',
            [
                'label' => esc_html__( 'REVIEWS', 'electron' ),
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
                'label' => esc_html__( 'Layout Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'slider',
                'options' => [
                    'slider' => esc_html__( 'Slider', 'electron' ),
                    'grid' => esc_html__( 'Grid', 'electron' )
                ]
            ]
        );
        $this->add_control( 'cardstyle',
            [
                'label' => esc_html__( 'Card/Box Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__( 'Style 1', 'electron' ),
                    'style2' => esc_html__( 'Style 2', 'electron' ),
                    'style3' => esc_html__( 'Style 3', 'electron' )
                ]
            ]
        );
        $this->add_responsive_control( 'col',
            [
                'label' => esc_html__( 'Column', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'default' => 5,
                'selectors' => ['{{WRAPPER}} .cr-reviews-grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr);'],
                'condition' => [ 'type' => 'grid' ]
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
                'selectors' => ['{{WRAPPER}} .cr-reviews-grid' => 'gap: {{SIZE}}px;'],
                'condition' => [ 'type' => 'grid' ]
            ]
        );
		$this->add_control('count',
			[
				'label' => esc_html__( 'Perpage Count', 'electron' ),
				'type' => Controls_Manager::NUMBER,
				'max' => 20,
				'min' => 0,
				'default' => 5,
				'description' => 'It is recommended to keep it between "0" and "5"'
			]
		);
		$this->add_control('show_products',
			[
				'label' => esc_html__( 'Show Products', 'electron' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);
		$this->add_control('product_links',
			[
				'label' => esc_html__( 'Products Links', 'electron' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);
        $this->add_control( 'sort',
            [
                'label' => esc_html__( 'Sort', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__( 'Date', 'electron' ),
                    'rating' => esc_html__( 'Rating', 'electron' )
                ]
            ]
        );
        $this->add_control( 'sort_by',
            [
                'label' => esc_html__( 'Sort By', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => esc_html__( 'ASC', 'electron' ),
                    'DESC' => esc_html__( 'DESC', 'electron' ),
                    'RAND' => esc_html__( 'RAND', 'electron' )
                ]
            ]
        );
        $this->add_control( 'categories',
            [
                'label' => esc_html__( 'Filter Category(s)', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)'
            ]
        );
        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            $this->add_control( 'products2',
                [
                    'label' => esc_html__( 'Add Product(s) IDs', 'electron' ),
                    'description' => esc_html__( 'Separate each id with comma', 'electron' ),
                    'type' => Controls_Manager::TEXTAREA
                ]
            );
        } else {
            $this->add_control( 'products',
                [
                    'label' => esc_html__( 'Filter Product(s)', 'electron' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $this->get_all_posts_by_type('product'),
                    'description' => 'Select Product(s)'
                ]
            );
        }
        $this->add_control( 'product_tags',
            [
                'label' => esc_html__( 'Filter Tag(s)', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_tag','name'),
                'description' => 'Select Tag(s)'
            ]
        );
        $this->add_control( 'avatars',
            [
                'label' => esc_html__( 'Avatars', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'initials',
                'options' => [
                    'initials' => esc_html__( 'Initials', 'electron' ),
                    'standard' => esc_html__( 'Standard', 'electron' ),
                    'false' => esc_html__( 'None', 'electron' )
                ]
            ]
        );
		$this->add_control('max_chars',
			[
				'label' => esc_html__( 'Max Chars', 'electron' ),
				'type' => Controls_Manager::NUMBER,
				'default' => ''
			]
		);
		$this->add_control('min_chars',
			[
				'label' => esc_html__( 'Min Chars', 'electron' ),
				'type' => Controls_Manager::NUMBER,
				'default' => ''
			]
		);
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('reviews_style_section',
            [
                'label' => esc_html__( 'REVIEWS STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control( 'box_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .cr-review-card-inner'
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
		$this->add_control('box_top_options',
			[
				'label' => esc_html__( 'Top Box', 'electron' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
        $this->add_responsive_control( 'box_top_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .top-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'box_top_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .top-row' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_top_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .cr-review-card .top-row'
            ]
        );
        $this->add_control('avatar_offset',
            [
                'label' => __( 'Avatar offset', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .review-thumbnail' => 'margin-right: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'name_color',
           [
               'label' => esc_html__( 'Name Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} cr-review-card .reviewer-name' => 'color: {{VALUE}};'
               ]
           ]
        );
		$this->add_control('box_rating_options',
			[
				'label' => esc_html__( 'Stars & Rating', 'electron' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
        $this->add_responsive_control( 'box_rating_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .rating-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'box_rating_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .rating-row' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control('rating_size',
            [
                'label' => __( 'Stars Size', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .cr-review-card .crstar-rating,
                    {{WRAPPER}} .cr-review-card .crstar-rating::before,
                    {{WRAPPER}} .cr-review-card .crstar-rating span' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .cr-review-card .crstar-rating' => 'height: {{SIZE}}px;'
                ]
            ]
        );
        $this->add_control('rating_width',
            [
                'label' => __( 'Stars Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .crstar-rating' => 'width: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'rating_color',
           [
               'label' => esc_html__( 'Stars Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .cr-review-card .crstar-rating' => 'color: {{VALUE}}!important;'
               ]
           ]
        );
        $this->add_control( 'rating_number__color',
           [
               'label' => esc_html__( 'Rating Number Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .cr-review-card .rating-label' => 'color: {{VALUE}};'
               ]
           ]
        );
		$this->add_control('reviews_text_options',
			[
				'label' => esc_html__( 'Review Text', 'electron' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
        $this->add_responsive_control( 'reviews_text_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .middle-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'reviews_text_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .middle-row' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'reviews_text_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .cr-review-card .middle-row'
            ]
        );
        $this->add_responsive_control( 'reviews_text_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .middle-row' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'reviews_text_bgcolor',
           [
               'label' => esc_html__( 'Background Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .cr-review-card .middle-row' => 'background-color: {{VALUE}}!important;']
           ]
        );
        $this->add_control( 'reviews_text_color',
           [
               'label' => esc_html__( 'Review Text Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .cr-review-card .middle-row p' => 'color: {{VALUE}};']
           ]
        );
        $this->add_control( 'reviews_date_color',
           [
               'label' => esc_html__( 'Date Text Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .cr-review-card .middle-row .datetime' => 'color: {{VALUE}};']
           ]
        );
		$this->add_control('bottom_product_options',
			[
				'label' => esc_html__( 'Bottom Product', 'electron' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
        $this->add_responsive_control( 'bottom_product_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .review-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'bottom_product_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .review-product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'bottom_product_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .cr-review-card .review-product',
            ]
        );
        $this->add_responsive_control( 'bottom_product_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .cr-review-card .review-product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'bottom_product_bgcolor',
           [
               'label' => esc_html__( 'Background Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .cr-review-card .review-product' => 'background-color: {{VALUE}};']
           ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bottom_product_name_typo',
                'label' => esc_html__( 'Review Text Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .cr-review-card .product-title'
            ]
        );
        $this->add_control( 'bottom_product_name_color',
           [
               'label' => esc_html__( 'Review Text Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .cr-review-card .product-title' => 'color: {{VALUE}};']
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
        $this->add_control( 'headerstyle',
            [
                'label' => esc_html__( 'Header Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__( 'Style 1', 'electron' ),
                    'style2' => esc_html__( 'Style 2', 'electron' ),
                    'style3' => esc_html__( 'Style 3', 'electron' )
                ]
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
        $this->add_control( 'header_desc',
            [
                'label' => esc_html__( 'Header Decription', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Header Decription'
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
        $this->start_controls_section('tab_header_style_section',
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
        if ( ! class_exists('WooCommerce') || ! class_exists('CR_Reviews_Slider') ) {
            return;
        }

        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        $products = '';

        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {

            $products = str_replace(' ', '', trim($settings['products2']) );
            $include = !empty($products) ? explode(',',$products) : '';

            if ( !empty($include) ) {
                $products = implode(',',$include);
            }
        } else {
            $products = !empty($settings['products']) ? implode(',',$settings['products']) : '';
        }

        $cats  = !empty($settings['categories']) ? implode(',',$settings['categories']) : '';
        $tags  = !empty($settings['product_tags']) ? implode(',',$settings['product_tags']) : '';
		$attr  = ' count="'.$settings['count'].'"';
		$attr .= 'yes' == $settings['show_products'] ? ' show_products="true"' : ' show_products="false"';
		$attr .= 'yes' == $settings['product_links'] ? ' product_links="true"' : ' product_links="false"';
		$attr .= ' sort_by="'.$settings['sort_by'].'"';
		$attr .= ' sort="'.$settings['sort'].'"';
		$attr .= ' categories="'.$cats.'"';
		$attr .= ' products="'.$products.'"';
		$attr .= ' product_tags="'.$tags.'"';
		$attr .= ' color_ex_brdr=""';
		$attr .= ' color_brdr=""';
		$attr .= ' color_ex_bcrd=""';
		$attr .= ' color_bcrd=""';
		$attr .= ' color_pr_bcrd=""';
		$attr .= ' color_stars=""';
		$attr .= ' avatars="'.$settings['avatars'].'"';
		$attr .= ' max_chars="'.$settings['max_chars'].'"';
		$attr .= ' min_chars="'.$settings['min_chars'].'"';
        $cardstyle = ' '.$settings['cardstyle'];

        $editmode   = \Elementor\Plugin::$instance->editor->is_edit_mode();
        $editmodeId = $editmode ? '-'.$id : '';

        $html = '';

        if ( 'yes' == $settings['header_display'] ) {
            $headerstyle = ' '.$settings['headerstyle'];
            $html .= '<div class="electron-widget-header '.$headerstyle.'">';

                if ( $settings['header_title'] ) {
                    $desc = $settings['header_desc'] ? '<span class="header-desc">'.$settings['header_desc'].'</span>' : '';
                    $html .= '<'.$settings['title_tag'].' class="electron-header-title">'.$settings['header_title'].$desc.'</'.$settings['title_tag'].'>';
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

        if (  'slider' == $settings['type'] ) {

            $mobspace = $settings['mobspace'] ? $settings['mobspace'] : $settings['space'];

            $slider_options = json_encode( array(
                "slidesPerView" => 1,
                "loop"          => 'yes' == $settings['loop'] || 'yes' == $settings['centermode'] ? true: false,
                "autoHeight"    => false,
                "rewind"        => false,
                "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                "wrapperClass"  => "electron-swiper-wrapper",
                "centeredSlides"=> 'yes' == $settings['centermode'] ? true : false,
                "centeredSlidesBounds" => 'yes' == $settings['centermode'] ? true : false,
                "watchSlidesProgress" => true,
                "speed"         => $settings['speed'],
                "spaceBetween"  => $settings['space'],
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

            $class  = 'electron-cr-slider has-height-container electron-swiper-container electron-swiper-slider'.$editmodeId.' nav-vertical-centered';

            $html .= '<div class="electron-cr-reviews-slider '.$class.' '.$cardstyle.'" data-swiper-options=\''.$slider_options.'\'>';
                $html .= '<div class="electron-swiper-wrapper">'.do_shortcode('[cusrev_reviews_slider'.$attr.']').'</div>';

                if ( 'yes' == $settings['dots'] ) {
                    $html .= '<div class="electron-swiper-pagination electron-pagination-'.$id.' position-relative"></div>';
                }

                if ( 'yes' == $settings['nav'] ) {
                    $html .= '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
                    $html .= '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
                }

            $html .= '</div>';

        } else {

            $html .= '<div class="electron-cr-grid cr-reviews-grid">'.do_shortcode('[cusrev_reviews_slider'.$attr.']').'</div>';
        }

        // final html
        echo '<div class="electron-cr-wrapper'.$cardstyle.'">'.$html.'</div>';

        if (  'slider' == $settings['type'] && $editmode ) {
            ?>
            <script>
            jQuery( document ).ready( function($) {
                const mySlider = new NTSwiper('.electron-swiper-slider-<?php echo $id; ?>', $('.electron-swiper-slider-<?php echo $id; ?>').data('swiper-options'));
            });
            </script>
            <?php
        }
    }
}
