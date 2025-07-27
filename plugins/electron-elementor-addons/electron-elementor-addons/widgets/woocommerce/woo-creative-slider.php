<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Creative_Slider extends \Elementor\Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-creative-slider';
    }
    public function get_title() {
        return 'Creative Slider';
    }
    public function get_icon() {
        return 'eicon-carousel';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_style_depends() {
        return [ 'creative-slider' ];
    }
    public function get_script_depends() {
        return [ 'creative-slider' ];
    }

    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'items_settings',
            [
                'label' => esc_html__('QUERY && LAYOUT', 'electron'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'scenario',
            [
                'label' => esc_html__( 'Select Scenario', 'electron' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'featured' => esc_html__( 'Featured', 'electron' ),
                    'on-sale' => esc_html__( 'On Sale', 'electron' ),
                    'rating' => esc_html__( 'Rating', 'electron' ),
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                    'best' => esc_html__( 'Best Selling', 'electron' ),
                    'custom' => esc_html__( 'Specific Categories', 'electron' )
                ],
                'default' => 'custom2'
            ]
        );
        $this->add_control( 'post_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'electron' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 2,
                'condition' => [ 'scenario!' => 'custom2' ]
            ]
        );
        $this->add_control( 'category_filter_type',
            [
                'label' => esc_html__( 'Category Filter Type', 'electron' ),
                'type' => \Elementor\Controls_Manager::SELECT,
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
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)',
                'condition' => [ 'scenario' => 'custom' ]
            ]
        );
        $this->add_control( 'post_other_heading',
            [
                'label' => esc_html__( 'OTHER FILTER', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'order',
            [
                'label' => esc_html__( 'Select Order', 'electron' ),
                'type' => \Elementor\Controls_Manager::SELECT,
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
                'type' => \Elementor\Controls_Manager::SELECT,
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
        $this->add_control( 'slider_bg_divider',
            [
                'label' => esc_html__( 'SLIDER BACKGROUND', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'bg_img',
                'types' => ['classic','gradient'],
                'selector' => '{{WRAPPER}}  .cr-slider-wrapper'
            ]
        );
        $this->add_control( 'slide_item_bg_type',
            [
                'label' => esc_html__( 'Slide Item Background Type', 'electron' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__( 'Image', 'electron' ),
                    'bg' => esc_html__( 'Background Image or Color', 'electron' ),
                ],
                'default' => 'image',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'image_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .product-slider',
                'condition' => ['slide_item_bg_type' => 'bg']
            ]
        );
        $this->add_control( 'item_bg',
            [
                'label' => esc_html__( 'Slide Item Background Image', 'electron' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => ['slide_item_bg_type' => 'image']
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_sibg',
                'defult' => 'large',
                'condition' => ['slide_item_bg_type' => 'image']
            ]
        );
        $this->add_control( 'durability',
            [
                'label' => esc_html__( 'Durability', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control( 'logo',
            [
                'label' => esc_html__( 'Logo', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'price',
            [
                'label' => esc_html__( 'Product Price', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'rating',
            [
                'label' => esc_html__( 'Product Stars/Rating', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'stock',
            [
                'label' => esc_html__( 'Product Stock Status', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'wishlist',
            [
                'label' => esc_html__( 'Wishlist', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'logo_image_divider',
            [
                'label' => esc_html__( 'LOGO', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['logo' => 'yes']
            ]
        );
        $this->add_control( 'item_logo',
            [
                'label' => esc_html__( 'Left Logo Image', 'electron' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => ['logo' => 'yes']
            ]
        );
        $this->add_control( 'percentage',
            [
                'label' => esc_html__( 'Durability Percentage', 'electron' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 80,
                'condition' => ['durability' => 'yes']
            ]
        );
        $this->add_control( 'durability_text',
            [
                'label' => esc_html__( 'Durability Text', 'electron' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'DURABILITY RATE',
                'condition' => ['durability' => 'yes']
            ]
        );
        $this->add_control( 'product_image_divider',
            [
                'label' => esc_html__( 'PRODUCT IMAGE SIZE', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'defult' => 'large'
            ]
        );
        $this->add_control( 'mob_img_size_heading',
            [
                'label' => esc_html__( 'Mobile Image Size', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
            'name' => 'mob_thumbnail',
            'default' => 'woocommerce_thumbnail'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
       /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('slider_options_section',
            [
                'label'=> esc_html__( 'SLIDER OPTIONS', 'electron' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'loop',
            [
                'label' => esc_html__( 'Infinite', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Nav', 'electron' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'electron' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
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
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'logo_divider',
            [
                'label' => esc_html__( 'LOGO IMAGE', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_boxshadow',
                'selector' => '{{WRAPPER}} .bg-shape',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'image_bgclr',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .bg-shape',
            ]
        );
        $this->add_control( 'container_divider',
            [
                'label' => esc_html__( 'CONTAINER', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_boxshadow',
                'selector' => '{{WRAPPER}} .product-slider',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'container_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .product-slider',
            ]
        );
        $this->add_control( 'price_divider',
            [
                'label' => esc_html__( 'Content', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'price_color',
            [
                'label' => esc_html__( 'Price Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-slider-wrapper .electron-price' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_color',
            [
                'label' => esc_html__( 'Stock Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-slider-wrapper span.in-stock' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_bgcolor',
            [
                'label' => esc_html__( 'Stock Background Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-slider-wrapper span.in-stock' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_brdcolor',
            [
                'label' => esc_html__( 'Stock Border Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-slider-wrapper span.in-stock' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Title Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-slider-wrapper .product-slider__title' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-slider-wrapper,{{WRAPPER}} .cr-slider-wrapper .dot-list li' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'checked_color',
            [
                'label' => esc_html__( 'Checked Icon Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .cr-slider-wrapper .dot-list li:before' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'button_divider',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_boxshadow',
                'selector' => '{{WRAPPER}} .product-slider__cart',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .product-slider__cart a',
            ]
        );
        $this->add_control( 'wishlist_divider',
            [
                'label' => esc_html__( 'WISHLIST BUTTON', 'electron' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'button_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-slider__fav' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'button_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-slider__fav:nover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('navs_style_section',
            [
                'label'=> esc_html__( 'SLIDER NAV STYLE', 'electron' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['nav' => 'yes']
            ]
        );
        $this->add_control( 'navs_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-slider .nav' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-slider .nav svg' => 'fill:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-slider .nav:hover svg' => 'fill:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-slider .nav' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .product-slider .nav:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        $editmode = \Elementor\Plugin::$instance->editor->is_edit_mode() ? 'edit-mode-'.$id: '';

        $args = array(
            'post_type' => 'product',
            'order'     => $settings['order']
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
                "loop"       => 'yes' == $settings['loop'] ? true : false,
                "autoplay"   => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                "speed"      => $settings['speed'],
                "effect"     => 'fade',
                "init"       => false,
                "navigation" => [
                    "nextEl" => ".next-".$id,
                    "prevEl" => ".prev-".$id
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

        $html = $itembgimage = $bgshape = $ihtml = '';

        if ( !empty( $settings['item_bg']['id'] ) ) {
            $sibg_size = $settings['thumbnail_sibg_size'] ? $settings['thumbnail_sibg_size'] : 'full';
            if ( 'custom' == $sibg_size ) {
                $sibg_sizew = $settings['thumbnail_sibg_custom_dimension']['width'];
                $sibg_sizeh = $settings['thumbnail_sibg_custom_dimension']['height'];
                $sibg_size = [ $sibg_sizew, $sibg_sizeh ];
            }
            $itembgimage = wp_get_attachment_image( $settings['item_bg']['id'], $sibg_size, false, ['class'=>'product-slider__cover'] );
        }
        $logo = 'yes' != $settings['logo'] ? ' logo-none' : '';
        if ( 'yes' == $settings['logo'] ) {
            $bgshape .= '<div class="bg-shape">';
            if ( !empty( $settings['item_logo']['id'] ) ) {
                $bgshape .= wp_get_attachment_image( $settings['item_logo']['id'], 'full', false );
            }
            $bgshape .= '</div>';
        }
        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {

            $ihtml .= '<div class="product-img">';
                $count = 1;
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    global $product;
                    $pid    = $product->get_id();
                    $ihtml .= '<div class="product-img__item" id="img'.$count.'">';
                    $ihtml .= get_the_post_thumbnail( $pid, $size, ['class'=>'product-img__img'] );
                    $ihtml .= '</div>';
                    $count++;
                }
                wp_reset_postdata();
            $ihtml .= '</div>';

            $html .= '<div class="product-slider__wrp swiper-wrapper electron-swiper-wrapper">';
                $count2 = 1;
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    global $product;
                    $pid     = $product->get_id();
                    $type    = $product->get_type();
                    $name    = $product->get_name();
                    $rating  = $product->get_rating_count();
                    $review  = $product->get_review_count();
                    $average = $product->get_average_rating();
                    $availability = $product->get_availability();
                    $stock   = get_post_meta( $pid, '_stock', true );
                    $sold    = $product->get_total_sales();
                    $percentage = $sold > 0 && $stock > 0 ? round( $sold / $stock * 100 ) : 0;
                    $wllabel = esc_html__( 'Add to Wishlist', 'electron' );
                    $html .= '<div class="product-slider__item swiper-slide" data-target="img'.$count2.'" data-id="'.$pid.'">';
                        $html .= '<div class="product-slider__card type-'.$type.'">';

                            $html .= $itembgimage;

                            $html .= '<div class="product-slider__content">';
                                $html .= '<h1 class="product-slider__title">'.$name.'</h1>';
                                if ( 'yes' == $settings['price'] ) {
                                    $html .= '<div class="product-slider__price">';
                                        ob_start();
                                        woocommerce_template_loop_price();
                                        $html .= ob_get_clean();
                                    $html .= '</div>';
                                }
                                if ( 'yes' == $settings['rating'] || 'yes' == $settings['stock'] ) {
                                    $html .= '<span class="product-slider__rating">';
                                        if ( wc_review_ratings_enabled() && 'yes' == $settings['rating'] ) {
                                            ob_start();
                                            woocommerce_template_single_rating();
                                            $html .= ob_get_clean();
                                        }
                                        if ( 'yes' == $settings['stock'] ) {
                                            $html .= '<span class="stock electron-stock-status">'.$availability['availability'].'</span>';
                                        }
                                    $html .= '</span>';
                                }

                                $html .= '<div class="product-ctr">';
                                    if ( $type == 'variable' ) {
                                        $html .= '<div class="product-labels">';
                                        $html .= '<div class="electron-swatches-wrapper">'.do_shortcode('[electron_swatches]').'</div>';
                                        $html .= '</div>';
                                    } else {
                                        $html .= $product->get_short_description();
                                    }
                                    if ( 'yes' == $settings['durability'] ) {
                                        $html .= '<span class="hr-vertical"></span>';
                                        $percentage_dur = ( (300 - $settings['percentage'] ) / $settings['percentage']  ) * 100;
                                        $html .= '<div class="product-inf">';
                                            $html .= '<div class="product-inf__percent">';
                                                $html .= '<div class="product-inf__percent-circle">';
                                                    $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">';
                                                        $html .= '<defs>';
                                                        $html .= '<linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">';
                                                        $html .= '<stop offset="0%" stop-color="#0c1e2c" stop-opacity="0" />';
                                                        $html .= '<stop offset="100%" stop-color="#cb2240" stop-opacity="1" />';
                                                        $html .= '</linearGradient>';
                                                        $html .= '</defs>';
                                                        $html .= '<circle cx="50" cy="50" r="47" stroke-dasharray="'.$percentage_dur.', 300" stroke="#cb2240" stroke-width="4" fill="none"/>';
                                                    $html .= '</svg>';
                                                $html .= '</div>';
                                                $html .= '<div class="product-inf__percent-txt">'.$settings['percentage'].'%</div>';
                                            $html .= '</div>';
                                            $html .= '<span class="product-inf__title">'.$settings['durability_text'].'</span>';
                                        $html .= '</div>';
                                    }
                                $html .= '</div>';

                                $html .= '<div class="product-slider__bottom">';
                                    $html .= '<div class="product-slider__cart">'.electron_add_to_cart('text').'</div>';
                                    $html .= '<div
                                    class="product-slider__fav js-fav woosw-btn wooswp-btn-'.esc_attr( $pid ).' woosw-btn-has-icon woosw-btn-icon-only"
                                    data-id="'.esc_attr( $pid ).'"
                                    data-product_name="'.esc_attr( $name ).'"
                                    data-label="'.esc_attr( $wllabel ).'"><span class="heart"></span>'.$wllabel.'</div>';
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                    $count2++;
                }
                wp_reset_postdata();
            $html .= '</div>';

            $html .= '<div class="prev disabled nav prev-'.$id.'">';
                $html .= '<span class="icon">';
                $html .= '<svg class="icon icon-arrow-right"><use xlink:href="#icon-arrow-left"></use></svg>';
                $html .= '</span>';
            $html .= '</div>';
            $html .= '<div class="next nav next-'.$id.'">';
                $html .= '<span class="icon">';
                $html .= '<svg class="icon icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg>';
                $html .= '</span>';
            $html .= '</div>';

            echo '<div class="cr-slider-wrapper'.$logo.'"><div class="cr-slider-content">'.$bgshape.$ihtml.'<div class="product-slider electron-swiper-container cr-slider'.$editmode.'" data-swiper-options=\''.$slider_options.'\'>'.$html.'</div></div></div>';

            echo '<svg class="hidden" hidden>
              <symbol id="icon-arrow-left" viewBox="0 0 32 32">
                <path d="M0.704 17.696l9.856 9.856c0.896 0.896 2.432 0.896 3.328 0s0.896-2.432 0-3.328l-5.792-5.856h21.568c1.312 0 2.368-1.056 2.368-2.368s-1.056-2.368-2.368-2.368h-21.568l5.824-5.824c0.896-0.896 0.896-2.432 0-3.328-0.48-0.48-1.088-0.704-1.696-0.704s-1.216 0.224-1.696 0.704l-9.824 9.824c-0.448 0.448-0.704 1.056-0.704 1.696s0.224 1.248 0.704 1.696z"></path>
              </symbol>
              <symbol id="icon-arrow-right" viewBox="0 0 32 32">
                <path d="M31.296 14.336l-9.888-9.888c-0.896-0.896-2.432-0.896-3.328 0s-0.896 2.432 0 3.328l5.824 5.856h-21.536c-1.312 0-2.368 1.056-2.368 2.368s1.056 2.368 2.368 2.368h21.568l-5.856 5.824c-0.896 0.896-0.896 2.432 0 3.328 0.48 0.48 1.088 0.704 1.696 0.704s1.216-0.224 1.696-0.704l9.824-9.824c0.448-0.448 0.704-1.056 0.704-1.696s-0.224-1.248-0.704-1.664z"></path>
              </symbol>
            </svg>';
        } else {
            echo '<div class="cr-slider-wrapper'.$logo.'">No Products Found</div>';
        }

        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
            <script>
                jQuery(document).ready( function($) {
                    var swiper = new NTSwiper('.cr-slideredit-mode-<?php echo $id; ?>', {
                        spaceBetween : 30,
                        effect       : 'fade',
                        loop         : false,
                        init         : false,
                        navigation   : {
                            nextEl: '.next',
                            prevEl: '.prev'
                        }
                    });

                    swiper.on('init', function () {
                        var index = this.activeIndex;

                        var target = $('.product-slider__item').eq(index).data('target');

                        $('.product-img__item').removeClass('active');
                        $('.product-img__item#'+ target).addClass('active');
                    });

                    swiper.on('slideChange', function () {
                        var index = this.activeIndex;

                        var target = $('.product-slider__item').eq(index).data('target');

                        $('.product-img__item').removeClass('active');
                        $('.product-img__item#'+ target).addClass('active');

                        if(swiper.isEnd) {
                            $('.prev').removeClass('disabled');
                            $('.next').addClass('disabled');
                        } else {
                            $('.next').removeClass('disabled');
                        }

                        if(swiper.isBeginning) {
                            $('.prev').addClass('disabled');
                        } else {
                            $('.prev').removeClass('disabled');
                        }
                    });
                    swiper.init();

                    $(".js-fav").on("click", function() {
                        $(this).find('.heart').toggleClass("is-active");
                    });
                });
            </script>
            <?php
        }
    }
}
