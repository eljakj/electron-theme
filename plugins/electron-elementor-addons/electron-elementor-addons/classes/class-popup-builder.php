<?php
/**
* Taxonomy: Electron Brands.
*/
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
if ( ! class_exists( 'Electron_Popup_Builder' ) ) {
    class Electron_Popup_Builder {
        private static $instance = null;
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
        public function __construct() {
            if ( ! get_option( 'disable_electron_popups' ) == 1 ) {
                add_action( 'init', array( $this, 'electron_register_popups' ) );

                $cpt_support = get_option( 'elementor_cpt_support' );
                if ( is_array( $cpt_support ) && ! in_array( 'electron_popups', $cpt_support ) ) {
                    $cpt_support[] = 'electron_popups';
                    update_option( 'elementor_cpt_support', $cpt_support );
                }
                // Add the custom columns to the book post type:
                add_filter( 'manage_electron_popups_posts_columns', array( $this, 'set_custom_edit_electron_popups_columns' ) );
                // Add the data to the custom columns for the book post type:
                add_action( 'manage_electron_popups_posts_custom_column' , array( $this, 'custom_electron_popups_column' ), 10, 2 );
            }
        }
        public function electron_register_popups() {

            /**
            * Post Type: Electron Popups.
            */

            $labels = [
                "name" => __( "Popups Builder", "electron" ),
                "singular_name" => __( "Popup Builder", "electron" ),
                "menu_name" => __( "Popups Builder", "electron" ),
                "all_items" => __( "Popups Builder", "electron" ),
                "add_new" => __( "Add Popup", "electron" ),
                "add_new_item" => __( "Add new Popup", "electron" ),
                "edit_item" => __( "Edit Popup", "electron" ),
                "new_item" => __( "New Popup", "electron" ),
                "view_item" => __( "View Popup", "electron" ),
                "view_items" => __( "View Popups", "electron" ),
                "search_items" => __( "Search Popups", "electron" ),
                "not_found" => __( "No Popups found", "electron" ),
                "not_found_in_trash" => __( "No Popups found in trash", "electron" ),
                "archives" => __( "Popup archives", "electron" ),
            ];

            $args = [
                "label" => __( "Electron Popups", "electron" ),
                "labels" => $labels,
                "description" => "",
                "public" => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "has_archive" => false,
                "show_in_menu" => "ninetheme_theme_manage",
                "show_in_nav_menus" => true,
                "delete_with_user" => false,
                "exclude_from_search" => true,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "rewrite" => [ "slug" => "electron_popups", "with_front" => true ],
                "query_var" => true,
                "supports" => [ "title", "editor", "author" ],
                "show_in_graphql" => false,
            ];

            register_post_type( "electron_popups", $args );
        }

        public function set_custom_edit_electron_popups_columns($columns) {
            $columns[ 'shortcode' ] = __( "Popups ID", "electron" );
        
            return $columns;
        }
        
        public function custom_electron_popups_column( $column, $post_id ) {
            
            if ( 'shortcode' === $column ) {
        
                /** %s = shortcode tag, %d = post_id */
                $shortcode = esc_attr(
                    sprintf(
                        '#%s%d',
                        'electron-popup-',
                        $post_id
                    )
                );
                printf(
                    '<input class="electron-popup-input widefat" type="text" readonly onfocus="this.select()" value="%s" />',
                    $shortcode
                );
            } 
        }
    }
    Electron_Popup_Builder::get_instance();
}
