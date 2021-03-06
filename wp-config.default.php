<?php
/**
 * Default config settings
 *
 * Enter any WordPress config settings that are default to all environments
 * in this file. These can then be overridden in the environment config files.
 *
 * Please note if you add constants in this file (i.e. define statements)
 * these cannot be overridden in environment config files.
 *
 * @package    Studio 24 WordPress Multi-Environment Config
 * @version    1.0
 * @author     Studio 24 Ltd  <info@studio24.net>
 */


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
define('AUTH_KEY',         'OPh[3owEY3f8sQ~vGNq|m|b1by2_ne+*<A^i3tx??`PRs+qSQp-e6|~5MZ%awDmZ');
define('SECURE_AUTH_KEY',  'L>YKg;{tK8-&%[r}!X# }sRc[k&~fiVK-HX3b+7mo=IoUOvO[hJ!(2_#As{$ojRL');
define('LOGGED_IN_KEY',    '=kW|40lUK(_8XvR&@Cqq~/BFMwD7.W+/S9z>|xc|hHSivOWNh[kjV5y=RVkZr%e^');
define('NONCE_KEY',        '0vxr!n>hWMF;k&-1|EGd,P2Wm&&-(sYQj|w$MiFzLyxK=U9YUrs6XeHjo.k4@fBr');
define('AUTH_SALT',        'W]`AZu|Hm3qe-WUZGXWQL4?BY?B&< xDm{!i)Z+/tNFr~6_i~u,pmmR(D jkzXlg');
define('SECURE_AUTH_SALT', '$:Q%1m#uGp)t&i1pw$dKV}m$H8ePsqgR ^Pj<woK!:!/rn:fVvV|g9b -a^ihV:p');
define('LOGGED_IN_SALT',   '(4bV2r735-y6Tlkt*Uh1pmW.]3sV|c6f-MLebCAa!tc5*]G+LrfJV}9MGK)pyw+p');
define('NONCE_SALT',       '+7!bR#cx(.%R7=K+KS|3)z)ImUrk6F$4lh KN3&|T1*#/Sk|1mU><.]U-&*gV#?=');

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
