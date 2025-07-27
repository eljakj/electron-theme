<?php

/**
* The template for displaying all single posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package WordPress
* @subpackage Electron
* @since 1.0.0
*/

get_header();

// Elementor `single` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

    wp_enqueue_style( 'electron-blog-post' );

    // you can use this action to add any content before single page
    do_action( 'electron_before_post_single' );
    
    $is_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true);

    if ( $is_elementor ) {

        while ( have_posts() ) {

            the_post();

            the_content();

        }

    } else {

        /**
        * Hook: electron_single.
        *
        * @hooked electron_single_layout
        */
        do_action( 'electron_single' );
    }

    // you can use this action to add any content after single page
    do_action( 'electron_after_post_single' );
}

get_footer();
?>
