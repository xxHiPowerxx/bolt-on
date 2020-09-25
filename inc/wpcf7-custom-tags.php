<?php
/**
 * Contact Form 7 Custom Tags.
 *
 * @package bolt-on
 */

function wpcf7_mail_recipients_tag_handler($tag){
	// var_dump($tag);
	$select_name = 'default-mail-recipients-name';
	if ( ! empty( $tag->options ) ) :
		$select_name = $tag->options[0];
	endif;

	// Get Parent Level Practice Areas
	$parent_query = get_practice_area_parents();
	if ( $parent_query->have_posts() ) :
		$posts_data = array();
		while ( $parent_query->have_posts() ) :
			$parent_query->the_post();
			$mail_recipients = get_field( 'mail_recipients' );
			if ( $mail_recipients ) :
				$long_title              = get_the_title();
				$short_title             = esc_attr( get_field( 'short_title' ) );
				$post_title              = $short_title ? : $long_title;
				$key = strrev( $post_title );
				$encrypted_mail_recipients = crypto_js_aes_encrypt(
					$key,
					$mail_recipients
				);
				$posts_data[$post_title] = $encrypted_mail_recipients;
				$posts_data['key'] = $key;
			endif;
		endwhile;
	endif;
	//create html and return

	$html = '<input type="hidden" disabled class="selectHiddenOptionTar" name="' . $select_name . '" />';

	return $html;

}

/**
 * Get Contact Form Practice Areas
 * That are configured in Site Settings Page.
 *
 */
function bolt_on_contact_form_practice_areas(){

	// Get Practice Areas for this Contact Form.
	$current_contact_form                 = WPCF7_ContactForm::get_current();
	$contact_form_practice_areas_repeater = get_field(
		'contact_form_practice_areas_repeater',
		'options'
	);
	$practice_area_titles                 = array();

	foreach ( (array) $contact_form_practice_areas_repeater as $contact_form_practice_area ) :
		$contact_form = $contact_form_practice_area['contact_form'];
		if (
			property_exists( $contact_form, 'ID' ) &&
			property_exists( $current_contact_form, 'id' )
		) :
			if( $contact_form->ID === $current_contact_form->id ) :
				$practice_area_mail_recipients_repeater = $contact_form_practice_area['practice_area_mail_recipients_repeater'];
				foreach ( (array) $practice_area_mail_recipients_repeater as $practice_area_mail_recipient ) :
					$practice_area = $practice_area_mail_recipient['practice_area'];
					if ( $practice_area ) :
						$long_title  = $practice_area->post_title;
						$short_title = $practice_area->short_title;
						$post_title  = $short_title ? : $long_title;
						$post_title  = esc_attr( $post_title );

						$practice_area_titles[$post_title] = $post_title;
					endif; // endif ( $practice_areas ) :
				endforeach;// endforeach ( (array) $practice_area_mail_recipients_repeater as $practice_area_mail_recipient ) :
				// Break foreach loop.
				break; 
			endif; // endif( $contact_form->ID === $current_contact_form->id ) :
		endif;
	endforeach ; // endforeach ( (array) $contact_form_practice_areas_repeater as $contact_form_practice_area ) :

	return $practice_area_titles;
}

/**
 * Create Practice Areas Custom Contact Form 7 Tag.
 * 
 * @link https://stackoverflow.com/questions/42792051/how-to-make-custom-form-tag-in-contact-form-7-required
 */
function wpcf7_practice_areas_tag_handler( $tag ) {

	$tag = new WPCF7_FormTag( $tag );

	if ( empty( $tag->name ) ) :
		return '';
	endif;

	$validation_error = wpcf7_get_validation_error( $tag->name );
	$class            = wpcf7_form_controls_class( $tag->type );

	if ( $validation_error ) :
		$class .= ' wpcf7-not-valid';
	endif;

	$atts          = array();
	$atts['class'] = $tag->get_class_option( $class );
	$atts['id']    = $tag->get_id_option();

	if ( $tag->is_required() ) :
		$atts['aria-required'] = 'true';
	endif;

	$atts['aria-invalid']  = $validation_error ? 'true' : 'false';
	$atts['name']          = $tag->name;
	$atts['autocomplete']  = 'off';
	$atts                  = wpcf7_format_atts( $atts );
	$html                  = '<option value="">-- Practice Area --</option>';
	$practice_areas_titles = bolt_on_contact_form_practice_areas();
	foreach( $practice_areas_titles as $practice_areas_title ) :
		global $post;
		$long_title  = $post->post_title;
		$short_title = $post->short_title;
		$post_title  = $short_title ? : $long_title;
		$post_title  = esc_attr( $post_title );
		$selected    = null; 
		if ( $post_title === $practice_areas_title ) :
			$selected = ' selected="selected"';
		endif;
		$html .= sprintf( '<option value="%1$s"%2$s>%1$s</option>', esc_attr( $practice_areas_title ), $selected );
	endforeach;

	$html .= '<option value="Other">Other</option>';

	$html = sprintf(
		'<span class="wpcf7-form-control-wrap %1$s"><select %2$s>%3$s</select>%4$s</span>',
		sanitize_html_class( $tag->name ),
		$atts,
		$html,
		$validation_error
	);

	return $html;
}

function bolt_on_wpcf7_tag_generator() {
	wpcf7_add_form_tag( array( 'practice_areas', 'practice_areas*' ), 
	'wpcf7_practice_areas_tag_handler', true );
	wpcf7_add_form_tag('mail_recipients', 'wpcf7_mail_recipients_tag_handler');
}
add_action( 'wpcf7_init', 'bolt_on_wpcf7_tag_generator' );

/**
 * Validation filter for practice_areas tag.
 * 
 * @link https://stackoverflow.com/questions/42792051/how-to-make-custom-form-tag-in-contact-form-7-required
 */
function bolt_on_wpcf7_validation_filter( $result, $tag ) {
	$tag = new WPCF7_FormTag( $tag );

	$name = $tag->name;

	if ( isset( $_POST[$name] ) && is_array( $_POST[$name] ) ) {
		foreach ( $_POST[$name] as $key => $value ) {
			if ( '' === $value ) {
				unset( $_POST[$name][$key] );
			}
		}
	}

	$empty = ! isset( $_POST[$name] ) || empty( $_POST[$name] ) && '0' !== $_POST[$name];

	if ( $tag->is_required() && $empty ) {
		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
	}

	return $result;
}
add_filter( 'wpcf7_validate_practice_areas', 'bolt_on_wpcf7_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_practice_areas*', 'bolt_on_wpcf7_validation_filter', 10, 2 );