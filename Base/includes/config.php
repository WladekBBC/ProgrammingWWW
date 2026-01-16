<?php


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'PAWWW');  
define('DB_USER', 'root');        
define('DB_PASS', 'root');                 
define('DB_CHARSET', 'utf8mb4');

define('LAST_PAGE_COOKIE', 'last_page');
define('LAST_PAGE_COOKIE_LIFETIME', 60 * 60 * 24 * 7);
define('LAST_VISIT_COOKIE', 'last_visit');
define('LAST_VISIT_COOKIE_LIFETIME', 60 * 60 * 24 * 365); // 1 rok 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicjalizuj licznik sesji jeśli nie istnieje
if (!isset($_SESSION['page_visits_count'])) {
    $_SESSION['page_visits_count'] = 0;
}




