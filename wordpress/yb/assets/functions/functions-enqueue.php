<?php

function yb_scripts_basic() {
	global$ybwp_data;

	/* register scripts */
	// wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/scripts/vendor/modernizr.custom.min.js', 'jquery', null, TRUE );

	wp_register_script( 'yb-js', get_stylesheet_directory_uri() . '/assets/scripts/build/scripts.min.js', array( 'jquery' ), null, TRUE );

	/* enqueue scripts */
	wp_enqueue_script('jquery');
	//wp_enqueue_script('modernizr');
	wp_enqueue_script( 'yb-js' );

	/* If Mobile menu is set to Offscreen nav */
	if (!empty($ybwp_data['opt-checkbox-mobilemenu']) && $ybwp_data['opt-select-mobilemenutype'] === "offscreen-nav" ) {
		wp_register_script( 'yb-mobilemenu', get_stylesheet_directory_uri() . '/assets/scripts/build/mobilemenu.min.js', array( 'jquery' ), null, FALSE );
		wp_enqueue_script( 'yb-mobilemenu' );
	}

	/* Localize ajax script - Uncomment if needed! */
	/* wp_localize_script( 'yb-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); */
}
add_action( 'wp_enqueue_scripts', 'yb_scripts_basic' );

function yb_styles_basic() {
	global $ybwp_data;

	/* register main stylesheet */
	wp_register_style( 'yb-stylesheet', get_stylesheet_directory_uri() . '/assets/styles/css/screen.css', array(), NULL, 'all' );

	/* ie-only style sheet */
	wp_register_style( 'yb-ie-only', get_stylesheet_directory_uri() . '/assets/styles/css/ie.css', array(), NULL );

	/* enqueue stylesheets */
	if( !empty($ybwp_data['opt-checkbox-dashicons'] ) ) {
		wp_enqueue_style( 'dashicons' );
	}

	wp_enqueue_style( 'yb-stylesheet' );
	wp_enqueue_style( 'yb-options-stylesheet' );
	wp_enqueue_style('yb-ie-only');

	if (class_exists('Woocommerce')){
		wp_register_style( 'woocommerce', get_template_directory_uri() . '/assets/styles/css/woocommerce.css', array(), '1', 'all' );
		wp_enqueue_style( 'woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'yb_styles_basic', 1 );

/* ie conditional wrapper around ie stylesheet */
/* source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/ */
function yb_ie_conditional( $tag, $handle ) {
	if ( 'yb-ie-only' == $handle )
		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	return $tag;
}
add_filter( 'style_loader_tag', 'yb_ie_conditional', 10, 2 );

?>