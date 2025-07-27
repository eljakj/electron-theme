<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

use Automattic\WooCommerce\Enums\ProductType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( '1' != electron_settings('product_meta_visibility', '1') ) {
    return;
}

?>
<div class="electron-summary-item electron-product-meta">

    <?php do_action( 'woocommerce_product_meta_start' ); ?>

    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( ProductType::VARIABLE ) ) ) : 
        $sku = $product->get_sku() ? $product->get_sku() : esc_html__( 'N/A', 'electron' );
        ?>
        <div class="electron-sku-wrapper electron-meta-wrapper"><span class="electron-meta-label"><?php esc_html_e( 'SKU:', 'electron' ); ?></span> <span class="sku meta-value"><?php echo esc_html( $sku ); ?></span></div>
    <?php endif; ?>

    <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="electron-small-title electron-meta-wrapper posted_in"><span class="electron-meta-label">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'electron' ) . '</span><span class="meta-value">', '</span></div>' ); ?>

    <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="electron-small-title electron-meta-wrapper tagged_as"><span class="electron-meta-label">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'electron' ) . '</span><span class="meta-value">', '</span></div>' ); ?>

    <?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
