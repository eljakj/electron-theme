<?php

/*
** theme options panel and metabox settings
** will change some parts of theme via custom style
*/

/*************************************************
## CONVERT HEX TO RGB
*************************************************/
function electron_hex2rgb( $hex )
{
    $hex = str_replace( "#", "", $hex );

    if ( strlen( $hex ) == 3 ) {
        $r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1 ) );
        $g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1 ) );
        $b = hexdec(substr( $hex, 2, 1 ).substr( $hex, 2, 1 ) );
    } else {
        $r = hexdec( substr( $hex, 0, 2 ) );
        $g = hexdec( substr( $hex, 2, 2 ) );
        $b = hexdec( substr( $hex, 4, 2 ) );
    }
    $rgb = array( $r, $g, $b );
    return implode(", ", $rgb); // returns with the rgb values
}

function electron_custom_css()
{

  // stop on admin pages
    if ( is_admin() ) {
        return false;
    }

    // Redux global
    global $electron;

    $is_right = is_rtl() ? 'right' : 'left';
    $is_left  = is_rtl() ? 'left' : 'right';
    /* CSS to output */
    $theCSS = '';

    $theCSS .= '.scroll-to-top {
    	display: inline-block;
    	width: 40px;
    	height: 40px;
    	line-height: 40px;
    	background: var(--electron-dark);
    	position: fixed;
    	color:var(--electron-light);
    	bottom: 60px;
    	right: 40px;
    	z-index: 99;
    	font-size: 15px;
    	text-align: center;
    	-webkit-transition: all 0.4s ease;
    	transition: all 0.4s ease;
    	display: none;
    	border-radius: 4px;
    	transition: all 0.4s ease;
    }
    .scroll-to-top:hover {
    	background: var(--electron-primary);
    	color: var(--electron-dark);
    }
    .electron-scrollbar {
        padding-right: 10px;
    }

    .electron-scrollbar>.elementor-container::-webkit-scrollbar,
    .electron-scrollbar::-webkit-scrollbar {
        width: 2px;
    }

    .electron-scrollbar>.elementor-container::-webkit-scrollbar-thumb,
    .electron-scrollbar::-webkit-scrollbar-thumb {
        background-color: var(--electron-dark);
    }

    .electron-scrollbar>.elementor-container::-webkit-scrollbar-track,
    .electron-scrollbar::-webkit-scrollbar-track {
        background-color: var(--electron-gray);
    }
    body:not(.page-loaded) .electron-category-item.swiper-slide {
        position: relative;
        padding-bottom: 0;
        max-height: 218px;
        max-width: 178px;
        margin-right: 15px;
    }
    body:not(.page-loaded) .style-2 .electron-category-item .electron-category-thumb {
        padding-bottom: 0;
        width: 100%;
        min-height: 160px;
    }';


    /*************************************************
    ## HEADER SETTINGS
    *************************************************/

    if ( '0' == electron_settings('theme_boxed_layout', '') && electron_settings('content_width', '') ) {
        $theCSS .= '@media (min-width: 1200px){
        .container, .electron-header-inner {
            max-width: '.electron_settings('content_width', '').'px !important;
        }}';
    }
    if ( '1' == electron_settings('theme_boxed_layout', '') && electron_settings('boxed_max_width', '') ) {
        $theCSS .= '.layout-boxed #wrapper,.layout-boxed .electron-header-default,.electron-promotion-bar .inner {
            max-width: '.electron_settings('boxed_max_width', '').'px;
        }';
    }
    if ( electron_settings('quick_view_width_sm', '') ) {
        $theCSS .= '@media (min-width: 1024px){
        .electron-quickview-wrapper {
            max-width: '.electron_settings('quick_view_width_sm', '').'px;
        }}';
    }
    if ( electron_settings('quick_view_width', '') ) {
        $theCSS .= '@media (min-width: 1200px){
        .electron-quickview-wrapper {
            max-width: '.electron_settings('quick_view_width', '').'px;
        }}';
    }
    if ( electron_settings('quick_shop_width', '') ) {
        $theCSS .= '@media (min-width: 1024px){
        .electron-quickshop-wrapper {
            max-width: '.electron_settings('quick_shop_width', '').'px;
        }}';
    }
    if ( electron_settings('quick_shop_width_sm', '') ) {
        $theCSS .= '@media (min-width: 1200px){
        .electron-quickshop-wrapper {
            max-width: '.electron_settings('quick_shop_width_sm', '').'px;
        }}';
    }

    if ( electron_settings('header_height', '') ) {
        $theCSS .= '.header-spacer,
        .electron-header-top-menu-area>ul>li.menu-item {
            height: '.electron_settings('header_height', '').'px;
        }';
    }
    if ( electron_settings('header_right_item_spacing', '') ) {
        $theCSS .= '.electron-header-top-right .electron-header-default-inner>div:not(:first-child) {
            margin-'.$is_right.': '.electron_settings('header_right_item_spacing', '').'px;
        }';
    }
    if ( electron_settings('header_left_item_spacing', '') ) {
        $theCSS .= '.electron-header-top-left .electron-header-default-inner>div:not(:last-child) {
            margin-'.$is_left.': '.electron_settings('header_right_item_spacing', '').'px;
        }';
    }

    if ( electron_settings('header_buttons_spacing', '') ) {
        $theCSS .= '.electron-header-default .top-action-btn {
            margin-'.$is_right.': '.electron_settings('header_buttons_spacing', '').'px;
        }';
    }
    if ( electron_settings('sidebar_menu_content_width', '') ) {
        $theCSS .= '.electron-canvas-menu {
            max-width: '.electron_settings('sidebar_menu_content_width', '').'px;
        }';
    }
    if ( electron_settings('sidebar_menu_bar_width', '') ) {
        $theCSS .= '.electron-header-mobile-sidebar {
            min-width: '.electron_settings('sidebar_menu_bar_width', '').'px;
        }';
    }
    // logo size
    if ( electron_settings('logo_size', '') ) {
        $theCSS .= '.nav-logo img,.electron-header .nav-logo .main-logo {
            max-width: '.electron_settings('logo_size', '').'px;
        }';
    }
    if ( electron_settings('sticky_logo_size', '') ) {
        $theCSS .= '.electron-header .nav-logo img.sticky-logo,
        .electron-header .electron-header-sticky .nav-logo img {
            max-width: '.electron_settings('sticky_logo_size', '').'px;
        }';
    }
    if ( electron_settings('sidebar_logo_size', '') ) {
        $theCSS .= '.electron-header .electron-header-mobile-sidebar-logo .nav-logo img {
            max-width: '.electron_settings('sidebar_logo_size', '').'px;
        }';
    }
    if ( electron_settings('mobile_logo_size', '') ) {
        $theCSS .= '.electron-header-mobile .nav-logo img.main-logo {
            max-width: '.electron_settings('mobile_logo_size', '').'px;
        }';
    }
    $options = get_option('electron_header');

    if ( is_array($options) ) {

        $col_disabled = isset( $options['header_top_mobile_col_visibility'] ) ? $options['header_top_mobile_col_visibility'] : array();
        if ( isset($col_disabled['disabled']) && !empty($col_disabled['disabled']) ) {

            $theCSS .= '@media (max-width: 1024px){';
            foreach ( $col_disabled['disabled'] as $key => $value ) {

                if ( $key == 'left' ) {

                    $theCSS .= '.electron-header-top .col-left {display: none}';

                } elseif ( $key == 'center' ) {

                    $theCSS .= '.electron-header-top .col-center {display: none}';

                } elseif ( $key == 'right' ) {

                    $theCSS .= '.electron-header-top .col-center {display: none}';

                }
            }
            $theCSS .= '}';
        }

        $disabled = isset( $options['header_mobile_top_elements_visibility'] ) ? $options['header_mobile_top_elements_visibility'] : array();

        if ( isset($disabled['disabled']) && !empty($disabled['disabled']) ) {
            $theCSS .= '@media (max-width: 1024px){';
            foreach ( $disabled['disabled'] as $key => $value ) {

                if ( $key == 'cart' ) {

                    $theCSS .= '.electron-header-top .top-action-btn.has-minicart {display: none}';

                } elseif ( $key == 'wishlist' ) {

                    $theCSS .= '.electron-header-top .top-action-btn.open-wishlist-btn {display: none}';

                } elseif ( $key == 'compare' ) {

                    $theCSS .= '.electron-header-top .top-action-btn.open-compare-btn {display: none}';

                } elseif ( $key == 'search' ) {

                    $theCSS .= '.electron-header-top .top-action-btn.search-icon {display: none}';

                } elseif ( $key == 'account' || $key == 'login' ) {

                    $theCSS .= '.electron-header-top .account-action {display: none}';

                } elseif ( $key == 'customtext' ) {

                    $theCSS .= '.electron-header-top .header-text {display: none}';

                } elseif ( $key == 'shortcode' ) {

                    $theCSS .= '.electron-header-top .header-shortcode {display: none}';

                } elseif ( $key == 'canvas' ) {

                    $theCSS .= '.electron-header-top .canvas-trigger {display: none}';

                } elseif ( $key == 'minimenu' ) {

                    $theCSS .= '.electron-header-top .header-minimenu.type-minimenu {display: none}';

                } elseif ( $key == 'dropdown' ) {

                    $theCSS .= '.electron-header-top .header-minimenu.type-dropdown {display: none}';
                }
            }
            $theCSS .= '}';
        }
    }

    /*************************************************
    ## PRELOADER SETTINGS
    *************************************************/
    if ( '0' != electron_settings('preloader_visibility') ) {

        $pretype = electron_settings('pre_type', 'default');
        $prebg   = electron_settings('pre_bg', '#fff');
        $prebg   = $prebg ? $prebg : '#f1f1f1';
        $spinclr = electron_settings('pre_spin', '#000');
        $spinclr = $spinclr ? $spinclr : '#000';
        if ( 'default' == $pretype ) {
            $theCSS .= 'body.dark .pace, body.light .pace { background-color: '. esc_attr( $spinclr ) .';}';
            $theCSS .= '#preloader:after, #preloader:before{ background-color:'. esc_attr( $prebg ) .';}';
        }

        $theCSS .= 'div#nt-preloader {background-color: '. esc_attr($prebg) .';overflow: hidden;background-repeat: no-repeat;background-position: center center;height: 100%;left: 0;position: fixed;top: 0;width: 100%;z-index: 9999999;}';
        $spin_rgb = electron_hex2rgb($spinclr);

        if ('01' == $pretype) {
            $theCSS .= '.loader01 {width: 56px;height: 56px;border: 8px solid '. $spinclr .';border-right-color: transparent;border-radius: 50%;position: relative;animation: loader-rotate 1s linear infinite;top: 50%;margin: -28px auto 0; }.loader01::after {content: "";width: 8px;height: 8px;background: '. $spinclr .';border-radius: 50%;position: absolute;top: -1px;left: 33px; }@keyframes loader-rotate {0% {transform: rotate(0); }100% {transform: rotate(360deg); } }';
        }
        if ('02' == $pretype) {
            $theCSS .= '.loader02 {width: 56px;height: 56px;border: 8px solid rgba('. $spin_rgb .', 0.25);border-top-color: '. $spinclr .';border-radius: 50%;position: relative;animation: loader-rotate 1s linear infinite;top: 50%;margin: -28px auto 0; }@keyframes loader-rotate {0% {transform: rotate(0); }100% {transform: rotate(360deg); } }';
        }
        if ('03' == $pretype) {
            $theCSS .= '.loader03 {width: 56px;height: 56px;border: 8px solid transparent;border-top-color: '. $spinclr .';border-bottom-color: '. $spinclr .';border-radius: 50%;position: relative;animation: loader-rotate 1s linear infinite;top: 50%;margin: -28px auto 0; }@keyframes loader-rotate {0% {transform: rotate(0); }100% {transform: rotate(360deg); } }';
        }
        if ('04' == $pretype) {
            $theCSS .= '.loader04 {width: 56px;height: 56px;border: 2px solid rgba('. $spin_rgb .', 0.5);border-radius: 50%;position: relative;animation: loader-rotate 1s ease-in-out infinite;top: 50%;margin: -28px auto 0; }.loader04::after {content: "";width: 10px;height: 10px;border-radius: 50%;background: '. $spinclr .';position: absolute;top: -6px;left: 50%;margin-left: -5px; }@keyframes loader-rotate {0% {transform: rotate(0); }100% {transform: rotate(360deg); } }';
        }
        if ('05' == $pretype) {
            $theCSS .= '.loader05 {width: 56px;height: 56px;border: 4px solid '. $spinclr .';border-radius: 50%;position: relative;animation: loader-scale 1s ease-out infinite;top: 50%;margin: -28px auto 0; }@keyframes loader-scale {0% {transform: scale(0);opacity: 0; }50% {opacity: 1; }100% {transform: scale(1);opacity: 0; } }';
        }
        if ('06' == $pretype) {
            $theCSS .= '.loader06 {width: 56px;height: 56px;border: 4px solid transparent;border-radius: 50%;position: relative;top: 50%;margin: -28px auto 0; }.loader06::before {content: "";border: 4px solid rgba('. $spin_rgb .', 0.5);border-radius: 50%;width: 67.2px;height: 67.2px;position: absolute;top: -9.6px;left: -9.6px;animation: loader-scale 1s ease-out infinite;animation-delay: 1s;opacity: 0; }.loader06::after {content: "";border: 4px solid '. $spinclr .';border-radius: 50%;width: 56px;height: 56px;position: absolute;top: -4px;left: -4px;animation: loader-scale 1s ease-out infinite;animation-delay: 0.5s; }@keyframes loader-scale {0% {transform: scale(0);opacity: 0; }50% {opacity: 1; }100% {transform: scale(1);opacity: 0; } }';
        }
        if ('07' == $pretype) {
            $theCSS .= '.loader07 {width: 16px;height: 16px;border-radius: 50%;position: relative;animation: loader-circles 1s linear infinite;top: 50%;margin: -8px auto 0; }@keyframes loader-circles {0% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.05), 19px -19px 0 0 rgba('. $spin_rgb .', 0.1), 27px 0 0 0 rgba('. $spin_rgb .', 0.2), 19px 19px 0 0 rgba('. $spin_rgb .', 0.3), 0 27px 0 0 rgba('. $spin_rgb .', 0.4), -19px 19px 0 0 rgba('. $spin_rgb .', 0.6), -27px 0 0 0 rgba('. $spin_rgb .', 0.8), -19px -19px 0 0 '. $spinclr .'; }12.5% {box-shadow: 0 -27px 0 0 '. $spinclr .', 19px -19px 0 0 rgba('. $spin_rgb .', 0.05), 27px 0 0 0 rgba('. $spin_rgb .', 0.1), 19px 19px 0 0 rgba('. $spin_rgb .', 0.2), 0 27px 0 0 rgba('. $spin_rgb .', 0.3), -19px 19px 0 0 rgba('. $spin_rgb .', 0.4), -27px 0 0 0 rgba('. $spin_rgb .', 0.6), -19px -19px 0 0 rgba('. $spin_rgb .', 0.8); }25% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.8), 19px -19px 0 0 '. $spinclr .', 27px 0 0 0 rgba('. $spin_rgb .', 0.05), 19px 19px 0 0 rgba('. $spin_rgb .', 0.1), 0 27px 0 0 rgba('. $spin_rgb .', 0.2), -19px 19px 0 0 rgba('. $spin_rgb .', 0.3), -27px 0 0 0 rgba('. $spin_rgb .', 0.4), -19px -19px 0 0 rgba('. $spin_rgb .', 0.6); }37.5% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.6), 19px -19px 0 0 rgba('. $spin_rgb .', 0.8), 27px 0 0 0 '. $spinclr .', 19px 19px 0 0 rgba('. $spin_rgb .', 0.05), 0 27px 0 0 rgba('. $spin_rgb .', 0.1), -19px 19px 0 0 rgba('. $spin_rgb .', 0.2), -27px 0 0 0 rgba('. $spin_rgb .', 0.3), -19px -19px 0 0 rgba('. $spin_rgb .', 0.4); }50% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.4), 19px -19px 0 0 rgba('. $spin_rgb .', 0.6), 27px 0 0 0 rgba('. $spin_rgb .', 0.8), 19px 19px 0 0 '. $spinclr .', 0 27px 0 0 rgba('. $spin_rgb .', 0.05), -19px 19px 0 0 rgba('. $spin_rgb .', 0.1), -27px 0 0 0 rgba('. $spin_rgb .', 0.2), -19px -19px 0 0 rgba('. $spin_rgb .', 0.3); }62.5% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.3), 19px -19px 0 0 rgba('. $spin_rgb .', 0.4), 27px 0 0 0 rgba('. $spin_rgb .', 0.6), 19px 19px 0 0 rgba('. $spin_rgb .', 0.8), 0 27px 0 0 '. $spinclr .', -19px 19px 0 0 rgba('. $spin_rgb .', 0.05), -27px 0 0 0 rgba('. $spin_rgb .', 0.1), -19px -19px 0 0 rgba('. $spin_rgb .', 0.2); }75% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.2), 19px -19px 0 0 rgba('. $spin_rgb .', 0.3), 27px 0 0 0 rgba('. $spin_rgb .', 0.4), 19px 19px 0 0 rgba('. $spin_rgb .', 0.6), 0 27px 0 0 rgba('. $spin_rgb .', 0.8), -19px 19px 0 0 '. $spinclr .', -27px 0 0 0 rgba('. $spin_rgb .', 0.05), -19px -19px 0 0 rgba('. $spin_rgb .', 0.1); }87.5% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.1), 19px -19px 0 0 rgba('. $spin_rgb .', 0.2), 27px 0 0 0 rgba('. $spin_rgb .', 0.3), 19px 19px 0 0 rgba('. $spin_rgb .', 0.4), 0 27px 0 0 rgba('. $spin_rgb .', 0.6), -19px 19px 0 0 rgba('. $spin_rgb .', 0.8), -27px 0 0 0 '. $spinclr .', -19px -19px 0 0 rgba('. $spin_rgb .', 0.05); }100% {box-shadow: 0 -27px 0 0 rgba('. $spin_rgb .', 0.05), 19px -19px 0 0 rgba('. $spin_rgb .', 0.1), 27px 0 0 0 rgba('. $spin_rgb .', 0.2), 19px 19px 0 0 rgba('. $spin_rgb .', 0.3), 0 27px 0 0 rgba('. $spin_rgb .', 0.4), -19px 19px 0 0 rgba('. $spin_rgb .', 0.6), -27px 0 0 0 rgba('. $spin_rgb .', 0.8), -19px -19px 0 0 '. $spinclr .'; } }';
        }
        if ('08' == $pretype) {
            $theCSS .= '.loader08 {width: 20px;height: 20px;position: relative;animation: loader08 1s ease infinite;top: 50%;margin: -46px auto 0; }@keyframes loader08 {0%, 100% {box-shadow: -13px 20px 0 '. $spinclr .', 13px 20px 0 rgba('. $spin_rgb .', 0.2), 13px 46px 0 rgba('. $spin_rgb .', 0.2), -13px 46px 0 rgba('. $spin_rgb .', 0.2); }25% {box-shadow: -13px 20px 0 rgba('. $spin_rgb .', 0.2), 13px 20px 0 '. $spinclr .', 13px 46px 0 rgba('. $spin_rgb .', 0.2), -13px 46px 0 rgba('. $spin_rgb .', 0.2); }50% {box-shadow: -13px 20px 0 rgba('. $spin_rgb .', 0.2), 13px 20px 0 rgba('. $spin_rgb .', 0.2), 13px 46px 0 '. $spinclr .', -13px 46px 0 rgba('. $spin_rgb .', 0.2); }75% {box-shadow: -13px 20px 0 rgba('. $spin_rgb .', 0.2), 13px 20px 0 rgba('. $spin_rgb .', 0.2), 13px 46px 0 rgba('. $spin_rgb .', 0.2), -13px 46px 0 '. $spinclr .'; } }';
        }
        if ('09' == $pretype) {
            $theCSS .= '.loader09 {width: 10px;height: 48px;background: '. $spinclr .';position: relative;animation: loader09 1s ease-in-out infinite;animation-delay: 0.4s;top: 50%;margin: -28px auto 0; }.loader09::after, .loader09::before {content:  "";position: absolute;width: 10px;height: 48px;background: '. $spinclr .';animation: loader09 1s ease-in-out infinite; }.loader09::before {right: 18px;animation-delay: 0.2s; }.loader09::after {left: 18px;animation-delay: 0.6s; }@keyframes loader09 {0%, 100% {box-shadow: 0 0 0 '. $spinclr .', 0 0 0 '. $spinclr .'; }50% {box-shadow: 0 -8px 0 '. $spinclr .', 0 8px 0 '. $spinclr .'; } }';
        }
        if ('10' == $pretype) {
            $theCSS .= '.loader10 {width: 28px;height: 28px;border-radius: 50%;position: relative;animation: loader10 0.9s ease alternate infinite;animation-delay: 0.36s;top: 50%;margin: -42px auto 0; }.loader10::after, .loader10::before {content: "";position: absolute;width: 28px;height: 28px;border-radius: 50%;animation: loader10 0.9s ease alternate infinite; }.loader10::before {left: -40px;animation-delay: 0.18s; }.loader10::after {right: -40px;animation-delay: 0.54s; }@keyframes loader10 {0% {box-shadow: 0 28px 0 -28px '. $spinclr .'; }100% {box-shadow: 0 28px 0 '. $spinclr .'; } }';
        }
        if ('11' == $pretype) {
            $theCSS .= '.loader11 {width: 20px;height: 20px;border-radius: 50%;box-shadow: 0 40px 0 '. $spinclr .';position: relative;animation: loader11 0.8s ease-in-out alternate infinite;animation-delay: 0.32s;top: 50%;margin: -50px auto 0; }.loader11::after, .loader11::before {content:  "";position: absolute;width: 20px;height: 20px;border-radius: 50%;box-shadow: 0 40px 0 '. $spinclr .';animation: loader11 0.8s ease-in-out alternate infinite; }.loader11::before {left: -30px;animation-delay: 0.48s;}.loader11::after {right: -30px;animation-delay: 0.16s; }@keyframes loader11 {0% {box-shadow: 0 40px 0 '. $spinclr .'; }100% {box-shadow: 0 20px 0 '. $spinclr .'; } }';
        }
        if ('12' == $pretype) {
            $theCSS .= '.loader12 {width: 20px;height: 20px;border-radius: 50%;position: relative;animation: loader12 1s linear alternate infinite;top: 50%;margin: -50px auto 0; }@keyframes loader12 {0% {box-shadow: -60px 40px 0 2px '. $spinclr .', -30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 0 40px 0 0 rgba('. $spin_rgb .', 0.2), 30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 60px 40px 0 0 rgba('. $spin_rgb .', 0.2); }25% {box-shadow: -60px 40px 0 0 rgba('. $spin_rgb .', 0.2), -30px 40px 0 2px '. $spinclr .', 0 40px 0 0 rgba('. $spin_rgb .', 0.2), 30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 60px 40px 0 0 rgba('. $spin_rgb .', 0.2); }50% {box-shadow: -60px 40px 0 0 rgba('. $spin_rgb .', 0.2), -30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 0 40px 0 2px '. $spinclr .', 30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 60px 40px 0 0 rgba('. $spin_rgb .', 0.2); }75% {box-shadow: -60px 40px 0 0 rgba('. $spin_rgb .', 0.2), -30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 0 40px 0 0 rgba('. $spin_rgb .', 0.2), 30px 40px 0 2px '. $spinclr .', 60px 40px 0 0 rgba('. $spin_rgb .', 0.2); }100% {box-shadow: -60px 40px 0 0 rgba('. $spin_rgb .', 0.2), -30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 0 40px 0 0 rgba('. $spin_rgb .', 0.2), 30px 40px 0 0 rgba('. $spin_rgb .', 0.2), 60px 40px 0 2px '. $spinclr .'; } }';
        }
    }

    $root1 = electron_settings( 'theme_clr1' );
        $root2 = electron_settings( 'theme_clr2' );
        $root3 = electron_settings( 'theme_clr3' );
        $root4 = electron_settings( 'theme_clr4' );
        $root5 = electron_settings( 'theme_clr5' );
        $root6 = electron_settings( 'theme_clr6' );
        $root7 = electron_settings( 'theme_clr7' );
        $root8 = electron_settings( 'theme_clr8' );
        $root9 = electron_settings( 'theme_clr9' );
        $root10 = electron_settings( 'theme_clr10' );
        $root11 = electron_settings( 'theme_clr11' );
        $root12 = electron_settings( 'theme_clr12' );
        $root13 = electron_settings( 'theme_clr13' );
        $root14 = electron_settings( 'theme_clr14' );
        $root15 = electron_settings( 'theme_clr15' );
        $root16 = electron_settings( 'theme_clr16' );
        $root17 = electron_settings( 'theme_clr17' );
        $root18 = electron_settings( 'theme_clr18' );
        $root19 = electron_settings( 'theme_clr19' );
        $root20 = electron_settings( 'theme_clr20' );
        $root21 = electron_settings( 'theme_clr21' );
        $root22 = electron_settings( 'theme_clr22' );
        $root23 = electron_settings( 'theme_clr23' );
        $root24 = electron_settings( 'theme_clr24' );
        $root25 = electron_settings( 'theme_clr25' );
        $root26 = electron_settings( 'theme_clr26' );
        $root27 = electron_settings( 'theme_clr27' );
        $root28 = electron_settings( 'theme_clr28' );
        $root29 = electron_settings( 'theme_clr29' );
        $root30 = electron_settings( 'theme_clr30' );
        $root31 = electron_settings( 'theme_clr31' );
        $root32 = electron_settings( 'theme_clr32' );
        $root33 = electron_settings( 'theme_clr33' );
        $root34 = electron_settings( 'theme_clr34' );
        $root35 = electron_settings( 'theme_clr35' );
        $root36 = electron_settings( 'theme_clr36' );
        $root37 = electron_settings( 'theme_clr37' );
        $root38 = electron_settings( 'theme_clr38' );
        $root39 = electron_settings( 'theme_clr39' );
        $root40 = electron_settings( 'theme_clr40' );
        $root41 = electron_settings( 'theme_clr41' );
        $root42 = electron_settings( 'theme_clr42' );
        $root43 = electron_settings( 'theme_clr43' );
        $root44 = electron_settings( 'theme_clr44' );
        $root45 = electron_settings( 'theme_clr45' );

    $theCSS .= ':root {';
        if( $root1 ) { $theCSS .= '--electron-primary: '.$root1.';'; }
        if( $root2 ) { $theCSS .= '--electron-secondary: '.$root2.';'; }
        if( $root3 ) { $theCSS .= '--electron-text: '.$root3.';'; }
        if( $root4 ) { $theCSS .= '--electron-text-soft: '.$root4.';'; }
        if( $root5 ) { $theCSS .= '--electron-dark: '.$root5.';'; }
        if( $root6 ) { $theCSS .= '--electron-dark-soft: '.$root6.';'; }
        if( $root7 ) { $theCSS .= '--electron-light: '.$root7.';'; }
        if( $root8 ) { $theCSS .= '--electron-light-soft: '.$root8.';'; }
        if( $root9 ) { $theCSS .= '--electron-gray: '.$root9.';'; }
        if( $root10 ) { $theCSS .= '--electron-gray-dark: '.$root10.';'; }
        if( $root11 ) { $theCSS .= '--electron-gray-soft: '.$root11.';'; }
        if( $root12 ) { $theCSS .= '--electron-border: '.$root12.';'; }
        if( $root13 ) { $theCSS .= '--electron-dark-border: '.$root13.';'; }
        if( $root14 ) { $theCSS .= '--electron-trans-border: '.$root14.';'; }
        if( $root15 ) { $theCSS .= '--electron-success: '.$root15.';'; }
        if( $root16 ) { $theCSS .= '--electron-success-bg: '.$root16.';'; }
        if( $root17 ) { $theCSS .= '--electron-success-border: '.$root17.';'; }
        if( $root18 ) { $theCSS .= '--electron-warning: '.$root18.';'; }
        if( $root19 ) { $theCSS .= '--electron-warning-bg: '.$root19.';'; }
        if( $root20 ) { $theCSS .= '--electron-warning-border: '.$root20.';'; }
        if( $root21 ) { $theCSS .= '--electron-info: '.$root21.';'; }
        if( $root22 ) { $theCSS .= '--electron-info-bg: '.$root22.';'; }
        if( $root23 ) { $theCSS .= '--electron-info-border: '.$root23.';'; }
        if( $root24 ) { $theCSS .= '--electron-red: '.$root24.';'; }
        if( $root25 ) { $theCSS .= '--electron-red-dark: '.$root25.';'; }
        if( $root26 ) { $theCSS .= '--electron-red-soft: '.$root26.';'; }
        if( $root27 ) { $theCSS .= '--electron-red-softer: '.$root27.';'; }
        if( $root28 ) { $theCSS .= '--electron-red-text: '.$root28.';'; }
        if( $root29 ) { $theCSS .= '--electron-red-bg: '.$root29.';'; }
        if( $root30 ) { $theCSS .= '--electron-red-border: '.$root30.';'; }
        if( $root31 ) { $theCSS .= '--electron-green: '.$root31.';'; }
        if( $root32 ) { $theCSS .= '--electron-green-soft: '.$root32.';'; }
        if( $root33 ) { $theCSS .= '--electron-green-bg: '.$root33.';'; }
        if( $root34 ) { $theCSS .= '--electron-purple: '.$root34.';'; }
        if( $root35 ) { $theCSS .= '--electron-purple-soft: '.$root35.';'; }
        if( $root36 ) { $theCSS .= '--electron-purple-bg: '.$root36.';'; }
        if( $root37 ) { $theCSS .= '--electron-yellow: '.$root37.';'; }
        if( $root38 ) { $theCSS .= '--electron-yellow-soft: '.$root38.';'; }
        if( $root39 ) { $theCSS .= '--electron-yellow-bg: '.$root39.';'; }
        if( $root40 ) { $theCSS .= '--electron-brown: '.$root40.';'; }
        if( $root41 ) { $theCSS .= '--electron-cream: '.$root41.';'; }
        if( $root42 ) { $theCSS .= '--electron-blue-dark: '.$root42.';'; }
        if( $root43 ) { $theCSS .= '--electron-blue: '.$root43.';'; }
        if( $root44 ) { $theCSS .= '--electron-blue-soft: '.$root44.';'; }
        if( $root45 ) { $theCSS .= '--electron-blue-bg: '.$root45.';'; }
    $theCSS .= '}';

    // use page/post ID for page settings
    $page_id = get_the_ID();

    /*************************************************
    ## THEME PAGINATION
    *************************************************/
    // pagination color
    $pag_radius = electron_settings('pagination_border_radius');
    $pag_align  = electron_settings('pagination_alignment');

    // pagination border radius
    if ( $pag_radius ) {
        $theCSS .= '.nt-pagination .nt-pagination-item .nt-pagination-link,
        .electron-woocommerce-pagination ul li a,
        .electron-woocommerce-pagination ul li span { border-radius: '. esc_attr( $pag_radius ) .'px; }';
    }
    // pagination border radius
    if ( $pag_align ) {
        $theCSS .= 'body .electron-woocommerce-pagination ul {justify-content: '. esc_attr( $pag_align ) .';}';
    }

    $container = electron_settings('shop_container_width', '1580');
    $sidebar   = electron_settings('shop_sidebar_width', '320');
    $col       = electron_settings('shop_col', '5');
    $col1024   = electron_settings('shop_col_1024');
    $col992    = electron_settings('shop_col_992');
    $col768    = electron_settings('shop_col_768');
    $col576    = electron_settings('shop_col_576');
    $col480    = electron_settings('shop_col_480');
    $col       = $col +1;

    if ( '1' == electron_get_shop_column() ) {
        $col = 3;
    }
    if ( '2' == electron_get_shop_column() ) {
        $col = 3;
    }
    if ( '3' == electron_get_shop_column() ) {
        $col = 4;
    }
    if ( '4' == electron_get_shop_column() ) {
        $col = 5;
    }
    if ( '5' == electron_get_shop_column() ) {
        $col = 6;
    }
    if ( '6' == electron_get_shop_column() ) {
        $col = 7;
    }

    $theCSS .= '@media(min-width:992px) {
    .shop-container.has-sidebar .electron-products:not(.products-type-list),
    .shop-container.has-sidebar .electron-shop-categories {
        grid-template-columns: repeat(auto-fill, minmax(calc(('.$container.'px - '.$sidebar.'px) / '.$col.'), 1fr));
    }
    .shop-container.has-sidebar .electron-products.column-5:not(.products-type-list),
    .shop-container.has-sidebar .electron-shop-categories.column-5 {
        grid-template-columns: repeat(auto-fill, minmax(calc(('.$container.'px - '.$sidebar.'px) / 7), 1fr));
    }
    .shop-container.has-sidebar .electron-products.column-4:not(.products-type-list),
    .shop-container.has-sidebar .electron-shop-categories.column-4 {
        grid-template-columns: repeat(auto-fill, minmax(calc(('.$container.'px - '.$sidebar.'px) / 6), 1fr));
    }
    .shop-container.has-sidebar .electron-products.column-3:not(.products-type-list),
    .shop-container.has-sidebar .electron-shop-categories.column-3 {
        grid-template-columns: repeat(auto-fill, minmax(calc(('.$container.'px - '.$sidebar.'px) / 4), 1fr));
    }
    .shop-container.has-sidebar .electron-products.column-2:not(.products-type-list),
    .shop-container.has-sidebar .electron-shop-categories.column-2 {
        grid-template-columns: repeat(auto-fill, minmax(calc(('.$container.'px - '.$sidebar.'px) / 3), 1fr));
    }
    }';


    $theCSS .= '.shop-container.has-sidebar {
        grid-template-columns: '.$sidebar.'px 1fr;
    }';
    $theCSS .= '.shop-container.has-sidebar.right-sidebar {
        grid-template-columns: 1fr '.$sidebar.'px;
    }';

    if ( '1' == electron_settings('product_name_max_line_visibility', '0' ) ) {
        $maxline = electron_settings( 'product_name_max_line', '2' );
        $theCSS .= '.product-inner .product-name {overflow: hidden;display: -webkit-box;-webkit-line-clamp: '. esc_attr( $maxline ) .';line-clamp: '. esc_attr( $maxline ) .';-webkit-box-orient: vertical;}';
    }

    if ( $col1024 != '0' ) {
        $theCSS .= '@media(max-width:1024px) {
            .shop-container .electron-products:not(.products-type-list) {
                grid-template-columns: repeat('.$col1024.', 1fr)!important;
            }
        }';
    }
    if ( $col992 != '0' ) {
        $theCSS .= '@media(max-width:992px) {
            .shop-container .electron-products:not(.products-type-list) {
                grid-template-columns: repeat('.$col992.', 1fr)!important;
            }
        }';
    }
    if ( $col768 != '0' ) {
        $theCSS .= '@media(max-width:768px) {
            .shop-container .electron-products:not(.products-type-list) {
                grid-template-columns: repeat('.$col768.', 1fr)!important;
            }
        }';
    }
    if ( $col576 != '0' ) {
        $theCSS .= '@media(max-width:576px) {
            .shop-container .electron-products:not(.products-type-list) {
                grid-template-columns: repeat('.$col576.', 1fr)!important;
            }
        }';
    }
    if ( $col480 != '0' ) {
        $theCSS .= '@media(max-width:480px) {
            .shop-container .electron-products:not(.products-type-list) {
                grid-template-columns: repeat('.$col480.', 1fr)!important;
            }
        }';
    }


    /*************************************************
    ## METABOX SETTINGS
    *************************************************/
    if ( class_exists( 'WooCommerce' ) && is_product() ) {

        $summarybg_type_ot = electron_settings( 'single_shop_showcase_bg_type', '' );
        $summarybg_type_mb = get_post_meta( $page_id, 'electron_showcase_bg_type', true );
        $summarybg_type    = $summarybg_type_mb ? $summarybg_type_mb : $summarybg_type_ot;
        $summarybg_type    = apply_filters('electron_showcase_bg_type', $summarybg_type );

        $summarybg_ot      = electron_settings( 'single_shop_showcase_custom_bgcolor', '' );
        $summarybg_mb      = get_post_meta( $page_id, 'electron_showcase_custom_bgcolor', true );
        $summarybg         = $summarybg_mb ? $summarybg_mb : $summarybg_ot;
        $summarybg         = apply_filters('electron_showcase_custom_bgcolor', $summarybg );

        $summarytext_ot    = electron_settings( 'single_shop_showcase_custom_textcolor', '' );
        $summarytext_mb    = get_post_meta( $page_id, 'electron_showcase_custom_textcolor', true );
        $summarytext       = $summarytext_mb ? $summarytext_mb : $summarytext_ot;
        $summarytext       = apply_filters('electron_showcase_custom_textcolor', $summarytext );

        if ( 'custom' == $summarybg_type ) {
            if ( $summarybg ) {
                $theCSS .= '.page-'.$page_id.' .electron-product-showcase, .postid-'.$page_id.' .electron-product-showcase.electron-bg-custom { background-color:'.esc_url( $summarybg ).'; }';
            }
            if ( $summarytext ) {
                $theCSS .= '.electron-product-showcase.electron-bg-custom .electron-summary-item.electron-product-title,
                .electron-product-showcase.electron-bg-custom .electron-product-summary .electron-summary-item.electron-price,
                .electron-product-showcase.electron-bg-custom .electron-price span.del > span,
                .electron-product-showcase.electron-bg-custom .electron-summary-item .woocommerce-product-details__short-description,
                .electron-product-showcase.electron-bg-custom .electron-small-title,
                .electron-product-showcase.electron-bg-custom .electron-small-title a,
                .electron-product-showcase.electron-bg-custom .electron-product-view,
                .electron-product-showcase.electron-bg-custom .electron-product-view span,
                .electron-product-showcase.electron-bg-custom .electron-estimated-delivery,
                .electron-product-showcase.electron-bg-custom .electron-estimated-delivery span,
                .electron-product-showcase.electron-bg-custom a.electron-open-popup,
                .electron-product-showcase.electron-bg-custom .electron-product-summary .electron-product-meta .posted_in,
                .electron-product-showcase.electron-bg-custom .electron-product-summary .electron-product-meta .tagged_as,
                .electron-product-showcase.electron-bg-custom .quantity-button.plus,
                .electron-product-showcase.electron-bg-custom .quantity-button.minus,
                .electron-product-showcase.electron-bg-custom .input-text.qty,
                .electron-product-showcase.electron-bg-custom .woocommerce-product-details__short-description,
                .electron-product-showcase.electron-bg-custom .electron-single-product-stock .stock-details span,
                .electron-product-showcase.electron-bg-custom .electron-breadcrumb li,
                .electron-product-showcase.electron-bg-custom .electron-breadcrumb li a,
                .electron-product-showcase.electron-bg-custom .electron-product-summary .electron-product-meta .electron-brands a,
                .electron-product-showcase.electron-bg-custom .electron-product-summary .electron-product-meta .posted_in a,
                .electron-product-showcase.electron-bg-custom .electron-product-summary .electron-product-meta .tagged_as a,
                .electron-product-showcase.electron-bg-custom span.electron-shop-link-icon,
                .electron-product-showcase.electron-bg-custom .product-nav-link,
                .electron-product-showcase.electron-bg-custom .electron-product-summary .electron-product-meta .electron-brands {
                    color: '.esc_url( $summarytext ).';
                }
                .electron-product-showcase.electron-bg-custom span.electron-shop-link-icon:before,
                .electron-product-showcase.electron-bg-custom span.electron-shop-link-icon:after {
                    border-color: '.esc_url( $summarytext ).';
                }';
            }
        }

        $product_header_mb = get_post_meta( $page_id, 'electron_product_header_type', true );
        if ( 'custom' == $product_header_mb ) {
            $header_bgcolor           = get_post_meta( $page_id, 'electron_product_header_bgcolor', true );
            $menuitem_color           = get_post_meta( $page_id, 'electron_product_header_menuitem_color', true );
            $menuitem_hvrcolor        = get_post_meta( $page_id, 'electron_product_header_menuitem_hvrcolor', true );
            $svgicon_color            = get_post_meta( $page_id, 'electron_product_header_svgicon_color', true );
            $counter_bgcolor          = get_post_meta( $page_id, 'electron_product_header_counter_bgcolor', true );
            $counter_color            = get_post_meta( $page_id, 'electron_product_header_counter_color', true );
            $sticky_header_bgcolor    = get_post_meta( $page_id, 'electron_product_sticky_header_bgcolor', true );
            $sticky_menuitem_color    = get_post_meta( $page_id, 'electron_product_sticky_header_menuitem_color', true );
            $sticky_menuitem_hvrcolor = get_post_meta( $page_id, 'electron_product_sticky_header_menuitem_hvrcolor', true );
            $sticky_svgicon_color     = get_post_meta( $page_id, 'electron_product_sticky_header_svgicon_color', true );
            $sticky_counter_bgcolor   = get_post_meta( $page_id, 'electron_product_sticky_header_counter_bgcolor', true );
            $sticky_counter_color     = get_post_meta( $page_id, 'electron_product_sticky_header_counter_color', true );

            if ( $header_bgcolor ) {
                $theCSS .= '.single-product.postid-'.$page_id.' header.electron-header-default {
                    background-color:'.esc_url( $header_bgcolor ).'!important;
                }';
            }
            if ( $menuitem_color ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default .electron-header-top-menu-area>ul>li.menu-item>a,
                .single-product.postid-'.$page_id.' .electron-header-top-menu-area ul li .submenu>li.menu-item>a {
                    color:'.esc_url( $menuitem_color ).'!important;
                }';
            }
            if ( $menuitem_hvrcolor ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default .electron-header-top-menu-area>ul>li.menu-item>a:hover,
                .single-product.postid-'.$page_id.' .electron-header-default .electron-header-top-menu-area ul li .submenu>li.menu-item>a:hover,
                .single-product.postid-'.$page_id.' .electron-header-default .electron-header-top-menu-area>ul>li.menu-item.active>a,
                .single-product.postid-'.$page_id.' .electron-header-default .electron-header-top-menu-area ul li .submenu>li.menu-item.active>a {
                    color:'.esc_url( $menuitem_hvrcolor ).'!important;
                }';
            }
            if ( $svgicon_color ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default .electron-svg-icon {
                    fill:'.esc_url( $svgicon_color ).'!important;
                    color:'.esc_url( $svgicon_color ).'!important;
                }';
            }
            if ( $counter_bgcolor ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default .electron-wc-count {
                    background-color:'.esc_url( $counter_bgcolor ).'!important;
                }';
            }
            if ( $counter_color ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default .electron-wc-count {
                    color:'.esc_url( $counter_color ).'!important;
                }';
            }
            if ( $sticky_header_bgcolor ) {
                $theCSS .= '.single-product.postid-'.$page_id.' header.electron-header-default.sticky-start {
                    background-color:'.esc_url( $sticky_header_bgcolor ).'!important;
                }';
            }
            if ( $sticky_menuitem_color ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-header-top-menu-area>ul>li.menu-item>a,
                .single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-header-top-menu-area ul li .submenu>li.menu-item>a {
                    color:'.esc_url( $sticky_menuitem_color ).'!important;
                }';
            }
            if ( $sticky_menuitem_hvrcolor ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-header-top-menu-area>ul>li.menu-item>a:hover,
                .single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-header-top-menu-area ul li .submenu>li.menu-item>a:hover,
                .single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-header-top-menu-area>ul>li.menu-item.active>a,
                .single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-header-top-menu-area ul li .submenu>li.menu-item.active>a {
                    color:'.esc_url( $sticky_menuitem_hvrcolor ).'!important;
                }';
            }
            if ( $sticky_svgicon_color ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-svg-icon {
                    fill:'.esc_url( $sticky_svgicon_color ).'!important;
                    color:'.esc_url( $sticky_svgicon_color ).'!important;
                }';
            }
            if ( $sticky_counter_bgcolor ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-wc-count {
                    background-color:'.esc_url( $sticky_counter_bgcolor ).'!important;
                }';
            }
            if ( $sticky_counter_color ) {
                $theCSS .= '.single-product.postid-'.$page_id.' .electron-header-default.sticky-start .electron-wc-count {
                    color:'.esc_url( $sticky_counter_color ).'!important;
                }';
            }
        }

        $share_shape_type = electron_settings( 'single_shop_share_shape_type', '' );
        $active_tab       = electron_settings( 'product_tabs_active_tab', '' );

        if ( 'square' == $share_shape_type ) {
            $theCSS .= '.postid-'.$page_id.' .electron-product-summary .electron-social-icons a { border-radius: 0; }';
        }
        if ( 'round' == $share_shape_type ) {
            $theCSS .= '.postid-'.$page_id.' .electron-product-summary .electron-social-icons a { border-radius: 4px; }';
        }
        if ( $active_tab != '' && $active_tab != 'all' ) {
            $theCSS .= '.electron-product-accordion-wrapper .electron-accordion-item'.$active_tab.' .electron-accordion-body { display: block; }';
        }
        if ( $active_tab == 'all' ) {
            $theCSS .= '.electron-product-accordion-wrapper .electron-accordion-item .electron-accordion-body { display: block; }';
        }

        $terms_brd_radius       = electron_settings( 'selected_variations_terms_brd_radius', '' );
        $disabled_terms_opacity = electron_settings( 'product_attr_term_inactive_opacity', '' );

        if ( '1' == electron_settings( 'swatches_visibility', '1' ) ) {
            if ( '-1' == $terms_brd_radius ) {
                $theCSS .= '.postid-'.$page_id.' .electron-selected-variations-terms-wrapper .electron-selected-variations-terms { border-radius:'.esc_attr( $terms_brd_radius ).'px; }';
            }

            if ( $disabled_terms_opacity ) {
                $theCSS .= '.electron-terms .electron-term.electron-disabled { opacity:'.$disabled_terms_opacity.';}';
            }
        }
        $product_sale_radius         = electron_settings( 'product_sale_radius', '' );
        $product_discount_radius     = electron_settings( 'product_discount_radius', '' );
        $product_stock_radius        = electron_settings( 'product_stock_radius', '' );
        $product_outofstock_radius   = electron_settings( 'product_outofstock_radius', '' );
        $product_progressbar_radius  = electron_settings( 'product_progressbar_wrapper_brd_radius', '' );
        $product_progress_brd_radius = electron_settings( 'product_progressbar_brd_radius', '' );
        if ( '-1' != $product_sale_radius ) {
            $theCSS .= '.electron-product-summary .electron-label.electron-badge { border-radius:'.esc_attr( $product_sale_radius ).'px; }';
        }
        if ( '-1' != $product_discount_radius ) {
            $theCSS .= '.electron-product-summary .electron-label.electron-discount { border-radius:'.esc_attr( $product_discount_radius ).'px; }';
        }
        if ( '-1' != $product_stock_radius ) {
            $theCSS .= '.electron-price-wrapper .electron-stock-status.in-stock { border-radius:'.esc_attr( $product_stock_radius ).'px; }';
        }
        if ( '-1' != $product_outofstock_radius ) {
            $theCSS .= '.electron-price-wrapper .electron-price-wrapper .out-of-stock { border-radius:'.esc_attr( $product_outofstock_radius ).'px; }';
        }
        if ( '-1' != $product_progressbar_radius ) {
            $theCSS .= '.electron-product-summary .electron-summary-item.electron-single-product-stock { border-radius:'.esc_attr( $product_progressbar_radius ).'px; }';
        }
        if ( '-1' != $product_progress_brd_radius ) {
            $theCSS .= '.electron-single-product-stock .electron-product-stock-progress { border-radius:'.esc_attr( $product_progress_brd_radius ).'px; }';
        }
        $thumbs_height = electron_settings( 'product_gallery_thumbs_height', '' );
        $thumbs_width  = electron_settings( 'product_gallery_thumbs_width', '' );
        if ( '29' != $thumbs_height ) {
            $theCSS .= '.electron-product-gallery-col .electron-swiper-thumbnails .swiper-slide { min-height: '.esc_attr( $thumbs_height ).'px; }';
        }
        if ( $thumbs_width && '29' != $thumbs_width ) {
            $theCSS .= '@media (min-width: 769px) {
                .electron-swiper-slider-wrapper.thumbs-left .electron-product-thumbnails,
                .electron-swiper-slider-wrapper.thumbs-right .electron-product-thumbnails {
                    max-width: '.esc_attr( $thumbs_width ).'px;
                }
                .electron-swiper-slider-wrapper.thumbs-right .electron-product-gallery-main-slider {
                    margin-right: '.esc_attr( intval($thumbs_width)+10 ).'px;
                }
                .electron-product-thumbnails-wrapper {
                    width: '.esc_attr( $thumbs_width ).'px;
                }
            }';
        }
        $coupons_bgcolor = electron_settings( 'product_coupons_bgcolor', '' );
        if ( '' != $coupons_bgcolor ) {
            $theCSS .= '.electron-summary-item.coupons .coupon::before {background-color: '.$coupons_bgcolor.';}';
            $theCSS .= '.electron-summary-item.coupons .coupon::after {background-image: radial-gradient(circle at 100% 50%,transparent 25px,'.$coupons_bgcolor.' 26px);}';

        }
        $coupons_right_bgcolor = electron_settings( 'product_coupons_right_bgcolor', '' );
        if ( '' != $coupons_right_bgcolor ) {
            $theCSS .= '.electron-summary-item.coupons .right {background-image: radial-gradient(circle at 100% 50%,transparent 25px,'.$coupons_right_bgcolor.' 26px);}';

        }
    }

    /*************************************************
    ## PAGE METABOX SETTINGS
    *************************************************/
    $is_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true);
    if ( is_page() && ! $is_elementor ) {

        $heroimg = wp_get_attachment_image_src( $page_id, 'full' );
        if ( $heroimg ) {
            $theCSS .= '.page-'.$page_id.' .breadcrumb-bg { background-image:url('.esc_url( $heroimg ).'); }';
        }
    }
    $blog_hero_tablet = electron_settings( 'blog_hero_height_tablet', '' );
    if ( !empty($blog_hero_tablet['height']) ) {
        $theCSS .= '@media(max-width:1024px) { #nt-index.nt-index .electron-page-hero { height:'.$blog_hero_tablet['height'].'; }}';
    }
    $blog_hero_phone = electron_settings( 'blog_hero_height_phone', '' );
    if ( !empty($blog_hero_phone['height']) ) {
        $theCSS .= '@media(max-width:576px) { #nt-index.nt-index .electron-page-hero { height:'.$blog_hero_phone['height'].'; }}';
    }

    if ( is_single() ) {
        $single_hero_tablet = electron_settings( 'single_hero_height_tablet', '' );
        if ( !empty($single_hero_tablet['height']) ) {
            $theCSS .= '@media(max-width:1024px) { #nt-single.nt-single .electron-page-hero { height:'.$single_hero_tablet['height'].'; }}';
        }
        $single_hero_phone = electron_settings( 'single_hero_height_phone', '' );
        if ( !empty($single_hero_phone['height']) ) {
            $theCSS .= '@media(max-width:576px) { #nt-single.nt-single .electron-page-hero { height:'.$single_hero_phone['height'].'; }}';
        }
    }
    if ( is_archive() ) {
        $archive_hero_tablet = electron_settings( 'archive_hero_height_tablet', '' );
        if ( !empty($archive_hero_tablet['height']) ) {
            $theCSS .= '@media(max-width:1024px) { #nt-archive.nt-archive .electron-page-hero { height:'.$archive_hero_tablet['height'].'; }}';
        }
        $archive_hero_phone = electron_settings( 'archive_hero_height_phone', '' );
        if ( !empty($archive_hero_phone['height']) ) {
            $theCSS .= '@media(max-width:576px) { #nt-archive.nt-archive .electron-page-hero { height:'.$archive_hero_phone['height'].'; }}';
        }
    }
    if ( is_search() ) {
        $search_hero_tablet = electron_settings( 'search_hero_height_tablet', '' );
        if ( !empty($search_hero_tablet['height']) ) {
            $theCSS .= '@media(max-width:1024px) { #nt-search.nt-search .electron-page-hero { height:'.$search_hero_tablet['height'].'; }}';
        }
        $search_hero_phone = electron_settings( 'search_hero_height_phone', '' );
        if ( !empty($search_hero_phone['height']) ) {
            $theCSS .= '@media(max-width:576px) { #nt-search.nt-search .electron-page-hero { height:'.$search_hero_phone['height'].'; }}';
        }
    }

    $extraCSS = '';
    $extraCSS = apply_filters( 'electron_add_custom_css', $extraCSS );
    $theCSS .= $extraCSS;

    /* Add CSS to style.css */
    wp_register_style('electron-custom-style', false);
    wp_enqueue_style('electron-custom-style');
    wp_add_inline_style('electron-custom-style', $theCSS );
}
add_action('wp_enqueue_scripts', 'electron_custom_css',9999999);


// customization on admin pages
function electron_admin_custom_css()
{
    if ( ! is_admin() ) {
        return false;
    }

    /* CSS to output */
    $theCSS   = '';
    $is_right = is_rtl() ? 'right' : 'left';
    $is_left  = is_rtl() ? 'left' : 'right';
    $theCSS  .= '
    #setting-error-tgmpa, #setting-error-electron {
        display: block !important;
    }

    li.menu-item:not(.menu-item-depth-0) .electron-field-link-shortcode,
    li.menu-item:not(.menu-item-depth-0) .electron-field-link-hidetitle,
    li.menu-item:not(.menu-item-depth-0) .electron-field-link-mega,
    li.menu-item:not(.menu-item-depth-0) .electron-field-link-mega-columns,
    li.menu-item.menu-item-depth-0:not(.mega-parent) .electron-field-link-shortcode,
    li.menu-item.menu-item-depth-0:not(.mega-parent) .electron-field-link-hidetitle,
    li.menu-item.menu-item-depth-0:not(.mega-parent) .electron-field-link-mega-columns {
        display: none;
    }
    div#message.updated.woocommerce-message {
        display: none;
    }
    .electron_menu_options {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 10px 0;
        background: #eeeeee;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .electron-field-link-mega.electron-menu-field.menu-flex {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .electron-menu-field {
        width: 100%;
        margin-top: 10px;
    }
    .electron_menu_options .small-tag {
        font-size: 10px;
        font-weight: 400;
        position: relative;
        top: -2px;
        display: inline-block;
        margin-'.$is_right.': 4px;
        color: #fff;
        background-color: #bbb;
        line-height: 1;
        padding: 3px 6px;
        border-radius: 3px;
    }
    .electron-panel-heading {
        padding: 10px 12px;
        border-bottom: 1px solid #ddd;
    }
    .electron-panel-subheading {
        padding: 0px 12px;
    }
    .electron-panel-divider {
        margin: 10px 0;
        border-bottom: 1px solid #ddd;
        display: block;
    }
    .reduxd_field_th {
        color: #191919;
        font-weight: 700;
    }
    .redux-container .redux-main .form-table tr {
        position: relative;
    }
    .redux-container .redux-main .form-table tr.hide-field {
        position: relative;
        min-height: 40px;
    }
    .toggle-field {
        position: absolute;
        top: 10px;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        cursor: pointer;
        background: #fff;
        border: 1px solid #7e8993;
    }
    .rtl .toggle-field {
        right: auto;
        left: 0;
    }
    .toggle-field.hide-field {
        background: #000;
        color: #fff;
    }
    .toggle-field.hide-field i {
        transform:rotate(180deg);
    }
    fieldset#electron-shop_hero_custom_layout,
    fieldset#electron-shop_loop_product_layouts {
        padding-right: 50px;
    }
    fieldset#shop_hero_custom_layout,
    fieldset#shop_loop_product_layouts {
        display: flex;
    }
    fieldset#shop_hero_custom_layout {
        flex-wrap: wrap;
    }
    fieldset#shop_hero_custom_layout ul,
    fieldset#shop_loop_product_layouts ul {
        flex: auto;
        float: none;
        min-width: 200px;
        width: auto!important;
    }
    fieldset#shop_hero_custom_layout ul {
        min-width: auto;
    }
    @media screen and (max-width: 768px) {
        fieldset#shop_hero_custom_layout,
        fieldset#shop_loop_product_layouts {
            flex-wrap: wrap;
            flex-direction: column;
        }
        fieldset#shop_hero_custom_layout ul,
        fieldset#shop_loop_product_layouts ul#shop_loop_product_layouts_hide {
            margin-top: 15px!important;
        }
    }
    ul#shop_loop_product_layouts_hide .shop_loop_product_layouts_inner {
        max-height: 400px;
        overflow: auto;
        display: flex;
        flex-wrap: wrap;
    }
    .shop_loop_product_layouts_inner li {
        flex: auto;
        margin: 10px 5px 10px 5px;
    }
    .redux-container .redux-main #electron-shop_product_type img {
        max-width: 175px!important;
        max-height: 220px;
    }
    #electron-shop_product_type.redux-container-image_select ul.redux-image-select li {
        padding: 15px!important;
    }
    #electron-shop_product_type.redux-container-image_select ul.redux-image-select{
        margin-left: -15px!important;
        margin-right: -15px!important;
    }
    input#electron_badge_color {
        margin: 0!important;
    }
    p.form-field.electron_wc_cat_banner_field span {
        display: block;
        max-width: 95%;
    }
    td.electron_cat_banner.column-electron_cat_banner {
        position: relative;
    }
    .electron_cat_banner span.wc-banner:before {
        font-family: Dashicons;
        font-weight: 400;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        text-indent: 0px;
        color: #2271b1;
        content: "\f155";
        font-variant: normal;
        margin: 0px;
        font-size: 18px;
    }
    span.wc-banner {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 25px;
        text-align: center;
    }
    .woocommerce_options_panel .electron-color-field-wrapper .wp-picker-input-wrap label{
        margin: 0;
        width: auto;
    }
    th#taxonomy-electron_product_brands,th#woosw {
        width: 11%!important;
    }
    .image-preview-wrapper {
        max-width: 100px;
    }
    .image-preview-wrapper img {
        max-width: 100%;
    }
    .options-trigger-wrapper {
        background-color: #23282d;
        margin-right: 20px;
        margin-bottom: -5px;
        margin-left: 3px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 60px;
        flex-wrap: wrap;
    }
    .redux-container #redux-header {
        display: none;
    }
    .nt-redux-header-theme + .wrap,
    .wrap.redux-wrap-div + .wrap {
        display: none;
    }
    .fold .select2-container .select2-selection--multiple .select2-selection__choice {
        padding-left: 25px;
    }
    .redux-main .description {
        display: block;
        font-weight: normal;
    }
    li#toplevel_page_wpclever,
    #redux-connect-message {
        opacity: 0 !important;
        display: none !important;
        visibility : hidden;
    }
    .redux-main .wp-picker-container .wp-color-result-text {
        line-height: 28px;
    }
    .redux-container .redux-main .input-append .add-on,
    .redux-container .redux-main .input-prepend .add-on {
        line-height: 22px;
    }
    .redux-main .redux-field-container {
        max-width: calc(100% - 40px);
    }
  	#customize-controls img {
  		max-width: 75%;
  	}
    .redux-info-desc .thm-btn:hover {
        color: #000;
    }
    .redux-info-desc .thm-btn i {
        margin-'.$is_right.': 10px;
    }
    .redux-info-desc .thm-btn {
        -moz-user-select: none;
        border: medium none;
        border-radius: 4px;
        color: #fff;
        background-color: #2271b1;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        height: 40px;
        min-width: 160px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0;
        line-height: 1;
        margin-bottom: 0;
        text-align: center;
        text-transform: uppercase;
        touch-action: manipulation;
        transition: all 0.3s ease 0s;
        vertical-align: middle;
        white-space: nowrap;
    }
    .electron-column-item {
        display: inline-block;
        width: 40px;
        height: 40px;
        background-color: #eee;
        box-sizing: border-box;
        border: 1px solid #eee;
    }
    #electron_swatches_image_thumbnail {
        float: left;
        margin-'.$is_left.': 10px;
    }
    #electron_swatches_image_wrapper {
        line-height: 60px;
    }

    span.electron-mega-menu-item-title,
    span.electron-mega-column-menu-item-title {
        margin-'.$is_right.': 10px;
        padding: 2px 4px;
        background: #2271b1;
        color: #fff;
        line-height: 1;
        font-size: 9px;
    }
    .electron-panel-subheading.menu-customize:not(.show_if_header_custom),
    .electron_product_header_bgcolor_field:not(.show_if_header_custom),
    .electron_product_header_menuitem_color_field:not(.show_if_header_custom),
    .electron_product_header_menuitem_hvrcolor_field:not(.show_if_header_custom),
    .electron_product_header_svgicon_color_field:not(.show_if_header_custom),
    .electron_product_header_counter_bgcolor_field:not(.show_if_header_custom),
    .electron_product_header_counter_color_field:not(.show_if_header_custom),
    .electron_product_sticky_header_type_field:not(.show_if_header_custom),
    .electron_product_sticky_header_bgcolor_field:not(.show_if_header_custom),
    .electron_product_sticky_header_menuitem_color_field:not(.show_if_header_custom),
    .electron_product_sticky_header_menuitem_hvrcolor_field:not(.show_if_header_custom),
    .electron_product_sticky_header_svgicon_color_field:not(.show_if_header_custom),
    .electron_product_sticky_header_counter_bgcolor_field:not(.show_if_header_custom),
    .electron_product_sticky_header_counter_color_field:not(.show_if_header_custom) {
        display: none;
    }
    ul.electron-variation-gallery-images {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    ul.electron-variation-gallery-images li {
        display: block;
        max-width: 60px;
        margin: 0;
    }
    ul.electron-variation-gallery-images li img {
        max-width: 100%;
    }
    .electron-select2 + .select2-container {
        width: 100%!important;
    }';
    // end $theCSS

    /* Add CSS to style.css */
    wp_register_style('electron-admin-custom-style', false);
    wp_enqueue_style('electron-admin-custom-style');
    wp_add_inline_style('electron-admin-custom-style', $theCSS);
}
add_action('admin_enqueue_scripts', 'electron_admin_custom_css');
