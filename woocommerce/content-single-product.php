<?php
/**
* The template for displaying product content in the single-product.php template
*
* This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see     https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 3.6.0
*/

defined( 'ABSPATH' ) || exit;

global $product;

remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
/**
* Hook: woocommerce_before_single_product.
*
* @hooked woocommerce_output_all_notices - 10
*/

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

$gallery     = isset($_GET['gallery']) ? esc_html($_GET['gallery']) : electron_settings( 'product_thumbs_layout', 'slider' );
$gallery_col = electron_settings( 'product_thumbs_column_width', 7 );
$bread       = electron_settings( 'product_bread_visibility', '1' );
$bread_pos   = electron_settings( 'product_bread_position', 'default' );
$summary_col = $gallery_col >= '9' ? 12 : 12 - $gallery_col;

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'electron-single-product-type-1', $product ); ?>>

    <div class="row electron-row-summary">

        <?php if ( '0' != $bread && 'before' == $bread_pos ) { ?>
            <div class="col-12 electron-product-top-nav position-top">
                <?php echo electron_breadcrumbs(); ?>
            </div>
        <?php } ?>

        <div class="col-12 col-lg-<?php echo esc_attr( $gallery_col ); ?> electron-product-gallery-col">
            <?php
            if ( 'grid' == $gallery ) {
                wc_get_template_part( 'content', 'gallery-grid' );
            } elseif ( 'woo' == $gallery ) {
                do_action( 'woocommerce_before_single_product_summary' );
            } else {
                wc_get_template_part( 'content', 'main-gallery' );
            }
            ?>
        </div>

        <div class="col-12 col-lg-<?php echo esc_attr( $summary_col ); ?> electron-product-summary-col">
            <div class="electron-product-summary">
                <div class="electron-product-summary-inner">
                    <?php if ( '0' != $bread && 'default' == $bread_pos ) { ?>
                        <div class="electron-summary-item electron-product-top-nav">
                            <?php echo electron_breadcrumbs(); ?>
                        </div>
                    <?php } ?>
                    <?php
                    if ( 'custom' == electron_settings( 'single_shop_summary_layout_type', 'default' ) ) {

                        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
                        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
                        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_brand_image', 10 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_single_stretch_type_product_labels', 15 );
                        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_countdown', 25 );
                        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_stock_progress_bar', 26 );
                        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_page_custom_btn', 31 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_popup_details', 35 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_coupon', 35 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_visitiors_message',39 );
                        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
                        remove_action( 'woocommerce_single_product_summary', 'electron_product_trust_image', 100 );

                        electron_product_summary_layouts_manager();

                        do_action( 'woocommerce_single_product_summary' );

                    } else {

                        /**
                        * Hook: woocommerce_single_product_summary.
                        *
                        * @hooked woocommerce_template_single_title - 5
                        * @hooked woocommerce_template_single_rating - 10
                        * @hooked woocommerce_template_single_price - 10
                        * @hooked woocommerce_template_single_excerpt - 20
                        * @hooked woocommerce_template_single_add_to_cart - 30
                        * @hooked woocommerce_template_single_meta - 40
                        * @hooked woocommerce_template_single_sharing - 50
                        * @hooked WC_Structured_Data::generate_product_data() - 60
                        */
                        do_action( 'woocommerce_single_product_summary' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row electron-row-after-summary">
        <div class="col-12">
            <?php
            /**
            * Hook: woocommerce_after_single_product_summary.
            *
            * @hooked woocommerce_output_product_data_tabs - 10
            * @hooked woocommerce_upsell_display - 15
            * @hooked woocommerce_output_related_products - 20
            */
            do_action( 'woocommerce_after_single_product_summary' );
            ?>
        </div>
    </div>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
