<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_WC_Product_Title extends Widget_Base {

	public function get_name() {
		return 'electron-wc-product-title';
	}

	public function get_title() {
		return __( 'Product Title', 'electron' );
	}

	public function get_icon() {
		return 'eicon-product-title';
	}
	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'title', 'heading', 'product' ];
	}
    public function get_categories() {
		return [ 'electron-woo-product' ];
	}
	protected function register_controls() {

	}

	protected function render() {
        global $product;

		$product = wc_get_product();

		if ( empty( $product ) ) {
			return;
		}
		echo get_the_title($product);
	}

}
