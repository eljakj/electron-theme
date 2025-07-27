<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$ajax_login   = electron_settings( 'wc_ajax_login_register', '1' );
$login_class  = '1' == $ajax_login ? ' electron-ajax-login' : '';
$hidden_class = '1' == $ajax_login ? ' hidden-message' : '';


do_action( 'electron_before_login_form' );

if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) {
    if ( 'multisteps' == apply_filters('electron_myaccount_page_type',electron_settings( 'myaccount_page_type', 'multisteps' ) ) ) {

        wc_get_template_part( 'myaccount/form-login-multisteps' );

    } else {

        ?>
        <div class="electron-before-login-form">
            <?php do_action( 'woocommerce_before_customer_login_form' ); ?>
        </div>

        <div class="electron-default-type row justify-content-center has-gap" id="customer_login">

            <div class="col-12 col-sm-10 col-md-8 col-lg-4 active" data-step="login">

                <h3 class="form-heading login-title active" data-step="login"><?php esc_html_e( 'Login', 'electron' ); ?></h3>

                <form class="woocommerce-form woocommerce-form-login login row electron-myaccount-form<?php echo esc_attr( $login_class ); ?>" method="post" novalidate>

                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <p class="woocommerce-form-row form-row col-12">
                        <label for="username"><?php esc_html_e( 'Username or email address', 'electron' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'electron' ); ?></span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required aria-required="true" />
                    </p>
                    <p class="woocommerce-form-row form-row col-12">
                        <label for="password"><?php esc_html_e( 'Password', 'electron' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'electron' ); ?></span></label>
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
                    </p>

                    <?php do_action( 'woocommerce_login_form' ); ?>

                    <p class="woocommerce-form-row form-row col-12">
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'electron' ); ?></span>
                        </label>
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> electron-btn electron-btn-primary" name="login" value="<?php esc_attr_e( 'Log in', 'electron' ); ?>"><span><?php esc_html_e( 'Log in', 'electron' ); ?></span></button>
                    </p>

                    <p class="woocommerce-LostPassword lost_password col-12">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'electron' ); ?></a>
                    </p>

                    <?php do_action( 'woocommerce_login_form_end' ); ?>

                </form>
            </div>

            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

                <div class="col-12 col-sm-10 col-md-8 col-lg-4" data-step="register">

                    <h3 class="form-heading register-title" data-step="register"><?php esc_html_e( 'Register', 'electron' ); ?></h3>

                    <form method="post" class="woocommerce-form woocommerce-form-register register row electron-myaccount-form" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                        <?php do_action( 'woocommerce_register_form_start' ); ?>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                            <p class="woocommerce-form-row form-row col-12">
                                <label for="reg_username"><?php esc_html_e( 'Username', 'electron' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'electron' ); ?></span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required aria-required="true" />
                            </p>

                        <?php endif; ?>

                        <p class="woocommerce-form-row form-row col-12">
                            <label for="reg_email"><?php esc_html_e( 'Email address', 'electron' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'electron' ); ?></span></label>
                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required aria-required="true" />
                        </p>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                            <p class="woocommerce-form-row form-row col-12">
                                <label for="reg_password"><?php esc_html_e( 'Password', 'electron' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'electron' ); ?></span></label>
                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
                            </p>

                        <?php else : ?>

                            <p class="woocommerce-form-row form-row col-12"><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'electron' ); ?></p>

                        <?php endif; ?>

                        <?php do_action( 'woocommerce_register_form' ); ?>

                        <p class="woocommerce-form-row form-row col-12">
                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                            <button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit electron-btn electron-btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'electron' ); ?>"><?php esc_html_e( 'Register', 'electron' ); ?></button>
                        </p>

                        <?php do_action( 'woocommerce_register_form_end' ); ?>

                    </form>

                </div>
            <?php endif; ?>
        </div>
        <?php
        do_action( 'woocommerce_after_customer_login_form' );
    }
}
?>
