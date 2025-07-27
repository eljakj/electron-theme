<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

// Elementor `archive` location
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'archive' ) ) {
    get_header();
}

// Elementor `archive` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
    $mode       = woocommerce_get_loop_display_mode();
    $pagination = isset($_GET['pagination']) ? esc_html($_GET['pagination']) : electron_settings('shop_paginate_type');
    $layout     = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'shop_layout', 'left-sidebar' );
    $is_tax     = isset( get_queried_object()->term_id ) ? get_queried_object()->term_id : '';
    $container  = electron_settings( 'shop_container', 'default' );
    $col        = electron_settings('shop_col');
    $loop       = woocommerce_product_loop();
    $total      = wc_get_loop_prop( 'total' );
    $column     = isset($_GET['column']) ? ' column-'.esc_html($_GET['column']) : ' column-'.$col;
    $class      = 'default' == $container ? 'shop-container container' : 'shop-container container-fluid';
    $class     .= '1' == apply_filters('electron_shop_product_border', electron_settings('shop_product_border') ) ? ' shop-style-bordered' : '';
    $class     .= ( $layout == 'left-sidebar' || $layout == 'right-sidebar' ) && is_active_sidebar( 'shop-page-sidebar' ) ? ' has-sidebar' : '';
    $class     .= ' '.$layout;
    $class     .= '1' == electron_settings( 'woo_catalog_mode', '0' ) ? ' shop-catalog-mode' : '';
    $class     .= $mode == 'subcategories' || $mode == 'both' ? ' shop-mode-cats display_mode-'.$mode : '';
    $class     .= $is_tax ? ' is_tax-archive' : '';
    $class     .= $total ? ' total-'.$total : '';
    $class     .= $loop ? '' : ' not-product-found';

    wp_enqueue_script( 'jquery-nice-select');

    if ( is_shop() || is_product_category() || is_product_tag() || is_tax( 'electron_product_brands' ) ) {

        if ( '1' == electron_settings('shop_ajax_filter', '1' ) ) {
            wp_enqueue_script( 'pjax' );
            wp_enqueue_script( 'shopAjaxFilter' );
        }
    }

    if ( $pagination == 'infinite' ) {
        wp_enqueue_script( 'electron-infinite-scroll' );
    }

    if ( $pagination == 'loadmore' ) {
        wp_enqueue_script( 'electron-load-more' );
    }

    if ( $mode == 'subcategories' && !$is_tax ) {
        remove_action( 'electron_shop_before_loop', 'electron_shop_top_fast_filters', 12 );
        remove_action( 'electron_shop_before_loop', 'shop_loop_filters_layouts', 15 );
        remove_action( 'electron_shop_before_loop', 'electron_shop_choosen_filters_row', 20 );
    }

    if ( !electron_is_pjax() ) {
        get_header();
    }

    ?>
    <div id="nt-shop-page" class="nt-shop-page nt-inner-page-wrapper">
        <?php
        /**
        * Hook: electron_before_shop_content.
        *
        * @hooked electron_wc_hero_section - 10
        * @hooked electron_before_shop_elementor_templates - 15
        */
        do_action( 'electron_before_shop_content' );
        ?>
        <div class="shop-area section-padding <?php echo esc_attr( $class ); ?>">
            <?php
            /**
            * Hook: electron_shop_sidebar.
            *
            * @hooked electron_shop_sidebar - 10
            */
            do_action( 'electron_shop_sidebar' );
            ?>

            <div class="electron-products-column">
                <?php
                /**
                * Hook: electron_shop_before_loop.
                *
                * @hooked electron_print_category_banner - 10
                * @hooked shop_loop_categories - 11
                * @hooked electron_shop_top_fast_filters - 12
                * @hooked shop_loop_filters_layouts - 15
                * @hooked electron_shop_choosen_filters_row - 20
                * @hooked electron_shop_top_hidden_sidebar - 20
                */
                do_action( 'electron_shop_before_loop' );

                /**
                * Hook: electron_shop_main_loop.
                *
                * @hooked electron_shop_main_loop - 10
                */
                do_action( 'electron_shop_main_loop' );

                /**
                * Hook: electron_after_shop_loop.
                *
                * @hooked electron_after_shop_loop_elementor_templates - 10
                */
                do_action( 'electron_after_shop_loop' );
                ?>
            </div>
        </div>
    </div>
    <?php

    /**
    * Hook: electron_after_shop_page.
    *
    * @hooked electron_after_shop_page_elementor_templates - 10
    * @hooked electron_shop_sidebar_fixed - 20
    */
    do_action('electron_after_shop_page');

    if ( !electron_is_pjax() ) {
        get_footer();
    }
}
// Elementor `archive` location
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'archive' ) ) {
    get_footer();
}
?>
