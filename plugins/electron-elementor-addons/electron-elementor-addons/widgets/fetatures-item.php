<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Features_Item extends Widget_Base {
    public function get_name() {
        return 'electron-features-item';
    }
    public function get_title() {
        return 'Features Item';
    }
    public function get_icon() {
        return 'eicon-icon-box';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'general_section',
            [
                'label'=> esc_html__( 'Content', 'electron' ),
                'tab'=> Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'box_type',
            [
                'label' => esc_html__( 'Icon Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'type1',
                'options' => [
                    'type1' => esc_html__( 'Type 1 - Clean', 'electron' ),
                    'type2' => esc_html__( 'Type 2 - Bordered', 'electron' ),
                    'type3' => esc_html__( 'Type 3 - Dark Solid', 'electron' ),
                    'type4' => esc_html__( 'Type 4 - Primary Solid Radius', 'electron' ),
                    'type5' => esc_html__( 'Type 5 - Bordered Boxed', 'electron' ),
                ],
            ]
        );
        $this->add_control( 'icon_type',
            [
                'label' => esc_html__( 'Icon Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'img',
                'options' => [
                    'img' => esc_html__( 'Image', 'electron' ),
                    'icon' => esc_html__( 'Icon', 'electron' ),
                ],
            ]
        );
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'agrikon' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => ''],
                'condition' => ['icon_type' => 'img']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'thumbnail',
                'condition' => ['icon_type' => 'img']
            ]
        );
        $this->add_control( 'icon',
            [
                'label' => esc_html__( 'Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ],
                'condition' => ['icon_type' => 'icon']
            ]
        );
        $this->add_control( 'label',
            [
                'label' => esc_html__( 'Label', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Label',
                'label_block' => true,
            ]
        );
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Free Shipping On Over $199',
                'label_block' => true,
            ]
        );
        $this->add_control( 'tag',
            [
                'label' => esc_html__( 'Title Tag', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h6',
                'options' => [
                    'h1' => esc_html__( 'H1', 'electron' ),
                    'h2' => esc_html__( 'H2', 'electron' ),
                    'h3' => esc_html__( 'H3', 'electron' ),
                    'h4' => esc_html__( 'H4', 'electron' ),
                    'h5' => esc_html__( 'H5', 'electron' ),
                    'h6' => esc_html__( 'H6', 'electron' ),
                    'div' => esc_html__( 'div', 'electron' ),
                    'p' => esc_html__( 'p', 'electron' ),
                ],
            ]
        );
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Short Description', 'electron' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet',
                'label_block' => true,
            ]
        );
        $this->add_control( 'link',
            [
                'label' => esc_html__( 'Add Link', 'electron' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => ''
                ],
                'show_external' => true,
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label' => esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'box_divider',
            [
                'label' => esc_html__( 'BOX', 'electron' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_responsive_control( 'text_alignment',
            [
                'label' => esc_html__( 'Text Alignment', 'electron' ),
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
                'selectors' => [ '{{WRAPPER}} .electron-features-item' => 'text-align:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'box_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item' => 'background-color:{{VALUE}};']
            ]
        );
        $this->add_control( 'box_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item:hover' => 'background-color:{{VALUE}};']
            ]
        );
        $this->add_responsive_control( 'box_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-features-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-features-item'
            ]
        );
        $this->add_control( 'box_hvrcolor',
            [
                'label' => esc_html__( 'Hover Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item:hover' => 'border-color:{{VALUE}};']
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-features-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_control( 'icon_divider',
            [
                'label' => esc_html__( 'ICON', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'icon_style',
            [
                'label' => esc_html__( 'Icon Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'border',
                'options' => [
                    'border' => esc_html__( 'Border', 'electron' ),
                    'simple' => esc_html__( 'Simple', 'electron' ),
                ],
            ]
        );
        $this->add_responsive_control( 'icon_svg_imgsize',
            [
                'label' => esc_html__( 'Image Icon Max Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item .electron-features-icon img' => 'max-width:{{SIZE}}px;' ],
                'condition' => ['icon_type' => 'img']
            ]
        );
        $this->add_responsive_control( 'icon_size',
            [
                'label' => esc_html__( 'Font Icon Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item .electron-features-icon' => 'font-size:{{SIZE}}px;' ],
                'condition' => ['icon_type' => 'icon']
            ]
        );
        $this->add_responsive_control( 'icon_svg_maxwidth',
            [
                'label' => esc_html__( 'SVG Icon Max Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 2000,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item .electron-features-icon svg' => 'width:{{SIZE}}px;max-width:{{SIZE}}px;' ],
                'condition' => ['icon_type' => 'icon']
            ]
        );
        $this->add_responsive_control( 'icon_svg_maxheight',
            [
                'label' => esc_html__( 'SVG Icon Max Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 2000,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item .electron-features-icon svg' => 'height:{{SIZE}}px;max-height:{{SIZE}}px;' ],
                'condition' => ['icon_type' => 'icon']
            ]
        );
        $this->add_responsive_control( 'icon_minh',
            [
                'label' => esc_html__( 'Icon Wrapper Min Height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item .electron-features-icon' => 'min-height:{{SIZE}}px;' ],
            ]
        );
        $this->add_control( 'icon_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-features-item .electron-features-icon' => 'color:{{VALUE}};',
                    '{{WRAPPER}} .electron-features-item .electron-features-icon svg' => 'fill:{{VALUE}};'
                ]
            ]
        );
        $this->add_control( 'icon_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-features-item:hover .electron-features-icon' => 'color:{{VALUE}};',
                    '{{WRAPPER}} .electron-features-item:hover .electron-features-icon svg' => 'fill:{{VALUE}};',
                ]
            ]
        );
        $this->add_responsive_control( 'icon_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-features-item .electron-features-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_responsive_control( 'icon_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-features-item .electron-features-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-features-item .electron-features-icon'
            ]
        );
        $this->add_responsive_control( 'icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-features-item .electron-features-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_control( 'title_divider',
            [
                'label' => esc_html__( 'TITLE', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-content .features-title' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'title_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item:hover .electron-features-content .features-title' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-features-content .features-title'
            ]
        );
        $this->add_responsive_control( 'title_margin',
            [
                'label' => esc_html__( 'Margin', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => ['{{WRAPPER}} .electron-features-content .features-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_control( 'desc_divider',
            [
                'label' => esc_html__( 'DESCRIPTION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-content .features-desc' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'desc_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-features-item:hover .features-desc' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-features-content .features-desc'
            ]
        );
        /*****   END CONTROLS SECTION   ******/

        /***** label Style ******/
        $this->add_control( 'label_divider',
            [
                'label' => esc_html__( 'DESCRIPTION', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'label_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-features-label' => 'color: {{VALUE}};']
            ]
        );
        $this->add_responsive_control( 'label_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-features-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'label_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-features-label',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'label_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-features-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );
        $this->add_control( 'label_bgcolor',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-features-label' => 'background-color: {{VALUE}};']
            ]
        );
        $this->end_controls_section();
        /***** End label Styling *****/

    }

    protected function render() {
        $settings  = $this->get_settings_for_display();

        $html = '';

        if ( $settings['link']['url'] ) {
            $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
            $rel = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
            $html .= '<a class="features-link" href="'.$settings['link']['url'].'"'.$target.$rel.'></a>';
        }


        if ( 'img' == $settings['icon_type'] ) {
            $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : 'thumbnail';
            if ( 'custom' == $size ) {
                $sizew = $settings['thumbnail_custom_dimension']['width'];
                $sizeh = $settings['thumbnail_custom_dimension']['height'];
                $size = [ $sizew, $sizeh ];
            }
            $html .= '<div class="electron-features-icon icon-'.$settings['icon_style'].'">';
                $html .= wp_get_attachment_image( $settings['image']['id'], $size, false, ['class'=>'f-icon'] );
            $html .= '</div>';
        }
        if ( !empty( $settings['icon']['value'] ) && 'img' != $settings['icon_type'] ) {
            ob_start();
            Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
            $icon = ob_get_clean();
            $html .= '<div class="electron-features-icon icon-'.$settings['icon_style'].'">'.$icon.'</div>';
        }
        $html .= '<div class="electron-features-content">';
            if ( $settings['label'] ) {
                $html .= '<span class="electron-features-label">'.$settings['label'].'</span>';
            }
            if ( $settings['title'] ) {
                $html .= '<'.$settings['tag'].' class="features-title">'.$settings['title'].'</'.$settings['tag'].'>';
            }
            if ( $settings['desc'] ) {
                $html .= '<span class="features-desc">'.$settings['desc'].'</span>';
            }
        $html .= '</div>';

        echo '<div class="electron-features-item box-'.$settings['box_type'].'">'.$html.'</div>';

    }
}
