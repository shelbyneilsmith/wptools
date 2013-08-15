<?php 

/*
	Plugin Name: WP Fluid Images
	Plugin URI: http://www.slash25.com
	Description: WP Fluid Images replaces the fixed width and height attributes so your images resize in a fluid or responsive design.
	Author: Pat Ramsey
	Author URI: http://www.slash25.com
	
	Version: 1.1.2
	
	License: GNU General Public License v2.0
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/

add_action( 'init', 'WPFluidSettingsInit', 15 );
function WPFluidSettingsInit() {
	//Translations
	if ( !is_admin() ) { // instruction to only load if it is not the admin area
		$foo_loc = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		$js_loc = $foo_loc . '/lib/';
		wp_register_script('fluidimage', $js_loc.'fluidimage.js', array('jquery'), '1.0',false);
		wp_enqueue_script('fluidimage');
	}
}


add_action ( 'wp_footer','fluidstyle' );
function fluidstyle() {
	if(!is_admin()) {
		echo '<span></span><style type="text/css" class="fluid-images">img{max-width:100%;height:auto;}</style>';
	}
}

add_filter( 'post_thumbnail_html', 's25_remove_image_dimensions', 30 );
add_filter( 'image_send_to_editor', 's25_remove_image_dimensions', 30 );
function s25_remove_image_dimensions($html){
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}

