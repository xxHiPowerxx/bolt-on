<?php
/**
 * File included in functions for Creating Custom Taxonomies.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 * @package bolt-on
 */

/**
 * A Function that will render our Custom Taxonomies.
 */
function bolt_on_custom_taxonomies() {
	// Add new taxonomy, make it hierarchical like categories
	//first do the translations part for GUI
 
	$labels = array(
		'name'              => _x( 'Video Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Video Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Video Categories' ),
		'all_items'         => __( 'All Video Categories' ),
		'parent_item'       => __( 'Parent Video Category' ),
		'parent_item_colon' => __( 'Parent Video Category:' ),
		'edit_item'         => __( 'Edit Video Category' ), 
		'update_item'       => __( 'Update Video Category' ),
		'add_new_item'      => __( 'Add New Video Category' ),
		'new_item_name'     => __( 'New Video Category Name' ),
		'menu_name'         => __( 'Video Categories' ),
	);

	// Now register the taxonomy
 
  register_taxonomy(
		'video-category',
		array(
			'videos',
		),
		array(
			'public'             => true,
			'publicly_queryable' => true,
			'hierarchical'       => true,
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_admin_column'  => true,
			'query_var'          => true,
			'show_in_rest'       => true,
			'rewrite'            => array(
				'slug'       => 'videos',
				'with_front' => false,
			),
			// 'rewrite'           => false,
		)
	);
	
}
	 
	/**
	 * Hook into the 'init' action so that the function
	 * Containing our taxonomy registration is not
	 * unnecessarily executed.
	 */
	 
	add_action( 'init', 'bolt_on_custom_taxonomies', 0 );