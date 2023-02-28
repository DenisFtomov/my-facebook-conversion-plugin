<?php
/**
 * Plugin settings page
 */

if (!defined('ABSPATH')) {
    exit;
}

// Check if user is authorized to manage options
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.', 'my-facebook-conversion-plugin'));
}

// Save settings if form is submitted
if (isset($_POST['save_settings'])) {
    update_option('my_facebook_conversion_pixel_id', sanitize_text_field($_POST['pixel_id']));
    update_option('my_facebook_conversion_access_token', sanitize_text_field($_POST['access_token']));
}

// Retrieve current settings values
$pixel_id = get_option('my_facebook_conversion_pixel_id', '');
$access_token = get_option('my_facebook_conversion_access_token', '');

?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="pixel_id"><?php esc_html_e('Pixel ID:', 'my-facebook-conversion-plugin'); ?></label></th>
                    <td><input type="text" id="pixel_id" name="pixel_id" value="<?php echo esc_attr($pixel_id); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="access_token"><?php esc_html_e('Access Token:', 'my-facebook-conversion-plugin'); ?></label></th>
                    <td><input type="text" id="access_token" name="access_token" value="<?php echo esc_attr($access_token); ?>" /></td>
                </tr>
            </tbody>
        </table>
        <?php wp_nonce_field('my_facebook_conversion_settings_nonce', 'my_facebook_conversion_settings_nonce'); ?>
        <p class="submit"><input type="submit" name="save_settings" class="button-primary" value="<?php esc_attr_e('Save Settings', 'my-facebook-conversion-plugin'); ?>" /></p>
    </form>
</div>
