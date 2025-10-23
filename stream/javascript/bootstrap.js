// Подключаем jQuery и Bootstrap 4 (если ещё не подключено Moodle-специфически)
require(['jquery'], function($) {
    // Просто проверим, что jQuery и Bootstrap работают
    $(document).ready(function () {
        console.log('Bootstrap carousel JS подключен');

        // Инициализация карусели (если вдруг не работает автоматически)
        $('#herocarousel').carousel({
            interval: 3000,
            pause: 'hover'
        });
    });
});
