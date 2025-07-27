<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$electron_options = get_option('electron');


/**
* Change number of related products output
*/
if ( ! function_exists( 'electron_wc_related_products_limit' ) ) {
    add_filter( 'woocommerce_output_related_products_args', 'electron_wc_related_products_limit', 20 );
    add_filter( 'woocommerce_product_related_posts_relate_by_tag', '__return_false' );
    function electron_wc_related_products_limit( $args )
    {
        $args['posts_per_page'] = apply_filters( 'electron_wc_related_products_limit', electron_settings('product_related_count', '6') );
        return $args;
    }
}


/**
* Product thumbnail
*/
if ( ! function_exists( 'shop_related_thumb_size' ) ) {
    function shop_related_thumb_size()
    {
        return apply_filters( 'shop_related_thumb_size', [370,370] );
    }
}


/**
* Single product labels
*/
if ( ! function_exists( 'electron_single_product_labels' ) ) {
    function electron_single_product_labels()
    {
        if ( '1' == electron_settings('product_labels_visibility', '1' ) ) {
            echo '<div class="electron-product-labels">';
                if ( '1' == electron_settings('product_sale_visibility', '1' ) ) {
                    electron_product_badge();
                }
                if ( '1' == electron_settings('product_discount_visibility', '1' ) ) {
                    electron_product_discount();
                }
            echo '</div>';
        }
    }
}

/**
* Single product labels
*/
if ( ! function_exists( 'electron_single_stretch_type_product_labels' ) ) {
	add_action( 'woocommerce_single_product_summary', 'electron_single_stretch_type_product_labels', 15 );
    function electron_single_stretch_type_product_labels()
    {
        if ( '1' == electron_settings('product_labels_visibility', '1' ) ) {
            echo '<div class="electron-summary-item electron-product-labels">';
                if ( '1' == electron_settings('product_sale_visibility', '1' ) ) {
                    electron_product_badge();
                }
                if ( '1' == electron_settings('product_discount_visibility', '1' ) ) {
                    electron_product_discount();
                }
            echo '</div>';
        }
    }
}


/**
* product brand
*/
if ( ! function_exists( 'electron_product_brands' ) ) {
    add_action( 'woocommerce_product_meta_end', 'electron_product_brands', 10 );
    function electron_product_brands()
    {
        global $product;
        $brands = '';
        $electronOptions = get_option('electron');
        $brands1   = taxonomy_exists('electron_product_brands') ? 'electron_product_brands' : '';
        $brands2   = taxonomy_exists('product_brand') ? 'product_brand' : '';
        $brandsTax =  '1' == electron_settings('brands_visibility', '1') ? $brands1 : $brands2;
        $terms = get_the_terms( $product->get_id(), $brandsTax );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $brands = array();
            foreach ( $terms as $term ) {
                if ( $term->parent == 0 ) {
                    $brands[] = sprintf( '<a class="electron-brands" href="%s" itemprop="brand" title="%s">%s</a>',
                        get_term_link( $term ),
                        $term->slug,
                        $term->name
                    );
                }
            }
        }
        $label = !empty( $brands ) && count( $brands ) > 1 ? esc_html__('Brands: ', 'electron' )  : esc_html__('Brand: ', 'electron' );
        if ( !empty( $brands ) ) {
            echo '<div class="electron-meta-wrapper electron-small-title electron-meta-brands">
            <span class="meta-label">'.$label.'</span>
            <span class="meta-value">' . implode( ', ', $brands ) .'</span>
            </div>';
        }
    }
}

/**
*  countdown for product
*/
if ( ! function_exists( 'electron_product_coupon' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_coupon', 35 );
    function electron_product_coupon()
    {
        if ( '1' == electron_settings('product_coupons_visibility', '1') ) {
            wp_enqueue_style( 'electron-coupons' );
            electron_wc_get_all_coupons('product');
        }
    }
}

/**
*  countdown for product
*/
if ( ! function_exists( 'electron_product_countdown' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_countdown', 25 );
    function electron_product_countdown()
    {
        if ( '0' != electron_settings('product_countdown_visibility','1') ) {

            global $product;

            $id      = $product->get_id();
            $ot_time = electron_settings('product_countdown_date');
            $date    = get_post_meta( $id, '_sale_price_dates_to', true);
			$hide    = get_post_meta( $id, 'electron_product_hide_countdown', true);
            $mb_time = $date ? date_i18n( 'Y/m/d', $date ) : '';
            $time    = $mb_time ? $mb_time : $ot_time;
            $icon    = electron_settings('product_countdown_icon','');
            $expired = electron_settings('product_countdown_expired','');
            $update  = electron_settings('product_countdown_update','');
            $onsale  = electron_settings('product_countdown_onsale','');
            $icon    = $icon ? $icon : electron_svg_lists( 'flash', 'electron-counter-icon' );
            $text1   = electron_settings('product_countdown_text','');
            $text2   = electron_settings('product_countdown_after_text');
            $class   = ' type-'.electron_settings('product_countdown_type');
            $class  .= '1' == electron_settings('product_countdown_icon_visibilty', '0') ? ' has-icon' : '';
            $class  .= $text1 || $text2 ? ' has-text' : '';
            $expired = $expired ? $expired : esc_html__( 'Expired', 'electron' );

			if ( 'yes' != $hide ) {
				if ( '1' == $onsale && !$product->is_on_sale() ) {
					return;
				}

				if ( $time ) {
					$current_time = date( 'Y/m/d' );

					if ( ( $current_time == $time || $time < $current_time ) && '1' == $update ) {
						$next_time = electron_settings('product_countdown_update_next', 7 );
						$time      = date('Y/m/d', strtotime($time. ' + '.$next_time.' days'));
					}

					echo '<div class="electron-summary-item electron-viewed-offer-time'.$class.'">';
						if ( $icon && '1' == electron_settings('product_countdown_icon_visibilty', '0')  ) {
							echo '<div class="offer-time-icon">'.$icon.'</div>';
						}
						echo '<div class="offer-time-inner">';
							if ( $text1 ) {
								echo '<p class="offer-time-text">'.$text1.'</p>';
							}
							echo '<div class="electron-coming-time" data-countdown=\'{"date":"'.$time.'","expired":"'.$expired.'"}\'>
							<div class="time-count days">00</div>
							<span class="separator">:</span>
							<div class="time-count hours">00</div>
							<span class="separator">:</span>
							<div class="time-count minutes">00</div>
							<span class="separator">:</span>
							<div class="time-count second">00</div>
							</div>';
							if ( $text2 ) {
								echo '<p class="offer-time-text-after">'.$text2.'</p>';
							}
						echo '</div>';
					echo '</div>';
				}
			}
        }
    }
}
/**
*  custom extra tabs for product page
*/
if ( ! function_exists( 'electron_wc_extra_tabs_array' ) ) {
    function electron_wc_extra_tabs_array()
    {
        global $product;
        $tabs     = array();
        $title    = get_post_meta( $product->get_id(), 'electron_tabs_title', true);
        $content  = get_post_meta( $product->get_id(), 'electron_tabs_content', true);

        if ( $title && $content ) {
            $title    = preg_split("/\\r\\n|\\r|\\n/", $title );
            $content  = preg_split("/\\r\\n|\\r|\\n/", $content );
            $acount   = $title ? count($title) : '';
            $bcount   = $content ? count($content) : '';
            $size     = ( $acount > $bcount ) ? $bcount : $acount;
            $titles   = array_slice($title, 0, $size);
            $contents = array_slice($content, 0, $size);
            $count    = 30;

            foreach( array_combine($titles, $contents) as $key => $details ) {
                if ( !empty( $key ) && !empty( $details ) ) {
                    $replaced_title = preg_replace('/\s+/', '_', strtolower(trim($key)));
                    $tabs[$replaced_title] = array(
                        'title'    => $key,
                        'priority' => $count,
                        'content'  => $details
                    );
                }
                $count = $count + 10;
            }
        }
        return $tabs;
    }
}


/**
* product page gallery
*/
if ( ! function_exists( 'electron_product_variation_gallery' ) ) {
    add_action( 'wc_ajax_electron_variation_gallery', 'electron_product_variation_gallery' );
    add_action( 'wc_ajax_nopriv_electron_variation_gallery', 'electron_product_variation_gallery' );
    function electron_product_variation_gallery()
    {
        $images       = $_POST['images'];
        $variation_id = $_POST['variation_id'];
        if ( $variation_id && $images ) {
            $size           = apply_filters( 'electron_product_thumb_size', 'woocommerce_single' );
            $tsize          = electron_settings( 'gallery_thumb_imgsize', '' );
            $layout         = apply_filters('electron_single_shop_layout', electron_settings( 'single_shop_layout', 'full-width' ) );
            $thumb_position = apply_filters( 'electron_product_gallery_thumb_position', electron_settings( 'product_gallery_thumb_position', 'left' ) );
            $iframe_video   = get_post_meta( get_the_ID(), 'electron_product_iframe_video', true );
            $popup_video    = get_post_meta( get_the_ID(), 'electron_product_popup_video', true );
            $video_type     = apply_filters( 'electron_product_video_type', get_post_meta( get_the_ID(), 'electron_product_video_type', true ) );
            $icon           = '<span class="electron-product-popup small-popup"><svg
            class="svgExpand electron-svg-icon"
            width="512"
            height="512"
            fill="currentColor"
            viewBox="0 0 512 512"
            xmlns="http://www.w3.org/2000/svg"><use href="#shopExpand"></use></svg></span>';

            $slider_class = 'electron-product-gallery-main-slider electron-swiper-main electron-swiper-container electron-swiper-theme-style nav-vertical-center';

            wp_enqueue_style( 'fancybox' );
            wp_enqueue_script( 'fancybox' );

            $classes  = $images ? ' has-thumbs thumbs-'.$thumb_position : '';
            $classes .= ' '.$layout;
            ?>
            <div class="electron-swiper-slider-wrapper electron-variation-slider active<?php echo esc_attr( $classes ); ?>" data-slider-id="<?php echo esc_attr( $variation_id ); ?>">
                <?php if ( $images && $thumb_position == 'top' ) { ?>
                    <div class="electron-product-thumbnails electron-swiper-thumbnails electron-swiper-container">
                        <div class="electron-swiper-wrapper"></div>
                    </div>
                <?php } ?>
                <div class="<?php echo esc_attr( $slider_class ); ?>">
                    <?php
                    if ( $popup_video && 'popup' == $video_type ) {
                        echo '<a data-fancybox="iframe" href="'.$popup_video.'" class="electron-product-video-button"><i class="nt-icon-button-play-2"></i></a>';
                    }
                    ?>
                    <div class="electron-swiper-wrapper electron-gallery-items">
                        <?php
                        $data_thumb = 'thumb' == $tsize ? ' data-thumb="'.$turl.'"' : '';
                        foreach ( $images as $image ) {
                            if (!empty($image)) {
                                $gimg  = wp_get_attachment_image( $image, $size );
                                $gurl  = wp_get_attachment_image_url( $image, 'full' );
                                $data_thumb = 'thumb' == $tsize ? ' data-thumb="'.$turl.'"' : '';
                                echo '<div class="swiper-slide" data-src="'.$gurl.'"'.$data_thumb.' data-fancybox="gallery">'.$gimg.$icon.'</div>';
                            }
                        }
                        if ( $iframe_video && 'gallery' == $video_type ) {
                            $iframe_html = '<iframe class="lazy" loading="lazy" data-src="https://www.youtube.com/embed/'.$iframe_video.'?playlist='.$iframe_video.'&modestbranding=1&rel=0&controls=0&autoplay=1&enablejsapi=1&showinfo=0&mute=1&loop=1&start=5&end=25" allow="autoplay; fullscreen; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowfullscreen></iframe>';
                            echo '<div class="swiper-slide swiper-slide-video-item iframe-video"><div class="electron-slide-iframe-wrapper" data-type="iframe" data-src="'.esc_url( $popup_video ).'" data-fancybox="gallery">'.$icon.$iframe_html.'</div></div>';
                        }
                        ?>
                    </div>
                    <div class="electron-swiper-prev electron-swiper-btn electron-nav-bg"></div>
                    <div class="electron-swiper-next electron-swiper-btn electron-nav-bg"></div>
                </div>
                <?php if ( $thumb_position != 'top' ) { ?>
                    <div class="electron-product-thumbnails electron-swiper-thumbnails electron-swiper-container">
                        <div class="electron-swiper-wrapper"></div>
                    </div>
                <?php } ?>
            </div>

            <?php
        }
        die();
    }
}


/**
* Remove Reviews tab from tabs
*/
if ( ! function_exists( 'electron_wc_remove_product_tabs' ) ) {
    add_filter( 'woocommerce_product_tabs', 'electron_wc_remove_product_tabs', 98 );
    function electron_wc_remove_product_tabs( $tabs )
    {
        $tabs['description']['callback'] = 'electron_wc_custom_description_tab_content'; // Custom description callback

        if ( '0' == electron_settings('product_hide_description_tab', '1' ) ) {
            unset($tabs['description']);
        }
        if ( '0' == electron_settings('product_hide_additional_tab', '1' ) ) {
            unset($tabs['additional_information']);
        }
        if ( '0' == electron_settings('product_hide_crqna_tab', '1' ) ) {
            unset($tabs['cr_qna']);
        }
        if ( '0' == electron_settings('single_shop_review_visibility', '1' ) || '0' == electron_settings('product_hide_reviews_tab', '1' ) ) {
            unset($tabs['reviews']);
        }

        if ( '1' == electron_settings( 'product_tabs_custom_order', '0' ) ) {
            $tabs_order = electron_settings( 'product_tabs_order', null );
            if ( !empty( $tabs_order['show'] ) ) {
                unset( $tabs_order['show']['placebo'] );
                $priority = 1;
                foreach ( $tabs_order['show'] as $key => $value ) {
                    $tabs[ $key ][ 'priority' ] = $priority;
                    $priority++;
                }
            }
        }
        return $tabs;
    }
}


/**
 * Customize product data tabs
 */
if ( ! function_exists( 'electron_wc_custom_description_tab_content' ) ) {
    function electron_wc_custom_description_tab_content()
    {
        $desc_tab_title = electron_settings( 'product_description_tab_title', '' );
        $desc_tab_title = '' != $desc_tab_title ? $desc_tab_title : esc_html__( 'Product Details', 'electron' );
        ?>
        <div class="product-desc-content">
            <?php if ( '1' == electron_settings( 'product_description_tab_title_visibility', '0' ) ) { ?>
                <h4 class="title"><?php echo apply_filters( 'electron_description_tab_title', $desc_tab_title ); ?></h4>
            <?php } ?>
            <?php the_content(); ?>
        </div>
        <?php
    }
}


/**
 * Move Reviews tab after product related
 */
if ( ! function_exists( 'electron_wc_move_product_reviews' ) ) {
    function electron_wc_move_product_reviews()
    {
        comments_template();
    }
}



/*************************************************
## Product Trust Image and Text
*************************************************/
if ( !function_exists( 'electron_product_trust_image' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_trust_image', 100 );
    function electron_product_trust_image()
    {
        global $product;
        if ( '1' == electron_settings('product_trust_image_visibility', '1') ) {
            $image = electron_settings('product_trust_image');
            $size  = electron_settings('product_trust_image_size');

            $terms = wc_get_product_term_ids( $product->get_id(), 'product_cat' );
            $category_exclude = electron_settings( 'product_trust_category_exclude', null );
            if ( !empty($terms) ) {
                foreach ($terms as $term ) {
                    if ( !empty($category_exclude) ) {
                        foreach ($category_exclude as $val ) {
                            if ( $term == $val ) {
                                return;
                            }
                        }
                    }
                }
            }

            if ( '' != electron_settings('product_trust_image_elementor_template', null) ) {

                echo electron_print_elementor_templates( 'product_trust_image_elementor_template', '' );

            } else {

                if ( !empty( $image['id'] ) ) {
                ?>
                <div class="electron-summary-item electron-product-trust-badge">
                        <div class="electron-trust-badge-image">
                            <?php echo wp_get_attachment_image( $image['id'], $size ); ?>
                        </div>
                    <?php if ( '' != electron_settings('product_trust_image_text') ) { ?>
                        <div class="electron-trust-badge-text"><?php echo electron_settings('product_trust_image_text'); ?></div>
                    <?php } else { ?>
                        <div class="electron-trust-badge-text"><?php esc_html_e('Guaranteed safe &amp; secure checkout','electron'); ?></div>
                    <?php } ?>
                </div>
                <?php
                }
            }
        }
    }
}


if ( !function_exists( 'electron_product_summary_layouts_manager' ) ) {
    function electron_product_summary_layouts_manager()
    {
        if ( 'default' == electron_settings( 'single_shop_summary_layout_type', 'default' ) ) {
            return;
        }
        $defaults = [
            'show'=> [
                'bread' => '',
                'title' => '',
                'rating' => '',
                'price' => '',
                'excerpt' => '',
                'cart' => '',
                'meta' => ''
            ]
        ];
        $bread     = electron_settings( 'product_bread_visibility', '1' );
        $bread_pos = electron_settings( 'product_bread_position', 'default' );
        $layouts   = electron_settings( 'single_shop_summary_layouts', $defaults );

        if ( $layouts ) {

            unset( $layouts['show']['placebo'] );

            foreach ( $layouts['show'] as $key => $value ) {
                switch ( $key ) {
                    case 'bread':
                    if ( '0' != $bread && 'default' == $bread_pos ) {
                        echo electron_breadcrumbs();
                    }
                    break;
                    case 'title':
                        woocommerce_template_single_title();
                    break;
                    case 'rating':
                        woocommerce_template_single_rating();
                    break;
                    case 'price':
                        woocommerce_template_single_price();
                    break;
                    case 'cart':
                        woocommerce_template_single_add_to_cart();
                    break;
                    case 'excerpt':
                        woocommerce_template_single_excerpt();
                    break;
                    case 'meta':
                        woocommerce_template_single_meta();
                    break;
                    case 'labels':
                        electron_single_stretch_type_product_labels();
                    break;
                    case 'visitors':
                        electron_product_visitiors_message();
                    break;
                    case 'progresbar':
                        electron_product_stock_progress_bar();
                    break;
                    case 'popups':
                        electron_product_popup_details();
                    break;
                    case 'coupon':
                        electron_product_coupon();
                    break;
                    case 'countdown':
                        electron_product_countdown();
                    break;
                    case 'custom-btn':
                        electron_product_page_custom_btn();
                    break;
                    case 'trust-badge':
                        electron_product_trust_image();
                    break;
                    case 'brand':
                        electron_product_brand_image();
                    break;
                }
            }
        }
    }
}


if ( ! function_exists( 'electron_product_page_custom_btn' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_page_custom_btn', 31 );
    function electron_product_page_custom_btn()
    {
        if ( '1' == electron_settings('product_custom_btn_visibility', '0' ) ) {
            $page_link = get_the_permalink();
            $page_id   = get_the_ID();
            $action    = electron_settings('product_custom_btn_action','');
            $title     = electron_settings('product_custom_btn_title','');
            $link      = electron_settings('product_custom_btn_link','');
            $target    = electron_settings( 'product_custom_btn_target' );
            $shortcode = electron_settings('product_custom_btn_form_shortcode','');
            $wlink     = electron_settings( 'product_custom_btn_whatsapp_link' );
            $wlink     = $wlink ? $wlink : 'https://api.whatsapp.com/send?text=' . urlencode( $page_link );
            $wm_link   = electron_settings( 'product_custom_btn_whatsapp_mobile_link' );
            $wm_link   = $wm_link ? $wm_link : 'whatsapp://send?text=' . urlencode( $page_link );
            $w_link    = wp_is_mobile() ? $wm_link : $wlink;

            echo '<div class="electron-summary-item electron-product-action-button" data-action="'.$action.'">';
                if ( 'link' == $action ) {


                    echo '<a class="electron-btn electron-btn-primary electron-btn-solid electron-btn-square electron-btn-large" href="'.$link.'" target="'.$target.'">'.$title.'</a>';

                } elseif ( 'form' == $action ) {

                    wp_enqueue_style( 'fancybox' );
                    wp_enqueue_script( 'fancybox' );

                    echo '<a class="electron-btn electron-btn-primary electron-btn-solid electron-btn-square electron-btn-large" data-fancybox="dialog" data-src="#dialog-content-'.$page_id.'">'.$title.'</a>';
                    echo '<div id="dialog-content-'.$page_id.'" style="display:none;max-width:500px;">'.do_shortcode( $shortcode ).'</div>';

                } elseif ( 'whatsapp' == $action ) {

                    echo '<a rel="noopener noreferrer nofollow" href="'.$w_link.'" target="'.esc_html( $target ).'" class="electron-btn electron-btn-green-soft electron-btn-solid electron-btn-square electron-btn-large electron-whatsapp-button">
                        <i class="electron-icons nt-icon-whatsapp"></i>
                        <span class="whatsapp-text">'.$title.'</span>
                    </a>';
                }
            echo '</div>';
        }
    }
}


/**
* Add stock progressbar
*/
if ( ! function_exists( 'electron_product_stock_progress_bar' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_stock_progress_bar', 26 );
    function electron_product_stock_progress_bar() {
        global $post,$product;
        $product_id   = $post->ID;
        $progressbar  = electron_settings( 'single_shop_progressbar_visibility', '0' );
        $manage_stock = get_post_meta( $product_id, '_manage_stock', true );

        if ( $manage_stock != 'yes' || '0' == $progressbar ) {
            return;
        }

        $current_stock = get_post_meta( $product_id, '_stock', true );
        $total_sold    = $product->get_total_sales();
        $percentage    = $total_sold > 0 && $current_stock > 0 ? round( $total_sold / $current_stock * 100 ) : 0;

        if ( $current_stock > 0 ) {
            ?>
            <div class="electron-summary-item electron-single-product-stock">
                <div class="stock-details">
                    <div class="stock-sold"><?php esc_html_e( 'Ordered:', 'electron' ); ?><span> <?php echo esc_html( $total_sold ); ?></span></div>
                    <div class="current-stock"><?php esc_html_e( 'Items available:', 'electron' ); ?><span> <?php echo esc_html( wc_trim_zeros( $current_stock ) ); ?></span></div>
                </div>
                <div class="electron-product-stock-progress">
                    <div class="electron-product-stock-progressbar" data-stock-percent="<?php echo esc_attr( $percentage ); ?>%"></div>
                </div>
            </div>
            <?php
        }
    }
}


/**
* Add size guide popup
*/
if ( ! function_exists( 'electron_product_popup_details' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_popup_details', 35 );
    function electron_product_popup_details()
    {
        $guide  = electron_settings( 'product_size_guide_template', null );
        $delivery = electron_settings( 'product_delivery_template', null );
        if ( $guide || $delivery || '1' == electron_settings('estimated_delivery_visibility', '0' ) ) {
            ?>
            <div class="electron-summary-item electron-product-popup-details">
                <?php
                electron_product_delivery_return();
                electron_product_size_guide();
                electron_product_estimated_delivery();
                ?>
            </div>
            <?php
        }
    }
}


if ( ! function_exists( 'electron_product_size_guide' ) ) {
    function electron_product_size_guide()
    {
        global $product;
        $id          = $product->get_id();
        $guide_id    = get_post_meta( $id, 'electron_product_size_guide', true );
        $template_id = $guide_id ? $guide_id : electron_settings( 'product_size_guide_template', null );

        if ( null != $template_id || '' != $template_id ) {

            $cats          = wc_get_product_term_ids( $id, 'product_cat' );
            $tags          = wc_get_product_term_ids( $id, 'product_tag' );
            $total_terms   = !empty( $cats ) && !empty( $tags ) ? array_merge( $cats, $tags ) : $cats;
            $total_terms[] = $id;
            $cat_exclude   = electron_settings( 'product_size_guide_category_exclude', null );
            $cat_exclude   = $cat_exclude ? $cat_exclude : array();
            $tag_exclude   = electron_settings( 'product_size_guide_tag_exclude', null );
            $tag_exclude   = $tag_exclude ? $tag_exclude : array();
            $total_exclude = array_merge( $cat_exclude, $tag_exclude );

            if ( array_intersect( $total_exclude, $total_terms ) ) {
                return;
            }
            wp_enqueue_script( 'magnific');
            $template_id = apply_filters( 'electron_translated_template_id', intval( $template_id ) );
            ?>
            <div class="electron-product-size-guide-btn has-svg-icon electron-flex electron-align-center">
                <?php echo '' != electron_settings('size_guide_icon', '') ? electron_settings('size_guide_icon', '') : electron_svg_lists('ruler', 'electron-svg-icon'); ?>&nbsp;
                <a data-fancybox href="#electron_product_size_guide_<?php echo esc_attr( $template_id ); ?>" class="electron-open-popup"><?php echo '' != electron_settings('size_guide_text', '') ? electron_settings('size_guide_text', '') : esc_html__( 'Size Guide', 'electron' ); ?></a>
            </div>
            <div class="electron-product-size-guide electron-popup-content-big electron-hidden has-el-template" data-template="<?php echo esc_attr( $template_id ); ?>" id="electron_product_size_guide_<?php echo esc_attr( $template_id ); ?>">
                <?php
                if ( $guide_id ) {
                    echo do_shortcode('[electron-template id="'.$guide_id.'" css="yes"]');
                } else {
                    echo electron_print_elementor_templates( 'product_size_guide_template', null );
                }
                ?>
            </div>
            <?php
        }
    }
}


/**
* Add delivery and return popup
*/
if ( ! function_exists( 'electron_product_delivery_return' ) ) {
    function electron_product_delivery_return()
    {
        global $product;
        $id          = $product->get_id();
        $delivery_id = get_post_meta( $id, 'electron_product_delivery_return', true );
        $template_id = $delivery_id ? $delivery_id : electron_settings( 'product_delivery_template', null );

        if ( null != $template_id || '' != $template_id ) {
            $cats          = wc_get_product_term_ids( $id, 'product_cat' );
            $tags          = wc_get_product_term_ids( $id, 'product_tag' );
            $total_terms   = !empty( $cats ) && !empty( $tags ) ? array_merge( $cats, $tags ) : $cats;
            $total_terms[] = $id;
            $cat_exclude   = electron_settings( 'product_delivery_category_exclude', null );
            $cat_exclude   = $cat_exclude ? $cat_exclude : array();
            $tag_exclude   = electron_settings( 'product_delivery_tag_exclude', null );
            $tag_exclude   = $tag_exclude ? $tag_exclude : array();
            $total_exclude = array_merge( $cat_exclude, $tag_exclude );
            $icon          = electron_settings('product_delivery_icon', '');
            $text          = electron_settings('product_delivery_text', '');

            if ( array_intersect( $total_exclude, $total_terms ) ) {
                return;
            }
            wp_enqueue_script( 'magnific');
            $template_id = apply_filters( 'electron_translated_template_id', intval( $template_id ) );
            ?>
            <div class="electron-product-delivery-btn has-svg-icon electron-flex electron-align-center">
                <?php echo '' != $icon ? $icon : electron_svg_lists('delivery-return', 'electron-svg-icon');?>&nbsp;
                <a data-fancybox href="#electron_product_delivery_<?php echo esc_attr( $template_id ); ?>" class="electron-open-popup"><?php echo '' != $text ? $text : esc_html__( 'Delivery & Return', 'electron' );?></a>
            </div>
            <div class="electron-single-product-delivery electron-popup-content-big electron-hidden has-el-template" data-template="<?php echo esc_attr( $template_id ); ?>" id="electron_product_delivery_<?php echo esc_attr( $template_id ); ?>">
                <?php
                if ( $delivery_id ) {
                    echo do_shortcode('[electron-template id="'.$delivery_id.'" css="yes"]');
                } else {
                    echo electron_print_elementor_templates( 'product_delivery_template', null );
                }
                ?>
            </div>
            <?php
        }
    }
}


if ( ! function_exists( 'electron_product_visitiors_message' ) ) {
    add_action( 'woocommerce_single_product_summary', 'electron_product_visitiors_message',39 );
    function electron_product_visitiors_message()
    {
        if ( '0' == electron_settings('product_visitiors_message_visibility', '0' )  ) {
            return;
        }

        $text2 = '' != electron_settings('product_visitiors_message_text2') ? electron_settings('product_visitiors_message_text2') : esc_html__('people have this in their carts right now. It\'s running out!','electron');

        if ( 'fake' == electron_settings('product_visitiors_message_type', 'default' ) ) {

            wp_enqueue_script( 'jquery-cookie');
            global $product;

            $data[] = electron_settings( 'visit_count_min' ) ? '"min":' . electron_settings( 'visit_count_min' ) : '"min":10';
            $data[] = electron_settings( 'visit_count_max' ) ? '"max":' . electron_settings( 'visit_count_max' ) : '"max":50';
            $data[] = electron_settings( 'visit_count_delay' ) ? '"delay":' . electron_settings( 'visit_count_delay' ) : '"delay":30000';
            $data[] = electron_settings( 'visit_count_change' ) ? '"change":' . electron_settings( 'visit_count_change' ) : '"change":5';
            $data[] = '"id":' . $product->get_id();

            ?>
            <div class="electron-summary-item electron-product-view electron-visitors-product-message electron-warning" data-product-view='{<?php echo implode(',', $data ); ?>}'>
                <?php echo electron_svg_lists( 'bag', 'electron-svg-icon' ); ?>
                <div class="electron-visitors-product-text">
                    <span class="electron-view-count"></span> <?php echo esc_html($text2); ?>
                </div>
            </div>
            <?php

        } else {

            global $wpdb, $product;
            $in_basket       = 0;
            $wc_session_data = $wpdb->get_results( "SELECT session_key FROM {$wpdb->prefix}woocommerce_sessions" );
            $wc_session_keys = wp_list_pluck( $wc_session_data, 'session_key' );

            if ( $wc_session_keys ) {
                foreach ( $wc_session_keys as $key => $_customer_id ) {
                    // if you want to skip current viewer cart item in counts or else can remove belows checking
                    if( WC()->session->get_customer_id() == $_customer_id ) continue;

                    $session_contents = WC()->session->get_session( $_customer_id, array() );
                    $cart_contents = !empty( $session_contents['cart'] ) ? maybe_unserialize( $session_contents['cart'] ) : '';
                    if( $cart_contents ){
                        foreach ( $cart_contents as $cart_key => $item ) {
                            if( $item['product_id'] == $product->get_id() ) {
                                $in_basket += 1;
                            }
                        }
                    }
                }
            }

            if ( $in_basket ) {
                ?>
                <div class="electron-summary-item electron-visitors-product-message electron-warning">
                    <?php echo electron_svg_lists( 'bag', 'electron-svg-icon' ); ?>
                    <div class="electron-visitors-product-text">
                        <?php echo sprintf( '%d  %s', $in_basket,$text2 ); ?>
                    </div>
                </div>
                <?php
            }
        }
    }
}

if ( ! function_exists( 'electron_product_estimated_delivery' ) ) {
    function electron_product_estimated_delivery() {

        if ( '0' == electron_settings('estimated_delivery_visibility', '0' ) ) {
            return;
        }
        global $product;
        $id   = $product->get_id();
        $text = get_post_meta( $id, 'electron_product_estimated_delivery', true );
        $icon = electron_settings('estimated_delivery_icon', '');
        $icon = '' != $icon ? $icon : electron_svg_lists('shipping', 'electron-svg-icon');

        if ( '' != $text ) {
            ?>
            <div class="electron-estimated-delivery electron-flex electron-align-center">
                <?php printf('%s',$icon);?>&nbsp;<span><?php printf('%s',$text ); ?></span>
            </div>
            <?php
        } else {

            $min_ed   = electron_settings('min_estimated_delivery');
            $max_ed   = electron_settings('max_estimated_delivery');
            $excDays  = electron_settings('estimated_delivery_exclude_days');
            $excDates = electron_settings('estimated_delivery_exclude_dates');

            $min   = $min_ed ? $min_ed : 3;
            $from  = '+' . $min;
            $from .= ' ' . ( $min == 1 ? 'day' : 'days' );

            $max = $max_ed ? (int) $max_ed : 7;
            $to  = '+' . $max;
            $to .= ' ' . ( $max == 1 ? 'day' : 'days' );

            $now      = get_date_from_gmt( date('Y-m-d H:i:s'), 'Y-m-d' );
            $est_days = $exclude_days = $exclude_dates = array();

            if ( !empty($excDays) ) {
                $exclude_days = $excDays;
            }
            if ( !empty($excDates) ) {
                $excDates = explode(',',$excDates);
                $exclude_dates = $excDates;
            }

            $format     = esc_html__( 'M d', 'electron' );
            $start_date = strtotime($now . $from);
            $end_date   = strtotime($now . $to);

            if ( !empty($excDays) || !empty($excDates) ) {
                while ($start_date <= $end_date) {
                    $day  = date('N', $start_date);
                    $date = date('Y-m-d', $start_date);
                    if (!in_array($day, $exclude_days) && !in_array($date, $exclude_dates)) {
                        $est_days[] = '<span class="date">'.date_i18n($format, $start_date, true).'</span>';
                    }
                    $start_date = strtotime("+1 day", $start_date);
                }
            } else {
                $est_days[] = '<span class="date-start">'.date_i18n( $format, $start_date, true ).'</span>';
                $est_days[] = '<span class="date-end">'.date_i18n( $format, $end_date, true ).'</span>';
            }

            if ( !empty( $est_days ) ) {
                ?>
                <div class="electron-estimated-delivery electron-flex electron-align-center">
                    <?php printf('%s',$icon);?>&nbsp;<span><?php
                    if ( '' != electron_settings('estimated_delivery_text', '') ) {
                        echo electron_settings('estimated_delivery_text', '');
                    } else {
                        esc_html_e( 'Estimated Delivery:', 'electron' );
                    }
                    ?>&nbsp;</span>
                    <span class="dates"><?php echo implode( ' ', $est_days ); ?></span>
                </div>
                <?php
            }
        }
    }
}


if ( ! function_exists( 'electron_single_product_nav_two' ) ) {
    function electron_single_product_nav_two() {

        if ( '0' == electron_settings('single_shop_nav_visibility', '1') ) {
            return;
        }
        $prev    = get_previous_post();
        $prevID  = $prev ? $prev->ID : '';
        $next    = get_next_post();
        $nextID  = $next ? $next->ID : '';
        $imgSize = array(40,40,true);
        ?>
        <div class="electron-product-nav electron-flex electron-align-center">
            <?php if ( $prevID ) : ?>
                <a class="product-nav-link electron-nav-prev" href="<?php echo esc_url( get_permalink( $prevID ) ); ?>">
                    <span class="electron-nav-arrow nt-icon-left-arrow-chevron"></span>
                    <span class="product-nav-content">
                        <?php echo apply_filters( 'electron_products_nav_image', get_the_post_thumbnail( $prevID, $imgSize ) ); ?>
                        <span class="product-nav-title"><?php echo get_the_title( $prevID ); ?></span>
                    </span>
                </a>
            <?php else : ?>
                <a class="product-nav-link electron-nav-prev disabled" href="#0">
                    <span class="electron-nav-arrow nt-icon-left-arrow-chevron"></span>
                </a>
            <?php endif ?>

            <a href="<?php echo apply_filters( 'electron_single_product_back_btn_url', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="product-nav-link electron-nav-shop">
                <span class="electron-shop-link-inner">
                    <span class="electron-shop-link-icon"></span>
                    <span class="electron-shop-link-icon"></span>
                </span>
            </a>

            <?php if ( $nextID ) : ?>
                <a class="product-nav-link electron-nav-next" href="<?php echo esc_url( get_permalink( $nextID ) ); ?>">
                    <span class="electron-nav-arrow nt-icon-right-arrow-chevron"></span>
                    <span class="product-nav-content">
                        <?php echo apply_filters( 'electron_products_nav_image', get_the_post_thumbnail( $nextID, $imgSize ) ); ?>
                        <span class="product-nav-title"><?php echo get_the_title( $nextID ); ?></span>
                    </span>
                </a>
            <?php else : ?>
                <a class="product-nav-link electron-nav-next disabled" href="#0">
                    <span class="electron-nav-arrow nt-icon-right-arrow-chevron"></span>
                </a>
            <?php endif ?>
        </div>
        <?php
    }
}


/**
* Single Bottom Popup Product Add To Cart
*/
if ( ! function_exists( 'electron_product_bottom_popup_cart' ) ) {
    add_action( 'electron_before_wp_footer', 'electron_product_bottom_popup_cart' );
    function electron_product_bottom_popup_cart()
    {
        global $product;

        if ( !is_product() || $product->is_type( 'grouped' ) || '0' == electron_settings( 'product_bottom_cart', '0' ) ) {
            return;
        }
        $id = $product->get_id();
        ?>
        <div class="electron-product-bottom-popup-cart">
            <div class="details">
                <?php echo get_the_post_thumbnail( $id, array(60,60,true) ); ?>
                <div class="name">
                    <?php echo get_the_title( $id ); ?>
                    <span class="electron-price"><?php woocommerce_template_loop_price(); ?></span>
                </div>

            </div>
            <?php echo electron_add_to_cart( 'button', $id ); ?>
        </div>
        <?php
    }
}


function electron_custom_add_variation_data( $data, $product, $variation ) {
    $imagess = get_post_meta( $variation->get_id(), '_electron_variation_gallery', true );
    $images = explode(';', $imagess);
    $imgs   = array();
    foreach ( $images as $image) {
        if (!empty($image)) {
            array_push($imgs,$image);
        }
    }
    $data['electron_variation_gallery'] = !empty($imgs) ? $imgs : '';

    return $data;
}
if ( isset( $electron_options['product_thumbs_layout'] ) && 'slider' == $electron_options['product_thumbs_layout'] ) {
    add_filter( 'woocommerce_available_variation', 'electron_custom_add_variation_data', 10, 3 );
}


/*************************************************
## Before Product Footer  Elementor Template
*************************************************/
if ( !function_exists( 'electron_after_product_elementor_template' ) ) {
    add_action( 'electron_after_wc_single', 'electron_after_product_elementor_template', 10 );
    function electron_after_product_elementor_template()
    {
        if ( '' != electron_settings('product_before_footer_template', null) ) {
            echo electron_print_elementor_templates( 'product_before_footer_template', 'electron_after_product' );
        }
    }
}

/**
* product brand image
*/
if ( ! function_exists( 'electron_product_brand_image' ) ) {
    if ( isset( $electron_options['product_brand_visibility'] ) && '1' == $electron_options['product_brand_visibility'] ) {
        add_action( 'woocommerce_single_product_summary', 'electron_product_brand_image', 10 );
    }
    function electron_product_brand_image()
    {
        if ( '1' == electron_settings('brands_visibility') ) {
            global $product;
            $html   = '';
            $brands = get_the_terms( $product->get_id(), 'electron_product_brands' );
            if ( !empty( $brands ) ) {
                foreach ( $brands as $brand ) {
                    $term_meta = get_option( "taxonomy_$brand->term_id" );
                    $image_id  = !empty($term_meta['brand_thumbnail_id']) ? absint( $term_meta['brand_thumbnail_id'] ) : '';
                    if ( $image_id ) {
                        $html .= '<a href="'.esc_url( get_term_link( $brand ) ).'" title="'.$brand->name.'">';
                            $html .= wp_get_attachment_image( $image_id, 'thumbnail', false, ['class'=>'electron-brand-image'] );
                        $html .= '</a>';
                    }
                }
                echo '<div class="electron-product-brand electron-summary-item">'.$html.'</div>';
            }
        }
    }
}
