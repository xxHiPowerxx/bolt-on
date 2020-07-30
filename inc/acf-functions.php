<?php
/**
 * File to handle all ACF Load and Save Fields
 *
 * @package bolt-on
 */

/**
 * Include ACF Dependancy
 */
// Define path and URL to the ACF plugin.
define( 'MY_ACF_PATH', get_template_directory() . '/vendor/advanced-custom-fields/' );
define( 'MY_ACF_URL', get_template_directory_uri() . '/vendor/advanced-custom-fields/' );

// Include the ACF plugin.
include_once( MY_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
	return MY_ACF_URL;
}
// (Optional) Hide the ACF admin menu item.
// add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
// function my_acf_settings_show_admin( $show_admin ) {
//     return false;
// }

/**
 * Load ACF Fields
 */
add_filter( 'acf/settings/load_json', 'xten_json_load_point' );

function xten_json_load_point( $paths ) {

	// remove original path (optional).
	unset( $paths[0] );

	// append path.
	$paths[] = get_template_directory() . '/acf-json';

	// return.
	return $paths;
}

// Check to see if xten Save fields file exsists and adds save point if it does.
$save_acf_fields = get_template_directory() . '/save-acf-fields.php';
// $select_where_to_save_acf_field_groups = get_field('select_where_to_save_acf_field_groups', 'options');
// $select_where_to_save_acf_field_groups = $select_where_to_save_acf_field_groups !== null ? $select_where_to_save_acf_field_groups : 'parent';
// if ( $select_where_to_save_acf_field_groups === 'parent' ) :
	if ( file_exists( $save_acf_fields ) ) :
		require $save_acf_fields;
	endif;
// endif;