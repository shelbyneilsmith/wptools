<?php
	//main site settings

	//company name, band name, artist/designer name, etc. nothing else. for site title and copyright.
	$company_name = "Wireframes";
	$site_title = "" . $company_name . "";

	//just list nav items in single-quotes separated by commas. use nested arrays for drop-down menus.
	$main_nav = array('home', array('bio', 'history', 'bleh'), 'contact'); //just list nav items in single-quotes separated by commas. use nested arrays for drop-down menus.
	$footer_nav = $main_nav;
	$footer_sections = 0;

	$DEBUG = 0;

	// Design Directory Links
	$wireframes = array( 'Home', 'Contact' );

	/*=== Style Tile Settings ===*/
	$styleTiles = 3;

	// set fonts for each option. first in array is display font, second is body font.
	$fonts= array(
		'a' => array( 'Sans Serif', 'Georgia' ),
		'b' => array( 'Sans Serif', 'Georgia' ),
		'c' => array( 'Sans Serif', 'Georgia' )
	);

	// set the brand attribute words for each option.
	$brandAttr = array(
		'a' => array( 'clean', 'minimal', 'light', 'flat' ),
		'b' => array( 'clean', 'minimal', 'light', 'flat' ),
		'c' => array( 'clean', 'minimal', 'light', 'flat' )
	);

?>
