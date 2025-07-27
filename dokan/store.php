<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();
$layout       = get_theme_mod( 'store_layout', 'left' );
$column       = 'full' != $layout ? 'col-xl-9 col-lg-8 shop-has-sidebar' : 'col-lg-12';

$orderby_options = dokan_store_product_catalog_orderby();
$store_id        = $store_user->get_id();

get_header( 'shop' );

?>
<div id="dokan-primary" class="dokan-single-store">
    <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

        <div class="nt-electron-inner-container shop-area gray-bg pt-0 pb-50">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <?php
                        if ( '1' == electron_settings( 'breadcrumbs_visibility', '1' ) ) {
                            if ( function_exists( 'yoast_breadcrumb' ) ) {
                                yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
                            } else {
                                woocommerce_breadcrumb();
                            }
                        }
                        ?>
                    </div>
                    <?php
                    if ( 'left' === $layout ) {
                        dokan_get_template_part( 'store', 'sidebar',array( 'store_user' => $store_user,'store_info' => $store_info,'map_location' => $map_location));
                    }
                    ?>

                    <div class="<?php echo esc_attr( $column ); ?>">

                        <?php dokan_get_template_part( 'store-header' ); ?>

                        <div class="dokan-shop-products-filter-area dokan-clearfix">
                            <form class="dokan-store-products-ordeby" method="get">
                                <div class="wc--row row before-shop--loop align-items-center">
                                    <div class="col-12 col-lg-8 catalog--ordering">
                                        <input type="text" name="product_name" class="product-name-search dokan-store-products-filter-search"  placeholder="<?php esc_attr_e( 'Enter product name', 'electron' ); ?>" autocomplete="off" data-store_id="<?php echo esc_attr( $store_id ); ?>">
                                        <input type="submit" name="search_store_products" class="search-store-products dokan-btn-theme" value="<?php esc_attr_e( 'Search', 'electron' ); ?>">
                                        <div id="dokan-store-products-search-result" class="dokan-ajax-store-products-search-result woocommerce"></div>
                                    </div>

                                    <?php if ( is_array( $orderby_options['catalogs'] ) && isset( $orderby_options['orderby'] ) ) : ?>
                                        <div class="col-12 col-lg-4 catalog--ordering">
                                            <select name="product_orderby" class="orderby orderby-search" aria-label="<?php esc_attr_e( 'Shop order', 'electron' ); ?>" onchange='if(this.value != 0) { this.form.submit(); }'>
                                                <?php foreach ( $orderby_options['catalogs'] as $id => $name ) : ?>
                                                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby_options['orderby'], $id ); ?>><?php echo esc_html( $name ); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <?php endif; ?>
                                    <input type="hidden" name="paged" value="1" />
                                </div>
                            </form>
                        </div>

                        <?php
                        if ( have_posts() ) {

                            woocommerce_product_loop_start();
                            while ( have_posts() ) {
                                the_post();
                                wc_get_template_part( 'content', 'product' );
                            }
                            woocommerce_product_loop_end();

                            //dokan_content_nav( 'nav-below' );
                            electron_index_loop_pagination();

                        } else { ?>
                            <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'electron' ); ?></p>

                        <?php } ?>
                    </div>
                    <?php
                    if ( 'right' === $layout ) {
                        dokan_get_template_part( 'store', 'sidebar',array( 'store_user' => $store_user,'store_info' => $store_info,'map_location' => $map_location));
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>
