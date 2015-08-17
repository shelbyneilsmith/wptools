<?php
$project_id = '';

$prod_preview_url_base = '';
$staging_url_base = '';

$prod_domain = '';

/**
 * Check for the current environment
 */
$server_var = "localhost";
if ( isset($_SERVER['HTTP_HOST']) && (isset($_SERVER['SERVER_ADDR'])) ) {
	$server_var  = preg_replace('/:.*/','', $_SERVER['HTTP_HOST']);
}

if ( ( $server_var === $project_id.'.'.$prod_preview_url_base ) || ( $server_var === $prod_domain ) ) {
	$wp_env = 'production';
} else {
	$wp_env = 'development';
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Tell wordpress the working environment **/
define('WP_ENV', $wp_env);

$table_prefix  = '';

# Security Salts, Keys, Etc
__salts__


# Localized Language Stuff
define('WPLANG', '');

/* Checks the WP_ENV define and sets up Wordpress depending on the environment */
$wp_debug = false;
$wp_cache = true;

if(isset($_SERVER['SERVER_ADDR'])) {
	if($server_var !== $prod_domain) {
		if (WP_ENV === 'development') {
			$wp_debug = false;
		}

		$wp_cache = false;
		define('WP_SITEURL', "http://$server_var");
		define('WP_HOME', "http://$server_var");
	} else {
		// define('FORCE_SSL_ADMIN', true);
		// if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
		// 	$_SERVER['HTTPS']='on';
		// } else {
		// 	$_SERVER['HTTPS'] = false;
		// }
		// define('WP_SITE_URI', ($_SERVER["HTTPS"]?"https://":"http://").$_SERVER["HTTP_HOST"]);
		// define('WP_SITEURI', ($_SERVER["HTTPS"]?"https://":"http://").$_SERVER["HTTP_HOST"]);
		// define("WP_CONTENT_URL", WP_SITE_URI . "/wp-content");
	}
}

define('WP_DEBUG', $wp_debug);
define('WP_CACHE', $wp_cache);
define('DISALLOW_FILE_EDIT', true);
define( 'WP_DEFAULT_THEME', 'yb' );

# Plugin License Keys
__plugin_keys__

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

if($server_var === $prod_domain) {
	// wp_cache_set("siteurl_secure", "https://" . $_SERVER["SERVER_NAME"], "options");
	// wp_cache_set("home", WP_SITE_URI, "options");
	// wp_cache_set("siteurl", WP_SITE_URI, "options");
}
