jQuery(document).ready(function($) {
    "use strict";

    $(document).on('submit', '.woocommerce-form-login.electron-ajax-login', function(event){
        event.preventDefault();

        var form     = $(this);
        var formData = form.serialize();
        var button   = form.find('button.woocommerce-form-login__submit');
        var data     = {
            cache      : false,
            type       : 'POST',
            action     : 'electron_ajax_login',
            beforeSend : function() {
                button.addClass("loading").attr('disabled', true);
            },
            logindata  : formData
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(electron_ajax_login.ajaxurl, data, function(response) {

            if ( response?.data?.redirecturl ) {
                $(".lost_password").hide();
                button.removeClass("loading").after('<ul class="woocommerce-message electron-success" style="display:none;"><li>'+response.data.message+'</li></ul>');
                $( '.woocommerce-message.electron-success' ).slideDown();
                window.location.href = response.data.redirecturl;
                return;
            }

            // Remove notices from all sources
            $( '.woocommerce-error, .woocommerce-message' ).remove();
            button.removeClass("loading").attr('disabled', false).after('<ul class="woocommerce-error"><li>'+response+'</li></ul>');

        });
    });


    $(document).on('submit', '.woocommerce-form-register', function(event){
        event.preventDefault();

        var form     = $(this);
        var formData = form.serialize();
        var button   = form.find('button.woocommerce-form-register__submit');
        var data     = {
            cache      : false,
            type       : 'POST',
            action     : 'electron_ajax_register',
            beforeSend : function() {
                button.addClass("loading").attr('disabled', true);
            },
            registerdata: formData
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(electron_ajax_login.ajaxurl, data, function(response) {

            if( response?.data?.redirecturl ){
                button.removeClass("loading").after('<ul class="woocommerce-message electron-success" style="display:none;"><li>'+response.data.message+'</li></ul>');
                $( '.woocommerce-message.electron-success' ).slideDown();
                window.location.href = response.data.redirecturl;
                return;
            }

            // Remove notices from all sources
            $( '.woocommerce-error, .woocommerce-message' ).remove();
            button.removeClass("loading").attr('disabled', false).after('<ul class="woocommerce-error"><li>'+response+'</li></ul>');

        });
    });

});
