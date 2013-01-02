<?php 
	//main site settings

	$company_name = "Wireframes"; //company name, band name, artist/designer name, etc. nothing else. for site title and copyright.
	$site_title = "".$company_name."";
	$year_created = 2012;
	$main_nav = array('home', array('bio', 'history', 'bleh'), 'contact'); //just list nav items in single-quotes separated by commas. use nested arrays for drop-down menus.
	$footer_nav = $main_nav;
	$footer_sections = 0;
		
	//enable certain features that require external libraries/plugins
	$hover_intent = 1;
	$lightbox = 0;
	$twitter_feed = 0;
	if ($twitter_feed):
		$twitter_user = "conanobrien"; //if you enable the twitter feed, don't forget to set the user name!
		$twitter_count = "5";
	endif;
	$slider = 0;
	$galleria = 0;
	$bxslider = 0;
	
	$DEBUG = 0;
?>
