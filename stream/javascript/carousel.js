require(['jquery'], function($) {
    // Загружаем Bootstrap через requireJS (CDN)
    require(['https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js'], function() {
        console.log('✅ Bootstrap JS загружен');

        $(document).ready(function () {
            $('#herocarousel').carousel({
                interval: 3000,
                pause: 'hover'
            });
            console.log('✅ Карусель инициализирована');
        });
    });
});
