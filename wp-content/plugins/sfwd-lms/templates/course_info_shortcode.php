<?php
/**
 * Displays course information for a user
 *
 * Available:
 * $user_id
 * $courses_registered: course
 * $course_progress: Progress in courses
 * $quizzes
 * 
 * @since 2.1.0
 * 
 * @package LearnDash\Course
 */

/**
 * Course registered
 */
?>
<div id='ld_course_info'>

	<!-- Course info shortcode -->
	<?php if ( $courses_registered ) : ?>
		<div id='ld_course_info_mycourses_list'>
			<h4><?php _e( 'You are registered for the following courses', 'learndash' ); ?></h4>
			<?php foreach ( $courses_registered as $c ) : ?>
				<div class='ld-course-info-my-courses'><?php echo get_the_post_thumbnail( $c ); ?>
				<?php echo '<h2 class="ld-entry-title entry-title"><a href="' . get_permalink( $c ) . '"  rel="bookmark">'.get_the_title( $c ).'</a></h2>'; ?>
				</div>
			<?php endforeach; ?>
			<br/>
		</div>
	<?php endif; ?>

	<?php /* Course progress */ ?>
	<?php if ( $course_progress ) : ?>
		<div id='course_progress_details'>
			<h4><?php printf( _x( '%s progress details:', 'Course progress details Label', 'learndash' ), LearnDash_Custom_Label::get_label( 'course' ) ); ?></h4>
			<?php foreach ( $course_progress as $course_id => $coursep ) : ?>
				<?php $course = get_post( $course_id ); ?>
				<?php if ( empty( $course->post_title ) ) : continue; endif; ?>
				<strong><?php echo $course->post_title ?></strong>: <?php _e( 'Completed', 'learndash' ); ?> <strong><?php echo $coursep['completed']; ?></strong> <?php _e( 'out of', 'learndash' ); ?> <strong> <?php echo $coursep['total']; ?> </strong> <?php _e( 'steps', 'learndash' ); ?><br/>
			<?php endforeach ?>
		</div>
		<br>
	<?php endif; ?>

	<?php /* Quizzes */ ?>
	<?php if ( $quizzes ) : ?>
		<h4><?php _e( 'You have taken the following quizzes:', 'learndash' ); ?></h4>

		<?php foreach ( $quizzes as $k => $v ) : ?>
			<?php $quiz = get_post( $v['quiz'] ); ?>
			<?php
			
			$certificateLink = null;

			if ( true === $v['has_graded'] && true === LD_QuizPro::quiz_attempt_has_ungraded_question( $v ) ) {
				$certificateLink = '';
				$certificate_threshold = 0;
				$passstatus = 'red';
			} else {
				$c = learndash_certificate_details( $v['quiz'], $user_id );
				$certificateLink = $c['certificateLink']; 
				$certificate_threshold = $c['certificate_threshold'];
				$passstatus = isset( $v['pass'] ) ? ( ( $v['pass'] == 1 ) ? 'green' : 'red' ) : '';
			}
			?>
			
			<?php //$passstatus = isset( $v['pass'] ) ? ( ( $v['pass'] == 1 ) ? 'green' : 'red' ) : ''; ?>
			<?php //$c = learndash_certificate_details( $v['quiz'], $user_id ); ?>
			<?php //$certificateLink = $c['certificateLink']; ?>
			<?php // $certificate_threshold = $c['certificate_threshold']; ?>
			<?php $quiz_title = ! empty( $quiz->post_title ) ? $quiz->post_title : @$v['quiz_title']; ?>

			<?php if ( ! empty( $quiz_title ) ) : ?>
				<p>
					<span style='color:<?php echo $passstatus ?>'><strong><?php echo LearnDash_Custom_Label::get_label( 'quiz' ); ?></strong>: <?php echo $quiz_title ?></span> 
					<?php echo isset( $v['percentage'] ) ? " - {$v['percentage']}%" : '' ?>

					<?php if ( $user_id == get_current_user_id() 
						&& ! empty( $certificateLink ) 
						&& ( ( isset( $v['percentage'] ) 
						&& $v['percentage'] >= $certificate_threshold * 100) 
						|| ( isset( $v['count'] ) && ( intval( $v['count'] ) ) && $v['score']/$v['count'] >= $certificate_threshold ) ) ) : ?>
						- <a href='<?php echo $certificateLink ?>&time=<?php echo $v['time']; ?>' target='_blank'><?php echo __( 'Print Certificate', 'learndash' ); ?></a>
					<?php endif; ?>
					<br/>

					<?php
						if ( ( true === $v['has_graded'] ) && ( isset( $v['graded'] ) ) && (is_array( $v['graded'] ) ) && (!empty( $v['graded'] ) ) ) {
							foreach($v['graded'] as $quiz_question_id => $graded ) {
								
								if ( isset( $graded['post_id'] ) ) {

									$graded_post = get_post( $graded['post_id'] );
									if ($graded_post instanceof WP_Post) {
									
										if ($graded['status'] == 'graded') {
											$graded_color = ' color: green;';
										} else {
											$graded_color = ' color: red;';
										}
									
										$post_status_object_label = get_post_status_object( $graded['status'] )->label;

										//$post_type_object_label_name = get_post_type_object( $graded_post->post_type )->labels->name;
										
										echo /* $post_type_object_label_name .': '. */ get_the_title( $graded['post_id'] ) . ', '. __('Status', 'learndash') . ': <span style="'. $graded_color .'">' . $post_status_object_label .'</span>, '. __('Points', 'learndash') .': ' .  $graded['points_awarded'];
									
										if (is_admin()) {
											echo ' <a target="_blank" href="'. get_edit_post_link( $graded['post_id'] ) .'">'. __( 'edit', 'learndash' ) .'</a>';
										}
										echo ' <a target="_blank" href="'. get_permalink( $graded['post_id'] ) .'">'. __( 'view', 'learndash' ) .'</a>';
									
										echo ' <a target="_blank" href="'. get_permalink( $graded['post_id'] ) .'#comments">'. __( 'comments', 'learndash' ) .' '. get_comments_number( $graded['post_id'] ) .'</a>';
										echo '<br />';
									}
								}
							}
						}
					?>

					
					<?php if ( isset( $v['rank'] ) && is_numeric( $v['rank'] ) ) : ?>
						<?php echo __( 'Rank: ', 'learndash' ); ?> <?php echo $v['rank']; ?>, 
					<?php endif; ?>

					<?php echo __( 'Score ', 'learndash' ); ?><?php echo $v['score']; ?> <?php echo __( ' out of ', 'learndash' ); ?> <?php echo $v['count']; ?> <?php echo __( ' question(s)', 'learndash' ); ?>
					
					<?php if ( isset( $v['points'] ) && isset( $v['total_points'] ) ) : ?>
						<?php echo __( ' . Points: ', 'learndash' ); ?> <?php echo $v['points']; ?>/<?php echo $v['total_points']; ?>
					<?php endif; ?>

					<?php echo __( ' on ', 'learndash' ); ?> <?php echo date_i18n( DATE_RSS, $v['time'] ); ?>
					
					<?php
					/**
					 * 'course_info_shortcode_after_item' filter
					 *
					 * @todo filter doesn't make sense, change to action?
					 * 
					 * @since 2.1.0
					 */
					?>
					<?php echo apply_filters( 'course_info_shortcode_after_item', '', $quiz, $v, $user_id ); ?>
				</p>
			<?php endif; ?>	
		<?php endforeach; ?>

	<?php endif; ?>
	<!-- End Course info shortcode -->
</div>
