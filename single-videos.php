<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bolt-on
 */

// Enqueue Styles
$single_videos_css_path = '/assets/css/single-videos.css';
wp_register_style(
	'single-videos-css',
	get_theme_file_uri( $single_videos_css_path ),
	array(
		'bolt-on-css',
	),
	filemtime( get_template_directory() . $single_videos_css_path ),
	'all'
);
wp_enqueue_style( 'single-videos-css' );

global $post;

get_header();

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<!--   Single Videos Section   --->
		<section id="single-videos-entry-section" class="single-videos-entry-section">
			<div class="container-fluid container-xxl container-ext container-single-videos-entry-section pad-onetwenty">
				<?php echo get_breadcrumbs(); ?>
				<div id="post-content" class="theme-content">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile; // End of the loop.
					?>
				</div><!-- /#single-videos-entry-section -->
			</div><!-- /.container-single-videos-intro-section -->
		</section>
		<!--   /Single Videos Section   --->

		<!--   Related Videos Section   --->
		<?php
		$args          = array( 'videos_to_show' => 6 );
		$video_archive = get_video_archive( $args );
		if ( $video_archive !== null) :
			?>
			<section id="related-videos-section" class="related-videos-section">
				<div class="container-fluid container-xxl container-ext container-related-videos-section pad-onetwenty">
					<?php echo $video_archive; ?>
				</div><!-- /.container-related-videos-section -->
			</section>
			<!--   /Related Videos Section   --->
		<?php
		endif; // endif ( $video_archive ) :

		/*   Contact Section   */
		echo get_contact_section();
		/*   Contact Section   */
		?>
	</main><!--   /#main   -->
</div> <!--   /#primary   -->

<?php

get_footer();
