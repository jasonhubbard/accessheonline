<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package nmbs
 */

get_header(); ?>

<header class="jumbotron page-header">
	<div class="container">
		<h1><?php _e( 'Oops! That page can&rsquo;t be found.', 'nmbs' ); ?></h1>
	</div>
	<?php if(get_option('nmbs_header_img')) : ?>
	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_header_img'); ?>&h=345&w=945"/>
	<?php endif; ?>
</header>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content row">

	<div id="primary" class="content-area col-md-12">
		<div id="main" class="site-main" role="main">

			<section class="error-404 not-found">

				<div class="page-content">

					<div class="row">
						<p class="col-md-8  col-md-offset-2 text-center"><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'nmbs' ); ?></p>
					</div>

					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center">
							<?php get_search_form(); ?>
						</div>
					</div>

					<p></p>

					<div class="row">
						<div class="col-md-4">
							<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
						</div>
						<div class="col-md-4">
							<?php if ( nmbs_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
							<div class="widget widget_categories">
								<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'nmbs' ); ?></h2>
								<ul>
								<?php
									wp_list_categories( array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 10,
									) );
								?>
								</ul>
							</div><!-- .widget -->
							<?php endif; ?>
						</div>
						<div class="col-md-4">
							<?php
							/* translators: %1$s: smiley */
							$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'nmbs' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
							?>
						</div>
					</div>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>