<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Button extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-button';
    }
    public function get_title() {
        return 'Button';
    }
    public function get_icon() {
        return 'eicon-button';
    }
    public function get_categories() {
        return [ 'electron' ];
    }

    // Registering Controls
    protected function register_controls() {
        $is_left = is_rtl() ? 'left' : 'right';
        $is_right = is_rtl() ? 'right' : 'left';
        /*****   Button Options   ******/
        $this->start_controls_section('btn_settings',
            [
                'label' => esc_html__( 'Button', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'btn_action',
            [
                'label' => esc_html__( 'Action Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'link',
                'options' => [
                    'link' => esc_html__( 'Link', 'electron' ),
                    'image' => esc_html__( 'Single Image', 'electron' ),
                    'youtube' => esc_html__( 'Youtube', 'electron' ),
                    'vimeo' => esc_html__( 'Vimeo', 'electron' ),
                    'map' => esc_html__( 'Google Map', 'electron' ),
                    'html5' => esc_html__( 'HTML5 Video', 'electron' ),
                    'modal' => esc_html__( 'Modal Content', 'electron' ),
                    'gallery' => esc_html__( 'Gallery Images', 'electron' )
                ]
            ]
        );
        $this->add_control( 'link_type',
            [
                'label' => esc_html__( 'Link Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'external',
                'options' => [
                    'external' => esc_html__( 'External', 'electron' ),
                    'internal' => esc_html__( 'Internal', 'electron' ),
                ],
                'condition' => ['btn_action' => 'link']
            ]
        );
        $this->add_control( 'text',
            [
                'label' => esc_html__( 'Button Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'Button Text', 'electron' )
            ]
        );
        $this->add_control( 'btn_id',
            [
                'label' => esc_html__( 'Button ID', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );
        $this->add_control( 'link',
            [
                'label' => esc_html__( 'Button Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => ''
                ],
                'show_external' => true,
                'condition' => ['btn_action' => 'link']
            ]
        );
        $this->add_control( 'images',
            [
                'label' => esc_html__( 'Images', 'electron' ),
                'type' => Controls_Manager::GALLERY,
                'condition' => ['btn_action' => 'gallery']
            ]
        );
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => Utils::get_placeholder_image_src()],
                'condition' => ['btn_action' => 'image']
            ]
        );
        $this->add_control( 'ltitle',
            [
                'label' => esc_html__( 'Lightbox Title', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Phone Name',
                'condition' => ['btn_action' => 'image']
            ]
        );
        $this->add_control( 'youtube',
            [
                'label' => esc_html__( 'Youtube Video URL', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'http://www.youtube.com/watch?v=AeeE6PyU-dQ',
                'condition' => ['btn_action' => 'youtube']
            ]
        );
        $this->add_control( 'vimeo',
            [
                'label' => esc_html__( 'Vimeo Video URL', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'https://vimeo.com/39493181',
                'condition' => ['btn_action' => 'vimeo']
            ]
        );
        $this->add_control( 'map',
            [
                'label' => esc_html__( 'Iframe Map URL', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'https://maps.google.com/maps?q=221B+Baker+Street,+London,+United+Kingdom&amp;hl=en&amp;t=v&amp;hnear=221B+Baker+St,+London+NW1+6XE,+United+Kingdom',
                'condition' => ['btn_action' => 'map']
            ]
        );
        $this->add_control( 'html5',
            [
                'label' => esc_html__( 'HTML5 Video URL', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => '',
                'pleaceholder' => esc_html__( 'Add your local video here', 'electron' ),
                'condition' => ['btn_action' => 'html5']
            ]
        );
        $this->add_control( 'modal_content',
            [
                'label' => esc_html__( 'Modal Content', 'electron' ),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default' => '<h3>Modal</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rhoncus pharetra dui, nec tempus tellus maximus et. Sed sed elementum ligula, id cursus leo. Duis imperdiet tortor id condimentum hendrerit.</p>',
                'pleaceholder' => esc_html__( 'Add html content here', 'electron' ),
                'condition' => ['btn_action' => 'modal']
            ]
        );
        $this->add_control( 'modal_width',
            [
                'label' => esc_html__( 'Modal Content Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 2000
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'condition' => ['btn_action' => 'modal']
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
        $this->add_control( 'use_icon',
            [
                'label' => esc_html__( 'Use Icon', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'icon',
            [
                'label' => esc_html__( 'Button Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ],
                'condition' => ['use_icon' => 'yes']
            ]
        );
        $this->add_control( 'icon_pos',
            [
                'label' => esc_html__( 'Icon Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'btn-icon-right',
                'options' => [
                    'btn-icon-'.$is_right => esc_html__( 'Before', 'electron' ),
                    'btn-icon-'.$is_left => esc_html__( 'After', 'electron' ),
                    'btn-icon-top' => esc_html__( 'Top', 'electron' ),
                    'btn-icon-bottom' => esc_html__( 'Bottom', 'electron' )
                ],
                'condition' => ['use_icon' => 'yes']
            ]
        );
        $this->add_control( 'icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 300
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-icon-left .electron-button-icon' => 'margin-right: {{SIZE}}px;',
                    '{{WRAPPER}} .btn-icon-right .electron-button-icon' => 'margin-left: {{SIZE}}px;',
                    '{{WRAPPER}} .btn-icon-top .electron-button-icon' => 'margin-bottom: {{SIZE}}px;',
                    '{{WRAPPER}} .btn-icon-bottom .electron-button-icon' => 'margin-top: {{SIZE}}px;'
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6
                ],
                'condition' => ['use_icon' => 'yes']
            ]
        );
        $this->add_control( 'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 300
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-button-icon i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .electron-button-icon svg' => 'width: {{SIZE}}px;height:auto;'
                ],
                'condition' => ['use_icon' => 'yes']
            ]
        );
        $this->add_control( 'full',
            [
                'label' => esc_html__( 'Full width', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before'
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
                    'electron-gradient' => esc_html__( 'Gradient BG', 'electron' ),
                    'electron-btn-text' => esc_html__( 'Simple Text', 'electron' )
                ]
            ]
        );
        $this->add_control( 'gradient_type',
            [
                'label' => esc_html__( 'Gradient Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'electron-grad-blue',
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
                'default' => 'electron-btn-primary',
                'options' => [
                    'electron-btn-primary' => esc_html__( 'Primary', 'electron' ),
                    'electron-btn-secondary' => esc_html__( 'Secondary', 'electron' ),
                    'electron-btn-success' => esc_html__( 'Success', 'electron' ),
                    'electron-btn-dark' => esc_html__( 'Black', 'electron' ),
                    'electron-btn-dark-soft' => esc_html__( 'Black Soft', 'electron' ),
                    'electron-btn-light' => esc_html__( 'White', 'electron' ),
                    'electron-btn-light-soft' => esc_html__( 'White Soft', 'electron' ),
                    'electron-btn-brown' => esc_html__( 'Brown', 'electron' ),
                    'electron-btn-cream' => esc_html__( 'Cream', 'electron' ),
                    'electron-btn-red' => esc_html__( 'Red', 'electron' ),
                    'electron-btn-red-dark' => esc_html__( 'Red Dark', 'electron' ),
                    'electron-btn-red-soft' => esc_html__( 'Red Soft', 'electron' ),
                    'electron-btn-gray' => esc_html__( 'Gray', 'electron' ),
                    'electron-btn-gray-soft' => esc_html__( 'Gray Soft', 'electron' ),
                    'electron-btn-gray-dark' => esc_html__( 'Gray Dark', 'electron' ),
                    'electron-btn-green' => esc_html__( 'Green', 'electron' ),
                    'electron-btn-green-soft' => esc_html__( 'Green Soft', 'electron' ),
                    'electron-btn-green-bg' => esc_html__( 'Green BG', 'electron' ),
                    'electron-btn-blue' => esc_html__( 'Blue', 'electron' ),
                    'electron-btn-blue-dark' => esc_html__( 'Blue Dark', 'electron' ),
                    'electron-btn-blue-soft' => esc_html__( 'Blue Soft', 'electron' ),
                    'electron-btn-blue-bg' => esc_html__( 'Blue BG', 'electron' ),
                    'electron-btn-purple' => esc_html__( 'Purple', 'electron' ),
                    'electron-btn-purple-soft' => esc_html__( 'Purple Soft', 'electron' ),
                    'electron-btn-purple-bg' => esc_html__( 'Purple BG', 'electron' ),
                    'electron-btn-yellow' => esc_html__( 'Yellow', 'electron' ),
                    'electron-btn-yellow-soft' => esc_html__( 'Yellow Soft', 'electron' ),
                    'electron-btn-yellow-bg' => esc_html__( 'Yellow BG', 'electron' ),
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
                'default' => 'electron-btn-medium',
                'options' => [
                    'electron-btn-large' => esc_html__( 'Large', 'electron' ),
                    'electron-btn-medium' => esc_html__( 'Medium', 'electron' ),
                    'electron-btn-small' => esc_html__( 'Small', 'electron' )
                ],
                'condition' => ['bg_type!' => 'electron-btn-text']
            ]
        );
        $this->add_responsive_control( 'btn_minw',
            [
                'label' => esc_html__( 'Min Width ( px )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    'px' => [
                        'max' => 2000,
                        'min' => 0
                    ],
                    '%' => [
                        'max' => 100,
                        'min' => 0
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-button-inner' => 'min-width: {{SIZE}}{{UNIT}};'
                ],
                'condition' => ['bg_type!' => 'electron-btn-text']
            ]
        );
        $this->add_responsive_control( 'btn_minh',
            [
                'label' => esc_html__( 'Min Height ( px )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 1500]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-button-inner' => 'min-height: {{SIZE}}px;',
                ],
                'condition' => ['bg_type!' => 'electron-btn-text']
            ]
        );
        $this->add_control( 'btn_radius',
            [
                'label' => esc_html__( 'Border Radius ( px )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 2000]
                ],
                'selectors' => ['{{WRAPPER}} .electron-btn' => 'border-radius: {{SIZE}}px;'],
                'condition' => ['bg_type!' => 'electron-btn-text']
            ]
        );
        $this->end_controls_section();
        /*****   End Button Options   ******/

        /***** Tooltips Style ******/
        $this->start_controls_section('btn_tooltips_styling',
            [
                'label' => esc_html__( 'Tooltips', 'electron' )
            ]
        );
        $this->add_control( 'tooltips',
            [
                'label' => esc_html__( 'Tooltips', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before'
            ]
        );
        $this->add_control( 'tooltiptext',
            [
                'label' => esc_html__( 'Tooltip Text', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => esc_html__( 'Button Text', 'electron' ),
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_pos',
            [
                'label' => esc_html__( 'Tooltip Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__( 'Top', 'electron' ),
                    'right' => esc_html__( 'Right', 'electron' ),
                    'bottom' => esc_html__( 'Bottom', 'electron' ),
                    'left' => esc_html__( 'Left', 'electron' )
                ],
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_trigger',
            [
                'label' => esc_html__( 'Tooltip Open Action', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'click',
                'options' => [
                    'hover' => esc_html__( 'Hover', 'electron' ),
                    'click' => esc_html__( 'Click', 'electron' ),
                ],
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_animation',
            [
                'label' => esc_html__( 'Tooltip Animation', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => esc_html__( 'fade', 'electron' ),
                    'grow' => esc_html__( 'grow', 'electron' ),
                    'swing' => esc_html__( 'swing', 'electron' ),
                    'slide' => esc_html__( 'slide', 'electron' ),
                    'fall' => esc_html__( 'fall', 'electron' ),
                ],
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_theme',
            [
                'label' => esc_html__( 'Tooltip Theme', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'default', 'electron' ),
                    'light' => esc_html__( 'light', 'electron' ),
                    'punk' => esc_html__( 'punk', 'electron' ),
                    'noir' => esc_html__( 'noir', 'electron' ),
                    'shadow' => esc_html__( 'shadow', 'electron' ),
                ],
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_arrow',
            [
                'label' => esc_html__( 'Tooltips Arrow', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltiptext_style_heading',
            [
                'label' => esc_html__( 'TOOLTIP STYLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_maxWidth',
            [
                'label' => esc_html__( 'Max Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000
                    ]
                ],
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_offsetx',
            [
                'label' => esc_html__( 'Spacing X', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300
                    ]
                ],
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_offsety',
            [
                'label' => esc_html__( 'Spacing Y', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300
                    ]
                ],
                'condition' => ['tooltips' => 'yes']
            ]
        );
        $this->add_control( 'tooltip_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
            ]
        );
        $this->add_control( 'tooltip_brdcolor',
            [
                'label' => esc_html__( 'Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
            ]
        );
        $this->end_controls_section();
        /*****   End Button Options   ******/

        /***** Button Style ******/
        $this->start_controls_section('btn_styling',
            [
                'label' => esc_html__( 'Button Style', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('btn_tabs');
        $this->start_controls_tab( 'btn_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'electron' ) ]
        );
        $this->add_control( 'btn_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-btn' => 'color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-btn-text'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-btn',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-btn',
                'separator' => 'before'
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab('btn_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'electron' ) ]
        );
        $this->add_control( 'btn_hvr_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-btn:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvr_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-btn:hover',
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-btn:hover',
                'separator' => 'before'
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control( 'btn_overlaycolor',
            [
                'label' => esc_html__( 'Background Image Overlay Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-btn' => 'position:relative;overflow:hidden;',
                    '{{WRAPPER}} .electron-btn:before' => 'content:"";position:absolute;width:100%;height:100%;top:0;left:0;background-color: {{VALUE}};z-index:0;',
                    '{{WRAPPER}} .electron-btn i' => 'position:relative;z-index:1;',
                    '{{WRAPPER}} .electron-btn .btn-text' => 'position:relative;z-index:2;',
                ]
            ]
        );
        $this->end_controls_section();
        /***** End Button Styling *****/
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $settingsid = $this->get_id();
        $edit       = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-edit' : '';

        $tooltipsdata = json_encode(array(
            'position'  => $settings['tooltip_pos'],
            'arrow'     => 'yes' == $settings['tooltip_arrow'] ? true : false,
            'maxwidth'  => empty( $settings['tooltip_maxWidth']['size'] ) || 0 == $settings['tooltip_maxWidth']['size'] ? 'auto' : $settings['tooltip_maxWidth']['size'],
            'trigger'   => $settings['tooltip_trigger'],
            'theme'     => 'tooltipster-'.$settings['tooltip_theme'],
            'animation' => $settings['tooltip_animation'],
            'offsetx'   => !empty( $settings['tooltip_offsetx']['size'] ) ? $settings['tooltip_offsetx']['size'] : '',
            'offsety'   => !empty( $settings['tooltip_offsety']['size'] ) ? $settings['tooltip_offsety']['size'] : '',
            'bgcolor'   => $settings['tooltip_bgcolor'],
            'brdcolor'  => $settings['tooltip_brdcolor'],
            'content'   => $settings['tooltiptext'] ? do_shortcode($settings['tooltiptext']) : ''
        ));

        $tooltips = '';
        if ( $settings['tooltips'] == 'yes' ) {
            wp_enqueue_style( 'tooltipster');
            wp_enqueue_script( 'tooltipster');
            $tooltips = ' data-electron-tooltip'.$edit.'=\''.$tooltipsdata.'\'';
        }

        $data_imgs = $data = '';

        $href  = !empty( $settings['link']['url'] ) ? $settings['link']['url'] : '';
        $data  = !empty( $settings['link']['is_external'] ) ? ' target="_blank"' : '';
        $data .= !empty( $settings['link']['nofollow'] ) ? ' rel="nofollow"' : '';

        if ( $settings['btn_action'] != 'link' ) {
            wp_enqueue_script( 'magnific');
            switch ($settings['btn_action']) {
                case 'image':
                    $title = $settings['ltitle'] ? ' title="'.$settings['ltitle'].'"' : '';
                    $data = ' data-electron-lightbox'.$edit.'=\'{"type":"image"}\'';
                    $href = $settings['image']['url'];
                break;
                case 'gallery':
                    $title = $settings['ltitle'] ? ' title="'.$settings['ltitle'].'"' : '';
                    $data = ' data-electron-lightbox'.$edit.'=\'{"type":"gallery"}\'';
                    $dataimgs = array();

                    if ( !empty( $settings['images'] ) ){
                		foreach ( $settings['images'] as $image ) {
                			array_push($dataimgs, ["src" => $image['url'] ]);
                		}
                        $data_imgs = ' data-electron-lightbox-gallery'.$edit.'=\''.json_encode($dataimgs).'\'';
                        $href = $settings['images'][0]['url'];
            		}
                break;
                case 'youtube':
                    $data = ' data-electron-lightbox'.$edit.'=\'{"type":"iframe"}\'';
                    $href = $settings['youtube'] ? $settings['youtube'] : 'http://www.youtube.com/watch?v=AeeE6PyU-dQ';
                break;
                case 'vimeo':
                    $data = ' data-electron-lightbox'.$edit.'=\'{"type":"iframe"}\'';
                    $href = $settings['vimeo'] ? $settings['vimeo'] : 'https://vimeo.com/39493181';
                break;
                case 'map':
                    $data = ' data-electron-lightbox'.$edit.'=\'{"type":"iframe"}\'';
                    $href = $settings['map'] ? $settings['map'] : 'https://maps.google.com/maps?q=221B+Baker+Street,+London,+United+Kingdom&amp;hl=en&amp;t=v&amp;hnear=221B+Baker+St,+London+NW1+6XE,+United+Kingdom';
                break;
                case 'html5':
                    $data = ' data-electron-lightbox'.$edit.'=\'{"type":"iframe"}\'';
                    $href = $settings['html5'] ? $settings['html5'] : '';
                break;
                case 'modal':
                    $data = ' data-electron-lightbox'.$edit.'=\'{"type":"inline"}\'';
                    $href = '#modal_'.$settingsid;
                break;
                default:

                break;
            }
        }

        $iconpos = $settings['icon_pos'];
        $bg     = 'gradient' == $settings['bg_type'] ? $settings['gradient_type'] : $settings['color_type'];
        $class  = 'type-widget electron-btn';
        $class .= ' '.$bg;
        $class .= ' '.$settings['bg_type'];
        $class .= ' '.$settings['radius_type'];
        $class .= ' '.$settings['size'];
        $class .= !empty( $settings['icon']['value'] ) ? ' '.$iconpos : '';
        $class .= $settings['use_icon'] == 'yes' ? ' has-icon' : '';
        $class .= $settings['full'] == 'yes' ? ' is-full' : '';

        $attr  = $settings['btn_id'] ? ' id="'.$settings['btn_id'].'" data-id="btn-'.$settingsid.'"' : ' data-id="btn-'.$settingsid.'"';
        $attr .= ' class="'.$class.'"';
        $attr .= $data;
        $attr .= ' href="'.$href.'"';
        $attr .= ' title="'.$settings['text'].'"';
        $attr .= $tooltips;
        $attr .= $data_imgs;
        $btn_icon = $icon = '';

        if ( 'yes' == $settings['use_icon'] && !empty( $settings['icon']['value'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
            $btn_icon = ob_get_clean();
        }

        $icon = 'yes' == $settings['use_icon'] ? '<svg class="svgRight" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>' : '';
        $icon = $btn_icon ? '<span class="electron-button-icon">'.$btn_icon.'</span>' : '<span class="electron-button-icon">'.$icon.'</span>';
        $text = '<span class="btn-text" data-hover="'.$settings['text'].'"></span>';
        $pos  = $iconpos == 'btn-icon-left' || $iconpos == 'btn-icon-top' ? $icon.$text : $text.$icon;

        echo '<a'.$attr.'><span class="electron-button-inner">'.$pos.'</span></a>';

        if ( $settings['btn_action'] == 'modal' && $settings['modal_content'] ) {
            echo '<div id="modal_'.$settingsid.'" class="mfp-hide" style="position:relative; max-width:'.$settings['modal_width']['size'].'px; margin:auto; padding:30px; background-color:#ffffff;">';
                echo do_shortcode($settings['modal_content']);
            echo '</div>';
        }

        // in edit mode
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            ?>
            <script>
            jQuery(document).ready(function($){

                var myButton  = $('.electron-btn[data-id="btn-<?php echo $settingsid;?>"]'),
                    myData    = myButton.data('electron-lightbox-edit'),
                    myTooltip = myButton.data('electron-tooltip-edit');

                if (myData && myData.type) {
                    myButton.magnificPopup({
                        type: myData.type,
                        modal: false
                    });
                }

                if (myTooltip) {
                    myButton.tooltipster({
                        position      : myTooltip.position,
                        content       : myTooltip.content,
                        animation     : myTooltip.animation,
                        theme         : myTooltip.theme,
                        trigger       : myTooltip.trigger,
                        offsetX       : myTooltip.offsetx,
                        offsetY       : myTooltip.offsety,
                        arrow         : myTooltip.arrow,
                        maxWidth      : myTooltip.maxwidth,
                        contentAsHTML : true,
                        hideOnClick   : true,
                        interactive   : true,
                        touchDevices  : true,
                        functionReady : function(){
                            var id  = this.__namespace,
                                bg  = myTooltip.bgcolor != '' ? myTooltip.bgcolor : '',
                                brd = myTooltip.brdcolor != '' ? myTooltip.brdcolor : '',
                                pos = myData.position;

                            $('#'+id+' .tooltipster-box').css({
                                'background-color' : bg,
                                'border-color' : brd
                            });

                            if ( myTooltip.arrow ) {
                                $('#'+id+' .tooltipster-arrow-background').css('border-'+pos+'-color', bg);
                                $('#'+id+' .tooltipster-arrow-border').css('border-'+pos+'-color', brd);
                            }
                        }
                    });
                }
            });
            </script>
            <?php
        }
    }
}
