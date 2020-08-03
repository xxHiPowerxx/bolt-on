<?php
/**
 * This Component Renders A Dynamic Post Menu with Children
 * 
 * @param array $args can use $args['child_level'] to get nested children.
 * 
 * @package bolt-on
 */
function component_dynamic_post_menu( $args ) {

	// If no child_level Provided Default to Max of 2.
	if (
		! isset( $args['child_level'] ) ||
		$args['child_level'] > 2
	) :
		$args['child_level'] = 2;
	endif;

	// Get the top page in the current tree
	global $post;

	// Current Post Class defaults to null.
	$current_post_last_ancestor = false;
	$post_ancestors             = get_post_ancestors( $post );
	if ( $post_ancestors ) :
		$last_ancestor      = get_post( end( $post_ancestors ) );
		$last_ancestor_link = get_the_permalink( $last_ancestor );
	else :
		$last_ancestor      = $post;
		$last_ancestor_link = '#';
	endif;
	$last_ancestor_title = get_the_title( $last_ancestor );
	$imm_children_args   = array(
		'posts_per_page' => -1,
		'post_parent'    => $last_ancestor->ID,
		'post_type'      => get_post_type(),
	);
	$imm_children        = get_children( $imm_children_args );

	ob_start();
	if ( $imm_children ) :
		?>
	
		<ul class="menu">
			<?php
			foreach ( $imm_children as $imm_child ) :
				$post_title         = esc_attr( $imm_child->post_title );
				// Check If Child is Current Post.
				if ( $imm_child->ID === $post->ID ) :
					$current_post_class = ' current-post';
					$post_link          = '#';
				else :
					$current_post_class = null;
					$post_link          = esc_url( get_the_permalink( $imm_child->ID ) );
				endif;
				$_imm_children_args = array(
					'posts_per_page' => -1,
					'post_parent'    => $imm_child->ID,
					'post_type'      => get_post_type(),
				);
				$_imm_children = get_children( $_imm_children_args );
				?>
				<li class="menu-item<?php echo $current_post_class; ?>">
					<a href="<?php echo $post_link; ?>" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></a>
					<?php if ( $_imm_children && $args['child_level'] > 0 ) : ?>
						<ul class="sub-menu">
							<?php
							foreach ( $_imm_children as $_imm_child ) :
								$_post_title         = esc_attr( $_imm_child->post_title );
								// Check If Child is Current Post.
								if ( $_imm_child->ID === $post->ID ) :
									$current_post_class = ' current-post';
									$_post_link         = '#';
								else :
									$current_post_class = null;
									$_post_link         = esc_url( get_the_permalink( $_imm_child->ID ) );
								endif;
								$__imm_children_args = array(
									'posts_per_page' => -1,
									'post_parent'    => $_imm_child->ID,
									'post_type'      => get_post_type(),
								);
								$__imm_children = get_children( $__imm_children_args );
								?>
								<li class="menu-item<?php echo $current_post_class; ?>">
									<a href="<?php echo $_post_link; ?>" title="<?php echo $_post_title; ?>"><?php echo $_post_title; ?></a>
									<?php if ( $__imm_children && $args['child_level'] > 1 ) : ?>
										<ul class="sub-menu">
											<?php
											foreach ( $__imm_children as $__imm_child ) :
												$__post_title = esc_attr( $__imm_child->post_title );
												// Check If Child is Current Post.
												if ( $_imm_child->ID === $post->ID ) :
													$current_post_class = ' current-post';
													$__post_link        = '#';
												else :
													$current_post_class = null;
													$__post_link        = esc_url( get_the_permalink( $__imm_child->ID ) );
												endif;
												?>
												<li class="menu-item<?php echo $current_post_class; ?>">
													<a href="<?php echo $__post_link; ?>" title="<?php echo $__post_title; ?>"><?php echo $__post_title; ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	endif; // endif ( $imm_children ) :
	$markup = ob_get_clean();
	$return_result = array (
		'markup'              => $markup,
		'last_ancestor_title' => $last_ancestor_title,
		'last_ancestor_link'  => $last_ancestor_link,
	);
	return $return_result;
}