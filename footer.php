<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bolt-on
 */

$site_url             = esc_url( home_url( '/' ) );
$site_name            = get_bloginfo();
$site_name_anchor_tag = '<a href="' . $site_url . '" class="site-name-url">' . $site_name . '</a>';
$site_info_default    = do_shortcode( wp_kses_post( '© ' . '[year] ' . $site_name ) );
?>

			</div><!-- #content -->

			<footer id="colophon" class="site-footer">
				<nav id="footer-nav" class="footer-navigation navbar-nav" aria-label="<?php esc_attr_e( 'Footer-Menu', 'bolt-on' ); ?>">
					<?php
					$menu_name = 'footer-menu';
					$menu_location = $menu_name . '-location';
					$locations = get_nav_menu_locations();

					if (
						$locations &&
						isset( $locations[ $menu_location ] ) &&
						$locations[ $menu_location ] > 0
					) :
						wp_nav_menu(
							array(
								'theme_location' => $menu_location,
								'menu_id'        => $menu_name,
								'container'      => 'ul',
								'depth'          => 1,
								'walker'         => new BoltOn_Walker(),
							)
						);
					endif;
					?>
				</nav><!-- /#footer-nav -->
				<div class="footer-main">
					<div class="container container-ext container-footer-main display-flex">
						<div class="footer-logo-social">
							<div class="site-branding">
								<?php
								$logo_svg_path = get_theme_mod('logo_svg_path', null);
								if ( $logo_svg_path ) :
									$logo_svg_path_radio = get_theme_mod('logo_svg_path_radio', 'relative');
									$logo_svg_src = $logo_svg_path_radio === 'relative' ?
																	get_stylesheet_directory() . $logo_svg_path :
																	esc_url( $logo_svg_path );
									$image_alt_text = esc_attr( get_bloginfo( 'name', 'display' ) . ' Logo' );
									?>
									<a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="custom-logo-link" rel="home">
									<div class="custom-logo">
										<?php include $logo_svg_src; ?>
									</div>
										<?php /*<img class="custom-logo" src="<?php echo $logo_svg_src; ?>" alt="<?php echo $image_alt_text; ?>" /> */ ?>
									</a>
									<?php
								else:
									$custom_logo = get_custom_logo();
									if ( $custom_logo ) :
										echo $custom_logo;
									else:
										if ( is_front_page() && is_home() ) :
											?>
											<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
											<?php
										else :
											?>
											<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
											<?php
										endif;
										$bolt_on_description = get_bloginfo( 'description', 'display' );
										if ( $bolt_on_description || is_customize_preview() ) :
											?>
											<p class="site-description"><?php echo $bolt_on_description; /* WPCS: xss ok. */ ?></p>
										<?php endif; ?>
									<?php endif; // endif ( $custom_logo ) : ?>
								<?php endif; // endif ( $logo_svg_path ) : ?>
							</div>
							<div class="social-icons display-flex">
								<a class="anchor-social-icon social-facebook" href="https://www.facebook.com/McCuneWrightArevalo/" target=_blank>
									<i class="fab fa-facebook-f social-icon"></i>
								</a>
								<a class="anchor-social-icon social-twitter" href="https://twitter.com/mccunewright" target=_blank>
									<i class="fab fa-twitter social-icon"></i>
								</a>
								<a class="anchor-social-icon social-linkedin" href="https://www.linkedin.com/company/mccunewright-llp" target=_blank>
									<i class="fab fa-linkedin-in social-icon"></i>
								</a>
							</div><!-- /.social-icons -->
						</div><!-- /.footer-loco-social -->
						<?php echo get_offices_list(); ?>
					</div>
				</div><!-- /.footer-main -->
				<div class="site-info-footer-wrapper">
					<div class="container container-ext container-site-info">
						<div class="site-info">
							<div class="site-info-copyright">
								<?php echo $site_info_default; ?>
							</div>
							<div class="site-info-disclaimer">
								The information on this website is for general information purposes only. Nothing on this site should be taken as legal advice for any individual case or situation. This information is not intended to create, and receipt or viewing does not constitute, an attorney-client relationship.
							</div>
						</div><!-- .site-info -->
					</div>
				</div>
			</footer><!-- /#colophon -->
		</div><!-- /#page -->

		<?php wp_footer(); ?>

	</body>
</html>
