<?php

function yb_scripts_basic() {
	global$ybwp_data;

	/* ------------------------------------------------------------------------ */
	/* Register Scripts */
	/* ------------------------------------------------------------------------ */
	wp_register_script('modernizr', get_template_directory_uri() . '/library/_scripts/libs/modernizr.custom.min.js', 'jquery', '1.0', TRUE);

	wp_register_script('shortcodes', get_template_directory_uri() . '/library/_scripts/shortcodes.js', 'jquery', '1.0', TRUE);

	// if( !empty($ybwp_data['opt-text-social-twitter'] ) ) {
	// 	wp_register_script('twitter', get_template_directory_uri() . '/library/_scripts/twitter/jquery.tweet.min.js', 'jquery', '1.0', TRUE);
	// }

	// if ( $data['check_portfoliotype'] == true ) {
	// 	wp_register_script('isotope', get_template_directory_uri() . '/library/_scripts/isotope.js', 'jquery', '1.5', TRUE);
	// }

	if ( !empty($ybwp_data['opt-checkbox-stickyheader'] ) ) {
		wp_register_script('waypoints', get_template_directory_uri() . '/library/_scripts/waypoints.js', 'jquery', '2.0.2', TRUE);
		wp_register_script('waypoints-sticky', get_template_directory_uri() . '/library/_scripts/waypoints-sticky.js', 'jquery', '1.4', TRUE);
	}

	wp_register_script( 'yb-js', get_stylesheet_directory_uri() . '/library/_scripts/scripts.js', array( 'jquery' ), '', true );

	/* ------------------------------------------------------------------------ */
	/* Enqueue Scripts */
	/* ------------------------------------------------------------------------ */
	wp_enqueue_script('jquery');

	wp_enqueue_script('modernizr');

	wp_enqueue_script('shortcodes');

	// if( !empty($ybwp_data['opt-text-social-twitter'] ) ) {
	// 	wp_enqueue_script('twitter');
	// }

	// if ( $data['check_portfoliotype'] == true ) {
	// 	wp_enqueue_script('isotope');
	// }

	if ( !empty($ybwp_data['opt-checkbox-stickyheader'] ) ) {
		wp_enqueue_script('waypoints');
		wp_enqueue_script('waypoints-sticky');
	}

	wp_enqueue_script( 'yb-js' );

	/* ------------------------------------------------------------------------ */
	/* Localize ajax script - Uncomment if needed! */
	/* ------------------------------------------------------------------------ */
	// wp_localize_script( 'yb-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'yb_scripts_basic' );

function yb_styles_basic() {
	global $ybwp_data;

	/* ------------------------------------------------------------------------ */
	/* Register Stylesheets */
	/* ------------------------------------------------------------------------ */
	// register main stylesheet
	wp_register_style( 'yb-stylesheet', get_stylesheet_directory_uri() . '/library/css/screen.css', array(), '', 'all' );
	wp_register_style( 'yb-options-stylesheet', get_stylesheet_directory_uri() . '/library/css/options-styles.css', array(), '', 'all' );

	// ie-only style sheet
 	wp_register_style( 'yb-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );

	// if ( $data['check_flexslider'] == true ) {
	// 	wp_register_style( 'flexslider-css', get_stylesheet_directory_uri() . '/library/_scripts/flexslider/flexslider.css', array(), '' );
	// }

	if (class_exists('Woocommerce')) {
		wp_register_style( 'woocommerce', get_template_directory_uri() . '/library/css/woocommerce.css', array(), '1', 'all' );
	}

	/* ------------------------------------------------------------------------ */
	/* Enqueue Stylesheets */
	/* ------------------------------------------------------------------------ */

	wp_enqueue_style( 'yb-stylesheet' );
	wp_enqueue_style( 'yb-options-stylesheet' );
	wp_enqueue_style('yb-ie-only');

	// if ( $data['check_flexslider'] == true ) {
	// 	wp_enqueue_style( 'flexslider-css' );
	// }

	if (class_exists('Woocommerce')){
		wp_enqueue_style( 'woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'yb_styles_basic', 1 );

// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
function yb_ie_conditional( $tag, $handle ) {
	if ( 'yb-ie-only' == $handle )
		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	return $tag;
}
// ie conditional wrapper
add_filter( 'style_loader_tag', 'yb_ie_conditional', 10, 2 );

// add ie conditional html5 shim to header
function add_ie_html5_shim () {
    echo '<!--[if lt IE 9]>';
    echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
    echo '<![endif]-->';
}
add_action('wp_head', 'add_ie_html5_shim');

?>