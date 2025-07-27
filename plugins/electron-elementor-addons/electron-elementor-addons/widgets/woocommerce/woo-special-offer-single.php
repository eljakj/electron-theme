<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Special_Offer_Single extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-special-offer-single';
    }
    public function get_title() {
        return 'Product Special Offer Single';
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
         $this->add_control( 'style',
            [
                'label' => esc_html__( 'Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'electron-style-1' => esc_html__( 'Default Bordered', 'electron' ),
                    'electron-style-2' => esc_html__( 'Gradient', 'electron' )

                ],
                'default' => 'electron-style-1'
            ]
        );
        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            $this->add_control( 'post_filter2',
                [
                    'label' => esc_html__( 'Add Product by ID', 'electron' ),
                    'description' => esc_html__( 'Supports only one product', 'electron' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );
        } else {
            $this->add_control( 'post_filter',
                [
                    'label' => esc_html__( 'Select Product', 'electron' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => false,
                    'options' => $this->get_all_posts_by_type('product'),
                    'description' => 'Select Specific Post(s)',
                ]
            );
        }
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
        $this->add_control( 'header_title',
            [
                'label' => esc_html__( 'Header Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Header Title',
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
                'condition' => [ 'header_title!' => '' ]
            ]
        );
        $this->add_control( 'header_desc',
            [
                'label' => esc_html__( 'Header Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Header Description'
            ]
        );
        $this->add_control( 'header',
            [
                'label' => esc_html__( 'Header', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control( 'timer',
            [
                'label' => esc_html__( 'Timer', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'excerpt',
            [
                'label' => esc_html__( 'Product Short Description', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
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
        $this->add_control( 'progressbar',
            [
                'label' => esc_html__( 'Progressbar', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'sold_title',
            [
                'label' => esc_html__( 'Sold Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Sold:',
                'condition' => [ 'progressbar' => 'yes' ]
            ]
        );
        $this->add_control( 'available_title',
            [
                'label' => esc_html__( 'Available Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Available:',
                'condition' => [ 'progressbar' => 'yes' ]
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
        $this->start_controls_section('style_section',
            [
                'label'=> esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control( 'box_sdivider',
            [
                'label' => esc_html__( 'BOX', 'electron' ),
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
                'selector' => '{{WRAPPER}} .deals-item,{{WRAPPER}} .deals-item:before'
            ]
        );
        $this->add_control( 'box_hvrbrdcolor',
            [
                'label' => esc_html__( 'Hover Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .deals-item:hover,,{{WRAPPER}} .deals-item:hover:before' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .deals-item,{{WRAPPER}} .deals-item:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_bxshodow',
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
        $this->add_control( 'boxtitle_sdivider',
            [
                'label' => esc_html__( 'HEADING', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'boxtitle_color',
            [
                'label' => esc_html__( 'Heading Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .deals-heading .heading' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'boxdesc_color',
            [
                'label' => esc_html__( 'Description Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .deals-heading .desc' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'image_sdivider',
            [
                'label' => esc_html__( 'PRODUCT IMAGE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .deals-item .deals-thumb'
            ]
        );
        $this->add_responsive_control( 'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .deals-item .deals-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_control( 'title_sdivider',
            [
                'label' => esc_html__( 'PRODUCT TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .details-wrapper .title a' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'title_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .details-wrapper .title a:hover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'stars_heading',
            [
                'label' => esc_html__( 'RATING STARS', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'stars_color',
            [
                'label' => esc_html__( 'Stars Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .details-wrapper .star-rating>span::before' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'reviews_color',
            [
                'label' => esc_html__( 'Reviews Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .details-wrapper .rating .count' => 'color: {{VALUE}};' ]
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
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .deals-item .price' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'price_color2',
            [
                'label' => esc_html__( 'Price Color 2', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .deals-item .price .del span' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'status_heading',
            [
                'label' => esc_html__( 'STOCK STATUS', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'stock_status_color',
            [
                'label' => esc_html__( 'In Stock Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .deals-item .instock' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'stock_status_color2',
            [
                'label' => esc_html__( 'Out of Stock Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .deals-item .outofstock' => 'color: {{VALUE}};' ]
            ]
        );
        $this->add_control( 'progressbar_heading',
            [
                'label' => esc_html__( 'PROGRESSBAR', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'progressbar' => 'yes' ]
            ]
        );
        $this->add_control( 'progressbar_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .stock-progress' => 'background-color: {{VALUE}};' ],
                'condition' => [ 'progressbar' => 'yes' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .stock-progressbar',
            ]
        );
        $this->add_control( 'progressbar_label_color',
            [
                'label' => esc_html__( 'Label Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .status-label' => 'color: {{VALUE}};' ],
                'condition' => [ 'progressbar' => 'yes' ]
            ]
        );
        $this->add_control( 'progressbar_value_color',
            [
                'label' => esc_html__( 'Value Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .status-value' => 'color: {{VALUE}};' ],
                'condition' => [ 'progressbar' => 'yes' ]
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
                'selectors' => ['{{WRAPPER}} .electron-timer' => 'gap: {{SIZE}}px;',]
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
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'time_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .time-count',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'time_border',
                'selector' => '{{WRAPPER}} .deals-timer .time-count'
            ]
        );
        $this->add_responsive_control( 'time_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .deals-timer .time-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_control( 'time_sep_color',
            [
                'label' => esc_html__( 'Seperator Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .separator' => 'color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }

        $settings = $this->get_settings_for_display();

        $mobsize = wp_is_mobile() ? 'mob_' : '';
        $size = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'woocommerce_thumbnail';
        if ( 'custom' == $size ) {
            $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
            $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
            $size = [ $sizew, $sizeh ];
        }
        $product = '';
        $electron_options = get_option('electron');
        if ( isset( $electron_options['disable_product_list_filter'] ) && '1' == $electron_options['disable_product_list_filter'] ) {
            if ( !empty($settings['post_filter2']) ) {
                $products   = str_replace(' ', '', trim($settings['post_filter2']) );
                $productIds = !empty($products) ? explode(',',$products) : '';
                $productId  = is_array($productIds) ? $productIds[0] : '';
                $product = wc_get_product( $productId );
            }
        } else {
            $product = wc_get_product( $settings['post_filter'] );
        }

        if ( $product ) {

            $pid     = $product->get_id();
            $name    = $product->get_name();
            $price   = $product->get_price_html();
            $rating  = $product->get_rating_count();
            $average = $product->get_average_rating();
            $status  = $product->get_stock_status();
            $stock   = $product->get_stock_quantity();
            $regular = (float) $product->get_regular_price();
            $sale    = (float) $product->get_sale_price();
            $link    = get_permalink($pid);
            $stock2  = get_post_meta($pid, '_stock', true);
            $sold    = $product->get_total_sales();
            $value   = $sold > 0 && $stock2 > 0 ? round( $sold / $stock2 * 100 ) : 0;
            $time    = $settings['timer_date'];

            $cur_time = date( 'Y/m/d' );

            if ( $time && ( $cur_time == $time || $time < $cur_time ) && 'yes' == $settings['update_date'] ) {
                $new  = $settings['new_time'];
                $time = date('Y/m/d', strtotime($time. ' + '.$new.' days'));
            }

            $html = '';

            $html .= '<div class="deals-item deals-single '.$settings['style'].'">';
                if ( 'yes' == $settings['header'] ) {
                    $html .= '<div class="deals-heading">';
                        if ( $settings['header_title'] ) {
                            $html .= '<'.$settings['title_tag'].' class="heading">'.$settings['header_title'].'</'.$settings['title_tag'].'>';
                        }
                        if ( $settings['header_desc'] ) {
                            $html .= '<p class="desc">'.$settings['header_desc'].'</p>';
                        }
                    $html .= '</div>';
                }

                if ( $time ) {
                    $time = '"date":"'.$time.'","expired":"'.$settings['expired'].'"';
                    $html .= '<div class="electron-timer" data-countdown=\'{'.$time.'}\'>';
                        $html .= '<div class="time-count days"></div>';
                        $html .= '<span class="separator">:</span>';
                        $html .= '<div class="time-count hours"></div>';
                        $html .= '<span class="separator">:</span>';
                        $html .= '<div class="time-count minutes"></div>';
                        $html .= '<span class="separator">:</span>';
                        $html .= '<div class="time-count second"></div>';
                    $html .= '</div>';
                }

                $html .= '<div class="thumb-wrapper">';
                    if ( function_exists('electron_product_discount') ) {
                        $html .= electron_product_discount(false,false,$pid);
                    }

                    $html .= '<a class="deals-thumb" href="'.$link.'" title="'.$name.'">'.get_the_post_thumbnail( $pid, $size ).'</a>';

                    if ( 'electron-style-1' == $settings['style'] ) {
            			$html .= '<div class="deals-buttons hint-left">';
            			    $html .= electron_wishlist_button($pid,$name);;
                            $html .= electron_compare_button($pid,$name);
                            $html .= electron_quickview_button($pid);
                            $html .= electron_add_to_cart('icon',$pid);
            			$html .= '</div>';
                    }
                $html .= '</div>';

                $html .= '<div class="deals-product-details">';
                    $html .= '<div class="title"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></div>';

                    $html .= '<span class="electron-price price">'.$price.'</span>';

                    if ( 'yes' == $settings['stock'] || 'yes' == $settings['rating'] ) {
                        $html .= '<div class="stock-rating">';
                            if ( 'yes' == $settings['stock'] && $stock>0 && function_exists('electron_loop_product_stock_status') ) {
                                $html .= electron_loop_product_stock_status($status,$stock,true);
                            }
                            if ( wc_review_ratings_enabled() && 'yes' == $settings['rating'] && $rating ) {
                                $html .= '<div class="rating">';
                                $html .= wc_get_rating_html( $average, $rating );
                                $html .= '</div>';
                            }
                        $html .= '</div>';
                    }
                    if ( 'yes' == $settings['progressbar'] ) {
                        $html .= '<div class="progressbar-wrapper">';
                            $html .= '<div class="stock-progress">';
                                $html .= '<div class="stock-progressbar" style="width:'.$value.'%"></div>';
                            $html .= '</div>';
                            $html .= '<div class="stock-details">';
                                $html .= '<div class="stock-sold"><span class="status-label">'.$settings['sold_title'].' </span><span class="status-value">'.$sold.'</span></div>';
                                if ( $stock2>0  ) {
                                    $html .= '<div class="current-stock"><span class="status-label">'.$settings['available_title'].' </span><span class="status-value">'.wc_trim_zeros($stock2).'</span></div>';
                                }
                            $html .= '</div>';
                        $html .= '</div>';
                    }
                $html .= '</div>';
            $html .= '</div>';

            echo '<div class="electron-product-deals-single">'.$html.'</div>';
        } else {
            echo '<p>No product found</p>';
        }

        if (  \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
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
