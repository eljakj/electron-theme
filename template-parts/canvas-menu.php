<?php
/*
* canvas menu
*/
$canvas_menu = electron_header_settings( 'canvas_menu_visibility', '' );
$canvas_type = electron_header_settings( 'canvas_menu_content_type', 'menu' );

if ( '1' == $canvas_menu ) {
    ?>
    <div class="electron-canvas-menu type-<?php echo esc_attr( $canvas_type ); ?>">
        <div class="panel-close" data-target=".electron-canvas-menu"></div>
        <div class="canvas-menu-inner">
            <?php if ( 'menu' == $canvas_type && has_nav_menu( 'canvas_menu' ) ) { ?>
                <div class="canvas-menu menu-sliding">
                    <ul class="nav">
                        <?php
                        echo wp_nav_menu(array(
                            'menu'            => '',
                            'theme_location'  => 'canvas_menu',
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => '',
                            'menu_id'         => '',
                            'items_wrap'      => '%3$s',
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'depth'           => 4,
                            'echo'            => true,
                            'fallback_cb'     => 'Electron_Wp_Bootstrap_Navwalker::fallback',
                            'walker'          => new \Electron_Wp_Bootstrap_Navwalker()
                        ));
                        ?>
                    </ul>
                </div>
            <?php } elseif ( 'sidebar' == $canvas_type && is_active_sidebar( 'electron-canvas-sidebar' ) ) { ?>
                <?php dynamic_sidebar( 'electron-canvas-sidebar' ); ?>
            <?php } elseif ( 'html' == $canvas_type && electron_header_settings( 'canvas_menu_html_content', '' ) ) { ?>
                <?php echo electron_header_settings( 'canvas_menu_html_content', '' ); ?>
            <?php } ?>
        </div>
    </div>
    <?php
}
