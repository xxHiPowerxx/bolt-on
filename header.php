<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bolt-on
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!--insert meta tags  -->
	<?php require_once get_template_directory() . '/inc/meta-tags.php'; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bolt-on' ); ?></a>

	<header id="masthead" class="site-header">
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
			<?php
			/*   TODO: Create Widget Area for header-info
			if ( is_active_sidebar( 'header-info' ) ) : ?>
				<div class="header-info-wrapper">
						<?php dynamic_sidebar( 'header-info' ); ?>
				</div>
				<?php
			endif;*/
			?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'bolt-on' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
