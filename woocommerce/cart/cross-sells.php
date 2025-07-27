<?php
/**
* Cross-sells
*
* This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 9.6.0
*/

defined( 'ABSPATH' ) || exit;

if ( $cross_sells ) {
    $heading   = electron_settings( 'shop_cross_sells_title', '' );
    $heading   = $heading ? esc_html( $heading ) : apply_filters( 'woocommerce_product_cross_sells_products_heading', esc_html__( 'You may be interested in&hellip;', 'electron' ) );
    $type      = electron_settings( 'shop_cross_sells_type', 'slider' );
    $tag       = electron_settings( 'shop_cross_sells_title_tag', 'h5' );
    $perview   = electron_settings( 'shop_cross_sells_perview', 5 );
    $mdperview = electron_settings( 'shop_cross_sells_mdperview', 3 );
    $smperview = electron_settings( 'shop_cross_sells_smperview', 2 );
    $sattr     = array();
    $sattr[]  .= '"speed":'.electron_settings( 'shop_cross_sells_speed', 1000 );
    $sattr[]  .= '"slidesPerView":1,"slidesPerGroup":1';
    $sattr[]  .= '"spaceBetween":'.electron_settings( 'shop_cross_sells_gap', 30 );
    $sattr[]  .= '"wrapperClass": "electron-swiper-wrapper"';
    $sattr[]  .= '"autoHeight": true';
    $sattr[]  .= '1' == electron_settings( 'shop_cross_sells_loop', 0 ) ? '"loop":true' : '"loop":false';
    $sattr[]  .= '1' == electron_settings( 'shop_cross_sells_autoplay', 1 ) ? '"autoplay":{"pauseOnMouseEnter":true,"disableOnInteraction":false}' : '"autoplay":false';
    $sattr[]  .= '1' == electron_settings( 'shop_cross_sells_mousewheel', 0 ) ? '"mousewheel":true' : '"mousewheel":false';
    $sattr[]  .= '1' == electron_settings( 'shop_cross_sells_freemode', 1 ) ? '  "freeMode":true' : '"freeMode":false';
    $sattr[]  .= '"navigation": {"nextEl": ".cross-sells-slider-nav .electron-swiper-next","prevEl": ".cross-sells-slider-nav .electron-swiper-prev"}';
    $sattr[]  .= '"breakpoints": {"0": {"slidesPerView": '.$smperview.',"slidesPerGroup":'.$smperview.'},"768": {"slidesPerView": '.$mdperview.',"slidesPerGroup":'.$mdperview.'},"1024": {"slidesPerView": '.$perview.',"slidesPerGroup":'.$perview.'}}';

    if ( 'slider' == $type ) {
        ?>
        <div class="cross-sells electron-section">
            <div class="section-title-wrapper">
                <?php if ( $heading ) : ?>
                    <<?php echo esc_attr( $tag ); ?> class="section-title"><?php echo esc_html( $heading ); ?></<?php echo esc_attr( $tag ); ?>>
                <?php endif; ?>
                <div class="cross-sells-slider-nav">
                    <div class="electron-slide-nav electron-swiper-prev"></div>
                    <div class="electron-slide-nav electron-swiper-next"></div>
                </div>
            </div>
            <div class="electron-wc-swipper-wrapper woocommerce">
                <div class="electron-swiper-slider electron-swiper-container" data-swiper-options='{<?php echo implode( ',',$sattr ); ?>}'>
                    <div class="electron-swiper-wrapper">
                        <?php foreach ( $cross_sells as $cross_sell ) : ?>
                            <div class="swiper-slide">
                                <?php
                                    $post_object = get_post( $cross_sell->get_id() );
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
    } else {
        ?>
        <div class="cross-sells electron-section">
            <?php
            if ( $heading ) {
                ?>
                <div class="section-title-wrapper"><<?php echo esc_attr( $tag ); ?> class="section-title"><?php echo esc_html( $heading ); ?></<?php echo esc_attr( $tag ); ?>></div>
                <?php
            }
            echo '<div class="electron-products products">';
                foreach ( $cross_sells as $cross_sell ) {
                    $post_object = get_post( $cross_sell->get_id() );
                    setup_postdata( $GLOBALS['post'] = $post_object );
                    wc_get_template_part( 'content', 'product' );
                }
            echo '</div>';
            ?>
        </div>
        <?php
    }
}
wp_reset_postdata();
