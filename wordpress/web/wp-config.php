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

$local_host = $local_host_base; //localhost
$dev_host = $staging_host_base; //dev host
$prod_host = ""; //production host

/**
 * Check for the current environment
 */
if ($_SERVER["HTTP_HOST"] === $project_name.".".$local_host) {
	$db_name = $project_name;
	$user_name = 'root';
	$password = 'root';
	$hostname = 'localhost';
} else if ($_SERVER["HTTP_HOST"] === $project_name.".".$dev_host) {
	$db_name = $dev_db_name;
	$user_name = $dev_user_name;
	$password = $dev_password;
	$hostname = $dev_hostname;
} else if ($_SERVER["HTTP_HOST"] === $prod_host) {
	$db_name = $prod_db_name;
	$user_name = $prod_user_name;
	$password = $prod_password;
	$hostname = $prod_hostname;
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

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define('DISALLOW_FILE_EDIT', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
