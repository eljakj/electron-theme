<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( '1' == electron_settings( 'woo_catalog_mode', '0' ) && '1' == electron_settings( 'woo_disable_product_addtocart', '0' ) ) {
    return;
}

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );


do_action( 'woocommerce_before_add_to_cart_form' );
wp_enqueue_style( 'electron-wc-product-variatons');

?>

<form class="electron-summary-item electron-flex variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr( $variations_attr ); // WPCS: XSS ok. ?>">
    <?php do_action( 'woocommerce_before_variations_form' ); ?>

    <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
        <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'electron' ) ) ); ?></p>
    <?php else : ?>
        <div class="electron-variations variations">
            <?php if ( '1' == electron_settings('selected_variations_terms_visibility', '1' ) ) : ?>
                <div class="electron-selected-variations-terms-wrapper">
                    <div class="electron-selected-variations-terms"></div>
                </div>
            <?php endif; ?>
            <?php foreach ( $attributes as $attribute_name => $options ) :
                $id   = wc_attribute_taxonomy_id_by_name( $attribute_name );
                $attr = wc_get_attribute( $id );
                $type = !empty( $attr->type ) ? $attr->type : 'select';
                ?>
                <div class="electron-variations-items variations-items electron-variations-type-<?php echo esc_attr( $type ); ?>">
                    <span class="electron-small-title"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></span>
                    <div class="value">
                        <?php
                        wc_dropdown_variation_attribute_options(
                            array(
                                'options'   => $options,
                                'attribute' => $attribute_name,
                                'product'   => $product,
                            )
                        );
                        ?>
                    </div>
                </div>
                <?php echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<div class="electron-btn-reset-wrapper"><span class="electron-small-title">reset</span><a class="electron-btn-reset reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'electron' ) . '">'.esc_html__( 'Clear', 'electron' ).'</a></div>' ) : ''; ?>
            <?php endforeach; ?>
        </div>
        <div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>

        <?php do_action( 'woocommerce_after_variations_table' ); ?>

        <div class="electron-product-info">
            <div class="electron-product-info-top">
                <?php
                /**
                * Hook: woocommerce_before_single_variation.
                */
                do_action( 'woocommerce_before_single_variation' );

                /**
                * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
                *
                * @since 2.4.0
                * @hooked woocommerce_single_variation - 10 Empty div for variation data.
                * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
                */
                do_action( 'woocommerce_single_variation' );

                /**
                * Hook: woocommerce_after_single_variation.
                */
                do_action( 'woocommerce_after_single_variation' );
                ?>
            </div>
            <?php if ( electron_shipping_class_name() ) { ?>
                <div class="electron-product-info-bottom">
                    <div class="info-message shipping-class"><?php echo electron_svg_lists( 'delivery-return', 'electron-svg-icon' ); ?> <strong><?php echo electron_shipping_class_name(); ?></strong></div>
                    <div class="info-message shipping-description"><?php echo electron_shipping_class_name('desc'); ?></div>
                </div>
            <?php } ?>
        </div>
    <?php endif; ?>
    <?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
