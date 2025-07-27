<?php


if ( ! class_exists( 'Electron_Compare' ) && class_exists( 'WC_Product' ) ) {
    class Electron_Compare {

        private static $instance = null;

        function __construct() {

            // enqueue scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

            // after user login
            add_action( 'wp_login', array( $this, 'set_user_cookie' ), 10, 2 );

            // ajax load compare table
            add_action( 'wp_ajax_electron_add_compare', array( $this, 'load_table' ) );
            add_action( 'wp_ajax_nopriv_electron_add_compare', array( $this, 'load_table' ) );

            add_action( 'wp_ajax_electron_load_compare_table', array( $this, 'load_compare_table' ) );
            add_action( 'wp_ajax_nopriv_electron_load_compare_table', array( $this, 'load_compare_table' ) );

            add_shortcode( 'electron_compare', array( $this, 'get_compare_table' ) );
        }

        public function enqueue_scripts() {
            $ot = get_option('electron');
            $pageId = isset($ot['compare_page_id']) ? $ot['compare_page_id'] : '';
            wp_enqueue_script( 'electron-compare', ELECTRON_PLUGIN_URL . 'assets/front/js/compare/compare.js', array( 'jquery' ), ELECTRON_PLUGIN_VERSION, true );

            wp_localize_script( 'electron-compare', 'compare_vars', array(
                'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                'limit'         => isset($ot['compare_max_count']) ? $ot['compare_max_count'] : 100,
                'notice'        => esc_html__( 'You can add a maximum of {max_limit} products to the compare table.', 'electron' ),
                'empty'         => esc_html__( 'There are no products on the compare!', 'electron' ),
                'inlist'        => esc_html__( '{name} is already in the Compare list.', 'electron' ),
                'added'         => esc_html__( '{name} has been added to Compare list.', 'electron' ),
                'removed'       => esc_html__( '{name} has been removed from the Compare list.', 'electron' ),
                'count'         => self::get_count(),
                'nonce'         => wp_create_nonce( 'electron-compare-nonce' ),
                'user_id'       => md5( 'electron' . get_current_user_id() ),
                'products'      => self::get_products_ids(),
                'btn_action'    => isset($ot['compare_btn_action']) ? $ot['compare_btn_action'] : 'message',
                'header_action' => isset($ot['header_compare_btn_action']) ? $ot['header_compare_btn_action'] : 'page',
                'compare_page'  => get_the_ID() == $pageId ? 'yes' : 'no',
                'page_url'      => $pageId ? get_page_link($pageId) : ''
            ));
        }

        public function set_user_cookie( $user_login, $user ) {
            if ( isset( $user->data->ID ) ) {
                $user_products = get_user_meta( $user->data->ID, 'electron_products', true );
                $user_fields   = get_user_meta( $user->data->ID, 'electron_fields', true );

                if ( ! empty( $user_products ) ) {
                    setcookie( 'electron_products_' . md5( 'electron' . $user->data->ID ), $user_products, time() + 604800, '/' );
                }

                if ( ! empty( $user_fields ) ) {
                    setcookie( 'electron_fields_' . md5( 'electron' . $user->data->ID ), $user_fields, time() + 604800, '/' );
                }
            }
        }

        public function load_table() {
            self::get_compare();
            wp_die();
        }

        public static function get_cookie()
        {
            $products = array();
            if ( isset( $_POST['products'] ) && ( $_POST['products'] !== '' ) ) {
                $products = explode( ',', $_POST['products'] );
            } else {
                $cookie = 'electron_products_' . md5( 'electron' . get_current_user_id() );

                if ( isset( $_COOKIE[ $cookie ] ) && ! empty( $_COOKIE[ $cookie ] ) ) {
                    if ( is_user_logged_in() ) {
                        update_user_meta( get_current_user_id(), 'electron_products', $_COOKIE[ $cookie ] );
                    }

                    $products = explode( ',', $_COOKIE[ $cookie ] );
                }
            }
            return $products;
        }

        public static function get_products_ids()
        {
            $ids       = array();
            $products  = self::get_cookie();

            if ( is_array( $products ) && ( count( $products ) > 0 ) ) {

                foreach ( $products as $product ) {
                    $ids[] = $product;
                }
                return $ids;
            }
        }

        public static function get_compare()
        {
            $ot = get_option('electron');
            // get items
            $pdata    = array();
            $products = self::get_cookie();
            $limit    = isset($ot['compare_max_count']) ? $ot['compare_max_count'] : 100;
            $catalog_mode  = isset($ot['woo_catalog_mode']) ? $ot['woo_catalog_mode'] : 0;
            $disable_price = isset($ot['woo_disable_price']) ? $ot['woo_disable_price'] : 0;
            if ( is_array( $products ) && ( count( $products ) > 0 ) ) {
                $pcount = 1;
                foreach ( $products as $p ) {
                    $product = wc_get_product( $p );

                    if ( ! $product ) {
                        continue;
                    }

                    $pdata[$p]['id']    = $product->get_id();
                    $pdata[$p]['link']  = $product->get_permalink();
                    $pdata[$p]['name']  = $product->get_name();
                    $pdata[$p]['image'] = $product->get_image( 'electron-panel', array( 'class' => 'compare-thumb' ) );
                    $pdata[$p]['price'] = $product->get_price_html();
                    $pdata[$p]['stock'] = $product->is_in_stock() ? esc_html__( 'In stock', 'electron' ) : esc_html__( 'Out of stock', 'electron' );

                    $pcount++;

                    if ( $pcount > $limit  ) {
                        break;
                    }
                }

                foreach ( $products_data as $cproduct ) {
                    $imgurl = get_the_post_thumbnail_url($cproduct['id'],'electron-panel');
                    $imgsrc = $imgurl ? $imgurl : wc_placeholder_img_src();
                    $img    = '<img width="80" height="80" src="'.$imgsrc.'" alt="'.esc_html( $cproduct['name'] ).'"/>';
                    ?>
                    <div class="electron-compare-item" data-id="<?php echo esc_attr( $cproduct['id'] ); ?>">
                        <div class="inner">
                            <?php printf( '<a href="%s">%s</a>',esc_url( $cproduct['link'] ), $img ); ?>
                            <div class="electron-content-info">
                                <div class="electron-small-title">
                                    <a class="electron-content-link" data-id="<?php echo esc_attr( $cproduct['id'] ); ?>" href="<?php echo esc_url( $cproduct['link'] ); ?>">
                                        <span class="product-name"><?php echo esc_html( $cproduct['name'] ); ?></span>
                                        <span>
                                            <?php
                                            if ( $cproduct['price'] && '1' != $catalog_mode && '1' != $disable_price ) {
                                                ?>
                                                <span class="product-price electron-price"><?php printf('%s', $cproduct['price'] ); ?></span> /
                                            <?php } ?>
                                            <span class="product-stock electron-stock"> <?php echo esc_html( $cproduct['stock'] ); ?></span>
                                        </span>
                                    </a>
                                </div>
                                <?php echo electron_add_to_cart('text',$cproduct['id']); ?>
                            </div>
                            <div class="electron-content-del-icon electron-compare-del-icon" data-id="<?php echo esc_attr( $cproduct['id'] ); ?>"><?php echo electron_svg_lists( 'trash', 'electron-svg-icon mini-icon' ); ?></div>
                        </div>
                    </div>
                    <?php
                }
            }
        }

        public static function get_compare_table()
        {
            $defaults = array(
                'image'        => 0,
                'price'        => 0,
                'sku'          => 0,
                'rating'       => 0,
                'stock'        => 0,
                'desc'         => 0,
                'content'      => 0,
                'weight'       => 0,
                'dimensions'   => 0,
                'additional'   => 0,
                'availability' => 0,
                'cart'         => 0
            );
            wp_enqueue_style( 'electron-compare' );
            // get items

            $ot = get_option('electron');
            $pdata    = array();
            $products = self::get_cookie();
            $url      = !is_shop() ? apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) : '#0';
            $limit    = isset($ot['compare_max_count']) ? $ot['compare_max_count'] : 5;
            $table    = isset($ot['compare_table']) ? $ot['compare_table'] : null;
            $table    = !empty($table) ? $table : $defaults;

            if ( is_array( $products ) && ( count( $products ) > 0 ) ) {
                $pcount = 1;
                foreach ( $products as $p ) {
                    $product = wc_get_product( $p );

                    if ( ! $product ) {
                        continue;
                    }

                    $pdata[$p]['id']           = $product->get_id();
                    $pdata[$p]['link']         = $product->get_permalink();
                    $pdata[$p]['name']         = $product->get_name();
                    $pdata[$p]['image']        = $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'compare-thumb' ) );
                    $pdata[$p]['price']        = $product->get_price_html();
                    $pdata[$p]['content']      = $product->get_description();
                    $pdata[$p]['desc']         = $product->get_short_description();
                    $pdata[$p]['sku']          = $product->get_sku();
                    $pdata[$p]['weight']       = wc_format_weight( $product->get_weight() );
                    $pdata[$p]['dimensions']   = wc_format_dimensions( $product->get_dimensions( false ) );
                    $pdata[$p]['rating']       = wc_get_rating_html( $product->get_average_rating() );
                    $pdata[$p]['availability'] = $product->get_availability();
                    $pdata[$p]['additional']   = $product->get_attributes();
                    $pdata[$p]['stock']        = $product->is_in_stock() ? esc_html__( 'In stock', 'electron' ) : esc_html__( 'Out of stock', 'electron' );

                    $pcount++;

                    if ( $pcount > $limit  ) {
                        break;
                    }
                }

                $placeholder     = wc_placeholder_img('woocommerce_thumbnail');
                $placeholder_src = wc_placeholder_img_src('woocommerce_thumbnail');
                $count           = count( $products );
                $placeholder_td  = $html = '';

                if ( $count < 3 && $count == 2 ) {
                    $placeholder_td = '</td><td class="td-placeholder"></td>';
                } elseif ( $count < 3 && $count == 1 ) {
                    $placeholder_td = '<td class="td-placeholder"></td><td class="td-placeholder"></td>';
                }

                $html .= '<table class="table table-striped">';
                    $html .= '<thead>';
                        $html .= '<tr>';
                            $html .= '<th>Name</th>';
                            foreach ( $pdata as $cp ) {
                                $icon = '<div class="electron-compare-del-icon" data-id="'.$cp['id'].'">'.electron_svg_lists( 'trash', 'electron-svg-icon mini-icon' ).'</div>';
                                $cart = '1' == $table['cart'] ? electron_add_to_cart('text',$cp['id']) : '';
                                $html .= '<th data-id="'.$cp['id'].'"><a class="name" href="'.esc_url( $cp['link'] ).'">'.$cp['name'].'</a>'.$cart.$icon.'</th>';
                            }
                            if ( $count < 3 && $count == 2 ) {
                                $html .= '<th class="th-placeholder"></th>';
                            } elseif ( $count < 3 && $count == 1 ) {
                                $html .= '<th class="th-placeholder"></th><th class="th-placeholder"></th>';
                            }
                        $html .= '</tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                        if ( '1' == $table['image'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Image', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td class="image" data-id="'.$cp['id'].'"><a href="'.esc_url( $cp['link'] ).'">'.$cp['image'].'</a></td>';
                                }
                                if ( $count < 3 && $count == 2 ) {
                                    $html .= '<td class="placeholder-image">'.$placeholder.'</td>';
                                } elseif ( $count < 3 && $count == 1 ) {
                                    $html .= '<td class="placeholder-image">'.$placeholder.'</td><td class="placeholder-image">'.$placeholder.'</td>';
                                }
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['price'] ) && '1' == $table['price'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Price', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'" class="electron-price">'.$cp['price'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['sku'] ) && '1' == $table['sku'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'SKU', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['sku'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['stock'] ) && '1' == $table['stock'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Stock Status', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['stock'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['rating'] ) && '1' == $table['rating'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Rating', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['rating'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['desc'] ) && '1' == $table['desc'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Description', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['desc'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['content'] ) && '1' == $table['content'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Content', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['content'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['weight'] ) && '1' == $table['weight'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Weight', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['weight'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['dimensions'] ) && '1' == $table['dimensions'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Dimensions', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['dimensions'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['availability'] ) && '1' == $table['availability'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Availability', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $html .= '<td data-id="'.$cp['id'].'">'.$cp['availability']['availability'].'</td>';
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                        if ( !empty( $pdata[$p]['additional'] ) && '1' == $table['additional'] ) {
                            $html .= '<tr>';
                                $html .= '<td>'.esc_html__( 'Additional information', 'electron' ).'</td>';
                                foreach ( $pdata as $cp ) {
                                    $product = wc_get_product( $cp['id'] );
                                    ob_start();
                                    wc_display_product_attributes( $product );
                                    $additional = ob_get_clean();
                                    $html .= sprintf( '<td data-id="'.$cp['id'].'">%s</td>', $additional );
                                }
                                $html .= $placeholder_td;
                            $html .= '</tr>';
                        }
                    $html .= '</tbody>';
                $html .= '</table>';
                $html .= '<div class="electron-empty-content">';
                    $html .= electron_svg_lists( 'compare', 'electron-big-svg-icon' );
                    $html .= '<div class="electron-small-title">'.esc_html__( 'No product is added to the compare list!', 'electron' ).'</div>';
                    $html .= '<a class="electron-btn-small mt-10" href="'.esc_url( $url ).'">'.esc_html__( 'Start Shopping', 'electron' ).'</a>';
                $html .= '</div>';

                echo '<div class="electron-compare-items container" data-count="'.count( $products ).'" data-placeholder="'.$placeholder_src.'">'.$html.'</div>';
            } else {
                echo '<div class="electron-compare-items electron-empty-content no-product">';
                    echo electron_svg_lists( 'compare', 'electron-big-svg-icon' );
                    echo '<div class="electron-small-title">'.esc_html__( 'No product is added to the compare list!', 'electron' ).'</div>';
                    echo '<a class="electron-btn-small mt-10" href="'.esc_url( $url ).'">'.esc_html__( 'Start Shopping', 'electron' ).'</a>';
                echo '</div>';
            }
        }

        public static function load_compare_table()
        {
            $ot = get_option('electron');
            $btn_action  = isset($ot['compare_btn_action']) ? $ot['compare_btn_action'] : 'message';
            $hbtn_action = isset($ot['header_compare_btn_action']) ? $ot['header_compare_btn_action'] : 'page';
            if ( 'popup' == $btn_action || 'popup' == $hbtn_action ) {
                echo self::get_compare_table();
            }
            wp_die();
        }

        public static function get_count()
        {
            $products = array();

            if ( isset( $_POST['products'] ) && ( $_POST['products'] !== '' ) ) {
                $products = explode( ',', $_POST['products'] );
            } else {
                $cookie = 'electron_products_' . md5( 'electron' . get_current_user_id() );
                if ( isset( $_COOKIE[ $cookie ] ) && ! empty( $_COOKIE[ $cookie ] ) ) {
                    $products = explode( ',', $_COOKIE[ $cookie ] );
                }
            }

            return count( $products );
        }

        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    }
    Electron_Compare::get_instance();
}
