<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

$column     = isset($_GET['column']) ? esc_html($_GET['column']) : '';
$type       = isset($_GET['product_style']) ? esc_html($_GET['product_style']) : electron_settings( 'shop_product_type', '1' );
$type       = apply_filters( 'electron_loop_product_type', $type );
$css_class  = $column == '1' ? 'electron-loop-product type-list' : 'electron-loop-product type-'.$type;
$css_class .= wp_doing_ajax() ? ' animated '.apply_filters( 'electron_loop_product_animation', electron_settings( 'shop_product_animation_type', 'fadeInUp' ) ) : '';
$animation  = apply_filters( 'electron_loop_product_animation', electron_settings( 'shop_product_animation_type', 'fadeInUp' ) );

?>
<div <?php wc_product_class( $css_class, $product ); ?> data-product-animation="<?php echo esc_attr( $animation ); ?>">

    <?php
    if ( '1' == $column || $type == 'list' ) {
        wc_get_template_part( 'product-type/type', 'list' );
    } else {
        wc_get_template_part( 'product-type/type', $type );
    }
    ?>

</div>
<?php
