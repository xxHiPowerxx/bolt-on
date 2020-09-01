<?php
/**
 * Template Name: Contact Us Page
 *
 * @package     bolt-on
 */

// Enqueue Styles
$contact_us_css_path = '/assets/css/contact-us-page-template.css';
wp_enqueue_style( 'contact-us-page-template-css', get_theme_file_uri( $contact_us_css_path ), array( 'bolt-on-css', 'fixed-width-page-css' ), filemtime( get_template_directory() . $contact_us_css_path ), 'all' );
$extended_container = get_field('extended_container') ? 'container-ext': '';

get_header();
?>
<div class="container-fluid container-xxl <?php echo esc_attr( $extended_container ); ?> main-container">
	<main class="site-main pad-onetwenty">
		<section id="contact-us" class="contact-us-section">
			<header class="section-header ctnr-section-title">
				<h1 class="section-title">Contact McCune Wright Arevalo, LLP</h2>
				<h2 class="section-subtitle">Complex Litigation and Trial Attorneys Serving Clients Nationwide</h3>
			</header>
			<div class="fraction-wrap">
				<div class="one-half" id="our-offices">
					<h3 class="offices-title">Our Offices</h3>
					<?php echo get_offices_list(); ?>
				</div>
				<div class="one-half" id="contact-us">
					<div class="ctnr-contact-form theme-style-border">
						<h3 class="contact-form-title">Contact Us Today</h3>
						<div class="contact-form">
							<?php
							$contact_form = get_first_contact_form();
							echo do_shortcode( $contact_form );
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
</div><!-- /.main-container -->
<?php
get_footer();