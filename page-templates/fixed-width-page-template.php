<?php
/**
 * Template Name: Fixed Width Page
 *
 * @package     bolt-on
 */

// Enqueue Styles
$home_page_template_css_path = '/assets/css/fixed-width-page.css';
wp_enqueue_style( 'fixed-width-page-css', get_theme_file_uri( $home_page_template_css_path ), array( 'bolt-on-css' ), filemtime( get_template_directory() . $home_page_template_css_path ), 'all' );
$extended_container = get_field('extended_container') ? 'container-ext': '';

get_header();
?>
<div class="container <?php echo esc_attr( $extended_container ); ?> main-container">
	<?php
	// Gets Page Content
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', get_post_type() );
	endwhile; // End of the loop.
	?>
</div><!-- /.main-container -->
<?php
get_footer();