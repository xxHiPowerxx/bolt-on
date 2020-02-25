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

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bolt-on' ); ?></a>

	<header id="masthead" class="site-header">
		<?php include $template_directory . '/inc/header-top.php'; ?>
		<?php include $template_directory . '/inc/header-nav.php'; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
