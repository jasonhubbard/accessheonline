<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package nmbs
 */

get_header(); ?>

<header class="jumbotron page-header">
	<div class="container">
		<h1><?php
			if ( is_category() ) :
				single_cat_title();

			elseif ( is_tag() ) :
				single_tag_title();

			elseif ( is_author() ) :
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				*/
				the_post();
				printf( __( 'Author: %s', 'nmbs' ), '<span class="vcard">' . get_the_author() . '</span>' );
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();

			elseif ( is_day() ) :
				printf( __( 'Day: %s', 'nmbs' ), '<span>' . get_the_date() . '</span>' );

			elseif ( is_month() ) :
				printf( __( 'Month: %s', 'nmbs' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

			elseif ( is_year() ) :
				printf( __( 'Year: %s', 'nmbs' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

			elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
				_e( 'Asides', 'nmbs' );

			elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
				_e( 'Images', 'nmbs');

			elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
				_e( 'Videos', 'nmbs' );

			elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
				_e( 'Quotes', 'nmbs' );

			elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
				_e( 'Links', 'nmbs' );

			else :
				_e( 'Archives', 'nmbs' );

			endif;
		?></h1>

		<?php
			// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;
		?>
	</div>
	<?php if(get_option('nmbs_header_img')) : ?>
	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_header_img'); ?>&h=345&w=945"/>
	<?php endif; ?>
</header>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content row">

		<?php if ( is_category() ) : ?>
		<section id="primary" class="content-area col-md-12">
			<div class="row category-tools">
				<div class="col-md-4">
					<div class="input-group">
						<label for="categories-dropdown" class="input-group-addon">Categories</label>
						<select class="form-control" id="categories-dropdown" name="categories-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> 
							<option value=""><?php echo esc_attr(__('Select category')); ?></option> 
							<?php 
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
		<?php else: ?>
		<section id="primary" class="content-area col-md-8 col-sd-8">
		<?php endif; ?>
		
			<div id="main" class="site-main" role="main">

			<?php if (have_posts() ) : ?>

				<?php if ( is_category() ) : ?>
				<div class="row">
				<?php endif; ?>
				
					<?php /* Start the Loop */ ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							if ( is_category() ) : 
								get_template_part( 'content', 'courses' );
							else :
								get_template_part( 'content', get_post_format() );
							endif;
						?>

					<?php endwhile; ?>

				<?php if ( is_category() ) : ?>
				</div>
				<?php endif; ?>

				<?php nmbs_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>

			</div><!-- #main -->
		</section><!-- #primary -->

<?php if ( ! is_category() ) : ?>
<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>
