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

?>