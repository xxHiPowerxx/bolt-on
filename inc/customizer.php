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
	wp_enqueue_script( 'bolt-on-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'bolt_on_customize_preview_js' );


/**
 * Add field to accept path for SVG image instead of png image.
 */
function bolt_on_customize_standard_header_register( $wp_customize ) {
	
	// Logo SVG Path Relative or Absolute.
	$wp_customize->add_setting(
		'logo_svg_path_radio',
		array(
			'default'           => 'relative',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'logo_svg_path_radio',
			array(
				'priority'    => 9,
				'label'       => __( 'Logo SVG Path Absolute or Relative?', 'bolt-on' ),
				'section'     => 'title_tagline',
				'settings'    => 'logo_svg_path_radio',
				'description' => __( 'Select Whether Logo SVG path is relative to theme directory or absolute', 'bolt-on' ),
				'type'        => 'radio',
				'choices' => array(
					'relative' => __( 'example: /images/svg/logo.svg' ),
					'absolute'  => __( 'example: https://somesite.com/images/logo.svg' ),
				),
			)
		)
	);
	$wp_customize->get_setting( 'logo_svg_path_radio' )->transport = 'postMessage';

	// Logo SVG Path.
	$wp_customize->add_setting(
		'logo_svg_path',
		array(
			'default'           => null,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'logo_svg_path',
			array(
				'priority'    => 9,
				'label'       => __( 'Logo SVG Path', 'bolt-on' ),
				'section'     => 'title_tagline',
				'settings'    => 'logo_svg_path',
				'description' => __( 'Input the Logo SVG Path', 'bolt-on' ),
				'type'        => 'text',
			)
		)
	);
	$wp_customize->get_setting( 'logo_svg_path' )->transport = 'postMessage';
}
add_action( 'customize_register', 'bolt_on_customize_standard_header_register' );