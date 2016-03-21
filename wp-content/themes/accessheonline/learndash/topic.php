<?php
/**
 * Displays a topic.
 *
 * Available Variables:
 * 
 * $course_id 		: (int) ID of the course
 * $course 		: (object) Post object of the course
 * $course_settings : (array) Settings specific to current course
 * $course_status 	: Course Status
 * $has_access 	: User has access to course or is enrolled.
 * 
 * $courses_options : Options/Settings as configured on Course Options page
 * $lessons_options : Options/Settings as configured on Lessons Options page
 * $quizzes_options : Options/Settings as configured on Quiz Options page
 * 
 * $user_id 		: (object) Current User ID
 * $logged_in 		: (true/false) User is logged in
 * $current_user 	: (object) Currently logged in user object
 * $quizzes 		: (array) Quizzes Array
 * $post 			: (object) The topic post object
 * $lesson_post 	: (object) Lesson post object in which the topic exists
 * $topics 		: (array) Array of Topics in the current lesson
 * $all_quizzes_completed : (true/false) User has completed all quizzes on the lesson Or, there are no quizzes.
 * $lesson_progression_enabled 	: (true/false)
 * $show_content	: (true/false) true if lesson progression is disabled or if previous lesson and topic is completed. 
 * $previous_lesson_completed 	: (true/false) true if previous lesson is completed
 * $previous_topic_completed	: (true/false) true if previous topic is completed
 * 
 * @since 2.1.0
 * 
 * @package LearnDash\Topic
 */
?>

 <div class="row">
	<div id="learndash_back_to_lesson"><a href='<?php echo esc_attr( get_permalink( $lesson_id) ); ?>'><?php _e( 'Back to Lesson', 'learndash' ); ?></a></div>
   </div>
    <div class="row">
<section class="eight columns">


    	<div class="inner-spacer course-content">
	
<?php
/**
 * Topic Dots
 */
?>
<?php if ( ! empty( $topics ) ) : ?>
	<div id='learndash_topic_dots-<?php echo esc_attr( $lesson_id ); ?>' class="learndash_topic_dots type-dots">

		<b><?php _e( 'Topic Progress:', 'learndash' ); ?></b>
        

		<?php foreach ( $topics as $key => $topic ) : ?>
			<?php $completed_class = empty( $topic->completed ) ? 'topic-notcompleted' : 'topic-completed'; ?>
			<a class='<?php echo esc_attr( $completed_class ); ?>' href='<?php echo get_permalink( esc_attr( $topic->ID ) ); ?>' title='<?php echo esc_attr( $topic->post_title ); ?>'>
				<span title='<?php echo esc_attr( $topic->post_title ); ?>'></span>
			</a>
		<?php endforeach; ?>

	</div>
<?php endif; ?>

 <h2 class="section-title"><?php the_title(); ?></h2>


<?php if ( $lesson_progression_enabled && ! $previous_topic_completed ) : ?>

	<p id="learndash_complete_prev_topic"><?php  _e( 'Please go back and complete the previous topic.', 'learndash' ); ?></p>
    
	<span class="prev-button"><?php echo learndash_previous_post_link(); ?></span>
    
<?php elseif ( $lesson_progression_enabled && ! $previous_lesson_completed ) : ?>

	<p id="learndash_complete_prev_lesson"><?php _e( 'Please go back and complete the previous lesson.', 'learndash' ); ?></p>

<?php endif; ?>

<?php if ( $show_content ) : ?>

	<?php echo $content; ?>

	<?php if ( ! empty( $quizzes ) ) : ?>
		<div id="learndash_quizzes">
			<div id="quiz_heading"><span><?php _e( 'Quizzes', 'learndash' ) ?></span><span class="right"><?php _e( 'Status', 'learndash' ) ?></span></div>

			<div id="quiz_list">
			<?php foreach( $quizzes as $quiz ) : ?>
				<div id='post-<?php echo esc_attr( $quiz['post']->ID ); ?>' class='<?php echo esc_attr( $quiz['sample'] ); ?>'>
					<div class="list-count"><?php echo $quiz['sno']; ?></div>
					<h4>
						<a class='<?php echo esc_attr( $quiz['status'] ); ?>' href='<?php echo esc_attr( $quiz['permalink'] ); ?>'><?php echo $quiz['post']->post_title; ?></a>
					</h4>
				</div>
			<?php endforeach; ?>
			</div>
		</div>	
	<?php endif; ?>

	<?php if ( lesson_hasassignments( $post ) ) : ?>

		<?php $assignments = learndash_get_user_assignments( $post->ID, $user_id ); ?>

		<div id="learndash_uploaded_assignments">
			
				<?php if ( ! empty( $assignments ) ) : ?>
                <h4><?php _e( 'Files you have uploaded', 'learndash' ); ?></h4>
                <ul>
					<?php foreach( $assignments as $assignment ) : ?>
							<li><a href='<?php echo esc_attr( get_post_meta( $assignment->ID, 'file_link', true ) ); ?>' target="_blank"><?php echo __( 'Download', 'learndash' ) . ' ' . get_post_meta( $assignment->ID, 'file_name', true ); ?></a>
							</li>
					<?php endforeach; ?>
                    </ul>
				<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php
    /**
     * Show Mark Complete Button
     */
    ?>
	<?php if ( $all_quizzes_completed ) : ?>
		<?php echo '<br />' . learndash_mark_complete( $post ); /* ?>
        <div class="module-nav-spacer">
<p id="learndash_next_prev_link"><?php echo learndash_next_post_link(); ?> &nbsp; <?php echo learndash_previous_post_link(); ?></p>
</div>
	<?php */ endif; ?>

<?php endif; ?>
</div>
    </section>
    
    <?php get_sidebar(); ?>
</div>