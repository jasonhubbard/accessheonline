<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package nmbs
 */
?>
	<div id="secondary" class="widget-area col-md-4 col-sd-4" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search well">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget well">
				<h1 class="widget-title"><?php _e( 'Archives', 'nmbs' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget well">
				<h1 class="widget-title"><?php _e( 'Meta', 'nmbs' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
