<?php
/**
 * This Component Renders the Offices List
 * 
 * TODO: use ACF to make this modifyable. CMS this.
 * 
 * @package bolt-on
 */
if ( ! function_exists( 'component_offices_list' ) ) :
	function component_offices_list() {
		ob_start();
		?>
		<div class="offices-list">
			<div class="listed-office">
				<h3 class="office-title">Main Office:</h3>
				<a class="anchor-office-phone-number"><span class="office-phone-number"><?php echo get_site_phone_number_func( false ); ?></span></a>
				<a class="anchor-office-location" title="View on Google Maps" href="https://www.google.com/maps/place/McCune+Wright+Arevalo,+LLP/@34.065147,-117.5822282,17z/data=!3m1!4b1!4m5!3m4!1s0x80c335b9858fe0f5:0x4599ecb937df3499!8m2!3d34.065147!4d-117.5800395" target="_blank" rel="noopener noreferrer">
					<div class="office-address">
						<span class="office-address-line-1">3281 East Guasti Road</span>
						<span class="office-address-line-2">Suite 100</span>
					</div>
					<div class="office-city-state-zip nowrap-parent">
						<span class="office-city">Ontario,</span>
						<span class="office-state">CA</span>
						<span class="office-zip">91761</span>
					</div>
				</a>
			</div>
			<div class="listed-office">
				<h3 class="office-title">Orange County Office:</h3>
				<a class="anchor-office-phone-number"><span class="office-phone-number">(714) 909-2326</span></a>
				<a class="anchor-office-location" title="View on Google Maps" href="https://www.google.com/maps/place/18565+Jamboree+Rd+%23550,+Irvine,+CA+92612/@33.6700884,-117.8530455,17z/data=!3m1!4b1!4m5!3m4!1s0x80dcde61b4172e7b:0x75f1ae014236794f!8m2!3d33.6700884!4d-117.8508568" target="_blank" rel="noopener noreferrer">
					<div class="office-address">
						<span class="office-address-line-1">18565 Jamboree Road</span>
						<span class="office-address-line-2">Suite 550</span>
					</div>
					<div class="office-city-state-zip nowrap-parent">
						<span class="office-city">Irvine,</span>
						<span class="office-state">CA</span>
						<span class="office-zip">92612</span>
					</div>
				</a>
			</div>
			<div class="listed-office">
				<h3 class="office-title nowrap-parent"><span>Inland Empire</span> – <span>East Office:</span></h3>
				<a class="anchor-office-phone-number"><span class="office-phone-number">(909) 443-1643</span></a>
				<a class="anchor-office-location" title="View on Google Maps" href="https://www.google.com/maps/place/McCune+Wright+Arevalo,+LLP/@34.0662623,-117.2887363,17z/data=!3m1!4b1!4m5!3m4!1s0x80dcad0c099da5c7:0xa29e6e639e5745e!8m2!3d34.0662623!4d-117.2865476" target="_blank" rel="noopener noreferrer">
					<div class="office-address">
						<span class="office-address-line-1">164 W. Hospitality Lane</span>
						<span class="office-address-line-2">Suite 109</span>
					</div>
					<div class="office-city-state-zip nowrap-parent">
						<span class="office-city">San Bernardino,</span>
						<span class="office-state">CA</span>
						<span class="office-zip">92408</span>
					</div>
				</a>
			</div>
			<div class="listed-office">
				<h3 class="office-title">Coachella Valley Office:</h3>
				<a class="anchor-office-phone-number"><span class="office-phone-number">(760) 892-5099</span></a>
				<a class="anchor-office-location" title="View on Google Maps" href="https://www.google.com/maps/place/73255+El+Paseo+%2310,+Palm+Desert,+CA+92260/@33.7194799,-116.3887936,17z/data=!3m1!4b1!4m5!3m4!1s0x80dafe7051879e63:0xec3535fb004c628c!8m2!3d33.7194799!4d-116.3866049" target="_blank" rel="noopener noreferrer">
					<div class="office-address">
						<span class="office-address-line-1">73255 El Paseo</span>
						<span class="office-address-line-2">Suite 10</span>
					</div>
					<div class="office-city-state-zip nowrap-parent">
						<span class="office-city">Palm Desert,</span>
						<span class="office-state">CA</span>
						<span class="office-zip">92260</span>
					</div>
				</a>
			</div>
			<div class="listed-office">
				<h3 class="office-title">Midwest Office:</h3>
				<a class="anchor-office-phone-number"><span class="office-phone-number">(618) 424-4402</span></a>
				<a class="anchor-office-location" title="View on Google Maps" href="https://www.google.com/maps/place/231+N+Main+St+%2320,+Edwardsville,+IL+62025/@38.8135514,-89.960748,17z/data=!4m5!3m4!1s0x8875f9d3dbf21543:0x2dfd270b6540929c!8m2!3d38.8135514!4d-89.9585593" target="_blank" rel="noopener noreferrer">
					<div class="office-address">
						<span class="office-address-line-1">231 North Main Street</span>
						<span class="office-address-line-2">Suite 20</span>
					</div>
					<div class="office-city-state-zip nowrap-parent">
						<span class="office-city">Edwardsville,</span>
						<span class="office-state">IL</span>
						<span class="office-zip">62025</span>
					</div>
				</a>
			</div>
			<div class="listed-office">
				<h3 class="office-title">East Coast Office:</h3>
				<a class="anchor-office-phone-number"><span class="office-phone-number">(973) 737-9981</span></a>
				<a class="anchor-office-location" title="View on Google Maps" href="https://www.google.com/maps/place/Regus+-+New+Jersey,+Newark+-+One+Gateway/@40.7342,-74.1680887,17z/data=!3m1!4b1!4m5!3m4!1s0x89c253838543e53d:0xa6d637cdded3fd8c!8m2!3d40.7342!4d-74.1659" target="_blank" rel="noopener noreferrer">
					<div class="office-address">
						<span class="office-address-line-1">One Gateway Center</span>
						<span class="office-address-line-2">Suite 2600</span>
					</div>
					<div class="office-city-state-zip nowrap-parent">
						<span class="office-city">Newark,</span>
						<span class="office-state">NJ</span>
						<span class="office-zip">07102</span>
					</div>
				</a>
			</div>
		</div><!-- /.offices-list -->
		<?php
		return ob_get_clean();
	}
endif; // endif ( ! function_exists( 'component_offices_list' ) ) :