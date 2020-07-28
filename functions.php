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


		// This theme uses wp_nav_menu() in two locations.
		// primary and footer-menu.
		register_nav_menus( array(
			'primary-menu-location' => esc_html__( 'Primary Menu Location', 'bolt-on' ),
			'footer-menu-location' => esc_html__( 'Footer Menu Location', 'bolt-on' ),
		) );

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

	// Register Styles
	$bolt_on_css_path = '/assets/css/bolt-on.css';
	wp_enqueue_style( 'bolt-on-css', get_theme_file_uri( $bolt_on_css_path ), array( 'bolt-on-vendor-fontawesome-css', 'bolt-on-vendor-slick-css' ), filemtime( get_template_directory() . $bolt_on_css_path ), 'all' );

	$bolt_on_blog_css_path = '/assets/css/content-archive.css';
	wp_register_style( 'content-archive-css', get_theme_file_uri( $bolt_on_blog_css_path ), array( 'bolt-on-css' ), filemtime( get_template_directory() . $bolt_on_blog_css_path ), 'all' );

	$google_font_css_path = 'https://fonts.googleapis.com/css';
	wp_enqueue_style( 'google-font-css', $google_font_css_path . '?family=Lora:400,400i,700,700i|Montserrat:100,200,300,300i,400,500,500i,600,600i,700,800,900', array(), '', 'all' );

	// Register Scripts
	$bolt_on_js_path = '/assets/js/bolt-on.js';
	wp_enqueue_script( 'bolt-on-js', get_theme_file_uri( $bolt_on_js_path ), array( 'jquery', 'bolt-on-vendor-bootstrap-js', 'bolt-on-vendor-slick-js' ), filemtime( get_template_directory() . $bolt_on_js_path ), false );

	$bolt_on_navigation_path = '/assets/js/navigation.js';
	wp_enqueue_script( 'bolt-on-navigation-js', get_theme_file_uri( $bolt_on_navigation_path ), array(), filemtime( get_template_directory() . $bolt_on_navigation_path ), true );

	$bolt_on_skip_link_path = '/assets/js/skip-link-focus-fix.js';
	wp_enqueue_script( 'bolt-on-skip-link-focus-fix-js', get_theme_file_uri( $bolt_on_skip_link_path ), array(), filemtime( get_template_directory() . $bolt_on_skip_link_path ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bolt_on_assets' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
 * Archive Excerpt.
 */
require get_template_directory() . '/inc/archive-excerpt.php';

/**
 * Custom Taxonomies.
 */
require get_template_directory() . '/inc/custom-taxonomies.php';

/**
 * Custom Post Types.
 */
require get_template_directory() . '/inc/custom-post-types.php';


/**
 * Only Show Parent-Level Practice Areas in Attorney's Practice Areas Post Types ACF Relationship Field.
 */
function change_posts_order_relationship( $args, $field, $post ) {
	$args['post_parent'] = 0;
	return $args;
}
add_filter('acf/fields/relationship/query/name=attorney_practice_areas', 'change_posts_order_relationship', 10, 3);
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
