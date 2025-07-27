<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Team_Slider extends Widget_Base {
    public function get_name() {
        return 'electron-team-slider';
    }
    public function get_title() {
        return 'Team Carousel';
    }
    public function get_icon() {
        return 'eicon-carousel';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    public function get_style_depends() {
        return [ 'electron-team' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'items_settings',
            [
                'label' => esc_html__('Images Items', 'electron'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'slider_title',
            [
                'label' => esc_html__( 'Slider Title', 'electron' ),
                'type' => Controls_Manager::TEXTAREA
            ]
        );
        $this->add_control( 'title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => esc_html__( 'H1', 'electron' ),
                    'h2' => esc_html__( 'H2', 'electron' ),
                    'h3' => esc_html__( 'H3', 'electron' ),
                    'h4' => esc_html__( 'H4', 'electron' ),
                    'h5' => esc_html__( 'H5', 'electron' ),
                    'h6' => esc_html__( 'H6', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' )
                ],
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_control( 'type',
            [
                'label' => esc_html__( 'Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'classic' => esc_html__( 'Classic', 'electron' ),
                    'card' => esc_html__( 'Card', 'electron' ),
                ],
                'default' => 'classic'
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $repeater->add_control( 'name',
            [
                'label' => esc_html__( 'Name', 'electron' ),
                'type' => Controls_Manager::TEXT
            ]
        );
        $repeater->add_control( 'position',
            [
                'label' => esc_html__( 'Position', 'electron' ),
                'type' => Controls_Manager::TEXT
            ]
        );
        $repeater->add_control( 'image_link',
            [
                'label' => esc_html__( 'Image Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [],
                'show_external' => true
            ]
        );
        $repeater->add_control( 'socials',
            [
                'label' => esc_html__( 'Social Links', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'items',
            [
                'label' => esc_html__( 'Items', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => 'Image',
                'default' => []
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
	            'name' => 'thumbnail',
	            'default' => 'medium_large'
            ]
        );
        $this->add_control( 'fitsize',
            [
                'label' => esc_html__( 'Fit Size', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_responsive_control('team_box_height',
            [
                'label' => esc_html__( 'Box Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-team-image-wrapper.fit-size' => 'padding-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => ['fitsize' => 'yes']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('slider_options_section',
            [
                'label'=> esc_html__( 'SLIDER OPTIONS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'loop',
            [
                'label' => esc_html__( 'Infinite', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'centermode',
            [
                'label' => esc_html__( 'Center Mode', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'item_opacity',
            [
                'label' => esc_html__( 'Inactive Item Opacity', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.01,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-slide:not(.swiper-slide-active)' => 'opacity:{{SIZE}};' ],
                'condition' => ['centermode' => 'yes']
            ]
        );
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Navigation', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'dots',
            [
                'label' => esc_html__( 'Dots', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'space',
            [
                'label' => esc_html__( 'Space Between Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 30
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 10000,
                'step' => 100,
                'default' => 1000
            ]
        );
        $this->add_control( 'desktop',
            [
                'label' => esc_html__( 'Desktop', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'laptop',
            [
                'label' => esc_html__( 'Laptop', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'tablet_extra',
            [
                'label' => esc_html__( 'Tablet Extra', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->add_control( 'tablet',
            [
                'label' => esc_html__( 'Tablet', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'phone_extra',
            [
                'label' => esc_html__( 'Phone Extra', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'step' => 1,
                'default' => 1
            ]
        );
        $this->add_control( 'phone',
            [
                'label' => esc_html__( 'Phone', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 4,
                'step' => 1,
                'default' => 1
            ]
        );
        $this->add_control( 'effect',
            [
                'label' => esc_html__( 'Effect', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => esc_html__( 'Slide', 'electron' ),
                    'flip' => esc_html__( 'flip', 'electron' ),
                    'coverflow' => esc_html__( 'Coverflow', 'electron' ),
                    'creative' => esc_html__( 'Creative', 'electron' ),
                ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('image_style_section',
            [
                'label'=> esc_html__( 'BOX STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'slider_title_divider',
            [
                'label' => esc_html__( 'SLIDER TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'slider_title_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-slider-nav-title',
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_control( 'slider_title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-slider-nav-title' => 'color:{{VALUE}};' ],
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_responsive_control( 'slider_title_alignment',
            [
                'label' => esc_html__( 'Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
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
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-section-title-wrapper' => 'text-align:{{VALUE}};' ],
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_responsive_control( 'title_spacing',
            [
                'label' => esc_html__( 'Bottom Spacing ( px )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 300]
                ],
				'default' => [
					'unit' => 'px',
					'size' => 30
				],
                'selectors' => [
                    '{{WRAPPER}} .electron-section-title-wrapper' => 'margin-bottom: {{SIZE}}px;'
                ],
                'condition' => [ 'slider_title!' => '' ]
            ]
        );
        $this->add_control( 'slider_item_name_divider',
            [
                'label' => esc_html__( 'NAME', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-team-name'
            ]
        );
        $this->add_control( 'name_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-team-name' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'slider_item_position_divider',
            [
                'label' => esc_html__( 'POSITION', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-team-position'
            ]
        );
        $this->add_control( 'position_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-team-position' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'slider_item_social_divider',
            [
                'label' => esc_html__( 'SOCIALS', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control( 'social_size',
            [
                'label' => esc_html__( 'Social Icon Size ( px )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 100]
                ],
				'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .electron-team-socials' => 'font-size: {{SIZE}}px;'
                ]
            ]
        );
        $is_rtl = is_rtl() ? 'right' : 'left';
        $this->add_responsive_control( 'social_spacing',
            [
                'label' => esc_html__( 'Social Icon Size ( px )', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 100]
                ],
				'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .electron-team-socials a + a' => 'margin-'.$is_rtl.': {{SIZE}}px;'
                ]
            ]
        );
        $this->add_control( 'social_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-team-socials a:hover' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'slider_item_divider',
            [
                'label' => esc_html__( 'BOX', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'card_text_coontent_bgcolor',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-team-slider.type-card .electron-team-details' => 'background-color:{{VALUE}};' ],
                'condition' => [ 'type!' => 'card' ]
            ]
        );
        $this->start_controls_tabs( 'box_tabs');
        $this->start_controls_tab( 'image_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'electron' ) ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-team-item-wrapper'
            ]
        );
        $this->add_responsive_control( 'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-team-item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'image_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'electron' ) ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_hvrborder',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-team-item-wrapper:hover'
            ]
        );
        $this->add_responsive_control( 'image_hvrborder_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-team-item-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('navs_style_section',
            [
                'label'=> esc_html__( 'SLIDER NAV STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'nav' => 'yes' ]
            ]
        );
        $this->add_control( 'navs_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 300,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-prev,{{WRAPPER}} .electron-swiper-next' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_arrow_size',
            [
                'label' => esc_html__( 'Arrow Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-prev:after,{{WRAPPER}} .electron-swiper-next:after' => 'font-size:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_color',
            [
                'label' => esc_html__( 'Arrow Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-prev:after,{{WRAPPER}} .electron-swiper-next:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrcolor',
            [
                'label' => esc_html__( 'Hover Arrow Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-prev:hover:after,{{WRAPPER}} .electron-swiper-next:hover:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-nav-bg' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-nav-bg:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'navs_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-nav-bg',
            ]
        );
        $this->add_control( 'navs_hvrbrdcolor',
            [
                'label' => esc_html__( 'Hover Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-nav-bg:hover' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'navs_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-nav-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('dots_style_section',
            [
                'label'=> esc_html__( 'SLIDER DOTS STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'dots' => 'yes' ]
            ]
        );
        $this->add_control( 'dots_top_offset',
            [
                'label' => esc_html__( 'Top Offset', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets' => 'margin-top:{{SIZE}}px;' ]
            ]
        );
        $this->add_responsive_control( 'dots_alignment',
            [
                'label' => esc_html__( 'Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
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
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets' => 'text-align:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'dots_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-bullet:before' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'dots_space',
            [
                'label' => esc_html__( 'Space', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-bullet + .electron-swiper-bullet' => 'margin: 0;margin-left: {{SIZE}}px;']
            ]
        );
        $this->start_controls_tabs( 'dots_nav_tabs');
        $this->start_controls_tab( 'dots_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'electron' ) ]
        );
        $this->add_control( 'dots_bgcolor',
            [
                'label' => esc_html__( 'Background', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-bullet:before' => 'background-color:{{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
            ]
        );
        $this->add_responsive_control( 'dots_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-swiper-bullet:before,{{WRAPPER}} .selectron-swiper-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'dots_hover_tab',
            [ 'label' => esc_html__( 'Active', 'electron' ) ]
        );
        $this->add_control( 'dots_hvrbgcolor',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-bullet.active:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_hvrborder',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-swiper-bullet.active'
            ]
        );
        $this->add_responsive_control( 'dots_hvrborder_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-swiper-bullet.active:before,{{WRAPPER}} .selectron-swiper-bullet.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();

        wp_enqueue_style( 'electron-team' );

        $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : [100,100];
        if ( 'custom' == $size ) {
            $sizew = $settings['thumbnail_custom_dimension']['width'];
            $sizeh = $settings['thumbnail_custom_dimension']['height'];
            $size  = [ $sizew, $sizeh ];
        }

        $editmode = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id: '';
        $effect = $settings['effect'];

        $slider_options = json_encode( array(
            "slidesPerView" => 1,
            "loop"          => 'yes' == $settings['loop'] ? true: false,
            "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
            "centeredSlides"=> 'yes' == $settings['centermode'] ? true: false,
            "speed"         => $settings['speed'],
            "spaceBetween"  => $settings['space'] ? $settings['space'] : 0,
            "direction"     => "horizontal",
            "wrapperClass"  => "electron-swiper-wrapper",
            "navigation" => [
                "nextEl" => ".slide-next-{$id}",
                "prevEl" => ".slide-prev-{$id}"
            ],
            "pagination" => [
                "el"                => ".electron-pagination-$id",
                "bulletClass"       => "electron-swiper-bullet",
                "bulletActiveClass" => "active",
                "type"              => "bullets",
                "clickable"         => true
            ],
        	"breakpoints" =>[
	   			"0" => [
    				"slidesPerView"  => $settings['phone'],
    				"slidesPerGroup" => $settings['phone']
	    		],
    			"576" => [
    				"slidesPerView"  => $settings['phone_extra'],
    				"slidesPerGroup" => $settings['phone_extra']
    			],
    			"881" => [
    				"slidesPerView"  => $settings['tablet'],
    				"slidesPerGroup" => $settings['tablet']
    			],
    			"1024" => [
    				"slidesPerView"  => $settings['tablet_extra'],
    				"slidesPerGroup" => $settings['tablet_extra']
    			],
    			"1200" => [
    				"slidesPerView"  => $settings['laptop'],
    				"slidesPerGroup" => $settings['laptop']
    			],
    			"1400" => [
    				"slidesPerView"  => $settings['desktop'],
    				"slidesPerGroup" => $settings['desktop']
    			]
        	]
        ));

		$fitsize = 'yes' == $settings['fitsize'] || 'card' == $settings['type'] ? ' fit-size' : '';

    	if ( $settings['slider_title'] ) {
			echo '<div class="electron-section-title-wrapper">';
                echo '<'.$settings['title_tag'].' class="electron-section-title">'.$settings['slider_title'].'</'.$settings['title_tag'].'>';
            echo '<div>';
    	}
        echo '<div class="electron-team-slider electron-swiper-container type-'.$settings['type'].' electron-swiper-slider'.$editmode.' nav-vertical-centered" data-swiper-options=\''.$slider_options.'\'>';
            echo '<div class="electron-swiper-wrapper">';
                foreach ( $settings['items'] as $item ) {
                    echo '<div class="swiper-slide">';
                        if ( !empty( $item['image']['id'] ) ) {
					        $link  = !empty( $item['link']['url'] ) ? ' href="'.$item['link']['url'].'"' : '';
					        $link .= !empty( $item['link']['is_external'] ) ? ' target="_blank"' : '';
					        $link .= !empty( $item['link']['nofollow'] ) ? ' rel="nofollow"' : '';

                        	echo '<div class="electron-team-item-wrapper">';

                        		echo '<div class="electron-team-image-wrapper'.$fitsize.'">';
                        			echo !empty( $item['link']['url'] ) ? '<a'.$link.' class="electron-team_link"></a>' : '';
                            		echo wp_get_attachment_image( $item['image']['id'], $size, false, ['class'=>'electron-team-img'] );
                            	echo '</div>';

                            	if ( !empty( $item['name'] ) || !empty( $item['socials'] ) ) {
		                        	echo '<div class="electron-team-details">';
		                        		$position = !empty( $item['position'] ) ? '<span class="electron-team-position"> '.$item['position'].'</span>' : '';
		                        		echo !empty( $item['name'] ) ? '<h6 class="electron-team-name">'.$item['name'].$position.'</h6>' : '';
		                        		echo !empty( $item['socials'] ) ? '<div class="electron-team-socials">'.$item['socials'].'</div>' : '';
		                            echo '</div>';
                            	}

                            echo '</div>';
                        }
                    echo '</div>';
                }
            echo '</div>';
            if ( 'yes' == $settings['dots'] ) {
                echo '<div class="electron-swiper-pagination electron-pagination-'.$id.' position-relative"></div>';
            }
            if ( 'yes' == $settings['nav'] ) {
                echo '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
                echo '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
            }
        echo '</div>';
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
            <script>
            jQuery(document).ready(function($) {
                var options = $('.electron-swiper-slider-<?php echo $id ?>').data('swiper-options');
                const mySlider<?php echo $id ?> = new NTSwiper('.electron-swiper-slider-<?php echo $id ?>', options);
            });
            </script>
            <?php
        }
    }
}
