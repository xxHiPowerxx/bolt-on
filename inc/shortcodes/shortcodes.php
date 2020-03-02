<?php
/**
 * File that includes shortcode functions.
 *
 *
 * @package bolt-on
 */

function recent_posts_function( $atts ) {
	$max_posts = get_option( 'posts_per_page' );
	extract( shortcode_atts( array(
		'posts' => $max_posts,
	), $atts ) );
	// $content = '<ul>';
		query_posts( array('orderby' => 'date', 'order' => 'DESC' , 'showposts' => $posts) );
		// $content = ob_start();
		ob_start();
		if ( have_posts() ) :
			
			while ( have_posts() )
			: the_post();
			get_template_part( 'template-parts/content-archive', get_post_type() );
			
			endwhile;
		endif;
		// $content .= '</ul>';

	wp_reset_query();
	return ob_get_clean();
}
add_shortcode('recent-posts', 'recent_posts_function');

?>