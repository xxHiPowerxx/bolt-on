<?php
/**
 * Template part for displaying Video posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */

// Post Title may have already been defined.
global $post_title;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php $page_header_class = is_single() ? ' page-header' : null; ?>
	<header class="entry-header theme-style-border <?php echo $page_header_class; ?>">
		<?php
		$post_title        = $post_title ? : get_the_title();
		$video_description = esc_attr( get_field( 'video_description' ) );
		// TODO: Set this width in a global Settings Page.
		$video_width       = 773;
		?>
		<h1 class="page-title entry-title"><?php echo $post_title; ?></h1>
		<?php if ( $video_description ) : ?>
			<p class="video-description"><?php echo $video_description; ?></p>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		// TODO: place this in a function so that it is not repeated in content-archive-video.php
		if ( have_rows( 'video_source' ) ) :
		?>
			<div id="featured-video" class="ctnr-video">
			<?php
			while ( have_rows('video_source') ) :
				the_row();
				if ( get_row_index() === 1 ) :
					$video = null;
					// External Source
					if ( get_row_layout() === 'external_source' ) :
						$external_video = esc_url( get_sub_field( 'url' ) );
						ob_start();
						if ( $external_video ) :
							$embed = wp_oembed_get( $external_video, array( 'width' => $video_width ) );
							?>
							<div class="external-video">
								<?php echo $embed; ?>
							</div>
							<?php
							$video = ob_get_clean();
						endif; // endif ( $external_video ) :
					endif; // endif ( get_row_layout() === 'external_source' ) :

					// From Media
					if ( get_row_layout() === 'media' ) :
						$video_array = get_sub_field('video');
						ob_start();
						if ( $video_array ) :
							$video_src   = esc_url( $video_array['url'] );
							$_video_width = $video_array['width'];
							$max_width   = $video_width;
							$_video_width = $_video_width > $max_width ? $max_width : $_video_width;
							?>
							<div class="internal-video">
								<video class="bolt-on-video" disableremoteplayback="" webkit-playsinline="" playsinline="" controls="" src="<?php echo $video_src; ?>" width="<?php echo $_video_width; ?>"></video>
							</div>
							<?php
							$video = ob_get_clean();
						endif; // endif ( $video_array ) :
					endif; // endif ( get_row_layout() === 'media' ) :

					if ( $video ) :
						echo $video;
					endif;

				endif; // endif ( get_row_index() === 1 ) :
			endwhile; // endwhile ( have_rows('content') ) :
			?>
			</div>
		<?php endif; // endif( have_rows( 'video_source' ) ) : ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
