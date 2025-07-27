<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Label extends Widget_Base {
    public function get_name() {
        return 'electron-widget-label';
    }
    public function get_title() {
        return 'Label';
    }
    public function get_icon() {
        return 'eicon-animated-headline';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    // Registering Controls
    protected function register_controls() {

        /*****   label Options   ******/
        $this->start_controls_section('label_settings',
            [
                'label' => esc_html__( 'LABEL', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'text',
            [
                'label' => esc_html__( 'Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'This is label', 'electron' )
            ]
        );
        $this->add_control( 'bg_type',
            [
                'label' => esc_html__( 'Background Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-solid',
                'options' => [
                    'electron-bordered' => esc_html__( 'Bordered Transparent', 'electron' ),
                    'electron-solid' => esc_html__( 'Solid BG', 'electron' ),
                    'electron-gradient' => esc_html__( 'Gradient BG', 'electron' )
                ]
            ]
        );
        $this->add_control( 'gradient_type',
            [
                'label' => esc_html__( 'Gradient Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'label-solid',
                'options' => [
                    'electron-grad-green' => esc_html__( 'Green', 'electron' ),
                    'electron-grad-blue' => esc_html__( 'Blue', 'electron' ),
                    'electron-grad-purple' => esc_html__( 'Purple', 'electron' ),
                    'electron-grad-orange' => esc_html__( 'Orange', 'electron' ),
                    'electron-grad-red' => esc_html__( 'Red', 'electron' ),
                    'electron-grad-dark' => esc_html__( 'Dark', 'electron' ),
                ],
                'condition' => ['bg_type' => 'electron-gradient']
            ]
        );
        $this->add_control( 'color_type',
            [
                'label' => esc_html__( 'Color Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-bg-primary',
                'options' => [
                    'electron-bg-primary' => esc_html__( 'Primary', 'electron' ),
                    'electron-bg-secondary' => esc_html__( 'Secondary', 'electron' ),
                    'electron-bg-success' => esc_html__( 'Success', 'electron' ),
                    'electron-bg-dark' => esc_html__( 'Black', 'electron' ),
                    'electron-bg-dark-soft' => esc_html__( 'Black Soft', 'electron' ),
                    'electron-bg-light' => esc_html__( 'White', 'electron' ),
                    'electron-bg-light-soft' => esc_html__( 'White Soft', 'electron' ),
                    'electron-bg-brown' => esc_html__( 'Brown', 'electron' ),
                    'electron-bg-cream' => esc_html__( 'Cream', 'electron' ),
                    'electron-bg-red' => esc_html__( 'Red', 'electron' ),
                    'electron-bg-red-dark' => esc_html__( 'Red Dark', 'electron' ),
                    'electron-bg-red-soft' => esc_html__( 'Red Soft', 'electron' ),
                    'electron-bg-gray' => esc_html__( 'Gray', 'electron' ),
                    'electron-bg-gray-soft' => esc_html__( 'Gray Soft', 'electron' ),
                    'electron-bg-gray-dark' => esc_html__( 'Gray Dark', 'electron' ),
                    'electron-bg-green' => esc_html__( 'Green', 'electron' ),
                    'electron-bg-green-soft' => esc_html__( 'Green Soft', 'electron' ),
                    'electron-green-bg' => esc_html__( 'Green BG', 'electron' ),
                    'electron-bg-blue' => esc_html__( 'Blue', 'electron' ),
                    'electron-bg-blue-dark' => esc_html__( 'Blue Dark', 'electron' ),
                    'electron-bg-blue-soft' => esc_html__( 'Blue Soft', 'electron' ),
                    'electron-blue-bg' => esc_html__( 'Blue BG', 'electron' ),
                    'electron-bg-purple' => esc_html__( 'Purple', 'electron' ),
                    'electron-bg-purple-soft' => esc_html__( 'Purple Soft', 'electron' ),
                    'electron-purple-bg' => esc_html__( 'Purple BG', 'electron' ),
                    'electron-bg-yellow' => esc_html__( 'Yellow', 'electron' ),
                    'electron-bg-yellow-soft' => esc_html__( 'Yellow Soft', 'electron' ),
                    'electron-yellow-bg' => esc_html__( 'Yellow BG', 'electron' ),
                ],
                'condition' => ['bg_type!' => 'electron-gradient']
            ]
        );
        $this->add_control( 'radius_type',
            [
                'label' => esc_html__( 'Radius Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-square',
                'options' => [
                    'electron-radius' => esc_html__( 'Radius', 'electron' ),
                    'electron-radius-soft' => esc_html__( 'Radius Soft', 'electron' ),
                    'electron-square' => esc_html__( 'Square', 'electron' ),
                ]
            ]
        );
        $this->add_control( 'size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'label-small',
                'options' => [
                    'label-large' => esc_html__( 'Large', 'electron' ),
                    'label-medium' => esc_html__( 'Medium', 'electron' ),
                    'label-small' => esc_html__( 'Small', 'electron' )
                ]
            ]
        );
        $this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}}' => 'text-align: {{VALUE}};'],
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-h-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-h-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-h-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => ''
            ]
        );
        $this->add_control( 'link',
            [
                'label' => esc_html__( 'Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => ''
                ],
                'show_external' => true
            ]
        );
        $this->end_controls_section();
        /*****   End label Options   ******/

        /***** label Style ******/
        $this->start_controls_section('label_styling',
            [
                'label' => esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control( 'label_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-widget-label' => 'color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-widget-label'
            ]
        );
        $this->add_responsive_control( 'label_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'label_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-widget-label',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'label_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-widget-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'label_background',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-widget-label',
                'separator' => 'before'
            ]
        );
        $this->end_controls_section();
        /***** End label Styling *****/
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $bg = 'gradient' == $settings['bg_type'] ? $settings['gradient_type'] : $settings['color_type'];
        $class  = $bg;
        $class .= ' '.$settings['bg_type'];
        $class .= ' '.$settings['radius_type'];
        $class .= ' '.$settings['size'];
        
        if ( !empty( $settings['link']['url'] ) ) {
            $link  = ' href="'.$settings['link']['url'].'"';
            $link .= !empty( $settings['link']['is_external'] ) ? ' target="_blank"' : '';
            $link .= !empty( $settings['link']['nofollow'] ) ? ' rel="nofollow"' : '';
            echo '<a'.$link.'><span class="electron-widget-label '.$class.'">'.$settings['text'].'</span></a>';
        } else {
            echo '<span class="electron-widget-label '.$class.'">'.$settings['text'].'</span>';
        }
    }
}
