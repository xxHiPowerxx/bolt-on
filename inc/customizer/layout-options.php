<?php
/**
 * Bolt-On Layout Customizer
 *
 * @package bolt-on
 */

/**
 * Add support for Layout Options in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Layout Customizer object.
 */
function bolt_on_customize_layout_register( $wp_customize ) {
	/**
	 * Layout options.
	 */
	$wp_customize->add_section(
		'layout_options',
		array(
			'title'    => __( 'Layout Options', 'bolt-on' ),
			'priority' => 40, // Before Background Image.
		)
	);

	// Default Post Image.
	$wp_customize->add_setting(
		'default_banner_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'default_banner_image',
			array(
				'priority'    => 2,
				'settings'    => 'default_banner_image',
				'section'     => 'layout_options',
				'label'       => __( 'Default Banner Image', 'bolt-on' ),
				'description' => __( 'Select the image, when banner is present, to be used when no featured image is added.', 'bolt-on' ),
				'width'       => 1920,
				'height'      => 402,
				'flex_width'  => true,
				'flex_height' => true,
			)
		)
	);
}
add_action( 'customize_register', 'bolt_on_customize_layout_register' );