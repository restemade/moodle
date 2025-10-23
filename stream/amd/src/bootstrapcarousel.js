define(['jquery'], function($) {
    return {
        init: function() {
            $('#herocarousel').carousel({
                interval: 3000,
                pause: 'hover'
            });
            console.log('✅ Bootstrap carousel инициализирован через AMD');
        }
    };
});
