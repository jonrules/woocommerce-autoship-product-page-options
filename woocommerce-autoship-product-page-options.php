<?php
/*
Plugin Name: WC Autoship Product Page Options
Plugin URI: http://wooautoship.com
Description: Select autoship display options for the product page.
Version: 1.0
Author: Patterns in the Cloud
Author URI: http://patternsinthecloud.com
License: Single-site
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce-autoship/woocommerce-autoship.php' ) ) {
	
	function wc_autoship_product_page_install() {

	}
	register_activation_hook( __FILE__, 'wc_autoship_product_page_install' );
	
	function wc_autoship_product_page_deactivate() {
	
	}
	register_deactivation_hook( __FILE__, 'wc_autoship_product_page_deactivate' );
	
	function wc_autoship_product_page_uninstall() {

	}
	register_uninstall_hook( __FILE__, 'wc_autoship_product_page_uninstall' );
	
	function wc_autoship_product_page_settings( $settings ) {
		$settings[] = array(
			'name' => __( 'Product Page Autoship Options Layout', 'wc-autoship' ),
			'desc' => __( 'The layout for autoship options on the product page', 'wc-autoship' ),
			'desc_tip' => true,
			'type' => 'select',
			'id' => 'wc_autoship_product_page_layout',
			'options' => array(
				'' => __( 'Default', 'wc-autoship' ),
				'radio-buttons' => __( 'Radio Buttons', 'wc-autoship' ),
				'select-box' => __( 'Select Box', 'wc-autoship' )
			)
		);
		return $settings;
	}
	add_filter( 'wc_autoship_settings', 'wc_autoship_product_page_settings', 10, 1 );
	
	function wc_autoship_product_page_template( $path, $template, $vars ) {
		$layout = get_option( 'wc_autoship_product_page_layout' );
		if ( empty( $layout ) ) {
			return $path;
		}
		if ( $template == 'product/autoship-options' ) {
			return wc_autoship_product_page_get_plugin_template_path( $layout . '/' . $template );
		} elseif ( $template == 'product/autoship-options-variable' ) {
			return wc_autoship_product_page_get_plugin_template_path( $layout . '/' . $template );
		}
		return $path;
	}
	add_filter( 'wc_autoship_plugin_template', 'wc_autoship_product_page_template', 10, 3 );
	
	function wc_autoship_product_page_get_plugin_template_path( $relative_path ) {
		return plugin_dir_path( __FILE__ ) . 'templates/' . $relative_path . '.php';
	}
}
