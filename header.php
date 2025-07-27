<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <!-- Meta UTF8 charset -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="initial-scale=1.0" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>

</head>

<!-- BODY START -->
<body <?php body_class(); ?>>
    <?php
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    }
    /**
    * Hook: electron_after_body_open
    *
    */
    do_action( 'electron_after_body_open' );

    get_template_part( 'template-parts/preloader' );

    // Elementor `header` location
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {

        if ( class_exists('Redux' ) ) {
            get_template_part( 'template-parts/promotion' );
            get_template_part( 'template-parts/header' );
            get_template_part( 'template-parts/canvas-menu' );
        } else {
            $electronOpt = get_option('electron_header');
            if ( isset( $electronOpt ) ) {
                get_template_part( 'template-parts/promotion' );
                get_template_part( 'template-parts/header' );
                get_template_part( 'template-parts/canvas-menu' );
            } else {
                get_template_part( 'template-parts/header-default' );
            }
        }

    }
    ?>
    <div class="page-overlay"></div>

    <div id="wrapper" class="page-wrapper">
        <div role="main" class="site-content">
