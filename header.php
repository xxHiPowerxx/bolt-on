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
	<?php
	$template_directory = get_template_directory();
	require_once $template_directory . '/inc/meta-tags.php'; ?>

	<?php wp_head(); ?>
</head>
<?php
	global $post;
	if ( $post ) :
		$post_slug = $post->post_name;
		$post_type = $post->post_type;
		$body_class = $post_slug . '-' . $post_type;
	else :
		$body_class = 'no-post';
	endif;
	$mobile_nav_breakpoint = esc_attr( $GLOBALS['mobile_nav_breakpoint'] );
	$mobile_nav_breakpoint_attr = 'data-mobile-nav-breakpoint="' . $mobile_nav_breakpoint . '"';
?>
<body <?php body_class('fixed-header hide-header' . ' ' . $body_class); ?> <?php echo $mobile_nav_breakpoint_attr; ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content" tabindex="1"><?php esc_html_e( 'Skip to Content', 'bolt-on' ); ?></a>

		<header id="masthead" class="site-header sizeHeaderPad scrolledPastHeaderRef">
			<?php include $template_directory . '/inc/header-top.php'; ?>
			<?php include $template_directory . '/inc/header-nav.php'; ?>
			<div id="show-header">
				<a href="<?php echo esc_url( home_url( '/' ) ) ?>" rel="home" class="show-header-icon" tabindex="0">
					<?php
					$icon_svg_path = get_theme_mod('icon_svg_path', null);
					if ( $icon_svg_path ) :
						$icon_svg_path_radio = get_theme_mod('icon_svg_path_radio', 'relative');
						$icon_svg_src = $icon_svg_path_radio === 'relative' ?
														get_stylesheet_directory() . $icon_svg_path :
														esc_url( $icon_svg_path );
						// $image_alt_text = esc_attr( get_bloginfo( 'name', 'display' ) . ' Logo' );
						include $icon_svg_src;
					else:
						$site_icon_id = get_option( 'site_icon' );
						if ( $site_icon_id ) :
							$custom_icon = wp_get_attachment_image( $site_icon_id, array(null, 24), true );
							echo $custom_icon;
						else:
							if ( is_front_page() && is_home() ) :
								?>
								<h2 class="site-title"><?php bloginfo( 'name' ); ?></h2>
								<?php
							else :
								?>
								<p class="site-title"><?php bloginfo( 'name' ); ?></p>
								<?php
							endif;
						endif; // endif ( $custom_icon ) :
					endif; // endif ( $icon_svg_path ) :
					?>
				</a>
				<i class="fa fas fa-chevron-down"></i>
				<i class="fa fas fa-bars"></i>
			</div>
		</header><!-- #masthead -->

		<div id="content" class="site-content sizeHeaderPadTar">
