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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sidoc');

/** MySQL database username */
define('DB_USER', 'sidoc');

/** MySQL database password */
define('DB_PASSWORD', 'sidoc2017');

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
define('AUTH_KEY',         '#O-6=CF*IU-9o<h$Zn^I9,otALOa[K)Vj8:Aqj]Nzj|59mCjoUt,.F/L#HDa]|[w');
define('SECURE_AUTH_KEY',  'ntLPPsKv=;^8IKxV#%2Er0N=UD&k>)n$P_Z{|yyW 0&}dmfLZ]E+KBX:_7P}Uu<~');
define('LOGGED_IN_KEY',    '0:!K9S[#fkj&>*#Y8hIL>`q) I47y0 Cm$_1!~RK47^=&7BfC8_V>%JsqoU}F!6Z');
define('NONCE_KEY',        '[?xpdya}EQ1N/Q4`g)o1oP.|Q[C6* {Wf,ZhEam%)*z^^xF>X6[%1_zylSmSLqbe');
define('AUTH_SALT',        '2AJ=,^Y~;0[X6W_PdR[m@kA=ea%kA==q*pQ9/MyGE/{qG%lkA*>Dm&%p*Vy>4/O+');
define('SECURE_AUTH_SALT', 'gg:|Uc~5D*!d.3U3!2F+ISS07S5@KG93JBiQqa.11@gR7Xm0Ep<($$.=5d@ N)%:');
define('LOGGED_IN_SALT',   '$MFZsp40p+#2Q,8J5lqYtudo,1#!RcD/%z3(5T!4=r0c>_=pHcO!5rgVMsC2/.*p');
define('NONCE_SALT',       '?~`|N9kvh0nt^giIC( ),7$S3gTxf9nD,0fPCucm)m>1^-OzQ)Ter &e]T){YD![');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'local_';

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
