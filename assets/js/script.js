(function ($) {
	'use strict';

	/* ----- Patch Owl: never loop/clone when not enough slides (prevents .clone crash) ----- */
	if (typeof $.fn.owlCarousel === 'function' && !$.fn.owlCarousel._eggxiPatched) {
		var eggxiOwlOriginal = $.fn.owlCarousel;
		$.fn.owlCarousel = function (options) {
			if (typeof options === 'object' || options === undefined) {
				options = $.extend({}, options || {});
				return this.each(function () {
					var $el = $(this);
					var count = $el.children('.item').length;
					if (!count) {
						count = $el.children().not('script').length;
					}
					if (!count) {
						return;
					}
					var opts = $.extend({}, options);
					var visible = 1;
					if (opts.responsive) {
						var width = window.innerWidth || document.documentElement.clientWidth;
						Object.keys(opts.responsive).sort(function (a, b) {
							return parseInt(a, 10) - parseInt(b, 10);
						}).forEach(function (bp) {
							if (width >= parseInt(bp, 10) && opts.responsive[bp].items) {
								visible = opts.responsive[bp].items;
							}
						});
					} else if (opts.items) {
						visible = opts.items;
					}
					if (count <= visible) {
						opts.loop = false;
						opts.center = false;
						opts.autoplay = false;
						opts.rewind = false;
					}
					eggxiOwlOriginal.call($el, opts);
				});
			}
			return eggxiOwlOriginal.apply(this, arguments);
		};
		$.fn.owlCarousel._eggxiPatched = true;
		$.fn.owlCarousel.Constructor = eggxiOwlOriginal.Constructor;
	}

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

	/* ----- Safe Owl helper: loop needs enough slides or Owl throws clone error ----- */
	function eggxiOwlItemCount($el) {
		return $el.children('.item').length || $el.children().not('.owl-stage-outer, script').length;
	}

	function eggxiCanLoop(count, minItems) {
		minItems = minItems || 2;
		return count >= minItems;
	}

	/* ----- Header text ticker ----- */
	if ($('.ht_text_slider').length && typeof $.fn.owlCarousel === 'function') {
		$('.ht_text_slider').each(function () {
			var $el = $(this);
			var count = eggxiOwlItemCount($el);
			if (!count) {
				return;
			}
			$el.owlCarousel({
				animateIn: 'fadeIn',
				animateOut: 'fadeOut',
				center: true,
				loop: eggxiCanLoop(count, 2),
				margin: 0,
				dots: false,
				nav: false,
				autoplayHoverPause: true,
				autoplay: count > 1,
				autoHeight: true,
				smartSpeed: 2000,
				items: 1
			});
		});
	}

	/* ----- Single post gallery ----- */
	if ($('.img_post_slider').length && typeof $.fn.owlCarousel === 'function') {
		$('.img_post_slider').each(function () {
			var $el = $(this);
			var count = eggxiOwlItemCount($el);
			if (!count) {
				return;
			}
			$el.owlCarousel({
				loop: eggxiCanLoop(count, 2),
				margin: 15,
				dots: count > 1,
				nav: false,
				autoplayHoverPause: true,
				autoplay: count > 1,
				smartSpeed: 1200,
				items: 1
			});
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
				var count = eggxiOwlItemCount($el);
				if (!count) {
					return;
				}
				var wantLoop = $el.data('loop');
				// Desktop shows 2 items — Owl loop/clone needs more slides than visible items.
				var safeLoop = wantLoop && count >= 3;
				try {
					$el.owlCarousel({
						autoplay: !!$el.data('autoplay') && count > 1,
						autoHeight: true,
						autoWidth: $el.data('autoWidth'),
						autoplayHoverPause: $el.data('autoplayHoverPause'),
						center: count > 1 ? $el.data('center') : false,
						loop: safeLoop,
						margin: $el.data('margin') || 0,
						nav: !!$el.data('nav') && count > 1,
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
							992: { items: Math.min(2, count) },
							1200: { items: Math.min(2, count) }
						}
					});
				} catch (err) {
					if (window.console && console.warn) {
						console.warn('Eggxi home1_slider init skipped:', err);
					}
				}
			});
		}

		if ($('.three-grid-slider').length) {
			$('.three-grid-slider').each(function () {
				var $el = $(this);
				var count = eggxiOwlItemCount($el);
				if (!count) {
					return;
				}
				var wantLoop = $el.data('loop');
				var safeLoop = wantLoop && count >= 4;
				try {
					$el.owlCarousel({
						animateIn: $el.data('animateIn'),
						autoplay: !!$el.data('autoplay') && count > 1,
						autoHeight: true,
						autoplayHoverPause: $el.data('autoplayHoverPause'),
						autoWidth: $el.data('autoWidth'),
						center: count > 1 ? $el.data('center') : false,
						items: $el.data('items') || 3,
						loop: safeLoop,
						margin: $el.data('margin') || 0,
						nav: !!$el.data('nav') && count > 1,
						navText: [
							'<i class="flaticon-left"></i>',
							'<i class="flaticon-right"></i>'
						],
						dots: $el.data('dots'),
						rtl: $el.data('rtl'),
						smartSpeed: $el.data('smartSpeed') || 1000,
						responsive: {
							0: { items: 1, center: false },
							600: { items: Math.min(2, count), center: false },
							768: { items: Math.min(2, count) },
							992: { items: Math.min(3, count) },
							1200: { items: Math.min(3, count) }
						}
					});
				} catch (err) {
					if (window.console && console.warn) {
						console.warn('Eggxi three-grid-slider init skipped:', err);
					}
				}
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
