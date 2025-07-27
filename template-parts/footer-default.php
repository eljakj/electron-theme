<?php

/**
* Custom template parts for this theme.
*
* Eventually, some of the functionality here could be replaced by core features.
*
* @package electron
*/

?>
<footer id="nt-footer" class="electron-footer-area electron-default-copyright">
    <div class="container">
        <div class="copyright-text">
            <?php
            if ( '' != electron_settings( 'footer_copyright' ) ) {

                echo electron_settings( 'footer_copyright' );

            } else {
                echo sprintf( '<p>Copyright &copy; %1$s, <a class="theme" href="%2$s">%3$s</a> Website. %4$s <a class="dev" href="https://ninetheme.com/contact/"> %5$s</a></p>',
                    date_i18n( _x( 'Y', 'copyright date format', 'electron' ) ),
                    esc_url( home_url( '/' ) ),
                    get_bloginfo( 'name' ),
                    esc_html__( 'Made with passion by', 'electron' ),
                    esc_html__( 'Ninetheme.', 'electron' )
                );
            }
            ?>
        </div>
    </div>
</footer>
