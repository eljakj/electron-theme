<?php
/**
* Checkout Form
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$labels = apply_filters( 'electron_checkout_multisteps_strings', array(
    'login'    => _x( 'Login', 'Checkout: user multisteps', 'electron' ),
    'billing'  => _x( 'Billing & Shipping', 'Checkout: user multisteps', 'electron' ),
    'order'    => _x( 'Order & Payment', 'Checkout: user multisteps', 'electron' ),
    'next'     => esc_html__( 'Next', 'electron' ),
    'prev'     => esc_html__( 'Previous', 'electron' ),
    'required' => esc_html__( 'This field is required', 'electron' )
));

$checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() );
$checkout = new WC_Checkout();

?>
<div class="container-sm electron-checkout-content-wrapper electron-page-multistep-checkout">
    <div class="row electron-justify-center">
        <div class="col-12 col-md-10 col-lg-8">

            <div class="electron-checkout-labels">
                <div class="electron-checkout-labels-inner">
                    <?php if ( ! is_user_logged_in() ) : ?>
                        <div class="electron-swiper-pagination" data-steps-labels='{"labels":["<?php echo esc_html( $labels['login'] ); ?>","<?php echo esc_html( $labels['billing'] ); ?>","<?php echo esc_html( $labels['order'] ); ?>"]}'></div>
                    <?php else : ?>
                        <div class="electron-swiper-pagination" data-steps-labels='{"labels":["<?php echo esc_html( $labels['billing'] ); ?>","<?php echo esc_html( $labels['order'] ); ?>"]}'></div>
                    <?php endif; ?>
                </div>
            </div>

            <div id="checkout_coupon" class="electron-woocommerce-checkout-coupon">
                <?php woocommerce_checkout_coupon_form(); ?>
            </div>

            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $checkout_url ); ?>" enctype="multipart/form-data">
                <div class="swiper-container electron-checkout-content">

                    <div class="swiper-wrapper">
                        <?php if ( ! is_user_logged_in() ) : ?>
                            <div class="swiper-slide">
                                <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) { ?>
                                    <div class="swiper-container electron-checkout-form-login">
                                        <div class="electron-inner-steps-buttons">
                                            <span class="electron-checkout-form-button-login signin-title">
                                                <?php echo electron_svg_lists( 'arrow-right', 'electron-svg-icon' ); ?>
                                                <span><?php esc_html_e( 'Sign in', 'electron' ); ?></span>
                                            </span>
                                            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) { ?>
                                                <span class="electron-checkout-form-button-register register-title">
                                                    <?php echo electron_svg_lists( 'user-2', 'electron-svg-icon' ); ?>
                                                    <span><?php esc_html_e( 'Register', 'electron' ); ?></span>
                                                </span>
                                            <?php } ?>
                                        </div>
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div id="checkout_login" class="electron-woocommerce-checkout-login">
                                                    <?php woocommerce_login_form(); ?>
                                                </div>
                                            </div>
                                            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) { ?>
                                                <div class="swiper-slide">
                                                    <div class="register-form-content">

                                                        <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                                                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                                                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                                                <p class="form-row electron-is-required">
                                                                    <label for="reg_username"><?php esc_html_e( 'Username', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
                                                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                                                                    <span class="electron-form-message"></span>
                                                                </p>
                                                            <?php endif; ?>

                                                            <p class="form-row electron-is-required">
                                                                <label for="reg_email"><?php esc_html_e( 'Email address', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
                                                                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                                                                <span class="electron-form-message"></span>
                                                            </p>

                                                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                                                                <p class="form-row electron-is-required">
                                                                    <label for="reg_password"><?php esc_html_e( 'Password', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
                                                                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                                                                    <span class="electron-form-message"></span>
                                                                </p>
                                                            <?php else : ?>
                                                                <p><?php esc_html_e( 'A password will be sent to your email address.', 'electron' ); ?></p>
                                                            <?php endif; ?>

                                                            <?php do_action( 'woocommerce_register_form' ); ?>

                                                            <p class="form-row">
                                                                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                                                <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit electron-btn-medium electron-btn electron-btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'electron' ); ?>"><?php esc_html_e( 'Register', 'electron' ); ?></button>
                                                            </p>

                                                            <?php do_action( 'woocommerce_register_form_end' ); ?>

                                                        </form>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div id="checkout_login" class="electron-woocommerce-checkout-login">
                                        <?php woocommerce_login_form(); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $checkout->get_checkout_fields() ) : ?>
                            <div class="swiper-slide">

                                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                                <div class="row check-form-required">
                                    <div class="col-12 col-lg-6">
                                        <div class="electron-customer-billing-details <?php echo is_user_logged_in() ? 'logged-in' : 'not-logged-in'; ?>" id="electron-customer-billing-details">
                                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="electron-customer-shipping-details" id="electron-customer-shipping-details">
                                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="electron-form-error hidden"><?php echo esc_html( $labels['required'] ); ?></div>

                                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                            </div>
                        <?php endif; ?>

                        <div class="swiper-slide">

                            <div class="electron-order-review">
                                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                                <div id="order_review">
                                    <h4 class="electron-form-title"><?php esc_html_e( 'Your order', 'electron' ); ?></h4>
                                    <?php echo woocommerce_order_review(); ?>
                                </div>
                                <div class="electron-order-checkout-payment mt-40">
                                    <?php echo woocommerce_checkout_payment(); ?>
                                </div>
                                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="electron-checkout-button-wrapper">
                        <div class="electron-checkout-button-prev button"><?php echo esc_html( $labels['prev'] ) ?></div>
                        <div class="electron-checkout-button-next button <?php echo !is_user_logged_in() ? 'disabled' : 'enabled' ?>"><?php echo esc_html( $labels['next'] ) ?></div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );
