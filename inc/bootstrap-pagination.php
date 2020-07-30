<?php
/**
 * @param WP_Query|null $wp_query
 * @param bool $echo
 *
 * @return string
 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
 * or nothing to use the current global $wp_query (eg: taxonomy term page)
 * - Tested on WP 4.9.5
 * - Tested with Bootstrap 4.1
 * - Tested on Sage 9
 *
 * USAGE:
 *     <?php echo bootstrap_pagination(); ?> //uses global $wp_query
 * or with custom WP_Query():
 *     <?php
 *      $query = new \WP_Query($args);
 *       ... while(have_posts()), $query->posts stuff ...
 *       echo bootstrap_pagination($query);
 *     ?>
 */
function bootstrap_pagination( \WP_Query $wp_query = null, $echo = true ) {

	$bootstrap_pagination_css_path = '/assets/css/bootstrap-pagination.css';
	wp_register_style(
		'bolt-on-bootstrap-pagination', 
		get_theme_file_uri( $bootstrap_pagination_css_path ),
		array(),
		filemtime( get_template_directory() . $bootstrap_pagination_css_path ),
		'all'
	);
	wp_enqueue_style( 'bolt-on-bootstrap-pagination' );

	if ( null === $wp_query ) {
		global $wp_query;
	}
	$pages = paginate_links( array(
		'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		'format'       => '?paged=%#%',
		'current'      => max( 1, get_query_var( 'paged' ) ),
		'total'        => $wp_query->max_num_pages,
		'type'         => 'array',
		'show_all'     => false,
		'end_size'     => 3,
		'mid_size'     => 1,
		'prev_next'    => true,
		'prev_text'    => __( '« Prev' ),
		'next_text'    => __( 'Next »' ),
		'add_args'     => false,
		'add_fragment' => ''
	)
	);
	if ( is_array( $pages ) ) {
		$pagination = '<div class="pagination bolt-on-highlight-font"><ul class="pagination">';
		foreach ( $pages as $page ) {
			$pagination .= '<li class="page-item"> ' . str_replace( 'page-numbers', 'page-link theme-style-border', $page ) . '</li>';
		}
		$pagination .= '</ul></div>';
		if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}
	return null;
}
