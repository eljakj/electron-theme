<?php
/**
* Layered nav widget
*
* @package WooCommerce\Widgets
* @version 2.6.0
*/

use Automattic\WooCommerce\Internal\ProductAttributesLookup\Filterer;

defined( 'ABSPATH' ) || exit;

/**
* Widget layered nav class.
*/
class Electron_Widget_Layered_Nav extends WC_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'electron-widget widget_layered_nav_multi';
        $this->widget_description = __( 'Display a list of attributes to filter products in your store.', 'electron' );
        $this->widget_id          = 'electron_wc_layered_nav';
        $this->widget_name        = __( 'Electron Multi Filter by Product Attribute', 'electron' );
        parent::__construct();

        add_action( 'wp_enqueue_scripts', [$this,'front_scripts'] );
    }

    public function front_scripts()
    {
        wp_enqueue_style( 'select2-full');
        wp_enqueue_script( 'select2-full');
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        $instance['title']     = strip_tags($new_instance['title']);
        $instance['attribute'] = $new_instance['attribute'];

        return $instance;
    }

    public function form( $instance )
    {
        $defaults = array(
            'title'       => 'Product Brands',
            'attribute'   => array(),
            'btn_title'   => '',
            'clear_title' => '',
            'message'     => ''
        );
        $instance   = wp_parse_args(( array ) $instance, $defaults );
        $select     = is_array( $instance['attribute'] ) ? $instance['attribute'] : array();
        $taxonomies = wc_get_attribute_taxonomies();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Filter by:','electron'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('attribute'); ?>"><?php esc_html_e( 'Exclude Brand(s):','electron' ); ?></label>
            <select class="electron-select2" id="attribute" name="<?php echo $this->get_field_name('attribute'); ?>[]" multiple>
                <?php
                foreach ( $taxonomies as $tax ) {
                    if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                        $taxname  = $tax->attribute_name;
                        $selected = in_array( $taxname, $select) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo esc_html( $taxname ); ?>" <?php echo esc_html( $selected ); ?>><?php echo esc_html( $taxname ); ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('btn_title'); ?>"><?php esc_html_e('Button Text:','electron'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('btn_title'); ?>" name="<?php echo $this->get_field_name('btn_title'); ?>" value="<?php echo $instance['btn_title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('clear_title'); ?>"><?php esc_html_e('Clear Button Text:','electron'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('clear_title'); ?>" name="<?php echo $this->get_field_name('clear_title'); ?>" value="<?php echo $instance['btn_title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('message'); ?>"><?php esc_html_e('Form message:','electron'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" value="<?php echo $instance['message']; ?>" />
        </p>
        <?php
    }

    public function widget( $args, $instance )
    {
        extract($args);
        global $wp;

        if ( ! is_shop() && ! is_product_taxonomy() ) {
            return;
        }

        $chosen     = WC_Query::get_layered_nav_chosen_attributes();
        $query_type = 'and';
        $title      = isset( $instance['title'] ) ? $instance['title'] : '';
        $taxonomy   = isset( $instance['attribute'] ) ? $instance['attribute'] : '';
        $btn_title  = isset( $instance['btn_title'] ) ? $instance['btn_title'] : esc_html__( 'Filter', 'electron' );
        $message    = isset( $instance['message'] ) ? $instance['message'] : esc_html__( 'Please select an option', 'electron' );
        $clear_title= isset( $instance['clear_title'] ) ? $instance['clear_title'] : esc_html__( 'Clear Selection', 'electron' );
        $multi      = is_array( $taxonomy ) ? 'multi-selection' : 'single-selection';
        $btnac      = $chosen ? ' active' : '';
        $html       = '';

        if ( '' === get_option( 'permalink_structure' ) ) {
            $form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( user_trailingslashit( $wp->request ) ) );
        }

        if ( !empty( $taxonomy ) ) {

                $html .= '<h6 class="nt-sidebar-inner-widget-title shop-widget-title"><span class="nt-sidebar-widget-title">'.esc_html($title).'</span><span class="nt-sidebar-widget-toggle"></span></h6>';
                $html .= '<div class="widget-body">';
                    $html .= '<form class="electron-multiselect '.$multi.'" action="' . esc_url( $form_action ) . '" method="get">';
                        foreach ( $taxonomy as $tax ) {
                            $taxo  = wc_attribute_taxonomy_name( $tax );
                            $terms = get_terms( $taxo, array( 'hide_empty' => '1' ) );

                            if ( is_array($terms) && 0 === count( $terms ) ) {
                                return;
                            }

                            $return_values = $this->layered_nav_dropdown( $terms, $taxo, $query_type );

                            list( 'html_output' => $html_output, 'found' => $found ) = $return_values;

                            if ( $found ) {
                                $html .= $html_output;;
                            }

                            // Force found when option is selected - do not force found on taxonomy attributes.
                            if ( ! is_tax() && is_array( $chosen ) && array_key_exists( $taxo, $chosen ) ) {
                                $found = true;
                            }
                        }
                    $html .= '</form>';
                    $html .= '<a href="'.esc_url( $form_action ).'" class="electron-btn electron-btn-primary form-clear'.$btnac.'">'.$clear_title.'</a>';
                $html .= '</div>';

            echo '<div class="nt-sidebar-inner-widget shop-widget electron-widget widget_layered_nav_multi electron-widget-show">'.$html.'</div>';
        }
    }

    protected function get_current_taxonomy()
    {
        return is_tax() ? get_queried_object()->taxonomy : '';
    }

    protected function get_current_term_id()
    {
        return absint( is_tax() ? get_queried_object()->term_id : 0 );
    }

    protected function get_current_term_slug()
    {
        return absint( is_tax() ? get_queried_object()->slug : 0 );
    }

    protected function layered_nav_dropdown( $terms, $taxonomy, $query_type ) {
        global $wp;
        $found = false;
        $html_output = '';

        if ( $taxonomy !== $this->get_current_taxonomy() ) {
            $term_counts    = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
            $chosen         = WC_Query::get_layered_nav_chosen_attributes();
            $filter_name    = wc_attribute_taxonomy_slug( $taxonomy );
            $taxonomy_label = wc_attribute_label( $taxonomy );
            $any_label      = apply_filters( 'woocommerce_layered_nav_any_label', sprintf( __( 'Any %s', 'electron' ), $taxonomy_label ), $taxonomy_label, $taxonomy );
            $current_values = isset( $chosen[ $taxonomy ]['terms'] ) ? $chosen[ $taxonomy ]['terms'] : array();
            $label_name     = wc_attribute_label( 'pa_'.$filter_name );
            $html_output    = '';

            $html_output .= '<div class="form-column">';
            $html_output .= '<select
            class="electron-select2"
            name="filter_'.esc_attr($filter_name).'"
            data-tax="pa_'.$filter_name.'"
            data-placeholder="'.esc_attr__('Select', 'electron').' '.esc_attr($label_name).'"
            data-search="true"
            data-searchplaceholder="'.esc_attr__('Search item...', 'electron').'">';
            $html_output .= '<option value="">' . esc_html( $any_label ) . '</option>';

            foreach ( $terms as $term ) {

                // If on a term page, skip that term in widget list.
                if ( is_object($term) && !is_wp_error( $term ) ) {
                    if ( !empty($term->term_id) && $term->term_id === $this->get_current_term_id() ) {
                        continue;
                    }

                    // Get count based on current view.
                    $option_is_set = in_array( $term->slug, $current_values, true );
                    $count         = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

                    // Only show options with count > 0.
                    if ( 0 < $count ) {
                        $found = true;
                    } elseif ( 0 === $count && ! $option_is_set ) {
                        continue;
                    }

                    $html_output .= '<option value="' . esc_attr( urldecode( $term->slug ) ) . '" ' . selected( $option_is_set, true, false ) . '>' . esc_html( $term->name ) . '</option>';
                }
            }

            $html_output .= '</select>';

            //$html_output .= '<input type="hidden" name="filter_' . esc_attr( $filter_name ) . '" value="' . esc_attr( implode( ',', $current_values ) ) . '" />';
            //$html_output .= wc_query_string_form_fields( null, array( 'filter_' . $filter_name, 'query_type_' . $filter_name ), '', true );

            $html_output .= '</div>';
        }

        return array( 'html_output' => $html_output, 'found' => $found );
    }

    protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
        return wc_get_container()->get( Filterer::class )->get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type );
    }

    protected function get_main_tax_query() {
        return WC_Query::get_main_tax_query();
    }

    protected function get_main_search_query_sql() {
        return WC_Query::get_main_search_query_sql();
    }

    protected function get_main_meta_query() {
        return WC_Query::get_main_meta_query();
    }
}

function electron_layerednav_register_widgets() {
    register_widget( 'Electron_Widget_Layered_Nav' );
}
add_action( 'widgets_init', 'electron_layerednav_register_widgets' );
