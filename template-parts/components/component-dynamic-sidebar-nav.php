<?php
/**
 * This Component Uses get_dynamic_post_menu() to render a dynamic sidebar nav.
 * 
 * @package bolt-on
 */

/**
 * Get Type of Sidebar Nav requested.
 * 
 * @param string $type_of_nav - The Type of Nav to return
 * Options are ancestor (default), category|categories, and year
 */
function component_dynamic_sidebar_nav( $type_of_nav = null ) {

	$type_of_nav =  $type_of_nav === null ? 'ancestor' : $type_of_nav;
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

	// Ancestor Menu
	if ( $type_of_nav === 'ancestor' ) :
		// Get Dynamic Post Menu.
		$dynamic_post_menu_array = get_dynamic_post_menu();
		if ( ! $dynamic_post_menu_array ) :
			return;
		endif;
		$sidebar_nav_title      = $dynamic_post_menu_array['last_ancestor_title'];
		$sidebar_nav_title_link = $dynamic_post_menu_array['last_ancestor_link'];
		$sidebar_nav_content    = $dynamic_post_menu_array['markup'];
	endif; // endif ( $type_of_nav === 'ancestor' ) :

	if ( $type_of_nav === 'categories' ) :
		// Get Dynamic Post Menu.
		$dynamic_category_menu = get_dynamic_category_menu();
		if ( ! $dynamic_category_menu ) :
			return;
		endif;
		$sidebar_nav_title      = ucfirst( $type_of_nav );
		$sidebar_nav_title_link = '#';
		$sidebar_nav_content    = $dynamic_category_menu;
	endif; // endif ( $type_of_nav === 'category' ) :

	if ( $type_of_nav === 'archives' ) :
		// Get Dynamic Post Menu.
		$dynamic_archive_menu = get_dynamic_archive_menu();
		if ( ! $dynamic_archive_menu ) :
			return;
		endif;
		$sidebar_nav_title      = ucfirst( $type_of_nav );
		$sidebar_nav_title_link = '#';
		$sidebar_nav_content    = $dynamic_archive_menu;
	endif; // endif ( $type_of_nav === 'archives' ) :

	$sidebar_nav_id = null;
	if ( ! function_exists( 'setCollapse' ) ) :
		function setCollapse(
			$type_of_nav = null,
			$button = null,
			$sidebar_nav_id = null,
			$sidebar_nav_title_tabindex = null
		) {
			if (
				$type_of_nav &&
				(
					$type_of_nav === 'categories' ||
					$type_of_nav === 'archives'
				)
			) :
				if ( $button && $sidebar_nav_id ) :
					$return = 'data-toggle="collapse" data-target="#' . $sidebar_nav_id . '" aria-expanded="false" aria-controls="' . $sidebar_nav_id . '" tabindex="1"';
				else :
					$return = 'collapse';
				endif;
				return $return;
			else :
				return 'tabindex="' . $sidebar_nav_title_tabindex . '"';
			endif;
		}
	endif; // endif ( ! function_exists( 'setCollapse' ) ) :

	$sidebar_nav_title_tabindex = $sidebar_nav_title_link === '#' ? '-1' : '0';

	if ( $sidebar_nav_title || $sidebar_nav_content ) :
		ob_start();
		?>
		<div class="dynamic-sidebar-nav <?php echo esc_attr( $type_of_nav ); ?>-dynamic-sidebar">
			<?php
			if ( $sidebar_nav_title ) :
				$sidebar_nav_id = 'nav-' . $sidebar_nav_title;
				?>
				<h3 class="sidebar-heading"><a href="<?php echo $sidebar_nav_title_link; ?>" <?php echo setCollapse( $type_of_nav, true, $sidebar_nav_id, $sidebar_nav_title_tabindex ); ?>><?php echo $sidebar_nav_title; ?></a></h3>
				<?php
			endif; // endif ( $last_ancestor_title ) :
			if ( $sidebar_nav_content ) :
				?>
				<nav id="<?php echo $sidebar_nav_id; ?>" class="sidebar-nav <?php echo setCollapse( $type_of_nav ); ?>">
					<?php echo $sidebar_nav_content;?>
				</nav>
				<?php
			endif; //endif ( $sidebar_nav_content ) :
		?>
		</div>
		<?php

		return ob_get_clean();
	endif; // endif ( $sidebar_nav_title || $sidebar_nav_content ) :

}