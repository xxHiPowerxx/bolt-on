<?php
/**
 * This Component Renders A Dynamic Category Menu with Count.
 * 
 * @package bolt-on
 */
function component_dynamic_category_menu( $args ) {

	$categories_walker = new BoltOn_Walker_Category();
 
	$categories_list = wp_list_categories(
		array(
			'walker'     => $categories_walker,
			'orderby'    => 'count',
			'hide_empty' => 0,
			'show_count' => 1,
			'title_li'   => '',
			'echo'       => 0,
		)
	);

	// Get Categories.
	ob_start();
	if ( $categories_list ) :
		?>
		<ul class="menu categories-list">
			<?php echo $categories_list; ?>
		</ul>
		<?php
	endif; // endif ( $categories_list ) :
	return ob_get_clean();
}