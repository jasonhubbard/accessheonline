<?php
/* Prevent direct script access */
if ( !empty( $_SERVER[ 'SCRIPT_FILENAME' ] ) && 'functions.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'No direct script access allowed' );
}





/**
* Flare Child Theme Setup
* 
* Always use child theme if you want to make some custom modifications. 
* This way theme updates will be a lot easier.
*/
function btp_flarechild_setup() {

	
	
	
}
add_action( 'after_setup_theme', 'btp_flarechild_setup' );
?>