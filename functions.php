<?php
/**
 * bolt-on functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bolt-on
 */

 /**
 * Utility Functions.
 */
require get_template_directory() . '/inc/utility-functions.php';

if ( ! function_exists( 'bolt_on_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bolt_on_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on bolt-on, use a find and replace
		 * to change 'bolt-on' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'bolt-on', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'archive-thumbnail', 464, 261, array( 'center', 'center' ) );


		// This theme uses wp_nav_menu() in three locations.
		// primary, mobile, and footer-menu.
		register_nav_menus( array(
			'primary-menu-location' => esc_html__( 'Primary Menu Location', 'bolt-on' ),
			'mobile-menu-location' => esc_html__( 'Mobile Menu Location', 'bolt-on' ),
			'footer-menu-location' => esc_html__( 'Footer Menu Location', 'bolt-on' ),
		) );

		// /**
		//  * Limit the Number of Items we can place in the Mobile Menu.
		//  */
		// function limit_mobile_menu_items($items, $args) {
		// 		// want our Mobile Menu to have MAX of 3 items
		// 		if ( $args->theme_location == 'mobile-menu-location' ) {
		// 				$toplinks = 0;
		// 				foreach ( $items as $k => $v ) {
		// 						if ( $v->menu_item_parent == 0 ) {
		// 								// count how many top-level links we have so far...
		// 								$toplinks++;
		// 						}
		// 						// if we've passed our max # ...
		// 						if ( $toplinks > 3 ) {
		// 								unset($items[$k]);
		// 						}
		// 				}
		// 		}
		// 		return $items;
		// }
		// add_filter( 'wp_nav_menu_objects', 'limit_mobile_menu_items', 10, 2 );


		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bolt_on_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'bolt_on_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bolt_on_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'bolt_on_content_width', 640 );
}
add_action( 'after_setup_theme', 'bolt_on_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function bolt_on_assets() {

	// Register Vendor Assets
	// Bootstrap Vendor
	$handle = 'bolt-on-vendor-bootstrap-js';
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		wp_register_script( $handle, get_theme_file_uri( '/vendor/bootstrap/js/bootstrap.bundle.min.js' ), array( 'jquery' ), '4.4.1', true );
	}

	// Fancybox Vendor
	// Fancybox JS
	$fancybox_version = '3.5.7';
	$handle = 'bolt-on-vendor-fancybox-js';
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		wp_register_script( $handle, get_theme_file_uri( '/vendor/fancybox/jquery.fancybox.min.js' ), array( 'jquery' ), $fancybox_version, true );
	}
	// Fancybox CSS
	$handle = 'bolt-on-vendor-fancybox-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, get_theme_file_uri( '/vendor/fancybox/jquery.fancybox.min.css' ), array(), $fancybox_version, 'all' );
	}

	// Fontawesome Vendor
	$handle = 'bolt-on-vendor-fontawesome-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, get_theme_file_uri( '/vendor/fontawesome/css/all.min.css' ), array(), ' 5.7.1', 'all' );
	}

	// Slick Slider Vendor
	// Slick JS
	$slick_version = '1.8.0';
	$handle = 'bolt-on-vendor-slick-js';
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		wp_register_script( $handle, get_theme_file_uri( '/vendor/slick/slick.min.js' ), array( 'jquery' ), $slick_version, true );
	}
	// Slick CSS
	$handle = 'bolt-on-vendor-slick-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, get_theme_file_uri( '/vendor/slick/slick.min.css' ), array(), $slick_version, 'all' );
	}

	// TODO: Remove Slick from Bolt On Dependancies.
	// Register Styles
	$bolt_on_css_path = '/assets/css/bolt-on.css';
	wp_enqueue_style( 'bolt-on-css', get_theme_file_uri( $bolt_on_css_path ), array( 'bolt-on-vendor-fontawesome-css' ), filemtime( get_template_directory() . $bolt_on_css_path ), 'all' );

	$archive_css_path = '/assets/css/archive.css';
	wp_register_style( 'bolt-on-archive-css', get_theme_file_uri( $archive_css_path ), array( 'bolt-on-css' ), filemtime( get_template_directory() . $archive_css_path ), 'all' );

	$content_archive_css_path = '/assets/css/content-archive.css';
	wp_register_style( 'bolt-on-content-archive-css', get_theme_file_uri( $content_archive_css_path ), array( 'bolt-on-css' ), filemtime( get_template_directory() . $content_archive_css_path ), 'all' );

	$google_font_css_path = 'https://fonts.googleapis.com/css';
	wp_enqueue_style( 'google-font-css', $google_font_css_path . '?family=Lora:400,400i,700,700i|Montserrat:100,200,300,300i,400,500,500i,600,600i,700,800,900', array(), '', 'all' );

	$bolt_on_404_css_path = '/assets/css/404.css';
	wp_register_style( 'bolt-on-404-css', get_theme_file_uri( $bolt_on_404_css_path ), array( 'bolt-on-css' ), filemtime( get_template_directory() . $bolt_on_404_css_path ), 'all' );

	$bolt_on_search_css_path = '/assets/css/search.css';
	wp_register_style( 'bolt-on-search-css', get_theme_file_uri( $bolt_on_search_css_path ), array( 'bolt-on-css' ), filemtime( get_template_directory() . $bolt_on_search_css_path ), 'all' );

	$fixed_width_page_css_path = '/assets/css/fixed-width-page.css';
	wp_register_style( 'fixed-width-page-css', get_theme_file_uri( $fixed_width_page_css_path ), array( 'bolt-on-css' ), filemtime( get_template_directory() . $fixed_width_page_css_path ), 'all' );

	// Register Scripts
	$bolt_on_js_path = '/assets/js/bolt-on.js';
	wp_enqueue_script( 'bolt-on-js', get_theme_file_uri( $bolt_on_js_path ), array( 'jquery', 'bolt-on-vendor-bootstrap-js' ), filemtime( get_template_directory() . $bolt_on_js_path ), false );

	$bolt_on_navigation_path = '/assets/js/navigation.js';
	wp_enqueue_script( 'bolt-on-navigation-js', get_theme_file_uri( $bolt_on_navigation_path ), array(), filemtime( get_template_directory() . $bolt_on_navigation_path ), true );

	$bolt_on_skip_link_path = '/assets/js/skip-link-focus-fix.js';
	wp_enqueue_script( 'bolt-on-skip-link-focus-fix-js', get_theme_file_uri( $bolt_on_skip_link_path ), array(), filemtime( get_template_directory() . $bolt_on_skip_link_path ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bolt_on_assets', -1 );

/**
 * Include ACF Functions
 */
require get_template_directory() . '/inc/acf-functions.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Nav Walker
 */
require get_template_directory() . '/inc/custom-nav-walker.php';

/**
 * Widget areas.
 */
require get_template_directory() . '/inc/widget-area.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
	* Disable Contact Form 7 WP Auto P
	*/
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Include Shortcodes
 */
require get_template_directory() . '/inc/shortcodes/shortcodes.php';

/**
 * Include WPCF7 Custom Tags
 */
require get_template_directory() . '/inc/wpcf7-custom-tags.php';

/**
 * Archive Excerpt.
 */
require get_template_directory() . '/inc/archive-excerpt.php';

/**
 * Inline Styles.
 */
require get_template_directory() . '/inc/inline-styles.php';

/**
 * Bootstrap pagination.
 */
require get_template_directory() . '/inc/bootstrap-pagination.php';

/**
 * Custom Taxonomies.
 */
require get_template_directory() . '/inc/custom-taxonomies.php';

/**
 * Custom Post Types.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Site Settings
 */
require get_template_directory() . '/inc/site-settings.php';


/**
 * Only Show Parent-Level Practice Areas in Attorney's Practice Areas Post Types ACF Relationship Field.
 */
function change_posts_order_relationship( $args, $field, $post ) {
	$args['post_parent'] = 0;
	return $args;
}
// add_filter('acf/fields/relationship/query/name=attorney_practice_areas', 'change_posts_order_relationship', 10, 3);
add_filter('acf/fields/relationship/query/name=case_practice_area', 'change_posts_order_relationship', 10, 3);


function save_additional_post_meta_to_cases( $post_id ) {
	if ( function_exists( 'get_field' ) ) :
		global $post;
		if ( $post ) :
			if ( $post->post_type != 'cases' ) :
					return;
			endif;
			/**
			 * Parse Number from Case Result String and Store it as Post Meta
			 */
			function parse_case_result_ammount( $post ) {
				$case_result = get_field( 'case_result' );
				if ( ! $case_result ) :
					return;
				endif;
				$lower_case_result = strtolower( $case_result );

				// Convert String to Number without currency or comma.
				function get_amount( $money ) {
					$clean_string = preg_replace('/([^0-9\.,])/i', '', $money);
					$only_numbers_string = preg_replace('/([^0-9])/i', '', $money);

					$separators_count_to_be_erased = strlen($clean_string) - strlen($only_numbers_string) - 1;

					$string_with_comma_or_dot = preg_replace('/([,\.])/', '', $clean_string, $separators_count_to_be_erased);
					$removed_thousand_separator = preg_replace('/(\,)(?=[0-9]{3,}$)/', '',  $string_with_comma_or_dot);

					return (float) str_replace(',', '.', $removed_thousand_separator);
				}

				$case_result_number = get_amount($lower_case_result);
				if ( strpos( $lower_case_result, 'billion' ) ) :
					$case_result_number *= pow(10, 9);
				elseif ( strpos( $lower_case_result, 'million' ) ) :
					$case_result_number *= pow(10, 6);
				elseif ( strpos( $lower_case_result, 'thousand' ) ) :
					$case_result_number *= pow(10, 3);
				endif;
				return update_post_meta( $post->ID, 'case_result_number', $case_result_number );
				// $post_meta = get_post_meta($post->ID,'case_result_number');

			}
			parse_case_result_ammount( $post );

			/**
			 * The ACF Relationship Field stores Serialized Data
			 * This is not easily or safely queryable, so we will store
			 * the string ourselves so that we easily query it.
			 */
			function save_case_practice_area( $post ) {
				$case_practice_area = get_field( 'case_practice_area' );
				if ( empty( $case_practice_area ) ) :
					return;
				endif;
				
				return update_post_meta( $post->ID, '_case_practice_area_id', $case_practice_area[0]->ID );
			}
			save_case_practice_area( $post );
		endif; // endif ( $post ) :
	endif; // endif ( function_exists( 'get_field' ) ) :
}
add_action('save_post','save_additional_post_meta_to_cases');

/**
 * Redirect Single Case Results to Cases Archive Page.
 */
function redirect_case_results() {
	$post_type = 'cases';
	if ( is_singular( $post_type ) ) :
		$archive_link = get_post_type_archive_link( $post_type );
    wp_redirect( $archive_link, 301 );
    exit;
	endif;
}
add_action( 'template_redirect', 'redirect_case_results' );

/**
 * Prepend First Found Video Category to Video Permalink.
 */ 
function add_video_category_to_post_link($permalink, $post_id, $leavename) {
	if ( strpos( $permalink, '%video-category%' ) === FALSE) :
		return $permalink;
	endif;

	// Get post
	$post = get_post( $post_id );
	if ( ! $post ) :
		return $permalink;
	endif;

	// Get taxonomy terms
	$terms = wp_get_object_terms( $post->ID, 'video-category' );
	if (
		! is_wp_error( $terms ) &&
		! empty( $terms )       &&
		is_object( $terms[0] )
	) :
		$taxonomy_slug = $terms[0]->slug;
	else :
		$taxonomy_slug = 'other';
	endif;

	return str_replace('%video-category%', $taxonomy_slug, $permalink);
}
add_filter( 'post_type_link', 'add_video_category_to_post_link', 10, 3 );

/**
 * Define default terms for custom taxonomies in WordPress
 */
function bolt_on_set_default_video_terms( $post_id, $post ) {
	if ( 'publish' === $post->post_status ) :
		$defaults = array(
			'video-category' => array( 'other' ),
		);
		$taxonomies = get_object_taxonomies( $post->post_type );
		foreach ( (array) $taxonomies as $taxonomy ) :
			$terms = wp_get_post_terms( $post_id, $taxonomy );
			if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) :
				wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
			endif;
		endforeach;
	endif;
}
add_action( 'save_post', 'bolt_on_set_default_video_terms', 100, 2 );

/**
 * Store mobile_nav_breakpoint in GLOBAL variable.
 */
$GLOBALS['mobile_nav_breakpoint'] = get_theme_mod( 'mobile_nav_breakpoint', 1050 );

function google_tag_manager_head() {
	?> 

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-KL8F6KS');</script>
	<!-- End Google Tag Manager -->

	<?php
}
add_action('wp_head','google_tag_manager_head', 20);


function google_tag_manager_body(){
	?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KL8F6KS" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<?php
}
add_action('__before_header','google_tag_manager_body', 20);

/*
// $geo = geoip_detect2_get_external_ip_adress();
// $geo = geoip_detect2_get_info_from_ip($geo);
$geo = geoip_detect2_get_info_from_current_ip();
	?><pre><?php var_dump($geo->); ?></pre><?php
	die;
function wpcf7_geolocation_spam( $spam ) {
  if ( $spam ) {
    return $spam;
	}
	// geoip_detect2_get_info_from_current_ip($locales = array('en'), $options = array());
	$geo = geoip_detect2_get_info_from_current_ip($locales = array('en'), $options = array());
	var_dump($geo);
	// if (  )
  if ( false !== stripos( $_POST['your-message'], 'viagra' ) ) {
    $spam = true;
  }
 
  return $spam;
}
add_filter( 'wpcf7_spam', 'wpcf7_geolocation_spam', 10, 1 );
*/
function add_mail_recipients_on_wpcf7_submit($array) {

	$array['mail-recipients']             = $array['mail-recipients'] ? : '';
	$contact_form_practice_areas_repeater = get_field(
		'contact_form_practice_areas_repeater',
		'options'
	);
	$current_contact_form                 = WPCF7_ContactForm::get_current();
	$message                              = $array['message'] ? : '';

	// Utility Function to Ensure Leading Commas.
	function ensure_leading_commas( $string ) {
		if ( strpos( substr( trim( $string ), 0, 2), ',' ) === false ) :
			$string = ', ' . $string;
		endif;
		return $string;
	}

	// Utility Function to Compare Posted Values with Values Provided in Settings
	// using Exact or Contains Operators to perform the check.
	function compare_ccgofcfi_values( $exact_comparison, $comparand, $comparator ) {
		$comparison = false;
		if ( $exact_comparison ) :
			$comparison = $comparand === $comparator;
		else :
			$comparison = strpos(
				strtolower( $comparand ),
				strtolower( $comparator )
			) !== false ?
				true :
				false;
		endif;
		return $comparison;
	}

	foreach ( (array) $contact_form_practice_areas_repeater as $contact_form_practice_area ) :
		if ( $current_contact_form->id === $contact_form_practice_area['contact_form']->ID ) :
			$mail_recipients          = '';
			$override_mail_recipients = array();
			$added_mail_recipients    = array();
			$case_guid_override       = array();


			// ccgofcfi_repeater = Captorra Case GUID Overrides for Contact Form Inputs Repeater
			$ccgofcfi_repeater = $contact_form_practice_area['ccgofcfi_repeater'];
			foreach ( (array) $ccgofcfi_repeater as $ccgofcfi_entry ) :
				$input_name                           = $ccgofcfi_entry['input_name'];
				$input_value_equals_array_input_value = false;
				// Make sure that submitted information has a field that matches field from override.
				if ( isset( $array[$input_name] ) ) :
					$input_values_repeater = $ccgofcfi_entry['input_values_repeater'];
					foreach ( $input_values_repeater as $index=>$input_value_entry ) :
						$input_value       = $input_value_entry['input_value'];
						$input_value_exact = $input_value_entry['input_value_exact'];
						if ( is_array( $array[$input_name] ) ) :
							// If Input Val from Contact Form is array,
							// Loop through and check to see Contact Form input value is equal
							// to our input value in Field.
							$array_input_values = $array[$input_name];
							foreach ( $array_input_values as $array_input_value ) :
								$input_value_equals_array_input_value = compare_ccgofcfi_values(
									$input_value_exact,
									$array_input_value,
									$input_value
								);
								// If we find our value, break the loop.
								if ( $input_value_equals_array_input_value ) :
									break;
								endif;
							endforeach; // endforeach ( $array_input_values as $array_input_value ) :
						else :
							$input_value_equals_array_input_value = compare_ccgofcfi_values(
								$input_value_exact,
								$array[$input_name],
								$input_value
							);
						endif; // endif ( is_array( $array[$input_name] ) ) :
						if (
							! $input_value ||
							$input_value_equals_array_input_value !== false
						) :
							$extra_mail_recipients = $ccgofcfi_entry['extra_mail_recipients'];
							if ( $extra_mail_recipients ) :
								if ( $ccgofcfi_entry['override_mail_recipients'] ) :
									$override_mail_recipients[] = $extra_mail_recipients;
								else :
									$added_mail_recipients[] = $extra_mail_recipients;
								endif;
							endif; // endif ( $extra_mail_recipients ) :
							if ( $ccgofcfi_entry['captorra_case_guid_override_for_input'] ) :
								if ( ! $case_guid_override['override'] && $ccgofcfi_entry['override_mail_recipients'] ) :
									$case_guid_override['override'] = $ccgofcfi_entry['captorra_case_guid_override_for_input'];
								else :
									$case_guid_override[] = $ccgofcfi_entry['captorra_case_guid_override_for_input'];
								endif;
							endif; // endif ( $ccgofcfi_entry['captorra_case_guid_override_for_input'] ) :
						endif; // endif ( ! $input_value && $input_value === $array[$input_name] ) :
					endforeach; //endforeach ( $input_values_repeater as $input_value ) :
				endif; // endif ( isset( $array[$input_name] ) ) :
			endforeach; // endforeach ( (array) $ccgofcfi_repeater as $ccgofcfi_entry ) :

			// If Override has not been used, check if Post has Override.
			if ( empty( $override_mail_recipients ) ) :
				// Add Extra Mail Recipients set in Post, Practice Area, Page, and Video Post Types
				$post_id                = $array['post-id'];
				$_extra_mail_recipients = get_field( 'extra_mail_recipients', $post_id );
				if ( $_extra_mail_recipients ) :
					$array['mail-recipients'] .= ', ' . $_extra_mail_recipients;
				elseif ( isset( $array['practice-area'] ) ) : // ! if ( $_extra_mail_recipients ) :
					$practice_area_mail_recipients_repeater = $contact_form_practice_area['practice_area_mail_recipients_repeater'];
					foreach ( (array) $practice_area_mail_recipients_repeater as $practice_area_mail_recipient ) :
						$practice_area        = $practice_area_mail_recipient['practice_area'];
						$long_title           = $practice_area->post_title;
						$short_title          = $practice_area->short_title;
						$post_title           = $short_title ? : $long_title;
						$post_title           = wp_specialchars_decode( esc_attr( $post_title ) );
						$decode_practice_area = wp_specialchars_decode( $array['practice-area'] );
						if ( $post_title === $decode_practice_area ) :
							$override_mail_recipients[] = $practice_area_mail_recipient['mail_recipients'];
							break;
						endif;
					endforeach;// endforeach ( (array) $practice_area_mail_recipients_repeater as $practice_area_mail_recipient ) :
				endif; // endif ( $override_mail_recipients ) :
			endif; // endif ( isset( $array['practice-area'] ) ) :

			if ( $array['ccguid'] && ! empty( $case_guid_override ) ) :
				// If Case Guid[Override] is not set, get first in the array.
				if ( $case_guid_override['override'] ) :
					$array['ccguid'] = $case_guid_override['override'];
				else :
					$array['ccguid'] = reset( $case_guid_override );
				endif;
			endif;
			if ( ! empty( $override_mail_recipients ) ) :
				// Ensure that Extra Mail Recipients has a leading comma.
				$mail_recipients = ensure_leading_commas( $override_mail_recipients[0] );
			endif;
			// Add Added Mail Recipients
			if ( ! empty( $added_mail_recipients ) ) :
				// Turn Array into Comma Seperated String.
				$added_mail_recipients_string = implode( ', ', $added_mail_recipients ); 
				$mail_recipients .= ensure_leading_commas( $added_mail_recipients_string );
			endif;
			if ( $mail_recipients !== '' ) :
				$array['mail-recipients'] .= $mail_recipients;
			endif;
			break; // Break Loop if We've found our contact form.
		endif; // endif ( $current_contact_form->id === $contact_form_practice_area['contact_form']->ID ) :
	endforeach ; // endforeach ( (array) $contact_form_practice_areas_repeater as $contact_form_practice_area ) :


	foreach ( $array as $key=>$a ) :
		$_POST[$key] = $array[$key];
	endforeach;

	return $array;
}
add_filter( 'wpcf7_posted_data', 'add_mail_recipients_on_wpcf7_submit', 10, 1 );

/**
 * Find Select Tags in WPCF7 forms and
 * set size attribute to options Length up to a maximum of 5.
 * @link https://stackoverflow.com/questions/46274317/how-to-add-a-custom-attribute
 * @link https://stackoverflow.com/questions/9478330/php-how-can-i-retrieve-a-div-tag-attribute-value
 * @link https://www.php.net/manual/en/book.dom.php
 *
 * @param string - $content - The html loaded from WPCF7 Shortcodes
 * @return string - returns doc $content after size attribute has been added to select tags.
 */
function bolt_on_add_size_to_wpcf7_multiple_select( $content ) {
	$doc     = DOMDocument::loadHTML($content);
	$xpath   = new DOMXPath($doc);
	$query   = "//select";
	$entries = $xpath->query($query);
	// we are replacing content with the Doc Body's children
	foreach ($entries as $entry) :
		$first_option_text = $entry->firstChild->textContent;
		$first_option_text = str_replace( array('-- ',' --'), '', $first_option_text );
		$child_nodes       = $entry->childNodes;
		foreach ( $child_nodes as $key=>$child_node ) :
			$text_content = $child_node->textContent;
			$child_node->setAttribute('title', $text_content);
			if ( $key === 0 ) :
				$first_option_text = str_replace( array('-- ',' --'), '', $text_content );
				$entry->setAttribute('title', $first_option_text);
			endif;
		endforeach;
	endforeach;
	$doc_body    = $doc->getElementsByTagName('body')->childNodes;
	$new_content = $doc->saveHTML( $doc_body );

	return $new_content;
}
add_filter( 'wpcf7_form_elements', 'bolt_on_add_size_to_wpcf7_multiple_select' );

function bolt_on_mod_attorneys_archive_query( $query ) {
	if ( $query->is_post_type_archive( 'attorneys' ) && $query->is_main_query() ) :
			$query->set( 'posts_per_page', -1 );
			$query->set( 'orderby', 'menu_order date' );
			$query->set( 'order', 'ASC' );
	endif;
}
add_filter( 'pre_get_posts', 'bolt_on_mod_attorneys_archive_query' );

//     // define the wpcf7_submit callback 
// function action_wpcf7_submit( $instance, $result ) {
// 	$submission = WPCF7_Submission::get_instance();
// 	$post_id = $submission->get_meta( 'container_post_id' );
// 	var_dump($submission);
// 	die;
// }; 
					 
// 	// add the action 
// 	add_action( 'wpcf7_submit', 'action_wpcf7_submit', 10, 2 ); 