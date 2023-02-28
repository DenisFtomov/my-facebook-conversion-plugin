<?php
/**
 * Plugin Name: My Facebook Conversion Plugin
 * Plugin URI: https://example.com/
 * Description: A plugin for integrating Facebook API Conversions into your WooCommerce store.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
define( 'MY_FACEBOOK_CONVERSION_PLUGIN_VERSION', '1.0.0' );
define( 'MY_FACEBOOK_CONVERSION_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MY_FACEBOOK_CONVERSION_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files
require_once MY_FACEBOOK_CONVERSION_PLUGIN_DIR . 'my-facebook-conversion-settings-page.php';
require_once MY_FACEBOOK_CONVERSION_PLUGIN_DIR . 'my-facebook-conversion-ajax-handler.php';
require_once MY_FACEBOOK_CONVERSION_PLUGIN_DIR . 'my-facebook-conversion-event-id.php';
require_once MY_FACEBOOK_CONVERSION_PLUGIN_DIR . 'my-facebook-conversion-event-value.php';

// Register activation and deactivation hooks
register_activation_hook( __FILE__, 'my_facebook_conversion_plugin_activate' );
register_deactivation_hook( __FILE__, 'my_facebook_conversion_plugin_deactivate' );

// Add settings page to the admin menu
add_action( 'admin_menu', 'my_facebook_conversion_plugin_add_settings_page' );
function my_facebook_conversion_plugin_add_settings_page() {
	add_options_page(
		'My Facebook Conversion Settings',
		'My Facebook Conversion',
		'manage_options',
		'my-facebook-conversion-settings',
		'my_facebook_conversion_plugin_render_settings_page'
	);
}

// Enqueue scripts and styles
add_action( 'admin_enqueue_scripts', 'my_facebook_conversion_plugin_enqueue_scripts' );
function my_facebook_conversion_plugin_enqueue_scripts() {
	wp_enqueue_style(
		'my-facebook-conversion-plugin-styles',
		MY_FACEBOOK_CONVERSION_PLUGIN_URL . 'css/my-facebook-conversion-plugin.css',
		array(),
		MY_FACEBOOK_CONVERSION_PLUGIN_VERSION
	);

	wp_enqueue_script(
		'my-facebook-conversion-plugin-script',
		MY_FACEBOOK_CONVERSION_PLUGIN_URL . 'js/my-facebook-conversion-tracking.js',
		array( 'jquery' ),
		MY_FACEBOOK_CONVERSION_PLUGIN_VERSION,
		true
	);

	wp_localize_script( 'my-facebook-conversion-plugin-script', 'myFacebookConversionAjax', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'my-facebook-conversion-nonce' )
	) );
}

// Activation function
function my_facebook_conversion_plugin_activate() {
	// Activation code here
}

// Deactivation function
function my_facebook_conversion_plugin_deactivate() {
	// Deactivation code here
}
