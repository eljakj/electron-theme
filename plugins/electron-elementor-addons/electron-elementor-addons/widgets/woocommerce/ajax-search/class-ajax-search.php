<?php
/**
* Main class
*
* @author Electron
* @package Electron WooCommerce Ajax Search
* @version 1.0.0
*/
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
if ( ! class_exists( 'Electron_Wc_As' ) ) {
    /**
    * Electron WooCommerce Ajax Search
    *
    * @since 1.0.0
    */
    class Electron_Wc_As {

        private static $instance = null;

        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
        /**
        * Constructor
        *
        * @return Electron_Wc_As
        * @since 1.0.0
        */
        public function __construct() {

            if ( ! isset( $_REQUEST['action'] ) || 'electron_as_products' !== $_REQUEST['action']  ) {

                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
            }

            add_action( 'wp_ajax_electron_as_products', array( $this, 'ajax_search_products' ) );
            add_action( 'wp_ajax_nopriv_electron_as_products', array( $this, 'ajax_search_products' ) );

            // register shortcode.
            add_shortcode( 'electron_wc_ajax_search', array( $this, 'add_wc_ajax_search_shortcode' ) );
        }

        /**
        * Enqueue styles and scripts
        *
        * @access public
        * @return void
        * @since 1.0.0
        */
        public function enqueue_styles_scripts() {
            wp_register_script( 'electron-autocomplete', ELECTRON_PLUGIN_URL. 'widgets/woocommerce/ajax-search/css-js/electron-autocomplete.min.js','', ELECTRON_PLUGIN_VERSION, true );
            wp_register_script( 'electron-ajax-search', ELECTRON_PLUGIN_URL . 'widgets/woocommerce/ajax-search/css-js/script.js', array( 'jquery' ), ELECTRON_PLUGIN_VERSION, true );
            wp_localize_script( 'electron-ajax-search', 'electron_as_params', array(
                'loading' => ELECTRON_PLUGIN_URL . 'assets/front/img/ajax-loader.gif',
                'ajax_url' => admin_url( 'admin-ajax.php' ),
            ));
            wp_enqueue_script( 'electron-autocomplete' );
        }

        public function add_wc_ajax_search_shortcode() {
            wp_enqueue_script( 'electron-autocomplete' );
            wp_enqueue_script( 'electron-ajax-search' );
            ob_start();
            ?>
            <div class="electron-asform-container">
                <form role="search" method="get" class="electron-asform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search"
                    value="<?php echo esc_attr( get_search_query() ); ?>"
                    name="s" class="electron-as"
                    placeholder="<?php esc_attr_e( 'Search products...', 'electron' ); ?>"
                    data-loader-icon="<?php echo esc_attr( str_replace( '"', '', apply_filters( 'electron_as_ajax_search_icon', '' ) ) ); ?>"
                    data-min-chars="<?php echo esc_attr( apply_filters( 'electron_as_min_chars', 1 ) ); ?>" />
                    <input type="hidden" name="post_type" value="<?php echo esc_attr( apply_filters( 'electron_as_search_type', 'product' ) ); ?>"/>
                    <div class="search-icon"><span class="ajax-loading"></span></div>
                    <?php do_action( 'wpml_add_language_form_field' ); ?>
                </form>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
        * Get microtime.
        *
        * @return float
        */
        public function get_microtime() {
            list( $usec, $sec ) = explode( ' ', microtime() );

            return ( (float) $usec + (float) $sec );
        }

        /**
        * Perform ajax search products
        */
        public function ajax_search_products() {
            global $woocommerce;

            $time_start         = $this->get_microtime();
            $transient_enabled  = apply_filters( 'electron_as_enable_transient', 'no' );
            $transient_duration = apply_filters( 'electron_as_transient_duration', 12 );
            $search_keyword     = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );
            $ordering_args      = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );
            $suggestions        = array();
            $transient_name     = 'electronas_' . $search_keyword;
            $suggestions        = get_transient( $transient_name );
            
            if ( 'no' === $transient_enabled || false === $suggestions ) {
                $args = array(
                    's'                   => apply_filters( 'electron_as_search_query', $search_keyword ),
                    'post_type'           => 'product',
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => 1,
                    'orderby'             => $ordering_args['orderby'],
                    'order'               => $ordering_args['order'],
                    'posts_per_page'      => apply_filters( 'electron_as_posts_per_page', apply_filters( 'electron_as_posts_per_page', -1 ) ),
                    'suppress_filters'    => false
                );

                $data       = array();
                $taxonomies = array();
                $taxonomies = get_object_taxonomies( 'product', 'objects' );
                foreach ( $taxonomies as $tax_slug => $tax ) {
                    if ( ! $tax->public || ! $tax->show_ui ) {
                        continue;
                    }
                    $data[ $tax_slug ] = $tax;
                }

                if ( isset( $_REQUEST['product_cat'] ) ) {
                    $args['tax_query'] = array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $data
                        ),
                    );
                }

                if ( version_compare( WC()->version, '2.7.0', '<' ) ) {
                    $args['meta_query'] = array(
                        array(
                            'key' => '_visibility',
                            'value' => array( 'search', 'visible' ),
                            'compare' => 'IN'
                        ),
                    );
                } else {
                    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'term_taxonomy_id',
                        'terms'    => $product_visibility_term_ids['exclude-from-search'],
                        'operator' => 'NOT IN'
                    );
                }

                $products = get_posts( $args );

                if ( ! empty( $products ) ) {
                    foreach ( $products as $post ) {
                        $product = wc_get_product( $post );

                        $suggestions[] = apply_filters( 'electron_as_suggestion',
                            array(
                                'id'    => $product->get_id(),
                                'value' => wp_strip_all_tags( $product->get_title() ),
                                'url'   => $product->get_permalink(),
                                'img'   => get_the_post_thumbnail_url( $product->get_id(), array( 50, 50 ) ),
                                'prc'   => $product->get_price_html()
                            ),
                            $product
                        );
                    }
                } else {
                    $suggestions[] = array(
                        'id'    => - 1,
                        'value' => esc_html__( 'No results', 'electron' ),
                        'url'   => ''
                    );
                }
                wp_reset_postdata();

                if ( 'yes' === $transient_enabled ) {
                    set_transient( $transient_name, $suggestions, $transient_duration * HOUR_IN_SECONDS );
                }
            }

            $time_end    = $this->get_microtime();
            $time        = $time_end - $time_start;
            $suggestions = array(
                'suggestions' => $suggestions,
                'time' => $time,
            );
            echo wp_json_encode( $suggestions );
            die();
        }
    }
    Electron_Wc_As::get_instance();
}
