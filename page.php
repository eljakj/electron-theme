<?php

/**
* default page template
*/

if ( function_exists('electron_is_pjax') && !electron_is_pjax() ) {
    get_header();
}

// Elementor `single` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
    $is_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true);
    if ( $is_elementor ) {
        while ( have_posts() )
        {
            the_post();
            the_content();
        }
    } else {
        get_template_part( 'page', 'content' );
    }
}

if ( function_exists('electron_is_pjax') && !electron_is_pjax() ) {
    get_footer();
}
