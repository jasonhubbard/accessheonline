<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package nmbs
 */

get_header(); ?>

<header class="jumbotron page-header">
	<div class="container">
		<h1><?php the_title(); ?></h1>
	</div>
	<?php if(get_option('nmbs_header_img')) : ?>
	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_header_img'); ?>&h=345&w=945"/>
	<?php endif; ?>
</header>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content row">

	<div id="primary" class="content-area col-md-8 col-sd-8">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
