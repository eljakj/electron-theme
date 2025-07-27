<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$electron_options = get_option('electron');


if ( !function_exists( 'electron_remove_some_fields_checkout' ) ) {
    add_filter( 'woocommerce_checkout_fields' , 'electron_remove_some_fields_checkout' );
    function electron_remove_some_fields_checkout($fields)
    {
        if ( 'no' == electron_settings( 'checkout_form_customize', 'no' ) ) {
            return $fields;
        }
        
        $layouts  = electron_settings( 'checkout_form_layouts' );
        
        // billing fields
        if ( '0' == $layouts['billing_first_name'] ) {
            unset( $fields['billing']['billing_first_name'] );
        }
        if ( '0' == $layouts['billing_last_name'] ) {
            unset( $fields['billing']['billing_last_name'] );
        }
        if ( '0' == $layouts['billing_company'] ) {
            unset( $fields['billing']['billing_company'] );
        }
        if ( '0' == $layouts['billing_address_1'] ) {
            unset( $fields['billing']['billing_address_1'] );
        }
        if ( '0' == $layouts['billing_address_2'] ) {
            unset( $fields['billing']['billing_address_2'] );
        }
        if ( '0' == $layouts['billing_city'] ) {
            unset( $fields['billing']['billing_city'] );
        }
        if ( '0' == $layouts['billing_postcode'] ) {
            unset( $fields['billing']['billing_postcode'] );
        }
        if ( '0' == $layouts['billing_country'] ) {
            unset( $fields['billing']['billing_country'] );
        }
        if ( '0' == $layouts['billing_state'] ) {
            unset( $fields['billing']['billing_state'] );
        }
        if ( '0' == $layouts['billing_phone'] ) {
            unset( $fields['billing']['billing_phone'] );
        }
        if ( '0' == $layouts['billing_email'] ) {
            unset( $fields['billing']['billing_email'] );
        }
        // order field
        if ( '0' == $layouts['order_comments'] ) {
            unset( $fields['order']['order_comments'] );
        }
        // account fields
        if ( '0' == $layouts['account_username'] ) {
            unset( $fields['account']['account_username'] );
        }
        if ( '0' == $layouts['account_password'] ) {
            unset( $fields['account']['account_password'] );
        }
        if ( '0' == $layouts['account_password-2'] ) {
            unset( $fields['account']['account_password-2'] );
        }
        // shipping fields
        if ( '0' == $layouts['shipping_first_name'] ) {
            unset( $fields['shipping']['shipping_first_name'] );
        }
        if ( '0' == $layouts['shipping_last_name'] ) {
            unset( $fields['shipping']['shipping_last_name'] );
        }
        if ( '0' == $layouts['shipping_company'] ) {
            unset( $fields['shipping']['shipping_company'] );
        }
        if ( '0' == $layouts['shipping_address_1'] ) {
            unset( $fields['shipping']['shipping_address_1'] );
        }
        if ( '0' == $layouts['shipping_address_2'] ) {
            unset( $fields['shipping']['shipping_address_2'] );
        }
        if ( '0' == $layouts['shipping_city'] ) {
            unset( $fields['shipping']['shipping_city'] );
        }
        if ( '0' == $layouts['shipping_postcode'] ) {
            unset( $fields['shipping']['shipping_postcode'] );
        }
        if ( '0' == $layouts['shipping_country'] ) {
            unset( $fields['shipping']['shipping_country'] );
        }
        if ( '0' == $layouts['shipping_state'] ) {
            unset( $fields['shipping']['shipping_state'] );
        }
        
        return $fields;
    }
}

if ( !function_exists( 'electron_remove_requirement_from_fields_checkout' ) ) {
    add_filter( 'woocommerce_billing_fields', 'electron_remove_requirement_from_fields_checkout', 10, 1 );
    function electron_remove_requirement_from_fields_checkout($fields)
    {
        if ( 'no' == electron_settings( 'checkout_form_customize', 'no' ) ) {
            return $fields;
        }
        
        $required = electron_settings( 'checkout_form_required_fields_layouts' );
        
        // billing fields
        if ( '0' == $required['billing_first_name'] && isset( $fields['billing_first_name'] ) ) {
            $fields['billing_first_name']['required'] = false;
        }
        if ( '0' == $required['billing_last_name'] && isset( $fields['billing_last_name'] ) ) {
            $fields['billing_last_name']['required'] = false;
        }
        if ( '1' == $required['billing_company'] && isset( $fields['billing_company'] ) ) {
            $fields['billing_company']['required'] = true;
        }
        if ( '0' == $required['billing_address_1'] && isset( $fields['billing_address_1'] ) ) {
            $fields['billing_address_1']['required'] = false;
        }
        if ( '1' == $required['billing_address_2'] && isset( $fields['billing_address_2'] ) ) {
            $fields['billing_address_2']['required'] = true;
        }
        if ( '0' == $required['billing_city'] && isset( $fields['billing_city'] ) ) {
            $fields['billing_city']['required'] = false;
        }
        if ( '0' == $required['billing_postcode'] && isset( $fields['billing_postcode'] ) ) {
            $fields['billing_postcode']['required'] = false;
        }
        if ( '0' == $required['billing_country'] && isset( $fields['billing_country'] ) ) {
            $fields['billing_country']['required'] = false;
        }
        if ( '0' == $required['billing_state'] && isset( $fields['billing_state'] ) ) {
            $fields['billing_state']['required'] = false;
        }
        if ( '0' == $required['billing_phone'] && isset( $fields['billing_phone'] ) ) {
            $fields['billing_phone']['required'] = false;
        }
        if ( '0' == $required['billing_email'] && isset( $fields['billing_email'] ) ) {
            $fields['billing_email']['required'] = false;
        }
        
        return $fields;
    }
}

if ( !function_exists( 'electron_remove_requirement_shipping_from_fields_checkout' ) ) {
    add_filter( 'woocommerce_shipping_fields', 'electron_remove_requirement_shipping_from_fields_checkout', 10, 1 );
    function electron_remove_requirement_shipping_from_fields_checkout($fields)
    {
        if ( 'no' == electron_settings( 'checkout_form_customize', 'no' ) ) {
            return $fields;
        }
        
        $required = electron_settings( 'checkout_form_required_fields_layouts' );
        
        // shipping fields
        if ( '0' == $required['shipping_first_name'] && isset( $fields['shipping_first_name'] ) ) {
            $fields['shipping_first_name']['required'] = false;
        }
        if ( '0' == $required['shipping_last_name'] && isset( $fields['shipping_last_name'] ) ) {
            $fields['shipping_last_name']['required'] = false;
        }
        if ( '1' == $required['shipping_company'] && isset( $fields['shipping_company'] ) ) {
            $fields['shipping_company']['required'] = true;
        }
        if ( '0' == $required['shipping_address_1'] && isset( $fields['shipping_address_1'] ) ) {
            $fields['shipping_address_1']['required'] = false;
        }
        if ( '1' == $required['shipping_address_2'] && isset( $fields['shipping_address_2'] ) ) {
            $fields['shipping_company']['required'] = true;
        }
        if ( '0' == $required['shipping_city'] && isset( $fields['shipping_city'] ) ) {
            $fields['shipping_city']['required'] = false;
        }
        if ( '0' == $required['shipping_postcode'] && isset( $fields['shipping_postcode'] ) ) {
            $fields['shipping_postcode']['required'] = false;
        }
        if ( '0' == $required['shipping_country'] && isset( $fields['shipping_country'] ) ) {
            $fields['shipping_country']['required'] = false;
        }
        if ( '0' == $required['shipping_state'] && isset( $fields['shipping_state'] ) ) {
            $fields['shipping_state']['required'] = false;
        }
        
        return $fields;
    }
}
