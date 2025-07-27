<?php
/*
* Theme Newsletter Popup
*/

$popup     = electron_settings('popup_newsletter_visibility', '0' );
$type      = electron_settings('popup_newsletter_type', 'elementor' );
$shortcode = electron_settings('popup_newsletter_shortcode');
$elementor = electron_settings('popup_newsletter_elementor_templates');
$image     = electron_settings('popup_newsletter_image');
$ncontent  = electron_settings('popup_newsletter_content');
$cookkie   = isset($_COOKIE['newsletterClosed']) ? true : false;
$date      = electron_settings('popup_newsletter_expire_date');
$class     = electron_settings('popup_newsletter_direction', 'image-left' );
$class    .= ' type-'.$type;
if ( '1' == $popup && ( $shortcode || $elementor ) && $cookkie !== true ) {
    ?>
    <div id="newsletterPopup" class="electron-newsletter-wrapper fadeIn <?php echo esc_attr( $class ); ?>">
        <div id="newsletterInner" class="electron-newsletter-inner zoomIn" data-expires="<?php echo esc_attr( $date ); ?>">
            <span id="newsletterClose" class="panel-close hint-left"><span class="electron-hint"><?php echo esc_html_e( 'Don\'t show this popup again.', 'electron' ); ?></span></span>
            <?php if ( 'shortcode' == $type && $shortcode ) { ?>
                <div class="site-newsletter-form"><?php echo do_shortcode( $shortcode ); ?></div>
            <?php } elseif ( 'elementor' == $type && $elementor ) { ?>
                <?php echo electron_print_elementor_templates( 'popup_newsletter_elementor_templates', 'site-newsletter-form', false ); ?>
            <?php } else { ?>
                <?php if ( !empty( $image['id'] ) ) { ?>
                    <div class="electron-newsletter-image"><?php echo wp_get_attachment_image($image['id'], 'large' ); ?></div>
                <?php } ?>
                <?php if ( trim($ncontent) ) { ?>
                    <div class="electron-newsletter-content">
                        <?php echo do_shortcode( $ncontent ); ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php
}
