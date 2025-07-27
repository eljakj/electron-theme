<?php
/*
* Header top template layout
*/
$bars_icon = '';
?>

<header class="electron-header header-def bg-light style-1" data-breakpoint="992">
    <div class="electron-header-middle electron-header-part hidden-mobile">
        <div class="electron-header-inner">
            <div class="header-col col-left"><?php get_template_part( 'template-parts/logo' ); ?></div>
            <div class="header-col col-center">
                <div class="header-mainmenu type-menu">
                    <ul class="nav">
                        <?php
                        echo wp_nav_menu(
                            array(
                                'menu'            => '',
                                'theme_location'  => 'header_menu',
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
                                'mobile'          => false,
                                'fallback_cb'     => 'Electron_Wp_Bootstrap_Navwalker::fallback',
                                'walker'          => new \Electron_Wp_Bootstrap_Navwalker()
                            )
                        );
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="electron-header-mobile electron-header-part bg-light">
        <div class="electron-header-inner">
            <div class="header-col col-left">
                <div class="mobile-trigger panel-open" data-target=".electron-mobile-menu">
                    <svg class="menuBars electron-svg-icon" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><use href="#menuBars"></use></svg>
                </div>
                <div class="header-col col-left"><?php get_template_part( 'template-parts/logo' ); ?></div>
            </div>
        </div>
    </div>
    <div class="electron-header-mobile-fixed"></div>
    <div class="electron-mobile-menu has-tab">
        <div class="panel-close" data-target=".electron-mobile-menu"></div>
        <div class="mobile-menu-inner electron-scrollbar">
            <div class="mobile-menu menu-active"></div>
        </div>
    </div>
</header>


<?php
/*
if ( '' != electron_header_settings( 'header_visibility', '1' ) ) {

    wp_enqueue_style( 'header-top');

    $style      = electron_header_settings( 'header_default_style', 'style-1' );
    $style      = isset($_GET['header_style']) ? esc_html($_GET['header_style']) : $style;
    $breakpoint = electron_header_settings( 'mobile_breakpoint', '992' );
    $is_mobile  = wp_is_mobile();

    $html = '';


    /*
    * Header mobile template layout
    */
    /*
    $mheader_class = 'search-'.electron_header_settings( 'header_mobile_search_position', '' );
    $msearch       = electron_header_settings( 'header_mobile_search_visibility', '' );

    $html .= '<div class="electron-header-mobile electron-header-part bg-light '.$mheader_class.'">';
        $html .= '<div class="electron-header-inner">';
            $html .= electron_header_layout('mobile','left');
            $html .= electron_header_layout('mobile','center');
            $html .= electron_header_layout('mobile','right');
        $html .= '</div>';
        if ( '1' == $msearch && shortcode_exists( 'electron_wc_ajax_product_search' ) ) {
            $middle = check_header_disabled_items('header_layout_middle','search-form');
            $bottom = check_header_disabled_items('header_layout_bottom','search-form');
            if ( $middle && $bottom ) {
                $html .= '<div class="electron-mobile-header-search">'.do_shortcode('[electron_wc_ajax_product_search cats="hide"]').'</div>';
            } else {
                $html .= '<div class="electron-mobile-header-search search-form-found"></div>';
            }
        }
    $html .= '</div>';
    $html .= '<div class="electron-header-mobile-fixed"></div>';

    $html .= '<div class="electron-mobile-menu has-tab">';
        $html .= '<div class="panel-close" data-target=".electron-mobile-menu"></div>';
        $html .= '<div class="mobile-menu-tabs">';
            $html .= '<div class="mobile-menu-tab" data-target="mobile-category-menu">Categories</div>';
            $html .= '<div class="mobile-menu-tab" data-target="mobile-menu">Menu</div>';
        $html .= '</div>';
        $html .= '<div class="mobile-menu-inner electron-scrollbar">';

            $html .= '<div class="mobile-category-menu menu-active">';
                $html .= electron_wc_cats_menu(false,true);
            $html .= '</div>';

            $html .= '<div class="mobile-menu"></div>';

        $html .= '</div>';
    $html .= '</div>';
    // final output
    echo '<header class="electron-header bg-light '.$style.'" data-breakpoint="'.esc_attr($breakpoint).'">'.$html.'</header>';
}
*/
