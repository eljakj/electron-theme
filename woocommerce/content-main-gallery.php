<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
* product page main-gallery
*/

global $product;
$images   = $product->get_gallery_image_ids();
$size     = apply_filters( 'electron_product_thumb_size', 'woocommerce_single' );
$tsize    = electron_settings( 'gallery_thumb_imgsize', '' );
$tperview = electron_settings( 'product_gallery_thumb_perview', '' );
$id       = $product->get_id();

// gallery top first thumbnail
$img  = get_the_post_thumbnail( $id, $size );
$full = get_the_post_thumbnail_url( $id, 'full' );
$turl = get_the_post_thumbnail_url( $id, $tsize );

$layout         = isset($_GET['layout']) ? esc_html($_GET['layout']) : electron_settings( 'single_shop_layout', 'full-width' );
$thumb_position = isset($_GET['thumbs']) ? esc_html($_GET['thumbs']) : electron_settings( 'product_gallery_thumb_position', 'left' );

$iframe_video  = get_post_meta( get_the_ID(), 'electron_product_iframe_video', true );
$popup_video   = get_post_meta( get_the_ID(), 'electron_product_popup_video', true );
$video_type    = isset($_GET['video']) ? esc_html($_GET['video']) : get_post_meta( get_the_ID(), 'electron_product_video_type', true );

$icon          = '<span class="electron-product-popup small-popup"><svg
class="svgExpand electron-svg-icon"
width="512"
height="512"
fill="currentColor"
viewBox="0 0 512 512"
xmlns="http://www.w3.org/2000/svg"><use href="#shopExpand"></use></svg></span>';

$slider_class = 'electron-product-gallery-main-image';

if ( $images || ( $iframe_video && 'gallery' == $video_type ) ) {
    $slider_class = 'electron-product-gallery-main-slider electron-swiper-main electron-swiper-container electron-swiper-theme-style nav-vertical-center';
}

wp_enqueue_style( 'fancybox' );
wp_enqueue_script( 'fancybox' );

$has_video = $iframe_video && 'gallery' == $video_type ? true : false;

$classes  = $images || $has_video ? ' has-thumbs thumbs-'.$thumb_position : '';
$classes .= ' '.$layout;

?>
<div class="electron-swiper-slider-wrapper<?php echo esc_attr( $classes ); ?>">

    <?php if ( ( $images || $has_video ) && $thumb_position == 'top' ) { ?>
        <?php if ( count($images) > 5 && '1' == electron_settings( 'product_gallery_thumb_nav', '1' ) ) { ?>
            <div class="electron-product-thumbnails-wrapper">
                <div class="electron-product-thumbnails electron-swiper-thumbnails electron-swiper-container" data-perview="<?php echo esc_attr( $tperview ); ?>">
                    <div class="electron-swiper-wrapper"></div>
                </div>
                <div class="electron-product-thumbnails-navs">
                    <div class="electron-swiper-prev electron-swiper-btn electron-nav-bg"></div>
                    <div class="electron-swiper-next electron-swiper-btn electron-nav-bg"></div>
                </div>
            </div>
        <?php } else { ?>
            <div class="electron-product-thumbnails electron-swiper-thumbnails electron-swiper-container" data-perview="<?php echo esc_attr( $tperview ); ?>">
                <div class="electron-swiper-wrapper"></div>
            </div>
        <?php }?>
    <?php } ?>

    <div class="<?php echo esc_attr( $slider_class ); ?>">
        <?php
        if ( $popup_video && 'popup' == $video_type ) {
            echo '<a data-fancybox="iframe" href="'.$popup_video.'" class="electron-product-video-button"><i class="nt-icon-button-play-2"></i></a>';
        }
        ?>
        <div class="electron-swiper-wrapper electron-gallery-items">
            <?php
            $data_thumb = 'thumb' == $tsize ? ' data-thumb="'.$turl.'"' : '';
            echo '<div class="swiper-slide electron-swiper-slide-first" data-src="'.$full.'"'.$data_thumb.' data-fancybox="gallery">'.$img.$icon.'</div>';
            foreach ( $images as $image ) {
                $gurl  = wp_get_attachment_image_url( $image, 'full' );
                $gturl = wp_get_attachment_image_url( $image, $tsize );
                $gimg  = wp_get_attachment_image( $image, $size,false, [ 'data-zoom'=> $gurl ] );
                $data_thumb = 'thumb' == $tsize ? ' data-thumb="'.$gturl.'"' : '';
                echo '<div class="swiper-slide" data-src="'.$gurl.'"'.$data_thumb.' data-fancybox="gallery">'.$gimg.$icon.'</div>';
            }

            if ( $iframe_video && 'gallery' == $video_type ) {
                $iframe_html = '<iframe class="lazy" loading="lazy" data-src="https://www.youtube.com/embed/'.$iframe_video.'?playlist='.$iframe_video.'&modestbranding=1&rel=0&controls=0&autoplay=1&enablejsapi=1&showinfo=0&mute=1&loop=1&start=5&end=25" allow="autoplay; fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowfullscreen></iframe>';
                echo '<div class="swiper-slide swiper-slide-video-item iframe-video"><div class="electron-slide-iframe-wrapper" data-type="iframe" data-src="'.esc_url( $popup_video ).'" data-fancybox="gallery">'.$icon.$iframe_html.'</div></div>';
            }
            ?>
        </div>

        <?php if ( $images || $has_video ) { ?>
            <div class="electron-swiper-prev electron-swiper-btn electron-nav-bg"></div>
            <div class="electron-swiper-next electron-swiper-btn electron-nav-bg"></div>
        <?php } ?>

        <?php do_action( 'electron_product_360_view' ); ?>

    </div>

    <?php if ( ( $images || $has_video ) && $thumb_position != 'top' ) { ?>
        <?php if ( count($images) > 5 && '1' == electron_settings( 'product_gallery_thumb_nav', '1' ) ) { ?>
            <div class="electron-product-thumbnails-wrapper">
                <div class="electron-product-thumbnails electron-swiper-thumbnails electron-swiper-container" data-perview="<?php echo esc_attr( $tperview ); ?>">
                    <div class="electron-swiper-wrapper"></div>
                </div>
                <div class="electron-product-thumbnails-navs">
                    <div class="electron-swiper-prev electron-swiper-btn electron-nav-bg"></div>
                    <div class="electron-swiper-next electron-swiper-btn electron-nav-bg"></div>
                </div>
            </div>
        <?php } else { ?>
            <div class="electron-product-thumbnails electron-swiper-thumbnails electron-swiper-container" data-perview="<?php echo esc_attr( $tperview ); ?>">
                <div class="electron-swiper-wrapper"></div>
            </div>
        <?php }?>
    <?php } ?>

</div>
<div class="zoom"></div>
