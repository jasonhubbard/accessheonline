<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 ***********************************************************
 *   W P A C H I E V E M E N T S   A D M I N   S E T U P   *
 ***********************************************************
 */
 //*************** Setup Admin Scripts ***************\\
 add_action( 'admin_enqueue_scripts', 'wpachievements_admin_scripts' );
 add_action( 'admin_head', 'wpachievements_admin_head' );
 function wpachievements_admin_scripts($hook) {
  if( 'update-core.php' == $hook ){ 
    wp_enqueue_script( 'UpdateScript', plugins_url('update/js/update-script.php', __FILE__), array('jquery') );
  } elseif( 'users.php' == $hook ){ 
    wp_enqueue_style( 'user_management_style', plugins_url('/css/user-management.css', __FILE__) );
  } elseif( 'user-edit.php' == $hook ){
    wp_enqueue_style( 'JUI', plugins_url('/js/ui-darkness/css/ui-darkness/jquery-ui-1.10.3.custom.css', __FILE__) );
    wp_enqueue_style( 'user_management_style', plugins_url('/css/user-profile.css', __FILE__) );
    
    wp_enqueue_script( "UIScript", plugins_url("/js/ui-darkness/js/jquery-ui-1.10.3.custom.js", __FILE__) );
    wp_enqueue_script( 'UI_Spinner_Script', plugins_url('/js/ui.spinner.js', __FILE__) );    
    wp_register_script( 'user_management_script', plugins_url('/js/user-profile-script.js', __FILE__), array('jquery','media-upload','thickbox') );
    wp_enqueue_media();
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'user_management_script' );
  }
  
  if( 'toplevel_page_wpachievements_admin' != $hook && 'wpachievements_page_wpachievements_users' != $hook && 'wpachievements_page_wpachievements_achievements' != $hook && 'wpachievements_page_wpachievements_supported_plugins' != $hook && 'wpachievements_page_wpachievements_latest_info' != $hook && 'wpachievements_page_wpachievements_documentation' != $hook )
    return;
  
  if( 'toplevel_page_wpachievements_admin' == $hook ){
    
  } elseif( 'wpachievements_page_wpachievements_supported_plugins' == $hook ){
    wp_enqueue_style( 'support_admin_style', plugins_url('/css/support-admin.css', __FILE__) );
  } elseif( 'wpachievements_page_wpachievements_latest_info' == $hook || 'wpachievements_page_wpachievements_documentation' == $hook ){
    wp_enqueue_style( 'wpa_latest_info', plugins_url('/css/info.css', __FILE__) );
    if( get_bloginfo('version') >= 3.8 ){
      wp_enqueue_style( 'wpa_latest_info_3_8', plugins_url('css/info-3.8.css', __FILE__) );
    }
    wp_enqueue_script( 'wpa_latest_info_script', plugins_url('/js/info.js', __FILE__), array('jquery') );
  } else{
    wp_enqueue_style( 'JUI', plugins_url('/js/ui-darkness/css/ui-darkness/jquery-ui-1.10.3.custom.css', __FILE__) );
    wp_enqueue_style( 'UI_Spinner', plugins_url('/css/admin.css', __FILE__) );
    wp_enqueue_style( 'SelectBox', plugins_url('/css/jquery.selectbox.css', __FILE__) );
    wp_enqueue_style( 'thickbox' );
    wp_enqueue_script( "UIScript", plugins_url("/js/ui-darkness/js/jquery-ui-1.10.3.custom.js", __FILE__) );
    wp_enqueue_script( 'UI_Spinner_Script', plugins_url('/js/ui.spinner.js', __FILE__) );
    wp_enqueue_script( 'SelectBox_Script', plugins_url('/js/jquery.selectbox-0.2.js', __FILE__) );
    wp_register_script( 'my-upload', plugins_url('/js/admin-script.js', __FILE__), array('jquery','media-upload','thickbox') );
    wp_enqueue_media();
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'my-upload' );
  }
 }
 function wpachievements_admin_head(){
   
  wp_register_script( 'wpachievements_admin_menu_script', plugins_url('js/admin-menu-script.js', __FILE__), array('jquery') );
  wp_enqueue_script( 'wpachievements_admin_menu_script' );
  
  $screen = get_current_screen();
    
  if( $screen->id == 'wpachievements' ){
    wp_enqueue_style( 'wpachievements_admin_style', plugins_url('css/admin.css', __FILE__) );
    if( get_bloginfo('version') >= 3.8 ){
      wp_enqueue_style( 'wpachievements_admin_style_3_8', plugins_url('css/admin-3.8.css', __FILE__) );
    }
    wp_register_script( 'wpachievements_admin_script', plugins_url('js/admin-script.js', __FILE__), array('jquery','media-upload','thickbox') );
    wp_enqueue_media();
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'wpachievements_admin_script' );
    
    add_filter( 'wp_default_editor', 'wpachievements_force_default_editor' );
    wp_dequeue_script( 'autosave' );
  }
 }
 
 //*************** Setup Admin Menu ***************\\
 if(function_exists('is_multisite') && is_multisite()){
   global $blog_id;
   if($blog_id == 1){
     add_action( 'admin_menu', 'wpachievements_admin_menu' );
   }
 } else{
   add_action('admin_menu', 'wpachievements_admin_menu');
 }
 function wpachievements_admin_menu(){
  if(function_exists('is_multisite') && is_multisite()){
    global $wpdb;
    $user_role = get_blog_option(1,'wpachievements_role'); 
  } else{
    $user_role = get_option('wpachievements_role'); 
  } 
  if($user_role=='Administrator'){$user_role='manage_options';}
  elseif($user_role=='Editor'){$user_role='moderate_comments';}
  elseif($user_role=='Author'){$user_role='edit_published_posts';}
  elseif($user_role=='Contributor'){$user_role='edit_posts';}
  else{$user_role='manage_options';}
  
  add_utility_page(__("WPAchievements", WPACHIEVEMENTS_TEXT_DOMAIN), __("WPAchievements", WPACHIEVEMENTS_TEXT_DOMAIN), $user_role, 'edit.php?post_type=wpachievements', '', plugins_url('img/logo_small.png', __FILE__) );
    
  add_submenu_page( 'edit.php?post_type=wpachievements', __('WPAchievements - Settings', WPACHIEVEMENTS_TEXT_DOMAIN), __('Settings', WPACHIEVEMENTS_TEXT_DOMAIN), 'manage_options', 'wpachievements_settings', 'wpachievements_settings_admin');
  
  add_submenu_page( 'edit.php?post_type=wpachievements', __('WPAchievements - Shortcodes', WPACHIEVEMENTS_TEXT_DOMAIN), __('Shortcodes', WPACHIEVEMENTS_TEXT_DOMAIN), 'manage_options', 'wpachievements_documentation', 'wpachievements_documentation');
  
  add_submenu_page( 'edit.php?post_type=wpachievements', __('WPAchievements - Supported Plugins', WPACHIEVEMENTS_TEXT_DOMAIN), __('Supported Plugins', WPACHIEVEMENTS_TEXT_DOMAIN), 'manage_options', 'wpachievements_supported_plugins', 'wpachievements_supported_plugins');
  
  add_submenu_page( 'edit.php?post_type=wpachievements', __('WPAchievements - Latest Info', WPACHIEVEMENTS_TEXT_DOMAIN), __('Latest Info', WPACHIEVEMENTS_TEXT_DOMAIN), 'manage_options', 'wpachievements_latest_info', 'wpachievements_latest_info');
  
 }
 
/**
 *****************************************************************
 *   W P A C H I E V E M E N T S   S E T T I N G S   A D M I N   *
 *****************************************************************
 */
 require_once('admin/admin-functions.php');
 require_once('admin/admin-interface.php');
 require_once('admin/admin-settings.php');
 function wpachievements_settings_admin(){
   wpach_of_load_only();
   wpach_of_style_only();
   wpach_siteoptions_options_page();
 }
 
/**
 ***********************************************************************
 *   W P A C H I E V E M E N T S   A C H I E V E M E N T   A D M I N   *
 ***********************************************************************
 */
 add_action( 'add_meta_boxes', 'wpachievements_add_custom_boxes', 1 );
 add_action( 'save_post', 'wpachievements_save_achievement' );

 function wpachievements_add_custom_boxes(){
  add_meta_box( 
    'achievement_desc',
    '<strong>'. __( 'Achievement Text', WPACHIEVEMENTS_TEXT_DOMAIN )  .'</strong> - <small>'. __('This text is displayed when a user get the achievement.', WPACHIEVEMENTS_TEXT_DOMAIN).'</small>',
    'wpachievements_desc_box', 'wpachievements', 'normal', 'high'
  );
  add_meta_box( 
    'achievement_details',
    '<strong>'. __( 'Achievement Details', WPACHIEVEMENTS_TEXT_DOMAIN )  .'</strong> - <small>'. __('Setup the detials of the achievement.', WPACHIEVEMENTS_TEXT_DOMAIN).'</small>',
    'wpachievements_how_box', 'wpachievements', 'normal', 'high'
  );
  add_meta_box( 
    'achievement_image',
    '<strong>'. __( 'Achievement Image', WPACHIEVEMENTS_TEXT_DOMAIN )  .'</strong>',
    'wpachievements_image_box', 'wpachievements', 'side', 'high'
  );
 }

 function wpachievements_desc_box( $post ){
  add_filter( 'wp_default_editor', 'wpachievements_force_default_editor' );
  wp_nonce_field( 'wpachievements_achievement_save', 'wpachievements_achievement_nonce' );
  wp_editor($post->post_content, "achievement_desc_editor", array(
    'media_buttons' => false,
    'quicktags' => false,
    'tinymce' => array(
      'theme_advanced_buttons1' => 'bold,italic,underline',
      'theme_advanced_buttons2' => '',
      'theme_advanced_buttons3' => '',
      'theme_advanced_buttons4' => ''
    )
  ));
 }
 function wpachievements_how_box( $post ){
  $cur_trigger = get_post_meta( $post->ID, '_achievement_type', true );
  $cur_points = get_post_meta( $post->ID, '_achievement_points', true );
  $cur_post = get_post_meta( $post->ID, '_achievement_associated_id', true );
  $cur_occurences = get_post_meta( $post->ID, '_achievement_occurrences', true );
  $cur_recurring = get_post_meta( $post->ID, '_achievement_recurring', true );
  if( empty($cur_points) ){$cur_points=1;}
  if( empty($cur_occurences) ){$cur_occurences=1;}
  
  if(function_exists('is_multisite') && is_multisite()){
    $cur_blog_limit = get_post_meta( $post->ID, '_achievement_blog_limit', true );
  }
  if( !empty($cur_trigger) ){
    $disabled = ' disabled title="This cannot be changed once the achievement is created."';
  } else{
    $disabled = '';
  }
  if( function_exists(WPACHIEVEMENTS_LEARNDASH) ){
    $extra_classes = ' first-select';
  } else{
    $extra_classes = '';
  }
  echo '
  <span class="pullleft'.$extra_classes.'">
    <label for="wpachievements_achievements_data_event">'.__('Trigger Event', WPACHIEVEMENTS_TEXT_DOMAIN).':</label><br/>
    <select id="wpachievements_achievements_data_event" name="wpachievements_achievements_data_event"'.$disabled.'>';
      if( !empty($cur_trigger) ){
        echo '
        <optgroup label="'.__('Currently Selected', WPACHIEVEMENTS_TEXT_DOMAIN).'">
          <option value="'.$cur_trigger.'" selected>'.apply_filters('wpachievements_trigger_description', $cur_trigger).'</option>
        </optgroup>';
      } else{
        echo '<option value="" selected>---------------- '.__('Select', WPACHIEVEMENTS_TEXT_DOMAIN).' ----------------</option>';
        do_action('wpachievements_admin_events');
      }
      echo '</select>
  </span>';
  if( $cur_recurring == 1 ){
    $checked = ' checked';
  } else{
    $checked = '';
  }
  echo '
  <span class="pullleft wpa_checkbox">
    <label for="wpachievements_achievements_recurring">'.__('Recurring Achievement', WPACHIEVEMENTS_TEXT_DOMAIN).':
    <input type="checkbox" id="wpachievements_achievements_recurring" name="wpachievements_achievements_recurring"'.$checked.' /></label><br/>
  </span>';
  if( function_exists(WPACHIEVEMENTS_LEARNDASH) ){
    $cur_first_only = get_post_meta( $post->ID, '_achievement_ld_first_attempt_only', true );
    if( !empty($cur_first_only) && $cur_trigger == 'ld_quiz_perfect' ){
      $show = ' style="display:block !important;"';
    } else{
      $show = '';
    }
    echo '<span id="first_try" class="pullleft"'.$show.'>
      <label for="wpachievements_achievement_ld_first_try">'.__('First Attempt Only', WPACHIEVEMENTS_TEXT_DOMAIN).':</label>
      <select id="wpachievements_achievement_ld_first_try" name="wpachievements_achievement_ld_first_try">';
        if( !empty($cur_first_only) ){
          echo '<optgroup label="'.__('Currently Selected', WPACHIEVEMENTS_TEXT_DOMAIN).'">
            <option value="'.$cur_first_only.'" selected>'.$cur_first_only.'</option>
          </optgroup>';
        }
        echo '<option value="Disabled">'.__('Disabled', WPACHIEVEMENTS_TEXT_DOMAIN).'</option>
        <option value="Enabled">'.__('Enabled', WPACHIEVEMENTS_TEXT_DOMAIN).'</option>
      </select>
    </span>';
  }
  echo '<div class="clear"></div>
  <div id="event_details" style="display:none;">';
    if(function_exists('is_multisite') && is_multisite()){
      echo '<span id="blog_limit" class="pullleft">
        <label for="wpachievements_achievement_blog_limit">'.__('Limit to Blog', WPACHIEVEMENTS_TEXT_DOMAIN).':</label>
        <select id="wpachievements_achievement_blog_limit" name="wpachievements_achievement_blog_limit">';
          if( !empty($cur_blog_limit) ){
            $blog_details = get_blog_details($cur_blog_limit);
            echo '<optgroup label="'.__('Currently Selected', WPACHIEVEMENTS_TEXT_DOMAIN).'">
              <option value="'.$cur_blog_limit.'" selected>'.$blog_details->blogname.'</option>
            </optgroup>';
          }
          $args = array(
            'limit' => 1000,
            'offset' => 0,
          );
          $blog_list = wp_get_sites($args);
          foreach( $blog_list as $blog ){
            $blog_details = get_blog_details($blog['blog_id']);
            echo '<option value="'.$blog['blog_id'].'">'.$blog_details->blogname.'</option>';
          }
          echo '
        </select>
      </span>';
    }
    if( !empty($cur_post) || ($cur_trigger == 'ld_lesson_complete' || $cur_trigger == 'ld_course_complete' || $cur_trigger == 'ld_quiz_pass' || $cur_trigger == 'wpcw_quiz') ){
      if($cur_trigger == 'ld_lesson_complete' || $cur_trigger == 'ld_course_complete'){
        $postid_title = __('Lesson ID', WPACHIEVEMENTS_TEXT_DOMAIN);
      }
      if($cur_trigger == 'ld_course_complete'){
        $postid_title = __('Course ID', WPACHIEVEMENTS_TEXT_DOMAIN);
      }
      if($cur_trigger == 'ld_quiz_pass' || $cur_trigger == 'wpcw_quiz'){
        $postid_title = __('Quiz ID', WPACHIEVEMENTS_TEXT_DOMAIN);
      }
      if($cur_trigger == 'wpcw_module_complete'){
        $postid_title = __('Module ID', WPACHIEVEMENTS_TEXT_DOMAIN);
      }
      if($cur_trigger == 'wpcw_course_complete'){
        $postid_title = __('Course ID', WPACHIEVEMENTS_TEXT_DOMAIN);
      }
      $show = ' style="display:block !important;"';
    } else{
      $postid_title = __('Form ID', WPACHIEVEMENTS_TEXT_DOMAIN);
      $show = '';
    }
    echo '<span id="post_id"'.$show.'>
      <label for="wpachievements_achievements_data_post_id">'.$postid_title.': <small>(Optional)</small></label>
      <input type="text" id="wpachievements_achievements_data_post_id" name="wpachievements_achievements_data_post_id" value="'.$cur_post.'" />
    </span>';
    
    echo '<label for="wpachievements_achievements_data_event_no">'.__('Number of Occurrences', WPACHIEVEMENTS_TEXT_DOMAIN).':</label>
    <div class="spinner-holder">
      <input type="text" id="wpachievements_achievements_data_event_no" name="wpachievements_achievements_data_event_no" value="'.$cur_occurences.'" />
      <ul class="wpmu_spinner_control">
        <li><input type="button" class="button button-primary wpmu_spinner_btn wpump_spinner_increase" value="&#9650;" /></li>
        <li><input type="button" class="button button-primary wpmu_spinner_btn wpump_spinner_decrease" value="&#9660;" /></li>
      </ul>
    </div>
    <label for="wpachievements_achievements_data_points">'.__('Points Awarded', WPACHIEVEMENTS_TEXT_DOMAIN).':</label>
    <div class="spinner-holder">
      <input type="text" id="wpachievements_achievements_data_points" name="wpachievements_achievements_data_points" value="'.$cur_points.'" />
      <ul class="wpmu_spinner_control">
        <li><input type="button" class="button button-primary wpmu_spinner_btn wpump_spinner_increase" value="&#9650;" /></li>
        <li><input type="button" class="button button-primary wpmu_spinner_btn wpump_spinner_decrease" value="&#9660;" /></li>
      </ul>
    </div>';
    echo'
  </div><div class="clear"></div>';
 }
 function wpachievements_image_box( $post ){
 
  $cur_image = get_post_meta( $post->ID, '_achievement_image', true );
  
  if( $cur_image ){
    echo '<div id="image_preview_holder"><img src="'.$cur_image.'" alt="Achievement Logo" /><br/><a href="#" id="achievement_image_remove">Remove</a></div>';
  } else{
    echo '<div id="image_preview_holder"></div>';
  }
  
  echo '<span id="no-image-links"><a href="#" id="achievement_image_pick">Select Image</a> &nbsp;|&nbsp; <input id="upload_image" type="text" name="upload_image" value="'.$cur_image.'" /><input class="button button-primary" id="upload_image_button" type="button" value="'.__('Upload Image', WPACHIEVEMENTS_TEXT_DOMAIN).'" /></span>';
  echo '<div id="default-image-selection" style="display:none;">';
  $path = plugin_dir_url(basename(__FILE__)).'wpachievements/img/icons/';
  $handle = opendir(dirname(realpath(__FILE__)).'/img/icons/');
  $ii=0;
  while($file = readdir($handle)){
    if($file !== '.' && $file !== '..'){
      $ii++;
      echo '<span><input type="radio" name="achievement_badge" value="'.$path.$file.'" /><img src="'.$path.$file.'" alt="'.__('Achievement Image', WPACHIEVEMENTS_TEXT_DOMAIN).' '.$ii.'" class="radio_btn" /></span>';
    }
  }
  echo '<div class="clear"></div></div>';
  
 }
 
 function wpachievements_force_default_editor() {
  return 'tinymce';
 }
 
 function wpachievements_save_achievement( $post_id ) {
  if ( !isset( $_POST['wpachievements_achievement_nonce'] ) )
    return $post_id;
  $nonce = $_POST['wpachievements_achievement_nonce'];
  if ( !wp_verify_nonce( $nonce, 'wpachievements_achievement_save' ) )
    return $post_id;
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
    return $post_id;
  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }
  $ach_title = sanitize_text_field( $_POST['post_title'] );
  $ach_desc = $_POST['achievement_desc_editor'];
  $ach_rank = 'any';
  $ach_type = $_POST['wpachievements_achievements_data_event'];
  if( isset($_POST['wpachievements_achievements_data_post_id']) ){
    $ach_postid = sanitize_text_field( $_POST['wpachievements_achievements_data_post_id'] );
  } else{
    $ach_postid = '';
  }
  $ach_occur = sanitize_text_field( $_POST['wpachievements_achievements_data_event_no'] );
  $ach_points = sanitize_text_field( $_POST['wpachievements_achievements_data_points'] );
  $ach_wcpoints = '';
  $ach_img = $_POST['upload_image'];
  $ach_order_limit = '';
  if( isset($_POST['wpachievements_achievement_ld_first_try']) ){
    $ach_first_try = sanitize_text_field( $_POST['wpachievements_achievement_ld_first_try'] );
  } else{
    $ach_first_try = '';
  }
  $ach_ass_title = '';
  if( isset($_POST['wpachievements_achievement_blog_limit']) ){
    $ach_blog_Limit = sanitize_text_field( $_POST['wpachievements_achievement_blog_limit'] );
  } else{
    $ach_blog_Limit = '';
  }
  if( isset($_POST['wpachievements_achievements_recurring']) ){
    $ach_recurring = 1;
  } else{
    $ach_recurring = '';
  }
  
  $already_exists = get_post_meta( $post_id, '_achievement_points', true );
  if( $already_exists ){
    $ach_prev_points = get_post_meta( $post_id, '_achievement_points', true );
    $ach_prev_occur = get_post_meta( $post_id, '_achievement_occurrences', true );
    $ach_prev_postid = get_post_meta( $post_id, '_achievement_associated_id', true );
    $ach_prev_ass_title = get_post_meta( $post_id, '_achievement_associated_title', true );
    if( $ach_points != $ach_prev_points || $ach_prev_occur != $ach_occur || $ach_prev_postid != $ach_postid || $ach_ass_title != $ach_prev_ass_title ){
      $ach_data = $ach_title.': '.$ach_desc;
      global $wpdb;
      if(function_exists('is_multisite') && is_multisite()){
        $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
      } else{
        $table = $wpdb->prefix.'achievements';
      }
      $users_gained = $wpdb->get_results( $wpdb->prepare("SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key LIKE '_user_gained_%%'", $post_id) );
      if( $users_gained ){
        foreach( $users_gained as $user ){
          $remove_ach = false;
          if( $ach_ass_title != $ach_prev_ass_title && !$remove_ach ){
            $group_id = BP_Groups_Group::group_exists($ach_ass_title);
            if( $ach_rank ){
              $activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=$user->meta_value AND rank='%s' AND postid=%d", $ach_type,$ach_rank,$group_id) );
            } else{
              $activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=$user->meta_value AND postid=%d", $ach_type,$group_id) );
            }
            if( $activities_count < $ach_occur ){
              $remove_ach = true;
              $userachievements = get_user_meta( $user->meta_value, 'achievements_gained', true );
              $user_ach_count = (int)sizeof($userachievements);
              if( $user_ach_count > 1 ){
                unset($userachievements[$post_id]);
                update_user_meta( $user->meta_value, 'achievements_gained', $userachievements );
              } else{
                delete_user_meta( $user->meta_value, 'achievements_gained' );
              }
              do_action( 'wpachievements_remove_achievement', $user->meta_value, $post_id );
              $wpdb->query( $wpdb->prepare("INSERT INTO `".$table."` (uid, type, data, points, rank) VALUES ($user->meta_value, 'wpachievements_removed', '$ach_data', '-%d', '')", $ach_prev_points) );
              $user_ach_count = (int)$user_ach_count - 1;
              wpachievements_decrease_points( $user->meta_value, $ach_prev_points );
              if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
                cp_points('wpachievements_removed', $user->meta_value, -$ach_prev_points, '' );
              }
              if(function_exists(WPACHIEVEMENTS_MYCRED)){
                mycred_subtract( 'wpachievements_removed', $user->meta_value, $ach_prev_points, '%plural% for Achievement Removed: '.$ach_title );
              }
              delete_post_meta( $post_id, '_user_gained_'.$user->meta_value );
              update_user_meta( $user->meta_value, 'achievements_count', $user_ach_count);
            }
          }
          if( $ach_prev_postid != $ach_postid && !$remove_ach ){
            if( $ach_rank ){
              $activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='$ach_type' AND uid=$user->meta_value AND rank='$ach_rank' AND postid=%d", $ach_postid) );
            } else{
              $activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='$ach_type' AND uid=$user->meta_value AND postid=%d", $ach_postid) );
            }
            if( $activities_count < $ach_occur ){
              $remove_ach = true;
              $userachievements = get_user_meta( $user->meta_value, 'achievements_gained', true );
              $user_ach_count = (int)sizeof($userachievements);
              if( $user_ach_count > 1 ){
                unset($userachievements[$post_id]);
                update_user_meta( $user->meta_value, 'achievements_gained', $userachievements );
              } else{
                delete_user_meta( $user->meta_value, 'achievements_gained' );
              }
              do_action( 'wpachievements_remove_achievement', $user->meta_value, $post_id );
              $wpdb->query( $wpdb->prepare("INSERT INTO `".$table."` (uid, type, data, points, rank) VALUES ($user->meta_value, 'wpachievements_removed', '$ach_data', '-%d', '')", $ach_prev_points) );
              $user_ach_count = (int)$user_ach_count - 1;
              wpachievements_decrease_points( $user->meta_value, $ach_prev_points );
              if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
                cp_points('wpachievements_removed', $user->meta_value, -$ach_prev_points, '' );
              }
              if(function_exists(WPACHIEVEMENTS_MYCRED)){
                mycred_subtract( 'wpachievements_removed', $user->meta_value, $ach_prev_points, '%plural% for Achievement Removed: '.$ach_title );
              }
              delete_post_meta( $post_id, '_user_gained_'.$user->meta_value );
              update_user_meta( $user->meta_value, 'achievements_count', $user_ach_count);
            }
          }
          if( $ach_prev_occur != $ach_occur && !$remove_ach ){
            $activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=$user->meta_value AND rank='%s'", $ach_type,$ach_rank) );
            if( $activities_count < $ach_occur ){
              $remove_ach = true;
              $userachievements = get_user_meta( $user->meta_value, 'achievements_gained', true );
              $user_ach_count = (int)sizeof($userachievements);
              if( $user_ach_count > 1 ){
                unset($userachievements[$post_id]);
                update_user_meta( $user->meta_value, 'achievements_gained', $userachievements );
              } else{
                delete_user_meta( $user->meta_value, 'achievements_gained' );
              }
              do_action( 'wpachievements_remove_achievement', $user->meta_value, $post_id );
              $wpdb->query( $wpdb->prepare("INSERT INTO `".$table."` (uid, type, data, points, rank) VALUES ($user->meta_value, 'wpachievements_removed', '$ach_data', '-%d', '')", $ach_prev_points) );
              $user_ach_count = (int)$user_ach_count - 1;
              wpachievements_decrease_points( $user->meta_value, $ach_prev_points );
              if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
                cp_points('wpachievements_removed', $user->meta_value, -$ach_prev_points, '' );
              }
              if(function_exists(WPACHIEVEMENTS_MYCRED)){
                mycred_subtract( 'wpachievements_removed', $user->meta_value, $ach_prev_points, '%plural% for Achievement Removed: '.$ach_title );
              }
              delete_post_meta( $post_id, '_user_gained_'.$user->meta_value );
              update_user_meta( $user->meta_value, 'achievements_count', $user_ach_count);
            }
          }
          if( $ach_points != $ach_prev_points && !$remove_ach ){
            if( $ach_points < $ach_prev_points ){
              $deduct_points = $ach_prev_points - $ach_points;
              if(function_exists(WPACHIEVEMENTS_MYCRED)){
                mycred_subtract( 'wpachievements_changed', $user->meta_value, $deduct_points, '%plural% Achievement Modified: '.$ach_title );
              }
              if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
                cp_points('wpachievements_changed', $user->meta_value, -$deduct_points, '' );
              }
              wpachievements_decrease_points( $user->meta_value, $deduct_points );
            } else{
              $add_points = $ach_points - $ach_prev_points;
              if(function_exists(WPACHIEVEMENTS_MYCRED)){
                $mycred = mycred();
                $mycred->add_creds( 'wpachievements_changed', $user->meta_value, $add_points, '%plural% Achievement Modified: '.$ach_title );
              }
              if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
                cp_points('wpachievements_changed', $user->meta_value, $add_points, '' );
              }
              wpachievements_increase_points( $user->meta_value, $add_points );
            }
          }
        }
      }
    }
  }
  remove_action('save_post', 'wpachievements_save_achievement');
  $wpa_args = array(
    'ID'           => $post_id,
    'post_content' => $ach_desc,
    'post_status'  => 'publish'
  );
  wp_update_post( $wpa_args );
  add_action('save_post', 'wpachievements_save_achievement');
  
  update_post_meta( $post_id, '_achievement_woo_order_limit', $ach_order_limit );
  update_post_meta( $post_id, '_achievement_rank', $ach_rank );
  update_post_meta( $post_id, '_achievement_type', $ach_type );
  update_post_meta( $post_id, '_achievement_points', $ach_points );
  update_post_meta( $post_id, '_achievement_woo_points', $ach_wcpoints );
  update_post_meta( $post_id, '_achievement_associated_id', $ach_postid );
  update_post_meta( $post_id, '_achievement_occurrences', $ach_occur );
  update_post_meta( $post_id, '_achievement_image', $ach_img );
  update_post_meta( $post_id, '_achievement_ld_first_attempt_only', $ach_first_try );
  update_post_meta( $post_id, '_achievement_associated_title', $ach_ass_title );
  update_post_meta( $post_id, '_achievement_postid', $post_id );
  update_post_meta( $post_id, '_achievement_recurring', $ach_recurring );
  if( !empty($ach_blog_Limit) )
    update_post_meta( $post_id, '_achievement_blog_limit', $ach_blog_Limit );

 }
 
/**
 *********************************************************
 *   W P A C H I E V E M E N T S   U S E R   A D M I N   *
 *********************************************************
 */
 //*************** Add Columns to User List ***************\\
 if(function_exists('is_multisite') && is_multisite()){
   add_filter('wpmu_users_columns', 'wpachievements_add_custom_user_columns');
 } else{
   add_filter('manage_users_columns', 'wpachievements_add_custom_user_columns');
 }
 add_action('manage_users_custom_column',  'wpachievements_show_custom_user_columns', 10, 3);
 
 function wpachievements_add_custom_user_columns($columns){
   
   return array_merge( $columns,
     array('user_points' => 'Points', 'user_achievements' => 'Achievements') );
   
 }
 function wpachievements_show_custom_user_columns($value, $column_name, $user_id){
   
   do_action('wpachievements_user_admin_load', $user_id);
   
   $user = get_userdata( $user_id );
   if( 'user_points' == $column_name ){
     if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
       $userpoints = (int)cp_getPoints($user_id);
     } elseif(function_exists(WPACHIEVEMENTS_MYCRED)){
       $userpoints = (int)mycred_get_users_total( $user_id );
     } else{
       $userpoints = (int)get_user_meta( $user_id, 'achievements_points', true );
     }
     if(empty($userpoints)){$userpoints=0;}
     return $userpoints;
   }
   if( 'user_achievements' == $column_name ){
     $userachievement = get_user_meta($user_id, 'achievements_gained', true );
     if(!empty($userachievement) && $userachievement != ''){
       $user_achievements_list = '';
       $iii=0;
       foreach($userachievement as $achievement){
         $user_achievements_list .= get_achievement_name($achievement);
         if( !empty($user_achievements_list) ){
           $iii++;
         }
         if(end($userachievement) !== $achievement){
           $user_achievements_list .= ', ';
         }
       }
       if( $iii < 1 ){
         $user_achievements_list = 'None';
       }
     } else{
       $user_achievements_list = 'None';
     }
                 
     return $user_achievements_list;
   }
   return $value;
 }
 
 //*************** Add Fields to User Profile ***************\\
 if(function_exists('is_multisite') && is_multisite()){
   if( is_network_admin() ){
     add_action( 'show_user_profile', 'wpachievements_show_extra_profile_fields' );
     add_action( 'edit_user_profile', 'wpachievements_show_extra_profile_fields' );
   }
 } else{
   add_action( 'show_user_profile', 'wpachievements_show_extra_profile_fields' );
   add_action( 'edit_user_profile', 'wpachievements_show_extra_profile_fields' );
 } 

 function wpachievements_show_extra_profile_fields( $user ){
   
   global $current_user;
   get_currentuserinfo();
  
   do_action('wpachievements_user_profile_load', $user->ID);
   if( function_exists('is_super_admin') && is_super_admin() ){

    if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
     $userpoints = (int)cp_getPoints($user->ID);
    } elseif(function_exists(WPACHIEVEMENTS_MYCRED)){
     $userpoints = (int)mycred_get_users_total( $user->ID );
    } else{
     $userpoints = (int)get_user_meta( $user->ID, 'achievements_points', true );
    }
    if(empty($userpoints)){$userpoints=0;}
    ?>
    <br/>
    <h3><?php echo __('WPAchievements Management',WPACHIEVEMENTS_TEXT_DOMAIN); ?></h3>
    <?php if(!function_exists(WPACHIEVEMENTS_MYCRED)){ ?>
      <table class="form-table">
       <tr>
        <th><label for="wpa_points"><?php echo __('Points',WPACHIEVEMENTS_TEXT_DOMAIN); ?></label></th>
        <td>
         <input type="text" name="wpa_points" id="wpa_points" value="<?php echo $userpoints; ?>" class="regular-text" /><br />
        </td>
       </tr>
      </table>
      <?php 
    }
    $args = array(
      'post_type' => 'wpachievements',
      'post_status' => 'publish',
      'posts_per_page' => -1
    );              
    $ii=0;
    $achievement_query = new WP_Query( $args );
    if( $achievement_query->have_posts() ){
      $userachievement = get_user_meta( $user->ID, 'achievements_gained', true );
      ?>
      <table class="form-table">
        <tr>
          <th><label><?php echo __('Achievements',WPACHIEVEMENTS_TEXT_DOMAIN); ?></label></th>
          <td>
          <?php
          while( $achievement_query->have_posts() ){
            $achievement_query->the_post();
            $ach_ID = get_the_ID();
            $ach_title = get_the_title();
            $ach_desc = get_the_content();
            $ach_points = get_post_meta( $ach_ID, '_achievement_points', true );
            $ach_points = sprintf( __('%d Points', WPACHIEVEMENTS_TEXT_DOMAIN), $ach_points );
            if($userachievement){
              if(in_array($ach_ID,$userachievement)){
                echo '<label><input type="checkbox" checked="checked" name="achi[]" value="'. $ach_ID .'" /> '. $ach_title .' - '. $ach_desc .' <small>('. $ach_points .')</small></label><br />';
              } else{
                echo '<label><input type="checkbox" name="achi[]" value="'. $ach_ID .'" /> '. $ach_title .' - '. $ach_desc .' <small>('. $ach_points .')</small></label><br />';
              }
            } else{
              echo '<label><input type="checkbox" name="achi[]" value="'. $ach_ID .'" /> '. $ach_title .' - '. $ach_desc .' <small>('. $ach_points .')</small></label><br />';
            }
          }
          ?>
          </td>
        </tr>
      </table>
      <br/>
      <?php
    }
    wp_reset_postdata();
   }
 }

 if(function_exists('is_multisite') && is_multisite()){
   if( is_network_admin() ){
     add_action( 'personal_options_update', 'wpachievements_save_profile_achievements' );
     add_action( 'edit_user_profile_update', 'wpachievements_save_profile_achievements' );
   }
 } else{
   add_action( 'personal_options_update', 'wpachievements_save_profile_achievements' );
   add_action( 'edit_user_profile_update', 'wpachievements_save_profile_achievements' );
 }

 function wpachievements_save_profile_achievements( $user_id ){
  if( function_exists('is_super_admin') && is_super_admin() ){
   
   global $wpdb;
   if( !isset($_POST['wpa_points']) ){
     $new_points = 0;
   } else{
     $new_points = $_POST['wpa_points'];
   }
   if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
     $current_points = (int)cp_getPoints($user_id);
     if( $new_points > $current_points ){
       $dif_points = $new_points - $current_points;
       cp_alterPoints($user_id, $dif_points);
       cp_log( 'admin', $user_id, $dif_points, 1);
     }
     if( $new_points < $current_points ){
       $dif_points = $current_points - $new_points;
       cp_alterPoints($user_id, -$dif_points);
       cp_log( 'admin', $user_id, -$dif_points, 1);
     }
   } elseif(!function_exists(WPACHIEVEMENTS_MYCRED)){
     $current_points = get_user_meta( $user_id, 'achievements_points', true );
     if( $new_points != $current_points ){
       update_user_meta( $user_id, 'achievements_points', $new_points );
     }
   }
   
   if( isset($_POST['achi']) ){
     $newachievements = $_POST['achi'];
   } else{
     $newachievements = '';
   }
   $userachievement = get_user_meta( $user_id, 'achievements_gained', true );
   
   if( !empty($newachievements) && $newachievements != '' ){
     if( !empty($userachievement) && $userachievement != '' ){
       if( is_array($newachievements) ){
        $addachievements = array_diff($newachievements, $userachievement);
        $removeachievements = array_diff($userachievement, $newachievements);
       } else{
        if( empty($newachievements) || $newachievements == '' ){
          $removeachievements = $newachievements;
        } else{
          if( !array_key_exists($newachievements, $userachievement) ){
            $addachievements = $userachievement;
          }
        }
       }
     } else{
       $addachievements = $newachievements;
       $removeachievements = '';
     }
   } else{
     $addachievements = '';
     $removeachievements = $userachievement;
   }
   
   if( !empty($addachievements) && $addachievements != '' ){
     $args = array(
       'post_type' => 'wpachievements',
       'post__in' => $addachievements,
       'post_status' => 'publish',
       'posts_per_page' => -1
     );
     $achievement_query = new WP_Query( $args );
     if( $achievement_query->have_posts() ){
       while( $achievement_query->have_posts() ){
         $achievement_query->the_post();
         $ach_ID = get_the_ID();
         $ach_title = get_the_title();
         $ach_desc = get_the_content();
         $ach_data = $ach_title.': '.$ach_desc;
         $ach_points = get_post_meta( $ach_ID, '_achievement_points', true );
         $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
         $type = 'wpachievements_achievement_'.get_post_meta( $ach_ID, '_achievement_type', true );
         
         if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
           cp_points('wpachievements_achievement_'.str_replace(" ", "", strtolower($ach_title)), $user_id, $ach_points, $ach_data );
         }
         if(function_exists(WPACHIEVEMENTS_MYCRED)){
           $mycred = mycred();
           $mycred->add_creds( 'new_achievement', $user_id, $ach_points, '%plural% for Achievement: '.$ach_title );
         }
         wpachievements_increase_points( $user_id, $ach_points );
         
         $achievement = array( $ach_title, $ach_desc, $ach_points, '', $type, '', $ach_img, '' );
         
         do_action( 'wpachievements_admin_add_achievement', $user_id, $ach_ID, $achievement );
           
         if(function_exists('is_multisite') && is_multisite()){
           $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
         } else{
           $table = $wpdb->prefix.'achievements';
         }
         $wpdb->query( $wpdb->prepare("INSERT INTO `".$table."` (uid, type, data, points, rank) VALUES ($user_id, '$type', '$ach_data', '%d', '')", $ach_points) );
         
         $ach_meta = get_user_meta( $user_id, 'wpachievements_got_new_ach', true );
         if( !in_array_r( $ach_title, $ach_meta ) && !in_array_r( $ach_desc, $ach_meta ) && !in_array_r( $ach_img, $ach_meta )  ){
           $ach_meta[] = array( "title" => $ach_title, "text" => $ach_desc, "image" => $ach_img);
           update_user_meta( $user_id, 'wpachievements_got_new_ach', $ach_meta );
           update_post_meta( $ach_ID, '_user_gained_'.$user_id, $user_id );
         }
       }
     }
     wp_reset_postdata();
   }
   if( !empty($removeachievements) && $removeachievements != '' ){
     $args = array(
       'post_type' => 'wpachievements',
       'post__in' => $removeachievements,
       'post_status' => 'publish',
       'posts_per_page' => -1
     );
     $achievement_query = new WP_Query( $args );
     if( $achievement_query->have_posts() ){
       while( $achievement_query->have_posts() ){
         $achievement_query->the_post();
         $ach_ID = get_the_ID();
         $ach_title = get_the_title();
         $ach_desc = get_the_content();
         $ach_data = $ach_title.': '.$ach_desc;
         $ach_points = get_post_meta( $ach_ID, '_achievement_points', true );
         $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
         
         if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
           cp_points('wpachievements_removed', $user_id, -$ach_points, $ach_data );
         }
         if(function_exists(WPACHIEVEMENTS_MYCRED)){
           mycred_subtract( 'wpachievements_removed', $user_id, $ach_points, '%plural% for Achievement Removed: '.$ach_title );
         }
         wpachievements_decrease_points( $user_id, $ach_points, 'wpachievements_removed' );
         
         do_action( 'wpachievements_remove_achievement', $user_id, $ach_ID );
         do_action( 'wpachievements_admin_remove_achievement', $user_id, 'wpachievements_removed', $ach_points );
         
         if(function_exists('is_multisite') && is_multisite()){
           $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
         } else{
           $table = $wpdb->prefix.'achievements';
         }
         $wpdb->query( $wpdb->prepare("INSERT INTO `".$table."` (uid, type, data, points, rank) VALUES ($user_id, 'wpachievements_removed', '$ach_data', '-%d', '')", $ach_points) );
       
         delete_post_meta( $ach_ID, '_user_gained_'.$user_id );
         
         $ach_meta = get_user_meta( $user_id, 'wpachievements_got_new_ach', true );
         if( in_array_r( $ach_title, $ach_meta ) && in_array_r( $ach_desc, $ach_meta ) && in_array_r( $ach_img, $ach_meta ) ){
           foreach( $ach_meta as $key => $value ){
             if( $value["title"] == $ach_title && $value["text"] == $ach_desc && $value["image"] == $ach_img ){ unset($ach_meta[$key]); }
           }
           update_user_meta( $user_id, 'wpachievements_got_new_ach', $ach_meta );
         }
         
       }
     }
     wp_reset_postdata();
   }
   if( empty($newachievements) || $newachievements == '' ){
    $size = 0;
   } else{
    $size = sizeof($newachievements);
   }
   update_user_meta( $user_id, 'achievements_gained', $newachievements );
   update_user_meta( $user_id, 'achievements_count', $size);
   
  }
 }
 
 
/**
 ***********************************************************************
 *   W P A C H I E V E M E N T S   S U P P O R T E D   P L U G I N S   *
 ***********************************************************************
 */
 //*************** Update Admin Menu Tabs ***************\\
 function wpachievements_supported_plugins(){
   ?>
   <img src="<?php echo plugins_url('wpachievements/img/logo.png'); ?>" alt="WPAchievements Logo" width="35" style="float:left;margin:6px 5px 0 0;" />
   <h2><?php echo __('WPAchievements - Supported Plugins', WPACHIEVEMENTS_TEXT_DOMAIN); ?></h2>
   <p style="padding-right:20px;">WPAchievements comes complete with a list of user events that you can link achievements to, this enables you to reward your users for being active. Here is a list of supported plugins:</p>
   <div id="plugin-support-images">
     <div class="item"><a href="http://wordpress.org/plugins/buddystream/" target="_blank" title="View: BuddyStream"><img src="<?php echo plugins_url('wpachievements/img/banners/buddystream.png'); ?>" alt="BuddyStream Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/buddypress/" target="_blank" title="View: BuddyPress"><img src="<?php echo plugins_url('wpachievements/img/banners/buddypress.png'); ?>" alt="BuddyPress Banner" /></a></div>
     <div class="item"><a href="http://simple-press.com/" target="_blank" title="View: Simple:Press"><img src="<?php echo plugins_url('wpachievements/img/banners/simplepress.png'); ?>" alt="Simple:Press Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/bbpress/" target="_blank" title="View: bbPress"><img src="<?php echo plugins_url('wpachievements/img/banners/bbpress.png'); ?>" alt="bbPress Banner" /></a></div>
     <div class="item"><a href="http://www.learndash.com/" target="_blank" title="View: LearnDash"><img src="<?php echo plugins_url('wpachievements/img/banners/learndash.png'); ?>" alt="LearnDash Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/gd-star-rating/" target="_blank" title="View: GD Star Rating"><img src="<?php echo plugins_url('wpachievements/img/banners/gd-star-rating.png'); ?>" alt="GD Star Rating Banner" /></a></div>
     <div class="item"><a href="http://www.wpcourseware.com/" target="_blank" title="View: WP-Courseware"><img src="<?php echo plugins_url('wpachievements/img/banners/wp-courseware.png'); ?>" alt="WP-Courseware Banner" /></a></div>
     <div class="item"><a href="http://www.gravityforms.com/" target="_blank" title="View: Gravity Forms"><img src="<?php echo plugins_url('wpachievements/img/banners/gravity-forms.png'); ?>" alt="Gravity Forms Banner" /></a></div>
     <div class="item"><a href="http://myarcadeplugin.com/" target="_blank" title="View: MyArcadePlugin"><img src="<?php echo plugins_url('wpachievements/img/banners/myarcadeplugin.png'); ?>" alt="MyArcadePlugin Banner" /></a></div>
     <div class="item"><a href="http://exells.com/shop/arcade-plugins/myarcadecontest/" target="_blank" title="View: MyArcadeContest"><img src="<?php echo plugins_url('wpachievements/img/banners/myarcadecontest.png'); ?>" alt="MyArcadeContest Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/mycred/" target="_blank" title="View: myCRED"><img src="<?php echo plugins_url('wpachievements/img/banners/mycred.png'); ?>" alt="myCRED Banner" /></a></div>
     <div class="item"><a href="http://codecanyon.net/item/userpro-user-profiles-with-social-login/5958681" target="_blank" title="View: UserPro"><img src="<?php echo plugins_url('wpachievements/img/banners/userpro.png'); ?>" alt="UserPro Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/cubepoints/" target="_blank" title="View: CubePoints"><img src="<?php echo plugins_url('wpachievements/img/banners/cubepoints.png'); ?>" alt="CubePoints Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/woocommerce/" target="_blank" title="View: BuddyStream"><img src="<?php echo plugins_url('wpachievements/img/banners/woocommerce.png'); ?>" alt="WooCommerce Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/wp-e-commerce/" target="_blank" title="View: WP e-Commerce"><img src="<?php echo plugins_url('wpachievements/img/banners/wp-e-commerce.png'); ?>" alt="WP e-Commerce Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/jigoshop/" target="_blank" title="View: Jigoshop"><img src="<?php echo plugins_url('wpachievements/img/banners/jigoshop.png'); ?>" alt="Jigoshop Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/wp-favorite-posts/" target="_blank" title="View: WP Favorite Posts"><img src="<?php echo plugins_url('wpachievements/img/banners/wp-favorite-posts.png'); ?>" alt="WP Favorite Posts Banner" /></a></div>
     <div class="item"><a href="http://wordpress.org/plugins/invite-anyone/" target="_blank" title="View: Invite Anyone"><img src="<?php echo plugins_url('wpachievements/img/banners/invite-anyone.png'); ?>" alt="Invite Anyone Banner" /></a></div>
     <div class="item"><img src="<?php echo plugins_url('wpachievements/img/banners/wordpress.png'); ?>" alt="WordPress Banner" /></div>
   </div>
   <?php
 }
 
 
 
 /**
 *************************************************************************
 *   W P A C H I E V E M E N T S   L A T E S T   I N F O R M A T I O N   *
 *************************************************************************
 */
 function wpachievements_important_notice(){
   if(function_exists('is_multisite') && is_multisite()){
     $notice_dismiss = get_blog_option(1, 'wpachievements_important_notice_status');
   } else{
     $notice_dismiss = get_option('wpachievements_important_notice_status');
   }
   wp_enqueue_script( 'ImportantNoticeScript', plugins_url('/js/info-notice.js', __FILE__) );
   if( empty($notice_dismiss) ){
     echo '<div class="updated" style="background-color:#ffd7d7;border-color:#F00;">
       <strong><p style="display:inline-block;">'. __('Important changes have been made to WPAchievements that could effect your website!!!', WPACHIEVEMENTS_TEXT_DOMAIN) .'&nbsp;</p></strong>
       <a href="javascript:void(0);" id="wpa_important_submit">View Changes</a>
     </div>';
   }
 }
 if(function_exists('is_multisite') && is_multisite()){
   add_action( 'network_admin_notices', 'wpachievements_important_notice' );
   global $blog_id;
   if($blog_id == 1){
     add_action( 'admin_notices', 'wpachievements_important_notice' );
   }
 } else{
   add_action( 'admin_notices', 'wpachievements_important_notice' );
 }
 
 function wpachievements_latest_info(){
   if(function_exists('is_multisite') && is_multisite()){
     $notice_status = get_blog_option(1,'wpachievements_important_notice_status');
     if( empty($notice_status) ){
       update_blog_option(1,'wpachievements_important_notice_status', 'visited');
     }
   } else{
     $notice_status = get_option('wpachievements_important_notice_status');
     if( empty($notice_status) ){
       update_option('wpachievements_important_notice_status', 'visited');
     }
   }
   ?>
   <div id="wpa_important">
     <h1 class="wpa_main_title">Important Update Notices</h1>
     <div class="wpa_important_item">
       <p><font color="#FF0000" style="font-weight:bold;font-size:13px;">Facebook Login Functionality Removed!!!</font></p>
       <p><strong>Facebook Login functionality and related shortcodes have been removed. &nbsp; Facebook & Twitter sharing buttons still work.</strong></p>
     </div>
   </div>
   <div class="clear"></div>
   <div id="wpa_change_log_outter">
     <h1 class="wpa_main_title">Changelog</h1>
     <div id="wpa_change_log">
       <h4>v7.10 - 2014-05-21</h4>
       <ul>
        <li><strong>Fixed:</strong>Activities not displaying in the admin bar when myCRED is active</li>
        <li><strong>Fixed:</strong>Database column missing if installation did not finish correctly</li>
       </ul>
       
       
       
     </div>
   </div>
   <div id="wpa_latest_products">
     <h1 class="wpa_main_title">Our Latest Products</h1>
     <?php
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, 'http://marketplace.envato.com/api/v1/new-files-from-user:DigitalBuilder,codecanyon.json');
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $ch_data = curl_exec($ch);
     curl_close($ch);

     if(!empty($ch_data)){
       $prod_descriptions = array( 'WP User Management Plus' => 'WP User Management Plus is a WordPress plugin that gives you massively improved control over your users when compared to the default WordPress User Management functionality.' );
       if( get_bloginfo('version') >= 3.8 ){ $prod_descriptions = array( 'WP User Management Plus' => 'WP User Management Plus gives you massively improved control over your users when compared to the default WordPress User Management functionality.' ); }
       $json_data = json_decode($ch_data, true);
       $data_count = count($json_data['new-files-from-user']) -1;
  
       for($i = 0; $i <= $data_count; $i++){
           echo '<div class="wpa_product_item">
             <div class="wpa_product_links">
               <img src="'.$json_data['new-files-from-user'][$i]['thumbnail'].'" width="80" height="80" alt="" class="wpa_pull_left">
               <a href="'.$json_data['new-files-from-user'][$i]['url'].'" target="_blank">View Details</a>
             </div>
             <h3>'.$json_data['new-files-from-user'][$i]['item'].' <small>(WordPress Plugin)</small></h3>
             <p>'.$prod_descriptions[$json_data['new-files-from-user'][$i]['item']].'</p>
             <span><strong>Cost:</strong> $'.$json_data['new-files-from-user'][$i]['cost'].'</span>
             <span>&nbsp;-&nbsp;<strong>Released:</strong> '.date('F j, Y',strtotime($json_data['new-files-from-user'][$i]['uploaded_on'])).'</span>
             <div class="wpa_clear"></div>
           </div>';
       }
     }
     ?>
     <?php if( get_bloginfo('version') < 3.8 ){ echo '<br/>'; } ?>
     <div id="wpa_donations">
       <h1 class="wpa_main_title">Donations</h1>
       <p>If you like WPAchievements or any of Digital Builder's products then feel free to show your support by making a donation.</p>
       <p><strong>Note:</strong> Any donations that we receive will be used to help improve our products, pay for support staff or developers, improve our server and equipment and/or help us to purchase premium plugins to integrate with our products.</p>
       <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
         <input type="hidden" name="cmd" value="_s-xclick">
         <input type="hidden" name="hosted_button_id" value="CQRANJNLUHM5Y">
         <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
         <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
       </form>
     </div>
   </div>
   <?php
 }
 
 function wpachievements_documentation(){
   ?>
   <div id="wpa_change_log_outter">
     <h1 class="wpa_main_title">WPAchievements Shortcodes</h1>
     <div id="wpa_change_log">
       <h2 style="font-weight:bold;">My Achievements</h2>
       <p>Copy this to any post/page to display a list of achievement images that the user has gained. <code class="wpa_code_blue">[wpa_myachievements]</code></p>
       <h4 style="font-weight:bold;margin-bottom:5px;">Available Parameters</h4>
       <table class="wpa_doc_params" cellspacing="0" cellpadding="0">
         <thead>
           <tr>
             <th>Parameter</th>
             <th>Description</th>
           </tr>
         </thead>
         <tbody>
           <tr class="alternate">
             <th>user_id</th>
             <td class="wpa_doc_desc">The ID of the user to list achievement images for. If blank it defaults to current logged in user.</td>
           </tr>
           <tr>
             <th>show_title</th>
             <td class="wpa_doc_desc">Whether to display the title: "My Achievements". Example: "True" to show or "False" to hide. If blank it defaults to true.</td>
           </tr>
           <tr class="alternate">
             <th>title_class</th>
             <td class="wpa_doc_desc">This class will be added to the title and will allow the use of custom CSS.</td>
           </tr>
           <tr>
             <th>image_holder_class</th>
             <td class="wpa_doc_desc">This class will be added to the achievement image holder and will allow the use of custom CSS.</td>
           </tr>
           <tr class="alternate">
             <th>image_class</th>
             <td class="wpa_doc_desc">This class will be added to the achievement images in the list and will allow the use of custom CSS.</td>
           </tr>
           <tr>
             <th>image_width</th>
             <td class="wpa_doc_desc">This is the width of each achievement image. Value needs to be in "px". Default is "30"</td>
           </tr>
           <tr class="alternate">
             <th>achievement_limit</th>
             <td class="wpa_doc_desc">Limit the number of achievement images shown. If blank it will show all achievements available.</td>
           </tr>
         </tbody>
       </table>
       <h4 style="font-weight:bold;margin-bottom:5px;">Examples</h4>
       <pre class="wpa_code wpa_code_green">[wpa_myachievements user_id="1" show_title="true" achievement_limit="30"]</pre>
       <pre class="wpa_code wpa_code_green">[wpa_myachievements user_id="2" show_title="false" image_width="20" achievement_limit="10"]</pre>
       <div class="wpa_shortcode_sep"></div>
       <h2 style="font-weight:bold;">Unformatted Leaderboard List</h2>
       <p>Copy this to any post/page to display an unformatted leaderboard list. <code class="wpa_code_blue">[wpa_leaderboard_list]</code></p>
       <h4 style="font-weight:bold;margin-bottom:5px;">Available Parameters</h4>
       <table class="wpa_doc_params" cellspacing="0" cellpadding="0">
         <thead>
           <tr>
             <th>Parameter</th>
             <th>Description</th>
           </tr>
         </thead>
         <tbody>
           <tr class="alternate">
             <th>user_position</th>
             <td class="wpa_doc_desc">Whether to show the trophy icons/place numbering. Example: "True" to show or "False" to hide. If blank it defaults to true.</td>
           </tr>
           <tr class="alternate">
             <th>type</th>
             <td class="wpa_doc_desc">Whether to order the leaderboard by amount of points or achievements. Example: "Points" or "Achievements". If blank it defaults to Achievements.</td>
           </tr>
           <tr>
             <th>limit</th>
             <td class="wpa_doc_desc">Limit the number of users shown. If blank it will show all users available.</td>
           </tr>
           <tr>
             <th>list_class</th>
             <td class="wpa_doc_desc">This class will be added to the leaderboard list and will allow the use of custom CSS.</td>
           </tr>
         </tbody>
       </table>
       <h4 style="font-weight:bold;margin-bottom:5px;">Examples</h4>
       <pre class="wpa_code wpa_code_green">[wpa_leaderboard_list user_position="true" type="points" limit="10"]</pre>
       <pre class="wpa_code wpa_code_green">[wpa_leaderboard_list user_position="false" type="achievements" limit="10"]</pre>
       <div class="wpa_shortcode_sep"></div>
       <h2 style="font-weight:bold;">Standard Leaderboard</h2>
       <p>Copy this to any post/page to display a standard leaderboard. <code class="wpa_code_blue">[wpa_leaderboard_widget]</code></p>
       <h4 style="font-weight:bold;margin-bottom:5px;">Available Parameters</h4>
       <table class="wpa_doc_params" cellspacing="0" cellpadding="0">
         <thead>
           <tr>
             <th>Parameter</th>
             <th>Description</th>
           </tr>
         </thead>
         <tbody>
            <tr class="alternate">
             <th>type</th>
             <td class="wpa_doc_desc">Whether to order the leaderboard by amount of points or achievements. Example: "Points" or "Achievements". If blank it defaults to Achievements.</td>
           </tr>
           <tr>
             <th>limit</th>
             <td class="wpa_doc_desc">Limit the number of users shown. If blank it will show all users available.</td>
           </tr>
         </tbody>
       </table>
       <h4 style="font-weight:bold;margin-bottom:5px;">Examples</h4>
       <pre class="wpa_code wpa_code_green">[wpa_leaderboard_widget type="points" limit="10"]</pre>
       <pre class="wpa_code wpa_code_green">[wpa_leaderboard_widget type="achievements" limit="10"]</pre>
       <div class="wpa_shortcode_sep"></div>
       <h2 style="font-weight:bold;">Leaderboard Data Table</h2>
       <p>Copy this to any post/page to display an advanced leaderboard data table. <code class="wpa_code_blue">[wpa_leaderboard]</code></p>
       <h4 style="font-weight:bold;margin-bottom:5px;">Available Parameters</h4>
       <table class="wpa_doc_params" cellspacing="0" cellpadding="0">
         <thead>
           <tr>
             <th>Parameter</th>
             <th>Description</th>
           </tr>
         </thead>
         <tbody>
           <tr class="alternate">
             <th>position_numbers</th>
             <td class="wpa_doc_desc">Whether to show leaderboard position numbering. Example: "True" to show or "False" to hide. If blank it defaults to true.</td>
           </tr>
           <tr>
             <th>columns</th>
             <td class="wpa_doc_desc">Select which columns to display. Available Inputs: avatar,points,achievements. If blank it defaults to true.</td>
           </tr>
           <tr class="alternate">
             <th>limit</th>
             <td class="wpa_doc_desc">Limit the number of users shown. If blank it will show all users available.</td>
           </tr>
           <tr>
             <th>achievement_limit</th>
             <td class="wpa_doc_desc">Limit the number of achievements shown. If blank it will show all achievements available.</td>
           </tr>
           <tr>
             <th>list_class</th>
             <td class="wpa_doc_desc">This class will be added to the leaderboard list and will allow the use of custom CSS.</td>
           </tr>
         </tbody>
       </table>
       <h4 style="font-weight:bold;margin-bottom:5px;">Examples</h4>
       <pre class="wpa_code wpa_code_green">[wpa_leaderboard position_numbers="true" achievement_limit="10" limit="10" columns="avatar,points,achievements"]</pre>
       <pre class="wpa_code wpa_code_green">[wpa_leaderboard position_numbers="false" limit="10" list_class="my_custom_class" columns="avatar,points,achievements"]</pre>
     </div>
   </div>
   <div id="wpa_latest_products">
     <h1 class="wpa_main_title">Our Latest Products</h1>
     <?php
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, 'http://marketplace.envato.com/api/v1/new-files-from-user:DigitalBuilder,codecanyon.json');
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $ch_data = curl_exec($ch);
     curl_close($ch);

     if(!empty($ch_data)){
       $prod_descriptions = array( 'WP User Management Plus' => 'WP User Management Plus is a WordPress plugin that gives you massively improved control over your users when compared to the default WordPress User Management functionality.' );
       if( get_bloginfo('version') >= 3.8 ){ $prod_descriptions = array( 'WP User Management Plus' => 'WP User Management Plus gives you massively improved control over your users when compared to the default WordPress User Management functionality.' ); }
       $json_data = json_decode($ch_data, true);
       $data_count = count($json_data['new-files-from-user']) -1;
  
       for($i = 0; $i <= $data_count; $i++){
           echo '<div class="wpa_product_item">
             <div class="wpa_product_links">
               <img src="'.$json_data['new-files-from-user'][$i]['thumbnail'].'" width="80" height="80" alt="" class="wpa_pull_left">
               <a href="'.$json_data['new-files-from-user'][$i]['url'].'" target="_blank">View Details</a>
             </div>
             <h3>'.$json_data['new-files-from-user'][$i]['item'].' <small>(WordPress Plugin)</small></h3>
             <p>'.$prod_descriptions[$json_data['new-files-from-user'][$i]['item']].'</p>
             <span><strong>Cost:</strong> $'.$json_data['new-files-from-user'][$i]['cost'].'</span>
             <span>&nbsp;-&nbsp;<strong>Released:</strong> '.date('F j, Y',strtotime($json_data['new-files-from-user'][$i]['uploaded_on'])).'</span>
             <div class="wpa_clear"></div>
           </div>';
       }
     }
     ?>
     <?php if( get_bloginfo('version') < 3.8 ){ echo '<br/>'; } ?>
     <div id="wpa_donations">
       <h1 class="wpa_main_title">Donations</h1>
       <p>If you like WPAchievements or any of Digital Builder's products then feel free to show your support by making a donation.</p>
       <p><strong>Note:</strong> Any donations that we receive will be used to help improve our products, pay for support staff or developers, improve our server and equipment and/or help us to purchase premium plugins to integrate with our products.</p>
       <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
         <input type="hidden" name="cmd" value="_s-xclick">
         <input type="hidden" name="hosted_button_id" value="CQRANJNLUHM5Y">
         <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
         <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
       </form>
     </div>
   </div>
   <?php
 }
 
/**
 *********************************************************************
 *   W P A C H I E V E M E N T S   U P D A T E   M E N U   T A B S   *
 *********************************************************************
 */
 //*************** Update Admin Menu Tabs ***************\\
 function update_wpachievements_points_menu_admin(){
  echo "<script>
  jQuery(document).ready(function(){
    jQuery('#wp-admin-bar-custom_ranks_menu').load('".get_bloginfo('url')." #wp-admin-bar-custom_ranks_menu > *');
  });
    </script>";
 }

/**
 *********************************************************************
 *   W P A C H I E V E M E N T S   A D D I T I O N A L   S T U F F   *
 *********************************************************************
 */
 function WPAchievements_Upgrade_Notice(){
   if( isset($GLOBALS['_GET']['post_type']) ){
     if( in_array($GLOBALS['_GET']['post_type'], array('wpachievements')) ){
       echo '<div class="updated"><strong><p>'. __('You are using a limited version of WPAchievements:', WPACHIEVEMENTS_TEXT_DOMAIN) .'&nbsp;&nbsp;<a href="edit.php?post_type=wpachievements&page=wpachievements_premium">View Premium Version</a></p></strong></div>';
     }
   }
 }
 add_action( 'admin_notices', 'WPAchievements_Upgrade_Notice' );
 
 add_action('wp_ajax_wpachievements_info_notice_ajax', 'wpachievements_info_notice_ajax_callback');
 function wpachievements_info_notice_ajax_callback(){
   if(isset($_POST['wpa_ignore'])){
     if(function_exists('is_multisite') && is_multisite()){
       global $wpdb;
       update_blog_option(1,'wpachievements_ignore_info', $_POST['wpa_ignore']);
     } else{
       update_option('wpachievements_ignore_info', $_POST['wpa_ignore']);
     }
   }
   die();
 }
 
?>