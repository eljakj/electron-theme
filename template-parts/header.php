<?php
/*
* Header top template layout
*/

if ( '0' != electron_header_settings( 'header_visibility', '1' ) ) {
	if ( 'elementor' == electron_header_settings( 'header_template', 'default' ) ) {
		$ID = electron_header_settings( 'header_elementor_templates' );
		$ID = apply_filters( 'electron_translated_template_id', $ID );
		$headerTemp = new WP_Query( array('p' => $ID, 'post_type' => 'elementor_library') );
		if ( $headerTemp->have_posts() ) {
			while ( $headerTemp->have_posts() ) {
				$headerTemp->the_post();
				the_content();
			}
		}
		wp_reset_postdata();
	} else {

		wp_enqueue_style( 'header-top');

		$style      = electron_header_settings( 'header_default_style', 'style-1' );
		$style      = isset($_GET['header_style']) ? esc_html($_GET['header_style']) : $style;
		$breakpoint = electron_header_settings( 'mobile_breakpoint', '992' );
		$is_mobile  = wp_is_mobile();
		$mob_hidden = '0' == electron_header_settings( 'header_top_mobile_visibility', '1' ) ? ' hidden-mobile' : '';

		$html = '';

		if ( '1' == electron_header_settings( 'header_top_visibility', '1' ) ) {
			$html .= '<div class="electron-header-top electron-header-part'.$mob_hidden.'">';
				$html .= '<div class="electron-header-inner">';
					$html .= electron_header_layout('top','left');
					$html .= electron_header_layout('top','center');
					$html .= electron_header_layout('top','right');
				$html .= '</div>';
			$html .= '</div>';
		}

		/*
		* Header middle template layout
		*/

		if ( '1' == electron_header_settings( 'header_middle_visibility', '1' ) ) {

			$html .= '<div class="electron-header-middle electron-header-part hidden-mobile">';
				$html .= '<div class="electron-header-inner">';
					$html .= electron_header_layout('middle','left');
					$html .= electron_header_layout('middle','center');
					$html .= electron_header_layout('middle','right');
				$html .= '</div>';
			$html .= '</div>';

		}

		/*
		* Header bottom template layout
		*/

		if ( '1' == electron_header_settings( 'header_bottom_visibility', '1' ) ) {

			$html .= '<div class="electron-header-bottom electron-header-part hidden-mobile">';
				$html .= '<div class="electron-header-inner">';
					$html .= electron_header_layout('bottom','left');
					$html .= electron_header_layout('bottom','center');
					$html .= electron_header_layout('bottom','right');
				$html .= '</div>';
			$html .= '</div>';

		}

		/*
		* Header sticky template layout
		*/

		if ( '1' == electron_header_settings( 'header_sticky_visibility', '1' ) ) {

			$html .= '<div class="electron-header-sticky electron-header-part sticky hidden-mobile bg-light">';
				$html .= '<div class="electron-header-inner">';
					$html .= electron_header_layout('sticky','left');
					$html .= electron_header_layout('sticky','center');
					$html .= electron_header_layout('sticky','right');
				$html .= '</div>';
			$html .= '</div>';

		}
		/*
		* Header mobile template layout
		*/
        $msearch  = electron_header_settings( 'header_mobile_search_visibility', '' );
		$msticky  = electron_header_settings( 'header_mobile_sticky', '0' );
		$mhclass  = 'search-'.electron_header_settings( 'header_mobile_search_position', '' );
		$mhclass .= '0' == $msticky ? ' sticky-none' : '';

		$html .= '<div class="electron-header-mobile electron-header-part bg-light '.$mhclass.'">';
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
		$html .= '1' == $msticky ? '<div class="electron-header-mobile-fixed"></div>' : '';
        $mobile_type = electron_header_settings( 'header_mobile_menu_type' );
        $menu_temp   = electron_header_settings( 'header_mobile_menu_template' );
        $tab_reverse = electron_header_settings( 'header_mobile_menu_tab_reverse' );
        $el_id       = electron_header_settings( 'header_mobile_menu_elementor_templates' );
        $socials     = electron_header_settings( 'header_mobile_menu_socials' );
        $socials_html= electron_header_settings( 'header_mobile_menu_socials_html' );
        $socials_pos = electron_header_settings( 'header_mobile_menu_socials_position' );

        $tab_reversed = '1' == $tab_reverse ? ' tab-reverse' : '';
        $tab_active   = '0' == $tab_reverse ? ' active' : '';
        $tab_active2  = '1' == $tab_reverse ? ' active' : '';
        $menu_active  = '0' == $tab_reverse ? ' menu-active' : '';
        $menu_active2 = '1' == $tab_reverse ? ' menu-active' : '';
        $custom_menu  = 'custom' == $menu_temp ? ' custom-menu' : '';
        $menu = '';

        if ( 'custom' == $menu_temp ) {
            $menu .= '<ul class="nav">';
            $menu .= wp_nav_menu(array(
                'menu'            => '',
                'theme_location'  => 'custom_mobile_menu',
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
                'echo'            => false,
                'mobile'          => false,
                'fallback_cb'     => 'Electron_Wp_Bootstrap_Navwalker::fallback',
                'walker'          => new \Electron_Wp_Bootstrap_Navwalker()
            ));
            $menu .= '</ul>';
        }

        if ( 'menu' == $mobile_type || 'cats' == $mobile_type ) {

            $html .= '<div class="electron-mobile-menu no-tab">';
                $html .= '<div class="panel-close" data-target=".electron-mobile-menu"></div>';
                $html .= '<div class="mobile-menu-inner electron-scrollbar">';
                    if ( 'menu' == $mobile_type ) {
                        $html .= '<div class="mobile-menu menu-active'.$custom_menu.'">'.$menu.'</div>';
                    } else {
                        $html .= '<div class="mobile-category-menu menu-active">'.electron_wc_cats_menu(false,true).'</div>';
                    }
                $html .= '</div>';
                if ( '1' == $socials ) {
                    $html .= '<div class="mobile-social-menu electron-product-share '.$socials_pos.'">'.$socials_html.'</div>';
                }
            $html .= '</div>';

        } elseif ( 'elementor' == $mobile_type ) {

            $html .= '<div class="electron-mobile-menu no-tab">';
                $html .= '<div class="panel-close" data-target=".electron-mobile-menu"></div>';
                $html .= '<div class="mobile-menu-inner has-el-template electron-scrollbar">';
                    $html .= electron_print_elementor_templates( $el_id );
                $html .= '</div>';
            $html .= '</div>';

        } else {

            $html .= '<div class="electron-mobile-menu has-tab">';
                $html .= '<div class="panel-close" data-target=".electron-mobile-menu"></div>';
                $html .= '<div class="mobile-menu-tabs'.$tab_reversed.'">';
                    $html .= '<div class="mobile-menu-tab'.$tab_active.'" data-target="mobile-menu">'.esc_html__('Menu','electron').'</div>';
                    $html .= '<div class="mobile-menu-tab'.$tab_active2.'" data-target="mobile-category-menu">'.esc_html__('Categories','electron').'</div>';
                $html .= '</div>';
                $html .= '<div class="mobile-menu-inner electron-scrollbar">';
                    $html .= '<div class="mobile-menu'.$menu_active.$custom_menu.'">'.$menu.'</div>';
                    $html .= '<div class="mobile-category-menu'.$menu_active2.'">'.electron_wc_cats_menu(false,true).'</div>';
                $html .= '</div>';
                if ( '1' == $socials ) {
                    $html .= '<div class="mobile-social-menu electron-product-share '.$socials_pos.'">'.$socials_html.'</div>';
                }
            $html .= '</div>';
        }
        // final output
        echo '<header class="electron-header bg-light '.$style.'" data-breakpoint="'.esc_attr($breakpoint).'">'.$html.'</header>';
    }
}
