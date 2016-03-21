<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !is_home() ){ get_header(); }
global $wpdb, $current_user;
get_currentuserinfo();
if(!function_exists(WPACHIEVEMENTS_MYCRED)){
  if(function_exists(WPACHIEVEMENTS_CUBEPOINTS)){
    if(function_exists('is_multisite') && is_multisite()){
      $prefix = get_blog_option($wpdb->blogid, 'cp_prefix' );
      $suffix = get_blog_option($wpdb->blogid, 'cp_suffix' );
    } else{
      $prefix = get_option( 'cp_prefix' );
      $suffix = get_option( 'cp_suffix' );
    }
  } else{
    $prefix = '';
    $suffix = ' Points';
  }
}

wp_enqueue_style( 'wpachievements-achievements-page-style', plugins_url('/css/page-style.css', __FILE__) );

if(function_exists('is_multisite') && is_multisite()){
  switch_to_blog(1);
}
          
echo '<center>
<div id="wpa_list_holder">';
  
  $args = array(
    'post_type' => 'wpachievements',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC'
  );
  $achievement_query = new WP_Query( $args );
  if( $achievement_query->have_posts() ){
    $achievementsShow = '';
  } else{
    $achievementsShow = ' style="display:none;"';
  }
  wp_reset_postdata();
            
  echo '<div class="wpa_list_hold" id="wpa_list_quests"'.$achievementsShow.'>
  
    <h2 class="wpa_heading_title"><span id="achievement_icon"></span>'.sprintf(__('Our %sAchievements%s', WPACHIEVEMENTS_TEXT_DOMAIN), '<span>','</span>').'</h2>
    <div class="wpa_list_inner">
      <div class="wpa_list_inner_info">
        <div id="wpa_info">';
          $ii=0;
          $args = array(
            'post_type' => 'wpachievements',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'ASC'
          );
          $achievement_query = new WP_Query( $args );
          if( $achievement_query->have_posts() ){
            while( $achievement_query->have_posts() ){
              $achievement_query->the_post();
              $ach_ID = get_the_ID();
              $ach_title = get_the_title();
              $ach_desc = get_the_content();
              $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
              if(function_exists(WPACHIEVEMENTS_MYCRED)){
                $mycred = mycred();
                $ach_points = $mycred->format_creds( get_post_meta( $ach_ID, '_achievement_points', true ) );
              } else{
                $ach_points = $prefix.get_post_meta( $ach_ID, '_achievement_points', true ).$suffix;
              }
              $ach_occurences = get_post_meta( $ach_ID, '_achievement_occurrences', true );
              $ach_type = get_post_meta( $ach_ID, '_achievement_type', true );
              $ach_trigger_desc = get_post_meta( $ach_ID, '_achievement_trigger_desc', true );
            
              if( $ach_type != 'custom_achievement' ){
                $ii++;
                echo '<div class="achive_tab" id="ach_tab_'.$ii.'"'; if($ii==1){echo 'style="display:block;"';} echo '>
                  <div class="wpa_image_block">';
                    if( is_user_logged_in() ){
                      $userachievements = get_user_meta( $current_user->ID, 'achievements_gained', true );
                      if( in_array($ach_ID, $userachievements) ){
                        echo '<div class="ach_point unlocked">'.__('Unlocked', WPACHIEVEMENTS_TEXT_DOMAIN).'</div>';
                      } else{
                        echo '<div class="ach_point">+'.$ach_points.'</div>';
                      }
                    } else{
                      echo '<div class="ach_point">+'.$ach_points.'</div>';
                    }
                    echo '<img src="'.$ach_img.'" alt="'.$ach_title.' Icon" width="100" />
                  </div>
                  <div class="wpa_info_block">
                    <h2>'.$ach_title.'</h2>
                    <p class="achieve_desc">'.$ach_desc.'</p>
                    <h3>'.__('How do I get this?', WPACHIEVEMENTS_TEXT_DOMAIN).'</h3>';
                    if( $ach_type == 'custom_trigger' ){
                      echo '<p style="margin-top:0;">'.__('Get this achievement for', WPACHIEVEMENTS_TEXT_DOMAIN).' '. $ach_trigger_desc .'</p>';
                    } else{
                      echo '<p style="margin-top:0;">'.__('Get this achievement', WPACHIEVEMENTS_TEXT_DOMAIN).' '. achievement_Desc($ach_type,'',$ach_occurences,'','') .'</p>';
                    }
                  echo '</div>';
                echo '</div>';
              } else{
                $ii++;
                echo '<div class="achive_tab" id="ach_tab_'.$ii.'"'; if($ii==1){echo 'style="display:block;"';} echo '>
                  <div class="wpa_image_block">';
                    if( is_user_logged_in() ){
                      $userachievements = get_user_meta( $current_user->ID, 'achievements_gained', true );
                      if( in_array($ach_ID, $userachievements) ){
                        echo '<div class="ach_point unlocked">'.__('Unlocked', WPACHIEVEMENTS_TEXT_DOMAIN).'</div>';
                      } else{
                        echo '<div class="ach_point">+'.$ach_points.'</div>';
                      }
                    } else{
                      echo '<div class="ach_point">+'.$ach_points.'</div>';
                    }
                    echo '<img src="'.$ach_img.'" alt="'.$ach_title.' Icon" width="100" />
                  </div>';
                  echo '<h2>'.$ach_title.'</h2>
                  <p class="achieve_desc">'.$ach_desc.'</p>';
                echo '</div>';
              }
            }
          }
          wp_reset_postdata();
          echo '<div class="clear"></div>
        </div>
        <br />
        <div id="wpa_listing">
          <center>';
            $ii=0;
            $args = array(
              'post_type' => 'wpachievements',
              'post_status' => 'publish',
              'posts_per_page' => -1,
              'orderby' => 'date',
              'order' => 'ASC'
            );
            $achievement_query = new WP_Query( $args );
            if( $achievement_query->have_posts() ){
              while( $achievement_query->have_posts() ){
                $achievement_query->the_post();
                $ach_ID = get_the_ID();
                $ach_title = get_the_title();
                $ach_img = get_post_meta( $ach_ID, '_achievement_image', true );
                $ii++;
                echo '<a href="javascript:void(0);" id="tab_'.$ii.'"'; if($ii==1){echo 'class="acti_tab"';} echo '>
                  <div>
                    <img src="'.$ach_img.'" width="50" height="50" alt="'.$ach_title.' Icon" />
                    <p class="achievement_listing_text">'.$ach_title.'</p>
                  </div>
                </a>';
              }
            }
            wp_reset_postdata();
            echo '<div class="clear"></div>
          </center>
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div></center>';
if(function_exists('is_multisite') && is_multisite()){
  restore_current_blog();
}
if( !is_home() ){ get_footer(); } ?>