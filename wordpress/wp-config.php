<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

$project_name = '';
$secret_code = '';

$local_host_base = '';
$staging_host_base = '';

$prod_domain = ""; //production domain name

/**
 * Dev Variables
 */
$dev_db_name = '';
$dev_user_name = '';
$dev_password = '';
$dev_hostname = '';

/**
 * Production Variables
 */
$prod_db_name = '';
$prod_user_name = '';
$prod_password = '';
$prod_hostname = '';

/**
 * Check for the current environment
 */
$server_var  = preg_replace('/:.*/','', $_SERVER['HTTP_HOST']);

if ($server_var === $project_name.".".$local_host_base) {
	$db_name = $project_name;
	$user_name = 'root';
	$password = 'root';
	$hostname = 'localhost';
	
	$wp_env = 'development';
} else if ($server_var === $project_name.".".$staging_host_base) {
	$db_name = $dev_db_name;
	$user_name = $dev_user_name;
	$password = $dev_password;
	$hostname = $dev_hostname;
	
	$wp_env = 'staging';
} else if ($server_var === $prod_domain) {
	$db_name = $prod_db_name;
	$user_name = $prod_user_name;
	$password = $prod_password;
	$hostname = $prod_hostname;
	
	$wp_env = 'production';
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $db_name);

/** MySQL database username */
define('DB_USER', $user_name);

/** MySQL database password */
define('DB_PASSWORD', $password);

/** MySQL hostname */
define('DB_HOST', $hostname);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Tell wordpress the working environment **/
define('WP_ENV', $wp_env);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
 
{{salts}}

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = $project_name.$secret_code.'_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');


/* Checks the WP_ENV define and sets up Wordpress depending on the environment */
if ((WP_ENV == 'development') || (WP_ENV == 'staging')) {
	
	$wp_debug = true;
	
	define('WP_POST_REVISIONS', false);

	define('WP_SITEURL', "http://$server_var");
	define('WP_HOME', "http://$server_var");
} else {
	$wp_debug = false;
}

define('WP_DEBUG', $wp_debug);
define('DISALLOW_FILE_EDIT', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');