<?php
/**
* Checkout Form
*
* This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 9.4.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'electron' ) ) );
    return;
}

$param = apply_filters( 'electron_buy_now_param', electron_settings( 'buy_now_param', 'electron-buy-now' ) );
if (isset( $_REQUEST[ $param ] ) && '1' == electron_settings( 'buy_now_visibility', '0' ) ) {
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
}

$electron_checkout_type = apply_filters( 'electron_checkout_enable_multistep', electron_settings( 'checkout_enable_multistep', 'default' ) );

wp_enqueue_style( 'electron-wc-checkout-page' );

if ( 'multisteps' == $electron_checkout_type ) {
    wp_enqueue_script( 'electron-multi-step-checkout');
    wc_get_template_part( 'checkout/multistep-form-checkout' );

} else {
    ?>
    <div class="electron-before-checkout-form-warapper">
        <?php do_action( 'woocommerce_before_checkout_form', $checkout );?>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <?php if ( $checkout->get_checkout_fields() ) : ?>

            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

            <div class="col2-set row row-cols-1 row-cols-lg-2" id="customer_details">

                <div class="col">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>

                <div class="col">

                    <div class="electron-order-review">
                        <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

                        <h6 class="electron-form-title" id="order_review_heading"><?php esc_html_e( 'Your order', 'electron' ); ?></h6>

                        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                        </div>

                        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

                    </div>
                </div>
            </div>

            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

        <?php endif; ?>

    </form>
    <?php
    do_action( 'woocommerce_after_checkout_form', $checkout );
}
?>
