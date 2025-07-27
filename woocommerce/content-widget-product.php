<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

?>
<li class="electron-widget-product-list-item">
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

    <a class="electron-widget-product-list-inner" href="<?php echo esc_url( $product->get_permalink() ); ?>">
    	<?php echo get_the_post_thumbnail( $product->get_id(), [ 50,50 ] ); ?>
    	<span class="electron-widget-product-list-details">
        	<span class="product-title"><?php echo wp_kses_post( $product->get_name() ); ?></span>
        	
        	<?php if ( ! empty( $show_rating ) ) : ?>
        		<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
        	<?php endif; ?>
            <span class="electron-price">
        	    <?php printf('%s', $product->get_price_html() ); ?>
        	</span>
    	</span>
    </a>
    
	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
