<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package nmbs
 */

get_header(); ?>
<header class="jumbotron page-header">
	<div class="container">
		<h1><?php printf( __( 'Search Results for: %s', 'nmbs' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</div>
	<?php if(get_option('nmbs_header_img')) : ?>
	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_header_img'); ?>&h=345&w=945"/>
	<?php endif; ?>
</header>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content row">
		
		<section id="primary" class="content-area col-md-8 col-sd-8">
			<div id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'nmbs' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>

				<?php nmbs_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'search' ); ?>

			<?php endif; ?>

			</div><!-- #main -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>