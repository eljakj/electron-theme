jQuery(document).ready(function($) {

    'use strict';


      var block = document.querySelectorAll('.theme-select');

      for (var i = 0; i < block.length; i++) {
        var self = block[i];
        var placeholder = self.dataset.placeholder;
        var search = self.dataset.search === "true" ? null : Infinity;
        var searchPlaceholder = self.dataset.searchplaceholder;
        $(self).select2({
          placeholder: placeholder,
          allowClear: true,
          minimumResultsForSearch: search,
          searchInputPlaceholder: searchPlaceholder
        });
      }


    $(document).on('change', 'form#klb-attribute-filter select', function(){

        var $this    = $(this);
        var attrname = $this.attr('name');
        var form     = $this.closest('form');

        if ( $this.hasClass("child-attr") ) {
            return;
        }

        if ( !form.find('#child_'+ attrname).length ){
            return;
        }

        var data = {
            cache       : false,
            action      : 'klb_models_output',
            selected_id : $(this).find('option:selected').attr("id"),
            attr_name   : $(this).find('option:selected').val(),
            parent_id   : $(this).attr("id"),
            tax         : $(this).attr("tax"),
            beforeSend  : function () {
                form.append('<div class="attribute-filter-loader"></div>');
            }
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(electron_vars.ajaxurl, data, function(response) {

            form.find('#child_'+data.parent_id).html(response);
            form.find('#child_'+data.parent_id).removeAttr('disabled');

            // remove the loader
            $('.attribute-filter-loader').remove();
        });

    });


    $(document).on('change', 'form#klb-attribute-filter select', function(){

        var sameselect = $(this).attr('name');

        if($(this).closest('form').find('select[name="'+ sameselect +'"]').length > 1){
            var total = '';
            var selectfield = $(this).closest('form').find('select[name="'+ sameselect +'"]').length;

            $(this).closest('form').find('select[name="'+ sameselect +'"]').each(function(index){
                if($(this).val() && $(this).val() != '0'){
                    total += $(this).val();
                }
                var last_item = index === selectfield - 1;

                if (!last_item) {
                    total += ',';
                }
            });

            var str = total.replace(/,\s*$/, "");

            var textValue = $(this).closest('form').find('#klb_'+ sameselect +'').val(str);
        }
    });

    $(document).on('submit', 'form#klb-attribute-filter', function(){
        var $this = $(this);
        var form  = $this.closest('form');
        $this.find(':input').filter(function() { return !this.value; }).attr('disabled', 'disabled');

        $this.find('select:not([disabled]').each(function(){

            var name   = $(this).attr('name');
            var select = form.find('select[name="'+ name +'"]');

            if ( select.length > 1){
                select.attr('disabled', 'disabled');
            }
        });

        return true;
    });
});
