<?php
function fb_conversion_plugin_options_page() {
    ?>
    <div class="wrap">
        <h2>Facebook Conversion Plugin Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('fb_conversion_plugin_options'); ?>
            <?php do_settings_sections('fb_conversion_plugin'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function fb_conversion_plugin_settings_init() {
    register_setting('fb_conversion_plugin_options', 'fb_pixel_id');
    register_setting('fb_conversion_plugin_options', 'fb_access_token');
    add_settings_section('fb_conversion_plugin_section', 'Facebook Conversion Plugin Settings', 'fb_conversion_plugin_section_callback', 'fb_conversion_plugin');
    add_settings_field('fb_pixel_id', 'Facebook Pixel ID', 'fb_pixel_id_callback', 'fb_conversion_plugin', 'fb_conversion_plugin_section');
    add_settings_field('fb_access_token', 'Facebook Access Token', 'fb_access_token_callback', 'fb_conversion_plugin', 'fb_conversion_plugin_section');
}

function fb_conversion_plugin_section_callback() {
    echo '<p>Enter your Facebook Pixel ID and Access Token below:</p>';
}

function fb_pixel_id_callback() {
    $fb_pixel_id = get_option('fb_pixel_id');
    echo '<input type="text" name="fb_pixel_id" value="' . esc_attr($fb_pixel_id) . '" />';
}

function fb_access_token_callback() {
    $fb_access_token = get_option('fb_access_token');
    echo '<input type="text" name="fb_access_token" value="' . esc_attr($fb_access_token) . '" />';
}

add_action('admin_menu', function () {
    add_options_page(
        'Facebook Conversion Plugin',
        'Facebook Conversion Plugin',
        'manage_options',
        'fb_conversion_plugin',
        'fb_conversion_plugin_options_page'
    );
});

add_action('admin_init', 'fb_conversion_plugin_settings_init');
