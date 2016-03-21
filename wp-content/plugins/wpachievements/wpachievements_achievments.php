<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
 
/**
 *******************************************
 *   C H E C K   A C H I E V E M E N T S   *
 *******************************************
 */
 function wpachievements_new_activity($type='', $uid='', $postid='', $points=''){
  if(is_user_logged_in() || !empty($uid)){
    
    if(function_exists('is_multisite') && is_multisite()){
      global $blog_id;
      $curBlog = $blog_id;
      switch_to_blog(1);
    }
    
    global $wpdb, $current_user;
    get_currentuserinfo();
    if(empty($uid)){$uid=$current_user->ID;}
    if(empty($postid)){$postid='';}
       
    if(function_exists('is_multisite') && is_multisite()){
      $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
    } else{
      $table = $wpdb->prefix.'achievements';
    }
    $userachievement = get_user_meta( $uid, 'achievements_gained', true );
    $notachievement = true;
    $ii=0;
    
    $time = time();
    
    if( !in_array("timestamp", $wpdb->get_col( "DESC " . $table, 0 )) ) {
     $wpdb->query( "ALTER TABLE $table ADD timestamp varchar(200) NULL" );
    }
    
    $wpdb->insert( 
      $table, 
      array( 'uid' => $uid, 'type' => $type, 'rank' => '', 'data' => '', 'points' => $points, 'postid' => $postid, 'timestamp' => $time ), 
      array( '%d', '%s', '%s', '%s', '%d', '%d', '%s' ) 
    );
    
    do_action( 'wpachievements_before_new_activity', $type, $uid, $postid, $points, '', $userachievement );
    
    $activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=%d", $type,$uid) );
    
    if( !empty($userachievement) ){
      $args = array(
        'post_type' => 'wpachievements',
        'post_status' => 'publish',
        'post__in' => $userachievement,
        'posts_per_page' => -1,
        'meta_query' => array(
          'relation' => 'AND',
          array(
            'key' => '_achievement_type',
            'value' => $type,
          ),
          array(
            'key' => '_achievement_recurring',
            'value' => '1',
            'type' => 'numeric',
            'compare' => '='
          )
        )
      );
      
      $achievement_query = new WP_Query( $args );
      if( $achievement_query->have_posts() ){
        while( $achievement_query->have_posts() ){
          $achievement_query->the_post();
          $ach_ID = get_the_ID();
          
          $check_occurences = get_post_meta( $ach_ID, '_achievement_occurrences', true );
          $check_type = get_post_meta( $ach_ID, '_achievement_type', true );
          $last_gained = get_user_meta( $uid, 'achievements_'.$ach_ID.'_gained', true );
          
          $gained_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=%d AND timestamp > '%s'", $check_type,$uid,$last_gained) );
          
          if( $gained_count < $check_occurences )
            continue;
        
          if(function_exists('is_multisite') && is_multisite()){
            $blog_limit = get_post_meta( $ach_ID, '_achievement_blog_limit', true );
            if( !empty($blog_limit) ){
              if( $curBlog != $blog_limit )
                continue;
            }
          }
          
          $ach_activity_count = get_post_meta( $ach_ID, '_achievement_occurrences', true );
          $ach_postid = get_post_meta( $ach_ID, '_achievement_associated_id', true );
          
          if( !empty($ach_postid) && $ach_postid != '' ){
            if( $postid == $ach_postid ){
              $this_activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=$uid AND postid=%d", $type,$ach_postid) );
              if( $this_activities_count < $ach_activity_count )
                continue;
            } else{
              continue;
            }
          }
        
          if( $type == 'ld_quiz_perfect' ){
            $ach_first_try_only = get_post_meta( $ach_ID, '_achievement_ld_first_attempt_only', true );
            if( $postid && ($ach_first_try_only == 'enabled' || $ach_first_try_only == 'Enabled') ){
              $attempt_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE (type='ld_quiz_pass' OR type='ld_quiz_fail' OR type='ld_quiz_perfect') AND uid=%d AND postid='%d'", $uid,$postid) );
            
              if( !empty($attempt_count) && $attempt_count > 1 )
                continue;
            }
          }
        
          $ach_title = get_the_title();
          $ach_desc = get_the_content();
          $ach_data = $ach_title.': '.$ach_desc;
          $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
          $ach_points = get_post_meta( $ach_ID, '_achievement_points', true );
          $ach_occurences = get_post_meta( $ach_ID, '_achievement_occurrences', true );
          $ach_type = 'wpachievements_achievement_'.get_post_meta( $ach_ID, '_achievement_type', true );
        
          wpa_trigger_achievement($ach_ID,$uid,$ach_type,'',$postid,$ach_title,$ach_desc,$ach_data,$ach_img,$ach_points,'','',$ach_occurences);
        
        }
      }
      wp_reset_postdata();
    }
    
    $userachievement = get_user_meta( $uid, 'achievements_gained', true );
    $notachievement = true;
    
    if( !empty($userachievement) ){
      $args = array(
        'post_type' => 'wpachievements',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
          'relation' => 'AND',
          array(
            'key' => '_achievement_type',
            'value' => $type,
          ),
          array(
            'key' => '_achievement_occurrences',
            'value' => $activities_count,
            'type' => 'numeric',
            'compare' => '<='
          ),
          array(
            'key' => '_achievement_postid',
            'value' => $userachievement,
            'compare' => 'NOT IN'
          )
        )
      );
    } else{
      $args = array(
        'post_type' => 'wpachievements',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
          array(
            'key' => '_achievement_type',
            'value' => $type,
          ),
          array(
            'key' => '_achievement_occurrences',
            'value' => $activities_count,
            'type' => 'numeric',
            'compare' => '<='
          )
        )
      );
    }
    
    $achievement_query = new WP_Query( $args );
    if( $achievement_query->have_posts() ){
      while( $achievement_query->have_posts() ){
        $achievement_query->the_post();
        $ach_ID = get_the_ID();
        
        $check_occurences = get_post_meta( $ach_ID, '_achievement_occurrences', true );
        $check_type = get_post_meta( $ach_ID, '_achievement_type', true );
        $last_gained = get_user_meta( $uid, 'achievements_'.$ach_ID.'_gained', true );
        
        $post_date = get_the_date();
        
        $post_date = strtotime($post_date);
          
        $gained_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=%d AND timestamp > '%s'", $check_type,$uid,$post_date) );
          
        if( $gained_count < $check_occurences )
          continue;
        
        if(function_exists('is_multisite') && is_multisite()){
          $blog_limit = get_post_meta( $ach_ID, '_achievement_blog_limit', true );
          if( !empty($blog_limit) ){
            if( $curBlog != $blog_limit )
              continue;
          }
        }
        
        $ach_activity_count = get_post_meta( $ach_ID, '_achievement_occurrences', true );
        
        $ach_postid = get_post_meta( $ach_ID, '_achievement_associated_id', true );
        
        if( !empty($ach_postid) && $ach_postid != '' ){
          if( $postid == $ach_postid ){
            $this_activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=$uid AND postid=%d", $type,$ach_postid) );
            if( $this_activities_count < $ach_activity_count )
              continue;
          } else{
            continue;
          }
        }
        
        if( $type == 'ld_quiz_perfect' ){
          $ach_first_try_only = get_post_meta( $ach_ID, '_achievement_ld_first_attempt_only', true );
          if( $postid && ($ach_first_try_only == 'enabled' || $ach_first_try_only == 'Enabled') ){
            $attempt_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE (type='ld_quiz_pass' OR type='ld_quiz_fail' OR type='ld_quiz_perfect') AND uid=%d AND postid='%d'", $uid,$postid) );
            
            if( !empty($attempt_count) && $attempt_count > 1 )
              continue;
          }
        }
        
        $ach_title = get_the_title();
        $ach_desc = get_the_content();
        $ach_data = $ach_title.': '.$ach_desc;
        $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
        $ach_points = get_post_meta( $ach_ID, '_achievement_points', true );
        $ach_occurences = get_post_meta( $ach_ID, '_achievement_occurrences', true );
        $type = 'wpachievements_achievement_'.get_post_meta( $ach_ID, '_achievement_type', true );
        
        wpa_trigger_achievement($ach_ID,$uid,$type,'',$postid,$ach_title,$ach_desc,$ach_data,$ach_img,$ach_points,'','',$ach_occurences);
        
      }
    }
    wp_reset_postdata();
    
    if( $points > 0 ){
      if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
        cp_points('wpachievements_achievement_new_activity', $uid, $points, $type);
      }
      if(function_exists(WPACHIEVEMENTS_MYCRED)){
        $mycred = mycred();
        $mycred->add_creds( 'new_activity', $uid, $points, '%plural% '.achievement_Desc($type,$points,1,'',''), $postid );
      }
      wpachievements_increase_points( $uid, $points );
    } elseif( $points < 0 ){
      if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
        cp_points('wpachievements_achievement_new_activity', $uid, $points, $type);
      }
      if(function_exists(WPACHIEVEMENTS_MYCRED)){
        mycred_subtract( 'wpachievements_changed', $uid, $points, '%plural% for: '.achievement_Desc($type,$points,1,'','') );
      }
      wpachievements_decrease_points( $uid, abs($points) );
    }
            
    do_action( 'wpachievements_after_new_activity', $type, $uid, $postid, $points, '', $notachievement );
    
    if(function_exists('is_multisite') && is_multisite()){
      restore_current_blog();
    }
    
  }
 }
 
/**
 *******************************************************
 *   W P A C H I E V E M E N T S   M E N U   T A B S   *
 *******************************************************
 */
 //*************** Actions ***************\\
 add_action('admin_bar_menu', 'wpachievements_points_menu', 1000);
 //*************** Create Points Menu ***************\\
 function wpachievements_points_menu() {
  if(is_user_logged_in()){
    if ( !is_admin_bar_showing() )
      return;
    global $wp_admin_bar, $current_user, $wpdb, $cp_module;
    get_currentuserinfo();
    
    if(function_exists('is_multisite') && is_multisite()){
      $rtl = get_blog_option(1,'wpachievements_rtl_lang');
    } else{
      $rtl = get_option('wpachievements_rtl_lang');
    }
    
    if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
      if(cp_module_activated('mypoints')){
        $link = admin_url('admin.php?page=cp_modules_mypoints_admin');
      } else{
        $link = '';
      }
    } else{
      $link = '';
    }
    if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
      if(function_exists('is_multisite') && is_multisite()){
        switch_to_blog(1);
      }
      $points = get_user_meta( $current_user->ID, 'cpoints', true );
      if(function_exists('is_multisite') && is_multisite()){
        restore_current_blog();
      }
      if(empty($points)){$points = 0;}
      if(function_exists('is_multisite') && is_multisite()){
        $prefix = get_blog_option($wpdb->blogid, 'cp_prefix' );
        $suffix = get_blog_option($wpdb->blogid, 'cp_suffix' );
      } else{
        $prefix = get_option( 'cp_prefix' );
        $suffix = get_option( 'cp_suffix' );
      }
    } elseif( !function_exists(WPACHIEVEMENTS_MYCRED) ){
      if(function_exists('is_multisite') && is_multisite()){
        switch_to_blog(1);
      }
      $points = get_user_meta( $current_user->ID, 'achievements_points', true );
      if(function_exists('is_multisite') && is_multisite()){
        restore_current_blog();
      }
      if(empty($points)){$points = 0;}
      $prefix = '';
      if($points == 1 || $points == -1){
        $suffix = ' Point';
      } else{
        $suffix = ' Points';
      }
    }
    
    if( function_exists(WPACHIEVEMENTS_MYCRED) ){
      
      $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu', 'parent' => 'top-secondary', 'title' => mycred_get_users_fcred( $current_user->ID ), 'textdomain', 'href' => $link ) );
      $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu_inner_1', 'parent' => 'wpachievements_points_menu', 'title' => '<strong>'.__('Recent Activity', WPACHIEVEMENTS_TEXT_DOMAIN).'</strong>', 'href' => FALSE, 'meta' => array( 'class' => 'recent_point_activity_head' ) ) );
      
      // The Query
      $logQuery = new myCRED_Query_Log( array( 'user_id=' => $current_user->ID, 'number' => 5 )  );
      $activities = $wpdb->get_results( $logQuery->request );
      
      $ii=0;
      if($rtl != 'true'){
        foreach ( $activities as $activity ){
          $ii++;
          $text = myCRED_Desc($activity->ref,$activity->creds,$activity->entry,$activity);
          $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu_inner_'.$ii.'', 'parent' => 'wpachievements_points_menu', 'title' => '<strong>'.$activity->creds.'</strong><i> '.$text.'</i><span>'.$ii.'</span>', 'href' => FALSE, 'meta' => array( 'class' => 'recent_point_activity' ) ) );
        }
      } else{
        foreach ( $activities as $activity ){
          $ii++;
          $text = myCRED_Desc($activity->ref,$activity->creds,$activity->entry,$activity);
          $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu_inner_'.$ii.'', 'parent' => 'wpachievements_points_menu', 'title' => '<span>'.$ii.'</span>'.'<i>'.$text.' </i>'.'<strong>'.$activity->creds.'</strong>', 'href' => FALSE, 'meta' => array( 'class' => 'recent_point_activity' ) ) );
        }
      }
    } else{
      $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu', 'parent' => 'top-secondary', 'title' => $prefix . number_format($points) . $suffix, 'textdomain', 'href' => $link ) );
      $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu_inner_1', 'parent' => 'wpachievements_points_menu', 'title' => '<strong>'.__('Recent Activity', WPACHIEVEMENTS_TEXT_DOMAIN).'</strong>', 'href' => FALSE, 'meta' => array( 'class' => 'recent_point_activity_head' ) ) );
    
      if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
        $table = $wpdb->prefix.'cp';
      } elseif( function_exists(WPACHIEVEMENTS_MYCRED) ){
      
      } else{
        if(function_exists('is_multisite') && is_multisite()){
          $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
        } else{
          $table = $wpdb->prefix.'achievements';
        }
      }

      $activities = $wpdb->get_results( "SELECT * FROM $table WHERE uid = $current_user->ID AND points != '' AND points != 0 ORDER BY id DESC LIMIT 5" );

      $ii=0;
      foreach ( $activities as $activity ){
        $ii++;
        $text = achievement_Desc($activity->type,$activity->points,'a ','',$activity->data);
        if($rtl != 'true'){
          if($activity->points == 1 || $activity->points == -1){
            $suffix = ' '.__( 'Point', WPACHIEVEMENTS_TEXT_DOMAIN );
          } else{
            $suffix = ' '.__( 'Points', WPACHIEVEMENTS_TEXT_DOMAIN );
          }
          $points = $prefix.$activity->points.$suffix;
          $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu_inner_'.$ii.'', 'parent' => 'wpachievements_points_menu', 'title' => '<strong>'.$points.'</strong><i> '.$text.'</i><span>'.$ii.'</span>', 'href' => FALSE, 'meta' => array( 'class' => 'recent_point_activity' ) ) );
        } else{
          if($activity->points == 1 || $activity->points == -1){
            $suffix = __( 'Point', WPACHIEVEMENTS_TEXT_DOMAIN ).' ';
          } else{
            $suffix = __( 'Points', WPACHIEVEMENTS_TEXT_DOMAIN ).' ';
          }
          $points = $suffix.$activity->points.$prefix;
          $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu_inner_'.$ii.'', 'parent' => 'wpachievements_points_menu', 'title' => '<span>'.$ii.'</span><i>'.$text.' </i><strong>'.$points.'</strong>', 'href' => FALSE, 'meta' => array( 'class' => 'recent_point_activity' ) ) );
        }
      }
      $ii++;
      if( function_exists(WPACHIEVEMENTS_CUBEPOINTS) && cp_module_activated('mypoints') ){
        $wp_admin_bar->add_menu( array( 'id' => 'wpachievements_points_menu_inner_'.$ii.'', 'parent' => 'wpachievements_points_menu', 'title' => 'See all activity', 'href' => $link, 'meta' => array( 'class' => 'recent_point_activity_link' ) ) );
      }
    
    }
    
  }
 }
/**
 *******************************************************
 *   W P A C H I E V E M E N T S   M E N U   T A B S   *
 *******************************************************
 */
 function get_achievement_name($ach=''){
   if(function_exists('is_multisite') && is_multisite()){
     switch_to_blog(1);
   }
   $ach_title = '';
   if( !empty($ach) ){
     $args = array(
       'post_type' => 'wpachievements',
       'post_status' => 'publish',
       'posts_per_page' => -1,
       'p' => $ach,
     );
     $achievement_query = new WP_Query( $args );
     if( $achievement_query->have_posts() ){
       while( $achievement_query->have_posts() ){
         $achievement_query->the_post();
         $ach_title = get_the_title();
       }
     }
     wp_reset_postdata();
   }
   if(function_exists('is_multisite') && is_multisite()){
     restore_current_blog();
   }
   return $ach_title;
 }
/**
 ***********************************************************
 *   W P A C H I E V E M E N T S   D E S C R I P T I O N   *
 ***********************************************************
 */
 function achievement_Desc($type='',$points='',$times='',$title='',$data=''){
  $pt = WPACHIEVEMENTS_POST_TEXT;
  if($times>1){$pt = WPACHIEVEMENTS_POST_TEXT."'s";}
  $text = __('for being awesome!', WPACHIEVEMENTS_TEXT_DOMAIN);
  switch($type){
   case 'dailypoints': { $text = sprintf( __('for visiting us %s time(s)', WPACHIEVEMENTS_TEXT_DOMAIN), $times ); } break;
   case 'admin': { $text = __('(Points adjusted by Admin)', WPACHIEVEMENTS_TEXT_DOMAIN); } break;
   case 'register': { $text = __('for registering with us', WPACHIEVEMENTS_TEXT_DOMAIN); } break;
   case 'comment': { if($points < 0){$text = sprintf( __('for removing %s comment(s)', WPACHIEVEMENTS_TEXT_DOMAIN), $times);} else{$text = sprintf( __('for adding %s comment(s)', WPACHIEVEMENTS_TEXT_DOMAIN), $times);} } break;
   case 'post': { if($points < 0){$text = sprintf( __('for removing %s %s', WPACHIEVEMENTS_TEXT_DOMAIN), $times, $pt);}else{$text = sprintf( __('for adding %s %s', WPACHIEVEMENTS_TEXT_DOMAIN), $times, $pt);} } break;
   case strpos($type,'wpachievements_achievement') !== false: { $achieve = explode(":",$data); $text = sprintf( __('for Achievement: %s', WPACHIEVEMENTS_TEXT_DOMAIN), $achieve['0']); } break;
   case 'wpachievements_removed': { $text = __('(Admin Removed Achievement)', WPACHIEVEMENTS_TEXT_DOMAIN); } break;
   case 'wpachievements_added': { $text = __('(Admin Added Achievement)', WPACHIEVEMENTS_TEXT_DOMAIN); } break;
   case 'custom_achievement': { $achieve = explode(":",$data); $text = sprintf( __('for Achievement: %s', WPACHIEVEMENTS_TEXT_DOMAIN), $achieve['0']); } break;
   case 'wpachievements_changed': { $text = __('(Admin Modified Achievement)', WPACHIEVEMENTS_TEXT_DOMAIN); } break;
   case 'fb_loggin': { $text = __('for logging in with Facebook', WPACHIEVEMENTS_TEXT_DOMAIN); } break;
  }
  return apply_filters('wpachievements_activity_description', $text,$type,$points,$times,$title,$data );
 }
 
/**
 ***************************************************************************
 *   W P A C H I E V E M E N T S   C U S T O M   A C H I E V E M E N T S   *
 ***************************************************************************
 */
 add_filter('wpachievements_admin_events', 'achievement_custom_admin_events', 10);
 function achievement_custom_admin_events(){
   $cur_url = curPageURL();
   echo $cur_url;
   echo '<optgroup label="'.__('Custom Achievement Events', WPACHIEVEMENTS_TEXT_DOMAIN).'">
     <option value="custom_achievement">'. __('Manually Awarded', WPACHIEVEMENTS_TEXT_DOMAIN) .'</option>';
   echo '</optgroup>';
 }
 
/**
 *************************************************************************
 *   W P A C H I E V E M E N T S   A C H I E V E M E N T   N O T I C E   *
 *************************************************************************
 */
 add_filter( 'heartbeat_received', 'wpa_respond_to_browser', 10, 3 );
 function wpa_respond_to_browser( $response, $data, $screen_id ) {
   if ( isset( $data['wpachievements-check'] ) ) {
     
     global $current_user;
     get_currentuserinfo();
     
     $umeta = get_user_meta( $data['wpachievements-check'], 'wpachievements_got_new_ach', true );
     if(!empty($umeta)){
       
       $html='';
       if( function_exists('wpachievements_fb_share_achievement_filter') )
         $html = wpachievements_fb_share_achievement_filter('achievement');
  
       delete_user_meta( $data['wpachievements-check'], 'wpachievements_got_new_ach' );
       if(function_exists('is_multisite') && is_multisite()){
         global $wpdb;
         $pop_col = strtolower (get_blog_option(1,'wpachievements_pcol'));
         $pop_time = strtolower (get_blog_option(1,'wpachievements_ptim'));
       } else{
         $pop_col = strtolower (get_option('wpachievements_pcol'));
         $pop_time = strtolower (get_option('wpachievements_ptim'));
       }
       if( empty($pop_col) ){
         $pop_col = '#333333';
       }
       if( strpos($pop_col,'#') === false ){
         $pop_col = '#'.$pop_col;
       }
       
       foreach($umeta as $achi){
         
           $html .= '<script type="text/javascript">
           jQuery.smallBox({
             title: "'. $achi['title'] .'",
             content: "'. str_replace( '"', '\'', $achi['text'] ) .'",
             color: "'. $pop_col .'",';
             
             if( $pop_time > 0 ){
               if( $pop_time < 1000 ){
                 $html .= 'timeout: "'.$pop_time.'000",';
               } else{
                 $html .= 'timeout: "'.$pop_time.'",';
               }
             }
             $html .='
             img: "'. $achi['image'] .'",
             icon: "'. plugins_url('/popup/img/medal.png', __FILE__) .'",
             extra_type: "achievement"
           });
           jQuery("#wp-admin-bar-wpachievements_points_menu").load("'. home_url('').' #wp-admin-bar-wpachievements_points_menu > *");
           </script>';
         
       }
       
       if( function_exists('wpachievements_twr_share_achievement_return') )
         $html .= wpachievements_twr_share_achievement_return();
       
       $response['wpachievements-check'] = $html;
       
     }
   }
   return $response;
 }
 add_action( 'wp_footer', 'wpa_check_for_achievements', 1 );
 function wpa_check_for_achievements() {
  if( is_user_logged_in() ){
   global $current_user;
   get_currentuserinfo();
   $umeta = get_user_meta( $current_user->ID, 'wpachievements_got_new_ach_footer' );
   if(!empty($umeta)){
  
     do_action( 'wpachievements_before_show_achievement', $current_user->ID, $umeta );
  
     delete_user_meta( $current_user->ID, 'wpachievements_got_new_ach_footer' );
     if(function_exists('is_multisite') && is_multisite()){
       global $wpdb;
       $pop_col = strtolower (get_blog_option(1,'wpachievements_pcol'));
       $pop_time = strtolower (get_blog_option(1,'wpachievements_ptim'));
     } else{
       $pop_col = strtolower (get_option('wpachievements_pcol'));
       $pop_time = strtolower (get_option('wpachievements_ptim'));
     }
     if( empty($pop_col) ){
       $pop_col = '#333333';
     }
     if( strpos($pop_col,'#') === false ){
       $pop_col = '#'.$pop_col;
     }
     foreach($umeta as $achi){
       foreach($achi as $thisachi){
         
         do_action( 'wpachievements_before_achievement_popup', $thisachi );
         
         ?>
         <script type="text/javascript">
         jQuery.smallBox({
           title: "<?php echo $thisachi['title']; ?>",
           content: "<?php echo str_replace( '"', '\'', $thisachi['text'] ); ?>",
           color: "<?php echo $pop_col; ?>",
           <?php
           if( $pop_time > 0 ){
             if( $pop_time < 1000 ){
               echo 'timeout: "'.$pop_time.'000",';
             } else{
               echo 'timeout: "'.$pop_time.'",';
             }
           }
           ?>
           img: "<?php echo $thisachi['image']; ?>",
           icon: "<?php echo plugins_url('/popup/img/medal.png', __FILE__); ?>",
           extra_type: "achievement"
         });
         jQuery("#wp-admin-bar-wpachievements_points_menu").load('<?php echo home_url(''); ?> #wp-admin-bar-wpachievements_points_menu > *');
         </script>
         <?php 
       }
     }
  
     do_action( 'wpachievements_after_show_achievement', $current_user->ID, $umeta );
       
   }
  }
 }
 
/**
 ***************************************************************************
 *   W P A C H I E V E M E N T S   T R I G G E R   A C H I E V E M E N T   *
 ***************************************************************************
 */
 function wpa_trigger_achievement($ach_ID,$uid,$type,$usersrank,$postid,$ach_title,$ach_desc,$ach_data,$ach_img,$ach_points,$ach_woopoints,$ach_rank,$ach_occurences){ 
    
    global $wpdb;
    
    $achievement = array( $ach_title, $ach_desc, $ach_points, '', $type, $ach_occurences, $ach_img, '' );
        
    if(function_exists('is_multisite') && is_multisite()){
      $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
    } else{
      $table = $wpdb->prefix.'achievements';
    }
        
    $wpdb->insert( 
      $table, 
      array( 'uid' => $uid, 'type' => $type, 'rank' => '', 'data' => $ach_data, 'points' => $ach_points, 'postid' => $ach_ID, 'timestamp' => time() ), 
      array( '%d', '%s', '%s', '%s', '%d', '%d', '%s' ) 
    );
    
    do_action( 'wpachievements_before_new_achievement', $type, $uid, $ach_ID, 0, '', '' );
    
    if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
      cp_points('wpachievements_achievement_'.str_replace(" ", "", strtolower($ach_title)), $uid, $ach_points, $ach_data);
    }
    if(function_exists(WPACHIEVEMENTS_MYCRED)){
      $mycred = mycred();
      $mycred->add_creds( 'new_achievement', $uid, $ach_points, '%plural% for Achievement: '.$ach_title, $postid );
    }
        
    wpachievements_increase_points( $uid, $ach_points, 'wpachievements_achievement' );
        
    $newmeta = array();
    $newuserachievement = get_user_meta( $uid, 'achievements_gained', true );
    $newmeta = $newuserachievement;
    if( is_array($newmeta) ){
      if( array_key_exists($ach_ID,$newmeta) )
        unset($newmeta[$ach_ID]);
    }
    $newmeta[] = $ach_ID;
            
    update_user_meta( $uid, 'achievements_'.$ach_ID.'_gained', time() );
    update_user_meta( $uid, 'achievements_gained', $newmeta );
    update_post_meta( $ach_ID, '_user_gained_'.$uid, $uid );
        
    $userachievements = get_user_meta( $uid, 'achievements_gained', true );
    $size = sizeof($userachievements);
    update_user_meta($uid, 'achievements_count', $size);
    
    $footerTriggers = wpa_get_footer_triggers();
    
    if( in_array($type,$footerTriggers) ){
      $ach_meta = get_user_meta( $uid, 'wpachievements_got_new_ach_footer', true );
      $ach_meta[] = array( "title" => $ach_title, "text" => $ach_desc, "image" => $ach_img);
      update_user_meta( $uid, 'wpachievements_got_new_ach_footer', $ach_meta );
    } else{
      $ach_meta = get_user_meta( $uid, 'wpachievements_got_new_ach', true );
      $ach_meta[] = array( "title" => $ach_title, "text" => $ach_desc, "image" => $ach_img);
      update_user_meta( $uid, 'wpachievements_got_new_ach', $ach_meta );
    }
    $notachievement = false;
        
    do_action( 'wpachievements_after_new_achievement', $uid, $ach_ID, $achievement );
        
 }
?>