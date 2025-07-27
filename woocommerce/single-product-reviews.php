<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() || '0' == electron_settings('single_shop_review_visibility', '1' ) ) {
	return;
}

$layout        = apply_filters('electron_single_shop_layout', electron_settings( 'single_shop_layout', 'full-width' ) );
$count         = '';
$tabs_type     = apply_filters( 'electron_product_tabs_type', electron_settings( 'product_tabs_type', 'tabs' ) );
$review_class  = $product->get_review_count() && wc_review_ratings_enabled() ? 'has-review' : 'no-review';
$review_class .= $tabs_type == 'accordion' || $layout == 'stretch' ? ' electron-section' : '';

?>
<div id="reviews" class="electron-product-reviews-wrapper <?php echo esc_attr( $review_class ); ?>">

    <?php if ( 'tabs' != $tabs_type ) { ?>
        <div class="section-title-wrapper">
            <h4 class="section-title"><?php echo apply_filters( 'electron_reviews_section_heading', esc_html__( 'Product Reviews', 'electron' ) ); ?></h4>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="reviews-count-title">
                <h5 class="title">
                    <?php
                    if ( $count && wc_review_ratings_enabled() ) {
                        /* translators: 1: reviews count 2: product name */
                        $reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'electron' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
                        echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
                    } else {
                        esc_html_e( 'Reviews', 'electron' );
                    }
                    ?>
                </h5>
            </div>
            <div class="product-review-list blog-comment">
                <div id="comments">

                    <?php if ( have_comments() ) { ?>

                        <ol class="commentlist">
                            <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
                        </ol>

                        <?php
                        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
                            echo '<nav class="electron-woocommerce-pagination">';
                            paginate_comments_links(
                                apply_filters(
                                    'woocommerce_comment_pagination_args',
                                    array(
                                        'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                                        'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                                        'type'      => 'list',
                                    )
                                )
                            );
                            echo '</nav>';
                        }
                    } else {
                        ?>
                        <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'electron' ); ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
            <div class="col-lg-6">
                <div class="product-review-form">
                    <div id="review_form_wrapper">
                        <div id="review_form">

                            <?php
                            $commenter    = wp_get_current_commenter();
                            $comment_form = array(
                                /* translators: %s is product title */
                                'title_reply' => have_comments() ? esc_html__( 'Add a review', 'electron' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'electron' ), get_the_title() ),
                                /* translators: %s is product title */
                                'title_reply_to' => esc_html__( 'Leave a Reply to %s', 'electron' ),
                                'title_reply_before' => '<h5 id="reply-title" class="comment-reply-title">',
                                'title_reply_after' => '</h5>',
                                'comment_notes_after' => '',
                                'label_submit' => esc_html__( 'Submit', 'electron' ),
                                'logged_in_as' => '',
                                'comment_field' => '',
                            );

                            $name_email_required = (bool) get_option( 'require_name_email', 1 );
                            $fields = array(
                                'author' => array(
                                    'label' => __( 'Name', 'electron' ),
                                    'type' => 'text',
                                    'value' => $commenter['comment_author'],
                                    'required' => $name_email_required,
                                ),
                                'email' => array(
                                    'label' => __( 'Email', 'electron' ),
                                    'type' => 'email',
                                    'value' => $commenter['comment_author_email'],
                                    'required' => $name_email_required,
                                ),
                            );

            				$comment_form['fields'] = array();

            				foreach ( $fields as $key => $field ) {
            					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
            					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

            					if ( $field['required'] ) {
            						$field_html .= '&nbsp;<span class="required">*</span>';
            					}

            					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" autocomplete="' . esc_attr( $field['autocomplete'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

            					$comment_form['fields'][ $key ] = $field_html;
            				}

            				$account_page_url = wc_get_page_permalink( 'myaccount' );
            				if ( $account_page_url ) {
            					/* translators: %s opening and closing link tags respectively */
            					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'electron' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
            				}

            				if ( wc_review_ratings_enabled() ) {
            					$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'electron' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
            						<option value="">' . esc_html__( 'Rate&hellip;', 'electron' ) . '</option>
            						<option value="5">' . esc_html__( 'Perfect', 'electron' ) . '</option>
            						<option value="4">' . esc_html__( 'Good', 'electron' ) . '</option>
            						<option value="3">' . esc_html__( 'Average', 'electron' ) . '</option>
            						<option value="2">' . esc_html__( 'Not that bad', 'electron' ) . '</option>
            						<option value="1">' . esc_html__( 'Very poor', 'electron' ) . '</option>
            					</select></p>';
            				}

            				$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'electron' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

            				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'electron' ); ?></p>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
</div>
