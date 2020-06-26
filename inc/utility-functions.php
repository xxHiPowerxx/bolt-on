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