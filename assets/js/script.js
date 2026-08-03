(function ($) {
	'use strict';

	/* ----- Preloader ----- */
	function preloaderLoad() {
		if ($('.preloader').length) {
			$('.preloader').delay(200).fadeOut(300);
		}
		$('.preloader_disabler').on('click', function () {
			$('#preloader').hide();
		});
	}

	/* ----- Sticky navbar ----- */
	function navbarScrollfixed() {
		if ($('.navbar-scrolltofixed').length && typeof $.fn.scrollToFixed === 'function') {
			$('.navbar-scrolltofixed').scrollToFixed();
		}
	}

	/* ----- Mobile nav (mmenu) ----- */
	$(function () {
		if ($('nav#menu').length && typeof $.fn.mmenu === 'function') {
			$('nav#menu').mmenu();
		}
	});

	/* ----- Mobile sidebar panel toggle ----- */
	var sidebar = $('.blog_sidebar_panel');
	$('.blog_sidebar_pp_button').on('click', function () {
		sidebar.toggleClass('open');
	});

	/* ----- Magnific Popup (video / iframe) ----- */
	if (
		($('.popup-img').length > 0 || $('.mfp-iframe').length > 0 || $('.mfp-img-single').length > 0) &&
		typeof $.fn.magnificPopup === 'function'
	) {
		$('.popup-img').magnificPopup({
			type: 'image',
			gallery: { enabled: true }
		});
		$('.mfp-img-single').magnificPopup({
			type: 'image',
			gallery: { enabled: false }
		});
		$('.mfp-iframe').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			preloader: false,
			fixedContentPos: false
		});
		$('.mfp-youtube, .mfp-vimeo, .mfp-gmaps').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false,
			iframe: {
				patterns: {
					youtube: {
						src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0'
					}
				}
			}
		});
		$('.mfp-youtube, .mfp-vimeo').on('click', function () {
			return false;
		});
	}

	/* ----- WOW animations ----- */
	function wowAnimation() {
		if (typeof WOW === 'undefined') {
			return;
		}
		new WOW({
			animateClass: 'animated',
			mobile: true,
			offset: 0
		}).init();
	}

	/* ----- Header text ticker ----- */
	if ($('.ht_text_slider').length && typeof $.fn.owlCarousel === 'function') {
		$('.ht_text_slider').owlCarousel({
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			center: true,
			loop: true,
			margin: 0,
			dots: false,
			nav: false,
			autoplayHoverPause: true,
			autoplay: true,
			autoHeight: true,
			smartSpeed: 2000,
			items: 1
		});
	}

	/* ----- Single post gallery ----- */
	if ($('.img_post_slider').length && typeof $.fn.owlCarousel === 'function') {
		$('.img_post_slider').owlCarousel({
			loop: true,
			margin: 15,
			dots: true,
			nav: false,
			autoplayHoverPause: true,
			autoplay: true,
			smartSpeed: 1200,
			items: 1
		});
	}

	/* ----- Data-attribute Owl carousels used by the theme ----- */
	function initOwlDataSliders() {
		if (typeof $.fn.owlCarousel !== 'function') {
			return;
		}

		if ($('.home1_slider').length) {
			$('.home1_slider').each(function () {
				var $el = $(this);
				$el.owlCarousel({
					autoplay: $el.data('autoplay'),
					autoHeight: true,
					autoWidth: $el.data('autoWidth'),
					autoplayHoverPause: $el.data('autoplayHoverPause'),
					center: $el.data('center'),
					loop: $el.data('loop'),
					margin: $el.data('margin'),
					nav: $el.data('nav'),
					navText: [
						'<i class="flaticon-left"></i>',
						'<i class="flaticon-right"></i>'
					],
					dots: $el.data('dots'),
					rtl: $el.data('rtl'),
					smartSpeed: $el.data('smartSpeed') || $el.data('smartspeed') || 1500,
					responsive: {
						320: { items: 1, center: false },
						768: { items: 1 },
						992: { items: 2 },
						1200: { items: 2 }
					}
				});
			});
		}

		if ($('.three-grid-slider').length) {
			$('.three-grid-slider').each(function () {
				var $el = $(this);
				$el.owlCarousel({
					animateIn: $el.data('animateIn'),
					autoplay: $el.data('autoplay'),
					autoHeight: true,
					autoplayHoverPause: $el.data('autoplayHoverPause'),
					autoWidth: $el.data('autoWidth'),
					center: $el.data('center'),
					items: $el.data('items'),
					loop: $el.data('loop'),
					margin: $el.data('margin'),
					nav: $el.data('nav'),
					navText: [
						'<i class="flaticon-left"></i>',
						'<i class="flaticon-right"></i>'
					],
					dots: $el.data('dots'),
					rtl: $el.data('rtl'),
					smartSpeed: $el.data('smartSpeed') || 1000,
					responsive: {
						0: { items: 1, center: false },
						600: { items: 2, center: false },
						768: { items: 2 },
						992: { items: 3 },
						1200: { items: 3 }
					}
				});
			});
		}
	}

	/* ----- Scroll to top ----- */
	function scrollToTop() {
		$(window).on('scroll', function () {
			if ($(this).scrollTop() > 600) {
				$('.scrollToHome').fadeIn();
			} else {
				$('.scrollToHome').fadeOut();
			}
		});

		$('.scrollToHome').on('click', function () {
			$('html, body').animate({ scrollTop: 0 }, 800);
			return false;
		});
	}

	$(function () {
		navbarScrollfixed();
		scrollToTop();
		wowAnimation();
		initOwlDataSliders();
	});

	$(window).on('load', function () {
		preloaderLoad();
	});
})(window.jQuery);
