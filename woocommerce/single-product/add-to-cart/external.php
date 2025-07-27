<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( '1' == electron_settings( 'woo_catalog_mode', '0' ) && '1' == electron_settings( 'woo_disable_product_addtocart', '0' ) ) {
    return;
}
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<div class="electron-summary-item electron-product-info">
	<div class="electron-product-info-top">
		<form class="electron-flex cart form-external" action="<?php echo esc_url( $product_url ); ?>" method="get">
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
			<button type="submit" class="single_add_to_cart_button electron-btn electron-btn-medium electron-btn-primary electron-btn-border">
			    <span class="button-title"><?php echo esc_html( $button_text ); ?></span>
			</button>
			<?php wc_query_string_form_fields( $product_url ); ?>
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</form>
	</div>
	<?php if ( electron_shipping_class_name() ) { ?>
	    <div class="electron-product-info-bottom">
	        <div class="info-message"><?php echo electron_svg_lists( 'delivery-return', 'electron-svg-icon' ); ?> <strong><?php echo electron_shipping_class_name(); ?></strong></div>
	        <div class="info-message"><?php echo electron_shipping_class_name('desc'); ?></div>
	    </div>
	<?php } ?>
</div>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
