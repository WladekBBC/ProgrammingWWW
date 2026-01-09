<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

// Prosty router podstron
$page = $_GET['page'] ?? 'home';

$allowedPages = [
    'home',
    'steps-mac',
    'steps-windows',
    'gallery',
    'resources',
    'contact',
    'login',
    'register',
    'notes',
];

if (!in_array($page, $allowedPages, true)) {
    $page = 'home';
}

// Ciasteczko z ostatnią odwiedzoną stroną (przykład użycia cookies)
setcookie(LAST_PAGE_COOKIE, $page, time() + LAST_PAGE_COOKIE_LIFETIME, '/');

// Obsługa wylogowania
if ($page === 'login' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    auth_logout();
    header('Location: index.php?page=home');
    exit;
}

require __DIR__ . '/includes/header.php';

// Wczytaj odpowiedni plik podstrony
$pageFile = __DIR__ . '/pages/' . $page . '.php';
if (file_exists($pageFile)) {
    require $pageFile;
} else {
    echo '<main class="container"><section class="card"><h2>Błąd</h2><p>Brak podstrony.</p></section></main>';
}

require __DIR__ . '/includes/footer.php';




