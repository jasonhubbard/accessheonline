<?php

/**
 * Plugin Name: Quiz Reporting Extension for LearnDash
 * Plugin URI: http://wisdmlabs.com/
 * Description: To export quiz statistics into .CSV format. 
 * Version: 1.1.3   
 * Author: WisdmLabs
 * Author URI: http://wisdmlabs.com/
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
global $wdm_plugin_data;
$wdm_plugin_data = array(
	'plugin_short_name' => 'Quiz Reporting Extension', //Plugins short name appears on the License Menu Page
	'plugin_slug' => 'quiz_reporting_learndash', //this slug is used to store the data in db. License is checked using two options viz edd_<slug>_license_key and edd_<slug>_license_status
	'plugin_version' => '1.1.3', //Current Version of the plugin. This should be similar to Version tag mentioned in Plugin headers
	'plugin_name' => 'Quiz Reporting Extension for LearnDash', //Under this Name product should be created on WisdmLabs Site
	'store_url' => 'http://wisdmlabs.com/check-update', //Url where program pings to check if update is available and license validity
	'author_name' => 'WisdmLabs', //Author Name
);

include_once 'includes/class-wdm-add-plugin-data-in-db.php';
new Wdm_Add_Plugin_Data_In_DB($wdm_plugin_data);

/**
 * This code checks if new version is available
 */
if (!class_exists('Wdm_Plugin_Updater')) {
	include 'includes/wdm-plugin-updater.php';

	$l_key = trim(get_option('edd_' . $wdm_plugin_data['plugin_slug'] . '_license_key'));

	// setup the updater
	new Wdm_Plugin_Updater($wdm_plugin_data['store_url'], __FILE__, array(
		'version' => $wdm_plugin_data['plugin_version'], // current version number
		'license' => $l_key, // license key (used get_option above to retrieve from DB)
		'item_name' => $wdm_plugin_data['plugin_name'], // name of this plugin
		'author' => $wdm_plugin_data['author_name'], //author of the plugin
	)
	);

	$l_key = null;
}
// to add link in the html table for export
if (!function_exists('wdm_link_export')) {

	function wdm_link_export() {
		global $wdm_plugin_data;
		include_once 'includes/class-wdm-get-plugin-data.php';
		$get_data_from_db = Wdm_Get_Plugin_Data::get_data_from_db($wdm_plugin_data);
		if ($get_data_from_db == 'available') {
			//Your Code goes here

			if (isset($_GET['page']) && isset($_GET['module']) && $_GET['page'] == 'ldAdvQuiz' && $_GET['module'] == 'statistics' && isset($_GET['id']) && $_GET['id'] != '') {
				// if page is 'module' and 'statistics' of quiz.
				$quiz_id = trim($_GET['id']);

				if (is_numeric($quiz_id)) {
					// to get all stat ids to export all responses - starts
					global $wpdb;
					$wp_tbl_prefix = $wpdb->prefix;

					$query = "SELECT statistic_ref_id  FROM {$wp_tbl_prefix}wp_pro_quiz_statistic_ref WHERE quiz_id = " . $quiz_id . " AND is_old=0 ORDER BY statistic_ref_id DESC; ";

					$result = $wpdb->get_results($query, ARRAY_A);

					$all_ids = '';

					if (is_array($result)) {
						$result = array_filter($result);
					}

					if (!empty($result)) {
						foreach ($result as $stat_id) {
							$all_ids .= $stat_id['statistic_ref_id'] . ',';
						}
					}

					$all_ids = substr($all_ids, 0, -1); // removing last char
					// to get all stat ids to export all responses - ends

					$wdm_nonce = wp_create_nonce('wdm' . get_current_user_id());

					$plugin_dir = plugin_dir_url(__FILE__);

					//$export_link = $plugin_dir . 'wdmExportCSV.php'; // export file where data has to post to get CSV file
					$export_link = $plugin_dir . 'wdmTestFile.php'; // export file where data has to post to get CSV file
					$loader_link = $plugin_dir . 'ajax_preloader.gif'; // loader image link after clicking export link

					wp_register_script('wdm_export', plugins_url('/js/wdm-export.js', __FILE__), array('jquery'), '4.2.3');
					wp_enqueue_script('wdm_export');

					$wdm_js_array = array('ajax_url' => admin_url('admin-ajax.php'),
						'export_link' => $export_link,
						'loader_link' => $loader_link,
						'all_ids' => $all_ids,
						'wdm_nonce' => $wdm_nonce);

					wp_localize_script('wdm_export', 'wdm_export_obj', $wdm_js_array);
				}
			}
		}
	}

}
add_action('admin_footer', 'wdm_link_export');

function wdm_load_plugin() {
	// to extend 'WpProQuiz_Model_AnswerTypes' class included file because some variables are class protected, so to read those vars must have to extend class.

	$plugin_dir = ABSPATH . 'wp-content/plugins/';

	$lms_plugin_activated = false;

	if (file_exists($plugin_dir . 'sfwd-lms/sfwd_lms.php')) {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		if (function_exists('is_plugin_active')) {

			if (is_plugin_active('sfwd-lms/sfwd_lms.php')) {
				$lms_plugin_activated = true;
			}
		}
	}

	if ($lms_plugin_activated) {
		// if LD LMS plugin is activated
		if (file_exists($plugin_dir . 'sfwd-lms/wp-pro-quiz/lib/model/WpProQuiz_Model_AnswerTypes.php')) {
			$inc_wdm = include_once $plugin_dir . 'sfwd-lms/wp-pro-quiz/lib/model/WpProQuiz_Model_AnswerTypes.php'; // file where 'WpProQuiz_Model_AnswerTypes' class locates.
		} elseif (file_exists($plugin_dir . 'sfwd-lms/includes/vendor/wp-pro-quiz/lib/model/WpProQuiz_Model_AnswerTypes.php')) {
			$inc_wdm = include_once $plugin_dir . 'sfwd-lms/includes/vendor/wp-pro-quiz/lib/model/WpProQuiz_Model_AnswerTypes.php'; // file where 'WpProQuiz_Model_AnswerTypes' class locates.
		}
		else{
			die( __("Check your plugin"));
		}
		if ($inc_wdm) {
			// if include successfull
			if (class_exists('WpProQuiz_Model_AnswerTypes')) {

				class Wdm_Export_Quiz extends WpProQuiz_Model_AnswerTypes {

					public function __construct() {
						// do nothing
					}

					public function print_ar($arr) {
						// to print array in <pre> tag.
						echo "<pre>";
						print_r($arr);
						echo "</pre>";
					}

					/**
					 * To get form questions data of custom field by quiz id
					 * @param number $quiz_id quiz id
					 * @return array $custom_form_data custom form field questions
					 */
					public function wdm_get_quiz_form_data($quiz_id) {
						$custom_form_data = array();
						if (!empty($quiz_id)) {
							global $wpdb;
							$wp_tbl_prefix = $wpdb->prefix;

							if (!empty($quiz_id)) {
								$custom_form_query = "SELECT form_id, fieldname, type, data FROM {$wp_tbl_prefix}wp_pro_quiz_form WHERE quiz_id={$quiz_id} ORDER BY sort ASC;";
								$custom_form_data = $wpdb->get_results($custom_form_query, ARRAY_A);
							}
						}
						return $custom_form_data;
					}

					/**
					 * to return custom field's answers
					 * @param numeric $ref_id statistics ref id
					 * @param numeric $quiz_id quiz id
					 * @param numeric $user_id user id of user
					 * @return array answers of user
					 */
					public function wdm_custom_quiz_answers($ref_id, $quiz_id, $user_id) {
						$custom_answers = array();
						if (!empty($ref_id) && !empty($quiz_id) && !empty($user_id)) {
							global $wpdb;
							$wp_tbl_prefix = $wpdb->prefix;

							$custom_query = "SELECT form_data FROM {$wp_tbl_prefix}wp_pro_quiz_statistic_ref WHERE statistic_ref_id={$ref_id} AND quiz_id={$quiz_id} AND user_id={$user_id};";

							$custom_answers = maybe_unserialize($wpdb->get_var($custom_query));
							if ($custom_answers != '') {
								$custom_answers = json_decode($custom_answers, 1);
							}
						}
						return $custom_answers;
					}

					/**
					 * Used for ajax call
					 *  Gets 'ref_id' variable from POST data.
					 * Does query to retrieve statistics data from tables, makes sql join for tables.
					 * There are several types of questions, for this need to create generic array, so it creates generic array of all data for all types of questions.
					 *
					 */
					public function wdm_export() {

						global $wpdb;
						$wp_tbl_prefix = $wpdb->prefix;
						$wdm_quiz_id = 0;

						$ref_id = isset($_POST['ref_id']) ? $_POST['ref_id'] : '';

						$wdm_nonce = isset($_POST['wdm_nonce']) ? $_POST['wdm_nonce'] : '';

						//If format of export is CSV
						//$format = isset($_POST['format']) ? $_POST['format'] : '';
						$format = isset($_POST['wdm_format']) ? $_POST['wdm_format'] : '';

						$table = "";

						if (!empty($ref_id) && wp_verify_nonce($wdm_nonce, 'wdm' . get_current_user_id())) {

							$query = "SELECT qsr.statistic_ref_id, qsr.quiz_id, qsr.user_id, qq.question, qq.points, qq.answer_type, qq.answer_data, qq.sort col_sort, qs.points qspoints, qs.answer_data qsanswer_data, qs.question_time FROM {$wp_tbl_prefix}wp_pro_quiz_statistic_ref qsr,  {$wp_tbl_prefix}wp_pro_quiz_question qq, {$wp_tbl_prefix}wp_pro_quiz_statistic qs WHERE qsr.statistic_ref_id = qs.statistic_ref_id AND qsr.quiz_id = qq.quiz_id AND qq.id=qs.question_id AND qsr.statistic_ref_id IN (" . $ref_id . ") ORDER BY qsr.statistic_ref_id DESC, col_sort ASC; ";

							if (preg_match('[update|delete|drop|alter]', strtolower($query)) === true) {
								// to prevent user from update,delte,drop,alter commands
								echo 'No cheating';
							} else {

								$result = $wpdb->get_results($query, ARRAY_A);

								if (is_array($result)) {
									$result = array_filter($result);
								}

								//self::print_ar($result);

								if (!empty($result)) {
									// not checked "$custom_result" because if there is only custom fields in quiz, then quiz doesn't show any question on the page.
									$arr_data = array(); // main array of final data
									$custom_form_data = array(); // array of custom form fields

									$arr_process_data = array(); // array to loop

									foreach ($result as $res_key => $res_value) {
										// to generate process array
										$wdm_ref_id = isset($res_value['statistic_ref_id']) ? $res_value['statistic_ref_id'] : '';

										// added in version 1.1.2
										if (!isset($arr_process_data[$wdm_ref_id])) {
											$arr_process_data[$wdm_ref_id] = array();
										}

										if (!is_array($arr_process_data[$wdm_ref_id])) {
											$arr_process_data[$wdm_ref_id] = array();
										}

										array_push($arr_process_data[$wdm_ref_id], $res_value);

										if ($wdm_quiz_id == 0) {
											// if quiz id not set
											$wdm_quiz_id = $res_value['quiz_id'];
										}
									}

									// for custom field answers - starts
									if (!empty($wdm_quiz_id)) {
										$custom_form_data = self::wdm_get_quiz_form_data($wdm_quiz_id); // gets form data of a quiz
									}

									$arr_custom_process_data = array(); // final custom fields process data

									if (!empty($custom_form_data)) {

										$arr_is_custom_inserted = array(); // to check if custom answers are already inserted in $arr_process_data
										foreach ($result as $res_key => $res_value) {

											$wdm_ref_id = isset($res_value['statistic_ref_id']) ? $res_value['statistic_ref_id'] : '';
											if (!in_array($wdm_ref_id, $arr_is_custom_inserted)) {

												$custom_answers = self::wdm_custom_quiz_answers($wdm_ref_id, $wdm_quiz_id, $res_value['user_id']); // to get answers of a ref id

												if (!empty($custom_answers)) {

													// added in version 1.1.2
													if (!isset($arr_custom_process_data[$wdm_ref_id])) {
														$arr_custom_process_data[$wdm_ref_id] = array();
													}

													if (!is_array($arr_custom_process_data[$wdm_ref_id])) {
														$arr_custom_process_data[$wdm_ref_id] = array();
													}

													$arr_custom_to_process = array();

													foreach ($custom_form_data as $cust_question) {
														$arr_custom_to_process['statistic_ref_id'] = $wdm_ref_id;
														$arr_custom_to_process['quiz_id'] = $wdm_quiz_id;
														$arr_custom_to_process['user_id'] = $res_value['user_id'];
														$arr_custom_to_process['question'] = $cust_question['fieldname'];
														$arr_custom_to_process['points'] = '';
														$arr_custom_to_process['answer_type'] = $cust_question['type'];
														$arr_custom_to_process['answer_data'] = $cust_question['data'];
														$arr_custom_to_process['col_sort'] = '';
														$arr_custom_to_process['qspoints'] = '';

														$form_id = $cust_question['form_id']; // id of custom question

														$arr_custom_to_process['qsanswer_data'] = isset($custom_answers[$form_id]) ? $custom_answers[$form_id] : '';
														$arr_custom_to_process['question_time'] = '';

														array_push($arr_custom_process_data[$wdm_ref_id], $arr_custom_to_process);
													}

													array_push($arr_is_custom_inserted, $wdm_ref_id);
												} //     if ( ! empty( $custom_answers ) )
											} // if( !  in_array( $wdm_ref_id, $arr_is_custom_inserted ) )
										}
									}
									// for custom field answers - ends

									$main_cnt = 0; // index counter of main data array

									foreach ($arr_process_data as $res_key => $res_value) {

										$wdm_user_id = isset($res_value[0]['user_id']) ? $res_value[0]['user_id'] : '';
										$wdm_quiz_id = isset($res_value[0]['quiz_id']) ? $res_value[0]['quiz_id'] : '';

										$arr_data[$main_cnt]['user_id'] = $wdm_user_id;
										$arr_data[$main_cnt]['user_login_name'] = '';

										if (!empty($wdm_user_id)) {
											// to get user name
											$wdm_userdata = get_userdata($wdm_user_id);
											$arr_data[$main_cnt]['user_login_name'] = $wdm_userdata->user_login;
										}

										$arr_data['quiz_title'] = '';
										if (!empty($wdm_quiz_id) && $arr_data['quiz_title'] == '') {
											// to get quiz title
											$quiz_query = "SELECT `name` FROM  {$wp_tbl_prefix}wp_pro_quiz_master WHERE id=" . $wdm_quiz_id;
											$quiz_name = $wpdb->get_var($quiz_query);
											$arr_data['quiz_title'] = $quiz_name;
										}

										$cnt = 0; // counter for all rows of main query

										if (!empty($res_value)) {

											foreach ($res_value as $key => $val) {

												$result[$key]['answer_data'] = maybe_unserialize($result[$key]['answer_data']);

												$wdm_answer_data = maybe_unserialize($result[$key]['answer_data']);

												$question_type = $val['answer_type'];
												$wdm_user_response = json_decode($val['qsanswer_data'], 1);

												$arr_user_response = array();
												$arr_answers = array();
												$arr_correct_answers = array();

												$switch_true = false; // if switch statement is true then make it TRUE.
												$is_attach_question = false; // if want to attache answer to question. For cloze questions.

												switch ($question_type) {

													// if $question_type is single OR multiple
													case 'single':
													case 'multiple':
														$switch_true = true;

														$ans_cnt = 0;

														foreach ($wdm_answer_data as $ans_obj) {

															$arr_answers[$ans_cnt] = $ans_obj->_answer;

															if ($ans_obj->_correct == 1) {
																// if correct answer, makes entry in $arr_correct_answers array
																array_push($arr_correct_answers, $ans_obj->_answer);
															}

															if ($wdm_user_response[$ans_cnt] == 1) {
																// if user has selected answer, '0' if not
																array_push($arr_user_response, $ans_obj->_answer);
															}

															$ans_cnt++;
														}

														break;

													case 'free_answer':
														$switch_true = true;

														$ans_obj = isset($wdm_answer_data[0]) ? $wdm_answer_data[0] : ''; // because it has only one answer with line breaks

														if ($ans_obj !== '') {
															$arr_answers[0] = $ans_obj->_answer;

															array_push($arr_correct_answers, $ans_obj->_answer); // correct answer is same as options

															$arr_user_response = $wdm_user_response;
														}
														break;
													case 'sort_answer':
														$switch_true = true;

														$ans_cnt = 0;

														foreach ($wdm_answer_data as $ans_obj) {

															$arr_answers[$ans_cnt] = $ans_obj->_answer;

															array_push($arr_correct_answers, $ans_obj->_answer);

															if (0 == $ans_cnt) {
																// loops only once.
																$arr_user_response = $wdm_user_response;
															}

															$ans_cnt++;
														}

														break;
													case 'matrix_sort_answer':
														$switch_true = true;

														$ans_cnt = 0;

														foreach ($wdm_answer_data as $ans_obj) {

															$arr_answers[$ans_cnt] = $ans_obj->_answer . ' -> ' . $ans_obj->_sortString;

															array_push($arr_correct_answers, $ans_obj->_answer . ' -> ' . $ans_obj->_sortString);

															$arr_user_response[$ans_cnt] = $ans_obj->_answer . ' -> ' . $wdm_answer_data[$wdm_user_response[$ans_cnt]]->_sortString;

															$ans_cnt++;
														}

														break;
													case 'cloze_answer':
														$switch_true = true;
														$is_attach_question = true;

														// examples -
														// I {[play][love][hate]} soccer
														// I {play} soccer, with a {ball|3}

														$ans_obj = isset($wdm_answer_data[0]) ? $wdm_answer_data[0] : '';

														$wdm_answer = $ans_obj->_answer;

														$arr_wdm_answer = explode('{', $wdm_answer);

														$arr_options = array();

														if (!empty($arr_wdm_answer)) {

															foreach ($arr_wdm_answer as $cloze_key => $cloze_val) {

																if ($cloze_key == 0) {
																	// first value never be ib
																	continue;
																}

																$arr_wdm_answer2 = explode('}', $cloze_val);

																$wdm_answer_str = isset($arr_wdm_answer2[0]) ? $arr_wdm_answer2[0] : '';

																if ($wdm_answer_str !== '') {

																	$arr_wdm_answer_str = explode('|', $wdm_answer_str);

																	if (isset($arr_wdm_answer_str[1])) {

																		$wdm_answer_str = $arr_wdm_answer_str[0];
																	}
																}

																$wdm_answer_str = str_replace(array('][', ']', '['), array(',', '', ''), $wdm_answer_str);
																array_push($arr_options, $wdm_answer_str);
															}
														}

														$arr_answers = $arr_options;

														$arr_correct_answers = $arr_options;

														foreach ($arr_answers as $ckey => $cval) {
															array_push($arr_user_response, isset($wdm_user_response[$ckey]) ? $wdm_user_response[$ckey] : '');
														}
														break;
													case 'assessment_answer':
														$switch_true = true;

														$ans_obj = isset($wdm_answer_data[0]) ? $wdm_answer_data[0] : '';

														$wdm_answer = $ans_obj->_answer;

														$arr_wdm_answer = explode('{', $wdm_answer);
														if (!empty($arr_wdm_answer)) {

															$arr_wdm_answer2 = explode('}', isset($arr_wdm_answer[1]) ? $arr_wdm_answer[1] : array());
															$wdm_answer_str = isset($arr_wdm_answer2[0]) ? $arr_wdm_answer2[0] : '';

															$wdm_answer_str = str_replace(array('] [', ']', '['), array(',', '', ''), $wdm_answer_str);

															$arr_answers[0] = $wdm_answer_str;
															$arr_correct_answers[0] = $wdm_answer_str;
														}

														array_push($arr_user_response, isset($wdm_user_response[0]) ? $wdm_user_response[0] : '');

														break;
												}

												if ($switch_true) {

													$arr_data[$main_cnt]['total_points'] += $val['points'];
													$arr_data[$main_cnt]['tot_points_scored'] += $val['qspoints'];
													$arr_data[$main_cnt]['tot_time_taken'] += $val['question_time'];

													$arr_data[$main_cnt]['question_meta'][$cnt]['question'] = $val['question'];
													if ($is_attach_question) {
														// to attache answer in question
														$arr_data[$main_cnt]['question_meta'][$cnt]['question'] .= '  ' . $wdm_answer;
													}

													$arr_data[$main_cnt]['question_meta'][$cnt]['points'] = $val['points'];

													$arr_data[$main_cnt]['question_meta'][$cnt]['points_scored'] = $val['qspoints'];

													$arr_data[$main_cnt]['question_meta'][$cnt]['time_taken'] = $val['question_time'];

													$arr_data[$main_cnt]['question_meta'][$cnt]['answers'] = $arr_answers;
													$arr_data[$main_cnt]['question_meta'][$cnt]['correct_answers'] = $arr_correct_answers;
													$arr_data[$main_cnt]['question_meta'][$cnt]['user_response'] = $arr_user_response;

													$arr_data[$main_cnt]['question_meta'][$cnt]['question_type'] = $val['answer_type'];

													$arr_data[$main_cnt]['ref_id'] = $val['statistic_ref_id']; // added for the use of custom fields

													$cnt++;
												} //if( $switch_true )
											} // foreach ( $result as $key => $val ) {
										} // if( !empty( $res_value ) )

										$main_cnt++;
									} //foreach ( $arr_process_data as $res_key => $res_value )
								} // if( !  empty( $result ) )
								// filter of question types for the custom fields

								if (!empty($arr_custom_process_data)) {

									foreach ($arr_custom_process_data as $cust_key => $cust_val) {

										foreach ($cust_val as $wdm_cust_key => $wdm_cust_value) {

											$cust_question_type = $wdm_cust_value['answer_type'];

											switch ($cust_question_type) {
												case '0': // text
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'text';
													break;

												case '1': // textarea
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'textarea';
													break;

												case '2': // number
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'number';
													break;

												case '3': // checkbox
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'checkbox';
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['qsanswer_data'] = ($wdm_cust_value['qsanswer_data'] == '1') ? 'Yes' : 'No';
													break;

												case '4': // email
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'email';
													break;

												case '5': // yes/no
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'yes/no';
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['qsanswer_data'] = ($wdm_cust_value['qsanswer_data'] == '1') ? 'Yes' : 'No';
													break;

												case '6': // date
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'date';
													break;

												case '7': // dropdown menu
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'dropdown';

													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_data'] = json_decode($wdm_cust_value['answer_data']);

													break;

												case '8': // radio buttons
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_type'] = 'radio';
													$arr_custom_process_data[$cust_key][$wdm_cust_key]['answer_data'] = json_decode($wdm_cust_value['answer_data']);
													break;

												default:
													break;
											} // switch ( $cust_question_type)
										} // foreach ( $cust_val as $wdm_cust_key => $wdm_cust_value )
									} // foreach ( $arr_custom_process_data as $cust_key => $cust_val )
								} // if( !  empty( $arr_custom_process_data ) ) {

								if (count($arr_data) > 2) {
									// if all records fetched, 2 becuase of [quiz_title]
									$user_login_name = 'all';
								} else {
									$user_login_name = $arr_data[0]['user_login_name'];
								}

								// creating html data table for Csv format
								if ($format === 'csv') {
									if (!empty($arr_data)) {
										$table = '';
										$table .= '<table id="wdm_export">';

										foreach ($arr_data as $key => $val) {

											if (isset($val['question_meta'])) {

												$table .= '<tr>
											<td>QUIZ TITLE: ' . $arr_data['quiz_title'] . '</td>
											<td>USER LOGIN: ' . $val['user_login_name'] . '</td>
											<td>USER ID: ' . $val['user_id'] . '</td>
										</tr><tr>
											<td>QUESTION</td>
											<td>OPTIONS</td>
											<td>CORRECT ANSWERS</td>
											<td>USER RESPONSE</td>
											<td>POINTS</td>
											<td>POINTS SCORED</td>
											<td>TIME TAKEN</td>
											<td>QUESTION TYPE</td>
										</tr>';

												$question_str = '';
												foreach ($val['question_meta'] as $qkey => $qval) {

													$question_str .= '<tr>
													<td>' . $qval['question'] . '</td>';
													$question_str .= '<td>';
													$cnt = 1;
													foreach ($qval['answers'] as $answer) {
														// options column
														$question_str .= $cnt . ') ' . $answer . '<br />';
														$cnt++;
													}
													$question_str .= '</td>';

													$question_str .= '<td>';
													$cnt = 1;
													foreach ($qval['correct_answers'] as $answer) {
														// correct answers
														$question_str .= $cnt . ') ' . $answer . '<br />';
														$cnt++;
													}
													$question_str .= '</td>';

													$question_str .= '<td>';
													$cnt = 1;
													foreach ($qval['user_response'] as $answer) {
														// user response
														$question_str .= $cnt . ') ' . $answer . '<br />';
														$cnt++;
													}
													$question_str .= '</td>';

													$question_str .= '<td>' . $qval['points'] . '</td>
													<td>' . $qval['points_scored'] . '</td>
													<td>' . gmdate("H:i:s", $qval['time_taken']) . '</td>
													<td>' . $qval['question_type'] . '</td>
												</tr>';
												}

												$table .= $question_str;

												// for custom fields - starts
												if (isset($arr_custom_process_data[$val['ref_id']])) {
													$question_str_custom = '';
													$question_str_custom .= '<tr><td>CUSTOM FIELDS</td></tr>';
													foreach ($arr_custom_process_data[$val['ref_id']] as $cust_val) {
														$question_str_custom .= '<tr>
														<td>' . $cust_val['question'] . '</td>';

														$question_str_custom .= '<td>';
														$cnt = 1;
														foreach ($cust_val['answer_data'] as $answer) {
															// options
															$question_str_custom .= $cnt . ') ' . $answer . '<br />';
															$cnt++;
														}
														$question_str_custom .= '</td>';

														$question_str_custom .= '<td> </td>
														<td>' . $cust_val['qsanswer_data'] . '</td>
														<td> </td>
														<td> </td>
														<td> </td>
														<td>' . $cust_val['answer_type'] . '</td>
													</tr>';
													}
												}
												$table .= $question_str_custom;
												// for custom fields - ends

												$table .= '<tr>
												<td> TOTAL </td>
												<td> </td>
												<td> </td>
												<td> </td>
												<td>' . $val['total_points'] . '</td>
												<td>' . $val['tot_points_scored'] . ' ( ' . round((($val['tot_points_scored'] / $val['total_points']) * 100), 2) . '% )' . '</td>
												<td>' . gmdate("H:i:s", $val['tot_time_taken']) . '</td>
												<td> </td>
											</tr>';
												$table .= '<tr>
												<td> </td>
											</tr>
											<tr>
												<td> </td>
											</tr>';
											} // if( isset( $arr_data[ 'question_meta' ] ) )
										} // foreach ( $arr_data as $key => $val ) {

										$table .= '</table>';
									} // $arr_data
								}
								//Data for xls format
								else {

									if (!empty($arr_data)) {
										// This array contains Data to be send to wdmExportCSV.php
										// It contains data for each row, each cell
										//Also contains style for each cell
										$table = array(0 => array(0 => array('value' => '', 'style' => array())));

										//For row number
										$i = 0;

										foreach ($arr_data as $key => $val) {

											if (isset($val['question_meta'])) {

												$table[$i][0]['value'] = 'QUIZ TITLE: ' . $arr_data['quiz_title'];
												$table[$i][1]['value'] = 'USER LOGIN: ' . $val['user_login_name'];
												$table[$i][2]['value'] = 'USER ID: ' . $val['user_id'];

												$table[$i][0]['style'] = array('bold' => 1, 'italic' => 1);
												$table[$i][1]['style'] = array('bold' => 1, 'italic' => 1);
												$table[$i][2]['style'] = array('bold' => 1, 'italic' => 1);

												$i++;

												$table[$i][0]['value'] = 'QUESTION';
												$table[$i][1]['value'] = 'OPTIONS';
												$table[$i][2]['value'] = 'CORRECT ANSWERS';
												$table[$i][3]['value'] = 'USER RESPONSE';
												$table[$i][4]['value'] = 'POINTS';
												$table[$i][5]['value'] = 'POINTS SCORED';
												$table[$i][6]['value'] = 'TIME TAKEN';
												$table[$i][7]['value'] = 'QUESTION TYPE';

												$table[$i][0]['style'] = array('bold' => 1);
												$table[$i][1]['style'] = array('bold' => 1);
												$table[$i][2]['style'] = array('bold' => 1);
												$table[$i][3]['style'] = array('bold' => 1);
												$table[$i][4]['style'] = array('bold' => 1);
												$table[$i][5]['style'] = array('bold' => 1);
												$table[$i][6]['style'] = array('bold' => 1);
												$table[$i][7]['style'] = array('bold' => 1);

												//For next row
												$i++;

												foreach ($val['question_meta'] as $qkey => $qval) {

													$table[$i][0]['value'] = $qval['question']; //Question Column
													// To number the options
													$cnt = 1;
													//To append array values
													$question_str = '';
													foreach ($qval['answers'] as $answer) {
														// options column
														$question_str .= $cnt . ') ' . $answer . "\n";
														$cnt++;
													}
													$table[$i][1]['value'] = $question_str;
													$question_str = '';
													$cnt = 1;
													foreach ($qval['correct_answers'] as $answer) {
														// correct answers
														$question_str .= $cnt . ') ' . $answer . "\n";
														$cnt++;
													}
													$table[$i][2]['value'] = $question_str;
													$question_str = '';

													$cnt = 1;
													foreach ($qval['user_response'] as $answer) {
														// user response
														$question_str .= $cnt . ') ' . $answer . "\n";
														$cnt++;
													}
													$table[$i][3]['value'] = $question_str;
													$question_str = '';

													$table[$i][4]['value'] = $qval['points'];

													$table[$i][5]['value'] = $qval['points_scored'];

													$table[$i][6]['value'] = gmdate("H:i:s", $qval['time_taken']);

													$table[$i][7]['value'] = $qval['question_type'];

													//Sets font color for different situations
													if ($qval['points'] === $qval['points_scored']) {
														$table[$i][3]['style'] = array('font-color' => 'green');
													} else if ($qval['points_scored'] <= 0) {
														$table[$i][3]['style'] = array('font-color' => 'red');
													} else {
														$table[$i][3]['style'] = array('font-color' => 'blue');
													}
													//Next row
													$i++;
												}

												// for custom fields - starts
												if (isset($arr_custom_process_data[$val['ref_id']])) {

													//self::print_ar($arr_custom_process_data);

													//To append array values
													$question_str_custom = '';
													$table[$i][0]['value'] = 'CUSTOM FIELDS';
													$table[$i][0]['style'] = array('bold' => 1);

													foreach ($arr_custom_process_data[$val['ref_id']] as $cust_val) {
														$i++;
														$table[$i][0]['value'] = $cust_val['question'];

														$cnt = 1;
														if (is_array($cust_val['answer_data'])) {
															foreach ($cust_val['answer_data'] as $answer) {
																// options
																$question_str_custom .= $cnt . ') ' . $answer . "\n";
																$cnt++;
															}
														}

														$table[$i][1]['value'] = $question_str_custom;

														$table[$i][2]['value'] = '';

														$table[$i][3]['value'] = $cust_val['qsanswer_data'];

														$table[$i][4]['value'] = '';

														$table[$i][5]['value'] = '';

														$table[$i][6]['value'] = '';

														$table[$i][7]['value'] = $cust_val['answer_type'];
													}
													//Next row
													$i++;
												} // for custom fields - ends
												//For total

												$table[$i][0]['value'] = 'TOTAL';
												$table[$i][0]['style'] = array('bold' => 1);

												$table[$i][1]['value'] = '';

												$table[$i][2]['value'] = '';

												$table[$i][3]['value'] = '';

												$table[$i][4]['value'] = $val['total_points'];
												$table[$i][4]['style'] = array('bold' => 1);

												$table[$i][5]['value'] = $val['tot_points_scored'] . ' ( ' . round((($val['tot_points_scored'] / $val['total_points']) * 100), 2) . '% )';
												$table[$i][5]['style'] = array('bold' => 1);

												$table[$i][6]['value'] = gmdate("H:i:s", $val['tot_time_taken']);
												$table[$i][6]['style'] = array('bold' => 1);

												$table[$i][7]['value'] = '';
												$i++;

												//For a blank row
												// $m as a loop variable
												for ($m = 0; $m < 8; $m++) {
													$table[$i][$m]['value'] = '';
												}
												$i++;
											} // if( isset( $val[ 'question_meta' ] ) )
										}
									} // if( !empty( $arr_data ) )

									$table = json_encode($table);
									//return json_encode(array('table' => $table, 'quiz_title' => $arr_data['quiz_title'], 'name' => $user_login_name));
									return array('table' => $table, 'quiz_title' => $arr_data['quiz_title'], 'name' => $user_login_name);
									//die();
								} //else part ends
							}
						}
						//return json_encode(array('table' => htmlentities($table), 'quiz_title' => $arr_data['quiz_title'], 'name' => $user_login_name));
						return array('table' => htmlentities($table), 'quiz_title' => $arr_data['quiz_title'], 'name' => $user_login_name);
						//die();
					}

				}

				$obj_class = new Wdm_Export_Quiz();
				//Ajax call
				add_action('wp_ajax_wdm_export', array($obj_class, 'wdm_export'));
				add_action('wp_ajax_nopriv_wdm_export', array($obj_class, 'wdm_export'));

				// Added in 1.1.2
				include_once 'wdmExportCSV.php';
			}
		}
	}
}

add_action('plugins_loaded', 'wdm_load_plugin'); // to load plugin after all plugins loaded

add_action('admin_notices', 'wdm_ld_dependency_check'); // to notify user to activate LearnDash LMS, if not activated

function wdm_ld_dependency_check() {
	if (!in_array('sfwd-lms/sfwd_lms.php', apply_filters('active_plugins', get_option('active_plugins')))) {

		echo "<div class='error'><p><b>LearnDash LMS</b> plugin is not active. In order to make <b>'Quiz Reporting Extension for LearnDash'</b> plugin work, you need to install and activate <b>LearnDash LMS</b> first.</p></div>";
	}
}
