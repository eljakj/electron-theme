<?php
class Electron_Widget_Product_Categories_Walker extends Walker {
    /**
    * What the class handles.
    *
    * @var string
    */
    public $tree_type = 'product_cat';

    /**
    * DB fields to use.
    *
    * @var array
    */
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
        'slug'   => 'slug',
    );
    /**
    * Starts the list before the elements are added.
    *
    * @see Walker::start_lvl()
    * @since 2.1.0
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param int    $depth Depth of category. Used for tab indentation.
    * @param array  $args Will only append content if style argument value is 'list'.
    */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $plus    = function_exists('electron_svg_lists') ? electron_svg_lists('plus') : '';
        $output .= "$indent<span class='subDropdown plus'>$plus</span><ul class='children'>\n";
    }

    /**
    * Ends the list of after the elements are added.
    *
    * @see Walker::end_lvl()
    * @since 2.1.0
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param int    $depth Depth of category. Used for tab indentation.
    * @param array  $args Will only append content if style argument value is 'list'.
    */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    /**
    * Start the element output.
    *
    * @see Walker::start_el()
    * @since 2.1.0
    *
    * @param string  $output            Passed by reference. Used to append additional content.
    * @param object  $cat               Category.
    * @param int     $depth             Depth of category in reference to parents.
    * @param array   $args              Arguments.
    * @param integer $current_object_id Current object ID.
    */
    public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $cat_id = intval( $cat->term_id );

        $output .= '<li class="cat-item cat-item-' . $cat_id;

        if ( $args['current_category'] === $cat_id ) {
            $output .= ' current-cat';
        }

        if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
            $output .= ' cat-parent';
        }

        if ( isset( $args['current_category_ancestors'] ) && $args['current_category'] && in_array( $cat_id, $args['current_category_ancestors'], true ) ) {
            $output .= ' current-cat-parent';
        }
        $checkbox = '';
        if ( isset( $_GET['filter_cat'] ) ) {
            if ( in_array( $cat_id, explode( ',', $_GET['filter_cat'] ) ) ) {
                $checkbox = ' checked';
                $output .= ' checked';
            }
        }
        $count = '';
        if ( isset( $args['show_count'] ) && $args['show_count'] ) {
            $count = '<span class="count">'.esc_html( $cat->count ).'</span>';
        }
        if ( !is_shop() && isset( $args['current_category_ancestors'] ) && $args['current_category'] ) {
                $checkbox = ' checked';
                $output .= ' checked';
        }
        if ( !is_shop() && $args['current_category'] === $cat_id ) {
                $checkbox = ' checked';
                $output .= ' checked';
        }
        $link    = is_shop() ? electron_get_cat_url( $cat_id ) : get_term_link($cat_id);
        $output .= '"><a class="product_cat'.esc_attr( $checkbox ).'" href="'.esc_url( $link ).'" rel="nofollow noreferrer">';
        $output .= '<span class="checkbox">&#x2713;</span><span class="name">'.esc_html( $cat->name ).'</span>';
        $output .= $count;
        $output .= '</a>';
    }

    /**
    * Ends the element output, if needed.
    *
    * @see Walker::end_el()
    * @since 2.1.0
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param object $cat    Category.
    * @param int    $depth  Depth of category. Not used.
    * @param array  $args   Only uses 'list' for whether should append to output.
    */
    public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }

    /**
    * Traverse elements to create list from elements.
    *
    * Display one element if the element doesn't have any children otherwise,
    * display the element and its children. Will only traverse up to the max.
    * depth and no ignore elements under that depth. It is possible to set the.
    * max depth to include all depths, see walk() method.
    *
    * This method shouldn't be called directly, use the walk() method instead.
    *
    * @since 2.5.0
    *
    * @param object $element           Data object.
    * @param array  $children_elements List of elements to continue traversing.
    * @param int    $max_depth         Max depth to traverse.
    * @param int    $depth             Depth of current element.
    * @param array  $args              Arguments.
    * @param string $output            Passed by reference. Used to append additional content.
    * @return null Null on failure with no changes to parameters.
    */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element || ( 0 === $element->count && ! empty( $args[0]['hide_empty'] ) ) ) {
            return;
        }
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

class Electron_Widget_Product_Categories extends WP_Widget {

    // Widget Settings
    function __construct() {
        $widget_ops = array('description' => esc_html__('For Main Shop Page.','electron') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'electron_product_categories' );
        parent::__construct( 'electron_product_categories', esc_html__('Electron Product Categories','electron'), $widget_ops, $control_ops );
        add_filter( 'woocommerce_product_query_tax_query', [ $this, 'product_query_tax_query' ], 10, 2 );
    }

    function product_query_tax_query( $tax_query, $instance )
    {
        if ( isset( $_GET['filter_cat'] ) && !empty( $_GET['filter_cat'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => explode( ',', $_GET['filter_cat'] )
            );
        }
        return $tax_query;
    }


    // Widget Output
    function widget( $args, $instance )
    {
        extract( $args );
        $title      = apply_filters( 'widget_title', empty($instance['title'] ) ? '' : $instance['title'], $instance );
        $exclude    = $instance['exclude'];
        $child_of   = ! empty( $instance['child_of'] ) ? true : false;
        $hide_empty = ! empty( $instance['hide_empty'] ) ? 1 : 0;
        $show_count = ! empty( $instance['show_count'] ) ? 1 : 0;
        $order      = ! empty( $instance['order'] ) ? $instance['order'] : 'asc';
        $orderby    = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'name';

        $current_term_id = get_queried_object_id();

        $child_categories = get_terms(array(
            'taxonomy'   => 'product_cat',
            'parent'     => $current_term_id,
            'hide_empty' => false
        ));

        if ( $child_of && empty($child_categories) ) {
            return;
        }

        echo $before_widget;

        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        echo '<div class="widget-body site-checkbox-lists electron-widget-product-categories">';
        echo '<div class="site-scroll">';
        echo '<ul class="ninetheme-product-categories-primary">';
        if ( $exclude == 'All' || $exclude == 'all' || $exclude == '' ) {
            $menu_args = array(
                'echo'       => true,
                'taxonomy'   => 'product_cat',
                'order'      => $order,
                'orderby'    => $orderby,
                'depth'      => 5,
                'hide_empty' => $hide_empty,
                'show_count' => $show_count,
                'title_li'   => '',
                'walker'     => new Electron_Widget_Product_Categories_Walker()
            );
        } else {
            $menu_args = array(
                'echo'       => true,
                'taxonomy'   => 'product_cat',
                'order'      => $order,
                'orderby'    => $orderby,
                'depth'      => 5,
                'hide_empty' => $hide_empty,
                'show_count' => $show_count,
                'title_li'   => '',
                'exclude'    => explode(',', $exclude),
                'walker'     => new Electron_Widget_Product_Categories_Walker()
            );
        }


        if ( $current_term_id && $child_of ) {
            $menu_args['child_of'] = $current_term_id;
        }

        echo wp_list_categories($menu_args);
        echo '</ul>';
        echo '</div>';
        echo '</div>';

        echo $after_widget;
    }

    // Update
    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        $instance['title']      = strip_tags($new_instance['title']);
        $instance['exclude']    = strip_tags($new_instance['exclude']);
        $instance['order']      = strip_tags($new_instance['order']);
        $instance['orderby']    = strip_tags($new_instance['orderby']);
        $instance['child_of']   = isset( $new_instance['child_of'] ) ? (bool) $new_instance['child_of'] : false;
        $instance['hide_empty'] = isset( $new_instance['hide_empty'] ) ? (bool) $new_instance['hide_empty'] : false;
        $instance['show_count'] = isset( $new_instance['show_count'] ) ? (bool) $new_instance['show_count'] : false;

        return $instance;
    }

    // Backend Form
    function form( $instance )
    {
        $defaults   = array('title' => 'Product Categories', 'exclude' => 'All', 'order' => 'name', 'orderby' => 'asc');
        $instance   = wp_parse_args(( array ) $instance, $defaults );
        $checked    = isset( $instance['child_of'] ) ? $instance['child_of'] : false;
        $hide_empty = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : false;
        $show_count = isset( $instance['show_count'] ) ? $instance['show_count'] : false;
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','electron'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('exclude'); ?>"><?php esc_html_e( 'Exclude id:','electron' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" value="<?php echo $instance['exclude']; ?>" />
        </p>

        <p>
            <input type="checkbox" <?php checked( $checked, true ); ?> class="widefat" id="<?php echo $this->get_field_id('child_of'); ?>" name="<?php echo $this->get_field_name('child_of'); ?>" />
            <label for="<?php echo $this->get_field_id('child_of'); ?>"><?php esc_html_e( 'Show Only Sub-category (for Category Page)','electron' ); ?></label>
        </p>

        <p>
            <input type="checkbox" <?php checked( $hide_empty, true ); ?> class="widefat" id="<?php echo $this->get_field_id('hide_empty'); ?>" name="<?php echo $this->get_field_name('hide_empty'); ?>" />
            <label for="<?php echo $this->get_field_id('hide_empty'); ?>"><?php esc_html_e( 'Hide if empty','electron' ); ?></label>
        </p>

        <p>
            <input type="checkbox" <?php checked( $show_count, true ); ?> class="widefat" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" />
            <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php esc_html_e( 'Show Count','electron' ); ?></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e( 'Order','electron' ); ?></label>
            <select class="ninetheme-select" id="order" name="<?php echo $this->get_field_name('order'); ?>">
                <option value="asc" <?php selected( $instance['order'], 'asc' ); ?>><?php esc_html_e( 'Ascending','electron' ); ?></option>
                <option value="desc" <?php selected( $instance['order'], 'desc' ); ?>><?php esc_html_e( 'Descending','electron' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php esc_html_e( 'Order By', 'electron' ); ?></label>
            <select class="ninetheme-select" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option value="name" <?php selected( $instance['orderby'], 'name' ); ?>><?php esc_html_e( 'Name', 'electron' ); ?></option>
                <option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php esc_html_e( 'By ID', 'electron' ); ?></option>
                <option value="slug" <?php selected( $instance['orderby'], 'slug' ); ?>><?php esc_html_e( 'Slug', 'electron' ); ?></option>
                <option value="count" <?php selected( $instance['orderby'], 'count' ); ?>><?php esc_html_e( 'Count', 'electron' ); ?></option>
                <option value="description" <?php selected( $instance['orderby'], 'description' ); ?>><?php esc_html_e( 'Description', 'electron' ); ?></option>
                <option value="menu_order" <?php selected( $instance['orderby'], 'menu_order' ); ?>><?php esc_html_e( 'Category Order', 'electron' ); ?></option>
            </select>
        </p>

        <?php
    }
}

// Add Widget
function electron_widget_product_categories_init() {
    register_widget('Electron_Widget_Product_Categories');
}
add_action('widgets_init', 'electron_widget_product_categories_init');

?>
