<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package nmbs
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<?php if(!get_option('nmbs_hide_page_title')) : ?>
	<header class="page-header">
		<h2 class="entry-title <?php if(get_option('nmbs_center_page_title')){ echo 'text-center';} ?> "><?php the_title(); ?></h2>
	</header><!-- .entry-header -->
	<?php endif; ?>

	
	<?php if(!get_option('nmbs_hide_page_content')) : ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'nmbs' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	<?php edit_post_link( __( 'Edit', 'nmbs' ), '<footer class="entry-meta"><span class="edit-link btn btn-default btn-xs">', '</span></footer>' ); ?>
</article><!-- #post-## -->
