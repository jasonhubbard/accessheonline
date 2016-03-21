<?php
/**
 * Theme widgets: Social icons, ...
 *
 * @package nmbs
 */


/**
 * NMBS social networks
 */
add_action( 'widgets_init', 'nmbs_social_w' );


function nmbs_social_w() {
	register_widget( 'Nmbs_Social_W' );
}

class Nmbs_Social_W extends WP_Widget {

	function Nmbs_Social_W() {
		$widget_ops = array( 'classname' => 'nmbs_social', 'description' => __('A widget that displays social networks. Configure this on Theme options ', 'nmbs_social') );
		
		$control_ops = array( 'id_base' => 'nmbs_social-widget' );
		
		$this->WP_Widget( 'nmbs_social-widget', __('Learndash social networks', 'Social networks'), $widget_ops, $control_ops );
	}

	static function icon_options($list, $list_close, $hidden, $size){
		if(get_option('nmbs_rss')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_rss').'" title="suscribe"><span aria-hidden="true" class="icon icon-feed-3 '.$size.'"></span> <span class="title '.$hidden.'">Feeds</span></a>'.$list_close;
		}
		if(get_option('nmbs_mail')) {
			echo $list.'<a target="_blank" href="mailto:'.get_option('nmbs_mail').'" title="e-mail"><span aria-hidden="true" class="icon icon-mail-2 '.$size.'"></span> <span class="title '.$hidden.'">E-mail</span></a>'.$list_close;
		}
		if(get_option('nmbs_twitter')) {
			echo $list.'<a target="_blank" href="https://twitter.com/'.get_option('nmbs_twitter').'" title="Twitter"><span aria-hidden="true" class="icon icon-twitter '.$size.'"></span> <span class="title '.$hidden.'">Twitter</span></a>'.$list_close;
		}
		if(get_option('nmbs_facebook')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_twitter').'" title="Facebook"><span aria-hidden="true" class="icon icon-facebook-2 '.$size.'"></span> <span class="title '.$hidden.'">Facebook</span></a>'.$list_close;
		}
		if(get_option('nmbs_google')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_google').'" title="Google+"><span aria-hidden="true" class="icon icon-google-plus-3 '.$size.'"></span> <span class="title '.$hidden.'">Google+</span></a>'.$list_close;
		}
		if(get_option('nmbs_skype')) {
			echo $list.'<a target="_blank" href="skype:'.get_option('nmbs_skype').'" title="add me to Skype"><span aria-hidden="true" class="icon icon-skype '.$size.'"></span> <span class="title '.$hidden.'">Skype</span></a>'.$list_close;
		}
		if(get_option('nmbs_linkedin')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_linkedin').'" title="get into my Linkedin Network"><span aria-hidden="true" class="icon icon-linkedin '.$size.'"></span> <span class="title '.$hidden.'">Linkedin</span></a>'.$list_close;
		}
		if(get_option('nmbs_instagram')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_instagram').'" title="Instagram"><span aria-hidden="true" class="icon icon-instagram '.$size.'"></span> <span class="title '.$hidden.'">Instagram</span></a>'.$list_close;
		}
		if(get_option('nmbs_youtube')) {
			echo '<a target="_blank" href="'.get_option('nmbs_youtube').'" title="Youtube"><span aria-hidden="true" class="icon icon-youtube '.$size.'"></span> <span class="title '.$hidden.'">Youtube</span></a>'.$list_close;
		}
		if(get_option('nmbs_vimeo')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_vimeo').'" title="Vimeo"><span aria-hidden="true" class="icon icon-vimeo2 '.$size.'"></span> <span class="title '.$hidden.'">Vimeo</span></a>'.$list_close;
		}
		if(get_option('nmbs_flickr')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_flickr').'" title="Flickr"><span aria-hidden="true" class="icon icon-flickr-3 '.$size.'"></span> <span class="title '.$hidden.'">Flickr</span></a>'.$list_close;
		}
		if(get_option('nmbs_picassa')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_picassa').'" title="Picassa"><span aria-hidden="true" class="icon icon-picassa '.$size.'"></span> <span class="title '.$hidden.'">Picassa</span></a>'.$list_close;
		}
		if(get_option('nmbs_dribbble')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_dribbble').'" title="Dribbble"><span aria-hidden="true" class="icon icon-dribbble-2 '.$size.'"></span> <span class="title '.$hidden.'">Dribbble</span></a>'.$list_close;
		}
		if(get_option('nmbs_deviantart')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_deviantart').'" title="Deviantart"><span aria-hidden="true" class="icon icon-deviantart-2 '.$size.'"></span> <span class="title '.$hidden.'">Deviantart</span></a>'.$list_close;
		}
		if(get_option('nmbs_github')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_github').'" title="Github"><span aria-hidden="true" class="icon icon-github-3 '.$size.'"></span> <span class="title '.$hidden.'">Github</span></a>'.$list_close;
		}
		if(get_option('nmbs_tumblr')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_tumblr').'" title="Tumblr"><span aria-hidden="true" class="icon icon-tumblr-2 '.$size.'"></span> <span class="title '.$hidden.'">Tumblr</span></a>'.$list_close;
		}
		if(get_option('nmbs_soundcloud')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_soundcloud').'" title="Soundcloud"><span aria-hidden="true" class="icon icon-soundcloud-2 '.$size.'"></span> <span class="title '.$hidden.'">Soundcloud</span></a>'.$list_close;
		}
		if(get_option('nmbs_lastfm')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_lastfm').'" title="Lastfm"><span aria-hidden="true" class="icon icon-lastfm-2 '.$size.'"></span> <span class="title '.$hidden.'">Lastfm</span></a>'.$list_close;
		}
		if(get_option('nmbs_delicious')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_delicious').'" title="Delicious"><span aria-hidden="true" class="icon icon-delicious '.$size.'"></span> <span class="title '.$hidden.'">Delicious</span></a>'.$list_close;
		}
		if(get_option('nmbs_stumbleupon')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_stumbleupon').'" title="Stumbleupon"><span aria-hidden="true" class="icon icon-stumbleupon '.$size.'"></span> <span class="title '.$hidden.'">Stumbleupon</span></a>'.$list_close;
		}
		if(get_option('nmbs_stackoverflow')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_stackoverflow').'" title="Stackoverflow"><span aria-hidden="true" class="icon icon-stackoverflow '.$size.'"></span> <span class="title '.$hidden.'">Stackoverflow</span></a>'.$list_close;
		}
		if(get_option('nmbs_pinterest')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_pinterest').'" title="Pinterest"><span aria-hidden="true" class="icon icon-pinterest '.$size.'"></span> <span class="title '.$hidden.'">Pinterest</span></a>'.$list_close;
		}
		if(get_option('nmbs_paypal')) {
			echo $list.'<a target="_blank" href="'.get_option('nmbs_paypal').'" title="Paypal"><span aria-hidden="true" class="icon icon-paypal '.$size.'"></span> <span class="title '.$hidden.'">Paypal</span></a>'.$list_close;
		}
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$icons_list = isset( $instance['icons_list'] ) ? $instance['icons_list'] : false;

		echo $before_widget;

		// Display the widget title 
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $icons_list ){
			echo '<ul class="nav nav-pills nav-stacked">';
			Nmbs_Social_W::icon_options('<li>','</li>','','i-16');
			echo '</ul>';
		} else{
			Nmbs_Social_W::icon_options('','', 'hidden', 'i-32');
		}
		
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['icons_list'] = $new_instance['icons_list'];

		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array( 'title' => __('Social networks', 'nmbs_social'), 'name' => __('Bilal Shaheen', 'Social networks') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'Social networks'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  type="text" class="widefat"/>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( isset( $instance['icons_list']), true ); ?> id="<?php echo $this->get_field_id( 'icons_list' ); ?>" name="<?php echo $this->get_field_name( 'icons_list' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'icons_list' ); ?>"><?php _e('Icons as list', 'nmbs_social'); ?></label>
		</p>

	<?php
	}
}

?>