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
function get_year_func() {
	$year = date( 'Y' );
	return $year;
}
add_shortcode( 'year', 'get_year_func' );

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

	// Get Component Function.
	$file_path = get_template_directory() . '/template-parts/components/component-contact-section.php';
	require_once( $file_path );

	return component_contact_section( $atts );
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
	$file_path = get_template_directory() . '/template-parts/components/component-dynamic-post-menu.php';
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
	$file_path = get_template_directory() . '/template-parts/components/component-dynamic-category-menu.php';
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
	$file_path = get_template_directory() . '/template-parts/components/component-dynamic-archive-menu.php';
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
	$file_path = get_template_directory() . '/template-parts/components/component-dynamic-sidebar-nav.php';
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
	$file_path = get_template_directory() . '/template-parts/components/component-dynamic-post-menu-section.php';
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

	// Get Component Function.
	$file_path = get_template_directory() . '/template-parts/components/component-sidebar-contact.php';
	require_once( $file_path );
	return component_sidebar_contact( $atts );
}
add_shortcode( 'sidebar_contact', 'get_sidebar_contact' );

/**
 * Video Archives
 * Renders a List of Most Recent Videos
 */
function get_video_archive( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	$file_path = get_template_directory() . '/template-parts/components/component-video-archive.php';
	require_once( $file_path );

	return component_video_archive( $atts );
}
add_shortcode( 'video_archive', 'get_video_archive' );

/**
 * Video Breadcrumbs
 * Renders a Breadcrumb Nav
 */
function get_breadcrumbs( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	$file_path = get_template_directory() . '/template-parts/components/component-breadcrumbs.php';
	require_once( $file_path );

	return component_breadcrumbs();
}
add_shortcode( 'breadcrumbs', 'get_breadcrumbs' );

/**
 * Site URL
 * @return string - the Site URL
 */
function bolt_on_site_url( $atts = null, $content = null ) {
	return site_url();
}
add_shortcode( 'site_url', 'bolt_on_site_url' );

/**
 * Template Directory URI
 * @return string - template directory uri
 */
function bolt_on_template_directory_uri( $atts = null, $content = null ) {
	return get_template_directory_uri();
}
add_shortcode( 'template_directory_uri', 'bolt_on_template_directory_uri' );

/**
 * Get Offices List
 * @return string - the offices list markup.
 */
function get_offices_list( $atts = null, $content = null ) {
	// Get Component Function.
	$file_path = get_template_directory() . '/template-parts/components/component-offices-list.php';
	require_once( $file_path );

	return component_offices_list();
}
add_shortcode( 'offices_list', 'get_offices_list' );

/**
 * Captorra Case ID
 * Select Either Default Case ID or Override.
 * @return string - Chosen Captorra Case ID
 */
function get_captorra_case_guid( $atts = null, $content = null ) {
	$captorra_case_guid_override = get_field( 'captorra_case_guid_override' );

	if ( $captorra_case_guid_override ) :
		$case_id = $captorra_case_guid_override;
	elseif( $default_captorra_case_guid = get_field( 'default_captorra_case_guid', 'options' ) ) :
		$case_id = $default_captorra_case_guid;
	endif;
	$content = str_replace( 'value=""', 'value="' . $case_id . '"', $content );
	return do_shortcode($content);
}
add_shortcode( 'captorra_case_guid', 'get_captorra_case_guid' );

/**
 * Get Swoosh
 * Render's swoosh with wp_get_attachment_image();
 * @return string - Chosen Captorra Case ID
 */
function get_swoosh( $atts = null, $content = null ) {
	$swoosh_image_id = get_field( 'swoosh_image' );
	if ( $swoosh_image_id ) :
		$size = array( null, 500 );
		$attr = array('class' => 'swoosh');
		return wp_get_attachment_image( $swoosh_image_id, $size, false, $attr );
	endif;
}
add_shortcode( 'swoosh', 'get_swoosh' );

function custom_code_generator(){
    wpcf7_add_form_tag('mail_recipients', 'custom_code_handler');
}
add_action('wpcf7_init', 'custom_code_generator');

function custom_code_handler($tag){
	// var_dump($tag);
	$select_name = 'default-mail-recipients-name';
	if ( ! empty( $tag->options ) ) :
		$select_name = $tag->options[0];
	endif;

	// Get Parent Level Practice Areas
	$parent_query = get_practice_area_parents();
	if ( $parent_query->have_posts() ) :
		$posts_data = array();
		while ( $parent_query->have_posts() ) :
			$parent_query->the_post();
			$mail_recipients = get_field( 'mail_recipients' );
			if ( $mail_recipients ) :
				$long_title              = get_the_title();
				$short_title             = esc_attr( get_field( 'short_title' ) );
				$post_title              = $short_title ? : $long_title;
				$posts_data[$post_title] = $mail_recipients;
			endif;
		endwhile;
		// TODO figure out why wp_localize_script is not passing data.
		// function localize_script($posts_data) {
			// Register Scripts
			$handle = 'bolt-on-mail-recipients-js';
			$path   = '/assets/js/bolt-on-mail-recipients.js';
			// wp_register_script( $handle, get_theme_file_uri( $path ), array( 'jquery', 'bolt-on-js' ), filemtime( get_template_directory() . $path ), true );
			// var_dump($posts_data);
			wp_localize_script( 'bolt-on-js', 'postsData', $posts_data );
			// wp_enqueue_script( $handle );
		// }
		// add_action('wp_enqueue_scripts', 'pass_var_to_js',99);
		// add_action( 'wp_enqueue_scripts', 'localize_script', 99 );
	endif;
	//create html and return

	$html = '<input type="hidden" disabled class="selectHiddenOptionTar" name="' . $select_name . '" />';

	return $html;

}