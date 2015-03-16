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
{{salts}}

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
	}
} else {
	define('WP_SITEURL', "http://$prod_domain");
	define('WP_HOME', "http://$prod_domain");
}

define('WP_DEBUG', $wp_debug);
define('WP_CACHE', $wp_cache);
define('DISALLOW_FILE_EDIT', true);
define( 'WP_DEFAULT_THEME', 'yb' );

# Plugin License Keys
define('GF_LICENSE_KEY','9d511f9fd6bf3992746ccd48d73cc208'); // Gravity Forms License Key

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
