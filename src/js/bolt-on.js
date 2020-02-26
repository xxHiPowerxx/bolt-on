// Write JS here
jQuery(document).ready(function($) {
	function collapseOnHover() {
		$('.has-dropdown').each(function() {
			var collapse = $(this).children('.collapse'),
				className = 'active';
			$(this).hover(
				function() {
					$(this).addClass(className);
					collapse.collapse('show');
				},
				function() {
					$(this).removeClass(className);
					collapse.collapse('hide');
				}
			);
		});
	}
	function sizeHeaderPad() {
		$('.sizeHeaderPad').each(function() {
			if (getComputedStyle(this).position === 'fixed') {
				var sizeHeaderPadTar = $('.sizeHeaderPadTar').first(),
					thisHeight = this.getBoundingClientRect().height;
				sizeHeaderPadTar.css('padding-top', thisHeight);
			}
		});
	}
	function scrolledPastHeader() {
		$('.scrolledPastHeaderRef').each(function() {
			var thisRect = this.getBoundingClientRect();
			if ($(window).scrollTop() >= thisRect.height + thisRect.top) {
				$('body').addClass('scrolledPastHeader');
			} else {
				$('body').removeClass('scrolledPastHeader');
			}
		});
	}

	function readyFuncs() {
		collapseOnHover();
		sizeHeaderPad();
		scrolledPastHeader();
	}
	function resizeFuncs() {
		sizeHeaderPad();
	}
	function scrollFuncs() {
		scrolledPastHeader();
	}
	readyFuncs();
	$(window).on('resize', function() {
		resizeFuncs();
	});
	$(window).on('scroll', function() {
		scrollFuncs();
	});
});
