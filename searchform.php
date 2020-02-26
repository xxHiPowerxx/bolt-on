<?php
/**
 * Template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Bolt-On
 */

?>
<form method="get" class="search-form display-flex align-items-center" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="fa fa-search icon-search" for="main-search"></label>
	<input id="main-search" type="search" class="search" name="s" title="Search" aria-label="Search" required>
	<button id="submit-search" type="submit" class="btn btn-submit btn-primary" aria-label="Search Button" name="submit">Search</button>
</form>