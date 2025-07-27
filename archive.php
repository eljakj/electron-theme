<?php
/**
* The template for displaying archive pages
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package WordPress
* @subpackage Electron
* @since 1.0.0
*/

get_header();

// you can use this action for add any content before container element
do_action( 'electron_before_archive' );

// Elementor `archive` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {

    ?>
    <div id="nt-archive" class="nt-archive nt-inner-page-wrapper">
        <?php
        get_template_part( 'template-parts/page-hero' );

        get_template_part( 'blog/layout/main' );
        ?>
    </div>
    <?php
}

do_action( 'electron_after_archive' );

get_footer();
?>
