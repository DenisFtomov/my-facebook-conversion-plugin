<?php
function fb_conversion_settings_page() {
    if (isset($_POST['submit'])) {
        update_option('fb_pixel_id', $_POST['fb_pixel_id']);
        update_option('fb_access_token', $_POST['fb_access_token']);
        echo '<div id="message" class="updated notice is-dismissible"><p>Настройки сохранены!</p></div>';
    }
    $fb_pixel_id = get_option('fb_pixel_id');
    $fb_access_token = get_option('fb_access_token');
?>
<div class="wrap">
    <h1>Facebook Conversion Tracking</h1>
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <th><label for="fb_pixel_id">Pixel ID</label></th>
                <td><input type="text" name="fb_pixel_id" id="fb_pixel_id" value="<?php echo esc_attr($fb_pixel_id); ?>" /></td>
            </tr>
            <tr>
                <th><label for="fb_access_token">Access Token</label></th>
                <td><input type="text" name="fb_access_token" id="fb_access_token" value="<?php echo esc_attr($fb_access_token); ?>" /></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Сохранить изменения" />
        </p>
    </form>
</div>
<?php } ?>
