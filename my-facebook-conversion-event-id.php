<?php
function generate_event_id($event_data) {
  $event_string = implode('|', $event_data);
  return sha1($event_string);
}
?>
