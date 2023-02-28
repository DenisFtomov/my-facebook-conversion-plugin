<?php
/**
 * Update Facebook event value.
 *
 * @param string $event_name Name of the event.
 * @param float  $value      Value to be added to the event.
 * @param string $event_id   ID of the event to update.
 * 
 * @return bool Whether the update was successful.
 */
function update_facebook_event_value($event_name, $value, $event_id) {
  // Get the Facebook pixel ID and access token from the plugin settings.
  $pixel_id = get_option('facebook_pixel_id');
  $access_token = get_option('facebook_access_token');

  // Build the API endpoint for updating the event value.
  $api_endpoint = 'https://graph.facebook.com/v11.0/'.$pixel_id.'/events';
  $api_endpoint .= '?access_token='.$access_token;

  // Build the JSON data for the API request.
  $json_data = array(
    'data' => array(
      array(
        'event_name' => $event_name,
        'event_id' => $event_id,
        'user_data' => array(
          'em' => md5($event_id),
        ),
        'custom_data' => array(
          array(
            'type' => 'value',
            'value' => $value,
            'currency' => 'USD',
          ),
        ),
      ),
    ),
  );

  // Send the API request to update the event value.
  $response = wp_remote_post(
    $api_endpoint,
    array(
      'headers' => array(
        'Content-Type' => 'application/json',
      ),
      'body' => json_encode($json_data),
    )
  );

  // Check if the API request was successful.
  if (is_wp_error($response)) {
    error_log('Error updating Facebook event value: '.$response->get_error_message());
    return false;
  } else {
    return true;
  }
}
