<?php

// DO NOT CALL THIS CLASS DIRECTLY. CALL VIA: pb_backupbuddy_destination in bootstrap.php.

class pb_backupbuddy_destination_stash2 { // Change class name end to match destination name.
	
	const MINIMUM_CHUNK_SIZE = 5; // Minimum size, in MB to allow chunks to be. Anything less will not be chunked even if requested.
	const API_URL = 'https://stash-api.ithemes.com';
	
	public static $destination_info = array(
		'name'			=>		'BackupBuddy Stash v2',
		'description'	=>		'<b>The easiest of all destinations</b> for PHP v5.3.3+; just enter your iThemes login and Stash away! Store your backups in the BackupBuddy cloud safely with high redundancy and encrypted storage.  Supports multipart uploads for larger file support with both bursting and chunking. Active BackupBuddy customers receive <b>free</b> storage! Additional storage upgrades optionally available. <a href="http://ithemes.com/backupbuddy-stash/" target="_blank">Learn more here.</a>',
	);
	
	// Default settings. Should be public static for auto-merging.
	public static $default_settings = array(
		'type'						=>		'stash2',	// MUST MATCH your destination slug. Required destination field.
		'title'						=>		'',			// Required destination field.
		
		'itxapi_username'			=>		'',			// Username to connect to iThemes API.
		'itxapi_token'				=>		'',			// Site token for iThemes API.
		
		'ssl'						=>		'1',		// Whether or not to use SSL encryption for connecting.
		'server_encryption'			=>		'AES256',	// Encryption (if any) to have the destination enact. Empty string for none.
		'max_time'					=>		'',			// Default max time in seconds to allow a send to run for. Set to 0 for no time limit. Aka no chunking.
		'max_burst'					=>		'10',		// Max size in mb of each burst within the same page load.
		'db_archive_limit'			=>		'10',		// Maximum number of db backups for this site in this directory for this account. No limit if zero 0.
		'full_archive_limit' 		=>		'4',		// Maximum number of full backups for this site in this directory for this account. No limit if zero 0.
		'files_archive_limit' 		=>		'4',		// Maximum number of files only backups for this site in this directory for this account. No limit if zero 0.
		'manage_all_files'			=>		'1',		// Allow user to manage all files in Stash? If enabled then user can view all files after entering their password. If disabled the link to view all is hidden.
		'use_packaged_cert'			=>		'0',		// When 1, use the packaged cacert.pem file included with the AWS SDK.
		'disable_file_management'	=>		'0',		// When 1, _manage.php will not load which renders remote file management DISABLED.
		'disabled'					=>		'0',		// When 1, disable this destination.
		'skip_bucket_prepare'		=>		'1',		// Always skip bucket prepare for Stash.
		'stash_mode'				=>		'1',		// Master destination is Stash.
	);
	
	
	
	/*	send()
	 *	
	 *	Send one or more files.
	 *	
	 *	@param		array			$files			Array of one or more files to send.
	 *	@return		boolean|array					True on success, false on failure, array if a multipart chunked send so there is no status yet.
	 */
	public static function send( $settings = array(), $file, $send_id = '', $delete_after = false, $clear_uploads = false ) {
		global $pb_backupbuddy_destination_errors;
		if ( '1' == $settings['disabled'] ) {
			$pb_backupbuddy_destination_errors[] = __( 'Error #48933: This destination is currently disabled. Enable it under this destination\'s Advanced Settings.', 'it-l10n-backupbuddy' );
			return false;
		}
		if ( is_array( $file ) ) {
			$file = $files[0];
		}
		
		$remote_path = self::get_remote_path(); // Has leading and trailng slashes.
		$additionalParams =array(
			'filename' => $remote_path . '/' . basename( $file ),
			'size'     => filesize( $file ),
			'timezone' => get_option('timezone_string')
		);
		$response = self::stashAPI( $settings, 'upload', $additionalParams );
		echo '<pre>';
		print_r( $response );
		echo '</pre>';
		
		
		
		
		
		die();
		
		
		
		
		
		pb_backupbuddy::status( 'details', 'Post-send deletion: ' . $delete_after );
		global $pb_backupbuddy_destination_errors;
		
		if ( !is_array( $files ) ) {
			$files = array( $files );
		}
		if ( $clear_uploads === false ) { // Uncomment the following line to override and always clear.
			//$clear_uploads = true;
		}
		
		$meta = array();
		if ( isset( $settings['meta'] ) ) {
			pb_backupbuddy::status( 'details', 'Meta setting passed. Applying to all files in this pass.' );
			$meta = $settings['meta'];
		}
		$forceRootUpload = false;
		if ( isset( $settings['forceRootUpload'] ) ) {
			$forceRootUpload = $settings['forceRootUpload'];
		}
		
		$itxapi_username = $settings['itxapi_username'];
		$itxapi_password = $settings['itxapi_password'];
		
		if ( true === $forceRootUpload ) {
			pb_backupbuddy::status( 'details', 'Forcing root upload.' );
			$remote_path = '/';
		} else {
			pb_backupbuddy::status( 'details', 'Not forcing root upload. Calculting root path.'  );
			$remote_path = self::get_remote_path( $settings['directory'] ); // Has leading and trailng slashes.
		}
		
		
		pb_backupbuddy::status( 'details', 'Stash remote path set to `' . $remote_path . '`.' );
		
		require_once( dirname( __FILE__ ) . '/lib/class.itx_helper.php' );
		require_once( pb_backupbuddy::plugin_path() . '/_s3lib2/aws-autoloader.php' );
		
		// Stash API talk.
		$stash = new ITXAPI_Helper( pb_backupbuddy_destination_stash::ITXAPI_KEY, pb_backupbuddy_destination_stash::ITXAPI_URL, $itxapi_username, $itxapi_password );
		$manage_data = pb_backupbuddy_destination_stash::get_manage_data( $settings );
		if ( ! is_array( $manage_data['credentials'] ) ) {
			pb_backupbuddy::status( 'error', 'Error #8484383b: Your authentication credentials for Stash failed. Verify your login and password to Stash. You may need to update the Stash destination settings. Perhaps you recently changed your password?' );
			return false;
		}
		
		// Wipe all current uploads.
		/*
		if ( $clear_uploads === true ) {
			pb_backupbuddy::status( 'details', 'Clearing any current uploads via Stash call to `abort-all`.' );
			$abort_url = $stash->get_upload_url(null, 'abort-all');
			$request = new RequestCore($abort_url);
			try {
				$response = $request->send_request( true );
			} catch (Exception $e) {
				$error = 'Error #237836: Unable to clear Stash quota information. Details:`' . $e->getMessage() . '`.';
				pb_backupbuddy::status( 'error', $error );
				echo $error;
				return false;
	        }
		}
		*/
		
		delete_transient( 'pb_backupbuddy_stash2quota_' . $settings['itxapi_username'] ); // Delete quota transient since it probably has changed now.
		
		
		
		
		// Success if we made it this far.
		return true;
		
	} // End send().
	
	
	
	public static function test( $settings ) {
		
		// Try sending a file.
		$send_response = pb_backupbuddy_destinations::send( $settings, dirname( dirname( __FILE__ ) ) . '/remote-send-test.php', $send_id = 'TEST-' . pb_backupbuddy::random_string( 12 ) ); // 3rd param true forces clearing of any current uploads.
		if ( false === $send_response ) {
			$send_response = 'Error sending test file to Stash (v2).';
		} else {
			$send_response = 'Success.';
		}
		
		
		
		
		die();
		
		
		
		
		
		// Delete sent file.
		$delete_response = 'Success.';
		$delete_response = self::delete( 'remote-send-test.php' );
		if ( !$delete_response->isOK() ) {
			$delete_response = 'Unable to delete test Stash file `remote-send-test.php`. Details: `' . print_r( $response, true ) . '`.';
			pb_backupbuddy::status( 'details', $delete_response );
		} else {
			$delete_response = 'Success.';
		}
		
		// Load destination fileoptions.
		pb_backupbuddy::status( 'details', 'About to load fileoptions data.' );
		require_once( pb_backupbuddy::plugin_path() . '/classes/fileoptions.php' );
		pb_backupbuddy::status( 'details', 'Fileoptions instance #223.' );
		$fileoptions_obj = new pb_backupbuddy_fileoptions( backupbuddy_core::getLogDirectory() . 'fileoptions/send-' . $send_id . '.txt', $read_only = false, $ignore_lock = false, $create_file = false );
		if ( true !== ( $result = $fileoptions_obj->is_ok() ) ) {
			pb_backupbuddy::status( 'error', __('Fatal Error #9034.828238. Unable to access fileoptions data.', 'it-l10n-backupbuddy' ) . ' Error: ' . $result );
			return false;
		}
		pb_backupbuddy::status( 'details', 'Fileoptions data loaded.' );
		$fileoptions = &$fileoptions_obj->options;
		
		if ( ( 'Success.' != $send_response ) || ( 'Success.' != $delete_response ) ) {
			$fileoptions['status'] = 'failure';
			
			$fileoptions_obj->save();
			unset( $fileoptions_obj );
			
			return 'Send details: `' . $send_response . '`. Delete details: `' . $delete_response . '`.';
		} else {
			$fileoptions['status'] = 'success';
			$fileoptions['finish_time'] = microtime(true);
		}
		
		$fileoptions_obj->save();
		unset( $fileoptions_obj );
		
		return true;
		
	} // End test().
	
	
	
	/* stashAPI()
	 *
	 * Communicate with the Stash API.
	 *
	 * @param	array 			$settings	Destination settings array.
	 * @param	string			$action		API verb/action to call.
	 * @return	array|string				Array with response data on success. String with error message if something went wrong. Auto-logs all errors to status log.
	 */
	public static function stashAPI( $settings, $action, $additionalParams = array() ) {
		global $wp_version;
		
		$url_params = array(
			'action'    => $action,
			'user'      => $settings['itxapi_username'],
			'wp'        => $wp_version,
			'site'      => site_url(),
			'timestamp' => time()
		);
		
		if ( isset( $settings['itxapi_password' ] ) ) { // Used on initital connection to  
			$params = array( 'auth_token' => $settings['itxapi_password'] ); // itxapi_password is a HASH of user's password.
		} elseif ( isset( $settings['itxapi_token' ] ) ) { // Used on initital connection to  
			$params = array( 'token' => $settings['itxapi_token'] ); // itxapi_password is a HASH of user's password.
		} else {
			$error = 'BackupBuddy Error #438923983: No valid token (itxapi_token) or hashed password (itxapi_password) specified. This should not happen.';
			pb_backupbuddy::status( 'error', $error );
			trigger_error( $error, E_USER_NOTICE );
			return $error;
		}
		
		$params = array_merge( $params, $additionalParams );
		
		$post_url = self::API_URL . '/?' . http_build_query( $url_params, null, '&' );
		$http_data = array(
			'method' => 'POST',
			'timeout' => 15,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'body' => array( 'request' => json_encode( $params ) ),
			'cookies' => array()
		);
		
		$response = wp_remote_post(
			$post_url,
			$http_data
		);
		
		/*
		echo 'POST URL: ' .$post_url . '<br>';
		echo '<pre>';
		print_r( $http_data );
		echo '</pre>';
		*/
		
		if ( is_wp_error( $response ) ) {
			$error = 'Error #3892774: `' . $response->get_error_message() . '`.';
			pb_backupbuddy::status( 'error', $error );
			return $error;
		} else {
			if ( null !== ( $response_decoded = json_decode( $response['body'], true  ) ) ) {
				if ( isset( $response_decoded['error'] ) ) {
					if ( isset( $response_decoded['error']['message'] ) ) {
						return $response_decoded['error']['message'];
					} else {
						return 'Error #3823973. Received Stash API error but no message found. Details: `' . print_r( $response_decoded, true ) . '`.';
					}
				} else {
					/*
					echo 'Response: ';
					echo '<pre>';
					print_r( $response_decoded );
					echo '</pre>';
					*/
					return $response_decoded;
				}
			} else {
				$error = 'Error #8393833: Unexpected server response: `' . htmlentities( $response['body'] ) . '`.';
				pb_backupbuddy::status( 'error', $error );
				return $error;
			}
		}
	} // End stashAPI().
	
	
	
	/* get_quota()
	 *
	 * Get Stash quota.
	 *
	 */
	public static function get_quota( $settings, $bypass_cache = false ) {
		$cache_time = 60*5; // 5 minutes.
		$bypass_cache = true;
		
		if ( false === $bypass_cache ) {
			$transient = get_transient( 'pb_backupbuddy_stash2quota_' . $settings['itxapi_username'] );
			if ( $transient !== false ) {
				pb_backupbuddy::status( 'details', 'Stash quota information CACHED. Returning cached version.' );
				return $transient;
			}
		} else {
			pb_backupbuddy::status( 'details', 'Stash bypassing cached quota information. Getting new values.' );
		}
		
		// Contact API.
		$quota_data = self::stashAPI( $settings, 'quota' );
		
		/*
		echo "QUOTARESULTS:";
		echo '<pre>';
		print_r( $quota_data );
		echo '</pre>';
		*/
		
		if ( ! is_array( $quota_data ) ) {
			return false;
		} else {
			set_transient( 'pb_backupbuddy_stash2quota_' . $settings['itxapi_username'], $quota_data, $cache_time );
			return $quota_data;
		}
		
	} // End get_quota().
	
	
	
	/*	get_manage_data()
	 *	
	 *	Get the required credentials and management data for managing user files.
	 *	
	 *	@param		array	$settings		Destination settings.
	 *	@param		bool	$hideAuthAlert	Default: false. Whether or not to suppress an alert box if authentication is failing. Useful for showing a more friendly message for that common error, or a re-auth form.
	 *	@return		false|array				Boolean false on failure. Array of data on success.
	 */
	public static function get_manage_data( $settings, $suppressAuthAlert = false ) {
		
		$remote_path = self::get_remote_path(); // Has leading and trailng slashes.
		
		array( 'token'    => SITE_TOKEN,
			'filename' => $remote_path . '/uploadtest.jpg',
			'size'     => '329041',
			'timezone' => 'America/Chicago'
		);
		
		return $manage_data;
	} // End get_manage_data().
	
	
	
	/*	get_remote_path()
	 *	
	 *	Returns the site-specific remote path to store into.
	 *	Slashes (caused by subdirectories in url) are replaced with underscores.
	 *	Always has a leading and trailing slash.
	 *	
	 *	@return		string			Ex: /dustinbolton.com_blog/
	 */
	public static function get_remote_path( $directory = '' ) {
		
		$remote_path = site_url();
		$remote_path = str_ireplace( 'http://', '', $remote_path );
		$remote_path = str_ireplace( 'https://', '', $remote_path );
		
		//$remote_path = preg_replace('/[^\da-z]/i', '_', $remote_path );
		
		$remote_path = str_ireplace( '/', '_', $remote_path );
		$remote_path = str_ireplace( '~', '_', $remote_path );
		$remote_path = str_ireplace( ':', '_', $remote_path );
		
		$remote_path = '/' . trim( $remote_path, '/\\' ) . '/';
		
		$directory = trim( $directory, '/\\' );
		if ( $directory != '' ) {
			$remote_path .= $directory . '/';
		}
		
		return $remote_path;
		
	} // End get_remote_path().
	
	
	
	
	/*	get_quota_bar()
	 *	
	 *	Returns the progress quota bar showing usage.
	 *	
	 *	@return		string			HTML for the quota bar.
	 */
	public static function get_quota_bar( $account_info ) {
		//echo '<pre>' . print_r( $account_info, true ) . '</pre>';
		
		$return = '<div class="backupbuddy-stash2-quotawrap">';
		$return .= '
		<style>
			.outer_progress {
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				-khtml-border-radius: 4px;
				border-radius: 4px;
				
				border: 1px solid #DDD;
				background: #EEE;
				
				max-width: 700px;
				
				margin-left: auto;
				margin-right: auto;
				
				height: 30px;
			}
			
			.inner_progress {
				border-right: 1px solid #85bb3c;
				background: #8cc63f url("' . pb_backupbuddy::plugin_url() . '/destinations/stash/progress.png") 50% 50% repeat-x;
				
				height: 100%;
			}
			
			.progress_table {
				color: #5E7078;
				font-family: "Open Sans", Arial, Helvetica, Sans-Serif;
				font-size: 14px;
				line-height: 20px;
				text-align: center;
				
				margin-left: auto;
				margin-right: auto;
				margin-bottom: 20px;
				max-width: 700px;
			}
		</style>';
		
		if ( isset( $account_info['quota_warning'] ) && ( $account_info['quota_warning'] != '' ) ) {
			//echo '<div style="color: red; max-width: 700px; margin-left: auto; margin-right: auto;"><b>Warning</b>: ' . $account_info['quota_warning'] . '</div><br>';
		}
		
		$return .= '
		<div class="outer_progress">
			<div class="inner_progress" style="width: ' . $account_info['quota_used_percent'] . '%"></div>
		</div>
		
		<table align="center" class="progress_table">
			<tbody><tr align="center">
			    <td style="width: 10%; font-weight: bold; text-align: center">Free Tier</td>
			    <td style="width: 10%; font-weight: bold; text-align: center">Paid Tier</td>        
			    <td style="width: 10%"></td>
			    <td style="width: 10%; font-weight: bold; text-align: center">Total</td>
			    <td style="width: 10%; font-weight: bold; text-align: center">Used</td>
			    <td style="width: 10%; font-weight: bold; text-align: center">Available</td>        
			</tr>

			<tr align="center">
			    <td style="text-align: center">' . $account_info['quota_free_nice'] . '</td>
			    <td style="text-align: center">';
			    if ( $account_info['quota_paid'] == '0' ) {
			    	$return .= 'none';
			    } else {
			    	$return .= $account_info['quota_paid_nice'];
			    }
			    $return .= '</td>
			    <td></td>
			    <td style="text-align: center">' . $account_info['quota_total_nice'] . '</td>
			    <td style="text-align: center">' . $account_info['quota_used_nice'] . ' (' . $account_info['quota_used_percent'] . '%)</td>
			    <td style="text-align: center">' . $account_info['quota_available_nice'] . '</td>
			</tr>
			';
		$return .= '
		</tbody></table>';
		
		$return .= '<div style="text-align: center;">';
		$return .= '
		<b>' . __( 'Upgrade to more space', 'it-l10n-backupbuddy' ) . ':</b> &nbsp;
		<a href="http://ithemes.com/member/cart.php?action=add&id=290" target="_blank" style="text-decoration: none; font-weight: 300;">+ 5GB</a>, &nbsp;
		<a href="http://ithemes.com/member/cart.php?action=add&id=290" target="_blank" style="text-decoration: none; font-weight: 600; font-size: 1.1em;">+ 10GB</a>, &nbsp;
		<a href="http://ithemes.com/member/cart.php?action=add&id=290" target="_blank" style="text-decoration: none; font-weight: 800; font-size: 1.2em;">+ 25GB</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="https://sync.ithemes.com/stash/" target="_blank" style="text-decoration: none;"><b>Manage Files & Account</b></a>
		';
		$return .= '<br><br></div>';
		
		$return .= '</div>';
		
		return $return;
		
	} // End get_quota_bar().
	
	
	
	/* _formatSettings()
	 *
	 * Called by _formatSettings().
	 *
	 */
	public static function _formatSettings( $settings ) {
		$settings['skip_bucket_prepare'] = '1';
		$settings['stash_mode'] = '1';
		return pb_backupbuddy_destination_s32::_formatSettings( $settings );
	} // End _formatSettings().
	
	
	
	public static function listFiles( $settings, $prefix ) {
		/*
		echo 'listfilesSettings<pre>';
		print_r( $settings );
		echo '</pre>';
		*/
		
		$settings = self::_formatSettings( $settings );
		
		$remote_path = self::get_remote_path(); // Has leading and trailng slashes.
		$additionalParams =array();
		$files = self::stashAPI( $settings, 'files', $additionalParams );
		return $files;
		//$prefix = $manage_data['subkey'] . '/' . ltrim( $prefix, '\\/' );
		
		//$settings['bucket'] = $manage_data['bucket'];
		//$settings['credentials'] = $manage_data['credentials'];
		
		/*
		echo 'Manage_data:<pre>';
		print_r( $manage_data );
		echo '</pre>';
		*/
		
		//return pb_backupbuddy_destination_s32::listFiles( $settings, $prefix );
	} // End listFiles().
	
	
	
	/* deleteFile()
	 *
	 * description
	 *
	 */
	public static function deleteFile( $settings, $file ) {
		self::deleteFiles( $settings, $file );
	} // End deleteFile().
	
	
	
	/* deleteFiles()
	 *
	 * description
	 *
	 */
	public static function deleteFiles( $settings, $files ) {
		$settings = self::_formatSettings( $settings );
		
		$remote_path = self::get_remote_path(); // Has leading and trailng slashes.
		$additionalParams =array();
		$manage_data = self::stashAPI( $settings, 'manage', $additionalParams );
		$settings['bucket'] = $manage_data['bucket'];
		$settings['credentials'] = $manage_data['credentials'];
		
		foreach( $files as &$file ) {
			$file = $manage_data['subkey'] . $remote_path . $file;
		}
		
		echo '<br>Delete: ' . $file . '<br>';
		
		print_r( $files );
		return pb_backupbuddy_destination_s32::deleteFiles( $settings, $files );
	} // End deleteFiles().
	
	
	
	public static function archiveLimit( $settings, $backup_type ) {
		pb_backupbuddy::status( 'error', 'Error #8339832893: TODO archiveLimit().' );
		return true;
	} // End archiveLimit();
	
	
	
} // End class.