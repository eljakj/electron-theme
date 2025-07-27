<?php
/**
* Electron Quick View
*/
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
if ( ! class_exists( 'Electron_QuickView' ) ) {
    class Electron_QuickView
    {
        private static $instance = null;

        function __construct()
        {
            // frontend scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

            // frontend template
            add_action( 'wp_ajax_electron_quickview', array( $this, 'quick_view_template' ) );
            add_action( 'wp_ajax_nopriv_electron_quickview', array( $this, 'quick_view_template' ) );
        }

        public function enqueue_scripts()
        {
            wp_enqueue_script( 'electron-swiper' );
            wp_enqueue_style( 'electron-swiper' );
            wp_enqueue_style( 'electron-wc-quick-view' );
            $ot    = get_option('electron');
            $quick = isset($ot['quick_view_type']) ? $ot['quick_view_type'] : 'sidebar';
            if ( 'popup' == $quick ) {
                wp_enqueue_script( 'magnific' );
                wp_enqueue_script( 'electron-quickview', ELECTRON_PLUGIN_URL . 'assets/front/js/quickview/quickview.js', array( 'jquery' ), ELECTRON_PLUGIN_VERSION, true );
            } else {
                wp_enqueue_script( 'electron-quickview', ELECTRON_PLUGIN_URL . 'assets/front/js/quickview/quickview-sidebar.js', array( 'jquery' ), ELECTRON_PLUGIN_VERSION, true );
            }
        }

        public function quick_view_template()
        {
            global $post;
            $ot      = get_option('electron');
            $type    = isset($ot['quick_view_type']) ? $ot['quick_view_type'] : 'sidebar';
            $pid     = 'popup' == $type ? absint( $_GET['product_id'] ) : absint( $_POST['product_id'] );
            $product = wc_get_product( $pid );
            $name    = esc_html( $product->get_name() );
            $images  = $product->get_gallery_image_ids();
            $size    = apply_filters( 'electron_product_thumb_size', 'medium_large' );
            $width   = isset($ot['quick_view_width']) ? $ot['quick_view_width'] : '';
            $col     = $width>680 ? 'col-lg-6' : 'col-12';
            $catalog_mode  = isset($ot['woo_catalog_mode']) ? $ot['woo_catalog_mode'] : '0';
            $disable_price = isset($ot['woo_disable_price']) ? $ot['woo_disable_price'] : '0';

            if ( $product ) {

                $post = get_post( $pid );
                setup_postdata( $post );
                if ( post_password_required($post) ) {
                    $strings = electron_theme_all_settings();
                    $text = $strings['protected'];
                    $btn  = $strings['check_product'];
                    if ( 'popup' == $type ) {
                        ?>
                        <div class="electron-quickshop-wrapper single-content zoom-anim-dialog product-protected">
                            <p class="protected-text"><?php echo esc_html( $text); ?></p>
                            <a class="electron-btn-medium electron-btn electron-btn-primary" href="<?php echo esc_url( get_permalink( $pid ) ) ?>"><?php echo esc_html( $btn); ?></a>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="panel-close" data-target=".electron-quickview-sidebar"></div>
                        <div class="electron-quickview-inner product-protected">
                            <p class="protected-text"><?php echo esc_html( $text); ?></p>
                            <a class="electron-btn-medium electron-btn electron-btn-primary" href="<?php echo esc_url( get_permalink( $pid ) ) ?>"><?php echo esc_html( $btn); ?></a>
                        </div>
                        <?php
                    }
                } else {
                    if ( 'popup' == $type ) {
                        ?>
                        <div class="electron-quickview-wrapper single-content zoom-anim-dialog">
                            <div class="container-full electron-container-full">
                                <div class="row">
                                    <div class="<?php echo esc_attr($col); ?> quick-gallery-col">
                                        <div class="electron-swiper-slider-wrapper">
                                            <?php if ( !empty( $images ) ) { ?>
                                                <div class="electron-quickview-main electron-swiper-main nav-vertical-center">
                                                    <div class="electron-swiper-wrapper">
                                                        <?php
                                                        echo '<div class="swiper-slide">'.get_the_post_thumbnail( $pid, $size ).'</div>';
                                                        foreach( $images as $image ) {
                                                            $img = wp_get_attachment_image_url($image,$size);
                                                            echo '<div class="swiper-slide"><img src="'.$img.'" alt="'.$name.'"/></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="electron-swiper-prev electron-swiper-btn electron-nav-bg"></div>
                                                    <div class="electron-swiper-next electron-swiper-btn electron-nav-bg"></div>
                                                </div>
                                                <div class="electron-quickview-thumbnails electron-swiper-thumbnails electron-swiper-container">
                                                    <div class="electron-swiper-wrapper"></div>
                                                </div>
                                            <?php } else { ?>
                                                <?php echo get_the_post_thumbnail( $pid, $size ); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="<?php echo esc_attr($col); ?> quick-summary-col">
                                        <div class="electron-quickview-product-details electron-product-summary">
                                            <?php the_title( '<h4 class="electron-product-title">', '</h4>' );?>
                                            <?php
                                            if ( '1' != $catalog_mode && '1' != $disable_price ) {
                                                woocommerce_template_single_price();
                                            }
                                            ?>
                                            <?php if ( has_excerpt() ) { ?>
                                                <div class="electron-summary-item"><?php the_excerpt(); ?></div>
                                            <?php } ?>
                                            <div class="electron-summary-item"><?php woocommerce_template_single_meta();?></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 quick-cart-col">
                                        <?php if ( '1' != $catalog_mode ) {
                                            woocommerce_template_single_add_to_cart();
                                        } ?>
                                        <div class="electron-quickview-notices"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>

                            <div class="panel-close" data-target=".electron-quickview-sidebar"></div>
                            <div class="electron-quickview-inner">
                                <?php if ( !empty( $images ) ) { ?>
                                    <div class="electron-swiper-container electron-swiper-slider quick-main nav-vertical-centered">
                                        <div class="electron-swiper-wrapper">
                                            <div class="swiper-slide"><?php echo get_the_post_thumbnail($pid, $size); ?></div>
                                            <?php
                                            foreach( $images as $image ) {
                                                $img = wp_get_attachment_image_url($image, $size);
                                                echo '<div class="swiper-slide"><img src="'.$img.'" alt="'.$name.'"/></div>';
                                            }
                                            ?>
                                        </div>
                                        <div class="electron-swiper-prev electron-swiper-btn electron-nav-bg"></div>
                                        <div class="electron-swiper-next electron-swiper-btn electron-nav-bg"></div>
                                    </div>
                                    <div class="quick-thumbs electron-swiper-container">
                                        <div class="electron-swiper-wrapper"></div>
                                    </div>
                                    <?php
                                } else {
                                    echo get_the_post_thumbnail($pid, $size);
                                }
                                ?>
                                <div class="quick-details">
                                    <?php
                                    the_title( '<h4 class="electron-product-title">', '</h4>' );
                                    if ( '1' != $catalog_mode && '1' != $disable_price ) {
                                        woocommerce_template_single_price();
                                    }
                                    the_excerpt();
                                    if ( '1' != $catalog_mode ) {
                                        woocommerce_template_single_add_to_cart();
                                    }
                                    woocommerce_template_single_meta();
                                    ?>
                                </div>
                            </div>
                        <?php
                    }
                }
                wp_reset_postdata();
            }
            die();
        }

        public static function get_instance()
        {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    }
    Electron_QuickView::get_instance();
}
