<?php
/**
* Related Products
*
* This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see         https://docs.woocommerce.com/document/template-structure/
* @package     WooCommerce\Templates
* @version     9.6.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( '1' != electron_settings('product_ralated_visibility', '1') ) {
    return;
}

$heading   = electron_settings('product_related_title', '');
$heading   = $heading ? esc_html( $heading ) : apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Viewers Also Liked', 'electron' ) );
$tag       = electron_settings( 'product_related_title_tag', 'h4' );
$perview   = electron_settings( 'product_related_perview', 4 );
$mdperview = electron_settings( 'product_related_mdperview', 3 );
$smperview = electron_settings( 'product_related_smperview', 2 );
$sattr     = array();
$sattr[]  .= '"speed":'.electron_settings( 'product_related_speed', 1000 );
$sattr[]  .= '"slidesPerView":1,"slidesPerGroup":1';
$sattr[]  .= '"spaceBetween":'.electron_settings( 'product_related_gap', 30 );
$sattr[]  .= '"wrapperClass": "electron-swiper-wrapper"';
$sattr[]  .= '"autoHeight": true';
$sattr[]  .= '1' == electron_settings( 'product_related_loop', 0 ) ? '"loop":true' : '"loop":false';
$sattr[]  .= '1' == electron_settings( 'product_related_autoplay', 1 ) ? '"autoplay":{"pauseOnMouseEnter":true,"disableOnInteraction":false}' : '"autoplay":false';
$sattr[]  .= '1' == electron_settings( 'product_related_mousewheel', 0 ) ? '"mousewheel":true' : '"mousewheel":false';
$sattr[]  .= '1' == electron_settings( 'product_related_freemode', 1 ) ? '"freeMode":true' : '"freeMode":false';
$sattr[]  .= '"navigation": {"nextEl": ".related-slider-nav .electron-swiper-next","prevEl": ".related-slider-nav .electron-swiper-prev"}';
$sattr[]  .= '"breakpoints": {"0": {"slidesPerView": '.$smperview.',"slidesPerGroup":'.$smperview.'},"768": {"slidesPerView": '.$mdperview.',"slidesPerGroup":'.$mdperview.'},"1024": {"slidesPerView": '.$perview.',"slidesPerGroup":'.$perview.'}}';

if ( $related_products ) {
    ?>
    <div class="electron-product-related electron-related-product-wrapper electron-section">
        <div class="section-title-wrapper">
            <?php if ( $heading ) : ?>
                <<?php echo esc_attr( $tag ); ?> class="section-title"><?php echo esc_html( $heading ); ?></<?php echo esc_attr( $tag ); ?>>
            <?php endif; ?>
            <div class="related-slider-nav">
                <div class="electron-slide-nav electron-swiper-prev"></div>
                <div class="electron-slide-nav electron-swiper-next"></div>
            </div>
        </div>
        <div class="electron-wc-swipper-wrapper woocommerce">
            <div class="electron-swiper-slider electron-swiper-container" data-swiper-options='{<?php echo implode( ',',$sattr ); ?>}'>
                <div class="electron-swiper-wrapper">
                    <?php foreach ( $related_products as $related_product ) : ?>
                        <div class="swiper-slide">
                            <?php
                            $post_object = get_post( $related_product->get_id() );
                            setup_postdata( $GLOBALS['post'] = $post_object );
                            wc_get_template_part( 'content', 'product' );
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
wp_reset_postdata();
