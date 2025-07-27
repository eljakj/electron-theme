<?php

/**
* Custom template parts for this theme.
*
* Eventually, some of the functionality here could be replaced by core features.
*
* @package electron
*/

if ( '0' != electron_settings( 'footer_visibility', '1' ) ) {

    if ( 'elementor' == electron_settings( 'footer_template', 'default' ) ) {
        if ( '1' == electron_settings( 'footer_ajax', '0' ) ) {
            echo '<div class="electron-elementor-footer"></div>';
        } else {
            $ID = isset($_GET['footer_style']) ? esc_html($_GET['footer_style']) : electron_settings( 'footer_elementor_templates' );
            $ID = apply_filters( 'electron_translated_template_id', $ID );
            if ( class_exists( '\Elementor\Frontend' ) && $ID ) {
                echo '<div class="footer-template">';
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $ID, false );
                echo '</div>';
            }
        }
    } else {

        get_template_part( 'template-parts/footer-default' );

    }
}
