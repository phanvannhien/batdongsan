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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'batdongsan');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123456');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'dH2=G5UJ#k>Jd%Kn4jK!=>BcH:xOGV3;CUc@.Z%udqet+g:oo`qCrzd]$@KPSD>p');
define('SECURE_AUTH_KEY',  'CGvPD%awMoz^@-A/(f|$n=f1cet38A86cBgrC62V 7{wTbNG;9|AE=ZMFCQD2ZhT');
define('LOGGED_IN_KEY',    'aV#z2lObGSU*jpx|^)Y=JqqT*}>4Mfy}%lL:}MP8>?:>O/nrcJf3AW^/8u]./qS#');
define('NONCE_KEY',        '1UoD_;KcB|S?^:<F!}|&Wiut$&x%u9{g5~AC1~B*CCkxrf>Ix.gD!T7RjJ`$rDeP');
define('AUTH_SALT',        '-qHoA4H]5nfQ4U`y1yZ#zg>&d{7.>BQPvI/~~fZQZSLt|;#N.8Y1NUxTEM(!;%`$');
define('SECURE_AUTH_SALT', 'L*R.PafBs*K2OKgJ(O<glL]WGHRiLI^&:U_~>4@=x,:u`^W<&=#NsPc4]3=TcK^{');
define('LOGGED_IN_SALT',   'Zh%BM0Kf$7Uf!ocy?{?<KHnw|>ly4{7a%XW#)z:Cv&?wF{R2wD%BN4,=Oa57/+w+');
define('NONCE_SALT',       'kFA9 Du=&e-@xQDe67|_UkhkRGzAX?W)1moj[xGy>.8jKJ1X$K;NgNO6+*mX-!U2');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'vn_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
