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

/** Authentication keys and salts - generated for production */
define('AUTH_KEY',         'X&7kL9$mP2@qR5#vW8!nY3*Z6aB1cD4eF0gH2iJ5kL8mN1pQ4rS7tU0wX3y');
define('SECURE_AUTH_KEY',  'T6vW9!xY2&zA5#bC8@dE1$fG4*hI7-jK0,lN3.oP6 qS9 tV2 wY5 zA8');
define('LOGGED_IN_KEY',    'bC8!dE1$fG4*hI7-jK0,lN3.oP6 qS9 tV2 wY5 zA8 bC1 dE4 fG7');
define('NONCE_KEY',        'hI7-jK0,lN3.oP6 qS9 tV2 wY5 zA8 bC1 dE4 fG7 hI0 jK3 lN6');
define('AUTH_SALT',        'P6 qS9 tV2 wY5 zA8 bC1 dE4 fG7 hI0 jK3 lN6 oP9 rS2 uV5');
define('SECURE_AUTH_SALT', 'Y5 zA8 bC1 dE4 fG7 hI0 jK3 lN6 oP9 rS2 uV5 wX8 yA1 zB4');
define('LOGGED_IN_SALT',   'C1 dE4 fG7 hI0 jK3 lN6 oP9 rS2 uV5 wX8 yA1 zB4 cD7 eF0');
define('NONCE_SALT',       'G7 hI0 jK3 lN6 oP9 rS2 uV5 wX8 yA1 zB4 cD7 eF0 gH3 iJ6');

/** WordPress debugging mode */
define('WP_DEBUG', false);
define('WP_POST_REVISIONS', false);

/** WordPress memory limit */
define('WP_MEMORY_LIMIT', '256M');

/** Security settings */
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);

/** Automatic updates */
define('WP_AUTO_UPDATE_CORE', 'minor');

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
