<!-- sidebar -->
<aside class="sidebar four columns">

<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists
				$courseauthorurl = get_field('course_author_url'); // check if course url exists
				if($courseauthorurl) : ?>
                <div class="course-logo">
				<a href="<?php echo $courseauthorurl; ?>" title="<?php the_title(); ?>" target="_blank">
					<?php the_post_thumbnail(); // Fullsize image for the single post ?>
				</a>
                </div>
                <?php else : ?>
                <?php the_post_thumbnail(); // Fullsize image for the single post ?>
			<?php endif; endif; ?>
			<!-- /post thumbnail -->

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
	</div>

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
	</div>

</aside>
<!-- /sidebar -->
