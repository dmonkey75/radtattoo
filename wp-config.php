<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define( 'DB_NAME', 'radtattooph' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'fw%L<AJ-`eE*2=mu9r)D.~Rn5*QrUy%^?@N<x$7m2sEC:/>zzGiQa }`7G?up%Mi' );
define( 'SECURE_AUTH_KEY',  '$MDG],8A7Ci,h1$C[4cTS;+2HH}g(i(P-1Ct}ny-!0R9=A>Q=vqz[QNYP:dn~iC/' );
define( 'LOGGED_IN_KEY',    'xAw=Ij,z/u,?&oT7,oQ=;Wp7sxWMnSPE10Mx)Ag,$|>$%yxA2=2qeJ2t@{kY/.Yj' );
define( 'NONCE_KEY',        'M{ltx;tI&G-WxIa.9[uDZ+z3:Vho%hm52=vE87k+]#:Z%5!Lu?]By4$?7U8_kzLj' );
define( 'AUTH_SALT',        '19j5OQi w8OgAP#}`aSKr.iHTG8vfPqL$qS(ihi lj,Sv__!5 49euUO5A:P>i}h' );
define( 'SECURE_AUTH_SALT', '7{{5M./K|zcSia,kg0u/ys#ZSiUhor_$:*BuC33AowF ~Se5%.,FL+OdWI<IFMQ[' );
define( 'LOGGED_IN_SALT',   'y3i3B;AHhegU`yZMy=i2_MMY91Mt`vui>%8Pr ^[<I>g6s!WR$M8KRmc^}grGzv%' );
define( 'NONCE_SALT',       'u//%}EExCZ5%cVS39f]5sN79I?Uj&D`)3U.Ml2i;`j%<ztMA(I3p&_z+SuR+>/&>' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
