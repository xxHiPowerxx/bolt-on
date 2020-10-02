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

$styles .= bolt_on_banner( $styles );

get_header();

?>
<div id="primary" class="content-area bolt-on-banner">
	<main id="main" class="site-main">

		<!--   Blog List Section   --->
		<section id="single-entry-section" class="single-entry-section bleeds-into-above-section">
			<div class="container-fluid container-xxl container-ext container-single-entry-section bleed-target pad-onetwenty bg-white">
				<div class="row row-single-entry-section">
					<aside id="archive-sidebar" class="left-sidebar col-xxl-3 col-xl-4 col-12 pad-bottom order-3 order-xl-1">
						<?php
						// Get Categories Sidebar Nav.
						echo get_dynamic_sidebar_nav( 'categories' );
						echo get_dynamic_sidebar_nav( 'archives' );
						?>
					</aside>
					<div class="col-1 d-xxl-block d-none order-2"></div>
					<div id="post-content" class="col-xl-8 col-12 order-1 order-xl-3 theme-content pad-bottom">
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
	</main><!--   /#main   -->
</div> <!--   /#primary   -->

<?php

// Add Inline Styles
$post_custom_css = esc_attr( get_field( 'post_custom_css' ) );
$styles .= $post_custom_css;

bolt_on_minify_css( $styles );

$inline_style = 'inline-single-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );

get_footer();
