<?php
/**
 * Header Navigation
 * 
 * @package bolt-on
 */

?>

<nav id="nav-mega-menu" class="main-navigation desktop-navigation navbar-nav ml-auto" aria-label="<?php esc_attr_e( 'Main menu', 'bolt-on' ); ?>">
	<?php
	$menu_name = 'primary-menu';
	$menu_location = $menu_name . '-location';
	$locations = get_nav_menu_locations();

	if (
		$locations &&
		isset( $locations[ $menu_location ] ) &&
		$locations[ $menu_location ] > 0
	) :
		wp_nav_menu(
			array(
				'theme_location' => $menu_location,
				'menu_id'        => $menu_name,
				'container'      => 'ul',
				'depth'          => 2,
				'walker'         => new BoltOn_Walker(),
			)
		);
	endif;
	?>
</nav><!-- #nav-mega-menu -->