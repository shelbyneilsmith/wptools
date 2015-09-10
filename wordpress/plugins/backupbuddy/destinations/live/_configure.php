<?php

$default_name = NULL;
if ( 'add' == $mode ) {
	$default_name = 'BackupBuddy Live';
}
$settings_form->add_setting( array(
	'type'		=>		'text',
	'name'		=>		'title',
	'title'		=>		__( 'Destination name', 'it-l10n-backupbuddy' ),
	'tip'		=>		__( 'Name of the new destination to create. This is for your convenience only.', 'it-l10n-backupbuddy' ),
	'rules'		=>		'required|string[1-45]',
	'default'	=>		$default_name,
) );

/*
$settings_form->add_setting( array(
	'type'		=>		'checkbox',
	'name'		=>		'scan_files',
	'options'	=>		array( 'unchecked' => '0', 'checked' => '1' ),
	'title'		=>		__( 'Scan files for changes', 'it-l10n-backupbuddy' ) . '*',
) );
*/

$settings_form->add_setting( array(
	'type'		=>		'title',
	'name'		=>		'advanced_begin',
	'title'		=>		'<span class="dashicons dashicons-arrow-right"></span> ' . __( 'Advanced Options', 'it-l10n-backupbuddy' ),
	'row_class'	=>		'advanced-toggle-title',
) );




$settings_form->add_setting( array(
	'type'		=>		'textarea',
	'name'		=>		'postmeta_key_excludes',
	'title'		=>		__( 'Postmeta Key Exclusions', 'it-l10n-backupbuddy' ),
	'row_class'	=>		'advanced-toggle',
) );
$settings_form->add_setting( array(
	'type'		=>		'textarea',
	'name'		=>		'options_excludes',
	'title'		=>		__( 'Options Exclusions', 'it-l10n-backupbuddy' ),
	'row_class'	=>		'advanced-toggle',
) );
$settings_form->add_setting( array(
	'type'		=>		'textarea',
	'name'		=>		'file_excludes',
	'title'		=>		__( 'File Exclusions', 'it-l10n-backupbuddy' ),
	'row_class'	=>		'advanced-toggle',
) );

$settings_form->add_setting( array(
	'type'		=>		'checkbox',
	'name'		=>		'disabled',
	'options'	=>		array( 'unchecked' => '0', 'checked' => '1' ),
	'title'		=>		__( 'Disable destination', 'it-l10n-backupbuddy' ),
	'tip'		=>		__( '[Default: unchecked] - When checked, this destination will be disabled and unusable until re-enabled. Use this if you need to temporary turn a destination off but don\t want to delete it.', 'it-l10n-backupbuddy' ),
	'css'		=>		'',
	'after'		=>		'<span class="description"> ' . __('Check to disable this destination until re-enabled.', 'it-l10n-backupbuddy' ) . '</span>',
	'rules'		=>		'',
	'row_class'	=>		'advanced-toggle',
) );