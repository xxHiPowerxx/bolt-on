// Write JS here
jQuery(document).ready(function($) {
	var headerHeight,
		fixedHeader = false,
		$body = $('body'),
		$header = $('#masthead').first(),
		transitionStart =
			'webkitTransitionStart otransitionstart oTransitionStart msTransitionStart transitionstart',
		transitionEnd =
			'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';

	function detectMac() {
		if (-1 != navigator.userAgent.indexOf('Mac OS X')) {
			$body.addClass('browser-mac');
			return true;
		}
	}

	function detectIe() {
		if (
			/MSIE 10/i.test(navigator.userAgent) ||
			/MSIE 9/i.test(navigator.userAgent) ||
			/rv:11.0/i.test(navigator.userAgent) ||
			/Edge\/\d./i.test(navigator.userAgent)
		) {
			if (/Edge\/\d./i.test(navigator.userAgent)) {
				$body.addClass('browser-edge');
			} else {
				$body.addClass('browser-ie');
			}
			return true;
		}
	}

	function detectIOS() {
		var userAgent = navigator.userAgent || navigator.vendor || window.opera;
		if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
			$body.addClass('os-ios');
			return 'iOS';
		}
	}

	function detectPlatform() {
		detectMac();
		detectIe();
		detectIOS();
	}

	function collapseOnHover() {
		$('.has-dropdown').each(function() {
			var collapse = $(this).children('.collapse'),
				otherCollapses = $(this).siblings('.has-dropdown').children('.collapse'),
				className1 = 'active',
				className2 = 'header-dropdown-active',
				dropDownHovered = false;
			this.collapseShown = false;
			function showCollapse($elem) {
				otherCollapses.collapse('hide');
				$elem.addClass(className1);
				if (! $header.is('.transitioning') ) {
					collapse.collapse('show').one('shown.bs.collapse', function() {
						$elem.one(transitionEnd, function() {
							$(this)
								.one('mouseenter', function() {
									dropDownHovered = true;
									if ($(this).closest('#masthead').length) {
										$body.addClass(className2);
									}
								})
								.one('mouseleave', function() {
									dropDownHovered = false;
									collapse.collapse('hide');
									if ($(this).closest('#masthead').length) {
										$body.removeClass(className2);
									}
								});
								return $elem[0].collapseShown = true;
						});
					});
				}
			}
			function hideCollapse($elem) {
				$elem.removeClass(className1);
				if (! dropDownHovered) {
					collapse.collapse('hide');
					return $elem[0].collapseShown = false;
				}
			}
			$(this).hover(
				function() {
					showCollapse($(this));
				},
				function() {
					hideCollapse($(this));
				}
			).on('click', function(e){
				if (e.target === this) {
					if ( ! this.collapseShown) {
						showCollapse($(this));
					} else {
						hideCollapse($(this));
					}
				}
			});
		});
	}
	function activateMobileMenu() {
		var breakPoint = $body.attr("data-mobile-nav-breakpoint"),
		windowWidth = window.innerWidth,
		activeClassName = "bolt-on-mobile-menu-active",
		inactiveClassName = "bolt-on-mobile-menu-inactive";

		if (windowWidth < breakPoint) {
			$body.addClass(activeClassName).removeClass(inactiveClassName);
		} else {
			$body.removeClass(activeClassName).addClass(inactiveClassName);
		}
	}
	function sizeHeaderPad() {
		$('.sizeHeaderPad').each(function() {
			fixedHeader = getComputedStyle(this).position === 'fixed';
			if (fixedHeader) {
				var sizeHeaderPadTar = $('.sizeHeaderPadTar');
				headerHeight = headerHeight || this.getBoundingClientRect().height;
				headerPad = headerHeight;
				sizeHeaderPadTar.css('padding-top', headerPad);
			}
		});
	}
	function scrolledPastHeader() {
		$('.scrolledPastHeaderRef').each(function() {
			var thisRect = this.getBoundingClientRect();
			if ($(window).scrollTop() >= thisRect.height + this.offsetTop) {
				$body.addClass('scrolledPastHeader');
			} else {
				$body.removeClass('scrolledPastHeader');
			}
		});
	}
	function getHeaderHeight() {
		$('.getHeaderHeight').each(function() {
			headerHeight = this.getBoundingClientRect().height;
		});
	}
	// utility function that returns mouse Postion.
	function getMousePosition(event) {
		var eventDoc, doc, body;
		event = event || window.event; // IE-ism
		// If pageX/Y aren't available and clientX/Y are,
		// calculate pageX/Y - logic taken from jQuery.
		// (This is to support old IE)
		if (event.pageX == null && event.clientX != null) {
			eventDoc = (event.target && event.target.ownerDocument) || document;
			doc = eventDoc.documentElement;
			body = eventDoc.body;
			event.pageX =
				event.clientX +
				((doc && doc.scrollLeft) || (body && body.scrollLeft) || 0) -
				((doc && doc.clientLeft) || (body && body.clientLeft) || 0);
			event.pageY =
				event.clientY +
				((doc && doc.scrollTop) || (body && body.scrollTop) || 0) -
				((doc && doc.clientTop) || (body && body.clientTop) || 0);
		}
		return event;
	}
	var checkMouseOverTarget = function(event) {
		if ($($(event.target).closest($header)).length) {
			$header[0].mouseIsOver = true;
		} else {
			$header[0].mouseIsOver = false;
		}
		return $header[0].mouseIsOver;
	}
	function bindCheckMouseOverTarget() {
		document.addEventListener('mousemove', checkMouseOverTarget);
		$header.on('focusin', checkMouseOverTarget);
	}
	function handleMouseMove(event) {
		// var headerHeightFromTop = headerHeight + $header[0].offsetTop;
		var headerHeightFromTop = window.innerHeight * .10;
		event = getMousePosition(event),
		isMouseOverTarget = checkMouseOverTarget(event);
		// Get Mouse Y Position relative to window and compare to Header Height.
		if (
			fixedHeader && event.clientY <= headerHeightFromTop ||
			isMouseOverTarget === true
		) {
			$body.addClass('mouseInHeaderArea');
		} else {
			if (isMouseOverTarget !== true) {
				$body.removeClass('mouseInHeaderArea');
			}
		}
		// Use event.pageX / event.pageY here
	}
	function mouseInHeaderArea() {
		if (fixedHeader) {
			document.addEventListener('mousemove', handleMouseMove);
			$header.on('focusin', handleMouseMove);
			// document.onmousemove = handleMouseMove;
		}
	}
	function triggerMouseMoveOnScroll() {
		if (fixedHeader) {
			document.addEventListener('scroll', function() {
				handleMouseMove();
			});
		}
	}
	function watchHeaderTransition() {
		if (fixedHeader) {
			$header.on(transitionStart, function(e){
				if (e.target === this) {
					$(this).addClass('transitioning');
				}
			}).on(transitionEnd, function(e){
				if (e.target === this) {
					$(this).removeClass('transitioning');
				}
			})
		}
	}
	function bleedIntoHeader() {
		if (fixedHeader) {
			$('.bleedIntoHeader').each(function() {
				$(this).css('margin-top', -headerHeight);
			});
		}
	}
	function initSlick() {
		$('.slickSlider').each(function() {
			if (typeof $(this).slick === 'function') {
				$(this).slick();
			}
		});
	}

	function preventExpandedCollapse() {
		$('.preventExpandedCollapse').on('click', function(e) {
			if ($(this).attr('aria-expanded') == 'true') {
				e.stopImmediatePropagation();
				e.preventDefault();
			}
		});
	}
	function configureBleedSections() {
		$('.bleeds-into-above-section').each(function() {
			$(this).prev().addClass('below-section-bleeds-in').children(':not(.ignore-bleed)').first().addClass('bleed-target');
		});
	}
	function mobileMenuToggler() {
		var activeClassName = 'mobile-primary-menu-shown';
		$('#nav-primary-menu').on('shown.bs.collapse', function(e){
			if ( $(e.target).is( $(this) ) ) {
				$body.addClass(activeClassName);
			}
		}).on('hide.bs.collapse', function (e){
			if ( $(e.target).is( $(this) ) ) {
				$body.removeClass(activeClassName);
			}
		});
	}
	

	function boltOnBanner() {
		$('.bolt-on-banner').each(function(index) {
			var paddingTop = parseFloat($(this).css('padding-top'));
			// If no paddingTop then mediaQuery is not active and we don't need to run this.
			if ( paddingTop > 0 ) {
				var styleTagId = 'bolt-on-banner-style-' + index,
					$styleTag = $('#' + styleTagId),
					headerHeight = headerHeight || $header[0].getBoundingClientRect().height,
					$adminBar = $('#wpadminbar').first(),
					adminBarHeight = 0;
				if ( ! $styleTag.length ) {
					$styleTagHTML = '<style id="' + styleTagId + '"></style>';
					$body.append($styleTagHTML);
					$styleTag = $('#' + styleTagId);
				}
				if ( $adminBar.length ) {
					adminBarHeight = $adminBar[0].getBoundingClientRect().height;
				}
				var bannerPad = headerHeight + paddingTop + adminBarHeight,
					css = '.bolt-on-banner:before{padding-bottom:' + bannerPad + 'px;}';
					$styleTag.html(css);
			}
		});
	}

	function preventPaste() {
		$('.preventPaste').on('paste', function (e) {
			e.preventDefault();
			var $wpcf7NotValid = $(this).siblings('.wpcf7-not-valid-tip'),
				output = 'Pasting has been prevented for security purposes.';
			if ( ! $wpcf7NotValid.length ) {
				var wpcf7NotValidHTML = '<span class="wpcf7-not-valid-tip" aria-hidden="true"></span>'
				$(this).parent().append(wpcf7NotValidHTML);
				$wpcf7NotValid = $(this).siblings('.wpcf7-not-valid-tip');
			}
			$wpcf7NotValid.text(output);
	 });
	}

	function searchSubmitTabIndex() {
		$('.input-search').on('input', function(){
			var tabIndex = -1;
			if ( this.checkValidity() ) {
					tabIndex = 0;
			}
			$(this).siblings('[type="submit"]').attr('tabindex', tabIndex);
		});
	}
	function changeSelectTitleOnChange() {
		$('.wpcf7 select').each(function(){
			function handleChange($this) {
				$this.attr('title', $this.children(':selected').html());
			}
			handleChange($(this));
			$(this).on('change', function(){
				handleChange($(this));
			});
		});
	}
	function scrollToTarget($target) {
		// Make sure $target is a jQuery object.
		$target = $target instanceof jQuery ? $target : $($target);
		var targetTop = $target.offset().top,
			siteHeaderHeight = window.siteHeaderHeight
				? parseFloat(window.siteHeaderHeight)
				: $(".site-header")[0].getBoundingClientRect().height,
			padding = 30,
			scrollPosition = targetTop - siteHeaderHeight - padding;
		console.log('siteHeaderHeight', siteHeaderHeight);
		console.log('$target', $target);
		console.log('targetTop', targetTop);
		console.log('scrollPosition', scrollPosition);
		$("html, body").animate({ scrollTop: scrollPosition }, 350);
	}
	function interceptHashChange($target) {
		$target = $target || null;
		$(window).on("load hashchange", function (e) {
			if (window.location.hash && $(window.location.hash).length) {
				$target = $target || $(window.location.hash);
			}
			if ($target !== null && $target.length) {
				scrollToTarget($target);
			}
		});
	}
	function contactUsClick() {
		var _hash = '#contact-us';
		function coreFunc($this) {
			var targetForm = $('.wpcf7:visible').first();
			scrollToTarget(targetForm);

			// $this is only defined on the click/keyup events
			// Not the initial load _hash check usage.
			if ( $this !== undefined ) {
				history.replaceState(
					null,
					null,
					document.location.pathname + $this.attr("href")
				);
			}
			targetForm.find('input:visible, select:visible, textarea:visible').first().focus();
		}
		$('[href*="' + _hash + '"]').on("click keyup", function (e) {
			var key = e.key || e.keyCode;
			if (key) {
				var enterKey = key === "Enter" || key === 13;
				var spaceKey = key === " " || key === 32;
				if (!(enterKey || spaceKey)) {
					return;
				}
			}
			e.stopImmediatePropagation();
			e.preventDefault();
			coreFunc( $(this) );
		});
		// Fire on Load if location hash is _hash
		if ( location.hash === _hash ) {
			coreFunc();
		}
	}

	function readyFuncs() {
		detectPlatform();
		interceptHashChange();
		contactUsClick();
		collapseOnHover();
		activateMobileMenu();
		sizeHeaderPad();
		boltOnBanner();
		scrolledPastHeader();
		watchHeaderTransition();
		bleedIntoHeader();
		initSlick();
		bindCheckMouseOverTarget();
		mouseInHeaderArea();
		preventExpandedCollapse();
		configureBleedSections();
		mobileMenuToggler();
		preventPaste();
		triggerMouseMoveOnScroll();
		searchSubmitTabIndex();
		changeSelectTitleOnChange();
	}
	function resizeFuncs() {
		activateMobileMenu();
		sizeHeaderPad();
		bleedIntoHeader();
		boltOnBanner();
	}
	function scrollFuncs() {
		scrolledPastHeader();
		bleedIntoHeader();
	}
	readyFuncs();
	$(window).on('resize', function() {
		resizeFuncs();
	});
	$(window).on('scroll', function() {
		scrollFuncs();
	});
	function dispatchResize() {
		var resizeEvent = window.document.createEvent('UIEvents');
		resizeEvent.initUIEvent('resize', true, false, window, 0);
		window.dispatchEvent(resizeEvent);
	}
	window.onload = new function() {
		dispatchResize();
	};
});
