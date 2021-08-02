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
define( 'AUTH_KEY',         '}.*UFj<nTt$fNHN`a<WcE). z=/kY8ITQ7I0ys/0#?[X~d7Z@~(b+n5MWE,CuG4J' );
define( 'SECURE_AUTH_KEY',  '9ZC8uSx+F{{_{P>/EBe/aD^yt@o.l@(3u_&3xHCXIvqDX+G!HMRlEth.WufAQRg$' );
define( 'LOGGED_IN_KEY',    'a&_.LP<Afl^qpu3A&$z$d<H~`BNj$* yKX].PE7q 8C6Ov45>A86^AjVYLq1t<q ' );
define( 'NONCE_KEY',        ' b)_mA)w-!5BIM5gHZSu.di[jie_?Y}m[a<^cK{aDPACeuntM+YH.=&V#;!YVn?_' );
define( 'AUTH_SALT',        ' UpLyRzLHx^1/v^I9Nn-/9wLSj>T*>j8z5}.[JK!_$M!jv@!:~WX1S#eBw&^raP)' );
define( 'SECURE_AUTH_SALT', 'fX-$f4sol85b`EX/I7!E=[3bQ#}kRLZJrR738&AT%!|O[|ZHYS%)z96F>GX#SUpv' );
define( 'LOGGED_IN_SALT',   'HhO3vkv)]d3tic *9LkwHr9bN`I;0E.IRh:.gjG&BzV`L!3].oe@[?`lu9E`u)VU' );
define( 'NONCE_SALT',       'mnL.i~J$~LPQBdj#d3m/7Mw8_0nD0R]k_}6VpmdS7fL*]*0vsee4bP.-!zV?3Y$~' );

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
