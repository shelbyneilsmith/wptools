<?php
/*
Plugin Name: Modernizr
Plugin URI: http://www.ramoonus.nl/wordpress/modernizr/
Description: Modernizr is a small JavaScript library that detects the availability of native implementations for next-generation web technologies
Version: 2.6.1
Author: Ramoonus
Author URI: http://www.ramoonus.nl/
*/

function rw_modernizr() {
		wp_deregister_script('modernizr'); // deregister
		wp_enqueue_script('modernizr', plugins_url('/js/modernizr.js', __FILE__), false, '2.6.1', false);
}
add_action('init', 'rw_modernizr'); // init
?>