<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

global $product;

if ( ! $product->is_purchasable() ) {
    return;
}
if ( '1' == electron_settings( 'woo_catalog_mode', '0' ) && '1' == electron_settings( 'woo_disable_product_addtocart', '0' ) ) {
    return;
}

$icon = '<svg
class="svgaddtocart electron-svg-icon"
width="512"
height="512"
fill="currentColor"
viewBox="0 0 32 32"
xmlns="http://www.w3.org/2000/svg"><use href="#shopBag"></use></svg>';

if ( $product->is_in_stock() ) : ?>
<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<div class="electron-summary-item electron-product-info">
	<div class="electron-product-info-top">
		<form class="electron-flex cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		    <?php
		    do_action( 'woocommerce_before_add_to_cart_button' );
		    do_action( 'woocommerce_before_add_to_cart_quantity' );
		    woocommerce_quantity_input(
		        array(
		            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
		            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		        )
		    );
		    do_action( 'woocommerce_after_add_to_cart_quantity' );
		    ?>
		    <button
		    type="submit"
		    name="add-to-cart"
		    value="<?php echo esc_attr( $product->get_id() ); ?>"
		    class="single_add_to_cart_button electron-btn electron-btn-primary electron-product-cart has-icon electron-spinner">
		        <span class="cart-text"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span>
		        <?php printf('%s', $icon ); ?>
		    </button>
		    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</form>
	</div>
	<?php if ( electron_shipping_class_name() ) { ?>
	    <div class="electron-product-info-bottom">
	        <div class="info-message shipping-class"><?php echo electron_svg_lists( 'delivery-return', 'electron-svg-icon' ); ?> <strong><?php echo electron_shipping_class_name(); ?></strong></div>
	        <div class="info-message shipping-description"><?php echo electron_shipping_class_name('desc'); ?></div>
	    </div>
	<?php } ?>
</div>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
<?php endif; ?>
