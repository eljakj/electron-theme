<?php
/**
* Electron Admin Page Template
*/


?>

    <div class="electron-admin-wrapper">
        <div class="container">
            <div class="page-heading">
                <h1 class="page-title"><?php _e( 'Electron Addons', 'electron' ); ?></h1>
                <p class="page-description">
                    <?php _e( 'Premium & Advanced Essential Elements for Elementor', 'electron' ); ?>
                </p>
            </div>
            <form class="electron-form" method="post">

                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-widget-tab" data-toggle="tab" href="#nav-widget" role="tab" aria-controls="nav-widget" aria-selected="false"><?php _e( 'Widgets', 'electron' ); ?></a>
                        <a class="nav-item nav-link" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true"><?php _e( 'Extra', 'electron' ); ?></a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-widget" role="tabpanel" aria-labelledby="nav-widget-tab">
                        <div class="row widget-row">
                            <?php

                            $list = array(
                                'header-menu-simple',
                                'menu-vertical',
                                'button',
                                'animated-headline',
                                'swiper-template',
                                'slide-show',
                                'posts-base',
                                'breadcrumbs',
                                'image-slider',
                                'instagram-slider',
                                'fetatures-item',
                                'timer',
                                'contact-form-7',
                                'testimonials-slider',
                                'sidebar-widgets',
                                'vegas-slider',
                                'vegas-template',
                                'gallery',
                                // wocommerce widgets
                                'woo-tab-slider',
                                'woo-grid',
                                'woo-category-grid',
                                'woo-list',
                                'woo-slider',
                                'woo-gallery',
                                'woo-banner',
                                'woo-banner-slider',
                                'woo-banner-hero-slider',
                                'woo-ajax-search',
                                'woo-archive-description',
                                'woo-page-title',
                                'woo-categories',
                                'woo-product-item',
                                // single post data
                                'post-data',
                                // wocommerce product page widgets
                                'add-to-cart',
                                'breadcrumb',
                                'product-add-to-cart',
                                'product-additional-information',
                                'product-data-tabs',
                                'product-images',
                                'product-meta',
                                'product-price',
                                'product-rating',
                                'product-related',
                                'product-short-description',
                                'product-stock',
                                'product-title',
                                'product-upsell',
                                'single-elements'
                            );

                            foreach ( $list as $widget ) {

                                $option = 'disable_'.str_replace( '-', '_', $widget );
                                $name = mb_strtoupper( str_replace( '-', ' ', $widget ) );

                                add_option( $option, 0 );
                                if ( isset( $_POST[ $option ] ) ) {
                                    update_option( $option, $_POST[ $option ] );
                                }

                                 ?>

                                <div class="col-md-4">
                                    <div class="widget-toggle">
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" name="<?php echo esc_attr( $option ); ?>" value="1">
                                            <input type="checkbox" class="custom-control-input" id="<?php echo esc_attr( $option ); ?>" name="<?php echo esc_attr( $option ); ?>" value="0" <?php checked( 0, get_option( $option ), true ); ?>>
                                            <label class="custom-control-label" for="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $name ); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                        <div class="row widget-row">
                            <div class="col-md-4">
                                <div class="widget-toggle">
                                    <?php
                                    add_option( 'disable_electron_list_shortcodes', 0 );
                                    if ( isset( $_POST['disable_electron_list_shortcodes'] ) ) {
                                        update_option( 'disable_electron_list_shortcodes', $_POST['disable_electron_list_shortcodes'] );
                                    }
                                    ?>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="disable_electron_list_shortcodes" value="1">
                                        <input type="checkbox" class="custom-control-input" id="disable_electron_list_shortcodes" name="disable_electron_list_shortcodes" value="0" <?php checked( 0, get_option( 'disable_electron_list_shortcodes' ), true ); ?>>
                                        <label class="custom-control-label" for="disable_electron_list_shortcodes"><?php _e( 'Shortcode Creator', 'electron' ); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="widget-toggle">
                                    <?php
                                    add_option( 'disable_electron_popups_builder', 0 );
                                    if ( isset( $_POST['disable_electron_popups_builder'] ) ) {
                                        update_option( 'disable_electron_popups_builder', $_POST['disable_electron_popups_builder'] );
                                    }
                                    ?>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="disable_electron_popups_builder" value="1">
                                        <input type="checkbox" class="custom-control-input" id="disable_electron_popups_builder" name="disable_electron_popups_builder" value="0" <?php checked( 0, get_option( 'disable_electron_popups_builder' ), true ); ?>>
                                        <label class="custom-control-label" for="disable_electron_popups_builder"><?php _e( 'Electron Popup Builder', 'electron' ); ?></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="page-actions">
                    <div class="row">
                        <div class="col-sm-12 submit-container">
                            <?php wp_nonce_field( 'electron_admin_nonce_field' ); ?>
                            <button type="submit" class="btn btn-primary"><?php _e( 'Save Settings', 'electron' ); ?></button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
