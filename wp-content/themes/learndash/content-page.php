<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package nmbs
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'nmbs' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'nmbs' ), '<footer class="entry-meta"><span class="edit-link btn btn-default btn-xs">', '</span></footer>' ); ?>
</article><!-- #post-## -->
