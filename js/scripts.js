/*-----------------------------------------------------------------------------------

    Theme Name: Electron
    Description: WordPress Theme
    Author: Ninetheme
    Author URI: https://ninetheme.com/
    Version: 1.0

-----------------------------------------------------------------------------------*/
(function(window, document, $) {

    "use strict";

    $.fn.sameSize = function( width, max ) {
        var prop = width ? 'width' : 'height',
        size = Math.max.apply( null, $.map( this, function( elem ) {
            return $( elem )[ prop ]();
        })),
        max = size < max ? size : max;
        return this[ prop ]( max || size );
    };

    jQuery.event.special.touchstart = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };

    jQuery.event.special.touchmove = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };

    jQuery.event.special.wheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("wheel", handle, { passive: true });
        }
    };

    jQuery.event.special.mousewheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("mousewheel", handle, { passive: true });
        }
    };


    function initCookies() {

        jQuery(window).on('load',function() {

            if (document.cookie.indexOf("newsletterClosed=true") === -1) {
                var newsletter = document.getElementById("newsletterPopup");
                if (newsletter) {
                    setTimeout( function(){
                        newsletter.classList.add("active");
                        document.getElementById("newsletterInner").classList.add("active");
                        jQuery('html,body').addClass('newsletterPopupOpened');
                    },500);
                }
            }

            if (document.cookie.indexOf("gdprClosed=true") === -1) {
                var gdprPopup = document.getElementById("gdprPopup");
                if (gdprPopup) {
                    setTimeout( function(){
                        gdprPopup.classList.add("active");
                    },300);
                }
            }

            if (document.cookie.indexOf("formPopupClosed=true") === -1) {
                var formPopup   = document.getElementById("formPopupBtn");
                var formTimeout = jQuery(formPopup).data('timeout');
                if (formPopup) {
                    setTimeout( function(){
                        formPopup.classList.add("active");
                    },formTimeout);
                }
            }
        });

        var expiryDate = new Date();
        expiryDate.setDate(expiryDate.getDate() + 7);

        // newsletter
        var newsletterClose = document.getElementById("newsletterClose");
        if (newsletterClose) {
            newsletterClose.addEventListener("click", function() {
                document.getElementById("newsletterInner").classList.remove("active");
                jQuery('html,body').removeClass('newsletterPopupOpened');
                setTimeout( function(){
                    document.getElementById("newsletterPopup").classList.add("closed");
                },300);
                document.cookie = "newsletterClosed=true; expires=" + expiryDate.toUTCString() + "; path=/";
            });
        }

        // siteclosePopup
        var disableSiteClosePopup = document.querySelectorAll(".disableSiteClosePopup");

        if (disableSiteClosePopup) {
            disableSiteClosePopup.forEach(function(element) {
                element.addEventListener("click", function() {
                    document.getElementById("sitecloseInner").classList.remove("active");
                    setTimeout( function(){
                        document.getElementById("siteclosePopup").classList.add("closed");
                        jQuery('html,body').removeClass('has-popup-overlay sitecloseOpened');
                    },300);
                    document.cookie = "sitecloseClosed=true; expires=" + expiryDate.toUTCString() + "; path=/";
                });
            });
        }

        // formPopup
        var formPopupBtn     = document.getElementById("formPopupBtn");
        var formPopupTrigger = document.getElementById("formPopupTrigger");
        var formPopup        = document.getElementById("formPopup");
        var formPopupInner   = document.getElementById("formPopupInner");

        if (formPopupTrigger) {

            formPopupTrigger.addEventListener("click", function() {
                jQuery('html,body').addClass('has-popup-overlay formPopupOpened');
                formPopup.classList.add("active");
                formPopupInner.classList.add("active");
            });

            var disableFormPopup = document.querySelectorAll(".disableFormPopup");

            // Her bir öğe üzerinde döngü
            disableFormPopup.forEach(function(element) {
                // Click olayını ekle
                element.addEventListener("click", function() {
                    formPopupBtn.classList.remove("active");
                    formPopup.classList.remove("active");
                    setTimeout( function(){
                        formPopupBtn.classList.add("closed");
                        formPopup.classList.add("closed");
                        jQuery('html,body').removeClass('has-popup-overlay formPopupOpened');
                    },300);
                    document.cookie = "formPopupClosed=true; expires=" + expiryDate.toUTCString() + "; path=/";
                });
            });
        }

        // Mouse farenin pencerenin dışına hareket ettiğinde
        document.addEventListener('mouseout', function(event) {
            // Mouse'un pencerenin dışına çıkıp çıkmadığını kontrol et
            if (!event.relatedTarget) {
                // Mouse pencerenin dışına çıktığında popup'ı göster
                if (document.cookie.indexOf("sitecloseClosed=true") === -1) {
                    jQuery('html,body').addClass('has-popup-overlay sitecloseOpened');
                    jQuery('#siteclosePopup,#sitecloseInner').addClass('active');
                }
            }
        });


        // header promotion bar
        var promotionClose = document.getElementById("promotionClose");
        if (promotionClose) {
            promotionClose.addEventListener("click", function() {
                document.getElementById("promotionBar").classList.add("closed");
                document.cookie = "promotionClosed=true; expires=" + expiryDate.toUTCString() + "; path=/";
            });
        }

        // accept Cookies popup
        var gdprPopup = document.getElementById("gdprPopup");
        if (gdprPopup) {

            var acceptCookies = document.getElementById("acceptCookies");

            acceptCookies.addEventListener("click", function() {
                gdprPopup.classList.remove("active");
                setTimeout( function(){
                    gdprPopup.classList.add("closed");
                },300);
                expiryDate.setDate(expiryDate.getDate() + 364);
                document.cookie = "gdprClosed=true; expires=" + expiryDate.toUTCString() + "; path=/";
            });
        }
    }

    initCookies();


    var doc  = jQuery(document),
        win  = jQuery(window),
        body = jQuery('body'),
        winw = jQuery(window).outerWidth();

    function bodyResize(winw) {
        if ( winw <= 1024 ) {
            body.removeClass('nt-desktop').addClass('nt-mobile');
        } else {
            body.removeClass('nt-mobile').addClass('nt-desktop');
        }
    }

    function slidingMenu() {

        $('.menu-sliding .submenu').each(function () {
            var $this       = $(this);
            var menuWrapper = $this.parents('.menu-sliding');
            var parent      = $this.parent();
            var parentId    = parent.hasClass('mega-container') ? parent.parent().attr('data-id') : parent.attr('data-id');
            var parentTitle = parent.hasClass('mega-container') ? parent.parent().find('>a').html() : parent.find('>a').html();

            $('<li class="back-title" data-id="'+parentId+'">'+parentTitle+'</li>').prependTo($this);
            $this.attr('data-id',parentId).appendTo(menuWrapper);
            menuWrapper.find('.mega-container').addClass('electron-hidden');
        });

        $('.menu-sliding .has-dropdown>a>.dropdown-btn').each(function () {
            var $this    = $(this);
            var parentLi = $this.parent().parent();

            $this.appendTo(parentLi);
        });

        $('.menu-sliding .has-dropdown>a,.menu-sliding .has-dropdown>.dropdown-btn').on('click',function (e) {
            e.preventDefault();
            var $this       = $(this);
            var menuWrapper = $this.parents('.menu-sliding');
            var parentId    = $this.parent().attr('data-id');
            var height      = menuWrapper.find('.submenu[data-id="'+parentId+'"]').height();

            menuWrapper.find('.submenu[data-id="'+parentId+'"]').addClass('active');
            menuWrapper.css('height',height);

            $this.parent().parent().addClass('animate');
        });

        $('.menu-sliding .back-title').on('click',function () {
            var $this       = $(this);
            var menuWrapper = $this.parents('.menu-sliding');
            var parentId    = $this.attr('data-id');
            var height      = menuWrapper.find('li[data-id="'+parentId+'"]').parent().height();

            menuWrapper.find('li[data-id="'+parentId+'"]').parent().removeClass('animate');
            $this.parent().removeClass('active');
            menuWrapper.css('height',height);
        });

        $('.menu-sliding .nav,.menu-sliding .submenu').each(function () {
            var height = $(this).height();
            $(this).css('height',height);
            $(this).find('.mega-container').remove();
        });
    }

    $(document.body).on('click','.type-dropdown>.nav>li:not(.lang-item):not(.wpml-ls-menu-item)>a',function(e){
        //e.preventDefault();
        var parent = $(this).parent();
        if ( parent.hasClass('open') ){
            parent.removeClass('open');
        } else {
            $(this).parents('.electron-header').find('.open').removeClass('open');
            $(this).parents('.electron-header').find('.active').removeClass('active');
            parent.addClass('open');
        }
    });

    $(document.body).on('click','.top-action-btn.has-minicart>svg,.has-panel.account-action>a>svg',function(e){
        //e.preventDefault();
        var $this  = $(this).parents('.top-action-btn');
        var header = $this.parents('.electron-header')
        if ( $(window).width() < 1024 ){
            if ( $this.hasClass('active') ){
                $this.removeClass('active').addClass('inactive');
            } else {
                header.find('.active').removeClass('active');
                header.find('.open').removeClass('open');
                $this.addClass('active').removeClass('inactive');
            }
        }
    });

    // Close when clicking outside
    $(document).on('click.nicee_select', function(event) {
      if ($(event.target).closest('.top-action-btn.active').length === 0) {
        $('.top-action-btn.active').removeClass('active').addClass('inactive');
      }
      if ($(event.target).closest('.header-minimenu').length === 0) {
        $('.electron-header .header-minimenu').find('.open').removeClass('open');
      }
    });

    $(document.body).on('click','.electron-mobile-menu .dropdown-btn',function(e){
        e.preventDefault();
        var parent = $(this).parent().parent();
        if ( parent.hasClass('open') ){
            parent.removeClass('open').find('>.submenu,>.mega-container>.submenu,>.mega-container.has-el-template,>.header-cat-template').slideUp('fast');
        } else {
            parent.addClass('open').find('>.submenu,>.mega-container>.submenu,>.mega-container.has-el-template,>.header-cat-template').slideDown('fast');
        }
    });

    $(document.body).on('click','.mobile-menu-tab',function(e){
        e.preventDefault();

        var target = $(this).attr('data-target');

        $(this).addClass('active').siblings().removeClass('active');
        $('.'+target).siblings().removeClass('menu-active');
        $('.'+target).addClass('menu-active');
    });

    $(document.body).on('click','.search-link.popup',function(e){
        e.preventDefault();
        $('html,body').addClass('has-overlay');
        $('.electron-popup-search').addClass('active');
    });

    $('.header-mainmenu>ul>li.menu-item--has-child').hover(
        function(){
            $(this).addClass('hover');
        },
        function(){
            $(this).removeClass('hover');
        }
    );

    $('.electron-btn').hover(function(){
        $(this).addClass('hover');
        },
        function(){
            $(this).removeClass('hover');
        }
    );


    $('.panel-header-wishlist,.panel-header-compare').on('click',function(){
        //$('.electron-side-panel').removeClass('active');
        //$('html,body').removeClass('has-overlay');
    });



    /*=============================================
    Menu sticky & Scroll to top
    =============================================*/
    function scrollToTopBtnClick() {
        if ( electron_vars.backtotop == 'yes' ) {
            $('<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="nt-icon-up-chevron"></i></a>').appendTo('body');
            $( ".scroll-to-target" ).on("click", function () {
                var target = $(this).attr("data-target");
                // animate
                $("html, body").animate({scrollTop: $(target).offset().top},1000);
                return false;
            });
        }
    }


    /*=============================================
    Menu sticky & Scroll to top
    =============================================*/
    function scrollToTopBtnHide() {
        var offset = 100;
        if ( $(".scroll-to-target").length ) {
            if ( $(window).scrollTop() > offset ) {
                $(".scroll-to-top").fadeIn(500);
            } else if ( $(".scroll-to-top").scrollTop() <= offset ) {
                $(".scroll-to-top").fadeOut(500);
            }
        }
    }

    /*=============================================
    Data Background
    =============================================*/
    $("[data-background]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-background") + ")")
    });

    document.addEventListener("DOMContentLoaded", function () {
        if ( $(".electron-swiper-slider").length ) {
            $('.electron-swiper-slider').each(function () {
            	var container  = $(this);
                const options  = $(this).data('swiper-options');
                const mySlider = new NTSwiper(this, options );
                mySlider.on('transitionStart', function () {
                    var animIn = $(container).find('.swiper-slide').data('anim-in');
                    var active = $(container).find('.swiper-slide-active');
                    var inactive = $(container).find('.swiper-slide:not(.swiper-slide-active)');

                    if( typeof animIn != 'undefined' ) {
                        inactive.find('.has-animation').each(function(e){
                            $(this).removeClass('animated '+animIn);
                        });
                        active.find('.has-animation').each(function(e){
                            $(this).addClass('animated '+animIn);
                        });
                    }
                });
                mySlider.on('resize', function (swiper) {
                    //swiper.updateAutoHeight(100);
                    //mySlider.reInit();
                    //swiper.updateSize();
                });
            });
        }
    });
    /* electronSwiperSlider */
    function electronSwiperSlider() {
        if ( $(".electron-swiper-slider").length ) {
            $('.electron-swiper-slider').each(function () {
            	var container  = $(this);
                const options  = $(this).data('swiper-options');
                const mySlider = new NTSwiper(this, options );
                mySlider.on('transitionEnd', function () {
                    var animIn = $(container).find('.swiper-slide').data('anim-in');
                    var active = $(container).find('.swiper-slide-active');
                    var inactive = $(container).find('.swiper-slide:not(.swiper-slide-active)');

                    if( typeof animIn != 'undefined' ) {
                        inactive.find('.has-animation').each(function(e){
                            $(this).removeClass('animated '+animIn);
                        });
                        active.find('.has-animation').each(function(e){
                            $(this).addClass('animated '+animIn);
                        });
                    }
                });
            });
        }
    }

    // agrikonVegasSlider Preview function
    function electronVegasSlider() {

        $(".home-slider-vegas-wrapper").each(function (i, el) {
            var myEl       = jQuery(el),
                myVegasId  = myEl.find('.nt-home-slider-vegas').attr('id'),
                myVegas    = $( '#' + myVegasId ),
                myPrev     = myEl.find('.vegas-control-prev'),
                myNext     = myEl.find('.vegas-control-next'),
                mySettings = myEl.find('.nt-home-slider-vegas').data('slider-settings'),
                myContent  = myEl.find('.nt-vegas-slide-content'),
                myCounter  = myEl.find('.nt-vegas-slide-counter'),
                myTitle    = myEl.find('.slider_title'),
                myDesc     = myEl.find('.slider_desc'),
                myBtn      = myEl.find('.btn'),
                myCounter  = myEl.find('.nt-vegas-slide-counter');

            myEl.parents('.elementor-widget-agrikon-vegas-slider').removeClass('elementor-invisible');

            if( mySettings.slides.length ) {
                var slides = mySettings.slides,
                    anim   = mySettings.animation ? mySettings.animation : 'kenburns',
                    trans  = mySettings.transition ? mySettings.transition : 'slideLeft',
                    delay  = mySettings.delay ? mySettings.delay : 7000,
                    dur    = mySettings.duration ? mySettings.duration : 2000,
                    autoply= mySettings.autoplay,
                    shuf   = 'yes' == mySettings.shuffle ? true : false,
                    timer  = 'yes' == mySettings.timer ? true : false,
                    over   = 'none' != mySettings.overlay ? true : false;

                myVegas.vegas({
                    autoplay: autoply,
                    delay: delay,
                    timer: timer,
                    shuffle: shuf,
                    animation: anim,
                    transition: trans,
                    transitionDuration: dur,
                    overlay: over,
                    slides: mySettings.slides,
                    init: function (globalSettings) {
                        myContent.eq(0).addClass('active');
                        myTitle.eq(0).addClass('fadeInLeft');
                        myDesc.eq(0).addClass('fadeInLeft');
                        myBtn.eq(0).addClass('fadeInLeft');
                        var total = myContent.size();
                        myCounter.find('.total').html(total);
                    },
                    walk: function (index, slideSettings) {
                        myContent.removeClass('active').eq(index).addClass('active');
                        myTitle.removeClass('fadeInLeft').addClass('fadeOutLeft').eq(index).addClass('fadeInLeft').removeClass('fadeOutLeft');
                        myDesc.removeClass('fadeInLeft').addClass('fadeOutLeft').eq(index).addClass('fadeInLeft').removeClass('fadeOutLeft');
                        myBtn.removeClass('fadeInLeft').addClass('fadeOutLeft').eq(index).addClass('fadeInLeft').removeClass('fadeOutLeft');
                        var current = index +1;
                        myCounter.find('.current').html(current);
                    },
                    end: function (index, slideSettings) {
                    }
                });

                myPrev.on('click', function () {
                    myVegas.vegas('previous');
                });

                myNext.on('click', function () {
                    myVegas.vegas('next');
                });
            }
        });
        // add video support on mobile device for vegas slider
        if( $(".home-slider-vegas-wrapper").length ) {
            $.vegas.isVideoCompatible = function () {
                return true;
            }
        }
    }

    // electronJarallax
    function electronJarallax() {
        var myParallaxs = $('.electron-parallax');
        myParallaxs.each(function (i, el) {

            var myParallax = $(el),
                myData     = myParallax.data('electronParallax');

            if (!myData) {
                return true; // next iteration
            }

             myParallax.jarallax({
                type            : myData.type,
                speed           : myData.speed,
                imgSize         : myData.imgsize,
                imgSrc          : myData.imgsrc,
                disableParallax : myData.mobile ? /iPad|iPhone|iPod|Android/ : null,
                keepImg         : false,
            });
        });
    }


    // electronCf7Form
    function electronCf7Form() {
        $('.electron-cf7-form-wrapper.form_front').each( function(){
            $(this).find('form>*').each( function(index,el){
                $(this).addClass('child-'+index);
            });
        });
    }

    function electronLightbox() {
        var myLightboxes = $('[data-electron-lightbox]');
        if (myLightboxes.length) {
            myLightboxes.each(function(i, el) {
                var myLightbox = $(el);
                var myData = myLightbox.data('electronLightbox');
                var myOptions = {};
                if (!myData || !myData.type) {
                    return true; // next iteration
                }
                if (myData.type === 'gallery') {
                    if (!myData.selector) {
                        return true; // next iteration
                    }
                    myOptions = {
                        delegate: myData.selector,
                        type: 'image',
                        gallery: {
                            enabled: true
                        }
                    };
                }
                if (myData.type === 'image') {
                    myOptions = {
                        type: 'image'
                    };
                }
                if (myData.type === 'iframe') {
                    myOptions = {
                        type: 'iframe'
                    };
                }
                if (myData.type === 'inline') {
                    myOptions = {
                        type: 'inline',
                    };
                }
                if (myData.type === 'modal') {
                    myOptions = {
                        type: 'inline',
                        modal: false
                    };
                }
                if (myData.type === 'ajax') {
                    myOptions = {
                        type: 'ajax',
                        overflowY: 'scroll'
                    };
                }
                myLightbox.magnificPopup(myOptions);
            });
        }
    }

    // popupGdpr
    function popupGdpr() {
        if ( !$('body').hasClass('gdpr-popup-visible') ) {
            return;
        }

        var body        = $('body'),
            popup       = $('.site-gdpr'),
            popupClose  = $('.site-gdpr .gdpr-button a'),
            expiresDate = popup.data('expires');

        if ( !( Cookies.get( 'gdpr-popup-visible' ) ) ) {
            setTimeout(function(){
                popup.addClass( 'active' );
            },1000);
        }

        popupClose.on( 'click', function(e) {
            e.preventDefault();
            Cookies.set( 'gdpr-popup-visible', 'disable', { expires: expiresDate, path: '/' });
            popup.removeClass( 'active' );
            $.cookie("ninetheme_gdpr", 'accepted');
        });
    }

    // product list type masonry for mobile
    function masonryInit(winw) {
        var masonry = $('.electron-products.electron-product-list');
        if ( masonry.length && winw <= 1200 ) {
            //set the container that Masonry will be inside of in a var
            var container = document.querySelector('.electron-products.electron-product-list');
            //create empty var msnry
            var msnry;
            // initialize Masonry after all images have loaded
            imagesLoaded( container, function() {
               msnry = new Masonry( container, {
                   itemSelector: '.electron-product-list>div.product'
               });
            });
        }
    }


    function electronGallery() {
        if ( $('.gallery_front').length > 0 ){
            $('.gallery_front').each( function(){
                const $this     = $(this);
                const gallery   = $this.find('.electron-wc-gallery .row');
                const filter    = $this.find('.gallery-menu');
                const filterbtn = $this.find('.gallery-menu span');
                gallery.imagesLoaded(function () {
                    // init Isotope
                    var $grid = gallery.isotope({
                        itemSelector    : '.grid-item',
                        percentPosition : true,
                        masonry         : {
                            columnWidth : '.grid-sizer'
                        }
                    });
                    // filter items on button click
                    filter.on('click', 'span', function () {
                        var filterValue = $(this).attr('data-filter');
                        $grid.isotope({ filter: filterValue });
                    });
                });
                //for menu active class
                filterbtn.on('click', function (event) {
                    $(this).siblings('.active').removeClass('active');
                    $(this).addClass('active');
                    event.preventDefault();
                });
            });
        }
    }

    // sidebar-widget-toggle
    $( document.body ).on('click', '.nt-sidebar-widget-toggle', function() {
        var $this = $(this);
        $this.toggleClass('active');
        $this.parents('.nt-sidebar-inner-widget').toggleClass('electron-widget-show electron-widget-hide');
        $this.parent().next().slideToggle('fast');

        if ( $('.nt-sidebar-inner-wrapper .electron-widget-show').length ) {
            $this.parents('.nt-sidebar-inner-wrapper').removeClass('all-closed');
        } else {
            $this.parents('.nt-sidebar-inner-wrapper').addClass('all-closed');
        }
    });


    function bannerBgVideo(){

        var iframeWrapper      = $('.electron-loop-product-iframe-wrapper'),
            iframeWrapper2     = $('.electron-woo-banner-iframe-wrapper'),
            videoid            = iframeWrapper2.data('electron-bg-video'),
            aspectRatioSetting = iframeWrapper2.find('iframe').data('bg-aspect-ratio');

        if ( iframeWrapper2.hasClass('electron-video-calculate') ) {
            var containerWidth   = iframeWrapper2.outerWidth(),
                containerHeight  = iframeWrapper2.outerHeight(),
                aspectRatioArray = aspectRatioSetting.split(':'),
                aspectRatio      = aspectRatioArray[0] / aspectRatioArray[1],
                ratioWidth       = containerWidth / aspectRatio,
                ratioHeight      = containerHeight * aspectRatio,
                isWidthFixed     = containerWidth / containerHeight > aspectRatio,
                size             = {
                    w: isWidthFixed ? containerWidth : ratioHeight,
                    h: isWidthFixed ? ratioWidth : containerHeight
                };

            iframeWrapper2.find('iframe').css({
                width: size.w + 100,
                height: size.h + 100
            });
        }

        if ( winw <= 1024 && ( iframeWrapper.length || iframeWrapper2.length ) ) {
            var iframe = iframeWrapper.find('iframe');
            if ( iframeWrapper.length ) {
                iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
            }
            if ( iframeWrapper2.hasClass('electron-video-youtube') ) {
                iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
            }
            if ( iframeWrapper2.hasClass('electron-video-vimeo') ) {
                iframe[0].contentWindow.postMessage('{"method":"play"}', '*');
            }
            if ( iframeWrapper.hasClass('electron-video-local') ) {
                iframe.get(0).play();
            }
        }
    }

    function ninethemeCountDown() {
        $('[data-countdown]').each(function () {
            var self      = $(this),
                data      = self.data('countdown'),
                countDate = data.date,
                expired   = data.expired,
                update    = data.update;

            if (!countDate) {
               return;
            }

            let countDownDate = new Date( countDate ).getTime();

            const d = self.find( '.days' );
            const h = self.find( '.hours' );
            const m = self.find( '.minutes' );
            const s = self.find( '.second' );

            var x = setInterval(function() {

                var now = new Date().getTime();

                var distance = countDownDate - now;

                var days    = (Math.floor(distance / (1000 * 60 * 60 * 24)));
                var hours   = ('0' + Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).slice(-2);
                var minutes = ('0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).slice(-2);
                var seconds = ('0' + Math.floor((distance % (1000 * 60)) / 1000)).slice(-2);

                d.text( days<10 ? '0'+days : days );
                h.text( hours );
                m.text( minutes );
                s.text( seconds );

                if ( distance < 0 ) {
                    clearInterval(x);
                    self.parents('.electron-summary-item').addClass('expired');
                    self.html('<div class="expired">' + expired + '</div>');
                }
            }, 1000);
        });
    }

    // masonry reinit
    $(document.body).on('electron_masonry_init', function() {
        masonryInit(winw);
    });

    function isLocalStorageSupported() {
        try {
            const testKey = 'test';
            localStorage.setItem(testKey, testKey);
            localStorage.removeItem(testKey);
            return true;
        } catch (e) {
            return false;
        }
    }


    function loadFooterTemplate() {
        var saveFooter     = electron_vars.save_footer;
        var isLocalStorage = isLocalStorageSupported();

        if ( isLocalStorage && saveFooter == "no" ) {
            localStorage.removeItem('electronFooterTemplate');
        }

        if ( isLocalStorage && saveFooter == "yes" ) {
            var localStorageKey = 'electronFooterTemplate';
            var storedData      = false;
            var storedContent   = localStorage.getItem(localStorageKey);

            try {
                storedData = JSON.parse(storedContent);
            }
            catch (e) {
                console.log('cant parse Json', e);
            }
        }

        if ( isLocalStorage && storedData && saveFooter == "yes" ) {
            $('.electron-elementor-footer').replaceWith(storedData);
        } else {
            $.ajax({
                url: electron_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_footer_template',
                    footerId : electron_vars.footer_temp
                },
                success: function(response) {
                    $('.electron-elementor-footer').replaceWith(response);
                    if ( isLocalStorage && saveFooter == "yes" ) {
                        localStorage.setItem(localStorageKey, JSON.stringify(response));
                    }
                }
            });
        }
    }

    function loadMegamenuContent() {
        var saveMegamenu   = electron_vars.save_megamenu;
        var isLocalStorage = isLocalStorageSupported();

        if ( isLocalStorage && saveMegamenu == "no" ) {
            localStorage.removeItem('megaMenuContent');
        }

        if ( isLocalStorage && saveMegamenu == "yes" ) {
            var localStorageKey = 'megaMenuContent';
            var storedContent   = localStorage.getItem('megaMenuContent');
            var ids             = [];
            var storedData      = false;

            $('.menu-load-ajax:not(.menu-loaded)').each(function() {
                ids.push($(this).data('id'));
            });

            try {
                storedData = JSON.parse(storedContent);
            }
            catch (e) {
                console.log('cant parse Json', e);
            }
        }

        if ( isLocalStorage && storedData && saveMegamenu == "yes" ) {

            $('.menu-load-ajax:not(.menu-loaded)').each(function() {

                var id       = $(this).data('id');
                var content  = storedData.data[id].shortcode;
                var content2 = storedData.data[id].shortcode2;

                if ( content ) {
                    $('.menu-load-ajax:not(.menu-loaded)[data-id="'+id+'"]').html(content).addClass('menu-loaded');
                }

                if ( content2 ) {
                    $('.sliding-menu-load-ajax:not(.menu-loaded)[data-id="'+id+'"]').html(content2).addClass('menu-loaded');
                } else {
                    $('.sliding-menu-load-ajax:not(.menu-loaded)[data-id="'+id+'"]').html(content).addClass('menu-loaded');
                }
            });

        } else {

            $.ajax({
                url      : electron_vars.ajax_url,
                type     : 'POST',
                dataType : 'json',
                data     : {
                action  : 'get_mega_menu_content',
                ids     : ids
            },
            success  : function(response) {

            $('.menu-load-ajax:not(.menu-loaded)').each(function() {
                var id       = $(this).data('id');
                var content  = response.data[id].shortcode;
                var content2 = response.data[id].shortcode2;

                if ( content ) {
                    $('.menu-load-ajax:not(.menu-loaded)[data-id="'+id+'"]').html(content).addClass('menu-loaded');
                }

                if ( content2 ) {
                    $('.sliding-menu-load-ajax:not(.menu-loaded)[data-id="'+id+'"]').html(content2).addClass('menu-loaded');
                } else {
                    $('.sliding-menu-load-ajax:not(.menu-loaded)[data-id="'+id+'"]').html(content).addClass('menu-loaded');
                }
                });

                if ( isLocalStorage && saveMegamenu == "yes" ) {
                    localStorage.setItem('megaMenuContent', JSON.stringify(response));
                }
            },
            error: function() {
                console.log('loading html dropdowns ajax error');
            }
            });
        }
    }


    doc.ready( function() {
        if ( electron_vars.megamenu_ajax == "yes" ) {
            loadMegamenuContent();
        }
        if ( electron_vars.footer_ajax == "yes" ) {
            loadFooterTemplate();
        }

        winw = $(window).outerWidth();

        var menuContent = $('.electron-header-part:not(.sticky) .header-mainmenu .nav').clone();
        var searchForm  = $('.electron-header .electron-ajax-product-search').clone();
        var miniCart    = $('.electron-header .main-minicart .minicart-panel').clone();
        var miniMenu    = $('.electron-header .header-minimenu.type-dropdown .nav').clone();

        $('.electron-header-sticky .header-mainmenu,.mobile-menu:not(.custom-menu)').html(menuContent).addClass('cloned');
        $(miniMenu).appendTo('.mobile-menu:not(.custom-menu)').addClass('cloned');
        $('.mobile-menu:not(.custom-menu) .nav.cloned').before('<div class="menu-divider"></div>');
        $('.electron-header-sticky .has-minicart').append(miniCart);
        $('.search-form-found').html(searchForm);
        $('.search-form-found .electron-ajax-product-search:nth-child(2)').remove();


        // popup search clone and
        var catslist = $('.electron-header .electron-category-menu.type-vertical').clone();
        catslist.find('.menu-title').remove();
        catslist.find('.dropdown-btn').remove();
        catslist.find('.cat-item>.submenu').remove();
        catslist.find('.electron-vertical-catmenu-primary').addClass('electron-scrollbar');
        catslist.find('.cat-item').append('<span class="nt-icon-up-chevron dropdown-right"></span>');

        $('.cats--found').html(catslist);

        $('.electron-popup-search .cat-item').on('click', function(e) {
            if( winw > 1024 ) {
                //$(this).parents('.electron-popup-search').find('.panel-close').trigger('click');
            }
        });

        if ( $('body').hasClass('theme-basic') ) {
            var headerH = $('.header-def').height();
            var heroH   = $('.electron-page-hero').height();
            var footerH = $('.electron-default-copyright').height();
            var totalH  = headerH+heroH+footerH;
            $('.blog-area').css('min-height','calc(100vh - '+totalH+'px)');
        }

        slidingMenu();
        //electronSwiperSlider();
        electronVegasSlider();
        scrollToTopBtnClick();
        popupGdpr();
        electronCf7Form();
        electronJarallax();
        bannerBgVideo();
        electronLightbox();
        ninethemeCountDown();
        // WooCommerce
        electronGallery();
        masonryInit(winw);

        $('.electron-header-bottom-bar .electron-shop-filter-top-area').removeClass('electron-shop-filter-top-area');

        // masonry
        var masonry = $('.electron-masonry-container');
        if ( masonry.length ) {
            //set the container that Masonry will be inside of in a var
            var container = document.querySelector('.electron-masonry-container');
            //create empty var msnry
            var msnry;
            // initialize Masonry after all images have loaded
            imagesLoaded( container, function() {
               msnry = new Masonry( container, {
                   itemSelector: '.electron-masonry-container>div'
               });
            });
        }

        var bgImage = $('.electron-shop-hero[data-bg]').data('bg');
        if ( bgImage ) {
        	$('.electron-shop-hero[data-bg]').css('background-image','url('+bgImage+')');
        }

        var block_check = $('.nt-single-has-block');
        if ( block_check.length ) {
            $( ".nt-electron-content ul" ).addClass( "nt-electron-content-list" );
            $( ".nt-electron-content ol" ).addClass( "nt-electron-content-number-list" );
        }

        $( ".electron-post-content-wrapper>*:last-child" ).addClass( "electron-last-child" );

        $( ".electron-category-menu .current-cat" ).parent().parent().addClass( "current-cat" );

        // add class for bootstrap table
        $( ".nt-electron-content table, #wp-calendar" ).addClass( "table table-striped" );
        $( ".woocommerce-order-received .nt-electron-content table" ).removeClass( "table table-striped" );

        // CF7 remove error message
        $('.wpcf7-response-output').ajaxComplete(function(){

            window.setTimeout(function(){
                $('.wpcf7-response-output').addClass('display-none');
            }, 4000);

            window.setTimeout(function(){
                $('.wpcf7-response-output').removeClass('wpcf7-validation-errors display-none');
                $('.wpcf7-response-output').removeAttr('style');
            }, 4500);
        });

        if ( typeof elementorFrontend != 'undefined' ) {
            var deviceMode = elementorFrontend.getCurrentDeviceMode();

            $('[data-bg]').each( function(index, el) {
                var $this = $(el);
                var elBg  = $this.data('bg');

                if ( typeof elBg != 'undefined' ) {
                    var desktop = elBg;

                    var widescreen   = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : desktop;
                    var laptop       = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : desktop;
                    var tablet_extra = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : laptop;
                    var tablet       = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : tablet_extra;
                    var mobile_extra = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : tablet;
                    var mobile       = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : mobile_extra;
                    var bgUrl        = mobile;

                    if ( bgUrl ) {
                        $this.css('background-image', 'url(' + bgUrl + ')' );
                    }
                }
            });
        }

        $(document.body).on('click','.electron-category-menu.always-open',function(e){
            //e.preventDefault();

            var $this = $(this);
			if ($this.hasClass('show')) {
				$this.removeClass('show');
			} else {
				$this.addClass('show');
			}
        });

        $(document.body).on('click','.panel-open',function(e){
            e.preventDefault();

            var target = $(this).attr('data-target');

            $('.page-overlay').attr('data-target',target);
            $('html,body').addClass('has-overlay');
            $(target).addClass('active');
        });

        $(document.body).on('click','.panel-popup-open',function(e){
            e.preventDefault();
            var target = $(this).attr('data-target');
            $('html,body').addClass('has-popup-overlay');
            $(target).addClass('active');
        });

        $(document.body).on('click','.panel-close',function(e){
            e.preventDefault();

            var target = $(this).attr('data-target');

            $(target).removeClass('active');
            $('html,body').removeClass('has-overlay has-popup-overlay');
        });

        $(document.body).on('click','.page-overlay,.popup-overlay',function(e){
            e.preventDefault();
            var target = $(this).attr('data-target');

            $(target).removeClass('active');
            $('html,body').removeClass('has-overlay has-popup-overlay quick-open');
        });

        $('.layout-slider .taxonomy-item').hover(
            function() {
                var $this       = $(this);
                var id          = $this.data('id');
                var wrapper     = $this.parents('.layout-slider');
                var desc        = wrapper.find('.taxonomy-details[data-id="'+id+'"]');
                var dwidth      = desc.width();
                var dheight     = desc.height();
                var width       = $this.width();
                var height      = $this.height();
                var pos         = $this.offset();
                var posTop      = pos.top;
                var posLeft     = pos.left;
                desc.addClass('active');
                desc.css({
                    "top"  : (posTop+height) -5,
                    "left" : (posLeft+width) - (dwidth+35) //(posLeft + width) - (width / 2)
                });
            },
            function() {
                var $this       = $(this);
                var id          = $this.data('id');
                var wrapper     = $this.parents('.layout-slider');
                var desc        = wrapper.find('.taxonomy-details[data-id="'+id+'"]');
                desc.removeClass('active');
            }
        );
    	var headerMh = $('.electron-header-mobile').outerHeight();
		$('.electron-header-mobile-fixed').css("min-height",headerMh);


        $('.electron-category-menu.fixed-submenu').hover(
            function() {
                var $this   = $(this);
                var submenu = $this.find('.electron-vertical-catmenu-primary');
                var height  = $this.height();
                var pos     = $this.offset();
                var posTop  = pos.top;
                var posLeft = pos.left;
                submenu.css({
                    "top"  : (posTop+height),
                    "left" : (posLeft)
                });
            }
        );

        $('.electron-category-menu.fixed-submenu .menu-item-has-children').hover(
            function() {
                var $this   = $(this);
                var submenu = $this.find('.submenu');
                var height  = $this.height();
                var width   = $this.width();
                var pos     = $this.offset();
                var posTop  = pos.top;
                var posLeft = pos.left;
                submenu.css({
                    "top"  : (posTop),
                    "left" : (posLeft+width)+15
                });
            }
        );

        $('.electron-category-menu.fixed-submenu .submenu').hover(
            function() {
                $(this).parent().addClass('active');
                $(this).parents('.fixed-submenu').addClass('active');
                $(this).parents('.submenu').addClass('active');
            },
            function() {
                $(this).parent().removeClass('active');
                $(this).parents('.fixed-submenu').removeClass('active');
                $(this).parents('.submenu').removeClass('active');
            }
        );
    });


    // === window When resize === //
    win.resize( function() {
        winw = $(window).outerWidth();
        bodyResize(winw);
        masonryInit(winw);

        body.addClass("electron-on-resize");

        body.attr("data-electron-resize", winw);

        if ( typeof elementorFrontend != 'undefined' ) {
            var deviceMode = elementorFrontend.getCurrentDeviceMode();

            $('[data-bg-responsive]').each( function(index, el) {
                var $this = $(el);
                var elBg  = $this.data('bg-responsive');

                if ( typeof elBg != 'undefined' ) {
                    var desktop = $(el).data('bg');

                    var widescreen   = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : desktop;
                    var laptop       = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : desktop;
                    var tablet_extra = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : laptop;
                    var tablet       = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : tablet_extra;
                    var mobile_extra = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : tablet;
                    var mobile       = typeof elBg[deviceMode] != 'undefined' ? elBg[deviceMode] : mobile_extra;
                    var bgUrl        = mobile;

                    if ( bgUrl ) {
                        $this.css('background-image', 'url(' + bgUrl + ')' );
                    }
                }
            });
        }
    });

    var headerH = $('.electron-header').height(),
        headerO = $('.electron-header').offset(),
        headerP = typeof headerO != 'undefined' ? headerO.top : 0,
        offSetH = headerP + headerH;

    var headerMh = $('.electron-header-mobile').height(),
        headerMo = $('.electron-header-mobile').offset(),
        headerMp = typeof headerMo != 'undefined' ? headerMo.top : 0,
        offSetMh = headerMp + headerMh;

    // === window When scroll === //

    win.on("scroll", function () {
        var bodyScroll = win.scrollTop();

        if ( bodyScroll > ( offSetH + 10 ) ) {
            $('.electron-header-sticky').addClass("sticky-start");
        } else {
            $('.electron-header-sticky').removeClass("sticky-start");
        }

        if ( bodyScroll > ( offSetMh + 10 ) ) {
            $('.electron-header-mobile:not(.sticky-none),.electron-header-mobile-fixed').addClass("sticky-ready");
        } else {
            $('.electron-header-mobile:not(.sticky-none),.electron-header-mobile-fixed').removeClass("sticky-ready");
        }

        if ( bodyScroll > ( offSetMh + 50 ) ) {
            $('.electron-header-mobile:not(.sticky-none)').addClass("sticky-start");
        } else {
            $('.electron-header-mobile:not(.sticky-none)').removeClass("sticky-start");
        }

        if ( bodyScroll > 0 ) {
            body.addClass("scroll-start");
        } else {
            body.removeClass("scroll-start");
        }

        var filterArea = $('.electron-products-column .electron-before-loop.electron-shop-filter-top-area');

        if ( filterArea.length ) {
            var filterAreaPos = filterArea.offset(),
                topoffset = $('.electron-header-bottom-bar').hasClass('electron-elementor-template') ? 10 : filterAreaPos.top-62;
            if ( bodyScroll > topoffset ) {
                $('.electron-header-bottom-bar').addClass('sticky-filter-active');
            } else {
                $('.electron-header-bottom-bar').removeClass('sticky-filter-active');
            }
        }

        //$('.page-overlay').trigger('click');

        scrollToTopBtnHide();

    });

    // === window When Loading === //
    win.on("load", function () {
        var bodyScroll = win.scrollTop();

        if ( bodyScroll > 10 ) {
            body.addClass("scroll-start");
            $('.has-sticky-header .electron-header-default').addClass("sticky-start");
        } else {
            body.removeClass("scroll-start");
            $('.has-sticky-header .electron-header-default').removeClass("sticky-start");
        }

        if ( $(".preloader").length || $("#nt-preloader").length ) {
            $('.preloader,#nt-preloader').fadeOut(1000);
        }

        body.addClass("page-loaded");

    });

    win.on('orientationchange', function(event) {
        body.addClass("electron-orientation-changed");

        win.height() > win.width() ? body.removeClass("electron-portrait").addClass("electron-landscape") : body.removeClass("electron-landscape").addClass("electron-portrait");

    });
})(window, document, jQuery);
