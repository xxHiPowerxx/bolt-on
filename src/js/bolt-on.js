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

	function readyFuncs() {
		collapseOnHover();
	}
	readyFuncs();
});
