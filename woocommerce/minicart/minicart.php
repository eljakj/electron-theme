<?php
/**
* Mini-cart
*
* Contains the markup for the mini-cart, used by the cart widget.
*
* This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( ! class_exists('WooCommerce') ) {
    return;
}

do_action( 'woocommerce_before_mini_cart' );

$qty_filter    = 'woocommerce_cart_item_quantity';
$show_quantity = electron_settings('minicart_cart_quantity_visibility', '1');
$clearbtn      = electron_settings('minicart_cart_clearbtn_visibility', '1');
$sku           = electron_settings('cart_sku_visibility', '0');
$shoplink      = electron_settings('minicart_cart_shop_link', '');
$privacylink   = electron_settings('minicart_cart_privacy_link', '');
$checkoutlink  = electron_settings('minicart_cart_checkout_link', '');
$cartlink      = electron_settings('minicart_cart_cart_link', '');
$shoplink      = $shoplink ? $shoplink : apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) );
$privacylink   = $privacylink ? $privacylink : get_permalink( get_option( 'wp_page_for_privacy_policy' ) );
$checkoutlink  = $checkoutlink ? $checkoutlink : apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() );
$cartlink      = $cartlink ? $cartlink : wc_get_cart_url();
$has_clear_btn = $clearbtn == '1' && ! WC()->cart->is_empty() && count( WC()->cart->get_cart() ) >= 2 ? ' has-clear-btn' : '';
$icon = '<svg
class="svgTrash electron-svg-icon mini-icon"
height="427pt"
viewBox="-40 0 427 427.00131"
width="427pt"
xmlns="http://www.w3.org/2000/svg"><use href="#shopTrash"></use></svg>';
?>
<div class="minicart-panel">
    <?php if ( ! WC()->cart->is_empty() ) : ?>
        <?php do_action( 'electron_before_mini_cart_contents' ); ?>
        <div class="electron-header-cart-details electron-minicart electron-cart-details has-product<?php echo esc_attr( $has_clear_btn ); ?>">
            <div class="electron-scrollbar">
                <?php
                do_action( 'woocommerce_before_mini_cart_contents' );
                foreach ( WC()->cart->get_cart() as $key => $item ) {
                    $p       = apply_filters( 'woocommerce_cart_item_product', $item['data'], $item, $key );
                    $pid     = apply_filters( 'woocommerce_cart_item_product_id', $item['product_id'], $item, $key );
                    $link    = apply_filters( 'woocommerce_cart_item_permalink', $p->is_visible() ? $p->get_permalink( $item ) : '', $item, $key );
                    $qty     = $item['quantity'];
                    $visible = apply_filters( 'woocommerce_widget_cart_item_visible', true, $item, $key );
                    if ( $p && $p->exists() && $qty > 0 && $visible ) {
                        $name   = apply_filters( 'woocommerce_cart_item_name', $p->get_name(), $item, $key );
                        $price  = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $p ), $item, $key );
                        $imgurl = get_the_post_thumbnail_url($pid, 'electron-panel');
                        $imgsrc = $imgurl ? $imgurl : wc_placeholder_img_src();
                        $img    = '<img width="80" height="80" src="'.$imgsrc.'" alt="'.esc_attr( $name ).'"/>';
                        $max    = $p->backorders_allowed() ? '' : $p->get_stock_quantity();
                        ?>
                        <div class="woocommerce-mini-cart-item mini-cart-item electron-cart-item" data-pid="<?php echo esc_attr( $pid ); ?>">
                            <div class="cart-item-details">
                                <a class="product-link" href="<?php echo esc_url( $link ); ?>"><?php printf( '%s', $img ); ?></a>
                                <div class="cart-item-title electron-small-title">
                                    <a class="product-link" href="<?php echo esc_url($link); ?>">
                                        <?php printf( '<span class="cart-name">%s %s</span>', $name, wc_get_formatted_cart_item_data( $item )); ?>
                                        <span class="electron-price price">
                                            <?php echo apply_filters( $qty_filter, '<span class="new">'.$price.'</span>', $item, $key ); ?>
                                            <span class="cart-quantity"><?php printf( esc_html__( 'X %1$s', 'electron' ), $qty ); ?></span>
                                        </span>
                                    </a>
                                    <?php
                                    if ( $show_quantity == '1' ) {
                                    if ( $p->is_sold_individually() ) {
                                        $min = 1;
                                        $max = 1;
                                    } else {
                                        $min = 0;
                                        $max = $p->get_max_purchase_quantity();
                                    }
                                    echo '<div class="cart-quantity-wrapper" data-product_id="'.$pid.'" data-key="'.$key.'">';
                                        $quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$key}][qty]",
                                                'input_value'  => $qty,
                                                'max_value'    => $max,
                                                'min_value'    => $min,
                                                'product_name' => $name
                                            ),
                                            $p,
                                            false
                                        );
                                        echo apply_filters( $qty_filter, $quantity, $key, $item );
                                    echo '</div>';
                                    }
                                    ?>
                                    <?php if ( $sku == '1' ) { ?>
                                        <span class="cart-sku"><?php esc_html_e('SKU:', 'electron'); ?> <?php echo esc_attr( $p->get_sku() ); ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="del-icon" data-id="<?php echo esc_attr( $pid ); ?>">
                                <?php
                                echo apply_filters(
                                    'woocommerce_cart_item_remove_linkk',
                                    sprintf(
                                        '<a href="%s" class="electron_remove_from_cart_button" data-product_id="%s" data-cart_item_key="%s" data-name="%s" data-qty="%s">'.$icon.'</a>',
                                        esc_url( wc_get_cart_remove_url( $key ) ),
                                        esc_attr( $pid ),
                                        esc_attr( $key ),
                                        esc_attr( $name ),
                                        $qty
                                    ),
                                    $key
                                );
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                do_action( 'woocommerce_mini_cart_contents' );
                ?>
                <span class="loading-wrapper"><span class="ajax-loading"></span></span>
            </div>
            <?php if ($clearbtn == '1' && count(WC()->cart->get_cart()) >= 2) { ?><div class="electron_clear_cart_button"><?php esc_html_e('Clear All', 'electron'); ?></div><?php } ?>
        </div>
        <div class="header-cart-footer">
            <div class="cart-total">
                <div class="cart-total-price">
                    <div class="cart-total-price-left"><?php echo esc_html_e( 'Subtotal: ', 'electron' ); ?></div>
                    <div class="cart-total-price-right"><?php printf( '%s', WC()->cart->get_cart_subtotal() ); ?></div>
                </div>
                <?php if ( '1' == electron_settings('cart_total_visibility', '0') ) { ?>
                    <div class="cart-total-price">
                        <div class="cart-total-price-left"><?php echo esc_html_e( 'Total: ', 'electron' ); ?></div>
                        <div class="cart-total-price-right"><?php printf( '%s', WC()->cart->get_cart_total() ); ?></div>
                    </div>
                <?php } ?>
            </div>
            <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
            <div class="cart-bottom-btn">
                <a class="electron-btn-medium electron-btn electron-btn-primary electron-btn-border" href="<?php echo esc_url( $cartlink ); ?>"><?php echo esc_html_e( 'View Cart', 'electron' ); ?></a>
                <a class="electron-btn-medium electron-btn electron-btn-primary electron-checkout-page-link" href="<?php echo esc_url( $checkoutlink ); ?>"><?php echo esc_html_e( 'Checkout', 'electron' ); ?></a>
            </div>
            <?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
        </div>
        <div class="header-cart-after-buttons">
            <?php do_action( 'electron_minicart_after_buttons' ); ?>
        </div>
    <?php else : ?>
        <div class="electron-header-cart-details electron-minicart">
            <div class="cart-empty-content">
                <?php echo electron_svg_lists( 'bag' ); ?>
                <?php if ( '' != electron_settings('sidebar_panel_cart_custom_title') ) { ?>
                    <span class="minicart-title"><?php echo esc_html( electron_settings('sidebar_panel_cart_custom_title') ); ?></span>
                <?php } else { ?>
                    <span class="minicart-title"><?php esc_html_e( 'Your Cart', 'electron' ); ?></span>
                <?php } ?>
                <p class="empty-title electron-small-title"><?php esc_html_e( 'No products in the cart.', 'electron' ); ?></p>
                <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
                <div class="cart-empty-actions cart-bottom-btn">
                    <a class="electron-btn-medium electron-btn electron-btn-primary electron-btn-border" href="<?php echo esc_url( $shoplink ); ?>"><?php esc_html_e( 'Start Shopping', 'electron' ); ?></a>
                    <a class="electron-btn-medium electron-btn electron-btn-primary" href="<?php echo esc_url( $privacylink ); ?>"><?php esc_html_e( 'Return Policy', 'electron' ); ?></a>
                </div>
                <?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
