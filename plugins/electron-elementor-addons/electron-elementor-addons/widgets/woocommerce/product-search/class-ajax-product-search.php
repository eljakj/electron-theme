<?php
/*
Plugin Name: Woocommerce AJAX product search
Plugin URI: http://www.enovathemes.com
Description: Ajax product search for WooCommerce
Author: Enovathemes
Version: 1.0
Author URI: http://enovathemes.com
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( ! class_exists( 'Electron_Wc_Ajax_Search' ) ) {
    /**
    * Electron WooCommerce Ajax Search
    *
    * @since 1.0.0
    */
    class Electron_Wc_Ajax_Search {

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
        * @return Electron_Wc_Ajax_Search
        * @since 1.0.0
        */
        public function __construct() {

            add_action( 'wp_ajax_electron_ajax_search_product', [ $this, 'search_product' ] );
            add_action( 'wp_ajax_nopriv_electron_ajax_search_product', [ $this, 'search_product' ] );

            // register shortcode.
            add_shortcode( 'electron_wc_ajax_product_search', [ $this, 'add_wc_ajax_search_shortcode' ] );
        }

        /*  Search action
        /*-------------------*/

        public function search_product() {

            global $wpdb;
            $ot            = get_option('electron_header');
            $sku           = isset($ot['ajax_search_sku']) ? $ot['ajax_search_sku'] : '1';
            $content       = isset($ot['ajax_search_content']) ? $ot['ajax_search_content'] : '1';
            $img           = isset($ot['ajax_search_result_img']) ? $ot['ajax_search_result_img'] : '1';
            $prc           = isset($ot['ajax_search_result_prc']) ? $ot['ajax_search_result_prc'] : '1';
            $pstock        = isset($ot['ajax_search_result_stock']) ? $ot['ajax_search_result_stock'] : '1';
            $btn           = isset($ot['ajax_search_result_btn']) ? $ot['ajax_search_result_btn'] : '1';
            $btn_type      = isset($ot['ajax_search_result_btn_type']) ? $ot['ajax_search_result_btn_type'] : 'text';
            $cimg          = isset($ot['ajax_search_custom_img']) ? $ot['ajax_search_custom_img'] : '0';
            $all_link      = isset($ot['ajax_search_result_all_products']) ? $ot['ajax_search_result_all_products'] : '1';
            $perpage       = isset($ot['ajax_search_perpage']) ? $ot['ajax_search_perpage'] : '10';
            $catalog_mode  = isset($ot['woo_catalog_mode']) ? $ot['woo_catalog_mode'] : '0';
            $disable_price = isset($ot['woo_disable_price']) ? $ot['woo_disable_price'] : '0';
            $disable_price = '1' == $catalog_mode ? $disable_price : 0;

            if ( isset($_GET['keyword'] ) && !empty( $_GET['keyword'] ) ) {

                $keyword = esc_html($_GET['keyword']);

                if ( isset($_GET['category']) && !empty($_GET['category']) ) {

                    $category = esc_html($_GET['category']);

                    $field = '';
                    $field .= $sku == '1' ? "(p.ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_sku' AND meta_value LIKE '%{$keyword}%'))" : "";
                    if ( $content == '1' ){
                        $field .= $sku == '1' ? " OR " : "";
                        $field .= "(p.post_content LIKE '%{$keyword}%')";
                    }
                    $field .= ( $sku == '1' || $content == '1' ) ? " OR (" : "";
                    $field .= "p.post_title LIKE '%{$keyword}%'";
                    $field .= ( $sku == '1' || $content == '1' ) ? ")" : "";
                    $pp  = $all_link == '1' ? " LIMIT $perpage" : '';

                    $querystr = "SELECT DISTINCT * FROM $wpdb->posts AS p
                    LEFT JOIN $wpdb->term_relationships AS r ON (p.ID = r.object_id)
                    INNER JOIN $wpdb->term_taxonomy AS x ON (r.term_taxonomy_id = x.term_taxonomy_id)
                    INNER JOIN $wpdb->terms AS t ON (r.term_taxonomy_id = t.term_id)
                    WHERE p.post_type IN ('product')
                    AND p.post_status = 'publish'
                    AND x.taxonomy = 'product_cat'
                    AND (
                        (x.term_id = {$category})
                    OR
                        (x.parent = {$category})
                    )
                    AND ($field)
                    ORDER BY t.name ASC, p.post_date DESC$pp";

                } else {

                    $pp  = $all_link == '1' ? " LIMIT $perpage" : '';
                    $field = '';
                    $field .= $sku == '1' ? "($wpdb->postmeta.meta_key = '_sku' AND $wpdb->postmeta.meta_value LIKE '%{$keyword}%')" : "";
                    if ( $content == '1' ) {
                        $field .= $sku == '1' ? " OR " : "";
                        $field .= "($wpdb->posts.post_content LIKE '%{$keyword}%')";
                    }
                    $field .= ( $sku == '1' || $content == '1' ) ? " OR (" : "";
                    $field .= "$wpdb->posts.post_title LIKE '%{$keyword}%'";
                    $field .= ( $sku == '1' || $content == '1' ) ? ")" : "";

                    $querystr = "SELECT DISTINCT $wpdb->posts.*
                    FROM $wpdb->posts, $wpdb->postmeta
                    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
                    AND ($field)
                    AND $wpdb->posts.post_status = 'publish'
                    AND $wpdb->posts.post_type = 'product'
                    ORDER BY $wpdb->posts.post_date DESC";

                    $querystrpp = "SELECT DISTINCT $wpdb->posts.*
                    FROM $wpdb->posts, $wpdb->postmeta
                    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
                    AND ($field)
                    AND $wpdb->posts.post_status = 'publish'
                    AND $wpdb->posts.post_type = 'product'
                    ORDER BY $wpdb->posts.post_date DESC$pp";
                }

                $query_results = $wpdb->get_results($querystrpp);
                $query_resultspp = $wpdb->get_results($querystr);

                if (!empty($query_results)) {
                    $countresult = count($query_resultspp);

                    $output = '';

                    foreach ($query_results as $result) {

                        $pid      = $result->ID;
                        $_product = wc_get_product( $pid );
                        $price    = $_product->get_price_html();
                        $imageId  = $_product->get_image_id();
                        $status   = $_product->get_stock_status();
                        $stock    = $_product->get_stock_quantity();
                        $sku      = $_product->get_sku();
                        $image    = $imageId ? wp_get_attachment_image_url($imageId,'electron-panel') : wc_placeholder_img_src( 'electron-panel' );
                        $image    = $cimg == '1' ? $cimg['url'] : $image;

                        $output .= '<li>';
                            $output .= '<a class="electron-ajax-product-link" href="'.get_permalink($pid).'">';
                                if ( $img == '1' ){
                                    $output .= '<div class="electron-ajax-product-image"><img src="'.esc_url($image).'"></div>';
                                }
                                $output .= '<div class="electron-ajax-product-data">';
                                    $output .= '<h5 class="electron-ajax-product-title">'.$result->post_title.'</h5>';
                                    if ( !empty( $price ) && $prc == '1' && '1' != $disable_price ) {
                                        $output .= '<div class="electron-ajax-product-price electron-price-wrapper price">'.$price.'</div>';
                                    }

                                    if ( !empty( $stock ) && $pstock == '1' ) {
                                        $output .= electron_loop_product_stock_status($status,$stock,true);
                                    }
                                    if ( $sku ) {
                                        $output .= '<span class="electron-ajax-product-sku">'.$_product->get_sku().'</span>';
                                    }
                                $output .= '</div>';
                            $output .= '</a>';
                            if ( $btn == '1' && '1' != $catalog_mode ) {
                                $output .= electron_add_to_cart($btn_type,$pid);
                            }
                        $output .= '</li>';
                    }
                    if ( !empty( $output ) ) {
                        $home_url = home_url( '/' );
                        $output .= $all_link == '1' && ( $countresult > $perpage ) ? '<li class="search-total-link"><a href="'.esc_url($home_url).'?s='.$keyword.'&post_type=product"><span class="search-total-text"></span><span class="search-total"> ( '.$countresult.' )</span></a></li>' : '';
                        echo $output;
                    }
                }
            }
            die();
        }

        public function add_wc_ajax_search_shortcode($attr='') {
            $args = shortcode_atts(array(
                'class' => 'style-inline style-select-bars style-circle',
                'cats' => '',
                'select_text' => '',
                'search_text' => ''
            ), $attr );
            $ot          = get_option('electron_header');
            $attr        = $args['class'] != '' ? ' '.$args['class'] : '';
            $select_text = $args['select_text'] != '' ? $args['select_text'] : esc_html__( 'All', 'electron' );
            $search_text = $args['search_text'] != '' ? $args['search_text'] : esc_html__( 'Search for products', 'electron' );
            $max_char    = isset($ot['ajax_search_max_char']) ? $ot['ajax_search_max_char'] : '3';
            $depth       = isset($ot['ajax_search_menu_depth']) ? $ot['ajax_search_menu_depth'] : '1';

            $product_categories = get_terms( 'product_cat', array(
                'orderby'    => 'name',
                'order'      => 'asc',
                'hide_empty' => true,
            ));

            wp_enqueue_script( 'electron-ajax-product-search' );
            ob_start();

            ?>
            <div class="electron-ajax-product-search<?php echo esc_attr( $attr ); ?>" data-max-str="<?php echo esc_attr( $max_char ); ?>">
                <form role="search" class="electron-ajax-product-search-form" name="electron-ajax-product-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" name="s"
                    class="electron-ajax-search-input hide-clear"
                    placeholder="<?php echo esc_attr( $search_text ); ?>"
                    value="<?php echo esc_attr( get_search_query() ); ?>">
                    <?php if ( $product_categories ) : ?>
                        <div class="category-select-wrapper">
                            <div class="electron-ajax-selected" data-val="">
                                <span class="cat-name"><?php echo esc_html( $select_text ); ?></span>
                                <span class="nt-icon-up-chevron icon"></span>
                            </div>
                            <ul class="category-list electron-scrollbar">
                                <li class="empty-cat electron-hidden" data-val=""><?php echo esc_html( $select_text ); ?></li>
                                <?php
                                    echo wp_list_categories(array(
                                        'echo'       => true,
                                        'taxonomy'   => 'product_cat',
                                        'depth'      => $depth == '0' ? 1 : 5,
                                        'hide_empty' => 1,
                                        'title_li'   => '',
                                        'walker'     => new Electron_WooCommerce_Categories_Select_Walker2()
                                    ));
                                ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <button class="electron-ajax-search-submit" type="submit" title="<?php echo esc_attr( $search_text ); ?>"><?php echo electron_svg_lists( 'search', 'electron-svg-icon' ); ?></button>
                    <input type="hidden" name="post_type" value="product">
                    <?php do_action( 'wpml_add_language_form_field' ); ?>
                    <div class="electron-ajax-close-search-results"></div>
                </form>

                <div class="electron-ajax-search-results electron-scrollbar electron-spinner"></div>
            </div>
            <?php

            return ob_get_clean();
        }
    }
    Electron_Wc_Ajax_Search::get_instance();
}

if ( !class_exists('Electron_WooCommerce_Categories_Select_Walker2') ) {
    class Electron_WooCommerce_Categories_Select_Walker2 extends Walker {
        /**
    	 * What the class handles.
    	 *
    	 * @var string
    	 */
    	public $tree_type = 'product_cat';

    	/**
    	 * DB fields to use.
    	 *
    	 * @var array
    	 */
    	public $db_fields = array(
    		'parent' => 'parent',
    		'id'     => 'term_id',
    		'slug'   => 'slug',
    	);

    	/**
    	 * Start the element output.
    	 *
    	 * @see Walker::start_el()
    	 * @since 2.1.0
    	 *
    	 * @param string  $output            Passed by reference. Used to append additional content.
    	 * @param object  $cat               Category.
    	 * @param int     $depth             Depth of category in reference to parents.
    	 * @param array   $args              Arguments.
    	 * @param integer $current_object_id Current object ID.
    	 */
    	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
    		$cat_id = intval( $cat->term_id );
    		$current = '';
    		if ( $args['current_category'] === $cat_id ) {
    			$current = ' current-cat';
    		}

    		$output .= '<li class="cat-item'.$current.'" data-val="'.$cat->term_id.'">'.$cat->name.'</li>';

    	}

    	/**
    	 * Ends the element output, if needed.
    	 *
    	 * @see Walker::end_el()
    	 * @since 2.1.0
    	 *
    	 * @param string $output Passed by reference. Used to append additional content.
    	 * @param object $cat    Category.
    	 * @param int    $depth  Depth of category. Not used.
    	 * @param array  $args   Only uses 'list' for whether should append to output.
    	 */
    	public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
    		//$output .= "</li>\n";
    	}

    	/**
    	 * Traverse elements to create list from elements.
    	 *
    	 * Display one element if the element doesn't have any children otherwise,
    	 * display the element and its children. Will only traverse up to the max.
    	 * depth and no ignore elements under that depth. It is possible to set the.
    	 * max depth to include all depths, see walk() method.
    	 *
    	 * This method shouldn't be called directly, use the walk() method instead.
    	 *
    	 * @since 2.5.0
    	 *
    	 * @param object $element           Data object.
    	 * @param array  $children_elements List of elements to continue traversing.
    	 * @param int    $max_depth         Max depth to traverse.
    	 * @param int    $depth             Depth of current element.
    	 * @param array  $args              Arguments.
    	 * @param string $output            Passed by reference. Used to append additional content.
    	 * @return null Null on failure with no changes to parameters.
    	 */
    	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
    		if ( ! $element || ( 0 === $element->count && ! empty( $args[0]['hide_empty'] ) ) ) {
    			return;
    		}
    		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    	}
    }
}
