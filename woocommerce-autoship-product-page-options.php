<?php
/*
Plugin Name: WC Autoship Product Page Options
Plugin URI: http://wooautoship.com
Description: Customize the autoship options on the product page.
Version: 1.0
Author: Patterns in the Cloud
Author URI: http://patternsinthecloud.com
License: Single-site
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce-autoship/woocommerce-autoship.php' ) ) {
	
	function wc_autoship_product_page_install() {
		// Add default settings
		add_option( 'wc_autoship_product_page_layout', 'radio-buttons' );
		add_option( 'wc_autoship_product_page_frequency_options', array(
			'7' => 'Weekly',
			'30' => 'Monthly',
			'60' => 'Bi-Monthly',
			'90' => 'Quarterly'
		) );
	}
	register_activation_hook( __FILE__, 'wc_autoship_product_page_install' );
	
	function wc_autoship_product_page_deactivate() {
	
	}
	register_deactivation_hook( __FILE__, 'wc_autoship_product_page_deactivate' );
	
	function wc_autoship_product_page_uninstall() {

	}
	register_uninstall_hook( __FILE__, 'wc_autoship_product_page_uninstall' );
	
	function wc_autoship_product_page_admin_scripts() {
		wp_enqueue_style( 'wc-autoship-product-page-admin', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), '1.0.0' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'wc-autoship-product-page-admin', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('jquery'), '1.0.0', true );
	}
	add_action( 'admin_enqueue_scripts', 'wc_autoship_product_page_admin_scripts' );
	
	function wc_autoship_product_page_settings( $settings ) {
		$settings[] = array(
			'title' => __( 'Product Page Autoship Options', 'wc-autoship-product-page' ),
			'desc' => __( 'Customize the autoship options on the product page', 'wc-autoship-product-page' ),
			'desc_tip' => false,
			'type' => 'title',
			'id' => 'wc_autoship_product_page_title'
		);
		$settings[] = array(
			'name' => __( 'Product Page Autoship Options Layout', 'wc-autoship-product-page' ),
			'desc' => __( 'The layout for autoship options on the product page', 'wc-autoship-product-page' ),
			'desc_tip' => true,
			'type' => 'select',
			'id' => 'wc_autoship_product_page_layout',
			'options' => array(
				'' => __( 'Default', 'wc-autoship-product-page' ),
				'radio-buttons' => __( 'Radio Buttons', 'wc-autoship-product-page' ),
				'select-box' => __( 'Select Box', 'wc-autoship-product-page' )
			)
		);
		$settings[] = array(
			'name' => __( 'Product Page Autoship Options', 'wc-autoship-product-page' ),
			'desc' => __( 'The autoship options to show on the product page', 'wc-autoship-product-page' ),
			'desc_tip' => true,
			'type' => 'wc_autoship_product_page_frequency_options',
			'id' => 'wc_autoship_product_page_frequency_options'
		);
		$settings[] = array(
			'type' => 'sectionend',
			'id' => 'wc_autoship_product_page_sectionend'
		);
		return $settings;
	}
	add_filter( 'wc_autoship_settings', 'wc_autoship_product_page_settings', 10, 1 );
	
	function wc_autoship_product_page_frequency_options( $value ) {
		$vars = array(
			'value' => $value,
			'description' => WC_Admin_Settings::get_field_description( $value ),
			'frequency_options' => get_option( 'wc_autoship_product_page_frequency_options' )
		);
		$relative_path = 'admin/wc-settings/wc-autoship/product-page-frequency-options';
		wc_autoship_product_page_include_plugin_template( $relative_path, $vars );
	}
	add_action( 'woocommerce_admin_field_wc_autoship_product_page_frequency_options', 'wc_autoship_product_page_frequency_options' );
	
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
	
	function wc_autoship_product_page_include_plugin_template( $relative_path, $vars = array() ) {
		extract( $vars );
		include ( wc_autoship_product_page_get_plugin_template_path( $relative_path, $vars ) );
	}
}
