<?php
/**
* The template for displaying post content card style within loops
*
* This template can be editing
*
*/
$grid_column = apply_filters('electron_blog_grid_column', electron_settings( 'grid_column', '1' ) );
$size =  $grid_column == 1 ? electron_loop_post_thumbnail_size() : [250,250];
?>

<div id="post-<?php echo get_the_ID() ?>" <?php post_class( 'electron-blog-posts-item style-split' ); ?>>
    <div class="electron-blog-post-item-inner">

        <div class="electron-blog-post-thumb-wrapper">
            <div class="electron-blog-post-thumb">
                <?php echo get_the_post_thumbnail( get_the_ID(), electron_loop_post_thumbnail_size() ); ?>
                <a class="blog-thumb-link" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo get_the_title(); ?>"></a>
            </div>
            <?php electron_loop_post_first_category(); ?>
        </div>

        <div class="electron-blog-post-content">
            <?php electron_loop_post_title(); ?>
            <?php electron_loop_post_excerpt(); ?>

            <div class="electron-blog-post-meta electron-inline-two-block">
                <?php echo electron_loop_post_author('<h6 class="electron-post-author">','</h6>', true); ?>
                <?php echo electron_loop_post_date('<h6 class="electron-post-date">','</span>', true); ?>
            </div>
        </div>

    </div>
</div>
