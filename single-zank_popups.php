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

    remove_action( 'electron_header_action', 'electron_main_header', 10 );
    remove_action( 'electron_footer_action', 'electron_footer', 10 );

    get_header();

    while ( have_posts() ) : the_post();
        the_content();
    endwhile;

    get_footer();
?>
