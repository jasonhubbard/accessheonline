<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package nmbs
 */
?>
	<div id="secondary" class="widget-area col-md-4 col-sd-4" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>
		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
