<?php
/**
 * Template part for displaying Single Case posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bolt-on
 */

$case_result        = esc_attr(get_field( 'case_result' ) );
$case_practice_area = get_field( 'case_practice_area' );
$case_title         = get_the_title();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card-style bg-white'); ?>>
	<?php if ( $case_result || $case_practice_area ) : ?>
		<div class="ctnr-case-result-practice-area">
			<?php if ( $case_result ) : ?>
				<div class="case-result">
					<?php echo $case_result; ?>
				</div>
			<?php endif; ?>
			<?php
			if ( ! empty( $case_practice_area ) ) :
				$case_practice_area_id    = $case_practice_area[0]->ID;
				$case_practice_area_link  = get_the_permalink( $case_practice_area_id );
				$case_practice_area_title = esc_attr( $case_practice_area[0]->post_title );
				?>
				<a href="<?php echo $case_practice_area_link; ?>" class="anchor-case-practice-area">
					<?php echo $case_practice_area_title; ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="ctnr-case-title">
		<h2 class="case-title"><?php echo $case_title; ?></h2>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
