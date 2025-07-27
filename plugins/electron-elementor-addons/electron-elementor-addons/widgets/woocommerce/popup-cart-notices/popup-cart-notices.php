<?php

if ( ! class_exists( 'ElectronWooCartNotice' ) && class_exists( 'WC_Product' ) ) {
    class ElectronWooCartNotice {
        function __construct() {
            // frontend scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'electroncn_enqueue_scripts' ) );
            // add the time
            add_action( 'woocommerce_add_to_cart', array( $this, 'electroncn_add_to_cart' ), 10 );
            // fragments
            add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'electroncn_cart_fragment' ) );
            // footer
            add_action( 'wp_footer', array( $this, 'electroncn_footer' ) );
        }
        function electroncn_enqueue_scripts() {

            wp_enqueue_script( 'electroncn-frontend', ELECTRON_PLUGIN_URL . 'widgets/woocommerce/popup-cart-notices/script.js', array( 'jquery' ), ELECTRON_PLUGIN_VERSION, true );
        }

        function electroncn_get_product() {
            $items = WC()->cart->get_cart();
            $html  = '<div class="electron-popup-notices">';

            if ( count( $items ) > 0 ) {
                foreach ( $items as $key => $item ) {
                    if ( ! isset( $item['electron_popup_notices_time'] ) ) {
                        $items[ $key ]['electron_popup_notices_time'] = time() - 10000;
                    }
                }
                
                array_multisort( array_column( $items, 'electron_popup_notices_time' ), SORT_ASC, $items );
                $electron_product = end( $items )['data'];

                if ( $electron_product && ( $electron_product_id = $electron_product->get_id() ) ) {
                    if ( ! in_array( $electron_product_id, apply_filters( 'electron_exclude_ids', array( 0 ) ), true ) ) {
                        $html .= '<div class="electron-text">' . sprintf( esc_html__( '%s was added to the cart.', 'electron' ), '<a href="' . $electron_product->get_permalink() . '" target="_blank">' . $electron_product->get_name() . '</a>' ) . '</div>';
                        $cart_content_data = '<span class="electron-popup-cart-content-total">' . wp_kses_post( WC()->cart->get_cart_subtotal() ) . '</span> <span class="electron-cart-content-count">' . wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'electron' ), WC()->cart->get_cart_contents_count() ) ) . '</span>';
                        $cart_content = sprintf( esc_html__( 'Your cart: %s', 'electron' ), $cart_content_data );
                        $html .= '<div class="electron-cart-content">' . $cart_content . '</div>';
                    }
                }
            }

            $html .= '</div>';

            return $html;
        }

        function electroncn_add_to_cart( $cart_item_key ) {

            WC()->cart->cart_contents[ $cart_item_key ]['electron_popup_notices_time'] = time();

        }

        function electroncn_cart_fragment( $fragments ) {
            $fragments['.electron-popup-notices'] = $this->electroncn_get_product();

            return $fragments;
        }

        function electroncn_footer() {
            echo '<div class="electron-popup-notices"></div>';
        }
    }
    new ElectronWooCartNotice();
}
