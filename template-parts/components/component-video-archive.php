<?php
/**
 * This Component Renders the Video Archive.
 * 
 * @param array $args {
 * 	@property int [videos_to_show] - Number of Videos to Show.
 * 	@property array [videos_to_get] - List of Post IDs to get.
 * }
 * 
 * 
 * @package bolt-on
 */
function component_video_archive( $args = array() ) {
	$videos_to_show = isset( $args['videos_to_show'] ) ?
		$args['videos_to_show'] :
		-1;
	$videos_to_get = isset( $args['videos_to_get'] ) ?
		$args['videos_to_get'] :
		null;
	
	global $post;
	$is_tax     = is_tax();
	$is_archive = is_archive();
	if ( ! $post && ! $is_archive ) :
		return;
	endif;
	if ( $is_tax ) :
		$videos_to_show = -1;
	endif;

	$post_type = get_post_type();
	// Determine if this is A Taxonomy Archive, The Post Type Archive or a single post.
	if ( $is_tax ) :
		$video_categories = array( get_queried_object() );
	elseif( $is_archive ) :
		$video_categories = get_terms( 'video-category' );
	else: // is post
		$video_categories = get_the_terms( $post, 'video-category' );
	endif; // endif ( $is_tax ) :
	if ( $video_categories ) :
		foreach ( $video_categories as $video_category ) :
			$video_category_id   = $video_category->term_id;
			$video_category_name = esc_attr( $video_category->name );
			$video_category_slug = $video_category->slug;
			$excluded            = $is_archive ? null : $post->ID;
			$get_posts_args      = array(
				'post_type'      => $post_type,
				'posts_per_page' => $videos_to_show,
				'video-category' => $video_category_slug,
				'post__in '      => $videos_to_get,
				'post__not_in'   => array( $excluded ),
			);
			$posts_of_category   = new WP_Query( $get_posts_args );

			if ( $posts_of_category->have_posts() ) :
				?>
				<div class="component-video-archive">
					<header class="section-header theme-header">
						<div class="theme-heading stroke-border">
							<div class="theme-heading-outer stroke-border-inner">
								<div class="theme-heading-inner stroke-border-lvl-three">
									<h2 class="theme-heading-title section-title">
										<?php echo $video_category_name . ' Videos'; ?>
									</h2>
								</div>
							</div>
						</div>
					</header>
					<div class="archive-list archive-video-list">
						<?php
						while ( $posts_of_category->have_posts() ) :
							$posts_of_category->the_post();
							// $title = apply_filters('get_the_title', $post_of_category->title);
							// var_dump(get_the_title());

							// $posts_of_category->the_post;
							get_template_part( 'template-parts/content-archive', get_post_type() );
						endwhile;
						wp_reset_query();
						?>
					</div><!-- /.archive-video-list -->
					<?php
					// If There are more posts than can be shown, 
					// $post_of_category->max_num_pages will be greater than 0
					// Note that $posts_of_category->max_num_pages is always > 0
					// If the current post has been excluded from the Query.
					$max_num_pages = $posts_of_category->max_num_pages;
					if ( $max_num_pages ) :
						//render a CTA btn.
						$videos_category_url = esc_url( get_category_link( $video_category ) );
						?>
						<div class="ctnr-btn-view-more-videos">
							<a class="anchor-btn-cta btn-cta-outer stroke-border has-chevron btn-view-more-videos" href="<?php echo $videos_category_url; ?>">
								<span class="btn-cta btn-cta-inner stroke-border-inner">
									<span class="btn-cta-text stroke-border-lvl-three"><span>View All</span>&nbsp;<span><?php echo $video_category_name; ?></span>&nbsp;<span>Videos</span></span>
								</span>
							</a>
						</div>
						<?php
					endif; // endif ( $found_posts > $videos_to_show ) :
					?>
				</div><!-- /.component-video-archive -->
				<?php
			endif; // endif ( have_posts( $posts_of_category ) ) :
		endforeach; // endforeach ( $video_categories as $video_category ) :
	endif; // endif ( $video_categories ) :
}