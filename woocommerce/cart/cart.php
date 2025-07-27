<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

$param = apply_filters( 'electron_buy_now_param', electron_settings( 'buy_now_param', 'electron-buy-now' ) );
if (isset( $_REQUEST[ $param ] ) && '1' == electron_settings( 'buy_now_visibility', '0' ) ) {
	remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
}

do_action( 'woocommerce_before_cart' );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

$icon = '<svg
class="svgTrash electron-svg-icon mini-icon"
height="427pt"
viewBox="-40 0 427 427.00131"
width="427pt"
xmlns="http://www.w3.org/2000/svg"><use href="#shopTrash"></use></svg>';
?>
<div class="row electron-cart-row">
    <div class="col-lg-8">
        <?php do_action( 'electron_before_cart_contents' ); ?>
        <form class="woocommerce-cart-form electron-woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <?php
                do_action( 'woocommerce_before_cart_contents' );

                foreach ( WC()->cart->get_cart() as $key => $item ) {
                    $_product = apply_filters( 'woocommerce_cart_item_product', $item['data'], $item, $key );
                    $pid      = apply_filters( 'woocommerce_cart_item_product_id', $item['product_id'], $item, $key );
                    $img_size = apply_filters( 'electron_cart_item_img_size', [80,80] );
                    $img      = $_product->get_image( $img_size );
                    $qty      = $item['quantity'];
                    $name     = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $item, $key );

                    if ( $_product && $_product->exists() && $qty > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $item, $key ) ) {
                        $permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $item ) : '', $item, $key );
                        ?>
                        <div class="row electron-cart-item electron-align-center woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $item, $key ) ); ?>">
                            <div class="col-12 col-sm-6">
                                <div class="row electron-meta-left electron-flex electron-align-center">
                                    <div class="col-3 product-thumbnail">
                                        <?php
                                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $img, $item, $key );

                                        if ( ! $permalink) {
                                            printf( '%s', $thumbnail );
                                        } else {
                                            printf( '<a href="%s">%s</a>', esc_url( $permalink), $thumbnail );
                                        }
                                        ?>
                                    </div>
                                    <div class="col-9 product-name electron-small-title" data-title="<?php esc_attr_e( 'Product', 'electron' ); ?>">
                                        <?php
                                        if ( ! $permalink) {
                                            printf( '%s', esc_html( $name ) );
                                        } else {
                                            printf( '<a href="%s">%s</a>', esc_url( $permalink), $name );
                                        }

                                        do_action( 'woocommerce_after_cart_item_name', $item, $key );

                                        // Meta data.
                                        echo wc_get_formatted_cart_item_data( $item );

                                        // Backorder notification.
                                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $qty ) ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'electron' ) . '</p>', $pid ) );
                                        }
                                        ?>
                                        <div class="product-price electron-price" data-title="<?php esc_attr_e( 'Price', 'electron' ); ?>">
                                            <span class="price">
                                                <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $item, $key ); ?>
                                            </span>
                                            <span class="cart-quantity"><?php printf( esc_html__( 'X %1$s', 'electron' ), $qty ); ?></span>
                                        </div>
                                        <?php if ( '1' == electron_settings('cart_sku_visibility', '0') ) { ?>
                                            <span class="cart-sku"><?php esc_html_e('SKU:', 'electron'); ?> <?php echo esc_attr( $_product->get_sku() ); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="row electron-meta-right electron-align-center">
                                    <div class="col-auto product-quantity electron-quantity-small" data-title="<?php esc_attr_e( 'Quantity', 'electron' ); ?>">
                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        } else {
                                            $min_quantity = 0;
                                            $max_quantity = $_product->get_max_purchase_quantity();
                                        }

                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$key}][qty]",
                                                'input_value'  => $qty,
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $name
                                            ),
                                            $_product,
                                            false
                                        );

                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $key, $item );
                                        ?>
                                    </div>
                                    <div class="col-auto product-subtotal electron-price" data-title="<?php esc_attr_e( 'Subtotal', 'electron' ); ?>">
                                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $qty ), $item, $key ); ?>
                                    </div>
                                    <div class="col-auto product-remove">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-name="%s" data-qty="%s">'.$icon.'</a>',
                                                esc_url( wc_get_cart_remove_url( $key ) ),
                                                esc_attr( sprintf( __( 'Remove %s from cart', 'electron' ), $name ) ),
                                                esc_attr( $pid ),
                                                esc_attr( $_product->get_sku() ),
                                                esc_attr( $name ),
                                                $qty
                                            ),
                                            $key
                                        );
                                        ?>
                                        <span class="loading-wrapper"><span class="ajax-loading"></span></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                }
                do_action( 'woocommerce_cart_contents' );
                ?>
                <div class="electron-cart-item electron-actions">
                    <div class="row">

                        <?php if ( wc_coupons_enabled() ) { ?>
                            <div class="col col-12 col-7 col-lg-8">
                                <div class="electron-flex">
                                    <input type="text" name="coupon_code" class="input-text electron-input electron-input-small" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'electron' ); ?>" />
                                    <button type="submit" class="electron-btn electron-btn-primary electron-btn-medium cart-apply-button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'electron' ); ?>"><?php esc_html_e( 'Apply coupon', 'electron' ); ?></button>
                                    <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col col-12 col-lg-4">
                            <div class="electron-hidden electron-flex electron-flex-right">
                                <button type="submit" class="electron-btn electron-btn-blue-soft electron-btn-medium cart-update-button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'electron' ); ?>"><?php esc_html_e( 'Update cart', 'electron' ); ?></button>
                                <?php do_action( 'woocommerce_cart_actions' ); ?>
                                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php do_action( 'woocommerce_after_cart_contents' ); ?>

            </div>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>
    </div>
    <div class="col-lg-4"><?php woocommerce_cart_totals(); ?></div>
</div>
<div class="row electron-cross_sell-row">
    <?php
    do_action( 'woocommerce_before_cart_collaterals' );
    /**
    * Cart collaterals hook.
    *
    * @hooked woocommerce_cross_sell_display
    * @hooked woocommerce_cart_totals - 10
    */
    do_action( 'woocommerce_cart_collaterals' );
    ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
