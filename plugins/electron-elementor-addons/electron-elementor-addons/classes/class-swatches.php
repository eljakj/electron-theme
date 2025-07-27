<?php
/**
* Electron_Swatches
*/
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
if ( ! class_exists( 'Electron_Swatches' ) && class_exists( 'WC_Product' ) ) {
    class Electron_Swatches {
        function __construct()
        {
            add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ), 99999999 );
            add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ) );

            add_shortcode( 'electron_swatches', array( $this, 'archive_shortcode' ) );
            // add field for attributes
            add_filter( 'product_attributes_type_selector', array( $this, 'type_selector' ) );

            $attrs = wc_get_attribute_taxonomies();

            foreach ( $attrs as $attr ) {
                $name = $attr->attribute_name;
                add_action( 'pa_' . $name . '_add_form_fields', array($this,'show_field') );
                add_action( 'pa_' . $name . '_edit_form_fields', array( $this,'show_field') );
                add_action( 'create_pa_' . $name, array($this,'save_field') );
                add_action( 'edited_pa_' . $name, array( $this, 'save_field' ) );
                add_filter( "manage_edit-pa_{$name}_columns", array($this,'custom_columns') );
                add_filter( "manage_pa_{$name}_custom_column", array($this,'custom_columns_content'), 10, 3 );
            }

            add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array($this,'variation_attribute_options_html'), 199, 2 );

            // ajax add to cart
            add_action( 'wp_ajax_electron_shop_swatches_add_to_cart', array( $this, 'add_to_cart' ) );
            add_action( 'wp_ajax_nopriv_electron_shop_swatches_add_to_cart', array( $this, 'add_to_cart' ) );
        }

        public function frontend_scripts()
        {
            wp_enqueue_script( 'wc-add-to-cart-variation' );
            wp_enqueue_script( 'electron-swatches', ELECTRON_PLUGIN_URL . 'assets/front/js/swatches/swatches.js', array( 'jquery' ), ELECTRON_PLUGIN_VERSION, true );
        }

        public function backend_scripts()
        {
            wp_enqueue_script( 'electron-backend', ELECTRON_PLUGIN_URL . 'assets/front/js/swatches/backend.js', array('jquery','wp-color-picker'), ELECTRON_PLUGIN_VERSION, true );
            wp_localize_script( 'electron-backend', 'electron_swatches_vars', array('placeholder_img' => wc_placeholder_img_src()) );
        }

        public function archive_shortcode( $atts )
        {
            $atts = shortcode_atts( array(
                'id' => null,
            ), $atts, 'electron_swatches' );

            ob_start();
            $this->archive_swatches( $atts['id'] );
            return ob_get_clean();
        }

        public function add_to_cart()
        {
            $product_id   = intval($_POST['product_id']);
            $variation_id = intval($_POST['variation_id']);
            $quantity     = (float) $_POST['quantity'];
            $variation    = (array) json_decode( stripslashes( $_POST['attributes'] ) );

            $cart_item_data = array(
                'variation_id' => $variation_id,
                'attributes'   => $variation
            );
            if ( $product_id && $variation_id ) {

                $item_key = WC()->cart->add_to_cart( $product_id, $quantity,$variation_id, $variation );

				$data = [
					'qty'       => $quantity,
					'variation' => $variation,
					'title'     => get_the_title($product_id)
				];

                if ( ! empty( $item_key ) ) {
                    electron_cart_fragments('add',$data);
                }

            } else {
				$data = [
					'error'       => true,
					'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
				];

				wp_send_json( $data );
            }
            die();
        }

        public function type_selector( $types )
        {
            global $pagenow;

            if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( $pagenow === 'post-new.php' ) || ( $pagenow === 'post.php' )  ) {
                return $types;
            } else {
                $types['color']  = esc_html__( 'Color', 'electron' );
                $types['image']  = esc_html__( 'Image', 'electron' );
                $types['button']  = esc_html__( 'Button', 'electron' );

                return $types;
            }
        }

        public function show_field( $term_or_tax )
        {
            if ( is_object( $term_or_tax ) ) {
                // is term
                $term_id    = $term_or_tax->term_id;
                $attr_id    = wc_attribute_taxonomy_id_by_name( $term_or_tax->taxonomy );
                $attr_info  = wc_get_attribute( $attr_id );
                $html_start = '<tr class="form-field"><th><label>';
                $html_mid   = '</label></th><td>';
                $html_end   = '</td></tr>';
            } else {
                // is taxonomy
                $term_id    = 0;
                $attr_id    = wc_attribute_taxonomy_id_by_name( $term_or_tax );
                $attr_info  = wc_get_attribute( $attr_id );
                $html_start = '<div class="form-field"><label>';
                $html_mid   = '</label>';
                $html_end   = '</div>';
            }
            $type = $attr_info->type;

            $tooltip = get_term_meta( $term_id, 'electron_swatches_tooltip', true );
            $value   = get_term_meta( $term_id, 'electron_swatches_'.$type, true );

            if ( $type == 'color' ) {
                echo $html_start . esc_html__( 'Color', 'electron' ) . $html_mid . '<input class="electron_swatches_color" id="electron_swatches_color" name="electron_swatches_color" value="' . esc_attr( $value ) . '" type="text"/>' . $html_end;
                echo $html_start . esc_html__( 'Tooltip', 'electron' ) . $html_mid . '<input id="electron_swatches_tooltip" name="electron_swatches_tooltip" value="' . esc_attr( $tooltip ) . '" type="text"/>' . $html_end;
            }
            if ( $type == 'image' ) {
                wp_enqueue_media();
                $image = $value ? wp_get_attachment_thumb_url( $value ) : wc_placeholder_img_src();

                echo $html_start . 'Image' . $html_mid; ?>
                    <div id="electron_swatches_image_thumbnail">
                        <img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px"/>
                    </div>
                    <div id="electron_swatches_image_wrapper">
                        <input type="hidden" id="electron_swatches_image" name="electron_swatches_image" value="<?php echo esc_attr( $value ); ?>"/>
                        <button id="electron_swatches_upload_image" type="button" class="electron_swatches_upload_image button"><?php esc_html_e( 'Upload/Add image', 'electron' ); ?></button>
                        <button id="electron_swatches_remove_image" type="button" class="electron_swatches_remove_image button"><?php esc_html_e( 'Remove image', 'electron' ); ?></button>
                    </div>
                <?php
                echo $html_end;
                echo $html_start . 'Tooltip' . $html_mid . '<input id="electron_swatches_tooltip" name="electron_swatches_tooltip" value="' . esc_attr( $tooltip ) . '" type="text"/>' . $html_end;
            }

            if ( $type == 'button' ) {
                echo $html_start . esc_html__( 'Label', 'electron' ) . $html_mid . '<input id="electron_swatches_button" name="electron_swatches_button" value="' . esc_attr( $value ) . '" type="text"/>' . $html_end;
                echo $html_start . esc_html__( 'Tooltip', 'electron' ) . $html_mid . '<input id="electron_swatches_tooltip" name="electron_swatches_tooltip" value="' . esc_attr( $tooltip ) . '" type="text"/>' . $html_end;
            }
        }

        public function save_field( $term_id )
        {
            $terms = [
                'electron_swatches_color',
                'electron_swatches_image',
                'electron_swatches_button',
                'electron_swatches_tooltip'
            ];
            foreach ( $terms as $term ) {
                if ( isset( $_POST[$term] ) ) {
                    update_term_meta( $term_id, $term, sanitize_text_field( $_POST[$term] ) );
                }
            }
        }

        public function variation_attribute_options_html( $html, $args )
        {
            $ot        = get_option('electron');
            $shape     = isset($ot['variations_terms_shape']) ? $ot['variations_terms_shape'] : 'square';
            $hints     = isset($ot['variations_terms_hints_visibility']) ? $ot['variations_terms_hints_visibility'] : '0';
            $bordered  = isset($ot['product_attr_type_bordered']) ? $ot['product_attr_type_bordered'] : '0';
            $checkedi  = isset($ot['variations_terms_checked_closed_icon_visibility']) ? $ot['variations_terms_checked_closed_icon_visibility'] : '0';
            $term_html = '';
            $attr_id   = wc_attribute_taxonomy_id_by_name( $args['attribute'] );

            $options   = $args['options'];
            $product   = $args['product'];
            $attribute = $args['attribute'];

            if ( $attr_id ) {
                $attr_info    = wc_get_attribute( $attr_id );
                $curr['type'] = isset( $attr_info->type ) ? $attr_info->type : '';
                $curr['slug'] = isset( $attr_info->slug ) ? $attr_info->slug : '';
                $curr['name'] = isset( $attr_info->name ) ? $attr_info->name : '';

                $class  = 'electron-type-'.esc_attr( $curr['type'] );
                $class .= '1' == $bordered ? ' terms-outline' : '';
                $class .= 'radius' == $shape ? ' terms-radius' : '';
                $class .= '0' == $checkedi ? ' hide-icon' : '';

                if ( $curr['type'] == 'color' || $curr['type'] == 'image' || $curr['type'] == 'button' ) {
                    $term_html .= '<div class="electron-terms '.$class.'" data-attribute="'.esc_attr( $args['attribute'] ).'"  data-attr-id="'.esc_attr( $attr_id ).'">';
                    if ( $product && taxonomy_exists( $attribute ) ) {

                        $terms = wc_get_product_terms($product->get_id(),$attribute,array('fields' => 'all') );
                        foreach ( $terms as $term ) {
                            if ( in_array( $term->slug, $options, true ) ) {
                                $tooltip = get_term_meta( $term->term_id, 'electron_swatches_tooltip', true ) ? : $term->name;
                                $color   = get_term_meta( $term->term_id, 'electron_swatches_color', true ) ? : '';
                                $image   = get_term_meta( $term->term_id, 'electron_swatches_image', true ) ? : '';
                                $img     = $image ? wp_get_attachment_thumb_url( $image ) : wc_placeholder_img_src();
                                $style   = ! empty( $color ) ? ' style="background-color:' . esc_attr( $color ) . '"' : '';
                                $hint    = '1' == $hints ? '<span class="electron-hint">'.esc_html( $tooltip ).'</span>' : '';

                                if ( $curr['type'] == 'color' ) {
                                    $term_html .= '<span class="electron-term" data-title="'.esc_attr( $tooltip ).'" data-term="'.esc_attr( $term->slug ).'" data-term-id="'.esc_attr( $term->term_id ).'"><span class="type-color"'.$style.'></span>'.$hint.'</span>';
                                }
                                if ( $curr['type'] == 'button' ) {
                                    $term_html .= '<span class="electron-term" data-title="'.esc_attr( $tooltip ).'" data-term="'.esc_attr( $term->slug ).'" data-term-id="'.esc_attr( $term->term_id ).'"><span class="type-button">'.esc_html( $term->name ).'</span>'.$hint.'</span>';
                                }
                                if ( $curr['type'] == 'image' ) {
                                    $term_html .= '<span class="electron-term" data-title="'.esc_attr( $tooltip ).'" data-term="'.esc_attr( $term->slug ).'" data-term-id="'.esc_attr( $term->term_id ).'"><img src="'.esc_url( $img ).'" alt="'.esc_attr( $term->name ).'"/>'.$hint.'</span>';
                                }
                            }
                        }
                    }
                    $term_html .= '</div>';
                }
            }
            return $term_html . $html;
        }

        public function archive_variation_attribute_options_html( $args )
        {
            $html = '';
            $ot        = get_option('electron');
            $shape     = isset($ot['variations_terms_shape']) ? $ot['variations_terms_shape'] : 'square';
            $hints     = isset($ot['variations_terms_hints_visibility']) ? $ot['variations_terms_hints_visibility'] : '0';
            $bordered  = isset($ot['product_attr_type_bordered']) ? $ot['product_attr_type_bordered'] : '0';
            $checkedi  = isset($ot['variations_terms_checked_closed_icon_visibility']) ? $ot['variations_terms_checked_closed_icon_visibility'] : '0';
            $attr_id   = wc_attribute_taxonomy_id_by_name( $args['attribute'] );

            $options   = $args['options'];
            $product   = $args['product'];
            $attribute = $args['attribute'];
            $selected  = $args['selected'] == 'selected' ? ' electron-selectedd' : '';

            if ( $attr_id ) {
                $attr_info    = wc_get_attribute( $attr_id );
                $curr['type'] = isset( $attr_info->type ) ? $attr_info->type : '';
                $curr['slug'] = isset( $attr_info->slug ) ? $attr_info->slug : '';
                $curr['name'] = isset( $attr_info->name ) ? $attr_info->name : '';

                $class  = 'electron-type-'.esc_attr( $curr['type'] );
                $class .= '1' == $bordered ? ' terms-outline' : '';
                $class .= 'radius' == $shape ? ' terms-radius' : '';
                $class .= '0' == $checkedi ? ' hide-icon' : '';

                if ( $curr['type'] == 'color' || $curr['type'] == 'image' || $curr['type'] == 'button' ) {
                    $html .= '<div class="electron-terms '.$class.'" data-attribute="'.esc_attr( $args['attribute'] ).'"  data-attr-id="'.esc_attr( $attr_id ).'">';
                    if ( $product && taxonomy_exists( $attribute ) ) {

                        $terms = wc_get_product_terms($product->get_id(),$attribute,array('fields' => 'all') );
                        foreach ( $terms as $term ) {
                            if ( in_array( $term->slug, $options, true ) ) {
                                $tooltip = get_term_meta( $term->term_id, 'electron_swatches_tooltip', true ) ? : $term->name;
                                $color   = get_term_meta( $term->term_id, 'electron_swatches_color', true ) ? : '';
                                $image   = get_term_meta( $term->term_id, 'electron_swatches_image', true ) ? : '';
                                $img     = $image ? wp_get_attachment_thumb_url( $image ) : wc_placeholder_img_src();
                                $style   = ! empty( $color ) ? ' style="background-color:' . esc_attr( $color ) . '"' : '';
                                $hint    = '1' == $hints ? '<span class="electron-hint">'.esc_html( $tooltip ).'</span>' : '';

                                if ( $curr['type'] == 'color' ) {
                                    $html .= '<span class="electron-term a-term" data-title="'.esc_attr( $tooltip ).'" data-term="'.esc_attr( $term->slug ).'" data-term-id="'.esc_attr( $term->term_id ).'"><span class="type-color"'.$style.'></span>'.$hint.'</span>';
                                }
                                if ( $curr['type'] == 'button' ) {
                                    $html .= '<span class="electron-term a-term" data-title="'.esc_attr( $tooltip ).'" data-term="'.esc_attr( $term->slug ).'" data-term-id="'.esc_attr( $term->term_id ).'"><span class="type-button">'.esc_html( $term->name ).'</span>'.$hint.'</span>';
                                }
                                if ( $curr['type'] == 'image' ) {
                                    $html .= '<span class="electron-term a-term" data-title="'.esc_attr( $tooltip ).'" data-term="'.esc_attr( $term->slug ).'" data-term-id="'.esc_attr( $term->term_id ).'"><img src="'.esc_url( $img ).'" alt="'.esc_attr( $term->name ).'"/>'.$hint.'</span>';
                                }
                            }
                        }
                    }
                    $html .= '</div>';
                }
            }
            return $html;
        }

        public function custom_columns( $columns )
        {
            $columns['electron_swatches_value']   = esc_html__( 'Value', 'electron' );
            $columns['electron_swatches_tooltip'] = esc_html__( 'Tooltip', 'electron' );

            return $columns;
        }

        public function custom_columns_content( $columns, $column, $term_id )
        {
            if ( 'electron_swatches_value' === $column ) {
                $term = get_term( $term_id );
                $id   = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
                $attr = wc_get_attribute( $id );

                switch ( $attr->type ) {
                    case 'image':
                    $val = get_term_meta( $term_id, 'electron_swatches_image', true );
                    echo '<img class="electron-column-item" src="' . esc_url( wp_get_attachment_thumb_url( $val ) ) . '"/>';
                    break;

                    case 'color':
                    $val = get_term_meta( $term_id, 'electron_swatches_color', true );
                    echo '<span class="electron-column-item" style="background-color: ' . esc_attr( $val ) . ';"></span>';
                    break;

                    case 'button':
                    $val = get_term_meta( $term_id, 'electron_swatches_button', true );
                    echo '<span class="electron-column-item">' . esc_attr( $val ) . '</span>';
                    break;
                }
            }

            if ( $column === 'electron_swatches_tooltip' ) {
                echo get_term_meta( $term_id, 'electron_swatches_tooltip', true );
            }
        }

        public function archive_swatches( $product_id = null )
        {
            if ( $product_id ) {
                $product = wc_get_product( $product_id );
            } else {
                global $product;
            }

            if ( ! $product || ! $product->is_type( 'variable' ) ) {
                return;
            }

            $attributes = $product->get_variation_attributes();
            $var_av     = $product->get_available_variations();
            $var_json   = wp_json_encode( $var_av );
            $var_attr   = function_exists( 'wc_esc_json' ) ? wc_esc_json( $var_json ) : _wp_specialchars( $var_json, ENT_QUOTES, 'UTF-8', true );

            if ( is_array( $attributes ) && ( count( $attributes ) > 0 ) ) {

                    $html = '<div class="electron-variations variations" data-count="'.count( $attributes ).'">';

                    foreach ( $attributes as $name => $opts ) {
                        $html .= '<div class="electron-variations-items electron-flex electron-align-center variation attr-'.sanitize_title( $name ).'">';
                            $html .= '<div class="select">';
                                $attr     = 'attribute_' . sanitize_title( $name );
                                $selected = isset( $_REQUEST[ $attr ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ $attr ] ) ) ) : $product->get_variation_default_attribute( $name );

                                $args = array(
                                    'options'   => $opts,
                                    'attribute' => $name,
                                    'product'   => $product,
                                    'selected'  => $selected
                                );

                                $html .= $this->archive_variation_attribute_options_html( $args );

                                $html .= '<select name="' . esc_attr( $name ) . '" data-attribute_name="' . $attr. '">';
                                $html .= '<option value="">' . __( 'Choose an option', 'woocommerce' ) . '</option>';
                                if ( ! empty( $opts ) ) {
                                    if ( $product && taxonomy_exists( $name ) ) {
                                        $terms = wc_get_product_terms(
                                            $product->get_id(),
                                            $name,
                                            array('fields' => 'all')
                                        );

                                        foreach ( $terms as $term ) {
                                            if ( in_array( $term->slug, $opts, true ) ) {
                                                $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $name, $product ) ) . '</option>';
                                            }
                                        }
                                    } else {
                                        foreach ( $opts as $option ) {
                                            $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
                                            $html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $name, $product ) ) . '</option>';
                                        }
                                    }
                                }
                        		$html .= '</select>';

                            $html .= '</div>';
                        $html .= '</div>';
                    }
                    $html .= '<a class="electron-btn-reset reset_variations active" href="#">Clear</a>';
                    $html .= '</div>';
                echo '<div class="variations_form electron-loop-swatches" data-product_id="'.absint( $product->get_id() ).'" data-product_variations="'.$var_attr.'">'.$html.'</div>';
            }
        }
    }
    new Electron_Swatches();
}
