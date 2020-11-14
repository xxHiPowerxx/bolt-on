<?php
/**
 * Template part for displaying an Attorney
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */
$attorney_full_name             = get_the_title();
$attorney_full_name_array       = explode(' ', $attorney_full_name );
$attorney_first_name            = $attorney_full_name_array[0];
$attorney_last_name             = end($attorney_full_name_array);
$attorney_middle_initial        = isset( $attorney_full_name_array[2] ) ?
	$attorney_full_name_array[1] :
	'';
$attorney_title                 = esc_attr( get_field( 'attorney_title' ) );
$attorney_practice_areas        = get_field( 'attorney_practice_areas' );
$extra_attorney_practice_areas  = get_field( 'extra_attorney_practice_areas' );
$site_phone_number              = get_theme_mod( 'site_phone_number', '' );

// Content Sections.
// Only store these for now, the rest are repeaters and require validation.
// Before getting their sub_fields().
$attorney_bio                       = wp_kses_post( get_field( 'attorney_bio' ) );
$attorney_successes                 = get_field( 'attorney_successes' );
$attorney_professional_associations = wp_kses_post( get_field( 'attorney_professional_associations' ) );
$attorney_speaking_engagements      = wp_kses_post( get_field( 'attorney_speaking_engagements' ) );
$attorney_videos                    = get_field( 'attorney_videos' );

$contact_form_title = 'Connect With ' . $attorney_first_name;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row main-row">
		<aside id="attorney-sidebar" class="left-sidebar col-xxl-3 col-lg-4 col-12">
			<?php the_post_thumbnail( array( 370, null ), array( 'class' => 'card-style' ) ); ?>
			<nav class="attorney-attributes-nav sidebar-nav card-style">

				<?php
				if ( $attorney_bio ) :
					$attorney_bio_id = 'attorney-bio';
					?>
					<button class="btn-attorney-attributes-nav btn-no-style has-chevron btn btn-sidebar-nav preventExpandedCollapse" type="button" data-toggle="collapse" data-target="#<?php echo $attorney_bio_id; ?>" aria-expanded="true" aria-controls="<?php echo $attorney_bio_id; ?>">Bio</button>
				<?php endif; // endif ( $attorney_bio ) : ?>

				<?php
				if ( $attorney_successes ) :
					$attorney_successes_id = 'attorney-successes';
					?>
					<button class="btn-attorney-attributes-nav btn-no-style has-chevron btn btn-sidebar-nav preventExpandedCollapse" type="button" data-toggle="collapse" data-target="#<?php echo $attorney_successes_id; ?>" aria-expanded="false" aria-controls="<?php echo $attorney_successes_id; ?>">Successes</button>
				<?php endif; // endif ( $attorney_successes ) : ?>

				<?php
				if ( have_rows( 'attorney_education_repeater' ) ) :
					$attorney_education_id = 'attorney-education';
					?>
					<button class="btn-attorney-attributes-nav btn-no-style has-chevron btn btn-sidebar-nav preventExpandedCollapse" type="button" data-toggle="collapse" data-target="#<?php echo $attorney_education_id; ?>" aria-expanded="false" aria-controls="<?php echo $attorney_education_id; ?>">Education</button>
				<?php endif; // endif ( have_rows( 'attorney_education_repeater' ) ) : ?>

				<?php
				if ( have_rows( 'attorney_awards_repeater' ) ) :
					$attorney_awards_id = 'attorney-awards';
					?>
					<button class="btn-attorney-attributes-nav btn-no-style has-chevron btn btn-sidebar-nav preventExpandedCollapse" type="button" data-toggle="collapse" data-target="#<?php echo $attorney_awards_id; ?>" aria-expanded="false" aria-controls="<?php echo $attorney_awards_id; ?>">Awards</button>
				<?php endif; // endif ( have_rows( 'attorney_awards_repeater' ) ) : ?>

				<?php
				if ( $attorney_professional_associations ) :
					$attorney_professional_associations_id = 'attorney-professional-associations';
					?>
					<button class="btn-attorney-attributes-nav btn-no-style has-chevron btn btn-sidebar-nav preventExpandedCollapse" type="button" data-toggle="collapse" data-target="#<?php echo $attorney_professional_associations_id; ?>" aria-expanded="false" aria-controls="<?php echo $attorney_professional_associations_id; ?>">Professional Associations</button>
				<?php endif; // endif ( $attorney_professional_associations ) : ?>

				<?php
				if ( $attorney_speaking_engagements ) :
					$attorney_speaking_engagements_id = 'attorney-speaking-engagements';
					?>
					<button class="btn-attorney-attributes-nav btn-no-style has-chevron btn btn-sidebar-nav preventExpandedCollapse" type="button" data-toggle="collapse" data-target="#<?php echo $attorney_speaking_engagements_id; ?>" aria-expanded="false" aria-controls="<?php echo $attorney_speaking_engagements_id; ?>">Speaking Engagements</button>
				<?php endif; // endif ( $attorney_speaking_engagements ) : ?>

				<?php
				if ( $attorney_videos ) :
					$attorney_videos_id = 'attorney-videos';
					?>
					<button class="btn-attorney-attributes-nav btn-no-style has-chevron btn btn-sidebar-nav preventExpandedCollapse" type="button" data-toggle="collapse" data-target="#<?php echo $attorney_videos_id; ?>" aria-expanded="false" aria-controls="<?php echo $attorney_videos_id; ?>">Videos</button>
				<?php endif; // endif ( $attorney_videos ) : ?>

			</nav>
			<?php
			$contact_form_atts = array(
				'contact_form_title' => $contact_form_title,
			);
			echo get_sidebar_contact($contact_form_atts);
			?>
		</aside>
		<div class="col-1 d-xxl-block d-none"></div>
		<main class="site-main col-lg-8 col-12 theme-content pad-bottom">
			<?php if ( $attorney_full_name || $attorney_title ) : ?>
				<header class="entry-header">
					<?php if ( $attorney_full_name ) : ?>
						<h1 class="entry-title attorney-name"><?php echo $attorney_full_name; ?></h1>
					<?php endif; ?>
					<?php if ( $attorney_title ) : ?>
						<h2 class="attorney-title"><?php echo $attorney_title; ?></h2>
					<?php endif; ?>
				</header><!-- .entry-header -->
			<?php endif; //endif ( $attorney_full_name || $attorney_title ) : ?>
			<?php if ( $attorney_practice_areas || $extra_attorney_practice_areas ) : ?>
				<div class="practice-areas">
					<h3 class="practice-areas-title">Practice Areas:</h3>
					<?php
					ob_start();
					// Loop Through Attorney Practice Areas.
					$last = $extra_attorney_practice_areas ?
						end( $extra_attorney_practice_areas ) :
						end( $attorney_practice_areas );
					foreach ( $attorney_practice_areas as $attorney_practice_area ) :
						$practice_area_link  = get_permalink( $attorney_practice_area );
						$long_title          = get_the_title( $attorney_practice_area );
						$short_title         = esc_attr( get_field( 'short_title', $attorney_practice_area ) );
						if ( $short_title ) :
							$practice_area_title      = $short_title;
							$practice_area_title_attr = ' title="' . $long_title . '"';
						else:
							$practice_area_title      = $long_title;
							$practice_area_title_attr = null;
						endif;

						?>
						<a class="anchor-attorney-practice-area anchor-practice-area" href="<?php echo $practice_area_link; ?>" <?php echo $practice_area_title_attr; ?>><span class="attorney-practice-area practice-area"><?php echo $practice_area_title; ?></span></a>
						<?php
						// Seperate Each Anchor tag with comma if not last.
						if ( $practice_area_title && $last !== $attorney_practice_area ) :
							?>
							<span class="comma-seperator">,&nbsp;</span>
							<?php
						endif;
					endforeach; //endforeach ($attorney_practice_areas as $attorney_practice_area) :
					foreach ( (array) $extra_attorney_practice_areas as $ex_attorney_practice_area ) :
						$ex_practice_area_title   = $ex_attorney_practice_area['extra_attorney_practice_area'];
						$last_practice_area_title = is_array( $last ) ? $last['extra_attorney_practice_area'] : null;
						if ( $ex_practice_area_title ) :
							?>
							<span class="anchor-attorney-practice-area anchor-practice-area"><span class="attorney-practice-area practice-area"><?php echo $ex_practice_area_title; ?></span></span>
							<?php
							if (
								$last_practice_area_title !== '' &&
								$last !== $ex_attorney_practice_area
							) :
								?>
								<span class="comma-seperator">,&nbsp;</span>
								<?php
							endif;
						endif;
					endforeach; // endforeach ( (array) $extra_attorney_practice_areas as $ex_attorney_practice_area ) :
					$content = ob_get_clean();
					echo preg_replace('/>\s+</m', '><', $content);
					?>
				</div><!-- /.practice-areas -->
			<?php endif; // endif ( $attorney_practice_areas || $extra_attorney_practice_areas ) : ?>

			<div id="attorney-attributes-sections">

				<?php if ( $attorney_bio ) : ?>
					<section id="<?php echo $attorney_bio_id; ?>" class="attorney-attributes-section collapse show" data-parent="#attorney-attributes-sections">
						<h2 class="attorney-attributes-title">Biography</h2>
						<div class="attorney-attributes-content">
							<?php echo $attorney_bio; ?>
						</div>
					</section><!-- /#<?php echo $attorney_bio_id; ?> -->
				<?php endif; // endif ( $attorney_bio ) : ?>

				<?php if ( $attorney_successes ) : ?>
					<section id="<?php echo $attorney_successes_id; ?>" class="attorney-attributes-section collapse" data-parent="#attorney-attributes-sections">
						<h2 class="attorney-attributes-title">Featured Successes</h2>
						<div class="attorney-attributes-content attorney-successes-list">
							<?php
							foreach ( $attorney_successes as $case ) :
								$case_result        = esc_attr( $case->case_result );
								$case_title         = esc_attr( $case->post_title );
								?>
								<div class="listed-success case">
									<div class="case-result">
										<h3><?php echo $case_result; ?></h3>
									</div>
									<div class="case-title theme-style-border">
										<?php echo $case_title; ?>
									</div>
								</div>
							<?php endforeach; // foreach ( $attorney_successes as $case ) : ?>
						</div><!-- ./attorney-successes-list -->
					</section><!-- /#<?php echo $attorney_successes_id; ?> -->
				<?php endif; // endif ( $attorney_successes ) : ?>

				<?php if ( have_rows( 'attorney_education_repeater' ) ) : ?>
					<section id="<?php echo $attorney_education_id; ?>" class="attorney-attributes-section collapse" data-parent="#attorney-attributes-sections">
						<h2 class="attorney-attributes-title">Education</h2>
						<div class="attorney-attributes-content">
							<ul class="attorney-education-list">
								<?php
								while ( have_rows( 'attorney_education_repeater' ) ) :
									the_row();
									$attorney_education = esc_html( get_sub_field( 'attorney_education' ) );
									?>
									<li class="listed-education"><?php echo $attorney_education; ?></li>
								<?php endwhile; // endwhile ( have_rows( 'attorney_education_repeater' ) ) : ?>
							</ul><!-- ./attorney-education-list -->
						</div>
					</section><!-- /#<?php echo $attorney_education_id; ?> -->
				<?php endif; // endif ( have_rows( 'attorney_education_repeater' ) ) : ?>

				<?php if ( have_rows( 'attorney_awards_repeater' ) ) : ?>
					<section id="<?php echo $attorney_awards_id; ?>" class="attorney-attributes-section collapse" data-parent="#attorney-attributes-sections">
						<h2 class="attorney-attributes-title">Awards</h2>
						<div class="attorney-attributes-content">
							<ul class="attorney-awards-list">
								<?php
								while ( have_rows( 'attorney_awards_repeater' ) ) :
									the_row();
									$attorney_award = esc_html( get_sub_field( 'attorney_award' ) );
									?>
									<li class="listed-award"><?php echo $attorney_award; ?></li>
								<?php endwhile; // endwhile ( have_rows( 'attorney_awards_repeater' ) ) : ?>
							</ul><!-- ./attorney-awards-list -->
						</div>
					</section><!-- /#<?php echo $attorney_awards_id; ?> -->
				<?php endif; // endif ( have_rows( 'attorney_awards_repeater' ) ) : ?>

				<?php if ( $attorney_professional_associations ) : ?>
					<section id="<?php echo $attorney_professional_associations_id; ?>" class="attorney-attributes-section collapse" data-parent="#attorney-attributes-sections">
						<h2 class="attorney-attributes-title">Professional Associations</h2>
						<div class="attorney-attributes-content">
							<?php echo $attorney_professional_associations; ?>
						</div>
					</section><!-- /#<?php echo $attorney_professional_associations_id; ?> -->
				<?php endif; // endif ( $attorney_professional_associations ) : ?>

				<?php if ( $attorney_speaking_engagements ) : ?>
					<section id="<?php echo $attorney_speaking_engagements_id; ?>" class="attorney-attributes-section collapse" data-parent="#attorney-attributes-sections">
						<h2 class="attorney-attributes-title">Speaking Engagements</h2>
						<div class="attorney-attributes-content">
							<?php echo $attorney_speaking_engagements; ?>
						</div>
					</section><!-- /#<?php echo $attorney_speaking_engagements_id; ?> -->
				<?php endif; // endif ( $attorney_speaking_engagements ) : ?>

				<?php if ( $attorney_videos ) : ?>
					<section id="<?php echo $attorney_videos_id; ?>" class="attorney-attributes-section collapse" data-parent="#attorney-attributes-sections">
						<h2 class="attorney-attributes-title">Featured Videos</h2>
							<div class="attorney-attributes-content">
							<?php
							$get_posts_args      = array(
								'post_type'      => 'videos',
								'posts_per_page' => count( $attorney_videos ),
								'post__in'       => $attorney_videos,
							);
							$posts_of_category   = new WP_Query( $get_posts_args );
							if ( $posts_of_category->have_posts() ) :
								?>
								<div class="archive-list archive-video-list">
									<?php
									while ( $posts_of_category->have_posts() ) :
										$posts_of_category->the_post();
											get_template_part( 'template-parts/content-archive', get_post_type() );
									endwhile;
									wp_reset_query();
									?>
								</div><!-- /.archive-video-list -->
								<?php
								// If There are more posts than can be shown, 
								// $post_of_category->max_num_pages will be greater than 0
								// Note that $posts_of_category->max_num_pages is always > 0
								// If the current post has been excluded from the Query.
								$max_num_pages = $posts_of_category->max_num_pages;
								if ( $max_num_pages ) :
									//render a CTA btn.
									$more_videos_link = get_field( 'more_videos_link' );
									if( $more_videos_link ) :
										$more_videos_link_url  = get_category_link( $more_videos_link );
										$more_videos_link_name = $more_videos_link->name;
									else :
										$more_videos_link_url  = get_post_type_archive_link( 'videos' );
										$more_videos_link_name = null;
									endif;

									?>
									<div class="ctnr-btn-view-more-videos">
										<a class="anchor-btn-cta btn-cta-outer stroke-border has-chevron btn-view-more-videos" href="<?php echo $more_videos_link_url; ?>">
											<span class="btn-cta btn-cta-inner stroke-border-inner">
												<span class="btn-cta-text stroke-border-lvl-three nowrap-parent">
													<span>View All</span>
													<span>Videos</span>
													<?php if( $more_videos_link_name ) : ?>
														<span>of</span>
														<span><?php echo $more_videos_link_name; ?></span>
													<?php endif;?>
												</span>
											</span>
										</a>
									</div>
									<?php
								endif; // endif ( $found_posts > $videos_to_show ) :
								?>
							</div><!-- /.attorney-attributes-content -->
							<?php
						endif; // endif ( have_posts( $posts_of_category ) ) :
						?>
					</section><!-- /#<?php echo $attorney_videos_id; ?> -->
				<?php endif; // endif ( $attorney_videos ) : ?>

			</div><!-- #attorney-attributes-sections -->
			<footer class="attorney-footer">
				<a href="tel:<?php echo $site_phone_number ?>" class="anchor-attorney-footer-phone-number">
					Contact <?php echo $attorney_first_name . ' ' . $attorney_last_name; ?> today by calling <span class="attorney-footer-phone-number"><?php echo $site_phone_number ?></span>.
				</a>
				<?php bolt_on_entry_footer(); ?>
			</footer><!-- ./attorney-footer -->
		</main><!-- /.site-main -->
	</div><!-- ./main-row -->
</article><!-- /#post-<?php the_ID(); ?> -->