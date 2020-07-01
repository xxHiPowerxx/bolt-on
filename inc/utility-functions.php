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
					$media_string .= '){' .
						$rule .
					'}';
					$rule = $media_string;
				endif;
				if ( is_string( $media_query ) ) :
				$rule = '@media (' . $media_query . '){' .
									$rule .
								'}';
				endif;
			endif;
			return $rule;
		endif;
	}
endif; // endif ( ! function_exists( 'bolt_on_add_inline_style' ) ) :