<?php
/**
 * Функция, которая возвращает массив с данными Facebook Pixel
 */
function get_facebook_pixel_data() {
    // Получаем настройки плагина
    $options = get_option('my_facebook_conversion_settings');

    // Если настройки не заданы, возвращаем пустой массив
    if (empty($options['pixel_id']) || empty($options['access_token'])) {
        return array();
    }

    // Формируем массив с данными Pixel
    $pixel_data = array(
        'id' => $options['pixel_id'],
        'access_token' => $options['access_token']
    );

    return $pixel_data;
}

/**
 * Функция, которая отправляет событие Facebook Pixel на сервер
 */
function send_facebook_conversion_event($event_name, $event_data) {
    // Получаем данные Facebook Pixel
    $pixel_data = get_facebook_pixel_data();

    // Если данные не заданы, ничего не делаем
    if (empty($pixel_data)) {
        return;
    }

    // Добавляем event_name в массив событий
    $event_data['event_name'] = $event_name;

    // Отправляем событие на сервер Facebook
    $url = 'https://graph.facebook.com/v12.0/' . $pixel_data['id'] . '/events';
    $params = array(
        'data' => array($event_data),
        'access_token' => $pixel_data['access_token']
    );
    $response = wp_remote_post($url, array(
        'body' => $params
    ));

    // Если ответ не успешный, выводим ошибку в лог
    if (is_wp_error($response)) {
        error_log($response->get_error_message());
    }
}

/**
 * Функция, которая удаляет дубликаты из массива событий
 */
function remove_duplicate_events($events) {
    // Получаем массив ID событий
    $event_ids = array_column($events, 'event_id');

    // Получаем уникальные значения ID событий
    $unique_event_ids = array_unique($event_ids);

    // Если все ID уникальные, возвращаем исходный массив
    if (count($event_ids) === count($unique_event_ids)) {
        return $events;
    }

    // Иначе оставляем только первое вхождение каждого события
    $unique_events = array();
    foreach ($events as $event) {
        if (!in_array($event['event_id'], $unique_event_ids)) {
            continue;
        }
        $unique_event_ids = array_diff($unique_event_ids, array($event['event_id']));
        $unique_events[] = $event;
    }

    return $unique_events;
}
