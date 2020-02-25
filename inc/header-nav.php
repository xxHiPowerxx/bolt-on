<?php
/**
 * Header Navigation
 * 
 * @package bolt-on
 */

?>

<nav id="nav-mega-menu" class="main-navigation desktop-navigation navbar-nav ml-auto" aria-label="<?php esc_attr_e( 'Main menu', 'bolt-on' ); ?>">
	<?php
	$menu_name = 'primary';
	$locations = get_nav_menu_locations();

	if ( $locations && isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] > 0 ) :
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'desktop-menu',
				'container'      => 'ul',
				'depth'          => 2,
				'walker'         => new BoltOn_Walker(),
			)
		);
	endif;
	?>
</nav><!-- #site-navigation -->