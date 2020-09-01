<?php
/**
 * Bolt-On Header Customizer
 *
 * @package bolt-on
 */

/**
 * Add support for Header Options in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Header Customizer object.
 */
function bolt_on_customize_header_register( $wp_customize ) {
	/**
	 * Header options.
	 */
	$wp_customize->add_section(
		'header_options',
		array(
			'title'       => __( 'Header Options', 'bolt-on' ),
			'priority'    => 40, // Before Header Image.
		)
	);
// Mobile Nav Breakpoint.
	$wp_customize->add_setting(
		'mobile_nav_breakpoint',
		array(
			'default'           => '1050',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Range_Control(
			$wp_customize,
			'mobile_nav_breakpoint',
			array(
				'priority'    => 4,
				'label'       => __( 'Mobile Nav Breakpoint', 'bolt-on' ),
				'section'     => 'header_options',
				'settings'    => 'mobile_nav_breakpoint',
				'description' => __( 'Set the Minimum Viewport Width before the Mobile Navigation is Enabled', 'bolt-on' ),
				// 'type'        => 'range',
				'input_attrs' => array(
					'min'   => 1050,
					'max'   => 3000,
					'unit'  => 'px',
					'step'  => 1,
					'class' => 'updateTextInput',
					'style' => 'color: #0a0',
				),
			)
		)
	);

	/**
	 * Add field to accept path for SVG image instead of png image.
	 */
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

	// Site Phone Number.
	$wp_customize->add_setting(
		'site_phone_number',
		array(
			'default'           => null,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'site_phone_number',
			array(
				'priority'    => 12,
				'label'       => __( 'Site Phone Number', 'bolt-on' ),
				'section'     => 'title_tagline',
				'settings'    => 'site_phone_number',
				'description' => __( 'The Site Phone Number Will Be displayed in multple areas', 'bolt-on' ),
				'type'        => 'text',
			)
		)
	);
	$wp_customize->get_setting( 'site_phone_number' )->transport = 'postMessage';
// Header Main Nav End!
}
add_action( 'customize_register', 'bolt_on_customize_header_register' );