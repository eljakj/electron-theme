<?php

    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if (! class_exists('Redux' )) {
        return;
    }
    $electron_options = get_option("electron");
    // This is your option name where all the Redux data is stored.
    $electron_pre = "electron";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $electron_theme = wp_get_theme(); // For use with some settings. Not necessary.

    $electron_options_args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name' => $electron_pre,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name' => $electron_theme->get('Name' ),
        // Name that appears at the top of your panel
        'display_version' => $electron_theme->get('Version' ),
        // Version that appears at the top of your panel
        'menu_type' => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu' => false,
        // Show the sections below the admin menu item or not
        'menu_title' => esc_html__( 'Theme Options', 'electron' ),
        'page_title' => esc_html__( 'Theme Options', 'electron' ),
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
        'global_variable' => 'electron',
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
        'page_slug' => '',
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

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $electron_options_args['admin_bar_links'][] = array(
        'id' => 'electron-electron-docs',
        'href' => 'https://electron.com/docs/electron-documentation/',
        'title' => esc_html__( 'electron Documentation', 'electron' ),
    );
    $electron_options_args['admin_bar_links'][] = array(
        'id' => 'electron-support',
        'href' => 'https://9theme.ticksy.com/',
        'title' => esc_html__( 'Support', 'electron' ),
    );
    $electron_options_args['admin_bar_links'][] = array(
        'id' => 'electron-portfolio',
        'href' => 'https://themeforest.net/user/electron/portfolio',
        'title' => esc_html__( 'NineTheme Portfolio', 'electron' ),
    );

    // Add content after the form.
    $electron_options_args['footer_text'] = esc_html__( 'If you need help please read docs and open a ticket on our support center.', 'electron' );

    Redux::setArgs($electron_pre, $electron_options_args);

    /* END ARGUMENTS */

    /* START SECTIONS */

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

    $activekit = get_option( 'elementor_active_kit' );

    $wpcf7_args = array(
        'post_type'      => 'wpcf7_contact_form',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC'
    );

    function electron_wc_attributes()
    {
        $options = array();

        $terms = wc_get_attribute_taxonomies();
        if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $options[ $term->attribute_name ] = $term->attribute_label;
            }
        }

        return $options;
    }

    $templates = array();
    $templates[] = array(
        'title'      => esc_html__( 'Select Elementor Template for Shortcode', 'electron' ),
        'subtitle'   => esc_html__( 'select the template for the creation of the shortcode you want to use.', 'electron' ),
        'customizer' => true,
        'id'         => 'elementor_template_ids',
        'type'       => 'select',
        'sortable'   => true,
        'multi'      => true,
        'data'       => 'posts',
        'args'       => $el_args
    );
    $templates_query = new WP_Query($el_args);
    if ($templates_query->have_posts()) {
        while ($templates_query->have_posts()) {
            $templates_query->the_post();
            $template_id    = get_the_ID();
            $template_title = get_the_title();

            $templates[] = array(
                'title'      => $template_title.' '.esc_html__('Shortcode', 'electron' ),
                'customizer' => false,
                'id'         => 'template_id_'.$template_id,
                'type'       => 'text',
                'readonly'   => true,
                'default'    => '[electron-template id="'.$template_id.'"]',
                'required'   => array( 'elementor_template_ids', '=', "$template_id" )
            );
        }
    }
    wp_reset_postdata();

    $templates[] = array(
        'title' => esc_html__( 'Disable Widget Product List Features', 'electron' ),
        'subtitle' => esc_html__( 'If you are having trouble editing Elementor pages please turn this setting to "Yes", if you are not sure what this setting does please ask the support team for help', 'electron' ),
        'customizer' => true,
        'id' => 'disable_product_list_filter',
        'type' => 'switch',
        'default' => false,
        'on' => esc_html__( 'Yes', 'electron' ),
        'off' => esc_html__( 'No', 'electron' ),
    );

    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Elementor', 'electron' ),
        'id' => 'elementor_shortcodes_section',
        'icon' => 'el el-cog',
        'fields' => $templates
    ));
    /*************************************************
    ## MAIN SETTING SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Main Setting', 'electron' ),
        'id' => 'basic',
        'desc' => esc_html__( 'These are main settings for general theme!', 'electron' ),
        'icon' => 'el el-cog'
    ));
    //BREADCRUMBS SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Layout', 'electron' ),
        'id' => 'thememainlayoutsubsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'id' =>'edit_layout_settings',
                'type' => 'info',
                'desc' => esc_html__( 'Wrapper layout settings', 'electron' ),
            ),
            array(
                'title' => esc_html__( 'Boxed Layout', 'electron' ),
                'subtitle' => esc_html__( 'You can change main layout as boxed or use fullwidth', 'electron' ),
                'customizer' => true,
                'id' => 'theme_boxed_layout',
                'type' => 'switch',
                'default' => false
            ),
            array(
                'title' => esc_html__( 'Theme Wrapper Max Width', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the theme content width.', 'electron' ),
                'customizer' => true,
                'id' => 'boxed_max_width',
                'type' => 'slider',
                'default' => 1600,
                'min' => 0,
                'step' => 1,
                'max' => 4000,
                'display_value' => 'text',
                'required' => array( 'theme_boxed_layout', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Theme Content Width', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the theme content width.', 'electron' ),
                'customizer' => true,
                'id' => 'content_width',
                'type' => 'slider',
                'default' => 1560,
                'min' => 0,
                'step' => 1,
                'max' => 4000,
                'display_value' => 'text',
                'required' => array( 'theme_boxed_layout', '=', '0' )
            )
        )
    ));
    //BREADCRUMBS SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Typograhy', 'electron' ),
        'id' => 'themetypograhysubsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'id' =>'edit_typograhy_settings',
                'type' => 'info',
                'desc' => sprintf( '<b>%s</b> <a class="thm-btn" href="%s" target="_blank">%s</a>',
                    esc_html__( 'This theme uses Elementor Site Settings', 'electron' ),
                    admin_url('post.php?post='.$activekit.'&action=elementor'),
                    esc_html__( 'Site Settings', 'electron' )
                )
            ),
            array(
                'title' => esc_html__( 'Disable Theme Default All Fonts', 'electron' ),
                'subtitle' => esc_html__( 'If you want to remove the default fonts of the theme, you can use this option.', 'electron' ),
                'customizer' => true,
                'id' => 'theme_fonts_visibility',
                'type' => 'switch',
                'on' => esc_html__( 'Yes', 'electron' ),
                'off' => esc_html__( 'No', 'electron' ),
                'default' => false
            ),
            array(
                'title' => esc_html__( 'Disable Theme Main Fonts ( Jost )', 'electron' ),
                'subtitle' => esc_html__( 'If you want to remove the default Jost font family of the theme, you can use this option.', 'electron' ),
                'customizer' => true,
                'id' => 'theme_fonts_jost_visibility',
                'type' => 'switch',
                'on' => esc_html__( 'Yes', 'electron' ),
                'off' => esc_html__( 'No', 'electron' ),
                'default' => false,
                'required' => array( 'theme_fonts_visibility', '!=', '1' )
            ),
            array(
                'title' => esc_html__( 'Theme Main Font Weights ( Jost )', 'electron' ),
                'subtitle' => esc_html__( 'If you want to remove the default Jost font family of the theme, you can use this option.', 'electron' ),
                'customizer' => true,
                'id' => 'theme_fonts_jost_weights',
                'type' => 'select',
                'sortable'  => false,
                'options' => array(
                    '300' => 'light 300',
                    '400' => 'regular 400',
                    '500' => 'medium 500',
                    '600' => 'bold 600',
                    '700' => 'semi-bold 700'
                ),
                'multi' => true,
                'required' => array(
                    array( 'theme_fonts_visibility', '!=', '1' ),
                    array( 'theme_fonts_jost_visibility', '!=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Disable Theme Second Fonts ( Manrope )', 'electron' ),
                'subtitle' => esc_html__( 'If you want to remove the default manrope font family of the theme, you can use this option.', 'electron' ),
                'customizer' => true,
                'id' => 'theme_fonts_manrope_visibility',
                'type' => 'switch',
                'default' => false,
                'on' => esc_html__( 'Yes', 'electron' ),
                'off' => esc_html__( 'No', 'electron' ),
                'required' => array( 'theme_fonts_visibility', '!=', '1' )
            ),
            array(
                'title' => esc_html__( 'Theme Second Font Weights ( Manrope )', 'electron' ),
                'subtitle' => esc_html__( 'If you want to remove the default Manrope font family of the theme, you can use this option.', 'electron' ),
                'customizer' => true,
                'id' => 'theme_fonts_manrope_weights',
                'type' => 'select',
                'sortable'  => false,
                'options' => array(
                    '400' => 'regular 400',
                    '500' => 'medium 500',
                    '600' => 'bold 600',
                    '700' => 'semi-bold 700',
                    '800' => 'extra-bold 800',
                ),
                'multi' => true,
                'required' => array(
                    array( 'theme_fonts_visibility', '!=', '1' ),
                    array( 'theme_fonts_manrope_visibility', '!=', '1' )
                )
            )
        )
    ));
    //BREADCRUMBS SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Colors', 'electron' ),
        'id' => 'themecolorssubsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Primary Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#6C5EBC"></div> %s',esc_html__( 'Default: #6C5EBC', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr1',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Secondary Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#B20808"></div> %s',esc_html__( 'Default: #B20808', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr2',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Text Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#4e4e4e"></div> %s',esc_html__( 'Default: #4e4e4e', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr3',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Text Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#949494"></div> %s',esc_html__( 'Default: #949494', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr4',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Dark Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#161616"></div> %s',esc_html__( 'Default: #161616', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr5',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Dark Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#343131"></div> %s',esc_html__( 'Default: #343131', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr6',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Light Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#FFFFFF"></div> %s',esc_html__( 'Default: #FFFFFF', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr7',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Light Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#bdbdbd"></div> %s',esc_html__( 'Default: #bdbdbd', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr8',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Gray Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#E1E2E3"></div> %s',esc_html__( 'Default: #E1E2E3', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr9',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Gray Dark Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#595959"></div> %s',esc_html__( 'Default: #595959', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr10',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Gray Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#F7F7F8"></div> %s',esc_html__( 'Default: #F7F7F8', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr11',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Border Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#EAEBED"></div> %s',esc_html__( 'Default: #EAEBED', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr12',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Border Dark Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#060606"></div> %s',esc_html__( 'Default: #060606', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr13',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Border Trans Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#f7f7f833"></div> %s',esc_html__( 'Default: #f7f7f833', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr14',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Success Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#398f14"></div> %s',esc_html__( 'Default: #398f14', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr15',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Success BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#d4ffe7"></div> %s',esc_html__( 'Default: #d4ffe7', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr16',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Success Border Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#b5fdb0"></div> %s',esc_html__( 'Default: #b5fdb0', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr17',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Warning Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#c28e00"></div> %s',esc_html__( 'Default: #c28e00', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr18',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Warning BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#fffcf2"></div> %s',esc_html__( 'Default: #fffcf2', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr19',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Warning Border Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#faeecf"></div> %s',esc_html__( 'Default: #faeecf', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr20',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Info Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#1e73be"></div> %s',esc_html__( 'Default: #1e73be', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr21',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Info BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#daedfd"></div> %s',esc_html__( 'Default: #daedfd', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr22',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Info Border Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#b0daff"></div> %s',esc_html__( 'Default: #b0daff', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr23',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Red Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#ED4B4B"></div> %s',esc_html__( 'Default: #ED4B4B', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr24',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Red Dark Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#B20808"></div> %s',esc_html__( 'Default: #B20808', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr25',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Red Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#FFB1B1"></div> %s',esc_html__( 'Default: #FFB1B1', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr26',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Red Softer Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#FFF5F5"></div> %s',esc_html__( 'Default: #FFF5F5', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr27',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Red Text Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#B20808"></div> %s',esc_html__( 'Default: #B20808', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr28',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Red BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#FFD9D9"></div> %s',esc_html__( 'Default: #FFD9D9', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr29',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Red Border Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#FFBFC1"></div> %s',esc_html__( 'Default: #FFBFC1', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr30',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Green Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#019267"></div> %s',esc_html__( 'Default: #019267', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr31',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Green Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#0ECEA6"></div> %s',esc_html__( 'Default: #0ECEA6', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr32',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Green BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#9BE8D8"></div> %s',esc_html__( 'Default: #9BE8D8', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr33',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Purple Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#6C5EBC"></div> %s',esc_html__( 'Default: #6C5EBC', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr34',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Purple Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#BDB3FF"></div> %s',esc_html__( 'Default: #BDB3FF', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr35',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Purple BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#DFDBFD"></div> %s',esc_html__( 'Default: #DFDBFD', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr36',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Yellow Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#ffdc00"></div> %s',esc_html__( 'Default: #ffdc00', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr37',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Yellow Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#ffdc00"></div> %s',esc_html__( 'Default: #ffdc00', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr38',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Yellow BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#FFFABC"></div> %s',esc_html__( 'Default: #FFFABC', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr39',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Brown Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#6C3428"></div> %s',esc_html__( 'Default: #6C3428', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr40',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Cream Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#F4EAD5"></div> %s',esc_html__( 'Default: #F4EAD5', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr41',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Blue Dark Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#011962"></div> %s',esc_html__( 'Default: #011962', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr42',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Blue Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#072AC8"></div> %s',esc_html__( 'Default: #072AC8', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr43',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Blue Soft Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#1E96FC"></div> %s',esc_html__( 'Default: #1E96FC', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr44',
                'type' => 'color',
                'default' => ''
            ),
            array(
                'title' => esc_html__( 'Blue BG Color', 'electron' ),
                'subtitle' => sprintf( '<div style="width:15px;height:15px;background:#CEE8FF"></div> %s',esc_html__( 'Default: #CEE8FF', 'electron' )),
                'customizer' => true,
                'id' => 'theme_clr45',
                'type' => 'color',
                'default' => ''
            ),
        )
    ));
    //BREADCRUMBS SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Breadcrumbs', 'electron' ),
        'id' => 'themebreadsubsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Breadcrumbs', 'electron' ),
                'subtitle' => esc_html__( 'If enabled, adds breadcrumbs navigation to bottom of page title.', 'electron' ),
                'customizer' => true,
                'id' => 'breadcrumbs_visibility',
                'type' => 'switch',
                'default' => true
            ),
            array(
                'id' =>'breadcrumbs_type',
                'type' => 'button_set',
                'title' => esc_html__( 'Breadcrumbs Template', 'electron' ),
                'customizer' => true,
                'options' => array(
                    'theme' => esc_html__( 'Theme Breadcrumbs', 'electron' ),
                    'woo' => esc_html__( 'WooCommerce Breadcrumbs', 'electron' ),
                    'rank' => esc_html__( 'Rank Math', 'electron' ),
                    'yoast' => esc_html__( 'Yoast SEO', 'electron' ),
                ),
                'default' => 'theme',
                'required' => array( 'breadcrumbs_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Breadcrumbs Current Color', 'electron' ),
                'customizer' => true,
                'id' => 'breadcrumbs_current',
                'type' => 'color',
                'default' => '',
                'output' => array( '.electron-breadcrumb li.breadcrumb_active' ),
                'required' => array( 'breadcrumbs_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Breadcrumbs Separator Color', 'electron' ),
                'customizer' => true,
                'id' => 'breadcrumbs_icon',
                'type' => 'color',
                'default' => '',
                'output' => array( '.electron-breadcrumb .breadcrumb_link_seperator' ),
                'required' => array( 'breadcrumbs_visibility', '=', '1' )
            )
        )
    ));
    //PRELOADER SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Preloader', 'electron' ),
        'id' => 'themepreloadersubsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Preloader', 'electron' ),
                'subtitle' => esc_html__( 'If enabled, adds preloader.', 'electron' ),
                'customizer' => true,
                'id' => 'preloader_visibility',
                'type' => 'switch',
                'default' => true
            ),
            array(
                'title' => esc_html__( 'Preloader Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your preloader type.', 'electron' ),
                'customizer' => true,
                'id' => 'pre_type',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Default', 'electron' ),
                    '01' => esc_html__( 'Type 1', 'electron' ),
                    '02' => esc_html__( 'Type 2', 'electron' ),
                    '03' => esc_html__( 'Type 3', 'electron' ),
                    '04' => esc_html__( 'Type 4', 'electron' ),
                    '05' => esc_html__( 'Type 5', 'electron' ),
                    '06' => esc_html__( 'Type 6', 'electron' ),
                    '07' => esc_html__( 'Type 7', 'electron' ),
                    '08' => esc_html__( 'Type 8', 'electron' ),
                    '09' => esc_html__( 'Type 9', 'electron' ),
                    '10' => esc_html__( 'Type 10', 'electron' ),
                    '11' => esc_html__( 'Type 11', 'electron' ),
                    '12' => esc_html__( 'Type 12', 'electron' )
                ),
                'default' => '12',
                'required' => array( 'preloader_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Preloader Image', 'electron' ),
                'subtitle' => esc_html__( 'Upload your Logo. If left blank theme will use site default preloader.', 'electron' ),
                'customizer' => true,
                'id' => 'pre_img',
                'type' => 'media',
                'url' => true,
                'customizer' => true,
                'required' => array(
                    array( 'preloader_visibility', '=', '1' ),
                    array( 'pre_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Background Color', 'electron' ),
                'subtitle' => esc_html__( 'Add preloader background color.', 'electron' ),
                'customizer' => true,
                'id' => 'pre_bg',
                'type' => 'color',
                'default' => '',
                'required' => array( 'preloader_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Spin Color', 'electron' ),
                'subtitle' => esc_html__( 'Add preloader spin color.', 'electron' ),
                'customizer' => true,
                'id' => 'pre_spin',
                'type' => 'color',
                'default' => '',
                'required' => array( 'preloader_visibility', '=', '1' )
            )
        )
    ));
    //NEWSLETTER SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Popup Newsletter', 'electron' ),
        'id' => 'themenewslettersubsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Newsletter Popup', 'electron' ),
                'subtitle' => esc_html__( 'If enabled, adds preloader.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_visibility',
                'type' => 'switch',
                'default' => false
            ),
            array(
                'title' => esc_html__( 'Template Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your preloader type.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_type',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Default', 'electron' ),
                    'elementor' => esc_html__( 'Elementor', 'electron' ),
                    'shortcode' => esc_html__( 'Shortcode', 'electron' )
                ),
                'default' => 'default',
                'required' => array( 'popup_newsletter_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Image Position', 'electron' ),
                'subtitle' => esc_html__( 'Select your image direction.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_direction',
                'type' => 'button_set',
                'customizer' => true,
                'options' => array(
                    'image-left' => esc_html__( 'Left (default)', 'electron' ),
                    'image-right' => esc_html__( 'Right', 'electron' ),
                    'image-top' => esc_html__( 'Top', 'electron' ),
                    'image-bottom' => esc_html__( 'Bottom', 'electron' ),
                ),
                'default' => 'image-left',
                'required' => array(
                    array( 'popup_newsletter_visibility', '=', '1' ),
                    array( 'popup_newsletter_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Image', 'electron' ),
                'subtitle' => esc_html__( 'Upload your image', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_image',
                'type' => 'media',
                'url' => true,
                'required' => array(
                    array( 'popup_newsletter_visibility', '=', '1' ),
                    array( 'popup_newsletter_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Content', 'electron' ),
                'subtitle' => esc_html__( 'Add your shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_content',
                'type' => 'editor',
                'customizer' => false,
                'args'   => array(
                    'wpautop'       => false,
                    'teeny'         => true,
                    'textarea_rows' => 10
                ),
                'required' => array(
                    array( 'popup_newsletter_visibility', '=', '1' ),
                    array( 'popup_newsletter_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array(
                    array( 'popup_newsletter_visibility', '=', '1' ),
                    array( 'popup_newsletter_type', '=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Shortcode', 'electron' ),
                'subtitle' => esc_html__( 'Add your shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_shortcode',
                'type' => 'text',
                'validate' => 'number',
                'customizer' => true,
                'required' => array(
                    array( 'popup_newsletter_visibility', '=', '1' ),
                    array( 'popup_newsletter_type', '=', 'shortcode' )
                )
            ),
            array(
                'title' => esc_html__( 'Expire Date', 'electron' ),
                'subtitle' => esc_html__( 'Add your expire date here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_newsletter_expire_date',
                'type' => 'text',
                'validate' => 'number',
                'default' => 15,
                'customizer' => true,
                'required' => array( 'popup_newsletter_visibility', '=', '1' )
            )
        )
    ));
    //NEWSLETTER SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Popup Site Close', 'electron' ),
        'id' => 'popup_siteclose_subsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Site Close Popup', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_visibility',
                'type' => 'switch',
                'default' => 0
            ),
            array(
                'title' => esc_html__( 'Template Type', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_type',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Default', 'electron' ),
                    'elementor' => esc_html__( 'Elementor', 'electron' ),
                    'shortcode' => esc_html__( 'Shortcode', 'electron' )
                ),
                'default' => 'default',
                'required' => array( 'popup_siteclose_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Expire Date', 'electron' ),
                'subtitle' => esc_html__( 'Add your expire date here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_expire_date',
                'type' => 'text',
                'validate' => 'number',
                'default' => 15,
                'customizer' => true,
                'required' => array( 'popup_siteclose_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Column Count', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_column',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'col-1' => esc_html__( '1 Column', 'electron' ),
                    'col-2' => esc_html__( '2 Column', 'electron' ),
                ),
                'default' => 'col-2',
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Column Layout', 'electron' ),
                'subtitle' => esc_html__( 'Select your column direction.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_direction',
                'type' => 'button_set',
                'customizer' => true,
                'options' => array(
                    'left-right' => esc_html__( 'Left-Right (default)', 'electron' ),
                    'right-left' => esc_html__( 'Right-Left', 'electron' ),
                    'top-bottom' => esc_html__( 'Top-Bottom', 'electron' ),
                    'bottom-top' => esc_html__( 'Bottom-Top', 'electron' ),
                ),
                'default' => 'left-right',
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Content Left', 'electron' ),
                'subtitle' => esc_html__( 'Add your html/shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left',
                'type' => 'editor',
                'customizer' => false,
                'default' => '<h4 class="content-heading">Before You Leave!</h4>
                <p class="subtitle">Get 12% Discount in Your Cart</p>
                <div class="coupon-code">COUPON12</div>
                <div class="desc">You can use the above code to get a 12% DISCOUNT on your first order during checkout...</div>
                <a class="electron-btn electron-btn-primary has-icon icon-after" href="https://ninetheme.com/themes/electron/shop/"><div class="btn-text" data-hover="Start Shopping"></div></a>',

                'args'   => array(
                    'wpautop'       => false,
                    'teeny'         => true,
                    'textarea_rows' => 10
                ),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Content Right Type', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_right_type',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'products' => esc_html__( 'Products', 'electron' ),
                    'custom' => esc_html__( 'Custom Content', 'electron' ),
                ),
                'default' => 'products',
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Content Right', 'electron' ),
                'subtitle' => esc_html__( 'Add your html/shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_right',
                'type' => 'editor',
                'customizer' => false,
                'args'   => array(
                    'wpautop'       => false,
                    'teeny'         => true,
                    'textarea_rows' => 10
                ),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                    array( 'popup_siteclose_content_right_type', '=', 'custom' ),
                )
            ),
            array(
                'title' => esc_html__( 'Products Heading', 'electron' ),
                'subtitle' => esc_html__( 'Add your products heading here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_products_heading',
                'type' => 'text',
                'customizer' => true,
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                    array( 'popup_siteclose_content_right_type', '=', 'products' ),
                )
            ),
            array(
                'title' => esc_html__( 'Products IDs', 'electron' ),
                'subtitle' => esc_html__( 'Add your products ids here,separate each product id with comma.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_products',
                'type' => 'text',
                'placeholder' => '18061,18060,18059,18033,18029',
                'customizer' => true,
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                    array( 'popup_siteclose_content_right_type', '=', 'products' ),
                )
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Shortcode', 'electron' ),
                'subtitle' => esc_html__( 'Add your shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_shortcode',
                'type' => 'text',
                'validate' => 'number',
                'customizer' => true,
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'shortcode' )
                )
            ),
            array(
                'title' => esc_html__( 'Customize Options', 'electron' ),
                'id' => 'popup_siteclose_customize_divide',
                'type' => 'info',
                'style' => 'success',
                'color' => '#000',
                'icon' => 'el el-brush',
                'notice' => true,
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                    array( 'popup_siteclose_content_right_type', '=', 'products' ),
                )
            ),
            array(
                'title' => esc_html__( 'Popup Max Width', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_maxwidth',
                'type' => 'dimensions',
                'output' => array('.electron-siteclose-inner'),
                'mode' => 'max-width',
                'units' => array('px'),
                'all' => false,
                'height' => false,
                'required' => array( 'popup_siteclose_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Content Left Max Width', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_maxwidth',
                'type' => 'dimensions',
                'output' => array('.electron-siteclose-inner .content-left'),
                'mode' => 'max-width',
                'units' => array('%'),
                'all' => false,
                'height' => false,
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Right Max Width', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_right_maxwidth',
                'type' => 'dimensions',
                'output' => array('.electron-siteclose-inner .content-right'),
                'mode' => 'max-width',
                'units' => array('%'),
                'all' => false,
                'height' => false,
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Popup Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_bg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Right Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_right_bg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-right'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Right Heading Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_right_heading_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-right .content-heading'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Right Product Name Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_right_prname_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-right .product-name'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Right Product Name Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_right_price_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-right .product-price'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Heading Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_heading_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .content-heading,.electron-siteclose-inner .content-left h1,.electron-siteclose-inner .content-left h2,.electron-siteclose-inner .content-left h3,.electron-siteclose-inner .content-left h4,.electron-siteclose-inner .content-left h5,.electron-siteclose-inner .content-left h6'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Subtitle Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_subtitle_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .subtitle'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Coupon Border Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_coupon_clr',
                'type' => 'color',
                'mode' => 'border-color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .coupon-code'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Paragraph Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_p_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .desc,.electron-siteclose-inner .content-left p'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Button Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_btn_bgclr',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .electron-btn'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Button Background Color ( Hover )', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_btn_hvtbgclr',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .electron-btn:hover'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Button Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_btn_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .electron-btn'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
            array(
                'title' => esc_html__( 'Content Left Button Background Color ( Hover )', 'electron' ),
                'customizer' => true,
                'id' => 'popup_siteclose_content_left_btn_hvtclr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-siteclose-inner .content-left .electron-btn:hover'),
                'required' => array(
                    array( 'popup_siteclose_visibility', '=', '1' ),
                    array( 'popup_siteclose_type', '=', 'default' ),
                )
            ),
        )
    ));
    //NEWSLETTER SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Popup Discount Form', 'electron' ),
        'id' => 'popup_form_subsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Popup Form', 'electron' ),
                'subtitle' => esc_html__( 'You can choose status of GDPR', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_visibility',
                'type' => 'switch',
                'default' => 0
            ),
            array(
                'title' => esc_html__( 'Template Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your preloader type.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_type',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Default', 'electron' ),
                    'elementor' => esc_html__( 'Elementor', 'electron' ),
                    'shortcode' => esc_html__( 'Shortcode', 'electron' )
                ),
                'default' => 'default',
                'required' => array( 'popup_form_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Style', 'electron' ),
                'subtitle' => esc_html__( 'Select your preloader type.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_style',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Style 1', 'electron' ),
                    'style-2' => esc_html__( 'Style 2', 'electron' ),
                ),
                'default' => 'default',
                'required' => array( 'popup_form_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Shortcode', 'electron' ),
                'subtitle' => esc_html__( 'Add your shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_shortcode',
                'type' => 'text',
                'customizer' => true,
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'shortcode' )
                )
            ),
            array(
                'title' => esc_html__( 'Timeout', 'electron' ),
                'subtitle' => esc_html__( 'Show this popup form trigger button after page loaded', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_timeout',
                'type' => 'text',
                'validate' => 'number',
                'default' => 10000,
                'customizer' => true,
                'required' => array( 'popup_form_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Expire Date', 'electron' ),
                'subtitle' => esc_html__( 'Add your expire date here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_expire_date',
                'type' => 'text',
                'validate' => 'number',
                'default' => 15,
                'customizer' => true,
                'required' => array( 'popup_form_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Button Text', 'electron' ),
                'subtitle' => esc_html__( 'Add your gdpr button text here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_text',
                'type' => 'text',
                'default' => '%12 Discount',
                'customizer' => true,
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Content', 'electron' ),
                'subtitle' => esc_html__( 'Add your html/shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_content',
                'type' => 'editor',
                'customizer' => false,
                'args'   => array(
                    'wpautop'       => false,
                    'teeny'         => true,
                    'textarea_rows' => 10
                ),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Customize Options', 'electron' ),
                'id' => 'popup_form_customize_divide',
                'type' => 'info',
                'style' => 'success',
                'color' => '#000',
                'icon' => 'el el-brush',
                'notice' => true,
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Form Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_bg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('#formPopupInner.electron-popupform-inner'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Trigger Button Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_bg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.electron-popupform-trigger'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Trigger Button Text Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-popupform-trigger'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Trigger Button Text Color ( Hover )', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_hvrclr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.electron-popupform-trigger:hover .btn-text'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Close Button Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_close_bg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('div#formPopupBtn .panel-close,#formPopup .panel-close'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Close Button Background Color ( Hover )', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_close_hvrbg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('div#formPopupBtn .panel-close:hover,#formPopup .panel-close:hover'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Close Button Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_close_clr',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('div#formPopupBtn .panel-close:before, div#formPopupBtn .panel-close:after,#formPopup .panel-close:before,#formPopup .panel-close:after'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Close Button Hint Backgorund Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_close_hint_bgclr',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('div#formPopupBtn .electron-hint,#formPopup .electron-hint'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Close Button Hint Arrow Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_close_hint_bgclr2',
                'type' => 'color',
                'mode' => 'border-left-color',
                'validate' => 'color',
                'output' => array('div#formPopupBtn .hint-left .electron-hint:before,#formPopup .electron-hint:before'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Popup Close Button Hint Text Color', 'electron' ),
                'customizer' => true,
                'id' => 'popup_form_btn_close_hint_text_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('div#formPopupBtn .hint-left .electron-hint,#formPopup .hint-left .electron-hint'),
                'required' => array(
                    array( 'popup_form_visibility', '=', '1' ),
                    array( 'popup_form_type', '=', 'default' )
                )
            ),
        )
    ));
    //NEWSLETTER SETTINGS SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Popup GDPR', 'electron' ),
        'id' => 'themegdprsubsection',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Popup GDPR', 'electron' ),
                'subtitle' => esc_html__( 'You can choose status of GDPR', 'electron' ),
                'customizer' => true,
                'id' => 'popup_gdpr_visibility',
                'type' => 'switch',
                'default' => 0
            ),
            array(
                'title' => esc_html__( 'Template Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your preloader type.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_gdpr_type',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Default', 'electron' ),
                    'elementor' => esc_html__( 'Elementor', 'electron' ),
                    'shortcode' => esc_html__( 'Shortcode', 'electron' )
                ),
                'default' => 'default',
                'required' => array( 'popup_gdpr_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Style', 'electron' ),
                'subtitle' => esc_html__( 'Select your preloader type.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_gdpr_style',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Style 1', 'electron' ),
                    'style-2' => esc_html__( 'Style 2', 'electron' ),
                ),
                'default' => 'default',
                'required' => array( 'popup_gdpr_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
                'customizer' => true,
                'id' => 'popup_gdpr_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array(
                    array( 'popup_gdpr_visibility', '=', '1' ),
                    array( 'popup_gdpr_type', '=', 'elementor' )
                )
            ),
            array(
                'title' => esc_html__( 'Shortcode', 'electron' ),
                'subtitle' => esc_html__( 'Add your shortcode here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_gdpr_shortcode',
                'type' => 'text',
                'required' => array(
                    array( 'popup_gdpr_visibility', '=', '1' ),
                    array( 'popup_gdpr_type', '=', 'shortcode' )
                )
            ),
            array(
                'title' => esc_html__( 'Expire Date', 'electron' ),
                'subtitle' => esc_html__( 'Add your expire date here', 'electron' ),
                'customizer' => true,
                'id' => 'popup_gdpr_expire_date',
                'type' => 'text',
                'validate' => 'number',
                'default' => 15,
                'required' => array( 'popup_gdpr_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Icon Image', 'electron' ),
                'subtitle' => esc_html__( 'Upload your image.', 'electron' ),
                'customizer' => true,
                'id' => 'gdpr_image',
                'type' => 'media',
                'url' => true,
                'required' => array(
                    array( 'popup_gdpr_visibility', '=', '1' ),
                    array( 'popup_gdpr_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'GDPR Text', 'electron' ),
                'subtitle' => esc_html__( 'Add your gdpr text here', 'electron' ),
                'customizer' => true,
                'id' => 'gdpr_text',
                'type' => 'textarea',
                'default' => 'In order to provide you a personalized shopping experience, our site uses cookies. <br><a href="#">cookie policy</a>.',
                'required' => array(
                    array( 'popup_gdpr_visibility', '=', '1' ),
                    array( 'popup_gdpr_type', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'GDPR Button Text', 'electron' ),
                'subtitle' => esc_html__( 'Add your gdpr button text here', 'electron' ),
                'customizer' => true,
                'id' => 'gdpr_button_text',
                'type' => 'text',
                'default' => 'Accept Cookies',
                'required' => array( 'popup_gdpr_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'gdpr_bg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.site-gdpr'),
                'required' => array( 'popup_gdpr_visibility', '=', '1' )
            )
        )
    ));

    $is_right = is_rtl() ? 'right' : 'left';
    $is_left = is_rtl() ? 'left' : 'right';
    //BACKTOTOP BUTTON SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Back-to-top Button', 'electron' ),
        'id' => 'backtotop',
        'icon' => 'el el-cog',
        'subsection' => true,
        'fields' => array(
            array(
                'title' => esc_html__( 'Back-to-top', 'electron' ),
                'subtitle' => esc_html__( 'Switch On-off', 'electron' ),
                'desc' => esc_html__( 'If enabled, adds back to top.', 'electron' ),
                'customizer' => true,
                'id' => 'backtotop_visibility',
                'type' => 'switch',
                'default' => true
            ),
            array(
                'title' => esc_html__( 'Bottom Offset', 'electron' ),
                'subtitle' => esc_html__( 'Set custom bottom offset for the back-to-top button', 'electron' ),
                'customizer' => true,
                'id' => 'backtotop_top_offset',
                'type' => 'spacing',
                'output' => array('.scroll-to-top'),
                'mode' => 'absolute',
                'units' => array('px'),
                'all' => false,
                'top' => false,
                $is_left => true,
                'bottom' => true,
                $is_right => false,
                'default' => array(
                    $is_left => '30',
                    'bottom' => '30',
                    'units' => 'px'
                ),
                'required' => array( 'backtotop_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'backtotop_bg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.scroll-to-top'),
                'required' => array( 'backtotop_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Hover Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'backtotop_hvrbg',
                'type' => 'color',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.scroll-to-top:hover'),
                'required' => array( 'backtotop_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Arrow Color', 'electron' ),
                'customizer' => true,
                'id' => 'backtotop_icon',
                'type' => 'color',
                'default' =>  '',
                'validate' => 'color',
                'output' => array('.scroll-to-top'),
                'required' => array( 'backtotop_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Hover Arrow Color', 'electron' ),
                'customizer' => true,
                'id' => 'backtotop_hvricon',
                'type' => 'color',
                'default' =>  '',
                'validate' => 'color',
                'output' => array('.scroll-to-top:hover'),
                'required' => array( 'backtotop_visibility', '=', '1' )
            )
        )
    ));

    // THEME PAGINATION SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Pagination', 'electron' ),
        'desc' => esc_html__( 'These are main settings for general theme!', 'electron' ),
        'id' => 'pagination',
        'subsection' => true,
        'icon' => 'el el-link',
        'fields' => array(
            array(
                'title' => esc_html__( 'Pagination', 'electron' ),
                'subtitle' => esc_html__( 'Switch On-off', 'electron' ),
                'desc' => esc_html__( 'If enabled, adds pagination.', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_visibility',
                'type' => 'switch',
                'default' => true
            ),
            array(
                'title' => esc_html__( 'Alignment', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_alignment',
                'type' => 'button_set',
                'customizer' => true,
                'options' => array(
                    'flex-start' => esc_html__( 'Left', 'electron' ),
                    'center' => esc_html__( 'Center', 'electron' ),
                    'flex-end' => esc_html__( 'Right', 'electron' )
                ),
                'default' => 'center',
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Size', 'electron' ),
                'subtitle' => esc_html__( 'Set the pagination link width and height of the image.', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_size',
                'type' => 'dimensions',
                'output' => array('.nt-pagination .nt-pagination-item .nt-pagination-link,.electron-woocommerce-pagination ul li a, .electron-woocommerce-pagination ul li span' ),
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Border', 'electron' ),
                'subtitle' => esc_html__( 'Set the pagination link border', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_border',
                'type' => 'border',
                'output' => array('.nt-pagination .nt-pagination-item .nt-pagination-link,.electron-woocommerce-pagination ul li a, .electron-woocommerce-pagination ul li span' ),
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Border ( Hover/Active )', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_hvrborder',
                'type' => 'border',
                'output' => array('.nt-pagination .nt-pagination-item.active .nt-pagination-link,.nt-pagination .nt-pagination-item .nt-pagination-link:hover,.electron-woocommerce-pagination ul li a:focus, .electron-woocommerce-pagination ul li a:hover, .electron-woocommerce-pagination ul li span.current' ),
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Border Radius ( px )', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_border_radius',
                'type' => 'slider',
                'max' => 300,
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Background Color', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_bgclr',
                'type' => 'color_rgba',
                'mode' => 'background-color',
                'validate' => 'color',
                'output' => array('.nt-pagination .nt-pagination-item .nt-pagination-link,.electron-woocommerce-pagination ul li a, .electron-woocommerce-pagination ul li span' ),
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Background Color ( Hover/Active )', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_hvrbgclr',
                'type' => 'color_rgba',
                'mode' => 'background-color',
                'output' => array('.nt-pagination .nt-pagination-item.active .nt-pagination-link,.nt-pagination .nt-pagination-item .nt-pagination-link:hover,.electron-woocommerce-pagination ul li a:focus, .electron-woocommerce-pagination ul li a:hover, .electron-woocommerce-pagination ul li span.current' ),
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Number Color', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_clr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.nt-pagination .nt-pagination-item .nt-pagination-link,.electron-woocommerce-pagination ul li a, .electron-woocommerce-pagination ul li span' ),
                'required' => array( 'pagination_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Number Color ( Hover/Active )', 'electron' ),
                'customizer' => true,
                'id' => 'pagination_hvrclr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array('.nt-pagination .nt-pagination-item.active .nt-pagination-link,.nt-pagination .nt-pagination-item .nt-pagination-link:hover,.electron-woocommerce-pagination ul li a:focus, .electron-woocommerce-pagination ul li a:hover, .electron-woocommerce-pagination ul li span.current' ),
                'required' => array( 'pagination_visibility', '=', '1' )
            )
        )
    ));

    // THEME OPTIMIZATION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Optimization', 'electron' ),
        'desc' => esc_html__( 'These are main settings for general theme!', 'electron' ),
        'id' => 'themeoptimization',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Disable Gutenberg Editor', 'electron' ),
                'subtitle' => esc_html__( 'This theme does not support gutenberg so some css files are filtered, if you want to use gutenberg you can use this option', 'electron' ),
                'customizer' => true,
                'id' => 'theme_blocks_styles',
                'type' => 'switch',
                'default' => false
            )
        )
    ));

    /*************************************************
    ## LOGO SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Logo', 'electron' ),
        'desc' => esc_html__( 'These are main settings for general theme!', 'electron' ),
        'id' => 'logosection',
        'icon' => 'el el-star-empty',
        'fields' => array(
            array(
                'title' => esc_html__( 'Logo Switch', 'electron' ),
                'subtitle' => esc_html__( 'You can select logo on or off.', 'electron' ),
                'customizer' => true,
                'id' => 'logo_visibility',
                'type' => 'switch',
                'default' => true
            ),
            array(
                'title' => esc_html__( 'Logo Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your logo type.', 'electron' ),
                'customizer' => true,
                'id' => 'logo_type',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'img' => esc_html__( 'Image Logo', 'electron' ),
                    'sitename' => esc_html__( 'Site Name', 'electron' ),
                    'customtext' => esc_html__( 'Custom HTML', 'electron' )
                ),
                'default' => 'sitename',
                'required' => array( 'logo_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Custom text for logo', 'electron' ),
                'desc' => esc_html__( 'Text entered here will be used as logo', 'electron' ),
                'customizer' => true,
                'id' => 'text_logo',
                'type' => 'editor',
                'args' => array(
                    'teeny' => false,
                    'textarea_rows' => 10
                ),
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '=', 'customtext' )
                ),
            ),
            array(
                'title' => esc_html__( 'Hover Logo Color', 'electron' ),
                'desc' => esc_html__( 'Set your own hover color for the text logo.', 'electron' ),
                'customizer' => true,
                'id' => 'text_logo_hvr',
                'type' => 'color',
                'validate' => 'color',
                'output' => array( '.nt-logo .header-text-logo:hover' ),
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '!=', 'img' )
                )
            ),
            array(
                'title' => esc_html__( 'Logo Image', 'electron' ),
                'subtitle' => esc_html__( 'Upload your Logo. If left blank theme will use site default logo.', 'electron' ),
                'customizer' => true,
                'id' => 'img_logo',
                'type' => 'media',
                'url' => true,
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '=', 'img' )
                )
            ),
            array(
                'title' => esc_html__( 'Logo Size', 'electron' ),
                'subtitle' => esc_html__( 'Set the logo max-width of the image.', 'electron' ),
                'customizer' => true,
                'id' => 'logo_size',
                'type' => 'slider',
                'default' => '',
                'min' => 0,
                'step' => 1,
                'max' => 400,
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '=', 'img' ),
                    array( 'logo_type', '!=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Sticky Logo', 'electron' ),
                'subtitle' => esc_html__( 'Upload your Logo. If left blank theme will use site default logo.', 'electron' ),
                'customizer' => true,
                'id' => 'sticky_logo',
                'type' => 'media',
                'url' => true,
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '=', 'img' )
                )
            ),
            array(
                'title' => esc_html__( 'Sticky Logo Size', 'electron' ),
                'subtitle' => esc_html__( 'Set the logo max-width of the image.', 'electron' ),
                'customizer' => true,
                'id' => 'sticky_logo_size',
                'type' => 'slider',
                'default' => '',
                'min' => 0,
                'step' => 1,
                'max' => 400,
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '=', 'img' )
                )
            ),
            array(
                'title' => esc_html__( 'Mobile Menu Logo', 'electron' ),
                'subtitle' => esc_html__( 'Upload your Logo. If left blank theme will use site default logo.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_logo',
                'type' => 'media',
                'url' => true,
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '=', 'img' )
                )
            ),
            array(
                'title' => esc_html__( 'Mobile Logo Size', 'electron' ),
                'subtitle' => esc_html__( 'Set the logo max-width of the image.', 'electron' ),
                'customizer' => true,
                'id' => 'mobile_logo_size',
                'default' => '',
                'min' => 0,
                'step' => 1,
                'max' => 400,
                'type' => 'slider',
                'required' => array(
                    array( 'logo_visibility', '=', '1' ),
                    array( 'logo_type', '=', 'img' ),
                    array( 'logo_type', '!=', '' )
                )
            )
        )
    ));
    //FOOTER SECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Footer', 'electron' ),
        'desc' => esc_html__( 'These are main settings for general theme!', 'electron' ),
        'id' => 'footersection',
        'icon' => 'el el-photo',
        'fields' => array(
            array(
                'title' => esc_html__( 'Footer Section Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site footer copyright and footer widget area on the site with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Footer Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your footer type.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_template',
                'type' => 'select',
                'customizer' => true,
                'options' => array(
                    'default' => esc_html__( 'Deafult Site Footer', 'electron' ),
                    'elementor' => esc_html__( 'Elementor Templates', 'electron' )
                ),
                'default' => 'default',
                'required' => array( 'footer_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'elementor' )
                )
            ),
            array(
                'id' =>'edit_footer_template',
                'type' => 'info',
                'desc' => 'Edit template',
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'elementor' ),
                    array( 'footer_elementor_templates', '!=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Footer Ajax', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to load footer with ajax', 'electron' ),
                'customizer' => true,
                'id' => 'footer_ajax',
                'type' => 'switch',
                'default' => 0,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'elementor' ),
                    array( 'footer_elementor_templates', '!=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Save Footer Template ( Local Storage )', 'electron' ),
                'subtitle' => esc_html__( 'Save data to local storage after ajax', 'electron' ),
                'customizer' => true,
                'id' => 'footer_ajax_localstorage',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'elementor' ),
                    array( 'footer_elementor_templates', '!=', '' ),
                    array( 'footer_ajax', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Copyright Text', 'electron' ),
                'subtitle' => esc_html__( 'HTML allowed (wp_kses)', 'electron' ),
                'desc' => esc_html__( 'Enter your site copyright text here.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_copyright',
                'type' => 'textarea',
                'validate' => 'html',
                'default' => sprintf( '<p>&copy; %1$s, <a class="theme" href="%2$s">%3$s</a> Theme. %4$s <a class="dev" href="https://electron.com/contact/">%5$s</a></p>',
                    date( 'Y' ),
                    esc_url( home_url( '/' ) ),
                    get_bloginfo( 'name' ),
                    esc_html__( 'Made with passion by', 'electron' ),
                    esc_html__( 'Ninetheme.', 'electron' )
                ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'default' )
                )
            ),
            //information on-off
            array(
                'id' =>'info_f0',
                'type' => 'info',
                'style' => 'success',
                'title' => esc_html__( 'Success!', 'electron' ),
                'icon' => 'el el-info-circle',
                'customizer' => true,
                'desc' => sprintf(esc_html__( '%s section is disabled on the site.Please activate to view subsection options.', 'electron' ), '<b>Site Main Footer</b>' ),
                'required' => array( 'footer_visibility', '=', '0' )
            )
        )
    ));
    //FOOTER SECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Footer Style', 'electron' ),
        'desc' => esc_html__( 'These are main settings for general theme!', 'electron' ),
        'id' => 'footer_style_subsection',
        'icon' => 'el el-photo',
        'subsection' => true,
        'fields' => array(
            array(
                'id' =>'footer_color_customize',
                'type' => 'info',
                'icon' => 'el el-brush',
                'customizer' => false,
                'desc' => sprintf(esc_html__( '%s', 'electron' ), '<h2>Footer Color Customize</h2>' ),
                'customizer' => true,
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Footer Padding', 'electron' ),
                'subtitle' => esc_html__( 'You can set the top spacing of the site main footer.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_pad',
                'type' => 'spacing',
                'output' => array('#nt-footer' ),
                'mode' => 'padding',
                'units' => array('em', 'px' ),
                'units_extended' => 'false',
                'default' => array(
                    'padding-top' => '',
                    'padding-right' => '',
                    'padding-bottom' => '',
                    'padding-left' => '',
                    'units' => 'px'
                ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Footer Background Color', 'electron' ),
                'desc' => esc_html__( 'Set your own colors for the footer.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_bg_clr',
                'type' => 'color',
                'validate' => 'color',
                'mode' => 'background-color',
                'output' => array( '#nt-footer' ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Copyright Text Color', 'electron' ),
                'desc' => esc_html__( 'Set your own colors for the copyright.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_copy_clr',
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'output' => array( '#nt-footer, #nt-footer p' ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Link Color', 'electron' ),
                'desc' => esc_html__( 'Set your own colors for the copyright.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_link_clr',
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'output' => array( '#nt-footer a' ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'default' )
                )
            ),
            array(
                'title' => esc_html__( 'Link Color ( Hover )', 'electron' ),
                'desc' => esc_html__( 'Set your own colors for the copyright.', 'electron' ),
                'customizer' => true,
                'id' => 'footer_link_hvr_clr',
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'output' => array( '#nt-footer a:hover' ),
                'required' => array(
                    array( 'footer_visibility', '=', '1' ),
                    array( 'footer_template', '=', 'default' )
                )
            ),
            //information on-off
            array(
                'id' =>'info_fc0',
                'type' => 'info',
                'style' => 'success',
                'title' => esc_html__( 'Success!', 'electron' ),
                'icon' => 'el el-info-circle',
                'customizer' => true,
                'desc' => sprintf(esc_html__( '%s section is disabled on the site.Please activate to view subsection options.', 'electron' ), '<b>Site Main Footer</b>' ),
                'required' => array( 'footer_visibility', '=', '0' )
            )
        )
    ));

    /*************************************************
    ## WOOCOMMERCE SECTION
    *************************************************/
    if ( class_exists( 'WooCommerce' ) ) {
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'WooCommerce', 'electron' ),
            'id' => 'woocommerce_section',
            'icon' => 'el el-shopping-cart-sign',
            'fields' => array(
            )
        ));
        $ajax_fields = array();
        $ajax_fields[] = array(
            'title' => esc_html__('Ajax Shop', 'electron'),
            'subtitle' => esc_html__('You can enable or disable the site shop page ajax filter actions.', 'electron'),
            'customizer' => true,
            'id' => 'shop_ajax_filter',
            'type' => 'switch',
            'default' => 1
        );
        $ajax_fields[] = array(
            'title' => esc_html__('Ajax Login/Register', 'electron'),
            'subtitle' => esc_html__('You can turn ajax login and registration process on or off here.', 'electron'),
            'customizer' => true,
            'id' => 'wc_ajax_login_register',
            'type' => 'switch',
            'default' => 1
        );
        $ajax_fields[] = array(
            'title' => esc_html__('URL to Redirect After Login ( General )', 'electron'),
            'customizer' => true,
            'id' => 'wc_ajax_login_redirect_url',
            'type' => 'text',
            'required' => array( 'wc_ajax_login_register', '=', '1' )
        );
        $ajax_fields[] = array(
            'title' => esc_html__('URL to Redirect After Registration ( General )', 'electron'),
            'customizer' => true,
            'id' => 'wc_ajax_register_redirect_url',
            'type' => 'text',
            'required' => array( 'wc_ajax_login_register', '=', '1' )
        );
        $ajax_fields[] = array(
            'title' => esc_html__('Custom Rerdirect URL By User Role ( Login )', 'electron'),
            'subtitle' => esc_html__('Redirect users to custom URL based on their role after login.', 'electron'),
            'customizer' => true,
            'id' => 'wc_ajax_login_custom_roles',
            'type' => 'switch',
            'default' => 0,
            'required' => array( 'wc_ajax_login_register', '=', '1' )
        );
        $ajax_fields[] = array(
            'title' => esc_html__( 'Select User Role(s)', 'electron' ),
            'subtitle' => esc_html__( 'Select Role(s) from the list.', 'electron' ),
            'customizer' => true,
            'id' => 'wc_ajax_login_roles',
            'type' => 'select',
            'sortable' => true,
            'data'  => 'roles',
            'multi' => true,
            'required' => array(
                array( 'wc_ajax_login_register', '=', '1' ),
                array( 'wc_ajax_login_custom_roles', '=', '1' )
            )
        );
        global $wp_roles;
        $roles = $wp_roles->roles;
        foreach ( $roles as $key => $value ) {
            if ( !empty($key) ) {
                $ajax_fields[] = array(
                    'title' => sprintf(esc_html__('Redirect URL ( for %s )', 'electron'),$value['name']),
                    'customizer' => true,
                    'id' => 'redirect_url_'.$key,
                    'type' => 'text',
                    'required' => array(
                        array( 'wc_ajax_login_register', '=', '1' ),
                        array( 'wc_ajax_login_custom_roles', '=', '1' ),
                        array( 'wc_ajax_login_roles', '=', $key ),
                    )
                );
            }
        }

        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'Ajax', 'electron' ),
            'id' => 'woocommerce_ajax_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => $ajax_fields
        ));

        // Quick Shop SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Ajax Add To Cart', 'electron'),
            'id' => 'shop_ajax_addtocart_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Ajax Add To Cart ( for Simple Products )', 'electron'),
                    'customizer' => true,
                    'id' => 'ajax_addtocart',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Ajax Add To Cart ( for Product Page )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_ajax_addtocart_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__( 'Ajax Add To Cart ( for Variable and Grouped Products ) Customize', 'electron' ),
                    'indent' => false,
                    'id' => 'quick_shop_lightbox_divide',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-cog',
                    'notice' => true,
                    'required' => array( 'quick_shop', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Ajax Add To Cart ( for Variable and Grouped Products )', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_shop',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Popup Overlay Color', 'electron'),
                    'subtitle' => esc_html__('Change quick view overlay color.', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_shop_overlaycolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.mfp-bg.mfp-electron-quickshop'),
                    'required' => array( 'quick_shop', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Content Background Color', 'electron'),
                    'subtitle' => esc_html__('Change quick view background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_shop_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-quickshop-wrapper'),
                    'required' => array( 'quick_shop', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Content Border', 'electron'),
                    'subtitle' => esc_html__('Set your custom border styles for the posts.', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_shop_brd',
                    'type' => 'border',
                    'all' => false,
                    'output' => array('.electron-quickshop-wrapper'),
                    'required' => array( 'quick_shop', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Content Padding', 'electron'),
                    'subtitle' => esc_html__('You can set the spacing of the site shop page post.', 'electron'),
                    'customizer' => true,
                    'id' =>'quick_shop_pad',
                    'type' => 'spacing',
                    'output' => array('.electron-quickshop-wrapper'),
                    'mode' => 'padding',
                    'units' => array('em', 'px'),
                    'units_extended' => 'false',
                    'default' => array(
                        'units' => 'px'
                    ),
                    'required' => array( 'quick_shop', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Max Width', 'electron' ),
                    'subtitle' => esc_html__( 'You can use this option to control the theme content width.', 'electron' ),
                    'customizer' => true,
                    'id' => 'quick_shop_width',
                    'type' => 'slider',
                    'default' => '',
                    'min' => 0,
                    'step' => 1,
                    'max' => 4000,
                    'display_value' => 'text',
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Max Width Responsive ( min-width 768px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can use this option to control the theme content width.', 'electron' ),
                    'customizer' => true,
                    'id' => 'quick_shop_width_sm',
                    'type' => 'slider',
                    'default' => '',
                    'min' => 0,
                    'step' => 1,
                    'max' => 1200,
                    'display_value' => 'text',
                    'required' => array( 'quick_shop', '=', '1' )
                )
            )
        ));
        // Popup Notices SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Wishlist', 'electron'),
            'id' => 'compare_wishlist_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Wishlist Display', 'electron'),
                    'customizer' => true,
                    'id' => 'wishlist_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' =>'wishlist_shortcoe_info',
                    'type' => 'info',
                    'desc' =>  sprintf( esc_html__( 'Create new Wishlist page and use this shortcode %s to display the wishlist on a page.', 'electron' ),'<code>[electron_wishlist]</code>'),
                    'required' => array( 'wishlist_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Wishlist Page', 'electron' ),
                    'subtitle' => esc_html__( 'Select page from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'wishlist_page_id',
                    'type' => 'select',
                    'data' => 'page',
                    'multi' => false,
                    'required' => array( 'wishlist_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Wishlist Page Copy', 'electron'),
                    'customizer' => true,
                    'id' => 'wishlist_page_copy',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'wishlist_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Wishlist My Account Page', 'styler'),
                    'customizer' => true,
                    'id' => 'wishlist_page_myaccount',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'wishlist_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Disable the wishlist for unauthenticated users', 'electron'),
                    'customizer' => true,
                    'id' => 'wishlist_disable_unauthenticated',
                    'type' => 'switch',
                    'on' => esc_html__( 'Yes', 'electron' ),
                    'off' => esc_html__( 'No', 'electron' ),
                    'default' => 0,
                    'required' => array( 'wishlist_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Maximum wishlists per user', 'electron' ),
                    'desc' => esc_html__( 'Please leave this field blank for unlimited additions', 'electron' ),
                    'customizer' => true,
                    'id' => 'wishlist_max_count',
                    'type' => 'text',
                    'default' => '',
                    'validate' => array( 'numeric' ),
                    'required' => array( 'wishlist_visibility', '=', '1' )
                )
            )
        ));
        // Popup Notices SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Compare', 'electron'),
            'id' => 'compare_compare_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Compare Display', 'electron'),
                    'customizer' => true,
                    'id' => 'compare_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Use Most Popular Plugins', 'electron'),
                    'customizer' => true,
                    'id' => 'use_compare_plugins',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'compare_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Select Available Plugins', 'electron' ),
                    'id' =>'compare_plugin',
                    'type' => 'select',
                    'mutiple' => false,
                    'options' => array(
                        'wpc' => esc_html__( 'WPC Smart Compare', 'electron' ),
                        'yith' => esc_html__( 'Yith Compare', 'electron' ),
                    ),
                    'default' => 'wpc',
                    'required' => array(
                        array( 'compare_visibility', '=', '1' ),
                        array( 'use_compare_plugins', '=', '1' ),
                    )
                ),
                array(
                    'id' =>'compare_shortcoe_info',
                    'type' => 'info',
                    'desc' =>  sprintf( esc_html__( 'Create new Compare page and use this shortcode %s to display the compare on a page.', 'electron' ),'<code>[electron_compare]</code>'),
                    'required' => array(
                        array( 'compare_visibility', '=', '1' ),
                        array( 'use_compare_plugins', '=', '0' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Compare Page', 'electron' ),
                    'subtitle' => esc_html__( 'Select page from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'compare_page_id',
                    'type' => 'select',
                    'data' => 'page',
                    'multi' => false,
                    'required' => array( 'compare_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Maximum compare per user', 'electron' ),
                    'desc' => esc_html__( 'Please leave this field blank for unlimited additions', 'electron' ),
                    'customizer' => true,
                    'id' => 'compare_max_count',
                    'type' => 'text',
                    'default' => '100',
                    'validate' => array( 'numeric' ),
                    'required' => array(
                        array( 'compare_visibility', '=', '1' ),
                        array( 'use_compare_plugins', '=', '0' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Product Compare Button Action', 'electron' ),
                    'id' =>'compare_btn_action',
                    'type' => 'select',
                    'mutiple' => false,
                    'options' => array(
                        'popup' => esc_html__( 'Open Compare Popup', 'electron' ),
                        'message' => esc_html__( 'Show Message', 'electron' ),
                    ),
                    'default' => 'message',
                    'required' => array(
                        array( 'compare_visibility', '=', '1' ),
                        array( 'use_compare_plugins', '=', '0' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Header Compare Button Action', 'electron' ),
                    'id' =>'header_compare_btn_action',
                    'type' => 'select',
                    'mutiple' => false,
                    'options' => array(
                        'popup' => esc_html__( 'Open Compare Popup', 'electron' ),
                        'page' => esc_html__( 'Open Compare Page', 'electron' ),
                    ),
                    'default' => 'page',
                    'required' => array( 'compare_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Compare table', 'electron' ),
                    'id' =>'compare_table',
                    'type' => 'checkbox',
                    'mutiple' => false,
                    'options' => array(
                        'image' => esc_html__( 'Image', 'electron' ),
                        'price' => esc_html__( 'Price', 'electron' ),
                        'sku' => esc_html__( 'SKU', 'electron' ),
                        'stock' => esc_html__( 'Stock', 'electron' ),
                        'rating' => esc_html__( 'Rating', 'electron' ),
                        'desc' => esc_html__( 'Description', 'electron' ),
                        'content' => esc_html__( 'Content', 'electron' ),
                        'weight' => esc_html__( 'Weight', 'electron' ),
                        'dimensions' => esc_html__( 'Dimensions', 'electron' ),
                        'additional' => esc_html__( 'Additional information', 'electron' ),
                        'availability' => esc_html__( 'Availability', 'electron' ),
                        'cart' => esc_html__( 'Add to cart', 'electron' ),
                    ),
                    'default' => array(
                        'image' => 1,
                        'price' => 1,
                        'sku' => 1,
                        'stock' => 1,
                        'rating' => 0,
                        'desc' => 1,
                        'content' => 0,
                        'weight' => 1,
                        'dimensions' => 1,
                        'additional' => 1,
                        'availability' => 1,
                        'cart' => 1,
                    ),
                    'required' => array(
                        array( 'compare_visibility', '=', '1' ),
                        array( 'use_compare_plugins', '=', '0' )
                    )
                )
            )
        ));
        // Quick View SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Quick View', 'electron'),
            'id' => 'shop_quick_view_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Quick View Display', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' =>'quick_view_type',
                    'type' => 'button_set',
                    'title' => esc_html__('Quick View Display Type', 'electron'),
                    'customizer' => true,
                    'options' => array(
                        'popup' => esc_html__( 'Popup', 'electron' ),
                        'sidebar' => esc_html__( 'Sidebar', 'electron' )
                    ),
                    'default' => 'sidebar'
                ),
                array(
                    'title' => esc_html__('Overlay Color', 'electron'),
                    'subtitle' => esc_html__('Change quick view overlay color.', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_overlaycolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.mfp-bg.mfp-electron-quickview'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Content Background Color', 'electron'),
                    'subtitle' => esc_html__('Change quick view background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Content Border', 'electron'),
                    'subtitle' => esc_html__('Set your custom border styles for the posts.', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_brd',
                    'type' => 'border',
                    'all' => false,
                    'output' => array('.electron-quickview-wrapper'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Content Padding', 'electron'),
                    'subtitle' => esc_html__('You can set the spacing of the site shop page post.', 'electron'),
                    'customizer' => true,
                    'id' =>'quick_view_pad',
                    'type' => 'spacing',
                    'output' => array('.electron-quickview-wrapper'),
                    'mode' => 'padding',
                    'units' => array('em', 'px'),
                    'units_extended' => 'false',
                    'default' => array(
                        'units' => 'px'
                    ),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Content Width', 'electron' ),
                    'customizer' => true,
                    'id' => 'quick_view_width',
                    'type' => 'slider',
                    'default' => '',
                    'min' => 0,
                    'step' => 1,
                    'max' => 4000,
                    'display_value' => 'text',
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Content Width Responsive ( max-width 768px )', 'electron' ),
                    'customizer' => true,
                    'id' => 'quick_view_width_sm',
                    'type' => 'slider',
                    'default' => '',
                    'min' => 0,
                    'step' => 1,
                    'max' => 1200,
                    'display_value' => 'text',
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Close Button Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_close_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.mfp-electron-quickview .panel-close'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Close Button Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_close_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .panel-close:before,.electron-quickview-wrapper .panel-close:after'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Product Title Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_title_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-product-title'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Product Price Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_price_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-price'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Product Description Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_desc_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-product-summary .electron-summary-item p'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Add to Cart Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_btn_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-btn'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Add to Cart Background Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_btn_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-btn:hover'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Add to Cart Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_btn_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-btn'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Add to Cart Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_btn_hvrcolor',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-btn:hover'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Meta Label Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_meta_label_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .electron-meta-label'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Meta Value Color', 'electron'),
                    'customizer' => true,
                    'id' => 'quick_view_meta_value_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-quickview-wrapper .meta-value a'),
                    'required' => array( 'quick_view_visibility', '=', '1' )
                )
            )
        ));
        // Popup Notices SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Popup Notices', 'electron'),
            'id' => 'popup_notices_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Ajax Add to Cart Notices Display', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_notices_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__( 'Notices Duration ( ms )', 'electron' ),
                    'customizer' => true,
                    'id' => 'notices_duration',
                    'type' => 'slider',
                    'default' => 3500,
                    'min' => 0,
                    'step' => 100,
                    'max' => 20000,
                    'display_value' => 'text',
                    'required' => array( 'shop_notices_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'subtitle' => esc_html__('Change popup notices background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'notices_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-popup-notices'),
                    'required' => array( 'shop_notices_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Text Color', 'electron'),
                    'subtitle' => esc_html__('Change popup notices text color.', 'electron'),
                    'customizer' => true,
                    'id' => 'notices_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'default' => '',
                    'output' => array('.electron-shop-popup-notices .electron-shop-popup-notices-wrapper'),
                    'required' => array( 'shop_notices_visibility', '=', '1' )
                )
            )
        ));
        // Product Swatches SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Swatches', 'electron'),
            'id' => 'product_swatches_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Swatches', 'electron'),
                    'customizer' => true,
                    'id' => 'swatches_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' => 'product_variations_attr_start',
                    'type' => 'section',
                    'title' => esc_html__('Product Attribute Terms Customize Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'id' =>'variations_terms_shape',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Terms Box Type', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'radius' => esc_html__( 'radius', 'electron' ),
                        'square' => esc_html__( 'square', 'electron' )
                    ),
                    'default' => 'square',
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Outline', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_bordered',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' =>'variations_terms_checked_closed_icon_visibility',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Checked Icon', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        '1' => esc_html__( 'Show', 'electron' ),
                        '0' => esc_html__( 'Hide', 'electron' )
                    ),
                    'default' => '0',
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Attribute Customize ( for genaral )', 'electron' ),
                    'indent' => false,
                    'id' => 'product_attr_genaral_term_divide',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Term Size', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_attr_term_size',
                    'type' => 'dimensions',
                    'output' => array('.electron-type-color .electron-term,.electron-type-button.terms-outline .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_term_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-terms .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Active Term Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_term_active_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-terms .electron-term.electron-selected'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Disabled Term Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_term_inactive_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-terms .electron-term.electron-disabled'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Disabled Terms Opacity', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_term_inactive_opacity',
                    'type' => 'slider',
                    'default' => 0.4,
                    'min' => 0,
                    'step' => 0.01,
                    'max' => 1,
                    'resolution' => 0.01,
                    'display_value' => 'text',
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Attribute Customize ( for type Color )', 'electron' ),
                    'id' => 'product_attr_type_color_term_divide',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Term Size', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_attr_type_color_term_size',
                    'type' => 'dimensions',
                    'output' => array('.variations-items .electron-type-color .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Padding', 'electron'),
                    'customizer' => true,
                    'id' =>'product_attr_type_color_term_pad',
                    'type' => 'spacing',
                    'output' => array('.variations-items .electron-type-color .electron-term'),
                    'mode' => 'padding',
                    'units' => array('em', 'px'),
                    'units_extended' => 'false',
                    'default' => array('units' => 'px'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_color_term_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.variations-items .electron-type-color .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Active Term Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_color_term_active_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.variations-items .electron-type-color .electron-term.electron-selected'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Inactive Term Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_color_term_inactive_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.variations-items .electron-type-color .electron-term.electron-disabled'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Attribute Customize ( for type Button )', 'electron' ),
                    'id' => 'product_attr_type_button_term_divide',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Term Size', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_attr_type_button_term_size',
                    'type' => 'dimensions',
                    'output' => array('.variations-items .electron-type-button .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Padding', 'electron'),
                    'customizer' => true,
                    'id' =>'product_attr_type_button_term_pad',
                    'type' => 'spacing',
                    'output' => array('.variations-items .electron-type-button .electron-term'),
                    'mode' => 'padding',
                    'units' => array('em', 'px'),
                    'units_extended' => 'false',
                    'default' => array('units' => 'px'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_button_term_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.variations-items .electron-type-button .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Active Term Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_button_term_active_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.variations-items .electron-type-button .electron-term.electron-selected'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Term Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_button_term_color',
                    'type' => 'color',
                    'output' => array( '.variations-items .electron-type-button .electron-term' ),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Active Term Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_button_term_active_color',
                    'type' => 'color',
                    'output' => array( '.variations-items .electron-type-button .electron-term.electron-selected' ),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Term Backgorund Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_button_term_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.variations-items .electron-type-button:not(.terms-outline) .electron-term,.variations-items .electron-type-button.terms-outline .type-button' ),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Active Term Backgorund Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_button_term_active_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.variations-items .electron-type-button:not(.terms-outline) .electron-term,.variations-items .electron-type-button.terms-outline .type-button' ),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Attribute Customize ( for type Image )', 'electron' ),
                    'id' => 'product_attr_type_image_term_divide',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Term Size', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_attr_type_image_term_size',
                    'type' => 'dimensions',
                    'output' => array('.variations-items .electron-type-image .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Padding', 'electron'),
                    'customizer' => true,
                    'id' =>'product_attr_type_image_term_pad',
                    'type' => 'spacing',
                    'output' => array('.variations-items .electron-type-image .electron-term'),
                    'mode' => 'padding',
                    'units' => array('em', 'px'),
                    'units_extended' => 'false',
                    'default' => array('units' => 'px'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_image_term_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.variations-items .electron-type-image .electron-term'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Active Term Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_attr_type_image_term_active_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.variations-items .electron-type-image .electron-term.electron-selected'),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'id' => 'product_variations_attr_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'id' => 'product_attr_title_typo_start',
                    'type' => 'section',
                    'title' => esc_html__('Attribute Title Customize Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Attribute Title Typography', 'electron' ),
                    'id' => 'product_attr_title_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'text-decoration' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-variations-items .electron-small-title' ),
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'id' => 'product_attr_title_typo_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                //
                array(
                    'id' => 'product_variations_hints_start',
                    'type' => 'section',
                    'title' => esc_html__('Attribute Hints Customize Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Show Hints', 'electron'),
                    'customizer' => true,
                    'id' => 'variations_terms_hints_visibility',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Hints Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_hints_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-terms .electron-hint' ),
                    'required' => array( 'variations_terms_hints_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Hints Arrow Color', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_hints_bgcolor2',
                    'type' => 'color',
                    'mode' => 'border-top-color',
                    'output' => array( '.electron-terms .electron-hint:before' ),
                    'required' => array( 'variations_terms_hints_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Hints Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_hints_titlecolor',
                    'type' => 'color',
                    'output' => array( '.electron-terms .electron-hint' ),
                    'required' => array( 'variations_terms_hints_visibility', '=', '1' )
                ),
                array(
                    'id' => 'product_variations_hints_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array( 'variations_terms_hints_visibility', '=', '1' )
                ),
                //
                array(
                    'id' => 'product_selected_variations_terms_start',
                    'type' => 'section',
                    'title' => esc_html__('Product Selected Variations Customize Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Selected Variations', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_terms_visibility',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'swatches_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Selected Terms Tiltle', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_terms_title',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__( 'Title Typography', 'electron' ),
                    'id' => 'selected_variations_terms_title_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'text-decoration' => true,
                    'all_styles' => true,
                    'output' => array('.electron-selected-variations-terms-wrapper .electron-selected-variations-terms-title'),
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_terms_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array('.electron-selected-variations-terms-wrapper .electron-selected-variations-terms'),
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_terms_brd',
                    'type' => 'border',
                    'all' => false,
                    'output' => array('.electron-selected-variations-terms-wrapper .electron-selected-variations-terms'),
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border Radius ( px )', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_terms_brd_radius',
                    'type' => 'slider',
                    'default' => 4,
                    'min' => -1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Padding', 'electron'),
                    'customizer' => true,
                    'id' =>'selected_variations_terms_pad',
                    'type' => 'spacing',
                    'output' => array('.electron-selected-variations-terms-wrapper .electron-selected-variations-terms'),
                    'mode' => 'padding',
                    'units' => array('em', 'px'),
                    'units_extended' => 'false',
                    'default' => array(
                        'units' => 'px'
                    ),
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Terms Color', 'electron'),
                    'customizer' => true,
                    'id' => 'selected_variations_terms_value_color',
                    'type' => 'color',
                    'output' => array( '.electron-selected-variations-terms-wrapper .selected-features' ),
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Selected Terms Typography', 'electron' ),
                    'id' => 'selected_variations_terms_value_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'text-decoration' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-selected-variations-terms-wrapper .selected-features' ),
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' )
                    )
                ),
                array(
                    'id' => 'product_selected_variations_terms_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array(
                        array( 'swatches_visibility', '=', '1' ),
                        array( 'selected_variations_terms_visibility', '=', '1' )
                    )
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Cross-Sells Posts', 'electron'),
            'id' => 'shop_crosssells_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Cross-Sells Title', 'electron'),
                    'subtitle' => esc_html__('Add your cart page cross-sells section title here.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_title',
                    'type' => 'text',
                    'default' => ''
                ),
                array(
                    'title' => esc_html__( 'Title Tag', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_title_tag',
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Select type', 'electron' ),
                        'h1' => esc_html__( 'H1', 'electron' ),
                        'h2' => esc_html__( 'H2', 'electron' ),
                        'h3' => esc_html__( 'H3', 'electron' ),
                        'h4' => esc_html__( 'H4', 'electron' ),
                        'h5' => esc_html__( 'H5', 'electron' ),
                        'h6' => esc_html__( 'H6', 'electron' ),
                        'p' => esc_html__( 'p', 'electron' ),
                        'div' => esc_html__( 'div', 'electron' ),
                        'span' => esc_html__( 'span', 'electron' )
                    ),
                    'default' => 'h4'
                ),
                array(
                    'title' => esc_html__( 'Title Typography', 'electron' ),
                    'id' => 'shop_cross_sells_title_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.cross-sells .section-title' )
                ),
                array(
                    'id' =>'shop_cross_sells_type',
                    'type' => 'button_set',
                    'title' => esc_html__('Cross-Sells Layout Type', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop product page cross-sells.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'slider' => esc_html__( 'Slider', 'electron' ),
                        'grid' => esc_html__( 'Grid', 'electron' )
                    ),
                    'default' => 'slider'
                ),
                array(
                    'title' => esc_html__('Post Column', 'electron'),
                    'subtitle' => esc_html__('You can control cross-sells post column with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_colxl',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 5,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'grid' )
                ),
                array(
                    'title' => esc_html__('Post Column ( Desktop/Tablet )', 'electron'),
                    'subtitle' => esc_html__('You can control cross-sells post column for tablet device with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_collg',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 4,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'grid' )
                ),
                array(
                    'title' => esc_html__('Post Column ( Tablet )', 'electron'),
                    'subtitle' => esc_html__('You can control cross-sells post column for phone device with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_colsm',
                    'type' => 'slider',
                    'default' => 2,
                    'min' => 1,
                    'step' => 1,
                    'max' => 3,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'grid' )
                ),
                array(
                    'title' => esc_html__('Post Column ( Phone )', 'electron'),
                    'subtitle' => esc_html__('You can control cross-sells post column for phone device with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_colxs',
                    'type' => 'slider',
                    'default' => 2,
                    'min' => 1,
                    'step' => 1,
                    'max' => 2,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'grid' )
                ),
                array(
                    'id' => 'shop_cross_sells_section_slider_start',
                    'type' => 'section',
                    'title' => esc_html__('Cross-Sells Slider Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 1024px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control cross-sells post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_perview',
                    'type' => 'slider',
                    'default' => 5,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 768px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control cross-sells post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_mdperview',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 480px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control cross-sells post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_smperview',
                    'type' => 'slider',
                    'default' => 2,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Speed', 'electron' ),
                    'subtitle' => esc_html__( 'You can control cross-sells post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_speed',
                    'type' => 'slider',
                    'default' => 1000,
                    'min' => 100,
                    'step' => 1,
                    'max' => 10000,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Gap', 'electron' ),
                    'subtitle' => esc_html__( 'You can control cross-sells post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_gap',
                    'type' => 'slider',
                    'default' => 30,
                    'min' => 0,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Autoplay', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_autoplay',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Loop', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_loop',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Mousewheel', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_mousewheel',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Free Mode', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cross_sells_freemode',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                ),
                array(
                    'id' => 'shop_cross_sells_section_slider_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array( 'shop_cross_sells_type', '=', 'slider' )
                )
            )
        ));
        // Cross-Sells Posts
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Recently Viewed Products', 'electron'),
            'id' => 'shop_recently_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Recently Viewed Display', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_recently_visibility',
                    'type' => 'switch',
                    'default' => 0
                ),
                array(
                    'id' =>'recently_include',
                    'type' => 'checkbox',
                    'title' => esc_html__( 'Include Pages', 'electron' ),
                    'subtitle' => esc_html__( 'Select the pages where you want the recently products to be displayed', 'electron' ),
                    'customizer' => true,
                    'options'  => array(
                        'product' => esc_html__( 'Product Page', 'electron' ),
                        'shop' => esc_html__( 'Shop Page', 'electron' ),
                        'home' => esc_html__( 'Home Page', 'electron' ),
                        'page' => esc_html__( 'Pages', 'electron' )
                    ),
                    'default'  => array(
                        'product' => '1',
                    ),
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Products Perpage', 'electron' ),
                    'subtitle' => esc_html__( 'You can control recently products count with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'recently_perpage',
                    'type' => 'slider',
                    'default' => 8,
                    'min' => 1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Recently Title', 'electron'),
                    'subtitle' => esc_html__('Add your recently viewed section title here.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_recently_title',
                    'type' => 'text',
                    'default' => '',
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'id' => 'shop_recently_section_slider_start',
                    'type' => 'section',
                    'title' => esc_html__('Recently Slider Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 1024px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control recently viewed product slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_recently_perview',
                    'type' => 'slider',
                    'default' => 5,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 768px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control recently viewed product slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_recently_mdperview',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 480px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control recently viewed product slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_recently_smperview',
                    'type' => 'slider',
                    'default' => 2,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Speed', 'electron' ),
                    'subtitle' => esc_html__( 'You can control recently viewed product slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_recently_speed',
                    'type' => 'slider',
                    'default' => 1000,
                    'min' => 100,
                    'step' => 1,
                    'max' => 10000,
                    'display_value' => 'text',
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Gap', 'electron' ),
                    'subtitle' => esc_html__( 'You can control recently viewed product slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_recently_gap',
                    'type' => 'slider',
                    'default' => 30,
                    'min' => 0,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Autoplay', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_recently_autoplay',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Loop', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_recently_loop',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                ),
                array(
                    'id' => 'shop_recently_section_slider_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array( 'shop_recently_visibility', '=', '1' )
                )
            )
        ));
        //HEADER MOBILE TOP
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'Brands Taxonomy', 'electron' ),
            'id' => 'shop_brand_taxonomy_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Brands Taxonomy Display', 'electron' ),
                    'subtitle' => esc_html__( 'You can disable theme brands taxonomy.', 'electron' ),
                    'customizer' => true,
                    'id' => 'brands_visibility',
                    'on' => esc_html__( 'Yes', 'electron' ),
                    'off' => esc_html__( 'No', 'electron' ),
                    'type' => 'switch',
                    'customizer' => true,
                    'default' => 1
                )
            )
        ));
        // Extra
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'Catalog Mode', 'electron' ),
            'id' => 'shop_catalog_mode_subsection',
            'subsection'=> true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Catalog Mode', 'electron'),
                    'subtitle' => esc_html__('Use this option to hide all the "Add to Cart" buttons in the shop.', 'electron'),
                    'on' => esc_html__('Yes', 'electron'),
                    'off' => esc_html__('No', 'electron'),
                    'customizer' => true,
                    'id' => 'woo_catalog_mode',
                    'type' => 'switch',
                    'default' => 0
                ),
                array(
                    'title' => esc_html__('Disable Add to Cart', 'electron'),
                    'subtitle' => esc_html__('Use this option to hide all the "Add to Cart" buttons in the shop.', 'electron'),
                    'on' => esc_html__('Yes', 'electron'),
                    'off' => esc_html__('No', 'electron'),
                    'customizer' => true,
                    'id' => 'woo_disable_addtocart',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'woo_catalog_mode', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Disable Price', 'electron'),
                    'subtitle' => esc_html__('Use this option to hide all the product price in the shop.', 'electron'),
                    'on' => esc_html__('Yes', 'electron'),
                    'off' => esc_html__('No', 'electron'),
                    'customizer' => true,
                    'id' => 'woo_disable_price',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'woo_catalog_mode', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Disable Product Page Add to Cart', 'electron'),
                    'subtitle' => esc_html__('Use this option to hide all the "Add to Cart" buttons in the product page.', 'electron'),
                    'on' => esc_html__('Yes', 'electron'),
                    'off' => esc_html__('No', 'electron'),
                    'customizer' => true,
                    'id' => 'woo_disable_product_addtocart',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'woo_catalog_mode', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Disable Cart and Checkout Page', 'electron'),
                    'subtitle' => esc_html__('Use this option to hide the "Cart" page, "Checkout" page in the shop.', 'electron'),
                    'on' => esc_html__('Yes', 'electron'),
                    'off' => esc_html__('No', 'electron'),
                    'customizer' => true,
                    'id' => 'woo_disable_cart_checkout',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'woo_catalog_mode', '=', '1' )
                )
            )
        ));

        Redux::setSection($electron_pre, array(
            'title' => esc_html__('SHOP PAGE', 'electron'),
            'id' => 'shop_page_section',
            'icon' => 'el el-shopping-cart-sign',
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'Shop Page Layout', 'electron' ),
            'id' => 'shop_layout_section',
            'subsection'=> true,
            'icon' => 'el el-website',
            'fields' => array(
                array(
                    'id' =>'shop_layout',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Shop Layouts', 'electron' ),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop page sidebar area.', 'electron' ),
                    'options' => array(
                        'top-sidebar' => esc_html__( 'Top Hidden Sidebar', 'electron' ),
                        'fixed-sidebar' => esc_html__( 'Left Fixed Sidebar', 'electron' ),
                        'left-sidebar' => esc_html__( 'Left Sidebar', 'electron' ),
                        'right-sidebar' => esc_html__( 'Right Sidebar', 'electron' ),
                        'no-sidebar' => esc_html__( 'No Sidebar', 'electron' )
                    ),
                    'default' => 'fixed-sidebar',
                ),
                array(
                    'title' => esc_html__('Choosen Filters', 'electron'),
                    'subtitle' => esc_html__('You can enable or disable the filters selected before the loop.', 'electron'),
                    'customizer' => true,
                    'id' => 'choosen_filters_before_loop',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'shop_layout', '!=', 'top-sidebar' ),
                        array( 'shop_layout', '!=', 'top-sidebar' ),
                        array( 'shop_layout', '!=', 'no-sidebar' )
                    )
                ),
                array(
                    'id' =>'shop_grid_type',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Shop Grid Type', 'electron' ),
                    'options' => array(
                        'grid' => esc_html__( 'Default Grid', 'electron' ),
                        'masonry' => esc_html__( 'Masonry', 'electron' )
                    ),
                    'default' => 'grid',
                    'required' => array(
                        array( 'shop_layout', '!=', 'left-sidebar' ),
                        array( 'shop_layout', '!=', 'right-sidebar' )
                    )
                ),
                array(
                    'id' =>'shop_masonry_column',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Shop Masonry Column Width', 'electron' ),
                    'subtitle' => esc_html__( 'Select your shop masonry type column width', 'electron' ),
                    'options' => array(
                        '3' => esc_html__( '3 Column', 'electron' ),
                        '4' => esc_html__( '4 Column', 'electron' ),
                        '5' => esc_html__( '5 Column', 'electron' ),
                        '6' => esc_html__( '6 Column', 'electron' ),
                    ),
                    'default' => '4',
                    'required' => array(
                        array( 'shop_layout', '!=', 'left-sidebar' ),
                        array( 'shop_layout', '!=', 'right-sidebar' ),
                        array( 'shop_grid_type', '=', 'masonry' )
                    )
                ),
                array(
                    'id' =>'shop_hidden_sidebar_column',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Hidden Sidebar Widget Column Width', 'electron' ),
                    'subtitle' => esc_html__( 'Select your shop sidebar widget column width', 'electron' ),
                    'options' => array(
                        '1' => esc_html__( '1 Column', 'electron' ),
                        '2' => esc_html__( '2 Column', 'electron' ),
                        '3' => esc_html__( '3 Column', 'electron' ),
                        '4' => esc_html__( '4 Column', 'electron' ),
                        '5' => esc_html__( '5 Column', 'electron' ),
                    ),
                    'default' => '3',
                    'required' => array( 'shop_layout', '=', 'top-sidebar' )
                ),
                array(
                    'title' => esc_html__('Mobile Sticky Filter Bar', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_sidebar_mobile_filter',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_layout', '!=', 'no-sidebar' )
                ),
                array(
                    'id' =>'shop_loop_filters_layouts',
                    'type' => 'sorter',
                    'title' => esc_html__( 'Shop Filter Area Layouts Manager', 'electron' ),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop page filter area.', 'electron' ),
                    'options' => array(
                        'left' => array(
                            'breadcrumbs' => esc_html__( 'Breadcrumbs', 'electron' ),
                        ),
                        'right' => array(
                            'sidebar-filter' => esc_html__( 'Sidebar Toggle', 'electron' ),
                            'per-page' => esc_html__( 'Perpage Selection', 'electron' ),
                            'column-select' => esc_html__( 'Column Selection', 'electron' ),
                            'ordering' => esc_html__( 'Ordering', 'electron' )
                        ),
                        'hide' => array(
                            'result-count' => esc_html__( 'Result Count', 'electron' ),
                            'search' => esc_html__( 'Search Popup', 'electron' ),
                        )
                    )
                ),
                array(
                    'title' => esc_html__('Per Page Select Options', 'electron'),
                    'subtitle' => esc_html__('Separate each number with a comma.For example: 12,24,36', 'electron'),
                    'customizer' => true,
                    'id' => 'per_page_select_options',
                    'type' => 'text',
                    'default' => '9,12,18,24'
                ),
                array(
                    'title' => esc_html__('Show Products ( Per Page )', 'electron'),
                    'subtitle' => esc_html__('You can control show product count with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_perpage',
                    'type' => 'slider',
                    'default' => 10,
                    'min' => 1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text'
                ),
                array(
                    'id' =>'shop_paginate_type',
                    'type' => 'button_set',
                    'title' => esc_html__('Pagination Type', 'electron'),
                    'subtitle' => esc_html__('Select your pagination type.', 'electron'),
                    'options' => array(
                        'pagination' => esc_html__('Default Pagination', 'electron'),
                        'ajax-pagination' => esc_html__('Ajax Pagination', 'electron'),
                        'loadmore' => esc_html__('Ajax Load More', 'electron'),
                        'infinite' => esc_html__('Ajax Infinite Scroll', 'electron')
                    ),
                    'default' => 'ajax-pagination',
                    'required' => array( 'shop_ajax_filter', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Bordered', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_border',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' =>'shop_container',
                    'type' => 'select',
                    'title' => esc_html__( 'Container Width', 'electron' ),
                    'subtitle' => esc_html__( 'Select your header background type.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'default' => esc_html__( 'Deafult ( theme Content Width from Main settings )', 'electron' ),
                        'stretch' => esc_html__( 'Stretch', 'electron' ),
                    ),
                    'default' => 'default'
                ),
                array(
                    'title' => esc_html__( 'Container Width (px)', 'electron' ),
                    'subtitle' => esc_html__( 'You can use this option to control the theme container width.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_container_width',
                    'type' => 'slider',
                    'default' => 1580,
                    'min' => 0,
                    'step' => 1,
                    'max' => 4000,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__( 'Sidebar Min Width (px)', 'electron' ),
                    'subtitle' => esc_html__( 'You can use this option to control the shop sidebar width.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_sidebar_width',
                    'type' => 'slider',
                    'default' => 320,
                    'min' => 0,
                    'step' => 1,
                    'max' => 4000,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__('Column', 'electron'),
                    'subtitle' => esc_html__('You can control post column with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_col',
                    'type' => 'slider',
                    'default' => 5,
                    'min' => 1,
                    'step' => 1,
                    'max' => 8,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__( 'Tablet Column (1024px)', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_col_1024',
                    'type' => 'slider',
                    'default' => 0,
                    'min' => 0,
                    'step' => 1,
                    'max' => 8,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__( 'Tablet Column (992px)', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_col_992',
                    'type' => 'slider',
                    'default' => 0,
                    'min' => 0,
                    'step' => 1,
                    'max' => 7,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__( 'Tablet Column (768px)', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_col_768',
                    'type' => 'slider',
                    'default' => 0,
                    'min' => 0,
                    'step' => 1,
                    'max' => 5,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__( 'Phone Column (576px)', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_col_576',
                    'type' => 'slider',
                    'default' => 0,
                    'min' => 0,
                    'step' => 1,
                    'max' => 3,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__( 'Phone Column (480px)', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_col_480',
                    'type' => 'slider',
                    'default' => 0,
                    'min' => 0,
                    'step' => 1,
                    'max' => 2,
                    'display_value' => 'text'
                ),
            )
        ));

        function electron_shop_loop_custom_query(){
            $filters_field = array();
            $filters_field[] = array(
                'title' => esc_html__('Custom Query', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_visibility',
                'type' => 'switch',
                'default' => 0
            );
            $filters_field[] = array(
                'title' => esc_html__('Scenario', 'electron'),
                'subtitle' => esc_html__('Choose the your scenario.', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_scenario',
                'type' => 'button_set',
                'options' => array(
                    '' => esc_html__( 'Newest', 'electron' ),
                    'featured' => esc_html__( 'Featured', 'electron' ),
                    'on-sale' => esc_html__( 'On Sale', 'electron' ),
                    'best' => esc_html__( 'Best Selling', 'electron' ),
                    'rated' => esc_html__( 'Top-rated', 'electron' ),
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                    'custom' => esc_html__( 'Specific Categories', 'electron' ),
                ),
                'default' => '',
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );
            $filters_field[] = array(
                'title' => esc_html__('Order', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_order',
                'type' => 'button_set',
                'options' => array(
                    'ASC' => esc_html__( 'Ascending', 'electron' ),
                    'DESC' => esc_html__( 'Descending', 'electron' )
                ),
                'default' => 'DESC',
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );
            $filters_field[] = array(
                'title' => esc_html__('Order By', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_orderby',
                'type' => 'button_set',
                'options' => array(
                    'ID' => esc_html__( 'Post ID', 'electron' ),
                    'menu_order' => esc_html__( 'Menu Order', 'electron' ),
                    'rand' => esc_html__( 'Random', 'electron' ),
                    'date' => esc_html__( 'Date', 'electron' ),
                    'title' => esc_html__( 'Title', 'electron' ),
                    'popularity' => esc_html__( 'Popularity', 'electron' ),
                ),
                'default' => 'title',
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );
            $filters_field[] = array(
                'title' => esc_html__('Show Products ( for Per Page )', 'electron'),
                'subtitle' => esc_html__('Here you can set the maximum number of products you want to show on your shop page.', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_perpage',
                'type' => 'slider',
                'default' => 20,
                'min' => 1,
                'step' => 1,
                'max' => 1000,
                'display_value' => 'text',
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );
            $filters_field[] = array(
                'title' => esc_html__('Mobile Device Show Products ( for Per Page )', 'electron'),
                'subtitle' => esc_html__('Here you can set the maximum number of products you want to show on mobile device.', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_mobile_perpage',
                'type' => 'slider',
                'default' => 20,
                'min' => 1,
                'step' => 1,
                'max' => 1000,
                'display_value' => 'text',
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );
            $filters_field[] = array(
                'title' => esc_html__('Category(s)', 'electron'),
                'subtitle' => esc_html__('Select category(s) from the list.', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_cats',
                'type' => 'select',
                'data' => 'terms',
                'multi' => true,
                'args' => [ 'taxonomies' => array('product_cat') ],
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );
            $filters_field[] = array(
                'title' => esc_html__('Category(s) Filter Type', 'electron'),
                'subtitle' => esc_html__('Choose the your product category filter type.', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_cats_operator',
                'type' => 'button_set',
                'options' => array(
                    'include' => esc_html__('Include', 'electron'),
                    'exclude' => esc_html__('Exclude', 'electron'),
                ),
                'default' => 'exclude',
                'required' => array(
                    array( 'shop_custom_query_visibility', '=', '1' ),
                    array( 'shop_custom_query_cats', '!=', '' )
                )
            );
            $filters_field[] = array(
                'title' => esc_html__('Tags(s)', 'electron'),
                'subtitle' => esc_html__('Select category(s) from the list.', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_tags',
                'type' => 'select',
                'data' => 'terms',
                'multi' => true,
                'args' => [ 'taxonomies' => array('product_tag') ],
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );
            $filters_field[] = array(
                'title' => esc_html__('Tag(s) Filter Type', 'electron'),
                'subtitle' => esc_html__('Choose the your product tag filter type.', 'electron'),
                'customizer' => true,
                'id' => 'shop_custom_query_tags_operator',
                'type' => 'button_set',
                'options' => array(
                    'include' => esc_html__('Include', 'electron'),
                    'exclude' => esc_html__('Exclude', 'electron'),
                ),
                'default' => 'exclude',
                'required' => array(
                    array( 'shop_custom_query_visibility', '=', '1' ),
                    array( 'shop_custom_query_tags', '!=', '' )
                )
            );
            $filters_field[] = array(
                'title' => esc_html__( 'Select Attributes', 'electron' ),
                'subtitle' => esc_html__( 'Select Attribute(s) from the list.', 'electron' ),
                'customizer' => true,
                'id' => 'shop_custom_query_attr',
                'type' => 'select',
                'sortable' => true,
                'options' => electron_wc_attributes(),
                'multi' => true,
                'required' => array( 'shop_custom_query_visibility', '=', '1' )
            );

            $attribute_taxonomies = wc_get_attribute_taxonomies();
            foreach ( $attribute_taxonomies as $tax ) {
                $options = array();
                $tax_name = $tax->attribute_name;
                $tax_label = $tax->attribute_label;
                $filters_field[] = array(
                    'title' => sprintf(esc_html__( 'Attributes Terms ( for %s )', 'electron' ),$tax_label),
                    'customizer' => true,
                    'id' => 'shop_custom_query_attr_terms_'.$tax_name,
                    'type' => 'select',
                    'sortable' => true,
                    'data' => 'terms',
                    'args' => array( 'taxonomies' => array( 'pa_'.$tax_name ) ),
                    'multi' => true,
                    'required' => array(
                        array( 'shop_custom_query_visibility', '=', '1' ),
                        array( 'shop_custom_query_attr', '=', $tax_name )
                    )
                );
                $filters_field[] = array(
                    'title' => sprintf(esc_html__('Filter Type ( for %s )', 'electron'),$tax_label),
                    'subtitle' => esc_html__('Choose the your product attribute terms filter type.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_custom_query_attr_terms_operator_'.$tax_name,
                    'type' => 'button_set',
                    'options' => array(
                        'include' => esc_html__('Include', 'electron'),
                        'exclude' => esc_html__('Exclude', 'electron'),
                    ),
                    'default' => 'include',
                    'required' => array(
                        array( 'shop_custom_query_visibility', '=', '1' ),
                        array( 'shop_custom_query_attr', '=', $tax_name ),
                        array( 'shop_custom_query_attr_terms_'.$tax_name, '!=', '' ),
                    )
                );
            }

            return $filters_field;
        }
        // SINGLE CONTENT SUBSECTION
        Redux::setSection($electron_pre,
            array(
                'title' => esc_html__('Shop Custom Query', 'electron'),
                'id' => 'shop_loop_custom_query_subsection',
                'subsection' => true,
                'icon' => 'el el-cog',
                'fields' => electron_shop_loop_custom_query()
            )
        );
        // SINGLE HERO SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Shop Page Hero', 'electron'),
            'desc' => esc_html__('These are shop page hero section settings', 'electron'),
            'id' => 'shop_hero_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Hero display', 'electron'),
                    'subtitle' => esc_html__('You can enable or disable the site shop page hero section with switch option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_hero_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Custom Page Title', 'electron'),
                    'subtitle' => esc_html__('Add your shop page custom title here.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_title',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Title Tag', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_title_tag',
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Select type', 'electron' ),
                        'h1' => esc_html__( 'H1', 'electron' ),
                        'h2' => esc_html__( 'H2', 'electron' ),
                        'h3' => esc_html__( 'H3', 'electron' ),
                        'h4' => esc_html__( 'H4', 'electron' ),
                        'h5' => esc_html__( 'H5', 'electron' ),
                        'h6' => esc_html__( 'H6', 'electron' ),
                        'p' => esc_html__( 'p', 'electron' ),
                        'div' => esc_html__( 'div', 'electron' ),
                        'span' => esc_html__( 'span', 'electron' )
                    ),
                    'default' => 'h2'
                ),
                array(
                    'id' =>'shop_hero_type',
                    'type' => 'button_set',
                    'title' => esc_html__('Shop Hero Type', 'electron'),
                    'subtitle' => esc_html__('Select your pagination type.', 'electron'),
                    'options' => array(
                        'default' => esc_html__('Default Hero', 'electron'),
                        'elementor' => esc_html__('Elementor Templates', 'electron'),
                    ),
                    'default' => 'default',
                    'required' => array( 'shop_hero_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Elementor Templates', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates.If you want to show the theme default hero template please leave a blank.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_elementor_templates',
                    'type' => 'select',
                    'customizer' => true,
                    'data' => 'posts',
                    'args' => $el_args,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'elementor' ),
                    )
                ),
                array(
                    'title' => esc_html__( 'Category Pages Hero Elementor Templates', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates.If you want to show the theme default hero template please leave a blank.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_cats_hero_elementor_templates',
                    'type' => 'select',
                    'customizer' => true,
                    'data' => 'posts',
                    'args' => $el_args,
                    'required' => array( 'shop_hero_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Tags Pages Elementor Templates', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates.If you want to show the theme default hero template please leave a blank.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_tax_hero_elementor_templates',
                    'type' => 'select',
                    'customizer' => true,
                    'data' => 'posts',
                    'args' => $el_args,
                    'required' => array( 'shop_hero_visibility', '=', '1' )
                ),
                array(
                    'id' =>'shop_hero_layout_type',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Default Hero Layouts', 'electron' ),
                    'subtitle' => esc_html__( 'Select how you want the layout to appear on the theme shop page sidebar area.', 'electron' ),
                    'options' => array(
                        'mini' => esc_html__( 'Title + Breadcrumbs', 'electron' ),
                        'small' => esc_html__( 'Title Center', 'electron' ),
                        'big' => esc_html__( 'Title + Categories', 'electron' ),
                        'cat-slider' => esc_html__( 'Title + Categories Slider', 'electron' ),
                    ),
                    'default' => 'mini',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                    )
                ),
                array(
                    'title' => esc_html__('Categories Customize Options', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_cat_customize_section_start',
                    'type' => 'section',
                    'indent' => true,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'title' => esc_html__( 'Category(s)', 'electron' ),
                    'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_cats',
                    'type' => 'select',
                    'data' => 'terms',
                    'multi' => true,
                    'sortable' => true,
                    'args'  => [
                        'taxonomies' => array( 'product_cat' ),
                    ],
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'id' =>'shop_hero_carousel_catfilter',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Category Filter Type', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'exclude' => esc_html__( 'Exclude', 'electron' ),
                        'include' => esc_html__( 'Include', 'electron' ),
                    ),
                    'default' => 'include',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                        array( 'shop_hero_carousel_cats', '!=', '' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Only Top Categories', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_catparent',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                        array( 'shop_hero_carousel_cats', '=', '' )
                    )
                ),
                array(
                    'id' => 'shop_hero_carousel_cathideempty',
                    'type' => 'switch',
                    'title' => esc_html__('Hide Empty Categories', 'electron'),
                    'customizer' => true,
                    'default' => '1',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'id' =>'shop_hero_carousel_catorder',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Category Order', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'ASC' => esc_html__( 'ASC', 'electron' ),
                        'DESC' => esc_html__( 'DESC', 'electron' ),
                    ),
                    'default' => 'ASC',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'id' =>'shop_hero_carousel_catorderby',
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
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'id' => 'shop_hero_carousel_catthumb',
                    'type' => 'switch',
                    'title' => esc_html__('Category Thumbnail', 'electron'),
                    'customizer' => true,
                    'default' => '1',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'id' => 'shop_hero_carousel_cattcount',
                    'type' => 'switch',
                    'title' => esc_html__('Category Count', 'electron'),
                    'customizer' => true,
                    'default' => '1',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'id' => 'shop_hero_carousel_ajax',
                    'type' => 'switch',
                    'title' => esc_html__('Category Click Action', 'electron'),
                    'customizer' => true,
                    'default' => 'filter',
                    'options' => array(
                        'filter' => esc_html__( 'Filter Products ( Ajax )', 'electron' ),
                        'link' => esc_html__( 'Category Link', 'electron' ),
                    ),
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_cat_customize_section_end',
                    'type' => 'section',
                    'indent' => false,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '!=', 'mini' ),
                        array( 'shop_hero_layout_type', '!=', 'small' ),
                    )
                ),
                array(
                    'title' => esc_html__('Carousel Slider Options', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_customize_section_start',
                    'type' => 'section',
                    'indent' => true,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'id' =>'shop_hero_carousel_style',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Carousel Slider Style', 'electron' ),
                    'options' => array(
                        '1' => esc_html__( 'Style 1', 'electron' ),
                        '2' => esc_html__( 'Style 2', 'electron' ),
                        '3' => esc_html__( 'Style 3', 'electron' )
                    ),
                    'default' => '1',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Slider Perview ( Min 1500px )', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_perview1',
                    'type' => 'slider',
                    'default' => 9,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Slider Perview ( Min 1400px )', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_perview2',
                    'type' => 'slider',
                    'default' => 8,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Slider Perview ( Min 1200px )', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_perview3',
                    'type' => 'slider',
                    'default' => 7,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Slider Perview ( Min 992px )', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_perview4',
                    'type' => 'slider',
                    'default' => 5,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Slider Perview ( Min 768px )', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_perview5',
                    'type' => 'slider',
                    'default' => 7,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Slider Perview ( Min 320px )', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_perview6',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Loop', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_loop',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Autoplay', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_autoplay',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Rewind', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_rewind',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Centred', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_centred',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Speed', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_speed',
                    'type' => 'slider',
                    'default' => 2000,
                    'min' => 100,
                    'step' => 1,
                    'max' => 10000,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Gap', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_gap',
                    'type' => 'slider',
                    'default' => 1,
                    'min' => 1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'customizer' => true,
                    'id' => 'shop_hero_carousel_customize_section_end',
                    'type' => 'section',
                    'indent' => false,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' ),
                        array( 'shop_hero_layout_type', '=', 'cat-slider' )
                    )
                ),
                array(
                    'title' => esc_html__('Hero Customize Options', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_hero_customize_section_start',
                    'type' => 'section',
                    'indent' => true,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' )
                    )
                ),
                array(
                    'title' => esc_html__('Hero Background', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_hero_bg',
                    'type' => 'background',
                    'output' => array( '#nt-shop-page .electron-page-hero' ),
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Background Image Size', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_bg_imgsize',
                    'type' => 'select',
                    'data' => 'image_sizes'
                ),
                array(
                    'title' => esc_html__( 'Hero height', 'electron' ),
                    'subtitle' => esc_html__( 'Set the hero height.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_hero_height',
                    'type' => 'dimensions',
                    'width' => false,
                    'output' => array( '#nt-shop-page .electron-page-hero' ),
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' )
                    )
                ),
                array(
                    'customizer' => true,
                    'id' => 'shop_hero_customize_section_end',
                    'type' => 'section',
                    'indent' => false,
                    'required' => array(
                        array( 'shop_hero_visibility', '=', '1' ),
                        array( 'shop_hero_type', '=', 'default' )
                    )
                )
            )
        ));
        function electron_fast_filters_fields(){
            $filters_field = array();
            $filters_field[] = array(
                'title' => esc_html__('Fast Filters Display', 'electron'),
                'subtitle' => esc_html__('You can enable or disable the site shop page fast filters section with switch option.', 'electron'),
                'customizer' => true,
                'id' => 'shop_fast_filter_visibility',
                'type' => 'switch',
                'default' => 1
            );

            $filters_field[] = array(
                'id' =>'shop_fast_filter_main',
                'type' => 'sorter',
                'title' => esc_html__( 'Main Filters Layout Manager', 'electron' ),
                'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme fast filters area', 'electron' ),
                'options' => array(
                    'show' => array(
                        'featured' => esc_html__( 'Featured', 'electron' ),
                        'bestseller' => esc_html__( 'Best Seller', 'electron' ),
                        'toprated' => esc_html__( 'Top Rated', 'electron' ),
                    ),
                    'hide'  => array()
                ),
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'Featured Filter Title', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_featured_title',
                'type' => 'text',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'Best Seller Filter Title', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_bestseller_title',
                'type' => 'text',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'Top Rated Filter Title', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_toprated_title',
                'type' => 'text',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'Select Attributes', 'electron' ),
                'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_terms',
                'type' => 'select',
                'sortable'  => true,
                'options' => electron_wc_attributes(),
                'multi' => true,
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $attribute_taxonomies = wc_get_attribute_taxonomies();
            foreach ( $attribute_taxonomies as $tax ) {
                $tax_name  = $tax->attribute_name;
                $tax_label = $tax->attribute_label;

                $filters_field[] = array(
                    'title' => sprintf(esc_html__( 'Terms Attributes for %s', 'electron' ),$tax_label),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_terms_attr_'.$tax_name,
                    'type' => 'select',
                    'sortable'  => true,
                    'data'  => 'terms',
                    'args'  => array(
                        'taxonomies' => array( 'pa_'.$tax_name ),
                    ),
                    'multi' => true,
                    'required' => array( 'shop_fast_filter_terms', '=', $tax_name )
                );
                $filters_field[] = array(
                    'title' => sprintf(esc_html__( 'Terms Title for %s', 'electron' ),$tax_label),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_terms_title_'.$tax_name,
                    'type' => 'text',
                    'default' => 'Select '.$tax_label,
                    'required' => array( 'shop_fast_filter_terms', '=', $tax_name )
                );
            }

            $filters_field[] = array(
                'title' => esc_html__('Fast Filters Label Before Display', 'electron'),
                'subtitle' => esc_html__('You can enable or disable the site shop page fast filters label before with switch option.', 'electron'),
                'customizer' => true,
                'id' => 'shop_fast_filter_before_label_visibility',
                'type' => 'switch',
                'default' => 1,
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'Fast Filters Label Before', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_main_title',
                'type' => 'text',
                'default' => '',
                'required' => array(
                    array( 'shop_ajax_filter', '=', '1' ),
                    array( 'shop_fast_filter_before_label_visibility', '=', '1' )
                )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'Remove All Filter Title', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_remove_title',
                'type' => 'text',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'In Stock Filter Title', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_instock_title',
                'type' => 'text',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__( 'On Sale Filter Title', 'electron' ),
                'customizer' => true,
                'id' => 'shop_fast_filter_onsale_title',
                'type' => 'text',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__('Fast Filters Ajax Loading', 'electron'),
                'subtitle' => esc_html__('You can enable or disable the site shop page fast filters ajax loading section with switch option.', 'electron'),
                'customizer' => true,
                'id' => 'shop_fast_filter_ajax',
                'type' => 'switch',
                'default' => 1,
                'required' => array(
                    array( 'shop_ajax_filter', '=', '1' ),
                    array( 'shop_fast_filter_visibility', '=', '1' )
                )
            );

            $filters_field[] = array(
                'title' => esc_html__('In Stock & On Sale Filter Display Status', 'electron'),
                'type' => 'button_set',
                'customizer' => true,
                'id' => 'shop_fast_filter_stock_sale_status',
                'options' => array(
                    'show-always' => esc_html__( 'Show Always', 'electron' ),
                    'hidden' => esc_html__( 'Show After Filter', 'electron' ),
                ),
                'default' => 'hidden',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__('Fetaured Icon HTML', 'electron'),
                'type' => 'textarea',
                'customizer' => true,
                'id' => 'shop_fast_filter_featured_icon',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__('Best Seller Icon HTML', 'electron'),
                'type' => 'textarea',
                'customizer' => true,
                'id' => 'shop_fast_filter_bestseller_icon',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__('Top Rated Icon HTML', 'electron'),
                'type' => 'textarea',
                'customizer' => true,
                'id' => 'shop_fast_filter_toprated_icon',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__('Onsale Icon HTML', 'electron'),
                'type' => 'textarea',
                'customizer' => true,
                'id' => 'shop_fast_filter_onsale_icon',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            $filters_field[] = array(
                'title' => esc_html__('Instock Icon HTML', 'electron'),
                'type' => 'textarea',
                'customizer' => true,
                'id' => 'shop_fast_filter_instock_icon',
                'default' => '',
                'required' => array( 'shop_fast_filter_visibility', '=', '1' )
            );

            foreach ( $attribute_taxonomies as $tax ) {
                $tax_name  = $tax->attribute_name;
                $tax_label = $tax->attribute_label;

                $filters_field[] = array(
                    'title' => sprintf('%s %s',$tax_label,esc_html__( 'Icon HTML ', 'electron' )),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_terms_icon_'.$tax_name,
                    'type' => 'textarea',
                    'default' => '',
                    'required' => array(
                        array( 'shop_fast_filter_visibility', '=', '1' ),
                        array( 'shop_fast_filter_terms', '=', $tax_name )
                    )
                );
            }

            return $filters_field;
        }

        // FAST FILTER SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Shop Fast Filters', 'electron'),
            'id' => 'shop_fast_filters_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => electron_fast_filters_fields()
        ));
        // FAST FILTER SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Shop Fast Filters Colors', 'electron'),
            'id' => 'shop_fast_filter_style_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Filters Label Before Color', 'electron'),
                    'subtitle' => esc_html__('Change fast filters label before color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_main_title_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .fast-filters-label'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Background Color (Hover/Active)', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li:hover> a,.electron-shop-fast-filters .electron-fast-filters-list li.active > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Title Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Title Color (Hover/Active)', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_hvrcolor',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li:hover> a,.electron-shop-fast-filters .electron-fast-filters-list li.active > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_brdcolor',
                    'type' => 'color',
                    'mode' => 'border-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Border Color (Hover/Active)', 'electron'),
                    'subtitle' => esc_html__('Change post background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_hvrbrdcolor',
                    'type' => 'color',
                    'mode' => 'border-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li:hover> a,.electron-shop-fast-filters .electron-fast-filters-list li.active > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Close Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_close_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li:not(.remove-fast-filter) .remove-filter'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Button Close Color (Hover/Active)', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_close_color',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li:not(.remove-fast-filter) .remove-filter:before, .electron-shop-fast-filters .electron-fast-filters-list li:not(.remove-fast-filter) .remove-filter:after'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Clear All Button Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_clear_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list .remove-fast-filter.active > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Clear All Button Background Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_clear_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list .remove-fast-filter.active:hover > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Clear All Button Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_clear_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list .remove-fast-filter.active > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Clear All Button Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_clear_hvrcolor',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list .remove-fast-filter.active:hover > a'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Clear All Button Close Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_clear_close_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li.remove-fast-filter .remove-filter'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Clear All Button Close Color', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_fast_filter_btn_clear_close_color',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.electron-shop-fast-filters .electron-fast-filters-list li.remove-fast-filter .remove-filter:before, .electron-fast-filters-list li.remove-fast-filter .remove-filter:after'),
                    'required' => array( 'shop_fast_filter_visibility', '=', '1' )
                ),
            )
        ));

        // SINGLE CONTENT SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Shop Elementor Template', 'electron'),
            'id' => 'shop_elementor_templates_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Before Shop Content Elementor Templates', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates, If you want to show any content after hero section.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_before_content_templates',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args
                ),
                array(
                    'title' => esc_html__( 'After Shop Content Elementor Templates', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates, If you want to show any content after products.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_after_content_templates',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args
                ),
                array(
                    'title' => esc_html__( 'Before Loop Elementor Templates', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products loop.Note:This option is only compatible with shop left sidebar and right sidebar layouts.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_before_loop_templates',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args
                ),
                array(
                    'title' => esc_html__( 'After Loop Elementor Templates', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates, If you want to show any content after products loop.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_after_loop_templates',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args,
                ),
                array(
                    'title' => esc_html__( 'Before Footer Elementor Templates ( for Category Pages )', 'electron' ),
                    'subtitle' => esc_html__( 'Select a template from elementor templates, If you want to show any content after products loop.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_category_before_footer_templates',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args,
                ),
                array(
                    'title' => esc_html__( 'Category(s) Exclude', 'electron' ),
                    'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_category_before_footer_templates_exclude',
                    'type' => 'select',
                    'data' => 'terms',
                    'multi' => true,
                    'args'  => [
                        'taxonomies' => array( 'product_cat' ),
                    ],
                    'required' => array( 'shop_category_before_footer_templates', '!=', '' )
                ),
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'PRODUCT CARD/BOX', 'electron' ),
            'id' => 'shop_product_box_section',
            'subsection'=> false,
            'icon' => 'el el-shopping-cart-sign',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Product Box Pre-layouts', 'electron' ),
                    'subtitle' => esc_html__( 'Choose the your product box type.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_product_type',
                    'type' => 'button_set',
                    'options' => array(
                        '1' => esc_html__( 'Type 1', 'electron' ),
                        '2' => esc_html__( 'Type 2', 'electron' ),
                        '3' => esc_html__( 'Type 3', 'electron' ),
                        '4' => esc_html__( 'Type 4', 'electron' ),
                        '5' => esc_html__( 'Type 5', 'electron' ),
                        '6' => esc_html__( 'Type 6', 'electron' ),
                        '7' => esc_html__( 'Type 7', 'electron' ),
                        '8' => esc_html__( 'Type 8', 'electron' ),
                        '9' => esc_html__( 'Type 9', 'electron' )
                    ),
                    'default' => '1'
                ),
                array(
                    'title' => esc_html__('Product Name Max Line Length Display', 'zank'),
                    'subtitle' => esc_html__('If your product name is too long and you want to shorten it, you can use this setting.', 'zank'),
                    'customizer' => true,
                    'id' => 'product_name_max_line_visibility',
                    'type' => 'switch',
                    'default' => 0
                ),
                array(
                    'title' => esc_html__('Product Name Max Line Length', 'zank'),
                    'customizer' => true,
                    'id' => 'product_name_max_line',
                    'type' => 'slider',
                    'default' => 2,
                    'min' => 1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array( 'product_name_max_line_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Show Product Gallery Thumbs', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_thumbs_imgs',
                    'type' => 'switch',
                    'default' => 0
                ),
                array(
                    'title' => esc_html__( 'Show Quantity', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_product_qty',
                    'type' => 'button_set',
                    'options' => array(
                        'none' => esc_html__( 'None', 'electron' ),
                        'all' => esc_html__( 'All Pages', 'electron' ),
                        'shop' => esc_html__( 'Shop Page', 'electron' ),
                        'catpage' => esc_html__( 'Shop Category Page', 'electron' ),
                    ),
                    'default' => 'none',
                ),
                array(
                    'title' => esc_html__( 'Add to Cart Type', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_product_qty_type',
                    'type' => 'button_set',
                    'options' => array(
                        'big' => esc_html__( 'Block', 'electron' ),
                        'small' => esc_html__( 'Inline', 'electron' ),
                    ),
                    'default' => 'big',
                    'required' => array( 'shop_product_qty', '!=', 'none' )
                ),
                array(
                    'title' => esc_html__( 'Variations Position', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_product_variations_type',
                    'type' => 'button_set',
                    'options' => array(
                        'absolute' => esc_html__( 'Absolute', 'electron' ),
                        'relative' => esc_html__( 'Relative', 'electron' ),
                    ),
                    'default' => 'absolute',
                    'required' => array( 'shop_product_qty', '!=', 'none' )
                ),
                array(
                    'title' => esc_html__('Stock Status', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_stock',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Quick View', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_quick_view',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Compare', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_compare',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Wishlist', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_wishlist',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Rating Count', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_rating_count',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Rating', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_rating',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('SKU', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_sku',
                    'type' => 'switch',
                    'default' => 0
                ),
                array(
                    'title' => esc_html__('Sale Label', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_label',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Discount', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_discount',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Swatches Selection', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_swatches',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'shop_product_qty', '=', 'none' )
                ),
                array(
                    'title' => esc_html__('Show Swatches Selection on Mobile', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_swatches_mobile',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_product_qty', '=', 'none' )
                ),
                array(
                    'title' => esc_html__('Product Features', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_product_fatures',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__( 'Product Features List', 'electron' ),
                    'subtitle' => esc_html__( '!Important note: One feature per line.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_extra_fatures',
                    'type' => 'textarea',
                    'default' => '',
                    'required' => array( 'shop_product_fatures', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Product Features List on Mobile', 'electron'),
                    'customizer' => true,
                    'id' => 'product_extra_fatures_mobile',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_product_fatures', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Excerpt Size ( for Shop page list type )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control blog post excerpt size with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_loop_excerpt_limit',
                    'type' => 'slider',
                    'default' => 17,
                    'min' => 0,
                    'step' => 1,
                    'max' => 300,
                    'display_value' => 'text'
                ),
            )
        ));
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Shop Page Product Style', 'electron'),
            'id' => 'shop_post_style_subsection',
            'subsection' => true,
            'icon' => 'el el-brush',
            'fields' => array(
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'subtitle' => esc_html__('Change post background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_post_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.woocommerce.electron-product')
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'subtitle' => esc_html__('Set your custom border styles for the posts.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_post_brd',
                    'type' => 'border',
                    'all' => false,
                    'output' => array('.woocommerce.electron-product')
                ),
                array(
                    'title' => esc_html__('Padding', 'electron'),
                    'subtitle' => esc_html__('You can set the spacing of the site shop page post.', 'electron'),
                    'customizer' => true,
                    'id' =>'shop_post_pad',
                    'type' => 'spacing',
                    'output' => array('.woocommerce.electron-product'),
                    'mode' => 'padding',
                    'units' => array('em', 'px'),
                    'units_extended' => 'false',
                    'default' => array(
                        'units' => 'px'
                    )
                ),
                array(
                    'title' => esc_html__('Post title', 'electron'),
                    'subtitle' => esc_html__('Change theme main color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_loop_post_title_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.electron-product .electron-product-name')
                ),
                array(
                    'title' => esc_html__('Price', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_loop_post_price_reg_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-price')
                ),
                array(
                    'title' => esc_html__('Price Regular', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_loop_post_price_reg_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-price del')
                ),
                array(
                    'title' => esc_html__('Price Sale', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_loop_post_price_sale_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-price ins')
                ),
                array(
                    'title' => esc_html__('Discount Background', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_loop_post_discount_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-label')
                ),
                array(
                    'title' => esc_html__('Button Background ( Add to cart )', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_addtocartbtn_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-btn')
                ),
                array(
                    'title' => esc_html__('Hover Button Background ( Add to cart )', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_addtocartbtn_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-btn:hover')
                ),
                array(
                    'title' => esc_html__('Button Title ( Add to cart )', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_addtocartbtn_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-btn')
                ),
                array(
                    'title' => esc_html__('Hover Button Title ( Add to cart )', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_addtocartbtn_hvrcolor',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce .electron-btn:hover')
                ),
                // post button ( view cart )
                array(
                    'title' => esc_html__('Button Background ( View cart )', 'electron'),
                    'subtitle' => esc_html__('Change button background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_viewcartbtn_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.woocommerce.electron-product a.added_to_cart')
                ),
                array(
                    'title' => esc_html__('Hover Button Background ( View cart )', 'electron'),
                    'subtitle' => esc_html__('Change button hover background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_viewcartbtn_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'default' => '',
                    'output' => array('.woocommerce.electron-product a.added_to_cart:hover')
                ),
                array(
                    'title' => esc_html__('Button Title ( View cart )', 'electron'),
                    'subtitle' => esc_html__('Change button title color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_viewcartbtn_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce.electron-product a.added_to_cart')
                ),
                array(
                    'title' => esc_html__('Hover Button Title ( View cart )', 'electron'),
                    'subtitle' => esc_html__('Change button hover title color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_viewcartbtn_hvrcolor',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce.electron-product a.added_to_cart')
                ),
                array(
                    'title' => esc_html__('Button Border ( View cart )', 'electron'),
                    'subtitle' => esc_html__('Change hover button border style.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_viewcartbtn_brd',
                    'type' => 'border',
                    'output' => array('.woocommerce.electron-product a.added_to_cart')
                ),
                array(
                    'title' => esc_html__('Hover Button Border ( View cart )', 'electron'),
                    'subtitle' => esc_html__('Change hover button border style.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_viewcartbtn_hvrbrd',
                    'type' => 'border',
                    'output' => array('.woocommerce.electron-product a.added_to_cart:hover')
                ),
                array(
                    'title' => esc_html__('Pagination Background Color', 'electron'),
                    'subtitle' => esc_html__('Change shop page pagination background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_pagination_bgcolor',
                    'type' => 'color',
                    'mode' => 'background',
                    'default' => '',
                    'output' => array('.woocommerce nav.electron-woocommerce-pagination ul li a, .woocommerce nav.electron-woocommerce-pagination ul li span')
                ),
                array(
                    'title' => esc_html__('Active Pagination Background Color', 'electron'),
                    'subtitle' => esc_html__('Change shop page pagination hover and active item background color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_pagination_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background',
                    'default' => '',
                    'output' => array('.woocommerce nav.electron-woocommerce-pagination ul li a:focus, .woocommerce nav.electron-woocommerce-pagination ul li a:hover, .woocommerce nav.electron-woocommerce-pagination ul li span.current')
                ),
                array(
                    'title' => esc_html__('Pagination Text Color', 'electron'),
                    'subtitle' => esc_html__('Change shop page pagination text color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_pagination_color',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce nav.electron-woocommerce-pagination ul li a, .woocommerce nav.electron-woocommerce-pagination ul li span')
                ),
                array(
                    'title' => esc_html__('Active Pagination Text Color', 'electron'),
                    'subtitle' => esc_html__('Change shop page pagination hover and active item text color.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_pagination_hvrcolor',
                    'type' => 'color',
                    'default' => '',
                    'output' => array('.woocommerce nav.electron-woocommerce-pagination ul li a:focus, .woocommerce nav.electron-woocommerce-pagination ul li a:hover, .woocommerce nav.electron-woocommerce-pagination ul li span.current')
                )
            )
        ));

        /*************************************************
        ## SINGLE PAGE SECTION
        *************************************************/
        // create sections in the theme options
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('PRODUCT PAGE', 'electron'),
            'id' => 'product_page_section',
            'icon' => 'el el-shopping-cart-sign'
        ));
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Layout', 'electron'),
            'id' => 'product_layout_general_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'id' =>'single_shop_layout',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Page Sidebar Layouts', 'electron' ),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop page sidebar area.', 'electron' ),
                    'options' => array(
                        'left-sidebar' => esc_html__( 'Left Sidebar', 'electron' ),
                        'right-sidebar' => esc_html__( 'Right Sidebar', 'electron' ),
                        'full-width' => esc_html__( 'Fullwidth ( no-sidebar )', 'electron' ),
                    ),
                    'default' => 'full-width'
                ),
                array(
                    'id' =>'product_thumbs_layout',
                    'type' => 'button_set',
                    'title' => esc_html__('Gallery Type', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop product page tumbs.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'grid' => esc_html__( 'Grid', 'electron' ),
                        'slider' => esc_html__( 'Theme Slider', 'electron' ),
                        'woo' => esc_html__( 'WooCommerce Default Slider', 'electron' ),
                    ),
                    'default' => 'slider'
                ),
                array(
                    'title' => esc_html__('Gallery Column Width', 'electron'),
                    'customizer' => true,
                    'id' => 'product_thumbs_column_width',
                    'type' => 'spinner',
                    'default' => '7',
                    'min' => '1',
                    'step' => '1',
                    'max' => '12'
                ),
                array(
                    'title' => esc_html__('Sticky Sidebar', 'electron'),
                    'customizer' => true,
                    'id' => 'product_sticky_sidebar',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_layout', '!=', 'full-width' )
                ),
                array(
                    'id' =>'electron_product_gallery_grid_column',
                    'type' => 'button_set',
                    'title' => esc_html__('Grid Column', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop product page tumbs.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        '1' => esc_html__( '1 Column', 'electron' ),
                        '2' => esc_html__( '2 Column', 'electron' ),
                        '3' => esc_html__( '3 Column', 'electron' ),
                        '4' => esc_html__( '4 Column', 'electron' ),
                    ),
                    'default' => '2',
                    'required' => array( 'product_thumbs_layout', '=', 'grid' )
                ),
                array(
                    'id' =>'product_gallery_thumb_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Slider Thumbs Position', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop product page tumbs.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'top' => esc_html__( 'Horizontal Top', 'electron' ),
                        'bottom' => esc_html__( 'Horizontal Bottom', 'electron' ),
                        'left' => esc_html__( 'Vertical Left', 'electron' ),
                        'right' => esc_html__( 'Vertical Right', 'electron' ),
                    ),
                    'default' => 'left',
                    'required' => array( 'product_thumbs_layout', '!=', 'grid' )
                ),
                array(
                    'title' => esc_html__('Slider Thumbs Nav', 'electron'),
                    'customizer' => true,
                    'id' => 'product_gallery_thumb_nav',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'product_thumbs_layout', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__('Slider Thumbs Count', 'electron'),
                    'customizer' => true,
                    'id' => 'product_gallery_thumb_perview',
                    'type' => 'spinner',
                    'default' => '4',
                    'min' => '2',
                    'step' => '1',
                    'max' => '10',
                    'required' => array(
                        array( 'product_thumbs_layout', '=', 'slider' ),
                        array( 'product_gallery_thumb_nav', '=', '1' ),
                        array( 'product_gallery_thumb_position', '=', array('left','right') ),
                    )
                ),
                array(
                    'title' => esc_html__('Slider Thumbs Min Width', 'electron'),
                    'customizer' => true,
                    'id' => 'product_gallery_thumbs_width',
                    'type' => 'slider',
                    'default' => '',
                    'min' => 29,
                    'step' => 1,
                    'max' => 200,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'product_thumbs_layout', '=', 'slider' ),
                        array( 'product_gallery_thumb_nav', '=', '1' ),
                        array( 'product_gallery_thumb_position', '=', array('left','right') ),
                    )
                ),
                array(
                    'title' => esc_html__('Slider Thumbs Min Height', 'electron'),
                    'customizer' => true,
                    'id' => 'product_gallery_thumbs_height',
                    'type' => 'slider',
                    'default' => '',
                    'min' => 29,
                    'step' => 1,
                    'max' => 200,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'product_thumbs_layout', '=', 'slider' ),
                        array( 'product_gallery_thumb_nav', '=', '1' ),
                        array( 'product_gallery_thumb_position', '=', array('left','right') ),
                    )
                ),
                array(
                    'id' =>'gallery_slider_imgsize',
                    'type' => 'button_set',
                    'title' => esc_html__('Slider Gallery Image Size', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop product page gallery slider.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'auto' => esc_html__( 'Auto', 'electron' ),
                        'full' => esc_html__( 'Full (100%)', 'electron' )
                    ),
                    'default' => 'full',
                    'required' => array( 'product_thumbs_layout', '=', 'slider' )
                ),
                array(
                    'id' =>'gallery_thumb_imgsize',
                    'type' => 'button_set',
                    'title' => esc_html__('Slider Thumbs Image Size', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop product page tumbs.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'thumb' => esc_html__( 'Thumbnail', 'electron' ),
                        'full' => esc_html__( 'Full', 'electron' )
                    ),
                    'default' => 'full',
                    'required' => array( 'product_thumbs_layout', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__('Gallery Zoom Effect', 'electron'),
                    'subtitle' => esc_html__('You can enable or disable the site product image zoom option.', 'electron'),
                    'customizer' => true,
                    'id' => 'electron_product_zoom',
                    'type' => 'switch',
                    'default' => 1
                ),
                /*
                array(
                    'id' =>'electron_product_zoom_type',
                    'type' => 'button_set',
                    'title' => esc_html__('Zoom Effect Type', 'electron'),
                    'customizer' => true,
                    'options' => array(
                        'default' => esc_html__( 'Default', 'electron' ),
                        'drift' => esc_html__( 'Drift', 'electron' )
                    ),
                    'default' => 'default',
                    'required' => array( 'electron_product_zoom', '=', '1' )
                ),
                */
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Summary Layout', 'electron'),
            'id' => 'product_summary_layout_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'id' =>'single_shop_summary_layout_type',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Product Summary Layouts', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'default' => esc_html__( 'Default', 'electron' ),
                        'custom' => esc_html__( 'Custom Layout', 'electron' )
                    ),
                    'default' => 'default'
                ),
                array(
                    'id' =>'single_shop_summary_layouts',
                    'type' => 'sorter',
                    'title' => esc_html__( 'Product Summary Layouts Manager', 'electron' ),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme product page summary area.', 'electron' ),
                    'options' => array(
                        'show' => array(
                            'bread' => esc_html__( 'Breadcrumbs', 'electron' ),
                            'title' => esc_html__( 'Title', 'electron' ),
                            'rating' => esc_html__( 'Rating', 'electron' ),
                            'labels' => esc_html__( 'Labels', 'electron' ),
                            'price' => esc_html__( 'Price', 'electron' ),
                            'excerpt' => esc_html__( 'Excerpt', 'electron' ),
                            'cart' => esc_html__( 'Cart', 'electron' ),
                            'meta' => esc_html__( 'Meta', 'electron' ),
                            'trust-badge' => esc_html__( 'Trusted Badge', 'electron' ),
                        ),
                        'hide' => array(
                            'progresbar' => esc_html__( 'Progressbar', 'electron' ),
                            'coupon' => esc_html__( 'Coupon', 'electron' ),
                            'countdown' => esc_html__( 'Countdown', 'electron' ),
                            'popups' => esc_html__( 'Popups', 'electron' ),
                            'visitors' => esc_html__( 'Visitors Message', 'electron' ),
                            'custom-btn' => esc_html__( 'Custom Button', 'electron' ),
                            'brand' => esc_html__( 'Brand Image', 'electron' ),
                        )
                    ),
                    'required' => array( 'single_shop_summary_layout_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__( 'Sticky Summary', 'electron' ),
                    'customizer' => true,
                    'id' => 'single_shop_sticky_summary',
                    'type' => 'switch',
                    'default' => 0
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Breadcrumbs', 'electron'),
            'id' => 'product_breadcrumbs_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Product Breadcrumbs', 'electron'),
                    'customizer' => true,
                    'id' => 'product_bread_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' =>'product_bread_position',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Breadcrumbs Position', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'default' => esc_html__( 'Default', 'electron' ),
                        'before' => esc_html__( 'Before Gallery', 'electron' )
                    ),
                    'default' => 'default'
                ),
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Labels', 'electron'),
            'id' => 'product_labels_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Product All Labels', 'electron'),
                    'subtitle' => esc_html__('Sale, Stock, Discount', 'electron'),
                    'customizer' => true,
                    'id' => 'product_labels_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Product Sale Label', 'electron'),
                    'customizer' => true,
                    'id' => 'product_sale_visibility',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array('product_labels_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Product Discount Label', 'electron'),
                    'customizer' => true,
                    'id' => 'product_discount_visibility',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array('product_labels_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Product Stock Label', 'electron'),
                    'customizer' => true,
                    'id' => 'product_stock_visibility',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array('product_labels_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Sale Style', 'electron'),
                    'customizer' => true,
                    'id' => 'product_labels_sale_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_sale_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Backgorund Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_sale_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array('.electron-product-labels .electron-label.electron-badge'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_sale_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_sale_color',
                    'type' => 'color',
                    'output' => array('.electron-product-labels .electron-label.electron-badge'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_sale_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_sale_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-product-labels .electron-label.electron-badge'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_sale_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border Radius', 'electron'),
                    'customizer' => true,
                    'id' => 'product_sale_radius',
                    'type' => 'slider',
                    'default' => '',
                    'min' => -1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_sale_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Discount Style', 'electron'),
                    'customizer' => true,
                    'id' => 'product_labels_discount_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_discount_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Backgorund Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_discount_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array('.electron-product-labels .electron-label.electron-discount'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_discount_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_discount_color',
                    'type' => 'color',
                    'output' => array('.electron-product-labels .electron-label.electron-discount'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_discount_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_discount_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-product-labels .electron-label.electron-discount'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_discount_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border Radius', 'electron'),
                    'customizer' => true,
                    'id' => 'product_discount_radius',
                    'type' => 'slider',
                    'default' => '',
                    'min' => -1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_discount_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Stock Status Style', 'electron'),
                    'customizer' => true,
                    'id' => 'product_labels_stock_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Backgorund Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_stock_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array('.electron-price-wrapper .electron-stock-status.in-stock'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_stock_color',
                    'type' => 'color',
                    'output' => array('.electron-price-wrapper .electron-stock-status.in-stock'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_stock_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-price-wrapper .electron-stock-status.in-stock'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border Radius', 'electron'),
                    'customizer' => true,
                    'id' => 'product_stock_radius',
                    'type' => 'slider',
                    'default' => '',
                    'min' => -1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Out of Stock Style', 'electron'),
                    'customizer' => true,
                    'id' => 'product_labels_outofstock_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Backgorund Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_outofstock_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array('.electron-price-wrapper .out-of-stock'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_outofstock_color',
                    'type' => 'color',
                    'output' => array('.electron-price-wrapper .out-of-stock'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_outofstock_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-price-wrapper .out-of-stock'),
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Border Radius', 'electron'),
                    'customizer' => true,
                    'id' => 'product_outofstock_radius',
                    'type' => 'slider',
                    'default' => '',
                    'min' => -1,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'product_labels_visibility', '=', '1' ),
                        array( 'product_stock_visibility', '=', '1' )
                    )
                ),
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Title', 'electron'),
            'id' => 'single_shop_title_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Title Tag', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_title_tag',
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Select type', 'electron' ),
                        'h1' => esc_html__( 'H1', 'electron' ),
                        'h2' => esc_html__( 'H2', 'electron' ),
                        'h3' => esc_html__( 'H3', 'electron' ),
                        'h4' => esc_html__( 'H4', 'electron' ),
                        'h5' => esc_html__( 'H5', 'electron' ),
                        'h6' => esc_html__( 'H6', 'electron' ),
                        'p' => esc_html__( 'p', 'electron' ),
                        'div' => esc_html__( 'div', 'electron' ),
                        'span' => esc_html__( 'span', 'electron' )
                    ),
                    'default' => 'h2'
                ),
                array(
                    'title' => esc_html__( 'Title Typography', 'electron' ),
                    'id' => 'product_title_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-product-title' ),
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_title_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-product-title' )
                ),
                array(
                    'title' => esc_html__( 'Border', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_title_border',
                    'type' => 'border',
                    'output' => array('.electron-product-summary .electron-product-title' )
                ),
                array(
                    'title' => esc_html__( 'Padding', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_title_padding',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array('.electron-product-summary .electron-product-title' )
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Excerpt', 'electron'),
            'id' => 'single_shop_excerpt_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Excerpt Typography', 'electron' ),
                    'id' => 'product_excerpt_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item .woocommerce-product-details__short-description p,.electron-product-summary .electron-summary-item .woocommerce-product-details__short-description ul > li' ),
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_excerpt_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .woocommerce-product-details__short-description' )
                ),
                array(
                    'title' => esc_html__( 'Border', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_excerpt_border',
                    'type' => 'border',
                    'output' => array('.electron-product-summary .electron-summary-item .woocommerce-product-details__short-description' )
                ),
                array(
                    'title' => esc_html__( 'Padding', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_excerpt_padding',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array('.electron-product-summary .electron-summary-item .woocommerce-product-details__short-description' )
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Add To Cart', 'electron'),
            'id' => 'single_shop_cart_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Cart Container Customize Options', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_addtocart_container_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_cart_container_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-product-info' )
                ),
                array(
                    'title' => esc_html__( 'Border', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_cart_container_border',
                    'type' => 'border',
                    'output' => array('.electron-product-summary .electron-product-info' )
                ),
                array(
                    'title' => esc_html__( 'Padding', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_cart_container_border',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array('.electron-product-summary .electron-product-info' )
                ),
                array(
                    'title' => esc_html__( 'Add to Cart Customize Options', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_addtocart_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn' )
                ),
                array(
                    'title' => esc_html__('Background Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn:hover' )
                ),
                array(
                    'title' => esc_html__('Title Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn' )
                ),
                array(
                    'title' => esc_html__('Title Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_hvrcolor',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn:hover' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn' )
                ),
                array(
                    'title' => esc_html__('Border ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn:hover' )
                ),
                array(
                    'title' => esc_html__('Background Color ( Loading )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_loading_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn.loading .loading-wrapper' )
                ),
                array(
                    'title' => esc_html__('Border ( Loading )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_addtocart_loading_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array( '.electron-product-summary .single_add_to_cart_button.electron-btn.loading .loading-wrapper' )
                ),
                array(
                    'title' => esc_html__( 'Quantity Customize Options', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_quantity_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_quantity_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item .quantity' )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_quantity_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .quantity' )
                ),
                array(
                    'title' => esc_html__('Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_quantity_color',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .quantity input' )
                ),
                array(
                    'title' => esc_html__('Plus & Minus Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_quantity_btns_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .quantity .quantity-button.plus,.electron-product-summary .electron-summary-item .quantity-button.minus' )
                ),
                array(
                    'title' => esc_html__('Plus & Minus Background Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_quantity_btns_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .quantity .quantity-button.plus:hover,.electron-product-summary .electron-summary-item .quantity-button.minus:hover' )
                ),
                array(
                    'title' => esc_html__('Plus & Minus Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_quantity_btns_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-summary-item .quantity .quantity-button.plus,.electron-product-summary .electron-summary-item .quantity-button.minus' )
                ),
                array(
                    'title' => esc_html__('Plus & Minus Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_quantity_btns_hvrcolor',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-summary-item .quantity .quantity-button.plus:hover,.electron-product-summary .electron-summary-item .quantity-button.minus:hover' )
                ),
                array(
                    'title' => esc_html__( 'Wishlist & Compare Customize Options', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_buttons_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_action_buttons_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button' )
                ),
                array(
                    'title' => esc_html__('Background Color ( Hover/Active )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_action_buttons_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button:hover,.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button.icon-added,.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button.woosc-added' )
                ),
                array(
                    'title' => esc_html__('Icon Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_action_buttons_color',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button svg' )
                ),
                array(
                    'title' => esc_html__('Icon Color ( Hover/Active )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_action_buttons_hvrcolor',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button:hover svg,.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button.woosw-added svg,.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button.woosc-added svg' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_action_buttons_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button' )
                ),
                array(
                    'title' => esc_html__('Border ( Hover/Active )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_action_buttons_hvrbrd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button:hover,.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button.woosw-added,.electron-product-summary .electron-summary-item .electron-after-single-cart-button .electron-product-button.woosc-added' )
                ),
                array(
                    'title' => esc_html__( 'Cart Info Bottom Customize Options', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_bottom_shipping_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                ),
                array(
                    'title' => esc_html__('Border Top Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_cart_info_bordertop',
                    'type' => 'color',
                    'mode' => 'border-top-color',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-product-info-bottom' )
                ),
                array(
                    'title' => esc_html__('Delivery Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_cart_info_delivery_text_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-product-info-bottom .info-message strong' )
                ),
                array(
                    'title' => esc_html__('Icon Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_cart_info_delivery_icon_color',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-product-info-bottom .shipping-class svg' )
                ),
                array(
                    'title' => esc_html__('Message Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_cart_info_delivery_message_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-summary-item .electron-product-info-bottom .info-message' )
                ),
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Price', 'electron'),
            'id' => 'product_price_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_price_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-price-wrapper' )
                ),
                array(
                    'title' => esc_html__( 'Border', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_price_border',
                    'type' => 'border',
                    'output' => array('.electron-product-summary .electron-price-wrapper' )
                ),
                array(
                    'title' => esc_html__( 'Padding', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_price_padding',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array('.electron-product-summary .electron-price-wrapper' )
                ),
                array(
                    'title' => esc_html__( 'Price Typography', 'electron' ),
                    'id' => 'product_price_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-price,.electron-product-summary .electron-summary-item.electron-price.price,.electron-product-summary .electron-summary-item.electron-price > span,.electron-product-summary .electron-summary-item.electron-price.price >.amount,.electron-product-summary .electron-summary-item.electron-price.price > .electron-primary-color.ins,.electron-product-summary .electron-summary-item.electron-price .price,.electron-product-summary .electron-summary-item.electron-price .price > .electron-primary-color.ins' )
                ),
                array(
                    'title' => esc_html__( 'Price 2 Typography', 'electron' ),
                    'id' => 'product_price2_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-price.price > .electron-primary-color.del,.electron-product-summary .electron-summary-item.electron-price .price > span.del,.electron-product-summary .electron-summary-item.electron-price.price span.del>span' )
                ),
                array(
                    'title' => esc_html__( 'Product Add to Cart Variation Price Typography', 'electron' ),
                    'id' => 'product_variation_price_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.cart .woocommerce-variation-price .price,.electron-product-summary .electron-summary-item.cart .woocommerce-variation-price .price > span' )
                ),
                array(
                    'title' => esc_html__( 'Product Add to Cart Variation Price 2 Typography', 'electron' ),
                    'id' => 'product_variation_price2_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.cart .woocommerce-variation-price .price > span.del,.electron-product-summary .electron-summary-item.cart .woocommerce-variation-price .price > span.del > span' )
                )
            )
        ));
        // Buy Now Button SUBSECTION
        Redux::setSection($electron_pre,
            array(
                'title' => esc_html__('Product Brand Image', 'electron'),
                'id' => 'product_brand_button_subsection',
                'subsection' => true,
                'icon' => 'el el-cog',
                'fields' => array(
                    array(
                        'title' => esc_html__('Product Brand Image Display', 'electron'),
                        'customizer' => true,
                        'id' => 'product_brand_visibility',
                        'type' => 'switch',
                        'default' => 0
                    ),
                )
            )
        );
        // Buy Now Button SUBSECTION
        Redux::setSection($electron_pre,
            array(
                'title' => esc_html__('Buy Now Button', 'electron'),
                'id' => 'buynow_button_subsection',
                'subsection' => true,
                'icon' => 'el el-cog',
                'fields' => array(
                    array(
                        'title' => esc_html__('Buy Now Button Display', 'electron'),
                        'customizer' => true,
                        'id' => 'buy_now_visibility',
                        'type' => 'switch',
                        'default' => 0
                    ),
                    array(
                        'title' => esc_html__( 'Button Text', 'electron' ),
                        'subtitle' => esc_html__('Leave blank to use the default text or its equivalent translation in multiple languages.', 'electron'),
                        'customizer' => true,
                        'id' => 'buy_now_btn_title',
                        'type' => 'text',
                        'default' => '',
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Reset Cart', 'electron'),
                        'subtitle' => esc_html__('Reset the cart before doing buy now.', 'electron'),
                        'on' => esc_html__('Yes', 'electron'),
                        'off' => esc_html__('No', 'electron'),
                        'customizer' => true,
                        'id' => 'buy_now_reset_cart',
                        'type' => 'switch',
                        'default' => 0,
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__( 'Parameter', 'electron' ),
                        'customizer' => true,
                        'id' => 'buy_now_param',
                        'type' => 'text',
                        'default' => 'electron-buy-now',
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    ),
                    array(
                        'id' =>'buy_now_redirect',
                        'type' => 'button_set',
                        'title' => esc_html__( 'Redirect to', 'electron' ),
                        'options' => array(
                            'checkout' => esc_html__( 'Checkout page', 'electron' ),
                            'cart' => esc_html__( 'Cart page', 'electron' ),
                            'custom' => esc_html__( 'Custom', 'electron' ),
                        ),
                        'default' => 'checkout',
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__( 'Custom Page', 'electron' ),
                        'customizer' => true,
                        'id' => 'buy_now_redirect_custom',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array( 'buy_now_visibility', '=', '1' ),
                            array( 'buy_now_redirect', '=', 'custom' ),
                        )
                    ),
                    array(
                        'title' => esc_html__('Background Color', 'electron'),
                        'subtitle' => esc_html__('Change button background color.', 'electron'),
                        'customizer' => true,
                        'id' => 'buy_now_bgcolor',
                        'type' => 'color',
                        'mode' => 'background-color',
                        'default' => '',
                        'output' => array('.electron-btn.electron-btn-buynow'),
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Background Color ( Hover )', 'electron'),
                        'subtitle' => esc_html__('Change button hover background color.', 'electron'),
                        'customizer' => true,
                        'id' => 'buy_now_hvrbgcolor',
                        'type' => 'color',
                        'mode' => 'background-color',
                        'default' => '',
                        'output' => array('.electron-btn.electron-btn-buynow:hover'),
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'electron'),
                        'subtitle' => esc_html__('Change button text color.', 'electron'),
                        'customizer' => true,
                        'id' => 'buy_now_color',
                        'type' => 'color',
                        'mode' => 'color',
                        'default' => '',
                        'output' => array('.electron-btn.electron-btn-buynow'),
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Text Color ( Hover )', 'electron'),
                        'subtitle' => esc_html__('Change button hover text color.', 'electron'),
                        'customizer' => true,
                        'id' => 'buy_now_hvrcolor',
                        'type' => 'color',
                        'mode' => 'color',
                        'default' => '',
                        'output' => array('.electron-btn.electron-btn-buynow:hover'),
                        'required' => array( 'buy_now_visibility', '=', '1' )
                    )
                )
            )
        );
        // Popup Notices SUBSECTION
        Redux::setSection($electron_pre,
            array(
                'title' => esc_html__('Product Custom Button', 'electron'),
                'id' => 'product_custom_button_subsection',
                'subsection' => true,
                'icon' => 'el el-cog',
                'fields' => array(
                    array(
                        'title' => esc_html__('Product Page Custom Button Display', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_visibility',
                        'type' => 'switch',
                        'default' => 0
                    ),
                    array(
                        'title' => esc_html__( 'Button Text', 'electron' ),
                        'subtitle' => esc_html__('Leave blank to use the default text or its equivalent translation in multiple languages.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_title',
                        'type' => 'text',
                        'default' => 'Request Information',
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    ),
                    array(
                        'id' =>'product_custom_btn_action',
                        'type' => 'select',
                        'title' => esc_html__( 'Action', 'electron' ),
                        'options' => array(
                            'link' => esc_html__( 'Custom Link', 'electron' ),
                            'form' => esc_html__( 'Open Popup Form', 'electron' ),
                            'whatsapp' => esc_html__( 'Open Whatsapp', 'electron' ),
                        ),
                        'default' => 'link',
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__( 'Custom Link', 'electron' ),
                        'customizer' => true,
                        'id' => 'product_custom_btn_link',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array( 'product_custom_btn_visibility', '=', '1' ),
                            array( 'product_custom_btn_action', '=', 'link' )
                        )
                    ),
                    array(
                        'title' => esc_html__( 'Form Shortcode or Custom HTML', 'electron' ),
                        'subtitle' => esc_html__('Add your form shortcode here.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_form_shortcode',
                        'type' => 'textarea',
                        'default' => '',
                        'required' => array(
                            array( 'product_custom_btn_visibility', '=', '1' ),
                            array( 'product_custom_btn_action', '=', 'form' )
                        )
                    ),
                    array(
                        'title' => esc_html__( 'Whatsapp Desktop Link', 'electron' ),
                        'subtitle' => esc_html__('Add your whatsapp link here.Deafult: https://api.whatsapp.com/send?text=', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_whatsapp_link',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array( 'product_custom_btn_visibility', '=', '1' ),
                            array( 'product_custom_btn_action', '=', 'whatsapp' )
                        )
                    ),
                    array(
                        'title' => esc_html__( 'Whatsapp Mobile Link', 'electron' ),
                        'subtitle' => esc_html__('Add your whatsapp link here.Deafult: whatsapp://send?text=', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_whatsapp_mobile_link',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array( 'product_custom_btn_visibility', '=', '1' ),
                            array( 'product_custom_btn_action', '=', 'whatsapp' )
                        )
                    ),
                    array(
                        'id' =>'product_whatsapp_target',
                        'type' => 'select',
                        'title' => esc_html__( 'Target', 'electron' ),
                        'options' => array(
                            '' => esc_html__( 'Select an option', 'electron' ),
                            '_blank' => esc_html__( 'Open in a new window', 'electron' ),
                            '_self' => esc_html__( 'Open in the same frame', 'electron' ),
                            '_parent' => esc_html__( 'Open in the parent frame', 'electron' ),
                            '_top' => esc_html__( 'Open in the full body of the window', 'electron' )
                        ),
                        'required' => array(
                            array( 'product_custom_btn_visibility', '=', '1' ),
                            array( 'product_custom_btn_action', '!=', 'form' )
                        )
                    ),
                    array(
                        'title' => esc_html__('Background Color', 'electron'),
                        'subtitle' => esc_html__('Change button background color.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_bgcolor',
                        'type' => 'color',
                        'mode' => 'background-color',
                        'default' => '',
                        'output' => array('.electron-product-action-button .electron-btn:not(.type-widget)'),
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Background Color ( Hover )', 'electron'),
                        'subtitle' => esc_html__('Change button hover background color.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_hvrbgcolor',
                        'type' => 'color',
                        'mode' => 'background-color',
                        'default' => '',
                        'output' => array('.electron-product-action-button .electron-btn:not(.type-widget):hover'),
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'electron'),
                        'subtitle' => esc_html__('Change button text color.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_color',
                        'type' => 'color',
                        'mode' => 'color',
                        'default' => '',
                        'output' => array('.electron-product-action-button .electron-btn:not(.type-widget)'),
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Text Color ( Hover )', 'electron'),
                        'subtitle' => esc_html__('Change button hover text color.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_hvrcolor',
                        'type' => 'color',
                        'mode' => 'color',
                        'default' => '',
                        'output' => array('.electron-product-action-button .electron-btn:not(.type-widget):hover'),
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Border', 'electron'),
                        'subtitle' => esc_html__('Change button border.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_brdcolor',
                        'type' => 'border',
                        'output' => array('.electron-product-action-button .electron-btn:not(.type-widget)'),
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    ),
                    array(
                        'title' => esc_html__('Border ( Hover )', 'electron'),
                        'subtitle' => esc_html__('Change button hover border.', 'electron'),
                        'customizer' => true,
                        'id' => 'product_custom_btn_hvrbrdcolor',
                        'type' => 'border',
                        'output' => array('.electron-product-action-button .electron-btn:not(.type-widget):hover'),
                        'required' => array( 'product_custom_btn_visibility', '=', '1' )
                    )
                )
            )
        );
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Coupons', 'electron'),
            'id' => 'product_coupons_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Product Coupons Display', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_bgcolor',
                    'type' => 'color',
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Discount Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_discount_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array('.electron-summary-item.coupons .center .discount'),
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Discount Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_discount_text_color',
                    'type' => 'color',
                    'output' => array('.electron-summary-item.coupons .center .discount'),
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Name & Date Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_discount_smalltext_color',
                    'type' => 'color',
                    'output' => array('.electron-summary-item.coupons .center .name,.electron-summary-item.coupons .center small'),
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Left Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_left_text_color',
                    'type' => 'color',
                    'output' => array('.electron-summary-item.coupons .coupon .left'),
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Left Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_left_border_color',
                    'type' => 'color',
                    'mode' => 'border-color',
                    'output' => array('.electron-summary-item.coupons .coupon .left'),
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Right Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_right_text_color',
                    'type' => 'color',
                    'output' => array('.electron-summary-item.coupons .coupon .right'),
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Right Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_coupons_right_bgcolor',
                    'type' => 'color',
                    'required' => array( 'product_coupons_visibility', '=', '1' )
                ),
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Delivery & Return Popup', 'electron'),
            'id' => 'product_delivery_popup_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Delivery & Return Popup', 'electron' ),
                    'subtitle' => esc_html__( 'Select an elementor template from list', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_delivery_template',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args
                ),
                array(
                    'title' => esc_html__( 'Category(s) Exclude', 'electron' ),
                    'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_delivery_category_exclude',
                    'type' => 'select',
                    'data' => 'terms',
                    'multi' => true,
                    'args'  => [
                        'taxonomies' => array( 'product_cat' ),
                    ],
                    'required' => array( 'product_delivery_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__( 'Tag(s) Exclude', 'electron' ),
                    'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_delivery_tag_exclude',
                    'type' => 'select',
                    'data' => 'terms',
                    'multi' => true,
                    'args'  => [
                        'taxonomies' => array( 'product_tag' ),
                    ],
                    'required' => array( 'product_delivery_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__( 'Custom Text', 'electron' ),
                    'desc' => esc_html__( 'Text entered here will be used for Delivery & Return area', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_delivery_text',
                    'type' => 'text',
                    'required' => array( 'product_delivery_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__( 'Custom SVG Icon HTML', 'electron' ),
                    'desc' => esc_html__( 'Icon entered here will be used for Delivery & Return area', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_delivery_icon',
                    'type' => 'textarea',
                    'required' => array( 'product_delivery_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_delivery_text_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-delivery-btn a' ),
                    'required' => array( 'product_delivery_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Text Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_delivery_text_hvrcolor',
                    'type' => 'color',
                    'output' => array( '.electron-product-delivery-btn a:hover' ),
                    'required' => array( 'product_delivery_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Icon Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_delivery_svg_color',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-product-delivery-btn svg' ),
                    'required' => array( 'product_delivery_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Icon Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_delivery_svg_hvrcolor',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-product-delivery-btn:hover svg' ),
                    'required' => array( 'product_delivery_template', '!=', '' )
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Size Guide Popup', 'electron'),
            'id' => 'product_size_guide_popup_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Size Guide', 'electron' ),
                    'subtitle' => esc_html__( 'Select an elementor template from list', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_size_guide_template',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args
                ),
                array(
                    'title' => esc_html__( 'Category(s) Exclude', 'electron' ),
                    'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_size_guide_category_exclude',
                    'type' => 'select',
                    'data' => 'terms',
                    'multi' => true,
                    'args'  => [
                        'taxonomies' => array( 'product_cat' ),
                    ],
                    'required' => array( 'product_size_guide_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__( 'Tag(s) Exclude', 'electron' ),
                    'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_size_guide_tag_exclude',
                    'type' => 'select',
                    'data' => 'terms',
                    'multi' => true,
                    'args'  => [
                        'taxonomies' => array( 'product_tag' ),
                    ],
                    'required' => array( 'product_size_guide_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__( 'Custom Text', 'electron' ),
                    'desc' => esc_html__( 'Text entered here will be used for Size Guide area', 'electron' ),
                    'customizer' => true,
                    'id' => 'size_guide_text',
                    'type' => 'text',
                    'required' => array( 'product_size_guide_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__( 'Custom SVG Icon HTML', 'electron' ),
                    'desc' => esc_html__( 'Icon entered here will be used for Size Guide area', 'electron' ),
                    'customizer' => true,
                    'id' => 'size_guide_icon',
                    'type' => 'textarea',
                    'required' => array( 'product_size_guide_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_size_guide_popup_text_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-size-guide-btn a' ),
                    'required' => array( 'product_size_guide_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Text Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_size_guide_popup_text_hvrcolor',
                    'type' => 'color',
                    'output' => array( '.electron-product-size-guide-btn a:hover' ),
                    'required' => array( 'product_size_guide_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Icon Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_size_guide_popup_svg_color',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-product-size-guide-btn svg' ),
                    'required' => array( 'product_size_guide_template', '!=', '' )
                ),
                array(
                    'title' => esc_html__('Icon Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_size_guide_popup_svg_hvrcolor',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-product-size-guide-btn:hover svg' ),
                    'required' => array( 'product_size_guide_template', '!=', '' )
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Stock Progress Bar', 'electron'),
            'id' => 'product_progressbar_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Stock Progress Bar', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_progressbar_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Container Style', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_wrapper_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Container Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_wrapper_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-single-product-stock' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Pading', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_wrapper_padding',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-single-product-stock' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_wrapper_brd',
                    'type' => 'border',
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-single-product-stock' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border Radius', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_wrapper_brd_radius',
                    'type' => 'slider',
                    'default' => '',
                    'min' => -1,
                    'step' => 0.01,
                    'max' => 1,
                    'resolution' => 0.1,
                    'display_value' => 'text'
                ),
                array(
                    'title' => esc_html__('Progressbar Style', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_progressbar_info',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Height', 'electron' ),
                    'customizer' => true,
                    'width' => false,
                    'id' => 'product_progressbar_progressbar_height',
                    'type' => 'dimensions',
                    'output' => array('.electron-single-product-stock .electron-product-stock-progressbar'),
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-single-product-stock .electron-product-stock-progress' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Progress Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_progress_color',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-single-product-stock .electron-product-stock-progressbar' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_text_color',
                    'type' => 'color',
                    'output' => array( '.electron-single-product-stock .electron-product-stock-progressbar .stock-details' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Value Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_value_color',
                    'type' => 'color',
                    'output' => array( '.electron-single-product-stock .electron-product-stock-progressbar .stock-details span' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Pading', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_padding',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array( '.electron-single-product-stock .electron-product-stock-progress' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_brd',
                    'type' => 'border',
                    'output' => array( '.electron-single-product-stock .electron-product-stock-progress' ),
                    'required' => array( 'single_shop_progressbar_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border Radius', 'electron'),
                    'customizer' => true,
                    'id' => 'product_progressbar_brd_radius',
                    'type' => 'slider',
                    'default' => '',
                    'min' => 0,
                    'step' => 0.01,
                    'max' => 1,
                    'resolution' => 0.1,
                    'display_value' => 'text'
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Metas', 'electron'),
            'id' => 'product_meta_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Meta', 'electron'),
                    'subtitle' => esc_html__('SKU, Categories, Tags', 'electron'),
                    'customizer' => true,
                    'id' => 'product_meta_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__( 'Meta Label Typography', 'electron' ),
                    'id' => 'product_meta_label_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-product-meta .electron-meta-label' ),
                    'required' => array( 'product_meta_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Meta Link Typography', 'electron' ),
                    'id' => 'product_meta_link_color',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-product-meta a' ),
                    'required' => array( 'product_meta_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Meta Link Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'product_meta_link_hvrcolor',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-product-meta a:hover' ),
                    'required' => array( 'product_meta_visibility', '=', '1' )
                )
            )
        ));
        // Product Countdown SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Countdown', 'electron'),
            'id' => 'product_countdown_subsection',
            'subsection' => true,
            'icon' => 'el el-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Countdown', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' =>'product_countdown_type',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Countdown Box Type', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'default' => esc_html__( 'Default', 'electron' ),
                        '1' => esc_html__( 'Type 1', 'electron' ),
                        '2' => esc_html__( 'Type 2', 'electron' ),
                        '3' => esc_html__( 'Type 3', 'electron' ),
                        '4' => esc_html__( 'Type 4', 'electron' )
                    ),
                    'default' => '1',
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('General End Date', 'electron'),
                    'subtitle' => esc_html__('If you want to use different time for each product, you can set or change time in product settings', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_date',
                    'type' => 'date',
                    'placeholder' => esc_html__('Click to enter a date', 'electron'),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Show only for on sale products', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_only_sale',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Update Countdown When Expires', 'electron'),
                    'subtitle' => esc_html__('When the time is expired, update the date every next X days', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_update',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Update Per Next Day', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_update_next',
                    'type' => 'text',
                    'default' => '7',
                    'validate' => array('numeric'),
                    'required' => array(
                        array( 'product_countdown_visibility', '=', '1' ),
                        array( 'product_countdown_update', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Heading', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_text',
                    'type' => 'textarea',
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Description', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_after_text',
                    'type' => 'textarea',
                    'default' => '',
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Expired Text', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_expired',
                    'type' => 'text',
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Icon', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_icon_visibilty',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Icon HTML', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_icon',
                    'type' => 'textarea',
                    'default' => '<svg class="svgFlash electron-svg-icon" fill="currentColor" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="a"><g><path d="m452.51 194.38c3.59-3.25 21.83-19.17 24.92-21.99 5 5.57 9.58 10.59 10.24 11.13 2.28 2.05 6.34 2.46 9.4.71 1.83-1.06 4.24-2.64 7.18-5.21 2.93-2.58 4.81-4.76 6.11-6.45 2.15-2.81 2.32-6.93.62-9.5-.96-1.62-20.53-25.25-22.82-27.75-2.13-2.64-22.54-25.53-24-26.72-2.28-2.06-6.34-2.46-9.4-.71-1.83 1.06-4.24 2.64-7.18 5.21-2.93 2.58-4.81 4.76-6.11 6.44-2.15 2.81-2.32 6.93-.62 9.5.44.74 4.72 6.02 9.47 11.8-2.85 2.39-20.75 17.81-24.02 20.59l26.21 32.94z" fill="#454565"></path><path d="m356.57 126.14c.5-4.1 5.2-25.34 5.62-28.97 11.36-.21 21.68-.47 22.98-.67 4.69-.51 9.73-4.21 11.42-8.77 1-2.74 2.14-6.49 2.87-11.63.71-5.14.63-8.89.4-11.63-.41-4.55-4.41-8.25-8.95-8.77-2.74-.44-49.07-1.17-54.22-1.03-5.11-.14-51.64.59-54.5 1.03-4.69.51-9.73 4.22-11.42 8.77-1 2.74-2.14 6.49-2.87 11.63-.71 5.13-.63 8.89-.4 11.63.41 4.55 4.41 8.25 8.95 8.77 1.25.2 11.5.46 22.79.67-.59 3.63-5.47 24.87-6.12 28.97h63.44z" fill="#454565"></path><rect fill="#f04760" height="37.83" rx="18.91" width="37.83" x="15.97" y="225.7"></rect><path d="m327.25 121.9c-34.31 0-67.66 10.31-96.71 27.99l-67.56-.03h-.13l-.06-.02-.04.02h-116.87c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86l92.75.05c9.78.7 17.49 8.85 17.49 18.81v.19c0 10.42-8.45 18.86-18.86 18.86h-51.97c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h20.4c10.42 0 18.86 8.45 18.86 18.86v.19c0 10.42-8.45 18.86-18.86 18.86h-86.71c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h101.67c10.42 0 18.86 8.44 18.86 18.86v.19c0 10.42-8.45 18.86-18.86 18.86h-49.4c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h103.7c25.91 26.16 62.55 42.06 105.15 42.06 92.63 0 178.27-75.09 191.29-167.72s-51.52-167.72-144.15-167.72z" fill="#e03757"></path><path d="m135.64 369.91c131.56-6.76 238.81-105.43 258.84-233.05-19.78-9.61-42.51-14.96-67.24-14.96-34.31 0-67.66 10.31-96.71 27.99l-67.56-.03h-.13l-.06-.02-.04.02h-116.86c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86l92.75.05c9.78.7 17.49 8.85 17.49 18.81v.19c0 10.42-8.45 18.86-18.86 18.86h-51.97c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h20.4c10.42 0 18.86 8.45 18.86 18.86v.19c0 10.42-8.45 18.86-18.86 18.86h-86.71c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h101.67c10.42 0 18.86 8.44 18.86 18.86v.19c0 4.29-1.45 8.24-3.87 11.41z" fill="#f04760"></path><path d="m389.77 272.6-79.02 121.93c-1.82 2.8-4.93 4.49-8.27 4.49h-6.19c-6.38 0-11.08-5.97-9.57-12.17l19.47-80.36h-47.47c-5.69 0-9.88-5.32-8.54-10.85l26.34-108.72c.95-3.94 4.48-6.72 8.54-6.72h54.62c5.69 0 9.88 5.32 8.54 10.85l-16.07 66.33h49.35c7.81 0 12.51 8.65 8.27 15.21z"></path></g></g></svg>',
                    'required' => array(
                        array( 'product_countdown_visibility', '=', '1' ),
                        array( 'product_countdown_icon_visibilty', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_icon_size',
                    'type' => 'dimensions',
                    'output' => array( '.electron-product-summary .electron-viewed-offer-time.has-icon .electron-svg-icon' ),
                    'required' => array(
                        array( 'product_countdown_visibility', '=', '1' ),
                        array( 'product_countdown_icon_visibilty', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Container Custmize options', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_container_divider',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-viewed-offer-time.electron-summary-item:not(.type-default),.electron-viewed-offer-time.electron-summary-item.type-default .electron-coming-time' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Padding', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_count_padding',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array( '.electron-viewed-offer-time.electron-summary-item:not(.type-default),.electron-viewed-offer-time.electron-summary-item.type-default .electron-coming-time' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_count_border',
                    'type' => 'border',
                    'output' => array( '.electron-viewed-offer-time.electron-summary-item:not(.type-default),.electron-viewed-offer-time.electron-summary-item.type-default .electron-coming-time' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Text Custmize Options', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_text_divider',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Heading Typography', 'electron' ),
                    'id' => 'product_countdown_heading_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'text-decoration' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-viewed-offer-time .offer-time-text' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Heading Typography', 'electron' ),
                    'id' => 'product_countdown_text_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'text-decoration' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-summary .electron-summary-item.electron-viewed-offer-time .offer-time-text-after' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Count Custmize Options', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_count_divider',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Count Padding', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_item_padding',
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'output' => array( '.electron-summary-item.electron-viewed-offer-time .electron-coming-time .time-count' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_item_border',
                    'type' => 'border',
                    'output' => array( '.electron-summary-item.electron-viewed-offer-time .electron-coming-time .time-count' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_item_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-summary-item.electron-viewed-offer-time .electron-coming-time .time-count' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Typography', 'electron' ),
                    'id' => 'product_countdown_item_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'text-decoration' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-summary-item.electron-viewed-offer-time .electron-coming-time .time-count' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Separator Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_countdown_count_separator_color',
                    'type' => 'color',
                    'output' => array( '.electron-summary-item.electron-viewed-offer-time .separator' ),
                    'required' => array( 'product_countdown_visibility', '=', '1' )
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Estimated Delivery', 'electron'),
            'id' => 'product_estimated_delivery_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Estimated Delivery', 'electron'),
                    'customizer' => true,
                    'id' => 'estimated_delivery_visibility',
                    'type' => 'switch',
                    'default' => 0
                ),
                array(
                    'title' => esc_html__('Estimated Delivery ( Min )', 'electron'),
                    'customizer' => true,
                    'id' => 'min_estimated_delivery',
                    'type' => 'spinner',
                    'default' => '3',
                    'min' => '1',
                    'step' => '1',
                    'max' => '31',
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Estimated Delivery ( Max )', 'electron'),
                    'customizer' => true,
                    'id' => 'max_estimated_delivery',
                    'type' => 'spinner',
                    'default' => '7',
                    'min' => '1',
                    'step' => '1',
                    'max' => '31',
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Exclude Days', 'electron'),
                    'customizer' => true,
                    'id' => 'estimated_delivery_exclude_days',
                    'type' => 'select',
                    'multi' => true,
                    'sortable' => true,
                    'options' => array(
                        1 => esc_html__( 'Monday', 'electron' ),
                        2 => esc_html__( 'Tuesday', 'electron' ),
                        3 => esc_html__( 'Wednesday', 'electron' ),
                        4 => esc_html__( 'Thursday', 'electron' ),
                        5 => esc_html__( 'Friday', 'electron' ),
                        6 => esc_html__( 'Saturday', 'electron' ),
                        7 => esc_html__( 'Sunday', 'electron' )
                    ),
                    'default' => '',
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Exclude Dates', 'electron'),
                    'desc' => esc_html__('!Important: separate each date with comma.format: 2024-02-15,2025-03-18', 'electron'),
                    'customizer' => true,
                    'id' => 'estimated_delivery_exclude_dates',
                    'type' => 'text',
                    'placeholder' => '2024-02-15,2025-03-18',
                    'default' => '',
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Custom Text', 'electron' ),
                    'desc' => esc_html__( 'Text entered here will be used for Estimated Delivery area', 'electron' ),
                    'customizer' => true,
                    'id' => 'estimated_delivery_text',
                    'type' => 'text',
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Custom SVG Icon HTML', 'electron' ),
                    'desc' => esc_html__( 'Icon entered here will be used for Estimated Delivery area', 'electron' ),
                    'customizer' => true,
                    'id' => 'estimated_delivery_icon',
                    'type' => 'textarea',
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_estimated_delivery_text_color',
                    'type' => 'color',
                    'output' => array( '.electron-estimated-delivery span' ),
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Date Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_estimated_delivery_date_color',
                    'type' => 'color',
                    'output' => array( '.electron-estimated-delivery' ),
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Icon Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_estimated_delivery_svg_color',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-estimated-delivery svg' ),
                    'required' => array( 'estimated_delivery_visibility', '=', '1' )
                ),
            )
        ));
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Visitors Message', 'electron'),
            'id' => 'product_visitiors_message_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Visitors Message', 'electron'),
                    'customizer' => true,
                    'id' => 'product_visitiors_message_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'id' =>'product_visitiors_message_type',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Visitors Message Type', 'electron' ),
                    'subtitle' => esc_html__( 'Select your header background type.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'default' => esc_html__( 'Deafult', 'electron' ),
                        'fake' => esc_html__( 'Fake', 'electron' ),
                    ),
                    'default' => 'default',
                    'required' => array( 'product_visitiors_message_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Fake Visitor Count ( Min )', 'electron'),
                    'customizer' => true,
                    'id' => 'visit_count_min',
                    'type' => 'spinner',
                    'default' => '10',
                    'min' => '1',
                    'step' => '1',
                    'max' => '100',
                    'required' => array(
                    	array( 'product_visitiors_message_visibility', '=', '1' ),
                    	array( 'product_visitiors_message_type', '=', 'fake' )
                    )
                ),
                array(
                    'title' => esc_html__('Fake Visitor Count ( Max )', 'electron'),
                    'customizer' => true,
                    'id' => 'visit_count_max',
                    'type' => 'spinner',
                    'default' => '50',
                    'min' => '1',
                    'step' => '1',
                    'max' => '100',
                    'required' => array(
                    	array( 'product_visitiors_message_visibility', '=', '1' ),
                    	array( 'product_visitiors_message_type', '=', 'fake' )
                    )
                ),
                array(
                    'title' => esc_html__('Fake Visitor Count ( Delay )', 'electron'),
                    'customizer' => true,
                    'id' => 'visit_count_delay',
                    'type' => 'spinner',
                    'default' => '30000',
                    'min' => '1000',
                    'step' => '100',
                    'max' => '100000',
                    'required' => array(
                    	array( 'product_visitiors_message_visibility', '=', '1' ),
                    	array( 'product_visitiors_message_type', '=', 'fake' )
                    )
                ),
                array(
                    'title' => esc_html__('Fake Visitor Count ( Change )', 'electron'),
                    'customizer' => true,
                    'id' => 'visit_count_change',
                    'type' => 'spinner',
                    'default' => '5',
                    'min' => '1',
                    'step' => '1',
                    'max' => '50',
                    'required' => array(
                    	array( 'product_visitiors_message_visibility', '=', '1' ),
                    	array( 'product_visitiors_message_type', '=', 'fake' )
                    )
                ),
                array(
                    'title' => esc_html__( 'Text', 'electron' ),
                    'desc' => esc_html__( 'Text entered here will be used for message area', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_visitiors_message_text2',
                    'type' => 'text',
                    'required' => array( 'product_visitiors_message_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Text Typography', 'electron' ),
                    'id' => 'product_visitiors_message_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-visitors-product-message' ),
                    'required' => array( 'product_visitiors_message_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_visitiors_message_textcolor2',
                    'type' => 'color',
                    'output' => array( '.electron-visitors-product-message' ),
                    'required' => array( 'product_visitiors_message_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_visitiors_message_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-visitors-product-message' ),
                    'required' => array( 'product_visitiors_message_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Border Color', 'electron'),
                    'customizer' => true,
                    'id' => 'product_visitiors_message_brdcolor',
                    'type' => 'color',
                    'mode' => 'border-color',
                    'output' => array( '.electron-visitors-product-message' ),
                    'required' => array( 'product_visitiors_message_visibility', '=', '1' )
                )
            )
        ));
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Product Trusted Image', 'electron'),
            'id' => 'product_trust_image_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Trusted Image', 'electron'),
                    'customizer' => true,
                    'id' => 'product_trust_image_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__( 'Custom Elementor Template', 'electron' ),
                    'subtitle' => esc_html__( 'Select an elementor template from list', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_trust_image_elementor_template',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args
                ),
                array(
                    'title' => esc_html__( 'Image', 'electron' ),
                    'subtitle' => esc_html__( 'Upload your image', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_trust_image',
                    'type' => 'media',
                    'url' => true,
                    'required' => array( 'product_trust_image_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Image Size', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_trust_image_size',
                    'type' => 'select',
                    'data' => 'image_sizes',
                    'required' => array( 'product_trust_image_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Text', 'electron' ),
                    'desc' => esc_html__( 'Text entered here will be used for trust area', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_trust_image_text',
                    'type' => 'editor',
                    'args' => array(
                        'teeny' => false,
                        'textarea_rows' => 10
                    ),
                    'required' => array( 'product_trust_image_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Text Typography', 'electron' ),
                    'id' => 'product_trust_image_text_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-trust-badge-text' ),
                    'required' => array( 'product_trust_image_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Category(s) Exclude', 'electron' ),
                    'subtitle' => esc_html__( 'Select category(s) from the list.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_trust_category_exclude',
                    'type' => 'select',
                    'data' => 'terms',
                    'multi' => true,
                    'args'  => [
                        'taxonomies' => array( 'product_cat' ),
                    ],
                    'required' => array( 'product_trust_image_visibility', '=', '1' )
                ),
            )
        ));
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Tabs', 'electron'),
            'id' => 'product_tabs_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Tabs Display', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_tabs_visibility',
                    'type' => 'switch',
                    'default' => 1,
                    'on' => esc_html__( 'On', 'electron' ),
                    'off' => esc_html__( 'Off', 'electron' )
                ),
                array(
                    'id' =>'product_tabs_type',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Tabs Type', 'electron' ),
                    'options' => array(
                        'tabs' => esc_html__( 'Default Tabs', 'electron' ),
                        'accordion' => esc_html__( 'Accordion', 'electron' )
                    ),
                    'default' => 'tabs',
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Description Tab', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_hide_description_tab',
                    'type' => 'switch',
                    'default' => 1,
                    'on' => esc_html__( 'Show', 'electron' ),
                    'off' => esc_html__( 'Hide', 'electron' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Hide Additional Information Tab', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_hide_additional_tab',
                    'type' => 'switch',
                    'default' => 1,
                    'on' => esc_html__( 'Show', 'electron' ),
                    'off' => esc_html__( 'Hide', 'electron' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Hide Q & A Tab', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_hide_crqna_tab',
                    'type' => 'switch',
                    'default' => 1,
                    'on' => esc_html__( 'Show', 'electron' ),
                    'off' => esc_html__( 'Hide', 'electron' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Hide Reviews Tab', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_hide_reviews_tab',
                    'type' => 'switch',
                    'default' => 1,
                    'on' => esc_html__( 'Show', 'electron' ),
                    'off' => esc_html__( 'Hide', 'electron' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Custom Order', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_tabs_custom_order',
                    'type' => 'switch',
                    'default' => 0,
                    'on' => esc_html__( 'Yes', 'electron' ),
                    'off' => esc_html__( 'No', 'electron' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'id' =>'product_tabs_order',
                    'type' => 'sorter',
                    'title' => esc_html__( 'Tabs Layouts Manager', 'electron' ),
                    'options' => array(
                        'show' => array(
                            'description' => esc_html__( 'Description', 'electron' ),
                            'additional_information' => esc_html__( 'Additional Information', 'electron' ),
                            'reviews' => esc_html__( 'Reviews', 'electron' ),
                            'cr_qna' => esc_html__( 'Q & A', 'electron' )
                        ),
                        'hide' => array()
                    ),
                    'required' => array(
                        array( 'product_tabs_visibility', '=', '1' ),
                        array( 'product_tabs_custom_order', '=', '1' )
                    )
                ),
                array(
                    'id' =>'product_tabs_active_tab',
                    'type' => 'button_set',
                    'title' => esc_html__( 'Active Tab', 'electron' ),
                    'options' => array(
                        '' => esc_html__( 'None', 'electron' ),
                        'all' => esc_html__( 'All Tabs', 'electron' ),
                        ':first-child' => esc_html__( '1. Tab', 'electron' ),
                        ':nth-child(2)' => esc_html__( '2. Tab', 'electron' ),
                        ':nth-child(3)' => esc_html__( '3. Tab', 'electron' ),
                        ':nth-child(4)' => esc_html__( '4. Tab', 'electron' ),
                        ':nth-child(5)' => esc_html__( '5. Tab', 'electron' ),
                        ':nth-child(6)' => esc_html__( '6. Tab', 'electron' )
                    ),
                    'default' => '',
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Description Tab Content Title Display', 'electron'),
                    'customizer' => true,
                    'id' => 'product_description_tab_title_visibility',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Description Tab Content Title', 'electron'),
                    'customizer' => true,
                    'id' => 'product_description_tab_title',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'product_tabs_visibility', '=', '1' ),
                        array( 'product_description_tab_title_visibility', '=', '1' ),
                    )
                ),
                array(
                    'id' => 'electron_product_accordion_start',
                    'title' => esc_html__('Tabs Color Options', 'electron'),
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Title Color', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_accordion_titlecolor',
                    'type' => 'color',
                    'output' => array( '.electron-accordion-header,.electron-product-tabs-wrapper .electron-product-tab-title-item' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Title Color ( Active )', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_accordion_active_titlecolor',
                    'type' => 'color',
                    'output' => array( '.electron-accordion-item.active .electron-accordion-header,.electron-product-tabs-wrapper .electron-product-tab-title-item.active' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Title Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_accordion_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-accordion-item,.electron-product-tabs-wrapper .electron-product-tab-title-item' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Title Background Color ( Active )', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_accordion_active_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-accordion-item.active .electron-accordion-header,.electron-product-tabs-wrapper .electron-product-tab-title-item.active' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Content Text Color', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_accordion_textcolor',
                    'type' => 'color',
                    'output' => array( '.electron-accordion-body,.electron-product-tabs-wrapper .electron-product-tab-content-item' ),
                    'required' => array( 'product_tabs_visibility', '=', '1' )
                ),
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Reviews Section', 'electron'),
            'id' => 'product_reviews_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Reviews Section', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_review_visibility',
                    'type' => 'switch',
                    'default' => 1
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Related Products', 'electron'),
            'id' => 'product_related_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Related Section', 'electron'),
                    'customizer' => true,
                    'id' => 'product_ralated_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Related Title', 'electron'),
                    'subtitle' => esc_html__('Add your single shop page related section title here.', 'electron'),
                    'customizer' => true,
                    'id' => 'product_related_title',
                    'type' => 'text',
                    'default' => '',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Title Tag', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_title_tag',
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Select type', 'electron' ),
                        'h1' => esc_html__( 'H1', 'electron' ),
                        'h2' => esc_html__( 'H2', 'electron' ),
                        'h3' => esc_html__( 'H3', 'electron' ),
                        'h4' => esc_html__( 'H4', 'electron' ),
                        'h5' => esc_html__( 'H5', 'electron' ),
                        'h6' => esc_html__( 'H6', 'electron' ),
                        'p' => esc_html__( 'p', 'electron' ),
                        'div' => esc_html__( 'div', 'electron' ),
                        'span' => esc_html__( 'span', 'electron' )
                    ),
                    'default' => 'h4',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Title Typography', 'electron' ),
                    'id' => 'product_related_title_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.electron-product-related .electron-section .section-title' ),
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Post Count ( Per Page )', 'electron'),
                    'subtitle' => esc_html__('You can control show related post count with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'product_related_count',
                    'type' => 'slider',
                    'default' => 10,
                    'min' => 1,
                    'step' => 1,
                    'max' => 24,
                    'display_value' => 'text',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'id' => 'shop_related_section_slider_start',
                    'type' => 'section',
                    'title' => esc_html__('Related Slider Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 1024px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_perview',
                    'type' => 'slider',
                    'default' => 4,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 768px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_mdperview',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 480px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_smperview',
                    'type' => 'slider',
                    'default' => 2,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Speed', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_speed',
                    'type' => 'slider',
                    'default' => 1000,
                    'min' => 100,
                    'step' => 1,
                    'max' => 10000,
                    'display_value' => 'text',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Gap', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_gap',
                    'type' => 'slider',
                    'default' => 30,
                    'min' => 0,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Autoplay', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_autoplay',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Loop', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_loop',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Mousewheel', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_mousewheel',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Free Mode', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_related_freemode',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'id' => 'shop_related_section_slider_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Upsells Product', 'electron'),
            'id' => 'product_upsells_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Upsells Title', 'electron'),
                    'subtitle' => esc_html__('Add your single shop page upsells section title here.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_upsells_title',
                    'type' => 'text',
                    'default' => ''
                ),
                array(
                    'title' => esc_html__( 'Title Tag', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_title_tag',
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Select type', 'electron' ),
                        'h1' => esc_html__( 'H1', 'electron' ),
                        'h2' => esc_html__( 'H2', 'electron' ),
                        'h3' => esc_html__( 'H3', 'electron' ),
                        'h4' => esc_html__( 'H4', 'electron' ),
                        'h5' => esc_html__( 'H5', 'electron' ),
                        'h6' => esc_html__( 'H6', 'electron' ),
                        'p' => esc_html__( 'p', 'electron' ),
                        'div' => esc_html__( 'div', 'electron' ),
                        'span' => esc_html__( 'span', 'electron' )
                    ),
                    'default' => 'h4',
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Title Typography', 'electron' ),
                    'id' => 'shop_upsells_title_typo',
                    'type' => 'typography',
                    'font-backup' => false,
                    'letter-spacing' => true,
                    'text-transform' => true,
                    'all_styles' => true,
                    'output' => array( '.up-sells .section-title' ),
                    'required' => array( 'product_ralated_visibility', '=', '1' )
                ),
                array(
                    'id' =>'shop_upsells_type',
                    'type' => 'button_set',
                    'title' => esc_html__('Upsells Layout Type', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop product page upsells.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'slider' => esc_html__( 'Slider', 'electron' ),
                        'grid' => esc_html__( 'Grid', 'electron' )
                    ),
                    'default' => 'slider'
                ),
                array(
                    'title' => esc_html__('Post Column', 'electron'),
                    'subtitle' => esc_html__('You can control upsells post column with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_upsells_colxl',
                    'type' => 'slider',
                    'default' => 4,
                    'min' => 1,
                    'step' => 1,
                    'max' => 6,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'grid' )
                ),
                array(
                    'title' => esc_html__('Post Column ( Desktop/Tablet )', 'electron'),
                    'subtitle' => esc_html__('You can control upsells post column for tablet device with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_upsells_collg',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 4,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'grid' )
                ),
                array(
                    'title' => esc_html__('Post Column ( Tablet )', 'electron'),
                    'subtitle' => esc_html__('You can control upsells post column for phone device with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_upsells_colsm',
                    'type' => 'slider',
                    'default' => 1,
                    'min' => 1,
                    'step' => 1,
                    'max' => 3,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'grid' )
                ),
                array(
                    'title' => esc_html__('Post Column ( Phone )', 'electron'),
                    'subtitle' => esc_html__('You can control upsells post column for phone device with this option.', 'electron'),
                    'customizer' => true,
                    'id' => 'shop_upsells_colxs',
                    'type' => 'slider',
                    'default' => 1,
                    'min' => 1,
                    'step' => 1,
                    'max' => 3,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'grid' )
                ),
                array(
                    'id' => 'shop_upsells_section_slider_start',
                    'type' => 'section',
                    'title' => esc_html__('Related Slider Options', 'electron'),
                    'customizer' => true,
                    'indent' => true,
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 1024px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_perview',
                    'type' => 'slider',
                    'default' => 4,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 768px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_mdperview',
                    'type' => 'slider',
                    'default' => 3,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Perview ( Min 480px )', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_smperview',
                    'type' => 'slider',
                    'default' => 2,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Speed', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_speed',
                    'type' => 'slider',
                    'default' => 1000,
                    'min' => 100,
                    'step' => 1,
                    'max' => 10000,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Gap', 'electron' ),
                    'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_gap',
                    'type' => 'slider',
                    'default' => 30,
                    'min' => 0,
                    'step' => 1,
                    'max' => 100,
                    'display_value' => 'text',
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Autoplay', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_autoplay',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Loop', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_loop',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Mousewheel', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_mousewheel',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'title' => esc_html__( 'Free Mode', 'electron' ),
                    'customizer' => true,
                    'id' => 'shop_upsells_freemode',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                ),
                array(
                    'id' => 'shop_upsells_section_slider_end',
                    'type' => 'section',
                    'customizer' => true,
                    'indent' => false,
                    'required' => array( 'shop_upsells_type', '=', 'slider' )
                )
            )
        ));
        // SINGLE CONTENT SUBSECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Share Buttons', 'electron'),
            'id' => 'product_share_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Products share', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__( 'Share type', 'electron' ),
                    'subtitle' => esc_html__( 'Select your product share type.', 'electron' ),
                    'customizer' => true,
                    'id' => 'single_shop_share_type',
                    'type' => 'select',
                    'multi' => false,
                    'options' => array(
                        'share' => esc_html__( 'Share', 'electron' ),
                        'follow' => esc_html__( 'follow', 'electron' )
                    ),
                    'default' => 'share',
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Color type', 'electron' ),
                    'subtitle' => esc_html__( 'Select your product share type.', 'electron' ),
                    'customizer' => true,
                    'id' => 'single_shop_share_color_type',
                    'type' => 'select',
                    'multi' => false,
                    'options' => array(
                        'official' => esc_html__( 'Official', 'electron' ),
                        'custom' => esc_html__( 'Custom', 'electron' )
                    ),
                    'default' => 'official',
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Shape type', 'electron' ),
                    'subtitle' => esc_html__( 'Select your product share type.', 'electron' ),
                    'customizer' => true,
                    'id' => 'single_shop_share_shape_type',
                    'type' => 'select',
                    'multi' => false,
                    'options' => array(
                        'square' => esc_html__( 'Square', 'electron' ),
                        'circle' => esc_html__( 'Circle', 'electron' ),
                        'round' => esc_html__( 'Round', 'electron' )
                    ),
                    'default' => 'circle',
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Share Customize Options', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_customize_divider',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-brush',
                    'notice' => true,
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Share Label Color', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_label_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-social-icons span.share-title' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__( 'Size', 'electron' ),
                    'customizer' => true,
                    'id' => 'single_shop_share_size',
                    'type' => 'dimensions',
                    'output' => array('.electron-product-summary .electron-social-icons a'),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-social-icons a' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Background Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-social-icons a' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Color', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-social-icons a' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Color ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_hvrcolor',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-social-icons a:hover' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Border', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_brd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-product-summary .electron-social-icons a'),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Border ( Hover )', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_hvrbrd',
                    'type' => 'border',
                    'all' => true,
                    'output' => array('.electron-product-summary .electron-social-icons a:hover'),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Hint Background Color', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_hint_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-product-summary .electron-social-icons a:after' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Hint Arrow Color ', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_hint_arrow_color',
                    'type' => 'color',
                    'mode' => 'border-top-color',
                    'output' => array( '.electron-product-summary .electron-social-icons a:before' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Hint Text Color ', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_hint_text_color',
                    'type' => 'color',
                    'output' => array( '.electron-product-summary .electron-social-icons a:after' ),
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Share Icons Options', 'electron'),
                    'customizer' => true,
                    'id' => 'single_shop_share_icons_divider',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-cog',
                    'notice' => true,
                    'required' => array( 'single_shop_share_color_type', '=', 'custom' )
                ),
                array(
                    'title' => esc_html__('Facebook', 'electron'),
                    'customizer' => true,
                    'id' => 'share_facebook',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Facebook link', 'electron'),
                    'customizer' => true,
                    'id' => 'facebook_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_facebook', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Twitter', 'electron'),
                    'customizer' => true,
                    'id' => 'share_twitter',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Twitter link', 'electron'),
                    'customizer' => true,
                    'id' => 'twitter_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_twitter', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Instagram', 'electron'),
                    'customizer' => true,
                    'id' => 'share_instagram',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Instagram link', 'electron'),
                    'customizer' => true,
                    'id' => 'instagram_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_instagram', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Youtube', 'electron'),
                    'customizer' => true,
                    'id' => 'share_youtube',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Youtube link', 'electron'),
                    'customizer' => true,
                    'id' => 'youtube_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_youtube', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Vimeo', 'electron'),
                    'customizer' => true,
                    'id' => 'share_vimeo',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Vimeo link', 'electron'),
                    'customizer' => true,
                    'id' => 'vimeo_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_vimeo', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Pinterest', 'electron'),
                    'customizer' => true,
                    'id' => 'share_pinterest',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Pinterest link', 'electron'),
                    'customizer' => true,
                    'id' => 'pinterest_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_pinterest', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Linkedin', 'electron'),
                    'customizer' => true,
                    'id' => 'share_linkedin',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Linkedin link', 'electron'),
                    'customizer' => true,
                    'id' => 'linkedin_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_linkedin', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Tumblr', 'electron'),
                    'customizer' => true,
                    'id' => 'share_tumblr',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Tumblr link', 'electron'),
                    'customizer' => true,
                    'id' => 'tumblr_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_tumblr', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Flickr', 'electron'),
                    'customizer' => true,
                    'id' => 'share_flickr',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Flickr link', 'electron'),
                    'customizer' => true,
                    'id' => 'flickr_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_flickr', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Github', 'electron'),
                    'customizer' => true,
                    'id' => 'share_github',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Github link', 'electron'),
                    'customizer' => true,
                    'id' => 'github_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_github', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Behance', 'electron'),
                    'customizer' => true,
                    'id' => 'share_behance',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Behance link', 'electron'),
                    'customizer' => true,
                    'id' => 'behance_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_behance', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Dribbble', 'electron'),
                    'customizer' => true,
                    'id' => 'share_dribbble',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Dribbble link', 'electron'),
                    'customizer' => true,
                    'id' => 'dribbble_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_dribbble', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Soundcloud', 'electron'),
                    'customizer' => true,
                    'id' => 'share_soundcloud',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Soundcloud link', 'electron'),
                    'customizer' => true,
                    'id' => 'soundcloud_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_soundcloud', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Spotify', 'electron'),
                    'customizer' => true,
                    'id' => 'share_spotify',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Spotify link', 'electron'),
                    'customizer' => true,
                    'id' => 'spotify_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_spotify', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Ok', 'electron'),
                    'customizer' => true,
                    'id' => 'share_ok',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Ok link', 'electron'),
                    'customizer' => true,
                    'id' => 'ok_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_ok', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Whatsapp', 'electron'),
                    'customizer' => true,
                    'id' => 'share_whatsapp',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Whatsapp link', 'electron'),
                    'customizer' => true,
                    'id' => 'whatsapp_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_whatsapp', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Telegram', 'electron'),
                    'customizer' => true,
                    'id' => 'share_telegram',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Telegram link', 'electron'),
                    'customizer' => true,
                    'id' => 'telegram_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_telegram', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Viber', 'electron'),
                    'customizer' => true,
                    'id' => 'share_viber',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'share' )
                    )
                ),
                array(
                    'title' => esc_html__('Viber link', 'electron'),
                    'customizer' => true,
                    'id' => 'viber_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'share' ),
                        array( 'share_viber', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Tiktok', 'electron'),
                    'customizer' => true,
                    'id' => 'share_tiktok',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Tiktok link', 'electron'),
                    'customizer' => true,
                    'id' => 'tiktok_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_tiktok', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Snapchat', 'electron'),
                    'customizer' => true,
                    'id' => 'share_snapchat',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' )
                    )
                ),
                array(
                    'title' => esc_html__('Snapchat link', 'electron'),
                    'customizer' => true,
                    'id' => 'snapchat_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'single_shop_share_type', '=', 'follow' ),
                        array( 'share_snapchat', '=', '1' ),
                    )
                ),
                array(
                    'title' => esc_html__('Vk', 'electron'),
                    'customizer' => true,
                    'id' => 'share_vk',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'single_shop_share_visibility', '=', '1' ),
                ),
                array(
                    'title' => esc_html__('Vk link', 'electron'),
                    'customizer' => true,
                    'id' => 'vk_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array(
                        array( 'single_shop_share_visibility', '=', '1' ),
                        array( 'share_vk', '=', '1' ),
                    )
                ),
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Bottom Popup Cart on Scroll', 'electron'),
            'id' => 'product_bottom_popup_cart_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Bottom Popup Cart on Scroll', 'electron'),
                    'customizer' => true,
                    'id' => 'product_bottom_cart',
                    'type' => 'switch',
                    'default' => 1
                )
            )
        ));
        // SHOP PAGE SECTION
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('Elementor Templates', 'electron'),
            'id' => 'product_elementor_templates_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Before Footer', 'electron' ),
                    'subtitle' => esc_html__( 'Select an elementor template from list', 'electron' ),
                    'customizer' => true,
                    'id' => 'product_before_footer_template',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => $el_args
                ),
            )
        ));
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('CART', 'electron'),
            'id' => 'shop_cart_page_section',
            'subsection' => false,
            'icon' => 'el el-shopping-cart-sign'
        ));
        //Minicart Panel
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'Minicart Panel', 'electron' ),
            'desc' => esc_html__( 'Cart', 'electron' ),
            'id' => 'minicart_panel_subsection',
            'subsection' => true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__( 'Minicart Panel Display', 'electron' ),
                    'subtitle' => esc_html__( 'You can disable right panel ( mini cart )', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_visibility',
                    'type' => 'switch',
                    'customizer' => true,
                    'default' => 1
                ),
                array(
                    'title' => esc_html__( 'Minicart Display Type', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_type',
                    'type' => 'button_set',
                    'options' => array(
                        'icon' => esc_html__( 'On Hover Cart Icon', 'electron' ),
                        'panel' => esc_html__( 'Side panel', 'electron' ),
                        'popup' => esc_html__( 'Popup Cart', 'electron' ),
                    ),
                    'default' => 'icon',
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Popup Minicart Style', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_popup_style',
                    'type' => 'button_set',
                    'options' => array(
                        'style1' => esc_html__( 'Style 1', 'electron' ),
                        'style2' => esc_html__( 'Style 2', 'electron' ),
                    ),
                    'default' => 'style1',
                    'required' => array( 'minicart_type', '=', 'popup' )
                ),
                array(
                    'title' => esc_html__( 'Popup Cart Upsell Products Display', 'electron' ),
                    'subtitle' => esc_html__( 'You can show popup cart upsells products when a product is added to the cart', 'electron' ),
                    'customizer' => true,
                    'id' => 'popupcart_upsells_visibility',
                    'type' => 'switch',
                    'customizer' => true,
                    'default' => 1,
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'minicart_type', '=', 'popup' ),
                    )
                ),
                array(
                    'title' => esc_html__( 'Minicart Panel Auto-Open', 'electron' ),
                    'subtitle' => esc_html__( 'You can disable automatic opening of the right panel( mini cart ) when a product is added to the cart', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_auto_open',
                    'type' => 'switch',
                    'customizer' => true,
                    'default' => 1,
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'minicart_type', '=', 'panel' ),
                    )
                ),
                array(
                    'title' => esc_html__( 'Minicart Cart Quantity', 'electron' ),
                    'subtitle' => esc_html__( 'You can disable cart quantity from minicart', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_quantity_visibility',
                    'type' => 'switch',
                    'customizer' => true,
                    'default' => 1,
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'minicart_type', '!=', 'icon' ),
                    )
                ),
                array(
                    'title' => esc_html__( 'Minicart Cart Clear All button', 'electron' ),
                    'subtitle' => esc_html__( 'You can disable cart clear button from minicart', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_clearbtn_visibility',
                    'type' => 'switch',
                    'customizer' => true,
                    'default' => 1,
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'minicart_type', '=', 'panel' ),
                    )
                ),
                array(
                    'title' => esc_html__('Minicart Total Display', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_total_visibility',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Minicart SKU Display', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_sku_visibility',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Minicart Coupons Display', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_coupon_visibility',
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'minicart_type', '=', 'icon' ),
                    )
                ),
                array(
                    'title' => esc_html__('Minicart Custom Shop Link', 'electron'),
                    'customizer' => true,
                    'id' => 'minicart_cart_shop_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Minicart Custom Privacy Link', 'electron'),
                    'customizer' => true,
                    'id' => 'minicart_cart_privacy_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Minicart Custom Checkout Link', 'electron'),
                    'customizer' => true,
                    'id' => 'minicart_cart_checkout_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__('Minicart Custom Cart Link', 'electron'),
                    'customizer' => true,
                    'id' => 'minicart_cart_cart_link',
                    'type' => 'text',
                    'default' => '',
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Panel Customize', 'electron' ),
                    'indent' => false,
                    'id' => 'minicart_cart_customize_divide',
                    'type' => 'info',
                    'style' => 'success',
                    'color' => '#000',
                    'icon' => 'el el-cog',
                    'notice' => true,
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Panel Background Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_bgcolor',
                    'type' => 'color',
                    'mode' => 'Background-color',
                    'output' => array( '.electron-side-panel' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Panel Header Border Bottom Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_header_brdcolor',
                    'type' => 'color',
                    'mode' => 'border-bottom-color',
                    'output' => array( '.electron-side-panel .panel-header' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Panel Header Close Background Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_close_icon_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .panel-header .panel-close' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Panel Header Close Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_close_icon_color',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .panel-header .panel-close:before,.electron-side-panel .panel-header .panel-close:after' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Panel Title Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_panel_title_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .panel-header-title' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Panel Title Border Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_panel_title_brdcolor',
                    'type' => 'color',
                    'mode' => 'border-bottom-color',
                    'output' => array( '.electron-side-panel .panel-header' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Cart Item Title Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_title_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .cart-name' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Cart Item Price Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_price_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .electron-price' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Cart Item Quantity Background Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_qty_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .quantity' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Cart Item Quantity,Plus,Minus Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_qty_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .quantity-button.plus,.electron-side-panel .quantity-button.minus,.electron-side-panel .input-text::-webkit-input-placeholder,.electron-side-panel .input-text'),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Cart Item Quantity Plus Minus Backgroud Color ( Hover )', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_qty_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .quantity-button.plus:hover,.electron-side-panel .quantity-button.minus:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Add to Cart Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_addtocart_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .electron-btn-text"' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Add to Cart Color ( Hover )', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_addtocart_hvrcolor',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .electron-btn-text:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Clear Button Color ', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_clearbtn_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .electron_clear_cart_button:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Clear Button Color ( Hover )', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_clearbtn_hvrcolor',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .electron_clear_cart_button:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Clear Button Background Color ', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_clearbtn_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .electron_clear_cart_button:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Clear Button Color ( Hover )', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_clearbtn_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .electron_clear_cart_button:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Subtotal Border Top Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_item_subtotal_brdcolor',
                    'type' => 'color',
                    'mode' => 'border-top-color',
                    'output' => array( '.electron-side-panel .cart-area .cart-total-price' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Subtotal Title Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_subtotal_color',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .cart-area .cart-total-price' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Subtotal Price Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_subtotal_price_color',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .cart-total-price .cart-total-price-right' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Delete Icon Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_delete_icon_color',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-side-panel .del-icon a svg' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Buttons Background Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_footer_buttons_bgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .cart-bottom-btn .electron-btn' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Buttons Background Color ( Hover )', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_footer_buttons_hvrbgcolor',
                    'type' => 'color',
                    'mode' => 'background-color',
                    'output' => array( '.electron-side-panel .cart-bottom-btn .electron-btn:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Buttons Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_footer_buttons_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .cart-bottom-btn .electron-btn' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Buttons Color ( Hover )', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_footer_buttons_hvrcolor',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .cart-bottom-btn .electron-btn:hover' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Empty Cart Icon Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_empty_svg_color',
                    'type' => 'color',
                    'mode' => 'fill',
                    'output' => array( '.electron-side-panel .panel-content svg' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                ),
                array(
                    'title' => esc_html__( 'Empty Cart Text Color', 'electron' ),
                    'customizer' => true,
                    'id' => 'minicart_cart_empty_text_color',
                    'type' => 'color',
                    'mode' => 'color',
                    'output' => array( '.electron-side-panel .electron-small-title' ),
                    'required' => array( 'minicart_visibility', '=', '1' )
                )
            )
        ));
        // Free Shipping Progressbar
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'Minicart Limited Timer', 'electron' ),
            'id' => 'cart_limited_timer_subsection',
            'subsection'=> true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Minicart Limited Timer Display', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_limited_timer_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Time', 'electron'),
                    'subtitle' => sprintf('%s <code>5m = 300</code>',esc_html__('Please enter the time in miliseconds for example: ', 'electron')),
                    'customizer' => true,
                    'validate' => array( 'numeric', 'not_empty' ),
                    'id' => 'cart_limited_timer_date',
                    'type' => 'text',
                    'default' => 300,
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'cart_limited_timer_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Initial Message', 'electron'),
                    'subtitle' => esc_html__('Please enter the date for limited time in this field.', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_limited_timer_message_initial',
                    'type' => 'textarea',
                    'default' => 'These products are limited, checkout within',
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'cart_limited_timer_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Expired Message', 'electron'),
                    'subtitle' => esc_html__('Please enter the expired message in this field.', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_limited_timer_message_expired',
                    'type' => 'textarea',
                    'default' => 'Congrats! You are eligible for more to enjoy FREE Shipping',
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'cart_limited_timer_visibility', '=', '1' )
                    )
                ),
                array(
                    'title' => esc_html__('Restart Limited Timer After Expired', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_limited_timer_restart',
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array(
                        array( 'minicart_visibility', '=', '1' ),
                        array( 'cart_limited_timer_visibility', '=', '1' )
                    )
                )
            )
        ));
        // Free Shipping Progressbar
        Redux::setSection($electron_pre, array(
            'title' => esc_html__( 'Minicart Shipping Progressbar', 'electron' ),
            'id' => 'shipping_progressbar_subsection',
            'subsection'=> true,
            'icon' => 'fa fa-cog',
            'fields' => array(
                array(
                    'title' => esc_html__('Progressbar Display', 'electron'),
                    'subtitle' => esc_html__('You can enable or disable the site shop free shipping progressbar with switch option.', 'electron'),
                    'customizer' => true,
                    'id' => 'free_shipping_progressbar_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Minicart Progressbar Display', 'electron'),
                    'subtitle' => esc_html__('You can enable or disable the site shop free shipping progressbar with switch option.', 'electron'),
                    'customizer' => true,
                    'id' => 'minicart_free_shipping_progressbar_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Cart Page Progressbar Display', 'electron'),
                    'subtitle' => esc_html__('You can enable or disable the site shop free shipping progressbar with switch option.', 'electron'),
                    'customizer' => true,
                    'id' => 'cart_free_shipping_progressbar_visibility',
                    'type' => 'switch',
                    'default' => 1
                ),
                array(
                    'title' => esc_html__('Targeted Amount', 'electron'),
                    'subtitle' => esc_html__('Please enter the targeted amount without currency for free shipping in this field.', 'electron'),
                    'customizer' => true,
                    'id' => 'free_shipping_progressbar_amount',
                    'validate' => array( 'numeric', 'not_empty' ),
                    'type' => 'text',
                    'default' => 500
                ),
                array(
                    'title' => esc_html__('Initial Message', 'electron'),
                    'subtitle' => sprintf('%s <code>[remainder]</code> %s',
                    	esc_html__('Please enter the initial message with', 'electron'),
                    	esc_html__('for free shipping in this field.', 'electron')
                    ),
                    'customizer' => true,
                    'id' => 'free_shipping_progressbar_message_initial',
                    'type' => 'textarea',
                    'default' => 'Buy [remainder] more to enjoy FREE Shipping'
                ),
                array(
                    'title' => esc_html__('Success Message', 'electron'),
                    'subtitle' => esc_html__('Please enter the success message with for free shipping in this field.', 'electron'),
                    'customizer' => true,
                    'id' => 'free_shipping_progressbar_message_success',
                    'type' => 'textarea',
                    'default' => 'Congrats! You are eligible for more to enjoy FREE Shipping'
                ),
            )
        ));
        $myaccount_fields = array();
        $myaccount_fields[] = array(
            'id' =>'myaccount_page_type',
            'type' => 'button_set',
            'title' => esc_html__('My Account Page Type', 'electron'),
            'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop account page.', 'electron' ),
            'customizer' => true,
            'options' => array(
                'default' => esc_html__( 'Default', 'electron' ),
                'multisteps' => esc_html__( 'Multi Steps', 'electron' ),
            ),
            'default' => 'default'
        );
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('MY ACCOUNT PAGE', 'electron'),
            'id' => 'shop_myaccount_page_section',
            'subsection' => false,
            'icon' => 'el el-shopping-cart-sign',
            'fields' => $myaccount_fields
        ));
        Redux::setSection($electron_pre, array(
            'title' => esc_html__('CHECKOUT PAGE', 'electron'),
            'id' => 'shop_checkout_page_section',
            'subsection' => false,
            'icon' => 'el el-shopping-cart-sign',
            'fields' => array(
                array(
                    'id' =>'checkout_enable_multistep',
                    'type' => 'button_set',
                    'title' => esc_html__('Checkout Page Type', 'electron'),
                    'subtitle' => esc_html__( 'Organize how you want the layout to appear on the theme shop checkout page.', 'electron' ),
                    'customizer' => true,
                    'options' => array(
                        'default' => esc_html__( 'Default', 'electron' ),
                        'multisteps' => esc_html__( 'Multi Steps', 'electron' )
                    ),
                    'default' => 'default'
                ),
                array(
                    'id' =>'checkout_form_customize',
                    'type' => 'button_set',
                    'title' => esc_html__('Custom Checkout Form Fields', 'electron'),
                    'subtitle' => esc_html__('If there is a field in the checkout form that you do not want to be, you can use this option.', 'electron'),
                    'customizer' => true,
                    'options' => array(
                        'yes' => esc_html__('Yes', 'electron'),
                        'no' => esc_html__('No', 'electron')
                    ),
                    'default' => 'no'
                ),
                array(
                    'id' =>'checkout_form_layouts',
                    'type' => 'checkbox',
                    'title' => esc_html__('Checkout Form Manager', 'electron'),
                    'subtitle' => esc_html__('Organize how you want the layout to appear on the theme Checkout Form.', 'electron'),
                    'options' => array(
                        'billing_first_name' => esc_html__('First name -Billing Form', 'electron'),
                        'billing_last_name' => esc_html__('Last name -Billing Form', 'electron'),
                        'billing_company' => esc_html__('Company -Billing Form', 'electron'),
                        'billing_address_1' => esc_html__('Address 1 -Billing Form', 'electron'),
                        'billing_address_2' => esc_html__('Address 2 -Billing Form', 'electron'),
                        'billing_city' => esc_html__('City -Billing Form', 'electron'),
                        'billing_postcode' => esc_html__('Postcode -Billing Form', 'electron'),
                        'billing_country' => esc_html__('Country -Billing Form', 'electron'),
                        'billing_state' => esc_html__('State -Billing Form', 'electron'),
                        'billing_phone' => esc_html__('Phone -Billing Form', 'electron'),
                        'billing_email' => esc_html__('Email -Billing Form', 'electron'),
                        'order_comments' => esc_html__('Order comments -Order', 'electron'),
                        'account_username' => esc_html__('Account username -Account', 'electron'),
                        'account_password' => esc_html__('Account password -Account', 'electron'),
                        'account_password-2' => esc_html__('Account password 2 -Account', 'electron'),
                        'shipping_first_name' => esc_html__('First name -Shipping Form', 'electron'),
                        'shipping_last_name' => esc_html__('Last name -Shipping Form', 'electron'),
                        'shipping_company' => esc_html__('Company -Shipping Form', 'electron'),
                        'shipping_address_1' => esc_html__('Address 1 -Shipping Form', 'electron'),
                        'shipping_address_2' => esc_html__('Address 2 -Shipping Form', 'electron'),
                        'shipping_city' => esc_html__('City -Shipping Form', 'electron'),
                        'shipping_postcode' => esc_html__('Postcode -Shipping Form', 'electron'),
                        'shipping_country' => esc_html__('Country -Shipping Form', 'electron'),
                        'shipping_state' => esc_html__('State -Shipping Form', 'electron')
                    ),
                    'default' => array(
                        'billing_first_name' => '1',
                        'billing_last_name' => '1',
                        'billing_company' => '1',
                        'billing_address_1' => '1',
                        'billing_address_2' => '1',
                        'billing_city' => '1',
                        'billing_postcode' => '1',
                        'billing_country' => '1',
                        'billing_state' => '1',
                        'billing_phone' => '1',
                        'billing_email' => '1',
                        'order_comments' => '1',
                        'account_username' => '1',
                        'account_password' => '1',
                        'account_password-2' => '1',
                        'shipping_first_name' => '1',
                        'shipping_last_name' => '1',
                        'shipping_company' => '1',
                        'shipping_address_1' => '1',
                        'shipping_address_2' => '1',
                        'shipping_city' => '1',
                        'shipping_postcode' => '1',
                        'shipping_country' => '1',
                        'shipping_state' => '1'
                    ),
                    'required' => array('checkout_form_customize', '=', 'yes')
                ),
                array(
                    'id' =>'checkout_form_required_fields_layouts',
                    'type' => 'checkbox',
                    'title' => esc_html__('Required Fields', 'electron'),
                    'options' => array(
                        'billing_first_name' => esc_html__('First name -Billing Form', 'electron'),
                        'billing_last_name' => esc_html__('Last name -Billing Form', 'electron'),
                        'billing_company' => esc_html__('Company -Billing Form', 'electron'),
                        'billing_address_1' => esc_html__('Address 1 -Billing Form', 'electron'),
                        'billing_address_2' => esc_html__('Address 2 -Billing Form', 'electron'),
                        'billing_city' => esc_html__('City -Billing Form', 'electron'),
                        'billing_postcode' => esc_html__('Postcode -Billing Form', 'electron'),
                        'billing_country' => esc_html__('Country -Billing Form', 'electron'),
                        'billing_state' => esc_html__('State -Billing Form', 'electron'),
                        'billing_phone' => esc_html__('Phone -Billing Form', 'electron'),
                        'billing_email' => esc_html__('Email -Billing Form', 'electron'),
                        'shipping_first_name' => esc_html__('First name -Shipping Form', 'electron'),
                        'shipping_last_name' => esc_html__('Last name -Shipping Form', 'electron'),
                        'shipping_company' => esc_html__('Company -Shipping Form', 'electron'),
                        'shipping_address_1' => esc_html__('Address 1 -Shipping Form', 'electron'),
                        'shipping_address_2' => esc_html__('Address 2 -Shipping Form', 'electron'),
                        'shipping_city' => esc_html__('City -Shipping Form', 'electron'),
                        'shipping_postcode' => esc_html__('Postcode -Shipping Form', 'electron'),
                        'shipping_country' => esc_html__('Country -Shipping Form', 'electron'),
                        'shipping_state' => esc_html__('State -Shipping Form', 'electron')
                    ),
                    'default' => array(
                        'billing_first_name' => '1',
                        'billing_last_name' => '1',
                        'billing_company' => '0',
                        'billing_address_1' => '1',
                        'billing_address_2' => '0',
                        'billing_city' => '1',
                        'billing_postcode' => '1',
                        'billing_country' => '1',
                        'billing_state' => '1',
                        'billing_phone' => '1',
                        'billing_email' => '1',
                        'shipping_first_name' => '1',
                        'shipping_last_name' => '1',
                        'shipping_company' => '0',
                        'shipping_address_1' => '1',
                        'shipping_address_2' => '0',
                        'shipping_city' => '1',
                        'shipping_postcode' => '1',
                        'shipping_country' => '1',
                        'shipping_state' => '1'
                    ),
                    'required' => array('checkout_form_customize', '=', 'yes')
                )
            )
        ));
    }

    /*************************************************
    ## DEFAULT PAGE SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Default Page', 'electron' ),
        'id' => 'defaultpagesection',
        'icon' => 'el el-home',
    ));
    // BLOG HERO SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Default Page Hero', 'electron' ),
        'desc' => esc_html__( 'These are default page hero settings!', 'electron' ),
        'id' => 'pageherosubsection',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Page Hero Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site default page hero section with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'page_hero_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Page Hero Background', 'electron' ),
                'customizer' => true,
                'id' => 'page_hero_bg',
                'type' => 'background',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-page-container .breadcrumb-bg' ),
                'required' => array( 'blog_hero_visibility', '=', '1' )
            )
        )
    ));
    /*************************************************
    ## BLOG PAGE SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Blog Posts Page', 'electron' ),
        'id' => 'blogsection',
        'icon' => 'el el-home',
    ));
    // BLOG HERO SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Blog Hero', 'electron' ),
        'desc' => esc_html__( 'These are blog index page hero text settings!', 'electron' ),
        'id' => 'blogherosubsection',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Blog Hero Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site blog index page hero section with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'blog_hero_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Blog Hero Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates instead of default template.', 'electron' ),
                'customizer' => true,
                'id' => 'blog_hero_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args
            ),
            array(
                'id' =>'edit_blog_hero_elementor_template',
                'type' => 'info',
                'desc' => 'Select template',
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '!=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Min Height', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'blog_hero_height',
                'type' => 'dimensions',
                'width' => false,
                'output' => array( '#nt-index .electron-page-hero' ),
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Tablet )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'blog_hero_height_tablet',
                'type' => 'dimensions',
                'width' => false,
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Phone )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'blog_hero_height_phone',
                'type' => 'dimensions',
                'width' => false,
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Blog Hero Background', 'electron' ),
                'customizer' => true,
                'id' => 'blog_hero_bg',
                'type' => 'background',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-index .electron-page-hero' ),
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Blog Title', 'electron' ),
                'subtitle' => esc_html__( 'Add your blog index page title here.', 'electron' ),
                'customizer' => true,
                'id' => 'blog_title',
                'type' => 'text',
                'default' => '',
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Blog Title Color', 'electron' ),
                'customizer' => true,
                'id' => 'blog_title_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-index .electron-page-hero .page-title' ),
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Blog Breadcrumbs Color', 'electron' ),
                'customizer' => true,
                'id' => 'blog_bread_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-index .electron-page-hero .electron-breadcrumb li, #nt-index .electron-page-hero .electron-breadcrumb li a' ),
                'required' => array(
                    array( 'blog_hero_visibility', '=', '1' ),
                    array( 'blog_hero_templates', '=', '' )
                )
            )
        )
    ));
    // BLOG LAYOUT AND POST COLUMN STYLE
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Blog Layout', 'electron' ),
        'id' => 'bloglayoutsubsection',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Blog Page Layout', 'electron' ),
                'subtitle' => esc_html__( 'Choose the blog index page layout.', 'electron' ),
                'customizer' => true,
                'id' => 'index_layout',
                'type' => 'image_select',
                'options' => array(
                    'left-sidebar' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cl.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/1col.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cr.png'
                    )
                ),
                'default' => 'right-sidebar'
            ),
            array(
                'title' => esc_html__( 'Container Width', 'electron' ),
                'subtitle' => esc_html__( 'Select blog page container width type.', 'electron' ),
                'customizer' => true,
                'id' => 'index_container_type',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Select type', 'electron' ),
                    'container' => esc_html__( 'Default Boxed', 'electron' ),
                    'container-fluid' => esc_html__( 'Fluid', 'electron' )
                ),
                'default' => 'container'
            )
        )
    ));
    // BLOG LAYOUT AND POST COLUMN STYLE
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Blog Post', 'electron' ),
        'id' => 'blogpostsubsection',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Layout Type', 'electron' ),
                'subtitle' => esc_html__( 'Select blog page layout type.', 'electron' ),
                'customizer' => true,
                'id' => 'index_type',
                'type' => 'select',
                'options' => array(
                    'grid' => esc_html__( 'grid', 'electron' ),
                    'masonry' => esc_html__( 'masonry', 'electron' )
                ),
                'default' => 'masonry',
                'select2' => array('select2' => array( 'allowClear' => false ) )
            ),
            array(
                'title' => esc_html__( 'Post Style', 'electron' ),
                'subtitle' => esc_html__( 'Select blog page post style type.', 'electron' ),
                'customizer' => true,
                'id' => 'post_style',
                'type' => 'select',
                'options' => array(
                    'classic' => esc_html__( 'Classic', 'electron' ),
                    'card' => esc_html__( 'Card', 'electron' ),
                    'split' => esc_html__( 'Split', 'electron' )
                ),
                'default' => 'classic',
                'select2' => array('select2' => array( 'allowClear' => false ) )
            ),
            array(
                'title' => esc_html__( 'Post Image Size Style', 'electron' ),
                'subtitle' => esc_html__( 'Select blog page post image size style type.', 'electron' ),
                'customizer' => true,
                'id' => 'post_image_style',
                'type' => 'select',
                'options' => array(
                    'default' => esc_html__( 'Default', 'electron' ),
                    'fit' => esc_html__( 'Fit', 'electron' ),
                    'split' => esc_html__( 'Split', 'electron' )
                ),
                'default' => 'default',
                'select2' => array('select2' => array( 'allowClear' => false ) )
            ),
            array(
                'title' => esc_html__( 'Post Overlay Color', 'electron' ),
                'customizer' => true,
                'id' => 'post_card_style_overlay_color',
                'type' => 'color_rgba',
                'mode' => 'background-color',
                'output' => array( '.electron-blog-posts-item.style-card .electron-blog-post-item-inner:before' ),
                'required' => array( 'post_style', '=', 'card' )
            ),
            array(
                'title' => esc_html__( 'Post Min Height', 'electron' ),
                'subtitle' => esc_html__( 'Set the blog post card item minimum height.', 'electron' ),
                'customizer' => true,
                'id' => 'post_card_style_height',
                'type' => 'dimensions',
                'width' => false,
                'output' => array('.electron-blog-posts-item.style-card .electron-blog-post-item-inner' ),
                'required' => array( 'post_style', '=', 'card' )
            ),
            array(
                'title' => esc_html__( 'Column Width', 'electron' ),
                'subtitle' => esc_html__( 'Select a column width.', 'electron' ),
                'customizer' => true,
                'id' => 'grid_column',
                'type' => 'select',
                'options' => array(
                    '1' => esc_html__( '1 column', 'electron' ),
                    '2' => esc_html__( '2 column', 'electron' ),
                    '3' => esc_html__( '3 column', 'electron' ),
                    '4' => esc_html__( '4 column', 'electron' )
                ),
                'default' => '3',
                'select2' => array('select2' => array( 'allowClear' => false ) )
            ),
            array(
                'title' => esc_html__( 'Mobile Column Width', 'electron' ),
                'subtitle' => esc_html__( 'Select a column width for mobile device.', 'electron' ),
                'customizer' => true,
                'id' => 'grid_mobile_column',
                'type' => 'select',
                'options' => array(
                    '1' => esc_html__( '1 column', 'electron' ),
                    '2' => esc_html__( '2 column', 'electron' ),
                    '3' => esc_html__( '3 column', 'electron' )
                ),
                'default' => '2',
                'select2' => array('select2' => array( 'allowClear' => false ) )
            ),
            array(
                'title' => esc_html__( 'Post Image Size', 'electron' ),
                'customizer' => true,
                'id' => 'post_imgsize',
                'type' => 'select',
                'data' => 'image_sizes'
            ),
            array(
                'title' => esc_html__( 'Custom Post Image Size', 'electron' ),
                'customizer' => true,
                'id' => 'post_custom_imgsize',
                'unit' => false,
                'type' => 'dimensions'
            ),
            array(
                'title' => esc_html__( 'Post Title Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site blog index page post title with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'post_title_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Excerpt Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site blog index page post meta with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'post_excerpt_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Excerpt Size (max word count)', 'electron' ),
                'subtitle' => esc_html__( 'You can control blog post excerpt size with this option.', 'electron' ),
                'customizer' => true,
                'id' => 'post_excerpt_limit',
                'type' => 'slider',
                'default' => 30,
                'min' => 0,
                'step' => 1,
                'max' => 100,
                'display_value' => 'text',
                'required' => array( 'post_excerpt_visibility', '=', '1' )
            )
        )
    ));

    /*************************************************
    ## SINGLE PAGE SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Single Post Page', 'electron' ),
        'id' => 'singlesection',
        'icon' => 'el el-home-alt',
    ));
    // SINGLE HERO SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Single Hero', 'electron' ),
        'desc' => esc_html__( 'These are single page hero section settings!', 'electron' ),
        'id' => 'singleherosubsection',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Single Hero Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page hero section with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_hero_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates instead of default template.', 'electron' ),
                'customizer' => true,
                'id' => 'single_hero_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array( 'single_hero_visibility', '=', '1' )
            ),
            array(
                'id' =>'edit_single_hero_template',
                'type' => 'info',
                'desc' => 'Select template',
                'required' => array(
                    array( 'single_hero_visibility', '=', '1' ),
                    array( 'single_hero_elementor_templates', '!=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Single Hero Background', 'electron' ),
                'customizer' => true,
                'id' => 'single_hero_bg',
                'type' => 'background',
                'output' => array( '#nt-single .electron-page-hero' ),
                'required' => array(
                    array( 'single_hero_visibility', '=', '1' ),
                    array( 'single_hero_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Min Height', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'single_hero_height',
                'type' => 'dimensions',
                'width' => false,
                'output' => array( '#nt-index .electron-page-hero' ),
                'required' => array(
                    array( 'single_hero_visibility', '=', '1' ),
                    array( 'single_hero_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Tablet )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'single_hero_height_tablet',
                'type' => 'dimensions',
                'width' => false,
                'required' => array(
                    array( 'single_hero_visibility', '=', '1' ),
                    array( 'single_hero_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Phone )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'single_hero_height_phone',
                'type' => 'dimensions',
                'width' => false,
                'required' => array(
                    array( 'single_hero_visibility', '=', '1' ),
                    array( 'single_hero_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Blog Breadcrumbs Color', 'electron' ),
                'customizer' => true,
                'id' => 'single_bread_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-single .electron-page-hero .electron-breadcrumb li, #nt-single .electron-page-hero .electron-breadcrumb li a' ),
                'required' => array(
                    array( 'single_hero_visibility', '=', '1' ),
                    array( 'single_hero_elementor_templates', '=', '' )
                )
            )
        )
    ));
    // SINGLE CONTENT SUBSECTION
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Single Content', 'electron' ),
        'id' => 'singlecontentsubsection',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Post Page Layout', 'electron' ),
                'subtitle' => esc_html__( 'Choose the single post page layout.', 'electron' ),
                'customizer' => true,
                'id' => 'single_layout',
                'type' => 'image_select',
                'options' => array(
                    'left-sidebar' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cl.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/1col.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cr.png'
                    )
                ),
                'default' => 'right-sidebar'
            ),
            array(
                'title' => esc_html__( 'Author Name Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page post date with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_postmeta_author_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Date Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page post date number with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_postmeta_date_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Categories Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page post meta tags with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_postmeta_category_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Tags Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page post meta tags with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_postmeta_tags_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Authorbox Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page post authorbox with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_post_author_box_visibility',
                'type' => 'switch',
                'default' => 0,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Post Pagination Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page post next and prev pagination with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_navigation_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Post Title Color', 'electron' ),
                'customizer' => true,
                'id' => 'single_title_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-single .nt-electron-content .electron-post-title' ),
                'required' => array(
                    array( 'single_hero_visibility', '=', '1' ),
                    array( 'single_hero_elementor_templates', '=', '' )
                )
            ),
        )
    ));
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Single Related Posts', 'electron' ),
        'id' => 'singlerelatedsubsection',
        'subsection' => true,
        'icon' => 'el el-cog',
        'fields' => array(
            array(
                'title' => esc_html__( 'Related Post Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site single page related post with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'single_related_visibility',
                'type' => 'switch',
                'default' => 0,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates instead of default related post template.', 'electron' ),
                'customizer' => true,
                'id' => 'single_related_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array( 'single_related_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Post Style', 'electron' ),
                'subtitle' => esc_html__( 'Select single page related post style type.', 'electron' ),
                'customizer' => true,
                'id' => 'related_post_style',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Select style', 'electron' ),
                    'default' => esc_html__( 'Classic', 'electron' ),
                    'card' => esc_html__( 'Card', 'electron' ),
                    'split' => esc_html__( 'Split', 'electron' )
                ),
                'default' => 'default',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'id' => 'related_section_heading_start',
                'type' => 'section',
                'title' => esc_html__('Related Section Heading', 'electron'),
                'customizer' => true,
                'indent' => true,
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Related Section Subtitle', 'electron' ),
                'subtitle' => esc_html__( 'Add your single page related post section subtitle here.', 'electron' ),
                'customizer' => true,
                'id' => 'related_subtitle',
                'type' => 'text',
                'default' => '',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Subtitle Tag', 'electron' ),
                'customizer' => true,
                'id' => 'related_subtitle_tag',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Select type', 'electron' ),
                    'h1' => esc_html__( 'H1', 'electron' ),
                    'h2' => esc_html__( 'H2', 'electron' ),
                    'h3' => esc_html__( 'H3', 'electron' ),
                    'h4' => esc_html__( 'H4', 'electron' ),
                    'h5' => esc_html__( 'H5', 'electron' ),
                    'h6' => esc_html__( 'H6', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'span' => esc_html__( 'span', 'electron' )
                ),
                'default' => 'p',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' ),
                    array( 'related_subtitle', '!=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Related Section Title', 'electron' ),
                'subtitle' => esc_html__( 'Add your single page related post section title here.', 'electron' ),
                'customizer' => true,
                'id' => 'related_title',
                'type' => 'text',
                'default' => esc_html__( 'Related Post', 'electron' ),
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Title Tag', 'electron' ),
                'customizer' => true,
                'id' => 'related_title_tag',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Select type', 'electron' ),
                    'h1' => esc_html__( 'H1', 'electron' ),
                    'h2' => esc_html__( 'H2', 'electron' ),
                    'h3' => esc_html__( 'H3', 'electron' ),
                    'h4' => esc_html__( 'H4', 'electron' ),
                    'h5' => esc_html__( 'H5', 'electron' ),
                    'h6' => esc_html__( 'H6', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'span' => esc_html__( 'span', 'electron' )
                ),
                'default' => 'h3',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' ),
                    array( 'related_title', '!=', '' )
                )
            ),
            array(
                'id' => 'related_section_heading_end',
                'customizer' => true,
                'type' => 'section',
                'indent' => false,
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'id' => 'related_section_posts_start',
                'type' => 'section',
                'title' => esc_html__('Related Post Options', 'electron'),
                'customizer' => true,
                'indent' => true
            ),
            array(
                'title' => esc_html__( 'Posts Perpage', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post count with this option.', 'electron' ),
                'customizer' => true,
                'id' => 'related_perpage',
                'type' => 'slider',
                'default' => 3,
                'min' => 1,
                'step' => 1,
                'max' => 24,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Post Image Size', 'electron' ),
                'customizer' => true,
                'id' => 'related_imgsize',
                'type' => 'select',
                'data' => 'image_sizes',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Post Excerpt Display', 'electron' ),
                'id' => 'related_excerpt_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Post Excerpt Limit', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post excerpt word limit.', 'electron' ),
                'customizer' => true,
                'id' => 'related_excerpt_limit',
                'type' => 'slider',
                'default' => 30,
                'min' => 0,
                'step' => 1,
                'max' => 100,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' ),
                    array( 'related_excerpt_visibility', '=', '1' )
                )
            ),
            array(
                'id' => 'related_section_posts_end',
                'customizer' => true,
                'type' => 'section',
                'indent' => false,
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'id' => 'related_section_slider_start',
                'type' => 'section',
                'title' => esc_html__('Related Slider Options', 'electron'),
                'customizer' => true,
                'indent' => true,
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Perview ( Min 1200px )', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                'customizer' => true,
                'id' => 'related_perview',
                'type' => 'slider',
                'default' => 5,
                'min' => 1,
                'step' => 1,
                'max' => 10,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Slider Perview ( Min 992px )', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                'customizer' => true,
                'id' => 'related_mdperview',
                'type' => 'slider',
                'default' => 3,
                'min' => 1,
                'step' => 1,
                'max' => 10,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Perview ( Min 768px )', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                'customizer' => true,
                'id' => 'related_smperview',
                'type' => 'slider',
                'default' => 3,
                'min' => 1,
                'step' => 1,
                'max' => 10,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Perview ( Min 480px )', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post slider item count for big device with this option.', 'electron' ),
                'customizer' => true,
                'id' => 'related_xsperview',
                'type' => 'slider',
                'default' => 2,
                'min' => 1,
                'step' => 1,
                'max' => 10,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Speed', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                'customizer' => true,
                'id' => 'related_speed',
                'type' => 'slider',
                'default' => 1000,
                'min' => 100,
                'step' => 1,
                'max' => 10000,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Gap', 'electron' ),
                'subtitle' => esc_html__( 'You can control related post slider item gap.', 'electron' ),
                'customizer' => true,
                'id' => 'related_gap',
                'type' => 'slider',
                'default' => 30,
                'min' => 0,
                'step' => 1,
                'max' => 100,
                'display_value' => 'text',
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Centered', 'electron' ),
                'customizer' => true,
                'id' => 'related_centered',
                'type' => 'switch',
                'default' => 0,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Autoplay', 'electron' ),
                'customizer' => true,
                'id' => 'related_autoplay',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Loop', 'electron' ),
                'customizer' => true,
                'id' => 'related_loop',
                'type' => 'switch',
                'default' => 0,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'title' => esc_html__( 'Mousewheel', 'electron' ),
                'customizer' => true,
                'id' => 'related_mousewheel',
                'type' => 'switch',
                'default' => 0,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            ),
            array(
                'id' => 'related_section_slider_end',
                'customizer' => true,
                'type' => 'section',
                'indent' => false,
                'required' => array(
                    array( 'single_related_visibility', '=', '1' ),
                    array( 'single_related_elementor_templates', '=', '' )
                )
            )
        )
    ));
    /*************************************************
    ## ARCHIVE PAGE SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Archive Page', 'electron' ),
        'id' => 'archivesection',
        'icon' => 'el el-folder-open',
        'fields' => array(
            array(
                'title' => esc_html__( 'Archive Page Layout', 'electron' ),
                'subtitle' => esc_html__( 'Choose the archive page layout.', 'electron' ),
                'customizer' => true,
                'id' => 'archive_layout',
                'type' => 'image_select',
                'options' => array(
                    'left-sidebar' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cl.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/1col.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cr.png'
                    )
                ),
                'default' => 'full-width'
            ),
            array(
                'title' => esc_html__( 'Archive Hero Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site archive page hero section with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'archive_hero_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Min Height', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'archive_hero_height',
                'type' => 'dimensions',
                'width' => false,
                'output' => array( '#nt-archive .electron-page-hero' ),
                'required' => array( 'archive_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Tablet )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'archive_hero_height_tablet',
                'type' => 'dimensions',
                'width' => false,
                'required' => array( 'archive_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Phone )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'archive_hero_height_phone',
                'type' => 'dimensions',
                'width' => false,
                'required' => array( 'archive_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Archive Hero Background', 'electron' ),
                'customizer' => true,
                'id' => 'archive_hero_bg',
                'type' => 'background',
                'output' => array( '#nt-archive .electron-page-hero' ),
                'required' => array( 'archive_hero_visibility', '=', '1' ),
            ),
            array(
                'title' => esc_html__( 'Custom Archive Title', 'electron' ),
                'subtitle' => esc_html__( 'Add your custom archive page title here.', 'electron' ),
                'customizer' => true,
                'id' => 'archive_title',
                'type' => 'text',
                'default' =>'',
                'required' => array( 'archive_hero_visibility', '=', '1' ),
            ),
            array(
                'title' => esc_html__( 'Archive Title Color', 'electron' ),
                'customizer' => true,
                'id' => 'archive_title_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-archive .electron-page-hero .page-title' ),
                'required' => array( 'archive_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Archive Breadcrumbs Color', 'electron' ),
                'customizer' => true,
                'id' => 'archive_bread_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-archive .electron-page-hero .electron-breadcrumb li, #nt-archive .electron-page-hero .electron-breadcrumb li a' ),
                'required' => array( 'archive_hero_visibility', '=', '1' )
            )
        )
    ));
    /*************************************************
    ## SEARCH PAGE SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( 'Search Page', 'electron' ),
        'id' => 'searchsection',
        'icon' => 'el el-search',
        'fields' => array(
            array(
                'title' => esc_html__( 'Search Page Layout', 'electron' ),
                'subtitle' => esc_html__( 'Choose the search page layout.', 'electron' ),
                'customizer' => true,
                'id' => 'search_layout',
                'type' => 'image_select',
                'options' => array(
                    'left-sidebar' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cl.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/1col.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/inc/core/theme-options/img/2cr.png'
                    )
                ),
                'default' => 'full-width'
            ),
            array(
                'title' => esc_html__( 'Search Hero Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site search page hero section with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'search_hero_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' )
            ),
            array(
                'title' => esc_html__( 'Search Hero Background', 'electron' ),
                'customizer' => true,
                'id' =>'search_hero_bg',
                'type' => 'background',
                'output' => array( '#nt-search .electron-page-hero' ),
                'required' => array( 'search_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Min Height', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'search_hero_height',
                'type' => 'dimensions',
                'width' => false,
                'output' => array( '#nt-search .electron-page-hero' ),
                'required' => array( 'search_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Tablet )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'search_hero_height_tablet',
                'type' => 'dimensions',
                'width' => false,
                'required' => array( 'search_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Min Height ( Phone )', 'electron' ),
                'subtitle' => esc_html__( 'You can use this option to control the height.', 'electron' ),
                'customizer' => true,
                'id' => 'search_hero_height_phone',
                'type' => 'dimensions',
                'width' => false,
                'required' => array( 'search_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Search Title Color', 'electron' ),
                'customizer' => true,
                'id' => 'search_title_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-search .electron-page-hero .page-title' ),
                'required' => array( 'search_hero_visibility', '=', '1' )
            ),
            array(
                'title' => esc_html__( 'Search Breadcrumbs Color', 'electron' ),
                'customizer' => true,
                'id' => 'search_bread_clr',
                'type' => 'color',
                'preview' => true,
                'preview_media' => true,
                'output' => array( '#nt-search .electron-page-hero .electron-breadcrumb li, #nt-search .electron-page-hero .electron-breadcrumb li a' ),
                'required' => array( 'search_hero_visibility', '=', '1' )
            )
        )
    ));
    /*************************************************
    ## 404 PAGE SECTION
    *************************************************/
    Redux::setSection($electron_pre, array(
        'title' => esc_html__( '404 Page', 'electron' ),
        'id' => 'errorsection',
        'icon' => 'el el-error',
        'fields' => array(
            array(
                'title' => esc_html__( '404 Type', 'electron' ),
                'subtitle' => esc_html__( 'Select your 404 page type.', 'electron' ),
                'customizer' => true,
                'id' => 'error_page_type',
                'type' => 'select',
                'options' => array(
                    'default' => esc_html__( 'Deafult', 'electron' ),
                    'elementor' => esc_html__( 'Elementor Templates', 'electron' )
                ),
                'default' => 'default'
            ),
            array(
                'title' => esc_html__( 'Elementor Templates', 'electron' ),
                'subtitle' => esc_html__( 'Select a template from elementor templates.', 'electron' ),
                'customizer' => true,
                'id' => 'error_page_elementor_templates',
                'type' => 'select',
                'data' => 'posts',
                'args'  => $el_args,
                'required' => array( 'error_page_type', '=', 'elementor' )
            ),
            array(
                'id' =>'edit_error_page_template',
                'type' => 'info',
                'desc' => 'Edit template',
                'required' => array(
                    array( 'error_page_type', '=', 'elementor' ),
                    array( 'error_page_elementor_templates', '!=', '' )
                )
            ),
            array(
                'title' => esc_html__( '404 Header Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site 404 page header with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'error_header_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array( 'error_page_type', '=', 'elementor' )
            ),
            array(
                'title' => esc_html__( '404 Footer Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site 404 page footer with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'error_footer_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array( 'error_page_type', '=', 'elementor' )
            ),
            array(
                'title' => esc_html__( '404 Hero Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site 404 page hero section with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'error_hero_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array( 'error_page_type', '=', 'default' )
            ),
            array(
                'title' => esc_html__( '404 Hero Background', 'electron' ),
                'customizer' => true,
                'id' => 'error_hero_bg',
                'type' => 'background',
                'output' => array( '#nt-archive .breadcrumb-bg' ),
                'required' => array(
                    array( 'error_page_type', '=', 'default' ),
                    array( 'error_hero_visibility', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Custom 404 Title', 'electron' ),
                'subtitle' => esc_html__( 'Add your custom 404 page title here.', 'electron' ),
                'customizer' => true,
                'id' => 'error_title',
                'type' => 'text',
                'default' =>'',
                'required' => array(
                    array( 'error_page_type', '=', 'default' ),
                    array( 'error_hero_visibility', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Content Description Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site 404 page content description with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'error_content_desc_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array( 'error_page_type', '=', 'default' )
            ),
            array(
                'title' => esc_html__( 'Content Description', 'electron' ),
                'subtitle' => esc_html__( 'Add your 404 page content description here.', 'electron' ),
                'customizer' => true,
                'id' => 'error_content_desc',
                'type' => 'textarea',
                'default' => '',
                'required' => array(
                    array( 'error_page_type', '=', 'default' ),
                    array( 'error_content_desc_visibility', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Button Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site 404 page content back to home button with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'error_content_btn_visibility',
                'type' => 'switch',
                'default' => 1,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array( 'error_page_type', '=', 'default' )
            ),
            array(
                'title' => esc_html__( 'Button Title', 'electron' ),
                'subtitle' => esc_html__( 'Add your 404 page content back to home button title here.', 'electron' ),
                'customizer' => true,
                'id' => 'error_content_btn_title',
                'type' => 'text',
                'default' => '',
                'required' => array(
                    array( 'error_page_type', '=', 'default' ),
                    array( 'error_content_btn_visibility', '=', '1' )
                )
            ),
            array(
                'title' => esc_html__( 'Search Form Display', 'electron' ),
                'subtitle' => esc_html__( 'You can enable or disable the site 404 page content search form with switch option.', 'electron' ),
                'customizer' => true,
                'id' => 'error_content_form_visibility',
                'type' => 'switch',
                'default' => 0,
                'on' => esc_html__( 'On', 'electron' ),
                'off' => esc_html__( 'Off', 'electron' ),
                'required' => array( 'error_page_type', '=', 'default' )
            )
        )
    ));

    Redux::setSection($electron_pre, array(
        'id' => 'inportexport_settings',
        'title' => esc_html__( 'Import / Export', 'electron' ),
        'desc' => esc_html__( 'Import and Export your Theme Options from text or URL.', 'electron' ),
        'icon' => 'fa fa-download',
        'fields' => array(
            array(
                'id' => 'opt-import-export',
                'type' => 'import_export',
                'title' => '',
                'customizer' => false,
                'subtitle' => '',
                'full_width' => true
            )
        )
    ));
    Redux::setSection($electron_pre, array(
        'id' => 'nt_support_settings',
        'title' => esc_html__( 'Support', 'electron' ),
        'icon' => 'el el-idea',
        'fields' => array(
            array(
                'id' => 'doc',
                'type' => 'raw',
                'markdown' => true,
                'class' => 'theme_support',
                'content' => '<div class="support-section">
                <h5>'.esc_html__( 'WE RECOMMEND YOU READ IT BEFORE YOU START', 'electron' ).'</h5>
                <h2><i class="el el-website"></i> '.esc_html__( 'DOCUMENTATION', 'electron' ).'</h2>
                <a target="_blank" class="button" href="https://electron.com/docs/electron/">'.esc_html__( 'READ MORE', 'electron' ).'</a>
                </div>'
            ),
            array(
                'id' => 'support',
                'type' => 'raw',
                'markdown' => true,
                'class' => 'theme_support',
                'content' => '<div class="support-section">
                <h5>'.esc_html__( 'DO YOU NEED HELP?', 'electron' ).'</h5>
                <h2><i class="el el-adult"></i> '.esc_html__( 'SUPPORT CENTER', 'electron' ).'</h2>
                <a target="_blank" class="button" href="https://electron.com/contact/">'.esc_html__( 'GET SUPPORT', 'electron' ).'</a>
                </div>'
            ),
            array(
                'id' => 'portfolio',
                'type' => 'raw',
                'markdown' => true,
                'class' => 'theme_support',
                'content' => '<div class="support-section">
                <h5>'.esc_html__( 'SEE MORE THE NINETHEME WORDPRESS THEMES', 'electron' ).'</h5>
                <h2><i class="el el-picture"></i> '.esc_html__( 'NINETHEME PORTFOLIO', 'electron' ).'</h2>
                <a target="_blank" class="button" href="https://themeforest.net/user/ninetheme/portfolio/">'.esc_html__( 'SEE MORE', 'electron' ).'</a>
                </div>'
            ),
            array(
                'id' => 'like',
                'type' => 'raw',
                'markdown' => true,
                'class' => 'theme_support',
                'content' => '<div class="support-section">
                <h5>'.esc_html__( 'WOULD YOU LIKE TO REWARD OUR EFFORT?', 'electron' ).'</h5>
                <h2><i class="el el-thumbs-up"></i> '.esc_html__( 'PLEASE RATE US!', 'electron' ).'</h2>
                <a target="_blank" class="button" href="https://themeforest.net/downloads/">'.esc_html__( 'GET STARS', 'electron' ).'</a>
                </div>'
            )
        )
    ));
    /*
     * <--- END SECTIONS
     */


    /** Action hook examples **/

    function electron_remove_demo()
    {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if (class_exists('ReduxFrameworkPlugin' )) {
            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ));
        }
    }

    function electron_newIconFont() {
        wp_register_style(
            'redux-font-awesome',
            '//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
            array(),
            time(),
            'all'
        );
        wp_enqueue_style( 'redux-font-awesome' );
    }
    add_action( 'redux/page/electron/enqueue', 'electron_newIconFont' );
