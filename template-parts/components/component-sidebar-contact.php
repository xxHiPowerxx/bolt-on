<?php
/**
 * This Component Renders the Sidebar Contact Form.
 * 
 * @package bolt-on
 */
function component_sidebar_contact(	$atts = null ) {

	$contact_form_override = get_field( 'contact_form_override' );
	if ( $contact_form_override ) :
		$contact_form_id               = $contact_form_override->ID;
		$contact_form_title            = $contact_form_override->post_title;
		$contact_form_shortcode        = do_shortcode( '[contact-form-7 id="' . $contact_form_id . '" title="' . $contact_form_title . '"]');
	elseif ( isset( $atts['contact_form'] ) ) :
		$contact_form_shortcode_string = $atts['contact_form'];
		$contact_form_shortcode        = '[' . $contact_form_shortcode_string . ']';
	else :
		$contact_form_shortcode = get_first_contact_form();
	endif;

	$contact_form_title = $atts['contact_form_title'];

	// Enqueue Stylesheet.
	$sidebar_contact_css_path = '/assets/css/sidebar-contact.css';
	wp_register_style(
		'sidebar-contact-css',
		get_theme_file_uri( $sidebar_contact_css_path ),
		array(
			'bolt-on-css',
		),
		filemtime( get_template_directory() . $sidebar_contact_css_path ),
		'all'
	);
	wp_enqueue_style( 'sidebar-contact-css' );
	$styles = '';
	ob_start();
	?>
	<?php if ( shortcode_exists( 'contact-form-7' ) ) : ?>
		<div class="ctnr-contact-form theme-style-border">
			<?php if ( $contact_form_title ) : ?>
				<h4 class="contact-form-title"><?php echo $contact_form_title; ?></h4>
				<?php
			endif;
			echo do_shortcode( $contact_form_shortcode );
			?>
		</div>
		<?php
	endif;
	return ob_get_clean();
}
