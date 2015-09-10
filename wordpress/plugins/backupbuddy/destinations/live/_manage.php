<?php
// Incoming vars: $destination, $destination_id
if ( isset( $destination['disabled'] ) && ( '1' == $destination['disabled'] ) ) {
	die( __( 'This destination is currently disabled based on its settings. Re-enable it under its Advanced Settings.', 'it-l10n-backupbuddy' ) );
}

wp_enqueue_script( 'thickbox' );
wp_print_scripts( 'thickbox' );
wp_print_styles( 'thickbox' );
?>

<style>
</style>



<?php

/*
$types = array(
	'media',
	'themes',
	'plugins',
	'custom'
);
*/
echo '<br>MediaStats:';
$mediaStats = backupbuddy_live::get_file_stats( 'media' );
print_r( $mediaStats );

echo '<br>ThemeStats:';
$mediaStats = backupbuddy_live::get_file_stats( 'theme' );
print_r( $mediaStats );

echo '<br>PluginStats:';
$mediaStats = backupbuddy_live::get_file_stats( 'plugins' );
print_r( $mediaStats );

echo '<br>CustomStats:';
$mediaStats = backupbuddy_live::get_file_stats( 'custom' );
print_r( $mediaStats );






// Handles thickbox auto-resizing. Keep at bottom of page to avoid issues.
if ( !wp_script_is( 'media-upload' ) ) {
	wp_enqueue_script( 'media-upload' );
	wp_print_scripts( 'media-upload' );
}
