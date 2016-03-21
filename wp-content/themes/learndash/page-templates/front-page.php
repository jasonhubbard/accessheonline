<?php
/**
 * Template Name: Front Page Template
 *
 *
 * @package academy
 */

get_header(); ?>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content row">
		
		<div id="primary" class="content-area col-md-12 col-sd-12">
			<div id="main" class="site-main" role="main">

      <?php if(get_option('nmbs_fsection')) : ?>
			<div class="container marketing">

        <?php if(get_option('nmbs_fsection1_title')) : ?>
        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4 text-center">
            <?php if(get_option('nmbs_fsection1_image')) : ?>
            <img src="<?php echo get_option('nmbs_fsection1_image'); ?>"/>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection1_title')) : ?>
            <h2><?php  echo stripslashes(get_option('nmbs_fsection1_title')); ?></h2>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection1_text')) : ?>
            <p><?php  echo stripslashes(get_option('nmbs_fsection1_text')); ?></p>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection1_link')) : ?>
            <p><a class="btn btn-primary" href="<?php echo get_option('nmbs_fsection1_link'); ?>" role="button"><?php  echo stripslashes(get_option('nmbs_fsection2_link_text')); ?></a></p>
            <?php endif; ?>
          </div><!-- /.col-lg-4 -->
          <?php endif; ?>

          <?php if(get_option('nmbs_fsection2_title')) : ?>
          <div class="col-lg-4 text-center">
            <?php if(get_option('nmbs_fsection2_image')) : ?>
            <img src="<?php echo get_option('nmbs_fsection2_image'); ?>"/>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection2_title')) : ?>
            <h2><?php  echo stripslashes(get_option('nmbs_fsection2_title')); ?></h2>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection2_text')) : ?>
            <p><?php  echo stripslashes(get_option('nmbs_fsection2_text')); ?></p>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection2_link')) : ?>
            <p><a class="btn btn-primary" href="<?php echo get_option('nmbs_fsection2_link'); ?>" role="button"><?php  echo stripslashes(get_option('nmbs_fsection2_link_text')); ?></a></p>
            <?php endif; ?>
          </div><!-- /.col-lg-4 -->
          <?php endif; ?>

          <?php if(get_option('nmbs_fsection3_title')) : ?>
          <div class="col-lg-4 text-center">
            <?php if(get_option('nmbs_fsection3_image')) : ?>
            <img src="<?php echo get_option('nmbs_fsection3_image'); ?>"/>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection3_title')) : ?>
            <h2><?php  echo stripslashes(get_option('nmbs_fsection3_title')); ?></h2>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection3_text')) : ?>
            <p><?php  echo stripslashes(get_option('nmbs_fsection1_text')); ?></p>
            <?php endif; ?>
            <?php if(get_option('nmbs_fsection3_link')) : ?>
            <p><a class="btn btn-primary" href="<?php echo get_option('nmbs_fsection3_link'); ?>" role="button"><?php  echo stripslashes(get_option('nmbs_fsection3_link_text')); ?></a></p>
            <?php endif; ?>
          </div><!-- /.col-lg-4 -->
          <?php endif; ?>
          
        </div><!-- /.row -->

        <hr class="featurette-divider">
        <?php endif; ?>


        <?php if(get_option('nmbs_tour')) : ?>
        
          <?php if(get_option('nmbs_tour1_title')) : ?>
          <div class="row featurette">
              <div class="col-md-7 col-sm-7">
                <h2 class="featurette-heading"><?php  echo stripslashes(get_option('nmbs_tour1_title')); ?></h2>
                <?php if(get_option('nmbs_tour1_text')) : ?>
                  <p class="lead"><?php  echo stripslashes(get_option('nmbs_tour1_text')); ?></p>
                <?php endif; ?>
              </div>
              <div class="col-md-5 col-sm-5 text-center">
                <?php if(get_option('nmbs_tour1_image')) : ?>
                <img class="featurette-image img-responsive" src="<?php echo get_option('nmbs_tour1_image'); ?>"/>
                <?php endif; ?>
              </div>
          </div>
          <hr class="featurette-divider">
          <?php endif; ?>

          <?php if(get_option('nmbs_tour2_title')) : ?>
          <div class="row featurette">
              <div class="col-md-5 col-sm-5 text-center">
                <?php if(get_option('nmbs_tour2_image')) : ?>
                <img class="featurette-image img-responsive" src="<?php echo get_option('nmbs_tour2_image'); ?>"/>
                <?php endif; ?>
              </div>
              <div class="col-md-7 col-sm-7">
                <h2 class="featurette-heading"><?php  echo stripslashes(get_option('nmbs_tour2_title')); ?></h2>
                <?php if(get_option('nmbs_tour2_text')) : ?>
                  <p class="lead"><?php  echo stripslashes(get_option('nmbs_tour2_text')); ?></p>
                <?php endif; ?>
              </div>
          </div>
          <hr class="featurette-divider">
          <?php endif; ?>

          <?php if(get_option('nmbs_tour3_title')) : ?>
          <div class="row featurette">
              <div class="col-md-7 col-sm-7">
                <h2 class="featurette-heading"><?php  echo stripslashes(get_option('nmbs_tour3_title')); ?></h2>
                <?php if(get_option('nmbs_tour3_text')) : ?>
                  <p class="lead"><?php  echo stripslashes(get_option('nmbs_tour3_text')); ?></p>
                <?php endif; ?>
              </div>
              <div class="col-md-5 col-sm-5 text-center">
                <?php if(get_option('nmbs_tour3_image')) : ?>
                <img class="featurette-image img-responsive" src="<?php echo get_option('nmbs_tour3_image'); ?>"/>
                <?php endif; ?>
              </div>
          </div>
          <?php endif; ?>

          
        <?php endif; ?>


    </div>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', 'home' ); ?>

      <?php endwhile; // end of the loop. ?>

			</div><!-- #main -->
		</div><!-- #primary -->

<?php get_footer(); ?>