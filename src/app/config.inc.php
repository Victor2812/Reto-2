<?php

/*
    Este archivo contiene la configuración de la aplicación
*/


/*
    Configuración de seguridad

    !! NO CAMBIAR SI NO ES NECESARIO
*/
ini_set('session.use_strict_mode',  1);
ini_set('session.gc_maxlifetime',   3600); // 1h
ini_set('session.use_trans_sid',    0);
ini_set('session.hash_function',    'sha256');
ini_set('session.name',             'aerobideid');

ini_set('session.cookie_lifetime',  0);
ini_set('session.use_cookies',      1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly',  1);
ini_set('session.cookie_secure',    1);
ini_set('session.cookie_samesite',  'Strict');


/*
    Configuración de la aplicación
*/

define('DB_HOST', 'db');
define('DB_NAME', 'aerbide');
define('DB_USER', 'aerbide');
define('DB_PASS', 'Jm12345');

define('LOGIN_ROUTE', '/login.php');

define('UPLOADS_ROUTE', ' /uploads');
define('UPLOADS_FOLDER', '/var/www/html/uploads');

define('MAX_TAGS_PER_POST', 5);

define('LANGUAGES', [
    'ES' => 'Español',
    'EU' => 'Euskera',
    'EN' => 'English'
]);

define ('LANGUAGE_COOKIE', 'aerbidelang');