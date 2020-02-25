<?php
/**
 * Header Top Portion
 *
 * Contains Search Bar, Logo, and Header Info
 * 
 * @package bolt-on
 */

?>

<div class="header-top display-flex align-items-center justify-content-center">
	<div class="ctnr-search-bar">
		<input id="main-search" type="search" class="search" />
		<button id="submit-search" type="submit" class="btn btn-submit btn-success">Search</button>
	</div>
	<div class="site-branding">
		<?php
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