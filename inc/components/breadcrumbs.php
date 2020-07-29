<?php
/**
 * This Component Renders a Breadcrumb Nav.
 * 
 * @package bolt-on
 */
function component_breadcrumbs() {
	global $post;
	if ( ! $post ) :
		return;
	endif;

	// Enqueue Styles
	$breadcrumbs_css_path = '/assets/css/breadcrumbs.css';
	wp_register_style(
		'breadcrumbs-css',
		get_theme_file_uri( $breadcrumbs_css_path ),
		array(),
		filemtime( get_template_directory() . $breadcrumbs_css_path ),
		'all'
	);
	wp_enqueue_style( 'breadcrumbs-css' );

	ob_start();
	?>
	<nav class="breadcrumb">
		<?php
		$home_url            = get_home_url();
		$post_type           = esc_attr( $post->post_type );
		$post_type_object    = get_post_type_object( $post_type );
		$videos_url          = get_post_type_archive_link( $post_type );
		$post_type_name      = esc_attr( $post_type_object->label );
		?>
		<a class="breadcrumb-item" href="<?php echo $home_url; ?>"><span class="breadcrumb-name">Home</span></a>
		<a class="breadcrumb-item" href="<?php echo $videos_url; ?>"><span class="breadcrumb-name"><?php echo $post_type_name; ?></span></a>
		<?php
		if ( ! is_post_type_archive( $post_type ) ) :
			$video_category      = wp_get_object_terms( $post->ID, 'video-category' )[0];
			$video_category_name = esc_attr( wp_get_object_terms( $post->ID, 'video-category')[0]->name );
			$videos_category_url = esc_url( get_category_link( $video_category ) );
			?>
			<a class="breadcrumb-item" href="<?php echo $videos_category_url; ?>"><span class="breadcrumb-name"><?php echo $video_category_name; ?></span></a>
			<?php
			if ( ! is_tax( $video_category->taxonomy, $video_category->term_id ) ) :
				$post_type_s_name    = esc_attr( $post_type_object->labels->singular_name );
				$post_title          = esc_attr( $post->post_title );
				?>
				<a class="breadcrumb-item current-breadcrumb-item" aria-current="<?php echo $post_type_s_name; ?>" href="#"><span class="breadcrumb-name"><?php echo $post_title; ?></span></a>
			<?php endif; // endif ( ! is_tax( ... ) ) : ?>
		<?php endif; // endif ( ! is_post_type_archive( $post_type ) ) : ?>
	</nav>
	<?php
	return ob_get_clean();
}