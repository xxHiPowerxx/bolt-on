<?php
/**
 * This Component Renders A Dynamic Post Archives Menu in Years and Months with Count.
 * 
 * @package bolt-on
 */
function component_dynamic_archive_menu( $args ) {

	function bolt_on_add_span_to_archive_count( $links ) {
			$links = str_replace('</a>&nbsp;(', '&nbsp;<span class="archive-count count">(', $links);
			$links = str_replace(')', ')</span></a>', $links);
			return $links;
	}
	// Add a custom filter
	add_filter( 'get_archives_link', 'bolt_on_add_span_to_archive_count', 10, 6 );

	$archives_list = wp_get_archives(
		array(
			'hide_empty' => 0,
			'show_post_count' => 1,
			'title_li'   => '',
			'echo'       => 0,
			'before'     => '<li class="menu-item has-count">',
			'after'      => '</li>',
		)
	);

	// Remove the custom filter
	remove_filter( 'get_archives_link', 'bolt_on_add_span_to_archive_count', 10, 6 );

	// Get archives.
	ob_start();
	if ( $archives_list ) :
		?>
		<ul class="menu archives-list">
			<?php echo $archives_list; ?>
		</ul>
		<?php
	endif; // endif ( $archives_list ) :
	return ob_get_clean();
}