<?php 

function register_slider_metabox(){
	add_meta_box( 'ld_slider_post', __('Home page slider', 'learndash-theme'), 'print_slider_metabox', 'post', 'side', 'default' );
	add_meta_box( 'ld_slider_page', __('Home page slider', 'learndash-theme'), 'print_slider_metabox', 'page', 'side', 'default' );
	add_meta_box( 'ld_slider_courses', __('Home page slider', 'learndash-theme'), 'print_slider_metabox', 'sfwd-courses', 'side', 'default' );
}

function print_slider_metabox(){
	global $post;
	$slider_posts = get_option('learndash_slider_posts');
	$options = get_post_meta($post->ID, '_slider_options', true);

	if(!$slider_posts)
		$slider_posts = array();
	if(!$options)
		$options = array(
			 'title' => '',
			 'text' => '',
			 'button' => '',
			 'link' => ''
		);

	$options['checked'] = array_search($post->ID, $slider_posts) !== FALSE ? 'checked="checked"' : '';
	$options['style'] = $options['checked'] ? '' : 'style="display:none"';
	include 'slider-metabox-template.php';
}

function register_slider_options_js(){
	wp_enqueue_script('slider_metabox', get_template_directory_uri() . '/js/slider_metabox.js', array('jquery', 'backbone'));
}

function store_slider_data($post_id){
	$slider_posts_option = 'learndash_slider_posts';
	$slider_options_meta = '_slider_options';

	$sliderable = get_option($slider_posts_option);
	if(!$sliderable)
		$sliderable = array();

	if(isset($_POST['slider'])){
		if(array_search($post_id, $sliderable) === FALSE){
			$sliderable[] = $post_id;
			update_option($slider_posts_option, $sliderable);
		}
		$slider_options = array(
			 'title' => isset($_POST['slider_title']) ? $_POST['slider_title'] : '',
			 'text' => isset($_POST['slider_text']) ? $_POST['slider_text'] : '',
			 'button' =>isset($_POST['slider_button']) ?  $_POST['slider_button'] : '',
			 'link' => isset($_POST['slider_link']) ? $_POST['slider_link'] : ''
		);

		update_post_meta($post_id, $slider_options_meta, $slider_options);
	}
	else {
		$index = array_search($post_id, $sliderable);
		if($index !== FALSE){
			array_splice($sliderable, $index, 1);
			update_option($slider_posts_option, $sliderable);
		}
	}
}

function sort_slider_post_list($a, $b){
	return $a['text'] > $b['text'] ? 1 : -1;
}

function get_slider_posts_list(){
	global $slider_post_list;
	if(! is_null($slider_post_list))
		return $slider_post_list;

	$slider_posts = get_option('learndash_slider_posts');
	if(!$slider_posts || empty($slider_posts))
		return array();

	$list = array();
	foreach($slider_posts as $id){
		$post = get_post($id);
		if($post){
			$list[] = array('id' => $id, 'text' => '[' . $post->post_type . '] ' . $post->post_title);
		}
	}
	usort($list, 'sort_slider_post_list');

	$slider_post_list = $list;

	return $list;
}

add_action('add_meta_boxes', 'register_slider_metabox');
add_action('admin_enqueue_scripts', 'register_slider_options_js');
add_action('save_post', 'store_slider_data');