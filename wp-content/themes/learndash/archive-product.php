<?php
/**
 * Archive template
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

	<div id="primary" class="content-area col-md-12">

		<div class="row category-tools">
				<div class="col-md-4">
					<div class="input-group">
						<label for="categories-dropdown" class="input-group-addon">Categories</label>
						<select class="form-control" id="categories-dropdown" name="categories-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> 
							<option value=""><?php echo esc_attr(__('Select category')); ?></option> 
							<?php 
								//$categories = get_categories('taxonomy=courses'); 
								$categories = get_categories(); 
								foreach ($categories as $category) {
									$option = '<option value="'.get_category_link( $category->term_id ).'">';
									$option .= $category->cat_name;
									$option .= ' ('.$category->category_count.')';
									$option .= '</option>';
									echo $option;
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-4">
					<form role="search" method="get" action="<?php echo esc_url( home_url( '/category' ) ); ?>">
						<div class="input-group">
							<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'nmbs' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'nmbs' ); ?>">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary" title="<?php echo esc_attr_x( 'Search', 'submit button', 'nmbs' ); ?>"><span aria-hidden="true" class="icon icon-search i-16"></span></button>
							</span>
						</div><!-- /input-group -->
					</form>
				</div>
			</div>

		<main id="main" class="site-main" role="main">

		<?php do_action('jigoshop_before_main_content'); ?>

		<?php
			$shop_page_id = jigoshop_get_page_id('shop');
			$shop_page = get_post($shop_page_id);
			echo apply_filters('the_content', $shop_page->post_content);
		?>

		<?php 
		ob_start();
		jigoshop_get_template_part( 'loop', 'shop' );
		$products_list_html = ob_get_clean();
		echo apply_filters( 'jigoshop_products_list', $products_list_html );
		?>

		<?php do_action('jigoshop_pagination'); ?>

		<?php do_action('jigoshop_after_main_content'); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //do_action('jigoshop_sidebar'); ?>

<?php get_footer(''); ?>