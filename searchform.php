<?php
/**
 * Template for displaying search forms 
 * 
 * @package WordPress
 * @subpackage Bolt-On
 */
global $instance;
$instance = isset( $instance ) ? $instance : 0;
$search_id = esc_attr( 'main-search-' . $instance );
$submit_id = esc_attr( 'submit-search-' . $instance );
?>
<form method="get" class="search-form display-flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="fa fa-search icon-search" for="<?php echo $search_id; ?>"></label>
	<input id="<?php echo $search_id; ?>" type="search" class="input-search form-control" name="s" title="Search" aria-label="Search" required>
	<button id="<?php echo $search_id; ?>" type="submit" class="btn-cta-outer stroke-border btn-submit" aria-label="Search Button" name="submit">
		<span class="btn-cta btn-cta-inner stroke-border-inner">
			<span class="btn-cta-text stroke-border-lvl-three">Search</span>
		</span>
	</button>
</form>
<?php
$instance ++;