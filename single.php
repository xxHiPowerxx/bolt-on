<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bolt-on
 */

// Enqueue Styles
$single_css_path = '/assets/css/single.css';
wp_register_style(
	'single-css',
	get_theme_file_uri( $single_css_path ),
	array(
		'bolt-on-css',
	),
	filemtime( get_template_directory() . $single_css_path ),
	'all'
);
wp_enqueue_style( 'single-css' );

// Start Inline Styles.
$styles = '';

if ( has_post_thumbnail() ) :
	$bg_banner_src = get_the_post_thumbnail_url( get_queried_object()
	, array(1920, null) );
	$styles .= bolt_on_add_inline_style(
		'.bolt-on-banner:before',
		array(
			'background-image' => 'url(' . $bg_banner_src . ')',
		)
	);
endif;

get_header();

?>
<div id="primary" class="content-area bolt-on-banner">
	<main id="main" class="site-main">

		<!--   Blog List Section   --->
		<section id="single-entry-section" class="single-entry-section bleeds-into-above-section">
			<div class="container container-ext container-single-entry-section bleed-target pad-onetwenty bg-white">
				<div class="row row-single-entry-section">
					<aside id="archive-sidebar" class="left-sidebar col-3">
						<?php
						// Get Categories Sidebar Nav.
						echo get_dynamic_sidebar_nav( 'categories' );
						echo get_dynamic_sidebar_nav( 'archives' );
						?>
					</aside>
					<div class="col-1"></div>
					<div id="post-content" class="col-8 theme-content">
						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );

							bolt_on_post_navigation();

						endwhile; // End of the loop.
						?>
					</div><!-- /#post-content -->
				</div><!-- /.row-archive-intro-section -->
			</div><!-- /.container-archive-intro-section -->
		</section>
		<!--   /Blog List Section   --->

		<?php

		/*   Contact Section   */
		echo get_contact_section();
		/*   Contact Section   */
	?>
</main><!-- #primary -->
</div> <!-- end column -->

<?php

// Add Inline Styles
$post_custom_css = esc_attr( get_field( 'post_custom_css' ) );
$styles .= $post_custom_css;

bolt_on_minify_css( $styles );

$inline_style = 'inline-archive-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );

get_footer();
