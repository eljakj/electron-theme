<?php
/*
* Theme Preloader
*/

if ( '0' != electron_settings('preloader_visibility', '1') ) {
    $type = electron_settings('pre_type', 'default');
    if ( 'default' == $type && '' != electron_settings( 'pre_img', '' ) ) {
        $img = electron_settings( 'pre_img' )[ 'url' ];
        ?>
        <div class="preloader">
            <img class="preloader__image" width="55" src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
        </div>
        <?php
    } else {
        ?>
        <div id="nt-preloader" class="preloader">
            <div class="loader<?php echo esc_attr( $type );?>"></div>
        </div>
        <?php
    }
}
