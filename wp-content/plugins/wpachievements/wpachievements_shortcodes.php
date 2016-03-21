<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
 
 // Show the "My Achievements" widget
 // [wpa_myachievements user_id="" show_title="" title_class="" image_holder_class="" image_class="" image_width="" achievement_limit=""]
 function wpachievements_myachievements_func( $atts ) {
	
		extract( shortcode_atts( array(
      'user_id' => '',
      'show_title' => 'true',
			'title_class' => '',
			'image_holder_class' => '',
			'image_class' => 'wpa_a_image',
			'image_width' => '30',
			'achievement_limit' => '',
		), $atts ) );
	
		global $current_user, $wpdb;
		get_currentuserinfo();
    if( $user_id ){
      $cur_user = $user_id;
    } else{
      $cur_user = $current_user->ID;
    }

	  $userachievement = get_user_meta( $cur_user, 'achievements_gained', true );
    $myachievements = '';
    if( $show_title == 'true' || $show_title == 'True' ){
		  $myachievements .= '<h3 class="ach_short_title '. $title_class .'">'. __('My Achievements', WPACHIEVEMENTS_TEXT_DOMAIN) .'</h3>';
    }
		$myachievements .= '<div class="'. $image_holder_class .'">';
    $already_counted[] = array();
    if(function_exists('is_multisite') && is_multisite()){
      $sim_ach = get_blog_option(1,'wpachievements_sim_ach');
    } else{
      $sim_ach = get_option('wpachievements_sim_ach');
    }
    $ii=0;
    $iii=0;
    $achievement_badges='';
		if( !empty($userachievement) && $userachievement != '' ){
      if(function_exists('is_multisite') && is_multisite()){
        switch_to_blog(1);
      }
      $args = array(
        'post_type' => 'wpachievements',
        'post_status' => 'publish',
        'post__in' => $userachievement,
        'posts_per_page' => -1
      );  
      $achievement_query = new WP_Query( $args );
      if( $achievement_query->have_posts() ){
        while( $achievement_query->have_posts() ){
          $achievement_query->the_post();
          $ii++;
          $ach_ID = get_the_ID();
          $ach_title = get_the_title();
          $ach_desc = get_the_content();
          $ach_data = $ach_title.': '.$ach_desc;
          $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
          $ach_points = get_post_meta( $ach_ID, '_achievement_points', true );
          $ach_woopoints = get_post_meta( $ach_ID, '_achievement_woo_points', true );
          $ach_occurences = get_post_meta( $ach_ID, '_achievement_occurrences', true );
          $type = 'wpachievements_achievement_'.get_post_meta( $ach_ID, '_achievement_type', true );
          if($sim_ach == 'true'){
            if( !array_key_exists($type,$already_counted) ){
              $iii++;
              if( $iii == 1 ){ $first='first '; } else{ $first=''; }
              if( $type != 'wpachievements_achievement_custom_achievement' ){
                $already_counted[$type] = $ach_occurences;
              }
              $achievement_badges[$ii] = '<img src="'.$ach_img.'" width="'. $image_width .'" class="'. $first . $image_class .'" alt="'.stripslashes($ach_title).__(' Icon',WPACHIEVEMENTS_TEXT_DOMAIN).'" title="'.stripslashes($ach_title).': '.stripslashes(strip_tags($ach_desc)).'" style="width:'.$image_width.'px !important;" />';
            } elseif( $already_counted[$type] <= $ach_occurences ){
              $iii++;
              if( $iii == 1 ){ $first='first '; } else{ $first=''; }
              if( $type != 'wpachievements_achievement_custom_achievement' ){
                $already_counted[$type] = $ach_occurences;
              }
              $achievement_badges[$ii] = '<img src="'.$ach_img.'" width="'. $image_width .'" class="'. $first . $image_class .'" alt="'.stripslashes($ach_title).__(' Icon',WPACHIEVEMENTS_TEXT_DOMAIN).'" title="'.stripslashes($ach_title).': '.stripslashes(strip_tags($ach_desc)).'" style="width:'.$image_width.'px !important;" />';
            }
          } else{
            $iii++;
            if( $iii == 1 ){ $first='first '; } else{ $first=''; }
            $achievement_badges[$ii] = '<img src="'.$ach_img.'" width="'. $image_width .'" class="'. $first . $image_class .'" alt="'.stripslashes($ach_title).__(' Icon',WPACHIEVEMENTS_TEXT_DOMAIN).'" title="'.stripslashes($ach_title).': '.stripslashes(strip_tags($ach_desc)).'" style="width:'.$image_width.'px !important;" />';
          }
					if( $achievement_limit > 0 && $iii >= $achievement_limit ){ break; }
        }
        if( is_array($achievement_badges) ){
          foreach( $achievement_badges as $achievement_badge ){
            $myachievements .= $achievement_badge;
          }
        }
      }
      wp_reset_postdata();
      if(function_exists('is_multisite') && is_multisite()){
        restore_current_blog();
      }
			if( $iii==0 ){
				$myachievements .= '<p>'. __('No Achievements Yet!', WPACHIEVEMENTS_TEXT_DOMAIN) .'</p>';
			}
		} else{
      $myachievements .= '<p>'. __('No Achievements Yet!', WPACHIEVEMENTS_TEXT_DOMAIN) .'</p>';
    }
		$myachievements .= '</div>';

		return $myachievements;
	
 }
 add_shortcode( 'wpa_myachievements', 'wpachievements_myachievements_func' );
 
 // List the Achievements Leaderboard
 // [wpa_leaderboard_list list_class="" limit="" type="" user_position=""]
 function wpachievements_leaderboard_list_func( $atts ) {
   extract( shortcode_atts( array(
     'list_class' => '',
     'limit' => '10',
     'type' => '',
     'user_position' => 'true'
   ), $atts ) );
   global $wpdb;
   if(function_exists('is_multisite') && is_multisite()){
     switch_to_blog(1);
   }
   $table = $wpdb->prefix.'usermeta';
   if(function_exists('is_multisite') && is_multisite()){
     restore_current_blog();
   }
   if(function_exists('is_multisite') && is_multisite()){
     $hide_admin = get_blog_option(1,'wpachievements_hide_admin');
   } else{
     $hide_admin = get_option('wpachievements_hide_admin');
   }
   if( $hide_admin == 'true' ){
     $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
     $users = $user_query->get_results();
     $admins = array();
     foreach( $users as $user ){
       $admins[] = $user->ID;
     }
   } else{
     $admins = array();
     $admins[] = 0;
   }
   if( strtolower($type) == 'points' ){
     if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
       $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='cpoints' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
     } elseif( function_exists(WPACHIEVEMENTS_MYCRED) ){
       $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='mycred_default' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
     } else{
       $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='achievements_points' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
     }
   } else{
     $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='achievements_count' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
   }
   $trophies = array('','gold','silver','bronze');
   $ii=0;
   $html = '<ul class="wpach_leaderboard '.$list_class.'">';
   if ( !empty($user_achievements) && $user_achievements!='') {
     foreach( $user_achievements as $user_info ):
       $ii++;
       if($user_info->meta_value > 0){
         $user_inf = get_userdata($user_info->user_id);
         $html .= '<li>';
         if( $user_position == 'true' || $user_position == 'True' ){
           if($ii<4){$trophy = $trophies[$ii];} else{$trophy = 'default';} 
           $html .= '<div class="myus_icon trophy_'.$trophy.'">';
           if($ii>3){ $html .= '<div class="myus_num">'.$ii.'<span>th</span></div>'; }
           $html .= '</div>';
         }
         $html .= '<h3>'. get_avatar($user_info->user_id, $size = '50') .'<span>'.$user_inf->display_name.'</span></h3>';
         if( strtolower($type) == 'points' ){
           $html .= '<div class="points_count">'.__('Total Points', WPACHIEVEMENTS_TEXT_DOMAIN).': '.$user_info->meta_value.'</div>';
         } else{
           $html .= '<div class="achievement_count">'.__('Achievements', WPACHIEVEMENTS_TEXT_DOMAIN).': '.$user_info->meta_value.'</div>';
         }
         $html .= '</li>';
       }
     endforeach;
   }
   $html .= '</ul>';
   
   return $html;
 }
 add_shortcode( 'wpa_leaderboard_list', 'wpachievements_leaderboard_list_func' );
 
 // Show the Achievements Leaderboard Widget
 // [wpa_leaderboard_widget limit="" type=""]
 function wpachievements_leaderboard_widget_func( $atts ) {
   extract( shortcode_atts( array(
     'limit' => '10',
     'type' => '',
   ), $atts ) );
   global $wpdb;
   if(function_exists('is_multisite') && is_multisite()){
     switch_to_blog(1);
   }
   $table = $wpdb->prefix.'usermeta';
   if(function_exists('is_multisite') && is_multisite()){
     restore_current_blog();
   }
   if(function_exists('is_multisite') && is_multisite()){
     $hide_admin = get_blog_option(1,'wpachievements_hide_admin');
   } else{
     $hide_admin = get_option('wpachievements_hide_admin');
   }
   if( $hide_admin == 'true' ){
     $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
     $users = $user_query->get_results();
     $admins = array();
     foreach( $users as $user ){
       $admins[] = $user->ID;
     }
   } else{
     $admins = array();
     $admins[] = 0;
   }
   if( strtolower($type) == 'points' ){     
     if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
       $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='cpoints' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
     } elseif( function_exists(WPACHIEVEMENTS_MYCRED) ){
       $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='mycred_default' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
     } else{
       $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='achievements_points' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
     }
   } else{
     $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='achievements_count' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
   }
   $trophies = array('','gold','silver','bronze');
   $ii=0;
   $html = '';
   if ( !empty($user_achievements) && $user_achievements!='') {
     $html = '<div class="widget_wpachievements_widget">';
       foreach( $user_achievements as $user_info ):
         if($user_info->meta_value > 0){
           $user_inf = get_userdata($user_info->user_id);
           $ii++;  
           if($ii<4){$trophy = $trophies[$ii];} else{$trophy = 'default';} 
           $html .= '<center>';
           global $bp;
           $html .= '<div class="myus_user wpach_leaderboard">'. get_avatar($user_info->user_id, $size = '50') .'<div class="myus_title">';
           if(defined( WPACHIEVEMENTS_BUDDYPRESS )){
             global $bp;
             if(bp_is_active('activity')){
               $html .= '<a href="'.bp_core_get_user_domain( $user_info->user_id ).'" title="View '.$user_inf->user_login.' Profile">'.$user_inf->user_login.'</a>';
             } else{$html .= $user_inf->display_name;}
           } else{$html .= $user_inf->user_login;}
           if( strtolower($type) == 'points' ){
             $html .= '</div><div class="myus_count">'.__('Total Points', WPACHIEVEMENTS_TEXT_DOMAIN).': '.$user_info->meta_value.'</div>';
           } else{
             $html .= '</div><div class="myus_count">'.__('Achievements', WPACHIEVEMENTS_TEXT_DOMAIN).': '.$user_info->meta_value.'</div>';
           }
           $html .= '<div class="myus_icon trophy_'.$trophy.'">';
           if($ii>3){$html .= '<div class="myus_num">'.$ii.'<span>th</span></div>';}
           $html .= '</div><div class="user_finish"></div></div></center>';
         }
       endforeach;
     $html .= '</div>';
   }
   
   return $html;
 }
 add_shortcode( 'wpa_leaderboard_widget', 'wpachievements_leaderboard_widget_func' ); 
 
 
 // Sortable Style Leaderboard
 // [wpa_leaderboard list_class="" limit="" achievement_limit="" position_numbers="" columns=""]
 function wpachievements_leaderboard_func( $atts ) {
   extract( shortcode_atts( array(
     'list_class' => '',
     'limit' => '10',
     'achievement_limit' => '10',
     'position_numbers' => 'true',
     'columns' => 'avatar,points,achievements'
   ), $atts ) );
   global $wpdb;
   
   wp_enqueue_style( 'wpachievements-data-table-style', plugins_url('/js/data-tables/css/jquery.dataTables.css', __FILE__) );
   wp_register_script( 'wpachievements-data-table-script', plugins_url('/js/data-tables/js/jquery.dataTables.min.js', __FILE__), array('jquery') );
   wp_enqueue_script( 'wpachievements-data-table-script' );
   wp_enqueue_script( 'wpachievements-leaderboard-script', plugins_url('/js/leaderboard-table.js', __FILE__) );
   
   if(function_exists('is_multisite') && is_multisite()){
     switch_to_blog(1);
   }
   $table = $wpdb->prefix.'usermeta';
   if(function_exists('is_multisite') && is_multisite()){
     restore_current_blog();
   }
   if(function_exists('is_multisite') && is_multisite()){
     $hide_admin = get_blog_option(1,'wpachievements_hide_admin');
   } else{
     $hide_admin = get_option('wpachievements_hide_admin');
   }
   if( $hide_admin == 'true' ){
     $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
     $users = $user_query->get_results();
     $admins = array();
     foreach( $users as $user ){
       $admins[] = $user->ID;
     }
   } else{
     $admins = array();
     $admins[] = 0;
   }
   
   if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
     $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='cpoints' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
   } elseif( function_exists(WPACHIEVEMENTS_MYCRED) ){
     $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='mycred_default' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
   } else{
     $user_achievements = $wpdb->get_results( $wpdb->prepare("SELECT user_id,meta_value FROM $table WHERE meta_key='achievements_points' AND user_id NOT IN (".implode(',',$admins).") ORDER BY meta_value * 1 DESC LIMIT %d", $limit) );
   }
      
   $trophies = array('','gold','silver','bronze');
   
   if( !empty($list_class) ){
     $list_class = ' class="'.$list_class.'"';
   }
   $html = '';
   if ( !empty($user_achievements) && $user_achievements!='' && !is_home()) {
     $html .= '<table id="wpa_leaderboard_sortable"'.$list_class.'>
       <thead>
         <tr>';
           $columns = strtolower($columns);
           if( $position_numbers == 'true' ){
             $html .= '<th>'.__('Position',WPACHIEVEMENTS_TEXT_DOMAIN).'</th>';
           }
           if( strpos($columns, 'avatar') !== FALSE ){
            $html .= '<th>'.__('Avatar',WPACHIEVEMENTS_TEXT_DOMAIN).'</th>';
           }
           $html .= '<th>'.__('Username',WPACHIEVEMENTS_TEXT_DOMAIN).'</th>';
           if( strpos($columns, 'points') !== FALSE ){
            $html .= '<th>'.__('Points',WPACHIEVEMENTS_TEXT_DOMAIN).'</th>';
           }
           if( strpos($columns, 'achievements') !== FALSE ){
            $html .= '<th>'.__('Achievements',WPACHIEVEMENTS_TEXT_DOMAIN).'</th>';
           }
         echo '</tr>
       </thead>';
   
       $html .= '<tbody>';
         $ii=0;
         foreach( $user_achievements as $user_info ):
           $ii++;
           if($user_info->meta_value > 0){
             $user_inf = get_userdata($user_info->user_id);
             $html .= '<tr>';
               if( $position_numbers == 'true' ){
                 $html .= '<td>'.$ii.'</td>';
               }
               if( strpos($columns, 'avatar') !== FALSE ){
                 if(defined( WPACHIEVEMENTS_BUDDYPRESS )){
                   global $bp;
                   if(bp_is_active('activity')){
                     $html .= '<td><a href="'.bp_core_get_user_domain( $user_info->user_id ).'" title="View '.$user_info->user_login.' Profile">'.get_avatar($user_info->user_id, $size = '50').'</a></td>';
                   } else{
                     $html .= '<td>'.get_avatar($user_info->user_id, $size = '50').'</td>';
                   }
                 } elseif(function_exists(WPACHIEVEMENTS_USERPRO)){
                   global $userpro;
                   $html .= '<td><a href="'.$userpro->permalink( $user_info->user_id ).'" title="View '.$user_info->user_login.' Profile">'.get_avatar($user_info->user_id, $size = '50').'</a></td>';
                 } else{
                   $html .= '<td>'.get_avatar($user_info->user_id, $size = '50').'</td>';
                 }
               }
               $html .= '<td>'.$user_inf->display_name.'</td>';
               if( strpos($columns, 'points') !== FALSE ){
                 $html .= '<td>'.$user_info->meta_value.'</td>';
               }
               if( strpos($columns, 'achievements') !== FALSE ){
                 $html .= '<td>';
                   $userachievement = get_user_meta( $user_info->user_id, 'achievements_gained', true );
                   if( !empty($userachievement) && $userachievement!='' ){
                     if(function_exists('is_multisite') && is_multisite()){
                       switch_to_blog(1);
                     }
                     $args = array(
                       'post_type' => 'wpachievements',
                       'post_status' => 'publish',
                       'post__in' => $userachievement,
                       'posts_per_page' => $achievement_limit
                     );
                     $achievement_query = new WP_Query( $args );
                     if( $achievement_query->have_posts() ){
                       while( $achievement_query->have_posts() ){
                         $achievement_query->the_post();
                         $ii++;
                         $ach_ID = get_the_ID();
                         $ach_title = get_the_title();
                         $ach_desc = get_the_content();
                         $ach_data = $ach_title.': '.$ach_desc;
                         $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
                         $html .= '<img src="'.$ach_img.'" class="wpa_table_ach_img" width="30" alt="'.stripslashes($ach_title).__(' Icon',WPACHIEVEMENTS_TEXT_DOMAIN).'" title="'.stripslashes($ach_title).': '.stripslashes(strip_tags($ach_desc)).'" />';
                       }
                     }
                     wp_reset_postdata();
                     if(function_exists('is_multisite') && is_multisite()){
                       restore_current_blog();
                     }
                   } else{
                     $html .= __('None',WPACHIEVEMENTS_TEXT_DOMAIN);
                   }
                 $html .= '</td>';
               }
             $html .= '</tr>';
           }
         endforeach;
       $html .= '</tbody>';
     $html .= '</table><br/>';
           
   }
   
   return $html;
 }
 add_shortcode( 'wpa_leaderboard', 'wpachievements_leaderboard_func' );
 
 
 // Trigger Custom Achievements
 // [wpa_custom_achievement trigger_id="" type="" text=""]
 function wpachievements_custom_achievement_func( $atts ) {
   if( is_user_logged_in() && !is_home() ){
     extract( shortcode_atts( array(
       'trigger_id' => '',
       'type' => 'button',
       'text' => __('Gain Achievement', WPACHIEVEMENTS_TEXT_DOMAIN),
     ), $atts ) );
   
     if(function_exists('is_multisite') && is_multisite()){
       global $blog_id;
       $curBlog = $blog_id;
       switch_to_blog(1);
     }
     global $wpdb, $current_user;
     get_currentuserinfo();
     if(function_exists('is_multisite') && is_multisite()){
       $table = $wpdb->get_blog_prefix(1).'wpachievements_activity';
     } else{
       $table = $wpdb->prefix.'achievements';
     }
     $userachievement = get_user_meta( $current_user->ID, 'achievements_gained', true );
     $activities_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(type) FROM $table WHERE type='%s' AND uid=%d", 'custom_trigger_'.$trigger_id,$current_user->ID) );
     $hasAchievement = true;
     if( !empty($userachievement) ){
       $args = array(
         'post_type' => 'wpachievements',
         'post_status' => 'publish',
         'post__not_in' => $userachievement,
         'posts_per_page' => -1,
         'meta_query' => array(
           array(
             'key' => '_achievement_trigger_id',
             'value' => $trigger_id,
           )
         )
       );
       $achievement_query = new WP_Query( $args );
       if( $achievement_query->have_posts() ){
         $hasAchievement = false;
       }
     } else{
       $hasAchievement = false;
     }
   
     if(function_exists('is_multisite') && is_multisite()){
       restore_current_blog();
     }
   
     if( !empty($trigger_id) && $hasAchievement == false ){
       $type = strtolower($type);
       if( $type == 'instant' || $type == 'Instant' ){
         wpa_trigger_custom_achievement($trigger_id);
       } else{
         $trigger_html = '<a href="#" id="'.$trigger_id.'" class="wpa_custom_trigger '.$type.'">'.$text.'</a>';
         $trigger_html .= '<script type="text/javascript">jQuery("a#'.$trigger_id.'").live("click",function(event){event.preventDefault();if( !jQuery(this).hasClass("trigger_disabled") ){jQuery.post( "'.admin_url( 'admin-ajax.php' ).'", { "action": "wpa_auto_custom_trigger", "wpa_trigger_id": "'.$trigger_id.'"} , function(data){jQuery("a#'.$trigger_id.'").addClass("trigger_disabled");});}});</script>';
         return $trigger_html;
       }
     }
   }
 }
 add_shortcode( 'wpa_custom_achievement', 'wpachievements_custom_achievement_func' );
 
 // Facebook Login - Depreciated
 function wpachievements_fbl_func( $atts ) {
    return;
 }
 add_shortcode( 'wpa_fbl', 'wpachievements_fbl_func' );
 
?>