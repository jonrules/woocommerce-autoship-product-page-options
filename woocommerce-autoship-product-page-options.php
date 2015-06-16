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
}
