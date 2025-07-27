<?php

/*************************************************
## Load More Button
*************************************************/
function electron_load_more_button(){
    $cur = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $max = wc_get_loop_prop( 'total_pages' );
    if ( $max > $cur ) {
        return '<div class="row row-more electron-more">
        <div class="col-12 nt-pagination electron-justify-center">
        <div class="electron-btn electron-btn-primary electron-solid electron-radius electron-btn-medium electron-load-more"
        data-title="'.esc_html__('Loading...','electron').'"
        data-nomore="'.esc_html__('All Products Loaded','electron').'">'.esc_html__('Load More','electron').'</div>
        </div>
        </div>';
    }
}

/*************************************************
## Infinite Pagination
*************************************************/
function electron_infinite_scroll(){
    $cur = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $max = wc_get_loop_prop( 'total_pages' );
    if ( $max > $cur ) {
        return '<div class="row row-infinite electron-more">
        <div class="col-12 nt-pagination electron-justify-center">
        <div class="electron-load-more"
        data-title="'.esc_html__('Loading...','electron').'"
        data-nomore="'.esc_html__('All Products Loaded','electron').'">'.esc_html__('Loading...','electron').'</div>
        </div>
        </div>';
    }
}


/*************************************************
## Load More CallBack
*************************************************/
add_action( 'wp_ajax_nopriv_electron_shop_load_more', 'electron_load_more_callback' );
add_action( 'wp_ajax_electron_shop_load_more', 'electron_load_more_callback' );
function electron_load_more_callback() {

    $args = array(
        's'              => $_POST['s'],
        'post_type'      => 'product',
        'posts_per_page' => $_POST['per_page'],
        'post_status'    => 'publish',
        'paged'          => $_POST['current_page'] + 1
    );

    if ( $_POST['is_shop'] == 'yes' && '1' == electron_settings( 'shop_custom_query_visibility', '0' ) ) {

        $scenario      = electron_settings( 'shop_custom_query_scenario' );
        $cats          = electron_settings( 'shop_custom_query_cats', null );
        $tags          = electron_settings( 'shop_custom_query_tags', null );
        $attrs         = electron_settings( 'shop_custom_query_attr', null );
        $order         = electron_settings( 'shop_custom_query_order' );
        $orderby       = electron_settings( 'shop_custom_query_orderby' );
        $cats_operator = 'include' == electron_settings( 'shop_custom_query_cats_operator' ) ? 'IN' : 'NOT IN';
        $tags_operator = 'include' == electron_settings( 'shop_custom_query_tags_operator' ) ? 'IN' : 'NOT IN';

        if ( !empty( $cats ) || !empty( $tags ) ) {
            $args['tax_query'] = array(
                'relation' => 'AND'
            );
        }

        if ( 'featured' == $scenario ) {

           $args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN'
            );

        } elseif ( 'on-sale' == $scenario ) {

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

        } elseif ( 'best' == $scenario ) {

            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = 'total_sales';

        } elseif ( 'rated' == $scenario ) {

            $args['meta_key'] = '_wc_average_rating';
            $args['order']    = 'DESC';
            $args['orderby']  = 'meta_value_num';

        } elseif ( 'popularity' == $scenario ) {

            $args['meta_key'] = 'total_sales';
            $args['order']    = 'DESC';
            $args['orderby']  = 'meta_value_num';

        } else {

            $args['order'] = $order;
            $args['orderby'] = $orderby;
        }

        if ( !empty( $cats ) ) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $cats,
                'operator' => $cats_operator
            );
        }

        if ( !empty( $tags ) ) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_tag',
                'field'    => 'term_id',
                'terms'    => $tags,
                'operator' => $tags_operator
            );
        }

        if ( !empty( $attrs ) ) {
            foreach ( $attrs as $key ) {

                $attr_terms     = electron_settings( 'shop_custom_query_attr_terms_'.$key );
                $terms_operator = 'include' == electron_settings( 'shop_custom_query_attr_terms_operator_'.$key ) ? 'IN' : 'NOT IN';
                $attr_id        = wc_attribute_taxonomy_id_by_name( $key );
                $attr_info      = wc_get_attribute( $attr_id );

                if ( !empty( $attr_terms ) ) {
                    $args['tax_query'][] = array(
                        'taxonomy' => $attr_info->slug,
                        'field'    => 'term_id',
                        'terms'    => $attr_terms,
                        'operator' => $terms_operator
                    );
                }
            }
        }
    }

    // Price Slider
    if ( $_POST['min_price'] != null || $_POST['max_price'] != null ) {
        $args['meta_query'][] = wc_get_min_max_price_meta_query( array(
          'min_price' => $_POST['min_price'],
          'max_price' => $_POST['max_price']
        ));
    }

    // On Sale Products
    if ( isset( $_POST['on_sale'] ) ) {
        $args['post__in'] = $_POST['on_sale'];
    }

    // Best Seller Products
    if ( isset( $_POST['best_seller'] ) ) {
        $args['meta_key'] = 'total_sales';
        $args['orderby']  = 'meta_value_num';
    }

    // Featured Products
    if ( isset( $_POST['featured'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured'
            )
        );
    }

    // Orderby
    $orderby_value = isset( $_POST['orderby'] ) ? wc_clean( (string) wp_unslash( $_POST['orderby'] ) ) : wc_clean( get_query_var( 'orderby' ) );

    if ( ! $orderby_value ) {
        if ( $_POST['is_search'] == 'yes' ) {
            $orderby_value = 'relevance';
        } else {
            $orderby_value = apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
        }
    }

    switch ( $orderby_value ) {
        case 'menu_order':
        $args['orderby'] = 'menu_order title';
        $args['order']   = 'ASC';
        break;
        case 'relevance':
        $args['orderby'] = 'relevance';
        $args['order']   = 'DESC';
        break;
        case 'price':
        add_filter( 'posts_clauses', array( WC()->query, 'order_by_price_asc_post_clauses' ) );
        break;
        case 'price-desc':
        add_filter( 'posts_clauses', array( WC()->query, 'order_by_price_desc_post_clauses' ) );
        break;
        case 'popularity':
        $args['meta_key'] = 'total_sales';
        add_filter( 'posts_clauses', array( WC()->query, 'order_by_popularity_post_clauses' ) );
        break;
        case 'rating':
        $args['meta_key'] = '_wc_average_rating'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
        $args['order']    = 'DESC';
        $args['orderby']  = 'meta_value_num';
        add_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
        break;
    }

    // Product Category Filter Widget on shop page
    if ( $_POST['filter_cat'] != null ) {
        if ( !empty( $_POST['filter_cat'] ) ) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => explode( ',', $_POST['filter_cat'] )
            );
        }
    }

    // Product Category Page
    if ( $_POST['is_cat'] == 'yes' && $_POST['cat_id'] != null ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'id',
            'terms'    => $_POST['cat_id']
        );
    }

    // Product Brands Filter Widget on shop page
    if ( $_POST['is_brand'] == 'yes' && $_POST['brand_id'] != null ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'electron_product_brands',
            'field'    => 'id',
            'terms'    => explode( ',', $_POST['filter_brand'] )
        );
    }

    // Product Brands Page
    if ( $_POST['is_brand'] == 'yes' && $_POST['brand_id'] != null ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'electron_product_brands',
                'field'    => 'id',
                'terms'    => $_POST['brand_id']
            )
        );
    }

    // Product Filter By widget
    if ( isset( $_POST['layered_nav'] ) ) {
        $choosen_attributes = $_POST['layered_nav'];

        foreach ( $choosen_attributes as $taxonomy => $data ) {
            $args['tax_query'][] = array(
                'taxonomy'         => $taxonomy,
                'field'            => 'slug',
                'terms'            => $data['terms'],
                'operator'         => 'and' === $data['query_type'] ? 'AND' : 'IN',
                'include_children' => false
            );
        }
    }
    // Product Filter By Coupon
    if ( isset( $_POST['coupon_code'] ) ) {
        $args['post__in'] = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish',
            'return' => 'ids',
            'coupon' => $_POST['coupon_code']
        ));
    }

    $type   = electron_settings( 'shop_product_type', 1 );
    $type   = apply_filters( 'electron_loop_product_type', $type );
    $column = '';

    if ( isset( $_POST['pstyle'] ) && $_POST['pstyle'] ) {
        $type = $_POST['pstyle'];
    }

    if ( isset( $_POST['column'] ) && $_POST['column'] ) {
        $column = $_POST['column'];
    }

    $animation  = apply_filters( 'electron_loop_product_animation', electron_settings( 'shop_product_animation_type', 'fadeInUp' ) );
    $css_class  = 'electron-loop-product type-'.$type;
    $css_class .= $column == '1' ? '' : ' animated '.$animation;
    $css_class .= ' perpage-'.$_POST['per_page'];

    //Loop
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post();
            global $product;

            if ( !empty( $product ) && $product->is_visible() ) {
                ?>
                <div <?php wc_product_class( $css_class, $product ); ?> data-product-animation="<?php echo esc_attr( $animation ); ?>">
                    <?php
                    if ( '1' == $column || $type == 'list' ) {
                        wc_get_template_part( 'product-type/type', 'list' );
                    } else {
                        wc_get_template_part( 'product-type/type', $type );
                    }
                    ?>
                </div>
                <?php
            }
        }
    }
    wp_reset_postdata();
    wp_die();
}
