<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$price_class = apply_filters( 'woocommerce_product_price_class', 'electron-summary-item electron-price' );
$stock_show  = electron_settings('product_labels_visibility', '1' );
$stock_show2 = electron_settings('product_stock_visibility', '1' );
if ( '1' == electron_settings( 'woo_catalog_mode', '0' ) && '1' == electron_settings( 'woo_disable_price', '0' ) ) {
    return;
}
?>
<div class="<?php echo esc_attr( $price_class ); ?>">
    <div class="electron-price-wrapper price"><?php printf('%s', $product->get_price_html() ); ?></div>
    <?php if ( '0' != $stock_show && '0' != $stock_show2 ) { echo wc_get_stock_html($product); } ?>
</div>
