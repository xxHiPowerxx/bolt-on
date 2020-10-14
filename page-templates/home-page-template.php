<?php
/**
 * Template Name: Home Page
 *
 * @package     bolt-on
 */

// Enqueue Styles
$home_page_template_css_path = '/assets/css/home-page-template.css';
wp_enqueue_style( 'home-page-template-css', get_theme_file_uri( $home_page_template_css_path ), array( 'bolt-on-vendor-slick-css', 'bolt-on-css' ), filemtime( get_template_directory() . $home_page_template_css_path ), 'all' );

$home_page_template_js_path = '/assets/js/bolt-on.js';
wp_enqueue_script( 'bolt-on-js', get_theme_file_uri( $home_page_template_js_path ), array( 'jquery', 'bolt-on-vendor-bootstrap-js', 'bolt-on-vendor-slick-js' ), filemtime( get_template_directory() . $home_page_template_js_path ), false );

// Add trans-header class to body.
function add_home_page_template_class( $class ) {
	$class[] = 'trans-header';
	return $class;
};
add_filter( 'body_class', 'add_home_page_template_class');

get_header();

	// Gets Page Content
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', get_post_type() );
	endwhile; // End of the loop.

get_footer();