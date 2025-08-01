<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

 ?>
<div class="row">
    <div class="col-12 col-md-10 col-lg-8">
        <?php  do_action( 'woocommerce_before_edit_account_form' ); ?>
        <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

            <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

            <p class="form-row electron-row electron-is-required">
                <label for="account_first_name"><?php esc_html_e( 'First name', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" aria-required="true" />
                <span class="electron-form-message"></span>
            </p>

            <p class="form-row electron-row electron-is-required">
                <label for="account_last_name"><?php esc_html_e( 'Last name', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" aria-required="true" />
                <span class="electron-form-message"></span>
            </p>

            <p class="form-row electron-row electron-is-required">
                <label for="account_display_name"><?php esc_html_e( 'Display name', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" aria-required="true" aria-describedby="account_display_name_description" /> <span id="account_display_name_description"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'electron' ); ?></em></span>
                <span class="electron-form-message"></span>
            </p>

            <p class="form-row electron-row electron-is-required">
                <label for="account_email"><?php esc_html_e( 'Email address', 'electron' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" aria-required="true" />
                <span class="electron-form-message"></span>
            </p>

            <?php do_action( 'woocommerce_edit_account_form_fields' ); ?>

            <fieldset>
                <legend><?php esc_html_e( 'Password change', 'electron' ); ?></legend>

                <p class="form-row electron-row">
                    <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'electron' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
                </p>

                <p class="form-row electron-row">
                    <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'electron' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                </p>

                <p class="form-row electron-row">
                    <label for="password_2"><?php esc_html_e( 'Confirm new password', 'electron' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                </p>
            </fieldset>

            <?php do_action( 'woocommerce_edit_account_form' ); ?>

            <p>
                <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
                <button type="submit" class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'electron' ); ?>"><?php esc_html_e( 'Save changes', 'electron' ); ?></button>
                <input type="hidden" name="action" value="save_account_details" />
            </p>

            <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
        </form>

        <?php do_action( 'woocommerce_after_edit_account_form' ); ?>

    </div>
</div>
