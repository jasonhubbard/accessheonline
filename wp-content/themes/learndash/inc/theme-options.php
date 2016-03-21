<?php
/**
 * Theme options: Social icons, keywords, google analitycs, ...
 *
 * @package nmbs
 */

$themename = __("Theme Options", 'learndash-theme');
$shortname = "nmbs";
$options = array (

array( "name" => $themename." Options",
	"type" => "title"),
array( "name" => __("General", 'learndash-theme'),
	"type" => "section"),
array( "type" => "open"),

array( "name" => __("Logo", 'learndash-theme'),
	"desc" => __("Upload your logo.", 'learndash-theme'),
	"id" => $shortname."_logo",
	"type" => "image",
	"std" => ""),
array( "name" => __("Logo size", 'learndash-theme'),
	"desc" => __("Select a size for logo. You can have a logo up to 200px tall using the 'extra' option.", 'learndash-theme'),
	"id" => $shortname."_logo_size",
	"type" => "select",  
    "options" => array("little", "medium", "big", "bigger", "extra"),  
    "std" => "little"),
array( "name" => __("Favicon", 'learndash-theme'),
	"desc" => __("A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image", 'learndash-theme'),
	"id" => $shortname."_favicon",
	"type" => "favicon",
	"std" => ""),
array( "name" => __("Meta Description", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_meta_description",
	"type" => "textarea",
	"std" => ""),	
array( "name" => __("Meta Keywords", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_meta_keywords",
	"type" => "textarea",
	"std" => ""),
array( "name" => __("Google analytics code", 'learndash-theme'),
	"desc" => __("Example: 'UA-XXXXX-Y'", 'learndash-theme'),
	"id" => $shortname."_analytics",
	"type" => "text",
	"std" => ""),
array( "name" => __("Search on navigation", 'learndash-theme'),
	"desc" => __("Show or hide search form on navigation", 'learndash-theme'),
	"id" => $shortname."_search",
	"type" => "checkbox",
	"std" => ""),
array( "name" => __("Login Link on navigation", 'learndash-theme'),
	"desc" => __("Show or hide Login Link on navigation", 'learndash-theme'),
	"id" => $shortname."_login",
	"type" => "checkbox",
	"std" => ""),
array( "name" => __("Footer copyright text", 'learndash-theme'),
	"desc" => __("Enter text used in the right side of the footer. It can be HTML", 'learndash-theme'),
	"id" => $shortname."_footer_text",
	"type" => "textarea",
	"std" => "&copy; 2013 ".get_bloginfo()),
array( "type" => "close"),


/*
 * Courses options
 */
array( "name" => __("LearnDash Options", 'learndash-theme'),
	"type" => "section"),
array( "type" => "open"),
array( "name" => __("Date and Author on Courses", 'learndash-theme'),
	"desc" => __("Show date and author on Courses", 'learndash-theme'),
	"id" => $shortname."_dateauthor",
	"type" => "checkbox",
	"std" => __("Show author and date info in courses lessons and Quizzes.", 'learndash-theme')),
array( "name" => __("Hide lessons topics", 'learndash-theme'),
	"desc" => __("Hide lessons topics on lesson grid", 'learndash-theme'),
	"id" => $shortname."_lessonstopics",
	"type" => "checkbox",
	"std" => __("", 'learndash-theme')),
array( "type" => "close"),

/*
 * Colors
 */
array( "name" => __("Colors", 'learndash-theme'),
	"type" => "section"),
array( "type" => "open"),


array( "name" => __("Background Image for header", 'learndash-theme'),
	"desc" => __("Upload a image for background", 'learndash-theme'),
	"id" => $shortname."_header_img",
	"type" => "image",
	"std" => ""),

array( "name" => __("Background Color navigation bar", 'learndash-theme'),
	"desc" => __("Select a color for background", 'learndash-theme'),
	"id" => $shortname."_navigation_background",
	"type" => "color",
	"std" => "#222222"),// set default color
array( "name" => __("Color for links on navigation bar", 'learndash-theme'),
	"desc" => __("Select a color for background", 'learndash-theme'),
	"id" => $shortname."_navigation_colors",
	"type" => "color",
	"std" => "#999999"),// set default color
array( "name" => __("Color for selected menu text", 'learndash-theme'),
	"desc" => __("Select a color for text of a selected menu item", 'learndash-theme'),
	"id" => $shortname."_selected_menu_text",
	"type" => "color",
	"std" => "#ffffff"),// set default color
array( "name" => __("Color for selected menu background ", 'learndash-theme'),
	"desc" => __("Select a color for the background of a selected menu item.", 'learndash-theme'),
	"id" => $shortname."_selected_menu_background",
	"type" => "color",
	"std" => "#000000"),// set default color

array( "name" => __("Color for submenu text", 'learndash-theme'),
	"desc" => __("Select a color for the submenu items text", 'learndash-theme'),
	"id" => $shortname."_submenu_text",
	"type" => "color",
	"std" => "#333333"),// set default color
array( "name" => __("Background for submenu", 'learndash-theme'),
	"desc" => __("Select a color for the background of the submenus.", 'learndash-theme'),
	"id" => $shortname."_submenu_background",
	"type" => "color",
	"std" => "#ffffff"),// set default color
array( "name" => __("Submenu item hover text color", 'learndash-theme'),
	"desc" => __("Select a color for the submenu items' text when the cursor is over.", 'learndash-theme'),
	"id" => $shortname."_submenu_text_hover",
	"type" => "color",
	"std" => "#ffffff"),// set default color
array( "name" => __("Submenu item hover background color", 'learndash-theme'),
	"desc" => __("Select a color for the submenu items' background when the cursor is over.", 'learndash-theme'),
	"id" => $shortname."_submenu_background_hover",
	"type" => "color",
	"std" => "#428bca"),// set default color


array( "name" => __("Background Color for header", 'learndash-theme'),
	"desc" => __("Select a color for background", 'learndash-theme'),
	"id" => $shortname."_header_background",
	"type" => "color",
	"std" => "#eeeeee"),// set default color
array( "name" => __("Color for header text", 'learndash-theme'),
	"desc" => __("Select a color for text on the header", 'learndash-theme'),
	"id" => $shortname."_header_color",
	"type" => "color",
	"std" => "#000000"),// set default color
array( "name" => __("Color for slider text", 'learndash-theme'),
	"desc" => __("Select a color for text on the slider", 'learndash-theme'),
	"id" => $shortname."_slider_text_color",
	"type" => "color",
	"std" => "#ffffff"),// set default color
array( "name" => __("Background Color for footer", 'learndash-theme'),
	"desc" => __("Select a color for background", 'learndash-theme'),
	"id" => $shortname."_footer_background",
	"type" => "color",
	"std" => "#eeeeee"),// set default color
array( "name" => __("Color for footer text", 'learndash-theme'),
	"desc" => __("Select a color for text on the footer", 'learndash-theme'),
	"id" => $shortname."_footer_color",
	"type" => "color",
	"std" => "#000000"),// set default color


array( "name" => __("Button color", 'learndash-theme'),
	"desc" => __("Select a color for the buttons", 'learndash-theme'),
	"id" => $shortname."_button_color",
	"type" => "color",
	"std" => "#428bca"),// set default color
array( "name" => __("Button hover color", 'learndash-theme'),
	"desc" => __("Select a color for the buttons with the cursor over", 'learndash-theme'),
	"id" => $shortname."_button_hover_color",
	"type" => "color",
	"std" => "#3276b1"),// set default color
array( "name" => __("Button text color", 'learndash-theme'),
	"desc" => __("Select a color for the buttons' text", 'learndash-theme'),
	"id" => $shortname."_button_text_color",
	"type" => "color",
	"std" => "#ffffff"),// set default color

array( "type" => "close"),

/*
 * Social
 */
array( "name" => __("Social Icons", 'learndash-theme'),
	"type" => "section"),
array( "type" => "open"),
array( "name" => __("Feedburner URL", 'learndash-theme'),
	"desc" => __("Feedburner is a Google service that takes care of your RSS feed. Paste your Feedburner URL here to let readers see it in your website. Example: " .get_bloginfo('rss2_url'), 'learndash-theme'),
	"id" => $shortname."_rss",
	"type" => "text",
	"std" => ""),
array( "name" => __("Mail", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_mail",
	"type" => "text",
	"std" => ""),
array( "name" => __("Twitter user", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_twitter",
	"type" => "text",
	"std" => ""),
array( "name" => __("Facebook URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_facebook",
	"type" => "text",
	"std" => ""),
array( "name" => __("Google+ URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_google",
	"type" => "text",
	"std" => ""),
array( "name" => __("Skype username", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_skype",
	"type" => "text",
	"std" => ""),
array( "name" => __("Linkedin URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_linkedin",
	"type" => "text",
	"std" => ""),
array( "name" => __("Instagram URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_instagram",
	"type" => "text",
	"std" => ""),
array( "name" => __("Youtube URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_youtube",
	"type" => "text",
	"std" => ""),
array( "name" => __("Vimeo URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_vimeo",
	"type" => "text",
	"std" => ""),
array( "name" => __("Flickr URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_flickr",
	"type" => "text",
	"std" => ""),
array( "name" => __("Picassa URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_picassa",
	"type" => "text",
	"std" => ""),
array( "name" => __("Dirbbble URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_dribbble",
	"type" => "text",
	"std" => ""),
array( "name" => "Deviantart URL",
	"desc" => "",
	"id" => $shortname."_deviantart",
	"type" => "text",
	"std" => ""),
array( "name" => __("Github URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_github",
	"type" => "text",
	"std" => ""),
array( "name" => __("Tumblr URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_tumblr",
	"type" => "text",
	"std" => ""),
array( "name" => __("Soundcloud URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_soundcloud",
	"type" => "text",
	"std" => ""),
array( "name" => __("Lastfm URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_lastfm",
	"type" => "text",
	"std" => ""),
array( "name" => __("Delicious URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_delicious",
	"type" => "text",
	"std" => ""),
array( "name" => __("Stumbleupon URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_stumbleupon",
	"type" => "text",
	"std" => ""),
array( "name" => __("Stackoverflow URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_stackoverflow",
	"type" => "text",
	"std" => ""),
array( "name" => __("Pinterest URL", 'learndash-theme'),
	"desc" => "",
	"id" => $shortname."_pinterest",
	"type" => "text",
	"std" => ""),
/*array( "name" => "Paypal URL",
	"desc" => "",
	"id" => $shortname."_paypal",
	"type" => "text",
	"std" => ""),*/
array( "type" => "close")
);

function nmbs_add_admin() {
	global $themename, $shortname, $options;
		if ( $_GET['page'] == basename(__FILE__) ) {
			if ( 'save' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
		foreach ($options as $value) {
			if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
			header("Location: themes.php?page=theme-options.php&saved=true");
		die;
		} 
		else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				delete_option( $value['id'] ); }
			header("Location: themes.php?page=theme-options.php&reset=true");
		die;
		}
}
add_theme_page($themename, $themename, 'administrator', basename(__FILE__), 'nmbs_admin');

}

function nmbs_add_init() {
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("functions", $file_dir."/css/theme-options.css", false, "1.0", "all");
}

function nmbs_options_enqueue_scripts() {
	
	wp_enqueue_script('jquery'); 

	wp_enqueue_script('thickbox'); 
	wp_enqueue_style('thickbox'); 

	wp_enqueue_script('wp-color-picker'); 
	wp_enqueue_style('wp-color-picker'); 

	wp_enqueue_script('media-upload'); 
	wp_enqueue_script('nmbs-upload'); 
 
} 
add_action('admin_enqueue_scripts', 'nmbs_options_enqueue_scripts');

function nmbs_admin() {
	global $themename, $shortname, $options;
		$i=0;
		if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
		if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
	?>
<div class="wrap nmbs-theme">
	<div id="icon-themes" class="icon32"><br></div><h2><?php echo $themename; ?> Settings</h2>
		<div class="rm_opts">
			<div class="rm_opts">
				<form method="post">
					<?php foreach ($options as $value) {
						switch ( $value['type'] ) {
						case "open":
					?>
					<?php break;
						case "close":
					?>
						</div>
						</div>
					<?php break;
					case "title":
					?>
					<?php break;
					case 'text':
					?>
						<div class="rm_input rm_text">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						 	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
						 	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
						</div>
					<?php break;
					case 'color':
					?>
						<div class="rm_input rm_text">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						 	<input class="colorpicker" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" data-default="<?php echo $value['std']; ?>" />
						 	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
						</div>
					<?php break;
					case 'image':
					?>
						<div class="rm_input rm_text">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						 	<table class="upload_image_component">
						 		<tr>
							        <td valign='top'>
							            <input type='text' class="text" id='<?php echo $value['id']; ?>' readonly='readonly' name='<?php echo $value['id']; ?>' size='40' value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
							            <input class='upload_button button' type='button' value='Upload image' />
							            <br />
							            <a href="#" class="remove_image">remove image</a>
							            <br />
							            <br />
							            <?php if ( get_option( $value['id'] ) != ""): ?>
							            	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>&h=80"/>
							        	<?php endif; ?>
							        </td>
							    </tr>
							</table>
						 	<small><?php echo $value['desc']; ?></small>
						 	<div class="clearfix"></div>
						</div>
					<?php break;
					case 'favicon':
					?>
						<div class="rm_input rm_text">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						 	<table class="upload_image_component">
						 		<tr>
							        <td valign='top'>
							            <input type='text' class="text" id='<?php echo $value['id']; ?>' readonly='readonly' name='<?php echo $value['id']; ?>' size='40' value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
							            <input class='upload_button button' type='button' value='Upload image' />
							            <br />
							            <a href="#" class="remove_image">remove image</a>
							            <br />
							            <br />
							            <?php if ( get_option( $value['id'] ) != ""): ?>
							            	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>&h=16&w=16"/>
							        	<?php endif; ?>
							        </td>
							    </tr>
							</table>
						 	<small><?php echo $value['desc']; ?></small>
						 	<div class="clearfix"></div>
						</div>
					<?php
						break;
						case 'textarea':
					?>
						<div class="rm_input rm_textarea">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
							<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
							<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
						</div>
					<?php
						break;
						case 'select':
					?>
						<div class="rm_input rm_select">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
							<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
								<?php foreach ($value['options'] as $option) { ?>
								<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
							</select>
							<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
						</div>
					<?php
						break;
						case "checkbox":
					?>
						<div class="rm_input rm_checkbox">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
							<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
							<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
							<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
						 </div>
					<?php break; 
						case "section":
						$i++;
					?>
						<div class="widgets-holder-wrap ui-droppable">
							<div class="sidebar-name">
								<h3><?php echo $value['name']; ?></h3>
								<span class="submit">
									<input name="save<?php echo $i; ?>" type="submit" value="Save changes" class="button button-primary widget-control-save right" />
								</span>
							<div class="clearfix">
						</div>
					</div>
					<div class="widget-holder">
					<?php break;
						}
						}
					?>
					<input type="hidden" name="action" value="save" />
					<script type="text/javascript">
						jQuery(document).ready(function($) {

						    var uploadID = ''; /*setup the var*/  
						  
						    jQuery('.nmbs-theme .upload_button').click(function() {  
						        uploadID = jQuery(this).prev('input'); /*grab the specific input*/  
						        formfield = jQuery('.nmbs-theme .upload').attr('name');  
						        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');  
						        return false;  
						    });  
						      
						    window.send_to_editor = function(html) {  
						        var imgurl = jQuery('img',html).attr('src');  
						        uploadID.val(imgurl); //assign the value to the input
						        $('.widget-control-save').click();
						        tb_remove();  
						    };  

						    $('.nmbs-theme .upload_image_component').each(function(){
						        
						        var $this = $(this);

						        $('.remove_image', $this).click(function() { 
						            $('.text', $this).val('');
						            $('img', $this).remove();
						            $('.widget-control-save').click();
						        });

						    });

						    jQuery('input.colorpicker').each(function(){
						    	$color_default = $(this).attr('data-default');
						    	$(this).wpColorPicker({
									defaultColor: $color_default,
								});
						    });		

						});
					</script>
				</form>
				<form method="post">
				<input id="reset_button" type="hidden" name="reset" type="submit" value="Reset" />
				<input type="hidden" name="action" value="reset" />
			</form>
		</div> 
	</div>
<?php
	}
?>
<?php
	if ( current_user_can( 'edit_theme_options' ) ) {
	add_action('admin_init', 'nmbs_add_init');
	add_action('admin_menu', 'nmbs_add_admin');
}