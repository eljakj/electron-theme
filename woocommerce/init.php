<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$electron_options = get_option('electron');


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );


/*************************************************
## ADD THEME SUPPORT FOR WOOCOMMERCE
*************************************************/
if ( ! function_exists( 'electron_wc_theme_setup' ) ) {
    add_action( 'after_setup_theme', 'electron_wc_theme_setup', 999999 );
    function electron_wc_theme_setup()
    {
        add_theme_support( 'woocommerce' );
        if ( '1' == electron_settings('electron_product_zoom', '1') ) {
            add_theme_support( 'wc-product-gallery-zoom' );
        }

        $thumbs_layout = apply_filters( 'electron_product_thumbs_layout', electron_settings( 'product_thumbs_layout', 'slider' ) );
        if ( $thumbs_layout == 'woo' ) {
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );
        }
    }
}

if ( isset( $electron_options['product_thumbs_layout'] ) && 'woo' != $electron_options['product_thumbs_layout'] ) {
    add_action( 'wp', 'electron_remove_zoom_lightbox_theme_support', 99 );
    function electron_remove_zoom_lightbox_theme_support() {
        remove_theme_support( 'wc-product-gallery-zoom' );
        remove_theme_support( 'wc-product-gallery-lightbox' );
        remove_theme_support( 'wc-product-gallery-slider' );
    }
}

/*************************************************
## Single Gallery Options
*************************************************/
if ( ! function_exists( 'electron_single_wc_gallery_options' ) ) {
    add_filter( 'woocommerce_single_product_carousel_options', 'electron_single_wc_gallery_options' );
    function electron_single_wc_gallery_options( $options )
    {
        $options['directionNav'] = true;

        return $options;
    }
}


// Remove each style one by one
if ( ! function_exists( 'electron_dequeue_wc_styles' ) ) {
    add_filter( 'woocommerce_enqueue_styles', 'electron_dequeue_wc_styles' );
    function electron_dequeue_wc_styles( $styles ) {
        unset( $styles['woocommerce-general'] ); // Remove the gloss
        unset( $styles['woocommerce-layout'] ); // Remove the layout
        unset( $styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation
        return $styles;
    }
}


/*************************************************
## Ajax Login/Register
*************************************************/

if ( isset( $electron_options['wc_ajax_login_register'] ) && '1' == $electron_options[ 'wc_ajax_login_register' ] ) {
    include ELECTRON_DIRECTORY . '/woocommerce/ajax-login/ajax-login.php';
}

if ( is_admin() ) {
    include ELECTRON_DIRECTORY . '/woocommerce/woocommerce-functions/product/admin.php';
}

include ELECTRON_DIRECTORY . '/woocommerce/product-init.php';
include ELECTRON_DIRECTORY . '/woocommerce/woocommerce-functions/product/frontend.php';
include ELECTRON_DIRECTORY . '/woocommerce/load-more/load-more.php';

if ( isset( $electron_options['checkout_form_customize'] ) && 'yes' == $electron_options[ 'checkout_form_customize' ] ) {
    include ELECTRON_DIRECTORY . '/woocommerce/woocommerce-functions/checkout.php';
}


/*************************************************
## WOOCOMMERCE PAGE TITLE FUNCTION
*************************************************/

if ( ! function_exists( 'electron_shop_page_title' ) ) {
    add_filter( 'woocommerce_page_title', 'electron_shop_page_title');
    function electron_shop_page_title( $page_title )
    {
        $tag = is_product() ? electron_settings( 'product_title_tag', 'h2' ) : electron_settings( 'shop_title_tag', 'h2' );
        if ( 'Shop' == $page_title && electron_settings( 'shop_title' ) ) {
            return '<'.$tag.' class="nt-hero-title page-title">'.electron_settings( 'shop_title' ).'</'.$tag.'>';
        } else {
            return '<'.$tag.' class="nt-hero-title page-title">'.$page_title.'</'.$tag.'>';
        }
    }
}


/*************************************************
## WOOCOMMERCE HERO FUNCTION
*************************************************/

if ( ! function_exists( 'electron_wc_hero_section' ) ) {
    add_action( 'electron_before_shop_content', 'electron_wc_hero_section', 10 );
    function electron_wc_hero_section()
    {
        $name = is_product() ? 'single_shop' : 'shop';
        $hero_visibility = electron_settings( $name.'_hero_visibility', '1' );
        if ( $hero_visibility == '0' ) {
            return;
        }
        $hero_type = electron_settings( $name.'_hero_layout_type', 'mini' );
        $hero_type = isset( $_GET['hero_type'] ) ? $_GET['hero_type'] : $hero_type;
        $class     = 'big' == $hero_type || 'cat-slider' == $hero_type ? ' page-hero-static' : '';

        $template_id      = apply_filters( 'electron_shop_hero_template_id', intval( electron_settings( 'shop_hero_elementor_templates' ) ) );
        $cats_template_id = apply_filters( 'electron_shop_category_hero_template_id', intval( electron_settings( 'shop_cats_hero_elementor_templates' ) ) );
        $tax_template_id  = apply_filters( 'electron_shop_tags_hero_template_id', intval( electron_settings( 'shop_tax_hero_elementor_templates' ) ) );
        $is_elementor     = class_exists( '\Elementor\Frontend' ) ? true : false;
        $frontend         = $is_elementor ? new \Elementor\Frontend : false;

        if ( !empty( $shop_hero_bg['background-image'] ) ) {
            $shop_hero_bg       = electron_settings( 'shop_hero_bg' );
            $shop_hero_bgsize   = wp_is_mobile() ? 'electron-square' : electron_settings( 'shop_hero_bg_imgsize', 'large' );
            $shop_hero_bg_id    = !empty($shop_hero_bg['media']['id']) ? $shop_hero_bg['media']['id'] : '';
            $shop_hero_bg_image = '' != $shop_hero_bgsize ? wp_get_attachment_image_url($shop_hero_bg_id,$shop_hero_bgsize) : $shop_hero_bg['background-image'];
        }

        if ( $hero_type == 'no-title' ) {
            return;
        }

        if ( is_product_category() ) {

            electron_wc_archive_category_page_hero_section();

        } elseif ( is_product_tag() && $is_elementor && $tax_template_id ) {

            printf( '<div class="electron-shop-hero-tag">%1$s</div>', $frontend->get_builder_content_for_display( $tax_template_id, false ) );

        } elseif ( ( is_shop() || is_product() ) && $is_elementor && $template_id ) {

            printf( '<div class="electron-shop-custom-hero">%1$s</div>', $frontend->get_builder_content_for_display( $template_id, false ) );

        } else {
            ?>
            <div class="electron-shop-hero-wrapper<?php echo esc_attr( $class ); ?>">
                <div class="electron-shop-hero electron-page-hero page-hero-<?php echo esc_attr( $hero_type ); ?>">
                    <?php
                        if ( !empty( $shop_hero_bg['background-image'] ) ) {
                            echo wp_get_attachment_image($shop_hero_bg_id,$shop_hero_bgsize);
                        }
                    ?>
                    <div class="electron-page-hero-content container">
                        <?php

                        echo electron_breadcrumbs();

                        woocommerce_page_title();

                        do_action( 'woocommerce_archive_description' );

                        if ( $hero_type == 'big' ) {
                            echo electron_wc_category_list();
                        }

                        if ( $hero_type == 'cat-slider' ) {
                            electron_wc_hero_category_slider();
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}


if ( ! function_exists( 'electron_wc_default_hero_section' ) ) {

    function electron_wc_default_hero_section()
    {
        ?>
        <div class="electron-shop-hero electron-page-hero">
            <div class="electron-page-hero-content container">
                <?php
                    echo electron_breadcrumbs();
                    woocommerce_page_title();
                    do_action( 'woocommerce_archive_description' );
                ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'electron_wc_archive_category_page_hero_section' ) ) {
    function electron_wc_archive_category_page_hero_section()
    {
        $cats_template_id = apply_filters( 'electron_shop_category_hero_template_id', intval( electron_settings( 'shop_cats_hero_elementor_templates' ) ) );
        $is_elementor     = class_exists( '\Elementor\Frontend' ) ? true : false;
        $frontend         = $is_elementor ? new \Elementor\Frontend : false;
        $term_bg_id       = get_term_meta( get_queried_object_id(), 'electron_product_cat_hero_bgimage_id', true );
        $term_bg_url      = wp_get_attachment_image_url( $term_bg_id, 'large' );

        if ( $term_bg_url ) {
            ?>
            <div class="electron-shop-hero electron-page-hero has-bg-image" data-bg="<?php echo esc_url( $term_bg_url ); ?>">
                <div class="electron-page-hero-content container">
                    <?php
                        echo electron_breadcrumbs();
                        woocommerce_page_title();
                        do_action( 'woocommerce_archive_description' );
                    ?>
                </div>
            </div>
            <?php
        } else {
            if ( $is_elementor && $cats_template_id ) {
                printf( '<div class="electron-shop-hero-cats">%1$s</div>', $frontend->get_builder_content_for_display( $cats_template_id, false ) );
            } else {
                electron_wc_default_hero_section();
            }
        }
    }
}



/*************************************************
## WOOCOMMERCE HERO CATEGORY SLIDER FUNCTION
*************************************************/

if ( ! function_exists( 'electron_wc_hero_category_slider' ) ) {
    function electron_wc_hero_category_slider()
    {
        $args = array(
            'order'      => electron_settings( 'shop_hero_carousel_catorder', 'ASC' ),
            'orderby'    => electron_settings( 'shop_hero_carousel_catorderby', 'name' ),
            'hide_empty' => '1' == electron_settings( 'shop_hero_carousel_cathideempty', '1' ) ? true : false
        );

        if ( '1' == electron_settings( 'shop_hero_carousel_catparent', '1' ) ) {
            $args['parent'] = 0;
        }

        $filter = electron_settings( 'shop_hero_carousel_catfilter', 'include' );
        $cats   = electron_settings( 'shop_hero_carousel_cats', null );

        if ( !empty($cats) ) {
            $args[$filter] = $cats;
        }

        $categories = get_terms( 'product_cat', $args);

        $slider_options = json_encode( array(
            "slidesPerView"        => 1,
            "spaceBetween"         => absint(electron_settings( 'shop_hero_carousel_gap', 1 )),
            "speed"                => absint(electron_settings( 'shop_hero_carousel_speed', 2000 )),
            "loop"                 => '1' == electron_settings( 'shop_hero_carousel_loop', '0' ) ? true : false,
            "rewind"               => '1' == electron_settings( 'shop_hero_carousel_rewind', '1' ) ? true : false,
            "autoplay"             => '1' == electron_settings( 'shop_hero_carousel_autoplay', '1' ) ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
            "centeredSlides"       => '1' == electron_settings( 'shop_hero_carousel_centred', '1' ) ? true : false,
            "centeredSlidesBounds" => true,
            "watchSlidesProgress"  => true,
            "pagination"           => false,
            "autoHeight"           => true,
            "direction"            => "horizontal",
            "wrapperClass"         => "electron-swiper-wrapper",
            "breakpoints"          => [
                "320"  => ["slidesPerView" => absint(electron_settings( 'shop_hero_carousel_perview6', 3 ))],
                "768"  => ["slidesPerView" => absint(electron_settings( 'shop_hero_carousel_perview5', 7 ))],
                "992"  => ["slidesPerView" => absint(electron_settings( 'shop_hero_carousel_perview4', 5 ))],
                "1200" => ["slidesPerView" => absint(electron_settings( 'shop_hero_carousel_perview3', 7 ))],
                "1400" => ["slidesPerView" => absint(electron_settings( 'shop_hero_carousel_perview2', 8 ))],
                "1500" => ["slidesPerView" => absint(electron_settings( 'shop_hero_carousel_perview1', 6 ))]
            ]
        ));
        $class    = ' style-'.electron_settings( 'shop_hero_carousel_style', '1' );
        $isfilter = 'link' != electron_settings( 'shop_hero_carousel_ajax', 'filter' ) ? ' type-filter' : '';
        if ( !empty( $categories ) ) {
            ?>
            <div class="electron-category-slider electron-container electron-swiper-container electron-swiper-slider swiper-container<?php echo esc_attr( $class ); ?>" data-swiper-options='<?php echo esc_attr( $slider_options ); ?>'>
                <div class="electron-swiper-wrapper">
                    <?php
                    foreach ( $categories as $category ) {
                        ?>
                        <div class="electron-category-slide-item swiper-slide<?php echo esc_attr( $isfilter ); ?>">
                            <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" rel="nofollow noreferrer">
                                <?php
                                if ( '1' == electron_settings( 'shop_hero_carousel_catthumb', '1' ) ) {
                                    $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                                    echo wp_get_attachment_image( $thumbnail_id, array(100,100), true );
                                }
                                ?>
                                <?php if ( '1' == electron_settings( 'shop_hero_carousel_cattcount', '1' ) ) { ?>
                                    <span class="cat-count"><?php echo esc_html( $category->count ); ?></span>
                                <?php } ?>
                                <span class="category-title"><?php echo esc_html( $category->name ); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }
}

/*************************************************
## WOOCOMMERCE HERO CATEGORY LIST FUNCTION
*************************************************/

if ( ! function_exists( 'electron_wc_category_list' ) ) {
    function electron_wc_category_list()
    {
        $args = array(
            'order'      => electron_settings( 'shop_hero_carousel_catorder', 'ASC' ),
            'orderby'    => electron_settings( 'shop_hero_carousel_catorderby', 'name' ),
            'hide_empty' => '1' == electron_settings( 'shop_hero_carousel_cathideempty', '1' ) ? true : false
        );

        if ( '1' == electron_settings( 'shop_hero_carousel_catparent', '1' ) ) {
            $args['parent'] = 0;
        }

        $filter = electron_settings( 'shop_hero_carousel_catfilter', 'include' );
        $cats   = electron_settings( 'shop_hero_carousel_cats', null );

        if ( !empty($cats) ) {
            $args[$filter] = $cats;
        }

        $categories = get_terms( 'product_cat', $args);

        if ( !empty( $categories ) ) {
            $isfilter = 'link' != electron_settings( 'shop_hero_carousel_ajax', 'filter' ) ? ' type-filter' : '';
            ?>
            <ul class="electron-wc-category-list<?php echo esc_attr( $isfilter ); ?>">
                <?php
                foreach ( $categories as $category ) {
                    ?>
                    <li>
                        <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                            <span class="category-title"><?php echo esc_html( $category->name ); ?></span>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
    }
}


if ( ! function_exists( 'electron_before_shop_elementor_templates' ) ) {
    add_action( 'electron_before_shop_content', 'electron_before_shop_elementor_templates', 15 );
    function electron_before_shop_elementor_templates()
    {
        echo electron_print_elementor_templates( 'shop_before_content_templates', '', true );
    }
}

if ( ! function_exists( 'electron_after_shop_loop_elementor_templates' ) ) {
    add_action( 'electron_after_shop_loop', 'electron_after_shop_loop_elementor_templates', 10 );
    function electron_after_shop_loop_elementor_templates()
    {
        echo electron_print_elementor_templates( 'shop_after_loop_templates', '', true );
    }
}

if ( ! function_exists( 'electron_after_shop_page_elementor_templates' ) ) {
    add_action( 'electron_after_shop_page', 'electron_after_shop_page_elementor_templates', 10 );
    function electron_after_shop_page_elementor_templates()
    {
        if ( !electron_is_pjax() ) {
            echo electron_print_elementor_templates( 'shop_after_content_templates', '' );
        }
    }
}

if ( ! function_exists( 'electron_after_shop_category_page_elementor_templates' ) ) {
    add_action( 'electron_after_shop_page', 'electron_after_shop_category_page_elementor_templates', 5 );
    function electron_after_shop_category_page_elementor_templates()
    {
        $template_id = electron_settings( 'shop_category_before_footer_templates', null );
        if ( is_product_category() && ( null != $template_id || '' != $template_id ) && !electron_is_pjax() ) {

            $id      = get_queried_object_id();
            $exclude = electron_settings( 'shop_category_before_footer_templates_exclude', null );
            $exclude = $exclude ? $exclude : array();

            if ( in_array( $id, $exclude ) ) {
                return;
            }

            echo electron_print_elementor_templates( 'shop_category_before_footer_templates', '' );
        }
    }
}

/*************************************************
## Load more
*************************************************/

if ( ! function_exists( 'electron_shop_pagination' ) ) {
    add_action( 'electron_shop_pagination', 'electron_shop_pagination', 15 );
    function electron_shop_pagination()
    {
        $pagination = isset($_GET['pagination']) ? esc_html($_GET['pagination']) : electron_settings('shop_paginate_type');
        $pagination = apply_filters('electron_shop_pagination_type', $pagination );
        $is_tax     = isset( get_queried_object()->term_id ) ? get_queried_object()->term_id : '';
        $loop_mode  = woocommerce_get_loop_display_mode();

        if ( $loop_mode == 'subcategories' && !$is_tax  ) {
            woocommerce_pagination();
        } else {
            if ( $pagination == 'loadmore' ) {

                echo electron_load_more_button();

            } elseif ( $pagination == 'infinite' ) {

                echo electron_infinite_scroll();

            } else  {

                woocommerce_pagination();

            }
        }
    }
}


if ( ! function_exists( 'electron_wc_filters_for_ajax' ) ) {
    function electron_wc_filters_for_ajax()
    {
        $type = isset($_GET['product_style']) ? esc_html($_GET['product_style']) : electron_settings( 'shop_product_type', '1' );

        return json_encode(
            array(
                'ajaxurl'      => esc_url( admin_url( 'admin-ajax.php' ) ),
                'current_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                'max_page'     => wc_get_loop_prop( 'total_pages' ),
                'per_page'     => isset( $_GET['per_page'] ) ? $_GET['per_page'] : wc_get_loop_prop( 'per_page' ),
                'layered_nav'  => WC_Query::get_layered_nav_chosen_attributes(),
                'cat_id'       => isset( get_queried_object()->term_id ) ? get_queried_object()->term_id : '',
                'brand_id'     => isset( get_queried_object()->term_id ) ? get_queried_object()->term_id : '',
                'filter_brand' => isset( $_GET['brand_id'] ) ? $_GET['brand_id'] : '',
                'filter_cat'   => isset( $_GET['filter_cat'] ) ? $_GET['filter_cat'] : '',
                'on_sale'      => isset( $_GET['on_sale'] ) ? wc_get_product_ids_on_sale() : '',
                'orderby'      => isset( $_GET['orderby'] ) ? $_GET['orderby'] : '',
                'min_price'    => isset( $_GET['min_price'] ) ? $_GET['min_price'] : '',
                'max_price'    => isset( $_GET['max_price'] ) ? $_GET['max_price'] : '',
                'pstyle'       => apply_filters( 'electron_loop_product_type', $type ),
                'column'       => electron_get_shop_column(),
                'is_search'    => is_search() ? 'yes' : '',
                'is_shop'      => is_shop() ? 'yes' : '',
                'is_brand'     => is_tax( 'electron_product_brands' ) ? 'yes' : '',
                'is_cat'       => is_tax( 'product_cat' ) ? 'yes' : '',
                'is_tag'       => is_tax( 'product_tag' ) ? 'yes' : '',
                's'            => isset($_GET['s']) ? $_GET['s'] : ''
            )
        );
    }
}


if ( ! function_exists( 'electron_get_cat_url' ) ) {
    function electron_get_cat_url( $termid )
    {
        global $wp;
        if ( '' === get_option( 'permalink_structure' ) ) {
            $link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $link = preg_replace( '%\/page/[0-9]+%', '', add_query_arg( null, null ) );
        }

        if ( isset( $_GET['filter_cat'] ) ) {
            $explode_old = explode( ',', $_GET['filter_cat'] );
            $explode_termid = explode( ',', $termid );

            if ( in_array( $termid, $explode_old ) ) {
                $data = array_diff( $explode_old, $explode_termid );
                $checkbox = 'checked';
            } else {
                $data = array_merge( $explode_termid , $explode_old );
            }
        } else {
            $data = array( $termid );
        }

        $dataimplode = implode( ',', $data );

        if ( empty( $dataimplode ) ) {
            $link = remove_query_arg( 'filter_cat', $link );
        } else {
            $link = add_query_arg( 'filter_cat', implode( ',', $data ), $link );
        }

        return $link;
    }
}


if ( ! function_exists( 'electron_get_brand_url' ) ) {
    function electron_get_brand_url( $termid )
    {
        global $wp;
        if ( '' === get_option( 'permalink_structure' ) ) {
            $link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $link = preg_replace( '%\/page/[0-9]+%', '', add_query_arg( null, null ) );
        }

        if ( isset( $_GET['brand_id'] ) ) {
            $explode_old = explode( ',', $_GET['brand_id'] );
            $explode_termid = explode( ',', $termid );

            if ( in_array( $termid, $explode_old ) ) {
                $data = array_diff( $explode_old, $explode_termid );
                $checkbox = 'checked';
            } else {
                $data = array_merge( $explode_termid , $explode_old );
            }
        } else {
            $data = array( $termid );
        }

        $dataimplode = implode( ',', $data );

        if ( empty( $dataimplode ) ) {
            $link = remove_query_arg( 'brand_id', $link );
        } else {
            $link = add_query_arg( 'brand_id', implode( ',', $data ), $link );
        }

        return $link;
    }
}


/**
* Change number of products that are displayed per page (shop page)
*/
if ( ! function_exists( 'electron_wc_shop_per_page' ) ) {
    add_filter( 'loop_shop_per_page', 'electron_wc_shop_per_page', 20 );
    add_filter( 'dokan_store_products_per_page', 'electron_wc_shop_per_page', 20 );
    function electron_wc_shop_per_page( $cols )
    {
        if ( isset( $_GET['per_page'] ) && $_GET['per_page'] ) {
            return $_GET['per_page'];
        }

        $cols = apply_filters( 'electron_wc_shop_per_page', electron_settings( 'shop_perpage', '8' ) );

        if ( class_exists('WeDevs_Dokan') && dokan_is_store_page() ) {
            $store_user  = dokan()->vendor->get( get_query_var( 'author' ) );
            $store_info  = dokan_get_store_info( $store_user->get_id() );
            $cols        = dokan_get_option( 'store_products_per_page', 'dokan_general', 12 );

            return $cols;
        }

        return $cols;
    }
}



/**
* Clear Filters
*/
if ( ! function_exists( 'electron_clear_filters' ) ) {
    function electron_clear_filters() {

        $url = wc_get_page_permalink( 'shop' );
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

        $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
        $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

        if ( 0 < count( $_chosen_attributes ) || $min_price || $max_price ) {
            $reset_url = strtok( $url, '?' );
            if ( isset( $_GET['post_type'] ) ) {
                $reset_url = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $reset_url );
            }
            ?>
            <div class="electron-clear-filters">
                <a href="<?php echo esc_url( $reset_url ); ?>"><?php echo esc_html__( 'Clear filters', 'electron' ); ?></a>
            </div>
            <?php
        }
    }
    add_action( 'electron_before_choosen_filters', 'electron_clear_filters' );
}



/**
* Product thumbnail
*/
if ( ! function_exists( 'electron_loop_product_thumb_overlay' ) ) {
    function electron_loop_product_thumb_overlay($column='')
    {
        global $product;
        $column = isset( $_GET['column'] ) ? esc_html( $_GET['column'] ) : $column;
        $size   = electron_settings('product_imgsize','woocommerce-thumbnail');

        $id           = $product->get_id();
        $size         = isset( $_POST['img_size'] ) != null ? $_POST['img_size'] : $size;
        $gallery      = $product->get_gallery_image_ids();
        $has_images   = !empty( $gallery ) && !wp_is_mobile() ? 'product-link has-images' : 'product-link';
        $attr         = !empty( $gallery ) ? 'product-thumb attachment-woocommerce_thumbnail size-'.$size : 'attachment-woocommerce_thumbnail size-'.$size;
        $show_video   = get_post_meta( $id, 'electron_product_video_on_shop', true );
        $iframe_video = get_post_meta( $id, 'electron_product_iframe_video', true );
        $show_gallery = get_post_meta( $id, 'electron_loop_product_slider', true );
        $isshop       = is_shop() ? ' is-shop' : '';

        if ( $iframe_video && $show_video == 'yes' && ( is_shop() || wp_doing_ajax() ) ) {
            $iframe_html = '<iframe class="lazy" loading="lazy" data-src="https://www.youtube.com/embed/'.$iframe_video.'?playlist='.$iframe_video.'&modestbranding=1&rel=0&controls=0&autoplay=1&enablejsapi=1&showinfo=0&mute=1&loop=1&start=5&end=25" allow="autoplay; fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowfullscreen></iframe>';
            echo '<div class="electron-loop-product-iframe-wrapper"><a href="'.esc_url( get_permalink() ).'" title="'.get_the_title().'"></a>'.$iframe_html.'</div>';
        } elseif ( !empty( $gallery ) && $show_gallery == 'yes' ) {
            electron_loop_product_gallery();
        } else {
            ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="<?php echo esc_attr( $has_images ); ?>">
                <?php
                echo has_post_thumbnail() ? get_the_post_thumbnail( $id, $size, array( 'class' => $attr ) ) : wc_placeholder_img( $size );

                if ( !empty( $gallery ) && !wp_is_mobile() ) {
                    echo wp_get_attachment_image( $gallery[0], $size, "", array( "class" => "overlay-thumb ".$isshop ) );
                }
                ?>
            </a>
            <?php
        }
    }
}

/**
* loop product gallery
*/
if ( ! function_exists( 'electron_loop_product_gallery' ) ) {
    function electron_loop_product_gallery($column='')
    {
        global $product;

        $column = isset( $_GET['column'] ) ? esc_html( $_GET['column'] ) : $column;
        $size   = electron_settings('product_imgsize','woocommerce-thumbnail');

        $id           = $product->get_id();
        $data         = array();
        $show_gallery = get_post_meta( $id, 'electron_loop_product_slider', true );
        $autoplay     = get_post_meta( $id, 'electron_loop_product_slider_autoplay', true );
        $speed        = get_post_meta( $id, 'electron_loop_product_slider_speed', true );
        $gallery      = $product->get_gallery_image_ids();
        $size         = isset( $_POST['img_size'] ) != null ? $_POST['img_size'] : $size;
        $size         = apply_filters( 'electron_product_thumb_size', $size );
        $attr         = !empty( $gallery ) ? 'product-thumb attachment-woocommerce_thumbnail size-'.$size : 'attachment-woocommerce_thumbnail size-'.$size;
        $thumburl     = get_the_post_thumbnail_url( $id, $size, array( 'class' => $attr ) );
        $data[]       = 'yes' == $autoplay ? '"autoplay":true' : '"autoplay":false';
        $data[]       = is_numeric($speed) ? '"speed":'.round($speed) : '"speed":500';
        $data[]       = '"slidesPerView":1';
        $data[]       = '"pagination":{"el": ".swiper-pagination","type": "bullets","clickable":true}';
        $data         = apply_filters('electron_loop_product_slider_options', $data);

        wp_enqueue_script( 'swiper' );

        if ( !empty( $gallery ) && 'yes' == $show_gallery ) {
            ?>
            <div class="electron-loop-slider electron-swiper-slider swiper-container" data-swiper-options='{<?php echo implode(',', $data ); ?>}'>
                <div class="swiper-wrapper">
                    <div class="electron-loop-slider-item swiper-slide">
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-link" data-img="<?php echo esc_url( $thumburl ); ?>">
                            <?php echo has_post_thumbnail() ? get_the_post_thumbnail( $id, $size, ['class'=>$attr ] ) : wc_placeholder_img( $size ); ?>
                        </a>
                    </div>
                    <?php
                    foreach ( $gallery as $img ) {
                        $imgurl = wp_get_attachment_image_url( $img, $size );
                        ?>
                        <div class="electron-loop-slider-item swiper-slide">
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-link" data-img="<?php echo esc_url( $imgurl ); ?>">
                                <?php echo wp_get_attachment_image( $img, $size ); ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <?php
        } else {
            electron_loop_product_thumb($column);
        }
    }
}


/**
* Add stock to loop
*/
if ( ! function_exists( 'electron_loop_product_stock_status' ) ) {
    function electron_loop_product_stock_status($status=null,$stock=null,$show_stock=true)
    {
        global $product;

        $status = $status ? $status : $product->get_stock_status();
        $stock  = $stock ? $stock : $product->get_stock_quantity();

        $text = $status == 'instock' ? esc_html__('In stock', 'electron') : esc_html__('Out of stock', 'electron');

        if ( $show_stock && $stock > 0 ) {
            $text .= $stock > 0 ? ':<span class="stock-value"> '.wc_trim_zeros($stock).'</span>' : '';
        }

        return '<span class="electron-small-title electron-stock-status '.$status.'">'.$text.'</span>';
    }
}


/**
* Cart Button with Quantity Box
*/
if ( !function_exists( 'electron_cart_with_quantity' ) ) {
    function electron_cart_with_quantity()
    {
        ?>
        <div class="product-cart-with-quantity">
            <div class="quantity ajax-quantity">
                <div class="quantity-button minus">-</div>
                <input type="text" class="input-text qty text" name="quantity" value="1" title="Menge" size="4" inputmode="numeric">
                <div class="quantity-button plus">+</div>
            </div>
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
        <?php
    }
}


/**
* Product wishlist button
*/
if ( ! function_exists( 'electron_single_product_buttons' ) ) {
    add_action( 'woocommerce_after_add_to_cart_button', 'electron_single_product_buttons', 10 );
    function electron_single_product_buttons()
    {
        global $product;
        $id   = $product->get_id();
        $name = $product->get_name();
        echo '<div class="product-after-cart-wrapper">';
            echo electron_wishlist_button($id,$name);
            echo electron_compare_button($id,$name);
        echo '</div>';
        electron_add_buy_now_button_single();
    }
}

/**
* Product quickview button
*/
if ( ! function_exists( 'electron_quickview_button' ) ) {
	function electron_quickview_button($id='')
	{
        if ( ! class_exists( 'Electron_QuickView' ) ) {
            return;
        }
        global $product;
        $pid   = $id ? $id : $product->get_id();
        $text = esc_html__( 'Quick View', 'electron' );
        $icon = '<svg
        class="quickview electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 32 32"
        xmlns="http://www.w3.org/2000/svg"><use href="#shopEye"></use></svg>';

	    return '<div class="electron-quickview-btn electron-product-button"
	    data-id="'.$pid.'"
	    data-label="'.$text.'"><span class="electron-hint">'.$text.'</span>'.$icon.'</div>';
	}
}

if ( ! function_exists( 'electron_wishlist_button' ) ) {
    function electron_wishlist_button( $id,$name )
    {
        if ( ! class_exists( 'Electron_Wishlist' ) || '1' == electron_settings( 'woo_catalog_mode', '0' ) ) {
            return;
        }
        $text = esc_html__( 'Add to Wishlist', 'electron' );
        $icon = '<svg
        class="svgwishlist electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 32 32"
        xmlns="http://www.w3.org/2000/svg"><use href="#shopLove"></use></svg>';

        return '<div class="electron-product-button electron-wishlist-btn electron-spinner"
        data-id="'.esc_attr( $id ).'" data-name="'.esc_attr( $name ).'"><span class="electron-hint">'.$text.'</span>'.$icon.'</div>';
    }
}

if ( ! function_exists( 'electron_compare_button' ) ) {
    function electron_compare_button( $id,$name )
    {
        if ( ! class_exists( 'Electron_Compare' ) || '1' == electron_settings( 'woo_catalog_mode', '0' ) ) {
            return;
        }
        $text = esc_html__( 'Compare', 'electron' );
        $icon = '<svg
        class="svgCompare electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 32 32"
        xmlns="http://www.w3.org/2000/svg"><use href="#shopCompare"></use></svg>';

        return '<div class="electron-product-button electron-compare-btn electron-spinner"
        data-id="'.esc_attr( $id ).'" data-name="'.esc_attr( $name ).'"><span class="electron-hint">'.$text.'</span>'.$icon.'</div>';
    }
}


/**
* Product add to cart icon button
*/
if ( ! function_exists( 'electron_add_to_cart' ) ) {
    function electron_add_to_cart( $btn_type = 'text', $id = '', $quick = false )
    {
        global $product;

        if ( $id ) {
            $product  = wc_get_product( $id );
        }

        $catalog_mode = electron_settings( 'woo_catalog_mode', '0' );

        if ( $product && '1' != $catalog_mode ) {
            $id         = $id ? $id : $product->get_id();
            $type       = $product->get_type();
            $url        = $product->add_to_cart_url();
            $sku        = $product->get_sku();
            $text       = null !== $product->add_to_cart_text() ? esc_html($product->add_to_cart_text()) : esc_html__( 'Add to cart', 'electron' );
            $in_stock   = $product->is_purchasable() && $product->is_in_stock();
            $ot_ajax    = electron_settings('ajax_addtocart','1');
            $is_ajax    = $product->supports( 'ajax_add_to_cart' );
            $ajax_class = $is_ajax && '1' == $ot_ajax ? ' electron_ajax_add_to_cart' : ' ajax_add_to_cart';
            $icon       = $is_ajax && $in_stock ? 'shopBag' : 'shopArrowRight';
            $class      = 'elc-btn type-'.$type;
            $class     .= $type == 'variable' || $type == 'grouped' ? ' electron-quick-shop-btn' : '';
            $class     .= $is_ajax && $in_stock ? $ajax_class : '';
            $hint       = '<span class="electron-hint">'.$text.'</span>';
            $qty        = '';
            $icon       = '<svg
            class="svgaddtocart electron-svg-icon"
            width="512"
            height="512"
            fill="currentColor"
            viewBox="0 0 32 32"
            xmlns="http://www.w3.org/2000/svg"><use href="#shopBag"></use></svg>';

            $title = $text;
            if ( $btn_type == 'button' ) {
                $class .= ' electron-btn electron-btn-primary electron-product-cart has-icon';
                $title = '<span class="cart-text">'.$text.'</span>'.$icon;
            }
            if ( $btn_type == 'icon' ) {
                $class .= ' btn-type-icon electron-add-to-cart-icon-link';
                $title = $icon;
            }
            if ( $btn_type == 'text' ) {
                $class .= ' electron-btn-text';
                $title = $text;
            }

            $args = apply_filters(
                'woocommerce_loop_add_to_cart_args',
                array(
                    'class'      => $class,
                    'attributes' => array(
                        'data-product_id'  => $id,
                        'data-product_sku' => $sku,
                        'aria-label'       => $product->add_to_cart_description(),
                        'rel'              => 'nofollow',
                        'title'            => $text,
                        'data-title'       => $text,
                        'data-ohref'       => $url,
                        'data-oclass'      => $class
                    )
                ),
                $product
            );

            $btn = apply_filters(
                'woocommerce_loop_add_to_cart_link',
                sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                esc_url( $url ),
                esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                esc_attr( isset( $args['class'] ) ? $args['class'] : $class ),
                isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                $title,
            ),$product,$args);

            if ( $btn_type == 'icon' ) {
                return '<div
                class="electron-add-to-cart-btn electron-product-button btn-type-icon"
                data-id="'.$id.'" data-label="'.$text.'">'.$hint.$btn.'</div>';
            } else {
                return $btn;
            }
        }
    }
}

/**
* Product add to cart icon button
*/
if ( ! function_exists( 'electron_swatches_add_to_cart' ) ) {
    function electron_swatches_add_to_cart()
    {
        global $product;

        $id         = $product->get_id();
        $type       = $product->get_type();
        $url        = $product->add_to_cart_url();
        $sku        = $product->get_sku();
        $text       = esc_html( $product->add_to_cart_text() );
        $in_stock   = $product->is_purchasable() && $product->is_in_stock();
        $ot_ajax    = electron_settings('ajax_addtocart','1');
        $is_ajax    = $product->supports( 'ajax_add_to_cart' );
        $class      = $is_ajax && $in_stock && '1' == $ot_ajax ? 'electron_ajax_add_to_cart' : 'ajax_add_to_cart';
        $class     .= $type == 'variable' || $type == 'grouped' ? ' electron-quick-shop-btn' : '';
        $class     .= $type == 'variable' ? ' electron-swatches-shop-btn' : '';
        $hint       = '<span class="electron-hint">'.$text.'</span>';
        $icon       = '<svg class="svgCompare electron-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use href="#shopBag"></use></svg>';
        $icon      .= '<svg class="progress-icon" xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34"><circle cx="16" cy="16" r="15.9155" class="progress-bar__background" /><circle cx="16" cy="16" r="15.9155" class="progress-bar__progress js-progress-bar" /></svg>';

        return apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf( '<div class="electron-add-to-cart hint-left"><a href="%s" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="%s" rel="nofollow" aria-label="'.$text.'"></a>%s%s</div>',
            esc_url( $url ),
            $id,
            $sku,
            esc_attr( $class ),
            $icon,
            $hint
        ),$product);
    }
}

/**
* Product discount label
*/
if ( ! function_exists( 'electron_product_discount' ) ) {
    function electron_product_discount($echo=true,$style=true,$pid=null)
    {
        if ( $pid ) {
            $product = wc_get_product( $pid );
        } else {
            global $product;
        }

        $discount = get_post_meta( $product->get_id(), 'electron_product_discount', true );
        $style    = $style ? ' electron-label electron-red' : '';
        if ( 'yes' != $discount ) {
            if ( $product->is_type('variable') ) {
                $productt   = wc_get_product($product->get_id());
                $variations = $productt->get_available_variations();
                $saving = '';

                foreach ($variations as $variation) {
                    $regular = $variation['display_regular_price'];
                    $sale    = $variation['display_price'];

                    if ( $regular > 0 ) {
                        $saving = $regular && $sale ? round( ((($regular - $sale) / $regular) * 100),0) : '';
                        $saving = $saving>0 ? $saving . '%' : '';
                    }
                }
                if ( $echo == true ) {
                    echo !empty( $saving ) && $saving>0 ? '<span class="electron-discount'.$style.'">'.$saving.'</span>' : '';
                } else {
                    return !empty( $saving ) && $saving>0 ? '<span class="electron-discount'.$style.'">'.$saving.'</span>' : '';
                }

    		} else {

                if ( $product->is_on_sale() ) {
                    $regular = (float) $product->get_regular_price();
                    $sale    = (float) $product->get_sale_price();
                    $saving  = $sale && $regular ? round( 100 - ( $sale / $regular * 100 ), 0 ) . '%' : '';

                    if ( $echo == true ) {
                        echo !empty( $saving ) ? '<span class="electron-discount'.$style.'">'.$saving.'</span>' : '';
                    } else {
                        return !empty( $saving ) ? '<span class="electron-discount'.$style.'">'.$saving.'</span>' : '';
                    }
                }
    		}
		}
    }
}

if ( ! function_exists( 'electron_product_discount2' ) ) {
    function electron_product_discount2($product=null,$label=true)
    {
        global $product;

        if ( $product->is_on_sale() && ! $product->is_type('variable') ) {
            $regular = (float) $product->get_regular_price();
            $sale    = (float) $product->get_sale_price();
            $saving  = $sale && $regular ? round( 100 - ( $sale / $regular * 100 ), 0 ) . '%' : '';
            $label   = esc_html__('Discount:','electron');

            return !empty( $saving ) ? '<span class="discount-wrapper"><span class="label">'.$label.'</span><span class="value">'.$saving.'</span></span>' : '';
        }
    }
}


/**
* Get all product categories
*/
if ( ! function_exists( 'electron_product_all_categories' ) ) {
    function electron_product_all_categories()
    {
        $cats = get_terms( 'product_cat' );
        $categories = array();

        if ( empty( $cats ) ) {
            return;
        }

        foreach ( $cats as $cat ) {
            $categories[] = '<a href="'.esc_url( get_term_link( $cat ) ) .'" >'. esc_html( $cat->name ) .'</a>';
        }
        return implode( ', ', $categories );
    }
}


/**
* Get all product tags
*/
if ( ! function_exists( 'electron_product_tags' ) ) {
    function electron_product_tags()
    {
        $tags = get_terms( 'product_tag' );
        $alltags = array();
        if ( empty( $tags ) ) {
            return;
        }
        foreach ( $tags as $tag ) {
            $alltags[] = '<a href="'.esc_url( get_term_link( $tag ) ) .'" >'. esc_html( $tag->name ) .'</a>';
        }
        return implode( ', ', $alltags );
    }
}


if ( ! function_exists( 'electron_product_terms' ) ) {

    /**
    * Function to return list of the terms.
    *
    * @param string 'taxonomy'
    *
    * @return html Returns the list of elements.
    */

    function electron_product_terms( $taxonomy, $label ) {

        $terms = get_the_terms( get_the_ID(), $taxonomy );

        if ( $terms && ! is_wp_error( $terms ) ) {

            $term_links = array();
            echo '<div class="electron-meta-wrapper">';
                foreach ( $terms as $term ) {
                    $term_links[] = '<a href="' . esc_url( get_term_link( $term->slug, $taxonomy ) ) . '">' . $term->name . '</a>';
                }
                $all_terms = join( ', ', $term_links );

                echo !empty( $label ) ? '<span class="electron-terms-label electron-small-title">' . $label . '</span>' : '';
                echo '<span class="electron-small-title terms-' . esc_attr( $term->slug ) . '">' . $all_terms . '</span>';
            echo '</div>';
        }
    }
}


/**
* Add product attribute name
*/
if ( ! function_exists( 'electron_product_attr_label' ) ) {
    function electron_product_attr_label()
    {
        global $product;

        $attributes = $product->get_attributes();
        foreach ( $attributes as $attribute ) {
            $values = array();
            $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
                'label' => wc_attribute_label( $attribute->get_name() ),
                'value' => apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ),
            );
            $label = $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ]['label'];
            $value = $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ]['value'];
            echo !empty( $label ) ? '<span class="product-attr_label">'.$label.'</span>' : '';
        }
    }
}


/**
* Add product excerpt
*/
if ( ! function_exists( 'electron_product_excerpt' ) ) {
    function electron_product_excerpt()
    {
        global $product;
        if ( $product->get_short_description() ) {
            $limit = electron_settings('shop_loop_excerpt_limit');
            ?>
            <p class="electron-product-excerpt"><?php echo wp_trim_words( $product->get_short_description(), apply_filters( 'electron_loop_excerpt_limit', $limit ) ); ?></p>
            <?php
        }
    }
}

/**
* Add product rating
*/
if ( ! function_exists( 'electron_product_rating' ) ) {

    function electron_product_rating()
    {
        global $product;
        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();

        if ( $product->get_average_rating() ) {
            ?>
            <div class="electron-rating star-rating">
                <span data-width="<?php echo esc_attr( ( $average / 5 ) * 100  ); ?>"></span>
                <?php if ( comments_open() ) { ?>
                    <a href="#reviews" class="electron-review-link electron-small-title" rel="nofollow"><?php printf( _n( '%s review', '%s reviews', $review_count, 'electron' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?></a>
                <?php } ?>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'electron_star_rating_html' ) ) {
    function electron_star_rating_html( $type = 1, $rating = 0, $count = 0, $review = 0 )
    {
    	if ( 0 < $count ) {
        	if ( $type == 1 ) {
        		return '<span class="star-rating"><span class="rating" style="width:'.(($rating / 5 ) * 100).'%">'.esc_html( $count ).'</span></span>';
        	} else {
        	    $review = $review >= 1000 ? ($review/1000).'k' : $review;
        	    return '<span class="rating-review"><span class="rating">'.esc_html( $rating ).'</span><span class="review">'.esc_html( $review ).'</span></span>';
        	}
    	}
    }
}

/**
* Add product rating
*/
if ( ! function_exists( 'electron_product_meta' ) ) {

    function electron_product_meta()
    {
        global $product;
        ?>
        <div class="electron-summary-item electron-product-meta">
            <?php do_action( 'woocommerce_product_meta_start' ); ?>
            <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="electron-small-title posted_in"><span class="electron-meta-label">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'electron' ) . '</span><span class="electron-meta-links"> ', '</span></span>' ); ?>
            <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="electron-small-title tagged_as"><span class="electron-meta-label">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'electron' ) . '</span> ', '</span>' ); ?>
            <?php do_action( 'woocommerce_product_meta_end' ); ?>
        </div>
        <?php
    }
}


/**
* Get product sku
*/
if ( ! function_exists( 'electron_product_sku' ) ) {
    function electron_product_sku($echo=true)
    {
        global $product;
        if ( $product->get_sku() ) {
            $label = esc_html__('SKU:', 'electron');
            $sku   = esc_html( $product->get_sku() );
            if ( $echo ) {
                echo '<div class="electron-meta-wrapper electron-small-title"><span class="electron-meta-label">'.$label.'</span><span class="electron-sku"> '.$sku.'</span></div>';
            } else {
                return '<div class="electron-meta-wrapper electron-small-title"><span class="electron-meta-label">'.$label.'</span><span class="electron-sku"> '.$sku.'</span></div>';
            }
        }
    }
}


if ( ! function_exists( 'electron_product_badge' ) ) {
    function electron_product_badge($echo=true)
    {
        global $product;
        $pid   = $product->get_id();
        $title = get_post_meta( $pid, 'electron_custom_badge', true );
        $color = get_post_meta( $pid, 'electron_badge_color', true );
        $color = $color ? ' data-label-color="'.$color.'"' : '';

        if ( true == $echo ) {
            if ( '' != $title ) {
                echo '<span class="electron-label electron-badge badge-'.esc_attr( $title ).'"'.$color.'>'.esc_html( $title ).'</span>';
            } else {
                if ( $product->is_on_sale() ) {
                    echo '<span class="electron-label electron-badge badge-def"'.$color.'>'.esc_html__( 'Sale!', 'electron' ).'</span>';
                }
            }
        } else {
            if ( '' != $title ) {
                return '<span class="electron-label electron-badge badge-'.esc_attr( $title ).'"'.$color.'>'.esc_html( $title ).'</span>';
            } else {
                if ( $product->is_on_sale() ) {
                    return '<span class="electron-label electron-badge badge-def"'.$color.'>'.esc_html__( 'Sale!', 'electron' ).'</span>';
                }
            }
        }
    }
}


if ( ! function_exists( 'electron_product_ribbon' ) ) {
    function electron_product_ribbon($echo=true)
    {
        global $product;
        $pid   = $product->get_id();
        $title = get_post_meta( $pid, 'electron_custom_badge', true );
        $color = get_post_meta( $pid, 'electron_badge_color', true );
        $color = $color ? ' data-label-color="'.$color.'"' : '';

        if ( true == $echo ) {
            if ( '' != $title ) {
                echo '<div class="ribbon badge-'.esc_attr( $title ).'"><span '.$color.'>'.esc_html( $title ).'</span></div>';
            } else {
                if ( $product->is_on_sale() ) {
                    echo '<div class="ribbon badge-def"><span '.$color.'>'.esc_html__( 'Sale!', 'electron' ).'</span></div>';
                }
            }
        } else {
            if ( '' != $title ) {
                return '<div class="ribbon badge-'.esc_attr( $title ).'"><span '.$color.'>'.esc_html( $title ).'</span></div>';
            } else {
                if ( $product->is_on_sale() ) {
                    return '<div class="ribbon badge-def"><span '.$color.'>'.esc_html__( 'Sale!', 'electron' ).'</span></div>';
                }
            }
        }
    }
}

if ( ! function_exists( 'electron_product_badge_byId' ) ) {
    function electron_product_badge_byId($id='')
    {
        $product = wc_get_product($id);
        $id      = $product->get_id();
        $title   = get_post_meta( $id, 'electron_custom_badge', true );
        $color   = get_post_meta( $id, 'electron_badge_color', true );
        $color   = $color ? ' data-label-color="'.$color.'"' : '';

        if ( '' != $title ) {
            return '<span class="electron-label electron-badge badge-'.esc_attr( $title ).'"'.$color.'>'.esc_html( $title ).'</span>';
        } else {
            if ( $product->is_on_sale() ) {
                return '<span class="electron-label electron-badge badge-def"'.$color.'>'.esc_html__( 'Sale!', 'electron' ).'</span>';
            }
        }
    }
}



if ( ! function_exists( 'electron_loop_category_title' ) ) {

    /**
    * Show the subcategory title in the product loop.
    *
    * @param object $category Category object.
    */
    function electron_loop_category_title( $category ) {
        ?>
        <h4 class="cat-name">
            <?php
            if ( $category->count > 0 ) {
                echo '<span class="cat-count">' . esc_html( $category->count ) . '</span>';
            }
            echo '<span class="cat-text">' . esc_html( $category->name ) . '</span>';
            ?>
        </h4>
        <?php
    }
}



/**
*  custom extra tabs for product page
*/
if ( ! function_exists( 'electron_product_extra_fetaures' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_extra_fetaures', 21 );
    function electron_product_extra_fetaures($echo=true)
    {
        global $product;
        $fatures  = get_post_meta( $product->get_id(), 'electron_product_extra_fatures', true );
        $fatures2 = electron_settings( 'product_extra_fatures' );
        $fatures  = $fatures ? $fatures : $fatures2;
        $lists    = '' != $fatures ? preg_split("/\\r\\n|\\r|\\n/", $fatures ) : '';
        $class    = is_product() ? 'electron-summary-item product-features' : 'product-features';
        $class   .= '1' == electron_settings( 'product_extra_fatures_mobile', '1' ) ? ' show-mobile' : '';

        $listItem = '';
		if ( !empty( $lists ) ) {
			foreach( $lists as $list ) {
				if ( !empty( $list ) ) {
					$listItem .= '<li><span class="checked">&#x2713;</span> '.$list.'</li>';
				}
			}

    		if ( $echo == true ) {
    		    echo '<ul class="'.$class.'">'.$listItem.'</ul>';
    		} else {
    		    return '<ul class="'.$class.'">'.$listItem.'</ul>';
    		}
		}
    }
}



/**
 * woocommerce_layered_nav_term_html WIDGET
 */
if ( !function_exists( 'electron_wv_layered_nav_count' ) ) {
    add_filter('woocommerce_layered_nav_count', 'electron_wv_layered_nav_count', 10, 3);
    function electron_wv_layered_nav_count($output, $count, $term) {
        $output = str_replace( '<span class="count">(', '<span class="widget-list-span">', $output );
        $output = str_replace( ')</span>', '</span>', $output );

        return $output;
    }
}


if ( !function_exists( 'electron_wc_cart_totals_coupon_html' ) ) {
    function electron_wc_cart_totals_coupon_html( $coupon )
    {
        if ( is_string( $coupon ) ) {
            $coupon = new WC_Coupon( $coupon );
        }

        $icon = '<svg
        class="svgTrash electron-svg-icon mini-icon"
        height="427pt"
        viewBox="-40 0 427 427.00131"
        width="427pt"
        xmlns="http://www.w3.org/2000/svg"><use href="#shopTrash"></use></svg>';

        $code        = $coupon->get_code();
        $is_checkout = defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url();
        $remove_url  = add_query_arg( 'remove_coupon', rawurlencode( $code ), $is_checkout );
        $amount      = WC()->cart->get_coupon_discount_amount( $code, WC()->cart->display_cart_ex_tax );
        $discount    = '-' . wc_price( $amount );
        $title       = esc_html__('Click here to Remove this coupon.', 'electron');

        $coupon_html  = '<a href="'.esc_url($remove_url).'" title="'.$title.'" class="electron-remove-coupon" data-coupon="'.esc_attr($code).'">';
        $coupon_html .= '<span class="name">'.$code.$icon.'</span><span class="value">'.$discount.'</span>';
        $coupon_html .= '</a>';

        return $coupon_html;
    }
}

if ( !function_exists( 'electron_wc_get_all_coupons' ) ) {
    function electron_wc_get_all_coupons($location='')
    {
        $coupons = get_posts(array(
            'post_type'      => 'shop_coupon',
            'post_status'    => 'publish',
            'posts_per_page' => -1
        ));
        wp_enqueue_style( 'electron-coupons' );
        $html = '';

        if ( $coupons ) {

            foreach ( $coupons as $coupon ) {
                $id     = $coupon->ID;
                $name   = esc_html($coupon->post_title);
                $desc   = $coupon->post_excerpt;
                $coupon = new WC_Coupon($name);
                $date   = $coupon->get_date_expires('view');
                $products = $coupon->get_product_ids();
                $code   = esc_attr( get_post_meta( $id,'coupon_code', true) );
                $amount = esc_attr( get_post_meta( $id,'coupon_amount', true) );
                $type   = esc_attr( get_post_meta( $id,'discount_type', true) );
                $free   = esc_attr( get_post_meta( $id,'free_shipping', true) );
                $text   = esc_html__('Discount', 'electron');
                $enjoy  = esc_html__('Enjoy Your Gift', 'electron');
                $apply  = esc_html__('Apply Coupon', 'electron');
                $off    = esc_html__('off', 'electron');
                $valid  = !empty($date) ? esc_html__('valid until', 'electron') : '';
                $title  = esc_html__('Click here to Apply this coupon.', 'electron');
                $date   = $date ? $date->format('M d, Y') : esc_html__('Never expire', 'electron');

                if ( $location == 'product' ) {

                    $amount = $type == 'percent' ? $amount.'% ' : wc_price($amount);
                    $amount = '<span class="value">'.$amount.' </span><span class="text">'.$off.'</span>';

                    $html .= '<div class="coupon">';
                        $html .= '<div class="add-coupon" rel="no-follow" title="'.$title.'" data-id="'.$id.'" data-coupon="'.$name.'" data-free="'.$free.'"></div>';
                        $html .= '<div class="left"><div>'.$enjoy.'</div></div>';
                        $html .= '<div class="center">';
                            $html .= '<div class="discount">'.$amount.'</div>';
                            $html .= '<div class="name">'.$name.'</div>';
                            $html .= '<small>'.$valid.' '.$date.'</small>';
                        $html .= '</div>';
                        $html .= '<div class="right"><div>'.$apply.'</div></div>';
                    $html .= '</div>';

                } elseif ( $location == 'shop' )  {

                    if ( !empty($products) ) {
                        $is_active = isset($_GET['coupon_code']) && ( esc_html($_GET['coupon_code']) == $name ) ? ' applied' : '';
                        if ( $type == 'percent' ) {
                            $amount = '<span class="value">'.$amount.'% </span><span class="text">'.$text.'</span>';
                        } else {
                            $amount = '<span class="value">'.wc_price($amount).'</span><span class="text">'.$text.'</span>';
                        }
                        $link  = isset($_GET['coupon_code']) ? remove_query_arg( 'coupon_code' ) : add_query_arg( 'coupon_code', $name );
                        $title  = isset($_GET['coupon_code']) ? esc_html__('Remove this coupon.', 'electron') : $title;
                        $html .= '<li>';
                        $html .= '<a class="shop-coupon'.$is_active.'" href="'.$link.'" rel="no-follow" title="'.$title.'" data-id="'.$id.'" data-coupon="'.$name.'" data-free="'.$free.'">';
                        $html .= '<span class="discount">'.$amount.'</span>';
                        $html .= $name || $date ? '<span class="name-date">' : '';
                        $html .= $name ? '<span class="name">'.$name.'</span>' : '';
                        $html .= $name || $date ? '</span>' : '';
                        $html .= '</a>';
                        $html .= '</li>';
                    }

                } else {

                    if ( $type == 'percent' ) {
                        $amount = '<span class="value">'.$amount.'% </span><span class="text">'.$text.'</span>';
                    } else {
                        $amount = '<span class="value">'.wc_price($amount).'</span><span class="text">'.$text.'</span>';
                    }

                    $html .= '<li>';
                    $html .= '<div rel="no-follow" title="'.$title.'" data-id="'.$id.'" data-coupon="'.$name.'" data-free="'.$free.'">';
                    $html .= '<span class="discount">'.$amount.'</span>';
                    $html .= $name || $date ? '<span class="name-date">' : '';
                    $html .= $name ? '<span class="name">'.$name.'</span>' : '';
                    $html .= $date ? '<span class="date">'.$date.'</span>' : '';
                    $html .= $name || $date ? '</span>' : '';
                    $html .= $desc ? '<span class="desc">'.$desc.'</span>' : '';
                    $html .= '</div>';
                    $html .= '</li>';
                }
            }
            if ( $location == 'product' ) {
                echo '<div class="electron-summary-item coupons electron-scrollbar horizontal electron-spinner">'.$html.'</div>';
            } elseif ( $location == 'shop' )  {
                echo '<div class="coupons-filters electron-spinner"><ul class="coupons">'.$html.'</ul></div>';
            } else {
                echo '<ul class="coupons electron-scrollbar electron-spinner">'.$html.'</ul>';
            }
        }
    }
}

// Ürünleri kupon parametresine göre filtrele
add_action('woocommerce_product_query', 'filter_products_by_coupon');
function filter_products_by_coupon($query) {
    $perpage     = electron_settings( 'shop_perpage' );
    $coupon_code = isset($_GET['coupon_code']) ? sanitize_text_field($_GET['coupon_code']) : '';
    $filter_cats = isset($_GET['filter_cats']) ? sanitize_text_field($_GET['filter_cats']) : '';
    $per_page    = isset( $_GET['per_page'] ) && $_GET['per_page'] ? esc_html( $_GET['per_page'] ) : $perpage;

    if (!empty($coupon_code)) {
        $coupon = new WC_Coupon($coupon_code);
        $product_ids = $coupon->get_product_ids();
        if (!empty($product_ids)) {
            $query->set('post__in', $product_ids);
        }
    }
}


/**
* Add to cart handler.
*/
if ( !function_exists( 'electron_ajax_add_to_cart_handler' ) ) {
    function electron_ajax_add_to_cart_handler()
    {
        electron_cart_fragments();
    }
    add_action( 'wc_ajax_electron_ajax_add_to_cart', 'electron_ajax_add_to_cart_handler' );
    add_action( 'wc_ajax_nopriv_electron_ajax_add_to_cart', 'electron_ajax_add_to_cart_handler' );
}

if ( !function_exists( 'apply_coupon_callback' ) ) {
    function apply_coupon_handler()
    {
        // Get the AJAX data
        $coupon = $_POST['coupon_code'];
        $action = $_POST['action_type'];
        if ( $action == 'remove' ) {
            // Remove the coupons
            WC()->cart->remove_coupon($coupon);
        } else {
            // Remove the coupons
            WC()->cart->remove_coupons();

            // Apply the coupon
            $applied = WC()->cart->apply_coupon($coupon);
        }

        WC()->cart->calculate_totals();

        $fragments = array(
            'name'    => $coupon,
            'applied' => $action == 'add' ? $applied : ''
        );

        electron_cart_fragments('coupon',$fragments);
    }
    add_action('wp_ajax_electron_apply_coupon', 'apply_coupon_handler');
    add_action('wp_ajax_nopriv_electron_apply_coupon', 'apply_coupon_handler');
}

if ( !function_exists( 'electron_remove_from_cart_handler' ) ) {
    function electron_remove_from_cart_handler()
    {
        $cart_item_key = wc_clean( isset( $_POST['cart_item_key'] ) ? wp_unslash( $_POST['cart_item_key'] ) : '' );

        if ( $cart_item_key && false !== WC()->cart->remove_cart_item( $cart_item_key ) ) {
            electron_cart_fragments('remove');
        } else {
            wp_send_json_error();
        }
    }
    add_action( 'wc_ajax_electron_remove_from_cart', 'electron_remove_from_cart_handler' );
    add_action( 'wc_ajax_nopriv_electron_remove_from_cart', 'electron_remove_from_cart_handler' );
}

if ( !function_exists( 'electron_ajax_update_cart_handler' ) ) {
    function electron_ajax_update_cart_handler()
    {
       if ( ( isset( $_GET['id'] ) && $_GET['id'] ) && ( isset( $_GET['qty'] ) ) ) {

           if ( $_GET['qty'] ) {
               WC()->cart->set_quantity( $_GET['id'], $_GET['qty'] );
           } else {
               WC()->cart->remove_cart_item( $_GET['id'] );
           }

           if ( WC()->cart->get_cart_contents_count() == 0 ) {
               $fragments = array(
                   'msg' => esc_html__('Your order has been reset!','electron')
               );
           } else {
               $fragments = array(
                   'msg' => $_GET['qty']
               );
           }

           if ( $_GET['is_cart'] == 'yes' ) {
               ob_start();
               get_template_part('woocommerce/cart/cart');
               $cart = ob_get_clean();
               $fragments['cart'] = $cart;
               electron_cart_fragments('update',$fragments);
           } else {
               electron_cart_fragments('update',$fragments);
           }
       }
    }
    add_action( 'wc_ajax_electron_ajax_update_cart', 'electron_ajax_update_cart_handler' );
    add_action( 'wc_ajax_nopriv_electron_ajax_update_cart', 'electron_ajax_update_cart_handler' );
}

if ( !function_exists( 'electron_clear_cart_handler' ) ) {
    function electron_clear_cart_handler()
    {
        global $woocommerce;

        $fragments = array(
            'status' => 'error',
            'msg'    => esc_html__('Your order could not be emptied','electron')
        );

        WC()->cart->empty_cart();

        if ( WC()->cart->get_cart_contents_count() == 0 ) {
            $fragments = array(
                'status' => 'success',
                'msg'    => esc_html__('Your order has been reset!','electron')
            );
        }

        electron_cart_fragments('clear',$fragments);
    }
    add_action('wc_ajax_electron_clear_cart', 'electron_clear_cart_handler');
    add_action('wc_ajax_nopriv_electron_clear_cart', 'electron_clear_cart_handler');
}

if ( !function_exists( 'electron_quantity_button' ) ) {
    function electron_quantity_button() {
        if ( ( isset( $_GET['id'] ) && $_GET['id'] ) && ( isset( $_GET['qty'] ) ) ) {

            if ( $_GET['qty'] ) {
                WC()->cart->set_quantity( $_GET['id'], $_GET['qty'] );
            } else {
                WC()->cart->remove_cart_item( $_GET['id'] );
            }

            if ( esc_html( WC()->cart->get_cart_contents_count() ) == 0 ) {
                $fragments = array(
                    'msg' => esc_html__('Your order has been reset!', 'electron')
                );
            } else {
                $fragments = array(
                    'msg' => $_GET['qty']
                );
            }

            if ( $_GET['is_cart'] == 'yes' ) {
                ob_start();
                get_template_part('woocommerce/cart/cart');
                $cart = ob_get_clean();
                $fragments['cart'] = $cart;
                electron_cart_fragments('update',$fragments);
            } else {
                electron_cart_fragments('update',$fragments);
            }
        }
    }
    add_action( 'wp_ajax_electron_quantity_button', 'electron_quantity_button' );
    add_action( 'wp_ajax_nopriv_electron_quantity_button', 'electron_quantity_button' );
}

if ( !function_exists( 'electron_cart_fragments' ) ) {
    function electron_cart_fragments( $name = '',$fragments = null )
    {
        $action = electron_settings( 'minicart_type', 'icon' );
        $cart   = 'icon' == $action ? '2' : '';
        ob_start();
        get_template_part('woocommerce/minicart/minicart'.$cart);
        $minicart = ob_get_clean();

        $notices = wc_print_notices(true);

        ob_start();
        $total  = WC()->cart->get_cart_subtotal();
        $total .= ob_get_clean();
        ob_start();
        $total2  = WC()->cart->get_cart_total();
        $total2 .= ob_get_clean();

        ob_start();
        $count  = esc_html( WC()->cart->get_cart_contents_count() );
        $count .= ob_get_clean();

        $data = array(
            'fragments' => array(
                'notices'  => $notices,
                'minicart' => $minicart,
                'total'    => $total,
                'total2'   => $total2,
                'count'    => $count,
                'shipping' => electron_free_shipping_goal_content()
            ),
            'cart_hash' => WC()->cart->get_cart_hash()
        );

        if ( $name == 'clear' && !empty( $fragments ) ) {
            $data['fragments']['clear'] = $fragments;
        }

        if ( $name == 'update' && !empty( $fragments ) ) {
            $data['fragments']['update'] = $fragments;
        }
        if ( $name == 'add' && !empty( $fragments ) ) {
            $data['fragments']['add'] = $fragments;
        }
        if ( $name == 'coupon' && !empty( $fragments ) ) {
            unset($data['fragments']['count']);
            unset($data['fragments']['shipping']);
            $data['fragments']['coupon'] = $fragments;
        }

        wp_send_json( $data );
    }
}

if ( !function_exists( 'electron_load_woo_cart_handler' ) ) {
    function electron_load_woo_cart_handler()
    {
        $action = electron_settings( 'minicart_type', 'icon' );
        $cart   = 'icon' == $action ? '2' : '';
        ob_start();
        get_template_part('woocommerce/minicart/minicart'.$cart);
        $minicart = ob_get_clean();
        $data['minicart'] = $minicart;
        $data['count'] = esc_html( WC()->cart->get_cart_contents_count() );

        wp_send_json( $data );
    }
    add_action( 'wp_ajax_load_woo_cart', 'electron_load_woo_cart_handler' );
    add_action( 'wp_ajax_nopriv_load_woo_cart', 'electron_load_woo_cart_handler' );
}

if ( ! function_exists( 'electron_free_shipping_goal_content' ) ) {
    function electron_free_shipping_goal_content()
    {
        $amount = round( electron_settings( 'free_shipping_progressbar_amount', 500 ), wc_get_price_decimals() );

        if ( !( $amount > 0 ) || '1' != electron_settings( 'free_shipping_progressbar_visibility', 1 ) ) {
            return;
        }

        $message_initial = electron_settings( 'free_shipping_progressbar_message_initial' );
        $message_success = electron_settings( 'free_shipping_progressbar_message_success' );

        $total     = WC()->cart->get_displayed_subtotal();
        $remainder = ( $amount - $total );
        $value     = $total <= $amount ? ( $total / $amount ) * 100 : 100;

        if ( $total == 0 ) {
            $value = 0;
        }

        if ( $total >= $amount ) {
            if ( $message_success ) {
                $message = sprintf('%s', $message_success );
            } else {
                $message = sprintf('%s <strong>%s</strong>',
                esc_html__('Congrats! You are eligible for', 'electron'),
                esc_html__('more to enjoy FREE Shipping', 'electron'));
            }
        } else {
            if ( $message_initial ) {
                $message = sprintf('%s', str_replace( '[remainder]', wc_price( $remainder ), $message_initial ) );
            } else {
                $message = sprintf('%s %s <strong>%s</strong>',
                esc_html__('Buy', 'electron'),
                wc_price( $remainder ),
                esc_html__('more to enjoy FREE Shipping', 'electron'));
            }
        }

        $shipping = array(
            'value'   => $value,
            'message' => $message
        );

        return $shipping;
    }
}


/**
* ajax quick shop handler.
*/
if ( !function_exists( 'electron_ajax_quick_shop' ) ) {

    add_action( 'wp_ajax_electron_ajax_quick_shop', 'electron_ajax_quick_shop' );
    add_action( 'wp_ajax_nopriv_electron_ajax_quick_shop', 'electron_ajax_quick_shop' );

    function electron_ajax_quick_shop()
    {
        global $post, $product;
        $pid     = absint( $_GET['product_id'] );
        $product = wc_get_product( $pid );

        if ( !$product ) {
            return;
        }

        $post = get_post( $pid );
        setup_postdata( $post );
        if ( post_password_required($post) ) {
            $strings = electron_theme_all_settings();
            $text = $strings['protected'];
            $btn  = $strings['check_product'];
            ?>
            <div class="electron-quickshop-wrapper single-content zoom-anim-dialog product-protected">
                <p class="protected-text"><?php echo esc_html_e('This content is password protected.', 'electron'); ?><?php echo esc_html( $text); ?></p>
                <a class="electron-btn-medium electron-btn electron-btn-primary" href="<?php echo esc_url( get_permalink( $pid ) ) ?>"><?php echo esc_html( $btn); ?></a>
            </div>
            <?php
        } else {
            ?>
            <div id="product-<?php echo esc_attr( $pid ); ?>" <?php wc_product_class( 'electron-quickshop-wrapper single-content zoom-anim-dialog', $product ); ?>>
                <div class="electron-quickshop-inner">
                    <?php if ( electron_settings('header_cart_before_buttons', '' ) ) { ?>
                        <div class="minicart-extra-text">
                            <?php echo electron_settings('header_cart_before_buttons', '' ); ?>
                        </div>
                    <?php } ?>

                    <div class="electron-quickshop-form-wrapper">
                        <h5 class="electron-product-title"><?php the_title();?></h5>
                        <?php woocommerce_template_single_price( $product ); ?>
                        <?php woocommerce_template_single_add_to_cart( $product ); ?>
                        <div class="electron-quickshop-notices"></div>
                    </div>

                    <div class="electron-quickshop-buttons-wrapper">
                        <div class="electron-flex">
                            <a class="electron-btn electron-btn-primary" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><span class="btn-text" data-hover="<?php echo esc_html_e( 'View Cart', 'electron' ); ?>"></span></a>
                            <a class="electron-btn electron-btn-primary" href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><span class="btn-text" data-hover="<?php echo esc_html_e( 'Checkout', 'electron' ); ?>"></span></a>
                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
        die();
    }
}


/*************************************************
## Buy Now Button For Single Product
*************************************************/
if ( ! function_exists( 'electron_add_buy_now_button_single' ) ) {
    function electron_add_buy_now_button_single()
    {
        if ( '0' == electron_settings( 'buy_now_visibility', '0' ) ) {
            return false;
        }
        global $product;
        $param = apply_filters( 'electron_buy_now_param', electron_settings( 'buy_now_param', 'electron-buy-now' ) );
        $btn_title = electron_settings( 'buy_now_btn_title', '' ) ? electron_settings( 'buy_now_btn_title' ) : esc_html__( 'Buy Now', 'electron' );
        $icon = '<svg
        class="svgaddtocart electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 32 32"
        xmlns="http://www.w3.org/2000/svg"><use href="#shopBag"></use></svg>';
        if ( $product->is_type( 'simple' ) || $product->is_type( 'variable' ) ) {
            printf( '<button id="buynow" type="submit" name="'.$param.'" value="%d" class="electron-btn-buynow electron-btn electron-btn-primary electron-product-cart has-icon"><span class="cart-text">%s</span>%s</button>', $product->get_ID(), $btn_title,$icon );
        }
    }
}

/*************************************************
## Handle for click on buy now
*************************************************/
if ( ! function_exists( 'electron_handle_buy_now' ) ) {
    function electron_handle_buy_now()
    {
        $param = apply_filters( 'electron_buy_now_param', electron_settings( 'buy_now_param', 'electron-buy-now' ) );

        if ( ! isset( $_REQUEST[ $param ] ) || '0' == electron_settings( 'buy_now_visibility', '0' ) ) {
            return false;
        }

        $quantity     = floatval( isset( $_REQUEST['quantity'] ) ? $_REQUEST['quantity'] : 1 );
        $product_id   = absint( isset( $_REQUEST[ $param ] ) ? $_REQUEST[$param] : 0 );
        $variation_id = absint( isset( $_REQUEST[ 'variation_id' ] ) ? $_REQUEST['variation_id'] : 0 );
        $variation    = [];

        foreach ( $_REQUEST as $name => $value ) {
            if ( substr( $name, 0, 10 ) === 'attribute_' ) {
                $variation[ $name ] = $value;
            }
        }

        if ( $product_id ) {
            if ( '1' == electron_settings( 'buy_now_reset_cart', '0' ) ) {
                WC()->cart->empty_cart();
            }

            if ( $variation_id ) {
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    if ( $cart_item['product_id'] == $product_id && $cart_item['variation_id'] == $variation_id ) {
                        WC()->cart->remove_cart_item( $cart_item_key );
                    }
                }
                WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );
            } else {
                WC()->cart->add_to_cart( $product_id, $quantity );
            }

            switch ( apply_filters( 'electron_buy_now_redirect', electron_settings( 'buy_now_redirect', 'checkout' ) ) ) {
                case 'checkout':
                $redirect = wc_get_checkout_url();
                break;
                case 'cart':
                $redirect = wc_get_cart_url();
                break;
                default:
                $redirect = electron_settings( 'buy_now_redirect_custom', '/' );
            }

            $redirect = esc_url( apply_filters( 'buy_now_redirect_url', $redirect ) );

            if ( empty( $redirect ) ) {
                $redirect = '/';
            }

            wp_safe_redirect( $redirect );

            exit;
        }

    }
    add_action( 'template_redirect', 'electron_handle_buy_now' );
}


/**
* Add category banner if shortcode exists
*/
if ( !function_exists( 'electron_print_category_banner' ) ) {
    add_action( 'electron_shop_before_loop', 'electron_print_category_banner', 10 );
    function electron_print_category_banner()
    {
        $banner = get_term_meta( get_queried_object_id(), 'electron_wc_cat_banner', true );
        $layouts = isset( $_GET['shop_layout'] ) && ( 'left-sidebar' == $_GET['shop_layout'] || 'right-sidebar' == $_GET['shop_layout'] ) ? true : false;

        if ( $banner && ( is_product_category() || is_product_tag() ) ) {

            printf( '<div class="shop-cat-banner electron-before-loop">%s</div>', do_shortcode( $banner ) );

        } else {

            if ( 'left-sidebar' == electron_settings('shop_layout') || 'right-sidebar' == electron_settings('shop_layout') || $layouts ) {

                echo electron_print_elementor_templates( 'shop_before_loop_templates', 'shop-cat-banner-template-wrapper', true );
            }
        }
    }
}


add_action('product_cat_add_form_fields', 'electron_wc_taxonomy_add_new_meta_field', 15, 1);
//Product Cat Create page
function electron_wc_taxonomy_add_new_meta_field() {
    ?>
	<div class="form-field electron_term-cat_svgimage-wrap">
		<label><?php esc_html_e( 'Electron SVG Image', 'electron' ); ?></label>
		<div id="electron_product_cat_svgimage" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="electron_product_cat_svgimage_id" name="electron_product_cat_svgimage_id" />
			<button type="button" class="electron_upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'electron' ); ?></button>
			<button type="button" class="electron_remove_image_button button"><?php esc_html_e( 'Remove image', 'electron' ); ?></button>
		</div>
		<div class="clear"></div>
		<span class="description"><?php esc_html_e( 'You can upload the image here to use svg icon instead of image in some areas.', 'electron'); ?></span>
		<script type="text/javascript">

			// Only show the "remove image" button when needed
			if ( ! jQuery( '#electron_product_cat_hero_bgimage_id' ).val() ) {
				jQuery( '.electron_term-cat_svgimage-wrap .electron_remove_image_button' ).hide();
			}

			// Uploading files
			var electron_cat_hero_file_frame;

			jQuery( document ).on( 'click', '.electron_term-cat_svgimage-wrap .electron_upload_image_button', function( event ) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( electron_cat_hero_file_frame ) {
					electron_cat_hero_file_frame.open();
					return;
				}

				// Create the media frame.
				electron_cat_hero_file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an image', 'electron' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use image', 'electron' ); ?>'
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				electron_cat_hero_file_frame.on( 'select', function() {
					var attachment           = electron_cat_hero_file_frame.state().get( 'selection' ).first().toJSON();
					var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

					jQuery( '#electron_product_cat_svgimage_id' ).val( attachment.id );
					jQuery( '#electron_product_cat_svgimage' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
					jQuery( '.electron_term-cat_svgimage-wrap .electron_remove_image_button' ).show();
				});

				// Finally, open the modal.
				electron_cat_hero_file_frame.open();
			});

			jQuery( document ).on( 'click', '.electron_term-hero-bgimage-wrap .electron_remove_image_button', function() {
				jQuery( '#electron_product_cat_svgimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#electron_product_cat_svgimage_id' ).val( '' );
				jQuery( '.electron_term-cat_svgimage-wrap .electron_remove_image_button' ).hide();
				return false;
			});

			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status
					&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}
					// Clear Thumbnail fields on submit
					jQuery( '#electron_product_cat_svgimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#electron_product_cat_svgimage_id' ).val( '' );
					jQuery( '.electron_term-cat_svgimage-wrap .electron_remove_image_button' ).hide();
					return;
				}
			} );

		</script>
	</div>
	<?php
    woocommerce_wp_textarea_input(
        array(
            'id' => 'electron_wc_cat_banner',
            'label' => esc_html__( 'Electron Category Banner', 'electron' ),
            'description' => esc_html__( 'If you want to show a different banner on the archive category page for this category, use this field.Iframe,shortcode,HTML content allowed.', 'electron' ),
            'rows' => 4
        )
    );
    woocommerce_wp_textarea_input(
        array(
            'id' => 'electron_wc_cat_header',
            'label' => esc_html__( 'Electron Header Category Menu Elementor Template', 'electron' ),
            'description' => esc_html__( 'If you want to show a different banner on the archive category page for this category, use this field.Iframe,shortcode,HTML content allowed.', 'electron' ),
            'rows' => 4
        )
    );
    woocommerce_wp_checkbox(
        array(
            'id' => 'electron_wc_cat_header_mobile',
            'label' => esc_html__( 'Hide Header Category Menu Elementor Template On Mobile?', 'electron' ),
            'description' => esc_html__( 'If you want to hide this template on the header category menu for this category, check this field.', 'electron' )
        )
    );
    ?>
	<div class="form-field electron_term-hero-bgimage-wrap">
		<label><?php esc_html_e( 'Electron Shop Category Page Hero Background Image', 'electron' ); ?></label>
		<div id="electron_product_cat_hero_bgimage" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="electron_product_cat_hero_bgimage_id" name="electron_product_cat_hero_bgimage_id" />
			<button type="button" class="electron_upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'electron' ); ?></button>
			<button type="button" class="electron_remove_image_button button"><?php esc_html_e( 'Remove image', 'electron' ); ?></button>
		</div>
		<div class="clear"></div>
		<span class="description"><?php esc_html_e( 'If you want to show a different background image on the shop archive category page for this category, upload your image from here.', 'electron'); ?></span>
		<script type="text/javascript">

			// Only show the "remove image" button when needed
			if ( ! jQuery( '#electron_product_cat_hero_bgimage_id' ).val() ) {
				jQuery( '.electron_term-hero-bgimage-wrap .electron_remove_image_button' ).hide();
			}

			// Uploading files
			var electron_cat_hero_file_frame;

			jQuery( document ).on( 'click', '.electron_term-hero-bgimage-wrap .electron_upload_image_button', function( event ) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( electron_cat_hero_file_frame ) {
					electron_cat_hero_file_frame.open();
					return;
				}

				// Create the media frame.
				electron_cat_hero_file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an image', 'electron' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use image', 'electron' ); ?>'
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				electron_cat_hero_file_frame.on( 'select', function() {
					var attachment           = electron_cat_hero_file_frame.state().get( 'selection' ).first().toJSON();
					var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

					jQuery( '#electron_product_cat_hero_bgimage_id' ).val( attachment.id );
					jQuery( '#electron_product_cat_hero_bgimage' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
					jQuery( '.electron_term-hero-bgimage-wrap .electron_remove_image_button' ).show();
				});

				// Finally, open the modal.
				electron_cat_hero_file_frame.open();
			});

			jQuery( document ).on( 'click', '.electron_term-hero-bgimage-wrap .electron_remove_image_button', function() {
				jQuery( '#electron_product_cat_hero_bgimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#electron_product_cat_hero_bgimage_id' ).val( '' );
				jQuery( '.electron_term-hero-bgimage-wrap .electron_remove_image_button' ).hide();
				return false;
			});

			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status
					&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}
					// Clear Thumbnail fields on submit
					jQuery( '#electron_product_cat_hero_bgimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#electron_product_cat_hero_bgimage_id' ).val( '' );
					jQuery( '.electron_term-hero-bgimage-wrap .electron_remove_image_button' ).hide();
					return;
				}
			} );

		</script>
	</div>
	<div class="clear"></div>
	<?php
}

add_action('product_cat_edit_form_fields', 'electron_wc_taxonomy_edit_meta_field', 15, 1);
//Product Cat Edit page
function electron_wc_taxonomy_edit_meta_field($term) {

    //getting term ID
    $termId      = $term->term_id;
    $svgImageId  = absint( get_term_meta( $termId, 'electron_product_cat_svgimage_id', true ) );
    $catBanner   = get_term_meta($termId, 'electron_wc_cat_banner', true);
    $catHeader   = get_term_meta($termId, 'electron_wc_cat_header', true);
    $catHeaderM  = get_term_meta($termId, 'electron_wc_cat_header_mobile', true);
    $thumbId     = absint( get_term_meta( $termId, 'electron_product_cat_hero_bgimage_id', true ) );
    $bannerImage = $thumbId ? wp_get_attachment_thumb_url( $thumbId ) : wc_placeholder_img_src();
    $svgImage    = $svgImageId ? wp_get_attachment_thumb_url( $svgImageId ) : wc_placeholder_img_src();
    $tvalue      = $catHeaderM != '' ? ' checked' : '';
    ?>
    <tr class="form-field electron_term-cat_svgimage-wrap">
        <th scope="row" valign="top"><label><?php esc_html_e( 'Electron SVG Image', 'electron' ); ?></label></th>
        <td>
            <div id="electron_product_cat_svgimage" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $svgImage ); ?>" width="60px" height="60px" /></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="electron_product_cat_svgimage_id" name="electron_product_cat_svgimage_id" value="<?php echo esc_attr( $svgImageId ); ?>" />
                <button type="button" class="electron_upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'electron' ); ?></button>
                <button type="button" class="electron_remove_image_button button"><?php esc_html_e( 'Remove image', 'electron' ); ?></button>
            </div>
            <div class="clear"></div>
            <span class="description"><?php esc_html_e( 'You can upload the image here to use svg icon instead of image in some areas.', 'electron'); ?></span>
            <script type="text/javascript">

            // Only show the "remove image" button when needed
            if ( '0' === jQuery( '#electron_product_cat_svgimage_id' ).val() ) {
                jQuery( '.electron_term-cat_svgimage-wrap .electron_remove_image_button' ).hide();
            }

            // Uploading files
            var electron_cat_hero_file_frame;

            jQuery( document ).on( 'click', '.electron_term-cat_svgimage-wrap .electron_upload_image_button', function( event ) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( electron_cat_hero_file_frame ) {
                    electron_cat_hero_file_frame.open();
                    return;
                }

                // Create the media frame.
                electron_cat_hero_file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php esc_html_e( 'Choose an image', 'electron' ); ?>',
                    button: {
                        text: '<?php esc_html_e( 'Use image', 'electron' ); ?>'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback.
                electron_cat_hero_file_frame.on( 'select', function() {
                    var attachment           = electron_cat_hero_file_frame.state().get( 'selection' ).first().toJSON();
                    var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                    jQuery( '#electron_product_cat_svgimage_id' ).val( attachment.id );
                    jQuery( '#electron_product_cat_svgimage' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
                    jQuery( '.electron_term-cat_svgimage-wrap .electron_remove_image_button' ).show();
                });

                // Finally, open the modal.
                electron_cat_hero_file_frame.open();
            });

            jQuery( document ).on( 'click', '.electron_term-cat_svgimage-wrap .electron_remove_image_button', function() {
                jQuery( '#electron_product_cat_svgimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                jQuery( '#electron_product_cat_svgimage_id' ).val( '' );
                jQuery( '.electron_term-cat_svgimage-wrap .electron_remove_image_button' ).hide();
                return false;
            });

            </script>
        <div class="clear"></div>
        </td>
    </tr>

    <tr class="form-field term-electron-banner-wrap">
        <th scope="row" valign="top"><label for="electron_wc_cat_banner"><?php esc_html_e('Electron Banner', 'electron'); ?></label></th>
        <td>
            <textarea name="electron_wc_cat_banner" id="electron_wc_cat_banner" rows="5" cols="50" class="large-text"><?php echo esc_html($catBanner) ? $catBanner : ''; ?></textarea>
            <p class="description"><?php esc_html_e('If you want to show a different banner on the archive category page for this category, use this field.Iframe,shortcode,HTML content allowed.', 'electron'); ?></p>
        </td>
    </tr>
    <tr class="form-field term-electron-banner-wrap">
        <th scope="row" valign="top"><label for="electron_wc_cat_header"><?php esc_html_e('Electron Header Category Menu Elementor Template', 'electron'); ?></label></th>
        <td>
            <textarea name="electron_wc_cat_header" id="electron_wc_cat_header" rows="5" cols="50" class="large-text"><?php echo esc_html($catHeader) ? $catHeader : ''; ?></textarea>
            <p class="description"><?php esc_html_e('If you want to show a different template on the header category menu for this category, use this field.Iframe,shortcode,HTML content allowed.', 'electron'); ?></p>
        </td>
    </tr>
    <tr class="form-field term-electron-banner-wrap">
        <th scope="row" valign="top"><label for="electron_wc_cat_header_mobile"><?php esc_html_e('Hide Header Category Menu Elementor Template On Mobile?', 'electron'); ?></label></th>
        <td>
			<input type="checkbox" id="electron_wc_cat_header_mobile" name="electron_wc_cat_header_mobile" value="yes"<?php echo esc_attr( $tvalue ); ?> />
            <p class="description"><?php esc_html_e('If you want to hide this template on the header category menu for this category, check this field.', 'electron'); ?></p>
        </td>
    </tr>
    <tr class="form-field electron_term-hero_bgimage-wrap">
        <th scope="row" valign="top"><label><?php esc_html_e( 'Electron Shop Category Page Hero Background Image', 'electron' ); ?></label></th>
        <td>
            <div id="electron_product_cat_hero_bgimage" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $bannerImage ); ?>" width="60px" height="60px" /></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="electron_product_cat_hero_bgimage_id" name="electron_product_cat_hero_bgimage_id" value="<?php echo esc_attr( $thumbId ); ?>" />
                <button type="button" class="electron_upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'electron' ); ?></button>
                <button type="button" class="electron_remove_image_button button"><?php esc_html_e( 'Remove image', 'electron' ); ?></button>
            </div>
            <div class="clear"></div>
            <span class="description"><?php esc_html_e( 'If you want to show a different background image on the shop archive category page for this category, upload your image from here.', 'electron'); ?></span>
            <script type="text/javascript">

            // Only show the "remove image" button when needed
            if ( '0' === jQuery( '#electron_product_cat_hero_bgimage_id' ).val() ) {
                jQuery( '.electron_term-hero_bgimage-wrap .electron_remove_image_button' ).hide();
            }

            // Uploading files
            var electron_cat_hero_file_frame;

            jQuery( document ).on( 'click', '.electron_term-hero_bgimage-wrap .electron_upload_image_button', function( event ) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( electron_cat_hero_file_frame ) {
                    electron_cat_hero_file_frame.open();
                    return;
                }

                // Create the media frame.
                electron_cat_hero_file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php esc_html_e( 'Choose an image', 'electron' ); ?>',
                    button: {
                        text: '<?php esc_html_e( 'Use image', 'electron' ); ?>'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback.
                electron_cat_hero_file_frame.on( 'select', function() {
                    var attachment           = electron_cat_hero_file_frame.state().get( 'selection' ).first().toJSON();
                    var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                    jQuery( '#electron_product_cat_hero_bgimage_id' ).val( attachment.id );
                    jQuery( '#electron_product_cat_hero_bgimage' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
                    jQuery( '.electron_term-hero_bgimage-wrap .electron_remove_image_button' ).show();
                });

                // Finally, open the modal.
                electron_cat_hero_file_frame.open();
            });

            jQuery( document ).on( 'click', '.electron_term-hero_bgimage-wrap .electron_remove_image_button', function() {
                jQuery( '#electron_product_cat_hero_bgimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                jQuery( '#electron_product_cat_hero_bgimage_id' ).val( '' );
                jQuery( '.electron_term-hero_bgimage-wrap .electron_remove_image_button' ).hide();
                return false;
            });

            </script>
            <div class="clear"></div>
        </td>
    </tr>
    <?php
}

add_action('edited_product_cat', 'electron_wc_save_taxonomy_custom_meta', 15, 1);
add_action('create_product_cat', 'electron_wc_save_taxonomy_custom_meta', 15, 1);
// Save extra taxonomy fields callback function.
function electron_wc_save_taxonomy_custom_meta( $term_id ) {

    $catBanner     = filter_input(INPUT_POST, 'electron_wc_cat_banner');
    $catHeader     = filter_input(INPUT_POST, 'electron_wc_cat_header');
    $catHeaderM    = filter_input(INPUT_POST, 'electron_wc_cat_header_mobile');
    $bannerImageId = filter_input(INPUT_POST, 'electron_product_cat_hero_bgimage_id');
    $svgImageId    = filter_input(INPUT_POST, 'electron_product_cat_svgimage_id');
    update_term_meta($term_id, 'electron_wc_cat_banner', $catBanner);
    update_term_meta($term_id, 'electron_wc_cat_header', $catHeader);
    update_term_meta($term_id, 'electron_wc_cat_header_mobile', $catHeaderM);
    update_term_meta($term_id, 'electron_product_cat_hero_bgimage_id', $bannerImageId);
    update_term_meta($term_id, 'electron_product_cat_svgimage_id', $svgImageId);
}

//Displaying Additional Columns
add_filter( 'manage_edit-product_cat_columns', 'electron_wc_customFieldsListTitle' ); //Register Function

function electron_wc_customFieldsListTitle( $columns ) {
    $columns['electron_cat_banner'] = esc_html__( 'Banner', 'electron' );
    return $columns;
}

add_action( 'manage_product_cat_custom_column', 'electron_wc_customFieldsListDisplay' , 10, 3); //Populating the Columns
function electron_wc_customFieldsListDisplay( $columns, $column, $id ) {
    if ( 'electron_cat_banner' == $column ) {
        $columns = get_term_meta($id, 'electron_wc_cat_banner', true);
        $columns = $columns ? '<span class="wc-banner"></span>' : '';
    }
    return $columns;
}

if ( ! function_exists( 'electron_wc_per_page_select' ) ) {
    function electron_wc_per_page_select()
    {
        if ( ! wc_get_loop_prop( 'is_paginated' ) ) {
            return;
        }

        $numbers = electron_settings( 'per_page_select_options' );
        $per_page_opt = ( ! empty( $numbers ) ) ? explode( ',', $numbers ) : array( 9, 12, 24, 36 );

        ?>
        <div class="electron-filter-per-page electron-shop-filter-item">
            <ul class="electron-filter-action">
                <li class="electron-per-page-title"><?php esc_html_e( 'Show', 'electron' ); ?></li>
                <?php foreach ( $per_page_opt as $key => $value ) {

                    $link = add_query_arg( 'per_page', $value );

                    $classes = isset( $_GET['per_page'] ) && $_GET['per_page'] === $value ? ' active' : '';
                    $val = $value == -1 ? esc_html__( 'All', 'electron' ) : $value;
                    ?>
                    <li class="electron-per-page-item<?php echo esc_attr( $classes ); ?>">
                        <a rel="nofollow noopener" href="<?php echo esc_url( $link ); ?>"><?php esc_html( printf( '%s', $val ) ); ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }
}

if ( ! function_exists( 'electron_wc_column_select' ) ) {
    function electron_wc_column_select()
    {
        if ( ! wc_get_loop_prop( 'is_paginated' ) ) {
            return;
        }
        if ( !electron_get_shop_column() && 'list' == electron_settings( 'shop_product_type', '2' ) ) {
            $col = 1;
        } elseif ( intval( electron_get_shop_column() ) > 1 ) {
            $col = intval( electron_get_shop_column() );
        } else {
            $col = isset( $_GET['column'] ) && $_GET['column'] ? intval( $_GET['column'] ) : intval( electron_settings( 'shop_colxl' ) );
        }

        $active = $hide = '';
        $cols = array( 1, 2, 3, 4, 5 );

        ?>
        <div class="electron-filter-column-select electron-shop-filter-item">
            <ul class="electron-filter-action electron-filter-columns electron-mini-icon">
                <?php
                foreach ( $cols as $key => $value ) {

                    if ( ( $col < 6 ) && ( $col === $value ) ) {
                        $active = ' active';
                    }
                    if ( $value === 3 ) {
                        $hide = ' d-none d-sm-flex';
                    }
                    if ( $value === 4 ) {
                        $hide = ' d-none d-lg-flex';
                    }
                    if ( $value === 5 ) {
                        $hide = ' d-none d-xl-flex';
                    }
                    ?>
                    <li class="<?php echo esc_attr( 'val-'.$value.$active.$hide ); ?>">
                        <a href="<?php echo esc_url( add_query_arg( 'column', $value ) ); ?>" rel="nofollow noreferrer"><?php echo electron_svg_lists('column-'.$value, 'electron-svg-icon');?></a>
                    </li>
                    <?php
                    $active = '';
                }
                ?>
            </ul>
        </div>
        <?php
    }
}


if ( !function_exists( 'electron_wc_category_search_form' ) ) {
    function electron_wc_category_search_form()
    {
        $terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0 ) );
        ?>
        <div class="header-search-wrap">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/'  ) ) ?>">
                <input  type="text" name="s"
                value="<?php get_search_query() ?>"
                placeholder="<?php echo esc_attr_e( 'Search for your item\'s type.....', 'electron' ) ?>">
                <input type="hidden" name="post_type" value="product" />
                <select class="custom-select" name="product_cat">
                    <option value="" selected><?php echo esc_html_e( 'All Category', 'electron' ) ?></option>
                    <?php
                    foreach ( $terms as $term ) {
                        if ( $term->count >= 1 ) {
                            ?>
                            <option value="<?php echo esc_attr( $term->slug ) ?>"><?php echo esc_html( $term->name ) ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <button class="btn-submit" type="submit"><?php echo electron_svg_lists( 'search' ); ?></button>
                <?php do_action( 'wpml_add_language_form_field' ); ?>
            </form>
        </div>
        <?php
    }
}


if ( !function_exists( 'shop_loop_categories' ) ) {
    add_action('electron_shop_before_loop','shop_loop_categories', 11 );
    function shop_loop_categories()
    {
        $mode = woocommerce_get_loop_display_mode();
        $col  = ' column-'.electron_settings('shop_col');
        if ( $mode == 'subcategories' || $mode == 'both' ) {
            echo '<div class="electron-shop-categories'.$col.'">'.woocommerce_maybe_show_product_subcategories().'</div>';
        }
    }
}


if ( !function_exists( 'electron_shop_main_loop' ) ) {
    add_action('electron_shop_main_loop','electron_shop_main_loop', 10 );
    function electron_shop_main_loop()
    {
        $pagination = apply_filters('electron_shop_pagination_type', electron_settings('shop_paginate_type') );
        $col        = electron_settings('shop_col');
        $loop       = woocommerce_product_loop();
        $type       = isset($_GET['product_style']) ? esc_html($_GET['product_style']) : electron_settings( 'shop_product_type', '1' );
        $type       = apply_filters( 'electron_loop_product_type', $type );
        $column     = ( isset($_GET['column']) && $_GET['column'] == '1' ) || ( is_archive() && $type == 'list' ) ? ' products-type-list' : ' products';
        $column    .= isset($_GET['column']) ? ' column-'.esc_html($_GET['column']) : ' column-'.$col;
        $is_tax     = isset( get_queried_object()->term_id ) ? get_queried_object()->term_id : '';
        $loop_mode  = woocommerce_get_loop_display_mode();

        echo '<div class="electron-products-wrapper">';

            do_action( 'electron_shop_choosen_filters' );

            echo '<div class="shop-data-filters" data-shop-filters=\''.electron_wc_filters_for_ajax().'\'></div>';

            echo '<div class="electron-products'.$column.'">';

                if ( $loop && wc_get_loop_prop( 'total' ) ) {

                    while ( have_posts() ) {
                        the_post();

                        /**
                        * Hook: woocommerce_shop_loop.
                        */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content', 'product' );
                    }
                }

            echo '</div>';

            if ( $loop ) {
                /**
                * Hook: electron_shop_pagination.
                *
                * @hooked electron_shop_pagination
                */
                do_action( 'electron_shop_pagination' );
            } else {
                /**
                * Hook: woocommerce_no_products_found.
                *
                * @hooked wc_no_products_found - 10
                */
                do_action( 'woocommerce_no_products_found' );
            }
        echo '</div>';
    }
}


if ( !function_exists( 'electron_shop_sidebar' ) ) {
    add_action('electron_shop_before_loop','electron_shop_choosen_filters_row', 20 );
    function electron_shop_choosen_filters_row()
    {
        $layout  = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'shop_layout', 'left-sidebar' );
        $filters = electron_settings( 'choosen_filters_before_loop', '1' );

        if ( ('left-sidebar' == $layout || 'right-sidebar' == $layout ) && is_active_sidebar( 'shop-page-sidebar' ) && '1' == $filters ) {
            ?>
            <div class="electron-choosen-filters-row electron-hidden-on-mobile">
                <?php do_action( 'electron_choosen_filters' );?>
            </div>
            <?php
        }
    }
}

if ( !function_exists( 'electron_shop_sidebar' ) ) {
    add_action('electron_shop_sidebar','electron_shop_sidebar', 10 );
    function electron_shop_sidebar()
    {
        $layout = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'shop_layout', 'left-sidebar' );
        if ( ( 'left-sidebar' == $layout || 'right-sidebar' == $layout ) && is_active_sidebar( 'shop-page-sidebar' ) ) {
            ?>
            <div id="nt-sidebar" class="nt-sidebar default-sidebar">
                <div class="electron-panel-close-button panel-close" data-target=".nt-sidebar"></div>
                <div class="nt-sidebar-inner-wrapper">
                    <?php do_action( 'electron_choosen_filters' );?>
                    <div class="nt-sidebar-inner electron-scrollbar">
                        <?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

if ( !function_exists( 'electron_shop_top_hidden_sidebar' ) ) {
    add_action('electron_shop_before_loop','electron_shop_top_hidden_sidebar', 20 );
    function electron_shop_top_hidden_sidebar()
    {
        $layout = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'shop_layout', 'left-sidebar' );
        $column = electron_settings( 'shop_hidden_sidebar_column', '3' );
        if ( 'top-sidebar' == $layout && is_active_sidebar( 'shop-page-sidebar' ) ) {
            ?>
            <div id="nt-sidebar" class="nt-sidebar electron-shop-hidden-top-sidebar d-none">
                <div class="electron-panel-close-button panel-close" data-target=".nt-sidebar"></div>
                <div class="nt-sidebar-inner-wrapper">
                    <?php do_action( 'electron_choosen_filters' );?>
                    <div class="nt-sidebar-inner sidebar-col-<?php echo esc_attr( $column ); ?> electron-scrollbar">
                        <?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

if ( !function_exists( 'electron_shop_sidebar_fixed' ) ) {
    add_action('electron_after_shop_page','electron_shop_sidebar_fixed', 20 );
    function electron_shop_sidebar_fixed()
    {
        $layout = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'shop_layout', 'left-sidebar' );
        $is_pjax = electron_is_pjax() ? ' is_pjax' : ' site-main-sidebar';
        if ( 'fixed-sidebar' == $layout && is_active_sidebar( 'shop-page-sidebar' ) ) {
            ?>
            <div id="nt-sidebar" class="nt-sidebar electron-shop-fixed-sidebar<?php echo esc_attr( $is_pjax ); ?>">
                <div class="electron-panel-close-button panel-close" data-target=".nt-sidebar"></div>
                <div class="nt-sidebar-inner-wrapper">
                    <?php do_action( 'electron_choosen_filters' );?>
                    <div class="nt-sidebar-inner electron-scrollbar">
                        <?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}


if ( !function_exists( 'shop_loop_filters_layouts' ) ) {
    add_action('electron_shop_before_loop','shop_loop_filters_layouts', 15 );
    function shop_loop_filters_layouts()
    {
        $defaults = [
            'left'=> [
                'result-count' => ''
            ],
            'right'=> [
                'sidebar-filter' => '',
                'per-page' => '',
                'ordering' => '',
                'column-select' => ''
            ]
        ];
        $layouts = apply_filters( 'electron_get_filters_layouts', electron_settings( 'shop_loop_filters_layouts', $defaults ) );
        $page_layout = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'shop_layout', 'left-sidebar' );
        if ( $layouts ) {

            unset( $layouts['left']['placebo'] );
            unset( $layouts['right']['placebo'] );

            echo '<div class="electron-inline-two-block electron-before-loop electron-shop-filter-top-area">';

                if ( !empty( $layouts['left'] ) ) {
                    echo '<div class="electron-block-left">';
                        foreach ( $layouts['left'] as $key => $value ) {
                            switch ( $key ) {
                                case 'sidebar-filter':
                                if ( $page_layout == 'top-sidebar' && is_active_sidebar( 'shop-page-sidebar' ) ) {
                                    echo '<div class="electron-toggle-hidden-sidebar"><span>'.esc_html__( 'Filter', 'electron' ).'</span> '.electron_svg_lists( 'filter', 'electron-svg-icon' ).'<div class="electron-filter-close"></div></div>';
                                }
                                if ( $page_layout != 'no-sidebar' && is_active_sidebar( 'shop-page-sidebar' ) ) {
                                    echo '<div class="electron-open-fixed-sidebar panel-open" data-target=".nt-sidebar"><span>'.esc_html__( 'Filter', 'electron' ).'</span> '.electron_svg_lists( 'filter', 'electron-svg-icon' ).'</div>';
                                }
                                break;

                                case 'search':
                                if ( '1' == electron_header_settings( 'popup_search_visibility' ) ) {
                                    echo '<div class="top-action-btn panel-open" data-target=".electron-popup-search">'.electron_svg_lists( 'search', 'electron-svg-icon' ).'</div>';
                                }
                                break;

                                case 'result-count':
                                echo '<div class="electron-woo-result-count">';woocommerce_result_count();echo '</div>';
                                break;

                                case 'breadcrumbs':
                                echo '<div class="electron-woo-breadcrumb">'.electron_breadcrumbs().'</div>';
                                break;

                                case 'per-page':
                                echo '<div class="electron-shop-filter-area electron-filter-per-page-area">';
                                    electron_wc_per_page_select();
                                echo '</div>';
                                break;

                                case 'column-select':
                                echo '<div class="electron-shop-filter-area electron-filter-column-select-area">';
                                    electron_wc_column_select();
                                echo '</div>';
                                break;

                                case 'ordering':
                                if ( woocommerce_product_loop() ) {
                                    echo '<div class="electron-shop-filter-area electron-filter-ordering-area">';
                                        woocommerce_catalog_ordering();
                                    echo '</div>';
                                }
                                break;
                            }
                        }
                    echo '</div>';
                }

                if ( !empty( $layouts['right'] ) ) {
                    echo '<div class="electron-block-right">';
                        foreach ( $layouts['right'] as $key => $value ) {
                            switch ( $key ) {

                                case 'sidebar-filter':
                                if ( $page_layout == 'top-sidebar' && is_active_sidebar( 'shop-page-sidebar' ) ) {
                                    echo '<div class="electron-toggle-hidden-sidebar"><span>'.esc_html__( 'Filter', 'electron' ).'</span> '.electron_svg_lists( 'filter', 'electron-svg-icon' ).'<div class="electron-filter-close"></div></div>';
                                }
                                if ( $page_layout != 'no-sidebar' && is_active_sidebar( 'shop-page-sidebar' ) ) {
                                    echo '<div class="electron-open-fixed-sidebar panel-open" data-target=".nt-sidebar"><span>'.esc_html__( 'Filter', 'electron' ).'</span> '.electron_svg_lists( 'filter', 'electron-svg-icon' ).'</div>';
                                }
                                break;

                                case 'search':
                                if ( '1' == electron_header_settings( 'popup_search_visibility' ) ) {
                                    echo '<div class="top-action-btn panel-open" data-target=".electron-popup-search">'.electron_svg_lists( 'search', 'electron-svg-icon' ).'</div>';
                                }
                                break;

                                case 'result-count':
                                echo '<div class="electron-woo-result-count">';woocommerce_result_count();echo '</div>';
                                break;

                                case 'breadcrumbs':
                                echo '<div class="electron-woo-breadcrumb">'.electron_breadcrumbs().'</div>';
                                break;

                                case 'per-page':
                                echo '<div class="electron-shop-filter-area electron-filter-per-page-area">';
                                    electron_wc_per_page_select();
                                echo '</div>';
                                break;

                                case 'column-select':
                                echo '<div class="electron-shop-filter-area electron-filter-column-select-area">';
                                    electron_wc_column_select();
                                echo '</div>';
                                break;

                                case 'ordering':
                                if ( woocommerce_product_loop() ) {
                                    echo '<div class="electron-shop-filter-area electron-filter-ordering-area">';
                                        woocommerce_catalog_ordering();
                                    echo '</div>';
                                }
                                break;
                            }
                        }
                    echo '</div>';
                }
            echo '</div>';
        }
    }
}


/**
* Product thumbnail
*/
if ( ! function_exists( 'electron_loop_product_thumb_two_column_size' ) ) {
    function electron_loop_product_thumb_two_column_size()
    {
        return 'electron-grid';
    }
}

if ( ! function_exists( 'electron_loop_product_thumb' ) ) {
	function electron_get_cropped_image( $id )
	{
		if ( empty( $id ) ) {
			return false;
		}

        $imageid = get_post_thumbnail_id($id);
        $size    = apply_filters( 'electron_single_product_archive_thumbnail_custom_size', array() );

        if ( !empty($size[0]) && !empty($size[1]) ) {
            // Use BFI_Thumb script
            // TODO: Please rewrite this code.
            require_once ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php';

            $attachment_size = [
                // Defaults sizes
                0 => $size[0], // Width.
                1 => $size[1], // Height.
                'bfi_thumb' => true,
                'crop' => true
            ];

            $img = get_post( $imageid );
            $src = wp_get_attachment_image_src( $imageid, $attachment_size );

            $attr  = 'src="'.$src[0].'"';
            $attr .= ' width="'.$size[0].'" height="'.$size[1].'"';
            $attr .= ' alt="'.get_post_meta( $img->ID, '_wp_attachment_image_alt', true ).'"';
            $attr .= ' title="'.$img->post_title.'"';
            $attr .= ' class="attachment-'.$size[0].' size-'.$size[1].' wp-image-'.$imageid.'"';

            return '<img '.$attr.' loading="lazy" />';

        } else {
            return wp_get_attachment_image( $imageid, 'thumbnail' );
        }
	}

    function electron_loop_product_thumb()
    {
        global $product;
        $id   = $product->get_id();
        $size = apply_filters( 'electron_single_product_archive_thumbnail_size', '__return_false' );

        if ( '2' == electron_get_shop_column() ) {
            add_filter( 'single_product_archive_thumbnail_size', 'electron_loop_product_thumb_two_column_size' );
        }

        ?>
        <a href="<?php echo esc_url( get_permalink() ) ?>" class="electron-product-thumb product-link" title="<?php echo get_the_title($id); ?>">
            <?php
            if ( $size == 'custom' && class_exists( '\Elementor\Plugin' ) ) {
                echo electron_get_cropped_image($id);
            } else {
                echo woocommerce_get_product_thumbnail();
            }
            ?>
        </a>
        <?php
    }
}


if ( ! function_exists( 'electron_get_swatches_colors' ) ) {
    function electron_get_swatches_colors()
    {
        $colors = array();
        $terms  = get_terms("pa_color");
        if ( empty( $terms ) ) {
            return;
        }
        foreach ( $terms as $term ) {
            if ( !empty( $term->term_id ) ) {
                $val = get_term_meta( $term->term_id, 'electron_swatches_color', true );
                $colors[$term->name] = $val;
            }
        }
        return !empty( $colors ) ? $colors : false;
    }
}


/*************************************************
## Shipping Class Name
*************************************************/
if ( !function_exists( 'electron_shipping_class_name' ) ) {
    function electron_shipping_class_name( $type = 'name' )
    {
        global $product;
        $class_id = $product->get_shipping_class_id();
        if ( $class_id ) {
            $term = get_term_by( 'id', $class_id, 'product_shipping_class' );
            if( $type == 'desc' ) {
                if ( $term && ! is_wp_error( $term ) ) {
                    return $term->description;
                }
            } else {
                if ( $term && ! is_wp_error( $term ) ) {
                    return $term->name;
                }
            }
        }
        return '';
    }
}


/*************************************************
## Shop Fast Filters
*************************************************/
if ( !function_exists( 'electron_shop_check_fast_filters' ) ) {
    function electron_shop_check_fast_filters()
    {
        $terms = electron_settings( 'shop_fast_filter_terms' );

        $check_filters = false;

        if ( !empty( $terms ) ) {
            foreach ( $terms as $tax ) {
                if ( isset( $_GET['filter_'.$tax] ) ) {
                    $check_filters = true;
                }
            }
        }

        if ( ( isset( $_GET['featured'] ) && $_GET['featured'] == 'yes' )
        || ( isset( $_GET['best_seller'] ) && $_GET['best_seller'] == 'yes' )
        || ( isset( $_GET['rating_filter'] ) && $_GET['rating_filter'] == '5' )
        || ( isset( $_GET['on_sale'] ) && $_GET['on_sale'] == 'onsale' )
        || ( isset( $_GET['stock_status'] ) && $_GET['stock_status'] == 'instock' )
        || $check_filters ) {
            return true;
        }

        return false;
    }
}

if ( !function_exists( 'electron_shop_top_fast_filters' ) ) {
    add_action( 'electron_shop_before_loop', 'electron_shop_top_fast_filters',12 );
    function electron_shop_top_fast_filters()
    {
        global $wp;

        $has_filter = electron_shop_check_fast_filters();

        if ( '0' == electron_settings('shop_fast_filter_visibility', '1' ) ) {
            return;
        }

        $filter_main = electron_settings( 'shop_fast_filter_main' );
        $terms       = electron_settings( 'shop_fast_filter_terms' );
        $is_ajax     = '1' == electron_settings( 'shop_fast_filter_ajax' ) ? ' is-ajax' : '';
        $stock_sale  = 'show-always' == electron_settings( 'shop_fast_filter_stock_sale_status' ) ? ' show-always' : ' show-after-filter';

        // titles
        $maintitle_title  = electron_settings( 'shop_fast_filter_main_title' );
        $removeall_title  = electron_settings( 'shop_fast_filter_remove_title' );
        $featured_title   = electron_settings( 'shop_fast_filter_featured_title' );
        $bestseller_title = electron_settings( 'shop_fast_filter_bestseller_title' );
        $toprated_title   = electron_settings( 'shop_fast_filter_toprated_title' );
        $onsale_title     = electron_settings( 'shop_fast_filter_onsale_title' );
        $instock_title    = electron_settings( 'shop_fast_filter_instock_title' );

        $titles = [
            'maintitle'  => $maintitle_title ? $maintitle_title : esc_html__('Fast Filters:', 'electron'),
            'removeall'  => $removeall_title ? $removeall_title : esc_html__('Remove All', 'electron'),
            'featured'   => $featured_title ? $featured_title : esc_html__('Featured', 'electron'),
            'bestseller' => $bestseller_title ? $bestseller_title : esc_html__('Best sellers', 'electron'),
            'toprated'   => $toprated_title ? $toprated_title : esc_html__('Top rated', 'electron'),
            'onsale'     => $onsale_title ? $onsale_title : esc_html__('On Sale', 'electron'),
            'instock'    => $instock_title ? $instock_title : esc_html__('In Stock', 'electron')
        ];

        // icons
        $featured_icon    = electron_settings( 'shop_fast_filter_featured_icon' );
        $bestseller_icon  = electron_settings( 'shop_fast_filter_bestseller_icon' );
        $toprated_icon    = electron_settings( 'shop_fast_filter_toprated_icon' );
        $onsale_icon      = electron_settings( 'shop_fast_filter_onsale_icon' );
        $instock_icon     = electron_settings( 'shop_fast_filter_instock_icon' );

        $featured_icon    = trim($featured_icon) ? $featured_icon : electron_svg_lists( 'featured', 'electron-svg-icon' );
        $bestseller_icon  = trim($bestseller_icon) ? $bestseller_icon :  electron_svg_lists( 'best-seller', 'electron-svg-icon' );
        $toprated_icon    = trim($toprated_icon) ? $toprated_icon : electron_svg_lists( 'top-rated', 'electron-svg-icon' );
        $onsale_icon      = trim($onsale_icon) ? $onsale_icon : electron_svg_lists( 'onsale', 'electron-svg-icon' );
        $instock_icon     = trim($instock_icon) ? $instock_icon : electron_svg_lists( 'instock-2', 'electron-svg-icon' );

        if ( '' === get_option( 'permalink_structure' ) ) {
            $baselink = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $baselink = preg_replace( '%\/page/[0-9]+%', '', home_url( add_query_arg( null, null ) ) );
        }

        $shoplink = wc_get_page_permalink( 'shop' );

        $is_filter = $has_filter ? ' has-filter' : '';

        $html = '';

        if ( '1' == electron_settings( 'shop_fast_filter_before_label_visibility', '1' ) ) {
            $html .= '<span class="fast-filters-label"><strong>'.esc_html( $titles['maintitle'] ).'</strong></span>';
        }

        $html .= '<ul class="electron-fast-filters-list filters-first'.esc_attr( $is_filter ).'">';

            if ( $has_filter ) {
                $html .= '<li class="remove-fast-filter active">';
                    $html .= '<a href="'.esc_url( remove_query_arg( array_keys( $_GET ) ) ).'" rel="nofollow noreferrer" class="electron-fast-filter-link">';
                        $html .= '<span class="remove-filter"></span> '.esc_html( $titles['removeall'] );
                    $html .= '</a>';
                $html .= '</li>';
            }

            if ( !empty( $filter_main['show'] ) ) {
                unset( $filter_main['show']['placebo'] );
                foreach ( $filter_main['show'] as $key => $value ) {
                    switch($key) {
                        case 'featured':
                        if ( isset( $_GET['featured'] ) && $_GET['featured'] == 'yes' ) {
                            $html .= '<li class="active"><a href="'.esc_url( remove_query_arg( 'featured' ) ).'" rel="nofollow noreferrer"><span class="remove-filter"></span>'.$featured_icon.' '.esc_html( $titles['featured'] ).'</a></li>';
                        } else {
                            $html .= '<li><a href="'.esc_url( add_query_arg( 'featured',wc_clean( wp_unslash( 'yes' ) ) ) ).'" rel="nofollow noreferrer">'.$featured_icon.' '.esc_html( $titles['featured'] ).'</a></li>';
                        }
                        break;

                        case 'bestseller':
                        if ( isset( $_GET['best_seller'] ) && $_GET['best_seller'] == 'yes' ) {
                            $html .= '<li class="active"><a href="'.esc_url( remove_query_arg( 'best_seller' ) ).'" rel="nofollow noreferrer"><span class="remove-filter"></span>'.$bestseller_icon.' '.esc_html( $titles['bestseller'] ).'</a></li>';
                        } else {
                            $html .= '<li><a href="'.esc_url( add_query_arg( 'best_seller',wc_clean( wp_unslash( 'yes' ) ) ) ).'" rel="nofollow noreferrer">'.$bestseller_icon.' '.esc_html( $titles['bestseller'] ).'</a></li>';
                        }
                        break;

                        case 'toprated':
                        if ( isset( $_GET['rating_filter'] ) && $_GET['rating_filter'] == '5' ) {
                            $html .= '<li class="active"><a href="'.esc_url( remove_query_arg( 'rating_filter' ) ).'" rel="nofollow noreferrer"><span class="remove-filter"></span>'.$toprated_icon.' '.esc_html( $titles['toprated'] ).'</a></li>';
                        } else {
                            $html .= '<li><a href="'.esc_url( add_query_arg( 'rating_filter', wc_clean( wp_unslash( '5' ) ) ) ).'" rel="nofollow noreferrer">'.$toprated_icon.' '.esc_html( $titles['toprated'] ).'</a></li>';
                        }
                        break;
                    }
                }
            }

            if ( $has_filter || 'show-always' == electron_settings( 'shop_fast_filter_stock_sale_status' ) ) {

                if ( isset( $_GET['on_sale'] ) && $_GET['on_sale'] == 'onsale' ) {
                    $html .= '<li class="on-sale active'.esc_attr( $stock_sale ).'"><a href="'.esc_url( remove_query_arg( 'on_sale' ) ).'"><span class="remove-filter" rel="nofollow noreferrer"></span> '.$onsale_icon.' '.esc_html( $titles['onsale'] ).'</a></li>';
                } else {
                    $html .= '<li class="on-sale'.esc_attr( $stock_sale ).'"><a href="'.esc_url( add_query_arg( 'on_sale', wc_clean( wp_unslash( 'onsale' ) ) ) ).'" rel="nofollow noreferrer">'.$onsale_icon.' '.esc_html( $titles['onsale'] ).'</a></li>';
                }

                if ( isset( $_GET['stock_status'] ) && $_GET['stock_status'] == 'instock' ) {
                    $html .= '<li class="instock active'.esc_attr( $stock_sale ).'"><a href="'.esc_url( remove_query_arg( 'stock_status' ) ).'"><span class="remove-filter" rel="nofollow noreferrer"></span>'.$instock_icon.' '.esc_html( $titles['instock'] ).'</a></li>';
                } else {
                    $html .= '<li class="instock'.esc_attr( $stock_sale ).'"><a href="'.esc_url( add_query_arg( 'stock_status', wc_clean( wp_unslash( 'instock' ) ) ) ).'" rel="nofollow noreferrer">'.$instock_icon.' '.esc_html( $titles['instock'] ).'</a></li>';
                }
            }

            if ( !empty( $terms ) ) {
                foreach ( $terms as $tax ) {
                    $terms_title = electron_settings( 'shop_fast_filter_terms_title_'.$tax );
                    $terms_attr  = electron_settings( 'shop_fast_filter_terms_attr_'.$tax );
                    $terms_icon  = electron_settings( 'shop_fast_filter_terms_icon_'.$tax );
                    $terms_icon  = $terms_icon ? $terms_icon : '';

                    if ( $terms_title ) {
                        $terms_active = $has_filter == true && isset( $_GET['filter_'.$tax] ) ? ' active' : '';
                        $html .= '<li class="electron-has-submenu'. $terms_active .'">';
                        if ( $has_filter && isset( $_GET['filter_'.$tax] ) ) {
                            $html .= '<a href="'.esc_url( remove_query_arg( 'filter_'.$tax ) ).'" rel="nofollow noreferrer"><span class="remove-filter"></span>'.$terms_icon.$terms_title.'</a>';
                        } else {
                            $html .= '<a href="#0" rel="nofollow noreferrer">'.$terms_icon.$terms_title.'</a>';
                        }
                        $html .= '<ul class="electron-fast-filters-submenu attr-type-'.$tax.'">';
                        foreach ( $terms_attr as $term ) {
                            $term_name = get_term_by( 'id', $term, 'pa_'.$tax );
                            $color     = get_term_meta( $term, 'electron_swatches_'.$tax, true ) ? : '';
                            $is_white  = $color == '#fff' || $color == '#FFF' || $color == '#ffffff' || $color == '#FFFFFF' ? ' is_white' : '';
                            $color     = $tax == 'color' && !empty( $color ) ? '<span class="term-color'.$is_white.'" data-color="'.esc_attr( $color ).'"></span>' : '';
                            if ( $has_filter && isset( $_GET['filter_'.$tax] ) && ( $_GET['filter_'.$tax] == $term_name->slug ) ) {
                                $html .= '<li class="active"><a href="'.esc_url( remove_query_arg( 'filter_'.$tax ) ).'" rel="nofollow noreferrer"><span class="remove-filter"></span> '.$term_name->name.$color.'</a></li>';
                            } else {
                                if ( !empty( $term_name->name ) ) {
                                    $html .= '<li><a href="'.esc_url( add_query_arg( 'filter_'.$tax, wc_clean( wp_unslash( $term_name->slug ) ) ) ).'" rel="nofollow noreferrer">'.$term_name->name.$color.'</a></li>';
                                }
                            }
                        }
                        $html .= '</ul>';
                        $html .= '</li>';
                    }
                }
            }

        $html .= '</ul>';

        // Final html
        echo '<div class="electron-shop-fast-filters is-shop'.$is_ajax.$stock_sale.'">'.$html.'</div>';
    }
}

if ( ! function_exists( 'electron_cart_goal_progressbar' ) ) {

    if ( isset( $electron_options['cart_free_shipping_progressbar_visibility'] ) && '1' == $electron_options['cart_free_shipping_progressbar_visibility'] ) {
        add_action( 'electron_before_cart_contents', 'electron_cart_goal_progressbar', 10 );
    }
    if ( isset( $electron_options['minicart_free_shipping_progressbar_visibility'] ) && '1' == $electron_options['minicart_free_shipping_progressbar_visibility'] ) {
        add_action( 'electron_side_panel_after_header', 'electron_cart_goal_progressbar', 10 );
        add_action( 'electron_popup_cart_before_upsell', 'electron_cart_goal_progressbar', 10 );
    }

    function electron_cart_goal_progressbar()
    {
        $amount = round( electron_settings( 'free_shipping_progressbar_amount', 500 ), wc_get_price_decimals() );
        if ( !( $amount > 0 ) || '1' != electron_settings( 'free_shipping_progressbar_visibility', 1 ) ) {
            return;
        }

        $message_initial = electron_settings( 'free_shipping_progressbar_message_initial' );
        $message_success = electron_settings( 'free_shipping_progressbar_message_success' );

        $total     = WC()->cart->get_displayed_subtotal();
        $remainder = ( $amount - $total );
        $success   = $total >= $amount ? ' free-shipping-success shakeY' : '';
        $value     = $total <= $amount ? ( $total / $amount ) * 100 : 100;


        if ( is_cart() ) {
            $success .= ' cart-page-goal';
        } elseif ( is_checkout() ) {
            $success .= ' checkout-page-goal';
        }

        wp_enqueue_style( 'electron-wc-free-shipping-progressbar' );
        ?>
        <div class="electron-cart-goal-wrapper<?php echo esc_attr( $success ); ?>">
            <div class="electron-cart-goal-text">
                <?php
                if ( $total >= $amount ) {
                    if ( $message_success ) {
                        echo sprintf('%s', $message_success );
                    } else {
                        echo sprintf('%s <strong>%s</strong>',
                        esc_html__('Congrats! You are eligible for', 'electron'),
                        esc_html__('more to enjoy FREE Shipping', 'electron'));
                    }
                } else {
                    if ( $message_initial ) {
                        echo sprintf('%s', str_replace( '[remainder]', wc_price( $remainder ), $message_initial ) );
                    } else {
                        echo sprintf('%s %s <strong>%s</strong>',
                        esc_html__('Buy', 'electron'),
                        wc_price( $remainder ),
                        esc_html__('more to enjoy FREE Shipping', 'electron'));
                    }
                }
                ?>
            </div>
            <div class="electron-free-shipping-progress">
                <div class="electron-progress-bar-wrap">
                    <div class="electron-progress-bar" style="width:<?php echo esc_attr( $value ); ?>%;">
                        <div class="electron-progress-value">
                            <?php echo electron_svg_lists( 'delivery-return', 'electron-svg-icon' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
*  countdown for product
*/
if ( ! function_exists( 'electron_product_cart_countdown' ) ) {
    add_action( 'electron_side_panel_after_header', 'electron_product_cart_countdown', 1 );
    function electron_product_cart_countdown()
    {
        if ( '0' != electron_settings('cart_limited_timer_visibility','1') ) {
            wp_enqueue_script( 'electron-sidepanel-timer');
            $time = electron_settings('cart_limited_timer_date');
            $text = electron_settings('cart_limited_timer_message_initial');

            if ( $time ) {

                $data[] = '"min":"'.esc_html__('min', 'electron').'"';
                $data[] = '"sec":"'.esc_html__('sec', 'electron').'"';

                echo '<div class="electron-summary-item electron-viewed-offer-time">';
                    if ( $text ) {
                        echo '<p class="offer-time-text">'.$text.'</p>';
                    }
                    echo '<div class="electron-cart-timer"></div>';
                echo '</div>';
            }
        }
    }
}


if ( ( isset( $electron_options['woo_catalog_mode'] ) && '1' == $electron_options['woo_catalog_mode'] ) && ( isset( $electron_options['woo_disable_cart_checkout'] ) && '1' == $electron_options['woo_disable_cart_checkout'] ) ) {
    add_filter( 'get_pages','electron_hide_cart_checkout_pages' );
    add_filter( 'wp_get_nav_menu_items', 'electron_hide_cart_checkout_pages' );
    add_filter( 'wp_nav_menu_objects', 'electron_hide_cart_checkout_pages' );
    add_action( 'wp', 'electron_check_pages_redirect' );
}

if ( !function_exists( 'electron_hide_cart_checkout_pages' ) ) {
    function electron_hide_cart_checkout_pages( $pages )
    {
        $excluded_pages = array(
            wc_get_page_id( 'cart' ),
            wc_get_page_id( 'checkout' )
        );

        foreach ( $pages as $key => $page ) {

            if ( in_array( current_filter(), array( 'wp_get_nav_menu_items', 'wp_nav_menu_objects' ), true ) ) {
                $page_id = $page->object_id;
                if ( 'page' !== $page->obect_id ) {
                    continue;
                }
            } else {
                $page_id = $page->ID;
            }

            if ( in_array( (int) $page_id, $excluded_pages, true ) ) {
                unset( $pages[ $key ] );
            }
        }

        return $pages;
    }
}

if ( !function_exists( 'electron_check_pages_redirect' ) ) {
    function electron_check_pages_redirect()
    {
        $cart     = is_page( wc_get_page_id( 'cart' ) );
        $checkout = is_page( wc_get_page_id( 'checkout' ) );

        wp_reset_postdata();

        if ( $cart || $checkout ) {
            wp_safe_redirect( home_url() );
            exit;
        }
    }
}



/**
* Shop page custom query
*/

if ( ! function_exists( 'electron_shop_custom_query' ) && isset( $electron_options['shop_custom_query_visibility'] ) && 'yes' == $electron_options['shop_custom_query_visibility'] ) {

    add_action( 'woocommerce_product_query', 'electron_shop_custom_query' );
    function electron_shop_custom_query( $q )
    {
        if ( '1' == electron_settings( 'shop_fast_filter_visibility', '0' ) ) {
            if ( isset( $_GET['featured'] ) && $_GET['featured'] == 'yes' ) {
                $q->set( 'tax_query', array (
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => array( 'featured' ),
                        'operator' => 'IN'
                    )
                ));
            }

            if ( isset( $_GET['best_seller'] ) && $_GET['best_seller'] == 'yes' ) {
                $q->set ( 'meta_key', 'total_sales' );
                $q->set ( 'orderby', 'meta_value_num' );
            }
        }

        if ( is_shop() ) {

            $tax_query        = $q->get( 'tax_query' );
            $meta_query       = $q->get( 'meta_query' );
            $scenario         = electron_settings( 'shop_custom_query_scenario' );
            $cats             = electron_settings( 'shop_custom_query_cats', null );
            $tags             = electron_settings( 'shop_custom_query_tags', null );
            $attrs            = electron_settings( 'shop_custom_query_attr', null );
            $order            = electron_settings( 'shop_custom_query_order' );
            $orderby          = electron_settings( 'shop_custom_query_orderby' );
            $cats_operator    = 'include' == electron_settings( 'shop_custom_query_cats_operator' ) ? 'IN' : 'NOT IN';
            $tags_operator    = 'include' == electron_settings( 'shop_custom_query_tags_operator' ) ? 'IN' : 'NOT IN';
            $perpage          = wp_is_mobile() ? electron_settings( 'shop_custom_query_mobile_perpage' ) : electron_settings( 'shop_custom_query_perpage' );
            $per_page         = isset( $_GET['per_page'] ) && $_GET['per_page'] ? esc_html( $_GET['per_page'] ) : $perpage;

            $q->set( 'order', $order );
            $q->set( 'posts_per_page', $per_page );

            $args['tax_query'] = array(
                'relation' => 'AND'
            );

            if ( 'featured' == $scenario ) {

                $tax_query[] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN'
                );

            } elseif ( 'on-sale' == $scenario ) {

                $meta_query[] = array(
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

                $q->set( 'orderby', 'meta_value_num' );
                $q->set( 'meta_key', 'total_sales' );

            } elseif ( 'rated' == $scenario ) {

                $q->set( 'meta_key', '_wc_average_rating' );
                $q->set( 'order', 'DESC' );
                $q->set( 'orderby', 'meta_value_num' );

            } elseif ( 'popularity' == $scenario ) {

                $q->set( 'meta_key', 'total_sales' );
                $q->set( 'order', 'DESC' );
                $q->set( 'orderby', 'meta_value_num' );

            } else {

                $q->set( 'orderby', $orderby );

            }

            // Kategorileri WPML ile çevir
            if ( !empty( $cats ) ) {
                $translated_cats = array();
                foreach ( $cats as $cat ) {
                    $translated_cats[] = apply_filters( 'wpml_object_id', $cat, 'product_cat', true );
                }
                $tax_query[] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $translated_cats,
                    'operator' => $cats_operator
                );
            }

            // Etiketleri WPML ile çevir
            if ( !empty( $tags ) ) {
                $translated_tags = array();
                foreach ( $tags as $tag ) {
                    $translated_tags[] = apply_filters( 'wpml_object_id', $tag, 'product_tag', true );
                }
                $tax_query[] = array(
                    'taxonomy' => 'product_tag',
                    'field'    => 'term_id',
                    'terms'    => $translated_tags,
                    'operator' => $tags_operator
                );
            }

            // Öznitelik filtrelerini WPML ile çevir
            if ( !empty( $attrs ) ) {
                foreach ( $attrs as $key ) {
                    $attr_terms      = electron_settings( 'shop_custom_query_attr_terms_'.$key );
                    $terms_operator  = 'include' == electron_settings( 'shop_custom_query_attr_terms_operator_'.$key ) ? 'IN' : 'NOT IN';
                    $attr_id         = wc_attribute_taxonomy_id_by_name( $key );
                    $attr_info       = wc_get_attribute( $attr_id );

                    if ( !empty( $attr_terms ) ) {
                        $translated_terms = array();
                        foreach ( $attr_terms as $term ) {
                            $translated_terms[] = apply_filters( 'wpml_object_id', $term, $attr_info->slug, true );
                        }
                        $tax_query[] = array(
                            'taxonomy' => $attr_info->slug,
                            'field'    => 'term_id',
                            'terms'    => $translated_terms,
                            'operator' => $terms_operator
                        );
                    }
                }
            }

            $q->set( 'meta_query', $meta_query );
            $q->set( 'tax_query', $tax_query );
            $q->set( 'suppress_filters', false ); // WPML filtrelerini etkinleştir
        }
    }
}

/*************************************************
## Recently Viewed Products Always
*************************************************/
if ( ! function_exists( 'electron_track_product_view' ) ) {
    remove_action( 'template_redirect', 'wc_track_product_view', 20 );
    add_action( 'template_redirect', 'electron_track_product_view', 20 );
    function electron_track_product_view() {
        if ( '1' != electron_settings( 'shop_recently_visibility', 1 ) ) {
            return;
        }

        $pages = electron_settings( 'recently_include', null );
        $check_pages = false;

        if ( is_product() && isset($pages['product']) && $pages['product'] == '1' ) {
            $check_pages = true;
        } elseif ( is_woocommerce() && !is_product() && isset($pages['shop']) && $pages['shop'] == '1' ) {
            $check_pages = true;
        } elseif ( is_front_page() && !is_home() && isset($pages['home']) && $pages['home'] == '1' ) {
            $check_pages = true;
        } elseif ( is_singular('page') && isset($pages['page']) && $pages['page'] == '1' ) {
            $check_pages = true;
        }

        if ( $check_pages == false ) {
            return;
        }

        global $post;

        if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
            $viewed_products = array();
        } else {
            $viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) );
        }

        // Unset if already in viewed products list.
        $keys = array_flip( $viewed_products );

        if ( isset( $keys[ $post->ID ] ) ) {
            unset( $viewed_products[ $keys[ $post->ID ] ] );
        }

        $viewed_products[] = $post->ID;

        if ( count( $viewed_products ) > 15 ) {
            array_shift( $viewed_products );
        }

        // Store for session only.
        wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
    }
}

/*************************************************
## Recently Viewed Products Loop
*************************************************/
if ( ! function_exists( 'electron_recently_viewed_product_loop' ) ) {
    add_action('electron_after_main_content','electron_recently_viewed_product_loop');
    function electron_recently_viewed_product_loop()
    {
        if ( '1' != electron_settings( 'shop_recently_visibility', 1 ) ) {
            return;
        }

        $pages = electron_settings( 'recently_include', null );
        $check_pages = false;

        if ( is_product() && isset($pages['product']) && $pages['product'] == '1' ) {
            $check_pages = true;
        } elseif ( is_woocommerce() && !is_product() && isset($pages['shop']) && $pages['shop'] == '1' ) {
            $check_pages = true;
        } elseif ( is_front_page() && !is_home() && isset($pages['home']) && $pages['home'] == '1' ) {
            $check_pages = true;
        } elseif ( is_singular('page') && isset($pages['page']) && $pages['page'] == '1' ) {
            $check_pages = true;
        }

        if ( $check_pages == false ) {
            return;
        }

        $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
        $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

        if ( empty( $viewed_products) ) {
            return;
        }

        $perpage = electron_settings('recently_perpage', 8);
        $heading = electron_settings('shop_recently_title', '');
        $heading = $heading ? esc_html( $heading ) : esc_html__( 'Recently Viewed Products', 'electron' );

        $slider_options = json_encode(array(
            "loop"          => '1' == electron_settings( 'shop_recently_loop', '0' ) ? true : false,
            "speed"         => intval(electron_settings( 'shop_recently_speed', 800 )),
            "spaceBetween"  => intval(electron_settings( 'shop_recently_gap', 20 )),
            "slidesPerView" => 1,
            "grabCursor"    => true,
            "autoHeight"    => false,
            "watchSlidesProgress" => true,
            "autoplay"      => '1' == electron_settings( 'shop_recently_autoplay', 1 ) ? ["pauseOnMouseEnter" => true,"disableOnInteraction" => false] : false,
            "navigation"    => [
                "nextEl" => ".electron-product-recently .electron-swiper-next",
                "prevEl" => ".electron-product-recently .electron-swiper-prev"
            ],
            "breakpoints"   => [
                "0" => [
                    "slidesPerView" => intval(electron_settings( 'shop_recently_smperview', 2 ))
                ],
                "768" => [
                    "slidesPerView" => intval(electron_settings( 'shop_recently_mdperview', 3 ))
                ],
                "1024" => [
                    "slidesPerView" => intval(electron_settings( 'shop_recently_perview', 6 ))
                ]
            ]
        ));

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $perpage,
            'post__in'       => $viewed_products,
            'orderby'        => 'post__in',
            'post_status'    => 'publish'
        );

        $loop = new WP_Query( $args );

        if ( $loop ) {
            wp_enqueue_style( 'electron-swiper' );
            wp_enqueue_script( 'electron-swiper' );
            ?>
            <div class="electron-product-recently electron-recently-product-wrapper mb-40">
                <div class="container">
                    <div class="row">
                        <div class="col-12">

                            <div class="section-title-wrapper">
                                <?php if ( $heading ) : ?>
                                    <h5 class="section-title mar-0"><?php echo esc_html( $heading ); ?></h5>
                                <?php endif; ?>
                                <div class="recently-slider-nav">
                                    <div class="electron-slide-nav electron-swiper-prev"></div>
                                    <div class="electron-slide-nav electron-swiper-next"></div>
                                </div>
                            </div>

                            <div class="electron-wc-swipper-wrapper woocommerce">
                                <div class="electron-swiper-slider electron-swiper-container" data-swiper-options="<?php echo esc_attr( $slider_options ); ?>">
                                    <div class="swiper-wrapper">
                                        <?php
                                            if ( $loop->have_posts() ) {
                                                while ( $loop->have_posts() ) {
                                                    $loop->the_post();
                                                    echo '<div class="swiper-slide">';
                                                        wc_get_template_part( 'content', 'product' );
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo esc_html__( 'No products found', 'electron');
                                            }
                                            wp_reset_postdata();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

/*************************************************
## Shop notices
*************************************************/
if ( !function_exists( 'electron_shop_loop_notices' ) ) {
    add_action('electron_before_wp_footer','electron_shop_loop_notices', 15 );
    function electron_shop_loop_notices()
    {
        if ( is_checkout() || '0' == electron_settings( 'shop_notices_visibility', '1' ) ) {
            return;
        }
        wp_enqueue_style( 'electron-wc-popup-notices' );
        ?>
        <div class="electron-shop-popup-notices postion-<?php echo electron_settings( 'shop_cart_popup_notices_position', 'bottom-right' );?>"></div>
        <?php
    }
}

/*************************************************
## minicart
*************************************************/
if ( ! function_exists( 'electron_side_panel_cart_content' ) ) {
    add_action( 'electron_before_wp_footer', 'electron_side_panel_cart_content' );
    function electron_side_panel_cart_content()
    {
        $minicart = electron_settings('minicart_visibility', '1' );
        $catalog  = electron_settings( 'woo_catalog_mode', '0' );
        $action   = electron_settings( 'minicart_type', 'icon' );
        $action2  = electron_header_settings( 'header_cart_action_type', 'popup' );

        if ( '1' == $minicart && ( 'panel' == $action || ( 'default' != $action2 && 'link' != $action2 ) ) && '1' != $catalog ) {
            wp_enqueue_script( 'electron-quantity-button' );
            $count = WC()->cart->get_cart_contents_count();

            ?>
            <div class="electron-side-panel <?php echo esc_attr( $action ); ?>" data-cart-count="<?php echo esc_attr( $count ); ?>">
                <div class="panel-header">
                    <div class="panel-close" data-target=".electron-side-panel"></div>
                    <div class="panel-header-title"><?php echo esc_html_e( 'Shopping Cart', 'electron' ); ?></div>
                </div>

                <?php do_action( 'electron_side_panel_after_header' ); ?>

                <div class="panel-content">
                    <div class="cart-area panel-content-item">
                        <div class="cart-content">
                            <?php get_template_part('woocommerce/minicart/minicart'); ?>
                        </div>
                    </div>
                    <?php do_action( 'electron_side_panel_content_after_cart' ); ?>
                </div>
            </div>
            <?php
        }
    }
}


if ( !function_exists( 'electron_fly_cart' ) ) {
    add_action( 'electron_before_wp_footer', 'electron_fly_cart' );
    function electron_fly_cart()
    {
        if ( '1' == electron_settings( 'shop_fly_cart_visibility', '0' ) ) {
            $count = esc_html( WC()->cart->get_cart_contents_count() );
            if ( 'page' == electron_settings( 'shop_fly_cart_action_type', 'panel' ) ) {
                ?>
                <div id="electron-sticky-cart-toggle" class="electron-sticky-cart-toggle has-page-link" data-duration="<?php echo electron_settings( 'shop_fly_cart_duration', 1500 ); ?>">
                    <a class="electron-view-cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                        <span class="electron-cart-count electron-wc-count"><?php echo esc_html( $count ); ?></span>
                        <?php echo electron_svg_lists( 'bag', 'electron-svg-icon' ); ?>
                    </a>
                </div>
                <?php
            } else {
                ?>
                <div id="electron-sticky-cart-toggle" class="electron-sticky-cart-toggle" data-duration="<?php echo electron_settings( 'shop_fly_cart_duration', 1500 ); ?>">
                    <span class="electron-cart-count electron-wc-count"><?php echo esc_html( $count ); ?></span>
                    <?php echo electron_svg_lists( 'bag', 'electron-svg-icon' ); ?>
                </div>
                <?php
            }
        }
    }
}


if ( !function_exists( 'electron_bottom_mobile_menu' ) ) {
    add_action( 'electron_before_wp_footer', 'electron_bottom_mobile_menu' );
    function electron_bottom_mobile_menu() {
        if ( !wp_is_mobile() || '0' == electron_header_settings( 'bottom_mobile_nav_visibility', '1' ) ) {
            return;
        }
        $menu_type    = electron_header_settings( 'bottom_mobile_menu_type' );
        $display_type = electron_header_settings( 'bottom_mobile_menu_display_type' );
        wp_enqueue_style( 'electron-bottom-mobile-menu');
        ?>
        <nav class="electron-bottom-mobile-nav <?php echo esc_attr( $display_type ); ?>">
            <?php
            if ( 'wp-menu' == $menu_type && has_nav_menu( 'mobile_bottom_menu' ) ) {

                echo '<div class="electron-mobile-nav-wrapper">';
                    echo '<ul>';
                        echo wp_nav_menu(
                            array(
                                'menu' => '',
                                'theme_location' => 'mobile_bottom_menu',
                                'container' => '',
                                'container_class' => '',
                                'container_id' => '',
                                'menu_class' => '',
                                'menu_id' => '',
                                'items_wrap' => '%3$s',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'depth' => 1,
                                'echo' => true,
                                'fallback_cb' => 'Electron_Wp_Bootstrap_Navwalker::fallback',
                                'walker' => new Electron_Wp_Bootstrap_Navwalker()
                            )
                        );
                    echo '</ul>';
                echo '</div>';

            } else {

                $layouts   = electron_header_settings( 'mobile_bottom_menu_layouts' );
                $arrow     = is_rtl() ? 'arrow-right' : 'arrow-left';
                $customize = electron_header_settings( 'bottom_mobile_nav_item_customize' );
                $is_woo    = class_exists('WooCommerce') ? true : false;

                if ( !empty( $layouts['show'] ) ) {
                    unset( $layouts['show']['placebo'] );
                    echo '<div class="mobile-nav-wrapper">';
                        echo '<ul>';
                        foreach ( $layouts['show'] as $key => $value ) {

                            switch ( $key ) {
                                case 'home':
                                    if ( '1' == $customize && '' != electron_header_settings( 'mobile_bottom_menu_custom_home_html' ) ) {
                                        echo electron_header_settings( 'mobile_bottom_menu_custom_home_html' );
                                    } else {
                                        echo '<li class="menu-item">';
                                            echo '<a href="'.esc_url( home_url( '/' ) ).'" class="home-page-link">';
                                                echo electron_svg_lists( $arrow, 'electron-svg-icon' );
                                                echo '<span>'.esc_html__( 'Home', 'electron' ).'</span>';
                                            echo '</a>';
                                        echo '</li>';
                                    }
                                break;

                                case 'shop':
                                    if ( '1' == $customize && '' != electron_header_settings( 'mobile_bottom_menu_custom_shop_html' ) ) {
                                        echo electron_header_settings( 'mobile_bottom_menu_custom_shop_html' );
                                    } else {
                                        if ( $is_woo ) {
                                            echo '<li class="menu-item">';
                                                echo '<a href="'.esc_url( wc_get_page_permalink( 'shop' ) ).'" class="shop-page-link">';
                                                    echo electron_svg_lists( 'store', 'electron-svg-icon' );
                                                    echo '<span>'.esc_html__( 'Store', 'electron' ).'</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    }
                                break;

                                case 'cart':
                                    if ( '1' == $customize && '' != electron_header_settings( 'mobile_bottom_menu_custom_cart_html' ) ) {
                                        echo electron_header_settings( 'mobile_bottom_menu_custom_cart_html' );
                                    } else {
                                        if ( $is_woo ) {
                                            $cart_link  = esc_url( wc_get_page_permalink( 'cart' ) );
                                            echo '<li class="menu-item">';
                                                echo '<a href="'.$cart_link.'" class="cart-page-link">';
                                                    echo electron_svg_lists( 'bag', 'electron-svg-icon' );
                                                    echo '<span class="electron-cart-count electron-wc-count">'.WC()->cart->get_cart_contents_count().'</span>';
                                                    echo '<span>'.esc_html__( 'Cart', 'electron' ).'</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    }
                                break;

                                case 'account':
                                    if ( '1' == $customize && '' != electron_header_settings( 'mobile_bottom_menu_custom_account_html' ) ) {
                                        echo electron_header_settings( 'mobile_bottom_menu_custom_account_html' );
                                    } else {
                                        if ( $is_woo ) {
                                            echo '<li class="menu-item">';
                                                echo '<a href="'.esc_url( wc_get_page_permalink( 'myaccount' ) ).'" class="acoount-page-link">';
                                                    echo electron_svg_lists( 'user-1', 'electron-svg-icon' );
                                                    echo '<span>'.esc_html__( 'Account', 'electron' ).'</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    }
                                break;

                                case 'search':
                                    if ( '1' == $customize && '' != electron_header_settings( 'mobile_bottom_menu_custom_search_html' ) ) {
                                        echo electron_header_settings( 'mobile_bottom_menu_custom_search_html' );
                                    } else {
                                        if ( '1' == electron_header_settings( 'popup_search_visibility' ) ) {
                                            echo '<li class="menu-item">';
                                                echo '<a href="#0" data-target=".electron-popup-search" class="panel-open">';
                                                    echo electron_svg_lists( 'search', 'electron-svg-icon' );
                                                    echo '<span>'.esc_html__( 'Search', 'electron' ).'</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    }
                                break;
                            }
                        }
                        echo '</ul>';
                    echo '</div>';
                }
            }
            ?>
        </nav>
        <?php
    }
}

if ( !function_exists( 'electron_popup_minicart_cart' ) ) {
    add_action( 'electron_before_wp_footer', 'electron_popup_minicart_cart' );
    function electron_popup_minicart_cart()
    {
        if ( '1' == electron_settings( 'minicart_visibility', '1' ) && 'popup' == electron_settings( 'minicart_type', '1' ) ) {
            $total = '<span class="electron-cart-count"></span>';
            $style = electron_settings( 'minicart_popup_style', 'style1' );
            wp_enqueue_style( 'product-box-style1' );
            ?>
            <div class="electron-popup-cart cart-area <?php esc_attr( $style ); ?>">
                <div class="popup-overlay" data-target=".electron-popup-cart"></div>
                <div class="popup-cart-inner">
					<span class="panel-close" data-target=".electron-popup-cart"></span>
					<div class="popup-cart-content electron-scrollbar">
						<div class="popup-cart-top">
							<div class="popup-cart-col cart-item-wrapper">
								<h6 class="cart-text"><?php esc_html_e('Successfully added to your cart.', 'electron'); ?></h6>
								<div class="cart-item woocommerce-mini-cart-item" data-pid=""></div>
							</div>
							<div class="popup-cart-col cart-item-total">
								<h6 class="total-text"><?php echo sprintf(esc_html__('There are %s items in your cart.', 'electron'), $total); ?></h6>
								<div class="cart-footer"></div>
								<?php do_action( 'electron_popup_cart_before_upsell' ); ?>
							</div>
						</div>
						<div class="cart-upsell"></div>
					</div>
                </div>
            </div>
            <?php
        }
    }
}


if ( !function_exists( 'electron_popup_cart_upsells_init' ) ) {
    if ( isset( $electron_options['popupcart_upsells_visibility'] ) && '1' == $electron_options['popupcart_upsells_visibility'] ) {
        add_action('wp_ajax_cart_upsells_init', 'electron_popup_cart_upsells_init');
        add_action('wp_ajax_nopriv_cart_upsells_init', 'electron_popup_cart_upsells_init');
        function electron_popup_cart_upsells_init($pid) {
            $p_id     = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
            $productt = wc_get_product( $p_id );
            $upsells  = $productt->get_upsell_ids();

            if ($p_id > 0 && !empty($upsells) && is_array($upsells) ) {

                $ptype     = electron_settings( 'shop_product_type', '1' );
                $heading   = electron_settings( 'shop_upsells_title', '' );
                $heading   = $heading ? esc_html( $heading ) : apply_filters( 'woocommerce_product_upsells_products_heading', esc_html__( 'You may also like', 'electron' ) );
                $tag       = electron_settings( 'shop_upsells_title_tag', 'h4' );
                $perview   = electron_settings( 'shop_upsells_perview', 4 );
                $mdperview = electron_settings( 'shop_upsells_mdperview', 3 );
                $smperview = electron_settings( 'shop_upsells_smperview', 2 );
                $sattr     = array();
                $sattr[]  .= '"speed":'.electron_settings( 'shop_upsells_speed', 1000 );
                $sattr[]  .= '"slidesPerView":1,"slidesPerGroup":1';
                $sattr[]  .= '"spaceBetween":'.electron_settings( 'shop_upsells_gap', 30 );
                $sattr[]  .= '"wrapperClass": "electron-swiper-wrapper"';
                $sattr[]  .= '"autoHeight": true';
                $sattr[]  .= '"loop":false';
                $sattr[]  .= '1' == electron_settings( 'shop_upsells_autoplay', 1 ) ? '"autoplay":{"pauseOnMouseEnter":true,"disableOnInteraction":false}' : '"autoplay":false';
                $sattr[]  .= '1' == electron_settings( 'shop_upsells_mousewheel', 0 ) ? '"mousewheel":true' : '"mousewheel":false';
                $sattr[]  .= '1' == electron_settings( 'shop_upsells_freemode', 1 ) ? '  "freeMode":true' : '"freeMode":false';
                $sattr[]  .= '"navigation": {"nextEl": ".upsells-slider-nav .electron-swiper-next","prevEl": ".upsells-slider-nav .electron-swiper-prev"}';
                $sattr[]  .= '"breakpoints": {"0": {"slidesPerView": '.$smperview.',"slidesPerGroup":'.$smperview.'},"768": {"slidesPerView": '.$mdperview.',"slidesPerGroup":'.$mdperview.'},"1024": {"slidesPerView": '.$perview.',"slidesPerGroup":'.$perview.'}}';

                ?>
                <div class="up-sells upsells electron-section">
                    <div class="section-title-wrapper">
                            <h6 class="section-title"><?php echo esc_html( $heading ); ?></h6>
                        <div class="upsells-slider-nav">
                            <div class="electron-slide-nav electron-swiper-prev"></div>
                            <div class="electron-slide-nav electron-swiper-next"></div>
                        </div>
                    </div>
                    <div class="electron-wc-swipper-wrapper woocommerce">
                        <div class="electron-swiper-slider electron-swiper-container" data-swiper-options='{<?php echo implode( ',',$sattr ); ?>}'>
                            <div class="electron-swiper-wrapper">
                                <?php
                                foreach ( $upsells as $upsell => $id )  {
                                    $product = wc_get_product( $id );
                                    if ( $product ) {
                                        $post_object = get_post( $id );
                                        setup_postdata( $GLOBALS['post'] =& $post_object );
                                        echo '<div class="swiper-slide">';
                                            wc_get_template_part( 'product-type/type', 'upsell' );
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
            wp_die();
        }
    }
}

if ( ! function_exists( 'electron_loop_product_cart_quantity' ) ) {
    function electron_loop_product_cart_quantity($type)
    {
        global $product;
        $cart_text = $product->single_add_to_cart_text();
        $pid       = $product->get_id();
        $purl      = $product->add_to_cart_url();
        $plink     = apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() );
        $qty_type  = electron_settings( 'shop_product_qty_type' );
        $class     = 'type-'.$type;
        $class    .= 'small' == $qty_type ? ' no-trans' : '';
        $icon      = '<svg class="shopBag electron-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 32 32"><use href="#shopBag"></use></svg>';

        if ( $type == 'variable' ) {

            // Get Available variations?
            $get_variations       = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
            $available_variations = $get_variations ? $product->get_available_variations() : false;
            $attributes           = $product->get_variation_attributes();
            $selected_attributes  = $product->get_default_attributes();

            $attribute_keys  = array_keys( $attributes );
            $variations_json = wp_json_encode( $available_variations );
            $variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

            ?>
            <form class="variations_form cart loop-cart <?php echo esc_attr( $class ); ?>" action="<?php echo esc_url( $plink); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $pid ); ?>" data-product_variations="<?php echo esc_attr( $variations_attr ); ?>">

                <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
                    <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'electron' ) ) ); ?></p>
                <?php else : ?>
                    <div class="electron-variations variations">
                        <div class="woocommerce-variation single_variation"></div>
                        <?php foreach ( $attributes as $attribute_name => $options ) :
                            $id   = wc_attribute_taxonomy_id_by_name( $attribute_name );
                            $attr = wc_get_attribute( $id );
                            $type = !empty( $attr->type ) ? $attr->type : 'select';
                            ?>
                            <div class="electron-variations-items variations-items electron-variations-type-<?php echo esc_attr( $type ); ?>">
                                <div class="value">
                                    <?php
                                    wc_dropdown_variation_attribute_options(
                                        array(
                                            'options'   => $options,
                                            'attribute' => $attribute_name,
                                            'product'   => $product,
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                            <?php echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="electron-btn-reset reset_variations" href="#">'.esc_html__( 'Clear', 'electron' ).'</a>' ) : ''; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="woocommerce-variation-add-to-cart variations_button">

                        <?php
                        woocommerce_quantity_input(
                            array(
                                'min_value' => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
                            )
                        );
                        ?>
                        <button type="submit"class="single_add_to_cart_button electron-btn electron-btn-primary electron-product-cart has-icon electron-spinner">
                            <span class="cart-text"><?php echo esc_html( $cart_text ); ?></span>
                            <?php printf('%s', $icon ); ?>
                        </button>

                        <input type="hidden" name="add-to-cart" value="<?php echo absint( $pid ); ?>" />
                        <input type="hidden" name="product_id" value="<?php echo absint( $pid ); ?>" />
                        <input type="hidden" name="variation_id" class="variation_id" value="0" />
                    </div>
                <?php endif; ?>
            </form>
            <?php

        } elseif ( $type == 'simple' ) {

            ?>
            <form class="cart loop-cart <?php echo esc_attr( $class ); ?>" action="<?php echo esc_url( $plink ); ?>" method="post" enctype='multipart/form-data'>
                <?php
                woocommerce_quantity_input(
                    array(
                        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
                    )
                );
                ?>
                <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $pid ); ?>" class="single_add_to_cart_button electron-btn electron-btn-primary electron-product-cart has-icon electron-spinner"><span class="cart-text"><?php echo esc_html( $cart_text ); ?></span><?php printf('%s', $icon ); ?></button>
            </form>
            <?php

        } elseif ( $type == 'external' ) {

            if ( ! $purl ) {
                return;
            }
            ?>
            <form class="cart loop-cart <?php echo esc_attr( $class ); ?>" action="<?php echo esc_url( $purl ); ?>" method="get">
                <button type="submit" class="single_add_to_cart_button electron-btn electron-btn-medium electron-btn-primary electron-btn-border">
                    <span class="button-title"><?php echo esc_html( $cart_text ); ?></span>
                </button>
                <?php wc_query_string_form_fields( $purl ); ?>
            </form>
            <?php

        } elseif ( $type == 'grouped' ) {

             ?>
            <form class="cart grouped_form loop-cart <?php echo esc_attr( $class ); ?>" action="<?php echo esc_url( $purl ); ?>" method="post" enctype='multipart/form-data'>
                 <button type="submit" class="single_add_to_cart_button electron-btn electron-btn-primary electron-product-cart has-icon electron-spinner">
                 <span class="cart-text"><?php echo esc_html( $cart_text ); ?></span>
                 <?php printf('%s', $icon ); ?>
                 </button>
             </form>
            <?php
        }
    }
}
