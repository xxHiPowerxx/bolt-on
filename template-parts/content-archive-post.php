<?php
/**
 * Template part for displaying archive posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bolt-on
 */

wp_enqueue_style( 'bolt-on-content-archive-css' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'listed-archive content-area display-flex' ); ?>>
	<div class="listed-archive-inner">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-image">
				<a class="anchor-archive-thumbnail" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php
					the_post_thumbnail( 'archive-thumbnail' );
					/*elseif ( get_theme_mod( 'default_post_image' ) ) :
					// 	echo wp_get_attachment_image( get_theme_mod( 'default_post_image' ), 'archive-thumbnail' );
					else :
						?>
						<?php
						$thumb_id = get_post_thumbnail_id( get_the_ID() );
						$alt      = esc_attr( get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) );
						?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/426x240.png" class="attachment-archive-thumbnail" alt="<?php echo $alt; ?>" width="426" height="240" />
						<?php*/ ?>
				</a>
			</div>
		<?php endif; ?>
		<div class="post-body display-flex flex-column">

			<header class="entry-header">
				<?php

				if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta bolt-on-highlight-font">
						<?php
						if ( is_singular() ) :
							the_title( '<h1 class="entry-title">', '</h1>' );
						else :
							the_title( '<a class="anchor-entry-title" href="' . esc_url( get_permalink() ) . '" rel="bookmark"><h3 class="entry-title test">', '</h3></a>' );
						endif;
						?>
						<div class="post-date">
							<?php
							bolt_on_posted_on();
							?>
						</div>
					</div><!-- .entry-meta -->
					<?php
				endif;
				?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php

				the_excerpt(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'bolt-on' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bolt-on' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer bolt-on-highlight-font">
				<div class="cat-link-container display-flex flex-row justify-content-between">
					<div class="post-category">
						<?php bolt_on_post_categories(); ?>
					</div>
					<a class="anchor-btn-cta btn-cta-outer stroke-border has-chevron post-link" href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" title="<?php echo get_the_title(); ?>">
						<span class="btn-cta btn-cta-inner stroke-border-inner">
							<span class="btn-cta-text stroke-border-lvl-three">Read More</span>
						</span>
					</a>
					<?php
					// TODO: Use the above CTA Button in child theme.
					/* <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" title="<?php echo get_the_title(); ?>" class="post-link bolt-on-theme-color-bg material-btn"><i class="fas fa-arrow-right"></i><span class="hide-me">Read More</span></a> */
					?>
				</div>
				<?php
				bolt_on_edit_post_link();
				?>
			</footer><!-- .entry-footer -->

		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
