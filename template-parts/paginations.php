<?php


/**
 * Custom paginations for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package electron
*/


/*************************************************
##  next post css class
*************************************************/

if ( ! function_exists( 'electron_posts_prev_pag_attrs' ) ) {
    function electron_posts_next_pag_attrs()
    {
        return 'class="nt-pagination-link -next"';
    }
    add_filter( 'next_posts_link_attributes', 'electron_posts_next_pag_attrs' );
}


/*************************************************
##  prev post css class
*************************************************/

if ( ! function_exists( 'electron_posts_prev_pag_attrs' ) ) {
    function electron_posts_prev_pag_attrs()
    {
        return 'class="nt-pagination-link -previous"';
    }
    add_filter( 'previous_posts_link_attributes', 'electron_posts_prev_pag_attrs' );
}


/*************************************************
##  SINLGE POST/CPT NAVIGATION - Display navigation to next/previous post when applicable.
*************************************************/

if ( ! function_exists( 'electron_single_navigation' ) ) {
    function electron_single_navigation()
    {
        if ( '0' != electron_settings( 'single_navigation_visibility', '1' ) ) {

            // Don't print empty markup if there's nowhere to navigate.
            $prev = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
            $next  = get_adjacent_post( false, '', false );

            if ( ! $next && ! $prev ) {
                return;
            }

            $blog = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );

            ?>
            <div class="pagination electron-bg">
                <?php
                if ( $prev ) {
                    previous_post_link( '%link', _x('PREVIOUS POST', 'Previous post link', 'electron' ) );
                } else {
                    echo '<a class="empty"></a>';
                }
                ?>
                <a class="icon" href="<?php echo esc_url( $blog ); ?>"><i class="fas fa-th-large"></i></a>
                <?php
                if ( $next ) {
                    next_post_link( '%link', _x('NEXT POST', 'Next post link', 'electron' ) );
                } else {
                    echo '<a class="empty"></a>';
                }
                ?>
            </div>
            <?php
        }
    }
}



/*************************************************
## POST PAGINATION - Display post navigation to next/previous post when applicable.
*************************************************/

if ( ! function_exists( 'electron_index_loop_pagination' ) ) {
    function electron_index_loop_pagination( $row = false )
    {
        if ( have_posts() && '0' !=  electron_settings( 'pagination_visibility', '1' ) ) {
            $pag_class= array();
            $pag_class[] = ('yes' == electron_settings( 'pag_group') ) ? '-group' : '';
            $pag_class[] = '-style-'.electron_settings( 'pag_type', 'default' );
            $pag_class[] = '-size-'.electron_settings( 'pag_size', 'medium' );
            $pag_class[] = '-corner-'.electron_settings( 'pag_corner', 'square' );
            $pag_class[] = '-align-'.electron_settings( 'pag_align', 'center' );
            $pag_class = implode( ' ', $pag_class );

            $prev = get_previous_posts_link( '<i class="nt-pagination-icon nt-icon-left-arrow-chevron" aria-hidden="true"></i>' );
            $next = get_next_posts_link( '<i class="nt-pagination-icon nt-icon-right-arrow-chevron" aria-hidden="true"></i>' );

            if ( is_singular() ) {
                return;
            }

            global $wp_query;

            /** Stop execution if there's only 1 page */
            if ( $wp_query->max_num_pages <= 1 ) {
                return;
            }

            $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
            $max = intval( $wp_query->max_num_pages );

            /** Add current page to the array */
            if ($paged >= 1) {
                $links[] = $paged;
            }

            /** Add the pages around the current page to the array */
            if ( $paged >= 3 ) {
                $links[] = $paged - 1;
                $links[] = $paged - 2;
            }

            if ( ( $paged + 2 ) <= $max) {
                $links[] = $paged + 2;
                $links[] = $paged + 1;
            }
            if ( $row == true ) {
                echo '<div class="row">';
            }
            echo '<div class="col-12 nt-pagination mt-60"><ul class="nt-pagination-inner">';

            /** Previous Post Link */
            if ( get_previous_posts_link() ) {
                printf('<li class="nt-pagination-item">%s</li>',$prev );
            }

            /** Link to first page, plus ellipses if necessary */
            if ( ! in_array( 1, $links ) ) {
                $class = 1 == $paged ? ' active' : '';

                printf('<li class="nt-pagination-item%s" ><a class="nt-pagination-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link(1) ), '1' );

                if ( ! in_array( 2, $links ) ) {
                    echo '<li class="nt-pagination-item">…</li>';
                }
            }

            /** Link to current page, plus 2 pages in either direction if necessary */
            sort( $links );
            foreach ( (array) $links as $link ) {
                $class = $paged == $link ? ' active' : '';
                printf('<li class="nt-pagination-item%s" ><a class="nt-pagination-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
            }

            /** Link to last page, plus ellipses if necessary */
            if ( ! in_array( $max, $links ) ) {
                if ( ! in_array( $max - 1, $links ) ) {
                    echo '<li class="nt-pagination-item">…</li>' . "\n";
                }

                $class = $paged == $max ? ' active' : '';
                printf('<li class="nt-pagination-item%s" ><a class="nt-pagination-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
            }

            /** Next Post Link */
            if ( get_next_posts_link() ) {
                printf('<li class="nt-pagination-item">%s</li>',$next);
            }

            echo '</ul></div>';

            if ( $row == true ) {
                echo '</div>';
            }
        }
    }
}


/*************************************************
##  LINK PAGES CURRENT CLASS
*************************************************/

if ( ! function_exists( 'electron_current_link_pages' ) ) {
    function electron_current_link_pages( $link )
    {
        if ( ctype_digit( $link ) ) {
            return '<span class="current">' . $link . '</span>';
        }

        return $link;
    }
    add_filter( 'wp_link_pages_link', 'electron_current_link_pages' );
}


/*************************************************
##  LINK PAGES
*************************************************/

if ( ! function_exists( 'electron_wp_link_pages' ) ) {
    function electron_wp_link_pages()
    {
        // pagination for page links
        wp_link_pages( array(
            'before' => '<div class="clearfix"></div><div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'electron' ) . '</span>',
            'after' => '</div>',
            'link_before' => '',
            'link_after' => '',
            'next_or_number' => 'number',
            'separator' => ' ',
            'nextpagelink' => esc_html__( 'Next page', 'electron' ),
            'previouspagelink' => esc_html__( 'Previous page', 'electron' ),
            'pagelink' => '%',
            'echo' => 1
        ));
    }
}
