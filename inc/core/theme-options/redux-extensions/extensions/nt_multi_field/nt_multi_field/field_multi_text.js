/*global redux_change, redux*/

(function( $ ) {
    "use strict";


    redux.field_objects = redux.field_objects || {};
    redux.field_objects.nt_multi_field = redux.field_objects.nt_multi_field || {};

    redux.field_objects.nt_multi_field.init = function( selector ) {

        if ( !selector ) {
            selector = $( document ).find( '.redux-container-nt_multi_field:visible' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }
                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }
                el.find( '.nt-multi-field-remove' ).live(
                    'click', function() {
                        redux_change( $( this ) );

                        $( this ).prev( 'input[type="text"]' ).val( '' );
                        var id = $( this ).attr( 'data-id' );

                        $( this ).parent().slideUp(
                            'medium', function() {
                                $( this ).remove();

                                var lis = el.find( '#' + id + ' li').length;
                                if (lis == 1) {
                                    var add = el.find( '.nt-multi-field-add' );
                                    var name = add.attr( 'data-name' );

                                    el.find( '#' + id + ' li:last-child input[type="text"]' ).attr( 'name', name );
                                }
                            }
                        );
                    }
                );

                el.find( '.nt-multi-field-add' ).click(
                    function() {
                        var number = parseInt( $( this ).attr( 'data-add_number' ) );
                        var id = $( this ).attr( 'data-id' );
                        var name = $( this ).attr( 'data-name' ) + '[]';

                        for ( var i = 0; i < number; i++ ) {
                            var new_input = $( '#' + id + ' li:last-child' ).clone();
                            el.find( '#' + id ).append( new_input );
                            el.find( '#' + id + ' li:last-child' ).removeAttr( 'style' );
                            el.find( '#' + id + ' li:last-child input[type="text"]' ).val( '' );
                            el.find( '#' + id + ' li:last-child input[type="text"]' ).attr( 'name', name );
                        }

                        var lis = el.find( '#' + id + ' li').length;
                        if (lis > 1) {
                            var css, input;
                            el.find('#' + id + ' li').each(function(idx, val){
                                css = $(this).css('display');
                                if (css === 'none') {
                                    input = $(this).find('input[type="text"]');
                                    input.attr('name', '');
                                }
                            })
                        }
                    }
                );
            }
        );
    };
})( jQuery );
