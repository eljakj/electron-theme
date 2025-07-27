<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Banner2 extends Widget_Base {
    public function get_name() {
        return 'electron-woo-banner2';
    }
    public function get_title() {
        return 'Banner 2';
    }
    public function get_icon() {
        return 'eicon-icon-box';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_style_depends() {
        return [ 'electron-banner' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'general_section',
            [
                'label'=> esc_html__( 'BANNER', 'electron' ),
                'tab'=> Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_responsive_control( 'box_height',
            [
                'label' => esc_html__( 'Min Box Height (px)', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 2000,
                'step' => 1,
                'default' => 360,
                'selectors' => [ '{{WRAPPER}} .electron-banner-default' => 'min-height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'bg_type',
            [
                'label' => esc_html__( 'Color Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bg-green',
                'options' => [
                    'bg-green' => esc_html__( 'Green', 'electron' ),
                    'bg-brown' => esc_html__( 'Brown', 'electron' ),
                    'bg-red' => esc_html__( 'Red', 'electron' ),
                    'bg-purple' => esc_html__( 'Purple', 'electron' ),
                    'bg-purple-soft' => esc_html__( 'Purple Soft', 'electron' ),
                    'bg-custom' => esc_html__( 'Custom Color', 'electron' )
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'bg_color',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .bg-custom',
                'condition' => ['bg_type' => 'bg-custom']
            ]
        );
        $this->add_control( 'box_text_color',
            [
                'label' => esc_html__( 'Text Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .bg-custom .title,{{WRAPPER}} .bg-custom .desc, {{WRAPPER}} .bg-custom span,{{WRAPPER}} .bg-custom .link' => 'color:{{VALUE}};' ],
                'condition' => ['bg_type' => 'bg-custom']
            ]
        );
        $this->add_control( 'banner_text_heading',
            [
                'label' => esc_html__( 'TEXT', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Iphone 15 Promax',
                'label_block' => true,
            ]
        );
        $this->add_control( 'tag',
            [
                'label' => esc_html__( 'Title Tag', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => [
                    'h1' => esc_html__( 'H1', 'electron' ),
                    'h2' => esc_html__( 'H2', 'electron' ),
                    'h3' => esc_html__( 'H3', 'electron' ),
                    'h4' => esc_html__( 'H4', 'electron' ),
                    'h5' => esc_html__( 'H5', 'electron' ),
                    'h6' => esc_html__( 'H6', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' )
                ]
            ]
        );
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Short Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Free Shipping On Over $50',
                'label_block' => true
            ]
        );
        $this->add_control( 'btn_title',
            [
                'label' => esc_html__( 'Button Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'See More Products',
                'label_block' => true
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
        $this->add_control( 'link_aria',
            [
                'label' => esc_html__( 'Link Aria Label (SEO))', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'See More Products',
                'label_block' => true
            ]
        );
        $this->add_control( 'box_link',
            [
                'label' => esc_html__( 'Add Link to Box', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'banner_image_heading',
            [
                'label' => esc_html__( 'IMAGE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => '']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'thumbnail',
            ]
        );
        $this->add_control('img_bottom_position',
            [
                'label' => esc_html__( 'Image Vertical Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-banner-default img' => 'bottom: {{SIZE}}px;'],
            ]
        );
        $this->add_control('img_left_position',
            [
                'label' => esc_html__( 'Image Horizontal Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-banner-default img' => 'left: {{SIZE}}px;']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label' => esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control( 'box_padding',
            [
                'label' => esc_html__( 'Box Content Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-default' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .electron-banner-default'
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Box Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-banner-default' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}']
            ]
        );
        $this->add_control( 'text_divider',
            [
                'label' => esc_html__( 'TEXT', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'text_hvrcolor',
            [
                'label' => esc_html__( 'Hover Text Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-default:hover,{{WRAPPER}} .electron-banner-default:hover a' => 'color:{{VALUE}};' ],
                'condition' => ['box_link' => 'yes']
            ]
        );
        $this->add_control('text_gap',
            [
                'label' => esc_html__( 'Gap', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-banner-default .content' => 'gap: {{SIZE}}px;'],
            ]
        );
        $this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Text Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .electron-banner-default' => 'text-align: {{VALUE}};'],
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
                'default' => 'flex-start'
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-default .title' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-default .desc' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'link_color',
            [
                'label' => esc_html__( 'Link Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-default .link' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'link_hvrcolor',
            [
                'label' => esc_html__( 'Link Color ( Hover )', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-banner-default .link:hover span' => 'color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $html = $link = '';

        if ( !empty( $settings['link']['url'] ) ) {
            $link  = ' href="'.$settings['link']['url'].'"';
            $link .= !empty( $settings['link']['is_external'] ) ? ' target="_blank"' : '';
            $link .= !empty( $settings['link']['nofollow'] ) ? ' rel="nofollow"' : '';
            $link .= $settings['link_aria'] ? ' title="'.$settings['link_aria'].'"' : '';
        }

        if ( 'yes' == $settings['box_link'] && !empty( $settings['link']['url'] ) ) {
            $html .= '<a class="box-link"'.$link.'></a>';
        }

        $html .= '<div class="content">';
            if ( $settings['title'] ) {
                $html .= '<'.$settings['tag'].' class="title">'.$settings['title'].'</'.$settings['tag'].'>';
            }
            if ( $settings['desc'] ) {
                $html .= '<p class="desc">'.$settings['desc'].'</p>';
            }
            if ( $settings['btn_title'] ) {
                if ( 'yes' == $settings['box_link'] ) {
                    $html .= '<span class="link">'.$settings['btn_title'].'</span>';
                } else {
                    $html .= '<a class="link electron-btn-text"'.$link.'><span class="btn-text" data-hover="'.$settings['btn_title'].'"></span></a>';
                }
            }
        $html .= '</div>';
        if ( !empty( $settings['image']['id'] ) ) {
            $html .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
        }
        // final output html
        echo '<div class="electron-banner-default '.$settings['bg_type'].'">'.$html.'</div>';
    }
}
