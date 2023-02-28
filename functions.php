<?php
function fb_conversion_filter_events($event) {
    $existing_events = get_option('fb_conversion_events', array());
    if (in_array($event['id'], $existing_events)) {
        return false;
    }
    $existing_events[] = $event['id'];
    update_option('fb_conversion_events', $existing_events);
    return true;
}

function fb_conversion_add_value($event) {
    if ($event['event_name'] == 'Purchase') {
        $value = $event['value'];
        $currency = $event['currency'];
        $conversion_value = array(
            'currency' => $currency,
            'value' => $value
        );
        return $conversion_value;
    }
    return null;
}

function fb_conversion_send_event($event_name, $conversion_value, $user_data) {
    $fb_pixel_id = get_option('fb_pixel_id');
    $fb_access_token = get_option('fb_access_token');
    $fb_api_url = 'https://graph.facebook.com/v11.0/' . $fb_pixel_id . '/events?access_token=' . $fb_access_token;
    $event_data = array(
        'event_name' => $event_name,
        'event_time' => time(),
        'user_data' => $user_data,
        'custom_data' => array(
            'value' => $conversion_value
        )
    );
    $json_data = json_encode($event_data);
    $args = array(
        'body' => $json_data,
        'headers' => array(
            'Content-Type' => 'application/json'
        ),
        'method' => 'POST',
        'timeout' => 5
    );
    $response = wp_remote_post($fb_api_url, $args);
    if (is_wp_error($response)) {
        error_log($response->get_error_message());
    }
}
