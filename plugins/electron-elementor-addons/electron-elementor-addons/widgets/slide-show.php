<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Slide_Show extends Widget_Base {
    public function get_name() {
        return 'electron-slide-show';
    }
    public function get_title() {
        return 'Animated Frame Slideshow';
    }
    public function get_icon() {
        return 'eicon-carousel';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    public function get_script_depends() {
        return [ 'anime','imagesloaded','slide-show' ];
    }
    public function get_style_depends() {
        return [ 'electron-main-slider2' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'items_settings',
            [
                'label' => esc_html__('Slide Items', 'electron'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $repeater->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );
        $repeater->add_control( 'desc',
            [
                'label' => esc_html__( 'Description', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );
        $repeater->add_control( 'btn_title',
            [
                'label' => esc_html__( 'Button Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );
        $repeater->add_control( 'link',
            [
                'label' => esc_html__( 'Button Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => ''
                ],
                'show_external' => true
            ]
        );
        $repeater->add_control( 'btn_id',
            [
                'label' => esc_html__( 'Button ID', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );
        $repeater->add_control( 'btn_title2',
            [
                'label' => esc_html__( 'Button 2 Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );
        $repeater->add_control( 'link2',
            [
                'label' => esc_html__( 'Button 2 Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => ''
                ],
                'show_external' => true
            ]
        );
        $repeater->add_control( 'btn_id2',
            [
                'label' => esc_html__( 'Button 2 ID', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );
        $repeater->add_responsive_control( 'ihorz_alignment',
            [
                'label' => esc_html__( 'Horizontal Text Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}.electron-slide' => 'align-items: {{VALUE}};'],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-h-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-h-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-h-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => 'center'
            ]
        );
        $repeater->add_responsive_control( 'ivert_alignment',
            [
                'label' => esc_html__( 'Vertical Text Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}.electron-slide' => 'justify-content: {{VALUE}};'],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-v-align-top'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-v-align-bottom'
                    ]
                ],
                'toggle' => true,
                'default' => 'center'
            ]
        );
        $repeater->add_responsive_control( 'islide_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}.electron-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $repeater->add_control( 'ioverlay_color',
            [
                'label' => esc_html__( 'Overlay Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .electron-slide-img:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $repeater->add_control( 'ititle_color',
            [
                'label' => esc_html__( 'Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .electron-slide-title' => 'color:{{VALUE}};' ]
            ]
        );
        $repeater->add_control( 'idesc_color',
            [
                'label' => esc_html__( 'Description Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .electron-slide-desc' => 'color:{{VALUE}};' ]
            ]
        );
        $repeater->add_control( 'ibtn_bgcolor',
            [
                'label' => esc_html__( 'Button Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .electron-slide-link' => 'background-color:{{VALUE}};' ]
            ]
        );
        $repeater->add_control( 'ibtn_color',
            [
                'label' => esc_html__( 'Button Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .electron-slide-link' => 'color:{{VALUE}};' ]
            ]
        );
        $repeater->add_control( 'ibtn_bgcolor2',
            [
                'label' => esc_html__( 'Button 2 Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .electron-slide-link2' => 'background-color:{{VALUE}};' ]
            ]
        );
        $repeater->add_control( 'ibtn_color2',
            [
                'label' => esc_html__( 'Button 2 Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .electron-slide-link2' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'items',
            [
                'label' => esc_html__( 'Items', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => 'Image',
                'default' => [
                    [
                        'title' => 'Title 1',
                        'desc' => 'This is a description',
                        'btn_title' => 'Button Title 1'
                    ],
                    [
                        'title' => 'Title 2',
                        'desc' => 'This is a description',
                        'btn_title' => 'Button Title 1'
                    ],
                    [
                        'title' => 'Title 3',
                        'desc' => 'This is a description',
                        'btn_title' => 'Button Title 1'
                    ]
                ]
            ]
        );
        $this->add_responsive_control( 'box_height',
            [
                'label' => esc_html__( 'Slider Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                        'step' => 5,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'vh',
                    'size' => 100,
                ],
                'selectors' => [ '{{WRAPPER}} .electron-slideshow' => 'height:{{SIZE}}{{UNIT}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'thumbnail',
            'separator' => 'before',
            ]
        );
        $this->add_control( 'tag',
            [
                'label' => esc_html__( 'Title Tag for SEO', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => esc_html__( 'h1', 'electron' ),
                    'h2' => esc_html__( 'h2', 'electron' ),
                    'h3' => esc_html__( 'h3', 'electron' ),
                    'h4' => esc_html__( 'h4', 'electron' ),
                    'h5' => esc_html__( 'h5', 'electron' ),
                    'h6' => esc_html__( 'h6', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' ),
                    'span' => esc_html__( 'span', 'electron' )
                ]
            ]
        );
        $this->add_control( 'prev_title',
            [
                'label' => esc_html__( 'Button Prev Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Previous'
            ]
        );
        $this->add_control( 'next_title',
            [
                'label' => esc_html__( 'Button Next Title', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Next'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('image_style_section',
            [
                'label'=> esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_responsive_control( 'horz_alignment',
            [
                'label' => esc_html__( 'Horizontal Text Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .electron-slide' => 'align-items: {{VALUE}};'],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-h-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-h-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-h-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => 'center'
            ]
        );
        $this->add_responsive_control( 'vert_alignment',
            [
                'label' => esc_html__( 'Vertical Text Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .electron-slide' => 'justify-content: {{VALUE}};'],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'electron' ),
                        'icon' => 'eicon-v-align-top'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'electron' ),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'electron' ),
                        'icon' => 'eicon-v-align-bottom'
                    ]
                ],
                'toggle' => true,
                'default' => 'center'
            ]
        );
        $this->add_responsive_control( 'slide_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_control( 'overlay_color',
            [
                'label' => esc_html__( 'Overlay Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-slide .electron-slide-img:before' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'shape_color',
            [
                'label' => esc_html__( 'Shape Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-slideshow .shape path' => 'fill:{{VALUE}}!important;' ]
            ]
        );
        $this->add_control( 'title_divider',
            [
                'label' => esc_html__( 'TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-slide-title' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-slide-title'
            ]
        );
        $this->add_control( 'desc_divider',
            [
                'label' => esc_html__( 'DESCRIPTION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-slide-desc' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-slide-desc'
            ]
        );
        $this->add_control( 'btn_divider',
            [
                'label' => esc_html__( 'BUTTON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-slide-link'
            ]
        );
        $this->start_controls_tabs('electron_btn_tabs');
        $this->start_controls_tab( 'electron_btn_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'electron' ) ]
        );
        $this->add_control( 'btn_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-slide-link' => 'color: {{VALUE}};']
            ]
        );
        $this->add_responsive_control( 'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-slide-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-slide-link',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-slide-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-slide-link',
                'separator' => 'before'
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab('electron_btn_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'electron' ) ]
        );
         $this->add_control( 'btn_hvr_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-slide-link:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvr_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-slide-link:hover',
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-slide-link:hover',
                'separator' => 'before'
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control( 'nav_divider',
            [
                'label' => esc_html__( 'NAVIGATION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'nav_top_offset',
            [
                'label' => esc_html__( 'Bottom Offset', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -300,
                'max' => 300,
                'step' => 1,
                'default' => 50,
                'selectors' => [ '{{WRAPPER}} .electron-slidenav' => 'bottom:{{SIZE}}px;' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'nav_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-slidenav-item'
            ]
        );
        $this->add_control( 'nav_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-slidenav-item' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'nav_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-slidenav-item:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();

        wp_enqueue_style( 'electron-main-slider2' );

        $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : [1000,1000];
        if ( 'custom' == $size ) {
            $sizew = $settings['thumbnail_custom_dimension']['width'];
            $sizeh = $settings['thumbnail_custom_dimension']['height'];
            $size  = [ $sizew, $sizeh ];
        }

        $count = 1;
        echo '<div class="electron-slideshow">';
            echo '<div class="electron-slides">';
                foreach ( $settings['items'] as $item ) {
                    if ( !empty( $item['image']['id'] ) ) {
                        $imgurl = wp_get_attachment_image_url( $item['image']['id'], $size );
                    }
                    $current = $count == 1 ? ' electron-slide-current' : '';
                    echo '<div class="electron-slide'.$current.' elementor-repeater-item-' . esc_attr( $item['_id'] ) . '">';

                        if ( !empty( $item['image']['id'] ) ) {
                            echo '<div class="electron-slide-img" style="background-image: url('.$imgurl.')"></div>';
                            if ( !empty( $item['title']) ) {
                                echo '<'.$settings['tag'].' class="electron-slide-title">'.$item['title'].'</'.$settings['tag'].'>';
                            }
                            if ( !empty( $item['desc'] ) ) {
                                echo '<p class="electron-slide-desc">'.$item['desc'].'</p>';
                            }
                            if ( !empty( $item['btn_title'] ) && !empty( $item['btn_title2'] ) ) {
                                echo '<div class="electron-slide-link-wrapper">';
                            }
                            if ( !empty( $item['btn_title'] ) ) {
                                $target   = !empty( $item['link']['is_external'] ) ? ' target="_blank"' : '';
                                $nofollow = !empty( $item['link']['nofollow'] ) ? ' rel="nofollow"' : '';
                                $btn_id   = !empty( $item['btn_id'] ) ? ' id="'.$item['btn_id'].'"' : '';
                                echo '<a class="electron-btn-large electron-btn electron-btn-primary electron-slide-link" href="'.$item['link']['url'].'"'.$btn_id.$target.$nofollow.'>'.$item['btn_title'].'</a>';
                            }
                            if ( !empty( $item['btn_title2'] ) ) {
                                $target2   = !empty( $item['link2']['is_external'] ) ? ' target="_blank"' : '';
                                $nofollow2 = !empty( $item['link2']['nofollow'] ) ? ' rel="nofollow"' : '';
                                $btn_id2   = !empty( $item['btn_id2'] ) ? ' id="'.$item['btn_id2'].'"' : '';
                                echo '<a class="electron-btn-large electron-btn electron-btn-primary electron-slide-link electron-slide-link2" href="'.$item['link2']['url'].'"'.$btn_id2.$target2.$nofollow2.'>'.$item['btn_title2'].'</a>';
                            }
                            if ( !empty( $item['btn_title'] ) && !empty( $item['btn_title2'] ) ) {
                                echo '</div>';
                            }
                        }
                    echo '</div>';
                    $count++;
                }
            echo '</div>';

            echo '<div class="electron-slidenav">';
                echo '<div class="electron-slidenav-item electron-slidenav-item-prev">'.$settings['prev_title'].'</div>';
                echo '<span>/</span>';
                echo '<div class="electron-slidenav-item electron-slidenav-item-next">'.$settings['next_title'].'</div>';
            echo '</div>';

        echo '</div>';
    }
}
