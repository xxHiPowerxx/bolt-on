<?php
/**
 * Widget areas.
 *
 * @package bolt-on
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bolt_on_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Header Info', 'bolt-on' ),
		'id'            => 'header-info',
		'description'   => esc_html__( 'Add Header Info widget here.', 'bolt-on' ),
		'before_widget' => '<div id="%1$s" class="widget header-info %2$s">',
		'after_widget'  => '</div>',
	));
}
add_action( 'widgets_init', 'bolt_on_widgets_init' );
