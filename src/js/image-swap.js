jQuery(document).ready(function ($) {
	var transitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';
	function imageSwap() {
		$('.imageSwap').each(function() {
			var $imgSwapControllers = $(this).find('.imgSwapController')
			$imageSwapTars = $(this).find('.imageSwapTar');
			$imgSwapControllers.on('mouseover focusin', function() {
				var id = $(this).attr('id'),
				$current = $imageSwapTars.filter('.shown'),
				$imageSwapTar = $imageSwapTars.filter('[data-image-swap-controller="' + id + '"]');
				if ( ! $current.is($imageSwapTar) ) {
					$imgSwapControllers.not($(this)).removeClass('active');
					$(this).addClass('active');
					$imageSwapTars.removeClass('show');
					$imageSwapTar.addClass('show');
				}
				// $imageSwapTars.hide('fade');
				// $imageSwapTar.show('fade');
			});
		});
	}

	function readyFuncs() {
		imageSwap();
	}
	readyFuncs();
});