jQuery(document).ready(function($){
    "use strict";

    var t,a,
    headerid        = $('#header_elementor_templates-select'),
    headertemp      = $('#info-edit_header_elementor_template .redux-info-desc'),
    bheaderid       = $('#before_header_template-select'),
    bheadertemp     = $('#info-edit_before_header_template .redux-info-desc'),
    aheaderid       = $('#after_header_template-select'),
    aheadertemp     = $('#info-edit_after_header_template .redux-info-desc'),
    bbarheaderid    = $('#header_bottom_bar_template-select'),
    bbarheadertemp  = $('#info-edit_header_bottom_bar_template .redux-info-desc'),
    sidebarid       = $('#blog_sidebar_templates-select'),
    sidebartemp     = $('#info-edit_sidebar_elementor_template .redux-info-desc'),
    blog_heroid     = $('#blog_hero_templates-select'),
    blog_herotemp   = $('#info-edit_blog_hero_elementor_template .redux-info-desc'),
    single_heroid   = $('#single_hero_elementor_templates-select'),
    single_herotemp = $('#info-edit_single_hero_template .redux-info-desc'),
    error_pageid    = $('#error_page_elementor_templates-select'),
    error_pagetemp  = $('#info-edit_error_page_template .redux-info-desc'),
    footerid        = $('#footer_elementor_templates-select'),
    footertemp      = $('#info-edit_footer_template .redux-info-desc'),
    product_header_type = $('#electron_product_header_type'),
    href            = window.location.href,
    index           = href.indexOf('/wp-admin'),
    homeUrl         = href.substring(0, index);

    if ( headerid.val() !== '' ) {
        headertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+headerid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    headerid.on('change', function(){
        if ( headerid.val() !== '' ) {
            headertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+headerid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( bheaderid.val() !== '' ) {
        headertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+bheaderid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    bheaderid.on('change', function(){
        if ( bheaderid.val() !== '' ) {
            bheadertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+bheaderid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( aheaderid.val() !== '' ) {
        headertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+aheaderid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    aheaderid.on('change', function(){
        if ( aheaderid.val() !== '' ) {
            aheadertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+aheaderid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( bbarheaderid.val() !== '' ) {
        headertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+bbarheaderid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    bbarheaderid.on('change', function(){
        if ( bbarheaderid.val() !== '' ) {
            bbarheadertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+bbarheaderid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( sidebarid.val() !== '' ) {
        sidebartemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+sidebarid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    sidebarid.on('change', function(){
        if ( sidebarid.val() !== '' ) {
            sidebartemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+sidebarid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( blog_heroid.val() !== '' ) {
        blog_herotemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+blog_heroid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    blog_heroid.on('change', function(){
        if ( blog_heroid.val() !== '' ) {
            blog_herotemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+blog_heroid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( single_heroid.val() !== '' ) {
        single_herotemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+single_heroid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    single_heroid.on('change', function(){
        if ( single_heroid.val() !== '' ) {
            single_herotemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+single_heroid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( error_pageid.val() !== '' ) {
        error_pagetemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+error_pageid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    error_pageid.on('change', function(){
        if ( error_pageid.val() !== '' ) {
            error_pagetemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+error_pageid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });
    if ( footerid.val() !== '' ) {
        footertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+footerid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
    }
    footerid.on('change', function(){
        if ( footerid.val() !== '' ) {
            footertemp.html( '<a class="thm-btn" href="'+homeUrl+'/wp-admin/post.php?post='+footerid.val()+'&action=elementor" target="_blank">Edit Template <i class="el el-arrow-right"></i></a>' );
        }
    });

    $(".electron-color-field").wpColorPicker(),
    $("#menu-to-edit").on("click",".item-edit",function(e){
        var t=$(this).closest(".menu-item").find(".electron-color-field");
        t.hasClass("wp-color-field")||t.wpColorPicker()
    }),

    $("body").hasClass("nav-menus-php")&&(window.onbeforeunload=null),

    $("#menu-to-edit").on("click",".electron-field-icon-url-input .upload-icon-button",function(e){
        var a=$(this);
        e.preventDefault();
        var r=wp.media({multiple:!1}).open().on("select",function(e){
            var t=r.state().get("selection").first().toJSON();
            a.prev('input[type="text"]').val(t.url);
        })
    });

    var megaMenu = $('#menu-to-edit .electron-field-link-mega input[type="checkbox"]');

    megaMenu.each( function() {
        var $this = $(this);
        var megaMenuParents = $this.parents('.menu-item-depth-0');
        var megaMenuParentsId = megaMenuParents.find('.menu-item-data-db-id').val();

        if ( $this.prop( "checked" ) ) {
            megaMenuParents.addClass('mega-parent').find('.menu-item-title').append( '<span class="electron-mega-menu-item-title">MEGA</span>' );

        } else {
            megaMenuParents.removeClass('mega-parent').find('.electron-mega-menu-item-title').remove();
        }

        $this.on('change', function(){
            if ( $this.prop( "checked" ) ) {
                megaMenuParents.addClass('mega-parent').find('.menu-item-title').append( '<span class="electron-mega-menu-item-title">MEGA</span>' );

                $('.menu-item-data-parent-id[value="'+megaMenuParentsId+'"]').each(function(){
                    var megaColumnId = $(this).val();
                    if ( megaColumnId == megaMenuParentsId ) {
                        $(this).parents('.menu-item-depth-1').find('.menu-item-title').append( '<span class="electron-mega-column-menu-item-title">COLUMN</span>' );
                    }
                });
            } else {
                megaMenuParents.removeClass('mega-parent').find('.electron-mega-menu-item-title').remove();
                $('.menu-item-data-parent-id[value="'+megaMenuParentsId+'"]').each(function(){
                    $(this).parents('.menu-item-depth-1').find('.electron-mega-column-menu-item-title').remove();
                });
            }
        });

        $('.menu-item-data-parent-id[value="'+megaMenuParentsId+'"]').each(function(){
            var megaColumnId = $(this).val();
            if ( megaColumnId == megaMenuParentsId && megaMenuParents.hasClass('mega-parent') ) {
                $(this).parents('.menu-item-depth-1').find('.menu-item-title').append( '<span class="electron-mega-column-menu-item-title">COLUMN</span>' );
            } else {
                $(this).parents('.menu-item-depth-1').find('.electron-mega-column-menu-item-title').remove();
            }
        });
    });

    $(".redux-field-container").each(function(){
        $(this).parents('tr').prepend('<div class="toggle-field"><i class="fa fa-arrow-up"></i></div>');
    });

    $("#shop_loop_product_layouts_hide>*").wrapAll('<div class="shop_loop_product_layouts_inner"></div>');
    $(".shop_loop_product_layouts_inner>h3").prependTo('#shop_loop_product_layouts_hide');

    $(".toggle-field").each( function() {
        $(this).on('click', function() {
            if ( $(this).hasClass('hide-field') ) {
                $(this).parent().removeClass('hide-field');
                $(this).removeClass('hide-field');
                $(this).next().next().find('.redux-field-container ').show();
                $(this).next().find('.description').show();
            } else {
                $(this).addClass('hide-field');
                $(this).addClass('hide-field');
                $(this).parent().addClass('hide-field');
                $(this).next().next().find('.redux-field-container ').hide();
                $(this).next().find('.description').hide();
            }
        });
    });

    if ( product_header_type.val() == 'custom' ) {
        $('.electron-panel-subheading.menu-customize,.electron_product_header_bgcolor_field,.electron_product_header_menuitem_color_field,.electron_product_header_menuitem_hvrcolor_field,.electron_product_header_svgicon_color_field,.electron_product_header_counter_bgcolor_field,.electron_product_header_counter_color_field,.electron_product_sticky_header_type_field,.electron_product_sticky_header_bgcolor_field,.electron_product_sticky_header_menuitem_color_field,.electron_product_sticky_header_menuitem_hvrcolor_field,.electron_product_sticky_header_svgicon_color_field,.electron_product_sticky_header_counter_bgcolor_field,.electron_product_sticky_header_counter_color_field').addClass('show_if_header_custom');
    }
    product_header_type.on('change', function(){
        if ( product_header_type.val() == 'custom' ) {
        $('.electron-panel-subheading.menu-customize,.electron_product_header_bgcolor_field,.electron_product_header_menuitem_color_field,.electron_product_header_menuitem_hvrcolor_field,.electron_product_header_svgicon_color_field,.electron_product_header_counter_bgcolor_field,.electron_product_header_counter_color_field,.electron_product_sticky_header_type_field,.electron_product_sticky_header_bgcolor_field,.electron_product_sticky_header_menuitem_color_field,.electron_product_sticky_header_menuitem_hvrcolor_field,.electron_product_sticky_header_svgicon_color_field,.electron_product_sticky_header_counter_bgcolor_field,.electron_product_sticky_header_counter_color_field').addClass('show_if_header_custom');
        } else {
            $('.electron-panel-subheading.menu-customize,.electron_product_header_bgcolor_field,.electron_product_header_menuitem_color_field,.electron_product_header_menuitem_hvrcolor_field,.electron_product_header_svgicon_color_field,.electron_product_header_counter_bgcolor_field,.electron_product_header_counter_color_field,.electron_product_sticky_header_type_field,.electron_product_sticky_header_bgcolor_field,.electron_product_sticky_header_menuitem_color_field,.electron_product_sticky_header_menuitem_hvrcolor_field,.electron_product_sticky_header_svgicon_color_field,.electron_product_sticky_header_counter_bgcolor_field,.electron_product_sticky_header_counter_color_field').removeClass('show_if_header_custom');
        }
    });

    if ( jQuery('.electron-select2').length ) {
        jQuery('.electron-select2').select2({
            placeholder: 'Select an option',
            allowClear: true,
            multiple: true
        });
        jQuery(document).on('widget-updated widget-added', function(){
            jQuery('.electron-select2').select2({
                placeholder: 'Select brands',
                allowClear: true,
                multiple: true
            });
        });
    }

    var meta_image_frame;

    $(document).on('click', '.electron-variation-gallery-add-button', function(event){
        event.preventDefault ? event.preventDefault() : (event.returnValue = false);
        var gallery = $(this).parent('div');

        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: 'Choose image(s)',
            multiple: 'add',
            button: { text: 'Choose image(s)' },
            library: { type: 'image' }
        });

        meta_image_frame.on('select', function(){
            var selection = meta_image_frame.state().get('selection');
            var size = 'thumbnail';
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                var field = gallery.find('input');
                field.val(field.val() + attachment.id + ';');
                gallery.find('ul.electron-variation-gallery-images').append("<li data-id=\""+attachment.id+"\"><img src="+attachment.url+" /></li>");
            });
            gallery.find('input').trigger('change');
        });

        meta_image_frame.open();
    });

    //Remove image from input and list
    $(document).on('click', 'ul.electron-variation-gallery-images li', function(event){
        event.preventDefault ? event.preventDefault() : (event.returnValue = false);
        var attId   = $(this).attr('data-id');
        var gallery = $(this).parent('ul').parent('div');
        $(this).remove();
        var field = gallery.find('input').val();
        field = field.replace(attId + ';', '');
        gallery.find('input').val(field);
        gallery.find('input').trigger('change');
    });
    $('.hide-admin-notice').on('click', function() {
        $(this).parents('.electron-admin-notice').fadeOut(200, function() {
            $(this).remove();
        });
    });

    // URL'den parametreleri al
    const urlParams = new URLSearchParams(window.location.search);

    // Kontrol etmek istediğiniz parametre adı
    const paramName = 'page';
    const paramValue = urlParams.get(paramName);

    // Parametre değerini kontrol et
    if ( paramValue === 'electron' ) {
        $('.toplevel_page_ninetheme_theme_manage .theme-options').addClass('current');
        $('.toplevel_page_ninetheme_theme_manage .header-builder').removeClass('current');
    }
    if ( paramValue === 'electron_header' ) {
        $('.toplevel_page_ninetheme_theme_manage .theme-options').removeClass('current');
        $('.toplevel_page_ninetheme_theme_manage .header-builder').addClass('current');
    }

});
