(function($) {
    'use strict';

    $(document).ready(function() {

        // Функция отправки данных на сервер
        function sendFacebookConversion(pixelId, accessToken, data) {
            $.ajax({
                url: ajaxurl, // переменная ajaxurl определена в WordPress и содержит адрес для обработки AJAX-запросов
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'send_facebook_conversion',
                    pixel_id: pixelId,
                    access_token: accessToken,
                    data: data
                },
                success: function(response) {
                    console.log('Сервер вернул ответ:', response);
                },
                error: function(error) {
                    console.error('Произошла ошибка:', error);
                }
            });
        }

        // Обработчик отправки формы настроек
        $('#my-facebook-conversion-settings-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var pixelId = $form.find('#my-facebook-conversion-pixel-id').val();
            var accessToken = $form.find('#my-facebook-conversion-access-token').val();
            var data = $form.serialize();
            sendFacebookConversion(pixelId, accessToken, data);
        });

    });

})(jQuery);
