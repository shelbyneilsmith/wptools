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

$project_name = 'ybwp2';
$secret_code = '4d6c024';

$local_host_base = 'stupid.local';
$staging_host_base = 'ybdevel.com';

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

define('SECURE_AUTH_KEY',  '{[9U=2Rn(/<fF ~-!Eg>,=o4A/k96m4C*/)W]]!W*fmr1t^pRL+*|QL}--_-5T&$');
define('AUTH_KEY',         '%AF;i2+`UQX<i1-]Mu&U*9{$+/{|cy-xCKF%>T!-am71e7KTcF~aa.<iVuUPNZgy');
define('SECURE_AUTH_KEY',  '{[9U=2Rn(/<fF ~-!Eg>,=o4A/k96m4C*/)W]]!W*fmr1t^pRL+*|QL}--_-5T&$');
define('LOGGED_IN_KEY',    '4tcTwPppwZge-PqjOTm8,rdJd.4E`8K_%6gJ{*Kszr,]y6CW0,O[X)m:aX5>GoA ');
define('NONCE_KEY',        'sKhXpoUC4-?0Y[HjyP?/C;|Pgvfj$NpN?-|%CLC;4plmy]NaU.6l%M2lj,A/Wl>f');
define('AUTH_SALT',        'gFuQ).?_Z3x{1_UqZ;&`Z)4jW<@PWV*?8-u~BVmV~Kifs7Itno.vZ~}dOX9j<*)3');
define('SECURE_AUTH_SALT', '4U%Se??][|8%aiyo205yn^N2I9_qd9<a>U@;Q>fD^&|1hT;IeV-dwuwYmOC6@3?=');
define('LOGGED_IN_SALT',   '|zK&}~ER,$-kKB?,NTUzOGDv+~8*3A?46>QuQ*U%+w=0O@0k8pq^Sj1?);TFmj/P');
define('NONCE_SALT',       '6Q)&ni-.+<e!1h)Uo2S=CZC$b1F[S|Pw@=LnnP5A*W]^*9V<8XWQ~=-Tswr*?0E8');


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
define( 'WP_DEFAULT_THEME', 'yb' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
