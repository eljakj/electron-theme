<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
    return;
}

$ajax_login = '1' == electron_settings( 'wc_ajax_login_register', '1' ) ? ' electron-ajax-login' : '';
do_action( 'electron_before_login_form' );
?>
<form class="woocommerce-form woocommerce-form-login login<?php echo esc_attr( $ajax_login ); ?>" method="post" <?php if ( $hidden ) { echo 'style="display:none;"'; } ?>>

    <?php do_action( 'woocommerce_login_form_start' ); ?>

    <?php
    if ( $message ) {
        echo wpautop( wptexturize( $message ) );
    }
    ?>

    <p class="form-row form-row-first electron-is-required">
        <label for="username"><?php esc_html_e( 'Username or email', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="text" class="input-text" name="username"  id="username" autocomplete="username" />
        <span class="electron-form-message"></span>
    </p>
    <p class="form-row form-row-last electron-is-required">
        <label for="password"><?php esc_html_e( 'Password', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
        <input class="input-text" type="password" name="password"  id="password" autocomplete="current-password" />
        <span class="electron-form-message"></span>
    </p>
    <div class="clear"></div>

    <?php do_action( 'woocommerce_login_form' ); ?>

    <p class="form-row">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" value="forever" /> <span><?php esc_html_e( 'Remember me', 'electron' ); ?></span>
        </label>
        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
        <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit electron-btn-medium electron-btn electron-btn-primary" name="login" value="<?php esc_attr_e( 'Login', 'electron' ); ?>"><?php esc_html_e( 'Login', 'electron' ); ?></button>
    </p>
    <p class="lost_password">
        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'electron' ); ?></a>
    </p>

    <div class="clear"></div>

    <?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
