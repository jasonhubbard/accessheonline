<?php
/**
 * Loop shop template
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

<?php
global $columns, $per_page;

do_action('jigoshop_before_shop_loop');

$loop = 0;

if ( ! isset( $columns ) || ! $columns ) $columns = apply_filters( 'loop_shop_columns', 3 );

//only start output buffering if there are products to list
if ( have_posts() ) {
	ob_start();
}

if ( have_posts()) : while ( have_posts() ) : the_post(); $_product = new jigoshop_product( $post->ID ); $loop++;

	?>

	<div class="product col-sm-6 col-md-4"><article class="thumbnail course product">

		<?php do_action('jigoshop_before_shop_loop_item'); ?>

		<a href="<?php the_permalink(); ?>">
			<?php do_action('jigoshop_before_shop_loop_item_title', $post, $_product); ?>
		</a>
		
		<div class="caption">
			<h3 class="entry-title"><?php the_title(); ?></h3>

			<?php do_action('jigoshop_after_shop_loop_item_title', $post, $_product); ?>

			<p><?php do_action('jigoshop_after_shop_loop_item', $post, $_product); ?></p>
		</div>

	</article></div><?php

	if ( $loop == $per_page ) break;

endwhile; endif;

if ( $loop == 0 ) :

	$content = '<p class="info">'.__('No products found which match your selection.', 'jigoshop').'</p>';

else :

	$found_posts = ob_get_clean();

	$content = '' . $found_posts . '<div class="clear"></div>';

endif;

echo apply_filters( 'jigoshop_loop_shop_content', $content );

do_action( 'jigoshop_after_shop_loop' );


		
		/*<?php 
			if($post->post_type == 'sfwd-courses'): ?>
		<div class="price <?php echo $course_options['sfwd-courses_course_price'] ? $course_options['sfwd-courses_course_price'] . ' ' . $currency : __('Free')?>">
			<?php echo $price ?>
		</div>
		<?php endif;?>

		<?php if(has_post_thumbnail()) :?>
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php the_post_thumbnail('course-thumb'); ?>
		</a>
		<?php else :?>
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php bloginfo('template_directory');?>/img/no_image.jpg&h=200&w=300"/>
		</a>
		<?php endif;?>
		<div class="caption">
			<h3 class="entry-title"><?php the_title(); ?></h3>
			<p><a class="btn btn-primary" role="button" href="<?php the_permalink(); ?>" rel="bookmark">See more...</a></p>
		</div><!-- .entry-header -->*/
