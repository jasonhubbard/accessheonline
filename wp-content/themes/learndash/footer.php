<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package nmbs
 */
?>

	</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer" role="contentinfo">

	<div class="site-info container">

		<div id="footer-sidebar" class="widget-area" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'sidebar-3' ) ) : ?>
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary -->
		<p class="footer-text text-center"><?php echo stripslashes(get_option('nmbs_footer_text')); ?><p>
	</div><!-- .site-info -->
</footer><!-- #colophon -->


<?php wp_footer(); ?>

</body>
</html>