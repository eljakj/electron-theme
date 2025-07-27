<?php
/*
* type 1
*/

global $product;

$catalog_mode = electron_settings( 'woo_catalog_mode', '0' );
$disable_price = '1' == $catalog_mode ? electron_settings( 'woo_disable_price', '0' ) : 0;
$pid     = $product->get_id();
$price   = $product->get_price_html();
$name    = $product->get_name();
$link    = $product->get_permalink();
$type    = $product->get_type();
$upsells = $product->get_upsell_ids();
$dots    = '';
$fdots   = '';

if ( '1' == electron_settings( 'shop_product_thumbs_imgs', '0' ) ) {
    $turl = get_the_post_thumbnail_url($pid,'woocommerce_thumbnail');
    $imgs = $product->get_gallery_image_ids();
    $fdots = '<span class="dot active" data-url="'.$turl.'"></span>';
    foreach ( $imgs as $img ) {
        $url = wp_get_attachment_image_url( $img, 'woocommerce_thumbnail' );
        $dots .= $url ? '<span class="dot" data-url="'.$url.'"></span>' : '';
    }
}
$class  = $dots ? ' has-thumbs' : '';
$class .= !empty($upsells) && is_array($upsells) ? ' has-upsell' : '';

$html = '<div class="thumb-wrapper">';
    $html .= '<a href="'.$link.'" class="product-thumb" title="'.$name.'">';
    $html .= woocommerce_get_product_thumbnail();
    $html .= '</a>';
    $html .= '<div class="product-actions hint-top">';
        $html .= electron_wishlist_button($pid,$name);
        $html .= electron_compare_button($pid,$name);
        $html .= electron_quickview_button($pid);
    $html .= '</div>';
$html .= '</div>';

$html .= '<div class="product-labels">';
    $html .= electron_product_badge(false);
    $html .= electron_product_discount(false);
$html .= '</div>';

$html .= '<div class="details-wrapper">';
    $html .= $dots ? '<div class="thumbs">'.$fdots.$dots.'</div>' : '';
    $html .= '<div class="details-inner">';
        $html .= '<h6 class="product-name"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></h6>';
        if ( '1' != $disable_price ) {
            $html .= '<span class="product-price">'.$price.'</span>';
        }
    $html .= '</div>';
$html .= '</div>';

if ( '1' != $catalog_mode ) {
    $html .= '<div class="product-cart-wrapper">'.electron_add_to_cart('button').'</div>';
}
?>
<div <?php wc_product_class( 'electron-loop-product type-1', $product ); ?>>
    <?php echo '<div class="product-inner'.$class.'" data-id="'.$pid.'">'.$html.'</div>';?>
</div>
