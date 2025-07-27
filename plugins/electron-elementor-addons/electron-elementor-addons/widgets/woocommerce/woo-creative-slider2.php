<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Creative_Slider2 extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-creative-slider2';
    }
    public function get_title() {
        return 'Vertical Product Carousel';
    }
    public function get_icon() {
        return 'eicon-carousel';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_style_depends() {
        return [ 'electron-swiper', 'creative-slider2' ];
    }
    public function get_script_depends() {
        return [ 'electron-swiper', 'creative-slider' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'items_settings',
            [
                'label' => esc_html__('QUERY && LAYOUT', 'electron'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'style',
            [
                'label' => esc_html__( 'Slider Style', 'electron' ),
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
                'default' => 2
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
                    'label' => esc_html__( 'Add Product(s) IDs', 'electron' ),
                    'description' => esc_html__( 'Separate each id with comma', 'electron' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'condition' => [ 'scenario' => 'custom2' ]
                ]
            );
        } else {
            $this->add_control( 'post_filter',
                [
                    'label' => esc_html__( 'Select Product(s)', 'electron' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $this->get_all_posts_by_type('product'),
                    'condition' => [ 'scenario' => 'custom2' ]
                ]
            );
        }
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
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'electron' ),
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
        $this->add_control( 'available',
            [
                'label' => esc_html__( 'Available', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'available_title',
            [
                'label' => esc_html__( 'Available Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Available:',
                'condition' => [ 'available' => 'yes' ]
            ]
        );
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Description', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'button',
            [
                'label' => esc_html__( 'Button', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_responsive_control( 'slider_maxwidth',
            [
                'label' => esc_html__( 'Slider Max Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 4000,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 800,
                ],
                'selectors' => [ '{{WRAPPER}} .cr-product-slider' => 'max-width:{{SIZE}}{{UNIT}};' ]
            ]
        );
        $this->add_responsive_control( 'image_container_width',
            [
                'label' => esc_html__( 'Image Conteiner Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 40,
                ],
                'selectors' => [ '{{WRAPPER}} .cr-product-slider__img' => 'width:{{SIZE}}%;' ],
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
        $this->add_control( 'dots',
            [
                'label' => esc_html__( 'Dots', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'mousewheel',
            [
                'label' => esc_html__( 'Mousewheel', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
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
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('widget_style_section',
            [
                'label'=> esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'image_divider',
            [
                'label' => esc_html__( 'IMAGE', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_boxshadow',
                'selector' => '{{WRAPPER}} .cr-product-slider__img',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .cr-product-slider__img',
            ]
        );
        $this->add_control( 'container_divider',
            [
                'label' => esc_html__( 'CONTAINER', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_boxshadow',
                'selector' => '{{WRAPPER}} .cr-product-slider',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'container_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .cr-product-slider',
            ]
        );
        $this->add_control( 'price_divider',
            [
                'label' => esc_html__( 'Content', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'price_color',
            [
                'label' => esc_html__( 'Price Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__price span' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stars_color',
            [
                'label' => esc_html__( 'Stars Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .star-rating>span::before' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_color',
            [
                'label' => esc_html__( 'Stock Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__data .instock' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_bgcolor',
            [
                'label' => esc_html__( 'Stock Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__content span.in-stock' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_brdcolor',
            [
                'label' => esc_html__( 'Stock Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__content span.in-stock' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__title a' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__text,{{WRAPPER}} .cr-product-slider__text .dot-list li' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'checked_color',
            [
                'label' => esc_html__( 'Checked Icon Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__text .dot-list li:before' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'button_divider',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_boxshadow',
                'selector' => '{{WRAPPER}} .cr-product-slider__button a',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .cr-product-slider__button a',
            ]
        );
        $this->add_control( 'button_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__button a' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'button_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-product-slider__button a:nover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('dots_style_section',
            [
                'label'=> esc_html__( 'SLIDER DOTS STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['dots' => 'yes']
            ]
        );
        $this->add_responsive_control( 'dots_lp',
            [
                'label' => esc_html__( 'Dots Left Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [ '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-bullets.cr-product-slider__pagination' => 'left:{{SIZE}}%;' ]
            ]
        );
        $this->add_responsive_control( 'dots_tp',
            [
                'label' => esc_html__( 'Dots Top Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [ '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-bullets.cr-product-slider__pagination' => 'top:{{SIZE}}%;' ]
            ]
        );
        $this->add_control( 'dots_width',
            [
                'label' => esc_html__( 'Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-bullets.cr-product-slider__pagination' => 'width:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'dots_actwidth',
            [
                'label' => esc_html__( 'Active Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet-active' => 'width:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'dots_height',
            [
                'label' => esc_html__( 'Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet' => 'height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'dots_actheight',
            [
                'label' => esc_html__( 'Active Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet-active' => 'height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'dots_size',
            [
                'label' => esc_html__( 'Active Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
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
                'selectors' => ['{{WRAPPER}} .swiper-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin:{{SIZE}}px 0;']
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
                'selectors' => ['{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border',
                'selector' => '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet',
            ]
        );
        $this->add_responsive_control( 'dots_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color:{{VALUE}};' ]
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
                    '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
        $editmode = \Elementor\Plugin::$instance->editor->is_edit_mode() ? ' edit-mode edit-mode-'.$id: '';

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $settings['post_per_page'],
            'order'          => $settings['order'],
        );

        $electron_options = get_option('electron');
        if ( 'custom2' == $settings['scenario'] && isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            $post_filter2 = str_replace(' ', '', trim($settings['post_filter2']) );
            $include      = !empty($settings['post_filter2']) ? explode(',',$post_filter2) : '';
            if ( !empty($include) ) {
                $args['post__in'] = $include;
            }

        } else {
            if ( !empty($settings['post_filter']) ) {
                $args['post__in'] = $settings['post_filter'];
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

        $slider_options = json_encode( array(
                "slidesPerView" => 1,
                "loop"          => 'yes' == $settings['loop'] ? true : false,
                "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                "speed"         => $settings['speed'],
                "effect"        => 'fade',
                "spaceBetween"  => 30,
                "mousewheel"    => 'yes' == $settings['mousewheel'] ? true : false,
                "pagination" => [
                    "el"        => ".electron-pagination-$id",
                    "clickable" => true
                ],
                "breakpoints" => [
                    "0" => [
                        "mousewheel" => false
                    ],
                    "1024" => [
                        "mousewheel" => 'yes' == $settings['mousewheel'] ? true : false
                    ]
                ]
            )
        );

        $mobsize = wp_is_mobile() ? 'mob_' : '';
        $size = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'thumbnail';
        if ( 'custom' == $size ) {
            $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
            $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
            $size = [ $sizew, $sizeh ];
        }

        $html = '';

        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {
            $html .= '<div class="cr-product-slider__wrp swiper-wrapper electron-swiper-wrapper">';
                $count2 = 1;
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    global $product;
                    $pid     = $product->get_id();
                    $name    = $product->get_name();
                    $price   = $product->get_price_html();
                    $desc    = $product->get_short_description();
                    $name    = $product->get_name();
                    $link    = $product->get_permalink();
                    $type    = $product->get_type();
                    $rating  = $product->get_rating_count();
                    $average = $product->get_average_rating();
                    $stock   = get_post_meta( $pid, '_stock', true );

            		$html .= '<div class="swiper-slide" data-id="'.$pid.'">';
                		$html .= '<div class="cr-product-slider__item">';
                			$html .= '<div class="cr-product-slider__img">';
                				$html .= '<a class="cr-product-slider__link" href="'.$link.'" title="'.$name.'">'.get_the_post_thumbnail( $pid, $size ).'</a>';
                			$html .= '</div>';
                			$html .= '<div class="cr-product-slider__content">';
                                if ( 'yes' == $settings['title'] ) {
                                    $html .= '<div class="cr-product-slider__title"><a class="cr-product-slider__link" href="'.$link.'" title="'.$name.'">'.$name.'</a></div>';
                                }

                                if ( 'yes' == $settings['price'] ) {
                                    $html .= '<div class="cr-product-slider__price">';
                                        $html .= $price;
                                    $html .= '</div>';
                                }
                			    if ( 'yes' == $settings['stock'] || 'yes' == $settings['rating'] || 'yes' == $settings['available'] ) {
                                    $html .= '<div class="cr-product-slider__data">';
                                    if ( 'yes' == $settings['stock'] ) {
                                        $html .= electron_loop_product_stock_status();
                                    }
                                    if ( 'yes' == $settings['rating'] ) {
                                        $html .= wc_get_rating_html( $average, $rating );
                                    }
                                    $html .= '</div>';
                                }

                                if ( 'yes' == $settings['desc'] ) {
                                    $html .= '<div class="cr-product-slider__text">'.$desc.'</div>';
                                }
                                if ( 'yes' == $settings['button'] ) {
                                    $html .= '<div class="cr-product-slider__button">'.electron_add_to_cart('text').'</div>';
                                }
                			$html .= '</div>';
            		    $html .= '</div>';
            		$html .= '</div>';
                }
            $html .= '</div>';
            if ( 'yes' == $settings['dots'] ) {
                $html .= '<div class="cr-product-slider__pagination electron-pagination-'.$id.'"></div>';
            }

            echo '<div class="cr-product-slider'.$editmode.' electron-swiper-slider '.$settings['style'].'" data-swiper-options=\''.$slider_options.'\'>'.$html.'</div>';
        }
        wp_reset_postdata();

        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
            <script>
                jQuery(document).ready( function($) {
                    var productSlider2 = new NTSwiper('.cr-product-slider.edit-mode-<?php echo $id; ?>', {
                        spaceBetween : 30,
                        effect       : 'fade',
                        autoplay     : <?php echo 'yes' == $settings['autoplay'] ? '{pauseOnMouseEnter:true,disableOnInteraction:false}' : 'false'; ?>,
                        loop         : <?php echo 'yes' == $settings['loop'] ? 'true' : 'false'; ?> ,
                        speed        : <?php echo $settings['speed'] ? $settings['speed'] : 1000; ?>,
                        mousewheel   : <?php echo 'yes' == $settings['mousewheel'] ? '{invert: false}' : 'false'; ?>,
                        pagination   : {
                        el: '.cr-product-slider.edit-mode-<?php echo $id; ?> .cr-product-slider__pagination',
                            clickable: true
                        }
                    });
                });
            </script>
            <?php
        }
    }
}
