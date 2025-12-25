<?php


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'PAWWW');  
define('DB_USER', 'root');        
define('DB_PASS', 'root');                 
define('DB_CHARSET', 'utf8mb4');


define('LAST_PAGE_COOKIE', 'last_page');
define('LAST_PAGE_COOKIE_LIFETIME', 60 * 60 * 24 * 7); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



