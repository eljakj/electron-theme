jQuery(document).ready( function($) {

    $('.cr-slider').each(function(){
        var options = $(this).data('swiper-options');
        var productSlider = new NTSwiper(this,options);

        productSlider.on('init', function () {
            var index = this.activeIndex;
            var target = $('.product-slider__item').eq(index).data('target');
            $('.product-img__item').removeClass('active');
            $('.product-img__item#'+ target).addClass('active');
        });

        productSlider.on('slideChange', function () {
            var index = this.activeIndex;
            var target = $('.product-slider__item').eq(index).data('target');

            $('.product-img__item').removeClass('active');
            $('.product-img__item#'+ target).addClass('active');

            if(productSlider.isEnd) {
                $('.prev').removeClass('disabled');
                $('.next').addClass('disabled');
            } else {
                $('.next').removeClass('disabled');
            }

            if(productSlider.isBeginning) {
                $('.prev').addClass('disabled');
            } else {
                $('.prev').removeClass('disabled');
            }
        });
        productSlider.init();
    });

    $(".js-fav").on("click", function() {
        $(this).find('.heart').toggleClass("is-active");
    });

});
