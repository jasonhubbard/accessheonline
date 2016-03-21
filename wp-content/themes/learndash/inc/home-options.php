<?php
/**
 * Theme home options: Slider, sections,...
 *
 * @package nmbs
 */

$themenamehome = "Home Options";
$shortname = "nmbs";

$optionshome = array(

	array( "name" => $themenamehome." Options",
		"type" => "title"),


	/*
	 * Slider
	 */
	array( "name" => "Slider",
		"type" => "section"),
	array( "type" => "open"),

	array( "name" => "Show slider on homepage",
		"desc" => "Show or hide slider on homepage. If Slider is active Introduction Text turns to hide",
		"id" => $shortname."_show_slider",
		"type" => "checkbox",
		"std" => ""),
	array( "name" => "Slider N. 1",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_1",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 2",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_2",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 3",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_3",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 4",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_4",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 5",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_5",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 6",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_6",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 7",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_7",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 8",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_8",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 9",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_9",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),
	array( "name" => "Slider N. 10",
		"desc" => "Select a page for slider home",  
	    "id" => $shortname."_slider_10",
	    "options" => get_slider_posts_list(),
	    "type" => "page",    
	    "std" => ""),

	array( "type" => "close"),
	/*
	 * Jumbotron
	 */
	/*array( "name" => "Introducction text",
		"type" => "section"),
	array( "type" => "open"),
	array( "name" => "Title for head",
		"desc" => "",
		"id" => $shortname."_introduction_title",
		"type" => "text",
		"std" => ""),
	array( "name" => "Text for head",
		"desc" => "",
		"id" => $shortname."_introduction_text",
		"type" => "textarea",
		"std" => ""),
	array( "name" => "Text for Link",
		"desc" => "",
		"id" => $shortname."_introduction_text_link",
		"type" => "text",
		"std" => ""),
	array( "name" => "Link for head",
		"desc" => "",
		"id" => $shortname."_introduction_link",
		"type" => "text",
		"std" => ""),
	
	array( "type" => "close"),*/

	/*
	 * HOME CONTENT
	 */
	array( "name" => "Home page content: Featured sections at top",
		"type" => "section"),
	array( "type" => "open"),
	array( "name" => "Show feature sections at top",
		"desc" => "",
		"id" => $shortname."_fsection",
		"type" => "checkbox",
		"std" => ""),
	array( "name" => "Feature section 1 Title",
		"desc" => "This is required for show this section",
		"id" => $shortname."_fsection1_title",
		"type" => "text",
		"std" => ""),
	array( "name" => "Feature section 1 Text",
		"desc" => "",
		"id" => $shortname."_fsection1_text",
		"type" => "textarea",
		"std" => ""),
	array( "name" => "Feature section 1 Image",
		"desc" => "",
		"id" => $shortname."_fsection1_image",
		"type" => "image",
		"std" => ""),
	array( "name" => "Feature section 1 url link",
		"desc" => "",
		"id" => $shortname."_fsection1_link",
		"type" => "text",
		"std" => ""),
	array( "name" => "Feature section 1 text link",
		"desc" => "",
		"id" => $shortname."_fsection1_link_text",
		"type" => "text",
		"std" => "View details"),
	array( "name" => "Feature section 2 Title",
		"desc" => "This is required for show this section",
		"id" => $shortname."_fsection2_title",
		"type" => "text",
		"std" => ""),
	array( "name" => "Feature section 2 Text",
		"desc" => "",
		"id" => $shortname."_fsection2_text",
		"type" => "textarea",
		"std" => ""),
	array( "name" => "Feature section 2 Image",
		"desc" => "",
		"id" => $shortname."_fsection2_image",
		"type" => "image",
		"std" => ""),
	array( "name" => "Feature section 2 url link",
		"desc" => "",
		"id" => $shortname."_fsection2_link",
		"type" => "text",
		"std" => ""),
	array( "name" => "Feature section 2 text link",
		"desc" => "",
		"id" => $shortname."_fsection2_link_text",
		"type" => "text",
		"std" => "View details"),
	array( "name" => "Feature section 3 Title",
		"desc" => "This is required for show this section",
		"id" => $shortname."_fsection3_title",
		"type" => "text",
		"std" => ""),
	array( "name" => "Feature section 3 Text",
		"desc" => "",
		"id" => $shortname."_fsection3_text",
		"type" => "textarea",
		"std" => ""),
	array( "name" => "Feature section 3 Image",
		"desc" => "",
		"id" => $shortname."_fsection3_image",
		"type" => "image",
		"std" => ""),
	array( "name" => "Feature section 3 url link",
		"desc" => "",
		"id" => $shortname."_fsection3_link",
		"type" => "text",
		"std" => ""),
	array( "name" => "Feature section 3 text link",
		"desc" => "",
		"id" => $shortname."_fsection3_link_text",
		"type" => "text",
		"std" => "View details"),
	array( "type" => "close"),


	/*
	 * HOME CONTENT
	 */
	array( "name" => "Home page content: Tour sections",
		"type" => "section"),
	array( "type" => "open"),
	array( "name" => "Show Tour section",
		"desc" => "",
		"id" => $shortname."_tour",
		"type" => "checkbox",
		"std" => ""),
	array( "name" => "Tour section 1 Title",
		"desc" => "This is required for show this section",
		"id" => $shortname."_tour1_title",
		"type" => "text",
		"std" => ""),
	array( "name" => "Tour section 1 Text",
		"desc" => "",
		"id" => $shortname."_tour1_text",
		"type" => "textarea",
		"std" => ""),
	array( "name" => "Tour section 1 Image",
		"desc" => "",
		"id" => $shortname."_tour1_image",
		"type" => "image",
		"std" => ""),
	array( "name" => "Tour section 2 Title",
		"desc" => "This is required for show this section",
		"id" => $shortname."_tour2_title",
		"type" => "text",
		"std" => ""),
	array( "name" => "Tour section 2 Text",
		"desc" => "",
		"id" => $shortname."_tour2_text",
		"type" => "textarea",
		"std" => ""),
	array( "name" => "Tour section 2 Image",
		"desc" => "",
		"id" => $shortname."_tour2_image",
		"type" => "image",
		"std" => ""),
	array( "name" => "Tour section 3 Title",
		"desc" => "This is required for show this section",
		"id" => $shortname."_tour3_title",
		"type" => "text",
		"std" => ""),
	array( "name" => "Tour section 3 Text",
		"desc" => "",
		"id" => $shortname."_tour3_text",
		"type" => "textarea",
		"std" => ""),
	array( "name" => "Tour section 3 Image",
		"desc" => "",
		"id" => $shortname."_tour3_image",
		"type" => "image",
		"std" => ""),
	
	array( "type" => "close"),

	/*
	 * HOME CONTENT
	 */
	array( "name" => "Home page content: Page content",
		"type" => "section"),
	array( "type" => "open"),
	array( "name" => "Hide page title",
		"desc" => "",
		"id" => $shortname."_hide_page_title",
		"type" => "checkbox",
		"std" => ""),
	array( "name" => "Center page title",
		"desc" => "",
		"id" => $shortname."_center_page_title",
		"type" => "checkbox",
		"std" => ""),
	array( "name" => "Hide page content",
		"desc" => "",
		"id" => $shortname."_hide_page_content",
		"type" => "checkbox",
		"std" => ""),

	array( "type" => "close")
);

function nmbshome_add_admin() {
	global $themenamehome, $shortnamehome, $optionshome;
		if ( $_GET['page'] == basename(__FILE__) ) {
			if ( 'save' == $_REQUEST['action'] ) {
				foreach ($optionshome as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
		foreach ($optionshome as $value) {
			if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
			header("Location: themes.php?page=home-options.php&saved=true");
		die;
		} 
		else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($optionshome as $value) {
				delete_option( $value['id'] ); }
			header("Location: themes.php?page=home-options.php&reset=true");
		die;
		}
}
add_theme_page($themenamehome, $themenamehome, 'administrator', basename(__FILE__), 'nmbshome_admin');

}

function nmbshome_add_init() {
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("functions", $file_dir."/css/theme-options.css", false, "1.0", "all");
}

function nmbshome_admin() {
	global $themenamehome, $shortnamehome, $optionshome;
		$i=0;
		if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themenamehome.' settings saved.</strong></p></div>';
		if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themenamehome.' settings reset.</strong></p></div>';
	?>
<div class="wrap nmbs-theme">
	<div id="icon-themes" class="icon32"><br></div><h2><?php echo $themenamehome; ?> Settings</h2>
		<div class="rm_opts">
			<div class="rm_opts">
				<form method="post">
					<?php foreach ($optionshome as $value) {
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
						case 'page':
					?>
						<div class="rm_input rm_select">
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

							<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
								<option value="">Select a page</option>
								<?php foreach ($value['options'] as $option) { ?>
								<option id="<?php echo $option['id']; ?>" <?php if (get_option( $value['id'] ) == $option['id']) { echo 'selected="selected"'; } ?> value="<?php echo $option['id']; ?>"><?php echo $option['text']; ?></option><?php } ?>
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
if (is_admin()) {  
    wp_enqueue_script('jquery-ui-sortable');  
}  
if ( current_user_can( 'edit_theme_options' ) ) {
	add_action('admin_init', 'nmbshome_add_init');
	add_action('admin_menu', 'nmbshome_add_admin');
}