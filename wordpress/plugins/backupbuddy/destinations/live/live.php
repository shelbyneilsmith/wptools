<?php
class backupbuddy_live {
	
	private static $_dbqueue = array();
	private static $_liveDestinationID = '';
	
	public static function init() {
		if ( true !== self::_setLiveID() ) { // Live is NOT enabled / set up.
			return false;
		}
		if ( '1' != self::_getOption( 'enabled' ) ) { // NOT enabled although set up.
			return false;
		}
		
		// Comments
		add_action( 'delete_comment',        array( 'backupbuddy_live', 'handle_comment' ) );
		add_action( 'wp_set_comment_status', array( 'backupbuddy_live', 'handle_comment' ) );
		add_action( 'trashed_comment',       array( 'backupbuddy_live', 'handle_comment' ) );
		add_action( 'untrashed_comment',     array( 'backupbuddy_live', 'handle_comment' ) );
		add_action( 'wp_insert_comment',     array( 'backupbuddy_live', 'handle_comment' ) );
		add_action( 'comment_post',          array( 'backupbuddy_live', 'handle_comment' ) );
		add_action( 'edit_comment',          array( 'backupbuddy_live', 'handle_comment' ) );
		
		// Commentmeta
		add_action( 'added_comment_meta',   array( 'backupbuddy_live', 'handle_commentmeta_insert' ), 10, 2 );
		add_action( 'updated_comment_meta', array( 'backupbuddy_live', 'handle_commentmeta' ), 10, 4 );
		add_action( 'deleted_comment_meta', array( 'backupbuddy_live', 'handle_commentmeta' ), 10, 4 );
		
		// Users
		if ( self::_is_main_site() ) {
			add_action( 'user_register',  array( 'backupbuddy_live', 'handle_user' ) );
			add_action( 'password_reset', array( 'backupbuddy_live', 'handle_user' ) );
			add_action( 'profile_update', array( 'backupbuddy_live', 'handle_user' ) );
			add_action( 'user_register',  array( 'backupbuddy_live', 'handle_user' ) );
			add_action( 'deleted_user',   array( 'backupbuddy_live', 'handle_user' ) );
		}
		
		// Usermeta
		if ( self::_is_main_site() ) {
			add_action( 'added_usermeta',  array( 'backupbuddy_live', 'handle_usermeta' ), 10, 4 );
			add_action( 'update_usermeta', array( 'backupbuddy_live', 'handle_usermeta' ), 10, 4 );
			add_action( 'delete_usermÏeta', array( 'backupbuddy_live', 'handle_usermeta' ), 10, 4 );
		}
		
		// Posts
		add_action( 'delete_post',              array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'trash_post',               array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'untrash_post',             array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'edit_post',                array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'save_post',                array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'wp_insert_post',           array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'edit_attachment',          array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'add_attachment',           array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'delete_attachment',        array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'private_to_published',     array( 'backupbuddy_live', 'handle_post' ) );
		add_action( 'wp_restore_post_revision', array( 'backupbuddy_live', 'handle_post' ) );
		
		// Postmeta
		add_action( 'added_post_meta',   array( 'backupbuddy_live', 'handle_post_postmetar' ), 10, 4 );
		add_action( 'update_post_meta',  array( 'backupbuddy_live', 'handle_post_postmeta' ), 10, 4 );
		add_action( 'updated_post_meta', array( 'backupbuddy_live', 'handle_post_postmeta' ), 10, 4 );
		add_action( 'delete_post_meta',  array( 'backupbuddy_live', 'handle_post_postmeta' ), 10, 4 );
		add_action( 'deleted_post_meta', array( 'backupbuddy_live', 'handle_post_postmeta' ), 10, 4 );
		add_action( 'added_postmeta',    array( 'backupbuddy_live', 'handle_postmeta' ), 10, 3 );
		add_action( 'update_postmeta',   array( 'backupbuddy_live', 'handle_postmeta' ), 10, 3 );
		add_action( 'delete_postmeta',   array( 'backupbuddy_live', 'handle_postmeta' ), 10, 3 );
		
		// Links
		add_action( 'edit_link',   array( 'backupbuddy_live', 'handle_link' ) );
		add_action( 'add_link',    array( 'backupbuddy_live', 'handle_link' ) );
		add_action( 'delete_link', array( 'backupbuddy_live', 'handle_link' ) );
		
		// Taxonomy
		add_action( 'created_term',              array( 'backupbuddy_live', 'handle_term' ), 2 );
		add_action( 'edited_terms',              array( 'backupbuddy_live', 'handle_term' ), 2 );
		add_action( 'delete_term',               array( 'backupbuddy_live', 'handle_term' ), 2 );
		add_action( 'edit_term_taxonomy',        array( 'backupbuddy_live', 'handle_term_taxonomy' ) );
		add_action( 'delete_term_taxonomy',      array( 'backupbuddy_live', 'handle_term_taxonomy' ) );
		add_action( 'edit_term_taxonomies',      array( 'backupbuddy_live', 'handle_term_taxonomy' ) );
		add_action( 'add_term_relationship',     array( 'backupbuddy_live', 'handle_term_relationship' ), 10, 2 );
		add_action( 'delete_term_relationships', array( 'backupbuddy_live', 'handle_term_relationship' ), 10, 2 );
		add_action( 'set_object_terms',          array( 'backupbuddy_live', 'set_object_terms_handler' ), 10, 3 );
		
		// Files
		/* NOT SURE IF NEEDED? MAY BE DUPES?
		if ( self::_is_main_site() ) {
			add_action( 'switch_theme',      array( 'backupbuddy_live', 'theme_action_handler' ) );
			add_action( 'activate_plugin',   array( 'backupbuddy_live', 'plugin_action_handler' ) );
			add_action( 'deactivate_plugin', array( 'backupbuddy_live', 'plugin_action_handler' ) );
		}
		add_action( 'wp_handle_upload',  array( 'backupbuddy_live', 'handle_upload' ) );
		*/
		
		// Options
		add_action( 'deleted_option', array( 'backupbuddy_live', 'handle_option' ), 1 );
		add_action( 'updated_option', array( 'backupbuddy_live', 'handle_option' ), 1 );
		add_action( 'added_option',   array( 'backupbuddy_live', 'handle_option' ), 1 );
	} // End init().
	
	
	
	// Handle comment changes.
	public static function handle_comment( $comments ) {
		if ( ! is_array( $comments ) ) {
			$comments = array( $comments );
		}
		foreach ( $comments as $comment_id ) {
			if ( wp_get_comment_status( $comment_id ) != 'spam' ) {
				self::dbqueue( 'comments', 'comment_ID', $comment_id );
				self::dbqueue( 'commentmeta', 'comment_id', $comment_id );
			}
		}
	}
	
	
	
	// Handle user changes.
	public static function handle_userid( $user_or_id ) {
		if ( is_object( $user_or_id ) )
			$user_id = intval( $user_or_id->ID );
		else
			$user_id = intval( $user_or_id );
		if ( ! $user_id ) {
			return;
		}
		self::dbqueue( 'users', 'ID', $user_id );
		self::dbqueue( 'usermeta', 'ID', $user_id );
	}
	
	
	
	// Handle user meta changes.
	public static function usermeta_action_handler( $umeta_id, $user_id, $meta_key, $meta_value='' ) {
		self::dbqueue( 'usermeta', $umeta_id );
	}
	
	
	
	// Handle post changes.
	public static function handle_post( $post_id ) {
		self::dbqueue( 'posts', 'ID', $post_id );
		self::dbqueue( 'postmeta', 'post_id', $post_id );
	}
	
	
	
	public static function handle_link( $link_id ) {
		self::dbqueue( 'links', 'link_id', $link_id );
	}
	
	
	
	// Handle commentmeta changes except adding.
	public static function handle_commentmeta( $meta_ids, $object_id, $meta_key, $meta_value ) {
		if ( ! is_array( $meta_ids ) ) {
			$meta_ids = array( $meta_ids );
		}
		foreach ( $meta_ids as $meta_id ) {
			self::dbqueue( 'commentmeta', 'meta_id', $meta_id );
		}
	}
	
	// Handle commentmeta addition.
	public static function handle_commentmeta_insert( $meta_id, $comment_id=null ) {
		if ( empty( $comment_id ) || wp_get_comment_status( $comment_id ) != 'spam' ) {
			self::dbqueue( 'commentmeta', 'meta_id', $meta_id );
		}
	}
	
	
	
	// Handle postmeta for a post changes.
	public static function handle_post_postmeta( $meta_ids, $object_id, $meta_key, $meta_value ) {
		if ( in_array( $meta_key, self::_getOption( 'postmeta_key_excludes', true ) ) ) {
			return;	
		}
		if ( ! is_array( $meta_ids ) ) {
			$meta_ids = array( $meta_ids );
		}
		foreach ( $meta_ids as $meta_id ) {
			self::dbqueue( 'postmeta', 'meta_id', $meta_id );
		}
	}
	
	
	
	// Handle postmeta changes.
	public static function handle_postmeta( $meta_ids, $post_id = null, $meta_key = null ) {
		if ( in_array( $meta_key, self::_getOption( 'postmeta_key_excludes', true ) ) ) {
			return;	
		}
		if ( ! is_array( $meta_ids ) ) {
			$meta_ids = array( $meta_ids );
		}
		foreach ( $meta_ids as $meta_id ) {
			self::dbqueue( 'postmeta', 'meta_id', $meta_id );
		}
	}
	
	
	
	// Handle term changes.
	public static function handle_term( $term_id, $tt_id = null ) {
		self::dbqueue( 'db', 'term_id', $term_id );
		if ( $tt_id ) {
			self::handle_term_taxonomy( $tt_id );
		}
	}
	
	// Handle term taxonomy changes.
	public static function handle_term_taxonomy( $tt_ids ) {
		if ( ! is_array( $tt_ids ) ) {
			$tt_ids = array( $tt_ids );
		}
		foreach( $tt_ids as $tt_id ) {
			self::dbqueue( 'term_taxonomy', 'term_taxonomy_id', $tt_id );
		}
	}
	
	
	
	// Handle term relationship changes.
	public static function handle_term_relationship( $object_ids, $term_id ) {
		if ( ! is_array( $object_ids ) ) {
			$object_ids = array( $object_ids );
		}
		foreach( $object_ids as $object_id ) {
			self::dbqueue( 'term_relationship', 'object_id', $object_id );
		}
	}
	
	
	
	public static function handle_set_object_terms( $object_id, $terms, $tt_ids ) {
		self::handle_term_relationship( $object_id, $tt_ids );
	}
	
	
	
	public static function handle_option( $option_name ) {
		if ( in_array( $option_name, self::_getOption( 'options_excludes', true ) ) ) {
			return;
		}
		self::dbqueue( 'options', 'option_name', $option_name );
		return $option_name;
	}
	
	
	
	// Handle upload of a file. NOT database portion here.
	public static function handle_upload( $file ) {
		self::filequeue( $file['file'] );
		return $file;
	}
	
	
	
	public static function dbqueue( $table_no_prefix, $column, $value, $timestamp = '' ) {
		if ( '' == $timestamp ) {
			$timestamp = microtime(true);
		}
		self::$_dbqueue[] = array(
			't' => $table_no_prefix,
			'c' => $column,
			'v' => $value,
			'w' => $timestamp
		);
	}
	
	public static function run_dbqueue() {
		print_r( self::$_dbqueue );
		echo '<hr>';
		foreach( self::$_dbqueue as $event ) {
			$sql = self::_render_insert( $event['t'], $event['c'], $event['v'] );
			echo '<pre>' . $sql . '<pre>';
		}
	}
	
	
	public static function get_file_stats( $type ) {
		require_once( pb_backupbuddy::plugin_path() . '/classes/fileoptions.php' );
		
		pb_backupbuddy::status( 'details', 'Fileoptions instance #89.' );
		$statsObj = new pb_backupbuddy_fileoptions( backupbuddy_core::getLogDirectory() . 'live/' . $type . '-' . pb_backupbuddy::$options['log_serial'] . '.txt', $read_only = true, $ignore_lock = true, $create_file = false );
		if ( true !== ( $result = $statsObj->is_ok() ) ) {
			pb_backupbuddy::status( 'error', 'Error #3443794. Unable to create or access fileoptions file for media. Details: `' . $result . '`.' );
			return false;
		}
		pb_backupbuddy::status( 'details', 'Fileoptions data loaded.' );
		
		if ( isset( $statsObj->options['stats'] ) ) {
			return $statsObj->options['stats'];
		} else {
			return false;
		}
	}
	
	/* file_scan()
	 *
	 * Scan all files to find new, deleted, or modified files compared to what has been sent to Live.
	 *
	 */
	public static function process_files( $state = array() ) {
		$start_time = microtime( true );
		
		$state = array_merge( array(
			'current_step'	=> 'update_files_list',
			'step_start' => microtime(true),
			'sha1' => false,
		), $state );
		
		$steps = array(
			'update_files_list', // Updates list of files, adding new files or marking deleted files for deletion.
			'update_files_details', // Updates details of files, including file sizes and hashes.
		);
		
		
		
		
		
		/* STEPS
		 *	1. Generate list of files, leaving stats blank.
		 *	2. Loop through list. Skip anything set to delete. If scantime is too old, calculate filesize, mtime, and optional sha1. Compare with existing values & update them.  If they changed then mark sent to false.
		 *
		 * array[filename] => {
		 *	size
		 *	mtime
		 *	sha1
		 *	scantime
		 *	[sent]
		 *	[delete]
		 * }
		 *
		 */
		
		
		
		
		pb_backupbuddy::status( 'details', 'About to load fileoptions data in create mode.' );
		require_once( pb_backupbuddy::plugin_path() . '/classes/fileoptions.php' );
		pb_backupbuddy::status( 'details', 'Fileoptions instance #88.' );
		$signaturesObj = new pb_backupbuddy_fileoptions( backupbuddy_core::getLogDirectory() . 'live/files-' . pb_backupbuddy::$options['log_serial'] . '.txt', $read_only = false, $ignore_lock = false, $create_file = true );
		if ( true !== ( $result = $signaturesObj->is_ok() ) ) {
			pb_backupbuddy::status( 'error', 'Error #382983. Unable to create or access fileoptions file for media. Details: `' . $result . '`.' );
			return false;
		}
		pb_backupbuddy::status( 'details', 'Fileoptions data loaded.' );
		if ( ! isset( $signaturesObj->options['signatures'] ) ) {
			$signaturesObj->options = array( // Defaults.
				'signatures' => array(),
				'stats' => array(
					'totalFiles' => 0,
					'pendingSend' => 0,
					'pendingDelete' => 0,
				),
			);
		}
		$signatures = &$signaturesObj->options['signatures'];
		
		if ( 'update_files_list' == $state['current_step'] ) {
			self::_process_files_update_files_list( $signaturesObj, self::_getOption( 'file_excludes', true ) );
		} elseif ( 'update_files_details' == $state['current_step'] ) {
		} else {
			
		}
		
		
		
		
		
		
		echo 'Total time: ' . ( microtime(true) - $start_time );
		
	} // End file_scan().
	
	private static function _process_update_files_details( $signaturesObj, $startAt ) {
	} // End _process_update_files_details().
	
	private static function _process_files_update_files_list( $signaturesObj, $excludes ) {
		$start_time = microtime( true );
		pb_backupbuddy::status( 'details', 'Starting to process files; updating files list.' );
		
		// Generate list of files
		$root = ABSPATH;
		$root = rtrim( $root, '/\\' ); // Make sure no trailing slash.
		$root_len = strlen( $root );
		
		$files = (array) pb_backupbuddy::$filesystem->deepglob( $root, $excludes );
		
		// Remove root from path AND remote directories..
		foreach( $files as $i => &$file ) {
			if ( is_dir( $file ) ) { // Don't track directories, only actual files.
				unset( $files[$i] );
				continue 1;
			}
			$file = substr( $file, $root_len );
		}
		
		// Flip array.
		$files = array_flip( $files );
		
		// Check if this file is already in the list or not.
		$filesAdded = 0;
		foreach( $files as $file => $ignoreID ) {
			if ( ! isset( $signaturesObj->options['signatures'][ $file ] ) ) { // File not already in signature list. Add it in with initial values.
				$signaturesObj->options['signatures'][ $file ] = array(
					'a' => time(),
					'm' => 0,
					's' => 0,
					'h' => '',
					'sent' => false,
				);
				$filesAdded++;
				$signaturesObj->options['stats']['pendingSend']++;
				$signaturesObj->options['stats']['totalFiles']++;
				pb_backupbuddy::status( 'details', 'Local file that does not exist remotely found. Adding file `' . $file . '`.' );
			}
		}
		
		// Compare existing files with new scan to see if anything needs deletion.
		$filesDeleted = 0;
		foreach( $signaturesObj->options['signatures'] as $signatureFile => $signatureDetails ) {
			if ( ! isset( $files[ $signatureFile ] ) ) { // File no longer exists in new scan. Mark for deletion.
				$filesDeleted++;
				$signaturesObj->options['signatures'][ $signatureFile ]['delete'] = true;
				$signaturesObj->options['stats']['pendingDelete']++;
				$signaturesObj->options['stats']['totalFiles']--;
				pb_backupbuddy::status( 'details', 'Remote file that no longer exists locally found. Flagging `' . $signatureFile . '` for deletion.' );
			}
		}
		
		echo '<pre>';
		print_r( $signaturesObj->options );
		echo '</pre>';
		
		$signaturesObj->save();
		pb_backupbuddy::status( 'details', 'Signatures saved. Added `' . $filesAdded++ . '` files. Deleted `' . $filesDeleted . '` files. Took `' . ( microtime( true ) - $start_time ) . '` seconds.' );
		
	} // End _process_files_update_files_list().
	
	
	
	/* _setLiveID()
	 *
	 * description
	 *
	 */
	private static function _setLiveID() {
		if ( '' == self::$_liveDestinationID ) {
			foreach( pb_backupbuddy::$options['remote_destinations'] as $destination_id => $destination ) {
				if ( 'live' == $destination['type'] ) {
					self::$_liveDestinationID = $destination_id;
					break;
				}
			}
			if ( '' == self::$_liveDestinationID ) {
				pb_backupbuddy::status( 'error', 'Error #382938932: Fatal error. No Live destination was found configured. Set up BackupBuddy live.' );
				return false;
			}
		}
		return true;
	} // End _setLiveID().
	
	
	
	/* _getOption()
	 *
	 * description
	 *
	 */
	private static function _getOption( $option, $makeArray = false ) {
		if ( true !== self::_setLiveID() ) {
			if ( true == $makeArray ) {
				return array();
			} else {
				return '';
			}
		}
		
		if ( ! isset( pb_backupbuddy::$options['remote_destination'][ self::$_liveDestinationID ][ $option ] ) ) {
			if ( true == $makeArray ) {
				return array();
			} else {
				return '';
			}
		}
		
		$optionValue = pb_backupbuddy::$options['remote_destination'][ self::$_liveDestinationID ][ $option ];
		
		if ( true === $makeArray ) {
			$optionValue = explode( "\n", $optionValue );
			$optionValue = array_map( 'trim', $optionValue );
			return array_filter( $optionValue ); // Removes empty lines.
		} else {
			return $optionValue;
		}
	} // End _getOption().
	
	
	
	/* _render_insert()
	 *
	 * description
	 *
	 */
	private static function _render_insert( $table_no_prefix, $column, $value ) {
		global $wpdb;
		$table = $wpdb->prefix . $table_no_prefix;
		
		$query = "SELECT * FROM `$table` WHERE $column = %s";
		$table_query = $wpdb->get_results( $wpdb->prepare( $query, array( $value ) ), ARRAY_N );
		
		if ( $table_query === false ) {
			pb_backupbuddy::status( 'error', 'ERROR #237273. Unable to retrieve data from table `' . $table . '`. This table may be corrupt (try repairing the database) or too large to hold in memory (increase mysql and/or PHP memory). Check your PHP error log for further errors which may provide further information. Not continuing database dump to insure backup integrity.' );
			return false;
		}
		$tableCount = count( $table_query );
		pb_backupbuddy::status( 'details', 'Got `' . $tableCount . '` rows from `' . $table . '`.' );
		
		$insert_sql = $wpdb->prepare( "DELETE FROM `$table` WHERE $column = %s", array( $value ) ) . ";\n"; // Initially delete everything that matches this query to get ready for insert.
		$columns = $wpdb->get_col_info();
		$num_fields = count( $columns );
		foreach( $table_query as $fetch_row ) {
			$insert_sql .= "INSERT INTO `$table` VALUES(";
			for ( $n=1; $n<=$num_fields; $n++ ) {
				$m = $n - 1;
				
				if ( $fetch_row[$m] === NULL ) {
					$insert_sql .= "NULL, ";
				} else {
					$insert_sql .= "'" . backupbuddy_core::dbEscape( $fetch_row[$m] ) . "', ";
				}
			}
			$insert_sql = substr( $insert_sql, 0, -2 );
			$insert_sql .= ");\n";
			
			/*
			$writeReturn = fwrite( $file_handle, $insert_sql );
			if ( ( false === $writeReturn ) || ( 0 == $writeReturn ) ) {
				pb_backupbuddy::status( 'error', 'Error #549546: Unable to write to SQL file. Return error/bytes written: `' . $writeReturn . '`.' );
				@fclose( $file_handle );
				return false;
			}
			*/
			//$insert_sql = '';
			
		} // end foreach table row.
		return $insert_sql;
	} // End _render_insert().
	
	
	
	private static function _is_main_site() {
		if ( ! function_exists( 'is_main_site' ) || ! self::_is_multisite() ) {
			return true;
		} else {
			return is_main_site();
		}
	} // End _is_main_site().
	
	
	
	private static function _is_multisite() {
		if ( function_exists( 'is_multisite' ) )
			return is_multisite();
		return false;
	}
	
	
} // End class.