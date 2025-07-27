<?php
/**
* The main template file
*
*/

if ( is_search() ) {
    $name           = 'search';
    $sidebar        = 'electron-search-sidebar';
    $default_layout = 'full-width';
} elseif ( is_archive() ) {
    $name           = 'archive';
    $sidebar        = 'electron-archive-sidebar';
    $default_layout = 'full-width';
} else {
    $name           = 'index';
    $sidebar        = 'sidebar-1';
    $default_layout = 'right-sidebar';
}

$electron_layout       = apply_filters('electron_index_layout', electron_settings( $name.'_layout', $default_layout ) );
$grid_column        = apply_filters('electron_blog_grid_column', electron_settings( 'grid_column', '3' ) );
$grid_mobile_column = apply_filters('electron_blog_grid_mobile_column', electron_settings( 'grid_mobile_column', '2' ) );

$masonry       = apply_filters('electron_index_type', electron_settings( 'index_type', 'masonry' ) );
$is_masonry    = 'masonry' == apply_filters('electron_index_type', electron_settings( 'index_type', 'masonry' ) ) ? ' electron-masonry-container' : '';
$has_sidebar   = ! empty( electron_settings( 'blog_sidebar_templates', null ) ) || is_active_sidebar( $sidebar ) ? true : false;
$layout_column = !$has_sidebar || 'full-width' == $electron_layout ? 'col-lg-12' : 'col-lg-9';
$row_reverse   = (! empty( electron_settings( 'blog_sidebar_templates', null ) ) || is_active_sidebar( $sidebar ) ) && 'left-sidebar' == $electron_layout ? ' flex-lg-row-reverse' : '';
$post_style    = apply_filters('electron_blog_post_style', electron_settings( 'post_style', 'classic' ) );

if ( 'masonry' == $masonry ) {
    wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script( 'masonry' );
}
wp_enqueue_style( 'electron-blog-post' );

?>
<div class="blog-area section-padding electron-blog-<?php echo esc_attr( $post_style  ); ?>">
    <div class="container">
        <div class="row justify-content-lg-center<?php echo esc_attr( $row_reverse ); ?>">

            <div class="<?php echo esc_attr( $layout_column ); ?>">
                <div class="row row-cols-sm-<?php echo esc_attr( $grid_mobile_column ); ?> row-cols-lg-<?php echo esc_attr( $grid_column.$is_masonry ); ?> electron-posts-row">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            get_template_part( 'blog/style/'.$post_style );
                        }
                    } else {
                        // if there are no posts, read content none function
                        get_template_part('content', 'none');
                    }
                    ?>
                </div>
                <?php
                // this function working with wp reading settins + posts
                electron_index_loop_pagination(true);
                ?>
            </div>

            <?php
            if ( $has_sidebar && ( 'right-sidebar' == $electron_layout || 'left-sidebar' == $electron_layout ) ) {
                get_sidebar();
            }
            ?>
        </div>
    </div>
</div>
