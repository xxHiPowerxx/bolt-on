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
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bolt-on' ); ?></a>

	<header id="masthead" class="site-header sizeHeaderPad scrolledPastHeaderRef">
		<?php include $template_directory . '/inc/header-top.php'; ?>
		<?php include $template_directory . '/inc/header-nav.php'; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content sizeHeaderPadTar">
