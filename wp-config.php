<?php
define('WP_CACHE', true); // Added by WP Rocket
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'goutamboro_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'FlenG+S?ke[*01YRc-cBDAE3Iz%<9v1az<.m|dALg ,:k7i5zVS-1tZGCIGiUSXh' );
define( 'SECURE_AUTH_KEY',  '~Kcn_t>pO!ub|v;h?yR>1QkOI/0]8~cFj_N#q;Z!+E31FPwN)T 2>I=&iES+S;o6' );
define( 'LOGGED_IN_KEY',    '3,7bo|k,nCK^Jhd<2,HL&wJ&=2oVK.o6DO1dv9EE&1wK;@rPA<&FUsy4!i6;TkHR' );
define( 'NONCE_KEY',        '!C*MO/Ugwo]auaK{S[ZPKwhpvrcytKyTck?8M;/= E+B)`<u?mif?}nY&{=2&Rb!' );
define( 'AUTH_SALT',        '95rme_k,Ks3o*0PQN7DkTppG_ 6fQSkK[LdJ|)gb.!crw?[_J`*B6^9w*Lrn|rgn' );
define( 'SECURE_AUTH_SALT', 'ySSpPto^oZ=,>K7O?4 ||LCf@EuLFjv#<FSp+D2p(xlI$1/x O:ra%(5Q}5DkJt ' );
define( 'LOGGED_IN_SALT',   '8B)/0}4b`LGY@f#/Q8@{B~jB(s7d)$@*?S^Ia?N:pS<g/3JS< [GfHk!DKjz>e@l' );
define( 'NONCE_SALT',       '6wvUpZVl!U?FIh;Fd9F!h6RnrkDm!jD<u4},5>L/S@D`C|j:1+:kw#corp0jg1+.' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
