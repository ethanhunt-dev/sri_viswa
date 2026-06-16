<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sri_viswa' );

/** Database username */
define( 'DB_USER', 'bn_wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'EDOTX3Ze7C6t6qjaGloXi6evMh6j7IyKkajaMtzKQIv35Zaw2I5E7mOmYqFE7cNZ' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         't>!&iWkyY,i4SEduu((XK|lK}vrDMTu?K*)k&=s8G(E9R/xSsA!^CNOwD4h`e]`P' );
define( 'SECURE_AUTH_KEY',  'YI xTGCc#v5;]AtkG[a*OzKW_$1Ivrcf lCp.T|1lX~2}.E^p!tR%&Vr[H&dK1<-' );
define( 'LOGGED_IN_KEY',    'zkZw!F_}$X$Ql*[:~}{e9b_@VNc{NP X2o?5O7b!.Wi[Jv-]1sD=[fmNe|N}#nYn' );
define( 'NONCE_KEY',        'aa5@OR)r/&fE_2|V*tWh0^:y/vcm*ta@TY/u*iT!}sjWQb1kxtU}>#+d_vdfg^l)' );
define( 'AUTH_SALT',        'rxOj)q1Rsj/,Lwx3vpb0+s.9G0F.5GYtdqo2QTP8y*1kH>]vzW-/.[H7;)[M#m~O' );
define( 'SECURE_AUTH_SALT', '6jPq s:SsZN|%=hr*AM<~ao#v69SAZPE:iWbxQ~mWoH}Hk`Ssn%Vb+o07&C.n9Z$' );
define( 'LOGGED_IN_SALT',   'EDS*:j5m.W4FDwy?}f/#M{h5L[+^4C5r8kOC.OmJkRr#Xu~jmP35mq=y,~-/R`PU' );
define( 'NONCE_SALT',       'yY:,wIYs_ennV#=s@03{rMF[8uv*se}[HY|!~!#QFd*=xd#,GExBZ+VP-}ed[V d' );

/**#@-*/



/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
 */
if ( defined( 'WP_CLI' ) ) {
	$_SERVER['HTTP_HOST'] = '127.0.0.1';
}

define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

/**
 * Disable pingback.ping xmlrpc method to prevent WordPress from participating in DDoS attacks
 * More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/
 */
if ( !defined( 'WP_CLI' ) ) {
	// remove x-pingback HTTP header
	add_filter("wp_headers", function($headers) {
		unset($headers["X-Pingback"]);
		return $headers;
	});
	// disable pingbacks
	add_filter( "xmlrpc_methods", function( $methods ) {
		unset( $methods["pingback.ping"] );
		return $methods;
	});
}
