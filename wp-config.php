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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wpwp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'NcQ:]J<o]E[P/t=7tO`yfLFxF;+]x7*bF+Jz(*kxanAmwx(F2P>E*Un0%g<IZ*+~');
define('SECURE_AUTH_KEY',  'K:,`}(Bw!6w}X(ph:fK9L3^+h|^VMKzpByy.H5bXveqVe^GU5EmV1sV.c/iztdzU');
define('LOGGED_IN_KEY',    'W{9isF%fFA;Smq>xqc~<6_4bt>+XLA.1@K{@[553Q)k{Rd84Pyb]<{F{B#k`>!|%');
define('NONCE_KEY',        '@9,tJK%Y*,V!bjWWo:3y}q3/VF8;[LV=*9kvc08r2X8Fe^ o${9Ts%:X?Ez;NK:[');
define('AUTH_SALT',        '`t*.Q,~N6PrR@G2%pL%l/wSV?gNDM|03]>~tLX^FOZuO2iq,-J}Unb17$BWnW[G:');
define('SECURE_AUTH_SALT', '45 gvJMTNODe8nm`Ynaa1a80MO~U)e_5*JQVv|j/F77?wYt};{1YyU/AKi8*@`FD');
define('LOGGED_IN_SALT',   'wunI2})Lf4ML4ugbfhILR,%7uQ`UEmmnGIl%T-w3;jWf*gR+*q3hMzI{srYMWl*v');
define('NONCE_SALT',       'G+{#`|n$SU{1~o.w1ZG>8whq|pi7l4kyg(-Imm4FQ@Q]@G9zsw4}E H~{(}:M(O!');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
