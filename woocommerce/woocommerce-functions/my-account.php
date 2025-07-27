<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$electron_options = get_option('electron');


if ( isset( $electron_options['myaccount_nav_customize'] ) && 'yes' == $electron_options['myaccount_nav_customize'] ) {
    add_filter( 'woocommerce_account_menu_items', 'electron_myaccount_menu_links_reorder', 9999 );
}

if ( ! function_exists( 'electron_myaccount_menu_links_reorder' ) ) {
    function electron_myaccount_menu_links_reorder( $items )
    {
        $nav_items = electron_settings('myaccount_nav_items' );
        $titles = array(
          'dashboard'       => esc_html__( 'Dashboard', 'electron' ),
          'orders'          => esc_html__( 'Orders', 'electron' ),
          'downloads'       => esc_html__( 'Downloads', 'electron' ),
          'edit-address'    => _n( 'Address', 'Addresses', ( 1 + (int) wc_shipping_enabled() ), 'electron' ),
          'payment-methods' => esc_html__( 'Payment methods', 'electron' ),
          'edit-account'    => esc_html__( 'Account details', 'electron' ),
          'customer-logout' => esc_html__( 'Logout', 'electron' ),
          'wishlist'        => esc_html__( 'Wishlist', 'electron' ),
          'compare'         => esc_html__( 'Compare', 'electron' )
        );

        if ( !empty( $nav_items ) ) {
            unset( $items['dashboard'] );
            unset( $items['downloads'] );
            unset( $items['orders'] );
            unset( $items['edit-address'] );
            unset( $items['edit-account'] );
            unset( $items['customer-logout'] );
            unset( $items['wishlist'] );
            unset( $items['compare'] );

            foreach ( $nav_items as $item => $value ) {
                $title    = electron_settings('myaccount_nav_items_title_'.$value );
                $endpoint = trim(electron_settings('myaccount_nav_item_endpoint_'.$value ));
                $endpoint = str_replace(' ', '-', strtolower( $endpoint ) );
                $content  = electron_settings('myaccount_nav_item_content_'.$value );
                $title    = !empty( $title ) ? esc_html( $title ) : $titles[$value];

                if ( !empty( $endpoint ) ) {
                    $items[$endpoint] = $title;
                } elseif ( empty( $endpoint ) && !empty( $title ) ) {
                    $items[$value] = $title;
                } else {
                    $items[$value] = $title;
                }

                add_action('woocommerce_account_' . $endpoint . '_endpoint', function() use ($content) {
                    echo apply_filters( 'the_content',$content);
                });
            }
        }
        return $items;
    }
}

// register permalink endpoint
if ( ! function_exists( 'electron_myaccount_add_endpoint' ) ) {
    add_action( 'init', 'electron_myaccount_add_endpoint' );
    function electron_myaccount_add_endpoint()
    {
        $nav_items = electron_settings('myaccount_nav_items' );
        if ( !empty( $nav_items ) ) {
            foreach ( $nav_items as $item => $value ) {
                $endpoint = trim(electron_settings('myaccount_nav_item_endpoint_'.$value ));
                if ( $endpoint ) {
                    add_rewrite_endpoint( str_replace(' ', '-', strtolower( $endpoint ) ), EP_ROOT | EP_PAGES );
                }
            }
        }
    }
}

function electron_wc_myaccount_query_vars( $vars ) {
    $nav_items = electron_settings('myaccount_nav_items' );
    if ( !empty( $nav_items ) ) {
        foreach ( $nav_items as $item => $value ) {
            $endpoint = trim(electron_settings('myaccount_nav_item_endpoint_'.$value ));
            if ( $endpoint ) {
                $vars[] = str_replace(' ', '-', strtolower( $endpoint ) );
            }
        }
    }
    return $vars;
}
add_filter( 'query_vars', 'electron_wc_myaccount_query_vars', 0 );
