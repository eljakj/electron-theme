<?php

function electron_page_settings( $document )
{
    if ( ! $document instanceof \Elementor\Core\DocumentTypes\PageBase || ! $document::get_property( 'has_elements' ) ) {
        return;
    }
    
    $document->start_controls_section( 'electron_page_header_settings',
        [
            'label' => esc_html__( 'ELECTRON PAGE HEADER-FOOTER', 'electron' ),
            'tab' => \Elementor\Controls_Manager::TAB_SETTINGS
        ]
    );
    $document->add_control( 'electron_page_header_settings_heading',
        [
            'label' => esc_html__( 'ELECTRON PAGE HEADER', 'electron' ),
            'type' => \Elementor\Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_header_bg_type',
        [
            'label' => esc_html__( 'Header Background Type', 'electron' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'multiple' => false,
            'options' => array(
                '' => esc_html__( 'Select an option', 'electron' ),
                'default' => esc_html__( 'Deafult', 'electron' ),
                'dark' => esc_html__( 'Dark', 'electron' ),
                'trans-light' => esc_html__( 'Transparent Light', 'electron' ),
                'trans-dark' => esc_html__( 'Transparent Dark', 'electron' )
            )
        ]
    );
    $document->add_control( 'electron_page_header_template',
        [
            'label' => esc_html__( 'Select Header Template', 'electron' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'multiple' => false,
            //'options' => $this->electron_get_elementor_templates()
        ]
    );
    $document->add_control( 'electron_page_footer_settings_heading',
        [
            'label' => esc_html__( 'ELECTRON PAGE FOOTER', 'electron' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );
    $document->add_control( 'electron_page_footer_template',
        [
            'label' => esc_html__( 'Select Footer Template', 'electron' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'multiple' => false,
            //'options' => $this->electron_get_elementor_templates()
        ]
    );
    $document->end_controls_section();

/*
    $document->start_controls_section( 'electron_page_header_logo_settings',
        [
            'label' => esc_html__( 'ELECTRON PAGE HEADER LOGO', 'electron' ),
            'tab' => Controls_Manager::TAB_SETTINGS
        ]
    );
    $document->add_control( 'electron_page_header_logo_update',
        [
            'label' => '<div class="elementor-update-preview" style="background-color: var(--electron-light);display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">Update changes to pages</div></div>',
            'type' => Controls_Manager::RAW_HTML
        ]
    );
    $document->add_control( 'electron_page_header_logo',
        [
            'label' => esc_html__( 'Logo', 'electron' ),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => '']
        ]
    );
    $document->add_control( 'electron_page_header_logo_max_width',
        [
            'label' => esc_html__( 'Image Max-Width', 'electron' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'default' => '',
            'selectors' => [ '{{WRAPPER}} .nt-logo.header-logo .main-logo:not(.sticky-logo)' => 'max-width: {{VALUE}}px;' ]
        ]
    );
    $document->add_control( 'electron_page_header_logo_max_height',
        [
            'label' => esc_html__( 'Image Max-Height', 'electron' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'default' => '',
            'selectors' => [ '{{WRAPPER}} .nt-logo.header-logo .main-logo:not(.sticky-logo)' => 'max-height: {{VALUE}}px;' ]
        ]
    );
    $document->add_control( 'electron_page_header_sticky_logo',
        [
            'label' => esc_html__( 'Sticky Logo', 'electron' ),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => '']
        ]
    );
    $document->add_control( 'electron_page_header_sticky_logo_max_width',
        [
            'label' => esc_html__( 'Sticky Logo Max-Width', 'electron' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'default' => '',
            'selectors' => [ '{{WRAPPER}} .nt-logo.header-logo .main-logo.sticky-logo' => 'max-width: {{VALUE}}px;' ]
        ]
    );
    $document->add_control( 'electron_page_header_sticky_logo_max_height',
        [
            'label' => esc_html__( 'Sticky Logo Max-Height', 'electron' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'default' => '',
            'selectors' => [ '{{WRAPPER}} .nt-logo.header-logo .main-logo.sticky-logo' => 'max-height: {{VALUE}}px;' ]
        ]
    );
    $document->add_control( 'electron_page_header_text_logo_color',
        [
            'label' => esc_html__( 'Text Logo Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [ '{{WRAPPER}} .nt-logo.header-logo .header-text-logo' => 'color:{{VALUE}};' ]
        ]
    );
    $document->add_control( 'electron_page_header_sticky_text_logo_color',
        [
            'label' => esc_html__( 'Sticky Text Logo Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [ '{{WRAPPER}}.scroll-start .nt-logo.header-logo .header-text-logo' => 'color:{{VALUE}};' ]
        ]
    );
    $document->end_controls_section();

    $document->start_controls_section( 'electron_page_header_customize_settings',
        [
            'label' => esc_html__( 'ELECTRON PAGE HEADER CUSTOMIZE', 'electron' ),
            'tab' => Controls_Manager::TAB_SETTINGS
        ]
    );
    $document->add_control( 'electron_page_header_bgcolor',
        [
            'label' => esc_html__( 'Header Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.has-default-header-type-default header.electron-header-default,
                {{WRAPPER}}.has-default-header-type-dark header.electron-header-default,
                {{WRAPPER}} .electron-header-top-menu-area ul li .submenu,
                {{WRAPPER}} .electron-header-top-menu-area ul li>.item-shortcode-wrapper,
                {{WRAPPER}} .electron-header-wc-categories .submenu,
                {{WRAPPER}} .electron-header-mobile-top,
                {{WRAPPER}} .electron-header-mobile,
                {{WRAPPER}}.has-default-header-type-trans header.electron-header-default' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_header_menu_settings',
        [
            'label' => esc_html__( 'Menu Items', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_header_menu_item_color',
        [
            'label' => esc_html__( 'Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-top-menu-area>ul>li.menu-item>a,
                {{WRAPPER}}.has-default-header-type-trans:not(.scroll-start) .electron-header-top-menu-area>ul>li.menu-item>a,
                {{WRAPPER}} .electron-header-wc-categories .product_cat,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu-inner li a,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li .sliding-menu__nav,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li.current-menu-parent>.sliding-menu__nav,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__back:before,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__nav:before,
                {{WRAPPER}} .electron-header-top-menu-area ul li .submenu>li.menu-item>a' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_header_menu_item_hvrcolor',
        [
            'label' => esc_html__( 'Color ( Hover/Active )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-top-menu-area>ul>li.menu-item:hover>a,
                {{WRAPPER}}.has-default-header-type-trans:not(.scroll-start) .electron-header-top-menu-area>ul>li.menu-item:hover>a,
                {{WRAPPER}} .electron-header-top-menu-area>ul>li.menu-item.active>a,
                {{WRAPPER}}.has-default-header-type-trans:not(.scroll-start) .electron-header-top-menu-area>ul>li.menu-item.active>a,
                {{WRAPPER}} .current-menu-parent>a,
                {{WRAPPER}} .current-menu-item>a,
                {{WRAPPER}} .electron-header-top-menu-area>ul>li.menu-item.active>a,
                {{WRAPPER}} .electron-header-top-menu-area>ul>li.menu-item>a:hover,
                {{WRAPPER}} .electron-header-wc-categories .product_cat:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li.current-menu-item>.sliding-menu__nav:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li.current-menu-item>a:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li a:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li.active a,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li .sliding-menu__nav:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__back:hover:before,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__nav:hover:before,
                {{WRAPPER}} .electron-header-top-menu-area ul li .submenu>li.menu-item>a:hover' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_header_settings',
        [
            'label' => esc_html__( 'STICKY HEADER', 'electron' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );
    $document->add_control( 'electron_page_sticky_header_bgcolor',
        [
            'label' => esc_html__( 'Sticky Header Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start header.electron-header-default,
                {{WRAPPER}}.scroll-start .electron-header-top-menu-area ul li .submenu,
                {{WRAPPER}}.scroll-start .electron-header-top-menu-area ul li>.item-shortcode-wrapper,
                {{WRAPPER}}.scroll-start .electron-header-wc-categories .submenu,
                {{WRAPPER}}.scroll-start .electron-header-mobile-top,
                {{WRAPPER}}.scroll-start .electron-header-mobile,
                {{WRAPPER}}.has-default-header-type-trans.scroll-start header.electron-header-default' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_header_menu_settings',
        [
            'label' => esc_html__( 'Sticky Menu Items', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_sticky_header_menu_item_color',
        [
            'label' => esc_html__( 'Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-top-menu-area>ul>li.menu-item>a,
                {{WRAPPER}}.has-default-header-type-trans.scroll-start .electron-header-top-menu-area>ul>li.menu-item>a,
                {{WRAPPER}}.scroll-start .electron-header-wc-categories .product_cat,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu-inner li a,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li .sliding-menu__nav,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.current-menu-parent>.sliding-menu__nav,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__back:before,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__nav:before,
                {{WRAPPER}}.scroll-start .electron-header-top-menu-area ul li .submenu>li.menu-item>a' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_header_menu_item_hvrcolor',
        [
            'label' => esc_html__( 'Color ( Hover/Active )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-top-menu-area>ul>li.menu-item:hover>a,
                {{WRAPPER}}.has-default-header-type-trans.scroll-start .electron-header-top-menu-area>ul>li.menu-item:hover>a,
                {{WRAPPER}}.scroll-start .electron-header-top-menu-area>ul>li.menu-item.active>a,
                {{WRAPPER}}.has-default-header-type-trans.scroll-start .electron-header-top-menu-area>ul>li.menu-item.active>a,
                {{WRAPPER}}.scroll-start .current-menu-parent>a,
                {{WRAPPER}}.scroll-start .current-menu-item>a,
                {{WRAPPER}}.scroll-start .electron-header-top-menu-area>ul>li.menu-item.active>a,
                {{WRAPPER}}.scroll-start .electron-header-top-menu-area>ul>li.menu-item>a:hover,
                {{WRAPPER}}.scroll-start .electron-header-wc-categories .product_cat:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.current-menu-item>.sliding-menu__nav:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.current-menu-item>a:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li a:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.active a,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li .sliding-menu__nav:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__back:hover:before,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__nav:hover:before,
                {{WRAPPER}}.scroll-start .electron-header-top-menu-area ul li .submenu>li.menu-item>a:hover' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_header_svg_icons_settings',
        [
            'label' => esc_html__( 'HEADER SVG ICONS', 'electron' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );
    $document->add_control( 'electron_page_header_svg_icons_color',
        [
            'label' => esc_html__( 'Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} header.electron-header-default .electron-svg-icon,
                {{WRAPPER}} .electron-header-mobile-top .electron-svg-icon' => 'fill:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_header_svg_counter_bgcolor',
        [
            'label' => esc_html__( 'Counter Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} header.electron-header-default .electron-wc-count,
                {{WRAPPER}} .electron-header-mobile-top .electron-wc-count' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_header_svg_counter_color',
        [
            'label' => esc_html__( 'Counter Number Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} header.electron-header-default .electron-wc-count,
                {{WRAPPER}} .electron-header-mobile-top .electron-wc-count' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_header_svg_icons_settings',
        [
            'label' => esc_html__( 'Sticky Header Color', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_sticky_header_svg_icons_color',
        [
            'label' => esc_html__( 'Sticky Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start header.electron-header-default .electron-svg-icon,
                {{WRAPPER}}.scroll-start .electron-header-mobile-top .electron-svg-icon' => 'fill:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_header_svg_counter_bgcolor',
        [
            'label' => esc_html__( 'Sticky Counter Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start header.electron-header-default .electron-wc-count,
                {{WRAPPER}}.scroll-start .electron-header-mobile-top .electron-wc-count' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_header_svg_counter_color',
        [
            'label' => esc_html__( 'Sticky Counter Number Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start header.electron-header-default .electron-wc-count,
                {{WRAPPER}}.scroll-start .electron-header-mobile-top .electron-wc-count' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->end_controls_section();

    $document->start_controls_section( 'electron_page_mobile_header_customize_settings',
        [
            'label' => esc_html__( 'ELECTRON PAGE MOBILE HEADER', 'electron' ),
            'tab' => Controls_Manager::TAB_SETTINGS
        ]
    );
    $document->add_control( 'electron_page_mobile_header_bgcolor',
        [
            'label' => esc_html__( 'Header Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-top' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_mobile_header_toggle_btn_color',
        [
            'label' => esc_html__( 'Toggle Button Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-top .mobile-toggle' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_mobile_header_toggle_btn_hvrcolor',
        [
            'label' => esc_html__( 'Toggle Button Color ( Hover )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-top .mobile-toggle:hover' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_settings',
        [
            'label' => esc_html__( 'Sticky Header Color', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_bgcolor',
        [
            'label' => esc_html__( 'Header Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile-top' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_toggle_btn_color',
        [
            'label' => esc_html__( 'Toggle Button Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile-top .mobile-toggle' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_toggle_btn_hvrcolor',
        [
            'label' => esc_html__( 'Toggle Button Color ( Hover )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile-top .mobile-toggle:hover' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_mobile_header_svg_icons_settings',
        [
            'label' => esc_html__( 'HEADER SVG ICONS', 'electron' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );
    $document->add_control( 'electron_page_mobile_header_svg_icons_color',
        [
            'label' => esc_html__( 'Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-top .electron-svg-icon' => 'fill:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_mobile_header_svg_counter_bgcolor',
        [
            'label' => esc_html__( 'Counter Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-top .electron-wc-count' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_mobile_header_svg_counter_color',
        [
            'label' => esc_html__( 'Counter Number Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-top .electron-wc-count' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_svg_icons_settings',
        [
            'label' => esc_html__( 'Sticky Header Color', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_svg_icons_color',
        [
            'label' => esc_html__( 'Sticky Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile-top .electron-svg-icon' => 'fill:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_svg_counter_bgcolor',
        [
            'label' => esc_html__( 'Sticky Counter Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile-top .electron-wc-count' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_mobile_header_svg_counter_color',
        [
            'label' => esc_html__( 'Sticky Counter Number Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile-top .electron-wc-count' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->end_controls_section();

    $document->start_controls_section( 'electron_page_slide_menu_customize_settings',
        [
            'label' => esc_html__( 'ELECTRON PAGE MOBILE SLIDE MENU', 'electron' ),
            'tab' => Controls_Manager::TAB_SETTINGS
        ]
    );
    $document->add_control( 'electron_page_slide_menu_close_btn_bgcolor',
        [
            'label' => esc_html__( 'Close Button Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .electron-panel-close.no-bar,
                {{WRAPPER}} .electron-header-mobile .electron-panel-close' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_close_btn_color',
        [
            'label' => esc_html__( 'Close Button Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .electron-panel-close-button:before,
                {{WRAPPER}} .electron-header-mobile .electron-panel-close-button:after,
                {{WRAPPER}} .electron-header-mobile .electron-panel-close.no-bar:before,
                {{WRAPPER}} .electron-header-mobile .electron-panel-close.no-bar:after' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_bgcolor',
        [
            'label' => esc_html__( 'Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile' => 'background-color:{{VALUE}};',
                '{{WRAPPER}} .electron-header-mobile .electron-header-mobile-content .action-content' => 'background-color:transparent;',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_minibar_bgcolor',
        [
            'label' => esc_html__( 'Minibar Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .electron-header-mobile-sidebar' => 'background-color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_minibar_svg_icons_color',
        [
            'label' => esc_html__( 'SVG Icon Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .electron-svg-icon' => 'fill:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_minibar_svg_icons_hvrbgcolor',
        [
            'label' => esc_html__( 'SVG Icon Background Color ( Active )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .sidebar-top-action .top-action-btn.active' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_minibar_svg_icons_hvrcolor',
        [
            'label' => esc_html__( 'SVG Icon Color ( Active )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .sidebar-top-action .top-action-btn.active' => 'fill:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_minibar_svg_counter_bgcolor',
        [
            'label' => esc_html__( 'Icon Counter Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .electron-wc-count' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_minibar_svg_counter_color',
        [
            'label' => esc_html__( 'Icon Counter Number Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .electron-wc-count' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_items_settings',
        [
            'label' => esc_html__( 'Menu Items', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_slide_menu_item_color',
        [
            'label' => esc_html__( 'Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu-inner li a,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li .sliding-menu__nav,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li.current-menu-parent>.sliding-menu__nav,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__back:before,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__nav:before,
                {{WRAPPER}} .electron-header-mobile .account-area li.menu-item a' => 'color:{{VALUE}};'
            ]
        ]
    );

    $document->add_control( 'electron_page_slide_menu_item_hvrcolor',
        [
            'label' => esc_html__( 'Color ( Hover/Active )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile .sliding-menu li.current-menu-item>.sliding-menu__nav:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li.current-menu-item>a:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li a:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li.active a,
                {{WRAPPER}} .electron-header-mobile .sliding-menu li .sliding-menu__nav:hover,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__back:hover:before,
                {{WRAPPER}} .electron-header-mobile .sliding-menu .sliding-menu__nav:hover:before,
                {{WRAPPER}} .electron-header-mobile .account-area li.menu-item a:hover' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_slide_menu_settings',
        [
            'label' => esc_html__( 'STICKY HEADER', 'electron' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );
    $document->add_control( 'electron_page_sticky_slide_menu_bgcolor',
        [
            'label' => esc_html__( 'Sticky Header Background Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile' => 'background-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_menu_back_brdcolor',
        [
            'label' => esc_html__( 'Border Separator Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .sliding-menu .sliding-menu__back:after' => 'border-bottom-color:{{VALUE}};',
                '{{WRAPPER}} .electron-sidemenu-lang-switcher' => 'border-top-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_slide_menu_items_settings',
        [
            'label' => esc_html__( 'Sticky Menu Items', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_sticky_slide_menu_item_color',
        [
            'label' => esc_html__( 'Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu-inner li a,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li .sliding-menu__nav,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.current-menu-parent>.sliding-menu__nav,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__back:before,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__nav:before,
                {{WRAPPER}}.scroll-start .electron-header-mobile .account-area li.menu-item a' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_slide_menu_item_hvrcolor',
        [
            'label' => esc_html__( 'Color ( Hover/Active )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.current-menu-item>.sliding-menu__nav:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.current-menu-item>a:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li a:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li.active a,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu li .sliding-menu__nav:hover,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__back:hover:before,
                {{WRAPPER}}.scroll-start .electron-header-mobile .sliding-menu .sliding-menu__nav:hover:before,
                {{WRAPPER}}.scroll-start .electron-header-mobile .account-area li.menu-item a:hover' => 'color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_sticky_slide_menu_back_brdcolor',
        [
            'label' => esc_html__( 'Border Separator Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}.scroll-start .sliding-menu .sliding-menu__back:after' => 'border-bottom-color:{{VALUE}};',
                '{{WRAPPER}}.scroll-start .electron-sidemenu-lang-switcher' => 'border-top-color:{{VALUE}};'
            ]
        ]
    );
    $document->add_control( 'electron_page_minibar_social_settings',
        [
            'label' => esc_html__( 'SOCIAL ICONS', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_minibar_social_color',
        [
            'label' => esc_html__( 'Minibar Social Icon Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .sidebar-bottom-socials a' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_minibar_social_hvrcolor',
        [
            'label' => esc_html__( 'Minibar Social Icon Color ( Hover )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .sidebar-bottom-socials a:hover' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_title_color_settings',
        [
            'label' => esc_html__( 'PANEL WOOCOMMERCE', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_top_title_color',
        [
            'label' => esc_html__( 'Top Title Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .panel-top-title' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_top_title_brdcolor',
        [
            'label' => esc_html__( 'Top Title Border Bottom Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .panel-top-title:after' => 'border-bottom-color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_product_title_color',
        [
            'label' => esc_html__( 'Product Title Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .electron-content-info .product-name' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_product_stock_color',
        [
            'label' => esc_html__( 'Product Stock Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .electron-content-info .product-stock' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_product_addtocart_color',
        [
            'label' => esc_html__( 'Add to Cart Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .electron-content-item .electron-content-info .electron-btn-small' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_product_trash_icon_color',
        [
            'label' => esc_html__( 'Trash Icon Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .electron-content-item .electron-svg-icon.mini-icon' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_product_subtotal_color',
        [
            'label' => esc_html__( 'Cart Subtotal Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .cart-area .cart-total-price' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_product_text_color',
        [
            'label' => esc_html__( 'Extra Text Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .minicart-extra-text' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_cart_buttons_settings',
        [
            'label' => esc_html__( 'Buttons', 'electron' ),
            'type' => Controls_Manager::HEADING
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_buttons_color',
        [
            'label' => esc_html__( 'Buttons Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .cart-bottom-btn .electron-btn' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_buttons_hvrcolor',
        [
            'label' => esc_html__( 'Buttons Color ( Hover )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .cart-bottom-btn .electron-btn:hover' => 'color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_buttons_bgcolor',
        [
            'label' => esc_html__( 'Buttons Backgroud Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .cart-bottom-btn .electron-btn' => 'background-color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_buttons_hvrbgcolor',
        [
            'label' => esc_html__( 'Buttons Backgroud Color ( Hover )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .cart-bottom-btn .electron-btn:hover' => 'background-color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_buttons_brdcolor',
        [
            'label' => esc_html__( 'Buttons Border Color', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .cart-bottom-btn .electron-btn' => 'border-color:{{VALUE}};',
            ]
        ]
    );
    $document->add_control( 'electron_page_slide_left_panel_buttons_hvrbrdcolor',
        [
            'label' => esc_html__( 'Buttons Border Color ( Hover )', 'electron' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .electron-header-mobile-content .cart-bottom-btn .electron-btn:hover' => 'border-color:{{VALUE}};',
            ]
        ]
    );
    $document->end_controls_section();
*/
}
