<?php
/**
 * This Component Renders A Dynamic Post Archives Menu in Years and Months with Count.
 * 
 * @package bolt-on
 */
function component_dynamic_archive_menu( $args ) {

	function bolt_on_add_span_to_archive_count( $links ) {
			$links = str_replace('</a>&nbsp;(', '&nbsp;<span class="archive-count count">(', $links);
			$links = str_replace(')', ')</span></a>', $links);
			return $links;
	}
	// Add the Count Span fucntion to get_archives_link filter
	add_filter( 'get_archives_link', 'bolt_on_add_span_to_archive_count', 10, 6 );

	function bolt_on_mod_archives_where( $where, $parsed_args ) {
		if ( ! empty( $parsed_args['in_year'] ) ) :
			$year   = absint( $parsed_args['in_year'] );
			$where .= " AND YEAR(post_date) = $year";
		endif;
		return $where;
	}
	add_filter( 'getarchives_where', 'bolt_on_mod_archives_where', 10, 2 );

	function get_posts_years_array() {
		global $wpdb;
		$result = array();
		$years  = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = 'publish' GROUP BY YEAR(post_date) DESC"
			),
			ARRAY_N
		);
		if ( is_array( $years ) && count( $years ) > 0 ) :
			foreach ( $years as $year ) :
				$result[] = $year[0];
			endforeach;
		endif;
		return $result;
	}
	$years = get_posts_years_array();
	ob_start();
	foreach ( $years as $year ) :
		$format         = 'custom';
		$url            = get_year_link( $year );
		$text           = '<span class="archive-year">' . sprintf( '%d', $year ) . '</span>';
		$archive_months = wp_get_archives(
			array(
				'hide_empty'      => 1,
				'show_post_count' => 1,
				'title_li'        => '',
				'echo'            => 0,
				'before'          => '<li class="menu-item has-count">',
				'after'           => '</li>',
				'in_year'         => $year,
			)
		);
		$months_count = substr_count( $archive_months, 'menu-item' );
		$count_html   = '&nbsp;(' . $months_count . ')';
		$year_link    = get_archives_link( $url, $text, $format, '', $count_html, false );
		?>
		<li id="yearly-archives-year-<?php echo esc_attr( $year ); ?>" class="menu-item has-count has-children">
			<?php
			echo $year_link;
			if ( $archive_months ) :
				?>
				<ul id="monthly-archives-year-<?php echo esc_attr( $year ); ?>" class="sub-menu archives-menu monthly-archives">
					<?php echo $archive_months; ?>
				</ul>
				<?php
			endif;
			?>
		</li>
		<?php
	endforeach;
	$markup = ob_get_clean();

	// Remove the Count Span filter
	remove_filter( 'get_archives_link', 'bolt_on_add_span_to_archive_count', 10, 6 );

	// Get archives.
	ob_start();
	if ( $markup ) :
		?>
		<ul class="menu archives-menu yearly-archives">
			<?php echo $markup; ?>
		</ul>
		<?php
	endif; // endif ( $markup ) :
	return ob_get_clean();
}