<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
* product page gallery
*/


global $product;

$column = isset($_GET['column']) ? esc_html($_GET['column']) : electron_settings( 'electron_product_gallery_grid_column', '2' );
$images = $product->get_gallery_image_ids();
$size   = apply_filters( 'electron_product_thumb_size', 'woocommerce_single' );
$id     = $product->get_id();

$iframe_video = get_post_meta( get_the_ID(), 'electron_product_iframe_video', true );
$popup_video  = get_post_meta( get_the_ID(), 'electron_product_popup_video', true );
$video_type   = apply_filters( 'electron_product_video_type', get_post_meta( get_the_ID(), 'electron_product_video_type', true ) );
$lightbox_icon = '<svg
class="svgExpand electron-svg-icon"
width="512"
height="512"
fill="currentColor"
viewBox="0 0 512 512"
xmlns="http://www.w3.org/2000/svg"><use href="#shopExpand"></use></svg>';

switch ( $column ) {
    case '1':
        $tsize = 'woocommerce_single';
        break;
    case '2':
        $tsize = [500,500];
        break;
    case '3':
        $tsize = [300,300];
        break;
    case '4':
        $tsize = [200,200];
        break;
    default:
        $tsize = [400,400];
        break;
}

// gallery top first thumbnail
$img = get_the_post_thumbnail( $product->get_id(), $tsize );
$url = get_the_post_thumbnail_url( $product->get_id(), 'full' );

wp_enqueue_style( 'fancybox' );
wp_enqueue_script( 'fancybox' );

echo '<div class="electron-product-main-gallery-grid grid-column-'.esc_attr( $column ).'">';

    if ( $iframe_video || $popup_video ) {
        if ( 'gallery' == $video_type ) {

            if ( $iframe_video && 'gallery' == $video_type ) {
                $iframe_html = '<iframe class="lazy" loading="lazy" src="https://www.youtube.com/embed/'.$iframe_video.'?playlist='.$iframe_video.'&modestbranding=1&rel=0&controls=0&autoplay=1&enablejsapi=1&showinfo=0&mute=1&loop=1&start=5&end=25" allow="autoplay; fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowfullscreen></iframe>';
                echo '<div class="electron-gallery-grid-item electron-gallery-grid-video-item iframe-video" data-src="'.esc_url( $popup_video ).'" data-fancybox="images"><span class="electron-product-popup small-popup">'.$lightbox_icon.'</span>'.$iframe_html.'</div>';
            }
        } else {
            if ( $popup_video ) {
                echo '<a data-fancybox href="'.$popup_video.'" class="electron-product-video-button"><i class="nt-icon-button-play-2"></i></a>';
            }
        }
    }

    echo '<div class="row row-cols-1 row-cols-sm-'.esc_attr( $column ).'">';
        echo '<div class="electron-gallery-grid-item electron-gallery-grid-item-first first" data-src="'.esc_url( $url ).'" data-fancybox="images"><span class="electron-product-popup small-popup">'.$lightbox_icon.'</span>'.$img.'</div>';
        if ( !empty( $images ) ) {
            foreach ( $images as $image ) {
                $gimg = wp_get_attachment_image( $image, $tsize );
                $gurl = wp_get_attachment_image_url( $image, 'full' );
                echo '<div class="col electron-gallery-grid-item" data-src="'.esc_url( $gurl ).'" data-fancybox="images"><span class="electron-product-popup small-popup">'.$lightbox_icon.'</span>'.$gimg.'</div>';
            }
        }
    echo '</div>';
echo '</div>';