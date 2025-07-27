<?php

class Electron_Discount_Filter_Widget extends WP_Widget {

    // Initialize the widget
    function __construct() {
        parent::__construct(
            'discount_filter_widget',
            __('Electron Discount Filter', 'electron'),
            array('description' => __('Filter products by discount percentage', 'electron'))
        );

        // Attach pre_get_posts action to the widget for filtering products
        add_action('pre_get_posts', array($this, 'filter_products_by_discount'));
    }

    // Widget backend (admin panel settings)
    public function form($instance) {
        $discount_percentages = !empty($instance['discount_percentages']) ? $instance['discount_percentages'] : '10,20,30,50'; // Default percentages
        $type = !empty($instance['type']) ? $instance['type'] : 'select'; // Default to select

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('discount_percentages')); ?>">
                <?php esc_attr_e('Enter Discount Percentages (comma separated):', 'electron'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('discount_percentages')); ?>" name="<?php echo esc_attr($this->get_field_name('discount_percentages')); ?>" type="text" value="<?php echo esc_attr($discount_percentages); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('type')); ?>">
                <?php esc_attr_e('Select Type (list or select):', 'electron'); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('type')); ?>" name="<?php echo esc_attr($this->get_field_name('type')); ?>">
                <option value="select" <?php selected($type, 'select'); ?>><?php _e('Select', 'electron'); ?></option>
                <option value="list" <?php selected($type, 'list'); ?>><?php _e('List', 'electron'); ?></option>
            </select>
        </p>
        <?php
    }

    // Save widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['discount_percentages'] = (!empty($new_instance['discount_percentages'])) ? sanitize_text_field($new_instance['discount_percentages']) : '';
        $instance['type'] = (!empty($new_instance['type'])) ? sanitize_text_field($new_instance['type']) : 'select';
        return $instance;
    }

    // Widget front-end display
    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . __('Discount Filter', 'electron') . $args['after_title'];

        // Retrieve settings for discount percentages and type
        $discount_percentages = !empty($instance['discount_percentages']) ? explode(',', $instance['discount_percentages']) : array(10, 20, 30, 50);
        $type = !empty($instance['type']) ? $instance['type'] : 'select';

        // Retrieve the current discount filter value from the query
        $selected_discount = isset($_GET['discount_filter']) ? intval(esc_html($_GET['discount_filter'])) : '';

        // Render form based on the selected type (select or list)

        $hasFilter = isset($_GET['discount_filter']) ? ' checked' : '';

        ?>
        <?php if ($type == 'select') : ?>
            <form method="GET" action="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ninetheme-discount-filter<?php echo esc_attr($hasFilter); ?>">
                <select name="discount_filter">
                    <option value=""><?php _e('Select Discount', 'electron'); ?></option>
                    <?php foreach ($discount_percentages as $percentage) : ?>
                        <option value="<?php echo intval($percentage); ?>" <?php selected($selected_discount, intval($percentage)); ?>>
                            <?php echo esc_html($percentage); ?>% <?php _e('Off or More', 'electron'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        <?php else : ?>
            <div class="site-scroll ninetheme-scrollbar discount_filter">
                <ul>
                    <?php foreach ($discount_percentages as $percentage) :
                    $discountlink = remove_query_arg('discount_filter');
                    $discountlink = add_query_arg('discount_filter',intval($percentage));
                    $hasFilter    = $selected_discount == intval($percentage) ? 'checked' : '';
                    ?>
                    <li>
                        <a  class="<?php echo esc_attr($hasFilter); ?>" href="<?php echo esc_url($discountlink); ?>" rel="nofollow noreferrer">
                            <span class="checkbox">✓</span>
                            <span class="name"><?php echo esc_html($percentage); ?>% <?php _e('Off or More', 'electron'); ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php

        echo $args['after_widget'];
    }

    // Filter products by discount
    public function filter_products_by_discount($query) {
        if (!is_admin() && $query->is_main_query() && is_shop()) {
            if (isset($_GET['discount_filter']) && !empty($_GET['discount_filter'])) {
                $discount = intval($_GET['discount_filter']);

                // Filter products by discount percentage
                add_filter('posts_clauses', function ($clauses, $query) use ($discount) {
                    global $wpdb;

                    $clauses['where'] .= $wpdb->prepare(" AND ( ( (meta_price.meta_value - meta_sale_price.meta_value) / meta_price.meta_value ) * 100 ) >= %d ", $discount);

                    return $clauses;
                }, 10, 2);

                // Ensure that both regular and sale prices are joined in the query
                add_filter('posts_join', function ($join) {
                    global $wpdb;

                    $join .= " LEFT JOIN $wpdb->postmeta AS meta_price ON $wpdb->posts.ID = meta_price.post_id AND meta_price.meta_key = '_regular_price' ";
                    $join .= " LEFT JOIN $wpdb->postmeta AS meta_sale_price ON $wpdb->posts.ID = meta_sale_price.post_id AND meta_sale_price.meta_key = '_sale_price' ";

                    return $join;
                });
            }
        }
    }
}

// Register the widget
function register_discount_filter_widget() {
    register_widget('Electron_Discount_Filter_Widget');
}
add_action('widgets_init', 'register_discount_filter_widget');
