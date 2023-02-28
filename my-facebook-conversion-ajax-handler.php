<?php
/**
 * Обработчик AJAX запросов на серверные события Facebook API Conversions
 */

// Проверка наличия запроса
if (isset($_POST['event'])) {

  // Подключаем WordPress
  define('WP_USE_THEMES', false);
  require_once('../../../../../wp-load.php');

  // Получаем данные события
  $event = json_decode(stripslashes($_POST['event']));

  // Проверяем, существует ли уже такое событие в базе данных
  $event_id = get_option('my_facebook_conversion_event_id_'.$event->event_name);
  if ($event_id === false) {
    // Если событие не существует, генерируем новый уникальный идентификатор
    $event_id = my_facebook_conversion_generate_event_id();
    // Сохраняем новый идентификатор в базе данных
    update_option('my_facebook_conversion_event_id_'.$event->event_name, $event_id);
  }

  // Обновляем событие с ценностью
  my_facebook_conversion_update_event_value($event_id, $event->event_name, $event->value);

  // Возвращаем успешный ответ на запрос
  echo json_encode(array('status' => 'success'));

} else {

  // Возвращаем ошибку, если запрос не содержит данных о событии
  echo json_encode(array('status' => 'error', 'message' => 'No event data provided'));

}
