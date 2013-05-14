<?php
/*
Plugin Name: WP Retina 2x
Plugin URI: http://www.meow.fr/wp-retina-2x
Description: Your website will look beautiful and smooth on Retina displays.
Version: 0.9.6
Author: Jordy Meow
Author URI: http://www.meow.fr

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html

Originally developed for two of my websites: 
- Totoro Times (http://www.totorotimes.com) 
- Haikyo (http://www.haikyo.org)
*/

/**
 *
 * @author      Jordy Meow  <http://www.meow.fr>
 * @package     Wordpress
 * @subpackage	Administration
 *
 */

//error_reporting(E_ALL);

add_action( 'admin_menu', 'wr2x_admin_menu' );
add_action( 'wp_enqueue_scripts', 'wr2x_wp_enqueue_scripts' );
add_action( 'admin_head', 'wr2x_admin_head' );
add_filter( 'wp_generate_attachment_metadata', 'wr2x_wp_generate_attachment_metadata' );
add_action( 'delete_attachment', 'wr2x_delete_attachment' );
add_filter( 'update_option', 'wr2x_update_option' );
add_filter( 'generate_rewrite_rules', 'wr2x_generate_rewrite_rules' );
add_action( 'plugins_loaded', 'wr2x_init' );

register_deactivation_hook( __FILE__, 'wr2x_deactivate' );
register_activation_hook( __FILE__, 'wr2x_activate' );

require('wr2x_functions.php');
require('wr2x_settings.php');
require('wr2x_ajax.php');
require('jordy_meow_footer.php');

if ( !wr2x_getoption( "hide_retina_dashboard", "wr2x_advanced", false ) )
	require('wr2x_retina-dashboard.php');

if ( !wr2x_getoption( "hide_retina_column", "wr2x_advanced", false ) )
	require('wr2x_media-library.php');

function wr2x_init() {
	load_plugin_textdomain( 'wp-retina-2x', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 *
 * ISSUES CALCULATION AND FUNCTIONS
 *
 */ 

 
// UPDATE THE ISSUE STATUS OF THIS ATTACHMENT
function wr2x_update_issue_status( $attachmentId, $issues = null, $info = null ) {
	if ( wr2x_is_ignore( $attachmentId ) )
		return;
	if ( $issues == null )
		$issues = wr2x_get_issues();
	if ( $info == null )
		$info = wr2x_retina_info( $attachmentId );
	$consideredIssue = in_array( $attachmentId, $issues );
	$realIssue = wr2x_info_has_issues( $info );
	if ( $consideredIssue && !$realIssue )
		wr2x_remove_issue( $attachmentId );
	else if ( !$consideredIssue && $realIssue )
		wr2x_add_issue( $attachmentId );
	return $realIssue;
}
 
function wr2x_get_issues() {
	$issues = get_transient( 'wr2x_issues' );
	if ( !$issues || !is_array( $issues ) ) {
		$issues = array();
		set_transient( 'wr2x_issues', $issues );
	}
	return $issues;
}
 
// CHECK IF THE 'INFO' OBJECT CONTAINS ISSUE (RETURN TRUE OR FALSE)
function wr2x_info_has_issues( $info ) {
	foreach ( $info as $aindex => $aval ) {
		if ( is_array( $aval ) || $aval == 'PENDING' )
			return true;
	}
	return false;
}

function wr2x_calculate_issues() {
	global $wpdb;
	$postids = $wpdb->get_col( $wpdb->prepare ( "
		SELECT p.ID
		FROM $wpdb->posts p
		WHERE post_status = 'inherit'
		AND post_type = 'attachment'
		AND ( post_mime_type = 'image/jpeg' OR
			post_mime_type = 'image/png' OR
			post_mime_type = 'image/gif' )
	", 0, 0 ) );
	$issues = array();
	foreach ( $postids as $id ) {
		$info = wr2x_retina_info( $id );
		if ( wr2x_info_has_issues( $info ) )
			array_push( $issues, $id );
	}
	set_transient( 'wr2x_ignores', array() );
	set_transient( 'wr2x_issues', $issues );
}

function wr2x_add_issue( $attachmentId ) {
	if ( wr2x_is_ignore( $attachmentId ) )
		return;
	$issues = wr2x_get_issues();
	if ( !in_array( $attachmentId, $issues ) ) {
		array_push( $issues, $attachmentId );
		set_transient( 'wr2x_issues', $issues );
	}
	return $issues;
}

function wr2x_remove_issue( $attachmentId, $onlyIgnore = false ) {
	$issues = array_diff( wr2x_get_issues(), array( $attachmentId ) );
	set_transient( 'wr2x_issues', $issues );
	if ( !$onlyIgnore )
		wr2x_remove_ignore( $attachmentId );
	return $issues;
}

// IGNORE

function wr2x_get_ignores( $force = false ) {
	$ignores = get_transient( 'wr2x_ignores' );
	if ( !$ignores || !is_array( $ignores ) ) {
		$ignores = array();
		set_transient( 'wr2x_ignores', $ignores );
	}
	return $ignores;
}

function wr2x_is_ignore( $attachmentId ) {
	$ignores = wr2x_get_ignores();
	return in_array( $attachmentId, wr2x_get_ignores() );
}

function wr2x_remove_ignore( $attachmentId ) {
	$ignores = wr2x_get_ignores();
	$ignores = array_diff( $ignores, array( $attachmentId ) );
	set_transient( 'wr2x_ignores', $ignores );
	return $ignores;
}

function wr2x_add_ignore( $attachmentId ) {
	$ignores = wr2x_get_ignores();
	if ( !in_array( $attachmentId, $ignores ) ) {
		array_push( $ignores, $attachmentId );
		set_transient( 'wr2x_ignores', $ignores );
	}
	wr2x_remove_issue( $attachmentId, true );
	return $ignores;
}
	
/**
 *
 * WP RETINA 2X CORE
 *
 */

function wr2x_admin_menu() {
	add_options_page( 'WP Retina 2x', 'WP Retina 2x', 'manage_options', 'wr2x_settings', 'wr2x_settings_page' );
}

function wr2x_get_image_sizes() {
	$sizes = array();
	global $_wp_additional_image_sizes;
	foreach (get_intermediate_image_sizes() as $s) {
		$crop = false;
		if (isset($_wp_additional_image_sizes[$s])) {
			$width = intval($_wp_additional_image_sizes[$s]['width']);
			$height = intval($_wp_additional_image_sizes[$s]['height']);
			$crop = $_wp_additional_image_sizes[$s]['crop'];
		} else {
			$width = get_option($s.'_size_w');
			$height = get_option($s.'_size_h');
			$crop = get_option($s.'_crop');
		}
		$sizes[$s] = array( 'width' => $width, 'height' => $height, 'crop' => $crop );
	}
	return $sizes;
}

function wr2x_is_debug() {
	static $debug = -1;
	if ( $debug == -1 ) {
		$debug = wr2x_getoption( "debug", "wr2x_advanced", false );
	}
	return $debug;
}

function wr2x_log( $data ) {
	if ( wr2x_is_debug() ) {
		$fh = fopen( trailingslashit( WP_PLUGIN_DIR ) . 'wp-retina-2x/wp-retina-2x.log', 'a' );
		fwrite($fh, "{$data}\n");
		fclose($fh);
	}
}

function wr2x_retina_info( $id ) {
	$result = array();
    $meta = wp_get_attachment_metadata($id);
	if ( !isset( $meta, $meta['width'], $meta['height'] ) ) {
		return $result;
	}
	$original_width = $meta['width'];
	$original_height = $meta['height'];
	$available_pixels = $original_width * $original_height;
	$sizes = wr2x_get_image_sizes();
	$required_files = true;
	$originalfile = get_attached_file( $id );
	$pathinfo = pathinfo( $originalfile );
	$basepath = $pathinfo['dirname'];
	$ignore = wr2x_getoption( "ignore_sizes", "wr2x_basics", array() );
	if ( $sizes ) {
		foreach ($sizes as $name => $attr) {
			if ( in_array( $name, $ignore ) ) {
				$result[$name] = 'IGNORED';
				continue;
			}
			// Check if the file related to this size is present
			$pathinfo = null;
			$retina_file = null;
			
			if (isset($meta['sizes'][$name]) && isset($meta['sizes'][$name]['file']) && file_exists( trailingslashit( $basepath ) . $meta['sizes'][$name]['file'] )) {
				$normal_file = trailingslashit( $basepath ) . $meta['sizes'][$name]['file'];
				$pathinfo = pathinfo( $normal_file ) ;
				$retina_file = trailingslashit( $pathinfo['dirname'] ) . $pathinfo['filename'] . '@2x.' . $pathinfo['extension'];
			}
			// None of the file exist
			else {
				$result[$name] = 'MISSING';
				$required_files = false;
				continue;
			}
			
			// The retina file exists
			if ( $retina_file && file_exists( $retina_file ) ) {
				$result[$name] = 'EXISTS';
				continue;
			}
			// The size file exists
			else if ( $retina_file )
				$result[$name] = 'PENDING';
			
			// The retina file exists
			if ( $meta['sizes'][$name]['width'] * 2 >= $original_width || $meta['sizes'][$name]['height'] * 2 >= $original_height ) {
				$required_width = $meta['sizes'][$name]['width'] * 2;
				$required_height = $meta['sizes'][$name]['height'] * 2;
				$required_pixels = $required_width * $required_height;
				$result[$name] = array( 'width' => $meta['sizes'][$name]['width'] * 2, 'height' => $meta['sizes'][$name]['height'] * 2, 'pixels' => $required_pixels );
				
			}			
		}
	}
	return $result;
}
 
function wr2x_delete_attachment( $attach_id ) {
	$meta = wp_get_attachment_metadata( $attach_id );
	wr2x_delete_images( $meta );
	wr2x_remove_issue( $attach_id );
}
 
function wr2x_wp_generate_attachment_metadata( $meta ) {
	if (wr2x_getoption( "auto_generate", "wr2x_basics", false ) == true)
		// Check if the attachment is an image
		if ( $meta && isset( $meta['width'] ) && isset( $meta['height'] ) )
			wr2x_generate_images( $meta );
    return $meta;
}

function wr2x_generate_images( $meta ) {
	require('wr2x_vt_resize.php');
	$sizes = wr2x_get_image_sizes();
	$originalfile = $meta['file'];
	$uploads = wp_upload_dir();
	$pathinfo = pathinfo( $originalfile );
	$original_basename = $pathinfo['basename'];
	$basepath = trailingslashit( $uploads['basedir'] ) . $pathinfo['dirname'];
	$ignore = wr2x_getoption( "ignore_sizes", "wr2x_basics", array() );
	$issue = false;
	wr2x_log("** RETINA INFO FOR ATTACHMENT '{$meta['file']}' **");
	wr2x_log( "- Original: {$original_basename}" );
	foreach ( $sizes as $name => $attr ) {
		if ( in_array( $name, $ignore ) ) {
			wr2x_log( "- {$name} => IGNORED" );
			continue;
		}
		// Is the file related to this size there?
		$pathinfo = null;
		$retina_file = null;
		
		if ( isset( $meta['sizes'][$name] ) && isset( $meta['sizes'][$name]['file'] ) ) {
			$normal_file = trailingslashit( $basepath ) . $meta['sizes'][$name]['file'];
			$pathinfo = pathinfo( $normal_file ) ;
			$retina_file = trailingslashit( $pathinfo['dirname'] ) . $pathinfo['filename'] . '@2x.' . $pathinfo['extension'];
		}
		
		if ( $retina_file && file_exists( $retina_file ) ) {
			wr2x_log( "- {$name}: {$normal_file } -> {$retina_file} => EXISTS" );
			continue;
		}
		if ( $retina_file ) {
			$originalfile = trailingslashit( $pathinfo['dirname'] ) . $original_basename;
			
			// Maybe that new image is exactly the size of the original image.
			// In that case, let's make a copy of it.
			if ( $meta['sizes'][$name]['width'] * 2 == $meta['width'] && $meta['sizes'][$name]['height'] * 2 == $meta['height'] ) {
				wr2x_log( "- {$name}: {$originalfile } -> {$retina_file} => COPY" );
				copy ( $originalfile, $retina_file );
			}
			// Otherwise let's resize (if the original size is big enough).
			else if ( $meta['sizes'][$name]['width'] * 2 <= $meta['width'] && $meta['sizes'][$name]['height'] * 2 <= $meta['height'] ) {
				$image = wr2x_vt_resize( $originalfile, $meta['sizes'][$name]['width'] * 2, 
					$meta['sizes'][$name]['height'] * 2, $retina_file );
			}
			if ( !file_exists( $retina_file ) ) {
				wr2x_log( "- {$name}: {$normal_file} -> {$retina_file} => FAIL" );
				$issue = true;
			}
			else {
				wr2x_log( "- {$name}: {$normal_file} -> {$retina_file} => RESIZE" );
			}
		} else {
			wr2x_log( "- {$name} => MISSING" );
		}
	}
	
	// Checks attachment ID + issues
	$id = wr2x_get_attachment_id( $meta['file'] );
	if ( !$id )
		return $meta;
	if ( $issue )
		wr2x_add_issue( $id );
	else
		wr2x_remove_issue( $id );
    return $meta;
}

function wr2x_delete_images( $meta ) {
	if ( !isset( $meta['sizes'] ) )
		return $meta;
	$sizes = $meta['sizes'];
	if ( !$sizes || !is_array( $sizes ) )
		return $meta;
	$originalfile = $meta['file'];
	$pathinfo = pathinfo( $originalfile );
	$uploads = wp_upload_dir();
	$basepath = trailingslashit( $uploads['basedir'] ) . $pathinfo['dirname'];
	foreach ( $sizes as $name => $attr ) {
		$pathinfo = pathinfo( $attr['file'] );
		$retina_file = $pathinfo['filename'] . '@2x.' . $pathinfo['extension'];
		if ( file_exists( trailingslashit( $basepath ) . $retina_file ) ) {
			unlink( trailingslashit( $basepath ) . $retina_file );
		}
	}
    return $meta;
}

function wr2x_activate() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function wr2x_deactivate() {
	remove_filter( 'generate_rewrite_rules', 'wr2x_generate_rewrite_rules' );
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/**
 *
 * LOAD SCRIPTS IF REQUIRED
 *
 */

function wr2x_wp_enqueue_scripts () {
	$method = wr2x_getoption( "method", "wr2x_advanced", 'retina.js' );
	if ( wr2x_is_debug() )
		wp_enqueue_script( 'debug', plugins_url( '/js/debug.js', __FILE__ ), array(), '0.1', false );
	if ($method == "Retina-Images")
		wp_enqueue_script( 'retina-images', plugins_url( '/js/retina-images.js', __FILE__ ), array(), '1.4.0', false );
	else if ($method == "retina.js")
		wp_enqueue_script( 'retinajs', plugins_url( '/js/retina.js', __FILE__ ), array(), '2012.10.09', true );
}

?>