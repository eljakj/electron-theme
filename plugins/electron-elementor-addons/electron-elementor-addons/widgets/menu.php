<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Menu_Dropdown extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-menu-dropdown';
    }
    public function get_title() {
        return 'Menu';
    }
    public function get_icon() {
        return 'eicon-nav-menu';
    }
    public function get_categories() {
        return [ 'electron' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('menu_general_settings',
            [
                'label' => esc_html__( 'General', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $menus   = wp_get_nav_menus();
        $options = array();
        if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
            foreach ( $menus as $menu ) {
                $options[ $menu->slug ] = $menu->name;
            }
        }
        $this->add_control( 'register_menus',
            [
                'label' => esc_html__( 'Select Menu', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'label_block' => true,
                'options' => $options
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label' => esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'menu_items_heading',
            [
                'label' => esc_html__( 'MENU ITEMS', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_items_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-header-top-menu-area ul>li>a'
            ]
        );
        $this->add_responsive_control( 'menu_item_height',
            [
                'label' => esc_html__( 'Menu Item Min Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-header-top-menu-area>ul>li.menu-item' => 'height:{{SIZE}}{{UNIT}};'
                ]
            ]
        );
        $this->add_responsive_control( 'arrow_position',
            [
                'label' => esc_html__( 'Arrow Top Position', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-header-top-menu-area li.has-dropdown .dropdown-btn' => 'top:{{SIZE}}{{UNIT}};'
                ]
            ]
        );
        $this->add_responsive_control( 'space_item',
            [
                'label' => esc_html__( 'Space Between Items', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .electron-header-top-menu-area>ul>li.menu-item>a' => 'margin-right:{{SIZE}}{{UNIT}};'
                ]
            ]
        );
        $this->add_responsive_control( 'menu_items_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-header-top-menu-area >ul>li>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'menu_item_brd',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-header-top-menu-area >ul>li>a'
            ]
        );
        $this->add_control( 'menu_item_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-header-top-menu-area >ul>li>a' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'menu_item_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-header-top-menu-area >ul>li>a:hover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'arrow_color',
            [
                'label' => esc_html__( 'Arrow Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-header-top-menu-area .dropdown-btn' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'dropdown_heading',
            [
                'label' => esc_html__( 'DROPDOWN', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'submenu_minwidth',
            [
                'label' => esc_html__( 'Min Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 1
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-header-top-menu-area ul>li>.submenu' => 'min-width:{{SIZE}}{{UNIT}};']
            ]
        );
        $this->add_responsive_control( 'submenu_padding',
            [
                'label' => esc_html__( 'Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-header-top-menu-area ul>li>.submenu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_control( 'submenu_bgcolor',
            [
                'label' => esc_html__( 'Dropdown Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-header-top-menu-area ul>li>.submenu' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'submenu_brd',
                'label' => esc_html__( 'Border', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-header-top-menu-area ul>li>.submenu'
            ]
        );
        $this->add_responsive_control( 'submenu_item_padding',
            [
                'label' => esc_html__( 'Submenu Item Padding', 'electron' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .electron-header-top-menu-area .submenu>li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submenu_items_typo',
                'label' => esc_html__( 'Typography', 'electron' ),
                'selector' => '{{WRAPPER}} .electron-header-top-menu-area .submenu>li>a'
            ]
        );
        $this->add_control( 'submenu_item_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-header-top-menu-area .submenu>li>a' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'submenu_item_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .electron-header-top-menu-area .submenu>li>a:hover' => 'color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo '<div class="electron-header-top-menu-area widget-menu">';
            echo '<ul class="navigation">';
                echo wp_nav_menu(
                    array(
                        'menu' => $settings['register_menus'],
                        'container' => '',
                        'container_class' => '',
                        'container_id' => '',
                        'menu_class' => '',
                        'menu_id' => '',
                        'items_wrap' => '%3$s',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 4,
                        'echo' => true,
                        'fallback_cb' => 'Electron_Wp_Bootstrap_Navwalker::fallback',
                        'walker' => new \Electron_Wp_Bootstrap_Navwalker()
                    )
                );
            echo '</ul>';
        echo '</div>';
    }
}
