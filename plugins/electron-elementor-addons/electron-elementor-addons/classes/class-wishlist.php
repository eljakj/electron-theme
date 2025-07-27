<?php
/**
* Electron_Wishlist
*/
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
if ( ! class_exists( 'Electron_Wishlist' ) ) {
    class Electron_Wishlist {
        private static $instance = null;
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        function __construct()
        {
            if ( ! class_exists('WooCommerce') ) {
                return;
            }
            $settings = get_option('electron');
            // add query var
            add_filter( 'query_vars', [ $this, 'query_vars' ], 1 );
            add_action( 'init', [ $this, 'init' ] );

            // my account
            if ( isset($settings['wishlist_page_myaccount']) && '1' == $settings['wishlist_page_myaccount'] ) {
                add_filter( 'woocommerce_account_menu_items', [ $this, 'account_items' ], 99 );
                add_action( 'woocommerce_account_wishlist_endpoint', [ $this, 'account_endpoint' ], 99 );
            }
            // frontend scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
            // add wishlist
            add_action( 'wp_ajax_electron_wishlist_add', array( $this, 'wishlist_add' ) );
            add_action( 'wp_ajax_nopriv_electron_wishlist_add', array( $this, 'wishlist_add' ) );
            // remove wishlist
            add_action( 'wp_ajax_electron_wishlist_remove', array( $this, 'wishlist_remove' ) );
            add_action( 'wp_ajax_nopriv_electron_wishlist_remove', array( $this, 'wishlist_remove' ) );
            // clear all wishlist
            add_action( 'wp_ajax_electron_wishlist_clear', array( $this, 'wishlist_clear' ) );
            add_action( 'wp_ajax_nopriv_electron_wishlist_clear', array( $this, 'wishlist_clear' ) );

            // user login & logout
            add_action( 'wp_login', array( $this, 'wishlist_wp_login' ), 10, 2 );
            add_action( 'wp_logout', array( $this, 'wishlist_wp_logout' ), 10, 1 );

            add_shortcode( 'electron_wishlist', [ $this, 'template_wishlist_page' ] );
        }

        function wp_enqueue_scripts()
        {
            // localize
            $ot        = get_option('electron');
            $unauthenticated = isset($ot['wishlist_disable_unauthenticated']) ? $ot['wishlist_disable_unauthenticated'] : '0';
            $page_id         = isset($ot['wishlist_page_id']) ? $ot['wishlist_page_id'] : '';
            $max_count       = isset($ot['wishlist_max_count']) ? $ot['wishlist_max_count'] : '';

            $is_login = ! is_user_logged_in() && '1' == $unauthenticated ? 'yes' : 'no';
            wp_enqueue_script( 'electron-wishlist', ELECTRON_PLUGIN_URL . 'assets/front/js/wishlist/wishlist.js', array( 'jquery' ), ELECTRON_PLUGIN_VERSION, true );
            wp_localize_script( 'electron-wishlist', 'wishlist_vars', array(
                'ajax_url'      => admin_url( 'admin-ajax.php' ),
                'count'         => $this->get_count(),
                'max_count'     => $max_count,
                'is_login'      => $is_login,
                'products'      => $this->get_products(),
                'nonce'         => wp_create_nonce( 'electron-wishlist-nonce' ),
                'user_id'       => md5( 'electron_wishlist_' . get_current_user_id() ),
                'wishlist_page' => get_the_ID() == $page_id ? 'yes' : 'no',
                'page_url'      => $page_id ? get_page_link($page_id) : ''
            ));
        }

        function query_vars( $vars ) {
            $vars[] = 'electronwl_id';

            return $vars;
        }
        function init() {
            // get key
            $key = isset( $_COOKIE['electron_wishlist_key'] ) ? sanitize_text_field( $_COOKIE['electron_wishlist_key'] ) : '#';
            $ot        = get_option('electron');
            $page_id   = isset($ot['wishlist_page_id']) ? $ot['wishlist_page_id'] : '';
            $myaccount = isset($ot['wishlist_page_myaccount']) ? $ot['wishlist_page_myaccount'] : '0';
            // rewrite
            if ( $page_id ) {
                $page_slug = get_post_field( 'post_name', $page_id );

                if ( $page_slug !== '' ) {
                    add_rewrite_rule( '^' . $page_slug . '/([\w]+)/?', 'index.php?page_id=' . $page_id . '&electronwl_id=$matches[1]', 'top' );
                    add_rewrite_rule( '(.*?)/' . $page_slug . '/([\w]+)/?', 'index.php?page_id=' . $page_id . '&electronwl_id=$matches[2]', 'top' );
                }
            }

            // my account page
            if ( '1' == $myaccount ) {
                add_rewrite_endpoint( 'wishlist', EP_PAGES );
            }
        }

        function account_items( $items ) {
            if ( isset( $items['customer-logout'] ) ) {
                $logout = $items['customer-logout'];
                unset( $items['customer-logout'] );
            } else {
                $logout = '';
            }

            if ( ! isset( $items['wishlist'] ) ) {
                $items['wishlist'] = apply_filters( 'electron_myaccount_wishlist_label', esc_html__( 'Wishlist', 'electron' ) );
            }

            if ( $logout ) {
                $items['customer-logout'] = $logout;
            }

            return $items;
        }

        function account_endpoint() {
            echo apply_filters( 'electronwl_myaccount_content', do_shortcode( '[electron_wishlist]' ) );
        }

        function template_wishlist_page()
        {
            $ot        = get_option('electron');
            $page_copy = isset($ot['wishlist_page_copy']) ? $ot['wishlist_page_copy'] : '1';
            $key = self::get_key();
            if ( get_query_var( 'electronwl_id' ) ) {
                $key = get_query_var( 'electronwl_id' );
            } else {
                $key = self::get_key();
            }

            $share_url = self::get_url( $key, true );

            $count = $this->get_count();
            $html  = '';
            $icon  = '<svg
            class="svgwishlist electron-svg-icon"
            width="512"
            height="512"
            fill="currentColor"
            viewBox="0 0 32 32"><use href="#shopLove"></use></svg>';
            wp_enqueue_style( 'electron-wishlist' );
            $html .='<div class="wishlist-content wishlist-all-items" data-count="'.$count.'">';
                if ( $count ) {
                    $html .='<div class="electron-wishlist-items">';
                        ob_start();
                        $this->print_wishlist();
                    $html .= ob_get_clean().'</div>';
                    if ( $share_url && '1' == $page_copy ) {
                        $html .='<div class="electron-wishlist-copy">';
                            $html .='<span class="electron-wishlist-copy-label">'.esc_html__( 'Wishlist link:', 'electron' ).'</span> ';
                            $html .='<span class="electron-wishlist_copy_url"><input id="electron-wishlist_copy_url" type="url" value="'.esc_attr( $share_url ).'" readonly/></span>';
                            $html .=' <span class="electron-wishlist_copy_btn"><input id="electron-wishlist_copy_btn" type="button" value="'.esc_attr__( 'Copy', 'electron' ).'"/></span>';
                        $html .='</div>';
                    }
                }
                $html .='<div class="wishlist-empty-content">';
                    $html .= $icon;
                    $html .='<div class="empty-text">'.esc_html__( 'There are no products on the wishlist!', 'electron' ).'</div>';
                    $html .='<a class="electron-btn electron-btn-primary shop-link" href="'.esc_url( wc_get_page_permalink( 'shop' ) ).'">'.esc_html__( 'Start Shopping', 'electron' ).'</a>';
                $html .='</div>';
            $html .='</div>';
            return $html;
        }

        function print_wishlist()
        {
            $ot        = get_option('electron');
            $catalog_mode  = isset($ot['woo_catalog_mode']) ? $ot['woo_catalog_mode'] : '0';
            $disable_price = isset($ot['woo_disable_price']) ? $ot['woo_disable_price'] : '0';
            $key      = self::get_key();
            $products = get_option( 'electron_wishlist_' . $key );
            $icon     = '<svg
            class="svgTrash electron-svg-icon mini-icon"
            height="427pt"
            viewBox="-40 0 427 427.00131"
            width="427pt"
            xmlns="http://www.w3.org/2000/svg"><use href="#shopTrash"></use></svg>';

            if ( is_array( $products ) && ( count( $products ) > 0 ) ) {

                foreach ( $products as $pid => $product_data ) {
                    $product = wc_get_product( $pid );

                    if ( ! $product ) {
                        continue;
                    }
                    $status = $product->get_stock_status();
                    $stock  = $product->get_stock_quantity();
                    $name   = $product->get_name();
                    $price  = $product->get_price_html();
                    $link   = $product->get_permalink();
                    $imgurl = get_the_post_thumbnail_url($pid,'thumbnail');
                    $imgsrc = $imgurl ? $imgurl : wc_placeholder_img_src();
                    $img    = '<img width="80" height="80" src="'.$imgsrc.'" alt="'.$name.'"/>';
                    ?>
                    <div class="electron-wishlist-item" data-id="<?php echo esc_attr( $pid ); ?>" data-key="<?php echo esc_attr( $key ); ?>">
                        <?php
                        echo sprintf( '<a href="%s">%s</a>',
                            esc_url( $link ),
                            $img
                        );
                        ?>
                        <div class="info">
                            <a class="product-link" href="<?php echo esc_url( $link ); ?>">
                                <h6 class="product-name"><?php echo esc_html( $name ); ?></h6>
                            </a>

                            <?php
                            if ( $price && '1' != $catalog_mode && '1' != $disable_price ) {
                                printf('<span class="electron-price">%s</span>', $price );
                            }

                            echo electron_add_to_cart('text',$pid);
                            ?>
                        </div>
                        <div class="electron-wishlist-del-icon"><?php printf('%s', $icon ); ?></div>
                    </div>
                    <?php
                }
            }
        }

        function wishlist_add()
        {
            $return = array( 'status' => 0 );
            $product_id = absint( $_POST['product_id'] );
            if ( $product_id > 0 ) {
                $key = self::get_key();

                if ( $key === '#' ) {
                    $return['status'] = 0;
                } else {
                    $products = get_option( 'electron_wishlist_' . $key ) ? get_option( 'electron_wishlist_' . $key ) : array();
                    $product  = wc_get_product( $product_id );

                    if ( ! array_key_exists( $product_id, $products ) ) {
                        $products = array(
                            $product_id => array('time' => time() )
                        ) + $products;

                        update_option( 'electron_wishlist_' . $key, $products );
                        $this->update_meta( $product_id, 'electron_wishlist_add' );

                        $return['notice'] = 'added';
                    }

                    $return['status']   = 1;
                    $return['count']    = count( $products );
                    $return['products'] = $products;
                }
            } else {
                $product_id       = 0;
                $return['status'] = 0;
                $return['notice'] = 'error';
            }

            echo json_encode( $return );
            die();
        }

        function wishlist_remove()
        {
            $return = array( 'status' => 0 );
            $pid    = absint( $_POST['pid'] );

            if ( $pid > 0 ) {
                $key = self::get_key();

                if ( $key === '#' ) {
                    $return['notice'] = 'login';
                } else {

                    $products = get_option( 'electron_wishlist_' . $key ) ? get_option( 'electron_wishlist_' . $key ) : array();

                    if ( array_key_exists( $pid, $products ) ) {
                        unset( $products[ $pid ] );
                        update_option( 'electron_wishlist_' . $key, $products );
                        $this->update_meta( $pid, 'electron_wishlist_remove' );
                        $return['count']  = count( $products );
                        $return['status'] = 1;

                        if ( count( $products ) > 0 ) {
                            $return['notice'] = 'removed';
                        } else {
                            $return['notice'] = 'empty';
                        }
                    }
                }
            } else {
                $pid = 0;
                $return['notice'] = 'error';
            }

            echo json_encode( $return );
            die();
        }

        function update_meta( $product_id, $action = 'electron_wishlist_add' )
        {
            $meta_count = 'electron_wishlist_count';
            $count      = get_post_meta( $product_id, $meta_count, true );
            $new_count  = 0;

            if ( $action === 'electron_wishlist_add' ) {
                if ( $count ) {
                    $new_count = absint( $count ) + 1;
                } else {
                    $new_count = 1;
                }
            } elseif ( $action === 'electron_wishlist_remove' ) {
                if ( $count && ( absint( $count ) > 1 ) ) {
                    $new_count = absint( $count ) - 1;
                } else {
                    $new_count = 0;
                }
            } elseif ( $action === 'electron_wishlist_clear' ) {
                if ( $count && ( absint( $count ) > 1 ) ) {
                    $new_count = absint( $count ) - 1;
                } else {
                    $new_count = 0;
                }
            }

            update_post_meta( $product_id, $meta_count, $new_count );
            update_post_meta( $product_id, $action, time() );
        }

        public function wishlist_wp_login( $user_login, $user ) {
            if ( isset( $user->data->ID ) ) {
                $user_key = get_user_meta( $user->data->ID, 'electron_wishlist_key', true );

                if ( empty( $user_key ) ) {
                    $user_key = self::generate_key();

                    while ( self::exists_key( $user_key ) ) {
                        $user_key = self::generate_key();
                    }

                    // set a new key
                    update_user_meta( $user->data->ID, 'electron_wishlist_key', $user_key );
                }

                $secure   = apply_filters( 'electron_wishlist_cookie_secure', wc_site_is_https() && is_ssl() );
                $httponly = apply_filters( 'electron_wishlist_cookie_httponly', true );

                if ( isset( $_COOKIE['electron_wishlist_key'] ) && ! empty( $_COOKIE['electron_wishlist_key'] ) ) {
                    wc_setcookie( 'electron_wishlist_key_ori', $_COOKIE['electron_wishlist_key'], time() + 604800, $secure, $httponly );
                }

                wc_setcookie( 'electron_wishlist_key', $user_key, time() + 604800, $secure, $httponly );
            }
        }

        public function wishlist_wp_logout( $user_id ) {
            if ( isset( $_COOKIE['electron_wishlist_key_ori'] ) && ! empty( $_COOKIE['electron_wishlist_key_ori'] ) ) {
                $secure   = apply_filters( 'electron_wishlist_cookie_secure', wc_site_is_https() && is_ssl() );
                $httponly = apply_filters( 'electron_wishlist_cookie_httponly', true );

                wc_setcookie( 'electron_wishlist_key', $_COOKIE['electron_wishlist_key_ori'], time() + 604800, $secure, $httponly );
            } else {
                unset( $_COOKIE['electron_wishlist_key_ori'] );
                unset( $_COOKIE['electron_wishlist_key'] );
            }
        }

        public static function generate_key()
        {
            $key         = '';
            $key_str     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $key_str_len = strlen( $key_str );

            for ( $i = 0; $i < 6; $i ++ ) {
                $key .= $key_str[ random_int( 0, $key_str_len - 1 ) ];
            }

            return $key;
        }

        public static function get_key()
        {
            $ot        = get_option('electron');
            $unauthenticated  = isset($ot['wishlist_disable_unauthenticated']) ? $ot['wishlist_disable_unauthenticated'] : '0';
            if ( ! is_user_logged_in() && '1' == $unauthenticated  ) {
                return '#';
            }

            if ( is_user_logged_in() && ( ( $user_id = get_current_user_id() ) > 0 ) ) {
                $user_key = get_user_meta( $user_id, 'electron_wishlist_key', true );

                if ( empty( $user_key ) ) {
                    $user_key = self::generate_key();

                    while ( self::exists_key( $user_key ) ) {
                        $user_key = self::generate_key();
                    }

                    // set a new key
                    update_user_meta( $user_id, 'electron_wishlist_key', $user_key );
                }

                return $user_key;
            }

            if ( isset( $_COOKIE['electron_wishlist_key'] ) ) {
                return esc_attr( $_COOKIE['electron_wishlist_key'] );
            }

            return 'STYLERWL';
        }

        public static function exists_key( $key )
        {
            return get_option( 'electron_list_' . $key ) ? true : false;
        }

        public static function get_ids( $key = null ) {
            if ( ! $key ) {
                $key = self::get_key();
            }

            return (array) get_option( 'electron_list_' . $key, [] );
        }

        public static function get_url( $key = null, $full = false ) {
            $url      = home_url( '/' );
            $ot       = get_option('electron');
            $page_id  = isset($ot['wishlist_page_id']) ? $ot['wishlist_page_id'] : '';
            if ( $page_id ) {
                if ( $full ) {
                    if ( ! $key ) {
                        $key = self::get_key();
                    }

                    if ( get_option( 'permalink_structure' ) !== '' ) {
                        $url = trailingslashit( get_permalink( $page_id ) ) . $key;
                    } else {
                        $url = get_permalink( $page_id ) . '&electronwl_id=' . $key;
                    }
                } else {
                    $url = get_permalink( $page_id );
                }
            }

            return esc_url( apply_filters( 'electron_wishlist_url', $url, $key, $full ) );
        }

        public static function get_count( $key = null )
        {
            if ( ! $key ) {
                $key = self::get_key();
            }
            $products = get_option( 'electron_wishlist_' . $key );

            if ( ( $key != '' ) && $products && is_array( $products ) ) {
                $count = count( $products );
            } else {
                $count = 0;
            }

            return $count;
        }

        public static function get_products( $key = null )
        {
            if ( ! $key ) {
                $key = self::get_key();
            }
            $products = get_option( 'electron_wishlist_' . $key );
            $ids = array();
            if ( ( $key != '' ) && $products && is_array( $products ) ) {
                foreach ( $products as $key => $id ) {
                    $ids[] = $key;
                }
                return $ids;
            }
        }
    }
    Electron_Wishlist::get_instance();
}
