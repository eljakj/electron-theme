jQuery(document).ready(function($) {
    var fetchedData = {};

    elementor.hooks.addAction('panel/open_editor/widget', function(panel, model, view) {
        var settings   = model.get('settings');
        var modelId    = model.id;
        var controls   = settings.controls;
        var attributes = settings.attributes;
        var dataType;
        var attrs = [];
        var select2Control = panel.$el.find('.elementor-control-post_filter .select2,.elementor-control-category_filter .select2');
        var selectId       = select2Control.parent().find('>select').attr('id');
        
        if ( attributes.post_filter ) {
            model.set('settings.attributes', attributes); // Restore updated data to settings
            model.save(); // save data
        }
        
        select2Control.on('click', function() {
            var $this = $(this);
            
            if ( $this.parents('.elementor-control').hasClass('elementor-control-post_filter')) {
                
                dataType = controls.post_filter.ajax.data.data_type;
                attrs    = attributes.post_filter;
            }
            
            
            if (!(modelId in fetchedData)) {
                fetchData(modelId,selectId,dataType,attrs);
            } else {
                updateSelectbox(selectId,fetchedData[modelId],attrs);
            }
        });
        
    });

    function fetchData(modelId,selectId,dataType,attrs) {
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action     : 'fetch_data_for_select2',
                data_type  : dataType,
                control_id : selectId
            },
            success: function(response) {
                
                var select = $('select#'+selectId);
                
                fetchedData[modelId] = response;
                updateSelectbox(selectId,response,attrs);
            }
        });
    }

    function updateSelectbox(selectId,data,attrs) {
        
        var select = $('select#'+selectId);
        
        $.each(data, function(key, value) {
            
            if ( attrs.indexOf(key) !== -1 ) {
                select.append($('<option selected></option>').val(key).html(value));
            } else {
                select.append($('<option></option>').val(key).html(value));
            }
        });
        
        select.select2();

        // Tıklamayı kaldır, veriler zaten yüklendi
        //select.off('click');
    }
});
