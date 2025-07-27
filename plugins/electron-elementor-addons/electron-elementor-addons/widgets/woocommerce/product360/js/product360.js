(function($) {

	$(document).ready(function() {

		$(".electron-product360-btn").appendTo(".flex-viewport");

		$('.electron-product360-btn a').on('click', function(e) {
			e.preventDefault();
			init($('.electron-360-view.electron-product-360'));
		});

		$('.electron-product360-btn a').magnificPopup({
			type: 'inline',
            fixedBgPos: true,
            fixedContentPos: true,
            closeBtnInside: true,
            removalDelay: 0,
            mainClass: 'electron-mfp-slide-bottom',
            tClose: '',
            tLoading: '<span class="loading-wrapper"><span class="ajax-loading"></span></span>',
            closeMarkup: '<div title="%title%" class="mfp-close electron-mfp-close"></div>',
		});


		function init($this) {
			var data = $this.data('args');

			if (!data || $this.hasClass('electron-360-view-inited')) {
				return false;
			}

			$this.ThreeSixty({
				totalFrames : data.frames_count,
				endFrame    : data.frames_count,
				currentFrame: 1,
				imgList     : '.electron-360-view-images',
				progress    : '.electron-spinner',
				imgArray    : data.images,
				height      : data.height,
				width       : data.width,
				responsive  : true,
				navigation  : true,

			});

			$this.addClass('electron-360-view-inited');
		}
	});

})(jQuery);
