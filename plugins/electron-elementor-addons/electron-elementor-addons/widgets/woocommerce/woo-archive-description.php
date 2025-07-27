<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_WC_Archive_Description extends Widget_Base {

	public function get_name() {
		return 'electron-wc-archive-description';
	}

	public function get_title() {
		return __( 'Archive Description', 'electron' );
	}

	public function get_icon() {
		return 'eicon-product-description';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'woo', 'wc', 'shop', 'store', 'text', 'description', 'category', 'product', 'archive' ];
	}

    public function get_categories() {
		return [ 'electron-woo' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_product_description_style',
			[
				'label' => __( 'Style', 'electron' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'electron' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'electron' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => ['{{WRAPPER}} .term-description' => 'text-align: {{VALUE}}']
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'electron' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}} .term-description' => 'color: {{VALUE}}' ]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Typography', 'electron' ),
				'selector' => '{{WRAPPER}} .term-description'
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
        if ( ! class_exists('WooCommerce') ) {
            return;
        }
        global $post;
        $post_type = get_post_type( $post->ID );
        if ( $post_type == 'elementor_library' ) {
            echo '<p class="term-description">This is demo paragraph. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>';
        } else {
            do_action( 'woocommerce_archive_description' );
        }
	}

}
