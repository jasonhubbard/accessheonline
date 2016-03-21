<?php
/**
 * @package nmbs
 */

get_header(); ?>

<header class="jumbotron page-header">
	<div class="container">
		<h1>Courses</h1>
	</div>
	<?php if(get_option('nmbs_header_img')) : ?>
	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_header_img'); ?>&h=345&w=945"/>
	<?php endif; ?>
</header>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content row">

		<section id="primary" class="content-area col-md-12">
			<div class="row category-tools">
				<div class="col-md-4">
					<div class="input-group">
						<label for="categories-dropdown" class="input-group-addon">Categories</label>
						<select class="form-control" id="categories-dropdown" name="categories-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> 
							<option value=""><?php echo esc_attr(__('Select category')); ?></option> 
							<?php 
								//$categories = get_categories('taxonomy=courses'); 
								$categories = get_categories('exclude=1'); 
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
		
			<div id="main" class="site-main courses-grid" role="main">

			<?php if (have_posts() ) : ?>

				
					<?php /* Start the Loop */ ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'courses' );?>

					<?php endwhile; ?>


				<?php nmbs_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>

			</div><!-- #main -->
		</section><!-- #primary -->
<?php get_footer(); ?>