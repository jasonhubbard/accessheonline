<?php get_header(); ?>


	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<div class="row">
    
    <div class="twelve columns course-title">
    	<div class="inner-spacer">
    	<p>A <strong><?php the_field('course_author'); ?></strong> course</p>
    	<div class="row">
        	<div class="eight columns">
			<h1><?php the_title(); ?></h1>
			</div>
            </div>
            </div>
   </div>
   </div>
   
   <div class="row">
	<!-- section -->
	<section class="eight columns course-content">
    	<div class="inner-spacer">
    
    	<?php the_content(); // Dynamic Content ?>
    
    	</div>
    </section>
    
    <?php get_sidebar('course'); ?>
    
    
    </div>


			
		


	<?php endwhile; ?>

	<?php endif; ?>

	

<?php get_footer(); ?>
