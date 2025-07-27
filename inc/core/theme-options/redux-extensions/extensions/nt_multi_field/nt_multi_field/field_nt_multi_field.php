<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_nt_multi_field' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_nt_multi_field {

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {


            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options' => array(),
                'stylesheet' => '',
                'output' => true,
                'enqueue' => true,
                'enqueue_frontend' => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );

        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            // HTML output goes here
            $this->add_text   = ( isset( $this->field['add_text'] ) ) ? $this->field['add_text'] : esc_html__( 'Add More', 'electron' );
            $this->show_empty = ( isset( $this->field['show_empty'] ) ) ? $this->field['show_empty'] : true;

            echo '<ul id="' . $this->field['id'] . '-ul" class="nt-multi-field">';

            if ( isset( $this->value ) && is_array( $this->value ) ) {
                $count = 0;

                foreach ( $this->value as $k => $value ) {

                        $pleaceholder =  $count % count($this->field['placeholder']);

                        if ( $count % count($this->field['placeholder']) == 0) {
                            echo '<li class="nt-multi-field-list">';
                        }

                        echo  '<input type="text" id="' . $this->field['id'] . '-' . $count . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '[]' . '" value="' . esc_attr( $value) . '" class="regular-text ' . $this->field['class'] . '" placeholder="'.$this->field['placeholder'][$pleaceholder].'"  /> ';

                        if ( $count % count($this->field['placeholder']) == (count($this->field['placeholder']) - 1 ) ) {
                            echo  '<a' . ' data-id="' . $this->field['id'] . '-ul" href="javascript:void(0);" class="deletion nt-multi-field-remove">' . esc_html__( 'Remove', 'electron' ) . '</a>';
                        echo '</li>';

                        }

                    $count++;

                }
            } elseif ( $this->show_empty == true ) {
                echo '<li>';
                echo     '<input type="text" id="' . $this->field['id'] . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '[]' . '" value="" class="regular-text ' . $this->field['class'] . '" /> ';
                echo     '<a' . ' data-id="' . $this->field['id'] . '-ul" href="javascript:void(0);" class="deletion nt-multi-field-remove">' . esc_html__( 'Remove', 'electron' ) . '</a>';
                echo '</li>';
            }

            $the_name = '';
            if (isset($this->value) && empty($this->value) && $this->show_empty == false) {
                $the_name = $this->field['name'] . $this->field['name_suffix'];
            }

                echo '<li class="nt-multi-field-list" style="display:none;">';
                foreach ( $this->field['placeholder'] as $value ) {
                    echo '<input type="text" id="'.$this->field['id'].'" name="'.$the_name.'" value="" class="regular-text ' . $this->field['class'] . '" placeholder="'.$value.'" />';
                }
                        echo '<a' . ' data-id="' . $this->field['id'] . '-ul" href="javascript:void(0);" class="deletion nt-multi-field-remove">' . esc_html__( 'Remove', 'electron' ) . '</a>';
                echo '</li>';
            echo '</ul>';

            echo '<span style="clear:both;display:block;height:0;" /></span>';
            $this->field['add_number'] = ( isset( $this->field['add_number'] ) && is_numeric( $this->field['add_number'] ) ) ? $this->field['add_number'] : 1;
            echo '<a href="javascript:void(0);" class="button button-primary nt-multi-field-add" data-add_number="' . $this->field['add_number'] . '" data-id="' . $this->field['id'] . '-ul" data-name="' . $this->field['name'] . $this->field['name_suffix'] . '">' . $this->add_text . '</a><br/>';

        }

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            wp_enqueue_script(
                'field-multi-text-js',
                $this->extension_url . 'field_multi_text.js',
                array( 'jquery' ),
                time(),
                true
            );
            wp_enqueue_style(
                'field-multi-text-css',
                $this->extension_url . 'field_multi_text.css',
                time(),
                true
            );

        }

        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function output() {

            if ( $this->field['enqueue_frontend'] ) {


            }

        }

    }
}
