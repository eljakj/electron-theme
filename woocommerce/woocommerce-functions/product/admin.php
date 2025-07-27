<?php

/*
* Tab
*/
if ( ! function_exists( 'electron_product_settings_tabs' ) ) {
    add_filter('woocommerce_product_data_tabs', 'electron_product_settings_tabs' );
    function electron_product_settings_tabs( $tabs ){
        $tabs['electron_general'] = array(
            'label'    => esc_html__('Electron General', 'electron'),
            'target'   => 'electron_product_general_data',
            'priority' => 100
        );
        $tabs['electron_product_page'] = array(
            'label'    => esc_html__('Electron Product Page', 'electron'),
            'target'   => 'electron_product_page_data',
            'priority' => 101
        );
        return $tabs;
    }
}

/**
*  add custom color field to for product badge
*/
if ( ! function_exists( 'electron_wc_product_meta_color' ) ) {
    function electron_wc_product_meta_color( $field )
    {
        global $thepostid, $post;

        $thepostid      = empty( $thepostid ) ? $post->ID : $thepostid;
        $field['class'] = isset( $field['class'] ) ? $field['class'] : 'electron-color-field';
        $field['value'] = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );

        echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>
        <input type="text" class="electron-color-field" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" /></p>';
    }
}


/*
* Tab content
*/
if ( ! function_exists( 'electron_product_panels' ) ) {
    add_action( 'woocommerce_product_data_panels', 'electron_product_panels' );
    function electron_product_panels(){

        $args = [
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1
        ];

        $templates = get_posts( $args );
        $options   = array('' => esc_html__('None', 'electron'));

        if ( !empty( $templates ) && !is_wp_error( $templates ) ) {
            foreach ( $templates as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        } else {
            $options = array(
                '' => esc_html__( 'No template exist.', 'electron' )
            );
        }

        echo '<div id="electron_product_general_data" class="panel woocommerce_options_panel hidden">';
            echo '<h3 class="electron-panel-heading">'.esc_html__('Electron Product General Settings', 'electron').'</h3>';
            woocommerce_wp_checkbox(
                array(
                    'id' => 'electron_product_discount',
                    'label' => esc_html__( 'Hide Product Discount?', 'electron' ),
                    'wrapper_class' => 'hide_if_variable',
                    'desc_tip' => false,
                )
            );
            woocommerce_wp_checkbox(
                array(
                    'id' => 'electron_product_hide_stock',
                    'label' => esc_html__( 'Hide Product Stock Label?', 'electron' ),
                    'wrapper_class' => 'hide_if_variable',
                    'desc_tip' => false,
                )
            );
            echo '<div class="electron-panel-divider"></div>';
            echo '<h4 class="electron-panel-subheading">'.esc_html__('Extra Features Settings', 'electron').'</h4>';
            woocommerce_wp_textarea_input(
                array(
                    'id' => 'electron_product_extra_fatures',
                    'label' => esc_html__( 'Extra Features', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( '!Important note: One feature per line.', 'electron' ),
                    'rows' => 3
                )
            );
            echo '<div class="electron-panel-divider"></div>';
            echo '<h4 class="electron-panel-subheading">'.esc_html__('Badge Settings', 'electron').'</h4>';
            woocommerce_wp_text_input(
                array(
                    'id' => 'electron_custom_badge',
                    'label' => esc_html__( 'Badge Label', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( 'Add your custom badge label here', 'electron' ),
                )
            );
            electron_wc_product_meta_color(
                array(
                    'id' => 'electron_badge_color',
                    'label' => esc_html__( 'Badge Color', 'electron' ),
                )
            );

            echo '<div class="electron-panel-divider"></div>';
            echo '<h4 class="electron-panel-subheading">'.esc_html__('Countdown Settings', 'electron').'</h4>';
            woocommerce_wp_checkbox(
                array(
                    'id' => 'electron_product_hide_countdown',
                    'label' => esc_html__( 'Hide Product Countdown?', 'electron' ),
                    'wrapper_class' => 'hide_if_variable',
                    'desc_tip' => false,
                )
            );
            woocommerce_wp_text_input(
                array(
                    'id' => 'electron_countdown_text',
                    'label' => esc_html__( 'Countdown Text', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( 'Add your custom text here', 'electron' ),
                )
            );
        echo '</div>';

        echo '<div id="electron_product_page_data" class="panel woocommerce_options_panel hidden">';
            echo '<h3 class="electron-panel-heading">'.esc_html__('Electron Product Page Settings', 'electron').'</h3>';
            echo '<h4 class="electron-panel-subheading">'.esc_html__('Product Summary Settings', 'electron').'</h4>';
            woocommerce_wp_select(
                array(
                    'id' => 'electron_product_size_guide',
                    'label' => esc_html__( 'Size Guide ( Elementor Template )', 'electron' ),
                    'options' => $options,
                    'desc_tip' => true,
                    'description' => esc_html__( 'Please select size guide elementor template for this product.', 'electron' )
                )
            );
            woocommerce_wp_select(
                array(
                    'id' => 'electron_product_delivery_return',
                    'label' => esc_html__( 'Delivery & Return ( Elementor Template )', 'electron' ),
                    'options' => $options,
                    'desc_tip' => true,
                    'description' => esc_html__( 'Please select delivery-return elementor template for this product.', 'electron' )
                )
            );
            woocommerce_wp_text_input(
                array(
                    'id' => 'electron_product_estimated_delivery',
                    'label' => esc_html__( 'Estimated Delivery Text', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( 'Add your custom estimated delivery text here', 'electron' )
                )
            );
            echo '<div class="electron-panel-divider"></div>';
            echo '<h4 class="electron-panel-subheading">'.esc_html__('Product Gallery Video Settings', 'electron').'</h4>';
            woocommerce_wp_select(
                array(
                    'id' => 'electron_product_video_type',
                    'label' => esc_html__( 'Product Video Type?', 'electron' ),
                    'options' => array(
                        '' => 'Select a type',
                        'popup' => esc_html__( 'Popup', 'electron' ),
                        'gallery' => esc_html__( 'Gallery Item', 'electron' ),
                    ),
                    'desc_tip' => false
                )
            );
            woocommerce_wp_text_input(
                array(
                    'id' => 'electron_product_popup_video',
                    'label' => esc_html__( 'Popup Video URL', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( 'Add your youtube,vimeo,hosted video URL here', 'electron' )
                )
            );
            woocommerce_wp_text_input(
                array(
                    'id' => 'electron_product_iframe_video',
                    'label' => esc_html__( 'Youtube video ID', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( 'Add your youtube video ID here for background autoplay video.', 'electron' ),
                    'rows' => 4
                )
            );
            echo '<div class="electron-panel-divider"></div>';
            echo '<h4 class="electron-panel-subheading">'.esc_html__('Product Extra Tabs Settings', 'electron').'</h4>';
            woocommerce_wp_textarea_input(
                array(
                    'id' => 'electron_tabs_title',
                    'label' => esc_html__( 'Extra Tabs Title', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( '!Important note: One title per line.', 'electron' ),
                    'rows' => 3
                )
            );
            woocommerce_wp_textarea_input(
                array(
                    'id' => 'electron_tabs_content',
                    'label' => esc_html__( 'Extra Tabs Content', 'electron' ),
                    'desc_tip' => true,
                    'description' => esc_html__( '!Important note: One content per line.Iframe,shortcode,HTML content allowed.', 'electron' ),
                    'rows' => 4
                )
            );
        echo '</div>';
    }
}

/**
*  Save Custom Field
*/
if ( ! function_exists( 'electron_save_product_custom_field' ) ) {
    add_action( 'woocommerce_process_product_meta', 'electron_save_product_custom_field' );
    function electron_save_product_custom_field( $_post_id )
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }
        $options = array(
            'electron_badge_color',
            'electron_custom_badge',
            'electron_product_discount',
            'electron_product_size_guide',
            'electron_product_delivery_return',
            'electron_product_estimated_delivery',
            'electron_product_hide_stock',
            'electron_product_extra_fatures',
            'electron_product_hide_countdown',
            'electron_countdown_text',
            'electron_product_video_type',
            'electron_product_popup_video',
            'electron_product_iframe_video',
            'electron_tabs_title',
            'electron_tabs_content'
        );
        foreach ( $options as $option ) {
            if ( isset( $_POST[$option] ) ) {
                update_post_meta( $_post_id, $option, $_POST[$option] );
            } else {
                delete_post_meta( $_post_id, $option );
            }
        }
    }
}


// Variable product gallery
add_action( 'woocommerce_product_after_variable_attributes', 'electron_variation_settings_fields', 10, 3 );
if ( !function_exists('electron_variation_settings_fields') ) {
    function electron_variation_settings_fields($loop, $variation_data, $variation) {
        $images = get_post_meta( $variation->ID, '_electron_variation_gallery', true );
        echo "<div class=\"options_group electron-variation-gallery\">
        <label>Additional images</label>";
        woocommerce_wp_hidden_input(
            array(
                'id'    => '_electron_variation_gallery[' . $variation->ID . ']',
                'name'  => '_electron_variation_gallery[' . $variation->ID . ']',
                'value' => $images
            )
        );
        echo"<ul class=\"electron-variation-gallery-images\">";
        if ($images) {
            $images = explode(';', $images);
            foreach ($images as $image) {
                if (!empty($image)) {
                    $src = wp_get_attachment_image_src($image, 'thumbnail');
                    echo"<li data-id=\"{$image}\"><img src=\"{$src[0]}\"></li>";
                }
            }
        }
        echo"</ul>";
        echo"<a href=\"#\" class=\"button-primary electron-variation-gallery-add-button\">".__('Add Variation Images', 'electron')."</a></div>";
    }
}

add_action( 'woocommerce_save_product_variation', 'electron_variation_save_variation_fields', 10, 2 );
if ( !function_exists('electron_variation_save_variation_fields') ) {
    function electron_variation_save_variation_fields($variation_id, $i) {
        $variation_input = $_POST['_electron_variation_gallery'][ $variation_id ];
        update_post_meta( $variation_id, '_electron_variation_gallery', sanitize_text_field( $variation_input ) );
    }
}
