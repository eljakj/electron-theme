<?php
/**
* The template for displaying search results pages
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
*
* @package WordPress
* @subpackage Electron
* @since 1.0.0
*/

get_header();

// you can use this action for add any content before container element
do_action( 'electron_before_search' );

// Elementor `archive` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
    ?>
    <!-- search page general div -->
    <div id="nt-search" class="nt-search nt-inner-page-wrapper">

        <?php
            get_template_part( 'template-parts/page-hero' );

            get_template_part( 'blog/layout/main' );
        ?>
    </div>
    <!--End search page general div -->
    <?php
}

// you can use this action to add any content after search page
do_action( 'electron_after_search' );

get_footer();
?>
