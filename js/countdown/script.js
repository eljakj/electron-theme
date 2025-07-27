jQuery(document).ready(function($) {

    /*-- Strict mode enabled --*/
    'use strict';

    $('[data-countdown]').each(function () {
        var self      = $(this),
            data      = self.data('countdown'),
            countDate = data.date,
            expired   = data.expired;

        let countDownDate = new Date( countDate ).getTime();

        const d = self.find( '.days' );
        const h = self.find( '.hours' );
        const m = self.find( '.minutes' );
        const s = self.find( '.second' );

        var x = setInterval(function() {

            var now = new Date().getTime();

            var distance = countDownDate - now;

            var days    = ('0' + Math.floor(distance / (1000 * 60 * 60 * 24))).slice(-2);
            var hours   = ('0' + Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).slice(-2);
            var minutes = ('0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).slice(-2);
            var seconds = ('0' + Math.floor((distance % (1000 * 60)) / 1000)).slice(-2);

            d.text( days );
            h.text( hours );
            m.text( minutes );
            s.text( seconds );

            if (distance < 0) {
                clearInterval(x);
                console.log( expired );
                self.parents('.electron-summary-item').addClass('expired');
                self.html('<div class="expired">' + expired + '</div>');
            }
        }, 1000);
    });

});
