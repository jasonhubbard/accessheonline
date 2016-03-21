<?php get_header(); ?>


	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
    <div class="row">
    
    <div class="twelve columns course-title course-title-slim">
    	<div class="inner-spacer">

		<h1><?php the_title(); ?></h1>
			
            </div>
   </div>
   </div>
   
   <div class="row">
	<!-- section -->
	<section class="twelve columns course-content">
    	<div class="inner-spacer">
        
        
        
    	<?php the_content(); // Dynamic Content ?>
    
    	</div>
    </section>

    
    
    </div>


			
		


	<?php endwhile; ?>

	<?php endif; ?>

	

<?php get_footer(); ?>