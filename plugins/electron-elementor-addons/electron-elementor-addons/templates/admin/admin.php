<?php

/*
* Admin Assets
*/
function electron_enqueue_admin_assets( $hook ) {
    global $electron_admin_menu_page;
    if ( $hook != $electron_admin_menu_page ) {
        return;
    }
    wp_enqueue_style( 'electron-admin-bootstrap-css',  plugins_url( 'assets/admin/css/bootstrap.min.css', dirname(__DIR__) )  );
    wp_enqueue_style( 'electron-admin-styles', plugins_url( 'assets/admin/css/plugin-admin-styles.css', dirname(__DIR__) ) );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'electron-admin-popper-js', plugins_url( 'assets/admin/js/popper.min.js', dirname(__DIR__) ) );
    wp_enqueue_script( 'electron-admin-bootstrap-js', plugins_url( 'assets/admin/js/bootstrap.min.js', dirname(__DIR__) ) );
    wp_enqueue_script( 'electron-admin-script-js',  plugins_url( 'assets/admin/js/plugin-admin-scripts.js', dirname(__DIR__) ) );
}
add_action( 'admin_enqueue_scripts', 'electron_enqueue_admin_assets' );

add_action( 'admin_menu', 'electron_admin_menu_page', 200 );
function electron_admin_menu_page() {
    $parent_slug = 'ninetheme_theme_manage';
    $page_title = esc_html__( 'Electron Addons', 'electron' );
    $menu_title = '<span class="dashicons dashicons-tagcloud"></span> ' .esc_html__( 'Electron Addons', 'electron' );
    $capability = 'manage_options';
    $menu_slug = 'electron';
    $function = 'electron_admin_menu_page_display';
    global $electron_admin_menu_page;
    $electron_admin_menu_page = add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
}

/*
* Admin Menu Page Output
*/
function electron_admin_menu_page_display() {
    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized user' );
    }
    require_once( __DIR__ . '/admin-template.php' );
}
