jQuery(document).ready(function($) {

    "use strict";

    function electronQtyBtn() {
        $('body').off('click.qtyBtn').on('click.qtyBtn','.plus, .minus', function() {

            var $this   = $(this),
                wrapper = $this.closest('.cart-quantity-wrapper'),
                qty     = $this.closest('.quantity').find('.qty'),
                val     = parseFloat( $(qty).val() ),
                max     = parseFloat( $(qty).attr('max') ),
                min     = parseFloat( $(qty).attr('min') ),
                step    = parseFloat( $(qty).attr('step') ),
                new_val = 0;

            if ( ! val || val === '' || val === 'NaN' ) {
                val = 0;
            }
            if ( max === '' || max === 'NaN' ) {
                max = '';
            }
            if ( min === '' || min === 'NaN' ) {
                min = 0;
            }
            if ( step === 'any' || step === '' || step === undefined || step === 'NaN' ) {
                step = 1;
            } else {
                step = step;
            }

            // Update values
            if ( $this.is( '.plus' ) ) {
                if ( max && ( max === val || val > max ) ) {
                    $(qty).val( max );
                    $this.addClass('disabled');
                } else {
                    $this.parent().find('.minus').removeClass('disabled');
                    new_val = val + step;
                    $(qty).val( new_val );
                    if ( max && ( max === new_val || new_val > max ) ) {
                        $this.addClass('disabled');
                    }
                    $(qty).trigger('change');
                }
            } else {
                if ( min && ( min === val || val < min ) ) {
                    $(qty).val( min );
                    $this.addClass('disabled');
                } else if ( val > 0 ) {
                    $this.parent().find('.plus').removeClass('disabled');
                    new_val = val - step;
                    $(qty).val( new_val );
                    if ( min && ( min === new_val || new_val < min ) ) {
                        $this.addClass('disabled');
                    }
                    $(qty).trigger('change');
                }
            }

            $('.cart-update-button[name="update_cart"]').addClass('active').attr('aria-disabled',false);
            $('.cart-update-button[name="update_cart"]').parents('.electron-hidden').slideDown();
            wrapper.addClass('active');
            $('.single_add_to_cart_button.disabled').removeClass('disabled');
            if ( $('.electron-shop-popup-notices .woocommerce-error').length>0 ) {
                $('.electron-shop-popup-notices .woocommerce-error').remove();
            }
        });
    }

    electronQtyBtn();

    $(document.body).on('electron_on_qtybtn', electronQtyBtn );

    $(document.body).on( 'update_checkout', electronQtyBtn );
});
