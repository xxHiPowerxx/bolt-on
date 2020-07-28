<?php
/**
 * Template part for displaying archive Video posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bolt-on
 */

// Enqueue Styles
$content_archive_video_css_path = '/assets/css/content-archive-video.css';
wp_register_style(
	'content-archive-video-css',
	get_theme_file_uri( $content_archive_video_css_path ),
	array(
		'bolt-on-css',
		'content-archive-css',
		'bolt-on-vendor-fancybox-css',
	),
	filemtime( get_template_directory() . $content_archive_video_css_path ),
	'all'
);
wp_enqueue_style( 'content-archive-video-css' );

// Enqueue Scripts
wp_enqueue_script( 'bolt-on-vendor-fancybox-js' );



$post_title        = get_the_title();
$video_description = esc_attr( get_field( 'video_description' ) );
// TODO: Set this width in a global Settings Page.
$video_width       = 773;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'listed-archive content-area display-flex' ); ?>>
	<div class="listed-archive-inner">
		<?php if ( have_rows( 'video_source' ) ) : ?>
			<div class="ctnr-video">
			<?php
			while ( have_rows('video_source') ) :
				the_row();
				if ( get_row_index() === 1 ) :
					$video_url = null;
					// External Source
					if ( get_row_layout() === 'external_source' ) :
						$video_url = esc_url( get_sub_field( 'url' ) );
						if ( $video_url ) :
							// $youtube_id = bolt_on_get_youtube_video_id( $video_url );
							// $video_img  = 'https://img.youtube.com/vi/' . $youtube_id . '/hqdefault.jpg';
							$video_img = bolt_on_get_video_thumbnail( $video_url );
							$video_class_name = 'external';
						endif; // endif ( $external_video ) :
					endif; // endif ( get_row_layout() === 'external_source' ) :

					// From Media
					if ( get_row_layout() === 'media' ) :
						$video_array = get_sub_field('video');
						if ( $video_array ) :
							$video_url = esc_url( $video_array['url'] );
							// $video_img = bolt_on_get_video_thumbnail( $video_url );
							$video_img = get_the_post_thumbnail_url( $video_array['id'] );
						endif; // endif ( $video_array ) :
					endif; // endif ( get_row_layout() === 'media' ) :

					if ( $video_url ) :
						?>
						<div class="external-video">
							<a class="anchor-archive-video theme-style-border" data-fancybox="" href="<?php echo $video_url; ?>">
								<div class="anchor-archive-video-inner">
									<img class="archive-video-thumbnail" src="<?php echo $video_img; ?>" />
								</div>
							</a>
						</div>
						<?php
					endif;

				endif; // endif ( get_row_index() === 1 ) :
			endwhile; // endwhile ( have_rows('content') ) :
			?>
			</div>
		<?php endif; // endif( have_rows( 'video_source' ) ) : ?>

		<div class="post-body display-flex flex-column theme-content">

			<header class="entry-header">
				<h4 class="entry-title"><?php echo $post_title; ?></h4>
			</header><!-- .entry-header -->

			<?php if ( $video_description ) : ?>
				<div class="entry-content">
					<p class="video-description"><?php echo $video_description; ?></p>
				</div><!-- .entry-content -->
			<?php endif; ?>

			<footer class="entry-footer bolt-on-highlight-font">
				<div class="cat-link-container display-flex flex-row justify-content-between">
					<div class="post-category">
						<?php bolt_on_post_categories(); ?>
					</div>
					<a class="anchor-btn-cta btn-cta-outer stroke-border has-chevron post-link" href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" title="<?php echo get_the_title(); ?>">
						<span class="btn-cta btn-cta-inner stroke-border-inner">
							<span class="btn-cta-text stroke-border-lvl-three">Go To Video</span>
						</span>
					</a>
					<?php
					// TODO: Use the above CTA Button in child theme.
					/* <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" title="<?php echo get_the_title(); ?>" class="post-link bolt-on-theme-color-bg material-btn"><i class="fas fa-arrow-right"></i><span class="hide-me">Read More</span></a> */
					?>
				</div>
				<?php
				bolt_on_edit_post_link();
				?>
			</footer><!-- .entry-footer -->

		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
