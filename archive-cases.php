<?php
/**
 * The template for displaying archive of Cases.
 * 
 * TODO: Move this into a page template so that Content can be editable through CMS
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */

// Enqueue Styles
$archive_cases_css_path = '/assets/css/archive-cases.css';
wp_register_style(
	'archive-cases-css',
	get_theme_file_uri( $archive_cases_css_path ),
	array(
		'bolt-on-css',
	),
	filemtime( get_template_directory() . $archive_cases_css_path ),
	'all'
);
wp_enqueue_style( 'archive-cases-css' );
$styles = '';

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

		<!--   Intro Section   --->
		<section id="cases-archive-intro-section" class="intro-section bleeds-into-above-section bleeds-into-below-section">
			<div class="container container-ext container-cases-archive-intro-section bleed-target pad-onetwenty bg-white">
				<header class="page-header">
					<h1 class="page-title">Case Results</h1>
					<h2 class="page-subtitle">Notable Victories Secured by Our Attorneys</h2>
				</header><!-- /.page-header -->
				<div class="intro-section-description theme-content">
					<p>One of the most important questions for a potential client to ask when selecting a law firm is, “What is their history of success and what have they been able to recover for their clients?” McCune Wright Arevalo, LLP has an outstanding group of experienced attorneys who are responsible for hundreds of millions of dollars in verdicts and settlements in complex litigation cases. Our lawyers have secured significant recoveries across our practice areas, in the Inland Empire and throughout the surrounding regions. We are standing by to see how we can help you.</p>
				</div><!-- /.intro-section-description -->
			</div><!-- /.container-cases-archive-intro-section -->
		</section>
		<!--   /Intro Section   --->
		
		<?php
		$queried_object = get_queried_object();
		$post_type      = $queried_object->name;
	
		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'meta_key'       => 'case_result_number',
			'orderby'        => 'meta_value_num',
		);
		$post_query = new WP_Query($args);
		
		if( $post_query->have_posts() ) :
			?>
			<!--   Cases Archive Section   --->
			<section id="cases-archive-section" class="pad-top pad-bottom">
				<div class="container container-ext container-cases-archive-section">
					<?php
					while ( $post_query->have_posts() ) :
						$post_query->the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					?>
				</div><!-- /.container-cases-archive-section -->
			</section>
			<!--   /Cases Archive Section   --->
			<?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; // endif ( $post_query->have_posts() ) :
		?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
// Add Inline Styles
$inline_style = 'inline-archive-cases-css';
wp_register_style( $inline_style, false );
wp_enqueue_style( $inline_style );
wp_add_inline_style( $inline_style, $styles );

get_footer();
