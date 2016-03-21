<div class="row">
	<div class="col-md-2 col-sd-2 text-center">
		<?php if(has_post_thumbnail()) :?>
		<?php the_post_thumbnail('course-thumb', array('class' => 'thumbnail')); ?>
		<?php else :?>
		<img  class="thumbnail" src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php bloginfo('template_directory');?>/img/no_image.jpg&h=200&w=300"/>
		<?php endif;?>
	</div>
	<div class="col-md-10 col-sd-10 ">
		<?php
			the_title( '<h2 class="ld-entry-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); 
		?>						
	</div>
</div>