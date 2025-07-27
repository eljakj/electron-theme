<?php
/*
* Theme Newsletter Popup
*/

$cookkie   = isset($_COOKIE['sitecloseClosed']) ? true : false;
$type      = electron_settings('popup_siteclose_type', 'elementor' );
$shortcode = electron_settings('popup_siteclose_shortcode');
$elementor = electron_settings('popup_siteclose_elementor_templates');
$contentl  = electron_settings('popup_siteclose_content_left');
$contentr  = electron_settings('popup_siteclose_content_right');
$rightType = electron_settings('popup_siteclose_content_right_type');
$products  = electron_settings('popup_siteclose_products');
$heading   = electron_settings('popup_siteclose_products_heading');
$date      = electron_settings('popup_siteclose_expire_date');
$column    = electron_settings('popup_siteclose_column', 'col-2' );
$class     = electron_settings('popup_siteclose_direction', 'left-right' );
$class    .= ' type-'.$type;
$class    .= ' has-'.$column;
$heading   = trim($heading) ? esc_html($heading) : esc_html__('Recommended Products');

if ( $cookkie !== true ) {
    ?>
    <div id="siteclosePopup" class="electron-siteclose-wrapper fadeIn <?php echo esc_attr( $class ); ?>">
        <div id="formPopupOverlay" class="popupform-overlay disableSiteClosePopup"></div>
        <div id="sitecloseInner" class="electron-siteclose-inner zoomIn" data-expires="<?php echo esc_attr( $date ); ?>">
            <span id="sitecloseClose" class="panel-close hint-left disableSiteClosePopup">
                <span class="electron-hint"><?php echo esc_html_e( 'Don\'t show this popup again.', 'electron' ); ?></span>
            </span>
            <?php if ( 'shortcode' == $type && $shortcode ) { ?>
                <div class="site-siteclose-form"><?php echo do_shortcode( $shortcode ); ?></div>
            <?php } elseif ( 'elementor' == $type && $elementor ) { ?>
                <?php echo electron_print_elementor_templates( 'popup_siteclose_elementor_templates', 'site-siteclose-form', false ); ?>
            <?php } else { ?>

                <?php if ( trim($contentl) ) { ?>
                    <div class="content-col content-left"><?php echo do_shortcode( $contentl ); ?></div>
                <?php } ?>

                <?php if ( 'products' == $rightType ) {
                    $products = explode(',',$products);
                    echo '<div class="content-col content-right">';
                        echo '<h6 class="content-heading">'.$heading.'</h6>';
                        echo '<div class="content-products electron-scrollbar">';
                            foreach ( $products as $id ) {
                                if ( $id && is_numeric($id) ) {
                                    $product = wc_get_product($id);
                                    $name    = $product->get_name();
                                    $price   = $product->get_price_html();
                                    $link    = $product->get_permalink();
                                    echo '<a class="product-link electron-loop-product" href="'.$link.'" title="'.$name.'">';
                                        echo get_the_post_thumbnail($id,'thumbnail');
                                        echo '<div class="product-details">';
                                            echo '<span class="product-name">'.$name.'</span>';
                                            echo '<span class="product-price">'.$price.'</span>';
                                        echo '</div>';
                                    echo '</a>';
                                }
                            }
                        echo '</div>';
                    echo '</div>';
                    ?>
                <?php } else { ?>
                    <?php if ( trim($contentr) ) { ?>
                        <div class="content-col content-right electron-scrollbar"><?php echo do_shortcode( $contentr ); ?></div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php
}
