<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Special_Offer extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-special-offer';
    }
    public function get_title() {
        return 'Products Special Offer';
    }
    public function get_icon() {
        return 'eicon-image-box';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'wc', 'woo', 'product', 'special' ];
    }
    public function get_style_depends() {
        return [ 'electron-deals' ];
    }
    public function get_script_depends() {
        return [ 'electron-countdown' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'widget_layout_section',
            [
                'label' => esc_html__( 'LAYOUT', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'type',
            [
                'label' => esc_html__( 'Layout Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'slider' => esc_html__( 'Slider', 'electron' ),
                    'grid' => esc_html__( 'Grid', 'electron' ),
                ],
                'default' => 'grid'
            ]
        );
        $this->add_control( 'header_style',
            [
                'label' => esc_html__( 'Header Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'header-style-1' => esc_html__( 'Style 1', 'electron' ),
                    'header-style-2' => esc_html__( 'Style 2', 'electron' ),
                    'header-style-3' => esc_html__( 'Style 3', 'electron' ),
                ],
                'default' => 'header-style-1'
            ]
        );
        $this->add_control( 'border_style',
            [
                'label' => esc_html__( 'Products Border Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'border-inside' => esc_html__( 'Border Inside', 'electron' ),
                    'border-outside' => esc_html__( 'Border Outside', 'electron' )
                ],
                'default' => 'border-inside'
            ]
        );
        $this->add_control( 'product_brdcolor',
            [
                'label' => esc_html__( 'Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .border-inside .deals-item' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .border-outside .deals-wrapper' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .border-outside .deals-wrapper .deals-item' => 'border-right-color: {{VALUE}};border-bottom-color: {{VALUE}};',
                    '{{WRAPPER}} .border-outside .electron-swiper-container' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .border-outside .electron-swiper-container .deals-item' => 'border-right-color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control( 'style',
            [
                'label' => esc_html__( 'Product Box Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'electron' ),
                    'style-2' => esc_html__( 'Style 2', 'electron' ),
                    'style-3' => esc_html__( 'Style 3', 'electron' ),
                    'style-4' => esc_html__( 'Style 4', 'electron' )
                ],
                'default' => 'style-1'
            ]
        );
        $this->add_responsive_control('col_width',
            [
                'label' => __( 'Columns Min Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'default' => [
                    'size' => 250
                ],
                'selectors' => ['{{WRAPPER}} .deals-wrapper' => 'grid-template-columns: repeat(auto-fit, minmax({{SIZE}}px, 1fr));'],
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
                'default' => [
                    'size' => 20
                ],
                'selectors' => ['{{WRAPPER}} .deals-wrapper' => 'gap: {{SIZE}}px;'],
                'condition' => [ 'type' => 'grid' ]
            ]
        );
        $this->add_responsive_control('image_column_width',
            [
                'label' => __( 'Image Column Max Width (%)', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .thumb-wrapper' => 'max-width: {{SIZE}}%;'],
                'condition' => [ 'style!' => 'style-3' ]
            ]
        );
        $this->add_control( 'slider_options_divider',
            [
                'label' => esc_html__( 'SLIDER OPTIONS', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'default' => 'no',
                'separator' => 'before',
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_responsive_control('slide_item_height',
            [
                'label' => __( 'Slide Item Min Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'default' => [
                    'size' => 150
                ],
                'selectors' => ['{{WRAPPER}} .electron-swiper-wrapper .deals-item' => 'min-height: {{SIZE}}px;'],
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'loop',
            [
                'label' => esc_html__( 'Infinite', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Navigation', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'dots',
            [
                'label' => esc_html__( 'Dots', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'space',
            [
                'label' => esc_html__( 'Space Between Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 20,
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 10000,
                'step' => 100,
                'default' => 1000,
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'items',
            [
                'label' => esc_html__( 'Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 8,
                'step' => 1,
                'default' => 5,
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'mditems',
            [
                'label' => esc_html__( 'Items Laptop', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 8,
                'step' => 1,
                'default' => 5,
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'smitems',
            [
                'label' => esc_html__( 'Items Tablet', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 2,
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_control( 'xsitems',
            [
                'label' => esc_html__( 'Items Phone', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 2,
                'step' => 1,
                'default' => 1,
                'condition' => [ 'type' => 'slider' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'thumbnail',
            'default' => 'woocommerce_thumbnail',
            'separator' => 'before',
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
        $this->add_control( 'header_display',
            [
                'label' => esc_html__( 'Header', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
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
        $this->start_controls_section( 'widget_query_section',
            [
                'label' => esc_html__( 'QUERY', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'scenario',
            [
                'label' => esc_html__( 'Select Scenario', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'featured' => esc_html__( 'Featured', 'electron' ),
                    'on-sale' => esc_html__( 'On Sale', 'electron' ),
                    'rating' => esc_html__( 'Rating', 'electron' ),
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                    'best' => esc_html__( 'Best Selling', 'electron' ),
                    'custom' => esc_html__( 'Specific Categories', 'electron' ),
                    'custom2' => esc_html__( 'Specific Products', 'electron' )
                ],
                'default' => 'custom2'
            ]
        );
        $this->add_control( 'post_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 4
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
                'default' => 'include',
                'condition' => [ 'scenario' => 'custom' ]
            ]
        );
        $this->add_control( 'category_filter',
            [
                'label' => esc_html__( 'Filter Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)',
                'condition' => [ 'scenario' => 'custom' ]
            ]
        );
        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            $this->add_control( 'post_filter2',
                [
                    'label' => esc_html__( 'Add Product(s) by IDs', 'electron' ),
                    'description' => esc_html__( 'Separate each id with comma', 'electron' ),
                    'type' => Controls_Manager::TEXTAREA,
                ]
            );
        } else {
            $this->add_control( 'post_filter',
                [
                    'label' => esc_html__( 'Select Product(s)', 'electron' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $this->get_all_posts_by_type('product')
                ]
            );
        }
        $this->add_control( 'post_filter_type',
            [
                'label' => esc_html__( 'Product Filter Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'post__in' => esc_html__( 'Include', 'electron' ),
                    'post__not_in' => esc_html__( 'Exclude', 'electron' ),
                ],
                'default' => 'post__in'
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
                'default' => 'id'
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
        $this->add_control( 'header_desc',
            [
                'label' => esc_html__( 'Short Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Time remaining until the end of the offer'
            ]
        );
        $this->add_control( 'timer_title',
            [
                'label' => esc_html__( 'Timer Title', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Hurry to take advantage of the offer'
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
        $this->add_control( 'header_desc_color',
            [
                'label' => esc_html__( 'Short Description Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-header-desc' => 'color: {{VALUE}};']
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
        $this->start_controls_section( 'timer_style_section',
            [
                'label'=> esc_html__( 'TIMER STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'timer' => 'yes' ]
            ]
        );
        $this->add_control( 'time_title_color',
            [
                'label' => esc_html__( 'Timer Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-timer-title' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'time_border',
                'selector' => '{{WRAPPER}} .time-count'
            ]
        );
        $this->add_responsive_control( 'time_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .time-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'time_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .time-count' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'time_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .time-count' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'time_brdcolor',
            [
                'label' => esc_html__( 'Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .time-count' => 'border-color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'time_last_color',
            [
                'label' => esc_html__( 'Last Item Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-timer .time-count:last-child' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'time_last_bgcolor',
            [
                'label' => esc_html__( 'Last Item Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-timer .time-count:last-child' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'time_last_brdcolor',
            [
                'label' => esc_html__( 'Last Item Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-timer .time-count:last-child' => 'border-color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'time_sep_color',
            [
                'label' => esc_html__( 'Seperator Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-timer .separator' => 'color:{{VALUE}};' ],
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
                'selectors' => ['{{WRAPPER}} .time-count' => 'min-width:{{SIZE}}px;' ],
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
                'selectors' => ['{{WRAPPER}} .time-count' => 'min-height:{{SIZE}}px;' ],
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
                'selectors' => ['{{WRAPPER}} .electron-timer' => 'gap: {{SIZE}}px;']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('box_style_section',
            [
                'label'=> esc_html__( 'PRODUCT BOX STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control( 'box_sdivider',
            [
                'label' => esc_html__( 'ITEM BOX', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control( 'box_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .deals-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .deals-item'
            ]
        );
        $this->add_control( 'box_hvrbrdcolor',
            [
                'label' => esc_html__( 'Hover Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .deals-item:hover:before' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .deals-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_bxshodow',
                'label' => esc_html__( 'Box Shadow', 'electron' ),
                'selector' => '{{WRAPPER}} .deals-item'
            ]
        );
        $this->add_control( 'box_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .deals-item' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'box_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .deals-item:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Product Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [ '{{WRAPPER}} .deals-item .title a' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'title_hvrcolor',
            [
                'label' => esc_html__( 'Hover Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .deals-item .title a:hover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stars_color',
            [
                'label' => esc_html__( 'Stars Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .star-rating>span::before' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'price_color',
            [
                'label' => esc_html__( 'Price Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .price' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'price_color2',
            [
                'label' => esc_html__( 'Price Color 2', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .price .del span' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_color',
            [
                'label' => esc_html__( 'Stock Status Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .electron-stock-status' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_value_color',
            [
                'label' => esc_html__( 'Stock Status Value Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .stock-value' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'discount_bgcolor',
            [
                'label' => esc_html__( 'Discount Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .electron-label' => 'background-color: {{VALUE}};' ],
            ]
        );
        $this->add_control( 'discount_brdcolor',
            [
                'label' => esc_html__( 'Discount Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .electron-label' => 'border-color: {{VALUE}};' ],
            ]
        );
        $this->add_control( 'discount_color',
            [
                'label' => esc_html__( 'Discount Text Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .electron-label,{{WRAPPER}} .deals-item .discount-wrapper .label' => 'color: {{VALUE}};' ],
            ]
        );
        $this->add_control( 'available_value_color',
            [
                'label' => esc_html__( 'Discount Value Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .deals-item .discount-wrapper .value' => 'color: {{VALUE}};' ],
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
        $type     = $settings['type'];

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $settings['post_per_page'],
            'order'          => $settings['order'],
        );

        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            if ( !empty($settings['post_filter2']) ) {
                $products = str_replace(' ', '', trim($settings['post_filter2']) );
                $include  = !empty($products) ? explode(',',$products) : '';

                $args[$settings['post_filter_type']] = $include;
            }
        } else {
            if ( !empty($settings['post_filter']) ) {
                $args[$settings['post_filter_type']] = $settings['post_filter'];
            }
        }

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

        } elseif ( 'popularity' == $settings['scenario'] ) {

            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
            $args['meta_key'] = 'total_sales';

        } elseif ( 'rating' == $settings['scenario'] ) {

                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                $args['meta_key'] = '_wc_average_rating';

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
        $size = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'woocommerce_thumbnail';
        if ( 'custom' == $size ) {
            $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
            $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
            $size = [ $sizew, $sizeh ];
        }

        $editmode = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id: '';
        $btn_icon = 'vertical' == $settings['type'] ? 'icon' : 'button';

        if ( 'slider' == $settings['type'] ) {
            $slider_options = json_encode( array(
                "slidesPerView" => 1,
                "loop"          => 'yes' == $settings['loop'] ? true: false,
                "rewind"        => true,
                "watchSlidesProgress" => true,
                "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                "wrapperClass"  => "electron-swiper-wrapper",
                "speed"         => $settings['speed'],
                "spaceBetween"  => $settings['space'] && 'border-outside' != $settings['border_style'] ? $settings['space'] : 0,
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
                    "1025" => [
                        "slidesPerView"  => $settings['mditems'],
                        "slidesPerGroup" => $settings['mditems']
                    ],
                    "1240" => [
                        "slidesPerView"  => $settings['items'],
                        "slidesPerGroup" => $settings['items']
                    ],
                ]
            ));
        }
        $html = $phtml = '';

        $time = $settings['timer_date'];

        if ( 'yes' == $settings['header_display'] ) {

            $html .= '<div class="electron-widget-header">';
                if ( $settings['header_title'] ) {
                    $desc = $settings['header_desc'] ? '<span class="header-desc">'.$settings['header_desc'].'</span>' : '';
                    $has_desc = $settings['header_desc'] ? ' has-desc' : '';
                    $html .= '<'.$settings['title_tag'].' class="electron-header-title'.$has_desc.'">'.$settings['header_title'].$desc.'</'.$settings['title_tag'].'>';
                }

                if ( $time ) {

                    $current_time = date( 'Y/m/d' );

                    if ( ( $current_time == $time || $time < $current_time ) && 'yes' == $settings['update_date'] ) {
                        $next_time = $settings['new_time'];
                        $time      = date('Y/m/d', strtotime($time. ' + '.$next_time.' days'));
                    }
                    $time_data = '"date":"'.$time.'","expired":"'.$settings['expired'].'"';
                    $html .= '<div class="electron-timer-wrapper">';
                        if ( $settings['timer_title'] ) {
                            $html .= '<span class="electron-timer-title" >'.$settings['timer_title'].'</span>';
                        }
                        $html .= '<div class="electron-timer" data-countdown=\'{'.$time_data.'}\'>';
                            $html .= '<div class="time-count days"></div>';
                            $html .= '<span class="separator">:</span>';
                            $html .= '<div class="time-count hours"></div>';
                            $html .= '<span class="separator">:</span>';
                            $html .= '<div class="time-count minutes"></div>';
                            $html .= '<span class="separator">:</span>';
                            $html .= '<div class="time-count second"></div>';
                        $html .= '</div>';
                    $html .= '</div>';
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

        $style = $settings['style'];

        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                global $product;
                $pid     = $product->get_id();
                $price   = $product->get_price_html();
                $name    = $product->get_name();
                $rating  = $product->get_rating_count();
                $average = $product->get_average_rating();
                $link    = $product->get_permalink();
                $stock   = get_post_meta( $pid, '_stock', true );
                $sold    = $product->get_total_sales();
                $upsells = $product->get_upsell_ids();
                $class   = !empty($upsells) && is_array($upsells) ? ' has-upsell' : '';

                $phtml .= 'slider' == $type ? '<div class="swiper-slide">' : '';

                    if ( 'style-1' == $style ) {
                        $phtml .= '<div class="deals-item product-inner'.$class.'" data-id="'.$pid.'">';
                            if ( electron_product_extra_fetaures(false) ) {
                                $phtml .= '<div class="details-trigger"><span></span><span></span><span></span></div>';
                                $phtml .= '<div class="features-wrapper">'.electron_product_extra_fetaures(false).'</div>';
                            }
                            if ( function_exists('electron_product_discount') ) {
                                $phtml .= electron_product_discount(false);
                            }

                            $phtml .= '<div class="deals-product">';
                                $phtml .= '<div class="thumb-wrapper">';
                                    $phtml .= '<a class="deals-thumb" href="'.$link.'" title="'.$name.'">';
                                        $phtml .= get_the_post_thumbnail( $pid, $size );
                                    $phtml .= '</a>';
                                $phtml .= '</div>';

                                $phtml .= '<div class="deals-product-details">';
                                    $phtml .= '<div class="title"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></div>';
                                    $phtml .= '<span class="electron-price-wrapper price">'.$price.'</span>';

                                    if ( 'yes' == $settings['stock'] || 'yes' == $settings['rating'] ) {
                                        $phtml .= '<div class="stock-rating">';
                                            if ( 'yes' == $settings['stock'] ) {
                                                $phtml .= electron_loop_product_stock_status();
                                            }
                                            if ( wc_review_ratings_enabled() && 'yes' == $settings['rating'] && $rating ) {
                                                $phtml .= '<div class="rating">';
                                                $phtml .= wc_get_rating_html( $average, $rating );
                                                $phtml .= '</div>';
                                            }
                                        $phtml .= '</div>';
                                    }
                                    $phtml .= '<div class="deals-buttons hint-top">';
                                        $phtml .= electron_add_to_cart('icon');
                                        $phtml .= electron_wishlist_button($pid,$name);
                                        $phtml .= electron_compare_button($pid,$name);
                                        $phtml .= electron_quickview_button($pid);
                                    $phtml .= '</div>';
                                $phtml .= '</div>';
                            $phtml .= '</div>';
                        $phtml .= '</div>';

                    } elseif ( 'style-2' == $style ) {

                        $phtml .= '<div class="deals-item product-inner'.$class.'" data-id="'.$pid.'">';
                            if ( function_exists('electron_product_discount') ) {
                                $phtml .= electron_product_discount(false);
                            }
                            $phtml .= '<div class="deals-product">';
                                $phtml .= '<div class="thumb-wrapper">';
                                    $phtml .= '<a class="deals-thumb" href="'.$link.'" title="'.$name.'">';
                                        $phtml .= get_the_post_thumbnail( $pid, $size );
                                    $phtml .= '</a>';
                                $phtml .= '</div>';

                                $phtml .= '<div class="deals-product-details">';
                                    $phtml .= '<div class="title"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></div>';

                                    $phtml .= '<span class="electron-price-wrapper price">'.$price.'</span>';

                                    if ( 'yes' == $settings['stock'] || 'yes' == $settings['rating'] ) {
                                        $phtml .= '<div class="stock-rating">';
                                            if ( 'yes' == $settings['stock'] ) {
                                                $phtml .= electron_loop_product_stock_status();
                                            }
                                            if ( wc_review_ratings_enabled() && 'yes' == $settings['rating'] && $rating ) {
                                                $phtml .= '<div class="rating">';
                                                $phtml .= wc_get_rating_html( $average, $rating );
                                                $phtml .= '</div>';
                                            }
                                        $phtml .= '</div>';
                                    }
                                $phtml .= '</div>';
                            $phtml .= '</div>';

                            $phtml .= '<div class="deals-footer">';
                                $phtml .= '<div class="deals-buttons hint-top">';
                                    $phtml .= electron_wishlist_button($pid,$name);
                                    $phtml .= electron_compare_button($pid,$name);
                                    $phtml .= electron_quickview_button($pid);
                                $phtml .= '</div>';
                                $phtml .= electron_add_to_cart('button');
                            $phtml .= '</div>';

                        $phtml .= '</div>';

                    } elseif ( 'style-3' == $style ) {

                        $phtml .= '<div class="deals-item product-inner'.$class.'" data-id="'.$pid.'">';
                            if ( function_exists('electron_product_discount') ) {
                                $phtml .= electron_product_discount(false);
                            }
                            $phtml .= '<div class="deals-product">';
                                $phtml .= '<div class="thumb-wrapper">';
                                    $phtml .= '<a class="deals-thumb" href="'.$link.'" title="'.$name.'">';
                                        $phtml .= get_the_post_thumbnail( $pid, $size );
                                    $phtml .= '</a>';
                                $phtml .= '</div>';

                                $phtml .= '<div class="deals-product-details">';
                                    $phtml .= '<div class="title"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></div>';
                                    $phtml .= '<span class="electron-price-wrapper price">'.$price.'</span>';

                                    if ( 'yes' == $settings['stock'] || 'yes' == $settings['rating'] ) {
                                        $phtml .= '<div class="stock-rating">';
                                            if ( 'yes' == $settings['stock'] ) {
                                                $phtml .= electron_loop_product_stock_status();
                                            }
                                            if ( wc_review_ratings_enabled() && 'yes' == $settings['rating'] && $rating ) {
                                                $phtml .= '<div class="rating">';
                                                $phtml .= wc_get_rating_html( $average, $rating );
                                                $phtml .= '</div>';
                                            }
                                        $phtml .= '</div>';
                                    }
                                $phtml .= '</div>';

                                $phtml .= '<div class="deals-footer">';
                                    $phtml .= '<div class="deals-buttons hint-top">';
                                        $phtml .= electron_wishlist_button($pid,$name);
                                        $phtml .= electron_compare_button($pid,$name);
                                        $phtml .= electron_quickview_button($pid);
                                    $phtml .= '</div>';
                                    $phtml .= electron_add_to_cart('icon');
                                $phtml .= '</div>';

                            $phtml .= '</div>';
                        $phtml .= '</div>';

                    } else {

                        $phtml .= '<div class="deals-item product-inner'.$class.'" data-id="'.$pid.'">';
                            $phtml .= '<div class="deals-product">';
                                $phtml .= '<div class="thumb-wrapper">';
                                    $phtml .= '<a class="deals-thumb" href="'.$link.'" title="'.$name.'">';
                                        $phtml .= get_the_post_thumbnail( $pid, $size );
                                    $phtml .= '</a>';
                                $phtml .= '</div>';

                                $phtml .= '<div class="deals-product-details">';
                                    $phtml .= '<div class="title"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></div>';
                                    $phtml .= '<span class="electron-price-wrapper price">'.$price.'</span>';

                                    if ( 'yes' == $settings['stock'] || 'yes' == $settings['rating'] ) {
                                        $phtml .= '<div class="stock-rating">';
                                            if ( 'yes' == $settings['stock'] && function_exists('electron_loop_product_stock_status') ) {
                                                $phtml .= electron_loop_product_stock_status();
                                            }
                                           if ( wc_review_ratings_enabled() && 'yes' == $settings['rating'] && $rating ) {
                                                $phtml .= '<div class="rating">';
                                                $phtml .= wc_get_rating_html( $average, $rating );
                                                $phtml .= '</div>';
                                            }
                                        $phtml .= '</div>';
                                    }
                                    $phtml .= '<div class="deals-buttons hint-top">';
                                        $phtml .= electron_wishlist_button($pid,$name);
                                        $phtml .= electron_compare_button($pid,$name);
                                        $phtml .= electron_quickview_button($pid);
                                    $phtml .= '</div>';
                                $phtml .= '</div>';
                            $phtml .= '</div>';
                            $has_discount = function_exists('electron_product_discount2') && electron_product_discount2() ? ' has-discount' : '';
                            $phtml .= '<div class="deals-footer'.$has_discount.'">';
                                $phtml .= electron_add_to_cart('button');
                                if ( function_exists('electron_product_discount2') ) {
                                    $phtml .= electron_product_discount2(false);
                                }
                            $phtml .= '</div>';

                        $phtml .= '</div>';
                    }
                $phtml .= 'slider' == $type ? '</div>' : '';
            }
        }
        wp_reset_postdata();

        if ( 'grid' == $settings['type'] ) {
            $html .= '<div class="deals-wrapper">';
                $html .= $phtml;
            $html .= '</div>';

        } else {

            $html .= '<div class="electron-products-widget-slider electron-swiper-container electron-swiper-slider'.$editmode.' nav-vertical-centered" data-swiper-options=\''.$slider_options.'\'>';
                $html .= '<div class="electron-swiper-wrapper">';
                    $html .= $phtml;
                $html .= '</div>';

                if ( 'yes' == $settings['dots'] ) {
                    $html .= '<div class="electron-swiper-pagination electron-pagination-'.$id.' position-relative"></div>';
                }

                if ( 'yes' == $settings['nav'] ) {
                    $html .= '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
                    $html .= '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
                }
            $html .= '</div>';
        }
        $class  = 'type-'.$settings['type'];
        $class .= ' '.$settings['style'];
        $class .= ' '.$settings['border_style'];
        $class .= ' '.$settings['header_style'];
        echo  '<div class="electron-widget-product-special-offers '.$class.'">'.$html.'</div>';

        if ( 'slider' == $settings['type'] && \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
            <script>
                jQuery( document ).ready( function($) {
                    const mySlider = new NTSwiper('.electron-swiper-slider-<?php echo $id; ?>', $('.electron-swiper-slider-<?php echo $id; ?>').data('swiper-options'));
                });
            </script>
            <?php
        }

        if (  \Elementor\Plugin::$instance->editor->is_edit_mode() && $time ) { ?>
                <script>
                jQuery(document).ready(function($){

                    $('.electron-timer').each(function () {
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

                            var now = new Date().getTime();

                            var distance = countDownDate - now;

                            var days    = ('0' + Math.floor(distance / (1000 * 60 * 60 * 24))).slice(-2);
                            var hours   = ('0' + Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).slice(-2);
                            var minutes = ('0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).slice(-2);
                            var seconds = ('0' + Math.floor((distance % (1000 * 60)) / 1000)).slice(-2);

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
