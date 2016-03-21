<?php
/**
 * This file is part of the BTP_Flare_Theme package.
 *
 * For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 */



/* Prevent direct script access */
if ( !defined( 'BTP_FRAMEWORK_VERSION' ) ) exit( 'No direct script access allowed' );



/**
 * Custom action for displaying the Precontent Theme Area
 */
function btp_precontent() {	
	$out = '';
	
	$precontent = btp_precontent_capture();
	
	ob_start();
	do_action( 'btp_precontent' );
	$out .= ob_get_clean();
	
	$out .= !empty( $precontent ) ? $precontent : '';
	
	$out = trim( $out );
		
	echo $out;
} 

/**
 * Captures the precontent from the first [precontent] shortcode used in the entry content.
 */
function btp_precontent_capture() {
	$content = '';

	if( is_singular() ) {
		$content = get_the_content();
	} else {		
		$post_id = (int) get_option( 'page_home_page' );
		if ( $post_id ) {
			$content = get_post( $post_id );
			$content = $content->post_content;	
		}
	}

    $content = str_replace(
        array('[precontent]', '[/precontent]'),
        array('[btp_precontent]', '[/btp_precontent]'),
        $content
    );

    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

	$precontent = '';	
	
	/* Get the content (precontent to be exact) between shortcode delimiters */	
	$start 	= strpos($content, '[btp_precontent]');
	$end 	= strpos($content, '[/btp_precontent]');
	if ( false !== $start && false !== $end ) {		
		$start += strlen('[btp_precontent]');
		
		$precontent = substr( $content , $start, $end - $start );
	}

	return $precontent;
}
function btp_precontent_render() {
	echo btp_precontent_capture();
}



/* Add [precontent] shortcode to the global shortcode generator */
btp_shortgen_add_item(
	'precontent', 
	array(
		'label' 	=> '[precontent]',
		'content' 	=> array( 'view' => 'Text' ),
		'type'		=> 'block',	
		'group'		=> 'general',
		'subgroup'	=> 'basic',
		'position'	=> 1750,
	)	
);



/**
 * [precontent] shortcode callback function.
 * 
 * This is a fake shortcode - it returns an empty string. 
 * Check the btp_precontent_capture function for the real solution.
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_precontent( $atts, $content = null ) {	
	return '';
}
add_shortcode( 'precontent', 'btp_shortcode_precontent' );
?>