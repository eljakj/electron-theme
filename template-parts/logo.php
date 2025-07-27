<?php
/*
* Theme Logo Template
*/

$type   = electron_settings( 'logo_type', 'sitename' );;
$logo   = '' != electron_settings( 'img_logo' ) ? electron_settings( 'img_logo' )[ 'id' ] : '';
$mlogo  = '' != electron_settings( 'mobile_logo' ) ? electron_settings( 'mobile_logo' )[ 'id' ] : '';
$logo   = wp_is_mobile() && $mlogo ? $mlogo : $logo;
$slogo  = '' != electron_settings( 'sticky_logo' ) ? electron_settings( 'sticky_logo' )[ 'id' ] : '';
$class  = 'nav-logo logo-type-'.$type;
$class .= '' != $slogo ? ' has-sticky-logo': '';

if ( '0' != electron_settings( 'logo_visibility', '1' ) ) { ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="logo image">
            <?php
            if ( 'img' == $type && '' != $logo ) {
                echo wp_get_attachment_image($logo, 'full', false, ['class' => 'main-logo','alt' => esc_attr( get_bloginfo( 'name' ) )]);
                if ( '' != $slogo ) {
                    echo wp_get_attachment_image($slogo, 'full', false, ['class' => 'main-logo sticky-logo','alt' => esc_attr( get_bloginfo( 'name' ) )]);
                }
            } elseif ( 'sitename' == $type ) {
                echo '<span class="header-text-logo">'.esc_html( get_bloginfo( 'name' ) ).'</span>';
            } elseif ( 'customtext' == $type ) {
                echo '<span class="header-text-logo">'.electron_settings( 'text_logo' ).'</span>';
            } else {
                echo '<span class="header-text-logo">'.esc_html( get_bloginfo( 'name' ) ).'</span>';
            }
            ?>
        </a>
    </div>
    <?php
}
