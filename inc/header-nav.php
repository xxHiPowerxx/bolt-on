<?php
/**
 * Header Navigation
 * 
 * @package bolt-on
 */

?>

<nav id="nav-primary-menu" class="main-navigation desktop-navigation navbar-nav ml-auto collapse" aria-label="<?php esc_attr_e( 'Main menu', 'bolt-on' ); ?>">
	<button class="btn-cta-outer stroke-border btn-mobile-menu-back" type="button" data-toggle="collapse" data-target="#nav-primary-menu" aria-expanded="true" aria-controls="nav-primary-menu">
		<span class="btn-cta btn-cta-inner stroke-border-inner">
			<span class="btn-cta-text stroke-border-lvl-three"><span class="fa fa-chevron-left"></span>Back</span>
		</span>
	</button>
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
</nav><!-- #primary-menu -->

<nav id="nav-mobile-menu" class="main-navigation mobile-navigation navbar-nav ml-auto" aria-label="<?php esc_attr_e( 'Mobile menu', 'bolt-on' ); ?>">
	<?php
	$menu_name = 'mobile-menu';
	$menu_location = $menu_name . '-location';
	$locations = get_nav_menu_locations();

	if (
		$locations &&
		isset( $locations[ $menu_location ] ) &&
		$locations[ $menu_location ] > 0
	) :
	$anchor_mobile_menu_more = '<a id="anchor-mobile-menu-more" href="#nav-primary-menu" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-primary-menu">More</a>';
		wp_nav_menu(
			array(
				'theme_location' => $menu_location,
				'menu_id'        => $menu_name,
				'container'      => '',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s<li id="mobile-menu-more" class="menu-item mobile-menu-toggler">' . $anchor_mobile_menu_more . '</li></ul>',
				'depth'          => 2,
				'walker'         => new BoltOn_Walker(),
			)
		);
	endif;
	?>
</nav><!-- #mobile-menu -->