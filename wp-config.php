<?php
/**
 * WordPress base configuration
 */

// ** MySQL settings - from original project ** //
define('DB_NAME', 'ch6accf14d_gorizont');
define('DB_USER', 'ch6accf14d_gorizont');
define('DB_PASSWORD', 'nuj3iduo');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

/** WordPress database table prefix */
$table_prefix = 'wp_';

/** Authentication keys and salts - regenerate at https://api.wordpress.org/secret-key/1.1/salt/ */
define('AUTH_KEY',         'x/NB9>m[BE+DO3B+|e!$)mD|GBdSgM]}9+fdoN.>|&j>uJ3Pr59:hbX*tk:q_J#N');
define('SECURE_AUTH_KEY',  'uV)yn9Fp<OenY!}?u#`hw;}Y|[9o>s2r5t(vxM$dv_oP/`|wUZ]g*JX)a_2YN2_F');
define('LOGGED_IN_KEY',    '_Jt]-#I!iH/gS{V:eG}Q/~$?7dY8,+%[;BPrT3xt{@+kbzVg(l-sOG}Svk/&,G1x');
define('NONCE_KEY',        '9T#]@zC!>eMOA{+^*0lEwI?-jow8r2h~fB<mP]e.vV|Y#0|w)8<tyU:!1L];OYj|');
define('AUTH_SALT',        'W%*+eO1^L|@Gqf>YZTg_Wx+!4{e6a}28e(D$5&0aE^h)~qXmG>L)5t3S4ufqH7Xb');
define('SECURE_AUTH_SALT', 'NDiCQ4/8^XvAS7>z,q6X;9WNi6R>`0m+&HwB}f?m|-&P2nD8S@X!toK|e9sVt4eY');
define('LOGGED_IN_SALT',   '|c}$QcBdG+V6=f$H0Dy~`V1i@M+l1~O;Hj39ugtgyY8.c_^hnW}Q0Szm}_9cVX1m');
define('NONCE_SALT',       'xbqH2L9D>.k|92f|7+85f5p!tKwzM>S6wG<V8}+Pv*z`|3NLeY_@:+({+xSBMpBS');

/** WordPress debugging mode */
define('WP_DEBUG', false);
define('WP_POST_REVISIONS', false);

/** WordPress memory limit */
define('WP_MEMORY_LIMIT', '256M');

/** Security settings */
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);
define('FORCE_SSL_ADMIN', true);
define('XMLRPC_ENABLED', false);
define('WP_ALLOW_UNFILTERED_UPLOADS', false);
define('AUTH_COOKIE_DAYS', 1);
define('WP_FAIL2BAN_BLOCK_USER_ENUMERATION', true);

/** Automatic updates */
define('WP_AUTO_UPDATE_CORE', 'minor');
define('AUTOMATIC_UPDATER_DISABLED', false);

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
