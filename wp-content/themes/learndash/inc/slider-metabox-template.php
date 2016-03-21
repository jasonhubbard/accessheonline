<input id="add_to_slider" type="checkbox" name="slider" value="1" <?php echo $options['checked'] ?>> <label for="add_to_slider"><?php _e('Add to home slider', 'learndash-theme') ?></label>
<div class="slider_options" <?php echo $options['style'] ?>>
	<label for="slider_title"><?php _e('Title', 'learndash-theme') ?>:</label>
	<input type="text" id="slider_title" name="slider_title" value="<?php echo $options['title'] ?>">
	<label for="slider_text"><?php _e('Text', 'learndash-theme') ?>:</label>
	<textarea id="slider_text" name="slider_text"><?php echo $options['text'] ?></textarea>
	<label for="slider_button"><?php _e('Button text', 'learndash-theme') ?>:</label>
	<input type="text" id="slider_button" name="slider_button" value="<?php echo $options['button'] ?>">
	<span class="field_info"><?php _e('Leave this field blank to transform all the text into a link.', 'learndash-theme') ?></span>
	<label for="slider_link"><?php _e('Link', 'learndash-theme') ?>:</label>
	<input type="text" id="slider_link" name="slider_link" value="<?php echo $options['link'] ?>">
	<span class="field_info"><?php _e('Leave this field blank to link to this entry.', 'learndash-theme') ?></span>
	<br>
	<span class="field_info"><?php _e('Insert a featured image for background. Recomended sizes: between 1024px and 1280px for width; 758px and 980px for height.', 'learndash-theme') ?></span>
</div>
<style>
	.slider_options label {
		margin-top: 10px;
		display: block;
	}
	.slider_options input, 
	.slider_options textarea {
		width: 100%;
	}
	.field_info {
		display:block;
		color: 666;
		font-style: italic;
	}
</style>