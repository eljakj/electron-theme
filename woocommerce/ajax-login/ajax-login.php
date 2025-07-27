<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$electron_options = get_option('electron');

function electron_ajax_login_scripts() {
    //wp_enqueue_script( 'wc-password-strength-meter');
    wp_enqueue_script( 'electron-ajax-login', get_template_directory_uri() . '/woocommerce/assets/js/ajax-login.js', array( 'jquery' ), false, '1.0' );
    wp_localize_script( 'electron-ajax-login', 'electron_ajax_login', array(
        'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' ))
    ));
}
add_action( 'electron_before_login_form', 'electron_ajax_login_scripts' );

/*************************************************
## Ajax Login CallBack
*************************************************/
add_action( 'wp_ajax_nopriv_electron_ajax_login', 'electron_ajax_login_callback' );
add_action( 'wp_ajax_electron_ajax_login', 'electron_ajax_login_callback' );
function electron_ajax_login_callback() {

    if ( is_user_logged_in() ) {
        return;
    }

    if ( !isset($_POST['logindata']) ){
        return;
    }

    parse_str( $_POST['logindata'], $_data );

    try {
        $creds = array(
            'user_login'    => trim( wp_unslash( $_data['username'] ) ),
            'user_password' => $_data['password'],
            'remember'      => isset( $_data['rememberme'] ),
        );

        $validation_error = new WP_Error();
        $validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $creds['user_login'], $creds['user_password'] );

        if ( $validation_error->get_error_code() ) {
            throw new Exception( '<strong>' . esc_html__( 'Error:', 'electron' ) . '</strong> ' . $validation_error->get_error_message() );
        }

        if ( empty( $creds['user_login'] ) ) {
            throw new Exception( '<strong>' . esc_html__( 'Error:', 'electron' ) . '</strong> ' . esc_html__( 'Username is required.', 'electron' ) );
        }

        // On multisite, ensure user exists on current site, if not add them before allowing login.
        if ( is_multisite() ) {
            $user_data = get_user_by( is_email( $creds['user_login'] ) ? 'email' : 'login', $creds['user_login'] );

            if ( $user_data && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
                add_user_to_blog( get_current_blog_id(), $user_data->ID, 'customer' );
            }
        }

        // Perform the login.
        $user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );

        if ( is_wp_error( $user ) ) {
            throw new Exception( $user->get_error_message() );
        } else {

            if ( ! empty( $_data['redirect'] ) ) {
                $redirect = wp_unslash( $_data['redirect'] );
            } elseif ( wc_get_raw_referer() ) {
                $redirect = wc_get_raw_referer();
            } else {
                $redirect = wc_get_page_permalink( 'myaccount' );
            }

            $data = array(
                'redirecturl' => apply_filters( 'woocommerce_login_redirect', remove_query_arg( 'wc_error', $redirect ), $user ), wc_get_page_permalink( 'myaccount' ),
                'message'     => esc_html__( 'Login successful, redirecting...', 'electron' )
            );
            // See also wp_send_json_error() and wp_send_json().
            wp_send_json_success( $data );

            exit;
        }
    } catch ( Exception $e ) {
        if ( $e->getMessage() ) {
            printf( '%s',$e->getMessage() );
            exit;
        }
    }
}

/*************************************************
## Ajax Register CallBack
*************************************************/
add_action( 'wp_ajax_nopriv_electron_ajax_register', 'electron_ajax_register_callback' );
add_action( 'wp_ajax_electron_ajax_register', 'electron_ajax_register_callback' );
function electron_ajax_register_callback() {

    if ( is_user_logged_in() ) {
        return;
    }

    if ( !isset($_POST['registerdata']) ) {
        return;
    }

    parse_str( $_POST['registerdata'], $_data );

    $username = 'no' === get_option( 'woocommerce_registration_generate_username' ) && isset( $_data['username'] ) ? wp_unslash( $_data['username'] ) : '';
    $password = 'no' === get_option( 'woocommerce_registration_generate_password' ) && isset( $_data['password'] ) ? $_data['password'] : '';
    $email    = wp_unslash( $_data['email'] );

    try {
        $validation_error  = new WP_Error();
        $validation_error  = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );
        $validation_errors = $validation_error->get_error_messages();

        if ( 1 === count( $validation_errors ) ) {
            throw new Exception( $validation_error->get_error_message() );
        } elseif ( $validation_errors ) {
            foreach ( $validation_errors as $message ) {
                wc_add_notice( '<strong>' . esc_html__( 'Error:', 'electron' ) . '</strong> ' . $message, 'error' );
            }
            throw new Exception();
        }

        $new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );

        if ( is_wp_error( $new_customer ) ) {
            throw new Exception( $new_customer->get_error_message() );
        }

        if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) ) {
            wc_add_notice( esc_html__( 'Your account was created successfully and a password has been sent to your email address.', 'electron' ) );
        } else {
            wc_add_notice( esc_html__( 'Your account was created successfully. Your login details have been sent to your email address.', 'electron' ) );
        }

        // Only redirect after a forced login - otherwise output a success notice.
        if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
            wc_set_customer_auth_cookie( $new_customer );

            if ( ! empty( $_data['redirect'] ) ) {
                $redirect = wp_sanitize_redirect( wp_unslash( $_data['redirect'] ) );
            } elseif ( wc_get_raw_referer() ) {
                $redirect = wc_get_raw_referer();
            } else {
                $redirect = wc_get_page_permalink( 'myaccount' );
            }

            $data = array(
                'redirecturl' => wc_get_page_permalink( 'myaccount' ),
                'message'     => esc_html__( 'Account created successfully. redirecting...', 'electron' ),
            );
            // See also wp_send_json_error() and wp_send_json().
            wp_send_json_success( $data );

            exit;
        }
    } catch ( Exception $e ) {
        if ( $e->getMessage() ) {
            printf( '%s',$e->getMessage() );
            exit;
        }
    }
}

if ( '1' == $electron_options[ 'wc_ajax_login_custom_roles' ] ) {
    /**
    * Redirect users to custom URL based on their role after login
    */
    add_filter( 'woocommerce_login_redirect', 'electron_wc_custom_redirect_by_role', 10, 2 );
    function electron_wc_custom_redirect_by_role( $redirect, $user )
    {
        $role         = $user->roles[0];
        $redirect_url = electron_settings('wc_ajax_login_redirect_url');
        $redirect_ref = wp_get_referer() ? wp_get_referer() : home_url();
        $redirect_ref = $redirect_url ? esc_url( $redirect_url ) : $redirect_ref;

        $custom_roles = electron_settings('wc_ajax_login_roles');

        if ( $role == 'administrator' && in_array( 'administrator', $custom_roles ) ) {
            $redirect = electron_settings('redirect_url_'.$role);
            $redirect = $redirect ? esc_url( $redirect ) : $redirect_ref;
        } elseif ( $role == 'shop-manager' && in_array( 'shop-manager', $custom_roles ) ) {
            $redirect = electron_settings('redirect_url_'.$role);
            $redirect = $redirect ? esc_url( $redirect ) : $redirect_ref;
        } elseif ( $role == 'editor' && in_array( 'editor', $custom_roles ) ) {
            $redirect = electron_settings('redirect_url_'.$role);
            $redirect = $redirect ? esc_url( $redirect ) : $redirect_ref;
        } elseif ( $role == 'author' && in_array( 'author', $custom_roles ) ) {
            $redirect = electron_settings('redirect_url_'.$role);
            $redirect = $redirect ? esc_url( $redirect ) : $redirect_ref;
        } elseif ( $role == 'customer' && in_array( 'customer', $custom_roles ) ) {
            $redirect = electron_settings('redirect_url_'.$role);
            $redirect = $redirect ? esc_url( $redirect ) : $redirect_ref;
        } elseif ( $role == 'subscriber' && in_array( 'subscriber', $custom_roles ) ) {
            $redirect = electron_settings('redirect_url_'.$role);
            $redirect = $redirect ? esc_url( $redirect ) : $redirect_ref;
        } elseif ( $role == 'contributor' && in_array( 'contributor', $custom_roles ) ) {
            $redirect = electron_settings('redirect_url_'.$role);
            $redirect = $redirect ? esc_url( $redirect ) : $redirect_ref;
        } else {
            $redirect = wp_get_referer() ? wp_get_referer() : home_url();
        }

        return apply_filters( 'electron_wc_login_redirect_url', $redirect );
    }

} else {

    add_filter( 'woocommerce_login_redirect', 'electron_wc_custom_redirect_url' );
    function electron_wc_custom_redirect_url( $redirect )
    {
        $redirect_url = electron_settings('wc_ajax_login_redirect_url');
        $redirect_ref = wp_get_referer() ? wp_get_referer() : home_url();
        $redirect     = $redirect_url ? esc_url( $redirect_url ) : $redirect_ref;

        return apply_filters( 'electron_wc_login_redirect_url', $redirect );
    }
}

if ( !empty( $electron_options[ 'wc_ajax_register_redirect_url' ] ) && '' != $electron_options[ 'wc_ajax_register_redirect_url' ] ) {
    add_filter( 'woocommerce_registration_redirect', 'electron_redirection_after_registration', 10, 1 );
    function electron_redirection_after_registration( $redirection_url )
    {
        $redirect_url    = $electron_options[ 'wc_ajax_register_redirect_url' ];
        $redirect_ref    = wp_get_referer() ? wp_get_referer() : home_url();
        $redirection_url = $redirect_url ? esc_url( $redirect_url ) : $redirect_ref;

        return apply_filters( 'electron_login_register_redirect_url', $redirection_url );
    }
}
