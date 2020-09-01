<?php
/**
 * Template Name: Fixed Width Page
 *
 * @package     bolt-on
 */

// Enqueue Styles
wp_enqueue_style( 'fixed-width-page-css' );
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