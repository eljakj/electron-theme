<?php
/*
* Theme Header Promotion
*/
$cookkie   = isset($_COOKIE['promotionClosed']) ? true : false;
$promotion = electron_header_settings( 'header_promotion_visibility', '0' );
$text      = electron_header_settings( 'header_promotion_text', '0' );
$mobile    = electron_header_settings( 'header_promotion_mobile_visibility', '1' );
$class     = $mobile == '0' ? ' mobile-hidden' : '';

if ( '1' == $promotion && $text && $cookkie !== true ) {
    ?>
    <div id="promotionBar" class="electron-promotion-bar<?php echo esc_attr( $class ); ?>">
        <div class="inner">
            <span id="promotionClose" class="panel-close"></span>
            <?php echo electron_header_settings( 'header_promotion_text', '0' ); ?>
        </div>
    </div>
    <?php
}
