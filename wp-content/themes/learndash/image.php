<?php
/**
 * The template for displaying image attachments.
 *
 * @package nmbs
 */

get_header(); ?>

	<div id="primary" class="content-area image-attachment col-md-12 col-sd-12">
		<div id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="page-header">
					<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

					<div class="entry-meta">
						<?php
							$metadata = wp_get_attachment_metadata();
							printf( __( 'Published <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>', 'nmbs' ),
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								esc_url( wp_get_attachment_url() ),
								$metadata['width'],
								$metadata['height'],
								esc_url( get_permalink( $post->post_parent ) ),
								esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
								get_the_title( $post->post_parent )
							);

							edit_post_link( __( 'Edit', 'nmbs' ), '<span class="edit-link">', '</span>' );
						?>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->

				<ul role="navigation" id="image-navigation" class="image-navigation pager">
					<li class="nav-previous previous"><?php previous_image_link( false, __( '<span class="meta-nav">&larr;</span> Previous', 'nmbs' ) ); ?></li>
					<li  class="nav-next next"><?php next_image_link( false, __( 'Next <span class="meta-nav">&rarr;</span>', 'nmbs' ) ); ?></li>
				</ul><!-- #image-navigation -->

				<div class="entry-content">
					<div class="entry-attachment">
						<div class="thumbnail text-center">
     						<?php nmbs_the_attached_image(); ?>
							<?php if ( has_excerpt() ) : ?>
							<div class="caption">
								<?php the_excerpt(); ?>
							</div><!-- .entry-caption -->
							<?php endif; ?>
						</div>
					</div><!-- .entry-attachment -->

					<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'nmbs' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->

				<?php edit_post_link( __( 'Edit', 'nmbs' ), '<footer class="entry-meta"><span class="edit-link btn btn-default btn-xs">', '</span></footer>' ); ?>
			</article><!-- #post-## -->

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
