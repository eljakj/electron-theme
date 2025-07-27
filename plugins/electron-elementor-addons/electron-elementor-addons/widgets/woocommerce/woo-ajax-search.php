<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Ajax_Search extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-ajax-search';
    }
    public function get_title() {
        return 'Ajax Search';
    }
    public function get_icon() {
        return 'eicon-site-search';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'cat', 'wc', 'woo', 'product', 'search'  ];
    }
    // Registering Controls
    protected function register_controls() {

        /* HEADER MINICART SETTINGS */
        $this->start_controls_section( 'general_section',
            [
                'label' => esc_html__( 'Style', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'action',
            [
                'label' => esc_html__( 'Search Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'ajax',
                'options' => [
                    'cat' => esc_html__( 'Category Form', 'electron' ),
                    'ajax' => esc_html__( 'Simple Ajax Form', 'electron' )
                ]
            ]
        );
        $this->add_control( 'result_postion',
            [
                'label' => esc_html__( 'Result Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'postion-bottom',
                'options' => [
                    'postion-top' => esc_html__( 'Top', 'electron' ),
                    'postion-bottom' => esc_html__( 'Bottom', 'electron' ),
                ]
            ]
        );
        $this->add_responsive_control( 'result_maxwidth',
            [
                'label' => esc_html__( 'Result Max Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                    'min' => 0,
                        'max' => 2000,
                        'step' => 1
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .autocomplete-suggestions' => 'max-width: {{SIZE}}px!important;']
            ]
        );
        $this->add_responsive_control( 'result_maxheight',
            [
                'label' => esc_html__( 'Result Max Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                    'min' => 0,
                        'max' => 2000,
                        'step' => 1
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .autocomplete-suggestions' => 'max-height: {{SIZE}}px!important;']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('style_section',
            [
                'label'=> esc_html__( 'Style', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'action' => 'ajax' ]
            ]
        );
        $this->add_responsive_control( 'form_maxwidth',
            [
                'label' => esc_html__( 'Min Width ( % )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                    'min' => 0,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-asform' => 'max-width: {{SIZE}}%;']
            ]
        );
        $this->add_responsive_control( 'form_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-asform' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'form_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-asform' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->start_controls_tabs( 'slider_nav_tabs');
        $this->start_controls_tab( 'slider_nav_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'electron' ) ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-asform',
            ]
        );
        $this->add_control( 'form_bgclr',
           [
               'label' => esc_html__( 'Background Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .electron-asform input.electron-as' => 'background-color: {{VALUE}};']
           ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'slider_nav_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'electron' ) ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'form_hvrborder',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-asform:hover,{{WRAPPER}} .electron-asform:focus',
            ]
        );
        $this->add_control( 'form_hvrbgclr',
           [
               'label' => esc_html__( 'Background Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .electron-asform:hover input.electron-as,{{WRAPPER}} .electron-asform:focus input.electron-as' => 'background-color: {{VALUE}};']
           ]
        );
        $this->add_control( 'form_hvrclr',
           [
               'label' => esc_html__( 'Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .electron-asform:hover input.electron-as,{{WRAPPER}} .electron-asform:focus input.electron-as' => 'color: {{VALUE}};']
           ]
        );
        $this->add_control( 'submit_bgclr',
           [
               'label' => esc_html__( 'Submit Background Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .electron-asform .header-search-wrap form button' => 'background-color: {{VALUE}};']
           ]
        );
        $this->add_control( 'submit_iconclr',
           [
               'label' => esc_html__( 'Submit Icon Color', 'electron' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => [
                   '{{WRAPPER}} .electron-asform .header-search-wrap form button' => 'color: {{VALUE}};',
                   '{{WRAPPER}} .electron-asform .header-search-wrap form button svg' => 'fill: {{VALUE}};',
               ]
           ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }
        $settings = $this->get_settings_for_display();

        echo'<div class="electron_as_form_wrapper form-type-'.$settings['action'].' result-'.$settings['result_postion'].'">';
            if ( 'cat' == $settings['action'] && function_exists( 'electron_wc_category_search_form' ) ) {
                electron_wc_category_search_form();
            } else {
                if ( shortcode_exists('electron_wc_ajax_search') ) {
                    echo do_shortcode('[electron_wc_ajax_search]');
                } else {
                    echo 'Please enable Ajax Search Form from Theme Options settings';
                }
            }
        echo'</div>';
    }
}
