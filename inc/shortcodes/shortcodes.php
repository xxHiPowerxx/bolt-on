<?php
/**
 * File that includes shortcode functions.
 *
 *
 * @package bolt-on
 */

/**
 * Year shortcode.
 */
function get_archives_func() {
	$archives = date( 'Y' );
	return $archives;
}
add_shortcode( 'archives', 'get_archives_func' );

/**
 * Recent Posts shortcode.
 */
function recent_posts_function( $atts ) {
	$max_posts = get_option( 'posts_per_page' );
	extract( shortcode_atts( array(
		'posts' => $max_posts,
	), $atts ) );
	query_posts( array('orderby' => 'date', 'order' => 'DESC' , 'showposts' => $posts) );
	ob_start();
	if ( have_posts() ) :
		
		while ( have_posts() ):
			the_post();
			get_template_part( 'template-parts/content-archive', get_post_type() );
		
		endwhile;
	endif;

	wp_reset_query();
	return ob_get_clean();
}
add_shortcode('recent-posts', 'recent_posts_function');

/**
 * Site Phone Number Shortcode.
 * Will Render Site Phone Number in Widget or Content.
 */
function get_site_phone_number_func( $atts = '' ) {
	$site_phone_number = esc_attr( get_theme_mod('site_phone_number', '') );
	if ( $atts !== '' ) :
		$return_result = '<a class="anchor-site-phone-number" href="tel:' . $site_phone_number . '"><span class="desktop site-phone-number">' . $site_phone_number . '</span></a>';
	else :
		$return_result = $site_phone_number;
	endif;
	return $return_result;
}
add_shortcode( 'site_phone_number', 'get_site_phone_number_func' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Contact Section Shortcode
 * Renders Contact Form and Offices List
 */
function get_contact_section( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// If no Contact Form Provided, default to first.
	if ( ! isset( $atts['contact_form'] ) ) :
		$contact_form = get_posts(
			array(
				'post_type' => 'wpcf7_contact_form',
				'numberposts' => 1
			)
		)[0];
		// var_dump($contact_form);
		$contact_form_id    = $contact_form->ID;
		$contact_form_title = $contact_form->post_title;
		$contact_form_shortcode_string = 'contact-form-7 id="' . $contact_form_id . '" title="' . $contact_form_title . '"';
		$atts['contact_form'] = $contact_form_shortcode_string;
	endif;

	// Get Component Function.
	$file_path = get_template_directory() . '/inc/components/contact-section.php';
	require_once( $file_path );

	if ( $atts['contact_form'] ) :
		return component_contact_section( $atts['contact_form'] );
	endif;
}
add_shortcode( 'contact_section', 'get_contact_section' );

/**
 * Dynamic Post Type Menu Shortcode
 * Gets list of Post Type and Children
 */
function get_dynamic_post_menu( $atts = '' ) {

	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	$file_path = get_template_directory() . '/inc/components/dynamic-post-menu.php';
	require_once( $file_path );

	return component_dynamic_post_menu( $atts );
}
add_shortcode( 'dynamic_post_menu', 'get_dynamic_post_menu' );

/**
 * Dynamic Post Type Menu Shortcode
 * Gets Post Categories.
 */
function get_dynamic_category_menu( $atts = '' ) {

	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	$file_path = get_template_directory() . '/inc/components/dynamic-category-menu.php';
	require_once( $file_path );

	return component_dynamic_category_menu( $atts );
}
add_shortcode( 'dynamic_category_menu', 'get_dynamic_category_menu' );

/**
 * Dynamic Post Type Menu Shortcode
 * Gets Post Archives in Years and Months.
 */
function get_dynamic_archive_menu( $atts = '' ) {

	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	$file_path = get_template_directory() . '/inc/components/dynamic-archive-menu.php';
	require_once( $file_path );

	return component_dynamic_archive_menu( $atts );
}
add_shortcode( 'dynamic_archive_menu', 'get_dynamic_archive_menu' );

/**
 * Sidebar Nav that Shows a Title Dynamically Generated Title
 * and a Dynamic Post Menu
 * uses get_dynamic_post_menu()
 */
function get_dynamic_sidebar_nav( $atts = '' ) {

	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	$type_of_nav = null;
	if ( is_string( $atts ) ) :
		$type_of_nav = $atts;
	elseif ( isset( $atts['type_of_nav'] ) ) :
		$type_of_nav = $atts['type_of_nav'];
	endif;

	// Get Component Function.
	$file_path = get_template_directory() . '/inc/components/dynamic-sidebar-nav.php';
	require_once( $file_path );

	return component_dynamic_sidebar_nav( $type_of_nav );
}
add_shortcode( 'dynamic_sidebar_nav', 'get_dynamic_sidebar_nav' );

/**
 * Section that Displays a Case Result 
 * and a Dynamically Generated Menu with Only the Second Level
 * Children as Menu Items.
 * uses get_dynamic_post_menu()
 */
function get_dynamic_post_menu_section( $atts = '' ) {

	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	$file_path = get_template_directory() . '/inc/components/dynamic-post-menu-section.php';
	require_once( $file_path );

	return component_dynamic_post_menu_section( $atts );
}
add_shortcode( 'dynamic_post_menu_section', 'get_dynamic_post_menu_section' );

/**
 * Sidebar Contact Shortcode
 * Renders Contact Form in Sidebar
 */
function get_sidebar_contact( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// If no Contact Form Provided, default to first.
	if ( ! isset( $atts['contact_form'] ) ) :
		$contact_form = get_posts(
			array(
				'post_type' => 'wpcf7_contact_form',
				'numberposts' => 1
			)
		)[0];
		$contact_form_id    = $contact_form->ID;
		$contact_form_title = $contact_form->post_title;
		$contact_form_shortcode_string = 'contact-form-7 id="' . $contact_form_id . '" title="' . $contact_form_title . '"';
		$atts['contact_form'] = $contact_form_shortcode_string;
	endif;

	// Get Component Function.
	$file_path = get_template_directory() . '/inc/components/sidebar-contact.php';
	require_once( $file_path );

	if ( $atts['contact_form'] ) :
		return component_sidebar_contact( $atts );
	endif;
}
add_shortcode( 'sidebar_contact', 'get_sidebar_contact' );