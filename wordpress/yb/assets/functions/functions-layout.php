<?php

/* ------------------------------------------------------------------------ */
/* REDUX mobile menu classes on body_class() */
/* ------------------------------------------------------------------------ */

function yb_mobile_menu_classes( $classes ) {
	global $ybwp_data;

	if ( !empty($ybwp_data['opt-checkbox-mobilemenu'] ) ) {
		$classes[] = 'mobile-menu';

		if ( $ybwp_data['opt-select-mobilemenutype'] === 'offscreen-nav' ) {
			$classes[] = 'offscreen-nav';
			$classes[] = 'mobilenav-pos-'.$ybwp_data['opt-select-offscreenpos'];
			$classes[] = 'mobilenav-anim-'.$ybwp_data['opt-select-mobilemenuanim'];
			$classes[] = 'mobilenav-btn-pos-'.$ybwp_data['opt-select-menubtnpos'];

			if ( $ybwp_data['opt-checkbox-utilitynavmerge'] ) { $classes[] = 'util-nav-merge'; }
		}
	}

	return $classes;
}
add_filter( 'body_class', 'yb_mobile_menu_classes' );

/* ------------------------------------------------------------------------ */
/* Return REDUX page layout and sidebar classes */
/* ------------------------------------------------------------------------ */

function yb_layout_class() {
	global $ybwp_data;
	global $post;

	/* Force full width by page ID */
	$fullwidth_ids = [];

	$post_id = $post->ID;
	$class_array = [];
	$return_default = false;

	/* Add Blog Settings to <body> */
	if ( is_blog() ) {

		/* Set Blog Sidebar */
		switch($ybwp_data['opt-bloglayout']) {
			case "Centered Left Sidebar" :
			$class_array[] = "sidebar-left";
			break;

			case "Centered Right Sidebar" :
			$class_array[] = "sidebar-right";
			break;

			default :
			$return_default = true;
			break;
		}
	}

	/* Apply Front Page Settings */
	if ( is_front_page() ) {
		switch ($ybwp_data['opt-homelayout']) {

			case 'Full Width':
			$class_array[] = "full-width";
			break;

			case 'Centered Left Sidebar':
			$class_array[] = "sidebar-left";
			break;

			case 'Centered Right Sidebar':
			$class_array[] = "sidebar-right";
			break;

			case 'default':
			$return_default = true;
			break;

			default:
			break;
		}
	}

	/* Is if WooCommerce template, use it's settings */
	if (is_page_template('woocommerce.php')) {
		switch($ybwp_data['opt-woocommercelayout']) {
			case "Full Width" :
			$class_array[] = "full-width";
			break;

			default :
			$return_default = true;
			break;
		}
	}

	/* Appy General Layout setting */
	if ( !is_blog() && !is_front_page() && !is_page_template('woocommerce.php') || $return_default === true ) {
		switch ($ybwp_data['opt-layout']) {
			case 'Full Width':
			$class_array[] = "full-width";
			break;

			case 'Centered Left Sidebar':
			$class_array[] = "sidebar-left";
			break;

			case 'Centered Right Sidebar':
			$class_array[] = "sidebar-right";
			break;

			default:
			/* Its the default! No class needed. */
			break;
		}
	}

	/* Force full width by page ID */
	if (in_array($post_id, $fullwidth_ids)) {
		$class_array[] = "full-width";
	}

	return $class_array;
}

/* ------------------------------------------------------------------------ */
/* Blog layout post classes on body_class() */
/* ------------------------------------------------------------------------ */

function yb_blog_layout_class() {
	global $ybwp_data;
	$class_array = [];

	if (is_blog()) {
		switch($ybwp_data['opt-select-blogpostlayout']) {
			case "blog-medium" :
			$class_array[] = "blog-medium";
			break;

			case "blog-fullwidth" :
			default :
			$class_array[] = "blog-fullwidth";
			break;
		}
	}

	return $class_array;
}

/* ------------------------------------------------------------------------ */
/* Add yb_layout_classes to body_class() */
/* requires yb_layout_class() */
/* ------------------------------------------------------------------------ */

function yb_body_class( $classes ) {
	/* Combine yb_layout_class array with body classes */
	$page_classes = yb_layout_class();
	$classes = array_merge($classes, $page_classes);

	/* Combine blog layout classes */
	//$blog_classes = yb_blog_layout_class();
	//$classes = array_merge($classes, $blog_classes);

	return $classes;
}
add_filter( 'body_class', 'yb_body_class' );

/* ------------------------------------------------------------------------ */
/* is_sidebar_page() : If this page should have a sideber */
/* requires yb_layout_class() */
/* ------------------------------------------------------------------------ */

function is_sidebar_page() {

	$is_sidebar_page = false;
	$sidebar_classes = ['sidebar-right', 'sidebar-left'];
	$page_classes = yb_layout_class();

	foreach ($sidebar_classes as $class) {
		if ( in_array($class, $page_classes) ) {
			$is_sidebar_page = true;
		}
	}

	return $is_sidebar_page;
}


?>