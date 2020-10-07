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
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 67.64 34.73"><path d="M4.85,28.34C3.9,34.29,0,34.73,0,34.73H9.7S5.8,34.29,4.85,28.34Z" style="fill:#345073"/><polygon points="22.63 34.73 23.86 34.73 36.7 11.82 35.75 11.29 27.03 26.86 13.24 0 3.49 0 5.5 1.38 22.63 34.73" style="fill:#345073"/><path d="M67.64,34.73,49.81,0H40.06l2,1.37,8.66,16.87H43.78s7.77,2.65,11.91,9.67l3.5,6.82Z" style="fill:#345073"/><polygon points="45.14 27.05 31.25 0 21.5 0 23.51 1.38 40.63 34.73 45.14 27.05" style="fill:#ad976e"/></svg>
				</a>
				<i class="fa fas fa-chevron-down"></i>
				<i class="fa fas fa-bars"></i>
			</div>
		</header><!-- #masthead -->

		<div id="content" class="site-content sizeHeaderPadTar">
