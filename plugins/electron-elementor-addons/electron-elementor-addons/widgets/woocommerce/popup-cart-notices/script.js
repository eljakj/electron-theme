'use strict';
 
(function($) {
  
  $(document.body).on('added_to_cart', function(e) {
      if ( jQuery('.electron-popup-notices').length ) {
        setTimeout(function() {
            jQuery('.electron-popup-notices').addClass('slide-in');
        }, 100);
        setTimeout(function() {
             jQuery('.electron-popup-notices').removeClass('slide-in');
        }, 4000);
      }
  });
  
})(jQuery);

