<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bolt-on
 */

if ( ! function_exists( 'bolt_on_posted_on' ) ) :
	/**
	 * Prints the header of the current displayed page based on its contents.
	 */
	function bolt_on_index_header() {
		if ( is_home() && ! is_front_page() ) {
			?>
			<header>
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
			<?php
		} elseif ( is_search() ) {
			?>
			<header class="page-header">
				<h1 class="page-title">
				<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'bolt_on' ), '<span>' . get_search_query() . '</span>' );
				?>
				</h1>
			</header><!-- .page-header -->
			<?php
		} elseif ( is_archive() ) {
			?>
			<header class="page-header content-area card-style">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<?php
		}
	}
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 * 
	 * @param {bool} include_updated - Set Whether to include "Date Updated" or not. 
	 */
	function bolt_on_posted_on( $include_updated = false ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( 
			$include_updated === true &&
			get_the_time( 'U' ) !== get_the_modified_time( 'U' )
		) :
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		endif;

		$archive_year  = get_the_time('Y');
		$archive_month = get_the_time('m');

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'bolt-on' ),
			'<a href="' . esc_url( get_month_link( $archive_year, $archive_month ) ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'bolt_on_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function bolt_on_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'bolt-on' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'bolt_on_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bolt_on_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ',&nbsp;', 'bolt-on' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'bolt-on' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'bolt-on' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'bolt-on' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bolt-on' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'bolt-on' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'bolt_on_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 * 
	 * @param string|array $size = 'full' - Optional Argument, Accepts same arguements as wp_get_attachment_image()
	 * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image/
	 * 
	 */
	function bolt_on_post_thumbnail( $size = 'full' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) :
			return;
		endif;
		$image_id = get_post_thumbnail_id();
		$wide_tall;
		if ( $image_id ) :
			$size = bolt_on_get_optimal_image_size( $image_id, $size, array( 16, 9 ) );
			if ( is_array( $size ) ) :
				$wide_tall = bolt_on_wide_tall_image( $size );
			else :
				$wide_tall = bolt_on_wide_tall_image( get_post_thumbnail_id() );
			endif;
		endif;

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( $size, array( 'class' => 'skip-lazy ' . $wide_tall ) ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php
				global $wp_query;
				if ( 0 === $wp_query->current_post ) :
					the_post_thumbnail(
						'full',
						array(
							'class' => 'skip-lazy',
							'alt'   => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				else :
					the_post_thumbnail(
						'post-thumbnail', array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				endif;
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif; // if ( ! function_exists( 'bolt_on_post_thumbnail' ) ) :

/**
 * Prints a link list of the current categories for the post.
 *
 * If additional post types should display categories, add them to the conditional statement at the top.
 */
function bolt_on_post_categories() {
	// Only show categories on post types that have categories.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'bolt-on' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links display-flex flex-row flex-wrap">' . esc_html__( '%1$s', 'bolt-on' ) . ' </span>', $categories_list ); // WPCS: XSS OK.
		}
	}
}
/**
 * Prints edit post/page link when a user with sufficient priveleges is logged in.
 */
function bolt_on_edit_post_link() {
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'bolt-on' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		' </span>'
	);
}

function bolt_on_post_navigation() {
	// Add Class Name to Post Navigation Links.
	function posts_link_class($format){
		$format = str_replace('href=', 'class="theme-style-border" href=', $format);
		return $format;
	}
	add_filter('next_post_link', 'posts_link_class');
	add_filter('previous_post_link', 'posts_link_class');

	$post_type_name = esc_attr( get_post_type_object( get_post_type() )->labels->singular_name );

	the_post_navigation(
		array(
			'prev_text'          => __( '<div class="nav-link-label"><i class="nav-link-label-icon fas fa-chevron-left"></i> <span class="nav-link-label-text">Previous ' . $post_type_name . '</span></div><div class="ctnr-nav-title"><span class="nav-title">%title</span></div>' ),
			'next_text'          => __( '<div class="nav-link-label"><span class="nav-link-label-text">Next ' . $post_type_name . '</span> <i class="nav-link-label-icon fas fa-chevron-right"></i></div><div class="ctnr-nav-title"><span class="nav-title">%title</span></div>' ),
			'screen_reader_text' => __( 'Posts navigation' ),
		)
	);
}