<?php
/**
 * Plugin Name: My Facebook Conversion Plugin
 * Plugin URI: https://example.com
 * Description: Plugin for integrating Facebook API Conversions for an online store.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 */

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'My_Facebook_Conversion_Plugin' ) ) {

	class My_Facebook_Conversion_Plugin {

		private static $instance;

		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof My_Facebook_Conversion_Plugin ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'page_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_ajax_my_facebook_conversion_event', array( $this, 'process_conversion_event' ) );
			add_action( 'wp_ajax_nopriv_my_facebook_conversion_event', array( $this, 'process_conversion_event' ) );
		}

		public function add_plugin_page() {
			add_menu_page(
				'My Facebook Conversion Plugin',
				'My Facebook Conversion',
				'manage_options',
				'my-facebook-conversion',
				array( $this, 'create_admin_page' ),
				'dashicons-analytics'
			);
		}

		public function create_admin_page() {
			include_once( 'my-facebook-conversion-settings-page.php' );
		}

		public function page_init() {
			register_setting(
				'my_facebook_conversion_options',
				'my_facebook_conversion_pixel_id'
			);
			register_setting(
				'my_facebook_conversion_options',
				'my_facebook_conversion_access_token'
			);
		}

		public function enqueue_scripts() {
			wp_enqueue_script( 'my_facebook_conversion_tracking', plugin_dir_url( __FILE__ ) . 'js/my-facebook-conversion-tracking.js', array( 'jquery' ), '1.0.0', true );
			wp_localize_script( 'my_facebook_conversion_tracking', 'myFacebookConversionSettings', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'pixelId' => get_option( 'my_facebook_conversion_pixel_id' ),
				'accessToken' => get_option( 'my_facebook_conversion_access_token' )
			) );
		}

		public function process_conversion_event() {
			include_once( 'my-facebook-conversion-ajax-handler.php' );
			wp_die();
		}
	}

	My_Facebook_Conversion_Plugin::get_instance();
}
