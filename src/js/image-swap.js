jQuery(document).ready(function ($) {
	function imageSwap() {
		$('.imageSwap').each(function() {
			var $imageSwapControllers = $(this).find('.imageSwapController'),
			$imageSwapTars = $(this).find('.imageSwapTar');
			$imageSwapControllers.on('mouseover focusin', function() {
				var id = $(this).attr('id'),
				$current = $imageSwapTars.filter('.shown'),
				$imageSwapTar = $imageSwapTars.filter('[data-image-swap-controller="' + id + '"]');
				if ( ! $current.is($imageSwapTar) ) {
					$imageSwapControllers.not($(this)).removeClass('active');
					$(this).addClass('active');
					$imageSwapTars.removeClass('show');
					$imageSwapTar.addClass('show');
				}
			});
		});
	}
	function bgImageSwap() {
		$('.bgImageSwap').each(function() {
			var $bgImageSwapControllers = $(this).find('.bgImageSwapController'),
			$bgImageSwapTar = $(this).find('.bgImageSwapTar');
			$bgImageSwapControllers.on('mouseover focusin', function() {
				var dataBgImageUrl = $(this).attr('data-bg-image-swap-url'),
				bgImageUrl = 'url(' + dataBgImageUrl + ')';
				$bgImageSwapTar.css('background-image', bgImageUrl);
			});
		});
	}

	function readyFuncs() {
		imageSwap();
		bgImageSwap();
	}
	readyFuncs();
});