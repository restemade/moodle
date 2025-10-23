// theme/stream_child/amd/src/carousel.js
define(['jquery'], function($) {
    return {
        init: function() {
            $('#herocarousel').carousel({
                interval: 3000,
                ride: 'carousel'
            });
        }
    };
});
