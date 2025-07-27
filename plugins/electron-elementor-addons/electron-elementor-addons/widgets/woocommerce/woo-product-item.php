<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Product_Item extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-product-item';
    }
    public function get_title() {
        return 'Product';
    }
    public function get_icon() {
        return 'eicon-image-box';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'wc', 'woo', 'product' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'post_query_section',
            [
                'label' => esc_html__( 'Query', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'post_filter',
            [
                'label' => esc_html__( 'Select Product(s)', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => [],
                'ajax' => [
                    'url' => admin_url('admin-ajax.php'),
                    'dataType' => 'json',
                    'data' => [
                        'action'    => 'fetch_data_for_select2',
                        'data_type' => 'product'
                    ]
                ],
                'description' => 'Select Specific Post(s)'
            ]
        );
        // Post Filter Heading
        $this->add_control( 'post_filter_heading',
            [
                'label' => esc_html__( 'Post Filter', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'defult' => 'large'
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
    }
    
    public function imgSize() {
        $settings  = $this->get_settings_for_display();
        $mobsize = wp_is_mobile() ? 'mob_' : '';
        $size = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'woocommerce_thumbnail';
        return $size;
    }
    
    protected function render() {
        
        $settings  = $this->get_settings_for_display();
        $elementid = $this->get_id();
        
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 1,
            'p' => $settings['post_filter'],
        );
        
        add_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                wc_get_template_part( 'content', 'product' );
            }
        }
        wp_reset_postdata();
        remove_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        
    }
}
