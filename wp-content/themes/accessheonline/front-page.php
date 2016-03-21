<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section style="text-align: center;">
<br><br>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class("row"); ?>>

<div class="four columns offset-by-four">
<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
</div>

			</article>
			<!-- /article -->

		<?php endwhile; ?>


		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
