<?php
/**
 * The template for displaying archive of Attorneys.
 * 
 * TODO: Move this into a page template so that Content can be editable through CMS
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */

// Enqueue Styles
$single_attorneys_css_path = '/assets/css/archive-attorneys.css';
wp_register_style(
	'archive-attorneys-css',
	get_theme_file_uri( $single_attorneys_css_path ),
	array(
		'bolt-on-css',
	),
	filemtime( get_template_directory() . $single_attorneys_css_path ),
	'all'
);
wp_enqueue_style( 'archive-attorneys-css' );
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
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main bolt-on-banner">

	<?php
	$queried_object = get_queried_object();
	$post_type      = $queried_object->name;

	/* TODO: Use this query with Page Template.
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC'
	);
	$post_query = new WP_Query($args);
	*/

	global $wp_query;
	$post_query = $wp_query;
	if( $post_query->have_posts() ) :
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
		<!--   Intro Section   --->
		<section id="attorneys-archive-intro-section" class="intro-section bleeds-into-above-section">
			<div class="container container-ext container-attorneys-archive-intro-section bleed-target pad-onetwenty bg-white">
				<header class="page-header">
					<h1 class="page-title">Our Attorneys</h1>
					<h2 class="page-subtitle">Committed to Helping Our Clients Achieve Justice</h2>
				</header><!-- /.page-header -->
				<div class="intro-section-description theme-content">
					<p>Competence, commitment, and compassion. These are the forces that drive the attorneys at McCune Wright Arevalo, LLP to success in representing clients in the Inland Empire and throughout the country.</p>
					<p>It takes an attorney who is not only knowledgeable and experienced, but who understands what you are going through and will do what it takes to pursue the best possible outcome on your behalf, no matter the odds. That is the level of counsel provided by our attorneys at McCune Wright Arevalo, LLP.</p>
					<p>For over 30 years, we have served the good people of the Inland Empire area in all areas of complex litigation matter. We have fought for the injured and for those who have lost loved ones due to negligence and wrongdoing. We have gone up against Fortune 500 companies – and won. We have built a well-earned reputation as a significant member of the legal community and have obtained very large verdicts, including a $203 million verdict against Wells Fargo, and settlements and recovered over $1 billion for our clients. Our attorneys are known for getting results.</p>
					<p><b>Find out more about our attorneys by reviewing their profiles, or give us a call at (909) 345-8110 for your free case evaluation. We look forward to helping you.</b></p>
				</div><!-- /.intro-section-description -->
			</div><!-- /.container-attorneys-archive-intro-section -->
		</section>
		<!--   /Intro Section   --->
		<?php
		$bg_att_archive_image_swap = 'url(' . get_template_directory_uri() . '/assets/images/attorneys-bg-full.jpg' . ')';
		$styles .= bolt_on_add_inline_style(
			'#attorneys-archive-image-swap-section',
			array(
				'background-image' => $bg_att_archive_image_swap,
			)
		);
		?>
		<!--   Attorneys Archive Image Swap Section   --->
		<section id="attorneys-archive-image-swap-section">
			<div class="container-fluid container-xxl container-ext pad-onetwenty container-attorneys-archive-image-swap-section">
				<header class="section-header theme-header">
					<div class="theme-heading stroke-border contrast-for-dark-bg">
						<div class="theme-heading-outer stroke-border-inner">
							<div class="theme-heading-inner stroke-border-lvl-three">
								<h2 class="theme-heading-title section-title bolt-on-h1">
									Our Attorneys
								</h2>
								<h3 class="theme-heading-subtitle section-subtitle bolt-on-h2 nowrap-parent">
									<span>Experience. Recognition.</span>
									<span>Service. Reputation.</span>
								</h3>
							</div>
						</div>
					</div>
				</header>
				<div id="attorneys-archive-image-swap" class="image-swap imageSwap">
					<div class="image-swap-controls attorneys-list">
						<?php
						// Start Array for Attorney Images.
						$attorney_data = array();
						while ( $post_query->have_posts() ) :
							$post_query->the_post();
							$attorney_full_name         = get_the_title();
							$attorney_stripped_name     = str_replace( '.', '', $attorney_full_name );
							$attorney_post_id           = get_the_id();
							$attorney_id                = 'archive-attorney-' . strtolower( str_replace(' ', '-', $attorney_stripped_name) );
							
							$attorney_title             = esc_attr( get_field( 'attorney_title' ) );
							$attorney_permalink         = get_permalink();
							$attorneys_isolated_picture = get_field( 'attorneys_isolated_picture' );
							$attorney_pic               = wp_get_attachment_image(
								$attorneys_isolated_picture['id'],
								array(null, 640),
								false,
								array(
									'class'            => 'image-swap-img',
									'data-attorney-id' => $attorney_id,
								)
							);
							?>
							<div id="<?php echo $attorney_id; ?>" data-post-id="<?php echo $attorney_post_id; ?>" class="listed-attorney imageSwapController">
								<a href="<?php echo $attorney_permalink; ?>" class="anchor-attorney line-left">
									<span class="archive-attorney-name"><?php echo $attorney_full_name; ?></span>
								</a>
							</div><!--  ./archive-attorney-<?php echo $attorney_id; ?> -->
							<?php
							// Store Image in $attorney_data[].
							$this_attorney_data = array(
								'attorney_pic'       => $attorney_pic,
								'attorney_full_name' => $attorney_full_name,
								'attorney_title'     => $attorney_title,
								'attorney_id'        => $attorney_id,
							);
							array_push($attorney_data, $this_attorney_data);
						endwhile; // endwhile ( $post_query->have_posts() ) :
						?>
					</div><!-- /.attorneys-list -->
					<?php if ( ! empty( $attorney_data ) ) : ?>
						<div class="image-swap-imgs attorneys-images">
							<?php
							foreach ( $attorney_data as $key => $_attorney_data ) :
								$first_image        = null;
								$attorney_pic       = $_attorney_data['attorney_pic'];
								$attorney_full_name = $_attorney_data['attorney_full_name'];
								$attorney_title     = $_attorney_data['attorney_title'];
								$attorney_id        = $_attorney_data['attorney_id'];
								reset($attorney_data);
								if ( $key === key($attorney_data) ) :
									$first_image      = ' show';
								endif;
								?>
								<div class="ctnr-image-swap-img imageSwapTar<?php echo $first_image; ?>" data-image-swap-controller="<?php echo $attorney_id; ?>">
									<div class="ctnr-archive-attorney-img">
										<?php echo $attorney_pic; ?>
									</div>
									<div class="ctnr-archive-attorney-name-title">
										<div class="archive-attorney-name"><?php echo $attorney_full_name; ?></div>
										<div class="archive-attorney-title"><?php echo $attorney_title; ?></div>
									</div>
								</div>
								<?php
							endforeach; 
							?>
						</div>
					<?php endif; // endif ( ! empty( $attorney_images ) ) : ?>
				</div><!-- /#attorneys-archive-image-swap -->
			</div><!-- /.container-attorneys-archive-image-swap-section -->
		</section>
		<!--   /Attorneys Archive Image Swap Section   --->
		<!--   #Making-A-Siginificant-Difference   --->
		<section id="Making-A-Siginificant-Difference" class="blurb-section">
			<div class="container container-ext pad-onetwenty">
				<div class="theme-content">
					<h2>Making a Significant Difference for Our Clients & Community</h2>
					<p>Your consultation with a lawyer at McCune Wright Arevalo, LLP is free and confidential. You have so much to gain and nothing to lose by discussing your case with one of our team members. We will take the time to listen to you, to hear your story, and to offer insight regarding your options and rights at this crucial juncture. If we take on your case, you pay nothing unless we secure a settlement or award on your behalf.</p>
					<p>With considerable experience handling class actions, dangerous product cases, and the most complex injury claims, our lawyers have the trials skill necessary to protect your interests in civil court. Our firm has the resources and personnel to take on any opponent, in the name of justice.</p>
				</div>
			</div>
		</section>
		<!--   /#Making-A-Siginificant-Difference   --->
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
$inline_style = 'inline-archive-attorneys-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );
get_footer();
