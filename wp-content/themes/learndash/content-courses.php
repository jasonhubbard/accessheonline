<?php
/**
 * @package nmbs
 */

global $post; $post_id = $post->ID;

$options = get_option('sfwd_cpt_options');
$currency = null;
if(!is_null($options)){
	if(isset($options['modules']) && isset($options['modules']['sfwd-courses_options']) && isset($options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency']))
	$currency = $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'];
}
if(is_null($currency))
	$currency = 'USD';


$course_options = get_post_meta($post_id, "_sfwd-courses", true);
$price = $course_options && isset($course_options['sfwd-courses_course_price']) ? $course_options['sfwd-courses_course_price'] : __('Free');

if($price=='')
	$price .= 'Free';

if(is_numeric($price))
	$price .= ' ' . $currency;

?>
<div class="col-sm-6 col-md-4">
	<article id="post-<?php the_ID(); ?>" <?php post_class('thumbnail course'); ?>>
		
		<?php 
			if($post->post_type == 'sfwd-courses'): ?>
		<div class="price <?php echo isset($course_options['sfwd-courses_course_price']) ? $course_options['sfwd-courses_course_price'] . ' ' . $currency : __('Free')?>">
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
		</div><!-- .entry-header -->
	</article><!-- #post-## -->
</div>