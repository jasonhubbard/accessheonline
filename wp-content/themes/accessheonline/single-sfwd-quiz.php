<?php get_header(); ?>


	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
    <div class="row">
    
    <div class="twelve columns course-title course-title-slim">
    	<div class="inner-spacer">
    	
			<?php $course = learndash_get_course_id($lesson_id); ?>
		<h1><?php echo get_post_field('post_title', $course); ?></h1>
			
            </div>
   </div>
   </div>

	<div class="row">
<section class="twelve columns">


    	<div class="inner-spacer course-content">
        
         <h2 class="section-title"><?php the_title(); ?></h2>

    	<?php the_content(); ?>
   
   
   		</div>
    </section>
    
</div>

	<?php endwhile; ?>

	<?php endif; ?>

	

<?php get_footer(); ?>