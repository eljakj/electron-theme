<?php


if ( ! function_exists('electron_loop_post_thumbnail')) {

    function electron_loop_post_thumbnail()
    {
        if ( has_post_thumbnail() ) {

            $size = electron_loop_post_thumbnail_size();
            printf( '<a class="blog-thumb-link" href="%s" title="%s">%s</a>',
                esc_url( get_permalink() ),
                the_title_attribute( 'echo=0' ),
                get_the_post_thumbnail( get_the_ID(), $size )
            );
        }
    }
}

if ( ! function_exists('electron_loop_post_thumbnail_size')) {

    function electron_loop_post_thumbnail_size()
    {
        $custom_size = electron_settings( 'post_custom_imgsize' );
        $custom_size = !empty( $custom_size['width'] ) ||  !empty( $custom_size['height'] ) ? [ $custom_size['width'], $custom_size['height'], true ] : '';
        $psize = $custom_size ? $custom_size : electron_settings( 'post_imgsize', 'full' );
        $size = is_single() && electron_settings( 'related_imgsize', '' ) ? electron_settings( 'related_imgsize', '' ) : $psize;

        return apply_filters( 'electron_blog_loop_image_size', $size );
    }
}


if ( ! function_exists( 'electron_loop_post_title' ) ) {

    function electron_loop_post_title()
    {
        if ( '0' != electron_settings( 'post_title_visibility', '1' ) ) {

            the_title( sprintf( '<h4 class="electron-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

        }
    }
}

if ( ! function_exists( 'electron_loop_post_first_category' ) ) {

    function electron_loop_post_first_category()
    {
        if ( has_category() && '0' != electron_settings( 'post_category_visibility', '0' ) ) {
            $category = get_the_category();
            printf( '<a class="electron-blog-post-category" href="%1$s" alt="%2$s"><span>%3$s</span></a>',
                esc_url( get_category_link( $category[0]->term_id ) ),
                esc_attr( sprintf( esc_html__( 'View all posts in %s', 'electron' ), $category[0]->name ) ),
                esc_html( $category[0]->name )
            );
        }
    }
}

if ( ! function_exists( 'electron_loop_post_excerpt' ) ) {

    function electron_loop_post_excerpt()
    {
        $limit   = is_single() && electron_settings( 'related_excerpt_limit', '9' ) ? electron_settings( 'related_excerpt_limit', '9' ) : electron_settings( 'post_excerpt_limit', '100' );
        $excerpt = is_single() ? electron_settings( 'related_excerpt_visibility', '1' ) : electron_settings( 'post_excerpt_visibility', '1' );

        if ( has_excerpt() && '1' == $excerpt ) {
            printf( '<p class="electron-post-excerpt">%s</p>', wp_trim_words( get_the_excerpt(), $limit ) );
        }
    }
}


if ( ! function_exists( 'electron_loop_post_tags' ) ) {

    function electron_loop_post_tags()
    {
        if ( has_tag() && '0' != electron_settings( 'post_tags_visibility', '1' ) ) {

            the_tags('<div class="tags">','','</div>');

        }
    }
}


if ( ! function_exists( 'electron_loop_post_content' ) ) {

    function electron_loop_post_content()
    {
        $limit   = is_single() ? electron_settings( 'related_excerpt_limit', '' ) : electron_settings( 'excerptsz', '' );
        $excerpt = is_single() ? electron_settings( 'related_excerpt_visibility', '1' ) : electron_settings( 'post_excerpt_visibility', '1' );

        if ( '0' != $excerpt ) {

            if ( has_excerpt() ) {
                if ( $limit ) {
                    echo wpautop( wp_trim_words( strip_tags( trim( get_the_excerpt() ) ), $limit ) );
                } else {
                    echo wpautop( get_the_excerpt() );
                }

            } else {

                echo wpautop( wp_trim_words( strip_tags( trim( get_the_content() ) ), $limit ) );

            }
        }

        electron_wp_link_pages();
    }
}


if ( ! function_exists( 'electron_loop_post_author' ) ) {

    function electron_loop_post_author($tagopen='',$tagclose='',$url=true)
    {
        if ( '0' != electron_settings( 'post_author_visibility', '1' ) ) {
            $author = get_the_author();
            $link   = $url == true ? '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" title="'.$author.'">'.$author.'</a>' : $author;

            return $tagopen && $tagclose ? $tagopen.$link.$tagclose : $link;
        }
    }
}


if ( ! function_exists( 'electron_loop_post_date' ) ) {

    function electron_loop_post_date($tagopen='',$tagclose='',$url=true)
    {
        if ( '0' != electron_settings( 'post_date_visibility', '1' ) ) {

            $date  = get_the_date();
            $year  = get_the_time( 'Y' );
            $month = get_the_time( 'm' );
            $day   = get_the_time( 'd' );
            $link  = $url == true ? '<a href="'.esc_url( get_day_link( $year, $month, $day ) ).'" title="'.$date.'">'.$date.'</a>' : $date;

            return $tagopen && $tagclose ? $tagopen.$link.$tagclose : $link;
        }
    }
}


if ( ! function_exists( 'electron_loop_post_comment_number' ) ) {

    function electron_loop_post_comment_number()
    {
        if ( comments_open() && '0' != get_comments_number() && '0' != electron_settings( 'post_comments_visibility', '1' ) ) {
            printf( '<a href="%s" title="%s">%s</a>',
                get_comments_link( get_the_ID() ),
                get_the_title(),
                _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'electron' ),
                number_format_i18n( get_comments_number() )
            );
        }
    }
}

if ( ! function_exists( 'electron_loop_post_button' ) ) {

    function electron_loop_post_button( $icon='' )
    {
        if ( '0' != electron_settings( 'post_button_visibility', '1' ) ) {

            $button_title = electron_settings( 'post_button_title' ) ? esc_html( electron_settings( 'post_button_title' ) ) : esc_html__( 'Read More', 'electron' );
            printf( '<a class="read-more" href="%s" title="%s">%s %s</a>',
                get_permalink(),
                the_title_attribute( 'echo=0' ),
                $button_title,
                $icon ? $icon : ''
            );

        }
    }
}


if ( ! function_exists('electron_sticky_post') ) {

    function electron_sticky_post()
    {
        if ( is_sticky() ) {
            ?>
            <div class="nt-sticky-label"><i class="fa fa-thumb-tack" aria-hidden="true"></i>Sticky</div>
            <?php
        }
    }
}
