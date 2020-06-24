<?php
/**
 * The template for displaying a Single Attorney.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bolt-on
 */

// Enqueue Styles
$single_attorneys_css_path = '/assets/css/single-attorneys.css';
wp_enqueue_style( 'single-attorneys-post-css', get_theme_file_uri( $single_attorneys_css_path ), array( 'bolt-on-css', 'bolt-on-vendor-slick-css' ), filemtime( get_template_directory() . $single_attorneys_css_path ), 'all' );

get_header();
?>
	<div class="container container-ext main-container">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		endwhile; // End of the loop.
		?>
	</div><!-- /.main-container -->
<?php
// Get Attorney Archive Component.
require_once get_template_directory() . '/template-parts/components/component-attorneys-archive.php';

get_footer();
