<?php
/*
* Theme Newsletter Popup
*/

$type      = electron_settings('popup_form_type', 'elementor' );
$shortcode = electron_settings('popup_form_shortcode');
$elementor = electron_settings('popup_form_elementor_templates');
$btn_text  = electron_settings('popup_form_btn_text');
$ncontent  = electron_settings('popup_form_content');
$cookkie   = isset($_COOKIE['formPopupClosed']) ? true : false;
$date      = electron_settings('popup_form_expire_date');
$timeout   = electron_settings('popup_form_timeout');
$class     = ' type-'.$type;
if ( ( $shortcode || $elementor ) && $cookkie !== true ) {
    ?>
    <div id="formPopupBtn" class="electron-popupform-trigger fadeIn <?php echo esc_attr( $class ); ?>" data-timeout="<?php echo esc_attr( $timeout ); ?>">
        <span id="formPopupTrigger" class="btn-text"><?php echo esc_html( $btn_text ); ?></span>
        <span id="formPopupClose1" class="panel-close hint-left disableFormPopup">
            <span class="electron-hint"><?php echo esc_html_e( 'Don\'t show this popup again.', 'electron' ); ?></span>
        </span>
    </div>
    <div id="formPopup" class="electron-popupform-wrapper fadeIn <?php echo esc_attr( $class ); ?>">
        <div id="formPopupOverlay" class="popupform-overlay disableFormPopup"></div>
        <div id="formPopupInner" class="electron-popupform-inner zoomIn" data-expires="<?php echo esc_attr( $date ); ?>">
            <span id="formPopupClose" class="panel-close hint-left disableFormPopup"><span class="electron-hint"><?php echo esc_html_e( 'Don\'t show this popup again.', 'electron' ); ?></span></span>
            <?php if ( 'shortcode' == $type && $shortcode ) { ?>
                <div class="site-popupform"><?php echo do_shortcode( $shortcode ); ?></div>
            <?php } elseif ( 'elementor' == $type && $elementor ) { ?>
                <?php echo electron_print_elementor_templates( 'popup_form_elementor_templates', 'site-popupform', false ); ?>
            <?php } else { ?>
                <?php if ( trim($ncontent) ) { ?>
                    <div class="electron-popupform-content">
                        <?php echo do_shortcode( $ncontent ); ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php
}
