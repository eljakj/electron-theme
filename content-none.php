<div class="col-lg-6 col-12 electron_content_none">
    <div class="content-none-container">
        <h3 class="__title mb-20"><?php esc_html_e( 'Nothing Found', 'electron' ); ?></h3>
        <?php
            if ( is_home() && current_user_can( 'publish_posts' ) ) {
                printf( '<p>%s</p> <a class="thm-btn" href="%s">%s</a>',
                esc_html__( 'Ready to publish your first post?', 'electron' ),
                esc_url( admin_url( 'post-new.php' ) ),
                esc_html__( 'Get started here', 'electron' ));
            } elseif ( is_search() ) {
                ?>
                <h5 class="__nothing"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'electron' ); ?></h5>
                <?php
                printf( '<a href="%1$s" class="electron-btn-medium electron-btn electron-btn-primary"><span>%2$s</span></a>',
                esc_url( home_url('/') ),
                esc_html__( 'Go to home page', 'electron' ));
            } else {
                ?>
                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'electron' ); ?></p>
                <?php
                printf( '<a href="%1$s" class="electron-btn-medium electron-btn electron-btn-primary"><span>%2$s</span></a>',esc_url( home_url('/') ),esc_html__( 'Go to home page', 'electron' ));
            }
        ?>
    </div>
</div>
