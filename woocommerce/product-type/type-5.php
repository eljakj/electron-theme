<?php
/*
* type 4
*/
global $product;

$pid     = $product->get_id();
$price   = $product->get_price_html();
$name    = $product->get_name();
$link    = $product->get_permalink();
$type    = $product->get_type();
$rating  = $product->get_rating_count();
$average = $product->get_average_rating();
$upsells = $product->get_upsell_ids();

$catalog_mode  = electron_settings( 'woo_catalog_mode', '0' );
$show_qty      = electron_settings( 'shop_product_qty', '0' );
$qty_type      = electron_settings( 'shop_product_qty_type' );
$swatches      = electron_settings( 'shop_product_swatches', '1' );
$swatches_mob  = electron_settings( 'shop_product_swatches_mobile', '0' );
$ot_stock      = electron_settings( 'shop_product_stock', '1' );
$ot_rating     = electron_settings( 'shop_product_rating', '1' );
$ot_rating2    = electron_settings( 'shop_product_rating_count', '1' );
$quick_view    = electron_settings( 'shop_product_quick_view', '1' );
$compare       = electron_settings( 'shop_product_compare', '1' );
$wishlist      = electron_settings( 'shop_product_wishlist', '1' );
$label         = electron_settings( 'shop_product_label', '1' );
$discount      = electron_settings( 'shop_product_discount', '1' );
$sku           = electron_settings( 'shop_product_sku', '0' );
$fatures       = electron_settings( 'shop_product_fatures', '1' );
$disable_price = '1' == $catalog_mode ? electron_settings( 'woo_disable_price', '0' ) : 0;
$is_swatches   = '1' == $swatches && '1' != $catalog_mode && $type == 'variable' && shortcode_exists('electron_swatches') ? true : false;

$html = $dots = $fdots = '';

if ( '1' == electron_settings( 'shop_product_thumbs_imgs', '0' ) ) {
    $turl = get_the_post_thumbnail_url($pid,'woocommerce_thumbnail');
    $imgs = $product->get_gallery_image_ids();
    $fdots = '<span class="dot active" data-url="'.$turl.'"></span>';
    foreach ( $imgs as $img ) {
        $url = wp_get_attachment_image_url( $img, 'woocommerce_thumbnail' );
        $dots .= $url ? '<span class="dot" data-url="'.$url.'"></span>' : '';
    }
}

$class  = ' ptype-'.$type;
$class .= $dots ? ' has-thumbs' : '';
$class .= !empty($upsells) && is_array($upsells) ? ' has-upsell' : '';
$class .= $is_swatches && '1' == $swatches_mob ? ' swatches-mobile' : '';
$cartbtn = true;

if ( 'shop' == $show_qty && is_shop() ) {
    $cartbtn = false;
    $class .= ' has-qty has-pb pb-'.$qty_type;
} elseif ( 'catpage' == $show_qty && is_product_category() ) {
    $cartbtn = false;
    $class .= ' has-qty has-pb pb-'.$qty_type;
} elseif ( 'all' == $show_qty ) {
    $cartbtn = false;
    $class .= ' has-qty has-pb pb-'.$qty_type;
} elseif ( 'none' == $show_qty ) {
    $cartbtn = true;
}

$html .= '<div class="thumb-wrapper">';
    $html .= '<a href="'.$link.'" class="product-link" title="'.$name.'">'.woocommerce_get_product_thumbnail().'</a>';

    if ( '1' == $wishlist ) {
        $html .= '<div class="nt-wish-icon">';
           $html .= electron_wishlist_button($pid,$name);
       $html .= '</div>';
    }

    $html .= '<div class="product-actions hint-top">';
        if ( '1' == $compare ) {
            $html .= electron_compare_button($pid,$name);
        }
        if ( '1' == $quick_view ) {
            $html .= electron_quickview_button($pid);
        }
        if ( '1' != $catalog_mode && $cartbtn ) {
            $html .= electron_add_to_cart('icon');
        }
    $html .= '</div>';

$html .= '</div>';

if ( '1' == $label || '1' == $discount ) {
    $html .= '<div class="product-labels">';
        if ( '1' == $label ) {
            $html .= electron_product_badge(false);
        }
        if ( '1' == $discount ) {
            $html .= electron_product_discount(false);
        }
    $html .= '</div>';
}

$html .= '<div class="product-details">';
    $html .= $dots ? '<div class="thumbs">'.$fdots.$dots.'</div>' : '';
    $html .= '<h6 class="product-name"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></h6>';

    if ( '1' != $disable_price ) {
        $html .= '<span class="product-price">'.$price.'</span>';
    }

    if ( '1' == $ot_stock || '1' == $ot_rating ) {
        $html .= '<div class="product-stock-rating">';
            if ( '1' == $ot_stock ) {
                $html .= electron_loop_product_stock_status();
            }
            if ( '1' == $ot_rating ) {
                $html .= wc_get_rating_html( $average, $rating );
            }
        $html .= '</div>';
    }

    if ( '1' == $sku ) {
        $html .= electron_product_sku(false);
    }
    
    if ( '1' != $catalog_mode ) {
        $html .= '<div class="product-footer">';
            if ( '1' == $fatures ) {
                $html .= electron_product_extra_fetaures(false);
            }
            if ( $is_swatches && $cartbtn ) {
                $html .= '<div class="electron-swatches-wrapper">';
                    $html .= do_shortcode( '[electron_swatches]' );
                $html .= '</div>';
            }
        $html .= '</div>';

    }
$html .= '</div>';

if ( '1' != $catalog_mode && 'none' != $show_qty ) {
    ob_start();
    electron_loop_product_cart_quantity($type);
    $cartqty = ob_get_clean();
    if ( 'shop' == $show_qty && is_shop() ) {
        $html .= '<div class="product-cart-wrapper">'.$cartqty.'</div>';
    } elseif ( 'catpage' == $show_qty && is_product_category() ) {
        $html .= '<div class="product-cart-wrapper">'.$cartqty.'</div>';
    } elseif ( 'all' == $show_qty ) {
        $html .= '<div class="product-cart-wrapper">'.$cartqty.'</div>';
    }
}

echo '<div class="product-inner'.$class.'" data-id="'.$pid.'">'.$html.'</div>';
