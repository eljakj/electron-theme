<div id="nt-sidebar" class="nt-sidebarrr col-xl-3 col-lg-4 col-md-6 col-sm-8 order-2 order-lg-0" role="complementary">
    <div class="blog-sidebar nt-sidebar-inner">
        <?php
        if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_appearance', 'off' ) === 'off' ) {

            do_action( 'dokan_sidebar_store_before', $store_user->data, $store_info );

            if ( !dynamic_sidebar( 'sidebar-store' ) ) {
                $args = [
                    'before_widget' => '<div class="nt-sidebar-inner-widget shop-widget mb-30 woocommerce %s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="shop-widget-title"><h6 class="nt-sidebar-inner-widget-title title">',
                    'after_title'   => '</h6></div>',
                ];

                if ( dokan()->widgets->is_exists( 'store_category_menu' ) ) {
                    the_widget( dokan()->widgets->store_category_menu, array( 'title' => esc_html__( 'Store Product Category', 'electron' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_location' ) && dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on' && ! empty( $map_location ) ) {
                    the_widget( dokan()->widgets->store_location, array( 'title' => esc_html__( 'Store Location', 'electron' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_open_close' ) && dokan_get_option( 'store_open_close', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_open_close, array( 'title' => esc_html__( 'Store Time', 'electron' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_contact_form' ) && dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_contact_form, array( 'title' => esc_html__( 'Contact Vendor', 'electron' ) ), $args );
                }

            }

            do_action( 'dokan_sidebar_store_after', $store_user->data, $store_info );

        } else {

            get_sidebar( 'store' );
        }
        ?>

    </div>
</div><!-- #secondary .widget-area -->
