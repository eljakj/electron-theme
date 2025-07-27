<?php
/**
 * The template for displaying post content card style within loops
 *
 * This template can be editing
 *
 */

$size = electron_loop_post_thumbnail_size();
$bg   = get_the_post_thumbnail_url( get_the_ID(), $size );
?>

<div id="post-<?php echo get_the_ID() ?>" <?php post_class( 'electron-blog-posts-item style-card' ); ?>>
    <div class="electron-blog-post-item-inner" data-background="<?php echo esc_url( $bg ); ?>">

        <?php electron_loop_post_first_category(); ?>

        <div class="electron-blog-post-content">
            <div class="electron-blog-post-meta electron-inline-two-block">
                <?php echo electron_loop_post_author('<h6 class="electron-post-author">','</h6>', true); ?>
                <?php echo electron_loop_post_date('<h6 class="electron-post-date">','</h6>', true); ?>
            </div>
            <?php electron_loop_post_title(); ?>
            <?php electron_loop_post_excerpt(); ?>
        </div>

    </div>
</div>
