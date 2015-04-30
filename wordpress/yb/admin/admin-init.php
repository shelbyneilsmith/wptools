<?php

/* Required Plugins Setup */
if (file_exists(dirname(__FILE__).'/plugin-init.php')) {
	require_once( dirname(__FILE__).'/plugin-init.php' );
}

/* Load Redux Extensions*/
// if (file_exists(dirname(__FILE__).'/redux-extensions/extensions-init.php')) {
//     require_once( dirname(__FILE__).'/redux-extensions/extensions-init.php' );
// }    

/* Load Redux, installed via Bower */
if (file_exists(dirname(__FILE__).'/bower_components/redux-framework/ReduxCore/framework.php')) {
	require_once( dirname(__FILE__).'/bower_components/redux-framework/ReduxCore/framework.php' );
}

/* Load YB Theme Options */
if (file_exists(dirname(__FILE__).'/options-init.php')) {
	require_once( dirname(__FILE__).'/options-init.php' );
}

/* Admin Functions */
add_action('admin_head', 'remove_redux_clutter');
function remove_redux_clutter() {
	echo '
	<style>
		#redux-share { display:none !important; }
		.rAds span { display:none !important; }
	</style>
	';
}