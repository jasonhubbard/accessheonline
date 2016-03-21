jQuery(document).ready(function($) {

/* main-slider
/////////////////////////////////////////////////////////*/

$('#main-slider').each(function(){

	var $slider 		= $('#main-slider');
	var $slider_number  = $('.carousel-inner', this).length;

	$('.carousel-inner .item', $slider).each(function(i) {
		$('.carousel-indicators', $slider).append('<li data-target="#main-slider" data-slide-to="'+((i+1)-1)+'"></li>');
	});

	$('.carousel-inner .item:first, .carousel-indicators li:first', $slider).addClass('active');

});

/* #learndash_lesson
/////////////////////////////////////////////////////////*/
$('#learndash_lessons .panel-body > div').addClass('col-md-4 col-sd-6 col-xs-12');
$('#learndash_quizzes .panel-body > div').addClass('col-md-4 col-sd-6 col-xs-12');

var learndash_lessons = $('#learndash_lessons .panel-body .col-md-4');
for( var i = 0; i < learndash_lessons.length; i+=3 ) {
	learndash_lessons.slice(i, i+3).wrapAll('<div class="row"></div>');
}

var learndash_quizzes = $('#learndash_quizzes .panel-body .col-md-4');
for( var i = 0; i < learndash_quizzes.length; i+=3 ) {
	learndash_quizzes.slice(i, i+3).wrapAll('<div class="row"></div>');
}

$('.entry-content .learndash_topic_dots a span').each(function(){
	$(this).append('<b>'+ $(this).attr('title') +'</b>')
	//$(this).text($(this).attr('title'))
});

$('#learndash_uploaded_assignments').each(function(){
	var $text = $('h2', this).text();
	$(this).prepend('<div class="panel-heading">'+ $text +'</div>').addClass('panel panel-default')
	$('h2', this).remove();
	$('a', this).wrapAll('<div class="panel-body"></div>');
});


$('#learndash_next_prev_link').append('<ul class="pager"><li class="previous"></li><li class="next"></li></ul>');
$('#learndash_next_prev_link > a:first').appendTo('#learndash_next_prev_link .pager .previous');
$('#learndash_next_prev_link > a:last').appendTo('#learndash_next_prev_link .pager .next');

$('#learndash_back_to_lesson').append('<ul class="pager"><li class="previous"></li></ul>');
$('#learndash_back_to_lesson > a').appendTo('#learndash_back_to_lesson .pager .previous');

$('.learndash br').remove();

$('#learndash_mark_complete_button, #sfwd-mark-complete input').addClass('btn btn-primary');


$('.wpProQuiz_button').addClass('btn btn-primary').removeClass('wpProQuiz_button');
$('div>#sfwd-mark-complete, #learndash_timer').addClass('col-md-6 col-sd-6 col-xs-6').wrapAll('<div class="row"></div>');

$( "p:contains(Course Status: Not Started)" ).addClass('alert alert-warning');

$('.wpProQuiz_certificate a').addClass('btn btn-warning');
$('.quiz_continue_link a').addClass('btn btn-success');


/* Widgets
/////////////////////////////////////////////////////////*/
$('.widget_ldcourseinfo').each(function(){
	var $text = $('b:first', this).text();
	$(this).prepend('<h2 class="widget-title panel-heading">'+ $text +'</h2>')
	$('b:first, br', this).remove();
});

/* courses-grid
/////////////////////////////////////////////////////////*/


var a = $('.type-sfwd-courses.thumbnail ').parent();
for( var i = 0; i < a.length; i+=3 ) {
	a.slice(i, i+3).wrapAll('<div class="row"></div>');
}

/* jigoshop-products
/////////////////////////////////////////////////////////*/

var a = $('.jigoshop-products .thumbnail.product ').parent();
for( var i = 0; i < a.length; i+=3 ) {
	a.slice(i, i+3).wrapAll('<div class="row"></div>');
}


$('.thumbnail.course.product .button').addClass('btn btn-primary').removeClass('button');

$('.jigoshop-cart  #content').removeClass('site-content');
$('.jigoshop-myaccount #content').removeClass('site-content');

$('#breadcrumb').addClass('breadcrumb');

$('.jigoshop.single-product .jumbotron.page-header h1').text($('.jigoshop.single-product .product_title').text());
$('.jigoshop.single-product .product_title').remove();



/* footer widgets
/////////////////////////////////////////////////////////*/
jQuery('#colophon .widget-title').removeClass('panel-heading');

var $n_widgets = $('#colophon .widget').length;

if ($n_widgets == 1 ){
	$('#colophon .widget').addClass(' col-md-6 col-md-offset-3');
	var a = $('#colophon .widget');
	for( var i = 0; i < a.length; i+=1 ) {
		a.slice(i, i+1).wrapAll('<div class="row"></div>');
	}
} else if ($n_widgets == 2 ){
	$('#colophon .widget').addClass(' col-md-6');
	var a = $('#colophon .widget');
	for( var i = 0; i < a.length; i+=2 ) {
		a.slice(i, i+2).wrapAll('<div class="row"></div>');
	}
} else if ($n_widgets == 3 ){
	$('#colophon .widget').addClass(' col-md-4');
	var a = $('#colophon .widget');
	for( var i = 0; i < a.length; i+=3 ) {
		a.slice(i, i+3).wrapAll('<div class="row"></div>');
	}
} else if ($n_widgets >= 4 ){
	$('#colophon .widget').addClass(' col-md-3')
	var a = $('#colophon .widget');
	for( var i = 0; i < a.length; i+=4 ) {
		a.slice(i, i+4).wrapAll('<div class="row"></div>');
	}
}


$('.jumbotron.page-header .widget-title').removeClass('panel-heading');

var $n_widgets = $('.jumbotron.page-header .widget').length;

if ($n_widgets == 1 ){
	$('.jumbotron.page-header .widget').addClass(' col-md-6 col-md-offset-3')
} else if ($n_widgets == 2 ){
	$('.jumbotron.page-header .widget').addClass(' col-md-6')
} else if ($n_widgets == 3 ){
	$('.jumbotron.page-header .widget').addClass(' col-md-4')
} else if ($n_widgets == 4 ){
	$('.jumbotron.page-header .widget').addClass(' col-md-3')
}

/* Join Buttons
/////////////////////////////////////////////////////////*/
$('a.take-course').on('click', function(e){
	e.preventDefault();
	var rel = $(e.delegateTarget).attr('rel');
	if(rel == 'join')
		return $('div.learndash_join_button').find('input[type=submit]').click();

	if($('.learndash_2checkout_button').length)
		return $('.learndash_2checkout_button').find('input[type=submit]').click();

	return $('.learndash_paypal_button').find('form').submit();
});

});