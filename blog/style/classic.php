<?php
/**
 * The template for displaying post content default style within loops
 *
 * This template can be editing
 *
 */

$post_style = electron_settings( 'post_style', 'classic' );
?>

<div id="post-<?php echo get_the_ID() ?>" <?php post_class( 'electron-blog-posts-item style-'.$post_style ); ?>>
    <div class="electron-blog-post-item-inner">

        <?php if ( is_sticky() ) { ?>
            <span class="blog-sticky"><?php esc_html_e( 'Featured', 'electron' ); ?></span>
        <?php } ?>

        <?php if ( has_post_thumbnail() ) { ?>
            <div class="electron-blog-thumb image-<?php echo apply_filters('electron_post_image_size_style', electron_settings( 'post_image_style', 'default' ) ); ?>">
                <?php electron_loop_post_thumbnail(); ?>
                <?php electron_loop_post_first_category(); ?>
            </div>
        <?php } ?>

        <div class="electron-blog-post-content">
            <div class="electron-blog-post-meta">
                <?php echo electron_loop_post_author('<h6 class="electron-post-meta-title">','</h6>', true); ?>
                <?php echo electron_loop_post_date('<span class="electron-post-meta-date">','</span>', true); ?>
            </div>
            <?php
                electron_loop_post_title();
                electron_loop_post_excerpt();
            ?>
            <?php if ( ! get_the_title() ) { ?>
                <a class="blog-read-more-link" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo get_the_title(); ?>"><?php esc_html_e( 'Read More', 'electron' ); ?></a>
            <?php } ?>
        </div>

    </div>
</div>
