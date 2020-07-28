<?php
/**
 * This Component Renders the Video Archive.
 * 
 * @param int $videos_to_show - Number of Videos to Show.
 * 
 * @package bolt-on
 */
function component_video_archive( $videos_to_show = -1 ) {
	global $post;
	if ( ! $post ) :
		return;
	endif;
	// TODO: Determine if is single video or post archive page.
	$post_type        = get_post_type();
	$video_categories = get_the_terms($post, 'video-category');
	if ( $video_categories ) :
		foreach ( $video_categories as $video_category ) :
			$video_category_id   = $video_category->term_id;
			$video_category_name = esc_attr( $video_category->name );
			$video_category_slug = $video_category->slug;
			$get_posts_args      = array(
				'post_type'      => $post_type,
				'numberposts'    => $videos_to_show,
				'video-category' => $video_category_slug,
				'post__not_in'   => array($post->ID ),
			);
			$posts_of_category   = new WP_Query( $get_posts_args );
			if ( $posts_of_category->have_posts() ) :
				?>
				<div class="component-video-archive">
					<header class="section-header theme-header">
						<div class="theme-heading stroke-border">
							<div class="theme-heading-outer stroke-border-inner">
								<div class="theme-heading-inner stroke-border-lvl-three">
									<h2 class="theme-heading-title section-title bolt-on-h1">
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
				</div><!-- /.component-video-archive -->
				<?php
			endif; // endif ( have_posts( $posts_of_category ) ) :
		endforeach; // endforeach ( $video_categories as $video_category ) :
	endif; // endif ( $video_categories ) :
}