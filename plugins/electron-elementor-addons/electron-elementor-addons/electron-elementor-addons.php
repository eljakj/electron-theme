<?php
/**
* Plugin Name: Electron Elementor Addons
* Description: Premium & Advanced Essential Elements for Elementor
* Plugin URI:  http://themeforest.net/user/Ninetheme
* Version:     1.2.6
* Author:      Ninetheme
* Text Domain: electron
* Domain Path: /languages/
* Author URI:  https://ninetheme.com/
*/

/*
* Exit if accessed directly.
*/

if ( ! defined( 'ABSPATH' ) ) exit;
define( 'ELECTRON_PLUGIN_VERSION', '1.2.6' );
define( 'ELECTRON_PLUGIN_FILE', __FILE__ );
define( 'ELECTRON_PLUGIN_BASENAME', plugin_basename(__FILE__) );
define( 'ELECTRON_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'ELECTRON_PLUGIN_URL', plugins_url('/', __FILE__) );

final class Electron_Elementor_Addons
{

    /**
    * Plugin Version
    *
    * @since 1.0
    *
    * @var string The plugin version.
    */
    const VERSION = '1.2.6';

    /**
    * Minimum Elementor Version
    *
    * @since 1.0
    *
    * @var string Minimum Elementor version required to run the plugin.
    */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
    * Minimum PHP Version
    *
    * @since 1.0
    *
    * @var string Minimum PHP version required to run the plugin.
    */
    const MINIMUM_PHP_VERSION = '5.6';

    /**
    * Instance
    *
    * @since 1.0
    *
    * @access private
    * @static
    *
    * @var Electron_Elementor_Addons The single instance of the class.
    */
    private static $_instance = null;

    /**
    * Instance
    *
    * Ensures only one instance of the class is loaded or can be loaded.
    *
    * @since 1.0
    *
    * @access public
    * @static
    *
    * @return Electron_Elementor_Addons An instance of the class.
    */
    public static function instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * Constructor
    *
    * @since 1.0
    *
    * @access public
    */
    public function __construct()
    {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );

        function electron_pjax()
        {
            $request_headers = function_exists( 'getallheaders') ? getallheaders() : array();

            $is_pjax = isset( $_REQUEST['_pjax'] ) && ( ( isset( $request_headers['X-Requested-With'] ) && 'xmlhttprequest' === strtolower( $request_headers['X-Requested-With'] ) ) || ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' === strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) );

            return $is_pjax ? true : false;
        }
        add_filter( 'wxr_importer.pre_process.term', 'woocommerce_product_attributes_registration', 10, 1 );

        function woocommerce_product_attributes_registration( $data ) {
            global $wpdb;

            if ( strstr( $data['taxonomy'], 'pa_' ) ) {
                if ( ! taxonomy_exists( $data['taxonomy'] ) ) {
                    $attrName = wc_sanitize_taxonomy_name( str_replace( 'pa_', '', $data['taxonomy'] ) );

                    // Create the taxonomy
                    if ( ! in_array( $attrName, wc_get_attribute_taxonomies() ) ) {
                        $type = 'select';
                        if ( 'storage' == $attrName || 'sizes' == $attrName || 'size' == $attrName || 'connectivity' == $attrName || 'system' == $attrName || 'brands' == $attrName || 'carat' == $attrName ){
                            $type = 'button';
                        } elseif ( 'color' == $attrName || 'colors' == $attrName ){
                            $type = 'color';
                        }
                        $attribute = array(
                            'attribute_label'   => $attrName,
                            'attribute_name'    => $attrName,
                            'attribute_type'    => $type,
                            'attribute_orderby' => 'menu_order',
                            'attribute_public'  => 0
                        );
                        $wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
                        delete_transient( 'wc_attribute_taxonomies' );
                    }

                    // Register the taxonomy
                    register_taxonomy(
                        $data['taxonomy'],
                        apply_filters( 'woocommerce_taxonomy_objects_' . $data['taxonomy'], array( 'product' ) ),
                        apply_filters( 'woocommerce_taxonomy_args_' . $data['taxonomy'], array(
                            'hierarchical' => true,
                            'show_ui'      => false,
                            'query_var'    => true,
                            'rewrite'      => false,
                        ) )
                    );
                }
            }

            return $data;
        }

        /**
         * Load icon content from the WordPress uploads directory
         * Returns inline SVG content for SVG files, or an <img> tag for other image types
         *
         * @param string $icon_url The URL of the icon (must point to wp-content/uploads)
         * @return string Inline SVG content, <img> tag, or empty string on failure
         */
        function ninetheme_convert_url_to_svg($icon_url) {
            // Return early if URL is empty or invalid
            if (empty($icon_url) || !is_string($icon_url)) {
                return '';
            }

            // Get uploads directory information
            $upload_dir = wp_get_upload_dir();
            $base_url = $upload_dir['baseurl'];
            $base_dir = $upload_dir['basedir'];

            // Check if the URL is from the uploads directory
            if (strpos($icon_url, $base_url) !== 0) {
                return '';
            }

            // Convert URL to file path
            $relative_path = str_replace($base_url, '', $icon_url);
            $file_path = trailingslashit($base_dir) . ltrim($relative_path, '/');

            // Verify file exists
            if (!file_exists($file_path)) {
                return '';
            }

            // Check cache
            $cache_key = 'ninetheme_icon_' . md5($icon_url);
            $cached_content = get_transient($cache_key);
            if ($cached_content !== false) {
                return $cached_content;
            }

            // Determine if the file is an SVG based on extension
            $is_svg = strtolower(pathinfo($file_path, PATHINFO_EXTENSION)) === 'svg';

            if ($is_svg) {
                // Handle SVG files
                $svg_content = file_get_contents($file_path);
                if ($svg_content === false || empty($svg_content)) {
                    return '';
                }

                // Sanitize SVG content (Safe SVG is active, but we add an extra layer of security)
                $svg_content = ninetheme_sanitize_svg($svg_content);
                if (empty($svg_content)) {
                    return '';
                }

                // Cache the sanitized SVG for 24 hours
                set_transient($cache_key, $svg_content, 24 * HOUR_IN_SECONDS);
                return $svg_content;
            } else {
                // Handle non-SVG image files (e.g., PNG, JPG)
                $img_tag = '<img src="' . esc_url($icon_url) . '" alt="Menu Icon" class="menu-icon" />';

                // Cache the img tag for 24 hours
                set_transient($cache_key, $img_tag, 24 * HOUR_IN_SECONDS);
                return $img_tag;
            }
        }

        /**
         * Sanitize SVG content to remove unsafe elements and attributes
         * Uses DOMDocument for precise parsing; falls back to wp_kses if DOMDocument is unavailable
         *
         * @param string $svg_content Raw SVG content
         * @return string Sanitized SVG content
         */
        function ninetheme_sanitize_svg($svg_content) {
            // Remove XML declaration
            $svg_content = preg_replace('/<\?xml[^>]*\?>/i', '', $svg_content);

            // Try DOMDocument for precise SVG parsing
            if (class_exists('DOMDocument')) {
                $doc = new DOMDocument();
                libxml_use_internal_errors(true); // Suppress parsing errors
                $doc->loadXML($svg_content, LIBXML_NOERROR | LIBXML_NOWARNING);
                libxml_clear_errors();

                if (!$doc->documentElement) {
                    return '';
                }

                // Allowed elements and attributes
                $allowed_elements = ['svg', 'path', 'g', 'circle', 'rect', 'line', 'polyline', 'polygon', 'text', 'title'];
                $allowed_attributes = ['viewBox', 'viewbox', 'width', 'height', 'fill', 'stroke', 'stroke-width', 'd', 'transform', 'class', 'style'];

                // Remove unsafe elements and attributes
                $nodes = $doc->getElementsByTagName('*');
                $nodes_to_remove = [];
                foreach ($nodes as $node) {
                    if (!in_array(strtolower($node->nodeName), $allowed_elements, true)) {
                        $nodes_to_remove[] = $node;
                        continue;
                    }
                    $attributes = iterator_to_array($node->attributes);
                    foreach ($attributes as $attr) {
                        if (!in_array(strtolower($attr->name), $allowed_attributes, true)) {
                            $node->removeAttribute($attr->name);
                        }
                    }
                }

                // Remove marked nodes
                foreach ($nodes_to_remove as $node) {
                    if ($node->parentNode) {
                        $node->parentNode->removeChild($node);
                    }
                }

                // Remove inline scripts
                $scripts = $doc->getElementsByTagName('script');
                while ($scripts->length > 0) {
                    $script = $scripts->item(0);
                    if ($script->parentNode) {
                        $script->parentNode->removeChild($script);
                    }
                }

                // Save cleaned SVG
                $svg_content = $doc->saveXML($doc->documentElement);

                // Remove unwanted IDs
                $svg_content = preg_replace('/\sid="[^"]*"/i', '', $svg_content);
            } else {
                // Fallback to wp_kses if DOMDocument is unavailable
                $allowed_tags = [
                    'svg' => ['viewBox' => true,'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'class' => true],
                    'path' => ['d' => true, 'fill' => true, 'stroke' => true],
                    'g' => ['transform' => true],
                    'circle' => ['cx' => true, 'cy' => true, 'r' => true, 'fill' => true],
                    'rect' => ['x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true],
                    'text' => ['x' => true, 'y' => true, 'font-size' => true],
                ];
                $svg_content = wp_kses($svg_content, $allowed_tags);
            }

            return $svg_content;
        }
    }

    /**
    * Load Textdomain
    *
    * Load plugin localization files.
    *
    * Fired by `init` action hook.
    *
    * @since 1.0
    *
    * @access public
    */
    public function i18n()
    {
        load_plugin_textdomain( 'electron', false, basename( __DIR__ ) . '/languages/' );
    }

    /**
    * Initialize the plugin
    *
    * Load the plugin only after Elementor (and other plugins) are loaded.
    * Checks for basic plugin requirements, if one check fail don't continue,
    * if all check have passed load the files required to run the plugin.
    *
    * Fired by `plugins_loaded` action hook.
    *
    * @since 1.0
    *
    * @access public
    */
    public function init()
    {
        $electron_options = get_option('electron');
        $electron_header_options = get_option('electron_header');
        // Check if Elementor is installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'electron_admin_notice_missing_main_plugin' ] );
            return;
        }
        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'electron_admin_notice_minimum_elementor_version' ] );
            return;
        }
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'electron_admin_notice_minimum_php_version' ] );
            return;
        }
        // register template name for the elementor saved templates
        add_filter( 'elementor/editor/localize_settings', [ $this,'electron_register_template'],10,2 );

        /* Custom plugin helper functions */
        require_once( ELECTRON_PLUGIN_PATH . '/classes/class-helpers-functions.php' );
        /* Add custom controls elementor section */
        require_once( ELECTRON_PLUGIN_PATH . '/classes/class-custom-elementor-section.php' );
        /* Add custom controls to default widgets */
        require_once( ELECTRON_PLUGIN_PATH . '/classes/class-customizing-default-widgets.php' );

        if ( class_exists('WooCommerce') ) {

            /* Add custom wp woocommerce widgets */
            require_once( ELECTRON_PLUGIN_PATH . '/widgets/woocommerce/wp-widgets/widget-product-status.php' );
            require_once( ELECTRON_PLUGIN_PATH . '/widgets/woocommerce/wp-widgets/widget-product-categories.php' );
            require_once( ELECTRON_PLUGIN_PATH . '/widgets/woocommerce/wp-widgets/widget-layered-nav.php' );
            require_once( ELECTRON_PLUGIN_PATH . '/widgets/woocommerce/wp-widgets/widget-product-discount.php' );

            if ( isset( $electron_options['brands_visibility'] ) && '0' != $electron_options['brands_visibility'] ) {
                require_once( ELECTRON_PLUGIN_PATH . '/widgets/woocommerce/brands/brands.php' );
            }

            if ( isset( $electron_options['swatches_visibility'] ) && '0' != $electron_options['swatches_visibility'] ) {
                require_once( ELECTRON_PLUGIN_PATH . '/classes/class-swatches.php' );
            }

            if ( isset( $electron_options['quick_view_visibility'] ) && '0' != $electron_options['quick_view_visibility'] ) {
                require_once( ELECTRON_PLUGIN_PATH . '/classes/class-quick-view.php' );
            }

            if ( isset( $electron_options['wishlist_visibility'] ) && '0' != $electron_options['wishlist_visibility'] ) {
                require_once( ELECTRON_PLUGIN_PATH . '/classes/class-wishlist.php' );
            }

            if ( isset( $electron_options['compare_visibility'] ) && '0' != $electron_options['compare_visibility'] ) {
                require_once( ELECTRON_PLUGIN_PATH . '/classes/class-compare.php' );
            }

            if ( isset( $electron_header_options['ajax_search_form_visibility'] ) && '0' != $electron_header_options['ajax_search_form_visibility'] ) {
                require_once( ELECTRON_PLUGIN_PATH . '/widgets/woocommerce/product-search/class-ajax-product-search.php' );
            }

            add_action( 'wp_ajax_electron_ajax_tab_slider', [ $this, 'electron_ajax_tab_slider_handler' ] );
            add_action( 'wp_ajax_nopriv_electron_ajax_tab_slider', [ $this, 'electron_ajax_tab_slider_handler' ] );
            add_action( 'woocommerce_single_product_summary', [ $this, 'electron_product_share_buttons' ], 90 );

            // Verileri çekme işlemini WordPress AJAX olarak tanımlayın
            add_action('wp_ajax_fetch_data_for_select2', [ $this, 'fetch_data_for_select2' ]);
        }

        // Categories registered
        add_action( 'elementor/elements/categories_registered', [ $this, 'electron_add_widget_category' ] );
        // Widgets registered
        add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
        add_action( 'elementor/widgets/register', [ $this, 'init_woo_widgets' ] );

        // Register Widget Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'widget_scripts' ] );
        // Register Widget Scripts
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'widget_front_scripts' ] );

        add_action('elementor/editor/after_enqueue_scripts', [ $this, 'admin_custom_scripts' ]);

        add_shortcode( 'electron-template', [ $this, 'electron_elementor_shortcode' ] );
    }

    public function electron_register_template( $localized_settings, $config )
    {
        $localized_settings = [
            'i18n' => [
                'my_templates' => esc_html__( 'Electron Templates', 'electron' )
            ]
        ];
        return $localized_settings;
    }

    public function admin_custom_scripts()
    {
        // Elementor Editor custom css
        wp_enqueue_style( 'electron-custom-editor', ELECTRON_PLUGIN_URL. 'assets/front/css/plugin-editor.css' );
        wp_enqueue_script( 'electron-custom-editor', plugins_url( 'assets/admin/js/plugin-editor-scripts.js', __FILE__ ) );
    }

    public function widget_front_scripts()
    {
        wp_enqueue_script( 'electron-addons-custom-scripts', ELECTRON_PLUGIN_URL. 'assets/front/js/custom-scripts.js', [ 'jquery' ], ELECTRON_PLUGIN_VERSION, true );
    }

    public function widget_scripts()
    {
        // vegas slider
        wp_register_style( 'vegas', ELECTRON_PLUGIN_URL. 'assets/front/js/vegas/vegas.css', '1.0', false );
        wp_register_script( 'vegas', ELECTRON_PLUGIN_URL. 'assets/front/js/vegas/vegas.min.js', array( 'jquery' ), '1.0', true );

        // animated-headline
        wp_register_style( 'animated-headline', ELECTRON_PLUGIN_URL. 'assets/front/js/animated-headline/style.css');
        wp_register_script( 'animated-headline', ELECTRON_PLUGIN_URL. 'assets/front/js/animated-headline/script.js', [ 'jquery','elementor-frontend' ], '1.0.0', true);

        // isotope
        wp_register_script( 'isotope', ELECTRON_PLUGIN_URL. 'assets/front/js/isotope/isotope.min.js', array( 'jquery' ), false, '1.0' );
        wp_register_script( 'imagesloaded', ELECTRON_PLUGIN_URL. 'assets/front/js/isotope/imagesloaded.pkgd.min.js', array( 'jquery' ), false, '1.0' );
        wp_register_script( 'anime', ELECTRON_PLUGIN_URL. 'assets/front/js/anime/anime.min.js', array( 'jquery' ), false, '1.0' );
        wp_register_script( 'slide-show', ELECTRON_PLUGIN_URL. 'assets/front/js/slide-show.js', array( 'jquery' ), false, '1.0' );

        // isotope
        wp_register_style( 'cbp', ELECTRON_PLUGIN_URL . 'assets/front/js/cbp/cubeportfolio.min.css', false, '1.0' );
        wp_register_style( 'cbp-custom', ELECTRON_PLUGIN_URL . 'assets/front/js/cbp/cubeportfolio-custom.css', false, '1.0' );
        wp_register_script( 'cbp', ELECTRON_PLUGIN_URL. 'assets/front/js/cbp/cubeportfolio.min.js', array( 'jquery' ), false, '1.0' );

        // jarallax
        wp_register_script( 'jarallax', ELECTRON_PLUGIN_URL. 'assets/front/js/jarallax/jarallax.min.js', array( 'jquery' ), false, '1.0' );
        wp_register_script( 'instafeed', ELECTRON_PLUGIN_URL. 'assets/front/js/instafeed/instafeed.min.js', array( 'jquery' ), false, '1.0' );

        // widget-tab-slider
        wp_register_script( 'widget-tab-slider', ELECTRON_PLUGIN_URL . 'assets/front/js/ajax-tab-slider/script.js', array('jquery'), '1.0.0', true );
    }

    /**
    * Admin notice
    *
    * Warning when the site doesn't have Elementor installed or activated.
    *
    * @since 1.0
    *
    * @access public
    */
    public function electron_admin_notice_missing_main_plugin()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '%1$s requires %2$s to be installed and activated.', 'electron' ),
            '<strong>' . esc_html__( 'Electron Elementor Addons', 'electron' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'electron' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required Elementor version.
    *
    * @since 1.0
    *
    * @access public
    */
    public function electron_admin_notice_minimum_elementor_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '%1$s requires %2$s version %3$s or greater.', 'electron' ),
            '<strong>' . esc_html__( 'Electron Elementor Addons', 'electron' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'electron' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required PHP version.
    *
    * @since 1.0
    *
    * @access public
    */
    public function electron_admin_notice_minimum_php_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '%1$s requires %2$s version %3$s or greater.', 'electron' ),
            '<strong>' . esc_html__( 'Electron Elementor Addons', 'electron' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'electron' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Register Widgets Category
    *
    */
    public function electron_add_widget_category( $elements_manager )
    {
        $elements_manager->add_category( 'electron', [ 'title' => esc_html__( 'Electron Basic', 'electron' ),'icon' => 'fa fa-smile-o' ] );
        $elements_manager->add_category( 'electron-post', [ 'title' => esc_html__( 'Electron Post', 'electron' ) ] );
        $elements_manager->add_category( 'electron-woo', [ 'title' => esc_html__( 'Electron WooCommerce', 'electron' ) ] );
        $elements_manager->add_category( 'electron-woo-product', [ 'title' => esc_html__( 'Electron WooCommerce Product', 'electron' ) ] );
    }

    public function electron_widgets_list()
    {
        $list = array(
            array( 'name' => 'menu',                'class' => 'Electron_Menu_Dropdown' ),
            //array( 'name' => 'menu-vertical',       'class' => 'Electron_Vertical_Menu' ),
            array( 'name' => 'button',              'class' => 'Electron_Button' ),
            array( 'name' => 'label',               'class' => 'Electron_Label' ),
            array( 'name' => 'animated-headline',   'class' => 'Electron_Animated_Headline' ),
            array( 'name' => 'home-slider',         'class' => 'Electron_Home_Slider' ),
            //array( 'name' => 'swiper-template',     'class' => 'Electron_Template_Slider' ),
            array( 'name' => 'slide-show',          'class' => 'Electron_Slide_Show' ),
            array( 'name' => 'posts-base',          'class' => 'Electron_Posts_Base' ),
            array( 'name' => 'breadcrumbs',         'class' => 'Electron_Breadcrumbs' ),
            array( 'name' => 'image-slider',        'class' => 'Electron_Images_Slider' ),
            array( 'name' => 'team',                'class' => 'Electron_Team_Slider' ),
            array( 'name' => 'instagram-slider',    'class' => 'Electron_Instagram_Slider' ),
            array( 'name' => 'fetatures-item',      'class' => 'Electron_Features_Item' ),
            array( 'name' => 'timer',               'class' => 'Electron_Timer' ),
            array( 'name' => 'contact-form-7',      'class' => 'Electron_Contact_Form_7' ),
            array( 'name' => 'testimonials-slider', 'class' => 'Electron_Testimonials' ),
            array( 'name' => 'vegas-template',      'class' => 'Electron_Vegas_Template' ),
            array( 'name' => 'gallery',             'class' => 'Electron_Portfolio' )
        );
        return $list;
    }

    /**
    * Init Widgets
    */
    public function init_widgets()
    {
        $widgets = $this->electron_widgets_list();

        if ( ! empty( $widgets ) ) {

            foreach ( $widgets as $widget ) {

                $option = 'disable_'.str_replace( '-', '_', $widget['name'] );
                $path = ELECTRON_PLUGIN_PATH . '/widgets/';
                $file = $widget['name'] . '.php';
                $file = isset( $widget['subfolder'] ) != '' ? $path.$widget['subfolder'] . '/' . $widget['name']. '.php' : $path.$file;
                $class = 'Elementor\\'.$widget['class'];

                if ( ! get_option( $option ) == 1 ) {

                    if ( file_exists( $file ) ) {
                        require_once( $file );
                        \Elementor\Plugin::instance()->widgets_manager->register( new $class() );
                    }
                }
            }
        }
    }

    public function electron_woo_widgets_list()
    {
        // wocommerce widgets
        $list = array(
            array( 'name' => 'woo-tab-two',             'subfolder' => 'woocommerce', 'class' => 'Electron_Tab_Two' ),
            array( 'name' => 'woo-tab-slider',          'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Ajax_Tab_Slider' ),
            array( 'name' => 'woo-grid',                'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Grid' ),
            array( 'name' => 'woo-grid-masonry',        'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Grid_Masonry' ),
            array( 'name' => 'woo-slider',              'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Slider' ),
            array( 'name' => 'woo-taxonomy-products',   'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Taxonomy_Products' ),
            array( 'name' => 'woo-category-grid',       'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Category_Grid' ),
            array( 'name' => 'woo-taxonomy-list',       'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Taxonomy_List' ),
            array( 'name' => 'woo-list',                'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Products_List' ),
            array( 'name' => 'woo-gallery',             'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Gallery' ),
            array( 'name' => 'woo-banner',              'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Banner' ),
            array( 'name' => 'woo-banner2',             'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Banner2' ),
            array( 'name' => 'woo-banner-slider',       'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Banner_Slider' ),
            array( 'name' => 'woo-brands',              'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Brands' ),
            array( 'name' => 'woo-custom-reviews',      'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Custom_Reviews' ),
            array( 'name' => 'woo-ajax-search',         'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Ajax_Search' ),
            array( 'name' => 'woo-archive-description', 'subfolder' => 'woocommerce', 'class' => 'Electron_WC_Archive_Description' ),
            array( 'name' => 'woo-page-title',          'subfolder' => 'woocommerce', 'class' => 'Electron_WC_Page_Title' ),
            array( 'name' => 'woo-product-item',        'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Product_Item' ),
            array( 'name' => 'woo-special-offer',       'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Special_Offer' ),
            array( 'name' => 'woo-special-offer-single','subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Special_Offer_Single' ),
            array( 'name' => 'woo-creative-slider',     'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Creative_Slider' ),
            array( 'name' => 'woo-creative-slider2',    'subfolder' => 'woocommerce', 'class' => 'Electron_Woo_Creative_Slider2' )
        );
        return $list;
    }

    /**
    * Init Widgets
    */
    public function init_woo_widgets()
    {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }
        $widgets = $this->electron_woo_widgets_list();

        if ( ! empty( $widgets ) ) {

            foreach ( $widgets as $widget ) {

                $option = 'disable_'.str_replace( '-', '_', $widget['name'] );
                $path = ELECTRON_PLUGIN_PATH . '/widgets/';
                $file = $widget['name'] . '.php';
                $file = isset( $widget['subfolder'] ) != '' ? $path.$widget['subfolder'] . '/' . $widget['name']. '.php' : $path.$file;
                $class = 'Elementor\\'.$widget['class'];

                if ( ! get_option( $option ) == 1 ) {

                    if ( file_exists( $file ) ) {
                        require_once( $file );
                        \Elementor\Plugin::instance()->widgets_manager->register( new $class() );
                    }
                }
            }
        }
    }

    /**
    * Register Single Post Widgets
    */
    public function electron_single_widgets_list()
    {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }
        $list = array(
            // post widgets
            array( 'post-type' => 'post', 'name' => 'post-data', 'class' => 'Electron_Post_Data' ),
            // wocommerce widgets
            array( 'post-type' => 'product','name' => 'add-to-cart',                    'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Add_To_Cart' ),
            array( 'post-type' => 'product','name' => 'breadcrumb',                     'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Breadcrumb' ),
            array( 'post-type' => 'product','name' => 'product-add-to-cart',            'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Add_To_Cart' ),
            array( 'post-type' => 'product','name' => 'product-additional-information', 'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Additional_Information' ),
            array( 'post-type' => 'product','name' => 'product-data-tabs',              'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Data_Tabs' ),
            array( 'post-type' => 'product','name' => 'product-images',                 'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Images' ),
            array( 'post-type' => 'product','name' => 'product-meta',                   'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Meta' ),
            array( 'post-type' => 'product','name' => 'product-price',                  'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Price' ),
            array( 'post-type' => 'product','name' => 'product-rating',                 'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Rating' ),
            array( 'post-type' => 'product','name' => 'product-related',                'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Related' ),
            array( 'post-type' => 'product','name' => 'product-short-description',      'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Short_Description' ),
            array( 'post-type' => 'product','name' => 'product-stock',                  'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Stock' ),
            array( 'post-type' => 'product','name' => 'product-title',                  'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Title' ),
            array( 'post-type' => 'product','name' => 'product-upsell',                 'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Product_Upsell' ),
            array( 'post-type' => 'product','name' => 'single-elements',                'subfolder' => 'woocommerce/product', 'class' => 'Electron_WC_Single_Elements' )
        );
        return $list;
    }

    /**
    * Init Single Post Widgets
    */
    public function init_single_widgets()
    {
        $widgets = $this->electron_single_widgets_list();
        global $post;
        $electron_post_type = false;

        if ( ! empty( $widgets ) && !is_404() && !is_archive() ) {

            $electron_post_type = get_post_type( $post->ID );

            $count = 0;

            foreach ( $widgets as $widget ) {

                if ( $electron_post_type == $widgets[$count]['post-type'] || $electron_post_type == 'elementor_library' ) {

                    $option = 'disable_'.str_replace( '-', '_', $widget['name'] );
                    $path = ELECTRON_PLUGIN_PATH . '/widgets/';
                    $file = $widget['name'] . '.php';
                    $file = isset( $widget['subfolder'] ) != '' ? $path.$widget['subfolder'] . '/' . $widget['name']. '.php' : $path.$file;
                    $class = 'Elementor\\'.$widget['class'];

                    if ( ! get_option( $option ) == 1 ) {

                        if ( file_exists( $file ) ) {
                            require_once( $file );
                            \Elementor\Plugin::instance()->widgets_manager->register( new $class() );
                        }
                    }
                }
                $count++;
            }
        }
    }

    /**
    * Shortcode to output an Elementor Saved Template by given ID.
    *
    * @since 1.0.0
    *
    * @uses \Elementor\Plugin::$instance
    *
    * @param array|string $atts Shortcode attributes. Empty string if no attributes.
    * @return string Output for `footer_home_link` shortcode.
    */
    public function electron_elementor_shortcode( $atts = [] ) {

        /** Set default shortcode attributes */
        $defaults = array(
            'id' => '',
            'css' => 'false'
        );

        /** Default shortcode attributes */
        $atts = shortcode_atts( $defaults, $atts, 'electron-template' );

        if ( empty( $atts[ 'id' ] ) ) {
            return '';
        }

        $include_css = false;

        if ( isset( $atts[ 'css' ] ) && 'false' !== $atts[ 'css' ] ) {
            $include_css = (bool) $atts[ 'css' ];
        }
        $frontend = new \Elementor\Frontend;

        return $frontend->get_builder_content_for_display( $atts[ 'id' ], $include_css );
    }

    public function electron_ajax_tab_slider_handler() {
        global $product;
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $_POST['per_page'],
            'order'          => $_POST['order'],
            'orderby'        => $_POST['orderby']
        );
        if ( $_POST['cat_id'] != null ) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => $_POST['cat_id']
            );
        }

        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) {
            while ( $loop->have_posts() ) {
                $loop->the_post();
                $product = new WC_Product(get_the_ID());
                if ( !empty( $product ) && $product->is_visible() ) {
                    echo '<div class="swiper-slide product_item">';
                        wc_get_template_part( 'content', 'product' );
                    echo '</div>';
                }
            }
        } else {
            echo esc_html__( 'No products found','electron' );
        }
        wp_reset_postdata();

        wp_die();
    }

    /**
    * ------------------------------------------------------------------------------------------------
    * Single product share buttons
    * ------------------------------------------------------------------------------------------------
    */
    public function electron_product_share_buttons()
    {
        if ( !function_exists( 'electron_settings' ) ) {
            return;
        }
        if ( '1' == electron_settings( 'single_shop_share_visibility', '0' ) ) {

            $type = electron_settings( 'single_shop_share_type' );
            $title = 'share' === $type ? esc_html__( 'Share', 'electron' ) : esc_html__( 'Follow', 'electron' );
            ?>
            <div class="electron-summary-item electron-product-share">
                <span class="share-title electron-small-title"><?php echo esc_html( $title ); ?>: </span> <?php $this->electron_shortcode_social( array( 'type' => $type ) ); ?>
            </div>
            <?php
        }
    }

	public function electron_shortcode_social($args) {

        if ( !function_exists( 'electron_settings' ) ) {
            return;
        }

        $def_args = array(
            'type' => 'share',
            'page_link' => false
        );

        $type       = !empty( $args ) ? $args['type'] : $def_args['type'];
        $page_link  = !empty( $args ) && isset( $args['page_link'] ) ? $args['page_link'] : $def_args['page_link'];
        $target     = "_blank";

        $thumb_id   = get_post_thumbnail_id();
        $thumb_url  = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
        $page_title = get_the_title();

        if ( ! $page_link ) {
            $page_link = get_the_permalink();
        }

        if ( class_exists( 'WooCommerce' ) && is_shop() ) {
            $page_link = get_permalink( get_option( 'woocommerce_shop_page_id' ) );
        }

        if ( class_exists( 'WooCommerce' ) && ( is_product_category() || is_category() ) ) {
            $page_link = get_category_link( get_queried_object()->term_id );
        }

        if ( is_home() && ! is_front_page() ) {
            $page_link = get_permalink( get_option( 'page_for_posts' ) );
        }

        ?>
        <div class="electron-social-icons">
            <?php if ( '1' == electron_settings( 'share_facebook', '0' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'fb_link' )) : 'https://www.facebook.com/sharer/sharer.php?u=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-facebook" data-title="facebook">
                    <i class="nt-icon-facebook"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_twitter', '0') ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'twitter_link' )) : 'https://twitter.com/share?url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-twitter" data-title="X">
                    <i class="nt-icon-twitter-new"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_instagram', '0') && $type == 'follow' && '' != electron_settings( 'instagram_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'instagram_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-instagram" data-title="instagram">
                    <i class="nt-icon-instagram"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_youtube', '0') && $type == 'follow' && '' != electron_settings( 'youtube_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'youtube_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-youtube" data-title="youtube">
                    <i class="nt-icon-youtube"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_vimeo', '0') && $type == 'follow' && '' != electron_settings( 'vimeo_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( electron_settings( 'vimeo_link' ) ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-vimeo" data-title="vimeo">
                    <i class="nt-icon-vimeo"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_pinterest', '0') ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'pinterest_link' )) : 'https://pinterest.com/pin/create/button/?url=' . $page_link . '&media=' . $thumb_url[0] . '&description=' . urlencode( $page_title ); ?>" target="<?php echo esc_attr( $target ); ?>" class="social-pinterest" data-title="pinterest">
                    <i class="nt-icon-pinterest"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_linkedin', '0') ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'linkedin_link' )) : 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-linkedin" data-title="linkedin">
                    <i class="nt-icon-linkedin"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_tumblr', '0') && $type == 'follow' && '' != electron_settings( 'tumblr_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'tumblr_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-tumblr" data-title="tumblr">
                    <i class="nt-icon-tumblr"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_flickr', '0') && $type == 'follow' && '' != electron_settings( 'flickr_link' ) ): ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'flickr_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-flickr" data-title="flickr">
                    <i class="nt-icon-flickr"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_github', '0') && $type == 'follow' && '' != electron_settings( 'github_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'github_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-github" data-title="github">
                    <i class="nt-icon-github"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_behance', '0') && $type == 'follow' && '' != electron_settings( 'behance_link' ) ): ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'behance_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-behance" data-title="behance">
                    <i class="nt-icon-behance"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_dribbble', '0') && $type == 'follow' && '' != electron_settings( 'dribbble_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'dribbble_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-dribbble" data-title="dribbble">
                    <i class="nt-icon-dribbble"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_soundcloud', '0') && $type == 'follow' && '' != electron_settings( 'soundcloud_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'soundcloud_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-soundcloud" data-title="soundcloud">
                    <i class="nt-icon-soundcloud"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_spotify', '0') && $type == 'follow' && '' != electron_settings( 'spotify_link' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'spotify_link' )) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-spotify" data-title="spotify">
                    <i class="nt-icon-spotify"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_ok', '0') ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url(electron_settings( 'ok_link' )) : 'https://connect.ok.ru/offer?url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-ok" data-title="ok">
                    <i class="nt-icon-odnoklassniki-square"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_whatsapp', '0') ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? ( electron_settings( 'whatsapp_link' )) : 'https://api.whatsapp.com/send?text=' . urlencode( $page_link ); ?>" target="<?php echo esc_attr( $target ); ?>" class="whatsapp-desktop social-whatsapp" data-title="whatsapp">
                    <i class="nt-icon-whatsapp"></i>
                </a>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? ( electron_settings( 'whatsapp_link' ) ) : 'whatsapp://send?text=' . urlencode( $page_link ); ?>" target="<?php echo esc_attr( $target ); ?>" class="whatsapp-mobile social-whatsapp" data-title="whatsapp">
                    <i class="nt-icon-whatsapp"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_telegram', '0') ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? ( electron_settings( 'tg_link' )) : 'https://telegram.me/share/url?url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-telegram" data-title="telegram">
                    <i class="nt-icon-telegram"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_viber', '0') && $type == 'share' && electron_settings( 'share_viber' ) ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'viber://forward?text=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-viber" data-title="viber">
                    <i class="nt-icon-viber"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_vk', '0') ) : ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? ( electron_settings( 'vk_link' )) : 'https://vk.com/share.php?url=' . $page_link . '&image=' . $thumb_url[0] . '&title=' . $page_title; ?>" target="<?php echo esc_attr( $target ); ?>" class="social-vk" data-title="vk">
                    <i class="nt-icon-vk"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_snapchat', '0') && $type == 'follow' && '' != electron_settings( 'snapchat_link' ) ): ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo electron_settings( 'snapchat_link' ); ?>" target="<?php echo esc_attr( $target ); ?>" class="social-snapchat" data-title="snapchat">
                    <i class="nt-icon-snapchat"></i>
                </a>
            <?php endif ?>

            <?php if ( '1' == electron_settings('share_tiktok', '0') && $type == 'follow' && '' != electron_settings( 'tiktok_link' ) ): ?>
                <a rel="noopener noreferrer nofollow" href="<?php echo electron_settings( 'tiktok_link' ); ?>" target="<?php echo esc_attr( $target ); ?>" class="social-tiktok" data-title="tiktok">
                    <i class="nt-icon-tiktok"></i>
                </a>
            <?php endif ?>

        </div>
        <?php
    }

    // Verileri AJAX ile çeken işlev
    public function fetch_data_for_select2() {

        if ( $_POST['data_type'] == 'product' ) {
            $list = get_posts(
                array(
                    'post_type'      => 'product',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'posts_per_page' => -1
                )
            );

            $options = array(
                'none' => 'Select Product'
            );

            if ( ! empty( $list ) && ! is_wp_error( $list ) ) {
                foreach ( $list as $post ) {
                    $options[ $post->ID ] = $post->post_title;
                }
            }
        }

        if ( $_POST['data_type'] == 'product_cat' ) {
            $terms = get_terms( 'product_cat' );
            if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
                foreach ( $terms as $term ) {
                    if ( !empty( $term ) && !is_wp_error( $term ) ) {
                        $options[$term->term_id] = $term->name;
                    }
                }
            }
        }

        wp_send_json($options);
    }
}
Electron_Elementor_Addons::instance();
