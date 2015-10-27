<?php
/* Create an ACF options page */

function yb_add_options_page() {
	/* create main yb options page */
	acf_add_options_page(array(
		'page_title'  => 'yb Site Options',
		'menu_title'  => 'Site Options',
		'menu_slug'   => 'yb-options',
		'capability'  => 'edit_posts',
		'redirect'    => false
	));

	/* create settings sub page */
	acf_add_options_sub_page(array(
		'page_title'  => 'Miscellaneous',
		'menu_title'  => 'Miscellaneous',
		'parent_slug' => 'yb-options',
	));
}

if( function_exists('acf_add_options_page') ) {
	yb_add_options_page();
}

?>