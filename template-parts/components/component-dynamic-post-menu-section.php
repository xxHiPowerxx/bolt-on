<?php
/**
 * Section that Displays a Case Result 
 * and a Dynamically Generated Menu with Only the Second Level
 * Children as Menu Items.
 * 
 * @param array $args can use $args['section_title']
 * to override the dynamically Generated Title.
 * Also an empty string can be used to remove it.
 * 
 * @package bolt-on
 */
function component_dynamic_post_menu_section( $args ) {

	// Enqueue Component Stylesheet.
	$dynamic_post_menu_section_css_path = '/assets/css/dynamic-post-menu-section.css';
	wp_register_style(
		'dynamic-post-menu-section-css',
		get_theme_file_uri( $dynamic_post_menu_section_css_path ),
		array(
			'bolt-on-css',
		),
		filemtime( get_template_directory() . $dynamic_post_menu_section_css_path ),
		'all'
	);
	wp_enqueue_style( 'dynamic-post-menu-section-css' );

	// Get Dynamic Post Menu.
	$dynamic_post_menu_args  = array(
		'child_level' => 0,
	);
	$dynamic_post_menu_array = get_dynamic_post_menu( $dynamic_post_menu_args );
	if (
		isset( $dynamic_post_menu_array['markup'] ) &&
		! $dynamic_post_menu_array['markup']
	) :
		return;
	endif;
	
	$section_title     = $args['section_title'] ? :
		$dynamic_post_menu_array['last_ancestor_title'];
	$section_title     = esc_attr( $section_title );
	$dynamic_post_menu = $dynamic_post_menu_array['markup'];

	// Get highest level Case of This Practice Area.
	global $post;
	// Current Post Class defaults to null.
	$post_ancestors = get_post_ancestors( $post );
	if ( $post_ancestors ) :
		$last_ancestor      = get_post( end( $post_ancestors ) );
		$last_ancestor_link = get_the_permalink( $last_ancestor );
	else :
		$last_ancestor      = $post;
		$last_ancestor_link = '#';
	endif;

	// Get First Case WHERE _case_practice_area_id is EQUAL TO Highest Parent Practice Area
	$greatest_case_result_args = array(
		'posts_per_page' => 1,
		'post_type'      => 'cases',
		'meta_query'     => array(
			'case_result_number',
			array (
				'key' => '_case_practice_area_id',
				'value' => $last_ancestor->ID,
			)
		),
		'meta_key'       => 'case_result_number',
		'orderby'        => 'meta_value_num',
	);
	$greatest_case_result = get_posts( $greatest_case_result_args );

	ob_start();
	?>
	<!--   Dynamic Post Menu Section   -->
	<section class="dynamic-post-menu-section pad-bottom">
		<div class="container-fluid container-sm container-ext container-dynamic-post-menu-section pad-onetwenty bleed-target">
			<?php
			if ( ! empty( $greatest_case_result ) ) :
				$greatest_case_result_id  = esc_attr( $greatest_case_result[0]->ID );
				$case_title               = esc_attr( $greatest_case_result[0]->post_title );
				$case_result              = esc_attr( get_field(
					'case_result',
					$greatest_case_result_id
				) );
				$case_practice_area_title = esc_attr( $last_ancestor->post_title );
				$case_practice_area_link  = esc_url( $last_ancestor_link );
				?>
				<div class="featured-case-result card-style bg-white">
					<div class="featured-case-result-inner theme-style-border">
						<div class="case-result bolt-on-h2">
							<?php echo $case_result; ?>
						</div>
						<div class="case-title">
							<?php echo $case_title; ?>
						</div>
						<div class="case-practice-area">
							<a href="<?php echo $case_practice_area_link; ?>"class="anchor-case-practice-area"><?php echo $case_practice_area_title ?></a>
						</div>
					</div>
				</div>
			<?php endif; // endif ( ! empty( $greatest_case_result ) ) : ?>
			<?php if ( $section_title || $dynamic_post_menu ) : ?>
				<div class="ctnr-section-title-dynamic-post-nav">
					<?php if ( $section_title ) : ?>
						<h2 class="section-title"><?php echo $section_title; ?></h2>
					<?php endif; ?>
					<?php if ( $dynamic_post_menu ) : ?>
						<nav class="dynamic-post-nav">
							<?php echo $dynamic_post_menu; ?>
						</nav>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<!--   /Dynamic Post Menu Section   -->
	<?php

	return ob_get_clean();
}