<?php
/**
* Single Product tabs
*
* This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see     https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 9.6.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
* Filter tabs and allow third parties to add their own.
*
* Each tab is an array containing title, callback and priority.
*
* @see woocommerce_default_product_tabs()
*/

if ( '0' == electron_settings( 'product_tabs_visibility', '1' ) ) {
    return;
}

$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( !empty( electron_wc_extra_tabs_array() ) ) {
    $extra_tabs   = electron_wc_extra_tabs_array();
    $product_tabs = array_merge($product_tabs, $extra_tabs);
}

if ( ! empty( $product_tabs ) ) {

    $count = $count2 = 0;
    $tabs = isset($_GET['tabs']) ? esc_html($_GET['tabs']) : electron_settings( 'product_tabs_type', 'tabs' );
    $type = 'accordion' == $tabs ? 'electron-section electron-accordion-after-summary' : 'electron-summary-item electron-accordion-in-summary';

    if ( class_exists( 'Ivole' ) && comments_open() && '1' == electron_settings('single_shop_review_visibility', '1' ) ) {
        wp_enqueue_style( 'electron-wc-custom-reviews' );
        wp_enqueue_style( 'cr-badges-css' );
        wp_enqueue_style( 'ivole-frontend-css' );
    }

    if ( 'accordion' == $tabs ) {
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 31 );
    }

    if ( 'accordion' == $tabs || 'accordion-2' == $tabs ) { ?>

        <div class="electron-product-accordion-wrapper <?php echo esc_attr( $type ); ?>" id="accordionProduct">
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <?php if ( !empty( $product_tab['title'] ) ) { ?>
                    <div class="electron-accordion-item">
                        <div class="electron-accordion-header" data-id="accordion-<?php echo esc_attr( $key ); ?>">
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                        </div>
                        <div data-id="accordion-<?php echo esc_attr( $key ); ?>" class="electron-accordion-body">
                            <?php
                            if ( isset( $product_tab['callback'] ) ) {
                                call_user_func( $product_tab['callback'], $key, $product_tab );
                            } elseif( isset( $product_tab['content'] ) ){
                                echo do_shortcode($product_tab['content'] );
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>

    <?php } else { ?>

        <div class="electron-product-tabs-wrapper tabs-type-1 electron-section" id="productTabContent">
            <div class="electron-product-tab-title">
                <?php foreach ( $product_tabs as $key => $product_tab ) :
                    $active = $count == 0 ? ' active' : '';
                    $count++;
                    ?>
                    <?php if ( !empty( $product_tab['title'] ) ) { ?>
                        <div class="electron-product-tab-title-item<?php echo esc_attr( $active ); ?>" data-id="tab-<?php echo esc_attr( $key ); ?>">
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
                <?php do_action( 'electron_product_extra_tabs_title' ); ?>
            </div>
            <div class="electron-product-tabs-content">
                <?php foreach ( $product_tabs as $key => $product_tab ) :
                    $active = $count2 == 0 ? ' show active' : '';
                    $count2++;
                    ?>
                    <?php if ( !empty( $product_tab['title'] ) ) { ?>
                        <div class="electron-product-tab-content-item<?php echo esc_attr( $active ); ?>" data-id="tab-<?php echo esc_attr( $key ); ?>">
                            <?php
                            if ( isset( $product_tab['callback'] ) ) {
                                call_user_func( $product_tab['callback'], $key, $product_tab );
                            } elseif( isset( $product_tab['content'] ) ){
                                echo do_shortcode($product_tab['content'] );
                            }
                            ?>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>

                <?php do_action( 'electron_product_extra_tabs_content' ); ?>

                <?php do_action( 'woocommerce_product_after_tabs' ); ?>
            </div>
        </div>
        <?php
    }
}
?>
