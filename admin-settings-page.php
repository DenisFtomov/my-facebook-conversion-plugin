<?php
/**
 * Admin settings page for My Facebook Conversion Plugin.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get saved settings from database.
$settings = get_option( 'my_fb_conversion_plugin_settings' );

// Update settings on form submit.
if ( isset( $_POST['my_fb_conversion_plugin_submit'] ) ) {

    // Validate input data.
    $pixel_id    = sanitize_text_field( $_POST['pixel_id'] );
    $access_token = sanitize_text_field( $_POST['access_token'] );

    // Save settings to database.
    update_option( 'my_fb_conversion_plugin_settings', array(
        'pixel_id'    => $pixel_id,
        'access_token' => $access_token,
    ) );

    // Display success message.
    $message = __( 'Settings saved.', 'my-fb-conversion-plugin' );
}

?>

<div class="wrap">
    <h1><?php esc_html_e( 'My Facebook Conversion Plugin Settings', 'my-fb-conversion-plugin' ); ?></h1>

    <?php if ( isset( $message ) ) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo esc_html( $message ); ?></p>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="pixel_id"><?php esc_html_e( 'Pixel ID', 'my-fb-conversion-plugin' ); ?></label></th>
                    <td><input type="text" id="pixel_id" name="pixel_id" value="<?php echo esc_attr( $settings['pixel_id'] ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="access_token"><?php esc_html_e( 'Access Token', 'my-fb-conversion-plugin' ); ?></label></th>
                    <td><input type="text" id="access_token" name="access_token" value="<?php echo esc_attr( $settings['access_token'] ); ?>" class="regular-text"></td>
                </tr>
            </tbody>
        </table>
        <?php wp_nonce_field( 'my_fb_conversion_plugin_submit', 'my_fb_conversion_plugin_nonce' ); ?>
        <input type="submit" name="my_fb_conversion_plugin_submit" class="button button-primary" value="<?php esc_attr_e( 'Save Settings', 'my-fb-conversion-plugin' ); ?>">
    </form>
</div>
