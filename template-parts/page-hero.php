<?php

$h_t = get_the_title();
$page_id = '';

wp_enqueue_style( 'electron-page-hero' );

if ( is_404() ) {

    $name = 'error';
    $h_t = esc_html__( 'Page Not Found', 'electron' );

} elseif ( is_archive() ) {

    $name = 'archive';
    $h_t = get_the_archive_title();

} elseif ( is_search() ) {

    $name = 'search';
    $h_t = esc_html__( 'Search results for :', 'electron' );

} elseif ( is_home() || is_front_page() ) {

    $name = 'blog';
    $h_t = esc_html__( 'Blog', 'electron' );

} elseif ( is_single() ) {

    $name = 'single';
    $h_t = get_the_title();

} elseif ( is_page() ) {

    $name = 'page';
    $h_t = get_the_title();
    $page_id = 'page-'.get_the_ID();
}

do_action( 'electron_before_page_hero' );

if ( '0' != electron_settings( $name.'_hero_visibility', '1' ) ) {
    ?>
    <div class="electron-page-hero <?php echo esc_attr( $page_id ); ?>">
        <div class="electron-page-hero-content container">
            <?php
            do_action( 'electron_before_page_title' );
            echo electron_breadcrumbs();

            if ( !is_single() ) {
                if ( $h_t ) {

                    printf( '<h2 class="nt-hero-title page-title">%s %s</h2>',
                        $h_t,
                        strlen( get_search_query() ) > 16 ? substr( get_search_query(), 0, 16 ).'...' : get_search_query()
                    );

                } else {

                    the_title('<h2 class="nt-hero-title page-title">', '</h2>');
                }
            }

            do_action( 'electron_after_page_title' );
            ?>
        </div>
    </div>
    <?php
}
do_action( 'electron_after_page_hero' );
