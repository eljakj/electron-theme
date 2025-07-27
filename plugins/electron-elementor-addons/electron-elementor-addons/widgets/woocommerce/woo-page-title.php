<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_WC_Page_Title extends Widget_Base {

	public function get_name() {
		return 'electron-wc-page-title';
	}

	public function get_title() {
		return __( 'Archive Title', 'electron' );
	}

	public function get_icon() {
		return 'eicon-product-description';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'woo','title','heading','wc', 'shop', 'store', 'text', 'description', 'category', 'product', 'archive' ];
	}

    public function get_categories() {
		return [ 'electron-woo' ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_product_title_style',
			[
				'label' => __( 'Style', 'electron' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control( 'tag',
            [
                'label' => esc_html__( 'Title Tag for SEO', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h2',
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
		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'electron' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'electron' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'electron' ),
						'icon' => 'eicon-text-align-center'
					],
					'right' => [
						'title' => __( 'Right', 'electron' ),
						'icon' => 'eicon-text-align-right'
					],
					'justify' => [
						'title' => __( 'Justified', 'electron' ),
						'icon' => 'eicon-text-align-justify'
					]
				],
				'selectors' => ['{{WRAPPER}} .electron-page-title' => 'text-align: {{VALUE}}']
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'electron' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}} .electron-page-title' => 'color: {{VALUE}}' ]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Typography', 'electron' ),
				'selector' => '{{WRAPPER}} .electron-page-title'
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
	    $settings = $this->get_settings_for_display();
        global $post;
        $post_type = get_post_type( $post->ID );
        if ( $post_type == 'elementor_library' ) {
            echo '<'.$settings['tag'].' class="electron-page-title">'.get_the_title().'</'.$settings['tag'].'>';
        } else {
            echo '<'.$settings['tag'].' class="electron-page-title">'.get_the_archive_title().'</'.$settings['tag'].'>';
        }
	}
}
