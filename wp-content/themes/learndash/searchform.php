<?php
/**
 * The template for displaying search forms in nmbs
 *
 * @package nmbs
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'nmbs' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'nmbs' ); ?>">
	   
		<span class="input-group-btn">
	    	<button type="submit" class="search-submit btn btn-primary" title="<?php echo esc_attr_x( 'Search', 'submit button', 'nmbs' ); ?>"><span aria-hidden="true" class="icon icon-search i-16"></span></button>
	    </span>
    </div>
</form>
