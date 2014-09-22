<?php

function options_typography_google_fonts() {

	global $data;

	$customfont = '';

	$default = array(
				'arial',
				'verdana',
				'trebuchet',
				'georgia',
				'times',
				'tahoma',
				'helvetica',
				'Helvetica');

	$googlefonts = array(
				$data['font_body']['face'],
				$data['font_h1']['face'],
				$data['font_h2']['face'],
				$data['font_h3']['face'],
				$data['font_h4']['face'],
				$data['font_h5']['face'],
				$data['font_h6']['face'],
				);

	// Remove any duplicates in the list
	$googlefonts = array_unique($googlefonts);

	// Check Google Fonts against System Fonts & Call Enque Font
	foreach($googlefonts as $getfonts) {
		if(!in_array($getfonts, $default)) {
			options_typography_enqueue_google_font($getfonts);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'options_typography_google_fonts' );

// Enqueues the Google $font that is passed
 function options_typography_enqueue_google_font($font) {
	$font = explode(',', $font);
	$font = $font[0];
	// Certain Google fonts need slight tweaks in order to load properly
	// Like our friend "Raleway"
	if ( $font == 'Open Sans' ){
		$font = 'Open Sans:400,600';
	} else{
		$font = $font . ':400,700';
	}
	$font = str_replace(" ", "+", $font);

	wp_enqueue_style( "options_typography_$font", "http://fonts.googleapis.com/css?family=$font", false, null, 'all' );
	//wp_enqueue_style( 'google-webfonts', 'http://fonts.googleapis.com/css?family=Ubuntu+Condensed|Open+Sans:400italic,700italic,400,700&subset=latin,latin-ext', array(), null );
}

?>