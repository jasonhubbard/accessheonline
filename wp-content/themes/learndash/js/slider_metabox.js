;jQuery(function($){
	$('#add_to_slider').on('change', function(){
		var options = $(this).siblings('.slider_options');
		if($(this).is(':checked'))
			options.slideDown('fast');
		else
			options.slideUp('fast');
	});
});