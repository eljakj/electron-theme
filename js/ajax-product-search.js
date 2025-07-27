(function($){

    "use strict";

    function productSearch(form,query,currentQuery,timeout){

        var search     = form.find('.electron-ajax-search-input'),
            category   = form.find('.category-list li.active').attr('data-val'),
            resultWrap = form.next('.electron-ajax-search-results'),
            formWrap   = form.parent(),
            maxStr     = formWrap.data('max-str');

        //resultWrap.removeClass('active');

        search.parents('.electron-header-mobile-content').removeClass('ajax-active search-loading');

        query = query.trim();

        if ( query.length >= maxStr ) {

            if ( timeout ) {
                clearTimeout(timeout);
            }

            resultWrap.empty().addClass('active electron-spinner loading');

            if ( query != currentQuery ) {
                timeout = setTimeout(function() {

                    $.ajax({
                        url  :electron_vars.ajax_url,
                        type : 'get',
                        data : {
                            action   : 'electron_ajax_search_product',
                            keyword  : query,
                            category : category
                        },
                        success: function(data) {
                            currentQuery = query;

                            resultWrap.removeClass('electron-spinner loading');
                            search.parents('.electron-header-mobile-content').removeClass('search-loading').addClass('ajax-active');

                            search.parent().addClass('active');

                            if (data.length) {
                                resultWrap.html('<ul>'+data+'</ul>').addClass('active').removeClass('electron-spinner empty');
                                var total  = resultWrap.find('.search-total-link');
                                var textTotal = electron_vars.search_total;
                                if (total.length>0) {
                                    total.find('.search-total-text').html(textTotal);
                                    var totalC = total.html();
                                    resultWrap.append('<div class="search-total-wrapper">'+totalC+'</div>');
                                }
                            } else {
                                resultWrap.html(electron_vars.no_results).addClass('active electron-spinner empty');
                            }

                            clearTimeout(timeout);
                            timeout = false;
                        }
                    });
                }, 500);
            }
        } else {

            search.parent().removeClass('loading');
            resultWrap.removeClass('active loading').addClass('empty');

            clearTimeout(timeout);
            timeout = false;
        }
    }

    var formName   = 'form[name="electron-ajax-product-search-form"]';
    var catSelect  = 'form[name="electron-ajax-product-search-form"] .category-list li';
    var catSelectW = 'form[name="electron-ajax-product-search-form"] .category-select-wrapper';
    var formInput  = 'form[name="electron-ajax-product-search-form"] .electron-ajax-search-input';
    var formClose  = 'form[name="electron-ajax-product-search-form"] .electron-ajax-close-search-results';

    $(document.body).on('submit', formName ,function(event){

        var form   = $(this),
            search = form.find('.electron-ajax-search-input'),
            val    = search.val();

        if ( val === '' || val === 'undefined' ) {
            event.preventDefault();
            search.after('<div class="error">'+electron_vars.fill+'</div>');
            search.focus();
            setTimeout( function(){
                form.find('div.error').remove();
            },2000)
        }
    });

    $(document.body).on('click', catSelect, function(){

        var $this    = $(this),
            cat      = $this.html(),
            form     = $this.closest('form'),
            search   = form.find('.electron-ajax-search-input'),
            query    = search.val(),
            curQuery = '',
            timeout  = false;

        $this.parents('.category-select-wrapper').find('.electron-ajax-selected .cat-name').text(cat).attr('data-val',$this.data('val'));

        $this.siblings().removeClass('active');

        $this.addClass('active');

        if ( !$this.hasClass('empty-cat') ) {
           $('.empty-cat').removeClass('electron-hidden');
        } else {
            $('.empty-cat').addClass('electron-hidden');
        }

        if ( $this.hasClass('empty-cat') ) {
           $this.addClass('electron-hidden').attr('data-val','');
        }

        productSearch(form,query,curQuery,timeout);
    });

    $(document.body).on('keyup', formInput, function(e){
        var $this      = $(this),
            form       = $this.closest('form'),
            search     = form.find('.electron-ajax-search-input'),
            resultWrap = form.next('.electron-ajax-search-results'),
            curQuery   = '',
            timeout    = false,
            query      = $this.val();

        productSearch(form,query,curQuery,timeout);
    });

    $(document.body).on('keypress', formInput, function(e){
        var $this      = $(this),
            form       = $this.closest('form'),
            search     = form.find('.electron-ajax-search-input'),
            resultWrap = form.next('.electron-ajax-search-results');

        if( e.which === 13 ) {
            var count = resultWrap.find('li').length;
            if ( count == 1 ) {
                e.preventDefault();
                var url = resultWrap.find('>ul li a.electron-ajax-product-link').attr('href');
                window.location.href = url;
            }
        }
    });

    $(document.body).on('click', formClose, function(e){
        var $this      = $(this),
            form       = $this.parents('form'),
            formWrap   = form.parent(),
            search     = form.find('.electron-ajax-search-input'),
            select     = form.find('.category-select-wrapper'),
            selectAct  = form.find('.cat-name'),
            selectDef  = form.find('.category-list .empty-cat').text(),
            resultWrap = form.next('.electron-ajax-search-results');

        search.val('');
        selectAct.html(selectDef);
        resultWrap.removeClass('active');
        form.removeClass('active');
        formWrap.removeClass('active');
        $(this).parent().removeClass('active loading');
    });

    $(document.body).on('click', catSelectW, function(event) {
        if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    // Close when clicking outside
    $(document).on('click', function(event) {
        if ( $(event.target).closest('.electron-ajax-product-search').length === 0 ) {
            $('.category-select-wrapper').removeClass('active');
            $('.electron-ajax-search-results').removeClass('active');
        }
    });

    $(document.body).on('focus', formInput, function(e){
        var $this      = $(this),
            form       = $this.closest('form'),
            resultWrap = form.next('.electron-ajax-search-results'),
            select     = form.find('.category-select-wrapper');

        if (resultWrap.find('li').length>0) {
            resultWrap.addClass('active');
        }
        select.removeClass('active');
    });

})(jQuery);
