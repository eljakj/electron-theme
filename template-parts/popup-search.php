<?php
/*
* Theme Popup Search Form
*/
$popup       = electron_header_settings( 'popup_search_visibility', '0' );
$title       = esc_html__( 'Most Popular Categories', 'electron' );
$search_type = electron_header_settings( 'ajax_search_form_type', 'theme' );
$search_form = electron_header_settings( 'ajax_search_form_shortcode', '' );
$popular     = electron_header_settings( 'popup_search_popular_cats_visibility', '0' );
$class       = electron_header_settings( 'header_ajax_search_style', '' );
$class      .= '0' == $popular ? ' none-poupular' : '';

if ( '1' == $popup && shortcode_exists( 'electron_wc_ajax_product_search' ) ) {
    ?>
    <div class="electron-popup-search <?php echo esc_attr( $class ); ?>">
        <span class="mobile-trigger panel-close" data-target=".electron-popup-search"></span>
        <div class="search-container">
            <div class="search-col search-wrapper">
                <?php
                $middle = check_header_disabled_items('header_layout_middle','search-form');
                $bottom = check_header_disabled_items('header_layout_bottom','search-form');
                if ( $middle && $bottom ) {
                    if ( $search_type == 'plugin' && $search_form ) {
                        ?>
                        <div class="electron-mobile-search"><?php echo do_shortcode($search_form); ?></div>
                        <?php
                    } else {
                        ?>
                        <div class="electron-mobile-search"><?php echo do_shortcode('[electron_wc_ajax_product_search cats="hide"]'); ?></div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="search-form-found"></div>
                    <?php
                }
                if ( '1' == $popular ) {
                    $cmiddle = check_header_disabled_items('header_layout_middle','catmenu');
                    $cbottom = check_header_disabled_items('header_layout_bottom','catmenu');
                    if ( $cmiddle && $cbottom ) {
                        ?>
                        <span class="cat-heading"><?php echo esc_html( $title ); ?></span>
                        <?php echo electron_wc_cats_menu(false,false); ?>
                    <?php } else { ?>
                        <span class="cat-heading"><?php echo esc_html( $title ); ?></span>
                        <div class="cats--found"></div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
}
