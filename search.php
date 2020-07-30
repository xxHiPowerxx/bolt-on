<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package bolt-on
 */

// Start Inline Styles.
$styles = '';


get_header();
wp_enqueue_style( 'bolt-on-search-css' );
wp_enqueue_style( 'bolt-on-archive-css' );

$bg_banner_src = 'url(' . get_template_directory_uri() . '/assets/images/sub-banner.jpg' . ')';
$styles .= bolt_on_add_inline_style(
	'.bolt-on-banner:before',
	array(
		'background-image' => $bg_banner_src,
	)
);

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main bolt-on-banner">
		<div class="container container-ext pad-onetwenty main-container">
			<div class="row main-row">
				<div class="col-12 col-md-8 mx-auto search-wrapper">
					<?php
					if ( have_posts() ) :

						/* Display the appropriate header when required. */
						$allsearch = new WP_Query( "s=$s&showposts=-1" );
						$count     = $allsearch->post_count;
						/**
						 * Wrap Search Term in span with yellow background color.
						 *
						 * @param string $string the full string that has the search term inside.
						 * @param string $search_word the actual search term.
						 */
						function search_term( $string, $search_word ) {
							$wrap_before = '<span class="yellow bold">';
							$wrap_after  = '</span>';
							echo wp_kses_post( preg_replace( "/($search_word)/i", "$wrap_before$1$wrap_after", $string ) );
						}
						?>
						<header class="section-header theme-header">
							<div class="theme-heading stroke-border">
								<div class="theme-heading-outer stroke-border-inner">
									<div class="theme-heading-inner stroke-border-lvl-three">
										<h1 class="theme-heading-title section-title">Search Our Site.</h1>
									</div>
								</div>
							</div>
						</header>
						<?php get_search_form(); ?>
						<h4 class="result-count"><?php echo esc_html( $count ); ?> results</h4>
						<?php

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						bootstrap_pagination();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
				</div><!-- /.search-wrapper -->
			</div><!-- /.main-row -->
		</div><!-- /.main-container -->
	</main><!-- #main -->
</div><!-- #primary -->

<?php
// Add Inline Styles
bolt_on_minify_css( $styles );

$inline_style = 'inline-search-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );

get_footer();

