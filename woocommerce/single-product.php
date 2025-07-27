<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

get_header();

do_action( "electron_before_wc_single" );

// Elementor `single` location

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

    $layout = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'single_shop_layout', 'full-width' );

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

    wp_enqueue_style( 'electron-wc-product-page' );
    wp_enqueue_script( 'electron-product-page' );

    if ( 'left-sidebar' == $layout || 'right-sidebar' == $layout ) {
        $class  = ( $layout == 'left-sidebar' || $layout == 'right-sidebar' ) && is_active_sidebar( 'shop-page-sidebar' ) ? 'has-sidebar '.$layout : '';
        $class .= '1' == electron_settings('product_sticky_sidebar', '1' ) ? ' sticky-sidebar' : '';
        echo '<div id="nt-woo-single" class="nt-woo-single '.$class.'">';
            wp_enqueue_style( 'electron-wc-sidebar' );
            wc_get_template_part( 'content', 'single-sidebar' );
        echo '</div>';

    } else {

        ?>
        <!-- WooCommerce product page container -->
        <div id="nt-woo-single" class="nt-woo-single full-width">
            <div class="nt-electron-inner-container section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            while ( have_posts() ) {
                                the_post();
                                wc_get_template_part( 'content', 'single-product' );
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

do_action( "electron_after_wc_single" );

get_footer();

?>
