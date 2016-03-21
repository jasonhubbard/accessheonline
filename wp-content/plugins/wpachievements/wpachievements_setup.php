<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 *******************************
 *    B A S I C   S E T U P    *
 *******************************
 */   
 //*************** Add Stylesheet ***************\\
 add_action( 'wp_enqueue_scripts', 'wpachievements_stylesheet' ); add_action( 'admin_enqueue_scripts', 'wpachievements_stylesheet' );
 function wpachievements_stylesheet() {
   if(function_exists('is_multisite') && is_multisite()){
     $rtl = get_blog_option(1,'wpachievements_rtl_lang');
   } else{
     $rtl = get_option('wpachievements_rtl_lang');
   }
   if($rtl == 'true'){
    wp_register_style( 'wpachievements-style', plugins_url('/css/style-rtl.css', __FILE__) );
   } else{
     wp_register_style( 'wpachievements-style', plugins_url('/css/style.css', __FILE__) );
   }
   
   wp_register_style( 'wpachievements-widget-style', plugins_url('/css/widget-style.css', __FILE__) );
   wp_enqueue_style( 'wpachievements-widget-style' );
   
   wp_enqueue_style( 'wpachievements-style' );
   if( get_bloginfo('version') >= 3.8 ){
     wp_enqueue_style( 'wpachievements-style-3-8', plugins_url('/css/style-3.8.css', __FILE__) );
   }
   wp_register_style( 'wpachievements-fb-sharing-style', plugins_url('/social/facebook/css/wpachievements_fb_sharing.css', __FILE__) );
   wp_enqueue_style( 'wpachievements-fb-sharing-style' );
   wp_register_style( 'wpachievements-twr-sharing-style', plugins_url('/social/twitter/css/wpachievements_twr_sharing.css', __FILE__) );
   wp_enqueue_style( 'wpachievements-twr-sharing-style' );
   
 }
 function wpachievements_modal_setup() {
   wp_register_style( 'wpachievements-notify-style', plugins_url('/popup/css/MetroNotificationStyle.min.css', __FILE__) );
   

   if(function_exists('is_multisite') && is_multisite()){
     $ach_share = get_blog_option(1,'wpachievements_pshare');
     $appId = get_blog_option(1,'wpachievements_appID');
   } else{
     $ach_share = get_option('wpachievements_pshare');
     $appId = get_option('wpachievements_appID');
   }
   if( $ach_share == 'true' && !empty($appId) ){
     wp_register_script( 'wpachievements-notify-script', plugins_url('/popup/js/MetroNotificationShare.js', __FILE__) );
   } else{
     wp_register_script( 'wpachievements-notify-script', plugins_url('/popup/js/MetroNotification.js', __FILE__) );
   }
   wp_enqueue_script( 'jquery' );
   wp_enqueue_style( 'wpachievements-notify-style' );
   if(function_exists('is_multisite') && is_multisite()){
     $rtl = get_blog_option(1,'wpachievements_rtl_lang');
   } else{
     $rtl = get_option('wpachievements_rtl_lang');
   }
   if($rtl == 'true'){
    wp_register_style( 'wpachievements-notify-rtl-style', plugins_url('/popup/css/MetroNotificationStyle.rtl.min.css', __FILE__) );
    wp_enqueue_style( 'wpachievements-notify-rtl-style' );
   }
   wp_enqueue_script( 'wpachievements-notify-script' );
   
   wp_register_script( 'wpachievements-achievements-list', plugins_url('/js/script.js', __FILE__), array('jquery') );
   wp_enqueue_script( 'wpachievements-achievements-list' );
   
   if( is_user_logged_in() ){     
     global $current_user;
     get_currentuserinfo();
     if(function_exists('is_multisite') && is_multisite()){
       $pcheck = get_blog_option(1,'wpachievements_pcheck');
     } else{
       $pcheck = get_option('wpachievements_pcheck');
     }
     wp_enqueue_script( 'wpachievements-notify-check', plugins_url('/js/notify-check.js', __FILE__), array( 'jquery', 'heartbeat' ) );
     wp_localize_script( 'wpachievements-notify-check', 'WPA_Ajax', array( 'userid' => $current_user->ID, 'check_rate' => $pcheck  ) );
   }
   
 } add_action( 'wp_enqueue_scripts', 'wpachievements_modal_setup' );

/**
 ***********************************
 *    I N C L U D E   F I L E S    *
 ***********************************
 */
 $mainplugindir = dirname( __FILE__ );
 if(is_admin()){
   require_once($mainplugindir. '/wpachievements_admin.php');
 }
 if(function_exists('is_multisite') && is_multisite()){
   global $wpdb;
   
   $query = "SELECT * FROM {$wpdb->blogs}, {$wpdb->registration_log}
   WHERE site_id = '{$wpdb->siteid}'
   AND {$wpdb->blogs}.blog_id = {$wpdb->registration_log}.blog_id";

   $blog_list = $wpdb->get_results( $query, ARRAY_A );

   $pi = array();

   $blog_list[-1] = array( 'blog_id' => 1 );
   ksort($blog_list);
   foreach( $blog_list as $k => $info ) {
     $bid = $info['blog_id'];
     $pi[ $bid ] = get_blog_option( $bid, 'active_plugins' );
   }
   $pi = array_filter($pi);
   $active = array();
   foreach($pi as $k => $v_array) {
     $active = array_merge($active, $v_array);
   }
 } else{
   $active = get_option('active_plugins');
 }
 
 require_once($mainplugindir. '/wpachievements_achievments.php');
 require_once($mainplugindir. '/wpachievements_achievements_page_setup.php');
 require_once($mainplugindir. '/wpachievements_shortcodes.php');
 
 //*************** Include Default WordPress Integration ***************\\ 
 require_once($mainplugindir. '/modules/wordpress.php');
 //*************** Include CubePoints Integration ***************\\ 
 if( function_exists(WPACHIEVEMENTS_CUBEPOINTS) || in_array('cubepoints/cubepoints.php',$active) ){
   require_once($mainplugindir. '/modules/cubepoints.php');
 }
 //*************** Include myCRED Integration ***************\\ 
 if( function_exists(WPACHIEVEMENTS_MYCRED) || in_array('mycred/mycred.php',$active) ){
   require_once($mainplugindir. '/modules/mycred.php');
 }
 //*************** Include MyArcadePlugin Integration ***************\\ 
 if( function_exists(WPACHIEVEMENTS_MYARCADE) || function_exists(WPACHIEVEMENTS_MYARCADE_ALT) || in_array('myarcadecontest/myarcadecontest.php',$active) ){
   require_once($mainplugindir. '/modules/myarcadeplugin.php');
 }
 //*************** Include LearnDash Integration ***************\\ 
 if( function_exists(WPACHIEVEMENTS_LEARNDASH) || in_array('sfwd-lms/sfwd_lms.php',$active) ){
   require_once($mainplugindir. '/modules/learndash.php');
 }
 //*************** Include WP-Courseware Integration ***************\\ 
 if( function_exists(WPACHIEVEMENTS_WPCOURSEWARE) ){
   require_once($mainplugindir. '/modules/wpcourseware.php');
 }
 
 //*************** Include Facebook Integration ***************\\ 
 require_once($mainplugindir. '/social/facebook/setup.php');
 //*************** Include Twitter Integration ***************\\ 
 require_once($mainplugindir. '/social/twitter/setup.php');

/**
 ***********************************************
 *   A D D I T I O N A L   F U N C T I O N S   *
 ***********************************************
 */
 if( !function_exists('in_array_r') ){
   function in_array_r($needle, $haystack, $strict = true) {
    if(is_array($haystack)){
     foreach ($haystack as $item) {
      if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
       return true;
      }
     }
    }
    return false;
   }
 }
 if( !function_exists('removeElementWithoutValue') ){
   function removeElementWithoutValue($array, $key, $value) {
    foreach($array as $subKey => $subArray){
     if($subArray[$key] != $value){
      unset($array[$subKey]);
     }
    }
    return $array;
   }
 }
 if( !function_exists('curPageURL') ){
   function curPageURL() { 
    $pageURL = 'http'; 
    if (!empty($_SERVER['HTTPS'])) {if($_SERVER['HTTPS'] == 'on'){$pageURL .= "s";}} 
    $pageURL .= "://"; 
    if ($_SERVER["SERVER_PORT"] != "80") { 
     $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; 
    } else { 
     $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; 
    } 
    return $pageURL; 
   }
 }
 function wpachievements_achievement_id_by_title($ach_title) {
   if(function_exists('is_multisite') && is_multisite()){
     switch_to_blog(1);
   }
   global $wpdb;
   $id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'wpachievements' AND post_status = 'publish'", $ach_title ));
   if(function_exists('is_multisite') && is_multisite()){
     restore_current_blog();
   }
   if( $id )
     return $id;
   return null;
 }
 function wpachievements_increase_points( $userID, $points){
   if(function_exists('is_multisite') && is_multisite()){
    switch_to_blog(1);
   }
   $curpoints = get_user_meta( $userID, 'achievements_points', true );
   $new_points = $curpoints + $points;
   update_user_meta( $userID, 'achievements_points', $new_points );
   if(function_exists('is_multisite') && is_multisite()){
    restore_current_blog();
   }
 }
 function wpachievements_decrease_points( $userID, $points ){
   if(function_exists('is_multisite') && is_multisite()){
    switch_to_blog(1);
   }
   $curpoints = get_user_meta( $userID, 'achievements_points', true );
   $new_points = $curpoints - $points;
   update_user_meta( $userID, 'achievements_points', $new_points );
   if(function_exists('is_multisite') && is_multisite()){
    restore_current_blog();
   }
 }
 
 //*************** Include Dashboard Widget ***************\\
 if(function_exists('is_multisite') && is_multisite()){
   add_action('wp_network_dashboard_setup', 'wpachievements_add_dashboard_widgets' );
 } else{
   add_action('wp_dashboard_setup', 'wpachievements_add_dashboard_widgets' );
 }
 function wpachievements_add_dashboard_widgets() {
  wp_add_dashboard_widget('dashboard_wpachievements', 'WPAchievements: Recent Activity', 'wpachievements_dashboard_widget_function');  
 }
 function wpachievements_dashboard_widget_function() {
  global $wpdb;
  if(function_exists('is_multisite') && is_multisite()){
    $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
  } else{
    $table = $wpdb->prefix.'achievements';
  }
  
  echo '<div id="inner_cont_hold">';
    echo '<h4>Most Recent Achievements:<a href="#" id="wpamra">Refresh</a></h4>';
    echo '<div id="wpamra_hold">';
    
    $activities = $wpdb->get_results( $wpdb->prepare("SELECT id, uid, data, points FROM $table WHERE type LIKE %s ORDER BY id DESC LIMIT 0, 5", 'wpachievements_achievement%') );
    
    if( is_array($activities) ){
      foreach( $activities as $activity ):
        $user_info = '';
        $user_info = get_user_by('id', $activity->uid);
        if( !empty($user_info) ){
          $ach_name = explode( ':',$activity->data);
          echo '<div class="achievements_item" id="achieve_'.$activity->id.'">';
          echo '<span><strong>'. $user_info->user_login .'</strong> '. __('gained the achievement: ', WPACHIEVEMENTS_TEXT_DOMAIN) .' </span>';
          echo '<span><strong>'. $ach_name[0] .'</strong> '. __('and got ', WPACHIEVEMENTS_TEXT_DOMAIN) .' </span>';
          echo '<span><strong>'. $activity->points .' '. __('points ', WPACHIEVEMENTS_TEXT_DOMAIN) .'</strong> </span>';
          echo '</div>';
        }
      endforeach;
    }
    echo '</div>';
    echo '<br/>';
    echo '<h4>Most Recent Points: <a href="#" id="wpamrp">Refresh</a></h4>';
    echo '<div id="wpamrp_hold">';
    
    $activities = $wpdb->get_results( $wpdb->prepare("SELECT id, uid, type, points FROM $table WHERE points <> 0 AND type NOT LIKE %s ORDER BY id DESC LIMIT 0, 5",'wpachievements_achievement%') );
    
    if( is_array($activities) ){
      foreach( $activities as $activity ):
        $user_info = '';
        $user_info = get_user_by('id', $activity->uid);
        if( !empty($user_info) ){
          $type_text = achievement_Desc($activity->type,$activity->points,'a ','','');
          if( $activity->points > 0 ){
            $point_type = __('gained', WPACHIEVEMENTS_TEXT_DOMAIN);
          } else{
            $point_type = __('lost', WPACHIEVEMENTS_TEXT_DOMAIN);
          }
          echo '<div class="achievements_item" id="achieve_'.$activity->id.'">';
          echo '<span><strong>'. $user_info->user_login .'</strong> '. sprintf( __('%s ', WPACHIEVEMENTS_TEXT_DOMAIN), $point_type ) .' </span>';
          echo '<span><strong>'. $activity->points .' '. __('points ', WPACHIEVEMENTS_TEXT_DOMAIN) .'</strong> </span>';
          echo '<span>'. $type_text .' </span>';
          echo '</div>';
        }
      endforeach;
    }
    echo '</div>';
  echo '</div>';
 }
 function wpachievements_dashboard_css() {
  echo '<style>
  #dashboard_wpachievements h4{color:#333;font-size:16px;border-bottom:1px solid #ccc;padding:5px 10px 5px 0;}
  #dashboard_wpachievements h4 a{float:right;font-size:12px;margin-top:3px;}
  #dashboard_wpachievements #loader-icon img{display:block;margin:20px auto 10px;}
  #dashboard_wpachievements .achievements_item{color:#666;padding:2px 0;}
  #dashboard_wpachievements .achievements_item strong{color:#444;}
  #dashboard_wpachievements .sbHolder{border:4px solid #D1D1D1 !important;margin:10px auto -5px;}
  </style>';
  echo "<script>
  jQuery(document).ready(function(){
    jQuery('#dashboard_wpachievements h4 a').click(function(event){
      event.preventDefault();
      if( jQuery(this).attr('id') == 'wpamra' ){
        jQuery('#dashboard_wpachievements #wpamra_hold').hide('slow').load('".curPageURL()." #dashboard_wpachievements #wpamra_hold', function() {
          jQuery('#dashboard_wpachievements #wpamra_hold').show('slow');
        });
      } else if( jQuery(this).attr('id') == 'wpamrp' ){
        jQuery('#dashboard_wpachievements #wpamrp_hold').hide('slow').load('".curPageURL()." #dashboard_wpachievements #wpamrp_hold', function() {
          jQuery('#dashboard_wpachievements #wpamrp_hold').show('slow');
        });
      }
    });";
  echo "});
  </script>";
 }
 add_action('admin_head', 'wpachievements_dashboard_css');
 

/**
 *****************************************
 *    C O N V E R T   O L D   D A T A    *
 *****************************************
 */
 add_action('wpachievements_user_admin_load', 'wpachievements_data_conversion', 1);
 add_action('wpachievements_user_profile_load', 'wpachievements_data_conversion', 1);
 add_action('wp_footer', 'wpachievements_data_conversion', 1);
 function wpachievements_sort_array($x){
   return $x[0];
 }
 function wpachievements_data_conversion($user_id){
   if( is_user_logged_in() ){
    if( empty($user_id) ){
      global $current_user;
      get_currentuserinfo();
      $user_id = $current_user->ID;
    }
    if( get_user_meta( $user_id, 'achievements_data_converted', true ) != 'done' ){
     if( function_exists('is_multisite') && is_multisite() ){

       global $wpdb;
       
       $table_name = 'wpachievements_activity';
       if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
         $sql =
          "CREATE TABLE " . $table_name . " (
          id bigint(20) NOT NULL AUTO_INCREMENT,
          uid bigint(20) NOT NULL,
          type VARCHAR(256) NOT NULL,
          rank TEXT NOT NULL,
          data TEXT NOT NULL,
          points bigint(20) NOT NULL,
          postid bigint(20) NOT NULL,
          UNIQUE KEY id (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
       }

       $blog_table = $wpdb->get_blog_prefix(1).'blogs';
       $old_blog = $wpdb->blogid;

       $site_blog_ids = $wpdb->get_results( "SELECT blog_id FROM $blog_table" ); // get all subsite blog ids

       $add_points = 0;
       $points = 0;
       $activities = array();
       $achievements = array();
       foreach( $site_blog_ids as $blog_id ){
         switch_to_blog( $blog_id->blog_id );

         $ach_table = $wpdb->get_blog_prefix($blog_id->blog_id).'achievements';
         array_push( $activities, $wpdb->get_results( $wpdb->prepare("SELECT type,rank,data,points,postid FROM $ach_table WHERE uid=%d", $user_id) ) );
         
         $wpdb->delete( 
           $ach_table, 
           array( 
             'uid' => $user_id 
           ) 
         );

         $points = $points + (int)get_blog_option( $wpdb->blogid, $user_id.'_achievements_points', true );
         delete_blog_option( $wpdb->blogid, $user_id.'_achievements_points' );

         array_push( $achievements, get_blog_option( $blog_id->blog_id, $user_id.'_achievements_gained' ) );
         delete_blog_option( $wpdb->blogid, $user_id.'_achievements_gained' );
         
         switch_to_blog( $old_blog );
       }
       
       $ach_table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
       
       $ii=0;
       if( is_array($activities) && !empty($activities) ){
         $activities = array_filter($activities);
         foreach( $activities as $activity ){
          if( array_key_exists($ii, $activity) ){
           if( strpos($activity[$ii]->type,'wpachievements_achievement_') === false ){
            $type = $activity[$ii]->type;
            $rank = $activity[$ii]->rank;
            $data = $activity[$ii]->data;
            $points = $activity[$ii]->points;
            $postid = $activity[$ii]->postid;
            $wpdb->insert( 
              $ach_table, 
              array( 
                'uid' => $user_id, 
                'type' => $type, 
                'rank' => $rank, 
                'data' => $data, 
                'points' => $points,
                'postid' => $postid 
              ), 
              array( 
                '%s', 
                '%s', 
                '%s', 
                '%s', 
                '%d', 
                '%d' 
              ) 
            );
            $add_points = $add_points + $activity[$ii]->points;
            $ii++;
           }
          }
         }
       }

       if( is_array($achievements) && !empty($achievements) ){
         $achievements = array_filter($achievements);
         $achievements = array_map('wpachievements_sort_array', $achievements);
         $achievements = array_values($achievements);
         $achievements_data = get_blog_option(1,'wpachievements_achievements_data');
         if( (!empty($achievements[0]) && $achievements[0] != '') && (!empty($achievements_data) && $achievements_data != '')){
           if( is_array($achievements[0]) ){
             $gainedachievements = array();
             $newachievements = array();
             $gainedachievements = call_user_func_array('array_merge',$achievements);
             $newachievements = array_unique($gainedachievements);
           } else{
             $newachievements = array();
             $newachievements = array_unique($achievements);
           }
           foreach( $newachievements as $new_activity ){
            
            $cur_ach = $achievements_data[$new_activity];
            $type = str_replace (" ", "", $cur_ach[0]);
            $type = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $type);
            $type = strtolower($type);
            $type = 'wpachievements_achievement_'.$type;
            $rank = '';
            $data = $cur_ach[0].': '.stripslashes($cur_ach[1]);
            $points = $cur_ach['2'];
            
            $wpdb->insert( 
             $ach_table, 
              array( 
                'uid' => $user_id, 
                'type' => $type, 
                'rank' => $rank, 
                'data' => $data, 
                'points' => $points
              ), 
              array( 
                '%s', 
                '%s', 
                '%s', 
                '%s', 
                '%d', 
                '%d' 
              ) 
            );
            $add_points = $add_points + $points;
           }
           update_user_meta( $user_id, 'achievements_gained', $newachievements );
         }
       }
       
       if( $add_points != 0 ){
         $current_points = (int)get_user_meta( $user_id, 'achievements_points', true );
         if( empty($current_points) || $current_points < $points ){
           update_user_meta( $user_id, 'achievements_points', $add_points );
         }
       }
       
       update_user_meta( $user_id, 'achievements_data_converted', 'done' );
       
     }
    }
   }
 }
 
 add_action('wp_footer', 'wpachievements_achievements_conversion');
 add_action('admin_head', 'wpachievements_achievements_conversion');
 function wpachievements_achievements_conversion(){
 if(function_exists('is_multisite') && is_multisite()){
   $convert = get_blog_option(1,'wpachievements_achievements_converted');
  } else{
   $convert = get_option('wpachievements_achievements_converted');
  }
  if( $convert != 'done' ){
    global $wpdb;
    if(function_exists('is_multisite') && is_multisite()){
      $achievements = get_blog_option(1,'wpachievements_achievements_data');
    } else{
      $achievements = get_option('wpachievements_achievements_data');
    }
    if(!empty($achievements) || $achievements != ''){
      foreach($achievements as $achievement){
         
        $new_achievement = array(
          'post_title'    => $achievement[0],
          'post_content'  => stripslashes($achievement[1]),
          'post_type'     => 'wpachievements',
          'post_status'   => 'publish',
          'post_author'   => 1
        );
        if(function_exists('is_multisite') && is_multisite()){
          switch_to_blog(1);
        }
        $achievement_id = wp_insert_post( $new_achievement );  
        
        update_post_meta($achievement_id, '_achievement_type', $achievement[4]);
        update_post_meta($achievement_id, '_achievement_occurrences', $achievement[5]);
        if( isset($achievement[7]) ){
          update_post_meta($achievement_id, '_achievement_associated_id', $achievement[7]);
        }
        update_post_meta($achievement_id, '_achievement_points', $achievement[2]);
        update_post_meta($achievement_id, '_achievement_image', $achievement[6]);
        
        if(function_exists('is_multisite') && is_multisite()){
          restore_current_blog();
        }
      }
      if(function_exists('is_multisite') && is_multisite()){
        $achievements = update_option(1,'wpachievements_achievements_converted', 'done');
      } else{
        $achievements = update_option('wpachievements_achievements_converted', 'done');
      }
     }
   }
   
   $args = array(
     'post_type' => 'wpachievements',
     'post_status' => 'publish',
     'posts_per_page' => -1,
     'meta_query' => array(
       array(
         'key' => '_achievement_type',
         'value' => 'post',
       )
     )
   );
   $achievement_query = new WP_Query( $args );
   if( $achievement_query->have_posts() ){
     while( $achievement_query->have_posts() ){
       $achievement_query->the_post();
       $ach_ID = get_the_ID();
       update_post_meta( $ach_ID, '_achievement_type', 'post_added' );
     }
   }
   wp_reset_postdata();
 }
 
 add_action('wpachievements_user_admin_load', 'wpachievements_new_data_conversion', 2);
 add_action('wpachievements_user_profile_load', 'wpachievements_new_data_conversion', 2);
 add_action('wp_footer', 'wpachievements_new_data_conversion', 2);
 function wpachievements_new_data_conversion($user_id){
   if( is_user_logged_in() ){
    if( empty($user_id) ){
      global $current_user;
      get_currentuserinfo();
      $user_id = $current_user->ID;
    }
    if(function_exists('is_multisite') && is_multisite()){
     $convert = get_blog_option(1,'wpachievements_achievements_converted');
    } else{
     $convert = get_option('wpachievements_achievements_converted');
    }
    if( get_user_meta( $user_id, 'achievements_new_data_converted', true ) != 'done' && $convert == 'done' ){
      global $wpdb;
      $userachievements = get_user_meta( $user_id, 'achievements_gained', true );
      if( $userachievements ){
        if(function_exists('is_multisite') && is_multisite()){
          $achievements_data = get_blog_option(1,'wpachievements_achievements_data');
        } else{
          $achievements_data = get_option('wpachievements_achievements_data');
        }
        if( $achievements_data ){
          foreach( $userachievements as $userachievement ){
            if( array_key_exists($userachievement, $achievements_data) ){
              $ach_ID = wpachievements_achievement_id_by_title( $achievements_data[$userachievement][0] );
              $newachievements[] = $ach_ID;
            }
          }
          update_user_meta( $user_id, 'achievements_gained', $newachievements );
        }
      }
      update_user_meta( $user_id, 'achievements_new_data_converted', 'done' );
    }
   }
 }
 
 add_action('bp_before_member_header_meta', 'wpachievements_bb_new_data_conversion');
 function wpachievements_bb_new_data_conversion(){
   global $bp;
   get_currentuserinfo();
   if(function_exists('is_multisite') && is_multisite()){
     $convert = get_blog_option(1,'wpachievements_achievements_converted');
   } else{
     $convert = get_option('wpachievements_achievements_converted');
   }
   if( get_user_meta( $bp->displayed_user->id, 'achievements_new_data_converted', true ) != 'done' && $convert == 'done' ){
     global $wpdb;
     $userachievements = get_user_meta( $bp->displayed_user->id, 'achievements_gained', true );
     if( $userachievements ){
       if(function_exists('is_multisite') && is_multisite()){
         $achievements_data = get_blog_option(1,'wpachievements_achievements_data');
       } else{
         $achievements_data = get_option('wpachievements_achievements_data');
       }
       if( $achievements_data ){
         foreach( $userachievements as $userachievement ){
           if( array_key_exists($userachievement, $achievements_data) ){
             $ach_ID = wpachievements_achievement_id_by_title( $achievements_data[$userachievement][0] );
             $newachievements[] = $ach_ID;
           }
         }
         update_user_meta( $bp->displayed_user->id, 'achievements_gained', $newachievements );
       }

     }
     update_user_meta( $bp->displayed_user->id, 'achievements_new_data_converted', 'done' );
   }
 }
 
 add_action('wpachievements_user_admin_load', 'wpachievements_update_needed_data', 2);
 add_action('wpachievements_user_profile_load', 'wpachievements_update_needed_data', 2);
 add_action('wp_footer', 'wpachievements_update_needed_data', 2);
 function wpachievements_update_needed_data(){
   if(function_exists('is_multisite') && is_multisite()){
    $convert = get_blog_option(1,'wpachievements_post_meta_updated');
   } else{
    $convert = get_option('wpachievements_post_meta_updated');
   }
   if( $convert != 'done' ){
     global $wpdb;
     
     if(function_exists('is_multisite') && is_multisite()){
       $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
     } else{
       $table = $wpdb->prefix.'achievements';
     }
     
     $args = array(
       'post_type' => 'wpachievements',
       'post_status' => 'publish',
       'posts_per_page' => -1,
     );
     $achievement_query = new WP_Query( $args );
     if( $achievement_query->have_posts() ){
       while( $achievement_query->have_posts() ){
         $achievement_query->the_post();
         $ach_ID = get_the_ID();
         update_post_meta( $ach_ID, '_achievement_recurring', 0 );
         update_post_meta( $ach_ID, '_achievement_postid', $ach_ID );
       }
     }
     wp_reset_postdata();
     
     $wpdb->query( "ALTER TABLE $table ADD timestamp varchar(200) NULL" );
     
     if(function_exists('is_multisite') && is_multisite()){
       update_option(1,'wpachievements_post_meta_updated', 'done');
     } else{
       update_option('wpachievements_post_meta_updated', 'done');
     }
   }
 }
 
 function wpa_get_footer_triggers(){
   return array('user_register','user_login','user_post_view','comment_added','comment_added_bad','post_added','post_added_bad','wc_order_complete','wc_user_spends','Forum_Post','Forum_Topic','Forum_Poll_create','js_order_complete','sentinvite','gform_sub','buddystream_facebook_activated','buddystream_flickr_activated','buddystream_lastfm_activated','buddystream_twitter_activated','buddystream_youtube_activated','cp_bp_avatar_uploaded','cp_bp_message_sent','cp_bp_group_create','cp_bp_group_joined','cp_bp_group_avatar_uploaded','cp_bp_new_group_forum_topic','cp_bp_new_group_forum_post','cp_bp_new_group_forum_post_edit','cp_bp_link_added','cp_bp_link_delete','cp_bp_galery_upload','cp_bp_galery_delete','bbp_new_forum','bbp_edit_forum','bbp_new_topic','bbp_closed_topic','bbp_merged_topic','bbp_post_split_topic','bbp_new_reply','bbp_deleted_reply');
 }
 
?>