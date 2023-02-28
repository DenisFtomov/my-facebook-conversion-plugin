// Определяем функцию для отправки события Facebook
function trackFacebookConversion(eventName, eventData) {
  // Определяем идентификатор пикселя и токен доступа из настроек плагина
  var pixelId = myFacebookConversionSettings.pixelId;
  var accessToken = myFacebookConversionSettings.accessToken;

  // Проверяем, что идентификатор пикселя и токен доступа заданы
  if (pixelId && accessToken) {
    // Отправляем событие Facebook через API
    fbq('track', eventName, eventData);
  }
}

// Определяем функцию для обработки событий на странице
function trackPageEvents() {
  // Получаем данные событий со страницы
  var pageEventsData = myFacebookConversionSettings.pageEventsData;

  // Проверяем, что данные событий заданы
  if (pageEventsData) {
    // Обходим все события и добавляем обработчик на каждое событие
    for (var eventName in pageEventsData) {
      // Получаем данные для текущего события
      var eventData = pageEventsData[eventName];

      // Добавляем обработчик на текущее событие
      $(document).on(eventName, eventData.selector, function() {
        // Выполняем отслеживание события
        trackFacebookConversion(eventName, eventData.params);
      });
    }
  }
}

// Вызываем функцию для обработки событий на странице
trackPageEvents();
