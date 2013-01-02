<?php
/*
Plugin Name: IE7-JS
Plugin URI: http://www.ramoonus.nl
Description: IE7.js is a JavaScript library to make Microsoft Internet Explorer behave like a standards-compliant browser. It fixes many HTML and CSS issues and makes transparent PNG work correctly under IE5 and IE6. 
Version: 1.0.0
Author: Ramoonus
Author URI: http://www.ramoonus.nl/wordpress/ie7-js/
*/

// init
function rw_ie7_js() {
	echo '<!--[if lt IE 9]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script><![endif]-->';
}
// load
add_action('wp_head', 'rw_ie7_js');
?>