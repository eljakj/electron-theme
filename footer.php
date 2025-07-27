<?php
/**
* The template for displaying the footer.
*
* Contains the closing of the #content div and all content after
*
* @package electron
*/

$newsletter = electron_settings('popup_newsletter_visibility', '0' );
$siteclose  = electron_settings('popup_siteclose_visibility', '0' );
$popup_form = electron_settings('popup_form_visibility', '0' );

?>

        </div>
        <?php
        do_action( 'electron_after_main_content' );
        // Elementor `footer` location
        if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
            get_template_part( 'template-parts/footer-elementor' );
        }
        ?>
    </div>

    <?php

    get_template_part( 'template-parts/theme-svg' );

    if ( '1' == $newsletter ) {
        get_template_part( 'template-parts/newsletter' );
    }

    if ( '1' == $siteclose ) {
        get_template_part( 'template-parts/siteclose' );
    }

    if ( '1' == $popup_form ) {
        get_template_part( 'template-parts/popup-form' );
    }

    get_template_part( 'template-parts/gdpr' );
    get_template_part( 'template-parts/popup-search' );

    do_action( 'electron_before_wp_footer' );

    wp_footer();
    ?>
    </body>
</html>
