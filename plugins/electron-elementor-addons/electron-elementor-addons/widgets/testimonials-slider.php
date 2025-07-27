<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Testimonials extends Widget_Base {
    public function get_name() {
        return 'electron-testimonials';
    }
    public function get_title() {
        return 'Testimonials Carousel';
    }
    public function get_icon() {
        return 'eicon-testimonial';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    public function get_style_depends() {
        return [ 'electron-testimonials' ];
    }

    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'items_settings',
            [
                'label' => esc_html__('Testimonials Items', 'electron'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'type',
            [
                'label' => esc_html__( 'Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__( 'Type 1', 'electron' ),
                    '2' => esc_html__( 'Type 2', 'electron' ),
                    '3' => esc_html__( 'Type 3', 'electron' )
                ]
            ]
        );
        $this->add_control( 'alignment',
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
                'default' => 'center'
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'name',
            [
                'label' => esc_html__( 'Name', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Sam Peters',
                'label_block' => true
            ]
        );
        $repeater->add_control( 'pos',
            [
                'label' => esc_html__( 'Position', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'CEO Solar Systems LLC',
                'label_block' => true
            ]
        );
        $repeater->add_control( 'text',
            [
                'label' => esc_html__( 'Quote', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true
            ]
        );
        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Avatar', 'electron' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $this->add_control( 'items',
            [
                'label' => esc_html__( 'Items', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{name}}',
                'default' => [
                    [
                        'name' => 'Jessica Brown',
                        'pos' => 'Customer',
                        'text' => 'This is due to their excellent service, competitive pricing and customer support. It’s throughly refresing to get such a personal touch. Duis aute lorem ipsum is simply free text irure dolor in reprehenderit in esse nulla pariatur'
                    ],
                    [
                        'name' => 'Caleb Hoffman',
                        'pos' => 'Customer',
                        'text' => 'This is due to their excellent service, competitive pricing and customer support. It’s throughly refresing to get such a personal touch. Duis aute lorem ipsum is simply free text irure dolor in reprehenderit in esse nulla pariatur'
                    ],
                    [
                        'name' => 'Bradley Kim',
                        'pos' => 'Customer',
                        'text' => 'This is due to their excellent service, competitive pricing and customer support. It’s throughly refresing to get such a personal touch. Duis aute lorem ipsum is simply free text irure dolor in reprehenderit in esse nulla pariatur'
                    ]
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'thumbnail',
            ]
        );
        $this->add_responsive_control( 'image_border_radius',
            [
                'label' => esc_html__( 'Image Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-testimonials img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_control( 'ntag',
            [
                'label' => esc_html__( 'Name Tag', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h5',
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
        $this->add_control( 'mditems',
            [
                'label' => esc_html__( 'Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'smitems',
            [
                'label' => esc_html__( 'Items Tablet', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->add_control( 'xsitems',
            [
                'label' => esc_html__( 'Items Phone', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 2,
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
        $this->start_controls_section('navs_style_section',
            [
                'label'=> esc_html__( 'SLIDER NAV STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => ['nav' => 'yes']
            ]
        );
        $this->add_control( 'navs_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:after' => 'font-size:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-theme-style .swiper-button-prev:hover:after,{{WRAPPER}} .electron-swiper-theme-style .swiper-button-next:hover:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('dots_style_section',
            [
                'label'=> esc_html__( 'SLIDER DOTS STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => ['dots' => 'yes']
            ]
        );
        $this->add_control( 'dots_top_offset',
            [
                'label' => esc_html__( 'Top Offset', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -300,
                'max' => 300,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-swiper-theme-style .swiper-pagination-bullets' => 'margin-top:{{SIZE}}px;' ]
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
                'selectors' => [ '{{WRAPPER}} .electron-swiper-theme-style .swiper-pagination-bullets' => 'text-align:{{VALUE}};' ]
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
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet:before' => 'width:{{SIZE}}px;height:{{SIZE}}px;' ]
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
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet + .swiper-pagination-bullet' => 'margin: 0;margin-left: {{SIZE}}px;',
                    '{{WRAPPER}} .swiper-pagination-horizontal.swiper-pagination-bullets .swiper-pagination-bullet + .swiper-pagination-bullet' => 'margin: 0;margin-left: {{SIZE}}px;',
                ]
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
                'selectors' => ['{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet',
            ]
        );
        $this->add_responsive_control( 'dots_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet:before,{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_hvrborder',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active'
            ]
        );
        $this->add_responsive_control( 'dots_hvrborder_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active:before,{{WRAPPER}} .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('style_section',
            [
                'label'=> esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control( 'box_sdivider',
            [
                'label' => esc_html__( 'ITEM BOX', 'electron' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'box_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-testimonial-item' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'box_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .testimonial-item'
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-testimonial-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'name_sdivider',
            [
                'label' => esc_html__( 'NAME', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'name_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-testimonial-info .name' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-testimonial-info .name'
            ]
        );
        $this->add_control( 'pos_sdivider',
            [
                'label' => esc_html__( 'POSITION / JOB', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'pos_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-testimonial-info span' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pos_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-testimonial-info span'
            ]
        );
        $this->add_control( 'text_sdivider',
            [
                'label' => esc_html__( 'TEXT', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'text_spacing',
            [
                'label' => esc_html__( 'Text Content Spacing', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'step' => 1,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-testimonial-1 .electron-testimonial-content' => 'margin-top:{{SIZE}};',
                    '{{WRAPPER}} .electron-testimonial-2 .electron-testimonial-content' => 'margin-bottom:{{SIZE}};',
                    '{{WRAPPER}} .electron-testimonial-3 .electron-testimonial-content' => 'margin-top:{{SIZE}};'
                ]
            ]
        );
        $this->add_control( 'text_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-testimonial-content p' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-testimonial-content p'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        
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
                "lazy"          => false,
                "navigation" => [
                    "nextEl" => ".slide-next-{$id}",
                    "prevEl" => ".slide-prev-{$id}"
                ],
                "pagination" => [
                    "el" => ".electron-pagination-$id",
                    "bulletClass" => "electron-swiper-bullet",
                    "bulletActiveClass" => "active",
                    "type" => "bullets",
                    "clickable" => true
                ],
                "breakpoints" => [
                    "0" => [
                        "slidesPerView" => $settings['xsitems'],
                        "slidesPerGroup" => $settings['xsitems']
                    ],
                    "768" => [
                        "slidesPerView" => $settings['smitems'],
                        "slidesPerGroup" => $settings['smitems']
                    ],
                    "1024" => [
                        "slidesPerView" => $settings['mditems'],
                        "slidesPerGroup" => $settings['mditems']
                    ]
                ]
            )
        );
        $html = '';
        foreach ( $settings['items'] as $item ) {
            if ( '1' == $settings['type'] ) {
                $html .= '<div class="electron-testimonial-item swiper-slide">';
                    $html .= '<div class="electron-testimonial-info">';
                        if ( !empty( $item['image']['id'] ) ) {
                            $html .= '<div class="electron-testimonial-avatar">';
                                echo wp_get_attachment_image( $item['image']['id'], $size, false, ['class'=>'t-img'] );
                            $html .= '</div>';
                        }
                        if ( !empty( $item['name'] ) ) {
                            $html .= '<div class="electron-testimonial-info">';
                                if ( !empty( $item['name'] ) ) {
                                    if ( is_rtl() ) {
                                        $position = !empty( $item['pos'] ) ? ' <span class="electron-small-title position">'.$item['pos'].' \ </span> ' : '';
                                        $html .= '<'.$settings['ntag'].' class="name">'.$position.$item['name'].'</'.$settings['ntag'].'>';
                                    } else {
                                        $position = !empty( $item['pos'] ) ? '<span class="electron-small-title position"> / '.$item['pos'].'</span>' : '';
                                        $html .= '<'.$settings['ntag'].' class="name">'.$item['name'].$position.'</'.$settings['ntag'].'>';
                                    }
                                }
                            $html .= '</div>';
                        }
                    $html .= '</div>';
                    if ( !empty( $item['text'] ) ) {
                        $html .= '<div class="electron-testimonial-content"><p>'.$item['text'].'</p></div>';
                    }
                $html .= '</div>';
            }

            if ( '2' == $settings['type'] ) {
                $html .= '<div class="electron-testimonial-item swiper-slide">';
                    if ( !empty( $item['text'] ) ) {
                        $html .= '<div class="electron-testimonial-content">';
                            $html .= '<p>'.$item['text'].'</p>';
                        $html .= '</div>';
                    }
                    $html .= '<div class="electron-testimonial-info electron-flex electron-align-center electron-flex-center">';
                        if ( !empty( $item['image']['id'] ) ) {
                            $html .= '<div class="electron-testimonial-avatar">';
                                echo wp_get_attachment_image( $item['image']['id'], $size, false, ['class'=>'t-img'] );
                            $html .= '</div>';
                        }
                        if ( !empty( $item['name'] ) || !empty( $item['pos'] ) ) {
                            $html .= '<div class="electron-testimonial-text">';
                                if ( !empty( $item['name'] ) ) {
                                    $html .= '<'.$settings['ntag'].' class="name mb-0">'.$item['name'].'</'.$settings['ntag'].'>';
                                }
                                if ( !empty( $item['pos'] ) ) {
                                    $html .= '<span class="electron-small-title position">'.$item['pos'].'</span>';
                                }
                            $html .= '</div>';
                        }
                    $html .= '</div>';
                $html .= '</div>';
            }

            if ( '3' == $settings['type'] ) {
                $html .= '<div class="electron-testimonial-item swiper-slide">';
                    $html .= '<div class="electron-testimonial-info electron-flex electron-align-center electron-flex-center">';
                        if ( !empty( $item['image']['id'] ) ) {
                            $html .= '<div class="electron-testimonial-avatar">';
                                echo wp_get_attachment_image( $item['image']['id'], $size, false, ['class'=>'t-img'] );
                            $html .= '</div>';
                        }
                        if ( !empty( $item['name'] ) || !empty( $item['pos'] ) ) {
                            $html .= '<div class="electron-testimonial-text">';
                                if ( !empty( $item['name'] ) ) {
                                    $html .= '<'.$settings['ntag'].' class="name mb-0">'.$item['name'].'</'.$settings['ntag'].'>';
                                }
                                if ( !empty( $item['pos'] ) ) {
                                    $html .= '<span class="electron-small-title position">'.$item['pos'].'</span>';
                                }
                            $html .= '</div>';
                        }
                    $html .= '</div>';
                    if ( !empty( $item['text'] ) ) {
                        $html .= '<div class="electron-testimonial-content"><p>'.$item['text'].'</p></div>';
                    }
                $html .= '</div>';
            }
        }

        echo '<div class="electron-testimonials electron-swiper-theme-style swiper-container electron-swiper-slider'.$editmode.'" data-swiper-options=\''.$slider_options.'\'>';
            echo '<div class="swiper-wrapper">'.$html.'</div>';
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
