<?php
/**
 * Product template
 *
 * DISCLAIMER
 *
 * Do not edit or add directly to this file if you wish to upgrade Jigoshop to newer
 * versions in the future. If you wish to customise Jigoshop core for your needs,
 * please use our GitHub repository to publish essential changes for consideration.
 *
 * @package             Jigoshop
 * @category            Catalog
 * @author              Jigoshop
 * @copyright           Copyright © 2011-2013 Jigoshop.
 * @license             http://jigoshop.com/license/commercial-edition
 */
 ?>

<?php get_header('shop'); ?>

<header class="jumbotron page-header">
	<div class="container">
		<?php if (is_search()) : ?>
		<h1><?php _e('Search Results:', 'jigoshop'); ?> &ldquo;<?php the_search_query(); ?>&rdquo; <?php if (get_query_var('paged')) echo ' &mdash; Page '.get_query_var('paged'); ?></h1>
		<?php else : ?>
			<?php echo apply_filters( 'jigoshop_products_list_title', '<h1 class="page-title">' . __( 'All Products', 'jigoshop' ) . '</h1>' ); ?>
		<?php endif; ?>
	</div>
	<?php if(get_option('nmbs_header_img')) : ?>
	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_header_img'); ?>&h=345&w=945"/>
	<?php endif; ?>
</header>


<div id="page" class="hfeed site container">
	<div id="content" class="row">

	<div id="primary" class="content-area col-md-8">
		<main id="main" class="site-main" role="main">

			<?php do_action('jigoshop_before_main_content'); // <div id="container"><div id="content" role="main"> ?>

				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); global $_product; $_product = new jigoshop_product( $post->ID ); ?>

					<?php do_action('jigoshop_before_single_product', $post, $_product); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php do_action('jigoshop_before_single_product_summary', $post, $_product); ?>

						<div class="summary">

							<?php do_action( 'jigoshop_template_single_summary', $post, $_product ); ?>

						</div>

						<?php do_action('jigoshop_after_single_product_summary', $post, $_product); ?>

					</div>

					<?php do_action('jigoshop_after_single_product', $post, $_product); ?>

				<?php endwhile; ?>

			<?php do_action('jigoshop_after_main_content'); // </div></div> ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action('jigoshop_sidebar'); ?>

<?php get_footer('shop'); ?>