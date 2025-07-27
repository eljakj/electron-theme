/*-----------------------------------------------------------------------------------

    Theme Name: electron
    Description: WordPress Theme
    Author: Ninetheme
    Author URI: https://ninetheme.com/
    Version: 1.0

-----------------------------------------------------------------------------------*/
"use strict";

(function(window, document, $) {

    if (electron_wishlist_get_cookie('electron_wishlist_key') == '') {
        electron_wishlist_set_cookie('electron_wishlist_key', electron_wishlist_get_key(), 7);
    }

    function electron_wishlist_get_key() {
        var result = [];
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var charactersLength = characters.length;

        for (var i = 0; i < 6; i++) {
            result.push(characters.charAt(Math.floor(Math.random() *
            charactersLength)));
        }

        return result.join('');
    }

    function electron_wishlist_set_cookie(cname, cvalue, exdays) {
        var d = new Date();

        d.setTime(d.getTime() + (
            exdays * 24 * 60 * 60 * 1000
        ));

        var expires = 'expires=' + d.toUTCString();

        document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/';
    }

    function electron_wishlist_get_cookie(cname) {
        var name = cname + '=';
        var ca = document.cookie.split(';');

        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];

            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {
                return decodeURIComponent(c.substring(name.length, c.length));
            }
        }

        return '';
    }

    // add
    $( document.body ).on('click touch', '.electron-wishlist-btn', function(e) {
        var $this = $(this),
            id    = $this.attr('data-id'),
            name  = $this.attr('data-name'),
            count = parseFloat(wishlist_vars.count),
            max   = parseFloat(wishlist_vars.max_count);
            
        if ( wishlist_vars.is_login == 'yes' ) {
            alert(electron_vars.wlogin);
           return;
        }
        
        // Redirect to cart option
        if ( $this.is('.added') ) {
            if ( wishlist_vars.page_url ) {
                window.location = wishlist_vars.page_url;
                return;
            }
        }
        
        if ( max != '' && ( count == max || count > max ) ) {
            alert(electron_vars.wmax);
            return;
        }
        
        var data = {
            action     : 'electron_wishlist_add',
            product_id : id,
            beforeSend : function() {
                $this.addClass('loading');
            }
        };
        
        $.post(wishlist_vars.ajax_url, data, function(response) {
            response     = JSON.parse( response );
            var duration = electron_vars.duration;
            var added    = electron_vars.wadded;
            var appended = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message">'+name+' '+added+'</div></div>';
            
            $(appended).prependTo('.electron-shop-popup-notices').delay(duration).fadeOut(300, function(){
                $(this).remove();
            });
            
            wishlist_vars.count++;
            
            $('.electron-wishlist-count').html(response['count']);
            
            $this.addClass('added').removeClass('loading');
        });
        
        e.preventDefault();
    });
    
    $( document ).on('click touch', '.electron-wishlist-del-icon', function(e) {
        
        var $this   = $(this),
            item    = $this.parents('.electron-wishlist-item'),
            pid     = item.attr('data-id'),
            name    = item.find('.product-name').html(),
            removed = electron_vars.wremoved,
            data    = {
                action : 'electron_wishlist_remove',
                pid    : pid,
                beforeSend: function() {
                    item.addClass('loading');
                }
            };
            
        $.post(wishlist_vars.ajax_url, data, function(response) {
            response     = JSON.parse( response );
            var count    = response['count'];
            var notice   = response['notice'];
            var appended = '';
            var duration = electron_vars.duration;
            
            if ( notice == 'login' ) {
                item.removeClass('loading');
                alert(electron_vars.wlogin);
                return;
            }
            
            if ( notice == 'error' ) {
                item.removeClass('loading');
                alert(electron_vars.werror);
                return;
            }
            
            if ( response['status'] == 1 ) {
                
                item.remove();
                
                if ( response['notice'] == 'removed' ) {
                    appended = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message">'+name+' '+removed+'</div></div>';
                    
                    $(appended).prependTo('.electron-shop-popup-notices').delay(duration).fadeOut(300, function(){
                        $(this).remove();
                    });
                }
                
            } else {
                
                item.removeClass('loading');
            }
            
            $('.electron-wishlist-count').html(count);
            $('.wishlist-content').attr('data-count',count);
            
            wishlist_vars.count = count;
            
            $('.electron-wishlist-btn[data-id="'+pid+'"]').removeClass('added');
            
        });
        e.preventDefault();
    });

    $(document).ready(function($) {
        $('.electron-wishlist-count').html(wishlist_vars.count);
        
        if ( ( typeof wishlist_vars != 'undefined' ) && wishlist_vars.products ) {
            var ids = wishlist_vars.products;
            for (let i = 0; i < ids.length; i++) {
              $('.electron-wishlist-btn[data-id="'+ids[i]+'"]').addClass('added');
            }
        }
    });
    
    // copy link
    $(document).on('click touch', '#electron-wishlist_copy_url, #electron-wishlist_copy_btn', function(e) {
        e.preventDefault();
        copy_to_clipboard('#electron-wishlist_copy_url');
    });
    
    function copy_to_clipboard(el) {
      // resolve the element
      el = (typeof el === 'string') ? document.querySelector(el) : el;
      
      // handle iOS as a special case
      if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
        // save current contentEditable/readOnly status
        var editable = el.contentEditable;
        var readOnly = el.readOnly;
        
        // convert to editable with readonly to stop iOS keyboard opening
        el.contentEditable = true;
        el.readOnly = true;
        
        // create a selectable range
        var range = document.createRange();
        range.selectNodeContents(el);
        
        // select the range
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        el.setSelectionRange(0, 999999);
        
        // restore contentEditable/readOnly to original state
        el.contentEditable = editable;
        el.readOnly = readOnly;
      } else {
        el.select();
      }
      
      // execute copy command
      document.execCommand('copy');
      
      // alert
      alert(electron_vars.copied_text + ' ' + el.value);
    }
    
})(window, document, jQuery);
