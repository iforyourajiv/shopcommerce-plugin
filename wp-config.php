<?php
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
define( 'DB_NAME', 'wordpresstest' );

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
define('FS_METHOD','direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=Q4z*.eID1QHeDmpAV02Uz*,<wP/so,Q K1J&(q_t^dL42xbjoY~^W=oAKCk/.jU' );
define( 'SECURE_AUTH_KEY',  ':=@}()a$2&Vsb;uT0qy0@^DRQcH:d+mL44nrrKezw.QPR>$b&W(4>/p;YVS{Ke62' );
define( 'LOGGED_IN_KEY',    'mh(_PT0<Oot<V&f1/O}j9ymQax8E5<czj23J1OUy**&VTq<RW|E1)E?wqC%6<X~#' );
define( 'NONCE_KEY',        'u[xBO6Z(ZSdy5%sb!M6DThhjXCr@l5@nG,u,?zVbr(vNzetY8@6}6q<PH4 ikj*S' );
define( 'AUTH_SALT',        '{ c3L+efFdKpRkCDD i&l(BU@`ZWp!si$WE./Qv}WENRV5T9eeyPBT6g,b}i%yOQ' );
define( 'SECURE_AUTH_SALT', '3zK$rc&CFSa:`GPb2XoT%)f*|C{sfKE_`rH,?S)Z<ZmV[HvtgUFYnVPnjAd.+9f=' );
define( 'LOGGED_IN_SALT',   'e)%x<^0`jBH;(0P2Gl/Ind/CM~a<k)6p{nAYZ,`K+v6V:fViKip)B*%VJLbtD4Cf' );
define( 'NONCE_SALT',       'sapLqF&x[:(3DbBY$c0H`SRfz=ciiJt%)&e2QtbNr2>phF0r=8^xM.Itx,@Hn8_.' );

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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
