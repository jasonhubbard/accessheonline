<?php get_header(); ?>

<div class="row">
	<main role="main" class="eight columns">
		<!-- section -->
		<section>

			<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

</div>

<?php get_footer(); ?>
