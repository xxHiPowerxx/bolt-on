<?php
/**
 * This Component Uses get_dynamic_post_menu() to render a dynamic sidebar nav.
 * 
 * @package bolt-on
 */
function component_dynamic_sidebar_nav() {

	// Enqueue Component Stylesheet.
	$dynamic_sidebar_nav_css_path = '/assets/css/dynamic-sidebar-nav.css';
	wp_register_style(
		'dynamic-sidebar-nav-css',
		get_theme_file_uri( $dynamic_sidebar_nav_css_path ),
		array(
			'bolt-on-css',
		),
		filemtime( get_template_directory() . $dynamic_sidebar_nav_css_path ),
		'all'
	);
	wp_enqueue_style( 'dynamic-sidebar-nav-css' );

	// Get Dynamic Post Menu.
	$dynamic_post_menu_array = get_dynamic_post_menu();
	if ( ! $dynamic_post_menu_array ) :
		return;
	endif;
	$last_ancestor_title = $dynamic_post_menu_array['last_ancestor_title'];
	$last_ancestor_link  = $dynamic_post_menu_array['last_ancestor_link'];
	$dynamic_post_menu   = $dynamic_post_menu_array['markup'];

	ob_start();
	if ( $last_ancestor_title ) :
		?>
		<h3 class="sidebar-heading"><a href="<?php echo $last_ancestor_link; ?>"><?php echo $last_ancestor_title; ?></a></h3>
		<?php
	endif; // endif ( $last_ancestor_title ) :
	if ( $dynamic_post_menu ) :
		?>
		<nav class="sidebar-nav">
			<?php echo $dynamic_post_menu;?>
		</nav>
		<?php
	endif; //endif ( $dynamic_post_menu ) :

	return ob_get_clean();

}