<?php

function yb_scripts_basic() {
	global$ybwp_data;

	/* ------------------------------------------------------------------------ */
	/* Register Scripts */
	/* ------------------------------------------------------------------------ */
	wp_register_script('modernizr', get_template_directory_uri() . '/assets/scripts/vendor/modernizr.custom.min.js', 'jquery', '1.0', TRUE);

	// wp_register_script('shortcodes', get_template_directory_uri() . '/assets/scripts/build/shortcodes.min.js', 'jquery', '1.0', TRUE);

	wp_register_script( 'yb-js', get_stylesheet_directory_uri() . '/assets/scripts/build/scripts.min.js', array( 'jquery' ), '', true );

	/* ------------------------------------------------------------------------ */
	/* Enqueue Scripts */
	/* ------------------------------------------------------------------------ */
	wp_enqueue_script('jquery');
	wp_enqueue_script('modernizr');

	// wp_enqueue_script('shortcodes');

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
	wp_register_style( 'yb-stylesheet', get_stylesheet_directory_uri() . '/assets/styles/css/screen.css', array(), '', 'all' );

	// ie-only style sheet
 	wp_register_style( 'yb-ie-only', get_stylesheet_directory_uri() . '/assets/styles/css/ie.css', array(), '' );

	if (class_exists('Woocommerce')) {
		wp_register_style( 'woocommerce', get_template_directory_uri() . '/assets/styles/css/woocommerce.css', array(), '1', 'all' );
	}

	/* ------------------------------------------------------------------------ */
	/* Enqueue Stylesheets */
	/* ------------------------------------------------------------------------ */

	wp_enqueue_style( 'yb-stylesheet' );
	wp_enqueue_style( 'yb-options-stylesheet' );
	wp_enqueue_style('yb-ie-only');

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