<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Grid extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-grid';
    }
    public function get_title() {
        return 'Products Grid';
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
        $this->start_controls_section( 'post_query_scenario_section',
            [
                'label' => esc_html__( 'Query', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'grid_style',
            [
                'label' => esc_html__( 'Style', 'electron' ),
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
        $this->add_responsive_control( 'col',
            [
                'label' => esc_html__( 'Column', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'default' => 5,
                'selectors' => ['{{WRAPPER}} .electron-products' => 'grid-template-columns: repeat({{SIZE}}, 1fr);']
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
                'condition' => [ 'grid_style!' => 'style-border-outside' ]
            ]
        );
        $this->add_control( 'query_heading',
            [
                'label' => esc_html__( 'QUERY', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
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
                    'newest'     => esc_html__( 'Newest', 'electron' ),
                    'featured'   => esc_html__( 'Featured', 'electron' ),
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                    'rated'      => esc_html__( 'Top Rated', 'electron' ),
                    'best'       => esc_html__( 'Best Selling', 'electron' ),
                    'sale'       => esc_html__( 'On Sale', 'electron' ),
                    'attr'       => esc_html__( 'Attribute Display', 'electron' ),
                    'custom_cat' => esc_html__( 'Specific Categories', 'electron' ),
                    'brands'     => esc_html__( 'Specific Brands', 'electron' ),
                    'recent'     => esc_html__( 'Recent Products', 'electron' ),
                ],
                'default' => 'newest'
            ]
        );
        $this->add_control( 'limit',
            [
                'label' => esc_html__( 'Posts Per Page', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => count( get_posts( array('post_type' => 'product', 'post_status' => 'publish', 'fields' => 'ids', 'posts_per_page' => '-1') ) ),
                'default' => 12
            ]
        );
        $this->add_control( 'attribute',
            [
                'label' => esc_html__( 'Select Attribute', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_woo_attributes(),
                'condition' => [ 'scenario' => 'attr','scenario!' => 'brands' ]
            ]
        );
        $this->add_control( 'attr_terms',
            [
                'label' => esc_html__( 'Select Attribute Terms', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_woo_attributes_taxonomies(),
                'condition' => [ 'scenario' => 'attr','scenario!' => 'brands' ]
            ]
        );
        $this->add_control( 'cat_filter',
            [
                'label' => esc_html__( 'Filter Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'condition' => [ 'scenario!' => 'brands' ]
            ]
        );
        $this->add_control( 'cat_operator',
            [
                'label' => esc_html__( 'Category Operator', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'AND' => esc_html__( 'display all of the chosen categories', 'electron' ),
                    'IN' => esc_html__( 'display products within the chosen category', 'electron' ),
                    'NOT IN' => esc_html__( 'display products that are not in the chosen category.', 'electron' ),
                ],
                'default' => 'IN',
                'condition' => [ 'scenario!' => 'brands' ]
            ]
        );
        $electronOptions = get_option('electron');
        $brands1 = taxonomy_exists('electron_product_brands') ? $this->electron_cpt_taxonomies('electron_product_brands') : array();
        $brands2 = taxonomy_exists('product_brand') ? $this->electron_cpt_taxonomies('product_brand') : array();
        $brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == 'yes' ? $brands1 : $brands2;
        $this->add_control( 'brands_filter',
            [
                'label' => esc_html__( 'Filter Brands', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $brandsTax,
                'condition' => [ 'scenario' => 'brands' ]
            ]
        );
        $this->add_control( 'brands_operator',
            [
                'label' => esc_html__( 'Brands Operator', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'AND' => esc_html__( 'display all of the chosen brands', 'electron' ),
                    'IN' => esc_html__( 'display products within the chosen brands', 'electron' ),
                    'NOT IN' => esc_html__( 'display products that are not in the chosen brands.', 'electron' ),
                ],
                'default' => 'IN',
                'condition' => [ 'scenario' => 'brands' ]
            ]
        );
        $this->add_control( 'tag_filter',
            [
                'label' => esc_html__( 'Filter Tag(s)', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_tag','name'),
                'condition' => [ 'scenario!' => 'brands' ]
            ]
        );
        $this->add_control( 'tag_operator',
            [
                'label' => esc_html__( 'Tags Operator', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'AND' => esc_html__( 'display all of the chosen tags', 'electron' ),
                    'IN' => esc_html__( 'display products within the chosen tags', 'electron' ),
                    'NOT IN' => esc_html__( 'display products that are not in the chosen tags.', 'electron' ),
                ],
                'default' => 'IN',
                'condition' => [ 'scenario!' => 'brands' ]
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
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                    'rand' => esc_html__( 'Random', 'electron' ),
                    'rating' => esc_html__( 'Rating', 'electron' ),
                    'date' => esc_html__( 'Date', 'electron' ),
                    'title' => esc_html__( 'Title', 'electron' ),
                ],
                'default' => 'id',
                'condition' => [ 'scenario!' => 'custom_cat','scenario!' => 'popularity' ]
            ]
        );
        $this->add_control( 'cat_orderby',
            [
                'label' => esc_html__( 'Order By', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'id' => esc_html__( 'Post ID', 'electron' ),
                    'menu_order' => esc_html__( 'Menu Order', 'electron' ),
                    'name' => esc_html__( 'Name', 'electron' ),
                    'slug' => esc_html__( 'Slug', 'electron' ),
                ],
                'default' => 'id',
                'condition' => [ 'scenario' => 'custom_cat' ]
            ]
        );
        $this->add_control( 'show_cat_empty',
            [
                'label' => esc_html__( 'Show Empty Categories', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'electron' ),
                'label_off' => esc_html__( 'No', 'electron' ),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [ 'scenario' => 'custom_cat' ]
            ]
        );
        $this->add_control( 'thumbnail_heading',
            [
                'label' => esc_html__( 'IMAGE SIZE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
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
        $this->add_control( 'paginate_heading',
            [
                'label' => esc_html__( 'PAGINATION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'paginate',
            [
                'label' => esc_html__( 'Pagination', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'paginate_type',
            [
                'label' => esc_html__( 'Pagination Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__( 'Ajax Pagination', 'electron' ),
                    'loadmore' => esc_html__( 'Ajax Load More', 'electron' )
                ],
                'default' => 'default',
                'condition' => [ 'paginate' => 'yes' ]
            ]
        );
        $this->add_control( 'load_type',
            [
                'label' => esc_html__( 'Load More Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'append' => esc_html__( 'Append', 'electron' ),
                    'replace' => esc_html__( 'Replace', 'electron' ),
                ],
                'default' => 'append',
                'condition' => [ 'paginate' => 'yes' ]
            ]
        );
        $this->add_control( 'push_url',
            [
                'label' => esc_html__( 'Push URL', 'electron' ),
                'desc' => esc_html__( 'Use pushState to add a browser history entry upon navigation', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [ 'paginate' => 'yes' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('post_style_section',
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
                'selectors' => ['{{WRAPPER}} .woocommerce.electron-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'post_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .woocommerce.electron-product' => 'background-color: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'post_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .woocommerce.electron-product'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'electron' ),
                'selector' => '{{WRAPPER}} .woocommerce.electron-product'
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
                'selector' => '{{WRAPPER}} .woocommerce.electron-product .electron-product-name'
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .woocommerce.electron-product .electron-product-name' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .woocommerce.electron-product span.del > span' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'price_color2',
            [
                'label' => esc_html__( 'Price Color 2', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}}  div.product .woocommerce.electron-product .electron-price' => 'color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} div.product .woocommerce.electron-product .electron-price'
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

    public function pagination_type () {
        $settings = $this->get_settings_for_display();

        return $settings['paginate_type'];
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

        } elseif ( 'brands' == $settings['scenario'] && !empty($settings['brands_filter']) ) {
            $electronOptions = get_option('electron');
            $brands1 = taxonomy_exists('electron_product_brands') ? 'electron_product_brands' : '';
            $brands2 = taxonomy_exists('product_brand') ? 'product_brand' : '';
            $brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == 'yes' ? $brands1 : $brands2;
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $brandsTax,
                    'field'    => 'id',
                    'terms'    => $settings['brands_filter'],
                    'operator' => $settings['brands_operator']
                )
            );

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
                    'field'    => 'id',
                    'terms'    => $settings['cat_filter'],
                    'operator' => $settings['cat_operator'],
                    'include_children' => 'AND' === $this->attributes['cat_operator'] ? false : true
                )
            );
        }

        if ( $settings['tag_filter'] ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_tag',
                    'field'    => 'id',
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
            $html .= '<div class="electron-products products">';
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    global $product;
                    ob_start();
                    wc_get_template_part( 'content', 'product' );
                    $html .= ob_get_clean();
                }
            $html .= '</div>';
            wp_reset_postdata();

            $total = $the_query->max_num_pages;

            if ( $total > 1 && 'yes' == $settings['paginate'] ){
                $current = max(1, $paged);

                $html .= '<nav class="electron-woocommerce-pagination '.$settings['paginate_type'].'" data-max="'.$total.'" data-current="'.$current.'">';
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
        $elementid = $this->get_id();

        $limit          = 'limit="'.$settings['limit'].'"';
        $order          = ' order="'.$settings['order'].'"';
        $orderby        = ' orderby="'.$settings['orderby'].'"';
        $paginate       = 'yes' == $settings['paginate'] ? ' paginate="true"' : '';
        $hide_empty     = 'yes' == $settings['show_cat_empty'] ? ' hide_empty="0"' : '';
        $operator       = ' cat_operator="'.$settings['cat_operator'].'"';
        $tag_operator   = ' tag_operator="'.$settings['tag_operator'].'"';
        $cat_orderby    = ' orderby="'.$settings['cat_orderby'].'"';
        $cat_filter     = is_array($settings['cat_filter']) ? ' category="'.implode(', ',$settings['cat_filter']).'"' : '';
        $hide_empty_cat = 'yes' == $settings['show_cat_empty'] ? ' hide_empty="0"' : '';
        $tag_filter     = is_array($settings['tag_filter']) ? ' tag="'.implode(', ',$settings['tag_filter']).'"' : '';
        $attr_filter    = is_array($settings['attribute']) ? ' attribute="'.implode(', ',$settings['attribute']).'"' : '';
        $attr_terms     = is_array($settings['attr_terms']) ? ' terms="'.implode(', ',$settings['attr_terms']).'"' : '';
        $paginate_type  = 'yes' == $settings['paginate'] ? ' has-pagination pagination-'.$settings['paginate_type'] : '';
        $paginate_type .= 'yes' == $settings['paginate'] && 'infinite' != $settings['paginate_type'] ? ' '.$settings['load_type'] : '';
        $push_url       = 'yes' == $settings['push_url'] ? 'true' : 'false';

        if ( $this->imgSize() == 'custom' ) {
            add_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            add_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            add_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        add_filter( 'electron_wc_pagination_class', [$this, 'pagination_type'] );

        $html = '';

        if ( 'yes'== $settings['paginate'] ) {
            wp_enqueue_script( 'pjax' );
        }

        if ( 'theme' == $settings['query_type'] ) {

            $html .= $this->get_custom_query();

        } else {
            remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
            remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
            if ( 'newest' == $settings['scenario'] ) {
                $html .= do_shortcode('[products '.$limit.$cat_filter.$tag_filter.$orderby.$order.$paginate.' visibility="visible"]');
            } elseif ( 'featured' == $settings['scenario'] ) {
                $html .= do_shortcode('[featured_products '.$limit.$orderby.$order.$tag_filter.$cat_filter.$paginate.']');
            } elseif ( 'popularity' == $settings['scenario'] ) {
                $html .= do_shortcode('[products '.$limit.$order.$tag_filter.$paginate.' orderby="popularity" on_sale="true"]');
            } elseif ( 'best' == $settings['scenario'] ) {
                $html .= do_shortcode('[best_selling_products '.$limit.$orderby.$order.$cat_filter.$operator.$hide_empty_cat.$tag_filter.$tag_operator.$paginate.']');
            } elseif ( 'custom_cat' == $settings['scenario'] ) {
                $html .= do_shortcode('[products '.$limit.$cat_orderby.$order.$cat_filter.$operator.$hide_empty_cat.$tag_filter.$paginate.']');
            } elseif ( 'attr' == $settings['scenario'] ) {
                $html .= do_shortcode('[products '.$limit.$attr_filter.$attr_terms.$orderby.$order.$paginate.']');
            } elseif ( 'sale' == $settings['scenario'] ) {
                $html .= do_shortcode('[sale_products '.$limit.$attr_filter.$attr_terms.$orderby.$order.$paginate.']');
            } elseif ( 'rated' == $settings['scenario'] ) {
                $html .= do_shortcode('[top_rated_products '.$limit.$cat_filter.$tag_filter.$operator.$tag_operator.$order.$paginate.']');
            } elseif ( 'recent' == $settings['scenario'] ) {
                $html .= do_shortcode('[recent_products '.$limit.$order.$orderby.$paginate.']');
            }
        }

        if ( 'default' != $settings['paginate_type'] ) {
            $html .= '<div class="shop-loadmore-wrapper"></div>';
        }

        $style = 'style-bgcolor-outside' == $settings['grid_style'] ? 'style-bgcolor style-border-outside' : $settings['grid_style'];

        echo '<div class="shop-loop-wrapper '.$style.$paginate_type.'" data-id="'.$elementid.'" data-pushurl="'.$push_url.'">'.$html.'</div>';

        if ( $this->imgSize() == 'custom' ) {
            remove_filter( 'electron_single_product_archive_thumbnail_size', [$this, 'imgSize'] );
            remove_filter( 'electron_single_product_archive_thumbnail_custom_size', [$this, 'imgCustomSize'] );
        } else {
            remove_filter( 'single_product_archive_thumbnail_size', [$this, 'imgSize'] );
        }

        remove_filter( 'electron_wc_pagination_class', [$this, 'pagination_type'] );
    }
}
