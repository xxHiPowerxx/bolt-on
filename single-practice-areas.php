<?php
/**
 * The template for displaying all single Practice Areas posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bolt-on
 */

// Enqueue Styles
$single_practice_areas_css_path = '/assets/css/single-practice-areas.css';
wp_register_style(
	'single-practice-areas-css',
	get_theme_file_uri( $single_practice_areas_css_path ),
	array(
		'bolt-on-css',
	),
	filemtime( get_template_directory() . $single_practice_areas_css_path ),
	'all'
);
wp_enqueue_style( 'single-practice-areas-css' );
// Start Inline Styles.
$styles = '';

get_header();

$default_banner = get_template_directory_uri() . '/assets/images/Banners/banner.jpg';
$bg_banner_src  = get_the_post_thumbnail_url( null, 'full' ) ? : $default_banner;
$styles .= bolt_on_add_inline_style(
	'.bolt-on-banner:before',
	array(
		'background-image' => 'url(' . $bg_banner_src . ')',
	)
);

?>
<div id="primary" class="content-area bolt-on-banner">
	<main id="main" class="site-main">

		<!--   Intro Section   --->
		<section id="single-practice-areas-intro-section" class="intro-section bleeds-into-above-section">
			<div class="container container-ext container-single-practice-areas-intro-section bleed-target pad-onetwenty bg-white">
				<div class="row row-single-practice-areas-intro-section">
					<aside id="single-practice-areas-sidebar" class="left-sidebar col-4 pad-bottom">
						<?php
						// Get Dynamic Sidebar Nav.
						echo get_dynamic_sidebar_nav();

						$contact_form_title = 'Start Putting Your Life Back Together Today';
						$contact_form_atts = array(
							'contact_form_title' => $contact_form_title,
						);
						echo get_sidebar_contact($contact_form_atts);
						?>
					</aside>
					<div class="col-1"></div>
					<div id="post-content" class="col-7 theme-content">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', get_post_type() );
						endwhile; // End of the loop.
						?>
					</div><!-- /#post-content -->
				</div><!-- /.row-single-practice-areas-intro-section -->
			</div><!-- /.container-single-practice-areas-intro-section -->
		</section>
		<!--   /Intro Section   --->

		<?php
		$dynamic_post_menu_section_title = 'How We Can Help';
		$dynamic_post_menu_section_atts  = array(
			'section_title' => $dynamic_post_menu_section_title,
		);
		/*   Dynamic Post Menu Section   */
		echo get_dynamic_post_menu_section( $dynamic_post_menu_section_atts );
		/*   Dynamic Post Menu Section   */

		/*   Call to Action Section   */
		$call_to_action_section = wp_kses_post( get_field( 'call_to_action_section' ) );
		if ( $call_to_action_section ) :
			?>
			<!--   Call to Action Section   --->
			<section class="practice-areas-call-to-action-section bleeds-into-above-section">
				<div class="container container-ext practice-areas-call-to-action-section pad-onetwenty bleed-target bg-white">
					<div class="theme-content">
						<?php echo $call_to_action_section; ?>
					</div>
				</div>
			</section>
			<!--   /Call to Action Section   --->
			<?php
		endif; // endif ( $call_to_action_section ) :
		/*   /Call to Action Section   */
		
		/*   FAQ Section   */
		if ( have_rows( 'faqs_repeater' ) ) :
			$faqs_section_title    = esc_attr( get_field( 'faqs_section_title' ) );
			$faqs_section_subtitle = esc_attr( get_field( 'faqs_section_subtitle' ) );
			$faqs_section_image    = get_field( 'faqs_section_image' );
			$faqs_section_id       = 'FAQs';
			$faqs_layout_class     = null;
			?>
			<!--   FAQ Section   --->
			<section id="<?php echo $faqs_section_id; ?>" class="faq-section practice-areas-faq-section">
				<?php if ( $faqs_section_title || $faqs_section_subtitle ) : ?>
				<div class="container container-faq-section-header">
					<header class="section-header theme-header">
						<div class="theme-heading stroke-border">
							<div class="theme-heading-outer stroke-border-inner">
								<div class="theme-heading-inner stroke-border-lvl-three">
									<?php if ( $faqs_section_title ) : ?>
										<h2 class="theme-heading-title section-title bolt-on-h1"><?php echo $faqs_section_title; ?></h2>
									<?php endif; ?>
									<?php if ( $faqs_section_subtitle ) : ?>
										<h3 class="theme-heading-subtitle section-subtitle bolt-on-h2"><?php echo $faqs_section_subtitle; ?></h3>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</header>
				</div>
				<?php endif; // endif ( $faqs_section_title || $faqs_section_subtitle ) : ?>
				<div class="faq-section-lower">
					<div class="container container-faq-section-lower pad-top pad-bottom fraction-wrap">
						<?php
						if ( $faqs_section_image ) :
							$faqs_layout_class     = 'one-half';
							$faqs_section_image_id = $faqs_section_image['ID'];
							$size                  = array( 481, 481 );
							$faqs_image            = wp_get_attachment_image(
								$faqs_section_image_id,
								$size,
								false,
								array (
									'class' => 'card-style',
								)
							);
							?>
							<div class="ctnr-faqs-image <?php echo $faqs_layout_class; ?>">
								<?php echo $faqs_image; ?>
							</div>
						<?php endif; // endif ( $faqs_section_image ) : ?>
						<div class="ctnr-faqs-accordions <?php echo $faqs_layout_class; ?>">
							<?php
							while ( have_rows( 'faqs_repeater' ) ) :
								the_row();
								$faq_q_id     = $faqs_section_id . '-q-' . get_row_index();
								$faq_a_id     = $faqs_section_id . '-a-' . get_row_index();
								$faq_question = esc_attr( get_sub_field( 'faq_question' ) );
								$faq_answer   = esc_attr( get_sub_field( 'faq_answer' ) );
								if ( $faq_question && $faq_answer ) :
									?>
									<div class="faq-q-and-a">
										<div class="faq-q" data-toggle="collapse" aria-controls="<?php echo $faq_a_id; ?>" data-target="#<?php echo $faq_a_id; ?>" aria-expanded="false" aria-label="Toggle Answer" tabindex="0">
											<span class="faq-q-text"><?php echo $faq_question; ?></span>
											<span class="collapse-control-indicator fa fa-chevron-down"></span>
										</div>
										<div id="<?php echo $faq_a_id; ?>" class="faq-a collapse" aria-labelledby="<?php echo $faq_q_id; ?>" data-parent="#<?php echo $faqs_section_id; ?>" >
											<?php echo $faq_answer; ?>
										</div>
									</div>
									<?php
								endif; // endif ( $faq_question && $faq_answer ) :
							endwhile // endwhile ( have_rows( $faqs_repeater ) ) :
							?>
						</div><!-- /.ctnr-faqs-accordions -->
					</div><!-- .,container-faq-section-lower -->
				</div><!-- /.faq-section-lower -->
			</section>
			<!--   /FAQ Section   --->
			<?php
		endif; // endif ( have_rows( 'faqs_repeater' ) ) :
		/*   /FAQ Section   */

		?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// Add Inline Styles
$post_custom_css = esc_attr( get_field( 'post_custom_css' ) );
$styles .= $post_custom_css;

bolt_on_minify_css( $styles );

$inline_style = 'inline-single-practice-areas-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );

get_footer();
