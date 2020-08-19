<?php
/**
 * bolt-on Theme Customizer
 *
 * @package bolt-on
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bolt_on_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'bolt_on_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'bolt_on_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'bolt_on_customize_register' );

/**
 * New Fields.
 */
require get_template_directory() . '/inc/customizer/new-fields.php';

/**
 * Header Options.
 */
require get_template_directory() . '/inc/customizer/header-options.php';

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function bolt_on_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function bolt_on_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bolt_on_customize_preview_js() {
	$bolt_on_customizer_path = '/assets/js/customizer.js';
	wp_enqueue_script( 'bolt-on-customizer', get_theme_file_uri( $bolt_on_customizer_path ), array( 'customize-preview' ), filemtime( get_template_directory() . $bolt_on_customizer_path ), true );

	// Send theme Directory to customizer.js.
	wp_localize_script(
		'bolt-on-customizer',
		'wpScriptVars',
		array(
			'themeDirectory' => get_template_directory_uri(),
		),
		true
	);
}
add_action( 'customize_preview_init', 'bolt_on_customize_preview_js' );