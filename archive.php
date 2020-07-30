<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */



// Start Inline Styles.
$styles = '';

$bg_banner_src = get_the_post_thumbnail_url( get_queried_object()
, 'full' );
$styles .= bolt_on_add_inline_style(
	'.bolt-on-banner:before',
	array(
		'background-image' => 'url(' . $bg_banner_src . ')',
	)
);

get_header();
wp_enqueue_style( 'bolt-on-archive-css' );


?>
<div id="primary" class="content-area bolt-on-banner">
	<main id="main" class="site-main">

		<!--   Blog List Section   --->
		<section id="archive-list-section" class="archive-list-section bleeds-into-above-section">
			<div class="container container-ext container-archive-list-section bleed-target pad-onetwenty bg-white">
				<div class="row row-archive-list-section">
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
						// TODO: Create Settings Page for Site or for Blog Archive
						// and CMS this ACF.
						?>
						<header class="entry-header page-header">
							<h1 class="entry-title page-title"><?php the_archive_title(); ?></h1>
						</header>
						<?php
						if ( have_posts() ) :
							?>
							<div class="archive-list">
								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();

									/*
									* Include the Post-Type-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Type name) and that will be used instead.
									*/
									get_template_part( 'template-parts/content-archive', get_post_type() );

								endwhile;
								?>
							</div><!-- /.archive-list -->
							<?php
							the_posts_pagination(
								array(
									'prev_text'          => __( '<i class="fas fa-chevron-left"></i> Newer Posts', 'bolt-on' ),
									'next_text'          => __( 'Older Posts <i class="fas fa-chevron-right"></i>', 'bolt-on' ),
									'screen_reader_text' => __( 'Posts Navigation', 'bolt-on' ),
								)
							);
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

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;

		?>

	</main><!--   /#main   -->
</div> <!--   /#primary   -->

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
