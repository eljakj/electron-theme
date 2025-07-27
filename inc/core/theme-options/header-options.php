<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (! class_exists('Redux' ) ) {
    return;
}

$electron_header_pre = "electron_header";

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$electron_theme = wp_get_theme(); // For use with some settings. Not necessary.

$electron_header_options_args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name' => $electron_header_pre,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $electron_theme->get('Name' ),
    // Name that appears at the top of your panel
    'display_version' => $electron_theme->get('Version' ),
    // Version that appears at the top of your panel
    'menu_type' => 'submenu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => false,
    'hide_expand' => false,
    'flyout_submenus' => false,
    // Show the sections below the admin menu item or not
    'menu_title' => esc_html__( 'Header Builder', 'electron' ),
    'page_title' => esc_html__( 'Header Builder', 'electron' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key' => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography' => false,
    // Use a asynchronous font on the front end or font string
    'admin_bar' => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-admin-generic',
    // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50,
    // Choose an priority for the admin bar menu
    'global_variable' => 'electron_header',
    // Set a different name for your global variable other than the electron_pre
    'dev_mode' => false,
    // Show the time the page took to load, etc
    'update_notice' => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => true,
    // Enable basic customizer support

    // OPTIONAL -> Give you extra features
    'page_priority' => 99,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => 'ninetheme_theme_manage',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon' => '',
    // Specify a custom URL to an icon
    'last_tab' => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug' => 'electron_header',
    // Page slug used to denote the panel, will be based off page title then menu title then electron_pre if not provided
    'save_defaults' => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show' => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn' => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints' => array(
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'dark',
            'shadow' => true,
            'rounded' => false,
            'style' => '',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'click mouseleave',
            ),
        ),
    )
);

Redux::setArgs($electron_header_pre, $electron_header_options_args);
$el_args = array(
    'post_type'      => 'elementor_library',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'meta_query'     => array(
        'relation' => 'OR',
        array(
            'key'     => '_elementor_template_type',
            'value'   => 'section',
            'compare' => '='
        ),
        array(
            'key'     => '_elementor_template_type',
            'value'   => 'container',
            'compare' => '='
        )
    )
);
/*************************************************
## HEADER & NAV SECTION
*************************************************/
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header General', 'electron' ),
    'id' => 'header_section',
    'icon' => 'fa fa-bars',
    'fields' => array(
        array(
            'title' => esc_html__( 'Header Display', 'electron' ),
            'subtitle' => esc_html__( 'You can enable or disable the site navigation.', 'electron' ),
            'customizer' => true,
            'id' => 'header_visibility',
            'type' => 'switch',
            'default' => 1
        ),
        array(
            'id' => 'header_template',
            'type' => 'button_set',
            'title' => esc_html__( 'Header Template', 'electron' ),
            'subtitle' => esc_html__( 'Select your header template.', 'electron' ),
            'customizer' => true,
            'options' => array(
                'default' => esc_html__( 'Top Header', 'electron' ),
                'elementor' => esc_html__( 'Elementor Templates', 'electron' )
            ),
            'default' => 'default',
            'required' => array( 'header_visibility', '=', '1' )
        ),
        array(
            'id' =>'header_default_style',
            'type' => 'button_set',
            'title' => esc_html__( 'Header Style', 'electron' ),
            'subtitle' => esc_html__( 'Select your header template style.', 'electron' ),
            'customizer' => true,
            'options' => array(
                'style-1' => esc_html__( 'Style 1', 'electron' ),
                'style-2' => esc_html__( 'Style 2', 'electron' ),
                'style-3' => esc_html__( 'Style 3', 'electron' ),
                'style-4' => esc_html__( 'Style 4', 'electron' ),
                'style-5' => esc_html__( 'Style 5', 'electron' ),
                'style-6' => esc_html__( 'Style 6', 'electron' ),
                'style-7' => esc_html__( 'Style 7', 'electron' )
            ),
            'default' => 'style-1',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'title' => esc_html__( 'Elementor Templates', 'electron' ),
            'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
            'customizer' => true,
            'id' => 'header_elementor_templates',
            'type' => 'select',
            'data' => 'posts',
            'args'  => $el_args,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'elementor' )
            )
        )
    )
));
//HEADER MOBILE TOP
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Promotion Bar', 'electron' ),
    'id' => 'header_promotion_bar_section',
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Promotion Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_promotion_visibility',
            'type' => 'switch',
            'default' => 0,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'title' => esc_html__( 'Promotion text', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_promotion_text',
            'type' => 'textarea',
            'default' => '"Today\'s lucky visitor! Get this product at a 20% discount within the next 30 minutes!"',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_promotion_visibility', '=', '1' ),
            )
        ),
        array(
            'id' =>'header_promotion_bgtype',
            'type' => 'button_set',
            'title' => esc_html__( 'Background Color Type', 'electron' ),
            'customizer' => true,
            'options' => array(
                'grad' => esc_html__( 'Gradient', 'electron' ),
                'bg' => esc_html__( 'Color', 'electron' ),
            ),
            'default' => 'grad',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_promotion_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_promotion_bg',
            'type' => 'color_rgba',
            'mode' => 'background-color',
            'output' => array( '.electron-promotion-bar,.electron-promotion-bar.grad-anim-1' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_promotion_visibility', '=', '1' ),
                array( 'header_promotion_bgtype', '=', 'bg' ),
            )
        ),
        array(
            'title' => esc_html__( 'Gradient Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_promotion_gradbg',
            'type' => 'color_gradient',
            'gradient-type'  => true,
            'gradient-reach' => true,
            'gradient-angle' => true,
            'output' => array( '.electron-promotion-bar,.electron-promotion-bar.grad-anim-1' ),
            'default'=> array(
                'from' => '#000fe8',
                'to' => '#e80027',
                'gradient-reach' => array(
                    'to'   => 50,
                    'from' => 0
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_promotion_visibility', '=', '1' ),
                array( 'header_promotion_bgtype', '=', 'grad' ),
            )
        ),
        array(
            'title' => esc_html__( 'Mobile Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_promotion_mobile_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_promotion_visibility', '=', '1' ),
            )
        ),
    )
));
//HEADER TOP MENU
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Top', 'electron' ),
    'id' => 'header_top_section',
    'subsection' => false,
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Header Top Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'title' => esc_html__( 'Header Top Mobile Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_mobile_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' => 'header_layout_top',
            'type' => 'sorter',
            'title' => esc_html__( 'Layout Manager', 'electron' ),
            'options' => array(
                'left' => array(
                    'dropdown'  => esc_html__( 'Dropdown Menu', 'electron' ),
                    'customtext'=> esc_html__( 'Text/HTML', 'electron' ),
                ),
                'center'=> array(
                ),
                'right'=> array(
                    'shortcode' => esc_html__( 'Shortcode/HTML', 'electron' ),
                ),
                'disabled'  => array(
                    'cart'      => esc_html__( 'Cart Icon', 'electron' ),
                    'compare'   => esc_html__( 'Compare Icon', 'electron' ),
                    'wishlist'  => esc_html__( 'Wishlist Icon', 'electron' ),
                    'account'   => esc_html__( 'Account Icon', 'electron' ),
                    'search'    => esc_html__( 'Search Icon', 'electron' ),
                    'minimenu'  => esc_html__( 'Mini Menu', 'electron' ),
                    'canvas'    => esc_html__( 'Canvas Menu', 'electron' ),
                    'notice'    => esc_html__( 'Notices', 'electron' ),
                    'btn'    => esc_html__( 'Custom Button', 'electron' ),
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Responsive Options', 'electron' ),
            'id' => 'header_top_responsive_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-cog',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' => 'header_tablet_top_elements_visibility',
            'type' => 'sorter',
            'title' => esc_html__( 'Tablet Display', 'electron' ),
            'options' => array(
                'enable' => array(
                ),
                'disabled'  => array(
                    'dropdown'  => esc_html__( 'Dropdown Menu', 'electron' ),
                    'customtext'=> esc_html__( 'Text/HTML', 'electron' ),
                    'shortcode' => esc_html__( 'Shortcode/HTML', 'electron' ),
                    'cart'      => esc_html__( 'Cart Icon', 'electron' ),
                    'compare'   => esc_html__( 'Compare Icon', 'electron' ),
                    'wishlist'  => esc_html__( 'Wishlist Icon', 'electron' ),
                    'account'   => esc_html__( 'Account Icon', 'electron' ),
                    'search'    => esc_html__( 'Search Icon', 'electron' ),
                    'minimenu'  => esc_html__( 'Mini Menu', 'electron' ),
                    'canvas'    => esc_html__( 'Canvas Menu', 'electron' ),
                    'notice'    => esc_html__( 'Notices', 'electron' ),
                    'btn'       => esc_html__( 'Custom Button', 'electron' )
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' => 'header_top_mobile_col_visibility',
            'type' => 'sorter',
            'title' => esc_html__( 'Mobile Column Display', 'electron' ),
            'options' => array(
                'enable' => array(
                ),
                'disabled'  => array(
                    'left'  => esc_html__( 'Left Column', 'electron' ),
                    'customtext'=> esc_html__( 'Center Column', 'electron' ),
                    'right' => esc_html__( 'Right Column', 'electron' )
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' => 'header_mobile_top_elements_visibility',
            'type' => 'sorter',
            'title' => esc_html__( 'Mobile Elements Display', 'electron' ),
            'options' => array(
                'enable' => array(
                ),
                'disabled'  => array(
                    'dropdown'  => esc_html__( 'Dropdown Menu', 'electron' ),
                    'customtext'=> esc_html__( 'Text/HTML', 'electron' ),
                    'shortcode' => esc_html__( 'Shortcode/HTML', 'electron' ),
                    'cart'      => esc_html__( 'Cart Icon', 'electron' ),
                    'compare'   => esc_html__( 'Compare Icon', 'electron' ),
                    'wishlist'  => esc_html__( 'Wishlist Icon', 'electron' ),
                    'account'   => esc_html__( 'Account Icon', 'electron' ),
                    'search'    => esc_html__( 'Search Icon', 'electron' ),
                    'minimenu'  => esc_html__( 'Mini Menu', 'electron' ),
                    'canvas'    => esc_html__( 'Canvas Menu', 'electron' ),
                    'notice'    => esc_html__( 'Notices', 'electron' ),
                    'btn'       => esc_html__( 'Custom Button', 'electron' ),
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Custom Text/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_text_top',
            'type' => 'textarea',
            'default' => '<a href="tel:280 900 3434"><i aria-hidden="true" class="electron-icons flaticon-24-hours-support"></i><span>280 900 3434<span class="phone-text">Call Anytime</span></span></a>',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Shortcode/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_shortcode_top',
            'type' => 'textarea',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Custom Button Title', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom button title here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_btn_title_top',
            'type' => 'text',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'header_top_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Height', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header height.', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_height',
            'type' => 'dimensions',
            'width' => false,
            'output' => array( '.electron-header-top' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_bg',
            'type' => 'color_rgba',
            'mode' => 'background-color',
            'output' => array( '.electron-header-top' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Border', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_brd',
            'type' => 'border',
            'all' => false,
            'output' => array( '.electron-header-top' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Text Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_text_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-top,.electron-header-top .header-top-text,.electron-header-top ul>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'SVG Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_icon_color',
            'type' => 'color',
            'mode' => 'fill',
            'output' => array( '.electron-header-top .top-action-btn svg' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_counter_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-top .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Number Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_top_counter_color',
            'type' => 'color',
            'output' => array( '.electron-header-top .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        )
    )
));
//HEADER MIDDLE MENU
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Middle', 'electron' ),
    'id' => 'header_middle_section',
    'subsection' => false,
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Header Middle Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' =>'header_layout_middle',
            'type' => 'sorter',
            'customizer' => true,
            'title' => esc_html__( 'Layout Manager', 'electron' ),
            'options' => array(
                'left' => array(
                    'logo'         => esc_html__( 'Logo', 'electron' ),
                    'canvas'       => esc_html__( 'Canvas Menu', 'electron' ),
                ),
                'center'=> array(
                    'search-form'  => esc_html__( 'Search Form', 'electron' ),
                ),
                'right'=> array(
                    'login'        => esc_html__( 'Login Text', 'electron' ),
                    'cart'         => esc_html__( 'Cart Icon', 'electron' ),
                    'compare'      => esc_html__( 'Compare Icon', 'electron' ),
                    'wishlist'     => esc_html__( 'Wishlist Icon', 'electron' ),
                    'account'      => esc_html__( 'Account Icon', 'electron' ),
                ),
                'disabled'  => array(
                    'search'       => esc_html__( 'Search Icon', 'electron' ),
                    'menu'         => esc_html__( 'Menu', 'electron' ),
                    'catmenu'      => esc_html__( 'Category Menu', 'electron' ),
                    'shortcode'    => esc_html__( 'Shortcode/HTML', 'electron' ),
                    'dropdown'     => esc_html__( 'Dropdown Menu', 'electron' ),
                    'customtext'   => esc_html__( 'Text/HTML', 'electron' ),
                    'minimenu'     => esc_html__( 'Mini Menu', 'electron' ),
                    'notice'       => esc_html__( 'Notices', 'electron' )
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Custom Text/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_text_middle',
            'type' => 'textarea',
            'default' => '<a href="tel:280 900 3434"><i aria-hidden="true" class="electron-icons flaticon-24-hours-support"></i><span>280 900 3434<span class="phone-text">Call Anytime</span></span></a>',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Shortcode/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_shortcode_middle',
            'type' => 'textarea',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'header_middle_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Height', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header height.', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_height',
            'type' => 'dimensions',
            'width' => false,
            'output' => array( '.electron-header-middle' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_bg',
            'type' => 'color_rgba',
            'mode' => 'background-color',
            'output' => array( '.electron-header-middle' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Border', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_brd',
            'type' => 'border',
            'all' => false,
            'output' => array( '.electron-header-middle' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Text Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_text_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-middle,.electron-header-middle .header-top-text,.electron-header-middle ul>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'SVG Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_icon_color',
            'type' => 'color',
            'mode' => 'fill',
            'output' => array( '.electron-header-middle .top-action-btn svg' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_counter_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-middle .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Number Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_counter_color',
            'type' => 'color',
            'output' => array( '.electron-header-middle .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_middle_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_mitem_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom ul>li>a,.bg-light .electron-header-bottom .nav >li> a,.bg-light .electron-header-bottom .header-mainmenu>ul>li>a,.electron-header-bottom .header-mainmenu .dropdown-btn,.electron-header-bottom .bg-light .header-mainmenu .submenu>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_mitem_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom ul>li>a:hover,.bg-light .electron-header-bottom .nav >li> a:hover,.bg-light .electron-header-bottom .header-mainmenu>ul>li>a:hover,.electron-header-bottom .header-mainmenu>ul>li>a:hover .dropdown-btn,.electron-header-bottom .bg-light .header-mainmenu .submenu>li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_smitem_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-bottom .header-mainmenu .nav>li>.submenu,.electron-header-bottom .header-mainmenu .nav>li>.submenu .submenu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_smitem_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom .header-mainmenu .submenu>li>a,.bg-light .electron-header-bottom .header-mainmenu .submenu>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_middle_smitem_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom .header-mainmenu .submenu>li>a:hover,.bg-light .electron-header-bottom .header-mainmenu .submenu>li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
    )
));
//HEADER MIDDLE MENU
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Bottom', 'electron' ),
    'id' => 'header_bottom_section',
    'subsection' => false,
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Header Bottom Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' =>'header_layout_bottom',
            'type' => 'sorter',
            'title' => esc_html__( 'Layout Manager', 'electron' ),
            'options' => array(
                'left' => array(
                    'catmenu'      => esc_html__( 'Category Menu', 'electron' ),
                    'menu'         => esc_html__( 'Menu', 'electron' )
                ),
                'center'=> array(
                ),
                'right'=> array(
                    'minimenu'     => esc_html__( 'Mini Menu', 'electron' ),
                ),
                'disabled'  => array(
                    'logo'         => esc_html__( 'Logo', 'electron' ),
                    'login'        => esc_html__( 'Login Text', 'electron' ),
                    'cart'         => esc_html__( 'Cart Icon', 'electron' ),
                    'compare'      => esc_html__( 'Compare Icon', 'electron' ),
                    'wishlist'     => esc_html__( 'Wishlist Icon', 'electron' ),
                    'search'       => esc_html__( 'Search Icon', 'electron' ),
                    'search-form'  => esc_html__( 'Search Form', 'electron' ),
                    'dropdown'     => esc_html__( 'Dropdown Menu', 'electron' ),
                    'customtext'   => esc_html__( 'Text/HTML', 'electron' ),
                    'shortcode'    => esc_html__( 'Shortcode/HTML', 'electron' ),
                    'canvas'       => esc_html__( 'Canvas Menu', 'electron' ),
                    'notice'       => esc_html__( 'Notices', 'electron' )
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Custom Text/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_text_bottom',
            'type' => 'textarea',
            'default' => '<a href="tel:280 900 3434"><i aria-hidden="true" class="electron-icons flaticon-24-hours-support"></i><span>280 900 3434<span class="phone-text">Call Anytime</span></span></a>',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Shortcode/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_shortcode_bottom',
            'type' => 'textarea',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'header_bottom_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Height', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header height.', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_height',
            'type' => 'dimensions',
            'width' => false,
            'output' => array( '.electron-header-bottom' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_bg',
            'type' => 'color_rgba',
            'mode' => 'background-color',
            'output' => array( '.electron-header-middle,.electron-header.bg-light .electron-header-middle,.electron-header-middle .header-mainmenu .nav>li>.submenu, .electron-header-middle .header-mainmenu .nav>li>.submenu .submenu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Border', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_brd',
            'type' => 'border',
            'all' => false,
            'output' => array( '.electron-header-bottom' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Text Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_text_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom,.electron-header-bottom .header-top-text,.electron-header-bottom ul>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'SVG Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_icon_color',
            'type' => 'color',
            'mode' => 'fill',
            'output' => array( '.electron-header-bottom .top-action-btn svg' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_counter_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-bottom .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Number Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_counter_color',
            'type' => 'color',
            'output' => array( '.electron-header-bottom .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_mitem_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom ul>li>a,.bg-light .electron-header-bottom .nav >li> a,.bg-light .electron-header-bottom .header-mainmenu>ul>li>a,.electron-header-bottom .header-mainmenu .dropdown-btn,.electron-header-bottom .bg-light .header-mainmenu .submenu>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_mitem_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom ul>li>a:hover,.bg-light .electron-header-bottom .nav >li> a:hover,.bg-light .electron-header-bottom .header-mainmenu>ul>li>a:hover,.electron-header-bottom .header-mainmenu>ul>li>a:hover .dropdown-btn,.electron-header-bottom .bg-light .header-mainmenu .submenu>li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_smitem_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-bottom .header-mainmenu .nav>li>.submenu,.electron-header-bottom .header-mainmenu .nav>li>.submenu .submenu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_smitem_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom .header-mainmenu .submenu>li>a,.bg-light .electron-header-bottom .header-mainmenu .submenu>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_bottom_smitem_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-bottom .header-mainmenu .submenu>li>a:hover,.bg-light .electron-header-bottom .header-mainmenu .submenu>li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_bottom_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
    )
));
//HEADER MIDDLE MENU
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Sticky', 'electron' ),
    'id' => 'header_sticky_section',
    'subsection' => false,
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Header Sticky Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' =>'header_layout_sticky',
            'type' => 'sorter',
            'title' => esc_html__( 'Layout Manager', 'electron' ),
            'options' => array(
                'left' => array(
                    'logo'         => esc_html__( 'Logo', 'electron' ),
                    'canvas'       => esc_html__( 'Canvas Menu', 'electron' )
                ),
                'center'=> array(
                    'menu'         => esc_html__( 'Menu', 'electron' ),
                ),
                'right'=> array(
                    'login'        => esc_html__( 'Login Text', 'electron' ),
                    'cart'         => esc_html__( 'Cart Icon', 'electron' ),
                    'compare'      => esc_html__( 'Compare Icon', 'electron' ),
                    'wishlist'     => esc_html__( 'Wishlist Icon', 'electron' ),
                    'account'      => esc_html__( 'Account Icon', 'electron' )
                ),
                'disabled'  => array(
                    'search'       => esc_html__( 'Search Icon', 'electron' ),
                    'search-form'  => esc_html__( 'Search Form', 'electron' ),
                    'catmenu'      => esc_html__( 'Category Menu', 'electron' ),
                    'shortcode'    => esc_html__( 'Shortcode/HTML', 'electron' ),
                    'dropdown'     => esc_html__( 'Dropdown Menu', 'electron' ),
                    'customtext'   => esc_html__( 'Text/HTML', 'electron' ),
                    'minimenu'     => esc_html__( 'Mini Menu', 'electron' ),
                    'notice'       => esc_html__( 'Notices', 'electron' )
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Custom Text/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_text_sticky',
            'type' => 'textarea',
            'default' => '<a href="tel:280 900 3434"><i aria-hidden="true" class="electron-icons flaticon-24-hours-support"></i><span>280 900 3434<span class="phone-text">Call Anytime</span></span></a>',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Shortcode/HTML', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_shortcode_sticky',
            'type' => 'textarea',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'header_sticky_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Height', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header height.', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_height',
            'type' => 'dimensions',
            'width' => false,
            'output' => array( '.electron-header-sticky' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_bg',
            'type' => 'color_rgba',
            'mode' => 'background-color',
            'output' => array( '.electron-header-sticky,.electron-header.bg-light .electron-header-sticky,.electron-header-sticky .header-mainmenu .nav>li>.submenu, .electron-header-sticky .header-mainmenu .nav>li>.submenu .submenu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Border', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_brd',
            'type' => 'border',
            'all' => false,
            'output' => array( '.electron-header-sticky' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Text Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_text_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-sticky,.electron-header-sticky .header-top-text,.electron-header-sticky ul>li>a,.bg-light .electron-header-sticky .nav >li> a, .bg-light .electron-header-sticky .header-mainmenu>ul>li>a,.electron-header-sticky .header-mainmenu .dropdown-btn,.electron-header-sticky .bg-light .header-mainmenu .submenu>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'SVG Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_icon_color',
            'type' => 'color',
            'mode' => 'fill',
            'output' => array( '.electron-header-sticky .top-action-btn svg' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_counter_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-sticky .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Number Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_counter_color',
            'type' => 'color',
            'output' => array( '.electron-header-sticky .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_mitem_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-sticky ul>li>a,.bg-light .electron-header-sticky .nav >li> a,.bg-light .electron-header-sticky .header-mainmenu>ul>li>a,.electron-header-sticky .header-mainmenu .dropdown-btn,.electron-header-sticky .bg-light .header-mainmenu .submenu>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_mitem_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-sticky ul>li>a:hover,.bg-light .electron-header-sticky .nav >li> a:hover,.bg-light .electron-header-sticky .header-mainmenu>ul>li>a:hover,.electron-header-sticky .header-mainmenu>ul>li>a:hover .dropdown-btn,.electron-header-sticky .bg-light .header-mainmenu .submenu>li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_smitem_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-sticky .header-mainmenu .nav>li>.submenu,.electron-header-sticky .header-mainmenu .nav>li>.submenu .submenu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_smitem_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-sticky .header-mainmenu .submenu>li>a,.bg-light .electron-header-sticky .header-mainmenu .submenu>li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Dropdown Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_sticky_smitem_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header-sticky .header-mainmenu .submenu>li>a:hover,.bg-light .electron-header-sticky .header-mainmenu .submenu>li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_sticky_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
    )
));

//HEADER MOBILE TOP
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Mobile Header', 'electron' ),
    'id' => 'header_mobile_section',
    'subsection' => false,
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'id' =>'header_layout_mobile',
            'type' => 'sorter',
            'title' => esc_html__( 'Mobile Header Layouts', 'electron' ),
            'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme mobile header', 'electron' ),
            'options' => array(
                'left'  => array(
                    'bars' => esc_html__( 'Bars Button', 'electron' ),
                    'logo'   => esc_html__( 'Logo', 'electron' ),
                ),
                'center'  => array(
                ),
                'right'  => array(
                    'account' => esc_html__( 'Account Icon', 'electron' ),
                    'cart'    => esc_html__( 'Cart Icon', 'electron' ),
                    'search'  => esc_html__( 'Search Icon', 'electron' ),
                ),
                'disabled'  => array(
                    'wishlist'    => esc_html__( 'Wishlist Icon', 'electron' ),
                    'compare'  => esc_html__( 'Compare Icon', 'electron' ),
                )
            ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Mobile Sticky Header', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_sticky',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Search Form Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_search_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' =>'header_mobile_search_position',
            'type' => 'button_set',
            'title' => esc_html__( 'Search Form Position', 'electron' ),
            'customizer' => true,
            'options' => array(
                'before' => esc_html__( 'Before Header', 'electron' ),
                'after' => esc_html__( 'After Header', 'electron' ),
            ),
            'default' => 'after',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_mobile_search_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'header_mobile_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Height', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header height.', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_height',
            'type' => 'dimensions',
            'width' => false,
            'output' => array( '.electron-header-mobile' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_bg',
            'type' => 'color_rgba',
            'mode' => 'background-color',
            'output' => array( '.electron-header-mobile,.electron-header-mobile.bg-light' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'SVG Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_icon_color',
            'type' => 'color',
            'mode' => 'fill',
            'output' => array( '.electron-header-mobile .top-action-btn svg' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_counter_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header-mobile .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Counter Number Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_counter_color',
            'type' => 'color',
            'output' => array( '.electron-header-mobile .electron-wc-count' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
    )
));
//HEADER MOBILE TOP
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Mobile Menu', 'electron' ),
    'id' => 'header_mobile_menu_section',
    'subsection' => false,
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'id' => 'header_mobile_menu_type',
            'type' => 'button_set',
            'title' => esc_html__( 'Menu Type', 'electron' ),
            'subtitle' => esc_html__( 'Select your mobile menu content type.', 'electron' ),
            'customizer' => true,
            'options' => array(
                'tab' => esc_html__( 'Tab Menu', 'electron' ),
                'menu' => esc_html__( 'Simple Menu', 'electron' ),
                'cats' => esc_html__( 'Simple Category Menu', 'electron' ),
                'elementor' => esc_html__( 'Elementor Templates', 'electron' ),
            ),
            'default' => 'tab',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Elementor Templates', 'electron' ),
            'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_menu_elementor_templates',
            'type' => 'select',
            'data' => 'posts',
            'args'  => $el_args,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_type', '=', 'elementor' )
            )
        ),
        array(
            'title' => esc_html__( 'Tab Reverse', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_menu_tab_reverse',
            'subtitle' => esc_html__( 'Turn on this option if you want to show the first tab as a category menu.', 'electron' ),
            'type' => 'switch',
            'default' => 0,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_type', '=', 'tab' ),
            )
        ),
        array(
            'id' => 'header_mobile_menu_template',
            'type' => 'button_set',
            'title' => esc_html__( 'Menu Template', 'electron' ),
            'subtitle' => esc_html__( 'Select your mobile menu content template.', 'electron' ),
            'customizer' => true,
            'options' => array(
                'default' => esc_html__( 'Default', 'electron' ),
                'custom' => esc_html__( 'Specific Menu', 'electron' ),
            ),
            'default' => 'default',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'cats' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
        array(
            'desc' => sprintf( '%s <b>"%s"</b> <a class="button" href="'.admin_url('nav-menus.php?action=edit&menu=0').'" target="_blank">%s</a>',
                esc_html__( 'Please create new menu and assign it as', 'electron' ),
                esc_html__( 'Custom Mobile Menu', 'electron' ),
                esc_html__( 'Create New Menu', 'electron' )
            ),
            'customizer' => true,
            'id' => 'header_custom_mobile_menu_info_divide',
            'type' => 'info',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_template', '=', 'custom' )
            )
        ),
        array(
            'title' => esc_html__( 'Social Icons', 'electron' ),
            'customizer' => true,
            'id' => 'header_mobile_menu_socials',
            'subtitle' => esc_html__( 'Turn on this option if you want to show the first tab as a category menu.', 'electron' ),
            'type' => 'switch',
            'default' => 0,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
        array(
            'id' => 'header_mobile_menu_socials_html',
            'type' => 'textarea',
            'title' => esc_html__( 'Social Icons HTML', 'electron' ),
            'customizer' => true,
            'default' => '<a href="#0" title="facebook" class="social-facebook"><i class="nt-icon-facebook"></i></a>
            <a href="#0" title="facebook" class="social-twitter"><i class="nt-icon-twitter-new"></i></a>',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_socials', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
        array(
            'id' => 'header_mobile_menu_socials_position',
            'type' => 'button_set',
            'title' => esc_html__( 'Social Icons Position', 'electron' ),
            'subtitle' => esc_html__( 'Select your mobile menu content template.', 'electron' ),
            'customizer' => true,
            'options' => array(
                'position-top' => esc_html__( 'Top', 'electron' ),
                'position-bottom' => esc_html__( 'Bottom', 'electron' ),
            ),
            'default' => 'position-bottom',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_socials', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'header_mobile_menu_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-icon-info-sign',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Width', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header height.', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_width',
            'type' => 'dimensions',
            'height' => false,
            'output' => array( '.electron-mobile-menu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_bg',
            'type' => 'color_rgba',
            'mode' => 'background-color',
            'output' => array( '.electron-mobile-menu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Tab Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_tab_bg',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.mobile-menu-tab' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Tab Color (Hover)', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_tab_hvrbg',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.mobile-menu-tab:hover, .mobile-menu-tab.active' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Tab Border Color (Hover)', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_tab_brd',
            'type' => 'color',
            'mode' => 'border-color',
            'output' => array( '.mobile-menu-tab,.mobile-menu-tab:hover, .mobile-menu-tab.active' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_item_clr',
            'type' => 'color',
            'output' => array( '.mobile-menu li>a, .mobile-category-menu li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color (Hover)', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_item_hvr',
            'type' => 'color',
            'output' => array( '.mobile-menu li>a:hover, .mobile-category-menu li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_item_bgclr',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.mobile-menu li>a, .mobile-category-menu li>a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Background Color (Hover)', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_item_hvrbg',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.mobile-menu li.open>a, .mobile-menu li>a:hover, .mobile-category-menu li.open>a, .mobile-category-menu li>a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Border Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_item_brd',
            'type' => 'color',
            'mode' => 'border-color',
            'output' => array( '.mobile-menu li>a, .mobile-category-menu li>a,.mobile-menu span.dropdown-btn, .mobile-category-menu span.dropdown-btn,.mobile-menu .nav.cloned,.mobile-menu .menu-divider' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Dropdown Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_item_dropdown_bg',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.mobile-menu span.dropdown-btn, .mobile-category-menu span.dropdown-btn' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Dropdown Color (Active)', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_item_dropdown_hvrbg',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.mobile-menu li.open>a>.dropdown-btn, .mobile-menu span.dropdown-btn:hover, .mobile-category-menu li.open>a>.dropdown-btn, .mobile-category-menu span.dropdown-btn:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Close Button Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_close_bg',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-mobile-menu .panel-close' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Close Button Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_close_clr',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-mobile-menu .panel-close:before, .electron-mobile-menu .panel-close:after' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Social Icon Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_social_bgclr',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-mobile-menu .mobile-social-menu.electron-product-share a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_socials', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
        array(
            'title' => esc_html__( 'Social Icon Background Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_social_hvrbgclr',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-mobile-menu .mobile-social-menu.electron-product-share a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_socials', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
        array(
            'title' => esc_html__( 'Social Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_social_clr',
            'type' => 'color',
            'output' => array( '.electron-mobile-menu .mobile-social-menu.electron-product-share a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_socials', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
        array(
            'title' => esc_html__( 'Social Background Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'mobile_menu_social_hvrclr',
            'type' => 'color',
            'output' => array( '.electron-mobile-menu .mobile-social-menu.electron-product-share a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_mobile_menu_socials', '=', '1' ),
                array( 'header_mobile_menu_type', '!=', 'elementor' ),
            )
        ),
    )
));
//HEADER MOBILE TOP
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Canvas Menu', 'electron' ),
    'id' => 'canvas_menu_section',
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Canvas Menu Display', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_visibility',
            'type' => 'switch',
            'default' => 0,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Canvas Menu Content Type', 'electron' ),
            'id' =>'canvas_menu_content_type',
            'type' => 'button_set',
            'customizer' => true,
            'options' => array(
                'menu' => esc_html__( 'Menu', 'electron' ),
                'sidebar' => esc_html__( 'Widget Sidebar', 'electron' ),
                'html' => esc_html__( 'Custom HTML', 'electron' ),
            ),
            'default' => 'menu',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'HTML Content', 'electron' ),
            'id' =>'canvas_menu_html_content',
            'type' => 'editor',
            'customizer' => true,
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' ),
                array( 'canvas_menu_content_type', '=', 'html' )
            )
        ),
        array(
            'title' => esc_html__( 'Important!', 'electron' ),
            'id' => 'canvas_menu_sidebar_info',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-icon-info-sign',
            'desc'  => esc_html__( 'Please save changes and add your widget into Canvas Sidebar from here Dashboard > Appearence > Widgets', 'electron'),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' ),
                array( 'canvas_menu_content_type', '=', 'sidebar' )
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'canvas_menu_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Width', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the width.', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_width',
            'type' => 'dimensions',
            'height' => false,
            'output' => array( '.electron-canvas-menu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-canvas-menu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Close Button Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_close_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-canvas-menu .panel-close' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Close Button Background Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_close_hvrbgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-canvas-menu .panel-close' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Close Button Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_close_color',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-canvas-menu .panel-close:before, .electron-canvas-menu .panel-close:after' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Close Button Background Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_close_hvrcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-canvas-menu .panel-close:hover:before, .electron-canvas-menu .panel-close:hover:after' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_item_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-canvas-menu .menu-sliding>ul>li a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' ),
                array( 'canvas_menu_content_type', '=', 'menu' ),
            )
        ),
        array(
            'title' => esc_html__( 'Menu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'canvas_menu_item_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-canvas-menu .menu-sliding>ul>li a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'canvas_menu_visibility', '=', '1' ),
                array( 'canvas_menu_content_type', '=', 'menu' ),
            )
        ),
    )
));
// Ajax Live Search
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__('Ajax Live Search', 'electron'),
    'id' => 'ajax_live_search_form_section',
    'icon' => 'el el-cog',
    'fields' => array(
        array(
            'id' =>'ajax_search_form_visibility',
            'type' => 'switch',
            'title' => esc_html__('Ajax Live Search', 'electron'),
            'customizer' => true,
            'default' => '1',
        ),
        array(
            'title' => esc_html__( 'Popup Search Display', 'electron' ),
            'customizer' => true,
            'id' => 'popup_search_visibility',
            'type' => 'switch',
            'default' => 1
        ),
        array(
            'title' => esc_html__( 'Popup Search Most Popular Categories Display', 'electron' ),
            'customizer' => true,
            'id' => 'popup_search_popular_cats_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'popup_search_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Popup Search Style', 'electron' ),
            'subtitle' => esc_html__( 'Select your popup search form style.', 'electron' ),
            'id' =>'header_ajax_search_style',
            'type' => 'button_set',
            'customizer' => true,
            'options' => array(
                'style-1' => esc_html__( 'Style 1', 'electron' ),
                'style-2' => esc_html__( 'Style 2', 'electron' ),
                'style-3' => esc_html__( 'Style 3', 'electron' )
            ),
            'default' => 'style-1',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'popup_search_visibility', '=', '1' )
            )
        ),
        array(
            'id' =>'ajax_search_form_type',
            'type' => 'button_set',
            'title' => esc_html__( 'Ajax Live Search Type', 'electron' ),
            'customizer' => true,
            'options' => array(
                'theme' => esc_html__( 'Theme Form', 'electron' ),
                'plugin' => esc_html__( 'Plugin', 'electron' ),
            ),
            'default' => 'theme',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' )
            )
        ),
        array(
            'id' =>'ajax_search_form_shortcode',
            'type' => 'text',
            'title' => esc_html__('Custom Ajax Live Search Shortcode', 'electron'),
            'subtitle' => esc_html__('If you want to use your own search form add the shortcode here', 'electron'),
            'customizer' => true,
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'plugin' ),
            )
        ),
        array(
            'id' =>'ajax_search_menu_depth',
            'type' => 'switch',
            'title' => esc_html__('Sub-category', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'id' =>'ajax_search_sku',
            'type' => 'switch',
            'title' => esc_html__('Search String by Product SKU', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'id' =>'ajax_search_content',
            'type' => 'switch',
            'title' => esc_html__('Search String by Product Content', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'title' => esc_html__('Max Strings', 'electron'),
            'subtitle' => esc_html__('Maximum number of strings required to start the search', 'electron'),
            'customizer' => true,
            'id' => 'ajax_search_max_char',
            'type' => 'slider',
            'default' => 3,
            'min' => 1,
            'step' => 1,
            'max' => 10,
            'display_value' => 'text',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'id' =>'ajax_search_result_img',
            'type' => 'switch',
            'title' => esc_html__('Search Result Image Display', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'title' => esc_html__( 'Search Result Custom Image', 'electron' ),
            'customizer' => true,
            'id' => 'ajax_search_custom_img',
            'type' => 'media',
            'url' => true,
            'customizer' => true,
            'required' => array(
                array( 'ajax_search_result_img', '=', '1' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'id' =>'ajax_search_result_prc',
            'type' => 'switch',
            'title' => esc_html__('Search Result Price Display', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'id' =>'ajax_search_result_stock',
            'type' => 'switch',
            'title' => esc_html__('Search Result Stock Display', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'id' =>'ajax_search_result_btn',
            'type' => 'switch',
            'title' => esc_html__('Search Result Add To Cart Display', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'id' =>'ajax_search_result_btn_type',
            'type' => 'button_set',
            'title' => esc_html__( 'Add To Cart Type', 'electron' ),
            'customizer' => true,
            'options' => array(
                'text' => esc_html__( 'Text', 'electron' ),
                'button' => esc_html__( 'Button', 'electron' ),
                'icon' => esc_html__( 'Icon', 'electron' ),
            ),
            'default' => 'text',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_result_btn', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'id' =>'ajax_search_result_all_products',
            'type' => 'switch',
            'title' => esc_html__('Search Result All Products Link Display', 'electron'),
            'customizer' => true,
            'default' => '0',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__('Max number of products to display', 'fitment'),
            'subtitle' => esc_html__('Enter the maximum number of products to be shown in the search result here', 'fitment'),
            'customizer' => true,
            'id' => 'ajax_search_perpage',
            'type' => 'slider',
            'default' => 10,
            'min' => 1,
            'step' => 1,
            'max' => 100,
            'display_value' => 'text',
            'required' => array(
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
                array( 'ajax_search_result_all_products', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Header Search Form Customize Options', 'electron' ),
            'id' => 'header_ajax_search_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Height', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header search form height.', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_height',
            'type' => 'dimensions',
            'width' => false,
            'output' => array( '.electron-header .electron-ajax-product-search:not(.custom-search-form) form' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' ),
            )
        ),
        array(
            'title' => esc_html__( 'Border', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_brd',
            'type' => 'border',
            'all' => false,
            'output' => array( '.electron-header .electron-ajax-product-search:not(.custom-search-form) form' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Category Select Border Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_select_brdcolor',
            'type' => 'color',
            'mode' => 'border-color',
            'output' => array( '.electron-header .electron-ajax-product-search .category-select-wrapper' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Category Select List Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_select_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .category-select-wrapper .category-list' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Category Select List Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_select_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header .category-select-wrapper .category-list' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Category Selected Text Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_selected_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header .category-select-wrapper .electron-ajax-selected' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Submit Button Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_submit_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-ajax-product-search button.electron-ajax-search-submit, .electron-ajax-product-search button.electron-ajax-search-submit:hover, .electron-header .electron-ajax-close-search-results' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Submit Button Background Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_submit_hvrbgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-ajax-product-search button.electron-ajax-search-submit:hover, .electron-header .electron-ajax-close-search-results:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Submit Button Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_submit_color',
            'type' => 'color',
            'mode' => 'fill',
            'output' => array( '.electron-header .electron-ajax-product-search button.electron-ajax-search-submit svg' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Submit Button Icon Color ( Close )', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_submit_hvrcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-ajax-close-search-results:before, .electron-header .electron-ajax-close-search-results:after' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Header Search Result Customize Options', 'electron' ),
            'id' => 'header_ajax_search_results_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Search Result Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_result_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-ajax-search-results' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Min Height', 'electron' ),
            'subtitle' => esc_html__( 'You can use this option to control the header search result height.', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_result_height',
            'type' => 'dimensions',
            'width' => false,
            'output' => array( '.electron-header .electron-ajax-product-search .electron-ajax-search-results' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Search Result Border', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_result_brd',
            'type' => 'border',
            'all' => false,
            'output' => array( '.electron-header .electron-ajax-product-search form' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Search Result Item Title Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_result_item_title_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header .electron-ajax-search-results .electron-ajax-product-title' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Search Result Item Price Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_result_item_price_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header .electron-ajax-product-data .electron-ajax-product-price' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
        array(
            'title' => esc_html__( 'Search Result Item Price Color 2', 'electron' ),
            'customizer' => true,
            'id' => 'header_ajax_search_result_item_price_color2',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.electron-header .electron-ajax-product-data .electron-ajax-product-price .electron-price-wrapper.price ins' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'ajax_search_form_visibility', '=', '1' ),
                array( 'ajax_search_form_type', '=', 'theme' )
            )
        ),
    )
));
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Category Menu', 'electron' ),
    'id' => 'header_cats_menu_section',
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'id' =>'header_cat_menu_include',
            'type' => 'select',
            'title' => esc_html__( 'Open Categories on Selected Pages ( for Categories dropdown menu )', 'electron' ),
            'subtitle' => esc_html__( 'Select the pages where you want the menu to be open', 'electron' ),
            'multi' => true,
            'customizer' => true,
            'data' => 'pages',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Category Dropdown Menu Title', 'electron' ),
            'id' =>'header_cat_menu_title',
            'type' => 'text',
            'customizer' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Category(s)', 'electron' ),
            'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_menu_items',
            'type' => 'select',
            'data' => 'terms',
            'multi' => true,
            'sortable' => true,
            'args'  => [
                'taxonomies' => array( 'product_cat' ),
            ],
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' =>'header_cat_menu_filter',
            'type' => 'button_set',
            'title' => esc_html__( 'Category Filter Type', 'electron' ),
            'customizer' => true,
            'options' => array(
                'exclude' => esc_html__( 'Exclude', 'electron' ),
                'include' => esc_html__( 'Include', 'electron' ),
            ),
            'default' => 'include',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_cat_menu_items', '!=', '' )
            )
        ),
        array(
            'id' => 'header_cat_menu_hide_empty',
            'type' => 'switch',
            'title' => esc_html__('Hide Empty Categories', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'id' =>'header_cat_menu_hide_order',
            'type' => 'button_set',
            'title' => esc_html__( 'Category Order', 'electron' ),
            'customizer' => true,
            'options' => array(
                'ASC' => esc_html__( 'ASC', 'electron' ),
                'DESC' => esc_html__( 'DESC', 'electron' ),
            ),
            'default' => 'ASC',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'id' =>'header_cat_menu_hide_orderby',
            'type' => 'button_set',
            'title' => esc_html__( 'Category Orderby', 'electron' ),
            'customizer' => true,
            'options' => array(
                'name' => esc_html__( 'Name', 'electron' ),
                'slug' => esc_html__( 'Slug', 'electron' ),
                'id' => esc_html__( 'ID', 'electron' ),
                'count' => esc_html__( 'Count', 'electron' ),
                'description' => esc_html__( 'Description', 'electron' ),
                'menu_order' => esc_html__( 'Menu order', 'electron' ),
            ),
            'default' => 'name',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'id' =>'header_cat_menu_thumb_visibility',
            'type' => 'switch',
            'title' => esc_html__('Thumbnail Display', 'electron'),
            'customizer' => true,
            'default' => '1',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'id' =>'header_cat_menu_thumb_type',
            'type' => 'button_set',
            'title' => esc_html__( 'Thumbnail Type', 'electron' ),
            'customizer' => true,
            'options' => array(
                'image' => esc_html__( 'Image', 'electron' ),
                'svg' => esc_html__( 'SVG', 'electron' ),
            ),
            'default' => 'image',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_cat_menu_thumb_visibility', '=', '1' )
            )
        ),
        array(
            'title' => esc_html__( 'Category Dropdown Menu Customize Options', 'electron' ),
            'id' => 'header_cat_menu_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_top_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Backgroud Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_menu_bg_color',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-category-menu .menu-title' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Backgroud Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_menu_bg_hvrcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-category-menu .menu-title:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'title' => esc_html__( 'Title Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_menu_title_color',
            'type' => 'color',
            'output' => array( '.electron-header .electron-category-menu .menu-title' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Title Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_menu_title_hvrcolor',
            'type' => 'color',
            'output' => array( '.electron-header .electron-category-menu .menu-title:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Bars Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_menu_bars_color',
            'type' => 'color',
            'mode' => 'stroke',
            'output' => array( '.electron-header .electron-category-menu .menu-title .menuBars' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Bars Icon Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_menu_bars_hvrcolor',
            'type' => 'color',
            'mode' => 'stroke',
            'output' => array( '.electron-header .electron-category-menu .menu-title:hover .menuBars' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Submenu Item Backgroud Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_submenu_bg_color',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-category-menu .submenu' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
            )
        ),
        array(
            'title' => esc_html__( 'Submenu Item Backgroud Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_submenu_bg_hvrcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.electron-header .electron-category-menu .submenu>li:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Submenu Item Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_submenu_item_color',
            'type' => 'color',
            'output' => array( '.electron-header .electron-category-menu .submenu > li >a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Submenu Item Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_submenu_item_hvrcolor',
            'type' => 'color',
            'output' => array( '.electron-header .electron-category-menu .submenu > li:hover>a, .electron-header .electron-category-menu .submenu > li.current-cat>a, .electron-header .electron-category-menu > .submenu li.current-cat, .electron-header .electron-category-menu > .submenu li:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Submenu Item Border Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_submenu_item_brdcolor',
            'type' => 'color',
            'mode' => 'border-bottom-color',
            'output' => array( '.electron-header .electron-category-menu .primary-cats>li:not(last-child), .electron-header .electron-category-menu .submenu>li:not(last-child)' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Submenu Item Border Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_cat_submenu_item_hvrbrdcolor',
            'type' => 'color',
            'mode' => 'border-bottom-color',
            'output' => array( '.electron-header .electron-category-menu .primary-cats>li:not(last-child):hover, .electron-header .electron-category-menu .submenu>li:not(last-child):hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
    )
));

//Header Notices
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header My Account', 'electron' ),
    'id' => 'header_account_action_section',
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'My Account Action Type', 'electron' ),
            'subtitle' => esc_html__( 'Select your header my account button action type.', 'electron' ),
            'customizer' => true,
            'id' => 'header_account_action_type',
            'type' => 'button_set',
            'customizer' => true,
            'options' => array(
                'default' => esc_html__( 'Default', 'electron' ),
                'link' => esc_html__( 'Click to redirect url', 'electron' ),
                'popup' => esc_html__( 'Open Popup Login Form', 'electron' ),
                'left-sidebar' => esc_html__( 'Open Popup Login Form ( left - sidebar )', 'electron' ),
                'right-sidebar' => esc_html__( 'Open Popup Login Form ( right - sidebar )', 'electron' )
            ),
            'default' => 'default',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Custom My Account Page URL', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom url here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_account_action_url',
            'type' => 'text',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_account_action_type', '=', array('default','link') ),
            )
        ),
        array(
            'title' => esc_html__( 'Custom Sign In URL', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom url here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_account_signin_url',
            'type' => 'text',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_account_action_type', '=', 'default' ),
            )
        ),
        array(
            'title' => esc_html__( 'Custom Register URL', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom url here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_account_register_url',
            'type' => 'text',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_account_action_type', '=', 'default' ),
            )
        ),
        array(
            'title' => esc_html__( 'Custom HTML SVG/Font Icon', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom icon here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_account_icon',
            'type' => 'textarea',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
    )
));
//Header Notices
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Cart', 'electron' ),
    'id' => 'header_cart_action_section',
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Cart Button Action Type', 'electron' ),
            'subtitle' => esc_html__( 'Select your header cart button action type.', 'electron' ),
            'customizer' => true,
            'id' => 'header_cart_action_type',
            'type' => 'button_set',
            'customizer' => true,
            'options' => array(
                'default' => esc_html__( 'Default', 'electron' ),
                'link' => esc_html__( 'Click to redirect url', 'electron' ),
                'left-sidebar' => esc_html__( 'Open Popup ( left - sidebar )', 'electron' ),
                'right-sidebar' => esc_html__( 'Open Popup ( right - sidebar )', 'electron' )
            ),
            'default' => 'default',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Custom Cart Page URL', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom url here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_cart_custom_url',
            'type' => 'text',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_cart_action_type', '=', array('default','link') ),
            )
        ),
        array(
            'title' => esc_html__( 'Custom HTML SVG/Font Icon', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom icon here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_cart_icon',
            'type' => 'textarea',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
    )
));

//Header Notices
Redux::setSection($electron_header_pre, array(
    'title' => esc_html__( 'Header Notices', 'electron' ),
    'id' => 'header_notices_section',
    'icon' => 'fa fa-cog',
    'fields' => array(
        array(
            'title' => esc_html__( 'Header Notices Display', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_visibility',
            'type' => 'switch',
            'default' => 1,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' )
            )
        ),
        array(
            'title' => esc_html__( 'Header Notices', 'electron' ),
            'subtitle' => esc_html__( 'Add your custom html here.', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices',
            'type' => 'textarea',
            'default' => '<a href="tel:280 900 3434"><i aria-hidden="true" class="electron-icons flaticon-24-hours-support"></i><span>280 900 3434<span class="phone-text">Call Anytime</span></span></a>',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Custom HTML SVG/Font Icon', 'electron' ),
            'subtitle' => esc_html__( 'Add your HTML icon here', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_icon',
            'type' => 'textarea',
            'default' => '',
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Customize Options', 'electron' ),
            'id' => 'header_notices_customize_divide',
            'type' => 'info',
            'style' => 'success',
            'color' => '#000',
            'icon' => 'el el-brush',
            'notice' => true,
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'SVG Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_icon_svg_color',
            'type' => 'color',
            'mode' => 'fill',
            'output' => array( '.header-notices.top-action-btn.has-panel>svg' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Font Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_icon_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.header-notices.top-action-btn.has-panel>i,.header-notices.top-action-btn.has-panel>a>i' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Content Background Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_bgcolor',
            'type' => 'color',
            'mode' => 'background-color',
            'output' => array( '.header-notices .mini-panel' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Content Border Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_brdcolor',
            'type' => 'color',
            'mode' => 'border-color',
            'output' => array( '.header-notices .mini-panel' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Content Arrow Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_arrow_color',
            'type' => 'color',
            'mode' => 'border-bottom-color',
            'output' => array( '.header-notices .mini-panel:before' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Content Link Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_link_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.header-notices .mini-panel a' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Content Link Color ( Hover )', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_link_hvrcolor',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.header-notices .mini-panel a:hover' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Content Text Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_text_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.header-notices .mini-panel' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
        array(
            'title' => esc_html__( 'Content Icon Color', 'electron' ),
            'customizer' => true,
            'id' => 'header_notices_content_icon_color',
            'type' => 'color',
            'mode' => 'color',
            'output' => array( '.header-notices .mini-panel a>i,.header-notices .mini-panel i' ),
            'required' => array(
                array( 'header_visibility', '=', '1' ),
                array( 'header_template', '=', 'default' ),
                array( 'header_notices_visibility', '=', '1' ),
            )
        ),
    )
));

if ( class_exists('WooCommerce') ) {
    //MOBILE BOTTOM MENU BAR SECTION
    Redux::setSection($electron_header_pre, array(
        'title' => esc_html__( 'Mobile Bottom Menu Bar', 'electron' ),
        'desc' => esc_html__( 'These are main settings for general theme!', 'electron' ),
        'id' => 'mobilebottommenusubsection',
        'subsection' => false,
        'icon' => 'el el-photo',
        'fields' => array(
            array(
                'title' => esc_html__( 'Mobile Bottom Menu Bar Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site mobile bottom menu bar.', 'electron' ),
                'customizer' => true,
                'id' => 'bottom_mobile_nav_visibility',
                'type' => 'switch',
                'default' => 0
            ),
            array(
                'title' => esc_html__( 'Mobile Bottom Menu Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your mobile bottom menu popup search type.', 'electron' ),
                'customizer' => true,
                'id' => 'bottom_mobile_menu_type',
                'type' => 'button_set',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Default', 'electron' ),
                    'wp-menu' => esc_html__( 'WP Menu', 'electron' ),
                ),
                'default' => 'default',
                'required' => array( 'bottom_mobile_nav_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Mobile Bottom Menu Display Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your mobile bottom menu popup search type.', 'electron' ),
                'customizer' => true,
                'id' => 'bottom_mobile_menu_display_type',
                'type' => 'button_set',
                'customizer' => true,
                'options' => array(
                    'show-allways' => esc_html__( 'Always show', 'electron' ),
                    'show-onscroll' => esc_html__( 'Show on scroll', 'electron' ),
                ),
                'default' => 'show-allways',
                'required' => array( 'bottom_mobile_nav_visibility', '=', '1' )
            ),
            array(
                'id' =>'mobile_bottom_menu_layouts',
                'type' => 'sorter',
                'title' => esc_html__( 'Layout Manager', 'electron' ),
                'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme bottom mobile menu bar', 'electron' ),
                'options' => array(
                    'show' => array(
                        'home' => esc_html__( 'Home', 'electron' ),
                        'shop' => esc_html__( 'Shop', 'electron' ),
                        'cart' => esc_html__( 'Cart', 'electron' ),
                        'account' => esc_html__( 'Account', 'electron' ),
                        'search' => esc_html__( 'Search', 'electron' ),
                    ),
                    'hide'  => array()
                ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' )
                )
            ),
            array(
                'desc' => sprintf( '%s <b>"%s"</b> <a class="button" href="'.admin_url('nav-menus.php?action=edit&menu=0').'" target="_blank">%s</a>',
                    esc_html__( 'Please create new menu and assign it as', 'electron' ),
                    esc_html__( 'Mobile Bottom Menu', 'electron' ),
                    esc_html__( 'Create New Menu', 'electron' )
                ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_custom_menu_info',
                'type' => 'info',
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'wp-menu' )
                )
            ),
            array(
                'title' => esc_html__( 'Change Default Menu Item HTML', 'electron' ),
                'subtitle' => esc_html__( 'You can change the site mobile bottom menu item html.', 'electron' ),
                'customizer' => true,
                'id' => 'bottom_mobile_nav_item_customize',
                'type' => 'switch',
                'default' => 0,
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Custom Home HTML ( optional )', 'electron' ),
                'desc' => esc_html__( 'If you do not want to make any changes in this part, please clear the default html from the field.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_custom_home_html',
                'type' => 'textarea',
                'default' => sprintf( '<li class="menu-item"><a href="%s">%s<span>Home</span></a></li>',
                    esc_url( home_url( '/' ) ),
                    electron_svg_lists( 'arrow-left', 'electron-svg-icon' )
                ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' ),
                    array( 'bottom_mobile_nav_item_customize', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Custom Shop HTML ( optional )', 'electron' ),
                'desc' => esc_html__( 'If you do not want to make any changes in this part, please clear the default html from the field.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_custom_shop_html',
                'type' => 'textarea',
                'default' => sprintf( '<li class="menu-item"><a href="%s">%s<span>Shop</span></a></li>',
                    function_exists('wc_get_page_permalink') ? esc_url( wc_get_page_permalink( 'shop' ) ) : '#0',
                    electron_svg_lists( 'store', 'electron-svg-icon' )
                ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' ),
                    array( 'bottom_mobile_nav_item_customize', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Custom Cart HTML ( optional )', 'electron' ),
                'desc' => esc_html__( 'If you do not want to make any changes in this part, please clear the default html from the field.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_custom_cart_html',
                'type' => 'textarea',
                'default' => sprintf( '<li class="menu-item"><a href="%s">%s<span class="electron-cart-count electron-wc-count"></span><span>Cart</span></a></li>',
                    function_exists('wc_get_page_permalink') ? esc_url( wc_get_page_permalink( 'cart' ) ) : '#0',
                    electron_svg_lists( 'bag', 'electron-svg-icon' )
                ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' ),
                    array( 'bottom_mobile_nav_item_customize', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Custom Account HTML ( optional )', 'electron' ),
                'desc' => esc_html__( 'If you do not want to make any changes in this part, please clear the default html from the field.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_custom_account_html',
                'type' => 'textarea',
                'default' => sprintf( '<li class="menu-item"><a href="%s">%s<span>Account</span></a></li>',
                    function_exists('wc_get_page_permalink') ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : '#0',
                    electron_svg_lists( 'user-1', 'electron-svg-icon' )
                ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' ),
                    array( 'bottom_mobile_nav_item_customize', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Custom Search HTML ( optional )', 'electron' ),
                'desc' => esc_html__( 'If you do not want to make any changes in this part, please clear the default html from the field.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_custom_search_html',
                'type' => 'textarea',
                'default' => sprintf( '<li class="menu-item"><a href="#0" data-target=".electron-popup-search" class="panel-open">%s<span>Search</span></a></li>',
                    electron_svg_lists( 'search', 'electron-svg-icon' )
                ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' ),
                    array( 'bottom_mobile_nav_item_customize', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Custom Categories HTML ( optional )', 'electron' ),
                'desc' => esc_html__( 'If you do not want to make any changes in this part, please clear the default html from the field.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_custom_cats_html',
                'type' => 'textarea',
                'default' => sprintf( '<li class="menu-item"><a href="#0" data-target="search-cats">%s<span>Categories</span></a></li>',
                    electron_svg_lists( 'paper-search', 'electron-svg-icon' )
                ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '=', 'default' ),
                    array( 'bottom_mobile_nav_item_customize', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Backgroud Color', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_bg_color',
                'type' => 'color',
                'mode' => 'background-color',
                'output' => array( '.has-bottom-mobile-nav .electron-bottom-mobile-nav' ),
                'required' => array( 'bottom_mobile_nav_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Menu Item Color', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_color',
                'type' => 'color',
                'mode' => 'color',
                'output' => array( '.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item a,.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item a span' ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Menu Item Color ( Hover )', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_hvrcolor',
                'type' => 'color',
                'mode' => 'color',
                'output' => array( '.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item a:hover,.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item a:hover span'),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'SVG Icon Color', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_icon_color',
                'type' => 'color',
                'mode' => 'fill',
                'output' => array('.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item svg,.has-bottom-mobile-nav .electron-bottom-mobile-nav .electron-svg-icon'),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'SVG Icon Color ( Hover )', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_icon_hvrcolor',
                'type' => 'color',
                'mode' => 'fill',
                'output' => array('.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item a:hover svg,.has-bottom-mobile-nav .electron-bottom-mobile-nav a:hover .electron-svg-icon'),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Font Icon Color', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_icon2_color',
                'type' => 'color',
                'mode' => 'color',
                'output' => array('.has-bottom-mobile-nav .electron-bottom-mobile-nav a i,.has-bottom-mobile-nav .electron-bottom-mobile-nav a span' ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Font Icon Color ( Hover )', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_icon2_hvrcolor',
                'type' => 'color',
                'mode' => 'color',
                'output' => array('.has-bottom-mobile-nav .electron-bottom-mobile-nav a:hover i,.has-bottom-mobile-nav .electron-bottom-mobile-nav a:hover span' ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Cart Count Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_cart_count_bg_color',
                'type' => 'color',
                'mode' => 'background-color',
                'output' => array( '.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item a span.electron-wc-count, .has-bottom-mobile-nav .electron-bottom-mobile-nav .electron-wc-count' ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Cart Count Number Color', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_bottom_menu_item_cart_count_number_color',
                'type' => 'color',
                'mode' => 'color',
                'output' => array( '.has-bottom-mobile-nav .electron-bottom-mobile-nav .menu-item a span.electron-wc-count, .has-bottom-mobile-nav .electron-bottom-mobile-nav .electron-wc-count' ),
                'required' => array(
                    array( 'bottom_mobile_nav_visibility', '=', '1' ),
                    array( 'bottom_mobile_menu_type', '!=', 'elementor' )
                )
            )
        )
    ));
}
