<?php
/**
 * Plugin Name: My Facebook Conversion Plugin
 * Plugin URI: https://example.com
 * Description: Plugin for tracking Facebook API conversions.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 **/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class My_Facebook_Conversion_Plugin {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page() {
        add_options_page(
            'My Facebook Conversion Plugin Settings',
            'My Facebook Conversion Plugin',
            'manage_options',
            'my-facebook-conversion-settings',
            array( $this, 'create_admin_page' )
        );
    }

    public function create_admin_page() {
        // Include the settings page.
        require_once plugin_dir_path( __FILE__ ) . 'my-facebook-conversion-settings-page.php';
    }

    public function page_init() {
        // Register settings.
        register_setting(
            'my-facebook-conversion-settings',
            'my_facebook_conversion_pixel_id'
        );

        register_setting(
            'my-facebook-conversion-settings',
            'my_facebook_conversion_access_token'
        );
    }
}

new My_Facebook_Conversion_Plugin();
