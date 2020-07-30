<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bolt-on
 */
// Start Inline Styles.
$styles = '';


get_header();
wp_enqueue_style( 'bolt-on-404-css' );


$bg_banner_src = get_template_directory_uri() . '/assets/images/404-page-image.jpg';
$styles .= bolt_on_add_inline_style(
	'#primary',
	array(
		'background-image' => 'url(' . $bg_banner_src . ')',
	)
);
?>

	<div id="primary" class="content-area">
		<main class="site-main" id="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<div class="big-404">404</div>
					<h1 class="page-title"><?php esc_html_e( 'Page Not Found.', 'bolt-on' ); ?></h1>
					<h2 class="page-sub-title"><?php esc_html_e( 'It looks like nothing was found at this Address. The URL may be misspelled, or the page may no longer be available.', 'bolt-on' ); ?></h2>
				</header><!-- .page-header -->

				<div class="page-content">
					<div class="row">
						<div class="col-xl-8 offset-xl-2">
							<div class="search">
								<?php get_search_form(); ?>
							</div>

							<!-- widget areas classes -->
							<div class="row">

								<div class="widget widget_404-left col-md-6">
									<?php dynamic_sidebar( 'error-404-left' ); ?>
								</div><!-- .widget- Left -->

								<div class="widget widget_404-right col-md-6">
									<?php dynamic_sidebar( 'error-404-right' ); ?>
								</div><!-- .widget- Right -->

							</div>
						</div>
					</div>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!--   /#main   -->
	</div> <!--   /#primary   -->
<?php

// Add Inline Styles
bolt_on_minify_css( $styles );

$inline_style = 'inline-404-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );

get_footer();
