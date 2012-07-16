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
define('DB_NAME', 'glump_blog');

/** MySQL database username */
define('DB_USER', 'glump');

/** MySQL database password */
define('DB_PASSWORD', 'K4mp4ng0');

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
define('AUTH_KEY', '3hetHUidhOqCrD3sjSma4K9uRbWIkDrje5Rhf9ZNlUrmXtmqIWvvgCuXe1jQULf4');
define('SECURE_AUTH_KEY', 'NhZ3CIzaPQzrHtry7VDrVwNxCVKhelpIzBwyUzOQMAaNjsGUqEdTHLLTG4IoW2lr');
define('LOGGED_IN_KEY', 'GeyokTURyQIpaJjBoO4K5htQG3o9EiT9e6PnXtSUXNftdJhfBQEd3zt65j9K5Quo');
define('NONCE_KEY', 'v52CqAMEKDlpszrO6X1FV0FnoMijBpxQkvdaooFwfo941BCGdZyequXufBAZh91y');
define('AUTH_SALT', 'SXuH5qrtboeS3bIlXdvwSiI9nKUX9ixGukQdBiLu7sgLgE4aesEbhlh2gVR0nYax');
define('SECURE_AUTH_SALT', 'CxD80v1dI9IbcxGOQbN7y6GiQbYd4kbtIUYAoJQ0dcAQi2GmLg6qttrGrnrptmfl');
define('LOGGED_IN_SALT', 'zb3NKNXsUT36UbJGvEqKleUWN9P5bMFcXel48nd5rL65pWwoL4xAQiIxRdHWuKpq');
define('NONCE_SALT', 'CXZ80wYdsqWaFYYMpa6vq0kFZ30hzuqKJnaHnnYaQzrxczNmjpHzD8zdpaSOq4vZ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
