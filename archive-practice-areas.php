<?php
/**
 * The template for displaying archive of Parent Level Practice Areas.
 * 
 * TODO: Move this into a page template so that Content can be editable through CMS
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */

// Enqueue Styles
$archive_practice_areas_css_path = '/assets/css/archive-practice-areas.css';
wp_register_style(
	'archive-practice-areas-css',
	get_theme_file_uri( $archive_practice_areas_css_path ),
	array(
		'bolt-on-css',
	),
	filemtime( get_template_directory() . $archive_practice_areas_css_path ),
	'all'
);
wp_enqueue_style( 'archive-practice-areas-css' );
$styles = '';

// Enqueue Scripts
$js_handle          = 'image-swap-js'; 
$image_swap_js_path = '/assets/js/image-swap.js';
wp_enqueue_script(
	$js_handle, 
	get_theme_file_uri( $image_swap_js_path ),
	array(
		'jquery',
	),
	filemtime( get_template_directory() . $image_swap_js_path ),
	true
);

get_header();

// Start Inline Styles.
// TODO: Set this bg-image through CMS.
// When this page becomes a page template, use the Featured Image
$bg_banner_src = 'url(' . get_template_directory_uri() . '/assets/images/sub-banner.jpg' . ')';
$styles .= bolt_on_add_inline_style(
	'.bolt-on-banner:before',
	array(
		'background-image' => $bg_banner_src,
	)
);
?>

<div id="primary" class="content-area bolt-on-banner">
	<main id="main" class="site-main">
		<?php
		$queried_object = get_queried_object();
		$post_type      = $queried_object->name;
		$post_type_name = esc_attr( $queried_object->label );

		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'post_parent'    => 0,
			'orderby'        => array(
				'menu_order',
				'date'
			),
			'order'          => 'ASC'
		);
		$post_query = new WP_Query($args);
		if( $post_query->have_posts() ) :
			?>
			<!--   Intro Section   --->
			<section id="practice-areas-archive-intro-section" class="intro-section bleeds-into-above-section">
				<div class="container-fluid container-xl container-ext container-practice-areas-archive-intro-section bleed-target pad-onetwenty bg-white">
					<div class="row row-practice-areas-archive-intro-section">
						<aside id="practice-areas-sidebar" class="left-sidebar col-xxl-3 col-lg-4 col-12 pad-bottom">
							<h3 class="sidebar-heading"><?php echo $post_type_name; ?></h3>
							<?php dynamic_sidebar( 'practice-areas-archive-sidebar' ); ?>
						</aside>
						<div class="col-1 d-xxl-block d-none"></div>
						<div class="col-lg-8 col-12 theme-content">
							<header class="page-header">
								<h1 class="page-title">Practice Areas</h1>
								<h2 class="page-subtitle">Restoring Hope Through Justice Across the Inland Empire</h2>
							</header><!-- /.page-header -->
							<div class="intro-section-description theme-content">
								<p><a href="/attorneys/">McCune Wright Arevalo, LLP's</a> practice is concentrated in the representation of plaintiffs in complex litigation. Our firm’s primary practice areas are:</p>
								<ul>
									<li><a href="/class-actions/">Class Actions</a></li>
									<li><a href="/commercial-litigation/">Commercial Litigation</a></li>
									<li><a href="/medical-devices-pharmaceuticals/">Defective medical devices and pharmaceuticals</a></li>
									<li><a href="/nursing-home-elder-abuse/">Nursing Home & Elder Abuse</a></li>
									<li><a href="/personal-injury/">Personal injury</a></li>
									<li><a href="/product-liability/">Product liability</a></li>
									<li><a href="/personal-injury/wrongful-death/">Wrongful death</a></li>
								</ul>
								<h3>Over $1 Billion in Verdicts & Settlements</h3>
								<p>Our lawyers accomplish this through our hard work and our commitment to seeing wrongs righted. With numerous multimillion-dollar <a href="/results">verdicts and settlements</a>, we have recovered over $1 Billion on behalf of our clients through our years in practice. We are regularly featured on major news outlets and have experience fighting Fortune 500 companies to protect the “little guy” – consumers, the injured, and businesses who have been wronged.</p>
								<h3>Put Our Powerful Attorneys on Your Side</h3>
								<img class="float-right" src="<?php echo get_template_directory_uri(); ?>/assets/images/content-img[2].jpg" />
								<p>The pursuit of civil justice is no easy task, but this has been our focus for the past 30 years. McCune Wright Arevalo, LLP helps clients across the Inland Empire and California and throughout the country.</p>
								<p>In addition to delivering the skilled legal representation you need, we never sacrifice personalized service. When you come to our firm, <b>you will be treated as a real person, not a case number</b>. We are prepared to negotiate or litigate on your behalf to recoup your losses and help you face a more stable future.</p>
								<p class="text-highlight v-1">
									<span>
										<b>There is no opponent too formidable for our powerful team of attorneys. Find out how we can help you by calling <span style="display:inline-block;"><?php echo get_site_phone_number_func(); ?></span> for a free, <a href="/contact-us/">confidential case evaluation</a>.</b>
									</span>
								</p>
							</div><!-- /.intro-section-description -->
						</div>
					</div><!-- /.row-practice-areas-archive-intro-section -->
				</div><!-- /.container-practice-areas-archive-intro-section -->
			</section>
			<!--   /Intro Section   --->

			<!--   Listed Practice Areas Section   --->
			<section id="listed-practice-areas-section">
				<div class="container-fluid container-xl container-ext container-listed-practice-areas-header pad-onetwenty">
					<header class="section-header theme-header">
						<div class="theme-heading stroke-border">
							<div class="theme-heading-outer stroke-border-inner">
								<div class="theme-heading-inner stroke-border-lvl-three">
									<h2 class="theme-heading-title section-title bolt-on-h1">How We Can Help</h2>
								</div>
							</div>
						</div>
					</header>
				</div>
				<div id="practice-areas-image-swap" class="bg-image-swap bgImageSwap">
					<div class="container-fluid container-xl container-ext container-listed-practice-areas-image-swap pad-onetwenty">
						<div class="practice-areas-list">
							<?php
							$practice_area_index = 0;
							$first_featured_image_url;
							// Start The Loop.
							while ( $post_query->have_posts() ) :
								$post_query->the_post();
								$post_link         = esc_url( get_the_permalink() );
								$post_title        = esc_attr( get_the_title() );

								if ( strtolower( html_entity_decode( $post_title ) ) === strtolower( 'Government Unfair & Deceptive Acts & Practices Civil Penalties' ) ) :
									$post_title = 'Government UDAP Civil Penalties';
								endif;
								$bg_image_swap_url = esc_url( get_the_post_thumbnail_url() );
								?>
								<a class="listed-practice-area line-left bgImageSwapController" href="<?php echo $post_link; ?>" data-bg-image-swap-url="<?php echo $bg_image_swap_url; ?>"><?php echo $post_title; ?></a>
								<?php
								if ( $practice_area_index === 0 && $bg_image_swap_url ) :
									$first_featured_image_url = $bg_image_swap_url;
								endif;
								$practice_area_index++;
							endwhile; // endwhile ( $post_query->have_posts() ) :
							?>
						</div><!-- /.practice-areas-list -->
						<div class="bg-image-swap-tar bgImageSwapTar" style='background-image:url(<?php echo $first_featured_image_url; ?>);'></div>
					</div><!-- /.container-listed-practice-areas-image-swap -->
				</div><!-- /#practice-areas-image-swap -->
			</section>
			<!--   /Listed Practice Areas Section   --->

			<?php

			echo get_contact_section();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; // endif ( $post_query->have_posts() ) :
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
// Add Inline Styles
$inline_style = 'inline-archive-practice-areas-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );

get_footer();
