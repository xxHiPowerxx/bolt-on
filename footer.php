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
						<div class="offices-list">
							<div class="listed-office">
								<h4 class="office-title">Main Office:</h4>
								<a class="anchor-office-location" title="View Location on Google Maps." href="https://www.google.com/maps/place/McCune+Wright+Arevalo,+LLP/@34.065147,-117.5822282,17z/data=!3m1!4b1!4m5!3m4!1s0x80c335b9858fe0f5:0x4599ecb937df3499!8m2!3d34.065147!4d-117.5800395" target="_blank">
									<div class="office-address">
										<span class="office-address-line-1">3281 East Guasti Road</span>
										<span class="office-address-line-2">Suite 100</span>
									</div>
									<div class="office-city-state-zip">
										<span class="office-city">Ontario,</span>
										&nbsp;
										<span class="office-state">CA</span>
										&nbsp;
										<span class="office-zip">91761</span>
									</div>
								</a>
							</div>
							<div class="listed-office">
								<h4 class="office-title">Orange County Office:</h4>
								<a class="anchor-office-location" title="View Location on Google Maps." href="https://www.google.com/maps/place/18565+Jamboree+Rd+%23550,+Irvine,+CA+92612/@33.6700884,-117.8530455,17z/data=!3m1!4b1!4m5!3m4!1s0x80dcde61b4172e7b:0x75f1ae014236794f!8m2!3d33.6700884!4d-117.8508568" target="_blank">
									<div class="office-address">
										<span class="office-address-line-1">18565 Jamboree Road</span>
										<span class="office-address-line-2">Suite 550</span>
									</div>
									<div class="office-city-state-zip">
										<span class="office-city">Irvine,</span>
										&nbsp;
										<span class="office-state">CA</span>
										&nbsp;
										<span class="office-zip">92612</span>
									</div>
								</a>
							</div>
							<div class="listed-office">
								<h4 class="office-title">Inland Empire – East Office:</h4>
								<a class="anchor-office-location" title="View Location on Google Maps." href="https://www.google.com/maps/place/McCune+Wright+Arevalo,+LLP/@34.0662623,-117.2887363,17z/data=!3m1!4b1!4m5!3m4!1s0x80dcad0c099da5c7:0xa29e6e639e5745e!8m2!3d34.0662623!4d-117.2865476" target="_blank">
									<div class="office-address">
										<span class="office-address-line-1">164 W. Hospitality Lane</span>
										<span class="office-address-line-2">Suite 109</span>
									</div>
									<div class="office-city-state-zip">
										<span class="office-city">San Bernardino,</span>
										&nbsp;
										<span class="office-state">CA</span>
										&nbsp;
										<span class="office-zip">92408</span>
									</div>
								</a>
							</div>
							<div class="listed-office">
								<h4 class="office-title">Coachella Valley Office:</h4>
								<a class="anchor-office-location" title="View Location on Google Maps." href="https://www.google.com/maps/place/73255+El+Paseo+%2310,+Palm+Desert,+CA+92260/@33.7194799,-116.3887936,17z/data=!3m1!4b1!4m5!3m4!1s0x80dafe7051879e63:0xec3535fb004c628c!8m2!3d33.7194799!4d-116.3866049" target="_blank">
									<div class="office-address">
										<span class="office-address-line-1">73255 El Paseo</span>
										<span class="office-address-line-2">Suite 10</span>
									</div>
									<div class="office-city-state-zip">
										<span class="office-city">Palm Desert,</span>
										&nbsp;
										<span class="office-state">CA</span>
										&nbsp;
										<span class="office-zip">92260</span>
									</div>
								</a>
							</div>
							<div class="listed-office">
								<h4 class="office-title">Midwest Office:</h4>
								<a class="anchor-office-location" title="View Location on Google Maps." href="https://www.google.com/maps/place/231+N+Main+St+%2320,+Edwardsville,+IL+62025/@38.8135514,-89.960748,17z/data=!4m5!3m4!1s0x8875f9d3dbf21543:0x2dfd270b6540929c!8m2!3d38.8135514!4d-89.9585593" target="_blank">
									<div class="office-address">
										<span class="office-address-line-1">231 North Main Street</span>
										<span class="office-address-line-2">Suite 20</span>
									</div>
									<div class="office-city-state-zip">
										<span class="office-city">Edwardsville,</span>
										&nbsp;
										<span class="office-state">IL</span>
										&nbsp;
										<span class="office-zip">62025</span>
									</div>
								</a>
							</div>
							<div class="listed-office">
								<h4 class="office-title">East Coast Office:</h4>
								<a class="anchor-office-location" title="View Location on Google Maps." href="https://www.google.com/maps/place/Regus+-+New+Jersey,+Newark+-+One+Gateway/@40.7342,-74.1680887,17z/data=!3m1!4b1!4m5!3m4!1s0x89c253838543e53d:0xa6d637cdded3fd8c!8m2!3d40.7342!4d-74.1659" target="_blank">
									<div class="office-address">
										<span class="office-address-line-1">One Gateway Center</span>
										<span class="office-address-line-2">Suite 2600</span>
									</div>
									<div class="office-city-state-zip">
										<span class="office-city">Newark,</span>
										&nbsp;
										<span class="office-state">NJ</span>
										&nbsp;
										<span class="office-zip">07102</span>
									</div>
								</a>
							</div>
						</div><!-- /.offices-list -->
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
