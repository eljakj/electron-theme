<?php
/*
* type list
*/
global $product;

$pid     = $product->get_id();
$price   = $product->get_price_html();
$name    = $product->get_name();
$link    = $product->get_permalink();
$type    = $product->get_type();
$review  = $product->get_review_count();
$count   = $product->get_rating_count();
$rating  = $product->get_average_rating();
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
$fatures       = electron_settings( 'shop_product_fatures', '1' );
$sku           = electron_settings( 'shop_product_sku', '0' );
$fatures_mob   = electron_settings( 'product_extra_fatures_mobile', '1' );
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
$class .= '1' == $fatures && '1' == $fatures_mob ? ' fatures-mobile' : '';
$class .= '1' == $quick_view || '1' == $compare || '1' == $wishlist ? ' has-actions' : '';
$cartbtn = true;

if ( 'shop' == $show_qty && is_shop() ) {
    $cartbtn = false;
    $class .= ' has-qty has-pb';
} elseif ( 'catpage' == $show_qty && is_product_category() ) {
    $cartbtn = false;
    $class .= ' has-qty has-pb';
} elseif ( 'all' == $show_qty ) {
    $cartbtn = false;
    $class .= ' has-qty has-pb';
} elseif ( 'none' == $show_qty ) {
    $cartbtn = true;
}

$html .= '<div class="thumb-wrapper">';
    $html .= woocommerce_get_product_thumbnail();
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
    $html .= $dots ? '<div class="thumbs">'.$fdots.$dots.'</div>' : '';
$html .= '</div>';

$html .= '<div class="details-wrapper">';
    $html .= '<h6 class="product-name"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></h6>';
    if ( '1' != $disable_price ) {
        $html .= '<span class="product-price">'.$price.'</span>';
    }
    if ( '1' == $ot_stock || '1' == $ot_rating ) {
        $html .= '<div class="stock-rating">';
            if ( '1' == $ot_stock ) {
                $html .= electron_loop_product_stock_status();
            }
            if ( '1' == $ot_rating2 ) {
                $html .= electron_star_rating_html( 1, $rating, $count );
            }
        $html .= '</div>';
    }
    if ( '1' == $sku ) {
        $html .= electron_product_sku(false);
    }
    if ( '1' == $fatures ) {
        $html .= electron_product_extra_fetaures(false);
    }
    if ( has_excerpt() ) {
        $limit = electron_settings('shop_loop_excerpt_limit');
        $html .= '<p class="product-desc">'.wp_trim_words( get_the_excerpt(), $limit ).'</p>';
    }
    if ( $is_swatches && $cartbtn ) {
        $html .= '<div class="electron-swatches-wrapper">';
            if ( '1' != $disable_price ) {
                $html .= '<span class="product-price price">'.$price.'</span>';
            }
            $html .= do_shortcode( '[electron_swatches]' );
        $html .= '</div>';
    }
$html .= '</div>';

if ( '1' != $catalog_mode ) {
    $html .= '<div class="cart-actions">';
        if ( '1' == $quick_view || '1' == $compare || '1' == $wishlist ) {
            $html .= '<div class="product-buttons">';
                if ( '1' == $wishlist ) {
                    $html .= electron_wishlist_button($pid,$name);
                }
                if ( '1' == $compare ) {
                    $html .= electron_compare_button($pid,$name);
                }
                if ( '1' == $quick_view ) {
                    $html .= electron_quickview_button($pid);
                }
            $html .= '</div>';
        }

        if ( 'none' != $show_qty ) {
            ob_start();
            electron_loop_product_cart_quantity($type);
            $cartqty = ob_get_clean();
            if ( 'shop' == $show_qty && is_shop() ) {
                $html .= '<div class="product-cart-wrapper">'.$cartqty.'</div>';
            } elseif ( 'catpage' == $show_qty && is_product_category() ) {
                $html .= '<div class="product-cart-wrapper">'.$cartqty.'</div>';
            } elseif ( 'all' == $show_qty ) {
                $html .= '<div class="product-cart-wrapper">'.$cartqty.'</div>';
            } else {
                $html .= '<div class="cart-wrapper">'.electron_add_to_cart('button').'</div>';
            }
        } else {
            $html .= '<div class="cart-wrapper">'.electron_add_to_cart('button').'</div>';
        }

    $html .= '</div>';
}

echo '<div class="list-inner product-inner'.$class.'" data-id="'.$pid.'">'.$html.'</div>';
