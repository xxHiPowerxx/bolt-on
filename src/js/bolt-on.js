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
	function checkIfMouseIsOverHeader() {
		$header.on('mouseover', function(){
			this.mouseIsOver = true;
		}).on('mouseout', function(){
			this.mouseIsOver = false;
		});
	}
	function mouseInHeaderArea() {
		if (fixedHeader) {
			document.onmousemove = handleMouseMove;
			function handleMouseMove(event) {
				// var headerHeightFromTop = headerHeight + $header[0].offsetTop;
				var headerHeightFromTop = window.innerHeight * .10;
				event = getMousePosition(event);
				// Get Mouse Y Position relative to window and compare to Header Height.
				if (fixedHeader && event.clientY <= headerHeightFromTop ) {
					$body.addClass('mouseInHeaderArea');
				} else if ($header[0].mouseIsOver === false) {
					$body.removeClass('mouseInHeaderArea');
				}
				// Use event.pageX / event.pageY here
			}
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
			if ($.isFunction($(this).slick)) {
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
	// Select hidden Option on change.
	function selectHiddenOption() {
		var $selectHiddenOption = $('.selectHiddenOption');
		$selectHiddenOption.each(function() {
			var $parent = $(this).closest('form'),
			$target = $parent.find('.selectHiddenOptionTar');
			$(this).on('change', function(){
				var selectedIndex = this.selectedIndex,
				$option = $(':nth-child(' + selectedIndex + ')', $target);
				if ( $option.length )
					$option.prop('selected', true);
				else {
					$target[0].selectedIndex = -1;
				}
			});
		});
	}

	function readyFuncs() {
		detectPlatform();
		collapseOnHover();
		activateMobileMenu();
		sizeHeaderPad();
		scrolledPastHeader();
		watchHeaderTransition();
		bleedIntoHeader();
		initSlick();
		checkIfMouseIsOverHeader();
		mouseInHeaderArea();
		preventExpandedCollapse();
		configureBleedSections();
		mobileMenuToggler();
		selectHiddenOption();
	}
	function resizeFuncs() {
		activateMobileMenu();
		sizeHeaderPad();
		bleedIntoHeader();
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
});
