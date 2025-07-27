<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Timer extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-countdown';
    }
    public function get_title() {
        return 'Countdown';
    }
    public function get_icon() {
        return 'eicon-countdown';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    public function get_keywords() {
		return [ 'time', 'timer', 'count', 'counter', 'countdown', 'date' ];
	}
    public function get_script_depends() {
        return [ 'electron-countdown' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('countdown_settings',
            [
                'label' => esc_html__( 'Countdown Settings', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'date',
            [
                'label' => esc_html__( 'Time', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Usage : 2030/01/01', 'electron' ),
                'default' => '2030/01/01'
            ]
        );
        $this->add_control( 'expired',
            [
                'label' => esc_html__( 'Expired Text', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Expired'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label'=> esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_responsive_control('alignment',
            [
                'label' => esc_html__( 'Alignment', 'electron' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => true,
                'default' => 'left',
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
                'selectors' => [ '{{WRAPPER}} .electron-coming-time' => 'justify-content: {{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'time_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count'
            ]
        );
        $this->add_responsive_control( 'time_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_responsive_control( 'time_last_color',
            [
                'label' => esc_html__( 'Last Item Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count:last-child' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'hide_sep',
            [
                'label' => esc_html__( 'Hide Separator', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'time_sep',
            [
                'label' => esc_html__( 'Seperator', 'electron' ),
                'type' => Controls_Manager::TEXT,
                'default' => ':',
                'condition' => ['hide_sep' => 'no']
            ]
        );
        $this->add_responsive_control( 'time_sep_color',
            [
                'label' => esc_html__( 'Seperator Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .separator' => 'color:{{VALUE}};' ],
                'condition' => ['hide_sep' => 'no']
            ]
        );
        $this->add_responsive_control( 'time_sep_size',
            [
                'label' => esc_html__( 'Seperator Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 15,
                'selectors' => ['{{WRAPPER}} .electron-coming-time .separator' => 'font-size:{{SIZE}}px;' ],
                'condition' => ['hide_sep' => 'no']
            ]
        );
        $this->add_responsive_control( 'time_min_width',
            [
                'label' => esc_html__( 'Item Min Width', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'min-width:{{SIZE}}px;' ],
            ]
        );
        $this->add_responsive_control( 'time_min_height',
            [
                'label' => esc_html__( 'Item Min height', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'min-height:{{SIZE}}px;' ],
            ]
        );
        $this->add_responsive_control( 'time_sep_space',
            [
                'label' => esc_html__( 'Space Between Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 15,
                'selectors' => [
                    '{{WRAPPER}} .electron-coming-time .separator' => 'margin:0 {{SIZE}}px;',
                    '{{WRAPPER}} .electron-coming-time.separator-none .time-count + .time-count' => 'margin-left:{{SIZE}}px;',
                ],
            ]
        );
        $this->add_responsive_control( 'time_padding',
            [
                'label' => esc_html__( 'Item Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'time_bgcolor',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'time_last_bgcolor',
                'label' => esc_html__( 'Background', 'electron' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count:last-child',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'time_border',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-coming-time .time-count',
            ]
        );
        $this->add_responsive_control( 'time_last_brdcolor',
            [
                'label' => esc_html__( 'Last Item Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-coming-time .time-count:last-child' => 'border-color:{{VALUE}};' ]
            ]
        );
        $this->add_responsive_control( 'time_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-coming-time .time-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = $this->get_id();

        if ( $s['date'] ) {
            $sep = 'yes' == $s['hide_sep'] ? ' separator-none' : '';
            $time_opt = '"date":"'.$s['date'].'","expired":"'.$s['expired'].'"';
            echo '<div class="electron-coming-time electron-widget-coming-time'.$sep.'" data-countdown=\'{'.$time_opt.'}\'>';
                echo '<div class="time-count days"></div>';
                echo '<span class="separator">'.$s['time_sep'].'</span>';
                echo '<div class="time-count hours"></div>';
                echo '<span class="separator">'.$s['time_sep'].'</span>';
                echo '<div class="time-count minutes"></div>';
                echo '<span class="separator">'.$s['time_sep'].'</span>';
                echo '<div class="time-count second"></div>';
            echo '</div>';
        }
    }
}
