<?php
/**
 * Utility Functions
 *
 * @package bolt-on
 */

/**
 * Convert Hex to RGB
 *
 * @param string $hex_string hex value from customizer.
 * @param string $opacity opacity value from customizer.
 */
if ( ! function_exists( 'convert_hex_to_rgb' ) ) :
	function convert_hex_to_rgb( $hex_string, $opacity = null ) {
		if ( null !== $opacity ) :
				$opacity = $opacity / 100;
		endif;

		list($r, $g, $b) = sscanf( $hex_string, '#%02x%02x%02x' );
		if ( 0 === $opacity || $opacity ) :
			return "rgba({$r}, {$g}, {$b}, {$opacity})";
		else :
				return "rgb({$r}, {$g}, {$b})";
		endif;
	}
endif; // endif ( ! function_exists( 'convert_hex_to_rgb' ) ) :

if ( ! function_exists( 'bolt_on_delete_acf_fields' ) ) :
	/**
	 * Delete ACF Fields
	 * Should be used to clean up after a field name is changed or removed.
	 * 
	 * @param string $field - The Field Name
	 * @param int|array $args - Post ID|Args for get_posts().
	 * @see https://developer.wordpress.org/reference/functions/get_posts/
	 */
	function bolt_on_delete_acf_fields( $field, $args = null ) {
		function delete_field_and_ref( $post_id, $field ) {
			$field_ref = '_' . $field;
			delete_post_meta($p->ID, $field);
			delete_post_meta($p->ID, $field_ref);
		}
		// Check if $args is a post_id or an array.
		if ( is_int( $args ) ) :
			delete_post_meta($args, $field);
			delete_post_meta($args, $field_ref);
		else :
			$args = is_array( $args ) ? $args : array(
				'post_type'      => get_post_type(),
				'posts_per_page' => -1,
				'meta_key'       => $field,
			);
			$posts = get_posts( $args );
			// Loop over results and delete.
			if ( $posts ) :
				foreach ( $posts as $p ) :
					delete_field_and_ref($p->ID, $field);
				endforeach;
			endif;
		endif; // endif ( $post_id ) :
	}
endif; // endif ( ! function_exists( 'bolt_on_delete_acf_fields' ) ) :

if ( ! function_exists( 'bolt_on_add_inline_style' ) ) :
	/**
	 * Add Inline Style
	 *
	 * @param string $selector - Selector for Style Rule
	 * @param array $rule_array - opacity value from customizer.
	 * @param string $validator - optional value for validation checking.
	 * @param string|array $media_query - optional value for Media Query Breakpoint.
	 * @return string $rule - The completed Style Rule.
	 * 
	 */
	function bolt_on_add_inline_style(
		$selector,
		$rule_array,
		$validator = true,
		$media_query = null
	) {
		if ( $validator ) :
			$rule = $selector . '{';
			foreach ( $rule_array as $property => $value ) :
				$rule .=	$property . ':' . $value . ';';
			endforeach;
			$rule .= '}';
			if ( $media_query ) :
				// Check if $media_query is string or array.
				if ( is_array( $media_query ) ) :
					$media_string = '@media ';
					foreach ( $media_query as $single_media_query ) :
						// Check if first $single_media_query.
						if ( $single_media_query === reset( $media_query ) ) :
							$media_string .= '(' . $single_media_query . ')';
						else :
							$media_string .= ' and (' . $single_media_query . ')';
						endif;
					endforeach;
					$media_string .= ') {' .
						$rule .
					'}';
					$rule = $media_string;
				endif;
				if ( is_string( $media_query ) ) :
				$rule = '@media (' . $media_query . ') {' .
									$rule .
								'}';
				endif;
			endif;
			return $rule;
		endif;
	}
endif; // endif ( ! function_exists( 'bolt_on_add_inline_style' ) ) :

if ( ! function_exists( 'bolt_on_minify_css' ) ) :
	require_once get_template_directory() . '/inc/minify-css.php';
	$singleQuoteSequenceFinder = new QuoteSequenceFinder('\'');
	$doubleQuoteSequenceFinder = new QuoteSequenceFinder('"');
	$blockCommentFinder = new StringSequenceFinder('/*', '*/');
	/**
	 * Minify CSS
	 *
	 * @param string $css - CSS Rules to be minified
	 * @return string $css - Minified Style.
	 */
	function bolt_on_minify_css( $css ) {
		global $minificationStore, $singleQuoteSequenceFinder, $doubleQuoteSequenceFinder, $blockCommentFinder;
		$css_special_chars = array(
			$blockCommentFinder, // CSS Comment
			$singleQuoteSequenceFinder, // single quote escape, e.g. :before{ content: '-';}
			$doubleQuoteSequenceFinder // double quote
		);
		// pull out everything that needs to be pulled out and saved
		while ( $sequence = getNextSpecialSequence( $css, $css_special_chars ) ) {
			switch ( $sequence->type ) {
				case '/*': // remove comments
					$css = substr( $css, 0, $sequence->start_idx ) . substr( $css, $sequence->end_idx );
					break;
				default: // strings that need to be preservered
				$placeholder = getNextMinificationPlaceholder();
				$minificationStore[$placeholder] = substr( $css, $sequence->start_idx, $sequence->end_idx - $sequence->start_idx );
				$css = substr( $css, 0, $sequence->start_idx ) . $placeholder . substr( $css, $sequence->end_idx );
			}
		}
			// minimize the string
			$css = preg_replace('/\s{2,}/s', ' ', $css);
			$css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
			$css = preg_replace('/;}/', '}', $css);
			// put back the preserved strings
			foreach ( $minificationStore as $placeholder => $original ) {
				$css = str_replace($placeholder, $original, $css);
			}
		return trim($css);
	}
endif; // endif ( ! function_exists( 'bolt_on_minify_css' ) ) :

if ( ! function_exists( 'bolt_on_wide_tall_image' ) ) :
	/**
	 * Determine if image is wider than tall or vice-versa.
	 * @param int|array $arg - Can be image ID or Size array(width,height).
	 * @return string 'object-fit-cover ' . 'wide' || 'tall' || 'square'.
	 */
	function bolt_on_wide_tall_image( $arg ) {
		if ( ! $arg ) :
			return;
		endif;
		$return_result = 'object-fit-cover ';
		$image_id      = null;
		$size          = null;
		$image_width   = null;
		$image_height  = null;
		if ( is_int( $arg ) ) :
			$image_id = $arg;
		endif;
		if ( is_array( $arg ) ) :
			$size = $arg;
		endif;
		if ( $image_id ) :
			$image_details = wp_get_attachment_image_src( $image_id, 'full' );
			$image_width   = $image_details[1];
			$image_height  = $image_details[2];
		endif;
		if ( $size ) :
			$image_width  = $size[0];
			$image_height = $size[1];
		endif;
		if ( $image_width > $image_height ) :
			$return_result .= 'wide';
		elseif ( $image_width < $image_height ) :
			$return_result .= 'tall';
		else:
			$return_result .= 'square';
		endif;
		return $return_result;
	}
endif; // if ( ! function_exists( 'bolt_on_wide_tall_image' ) ) :

if ( ! function_exists( 'bolt_on_get_optimal_image_size' ) ) :
	/**
	 * Get Optimal image size when only one dimension is provided
	 * 
	 * @param int $image_id - Post ID for image.
	 * @param array $size - $size[0] = width and $size[1] = height.
	 * @param array $aspect_ratio - $aspect_ratio[0] = Aspect Ratio Width
	 * $aspect_ratio[1] = Aspect Ratio Height
	 * Desired aspect ratio is used to calculate
	 * the null dimension in $size array. Default is 16/9.
	 * @return array $size_array returns provided $size and calculated $size.
	 */
	function bolt_on_get_optimal_image_size(
		$image_id     = null,
		$size         = array( null, null ),
		$aspect_ratio = array( 16, 9 )
	) {
		if ( ! $image_id ) :
			return;
		endif;
		$size_array = array();
		// Get Image dimensions.
		$image_details       = wp_get_attachment_image_src( $image_id, 'full' );
		$image_width         = $image_details[1];
		$image_height        = $image_details[2];

		// Determine whether min_height is at least 56.25% of min_width
		$min_width           = $size[0];
		$min_height          = $size[1];
		$aspect_ratio_width  = $aspect_ratio[0];
		$aspect_ratio_height = $aspect_ratio[1];

		// If $min_width was provided we need to calculate Height.
		if ( $min_width ) :
			$provided_min_dimension    = $min_width;
			$actual_provided_dimension = $image_width;
			$actual_missing_dimension  = $image_height;
			$aspect_ratio_dividend     = $aspect_ratio_height;
			$aspect_ratio_divisor      = $aspect_ratio_width;
			$provided_dimension_index  = 0;
			$missing_dimension_index   = 1;
		else:
			$provided_min_dimension    = $min_height;
			$actual_provided_dimension = $image_height;
			$actual_missing_dimension  = $image_width;
			$aspect_ratio_dividend     = $aspect_ratio_width;
			$aspect_ratio_divisor      = $aspect_ratio_height;
			$provided_dimension_index  = 1;
			$missing_dimension_index   = 0;
		endif;
		$optimal_provided_dimension  = $actual_provided_dimension;

		$aspect_ratio_multiplicand   = $aspect_ratio_dividend / $aspect_ratio_divisor;

		// Whichever value was not provided (height or width) needs to be calculated.
		$calc_missing_dimension      = $provided_min_dimension *
			$aspect_ratio_multiplicand;

		$calc_min_missing_dimension  = $calc_missing_dimension /
			$provided_min_dimension *
			$actual_missing_dimension;

		$calc_min_provided_dimension = $actual_provided_dimension /
			$actual_missing_dimension *
			$calc_missing_dimension;

		$optimal_missing_dimension = $calc_missing_dimension /
			$calc_min_provided_dimension *
			$provided_min_dimension;

		$size_array[$provided_dimension_index] = $optimal_provided_dimension;
		$size_array[$missing_dimension_index]  = $optimal_missing_dimension;

		return $size_array;
	}
endif; // endif ( ! function_exists( 'bolt_on_get_optimal_image_size' ) ) :

if ( ! function_exists( 'bolt_on_get_youtube_video_id' ) ) :
	/**
	 * Get Youtube ID from URL String.
	 * 
	 * @param string $page_vid_url - The Video URL
	 * 
	 * @return string Youtube Video ID.
	 */
	function bolt_on_get_youtube_video_id( $youtube_url ) {
		$link     = $youtube_url;
		$video_id = explode( "?v=", $link );
		if ( ! isset( $video_id[1] ) ) :
			$video_id = explode( "youtu.be/", $link );
		endif;
		$youtubeID = $video_id[1];
		if ( empty( $video_id[1] ) ) :
			$video_id = explode( "/v/", $link );
		endif;
		$video_id       = explode( "&", $video_id[1] );
		$youtube_video_id = $video_id[0];
		if ( $youtube_video_id ) :
			return $youtube_video_id;
		else :
			return false;
		endif;
}
endif; // endif ( ! function_exists( 'bolt_on_get_youtube_video_id' ) ) :

if ( ! function_exists( 'bolt_on_get_video_thumbnail' ) ) :
	/**
	 * Get Thumbnail from Video using oEmbed.
	 * 
	 * @param string $video_url - The Video URL
	 * 
	 * @return string Video Thumbnail URL.
	 */
	function bolt_on_get_video_thumbnail( $video_url = null ) {
		if ( ! $video_url ) :
			return false;
		else:

		$youtube_video_id = bolt_on_get_youtube_video_id( $video_url );
		$img = 'https://img.youtube.com/vi/' . $youtube_video_id . '/hqdefault.jpg';
		return $img;
	endif;
}
endif; // endif ( ! function_exists( 'bolt_on_get_video_thumbnail' ) ) :

if ( ! function_exists( 'get_first_contact_form' ) ) :
	/**
	 * Get First Contact Form.
	 * 
	 * @return string Contact Form 7 Markup.
	 */
	function get_first_contact_form() {
		$args = array(
			'numberposts' => 1,
			'order'       => 'ASC',
			'orderby'     => 'date',
			'post_type'   => 'wpcf7_contact_form',
		);
		$contact_forms_array = get_posts( $args );
		if ( is_array( $contact_forms_array ) ) :
			 $contact_form = $contact_forms_array[0];
			 return do_shortcode( '[contact-form-7 id="' . $contact_form->ID . '" title="' . $contact_form->post_title . '"]' );
		else:
			return false;
		endif;
	}
endif; // endif ( ! function_exists( 'get_first_contact_form' ) ) :

if ( ! function_exists( 'bolt_on_banner' ) ) :
	/**
	 * Set up Bolt On Banner.
	 *
	 * @param string $styles pass the styles tag in so the inline style can be contantenated.
	 * 
	 * @return string $styles.
	 */
	function bolt_on_banner( $styles ) {
		$bg_banner_src  = null;
		$banner_size    = array(1920, null);
		$queried_object = get_queried_object();
		if ( $queried_object && has_post_thumbnail( $queried_object ) ) :
			$bg_banner_src = get_the_post_thumbnail_url( $queried_object, $banner_size );
		elseif( $default_post_image = get_theme_mod( 'default_banner_image', null ) ) :
			$bg_banner_src =  wp_get_attachment_image_url( $default_post_image, $banner_size );
		endif;
		if ( $bg_banner_src ) :
			$styles .= bolt_on_add_inline_style(
				'.bolt-on-banner:before',
				array(
					'background-image' => 'url(' . $bg_banner_src . ')',
				)
			);
		endif;
		return $styles;
	}
endif; // endif ( ! function_exists( 'bolt_on_banner' ) ) :

if ( ! function_exists( 'get_practice_area_parents' ) ) :
	/**
	 * Get Practice Area Parents.
	 *
	 * @return WP_Query - object with found parent-level practice areas.
	 */
	function get_practice_area_parents() {
		$post_type = 'practice-areas';

		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'post_parent'    => 0,
			'orderby'        => array(
				'menu_order',
				'date'
			),
			'order'          => 'ASC'
		);
		$post_query = new WP_Query($args);
		return $post_query;
	}
endif; // endif ( ! function_exists( 'get_practice_area_parents' ) ) :