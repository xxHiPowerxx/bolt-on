<?php
/**
 * This Component Renders the Sidebar Contact Form.
 * 
 * @package bolt-on
 */
function component_sidebar_contact(	$atts ) {
	// Die if no Contact Form
	if ( ! $atts['contact_form'] ) :
		return;
	endif;
	$contact_form = $atts['contact_form'];
	$contact_form_title = $atts['contact_form_title'];

	// Turn $contact_form string into  shortcode.
	$contact_form_shortcode = '[' . $contact_form . ']';

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
