
<?php
/**
 * The Template for displaying single course.
 *
 * @package nmbs
 */

get_header(); ?>

<header class="jumbotron page-header">
	<div class="container">
		

		<div class="row">
			<div class="col-md-4 col-sd-6 text-center">
				<?php if(has_post_thumbnail()) :?>
				<?php the_post_thumbnail('course-thumb', array('class' => 'thumbnail')); ?>
				<?php else :?>
				<img  class="thumbnail" src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php bloginfo('template_directory');?>/img/no_image.jpg&h=200&w=300"/>
				<?php endif;?>
			</div>
			<div class="col-md-8 col-sd-6 ">
				<h1><?php the_title(); ?></h1>

			    <?php 
			    	global $post; $post_id = $post->ID;
			    	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			    	$membership_pro = is_plugin_active('learndash-paidmemberships/learndash-paidmemberships.php');
					if($post->post_type == 'sfwd-courses' && !$membership_pro):
						$course_options = get_post_meta($post_id, "_sfwd-courses", true);
						$course_access_list = $course_options['sfwd-courses_course_access_list'];
						$course_access_list = empty($course_access_list) ? array() : explode( ',', $course_access_list );
						$user_id = get_current_user_id();
						$course_started = current_user_can('level_8') || in_array( $user_id, $course_access_list ) || (empty($course_options['sfwd-courses_course_price']) && empty($course_options['sfwd-courses_course_join']));
						if(!$course_started):
							$course_price = isset($course_options['sfwd-courses_course_price']) ? $course_options['sfwd-courses_course_price'] : 0;
							$text = __('Join', 'learndash-theme');
							$rel = 'join';
							if($course_price){
								$options = get_option('sfwd_cpt_options');
								$currency = null;					
								if(!is_null($options)){
									if(isset($options['modules']) && isset($options['modules']['sfwd-courses_options']) && isset($options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency']))
									$currency = $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'];
								}
								if(is_null($currency))
									$currency = 'USD';
								$text = __('Take this course') . ' | <strong>' . $course_price . ' ' . $currency . '</strong>';
								$rel = 'pay';
							}
							?>
							<p>
								<a class="btn btn-success btn-lg take-course" href="#" rel="<?php echo $rel ?>">
									<?php echo $text ?>
								</a>
							</p>
						<?php endif;?>
					<?php endif;?>

			</div>
		</div>

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

				<?php get_template_part( 'content', 'course' ); ?>

				<?php nmbs_content_nav( 'nav-below' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

<?php get_sidebar('course'); ?>
<?php get_footer(); ?>