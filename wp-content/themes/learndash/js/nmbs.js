jQuery(document).ready(function($) {

/* Class init
/////////////////////////////////////////////////////////*/
$('ul.page-numbers').addClass('pagination');
$('#commentform').addClass('form-horizontal');
$( '#submit' ).addClass( 'btn btn-primary' );
$( 'table' ).addClass( 'table table-striped table-bordered' );
$( '.widget ul' ).addClass( 'nav nav-pills nav-stacked' );

/* Widgets
/////////////////////////////////////////////////////////*/
$('.widget').each(function(){
	$('.widget-title', this).addClass('panel-heading');
	var $title 	= $('.widget-title', this);
	$title.remove();
	$(this).prepend($title);
});

/* Navbar hover
/////////////////////////////////////////////////////////*/
$(window).resize(function(){
	if( $(window).width() >= 980 ){
		$('.site-header .navbar .nav .dropdown').hover(function() {
			$(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeIn('fast');
		}, function() {
			$(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeOut('fast');
		});
		$('.site-header .navbar .nav .dropdown .dropdown-toggle').click(function(e) {
		    e.stopPropagation();
		});
	} else{
		$('.site-header .navbar .nav .dropdown').off('hover');
	}
}).resize();

/* Shortcodes: Tabs
/////////////////////////////////////////////////////////*/
$('.nav-tabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
$('.nav-tabs li:first, .tab-content .tab-pane:first').addClass('active');
$('.nav-tabs p').remove();

/* Shortcodes: Accordion
/////////////////////////////////////////////////////////*/
$('.panel-group br').remove();
$('.panel-group .panel:first .panel-collapse').addClass('in');
	
});