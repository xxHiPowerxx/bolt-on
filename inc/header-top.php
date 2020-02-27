<?php
/**
 * Header Top Portion
 *
 * Contains Search Bar, Logo, and Header Info
 * 
 * @package bolt-on
 */

?>

<div class="header-top display-flex align-items-center justify-content-between">
	<div class="ctnr-search-bar">
		<?php echo get_search_form(); ?>
	</div>
	<div class="site-branding">
		<?php
		$logo_svg_path = get_theme_mod('logo_svg_path', null);
		if ( $logo_svg_path ) :
			$logo_svg_path_radio = get_theme_mod('logo_svg_path_radio', 'relative');
			$logo_svg_src = $logo_svg_path_radio === 'relative' ?
											get_stylesheet_directory() . $logo_svg_path :
											esc_url( $logo_svg_path );
			$image_alt_text = esc_attr( get_bloginfo( 'name', 'display' ) . ' Logo' );
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="custom-logo-link" rel="home">
			<div class="custom-logo">
				<?php include $logo_svg_src; ?>
			</div>
				<?php /*<img class="custom-logo" src="<?php echo $logo_svg_src; ?>" alt="<?php echo $image_alt_text; ?>" /> */ ?>
			</a>
			<?php
		else:
			$custom_logo = get_custom_logo();
			if ( $custom_logo ) :
				echo $custom_logo;
			else:
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$bolt_on_description = get_bloginfo( 'description', 'display' );
				if ( $bolt_on_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $bolt_on_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
			<?php endif; // endif ( $custom_logo ) : ?>
		<?php endif; // endif ( $logo_svg_path ) : ?>
	</div><!-- .site-branding -->
	<?php
	if ( is_active_sidebar( 'header-info' ) ) : ?>
		<div class="ctnr-header-info">
			<?php dynamic_sidebar( 'header-info' ); ?>
		</div>
		<?php
	endif;
	?>
</div>