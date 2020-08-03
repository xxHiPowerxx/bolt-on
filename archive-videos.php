<?php
/**
 * The template for displaying archive of Videos.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */

 // Enqueue Styles
$archive_videos_css_path = '/assets/css/archive-videos.css';
wp_register_style(
	'archive-videos-css',
	get_theme_file_uri( $archive_videos_css_path ),
	array(
		'bolt-on-css',
		'bolt-on-archive-css',
	),
	filemtime( get_template_directory() . $archive_videos_css_path ),
	'all'
);
wp_enqueue_style( 'archive-videos-css' );

// global $post;

get_header();

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<section id="archive-videos-intro-section" class="archive-videos-entry-section">
			<div class="container container-ext container-archive-videos-entry-section pad-onetwenty">
				<?php echo get_breadcrumbs(); ?>
				<header class="page-header">
					<h1 class="page-title"><?php echo get_bloginfo(); ?> Videos</h1>
				</header>
			</div><!-- /.container-archive-videos-intro-section -->
		</section>

		<!--   Archive Videos Section   --->
		<section id="archive-videos-section" class="archive-videos-section">
			<div class="container container-ext container-archive-videos-section pad-onetwenty">
				<?php
				// Videos Archive
				$args = array( 'videos_to_show' => 6 );
				echo get_video_archive( $args );
				?>
			</div><!-- /.container-archive-videos-section -->
		</section>
		<!--   /Archive Videos Section   --->

		<?php
		/*   Contact Section   */
		echo get_contact_section();
		/*   Contact Section   */
		?>
	</main><!--   /#main   -->
</div> <!--   /#primary   -->

<?php

get_footer();