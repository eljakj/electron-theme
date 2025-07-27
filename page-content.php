<div id="nt-page-container" class="nt-page-layout">

    <?php get_template_part( 'template-parts/page-hero' ); ?>

    <div id="nt-page" class="nt-electron-inner-container section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">

                    <?php while ( have_posts() ) : the_post(); ?>

                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="nt-electron-content nt-clearfix content-container">
                                <?php

                                /* translators: %s: Name of current post */
                                the_content( sprintf(
                                    esc_html__( 'Continue reading %s', 'electron' ),
                                    the_title( '<span class="screen-reader-text">', '</span>', false )
                                ) );

                                /* theme page link pagination */
                                electron_wp_link_pages();

                                ?>
                            </div>
                        </div>
                        <?php

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                            wp_enqueue_script( 'comment-reply' );
                            comments_template();
                        }

                    // End the loop.
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
