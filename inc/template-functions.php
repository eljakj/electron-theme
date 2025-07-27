<?php
/**
 * Functions which enhance the theme by hooking into WordPress
*/

/*************************************************
## DATA CONTROL FROM THEME-OPTIONS PANEL
*************************************************/
if ( ! function_exists( 'electron_settings' ) ) {
    function electron_settings( $opt_id, $def_value='' )
    {
        if ( !class_exists( 'Redux' ) ) {
            $electronOpt = get_option('electron');

            if ( isset( $electronOpt[ $opt_id ] ) ) {
                return $electronOpt[ $opt_id ];
            }

            return $def_value;
        }

        global $electron;

        $defval = '' != $def_value ? $def_value : false;
        $opt_id = trim( $opt_id );
        $opt    = isset( $electron[ $opt_id ] ) ? $electron[ $opt_id ] : $defval;

        return $opt;
    }
    function electron_header_settings( $opt_id, $def_value='' )
    {
        if ( !class_exists( 'Redux' ) ) {
            $electronOpt = get_option('electron_header');

            if ( isset( $electronOpt[ $opt_id ] ) ) {
                return $electronOpt[ $opt_id ];
            }
            return $def_value;
        }

        global $electron_header;

        $electronOpt = get_option('electron');

        $defval = '' != $def_value ? $def_value : false;
        $opt_id = trim( $opt_id );
        $opt    = isset( $electron_header[ $opt_id ] ) ? $electron_header[ $opt_id ] : $defval;

        return $opt;
    }
}


 /*************************************************
 ## WPML && POLYLANG Compatibility for Elementor Templates.
 *************************************************/
if ( ! function_exists( 'electron_get_wpml_object' ) ) {
    add_filter( 'electron_translated_template_id', 'electron_get_wpml_object' );
    function electron_get_wpml_object( $id )
    {
        $translated_id = apply_filters( 'wpml_object_id', $id );

        if ( defined( 'POLYLANG_BASENAME' ) ) {

            if ( null === $translated_id ) {

                // The current language is not defined yet or translation is not available.
                return $id;
            } else {

                // Return translated post ID.
                return pll_get_post( $translated_id );
            }
        }

        if ( null === $translated_id ) {
            return $id;
        }

        return $translated_id;
    }
}


/*************************************************
## PRINT ELEMENTOR CURRENT TEMPLATE
*************************************************/
if ( ! function_exists( 'electron_print_elementor_templates' ) ) {
    function electron_print_elementor_templates( $option_id, $wrapper_class='', $css=false )
    {
        if ( class_exists( '\Elementor\Frontend' ) ) {
            $css    = $css ? true : false;
            $option = electron_settings( $option_id, null ) ? electron_settings( $option_id ) : trim( $option_id );
            $id     = $option ? apply_filters( 'electron_elementor_template_id', $option ) : '';
            $tempId = apply_filters( 'electron_translated_template_id', intval( $id ) );

            if ( $tempId ) {
                $frontend = new \Elementor\Frontend;
                $content  = $frontend->get_builder_content_for_display( $tempId, $css );
                return $wrapper_class ? '<div class="'.$wrapper_class.'">'.$content.'</div>' : $content;
            }
        }
    }
}


/*************************************************
## CHECK IF PAGE HERO
*************************************************/

if ( !function_exists( 'electron_check_page_hero' ) ) {
    function electron_check_page_hero()
    {
        if ( is_404() ) {

            $name = 'error';

        } elseif ( is_archive() ) {

            $name = 'archive';

        } elseif ( is_search() ) {

            $name = 'search';

        } elseif ( is_home() || is_front_page() ) {

            $name = 'blog';

        } elseif ( is_single() ) {

            $name = 'single';

        } elseif ( is_page() ) {

            $name = 'page';
        }

        $h_v = electron_settings( $name.'_hero_visibility', '1' );
        $h_v = '0' == $h_v ? 'page-hero-off' : '';
        return $h_v;
    }
}

/**
* ------------------------------------------------------------------------------------------------
* is ajax request
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'electron_is_pjax' ) ) {
    function electron_is_pjax()
    {
        return function_exists( 'electron_pjax') ? electron_pjax() : false;
    }
}


/*************************************************
## CUSTOM BODY CLASSES
*************************************************/
if ( !function_exists( 'electron_body_theme_classes' ) ) {
    function electron_body_theme_classes( $classes )
    {
        global $post,$is_IE,$is_safari,$is_chrome,$is_iphone;

        if ( class_exists( 'Redux' ) && get_option( 'merlin_electron_completed' ) ) {
            $boxed = isset($_GET['theme_boxed']) ? esc_html($_GET['theme_boxed']) : electron_settings( 'theme_boxed_layout', '0' );
            $compare_page_id = electron_settings( 'compare_page_id' );
            $classes[] = wp_get_theme();
            $classes[] = wp_get_theme() . '-v' . wp_get_theme()->get( 'Version' );
            $classes[] = class_exists( 'WooCommerce' ) && ! is_cart() && ! is_account_page() ? 'nt-page-default' : '';
            $classes[] = class_exists( 'WooCommerce' ) && ( is_shop() && is_archive() ) && !woocommerce_product_loop() ? 'not-found' : '';
            $classes[] = class_exists( 'WooCommerce' ) && '1' == electron_settings( 'woo_catalog_mode', '0' ) ? 'catalog-mode-active' : '';
            $classes[] = '1' == $boxed ? 'layout-boxed' : '';
            $classes[] = '1' == electron_header_settings( 'minibar_visibility', '0' ) ? 'has-minibar' : '';
            $classes[] = '1' == electron_header_settings( 'bottom_mobile_nav_visibility', '1' ) ? 'has-bottom-mobile-nav' : '';
            $classes[] = class_exists( 'WooCommerce' ) && is_page() && get_the_ID() == $compare_page_id ? 'electron-compare-page' : '';
            $classes[] = electron_check_page_hero();

        } else {

            $classes[] = 'theme-basic';
        }

        $classes[] = is_singular( 'post' ) && has_blocks() ? 'nt-single-has-block' : '';
        $classes[] = is_page() && comments_open() ? 'page-has-comment' : '';
        $classes[] = is_singular( 'post' ) && !has_post_thumbnail() ? 'nt-single-thumb-none' : '';
        $classes[] = $is_IE ? 'nt-msie' : '';
        $classes[] = $is_chrome ? 'nt-chrome' : '';
        $classes[] = $is_iphone ? 'nt-iphone' : '';
        $classes[] = function_exists('wp_is_mobile') && wp_is_mobile() ? 'nt-mobile' : 'nt-desktop';

        return $classes;
    }
    add_filter( 'body_class', 'electron_body_theme_classes' );
}


/*************************************************
## Theme Localize Settings
*************************************************/
if ( ! function_exists( 'electron_theme_all_settings' ) ) {
    function electron_theme_all_settings()
    {
        $is_woo = class_exists( 'WooCommerce' ) ? true : false;
        $footerId = '';
        if ( 'elementor' == electron_settings( 'footer_template', 'default' ) ) {
            $footerId = isset($_GET['footer_style']) ? esc_html($_GET['footer_style']) : electron_settings( 'footer_elementor_templates' );
        }

        $electron_vars = [
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'wc_ajax_url'   => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
            'security'      => wp_create_nonce( 'electron-special-string' ),
            'is_mobile'     => wp_is_mobile() ? 'yes' : 'no',
            'shop_ajax'     => '1' == electron_settings('shop_ajax_filter', '0' ) ? 'yes' : 'no',
            'product_ajax'  => '1' == electron_settings('product_ajax_addtocart_visibility', '0' ) ? 'yes' : 'no',
            'minicart_open' => '1' == electron_settings('minicart_auto_open', '1' ) ? 'yes' : 'no',
            'swatches'      => function_exists( 'electron_get_swatches_colors' ) ? electron_get_swatches_colors() : false,
            'notices'       => '1' == electron_settings( 'shop_cart_popup_notices_visibility', '1' ) ? true : false,
            'duration'      => electron_settings( 'notices_duration', 3500 ),
            'addto'         => esc_html__( 'Add to cart', 'electron' ),
            'added'         => esc_html__( 'Added to cart', 'electron' ),
            'view'          => esc_attr__( 'View cart', 'electron' ),
            'removed'       => esc_html__( 'Removed from Cart', 'electron' ),
            'updated'       => esc_html__( 'Cart updated', 'electron' ),
            'clear'         => esc_html__( 'Are you sure you want to clear all rows?', 'electron' ),
            'max_message'   => esc_html__( 'Sorry, you have reached the max product limit.You can not add more products.', 'electron' ),
            'coupon_remove' => esc_html__( 'Coupon code removed successfully.', 'electron' ),
            'wadded'        => esc_html__( 'Added to Wishlist', 'electron' ),
            'wremoved'      => esc_html__( 'Removed from wishlist!', 'electron' ),
            'wlogin'        => esc_html__( 'Please log in to use the wishlist!', 'electron' ),
            'werror'        => esc_html__( 'Have an error, please try again!', 'electron' ),
            'wmax'          => esc_html__( 'Sorry, you\'ve reached the max product limit.You can\'t add more products.', 'electron' ),
            'copied_text'   => esc_html__( 'Copied', 'electron' ),
            'start_shop'    => esc_html__( 'Start Shopping', 'electron' ),
            'load_title'    => esc_html__( 'Load More', 'electron' ),
            'loading_title' => esc_html__( 'Loading...', 'electron' ),
            'nomore'        => esc_html__( 'All Products Loaded', 'electron' ),
            'no_results'    => esc_html__( 'No product found', 'electron' ),
            'fill'          => esc_html__( 'Please fill out this field.', 'electron' ),
            'protected'     => esc_html__( 'This content is password protected.', 'electron' ),
            'check_product' => esc_html__( 'Check Product', 'electron' ),
            'menu_back'     => esc_html__( 'Back', 'electron' ),
            'search_total'  => esc_html__( 'Show All Products', 'electron' ),
            'cart_url'      => $is_woo ? apply_filters( 'woocommerce_add_to_cart_redirect', wc_get_cart_url(), null ) : '',
            'is_cart'       => $is_woo && is_cart() ? 'yes' : 'no',
            'is_checkout'   => $is_woo && is_checkout() ? 'yes' : 'no',
            'is_account'    => $is_woo && is_account_page() ? 'yes' : 'no',
            'shop_url'      => $is_woo ? apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) : '',
            'cart_redirect' => get_option( 'woocommerce_cart_redirect_after_add' ),
            'shop_mode'     => $is_woo ? woocommerce_get_loop_display_mode() : '',
            'footer_ajax'   => '1' == electron_settings('footer_ajax', '1' ) ? 'yes' : 'no',
            'save_footer'   => '1' == electron_settings('footer_ajax_localstorage', '1' ) ? 'yes' : 'no',
            'megamenu_ajax' => '1' == electron_settings('header_megamenu_ajax', '1' ) ? 'yes' : 'no',
            'save_megamenu' => '1' == electron_settings('header_megamenu_localstorage', '1' ) ? 'yes' : 'no',
            'backtotop'     => '0' != electron_settings('backtotop_visibility', '1') ? 'yes' : 'no',
            'product_type'  => isset($_GET['product_style']) ? esc_html($_GET['product_style']) : electron_settings( 'shop_product_type', '1' ),
            'minicart_type' => electron_settings( 'minicart_type', 'icon' ),
            'popup_upsells' => '1' == electron_settings( 'popupcart_upsells_visibility', '1' ) ? 'yes' : 'no',
            'footer_temp'   => $footerId,
            'mobile_filter' => '1' == electron_settings( 'shop_sidebar_mobile_filter', '0' ) ? 'yes' : 'no',
        ];

        return $electron_vars;
    }
}

/*************************************************
## CUSTOM POST CLASS
*************************************************/
if ( !function_exists( 'electron_post_theme_class' ) ) {
    function electron_post_theme_class( $classes )
    {
        if ( ! is_single() AND ! is_page() ) {
            $classes[] = 'nt-post-class';
            $classes[] = is_sticky() ? '-has-sticky' : '';
            $classes[] = !has_post_thumbnail() ? 'thumb-none' : '';
            $classes[] = !get_the_title() ? 'title-none' : '';
            $classes[] = !has_excerpt() ? 'excerpt-none' : '';
            $classes[] = wp_link_pages('echo=0') ? 'nt-is-wp-link-pages' : '';
        }

        return $classes;
    }
    add_filter( 'post_class', 'electron_post_theme_class' );
}


/*************************************************
## THEME SIDEBARS SEARCH FORM
*************************************************/
if ( !function_exists( 'electron_search_form' ) ) {
    function electron_search_form()
    {
        $icon = !class_exists('Redux') ? esc_html__( 'Submit', 'electron' ) : '<i class="fas fa-search"></i>';
        $form = '<form class="sidebar-search-form" role="search" method="get" id="widget-searchform" action="' . esc_url( home_url( '/' ) ) . '" >
        <input class="sidebar_search_input" type="text" value="' . get_search_query() . '" placeholder="'. esc_attr__( 'Search', 'electron' ) .'" name="s" id="ws">
        <button class="sidebar_search_button" id="searchsubmit" type="submit">'.$icon.'</button>
        </form>';
        return $form;
    }
    add_filter( 'get_search_form', 'electron_search_form' );
}

if ( !function_exists( 'electron_error_page_form' ) ) {
    function electron_error_page_form()
    {
        $form = '<div class="search_form"><form class="sidebar-search-form" role="search" method="get" id="widget-searchform" action="' . esc_url( home_url( '/' ) ) . '" >
        <input class="form-control" type="text" value="' . get_search_query() . '" placeholder="'. esc_attr__( 'Search', 'electron' ) .'" name="s" id="ws">
        <button type="submit" class="icon_search"><i class="fa fa-angle-right"></i></button></form></div>';
        return $form;
    }
    add_filter( 'get_search_form', 'electron_error_page_form' );
}

/*************************************************
## EXCERPT FILTER
*************************************************/
if ( !function_exists( 'electron_custom_excerpt_more' ) ) {
    function electron_custom_excerpt_more( $more )
    {
        return '...';
    }
    add_filter( 'excerpt_more', 'electron_custom_excerpt_more' );
}

/*************************************************
## DEFAULT CATEGORIES WIDGET
*************************************************/
if ( !function_exists( 'electron_add_span_cat_count' ) ) {
    add_filter( 'wp_list_categories', 'electron_add_span_cat_count' );
    function electron_add_span_cat_count( $links )
    {
        $links = str_replace( '</a> (', '</a> <span class="widget-list-span">', $links );
        $links = str_replace( '</a> <span class="count">(', '</a> <span class="widget-list-span">', $links );
        $links = str_replace( ')', '</span>', $links );

        return $links;
    }
}


/*************************************************
## DEFAULT ARCHIVES WIDGET
*************************************************/
if ( !function_exists( 'electron_add_span_arc_count' ) ) {
    add_filter( 'get_archives_link', 'electron_add_span_arc_count' );
    function electron_add_span_arc_count( $links )
    {
        $links = str_replace( '</a>&nbsp;(', '</a> <span class="widget-list-span">', $links );

        $links = str_replace( ')', '</span>', $links );

        // dropdown selectbox
        $links = str_replace( '&nbsp;(', ' - ', $links );

        return $links;
    }
}

/*************************************************
## PAGINATION CUSTOMIZATION
*************************************************/
if ( !function_exists( 'electron_sanitize_pagination' ) ) {
    add_action( 'navigation_markup_template', 'electron_sanitize_pagination' );
    function electron_sanitize_pagination( $content )
    {
        // remove role attribute
        $content = str_replace( 'role="navigation"', '', $content );

        // remove h2 tag
        $content = preg_replace( '#<h2.*?>(.*?)<\/h2>#si', '', $content );

        return $content;
    }
}

/*************************************************
## CUSTOM ARCHIVE TITLES
*************************************************/
if ( !function_exists( 'electron_archive_title' ) ) {
    add_filter( 'get_the_archive_title', 'electron_archive_title' );
    function electron_archive_title()
    {
        $title = '';
        if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag()) {
            $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
            $title = get_the_author();
        } elseif ( is_year() ) {
            $title = get_the_date( _x( 'Y', 'yearly archives date format', 'electron' ) );
        } elseif ( is_month() ) {
            $title = get_the_date( _x( 'F Y', 'monthly archives date format', 'electron' ) );
        } elseif ( is_day() ) {
            $title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'electron' ) );
        } elseif ( is_post_type_archive() ) {
            $title = post_type_archive_title( '', false );
        } elseif ( is_tax() ) {
            $title = single_term_title( '', false );
        }
        return $title;
    }
}

add_action('wp_ajax_load_footer_template', 'load_footer_template');
add_action('wp_ajax_nopriv_load_footer_template', 'load_footer_template');

function load_footer_template() {
    $ID = electron_settings( 'footer_elementor_templates' );
    $ID = isset($_POST['footerId']) ? esc_html($_POST['footerId']) : $ID;
    $ID = apply_filters( 'electron_translated_template_id', $ID );
    $footerTemp = new WP_Query( array('p' => $ID, 'post_type' => 'elementor_library') );
    if ( $footerTemp->have_posts() ) {
        while ( $footerTemp->have_posts() ) {
            $footerTemp->the_post();
            the_content();
        }
    }
    wp_reset_postdata();
	die();
}

add_action('wp_ajax_get_mega_menu_content', 'electron_get_mega_menu_content');
add_action('wp_ajax_nopriv_get_mega_menu_content', 'electron_get_mega_menu_content');

function electron_get_mega_menu_content() {
    $response = array(
        'data' => array()
    );
    if( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
        $count = 0;
        foreach ($_POST['ids'] as $id) {
            $shortcode  = get_post_meta( $id, '_menu_item_menushortcode', true );
            $shortcode2 = get_post_meta( $id, '_menu_item_menushortcode_sidebar', true );
            $response['data'][$id] = [
                "shortcode"  => do_shortcode($shortcode),
                "shortcode2" => do_shortcode($shortcode2)
            ];
        }
    }
    echo json_encode($response);
    die();
}

/**
* Displays svg file
*/
if ( ! function_exists( 'electron_svg_lists' ) ) {
    function electron_svg_lists( $name, $class='' )
    {
        if ( !$name ) {
            return;
        }
        $class = $class ? ' '.$class : '';

        $svg = array(
            // paper-search
            'paper-search' => '<svg class="svgPaperSearch'.$class.'" height="512" width="512" fill="currentColor" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="m17 22c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5zm0-8.5c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5 3.5-1.57 3.5-3.5-1.57-3.5-3.5-3.5z"/><path d="m23.25 24c-.192 0-.384-.073-.53-.22l-3.25-3.25c-.293-.293-.293-.768 0-1.061s.768-.293 1.061 0l3.25 3.25c.293.293.293.768 0 1.061-.147.147-.339.22-.531.22z"/><path d="m10.53 21h-7.78c-1.517 0-2.75-1.233-2.75-2.75v-15.5c0-1.517 1.233-2.75 2.75-2.75h11.5c1.517 0 2.75 1.233 2.75 2.75v7.04c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-7.04c0-.689-.561-1.25-1.25-1.25h-11.5c-.689 0-1.25.561-1.25 1.25v15.5c0 .689.561 1.25 1.25 1.25h7.78c.414 0 .75.336.75.75s-.336.75-.75.75z"/><path d="m13.25 9.5h-9.5c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h9.5c.414 0 .75.336.75.75s-.336.75-.75.75z"/><path d="m9.25 13.5h-5.5c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h5.5c.414 0 .75.336.75.75s-.336.75-.75.75z"/><path d="m8.25 5.5h-4.5c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h4.5c.414 0 .75.336.75.75s-.336.75-.75.75z"/></svg>',
            // contact
            'contact-form' => '<svg class="svgContactForm'.$class.'" height="512" width="512" fill="currentColor" enable-background="new 0 0 511.987 511.987" viewBox="0 0 511.987 511.987"><path d="m491.007 5.907c-20.045-11.575-45.767-4.681-57.338 15.364l-57.212 99.095h-123.383c-5.523 0-10 4.478-10 10s4.477 10 10 10h111.836l-41.518 71.912h-233.39c-5.523 0-10 4.478-10 10 0 5.523 4.477 10 10 10h221.842l-23.094 40h-198.748c-5.523 0-10 4.478-10 10s4.477 10 10 10h194.612l-4.309 40h-190.303c-5.523 0-10 4.478-10 10s4.477 10 10 10h188.148l-.532 4.939c-.424 3.936 1.514 7.752 4.942 9.731 1.553.897 3.278 1.34 4.999 1.34 2.079 0 4.151-.647 5.9-1.925l63.851-46.645c1.125-.822 2.065-1.869 2.761-3.075l77.929-134.975v193.827c0 22.406-18.229 40.636-40.636 40.636h-231.751c-3.573 0-6.874 1.906-8.66 5l-34.967 60.565-34.967-60.565c-1.786-3.094-5.087-5-8.66-5h-17.723c-22.407 0-40.636-18.23-40.636-40.636v-194.493c0-22.406 18.229-40.636 40.636-40.636h102.439c5.523 0 10-4.478 10-10 0-5.523-4.477-10-10-10h-102.439c-33.435 0-60.636 27.201-60.636 60.636v194.493c0 33.435 27.201 60.636 60.636 60.636h11.949l40.741 70.565c1.786 3.094 5.087 5 8.66 5s6.874-1.906 8.66-5l40.741-70.565h225.978c33.435 0 60.636-27.201 60.636-60.636v-194.493c0-8.572-1.818-17.04-5.295-24.804l53.666-92.952c11.572-20.044 4.68-45.766-15.365-57.339zm-10 17.32c10.494 6.059 14.102 19.525 8.043 30.019l-5.714 9.897-38.061-21.975 5.714-9.897c6.059-10.493 19.524-14.1 30.018-8.044zm-176.679 272.779 28.786 16.62-33.188 24.245zm43.423 1.977-38.061-21.975 125.585-217.52 38.061 21.975z"/><path d="m208.07 140.367c2.63 0 5.21-1.07 7.08-2.93 1.86-1.86 2.93-4.44 2.93-7.07s-1.07-5.21-2.93-7.07c-1.87-1.859-4.44-2.93-7.08-2.93-2.63 0-5.21 1.07-7.07 2.93s-2.92 4.44-2.92 7.07 1.059 5.21 2.92 7.07c1.87 1.86 4.44 2.93 7.07 2.93z"/></svg>',
            // three-bar
            'bars' => '<svg class="svgBars'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="0" y1="12" x2="21" y2="12"></line><line x1="0" y1="6" x2="21" y2="6"></line><line x1="0" y1="18" x2="21" y2="18"></line></svg>',
            // column
            'column-11' => '<svg class="svgList'.$class.'" height="512" width="512" fill="currentColor" viewBox="0 0 128 128" enable-background="new 0 0 128 128"><path d="m32 40h-16c-4.412 0-8-3.59-8-8v-16c0-4.41 3.588-8 8-8h16c4.412 0 8 3.59 8 8v16c0 4.41-3.588 8-8 8zm-16-24v16h16.006l-.006-16zm104 8c0-2.211-1.791-4-4-4h-64c-2.209 0-4 1.789-4 4s1.791 4 4 4h64c2.209 0 4-1.789 4-4zm-88 56h-16c-4.412 0-8-3.59-8-8v-16c0-4.41 3.588-8 8-8h16c4.412 0 8 3.59 8 8v16c0 4.41-3.588 8-8 8zm-16-24v16h16.006l-.006-16zm104 8c0-2.211-1.791-4-4-4h-64c-2.209 0-4 1.789-4 4s1.791 4 4 4h64c2.209 0 4-1.789 4-4zm-88 56h-16c-4.412 0-8-3.59-8-8v-16c0-4.41 3.588-8 8-8h16c4.412 0 8 3.59 8 8v16c0 4.41-3.588 8-8 8zm-16-24v16h16.006l-.006-16zm104 8c0-2.211-1.791-4-4-4h-64c-2.209 0-4 1.789-4 4s1.791 4 4 4h64c2.209 0 4-1.789 4-4z"/></svg>',
            // one-column
            'column-1' => '<svg class="svgList'.$class.'" width="100px" height="100px" viewBox="0 0 100 100" fill="currentColor"><path d="M25,35.83H0V64.17H25Zm0,35.84H0V100H25ZM25,0H0V28.33H25Zm5,71.67V100h70V71.67ZM30,0V28.33h70V0Zm0,35.83V64.17h70V35.83Z"/></svg>',
            // two-column
            'column-2' => '<svg class="svgTwoColumn'.$class.'" width="100px" height="100px" viewBox="0 0 100 100" fill="currentColor"><path d="M100,100H54V0h46ZM46,0H0V100H46Z" transform="translate(0.5 0.65)"/></svg>',
            // three-column
            'column-3' => '<svg class="svgThreeColumn'.$class.'" width="100px" height="100px" viewBox="0 0 101 101.15" fill="currentColor"><path d="M100,100H70V0h30ZM30,0H0V100H30ZM65-.15H35v100H65Z" transform="translate(0.5 0.65)"/></svg>',
            // four-column
            'column-4' => '<svg class="svgFourColumn'.$class.'" width="100px" height="100px" viewBox="0 0 100 100" fill="currentColor"><path d="M21.5,0H0V100H21.5ZM100,0H78.5V100H100ZM48,0H26.5V100H48ZM74,0H52.5V100H74Z"/></svg>',
            // five-column
            'column-5' => '<svg class="svgFiveColumn'.$class.'" width="100px" height="100px" viewBox="0 0 100 100" fill="currentColor"><path d="M16,0H0V100H16Zm84,0H84V100h16ZM79,0H63V100H79ZM37,0H21V100H37ZM58,0H42V100H58Z"/></svg>',
            // five-column
            'filter' => '<svg class="svgFilter'.$class.'" height="512" viewBox="0 0 32 32" width="512" data-name="Layer 1"><g fill="rgb(0,0,0)"><path d="m1.917 24.75h17.333v2h-17.333z"/><path d="m23.5 22.5h-2v6.5h2v-2.25h6.583v-2h-6.583z"/><path d="m12.75 15h17.333v2h-17.333z"/><path d="m8.5 19.25h2v-6.5h-2v2.25h-6.583v2h6.583z"/><path d="m1.917 5.25h17.333v2h-17.333z"/><path d="m23.5 5.25v-2.25h-2v6.5h2v-2.25h6.583v-2z"/></g></svg>',
            // four-column
            'column-6' => '<svg class="svgFourColumn'.$class.'" width="16px" height="16px" fill="currentColor" viewBox="0 0 19 19" enable-background="new 0 0 19 19" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" xml:space="preserve"><rect width="4" height="4"></rect><rect x="5" width="4" height="4"></rect><rect x="10" width="4" height="4"></rect><rect x="15" width="4" height="4"></rect><rect y="5" width="4" height="4"></rect><rect x="5" y="5" width="4" height="4"></rect><rect x="10" y="5" width="4" height="4"></rect><rect x="15" y="5" width="4" height="4"></rect><rect y="15" width="4" height="4"></rect><rect x="5" y="15" width="4" height="4"></rect><rect x="10" y="15" width="4" height="4"></rect><rect x="15" y="15" width="4" height="4"></rect><rect y="10" width="4" height="4"></rect><rect x="5" y="10" width="4" height="4"></rect><rect x="10" y="10" width="4" height="4"></rect><rect x="15" y="10" width="4" height="4"></rect></svg>',
            // cancel
            'cancel' => '<svg class="svgCancel'.$class.'" height="512" fill="currentColor" viewBox="0 0 16 16" width="512"><path d="m8 16a8 8 0 1 1 8-8 8 8 0 0 1 -8 8zm0-15a7 7 0 1 0 7 7 7 7 0 0 0 -7-7z"/><path d="m8.71 8 3.14-3.15a.49.49 0 0 0 -.7-.7l-3.15 3.14-3.15-3.14a.49.49 0 0 0 -.7.7l3.14 3.15-3.14 3.15a.48.48 0 0 0 0 .7.48.48 0 0 0 .7 0l3.15-3.14 3.15 3.14a.48.48 0 0 0 .7 0 .48.48 0 0 0 0-.7z"/></svg>',
            // search
            'search' => '<svg class="svgSearch'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 48 48" enable-background="new 0 0 48 48"><g><path d="m40.2850342 37.4604492-6.4862061-6.4862061c1.9657593-2.5733643 3.0438843-5.6947021 3.0443115-8.9884033 0-3.9692383-1.5458984-7.7011719-4.3530273-10.5078125-2.8066406-2.8066406-6.5380859-4.3525391-10.5078125-4.3525391-3.9692383 0-7.7011719 1.5458984-10.5078125 4.3525391-5.7939453 5.7944336-5.7939453 15.222168 0 21.015625 2.8066406 2.8071289 6.5385742 4.3530273 10.5078125 4.3530273 3.2937012-.0004272 6.4150391-1.0785522 8.9884033-3.0443115l6.4862061 6.4862061c.3901367.390625.9023438.5859375 1.4140625.5859375s1.0239258-.1953125 1.4140625-.5859375c.78125-.7807617.78125-2.0473633 0-2.828125zm-25.9824219-7.7949219c-4.234375-4.234375-4.2338867-11.1245117 0-15.359375 2.0512695-2.0507813 4.7788086-3.1806641 7.6796875-3.1806641 2.9013672 0 5.628418 1.1298828 7.6796875 3.1806641 2.0512695 2.0512695 3.1811523 4.7788086 3.1811523 7.6796875 0 2.9013672-1.1298828 5.628418-3.1811523 7.6796875s-4.7783203 3.1811523-7.6796875 3.1811523c-2.9008789.0000001-5.628418-1.1298827-7.6796875-3.1811523z"/></g></svg>',
            // filter
            'filter2' => '<svg class="svgFilter'.$class.'" width="20" height="20" fill="currentColor" viewBox="0 0 512 512" enable-background="new 0 0 512 512"><g><g><path d="m140.7 123h-80.8c-7.6 0-13.8-6.2-13.8-13.8s6.2-13.8 13.8-13.8h80.8c7.6 0 13.8 6.2 13.8 13.8s-6.1 13.8-13.8 13.8z"/></g><g><path d="m452.1 123h-235.3c-7.6 0-13.8-6.2-13.8-13.8s6.2-13.8 13.8-13.8h235.3c7.6 0 13.8 6.2 13.8 13.8s-6.1 13.8-13.8 13.8z"/></g><g><path d="m178.8 161c-28.6 0-51.9-23.3-51.9-51.9s23.3-51.9 51.9-51.9 51.9 23.3 51.9 51.9-23.3 51.9-51.9 51.9zm0-76.1c-13.4 0-24.2 10.9-24.2 24.2s10.9 24.2 24.2 24.2c13.4 0 24.2-10.9 24.2-24.2s-10.9-24.2-24.2-24.2z"/></g><g><path d="m140.7 416.7h-80.8c-7.6 0-13.8-6.2-13.8-13.8s6.2-13.8 13.8-13.8h80.8c7.6 0 13.8 6.2 13.8 13.8.1 7.6-6.1 13.8-13.8 13.8z"/></g><g><path d="m452.1 416.7h-235.3c-7.6 0-13.8-6.2-13.8-13.8s6.2-13.8 13.8-13.8h235.3c7.6 0 13.8 6.2 13.8 13.8.1 7.6-6.1 13.8-13.8 13.8z"/></g><g><path d="m178.8 454.8c-28.6 0-51.9-23.3-51.9-51.9s23.3-51.9 51.9-51.9 51.9 23.3 51.9 51.9-23.3 51.9-51.9 51.9zm0-76.1c-13.4 0-24.2 10.9-24.2 24.2s10.9 24.2 24.2 24.2c13.4 0 24.2-10.9 24.2-24.2s-10.9-24.2-24.2-24.2z"/></g><g><path d="m452.1 269.8h-80.8c-7.6 0-13.8-6.2-13.8-13.8s6.2-13.8 13.8-13.8h80.8c7.6 0 13.8 6.2 13.8 13.8s-6.1 13.8-13.8 13.8z"/></g><g><path d="m295.2 269.8h-235.3c-7.6 0-13.8-6.2-13.8-13.8s6.2-13.8 13.8-13.8h235.3c7.6 0 13.8 6.2 13.8 13.8s-6.2 13.8-13.8 13.8z"/></g><g><path d="m333.2 307.9c-28.6 0-51.9-23.3-51.9-51.9s23.3-51.9 51.9-51.9 51.9 23.3 51.9 51.9-23.2 51.9-51.9 51.9zm0-76.1c-13.4 0-24.2 10.9-24.2 24.2s10.9 24.2 24.2 24.2c13.4 0 24.2-10.9 24.2-24.2s-10.8-24.2-24.2-24.2z"/></g></g></svg>',
            // user 1
            'love' => '<svg class="svgLove'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 32 32"><path d="m29.55 6.509c-1.73-2.302-3.759-3.483-6.031-3.509h-.076c-3.29 0-6.124 2.469-7.443 3.84-1.32-1.371-4.153-3.84-7.444-3.84h-.075c-2.273.026-4.3 1.207-6.059 3.549a8.265 8.265 0 0 0 1.057 10.522l11.821 11.641a1 1 0 0 0 1.4 0l11.82-11.641a8.278 8.278 0 0 0 1.03-10.562zm-2.432 9.137-11.118 10.954-11.118-10.954a6.254 6.254 0 0 1 -.832-7.936c1.335-1.777 2.831-2.689 4.45-2.71h.058c3.48 0 6.627 3.924 6.658 3.964a1.037 1.037 0 0 0 1.57 0c.032-.04 3.2-4.052 6.716-3.964a5.723 5.723 0 0 1 4.421 2.67 6.265 6.265 0 0 1 -.805 7.976z"/></svg>',
            // bag
            'bag' => '<svg class="shopBag'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 32 32"><path d="m26 8.9a1 1 0 0 0 -1-.9h-3a6 6 0 0 0 -12 0h-3a1 1 0 0 0 -1 .9l-1.78 17.8a3 3 0 0 0 .78 2.3 3 3 0 0 0 2.22 1h17.57a3 3 0 0 0 2.21-1 3 3 0 0 0 .77-2.31zm-10-4.9a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9.53 23.67a1 1 0 0 1 -.74.33h-17.58a1 1 0 0 1 -.74-.33 1 1 0 0 1 -.26-.77l1.7-16.9h2.09v3a1 1 0 0 0 2 0v-3h8v3a1 1 0 0 0 2 0v-3h2.09l1.7 16.9a1 1 0 0 1 -.26.77z"/></svg>',
            // user 1
            'user-1' => '<svg class="svgUser2'.$class.'"  enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"><g><g><path d="m256 253.7c-62 0-112.4-50.4-112.4-112.4s50.4-112.4 112.4-112.4 112.4 50.4 112.4 112.4-50.4 112.4-112.4 112.4zm0-195.8c-46 0-83.4 37.4-83.4 83.4s37.4 83.4 83.4 83.4 83.4-37.4 83.4-83.4-37.4-83.4-83.4-83.4z"/></g><g><path d="m452.1 483.2h-392.2c-8 0-14.5-6.5-14.5-14.5 0-106.9 94.5-193.9 210.6-193.9s210.6 87 210.6 193.9c0 8-6.5 14.5-14.5 14.5zm-377-29.1h361.7c-8.1-84.1-86.1-150.3-180.8-150.3s-172.7 66.2-180.9 150.3z"/></g></g></svg>',
            // user 2
            'user-2' => '<svg class="svgUser2'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 512 512" enable-background="new 0 0 512 512"><g><g><path d="m256 253.7c-62 0-112.4-50.4-112.4-112.4s50.4-112.4 112.4-112.4 112.4 50.4 112.4 112.4-50.4 112.4-112.4 112.4zm0-195.8c-46 0-83.4 37.4-83.4 83.4s37.4 83.4 83.4 83.4 83.4-37.4 83.4-83.4-37.4-83.4-83.4-83.4z"/></g><g><path d="m452.1 483.2h-392.2c-8 0-14.5-6.5-14.5-14.5 0-106.9 94.5-193.9 210.6-193.9s210.6 87 210.6 193.9c0 8-6.5 14.5-14.5 14.5zm-377-29.1h361.7c-8.1-84.1-86.1-150.3-180.8-150.3s-172.7 66.2-180.9 150.3z"/></g></g></svg>',
            // user 3
            'user-3' => '<svg class="svgUser3'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><path d="m8 8a4 4 0 1 1 4-4 4 4 0 0 1 -4 4zm0-7a3 3 0 1 0 3 3 3 3 0 0 0 -3-3z"/><path d="m13.5 16h-11a.5.5 0 0 1 -.5-.5v-4a5.92 5.92 0 0 1 1.62-4.09.5.5 0 0 1 .72.68 5 5 0 0 0 -1.34 3.41v3.5h10v-3.5a5 5 0 0 0 -1.34-3.41.5.5 0 1 1 .72-.68 5.92 5.92 0 0 1 1.62 4.09v4a.5.5 0 0 1 -.5.5z"/></svg>',
            // compare
            'compare' => '<svg class="svgCompare'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 30 30"><path d="m26 9a1 1 0 0 0 0-2h-4a1 1 0 0 0 -1 1v4a1 1 0 0 0 2 0v-1.66a9 9 0 0 1 -7 14.66c-.3 0-.6 0-.9 0a1 1 0 1 0 -.2 2c.36 0 .73.05 1.1.05a11 11 0 0 0 8.48-18.05z"/><path d="m10 19a1 1 0 0 0 -1 1v1.66a9 9 0 0 1 8.8-14.48 1 1 0 0 0 .4-2 10.8 10.8 0 0 0 -2.2-.18 11 11 0 0 0 -8.48 18h-1.52a1 1 0 0 0 0 2h4a1 1 0 0 0 1-1v-4a1 1 0 0 0 -1-1z"/></svg>',
            // eye
            'eye' => '<svg class="svgEye'.$class.'" height="512" width="512" fill="currentColor" viewBox="0 0 32 32"><path d="m29.91 15.59c-.17-.39-4.37-9.59-13.91-9.59s-13.74 9.2-13.91 9.59a1 1 0 0 0 0 .82c.17.39 4.37 9.59 13.91 9.59s13.74-9.2 13.91-9.59a1 1 0 0 0 0-.82zm-13.91 8.41c-7.17 0-11-6.32-11.88-8 .88-1.68 4.71-8 11.88-8s11 6.32 11.88 8c-.88 1.68-4.71 8-11.88 8z"/><path d="m16 10a6 6 0 1 0 6 6 6 6 0 0 0 -6-6zm0 10a4 4 0 1 1 4-4 4 4 0 0 1 -4 4z"/></svg>',
            // store
            'store' => '<svg class="svgStore'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><path d="M511.989,148.555c0-.107.007-.214.008-.322,0-.042,0-.083,0-.125h-.007a15.921,15.921,0,0,0-1.805-7.4L441.3,8.6A16,16,0,0,0,427.115,0H84.885A16,16,0,0,0,70.7,8.6L1.813,140.711a15.91,15.91,0,0,0-1.806,7.4H0c0,.042,0,.083,0,.125,0,.108.005.215.008.322a75.953,75.953,0,0,0,32.6,61.9V466a46.053,46.053,0,0,0,46,46H433.386a46.058,46.058,0,0,0,46-46V210.455A75.953,75.953,0,0,0,511.989,148.555Zm-32.15,3.167A43.994,43.994,0,0,1,392,148.108h-.016a16,16,0,0,0-.512-4.077L361.946,32h55.468ZM183.146,32H240V148.108A44,44,0,0,1,152.048,150ZM272,32h56.854l31.1,118A44,44,0,0,1,272,148.108ZM94.586,32h55.468L120.528,144.031a16,16,0,0,0-.512,4.077H120a43.994,43.994,0,0,1-87.839,3.614ZM380.331,480H298.96V306.347h81.371Zm67.054-14a14.058,14.058,0,0,1-14,14H412.331V290.347a16,16,0,0,0-16-16H282.96a16,16,0,0,0-16,16V480H78.615a14.016,14.016,0,0,1-14-14V223.253A75.917,75.917,0,0,0,136,194.673a75.869,75.869,0,0,0,120,0,75.869,75.869,0,0,0,120,0,75.917,75.917,0,0,0,71.385,28.58ZM215.215,274.347H115.67a16,16,0,0,0-16,16v99.545a16,16,0,0,0,16,16h99.545a16,16,0,0,0,16-16V290.347A16,16,0,0,0,215.215,274.347Zm-16,99.545H131.67V306.347h67.545Z"/></svg>',
            // arrow-left
            'arrow-left' => '<svg class="svgLeft'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 128 128" enable-background="new 0 0 128 128"><path d="m64 0c-35.289 0-64 28.711-64 64s28.711 64 64 64 64-28.711 64-64-28.711-64-64-64zm0 120c-30.879 0-56-25.121-56-56s25.121-56 56-56 56 25.121 56 56-25.121 56-56 56zm28-56c0 2.211-1.791 4-4 4h-38.344l13.172 13.172c1.563 1.563 1.563 4.094 0 5.656-.781.781-1.805 1.172-2.828 1.172s-2.047-.391-2.828-1.172l-20-20c-1.563-1.563-1.563-4.094 0-5.656l20-20c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656l-13.172 13.172h38.344c2.209 0 4 1.789 4 4z"/></svg>',
            // arrow-right
            'arrow-right' => '<svg class="svgRight'.$class.'" width="512" height="512" fill="currentColor" viewBox="0 0 128 128" enable-background="new 0 0 128 128"><path d="m64 0c-35.289 0-64 28.711-64 64s28.711 64 64 64 64-28.711 64-64-28.711-64-64-64zm0 120c-30.879 0-56-25.121-56-56s25.121-56 56-56 56 25.121 56 56-25.121 56-56 56zm26.828-58.828c1.563 1.563 1.563 4.094 0 5.656l-20 20c-.781.781-1.805 1.172-2.828 1.172s-2.047-.391-2.828-1.172c-1.563-1.563-1.563-4.094 0-5.656l13.172-13.172h-38.344c-2.209 0-4-1.789-4-4s1.791-4 4-4h38.344l-13.172-13.172c-1.563-1.563-1.563-4.094 0-5.656s4.094-1.563 5.656 0z"/></svg>',
            // ruler
            'ruler' => '<svg class="svgRuler'.$class.'" width="466.85" height="466.85" fill="currentColor" viewBox="0 0 466.85 466.85"><path d="M463.925,122.425l-119.5-119.5c-3.9-3.9-10.2-3.9-14.1,0l-327.4,327.4c-3.9,3.9-3.9,10.2,0,14.1l119.5,119.5 c3.9,3.9,10.2,3.9,14.1,0l327.4-327.4C467.825,132.625,467.825,126.325,463.925,122.425z M129.425,442.725l-105.3-105.3l79.1-79.1 l35.9,35.9c3.8,4,10.2,4.1,14.1,0.2c4-3.8,4.1-10.2,0.2-14.1c-0.1-0.1-0.1-0.1-0.2-0.2l-35.9-35.8l26.1-26.1l56,56 c3.9,3.9,10.3,3.9,14.1-0.1c3.9-3.9,3.9-10.2,0-14.1l-56-56l26.1-26.1l35.9,35.8c3.9,3.9,10.2,3.9,14.1,0c3.9-3.9,3.9-10.2,0-14.1 l-35.9-35.8l26.1-26.1l56,56c3.9,3.9,10.2,3.9,14.1,0c3.9-3.9,3.9-10.2,0-14.1l-56-56l26.1-26.1l35.9,35.9 c3.9,3.9,10.2,4,14.1,0.1c3.9-3.9,4-10.2,0.1-14.1c0,0,0,0-0.1-0.1l-35.6-36.2l26.1-26.1l56,56c3.9,3.9,10.2,3.9,14.1,0 c3.9-3.9,3.9-10.2,0-14.1l-56-56l18.8-18.8l105.3,105.3L129.425,442.725z"/><path d="M137.325,331.325c-12.6-12.5-32.9-12.5-45.4,0c-12.5,12.6-12.5,32.9,0,45.4s32.9,12.5,45.4,0 S149.825,343.925,137.325,331.325z M124.225,362.325c-0.2,0.2-0.5,0.5-1.1,0.4c-4.7,4.7-12.4,4.7-17.2,0c-4.7-4.7-4.7-12.4,0-17.2 c4.7-4.7,12.4-4.7,17.2,0C128.025,350.025,128.725,357.425,124.225,362.325z"/></svg>',
            // question
            'question' => '<svg class="svgQuestion'.$class.'" width="40.124px" height="40.124px" enable-background="new 0 0 20 20"  viewBox="0 0 20 20"><path d="m10 0c-5.5 0-10 4.5-10 10s4.5 10 10 10 10-4.5 10-10-4.5-10-10-10zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8z"/><path d="m10.7 4.1c-1.2-.2-2.4.1-3.3.8-.9.8-1.4 1.9-1.4 3.1h2c0-.6.3-1.2.7-1.5.5-.4 1.1-.6 1.7-.5.8.1 1.5.8 1.6 1.6.2.9-.2 1.7-1 2.1-1.2.7-2 1.9-2 3.2h2c0-.6.4-1.2.9-1.5 1.5-.8 2.3-2.5 2-4.2-.2-1.5-1.6-2.9-3.2-3.1z"/><path d="m9 14h2v2h-2z"/></g></svg>',
            // delivery-return
            'delivery-return' => '<svg class="svgDeliveryReturn'.$class.'" width="40.124px" height="40.124px" enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512"><path d="m386.69 304.4c-35.587 0-64.538 28.951-64.538 64.538s28.951 64.538 64.538 64.538c35.593 0 64.538-28.951 64.538-64.538s-28.951-64.538-64.538-64.538zm0 96.807c-17.796 0-32.269-14.473-32.269-32.269s14.473-32.269 32.269-32.269 32.269 14.473 32.269 32.269c0 17.797-14.473 32.269-32.269 32.269z"/><path d="m166.18 304.4c-35.587 0-64.538 28.951-64.538 64.538s28.951 64.538 64.538 64.538 64.538-28.951 64.538-64.538-28.951-64.538-64.538-64.538zm0 96.807c-17.796 0-32.269-14.473-32.269-32.269s14.473-32.269 32.269-32.269c17.791 0 32.269 14.473 32.269 32.269 0 17.797-14.473 32.269-32.269 32.269z"/><path d="m430.15 119.68c-2.743-5.448-8.32-8.885-14.419-8.885h-84.975v32.269h75.025l43.934 87.384 28.838-14.5-48.403-96.268z"/><rect x="216.2" y="353.34" width="122.08" height="32.269"/><path d="m117.78 353.34h-55.932c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h55.933c8.912 0 16.134-7.223 16.134-16.134 0-8.912-7.223-16.134-16.135-16.134z"/><path d="m508.61 254.71-31.736-40.874c-3.049-3.937-7.755-6.239-12.741-6.239h-117.24v-112.94c0-8.912-7.223-16.134-16.134-16.134h-268.91c-8.912 0-16.134 7.223-16.134 16.134s7.223 16.134 16.134 16.134h252.77v112.94c0 8.912 7.223 16.134 16.134 16.134h125.48l23.497 30.268v83.211h-44.639c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h60.773c8.912 0 16.134-7.223 16.135-16.134v-104.87c0-3.582-1.194-7.067-3.388-9.896z"/><path d="m116.71 271.6h-74.219c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h74.218c8.912 0 16.134-7.223 16.134-16.134 1e-3 -8.911-7.222-16.134-16.133-16.134z"/><path d="m153.82 208.13h-137.68c-8.911 0-16.134 7.223-16.134 16.135s7.223 16.134 16.134 16.134h137.68c8.912 0 16.134-7.223 16.134-16.134s-7.222-16.135-16.134-16.135z"/><path d="m180.17 144.67h-137.68c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h137.68c8.912 0 16.134-7.223 16.134-16.134 1e-3 -8.911-7.222-16.134-16.134-16.134z"/></svg>',
            'plus' => '<svg class="svgPlus'.$class.'" width="426.66667pt" height="426.66667pt" fill="currentColor" viewBox="0 0 426.66667 426.66667"><path class="horizontal" d="m410.667969 229.332031h-394.667969c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h394.667969c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path class="vertical" d="m213.332031 426.667969c-8.832031 0-16-7.167969-16-16v-394.667969c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v394.667969c0 8.832031-7.167969 16-16 16zm0 0"/></svg>',
            'smile' => '<svg class="svgSmile'.$class.'" width="40.124px" height="40.124px" fill="currentColor" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M437.02,74.98C388.667,26.629,324.38,0,256,0S123.333,26.629,74.98,74.98C26.629,123.333,0,187.62,0,256 s26.629,132.668,74.98,181.02C123.333,485.371,187.62,512,256,512s132.667-26.629,181.02-74.98 C485.371,388.668,512,324.38,512,256S485.371,123.333,437.02,74.98z M256,472c-119.103,0-216-96.897-216-216S136.897,40,256,40 s216,96.897,216,216S375.103,472,256,472z"/><path d="M368.993,285.776c-0.072,0.214-7.298,21.626-25.02,42.393C321.419,354.599,292.628,368,258.4,368 c-34.475,0-64.195-13.561-88.333-40.303c-18.92-20.962-27.272-42.54-27.33-42.691l-37.475,13.99 c0.42,1.122,10.533,27.792,34.013,54.273C171.022,389.074,212.215,408,258.4,408c46.412,0,86.904-19.076,117.099-55.166 c22.318-26.675,31.165-53.55,31.531-54.681L368.993,285.776z"/><circle cx="168" cy="180.12" r="32"/><circle cx="344" cy="180.12" r="32"/></svg>',
            'shipping' => '<svg class="svgShipping'.$class.'" width="40.124px" height="40.124px" enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve"><circle cx="386" cy="210" r="20"/><path d="m432 40h-26v-20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-91v-20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-90v-20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-25c-44.112 0-80 35.888-80 80v312c0 44.112 35.888 80 80 80h153c11.046 0 20-8.954 20-20s-8.954-20-20-20h-153c-22.056 0-40-17.944-40-40v-312c0-22.056 17.944-40 40-40h25v20c0 11.046 8.954 20 20 20s20-8.954 20-20v-20h90v20c0 11.046 8.954 20 20 20s20-8.954 20-20v-20h91v20c0 11.046 8.954 20 20 20s20-8.954 20-20v-20h26c22.056 0 40 17.944 40 40v114c0 11.046 8.954 20 20 20s20-8.954 20-20v-114c0-44.112-35.888-80-80-80z"/><path d="m391 270c-66.72 0-121 54.28-121 121s54.28 121 121 121 121-54.28 121-121-54.28-121-121-121zm0 202c-44.663 0-81-36.336-81-81s36.337-81 81-81 81 36.336 81 81-36.337 81-81 81z"/><path d="m420 371h-9v-21c0-11.046-8.954-20-20-20s-20 8.954-20 20v41c0 11.046 8.954 20 20 20h29c11.046 0 20-8.954 20-20s-8.954-20-20-20z"/><circle cx="299" cy="210" r="20"/><circle cx="212" cy="297" r="20"/><circle cx="125" cy="210" r="20"/><circle cx="125" cy="297" r="20"/><circle cx="125" cy="384" r="20"/><circle cx="212" cy="384" r="20"/><circle cx="212" cy="210" r="20"/></svg>',
            'share' => '<svg class="svgShare'.$class.'" height="512pt" viewBox="-21 0 512 512" width="512pt" fill="currentColor"><path d="m389.332031 160c-44.09375 0-80-35.882812-80-80s35.90625-80 80-80c44.097657 0 80 35.882812 80 80s-35.902343 80-80 80zm0-128c-26.453125 0-48 21.523438-48 48s21.546875 48 48 48 48-21.523438 48-48-21.546875-48-48-48zm0 0"/><path d="m389.332031 512c-44.09375 0-80-35.882812-80-80s35.90625-80 80-80c44.097657 0 80 35.882812 80 80s-35.902343 80-80 80zm0-128c-26.453125 0-48 21.523438-48 48s21.546875 48 48 48 48-21.523438 48-48-21.546875-48-48-48zm0 0"/><path d="m80 336c-44.097656 0-80-35.882812-80-80s35.902344-80 80-80 80 35.882812 80 80-35.902344 80-80 80zm0-128c-26.453125 0-48 21.523438-48 48s21.546875 48 48 48 48-21.523438 48-48-21.546875-48-48-48zm0 0"/><path d="m135.703125 240.425781c-5.570313 0-10.988281-2.902343-13.910156-8.0625-4.375-7.679687-1.707031-17.453125 5.972656-21.824219l197.953125-112.855468c7.65625-4.414063 17.449219-1.726563 21.800781 5.976562 4.375 7.679688 1.707031 17.449219-5.972656 21.824219l-197.953125 112.851563c-2.496094 1.40625-5.203125 2.089843-7.890625 2.089843zm0 0"/><path d="m333.632812 416.425781c-2.6875 0-5.398437-.683593-7.894531-2.109375l-197.953125-112.855468c-7.679687-4.371094-10.34375-14.144532-5.972656-21.824219 4.351562-7.699219 14.125-10.367188 21.804688-5.972657l197.949218 112.851563c7.679688 4.375 10.347656 14.144531 5.976563 21.824219-2.945313 5.183594-8.363281 8.085937-13.910157 8.085937zm0 0"/></svg>',
            'trash' => '<svg class="svgTrash'.$class.'" fill="currentColor" height="427pt" viewBox="-40 0 427 427.00131" width="427pt"><path d="m232.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/><path d="m114.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/><path d="m28.398438 127.121094v246.378906c0 14.5625 5.339843 28.238281 14.667968 38.050781 9.285156 9.839844 22.207032 15.425781 35.730469 15.449219h189.203125c13.527344-.023438 26.449219-5.609375 35.730469-15.449219 9.328125-9.8125 14.667969-23.488281 14.667969-38.050781v-246.378906c18.542968-4.921875 30.558593-22.835938 28.078124-41.863282-2.484374-19.023437-18.691406-33.253906-37.878906-33.257812h-51.199218v-12.5c.058593-10.511719-4.097657-20.605469-11.539063-28.03125-7.441406-7.421875-17.550781-11.5546875-28.0625-11.46875h-88.796875c-10.511719-.0859375-20.621094 4.046875-28.0625 11.46875-7.441406 7.425781-11.597656 17.519531-11.539062 28.03125v12.5h-51.199219c-19.1875.003906-35.394531 14.234375-37.878907 33.257812-2.480468 19.027344 9.535157 36.941407 28.078126 41.863282zm239.601562 279.878906h-189.203125c-17.097656 0-30.398437-14.6875-30.398437-33.5v-245.5h250v245.5c0 18.8125-13.300782 33.5-30.398438 33.5zm-158.601562-367.5c-.066407-5.207031 1.980468-10.21875 5.675781-13.894531 3.691406-3.675781 8.714843-5.695313 13.925781-5.605469h88.796875c5.210937-.089844 10.234375 1.929688 13.925781 5.605469 3.695313 3.671875 5.742188 8.6875 5.675782 13.894531v12.5h-128zm-71.199219 32.5h270.398437c9.941406 0 18 8.058594 18 18s-8.058594 18-18 18h-270.398437c-9.941407 0-18-8.058594-18-18s8.058593-18 18-18zm0 0"/><path d="m173.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/></svg>',
            '360deg' => '<svg class="svg360Deg'.$class.'" fill="currentColor" height="512pt" viewBox="0 -66 512 512" width="512pt"><path d="m138.664062 230.164062c26.601563 0 48.070313-11.78125 48.070313-42.941406v-3.609375c0-15.390625-8.167969-23.75-19.378906-27.929687 9.5-4.371094 14.628906-17.292969 14.628906-31.160156 0-25.652344-18.238281-34.390626-42.371094-34.390626-32.679687 0-43.316406 19.1875-43.316406 34.007813 0 9.121094 1.707031 11.972656 15.386719 11.972656 11.019531 0 13.871094-4.371093 13.871094-10.832031 0-7.410156 4.75-9.6875 14.058593-9.6875 7.792969 0 14.0625 2.660156 14.0625 13.679688 0 15.390624-7.601562 16.339843-14.820312 16.339843-6.460938 0-8.550781 5.699219-8.550781 11.402344 0 5.699219 2.089843 11.398437 8.550781 11.398437 10.449219 0 18.242187 2.46875 18.242187 15.199219v3.609375c0 12.351563-4.5625 17.101563-17.480468 17.101563-8.550782 0-16.910157-2.089844-16.910157-11.019531 0-7.222657-3.042969-9.882813-15.199219-9.882813-10.453124 0-14.0625 2.28125-14.0625 10.832031 0 15.960938 12.539063 35.910156 45.21875 35.910156zm0 0"/><path d="m256.273438 115.972656c8.929687 0 16.53125 3.800782 16.53125 11.019532 0 8.738281 7.21875 10.828124 15.390624 10.828124 9.5 0 13.871094-2.847656 13.871094-11.96875 0-15.769531-12.730468-35.71875-44.839844-35.71875-27.363281 0-48.453124 12.160157-48.453124 44.839844v50.351563c0 32.679687 20.519531 44.839843 46.742187 44.839843 26.21875 0 46.550781-12.160156 46.550781-44.839843v-1.710938c0-30.398437-18.242187-39.898437-39.902344-39.898437-9.117187 0-17.667968 1.707031-23.75 8.355468v-17.097656c0-13.113281 6.652344-19 17.859376-19zm-.949219 50.539063c10.832031 0 17.101562 5.320312 17.101562 19.191406v1.710937c0 13.109376-6.269531 18.808594-16.910156 18.808594s-17.101563-5.699218-17.101563-18.808594v-3.421874c0-12.539063 6.652344-17.480469 16.910157-17.480469zm0 0"/><path d="m371.796875 169.933594c5.886719 0 9.5-3.992188 9.5-9.691406 0-5.890626-3.613281-9.5-9.5-9.5-6.082031 0-9.691406 3.609374-9.691406 9.5 0 5.699218 3.609375 9.691406 9.691406 9.691406zm0 0"/><path d="m371.605469 230.164062c26.21875 0 46.738281-12.160156 46.738281-44.84375v-50.347656c0-32.683594-20.519531-44.839844-46.738281-44.839844-26.222657 0-46.550781 12.15625-46.550781 44.839844v50.347656c0 32.683594 20.328124 44.84375 46.550781 44.84375zm-16.910157-95.191406c0-13.109375 6.269532-19 16.910157-19s17.097656 5.890625 17.097656 19v50.351563c0 13.109375-6.457031 19-17.097656 19s-16.910157-5.890625-16.910157-19zm0 0"/><path d="m454.351562 90c24.8125 0 45-20.1875 45-45s-20.1875-45-45-45c-24.816406 0-45 20.1875-45 45s20.183594 45 45 45zm0-60c8.269532 0 15 6.730469 15 15s-6.730468 15-15 15c-8.273437 0-15-6.730469-15-15s6.726563-15 15-15zm0 0"/><path d="m466.847656 146.503906c-6.824218-4.691406-16.164062-2.96875-20.859375 3.859375-4.695312 6.824219-2.96875 16.164063 3.855469 20.859375 14.667969 10.089844 32.15625 26.269532 32.15625 46.039063 0 17.9375-14.941406 36.519531-42.078125 52.332031-29.671875 17.285156-72.117187 30.132812-119.515625 36.167969-8.21875 1.046875-14.03125 8.558593-12.984375 16.777343.964844 7.574219 7.421875 13.105469 14.859375 13.105469.632812 0 1.273438-.039062 1.917969-.121093 52.039062-6.628907 97.277343-20.464844 130.824219-40.011719 37.273437-21.714844 56.976562-48.773438 56.976562-78.25 0-25.96875-15.613281-50.4375-45.152344-70.757813zm0 0"/><path d="m226.605469 274.15625c-5.855469-5.859375-15.355469-5.859375-21.210938 0-5.859375 5.855469-5.859375 15.355469 0 21.210938l13.0625 13.066406c-47.960937-3.417969-92.023437-13.363282-126.761719-28.855469-39.207031-17.492187-61.695312-40.203125-61.695312-62.316406 0-17.652344 14.554688-36 40.980469-51.664063 7.128906-4.226562 9.480469-13.425781 5.257812-20.550781-4.226562-7.128906-13.425781-9.480469-20.554687-5.257813-46.023438 27.28125-55.683594 57.1875-55.683594 77.472657 0 34.992187 28.226562 66.851562 79.476562 89.714843 38.949219 17.371094 88.226563 28.324219 141.414063 31.679688l-15.496094 15.5c-5.859375 5.855469-5.859375 15.355469 0 21.210938 2.929688 2.929687 6.765625 4.394531 10.605469 4.394531s7.679688-1.464844 10.605469-4.394531l40-40c5.859375-5.855469 5.859375-15.351563 0-21.210938zm0 0"/></svg>',
            'best-seller' => '<svg class="svgBestSeller'.$class.'" fill="currentColor" height="512pt" viewBox="-8 0 512 512" width="512pt"><path d="m247.5 512-65.347656-54.921875-87.613282 9.449219-18.101562-86.234375-76.4375-43.871094 36.0625-80.421875-36.0625-80.421875 76.4375-43.871094 18.101562-86.234375 87.613282 9.449219 65.347656-54.921875 65.347656 54.921875 87.613282-9.449219 18.101562 86.234375 76.4375 43.871094-36.0625 80.421875 36.0625 80.421875-76.4375 43.871094-18.101562 86.234375-87.613282-9.449219zm0 0" fill="#ff641a"/><path d="m312.847656 457.078125 87.613282 9.449219 18.101562-86.234375 76.4375-43.871094-36.0625-80.421875 36.0625-80.421875-76.4375-43.871094-18.101562-86.234375-87.613282 9.449219-65.347656-54.921875v512zm0 0" fill="#f03800"/><path d="m157.5 241h-30v-45h-30v120h30v-45h30v45h30v-120h-30zm0 0" fill="#fff7cc"/><path d="m397.5 196h-90v30h30v90h30v-90h30zm0 0" fill="#ffe6b3"/><path d="m247.5 196c-24.8125 0-45 20.1875-45 45v30c0 24.8125 20.1875 45 45 45s45-20.1875 45-45v-30c0-24.8125-20.1875-45-45-45zm15 75c0 8.277344-6.722656 15-15 15s-15-6.722656-15-15v-30c0-8.277344 6.722656-15 15-15s15 6.722656 15 15zm0 0" fill="#fff7cc"/><path d="m262.5 241v30c0 8.277344-6.722656 15-15 15v30c24.8125 0 45-20.1875 45-45v-30c0-24.8125-20.1875-45-45-45v30c8.277344 0 15 6.722656 15 15zm0 0" fill="#ffe6b3"/></svg>',
            'featured' => '<svg class="svgFeatured'.$class.'" fill="currentColor" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"><g><g><path d="m494.89 204.7c-17.65-23.66-29.47-51.79-34.2-81.33-2.91-18.16-11.34-34.65-24.38-47.69-13.03-13.03-29.52-21.46-47.68-24.37-29.54-4.73-57.67-16.55-81.33-34.2-15.01-11.19-32.75-17.11-51.3-17.11s-36.29 5.92-51.3 17.11c-23.66 17.65-51.79 29.47-81.33 34.2-18.16 2.91-34.65 11.34-47.69 24.38-13.03 13.03-21.46 29.52-24.37 47.68-4.73 29.54-16.55 57.67-34.2 81.33-11.19 15.01-17.11 32.75-17.11 51.3s5.92 36.29 17.11 51.3c17.65 23.66 29.47 51.79 34.2 81.33 2.91 18.16 11.34 34.64 24.38 47.69 13.04 13.03 29.52 21.46 47.68 24.37 29.54 4.73 57.67 16.55 81.33 34.2 15.01 11.19 32.75 17.11 51.3 17.11s36.29-5.92 51.3-17.11c23.66-17.65 51.79-29.47 81.33-34.2 18.16-2.91 34.65-11.34 47.69-24.38 13.03-13.03 21.46-29.52 24.37-47.68 2.37-14.77 6.5-29.19 12.25-42.87 5.76-13.68 13.12-26.63 21.95-38.46 11.19-15.01 17.11-32.75 17.11-51.3s-5.92-36.29-17.11-51.3z" fill="#fff239"/></g><g><path d="m512 256c0 18.55-5.92 36.29-17.11 51.3-8.83 11.83-16.19 24.78-21.95 38.46-5.75 13.68-9.88 28.1-12.25 42.87-2.91 18.16-11.34 34.65-24.37 47.68-13.04 13.04-29.53 21.47-47.69 24.38-29.54 4.73-57.67 16.55-81.33 34.2-15.01 11.19-32.75 17.11-51.3 17.11v-512c18.55 0 36.29 5.92 51.3 17.11 23.66 17.65 51.79 29.47 81.33 34.2 18.16 2.91 34.65 11.34 47.68 24.37 13.04 13.04 21.47 29.53 24.38 47.69 4.73 29.54 16.55 57.67 34.2 81.33 11.19 15.01 17.11 32.75 17.11 51.3z" fill="#ffd600"/></g><g><path d="m256 73c-100.91 0-183 82.09-183 183s82.09 183 183 183 183-82.09 183-183-82.09-183-183-183z" fill="#ffd600"/></g><g><path d="m439 256c0 100.91-82.09 183-183 183v-366c100.91 0 183 82.09 183 183z" fill="#ffb229"/></g><g><path d="m358.13 218.96c-2.13-5.97-7.79-9.96-14.13-9.96h-54.22l-19.68-54.13c-2.16-5.92-7.79-9.87-14.1-9.87s-11.94 3.95-14.1 9.87l-19.68 54.13h-54.22c-6.34 0-12 3.99-14.13 9.96s-.28 12.63 4.63 16.65l41.65 34.08-22.25 61.18c-2.18 6.02-.31 12.76 4.66 16.79 4.98 4.03 11.96 4.45 17.39 1.06l56.05-35.03 56.05 35.03c2.44 1.53 5.2 2.28 7.95 2.28 3.36 0 6.7-1.13 9.44-3.34 4.97-4.03 6.84-10.77 4.66-16.79l-22.25-61.18 41.65-34.08c4.91-4.02 6.76-10.68 4.63-16.65z" fill="#fff239"/></g><g><path d="m353.5 235.61-41.65 34.08 22.25 61.18c2.18 6.02.31 12.76-4.66 16.79-2.74 2.21-6.08 3.34-9.44 3.34-2.75 0-5.51-.75-7.95-2.28l-56.05-35.03v-168.69c6.31 0 11.94 3.95 14.1 9.87l19.68 54.13h54.22c6.34 0 12 3.99 14.13 9.96s.28 12.63-4.63 16.65z" fill="#ffd600"/></g></g></svg>',
            'instock' => '<svg class="svgInstock'.$class.'" fill="currentColor" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"><g><g><g><path d="m153.25 342.422-25.24 166.426c-2.812 0-5.625-.659-8.211-1.978l-22.695-11.569-86.731-44.215c-6.345-3.235-10.373-9.932-10.373-17.256v-132.1c0-3.698 1.02-7.232 2.854-10.24l118.708 40.198z" fill="#d5daf3"/><path d="m153.25 342.422-25.24 166.426c-2.812 0-5.625-.659-8.211-1.978l-22.695-11.569v-155.764l24.456-7.85z" fill="#bec6ed"/><path d="m128.009 355.291v153.559c2.804 0 5.619-.66 8.199-1.981l119.792-61.055 22.081-74.599-22.081-81.178-81.81 20.266z" fill="#d5daf3"/><path d="m256 290.037 22.081 81.178-22.081 74.596-119.789 61.059c-2.586 1.319-5.398 1.978-8.2 1.978v-13.547l88.212-44.967c5.445-2.776 8.873-8.37 8.873-14.482v-130.063l5.828-9.539z" fill="#bec6ed"/><path d="m256 290.037-143.442 57.371-109.711-55.926c1.732-2.841 4.187-5.233 7.177-6.828l117.985-63.41 75.036 21.765z" fill="#6c7fd8"/><path d="m256 290.037-127.99 65.252-15.453-7.881 102.348-52.176c4.305-2.195 4.372-8.322.115-10.609l-102.463-55.077 15.453-8.303 75.035 21.768z" fill="#4f66d0"/></g><g><path d="m415.369 339.29-31.379 169.558c-2.802 0-5.615-.659-8.2-1.978l-22.705-11.569-97.085-49.49v-155.774l138.364 42.763z" fill="#d5daf3"/><path d="m415.369 339.29-31.379 169.558c-2.802 0-5.615-.659-8.2-1.978l-22.705-11.569v-155.764l41.279-6.737z" fill="#bec6ed"/><path d="m383.994 355.29v153.563c2.81 0 5.62-.66 8.207-1.981l109.425-55.785c6.348-3.234 10.373-9.931 10.373-17.258v-132.101c0-3.695-1.023-7.227-2.852-10.243l-70.301 20.081z" fill="#d5daf3"/><path d="m512 301.73v132.1c0 7.325-4.028 14.021-10.374 17.256l-109.426 55.784c-2.586 1.319-5.398 1.978-8.211 1.978v-13.547l86.731-44.215c6.346-3.235 10.374-9.931 10.374-17.256v-128.041l6.038-8.014 22.014-6.285c1.834 3.008 2.854 6.541 2.854 10.24z" fill="#bec6ed"/><path d="m509.157 291.479-140.62 55.929-112.537-57.371 32.636-30.411 17.822-16.617 77.531-21.768 40.836 21.943 77.15 41.465c2.989 1.597 5.451 3.997 7.182 6.83z" fill="#6c7fd8"/><g fill="#4f66d0"><path d="m509.157 291.479-125.167 63.81-15.453-7.881 102.355-52.177c4.237-2.16 4.45-8.268.268-10.533-.03-.016-.06-.032-.089-.048l-102.534-55.104 15.453-8.303 117.987 63.408c2.987 1.595 5.449 3.995 7.18 6.828z"/><path d="m424.826 243.185c-9.375 30.72-37.942 53.065-71.742 53.065-27.392 0-51.365-14.69-64.448-36.623l17.822-16.617 77.531-21.768z"/></g></g><g><path d="m278.077 123.467-52.982 149.953-97.084-52.179v-140.073c0-3.698 1.02-7.232 2.843-10.25l120.284 42.938z" fill="#d5daf3"/><path d="m278.077 123.467-22.077 166.57-30.905-16.617v-154.455l26.043-5.109z" fill="#bec6ed"/><path d="m383.99 81.168-88.771 187.792-39.219 21.077v-155.32l52.986-36.156 72.15-27.643c1.834 3.018 2.854 6.552 2.854 10.25z" fill="#d5daf3"/><path d="m381.136 70.918-24.405 9.35-3.647 4.948v51.842c0 4.993-3.787 9.104-8.747 9.68-37.303 4.333-66.26 36.038-66.26 74.503 0 18.121 6.428 34.758 17.142 47.718l57.865-31.105v.004l30.905-16.617v-68.373-71.7c.001-3.698-1.019-7.232-2.853-10.25z" fill="#bec6ed"/><path d="m381.136 70.922-140.589 55.914-109.689-55.914c1.733-2.847 4.181-5.233 7.172-6.834l109.409-58.776c.03-.012.054-.031.084-.043 5.349-2.841 11.696-2.828 17.033.043l109.409 58.777c2.989 1.6 5.444 3.986 7.171 6.833z" fill="#6c7fd8"/><path d="m381.136 70.918-125.136 63.799-15.453-7.881 102.335-52.172c4.235-2.159 4.447-8.264.267-10.528-.03-.016-.06-.032-.089-.048l-102.513-55.064 6.892-3.709c.031-.021.051-.031.082-.051 5.347-2.833 11.693-2.823 17.029.051l109.416 58.772c2.988 1.597 5.439 3.987 7.17 6.831z" fill="#4f66d0"/></g></g><path d="m444.523 221.244c0-41.426-57.613-73.633-57.613-73.633l-18.363.219c-34.18 6.994-59.561 37.166-59.561 73.413 0 36.221 25.418 66.385 59.561 73.408l17.965-.593c0 .002 58.011-31.388 58.011-72.814z" fill="#0ed2b3"/><path d="m458.997 221.242c0 41.424-33.574 75.007-75.007 75.007-5.295 0-10.456-.546-15.442-1.597 34.006-7.119 59.544-37.282 59.544-73.411 0-36.128-25.538-66.292-59.544-73.411 4.986-1.051 10.147-1.597 15.442-1.597 41.434.001 75.007 33.585 75.007 75.009z" fill="#0ab69f"/><g><g><path d="m373.796 255.284c-1.88 0-3.764-.682-5.25-2.059l-24.989-23.154c-3.13-2.9-3.317-7.789-.417-10.919s7.789-3.317 10.918-.417l19.396 17.971 38.047-39.734c2.942-3.092 7.833-3.213 10.923-.273 3.092 2.941 3.214 7.831.273 10.923l-43.302 45.26c-1.517 1.596-3.556 2.402-5.599 2.402z" fill="#f3f0f3"/></g></g></g></svg>',
            'instock-2' => '<svg class="svgInstock'.$class.'" height="512" viewBox="0 0 512 512" width="512" data-name="Layer 1"><path d="m441.667 118.253-192-85.333a10.687 10.687 0 0 0 -8.667 0l-192 85.333a10.669 10.669 0 0 0 -6.333 9.747v234.667a10.669 10.669 0 0 0 6.333 9.747l192 85.333a10.673 10.673 0 0 0 8.667 0l192-85.333a10.669 10.669 0 0 0 6.333-9.747v-234.667a10.669 10.669 0 0 0 -6.333-9.747z" fill="#ff9500"/><path d="m249.667 457.747 192-85.333a10.669 10.669 0 0 0 6.333-9.747v-234.667a10.669 10.669 0 0 0 -6.333-9.747l-192-85.333a10.687 10.687 0 0 0 -4.334-.92v426.667a10.7 10.7 0 0 0 4.334-.92z" fill="#fbab01"/><path d="m245.333 213.333 201.65-89.622a10.572 10.572 0 0 0 -5.316-5.459l-192-85.333a10.687 10.687 0 0 0 -8.667 0l-192 85.334a10.572 10.572 0 0 0 -5.316 5.459z" fill="#fac100"/><path d="m156.467 173.837 205.133-91.17-26.265-11.673-205.133 91.17z" fill="#fbab01"/><circle cx="373.333" cy="362.667" fill="#00cf66" r="96"/><path d="m389.333 437.333a90.608 90.608 0 0 1 -56.1-161.807 95.949 95.949 0 1 0 127.241 127.238 90.434 90.434 0 0 1 -71.141 34.569z" fill="#00b157"/><path d="m362.667 405.333a10.632 10.632 0 0 1 -7.542-3.125l-26.667-26.667a10.666 10.666 0 0 1 15.083-15.083l19.125 19.122 45.792-45.789a10.666 10.666 0 1 1 15.083 15.083l-53.333 53.333a10.632 10.632 0 0 1 -7.541 3.126z" fill="#eaeff0"/></svg>',
            'onsale' => '<svg class="svgOnsale'.$class.'" fill="currentColor" x="0px" y="0px" viewBox="0 0 511.548 511.548" style="enable-background:new 0 0 511.548 511.548;" width="512" height="512"><g><path style="fill:#FF6200;" d="M394.441,191.548C307.52,95.547,287.775,20.882,287.775,20.882s-15.054,6.718-32,22.11 l-21.333,244.556l21.333,209h0.001c104.842-0.001,189.833-84.992,189.833-189.833C445.608,263.409,421.423,221.349,394.441,191.548 z"/><path style="fill:#FD7D21;" d="M223.775,84.882c-10.873,21.747-13.434,46.265-13.33,65.08c0.1,18.252-12.758,34.004-30.655,37.584 c-12.504,2.501-25.43-1.413-34.447-10.43l-17.568-17.568c0,0-26.044,35.911-30.507,42.667 c-20.047,30.346-31.613,66.786-31.321,105.945c0.778,104.581,85.244,188.388,189.828,188.388V42.992 C244.69,53.06,232.797,66.838,223.775,84.882z"/><g><path style="fill:#FFB62D;" d="M405.561,181.48c-43.372-47.903-69.147-90.072-83.134-117.013 c-15.148-29.181-20.112-47.276-20.15-47.42L297.768,0l-16.104,7.183c-0.917,0.409-11.941,5.434-25.89,16.238l-10.667,18.794 l10.667,22.117c8.336-9.351,16.934-16.341,23.849-21.18c11.282,28.696,39.881,87.981,103.699,158.465 c14.217,15.702,47.285,57.376,47.285,105.099c0,96.403-78.43,174.833-174.832,174.833h-0.001l-10.667,19.333l10.667,10.667h0.001 c112.945-0.001,204.832-91.888,204.832-204.833C460.608,265.764,440.544,220.118,405.561,181.48z"/><path style="fill:#FDCB02;" d="M132.499,430.925c-32.898-32.646-51.206-76.285-51.553-122.876 c-0.26-34.878,9.712-68.616,28.837-97.565c2.335-3.534,11.702-16.602,19.833-27.879l5.119,5.119 c12.592,12.592,30.53,18.025,47.996,14.532c24.888-4.978,42.852-27.004,42.713-52.375c-0.087-15.701,1.881-38.558,11.746-58.29 c5.351-10.702,11.883-19.741,18.584-27.258V23.421c-14.692,11.381-32.628,29.175-45.417,54.753 c-12.515,25.031-15.018,52.9-14.913,71.87c0.061,11.04-7.761,20.626-18.598,22.793c-7.598,1.518-15.414-0.844-20.898-6.328 l-29.997-29.997l-10.319,14.229c-1.071,1.477-26.289,36.256-30.88,43.205c-22.419,33.937-34.109,73.47-33.806,114.325 c0.406,54.565,21.864,105.686,60.421,143.948c38.554,38.259,89.839,59.329,144.407,59.329v-30 C209.176,481.548,165.396,463.57,132.499,430.925z"/></g><g><path style="fill:#ED3800;" d="M255.775,206.042c-0.111,0-0.222,0.004-0.333,0.004l-24.997,117.329l24.997,117.329 c0.111,0,0.222,0.004,0.333,0.004c64.801,0,117.333-52.532,117.333-117.333C373.108,258.574,320.576,206.042,255.775,206.042z"/><path style="fill:#FF4B00;" d="M138.441,323.375c0,64.69,52.352,117.149,117,117.329V206.046    C190.794,206.226,138.441,258.685,138.441,323.375z"/></g><g><polygon style="fill:#D9E7EC;" points="319.432,254.503 286.177,254.503 255.441,299.513 245.108,340.882 255.441,348.214 "/><path style="fill:#D9E7EC;" d="M306.248,317.472c-20.858,0-36.601,13.971-36.601,38.372c0,24.597,15.742,38.371,36.601,38.371 s36.601-13.774,36.601-38.371C342.849,331.443,327.106,317.472,306.248,317.472z M306.248,372.963 c-4.329,0-8.658-3.936-8.658-17.12c0-13.184,4.329-17.12,8.658-17.12s8.658,3.936,8.658,17.12    C314.906,369.027,310.577,372.963,306.248,372.963z"/><polygon style="fill:#FAFCFD;" points="225.372,392.247 255.441,348.214 255.441,299.513 192.117,392.247"/><path style="fill:#FAFCFD;" d="M241.902,290.907c0-24.4-15.742-38.372-36.601-38.372s-36.601,13.971-36.601,38.372 c0,24.597,15.742,38.372,36.601,38.372S241.902,315.504,241.902,290.907z M196.643,290.907c0-13.184,4.329-17.12,8.658-17.12 c4.329,0,8.658,3.936,8.658,17.12c0,13.184-4.329,17.12-8.658,17.12C200.972,308.027,196.643,304.091,196.643,290.907z"/></g></g></svg>',
            'flash-sale' => '<svg class="svgFlashsale'.$class.'" fill="currentColor" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"> <polygon style="fill:#EF5350;" points="484.016,289.897 512,263.895 485.576,236.31 506.809,204.557 474.735,183.809 488.072,148.014 452.078,135.223 456.802,97.317 418.828,93.172 414.683,55.198 376.777,59.922 363.986,23.928 328.191,37.265 307.443,5.191 275.69,26.424 248.105,0 222.103,27.984 189.168,8.633 170.321,41.858 133.811,30.625 123.134,67.302 85.018,64.79 83.087,102.94 45.419,109.287 52.338,146.854 17.149,161.717 32.545,196.676 1.733,219.252 24.776,249.719 0,278.793 29.448,303.124 12.045,337.128 46.311,354.011 37.218,391.112 74.454,399.639 74.164,437.836 112.361,437.546 120.888,474.782 157.989,465.689 174.872,499.955 208.876,482.552 233.207,512 262.281,487.224 292.748,510.267 315.324,479.454 350.283,494.851 365.146,459.662 402.713,466.581 409.059,428.913 447.21,426.982 444.698,388.866 481.375,378.189 470.142,341.679 503.367,322.832 "/><g><path style="fill:#FFFFFF;" d="M157.512,325.436c-8.771-19.608-48.044,5.174-61.902-25.806 c-8.712-19.478,5.039-33.629,20.072-40.353c7.712-3.45,25.656-9.279,29.515-0.651c1.345,3.007,1.943,9.955-2.764,12.06 c-4.053,1.812-9.28-1.81-20.262,3.102c-9.413,4.209-13.075,10.399-10.269,16.673c7.25,16.209,46.697-8.181,61.84,25.676 c8.362,18.694-0.382,34.213-18.423,42.282c-17.125,7.659-34.056,4.88-37.447-2.702c-1.638-3.66-0.694-10.671,3.358-12.484 c5.36-2.397,13.391,6.089,26.725,0.126C155.801,339.85,161.02,333.28,157.512,325.436z"/> <path style="fill:#FFFFFF;" d="M198.17,329.369c-0.116-0.261-0.22-0.842-0.322-1.424l-11.549-93.509 c-0.578-4.447,3.441-8.441,8.277-10.606c4.967-2.221,10.623-2.554,13.553,0.841l62.008,70.939c0.365,0.465,0.672,0.798,0.847,1.19 c1.813,4.053-2.988,9.808-7.564,11.854c-2.875,1.287-5.507,1.365-7.271-0.826l-12.744-15.164l-29.936,13.39l2.809,19.607 c0.458,2.775-1.354,4.685-4.231,5.971C207.47,333.682,200.041,333.553,198.17,329.369z M233.78,280.968l-29.324-35.045 l6.578,45.219L233.78,280.968z"/><path style="fill:#FFFFFF;" d="M301.062,291.818c-3.791,1.696-8.267,1.502-9.847-2.027l-38.005-84.968 c-1.638-3.661,1.844-7.101,6.156-9.031c4.184-1.871,9.2-2.231,10.835,1.429l33.738,75.427l31.897-14.267 c3.399-1.521,6.734,1.379,8.431,5.17c1.638,3.66,1.632,8.212-1.767,9.732L301.062,291.818z"/><path style="fill:#FFFFFF;" d="M359.945,200.063l19.869-8.887c3.401-1.521,6.823,0.871,8.402,4.4 c1.344,3.006,1.224,7.297-2.436,8.933l-19.871,8.887l11.752,26.276l36.996-16.548c3.399-1.521,6.937,1.132,8.75,5.185 c1.579,3.529,1.573,8.081-2.086,9.718l-46.537,20.816c-3.791,1.696-8.267,1.502-9.847-2.027l-37.948-84.839 c-1.579-3.529,1.264-6.997,5.054-8.693l46.537-20.816c3.66-1.637,7.055,1.394,8.634,4.923c1.813,4.053,1.431,8.459-1.97,9.979 l-36.994,16.548L359.945,200.063z"/></g></svg>',
            'top-rated' => '<svg class="svgToprated'.$class.'" fill="currentColor" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"><g><path d="m361 377 49.2 15-8.101 45-41.099 15 35.698 15-8.101 45h-120.298c-28.799 0-56.999-10.8-78.3-30h-69l30-165h45c8.401 0 15-6.599 15-15v-105c32.999 0 60 27.001 60 60v60h152.703l-8.101 45z" fill="#ffd5cc"/><path d="m407.501 407h-272.865l-13.636 75h69c21.301 19.2 49.501 30 78.3 30h120.298l8.101-45-35.699-15 41.1-15z" fill="#ffc0b3"/><g id="Customer_Feedback_2_"><g><path d="m151 512h-60v-195h60z" fill="#4d5e80"/></g><g><path d="m402.1 437-5.402 30h-95.698v-30z" fill="#fa9"/></g><g><path d="m415.602 362-5.402 30h-109.2v-30z" fill="#ffc0b3"/></g><g><path d="m311.195 169.849-55.195-29.019-55.195 29.019 10.547-61.465-44.648-43.521 61.699-8.965 27.597-55.898 27.598 55.898 61.699 8.965-44.648 43.521z" fill="#ffdf40"/></g><g><path d="m477.898 257.967-55.195-29.019-55.195 29.019 10.547-61.465-44.648-43.521 61.699-8.965 27.598-55.898 27.598 55.898 61.698 8.965-44.648 43.521z" fill="#ffbe40"/></g><g><path d="m144.492 257.967-55.195-29.019-55.195 29.019 10.547-61.465-44.649-43.521 61.699-8.965 27.598-55.898 27.598 55.898 61.699 8.965-44.648 43.521z" fill="#ffdf40"/></g></g><path d="m311.195 169.849-10.547-61.465 44.649-43.521-61.699-8.965-27.598-55.898v140.83z" fill="#ffbe40"/><path d="m91 407h60v105h-60z" fill="#3d4b66"/></g></svg>',
            'full-screen' => '<svg class="svgFullscreen'.$class.'" fill="currentColor" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"><g><path d="M128,32V0H16C7.163,0,0,7.163,0,16v112h32V54.56L180.64,203.2l22.56-22.56L54.56,32H128z"/><path d="M496,0H384v32h73.44L308.8,180.64l22.56,22.56L480,54.56V128h32V16C512,7.163,504.837,0,496,0z"/><path d="M480,457.44L331.36,308.8l-22.56,22.56L457.44,480H384v32h112c8.837,0,16-7.163,16-16V384h-32V457.44z"/><path d="M180.64,308.64L32,457.44V384H0v112c0,8.837,7.163,16,16,16h112v-32H54.56L203.2,331.36L180.64,308.64z"/></g></svg>',
            'flash' => '<svg class="svgFlash'.$class.'" fill="currentColor" viewBox="0 0 512 512" width="512"><g id="a"><g><path d="m452.51 194.38c3.59-3.25 21.83-19.17 24.92-21.99 5 5.57 9.58 10.59 10.24 11.13 2.28 2.05 6.34 2.46 9.4.71 1.83-1.06 4.24-2.64 7.18-5.21 2.93-2.58 4.81-4.76 6.11-6.45 2.15-2.81 2.32-6.93.62-9.5-.96-1.62-20.53-25.25-22.82-27.75-2.13-2.64-22.54-25.53-24-26.72-2.28-2.06-6.34-2.46-9.4-.71-1.83 1.06-4.24 2.64-7.18 5.21-2.93 2.58-4.81 4.76-6.11 6.44-2.15 2.81-2.32 6.93-.62 9.5.44.74 4.72 6.02 9.47 11.8-2.85 2.39-20.75 17.81-24.02 20.59l26.21 32.94z" fill="#454565"/><path d="m356.57 126.14c.5-4.1 5.2-25.34 5.62-28.97 11.36-.21 21.68-.47 22.98-.67 4.69-.51 9.73-4.21 11.42-8.77 1-2.74 2.14-6.49 2.87-11.63.71-5.14.63-8.89.4-11.63-.41-4.55-4.41-8.25-8.95-8.77-2.74-.44-49.07-1.17-54.22-1.03-5.11-.14-51.64.59-54.5 1.03-4.69.51-9.73 4.22-11.42 8.77-1 2.74-2.14 6.49-2.87 11.63-.71 5.13-.63 8.89-.4 11.63.41 4.55 4.41 8.25 8.95 8.77 1.25.2 11.5.46 22.79.67-.59 3.63-5.47 24.87-6.12 28.97h63.44z" fill="#454565"/><rect fill="#f04760" height="37.83" rx="18.91" width="37.83" x="15.97" y="225.7"/><path d="m327.25 121.9c-34.31 0-67.66 10.31-96.71 27.99l-67.56-.03h-.13l-.06-.02-.04.02h-116.87c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86l92.75.05c9.78.7 17.49 8.85 17.49 18.81v.19c0 10.42-8.45 18.86-18.86 18.86h-51.97c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h20.4c10.42 0 18.86 8.45 18.86 18.86v.19c0 10.42-8.45 18.86-18.86 18.86h-86.71c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h101.67c10.42 0 18.86 8.44 18.86 18.86v.19c0 10.42-8.45 18.86-18.86 18.86h-49.4c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h103.7c25.91 26.16 62.55 42.06 105.15 42.06 92.63 0 178.27-75.09 191.29-167.72s-51.52-167.72-144.15-167.72z" fill="#e03757"/><path d="m135.64 369.91c131.56-6.76 238.81-105.43 258.84-233.05-19.78-9.61-42.51-14.96-67.24-14.96-34.31 0-67.66 10.31-96.71 27.99l-67.56-.03h-.13l-.06-.02-.04.02h-116.86c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86l92.75.05c9.78.7 17.49 8.85 17.49 18.81v.19c0 10.42-8.45 18.86-18.86 18.86h-51.97c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h20.4c10.42 0 18.86 8.45 18.86 18.86v.19c0 10.42-8.45 18.86-18.86 18.86h-86.71c-10.42 0-18.86 8.45-18.86 18.86v.19c0 10.42 8.45 18.86 18.86 18.86h101.67c10.42 0 18.86 8.44 18.86 18.86v.19c0 4.29-1.45 8.24-3.87 11.41z" fill="#f04760"/><path d="m389.77 272.6-79.02 121.93c-1.82 2.8-4.93 4.49-8.27 4.49h-6.19c-6.38 0-11.08-5.97-9.57-12.17l19.47-80.36h-47.47c-5.69 0-9.88-5.32-8.54-10.85l26.34-108.72c.95-3.94 4.48-6.72 8.54-6.72h54.62c5.69 0 9.88 5.32 8.54 10.85l-16.07 66.33h49.35c7.81 0 12.51 8.65 8.27 15.21z" fill="#fff"/></g></g></svg>',
            'expand' => '<svg class="svgExpand'.$class.'" fill="currentColor" viewBox="0 0 448 512"><path d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64V352zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32H320zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V352z"/></svg>',
            'coupon' => '<svg class="svgCoupon'.$class.'" fill="currentColor" enable-background="new 0 0 511.986 511.986" height="512" viewBox="0 0 511.986 511.986" width="512"><g><path d="m185.08 114.947c1.405 7.504 8.849 13.422 17.63 11.78 8.526-1.78 13.375-9.955 11.78-17.64-1.873-8.936-10.699-13.914-19.061-11.42-7.469 2.229-11.887 9.942-10.349 17.28z"></path><path d="m508.225 324.453c-81.619-237.586-76.004-221.308-76.353-222.117-8.496-19.663-24.988-34.949-45.249-41.94-2.901-1.001-167.187-39.431-171.935-41.075-14.561-5.043-34.791-2.216-48.993 10.846l-140.789 129.549c-15.828 14.558-24.906 35.282-24.906 56.86v229.41c0 27.035 21.877 49.03 48.768 49.03h301.205c26.891 0 48.768-21.995 48.768-49.03v-22.174l83.955-35.93c24.409-10.563 35.764-38.912 25.529-63.429zm-158.252 140.563h-301.205c-10.349 0-18.768-8.537-18.768-19.03v-229.41c0-13.209 5.546-25.887 15.217-34.782 120.62-110.988 46.064-41.76 141.269-129.559 4.965-4.576 11.82-6.414 18.619-4.364 6.077 1.815-4.646-6.919 148.421 133.925 9.669 8.894 15.215 21.571 15.215 34.78v229.41c-.001 10.493-8.42 19.03-18.768 19.03zm120.864-104.691-72.097 30.855v-174.604c0-21.578-9.078-42.302-24.904-56.858l-104.848-96.477 108.503 25.746c11.844 4.287 21.498 13.261 26.626 24.757 81.464 237.133 75.969 221.217 76.326 222.038 4.096 9.468-.238 20.489-9.606 24.543z"></path><path d="m241.959 202.297c-7.637-3.206-16.43.39-19.636 8.028l-73.023 174.04c-4.166 9.929 3.193 20.808 13.825 20.808 5.861 0 11.429-3.457 13.839-9.2l73.023-174.04c3.205-7.64-.389-16.431-8.028-19.636z"></path><path d="m171.659 245.52c0-28.95-21.203-52.503-47.266-52.503s-47.265 23.553-47.265 52.503 21.203 52.503 47.266 52.503 47.265-23.553 47.265-52.503zm-47.265 22.503c-9.359 0-17.266-10.305-17.266-22.503s7.906-22.503 17.266-22.503 17.266 10.305 17.266 22.503c-.001 12.198-7.907 22.503-17.266 22.503z"></path><path d="m275.751 312.011c-26.063 0-47.266 23.553-47.266 52.503s21.203 52.503 47.266 52.503 47.266-23.553 47.266-52.503-21.204-52.503-47.266-52.503zm0 75.006c-9.359 0-17.266-10.305-17.266-22.503s7.906-22.503 17.266-22.503 17.266 10.305 17.266 22.503-7.907 22.503-17.266 22.503z"></path></g></svg>',
            'notice' => '<svg class="svgNotification'.$class.'" height="512" viewBox="0 0 512 512" width="512"><g clip-rule="evenodd" fill-rule="evenodd"><path d="m328.084 422.916c-5.04 37.808-37.451 66.165-75.592 66.165s-70.552-28.355-75.601-66.161l-2.432-18.208h156.052z" fill="#e4404d"/><path d="m241.242 488.243c-33.1-4.935-59.807-31.3-64.351-65.324l-2.432-18.208h133.552l-2.427 18.204c-4.536 34.027-31.243 60.393-64.342 65.328z" fill="#fd4755"/><path d="m85.729 189.68c0-91.962 74.801-166.76 166.763-166.76 91.963 0 166.753 74.798 166.753 166.76v180.95h-333.516z" fill="#e6bd5c"/><path d="m85.729 189.68c0-49.496 21.676-94.011 56.026-124.577 24.848-14.719 53.819-23.183 84.736-23.183 91.963 0 166.753 74.798 166.753 166.76v161.95h-307.515z" fill="#ffd266"/><path d="m420.819 354.471c18.314 0 33.199 14.885 33.199 33.2 0 18.314-14.886 33.199-33.199 33.199h-336.655c-18.313 0-33.199-14.886-33.199-33.199 0-18.314 14.884-33.2 33.199-33.2z" fill="#e6bd5c"/><path d="m430.211 419.516c-2.979.88-6.13 1.354-9.392 1.354h-336.655c-18.313 0-33.199-14.886-33.199-33.199 0-5.941 1.568-11.52 4.309-16.348 2.978-.879 6.129-1.352 9.39-1.352h336.655c18.314 0 33.199 14.885 33.199 33.2.001 5.939-1.566 11.518-4.307 16.345z" fill="#ffd266"/><path d="m230.068 138.4c0-63.686 51.793-115.48 115.479-115.48 63.687 0 115.488 51.791 115.488 115.48 0 63.693-51.794 115.491-115.488 115.491-63.693-.001-115.479-51.801-115.479-115.491z" fill="#d7d7d7"/><path d="m230.068 138.4c0-63.184 50.983-114.654 113.979-115.461 62.997.807 113.988 52.273 113.988 115.461 0 63.192-50.984 114.665-113.988 115.471-63.003-.807-113.979-52.283-113.979-115.471z" fill="#efefef"/><path d="m245.187 138.4c0-55.341 45.018-100.36 100.359-100.36 55.342 0 100.369 45.017 100.369 100.36 0 55.348-45.02 100.371-100.369 100.371-55.347 0-100.359-45.026-100.359-100.371z" fill="#e4404d"/><path d="m348.797 38.098c53.843 1.722 97.118 46.047 97.118 100.302 0 54.26-43.269 98.591-97.118 100.313-53.848-1.722-97.11-46.056-97.11-100.313 0-54.253 43.268-98.58 97.11-100.302z" fill="#fd4755"/><path d="m345.546 157.521c4.419 0 8-3.581 8-8.002v-62.35c0-4.419-3.581-8-8-8-4.41 0-8 3.581-8 8v62.35c.001 4.421 3.59 8.002 8 8.002zm8 27.41c0-4.421-3.581-8.002-8-8.002-4.41 0-8 3.58-8 8.002v4.709c0 4.41 3.59 8 8 8 4.419 0 8-3.59 8-8z" fill="#d7d7d7"/><path d="m345.546 157.521c.617 0 1.218-.07 1.795-.202 1.447-1.448 2.343-3.448 2.343-5.658v-62.35c0-4.419-3.581-8-8-8-.616 0-1.216.07-1.793.202-1.448 1.448-2.345 3.447-2.345 5.655v62.35c.001 4.422 3.59 8.003 8 8.003zm4.138 29.552c0-4.421-3.581-8.002-8-8.002-.616 0-1.216.07-1.792.202h-.001c-1.448 1.448-2.345 3.447-2.345 5.657v4.709c0 4.41 3.59 8 8 8 .616 0 1.216-.07 1.791-.202 1.449-1.449 2.346-3.449 2.346-5.656v-4.708z" fill="#efefef"/></g></svg>',
        );

        $svg = apply_filters( 'electron_svg_lists', $svg );

        return $svg[$name];
    }
}


if ( !function_exists( 'electron_wc_cats_menu') ) {
    function electron_wc_cats_menu($show_title=true,$mobile=false)
    {
        $taxonomy = 'product_cat';

        $categories = get_terms( $taxonomy, array(
            'orderby'    => 'name',
            'order'      => 'asc',
            'hide_empty' => true
        ));

        if ( is_singular() ) {
            $page_id = get_the_ID();
        } elseif ( function_exists('wc_get_page_id') ) {
            $page_id = is_shop() ? wc_get_page_id('shop') : get_queried_object_id();
        }

        $page_inc   = electron_header_settings( 'header_cat_menu_include', '' );
        $order      = electron_header_settings( 'header_cat_menu_hide_order', 'ASC' );
        $orderby    = electron_header_settings( 'header_cat_menu_hide_orderby', 'name' );
        $hide_empty = electron_header_settings( 'header_cat_menu_hide_empty', 1 );
        $filter     = electron_header_settings( 'header_cat_menu_filter', 'include' );
        $cats       = electron_header_settings( 'header_cat_menu_items', null );
        $thumb      = electron_header_settings( 'header_cat_menu_thumb_visibility', 1 );
        $thumb_type = electron_header_settings( 'header_cat_menu_thumb_type', 'img' );
        $title      = electron_header_settings( 'header_cat_menu_title', '' );
        $title      = trim($title) ? $title : esc_html__( 'Categories', 'electron' );

        $open_type  = is_array($page_inc) && in_array($page_id,$page_inc) ? ' always-open' : '';

        $bars_icon  = '<svg
        class="menuBars electron-svg-icon"
        width="24"
        height="24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        viewBox="0 0 24 24" ><use href="#menuBars"></use></svg>';

        $html = '';

        if ( !empty( $categories ) ) {
            $args = array(
                'echo'       => false,
                'taxonomy'   => $taxonomy,
                'max_depth'  => 5,
                'hide_empty' => $hide_empty,
                'title_li'   => '',
                'svgimg'     => $thumb_type,
                'cat_img'    => $thumb,
                'mobile'     => $mobile,
                'order'      => $order,
                'orderby'    => $orderby,
                'sorter'     => $cats,
                'walker'     => new Electron_WooCommerce_Categories_Walker()
            );

            if ( !empty($cats) ) {
                $args[$filter] = $cats;
            }

            if ( $mobile == true ) {
                $html .= '<ul class="main-cats">'.wp_list_categories($args).'</ul>';
            } else {
                $html .= '<div class="electron-category-menu type-vertical'.$open_type.'">';
                    if ( $show_title ) {
                        $html .= '<div class="menu-title"><span class="title">'.$bars_icon.$title.'</span><span class="icon-arrow nt-icon-up-chevron"></span></div>';
                    }
                    $html .= '<ul class="electron-vertical-catmenu-primary submenu">'.wp_list_categories($args).'</ul>';
                $html .= '</div>';
            }
            return $html;
        }
    }
}


function check_header_disabled_items($layout,$key)
{
    $options = get_option('electron_header');

    if ( is_array($options) ) {
        return isset( $options[$layout]['disabled'][$key] ) ? true : false;
    }
}


if ( !function_exists( 'electron_header_layout') ) {
    function electron_header_layout($type,$col)
    {
        $catalog        = electron_settings( 'woo_catalog_mode', '0' );
        $minicart       = electron_settings( 'minicart_type', 'icon' );
        $layout         = electron_header_settings( 'header_layout_'.$type );
        $layout         = apply_filters( 'header_middle_layouts', $layout );
        $text           = electron_header_settings( 'header_text_'.$type, '' );
        $shortcode      = electron_header_settings( 'header_shortcode_'.$type, '' );
        $notice_vis     = electron_header_settings( 'header_notices_visibility', '' );
        $notice         = electron_header_settings( 'header_notices', '' );
        $notice_icon    = electron_header_settings( 'header_notices_icon', '' );
        $canvas         = electron_header_settings( 'canvas_menu_visibility', '' );
        $search_type    = electron_header_settings( 'ajax_search_form_type', 'theme' );
        $search_form    = electron_header_settings( 'ajax_search_form_shortcode', '' );
        $account_action = electron_header_settings( 'header_account_action_type', '' );
        $account_cicon  = electron_header_settings( 'header_account_icon', '' );
        $cart_action    = electron_header_settings( 'header_cart_action_type', '' );
        $cart_curl      = electron_header_settings( 'header_cart_custom_url', '' );
        $cart_cicon     = electron_header_settings( 'header_cart_icon', '' );

        $cart_icon = trim($cart_cicon) ? trim($cart_cicon) : '<svg
        class="shopBag electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 32 32"><use href="#shopBag"></use></svg>';

        $compare_icon = '<svg
        class="shopCompare electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 32 32"><use href="#shopCompare"></use></svg>';

        $wishlist_icon = '<svg
        class="shopLove electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 32 32"><use href="#shopLove"></use></svg>';

        $account_icon = trim($account_cicon) ? trim($account_cicon) : '<svg height="512pt" viewBox="0 0 512 512" width="512pt" class="shopUser electron-svg-icon" fill="currentColor"><path d="m437.019531 74.980469c-48.351562-48.351563-112.640625-74.980469-181.019531-74.980469-68.382812 0-132.667969 26.628906-181.019531 74.980469-48.351563 48.351562-74.980469 112.636719-74.980469 181.019531 0 68.378906 26.628906 132.667969 74.980469 181.019531 48.351562 48.351563 112.636719 74.980469 181.019531 74.980469 68.378906 0 132.667969-26.628906 181.019531-74.980469 48.351563-48.351562 74.980469-112.640625 74.980469-181.019531 0-68.382812-26.628906-132.667969-74.980469-181.019531zm-308.679687 367.40625c10.707031-61.648438 64.128906-107.121094 127.660156-107.121094 63.535156 0 116.953125 45.472656 127.660156 107.121094-36.347656 24.972656-80.324218 39.613281-127.660156 39.613281s-91.3125-14.640625-127.660156-39.613281zm46.261718-218.519531c0-44.886719 36.515626-81.398438 81.398438-81.398438s81.398438 36.515625 81.398438 81.398438c0 44.882812-36.515626 81.398437-81.398438 81.398437s-81.398438-36.515625-81.398438-81.398437zm235.042969 197.710937c-8.074219-28.699219-24.109375-54.738281-46.585937-75.078125-13.789063-12.480469-29.484375-22.328125-46.359375-29.269531 30.5-19.894531 50.703125-54.3125 50.703125-93.363281 0-61.425782-49.976563-111.398438-111.402344-111.398438s-111.398438 49.972656-111.398438 111.398438c0 39.050781 20.203126 73.46875 50.699219 93.363281-16.871093 6.941406-32.570312 16.785156-46.359375 29.265625-22.472656 20.339844-38.511718 46.378906-46.585937 75.078125-44.472657-41.300781-72.355469-100.238281-72.355469-165.574219 0-124.617188 101.382812-226 226-226s226 101.382812 226 226c0 65.339844-27.882812 124.277344-72.355469 165.578125zm0 0"/></svg>';

        $search_icon = '<svg
        class="shopSearch electron-svg-icon"
        width="512"
        height="512"
        fill="currentColor"
        viewBox="0 0 48 48"><use href="#shopSearch"></use></svg>';

        $bars_icon = '<svg
        class="menuBars electron-svg-icon"
        width="24"
        height="24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        viewBox="0 0 24 24" ><use href="#menuBars"></use></svg>';

        $html = $cart_html = $miniCart = $user_html = '';

        if ( class_exists( 'WooCommerce' ) ) {

            $cart_url = $cart_curl ? esc_url( $cart_curl ) : esc_url( wc_get_page_permalink( 'cart' ) );
            $count    = esc_html( WC()->cart->get_cart_contents_count() );
            $count    = '<span class="electron-cart-count electron-wc-count">'.$count.'</span>';

            if ( '0' == electron_settings( 'minicart_visibility', '1' ) || 'link' == $cart_action ) {
                $cart_html = '<div class="top-action-btn has-minicart"><a class="cart-page-link" href="'.$cart_url.'">'.$count.$cart_icon.'</a></div>';
            } else {
                if ( 'icon' == $minicart ) {
                    if ( 'sticky' != $type ) {
                        ob_start();
                        get_template_part('woocommerce/minicart/minicart2');
                        $miniCart = ob_get_clean();
                    }
                    $cart_html = '<div class="top-action-wraper"><div class="top-action-btn has-minicart main-minicart">'.$count.$cart_icon.$miniCart.'</div></div>';
                } else {
                    $cart_html = '<div class="top-action-wraper"><div class="top-action-btn panel-open has-minicart" data-target=".electron-side-panel">'.$count.$cart_icon.'</div></div>';
                }
            }

            $user_html = '<div class="mini-panel">';
                $user_html .= '<div class="inner">';
                    $user_html .= electron_myaccount_minipanel();
                $user_html .= '</div>';
            $user_html .= '</div>';
        }

        ob_start();
        get_template_part( 'template-parts/logo' );
        $logo_html = ob_get_clean();

        if ( $layout ) {
            unset( $layout[$col]['placebo'] );

            if ( !empty( $layout[$col] ) ) {

                if ( 'mobile' == $type ) {

                    foreach ( $layout[$col] as $key => $value ) {

                        if ( $key == 'logo' ) {

                            $html .= $logo_html;

                        } elseif ( $key == 'bars' ) {

                            $html .= '<div class="mobile-trigger panel-open" data-target=".electron-mobile-menu">'.$bars_icon.'</div>';

                        } elseif ( $key == 'cart' && '1' != $catalog ) {

                            $html .= $cart_html;

                        } elseif ( $key == 'search' ) {
                            if ( '1' == electron_header_settings( 'popup_search_visibility' ) ) {
                                $html .= '<div class="top-action-btn panel-open" data-target=".electron-popup-search">'.$search_icon.'</div>';
                            }
                        } elseif ( $key == 'wishlist' && class_exists( 'Electron_Wishlist' ) && '1' != $catalog ) {

                            $page_id    = electron_settings('wishlist_page_id');
                            $woosw_url  = $page_id ? get_page_link($page_id) : wc_get_page_permalink( 'shop' );
                            $link      = '<a class="wishlist-page-link" href="'.esc_url( $woosw_url ).'"></a>';

                            $html .= '<div class="top-action-btn open-wishlist-btn">';
                            $html .= $link;
                            $html .= '<span class="electron-wishlist-count electron-wc-count"></span>'.$wishlist_icon.'</div>';

                        } elseif ( $key == 'compare' && class_exists( 'Electron_Compare' ) && '1' != $catalog ) {

                            $page_id   = electron_settings('compare_page_id');
                            $woosc_btn_action = electron_settings('header_compare_btn_action');
                            $woosc_url = $page_id ? get_page_link($page_id) : wc_get_page_permalink( 'shop' );

                            if ( $woosc_btn_action == 'popup' ) {
                                $html .= '<div class="top-action-btn has-custom-action open-compare-popup">';
                                $html .= '<span class="electron-compare-count electron-wc-count"></span>'.$compare_icon.'</div>';
                            } else {
                                $html .= '<a class="top-action-btn has-custom-action open-compare-btn" href="'.esc_url( $woosc_url ).'">';
                                $html .= '<span class="electron-compare-count electron-wc-count"></span>'.$compare_icon.'</a>';
                            }
                        } elseif ( $key == 'account' ) {
                            $account_url = wc_get_page_permalink( 'myaccount' );
                            $caccount_url = electron_header_settings( 'header_account_action_url' );
                            $caccount_url = $caccount_url ? esc_url($caccount_url) : $account_url;
                            if ( 'default' == $account_action ) {
                                $html .= '<div class="top-action-btn has-panel account-action action-'.$account_action.'"><a class="account-page-link" href="#0">'.$account_icon.'</a>'.$user_html.'</div>';
                            } elseif ( 'link' == $account_action ) {
                                $html .= '<div class="top-action-btn account-action action-link"><a class="account-page-link" href="'.$caccount_url.'">'.$account_icon.'</a></div>';
                            } else {
                                if ( is_account_page() ) {
                                    $html .= '<div class="top-action-btn account-action action-link"><a class="account-page-link" href="'.$caccount_url.'">'.$account_icon.'</a></div>';
                                } else {
                                    $html .= '<div class="top-action-btn account-action panel-popup-open" data-target=".electron-popup-account">'.$account_icon.'</div>';
                                }
                            }
                        }
                    }

                } else {

                    foreach ( $layout[$col] as $key => $value ) {

                        if ( $key == 'logo' ) {

                            $html .= $logo_html;

                        } elseif ( $key == 'search-form' && shortcode_exists( 'electron_wc_ajax_product_search' ) ) {
                            if ( $search_type == 'plugin' && $search_form ) {
                                $html .= '<div class="electron-ajax-product-search custom-search-form">';
                                    $html .= do_shortcode($search_form);
                                $html .= '</div>';
                            } else {
                                $html .= do_shortcode('[electron_wc_ajax_product_search cats="hide"]');
                            }

                        } elseif ( $key == 'menu' ) {

                            $menu = wp_nav_menu(
                                array(
                                    'menu'            => '',
                                    'theme_location'  => 'header_menu',
                                    'container'       => '',
                                    'container_class' => '',
                                    'container_id'    => '',
                                    'menu_class'      => '',
                                    'menu_id'         => '',
                                    'items_wrap'      => '%3$s',
                                    'before'          => '',
                                    'after'           => '',
                                    'link_before'     => '',
                                    'link_after'      => '',
                                    'depth'           => 4,
                                    'echo'            => false,
                                    'mobile'          => false,
                                    'fallback_cb'     => 'Electron_Wp_Bootstrap_Navwalker::fallback',
                                    'walker'          => new \Electron_Wp_Bootstrap_Navwalker()
                                )
                            );

                            $html .= '<div class="header-mainmenu type-'.$key.'">';
                                $html .= 'sticky' == $type ? '' : '<ul class="nav">'.$menu.'</ul>';
                            $html .= '</div>';

                        } elseif ( $key == 'cart' && '1' != $catalog ) {

                            $html .= $cart_html;

                        } elseif ( $key == 'wishlist' && class_exists( 'Electron_Wishlist' ) && '1' != $catalog ) {

                            $page_id    = electron_settings('wishlist_page_id');
                            $woosw_url  = $page_id ? get_page_link($page_id) : wc_get_page_permalink( 'shop' );
                            $link      = '<a class="wishlist-page-link" href="'.esc_url( $woosw_url ).'"></a>';

                            $html .= '<div class="top-action-btn open-wishlist-btn">';
                            $html .= $link;
                            $html .= '<span class="electron-wishlist-count electron-wc-count"></span>'.$wishlist_icon.'</div>';

                        } elseif ( $key == 'compare' && class_exists( 'Electron_Compare' ) && '1' != $catalog ) {

                            $page_id   = electron_settings('compare_page_id');
                            $woosc_btn_action = electron_settings('header_compare_btn_action');
                            $woosc_url = $page_id ? get_page_link($page_id) : wc_get_page_permalink( 'shop' );

                            if ( $woosc_btn_action == 'popup' ) {
                                $html .= '<div class="top-action-btn has-custom-action open-compare-popup">';
                                $html .= '<span class="electron-compare-count electron-wc-count"></span>'.$compare_icon.'</div>';
                            } else {
                                $html .= '<a class="top-action-btn has-custom-action open-compare-btn" href="'.esc_url( $woosc_url ).'">';
                                $html .= '<span class="electron-compare-count electron-wc-count"></span>'.$compare_icon.'</a>';
                            }

                        } elseif ( $key == 'search' ) {
                            if ( '1' == electron_header_settings( 'popup_search_visibility' ) ) {
                                $html .= '<div class="top-action-btn panel-open search-icon" data-target=".electron-popup-search">'.$search_icon.'</div>';
                            }
                        } elseif ( $key == 'account' || $key == 'login' ) {
                            $account_url = wc_get_page_permalink( 'myaccount' );

                            if ( $key == 'login' ) {
                                $html  .= '<a class="account-page-link account-action action-'.$account_action.'" href="'.$account_url.'">'.esc_html__('Login/Register','electron').'</a>';
                            } else {
                                $caccount_url = electron_header_settings( 'header_account_action_url' );
                                $caccount_url = $caccount_url ? esc_url($caccount_url) : $account_url;
                                if ( 'default' == $account_action ) {
                                    $html .= '<div class="top-action-btn has-panel account-action action-'.$account_action.'"><a class="account-page-link" href="'.$caccount_url.'">'.$account_icon.'</a>'.$user_html.'</div>';
                                } elseif ( 'link' == $account_action ) {
                                    $html .= '<div class="top-action-btn account-action action-link"><a class="account-page-link" href="'.$caccount_url.'">'.$account_icon.'</a></div>';
                                } else {
                                    if ( is_account_page() ) {
                                        $html .= '<div class="top-action-btn account-action action-link"><a class="account-page-link" href="'.$caccount_url.'">'.$account_icon.'</a></div>';
                                    } else {
                                        $html .= '<div class="top-action-btn account-action panel-popup-open" data-target=".electron-popup-account">'.$account_icon.'</div>';
                                    }
                                }
                            }

                        } elseif ( $key == 'customtext' && '' != $text ) {

                            $html .= '<div class="header-text">'.$text.'</div>';

                        } elseif ( $key == 'shortcode' && '' != $shortcode ) {

                            $html .= '<div class="header-shortcode">'.$shortcode.'</div>';

                        } elseif ( $key == 'canvas' && '1' == $canvas ) {

                            $html .= '<div class="panel-open canvas-trigger" data-target=".electron-canvas-menu">'.$bars_icon.'</div>';
                            wp_enqueue_style( 'electron-canvas-menu' );
                            wp_enqueue_style( 'electron-sliding-menu' );
                        } elseif ( $key == 'catmenu' ) {

                            $html .= electron_wc_cats_menu(true,false);

                        } elseif ( ( $key == 'minimenu' || $key == 'dropdown' ) && has_nav_menu( 'header_mini_menu' ) ) {

                            $menu = wp_nav_menu(
                                array(
                                    'menu'            => '',
                                    'theme_location'  => $key == 'dropdown' ? 'header_dropdown_menu' : 'header_mini_menu',
                                    'container'       => '',
                                    'container_class' => '',
                                    'container_id'    => '',
                                    'menu_class'      => '',
                                    'menu_id'         => '',
                                    'items_wrap'      => '%3$s',
                                    'before'          => '',
                                    'after'           => '',
                                    'link_before'     => '',
                                    'link_after'      => '',
                                    'depth'           => $key == 'dropdown' ? 2 : 2,
                                    'echo'            => false,
                                    'mobile'          => false,
                                    'fallback_cb'     => 'Electron_Wp_Bootstrap_Navwalker::fallback',
                                    'walker'          => new \Electron_Wp_Bootstrap_Navwalker()
                                )
                            );

                            $html .= '<div class="header-minimenu type-'.$key.'">';
                                $html .= '<ul class="nav">'.$menu.'</ul>';
                            $html .= '</div>';

                        } elseif ( $key == 'notice' && $notice && '1' == $notice_vis ) {

                            $html .= '<div class="header-notices top-action-btn has-panel">';
                                $html .= trim($notice_icon) ? $notice_icon : electron_svg_lists('notice', 'electron-svg-icon');
                                $html .= '<div class="notices mini-panel"><div class="inner">'.$notice.'</div></div>';
                            $html .= '</div>';
                        }
                    }
                }
                return '<div class="header-col col-'.$col.'">'.$html.'</div>';
            }
        }
    }
}

function electron_myaccount_minipanel() {
    if ( !class_exists( 'WooCommerce' ) ) {
        return;
    }

    $url = wc_get_page_permalink( 'myaccount' );

    $html = '';
    $signIn       = esc_html__( 'Sign in', 'electron' );
    $register     = esc_html__( 'Register', 'electron' );
    $action_type  = electron_header_settings( 'header_account_action_type', '' );
    $signin_url   = electron_header_settings( 'header_account_signin_url', '' );
    $register_url = electron_header_settings( 'header_account_register_url', '' );
    $signin_url   = $signin_url ? $signin_url : $url;
    $register_url = $register_url ? $register_url : $url;
    $btn_class    = 'left-sidebar' == $action_type || 'right-sidebar' == $action_type || 'popup' == $action_type ? ' class="electron-btn electron-btn-primary"' : '';

    if ( is_user_logged_in() ) {
        $curUser = wp_get_current_user();
        $menus   = wc_get_account_menu_items();

        $html .= '<span class="panel-title">'.esc_html__( 'Hello', 'electron' );
            $html .= '<strong class="nt-strong-sfot"> '.esc_html( $curUser->display_name ).'</strong>';
        $html .= '</span>';
        $html .= '<ul class="navigation">';
            foreach ( $menus as $endpoint => $label ) {
                $html .= '<li class="menu-item">';
                    $html .= '<a href="'.esc_url( wc_get_account_endpoint_url( $endpoint ) ).'"'.$btn_class.'><span class="btn-text" data-hover="'.esc_html( $label ).'"></span></a>';
                $html .= '</li>';
            }
        $html .= '</ul>';

    } else {
        if ( 'default' != $action_type && 'link' != $action_type && !is_account_page() ) {
            $html .= 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ? ' <div class="account-steps"></div>' : '';
            ob_start();
            $html .= wc_get_template('myaccount/form-login.php');
            $html .= ob_get_clean();
        } else {
            $html .= '<a class="electron-btn electron-btn-primary" href="'.esc_url( $signin_url ).'"><span class="btn-text" data-hover="'.$signIn.'"></span></a>';
            $html .= '<a class="electron-btn electron-btn-primary" href="'.esc_url( $register_url ).'"><span class="btn-text" data-hover="'.$register.'"></span></a>';
        }
    }

    return '<div class="account-area">'.$html.'</div>';
}


add_action('electron_before_wp_footer','electron_myaccount_popup_panel');
function electron_myaccount_popup_panel() {
    if ( !class_exists( 'WooCommerce' ) ) {
        return;
    }

    $ajax_login = electron_settings( 'wc_ajax_login_register', '1' );

    $action = electron_header_settings( 'header_account_action_type', 'default' );

    $class  = $action;
    $class .= 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ? ' multi-forms' : ' simple-forms';
    $class .= '1' == $ajax_login ? ' ajax-login-active' : '';
    $class .= 'left-sidebar' != $action || 'right-sidebar' != $action ? ' electron-scrollbar' : '';

    if ( 'default' != $action && 'link' != $action && !is_account_page() ) {
        wp_enqueue_style( 'woocommerce-account-popup' );
        $html = '<div class="account-popup-inner">';
            $html .= '<span class="panel-close" data-target=".electron-popup-account"></span>';
            $html .= electron_myaccount_minipanel();
        $html .= '</div>';

        echo '<div class="electron-popup-account '.$class.'"><div class="popup-overlay" data-target=".electron-popup-account"></div>'.$html.'</div>';
    }
}

/*************************************************
## Get Columns options
*************************************************/
if ( ! function_exists( 'electron_get_shop_column' ) ) {
    function electron_get_shop_column()
    {
        $column = isset( $_GET['column'] ) ? $_GET['column'] : '';
        return esc_html($column);
    }
}

if ( !function_exists( 'electron_wc_get_account_menu_items' ) ) {
    function electron_wc_get_account_menu_items() {
        $endpoints = wc_get_account_menu_items();
        return $endpoints;
    }
}
