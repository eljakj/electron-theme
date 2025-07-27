<?php

/*************************************************
## ADMIN NOTICES
 *************************************************/

add_action('admin_notices', 'electron_theme_activation_notice');
function electron_theme_activation_notice()
{
    if (get_user_meta(get_current_user_id(), 'electron-ignore-notice', true) == 'yes') {
        return;
    }
    $url = add_query_arg('electron-ignore-notice', 'electron_dismiss_admin_notices');
?>
    <div class="updated notice notice-info is-dismissible electron-admin-notice">
        <p><?php echo esc_html__('If you need help about demodata installation, please read docs and ', 'electron'); ?>
            <a target="_blank" href="<?php echo esc_url('https://electron.com/contact/'); ?>"><?php echo esc_html__('Open a ticket', 'electron'); ?></a>
            <?php echo esc_html__('or', 'electron'); ?>
            <a href="<?php echo esc_url($url); ?>"><?php echo esc_html__('Dismiss this notice', 'electron'); ?></a>
            <button type="button" class="notice-dismiss hide-admin-notice"><span class="screen-reader-text"></span></button>
        </p>
    </div>
<?php
}


add_action('admin_init', 'electron_theme_activation_notice_ignore');
function electron_theme_activation_notice_ignore()
{
    if (isset($_GET['electron-ignore-notice'])) {
        update_user_meta(get_current_user_id(), 'electron-ignore-notice', 'yes');
    }
}

add_action('admin_notices', 'electron_notice_for_activation');
if (!function_exists('electron_notice_for_activation')) {
    function electron_notice_for_activation()
    {
        global $pagenow;

        if (!get_option('envato_purchase_code_48852413')) {

            echo '<div class="notice notice-warning">
                <p>' . sprintf(
                esc_html__('Enter your Envato Purchase Code to receive electron Theme and plugin updates %s', 'electron'),
                '<a href="' . admin_url('admin.php?page=merlin&step=license') . '">' . esc_html__('Enter Purchase Code', 'electron') . '</a>'
            ) . '</p>
            </div>';
        }
    }
}

if (!get_option('envato_purchase_code_48852413')) {
    add_filter('auto_update_theme', '__return_false');
}

add_action('upgrader_process_complete', 'electron_upgrade_function', 10, 2);
if (!function_exists('electron_upgrade_function')) {
    function electron_upgrade_function($upgrader_object, $options)
    {
        $purchase_code = get_option('envato_purchase_code_48852413');

        if (($options['action'] == 'update' && $options['type'] == 'theme') && !$purchase_code) {
            wp_redirect(admin_url('admin.php?page=merlin&step=license'));
        }
    }
}

if (!function_exists('electron_is_theme_registered')) {
    function electron_is_theme_registered()
    {
        $purchase_code = get_option('envato_purchase_code_48852413');
        $registered_by_purchase_code = !empty($purchase_code);

        // Purchase code entered correctly.
        if ($registered_by_purchase_code) {
            return true;
        }
    }
}
if (isset($_GET['ntignore']) && esc_html($_GET['ntignore']) == 'yes') {
    add_option('envato_purchase_code_48852413', 'yes');
}

function electron_deactivate_envato_plugin()
{
    if (function_exists('envato_market') && !get_option('envato_purchase_code_48852413')) {
        deactivate_plugins('envato-market/envato-market.php');
    }
}

/*************************************************
## ADMIN STYLE AND SCRIPTS
 *************************************************/
add_action('admin_enqueue_scripts', 'electron_admin_scripts');
function electron_admin_scripts()
{
    if (!is_customize_preview()) {
        wp_register_style('select2-full', ELECTRON_DIRECTORY_URI . '/js/select2/select2.min.css');
        wp_register_script('select2-full', ELECTRON_DIRECTORY_URI . '/js/select2/select2.full.min.js', array('jquery'), '1.0', true);
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('electron-framework-admin', ELECTRON_DIRECTORY_URI . '/js/framework-admin.js', array('jquery', 'wp-color-picker'));
    }
}

/*************************************************
## INCLUDE THE TGM_PLUGIN_ACTIVATION CLASS.
 *************************************************/
// TGM plugin activation
include ELECTRON_DIRECTORY . '/inc/core/class-tgm-plugin-activation.php';
function electron_register_required_plugins()
{
    $plugins = array(
        array(
            'name' => esc_html__('Contact Form 7', 'electron'),
            'slug' => 'contact-form-7'
        ),
        array(
            'name' => esc_html__('Safe SVG', 'electron'),
            'slug' => 'safe-svg'
        ),
        array(
            'name' => esc_html__('Theme Options Panel', 'electron'),
            'slug' => 'redux-framework',
            'required' => true
        ),
        array(
            'name' => esc_html__('Elementor', 'electron'),
            'slug' => 'elementor',
            'required' => true
        ),
        array(
            'name' => esc_html__('WooCommerce', 'electron'),
            'slug' => 'woocommerce',
            'required' => true
        ),
        array(
            'name' => esc_html__('Customer Reviews for WooCommerce', 'electron'),
            'slug' => 'customer-reviews-woocommerce',
            'required' => false
        ),
        array(
            'name' => esc_html__('WPC Bought Together', 'electron'),
            'slug' => 'woo-bought-together',
            'required' => false
        ),
        array(
            'name' => esc_html__('Envato Auto Update Theme', 'electron'),
            'slug' => 'envato-market',
            'source' => 'https://electron.com/documentation/plugins/envato-market.zip',
            'required' => false
        ),
        array(
            'name' => esc_html__('Electron Elementor Addons', 'electron'),
            'slug' => 'electron-elementor-addons',
            'source' => ELECTRON_DIRECTORY . '/plugins/electron-elementor-addons.zip',
            'required' => true,
            'version' => '1.2.6'
        )
        // end plugins list
    );

    $config = array(
        'id' => 'tgmpa',
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'parent_slug' => apply_filters('electron_parent_slug', 'themes.php'),
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => true,
        'message' => ''
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'electron_register_required_plugins');


/*************************************************
## THEME SETUP WIZARD
    https://github.com/richtabor/MerlinWP
 *************************************************/

function electron_merlin_local_import_files()
{
    $rtl = is_rtl() ? '-rtl' : '';
    return array(
        array(
            'import_file_name' => esc_html__('Home 1', 'electron'),
            'import_preview_url' => 'https://ninetheme.com/themes/electron/v1/',
            // XML data
            'local_import_file' => get_parent_theme_file_path('inc/core/merlin/demodata/data' . $rtl . '.xml'),
            // Widget data
            'local_import_widget_file' => get_parent_theme_file_path('inc/core/merlin/demodata/widgets.wie'),
            // Theme options
            'local_import_redux' => array(
                array(
                    'file_path' => trailingslashit(ELECTRON_DIRECTORY) . 'inc/core/merlin/demodata/redux.json',
                    'option_name' => 'electron'
                ),
                array(
                    'file_path' => trailingslashit(ELECTRON_DIRECTORY) . 'inc/core/merlin/demodata/redux_header.json',
                    'option_name' => 'electron_header'
                )
            )
        )
    );
}
add_filter('merlin_import_files', 'electron_merlin_local_import_files');

function electron_disable_size_images_during_import()
{
    add_filter('intermediate_image_sizes_advanced', function ($sizes) {
        //unset( $sizes['thumbnail'] );
        unset($sizes['medium']);
        unset($sizes['medium_large']);
        unset($sizes['large']);
        unset($sizes['1536x1536']);
        unset($sizes['2048x2048']);
        return $sizes;
    });
}
add_action('import_start', 'electron_disable_size_images_during_import');

/**
 * Execute custom code after the whole import has finished.
 */
function electron_merlin_after_import_setup()
{
    // Assign front page and posts page (blog page).

    update_option('show_on_front', 'page');

    $front_pagequery = new WP_Query(array(
        'post_type' => 'page',
        'title' => 'Home 7 - Advanced',
    ));
    if ($front_pagequery->have_posts()) {
        $front_pagequery->the_post();
        update_option('page_on_front', get_the_ID());
        wp_reset_postdata();
    }

    $blog_pagequery = new WP_Query(array(
        'post_type' => 'page',
        'title' => 'Blog',
    ));
    if ($blog_pagequery->have_posts()) {
        $blog_pagequery->the_post();
        update_option('page_for_posts', get_the_ID());
        wp_reset_postdata();
    }

    update_option('thumbnail_crop', 0);
    update_option('thumbnail_size_w', 100);
    update_option('thumbnail_size_h', 100);
    update_option('woocommerce_thumbnail_cropping_custom_width', 1);
    update_option('woocommerce_thumbnail_cropping_custom_height', 2);
    update_option('woocommerce_thumbnail_cropping', 'uncropped');

    if (did_action('elementor/loaded')) {

        // update some default elementor global settings after setup theme
        $kit_pagequery = new WP_Query(array(
            'post_type' => 'elementor_library',
            'title' => 'Imported Kit',
        ));

        if ($kit_pagequery->have_posts()) {
            $kit_pagequery->the_post();
            update_option('elementor_active_kit', get_the_ID());
            wp_reset_postdata();
        }

        update_option('elementor_experiment-e_font_icon_svg', 'active');
        update_option('elementor_experiment-container', 'active');
        update_option('elementor_experiment-e_dom_optimization', 'active');
        update_option('elementor_experiment-e_optimized_assets_loading', 'active');
        update_option('elementor_experiment-e_optimized_css_loading', 'inactive');
        update_option('elementor_experiment-a11y_improvements', 'active');
        update_option('elementor_experiment-additional_custom_breakpoints', 'active');
        update_option('elementor_experiment-e_import_export', 'active');
        update_option('elementor_experiment-e_hidden_wordpress_widgets', 'active');
        update_option('elementor_experiment-landing-pages', 'inactive');
        update_option('elementor_experiment-elements-color-picker', 'active');
        update_option('elementor_experiment-favorite-widgets', 'active');
        update_option('elementor_experiment-admin-top-bar', 'active');
        update_option('elementor_disable_color_schemes', 'yes');
        update_option('elementor_disable_typography_schemes', 'yes');
        update_option('elementor_global_image_lightbox', 'no');
        update_option('elementor_load_fa4_shim', 'yes');

        $cpt_support = get_option('elementor_cpt_support');
        if (!is_array($cpt_support) || ! in_array(['post', 'page', 'product'], $cpt_support)) {
            $cpt_support = ['post', 'page', 'product'];
            update_option('elementor_cpt_support', $cpt_support);
        }
        update_option('taxonomy_25', array('brand_thumbnail_id' => 11676));
        update_option('taxonomy_34', array('brand_thumbnail_id' => 11678));
        update_option('taxonomy_44', array('brand_thumbnail_id' => 11681));
        update_option('taxonomy_49', array('brand_thumbnail_id' => 11685));
    }

    /*
    * Customer Reviews for WooCommerce Plugins Settings
    * update some options after demodata insall
    */
    if (class_exists('Ivole')) {
        update_option('ivole_attach_image', 'yes');
        update_option('ivole_attach_image_quantity', 2);
        update_option('ivole_attach_image_size', 2);
        update_option('ivole_ajax_reviews_per_page', 3);
        update_option('ivole_disable_lightbox', 'yes');
        update_option('ivole_reviews_histogram', 'yes');
        update_option('ivole_reviews_voting', 'yes');
        update_option('ivole_reviews_nobranding', 'yes');
        update_option('ivole_ajax_reviews', 'yes');
        update_option('ivole_ajax_reviews_form', 'yes');
        update_option('ivole_questions_answers', 'yes');
        update_option('ivole_qna_count', 'yes');
        update_option('ivole_reviews_shortcode', 'yes');
        update_option('ivole_ajax_reviews', 'no');
    }

    if (class_exists('WPCleverWoobt')) {
        $woobt_settings = get_option('woobt_settings');
        if (is_array($woobt_settings)) {
            $woobt_settings['default']       = [0 => 'default', 1 => 'related', 2 => 'upsells'];
            $woobt_settings['default_limit'] = '4';
            $woobt_settings['position']      = 'after';
            $woobt_settings['search_same']   = 'yes';
            update_option('woobt_settings', $woobt_settings);
        } else {
            $woobt_settings = array();
            $woobt_settings['default']       = [0 => 'default', 1 => 'related', 2 => 'upsells'];
            $woobt_settings['default_limit'] = '4';
            $woobt_settings['position']      = 'after';
            $woobt_settings['search_same']   = 'yes';
            update_option('woobt_settings', $woobt_settings);
        }
    }

    if (class_exists('WooCommerce')) {
        $cartPage = get_option('woocommerce_cart_page_id');
        $cart_page_data = array(
            'ID' => $cartPage,
            'post_content' => '[woocommerce_cart]'
        );
        wp_update_post($cart_page_data);

        $checkoutPage = get_option('woocommerce_checkout_page_id');
        $checkout_page_data = array(
            'ID' => $checkoutPage,
            'post_content' => '[woocommerce_checkout]'
        );
        wp_update_post($checkout_page_data);

        // Ürün sayımlarını güncellemek için işlemi woocommerce_init kancasına ertele
        add_action('woocommerce_init', 'electron_update_product_term_counts', 20);
    }

    // removes block widgets from sidebars after demodata install
    if (is_active_sidebar('sidebar-1')) {
        $sidebars_widgets = get_option('sidebars_widgets');
        $sidebar_1_array  = $sidebars_widgets['sidebar-1'];
        foreach ($sidebar_1_array as $k => $v) {
            if (substr($v, 0, strlen("block-")) === "block-") {
                unset($sidebars_widgets['sidebar-1'][$k]);
            }
        }
        update_option('sidebars_widgets', $sidebars_widgets);
    }

    // Assign menus to their locations.
    $primary    = get_term_by('name', 'Header Menu', 'nav_menu');
    $mini_menu  = get_term_by('name', 'Header Dropdown Mini Menu', 'nav_menu');
    $mini_menu2 = get_term_by('name', 'Header Top Mini Menu', 'nav_menu');

    wp_update_term_count($primary->term_id, 'nav_menu', true);
    wp_update_term_count($mini_menu->term_id, 'nav_menu', true);
    wp_update_term_count($mini_menu2->term_id, 'nav_menu', true);

    set_theme_mod('nav_menu_locations', array(
        'header_menu'          => $primary->term_id,
        'canvas_menu'          => $primary->term_id,
        'header_dropdown_menu' => $mini_menu->term_id,
        'header_mini_menu'     => $mini_menu2->term_id
    ));

    global $wpdb;
    $old_base_url = 'https://electron.com/themes/electron2/';
    $new_base_url = get_home_url() . '/';

    $wpdb->query(
        $wpdb->prepare(
            "UPDATE {$wpdb->postmeta}
            SET meta_value = REPLACE(meta_value, %s, %s)
            WHERE meta_key IN ('_menu_item_icon_url', '_menu_item_url')",
            $old_base_url,
            $new_base_url
        )
    );

    $menu_items = wp_get_nav_menu_items('main-menu');

    if (! empty($menu_items)) {
        foreach ($menu_items as $menu_item) {
            if (isset($menu_item->url) && strpos($menu_item->url, $old_base_url) !== false) {
                // Menü URL'sini güncelle
                $updated_url = str_replace($old_base_url, $new_base_url, $menu_item->url);
                wp_update_post([
                    'ID' => $menu_item->ID,
                    'menu_item_url' => $updated_url,
                ]);
            }
        }
    }
}
add_action('merlin_after_all_import', 'electron_merlin_after_import_setup');

function electron_update_product_term_counts()
{
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 14,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'fields'         => 'ids',
    );

    $product_ids = get_posts($args);

    if (empty($product_ids)) {
        return;
    }

    // Taksonomiler için terim sayımlarını güncelle
    $taxonomies = array('product_cat', 'product_tag', 'product_brand');

    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'fields'   => 'ids',
            'hide_empty' => false,
        ));

        if (!is_wp_error($terms) && !empty($terms)) {
            wp_update_term_count_now($terms, $taxonomy);
        }
    }

    if (function_exists('wc_update_product_lookup_tables')) {
        foreach ($product_ids as $product_id) {
            wc_update_product_lookup_tables($product_id);
        }
    }

    wp_cache_flush();
}

add_action('init', 'do_output_buffer');
function do_output_buffer()
{
    ob_start();
}

add_filter('woocommerce_prevent_automatic_wizard_redirect', '__return_true');

add_action('admin_init', function () {
    if (did_action('elementor/loaded')) {
        remove_action('admin_init', [\Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started']);
    }
}, 1);

/**
 * Add custom fields to menu items (HTML yapısı korunuyor)
 */
function electron_custom_fields($item_id, $item)
{
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'nav-menus') {
        return;
    }

    // Add nonce field
    wp_nonce_field('electron_menu_save', 'electron_menu_nonce');

    // Enqueue media uploader only once
    static $media_enqueued = false;
    if (!$media_enqueued) {
        wp_enqueue_media();
        $media_enqueued = true;
    }

    // Fetch all meta fields at once
    $meta_fields = [
        '_menu_item_megamenu' => '',
        '_menu_item_megamenu_columns' => 5,
        '_menu_item_menushortcode' => '',
        '_menu_item_shortcode_sidebar' => '',
        '_menu_item_menuhidetitle' => '',
        '_menu_item_menulabel' => '',
        '_menu_item_menulabelcolor' => '',
        '_menu_item_icon_url' => '',
    ];
    $meta_values = [];
    foreach ($meta_fields as $key => $default) {
        $meta_values[$key] = get_post_meta($item_id, $key, true) ?: $default;
    }

    // Prepare checkbox values
    $mega_value = $meta_values['_menu_item_megamenu'] ? 'checked' : '';
    $hide_title_value = $meta_values['_menu_item_menuhidetitle'] ? 'checked' : '';
?>
    <div class="electron_menu_options">
        <div class="electron-field-link-mega electron-menu-field menu-flex description description-thin">
            <label for="menu_item_megamenu-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Show as Mega Menu', 'gemstone'); ?><br />
                <input type="checkbox" value="enabled" id="menu_item_megamenu-<?php echo esc_attr($item_id); ?>" name="menu_item_megamenu[<?php echo esc_attr($item_id); ?>]" <?php echo esc_attr($mega_value); ?> />
                <?php esc_html_e('Enable', 'gemstone'); ?>
            </label>
            <label class="electron-field-link-mega-columns" for="menu_item_megamenu_columns-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Mega menu columns', 'gemstone'); ?><br />
                <select class="widefat code edit-menu-item-custom" id="menu_item_megamenu_columns-<?php echo esc_attr($item_id); ?>" name="menu_item_megamenu_columns[<?php echo esc_attr($item_id); ?>]">
                    <?php
                    $max_columns = 12;
                    for ($i = 1; $i <= $max_columns; $i++) {
                    ?>
                        <option value="<?php echo esc_attr($i); ?>" <?php selected($meta_values['_menu_item_megamenu_columns'], $i); ?>><?php echo esc_html($i); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </label>
        </div>

        <div class="electron-field-icon-url-input electron-menu-field description description-thin">
            <label for="menu_item_icon_url-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Menu SVG Icon', 'gemstone'); ?><br />
                <div class="electron-field-flex">
                    <input type="text" id="menu_item_icon_url-<?php echo esc_attr($item_id); ?>" name="menu_item_icon_url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_url($meta_values['_menu_item_icon_url']); ?>" />
                    <input type="button" class="upload-icon-button button" data-menu-item-id="<?php echo esc_attr($item_id); ?>" value="<?php esc_attr_e('Upload Icon', 'gemstone'); ?>" />
                </div>
            </label>
        </div>

        <div class="electron-field-link-shortcode electron-menu-field description description-wide">
            <label for="menu_item_menushortcode-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Top Menu Shortcode', 'gemstone'); ?><br />
                <input type="text" class="widefat code edit-menu-item-custom" id="menu_item_menushortcode-<?php echo esc_attr($item_id); ?>" name="menu_item_menushortcode[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($meta_values['_menu_item_menushortcode']); ?>" />
            </label>
        </div>

        <div class="electron-field-link-shortcode electron-menu-field description description-wide">
            <label for="menu_item_shortcode_sidebar-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Sidebar Menu Shortcode', 'gemstone'); ?><br />
                <input type="text" class="widefat code edit-menu-item-custom" id="menu_item_shortcode_sidebar-<?php echo esc_attr($item_id); ?>" name="menu_item_shortcode_sidebar[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($meta_values['_menu_item_shortcode_sidebar']); ?>" />
            </label>
        </div>

        <div class="electron-field-link-hidetitle electron-menu-field description description-thin">
            <label for="menu_item_menuhidetitle-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Hide Title for Shortcode', 'gemstone'); ?><br />
                <input type="checkbox" value="yes" id="menu_item_menuhidetitle-<?php echo esc_attr($item_id); ?>" name="menu_item_menuhidetitle[<?php echo esc_attr($item_id); ?>]" <?php echo esc_attr($hide_title_value); ?> />
                <?php esc_html_e('Yes', 'gemstone'); ?>
            </label>
        </div>

        <div class="electron-field-link-label electron-menu-field description description-wide">
            <label for="menu_item_menulabel-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Highlight Label', 'gemstone'); ?> <span class="small-tag"><?php esc_html_e('Label', 'gemstone'); ?></span><br />
                <input type="text" class="widefat code edit-menu-item-custom" id="menu_item_menulabel-<?php echo esc_attr($item_id); ?>" name="menu_item_menulabel[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($meta_values['_menu_item_menulabel']); ?>" />
            </label>
        </div>

        <div class="electron-field-link-labelcolor electron-menu-field description description-wide">
            <label for="menu_item_menulabelcolor-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Highlight Label Color', 'gemstone'); ?><br />
                <input type="text" class="widefat code edit-menu-item-custom electron-color-field" id="menu_item_menulabelcolor-<?php echo esc_attr($item_id); ?>" name="menu_item_menulabelcolor[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($meta_values['_menu_item_menulabelcolor']); ?>" />
            </label>
        </div>
    </div>
<?php
}
add_action('wp_nav_menu_item_custom_fields', 'electron_custom_fields', 10, 2);

/**
 * Define maybe_sanitize_hex_color if not exists
 */
if (!function_exists('maybe_sanitize_hex_color')) {
    function maybe_sanitize_hex_color($color)
    {
        if (empty($color)) {
            return '';
        }
        $sanitized = sanitize_hex_color($color);
        return $sanitized !== '' ? $sanitized : '';
    }
}

/**
 * Save the menu item meta
 *
 * @param int $menu_id The ID of the menu
 * @param int $menu_item_db_id The ID of the menu item
 */
function electron_nav_update($menu_id, $menu_item_db_id)
{
    // Verify nonce for security
    if (!isset($_POST['electron_menu_nonce']) || !wp_verify_nonce($_POST['electron_menu_nonce'], 'electron_menu_save')) {
        return;
    }

    // Define meta fields and their sanitization callbacks
    $meta_fields = [
        'menu_item_megamenu' => 'sanitize_text_field',
        'menu_item_icon_url' => 'esc_url_raw',
        'menu_item_megamenu_columns' => 'absint',
        'menu_item_menushortcode' => 'sanitize_text_field',
        'menu_item_shortcode_sidebar' => 'sanitize_text_field',
        'menu_item_menuhidetitle' => 'sanitize_text_field',
        'menu_item_menulabel' => 'sanitize_text_field',
        'menu_item_menulabelcolor' => 'sanitize_hex_color',
    ];

    // Process each meta field
    foreach ($meta_fields as $field => $sanitize_callback) {
        $meta_key = "_$field";
        $post_key = $field;
        $value = isset($_POST[$post_key][$menu_item_db_id]) ? $_POST[$post_key][$menu_item_db_id] : '';

        // Special handling for checkboxes
        if (in_array($field, ['menu_item_megamenu', 'menu_item_menuhidetitle'], true)) {
            $value = ($value === 'enabled' || $value === 'yes') ? '1' : '';
        }

        // Sanitize the value
        if ($sanitize_callback === 'sanitize_hex_color') {
            $value = maybe_sanitize_hex_color($value);
        } else {
            $value = call_user_func($sanitize_callback, $value);
        }

        // Update or delete meta based on value
        if (in_array($field, ['menu_item_megamenu', 'menu_item_menuhidetitle'], true)) {
            if ($value === '1') {
                update_post_meta($menu_item_db_id, $meta_key, $value);
            } else {
                delete_post_meta($menu_item_db_id, $meta_key);
            }
        } else {
            if (!empty($value)) {
                update_post_meta($menu_item_db_id, $meta_key, $value);
            } else {
                delete_post_meta($menu_item_db_id, $meta_key);
            }
        }
    }
}
add_action('wp_update_nav_menu_item', 'electron_nav_update', 10, 2);
