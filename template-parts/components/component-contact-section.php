<?php
/**
 * This Component Renders the Contact Form and the Office List.
 * 
 * TODO: Allow $contact_form to be passed in via shortcode.
 * 
 * @package bolt-on
 */
function component_contact_section( $contact_form = null ) {

	$contact_form_override = get_field( 'contact_form_override' );

	if ( $contact_form_override ) :
		$contact_form_id    = $contact_form_override->ID;
		$contact_form_title = $contact_form_override->post_title;
		$contact_form_shortcode = '[contact-form-7 id="' . $contact_form_id . '" title="' . $contact_form_title . '"]';
	else :
		$contact_form_shortcode = get_first_contact_form();
	endif;
	// Turn $contact_form string into  shortcode.

	// Enqueue Contact Section Stylesheet.
	$contact_section_css_path = '/assets/css/contact-section.css';
	wp_register_style(
		'contact-section-css',
		get_theme_file_uri( $contact_section_css_path ),
		array(
			'bolt-on-css',
		),
		filemtime( get_template_directory() . $contact_section_css_path ),
		'all'
	);
	wp_enqueue_style( 'contact-section-css' );
	$styles = '';
	ob_start();
	?>
	<!--   Contact Section   --->
	<section class="contact-section">
		<div class="container-fluid container-xxl container-ext container-contact">
			<div class="ctnr-contact-form pad-onetwenty">
				<header class="section-header ctnr-section-title">
					<h2 class="section-title bolt-on-h1">Take The Next Step</h2>
					<h3 class="section-subtitle bolt-on-h2">Schedule Your Free Consultation Today</h3>
				</header>
				<div class="contact-form">
					<?php echo do_shortcode( $contact_form_shortcode ); ?>
				</div>
			</div><!-- ./ctnr-contact-form -->
			<div class="ctnr-contact-info">
				<div class="contact-info-inner pad-onetwenty">
					<header class="section-header ctnr-section-title">
						<h2 class="section-title bolt-on-h1 nowrap-parent"><span>McCune Wright</span> <span>Arevalo, LLP</span></h2>
						<a class="phone-number" href="tel:(909) 345-8110">(909) 345-8110</a>
					</header>
					<?php echo get_offices_list(); ?>
				</div>
			</div><!-- /.ctnr-contact-info -->
		</div><!-- /.container-contact -->
	</section>
	<!--   /Contact Section   --->
	<?php
	return ob_get_clean();
}
