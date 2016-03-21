<?php
/**
 * The Template for displaying slider.
 *
 * @package nmbs
 */

?>

<?php if(get_option('nmbs_show_slider')) : ?>
<div id="main-slider" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators"></ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		

		<?php if(get_option('nmbs_slider_1')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_1'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_1'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_2')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_2'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_2'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_3')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_3'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_3'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_4')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_4'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_4'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_5')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_5'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_5'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_6')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_6'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_6'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_7')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_7'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_7'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_8')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_8'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_8'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_9')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_9'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_9'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>

		<?php if(get_option('nmbs_slider_10')) : ?>
		<div class="item">
			<div class="carousel-caption">
				
				<?php $options = get_post_meta (get_option('nmbs_slider_10'), '_slider_options', true);?>
				<h3><?php echo $options['title']; ?></h3>
				<p><?php echo $options['text']; ?></p>
				<p><a class="btn btn-primary" href="<?php echo $options['link']; ?>"><?php echo $options['button']; ?></a></p>

			</div>
			<?php echo get_the_post_thumbnail( get_option('nmbs_slider_10'), 'featured-thumb'); ?>
		</div>
		<?php endif; ?>
		
		
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#main-slider" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left">‹</span>
	</a>
	<a class="right carousel-control" href="#main-slider" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right">›</span>
	</a>
</div>
<?php else: ?>
<div class="jumbotron page-header">
	<div class="container">

		<div class="widget-area row" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'sidebar-0' ) ) : ?>
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary -->


		<?php if(get_option('nmbs_introduction_title')) : ?>
		<h1><?php echo get_option('nmbs_introduction_title'); ?></h1>
		<?php endif; ?>
		<?php if(get_option('nmbs_introduction_text')) : ?>
		<p><?php echo get_option('nmbs_introduction_text'); ?></p>
		<?php endif; ?>
		<?php if(get_option('nmbs_introduction_text_link')) : ?>
		<p><a class="btn btn-primary btn-lg" href="<?php echo get_option('nmbs_introduction_link'); ?>" role="button"><?php echo get_option('nmbs_introduction_text_link'); ?> »</a></p>
		<?php endif; ?>
	</div>
	<?php if(get_option('nmbs_header_img')) : ?>
	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_header_img'); ?>&h=345&w=945"/>
	<?php endif; ?>
</div>
<?php endif; ?>