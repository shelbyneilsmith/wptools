<?php
/*
Plugin Name: HTML5shiv
Plugin URI: http://www.ramoonus.nl/wordpress/html5shiv/
Description: The latest HTML5 JavaScript shiv for IE to recognise and style the HTML5 elements. 
Version: 3.4
Author: Ramoonus
Author URI: http://www.ramoonus.nl/
*/

function rw_html5shiv() {
		wp_deregister_script('html5shiv'); // deregister
		
		//Original
		//wp_enqueue_script('html5shiv', plugins_url('/js/html5shiv.js', __FILE__), false, '3.4');
		
		// With Printshiv
		wp_enqueue_script('html5shiv', plugins_url('/js/html5shiv-printshiv.js', __FILE__), false, '3.4');
}
		
// if WP Resume is NOT found // if Modernizr is not found
if(!function_exists("wp_resume_header") || !function_exists("rw_modernizr") ) {
	add_action('wp_print_scripts', 'rw_html5shiv');
}
?>