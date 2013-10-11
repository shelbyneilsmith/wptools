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
?>
