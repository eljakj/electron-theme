<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( !class_exists( 'Ivole' ) ) {
   exit; 
}


foreach ( $reviews as $i => $review ) {
    
    $comment_ID      = $review->comment_ID;
    $comment_post_ID = $review->comment_post_ID;
    $rating          = intval( get_comment_meta( $comment_ID, 'rating', true ) );
    $comment_content = $review->comment_content;
    $author          = get_comment_author( $review );
    
    if ( 'yes' === get_option( 'ivole_verified_links', 'no' ) ) {
        $order_id = intval( get_comment_meta( $comment_ID, 'ivole_order', true ) );
    } else {
        $order_id = 0;
    }

    $html = '';
	
	$html .= '<div class="cr-review-card-inner">';
		$html .= '<div class="top-row">';
		
			$avtr = get_avatar( $review, 56, '', esc_attr( $author ) );
			if( $avatars && $avtr ) {
				$html .= '<div class="review-thumbnail">'.$avtr.'</div>';
			}
			$html .= '<div class="reviewer">';
				$html .= '<div class="reviewer-name">'.esc_html( $author ).'</div>';
				if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && wc_review_is_from_verified_owner( $comment_ID ) ) {
					$html .= '<div class="reviewer-verified">'.$verified_text.'</div>';
				} else {
					$html .= '<div class="reviewer-verified">'.esc_html__( 'Reviewer', 'electron' ).'</div>';
				}
			$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="rating-row">';
			$html .= '<div class="rating">';
				$html .= '<div class="crstar-rating"><span style="width:'.(($rating / 5) * 100).'%;"></span></div>';
			$html .= '</div>';
			$html .= '<div class="rating-label">'.$rating.'/5</div>';
		$html .= '</div>';
		$html .= '<div class="middle-row">';
			$html .= '<div class="review-content">';
				$html .= '<div class="review-text">';
				$clear_content = wp_strip_all_tags( $comment_content );
				if ( $max_chars && mb_strlen( $clear_content ) > $max_chars ) {
					$less_content    = wp_kses_post( mb_substr( $clear_content, 0, $max_chars ) );
					$more_content    = wp_kses_post( mb_substr( $clear_content, $max_chars ) );
					$read_more       = '<span class="cr-slider-read-more">...<br><a href="#">'.esc_html__( 'Show More', 'electron' ).'</a></span>';
					$more_content    = '<div class="cr-slider-details" style="display:none;">' . $more_content . '<br><span class="cr-slider-read-less"><a href="#">'.esc_html__( 'Show Less', 'electron' ) . '</a></span></div>';
					$comment_content = $less_content . $read_more . $more_content;
					$html .= $comment_content;
				} else {
					$html .= wpautop( wp_kses_post( $comment_content ) );
				}
				$html .= '</div>';
			$html .= '</div>';
			if ( $order_id && intval( $comment_post_ID ) !== intval( $shop_page_id ) ) {
				$html .= '<div class="verified-review-row">';
					$html .= '<div class="verified-badge">'.$badge.$comment_post_ID.$order_id.'</div>';
				$html .= '</div>';
			} elseif ( $order_id && intval( $comment_post_ID ) === intval( $shop_page_id ) ) {
				$html .= '<div class="verified-review-row">';
					$html .= '<div class="verified-badge">'.$badge_sr.$order_id.'</div>';
				$html .= '</div>';
			}
			$html .= '<div class="datetime">';
				$html .= sprintf( _x( '%s ago', '%s = human-readable time difference', 'electron' ), human_time_diff( mysql2date( 'U', $review->comment_date, true ), current_time( 'timestamp' ) ) );
			$html .= '</div>';
		$html .= '</div>';
        if ( $show_products && $product = wc_get_product( $comment_post_ID ) ) {
            if ( 'publish' === $product->get_status() ) {
                $pname = $product->get_title();
                $pimg  = $product->get_image( 'woocommerce_gallery_thumbnail' );
                $html .= '<div class="review-product">';
                    $html .= '<div class="product-thumbnail">'.$pimg.'</div>';
                    $html .= '<div class="product-title"><a href="'.esc_url( get_permalink( $product->get_id() ) ).'">'.$pname.'</a></div>';
                $html .= '</div>';
            }
        }
	$html .= '</div>';
	
	echo '<div class="cr-review-card swiper-slide">'.$html.'</div>';
}

