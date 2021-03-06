<?php
/**
 * Component for displaying Attorney Archive Posts.
 * 
 * TODO: Figure out how to render this as a Block/Component in a page.
 *
 * @package bolt-on
 */
// TODO: Componentize Styles.
// wp_enqueue_style( 'bolt-on-attorneys-archive-css' );
wp_enqueue_style( 'bolt-on-vendor-slick-css' );
// Enqueue Scripts
wp_enqueue_script( 'bolt-on-vendor-slick-js' );
if ( ! function_exists( 'get_attorneys_archive' ) ) :
	function get_attorneys_archive() {
		ob_start();
		$args = array(
							'post_type'      =>'attorneys',
							'posts_per_page' => -1,
							'orderby'        => 'menu_order',
							'order'          => 'ASC'
						);
		$post_query = new WP_Query($args);
		if ( $post_query->have_posts() ) :
			// Get the current Post ID for a later comparison.
			$current_post_id = get_the_id();
			while ( $post_query->have_posts() ) :
				$post_query->the_post();

				$this_post_id = get_the_id();

				// Only render the attorneys that are not the current attorney.
				if ( $current_post_id !== $this_post_id ) :

					$attorney_full_name         = get_the_title();
					$attorney_stripped_name     = str_replace( '.', '', $attorney_full_name );
					$attorney_id                = strtolower( str_replace(' ', '-', $attorney_stripped_name) );
					$attorney_title             = esc_attr( get_field( 'attorney_title' ) );
					$attorney_permalink         = get_permalink();
					$attorneys_isolated_picture = get_field( 'attorneys_isolated_picture' );
					$attorney_pic               = wp_get_attachment_image(
						$attorneys_isolated_picture['id'],
						array(null, 500),
						false,
						array('class'=>'archive-attorney-img')
					);
					?>
					<div id="archive-attorney-<?php echo $attorney_id; ?>" data-post-id="<?php echo $this_post_id; ?>" class="archive-attorney">
						<div class="ctnr-archive-attorney-img">
							<?php echo $attorney_pic; ?>
						</div>
						<div class="ctnr-btn-cta-archive-attorney ctnr-archive-attorney-name-title">
							<a class="anchor-btn-cta btn-cta-outer stroke-border" href="<?php echo $attorney_permalink; ?>">
								<span class="btn-cta btn-cta-inner stroke-border-inner">
									<span class="btn-cta-text stroke-border-lvl-three">
										<div class="archive-attorney-name"><?php echo $attorney_full_name; ?></div>
										<div class="archive-attorney-title"><?php echo $attorney_title; ?></div>
									</span>
								</span>
							</a>
						</div>
					</div>
					<?php
				endif; // endif ( $current_post_id !== $this_post_id ) :
			endwhile; // endwhile ( $post_query->have_posts() ) :
		endif; // endif ( $post_query->have_posts() ) :

		wp_reset_query();
		return ob_get_clean();
	}
endif; // endif ( ! function_exists( 'get_attorneys_archive' ) ) :

?>

<section id="component-attorneys-archive" class="bolt-on-component theme-content">
	<div class="left-side">
		<div class="left-side-inner">
			<header class="section-header theme-header">
				<div class="theme-heading stroke-border">
					<div class="theme-heading-outer stroke-border-inner">
						<div class="theme-heading-inner stroke-border-lvl-three">
							<h2 class="theme-heading-title section-title bolt-on-h1">Meet Our Other Attorneys</h2>
							<h3 class="theme-heading-subtitle section-subtitle bolt-on-h2">A Team You Can Count On</h3>
						</div>
					</div>
				</div>
			</header>
			<p class="tagline">Our firm has established a reputation as the Premier Complex Litigation firm in the Inland Empire.</p>
			<?php echo get_site_phone_number_func(true); ?>
			<div class="ctnr-speak-with-attorney-btn">
				<a class="anchor-btn-cta btn-cta-outer stroke-border has-chevron" href="/contact-us/">
					<span class="btn-cta btn-cta-inner stroke-border-inner">
						<span class="btn-cta-text stroke-border-lvl-three">Speak With An Attorney Today</span>
					</span>
				</a>
			</div>
		</div>
	</div><!-- ./left-side -->
	<div class="right-side">
		<div
			id="attorneys-archive-slider"
			class="slickSlider"
			data-slick='{"dots": false,"arrows": true,"infinite": true,"autoplay": true,"autoplaySpeed": 5000,"slidesToShow": 2,"speed": 350,"cssEase": "cubic-bezier(0.22, 0.61, 0.36, 1)","responsive": [{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'
		>
			<?php echo get_attorneys_archive(); ?>
		</div>
	</div><!-- ./right-side -->
</section>