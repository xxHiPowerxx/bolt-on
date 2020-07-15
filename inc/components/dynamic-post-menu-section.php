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
	if ( ! $dynamic_post_menu_array ) :
		return;
	endif;
	
	$section_title     = $args['section_title'] ? :
		$dynamic_post_menu_array['last_ancestor_title'];
	$section_title     = esc_attr( $section_title );
	$dynamic_post_menu = $dynamic_post_menu_array['markup'];

	ob_start();
	?>
	<!--   Dynamic Post Menu Section   -->
	<section class="dynamic-post-menu-section pad-bottom">
		<div class="container container-ext dynamic-post-menu-section pad-onetwenty">
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