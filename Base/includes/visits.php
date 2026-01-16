<?php
require_once __DIR__ . '/db.php';

/**
 * Funkcje do zarządzania licznikiem odwiedzin
 * 
 * CREATE TABLE page_visits (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   user_id INT,
 *   page VARCHAR(255) NOT NULL,
 *   ip_address VARCHAR(45),
 *   user_agent TEXT,
 *   visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
 *   KEY (visited_at),
 *   KEY (user_id),
 *   KEY (page)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */
// Ostatnia wizyta użytkownika (ciasteczko)
function visits_set_last_visit_cookie(): void
{
    $now = date('Y-m-d H:i:s');
    setcookie(LAST_VISIT_COOKIE, $now, time() + LAST_VISIT_COOKIE_LIFETIME, '/');
}

function visits_get_last_visit_cookie(): ?string
{
    return $_COOKIE[LAST_VISIT_COOKIE] ?? null;
}

// Licznik wizyt w sesji
function visits_increment_session_counter(): int
{
    if (!isset($_SESSION['page_visits_count'])) {
        $_SESSION['page_visits_count'] = 0;
    }
    $_SESSION['page_visits_count']++;
    return $_SESSION['page_visits_count'];
}

function visits_get_session_counter(): int
{
    return $_SESSION['page_visits_count'] ?? 0;
}

function visits_reset_session_counter(): void
{
    $_SESSION['page_visits_count'] = 0;
}

function visits_log_visit(string $page, ?int $userId = null): void
{
    try {
        $pdo = get_pdo();
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        $stmt = $pdo->prepare(
            'INSERT INTO page_visits (user_id, page, ip_address, user_agent) 
             VALUES (:user_id, :page, :ip_address, :user_agent)'
        );
        $stmt->execute([
            'user_id'    => $userId,
            'page'       => $page,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    } catch (PDOException $e) {
        // Cichy błąd - nie przerywamy działania aplikacji
    }
}

function visits_get_total_visits(): int
{
    $pdo = get_pdo();
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM page_visits');
    $result = $stmt->fetch();
    return (int)($result['count'] ?? 0);
}

function visits_get_visits_today(): int
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT COUNT(*) as count FROM page_visits 
         WHERE DATE(visited_at) = CURDATE()'
    );
    $result = $stmt->fetch();
    return (int)($result['count'] ?? 0);
}

function visits_get_visits_by_page(): array
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT page, COUNT(*) as count 
         FROM page_visits 
         GROUP BY page 
         ORDER BY count DESC'
    );
    return $stmt->fetchAll();
}

function visits_get_visits_by_user(): array
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT u.email, COUNT(pv.id) as count 
         FROM page_visits pv 
         LEFT JOIN users u ON pv.user_id = u.id 
         WHERE pv.user_id IS NOT NULL 
         GROUP BY pv.user_id 
         ORDER BY count DESC 
         LIMIT 10'
    );
    return $stmt->fetchAll();
}

function visits_get_visits_this_week(): int
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT COUNT(*) as count FROM page_visits 
         WHERE visited_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)'
    );
    $result = $stmt->fetch();
    return (int)($result['count'] ?? 0);
}

function visits_get_visits_this_month(): int
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT COUNT(*) as count FROM page_visits 
         WHERE MONTH(visited_at) = MONTH(NOW()) 
         AND YEAR(visited_at) = YEAR(NOW())'
    );
    $result = $stmt->fetch();
    return (int)($result['count'] ?? 0);
}

function visits_get_unique_visitors_today(): int
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT COUNT(DISTINCT ip_address) as count FROM page_visits 
         WHERE DATE(visited_at) = CURDATE()'
    );
    $result = $stmt->fetch();
    return (int)($result['count'] ?? 0);
}

function visits_get_recent_visits(int $limit = 20): array
{
    $pdo = get_pdo();
    $stmt = $pdo->prepare(
        'SELECT pv.id, pv.page, pv.ip_address, pv.visited_at, u.email 
         FROM page_visits pv 
         LEFT JOIN users u ON pv.user_id = u.id 
         ORDER BY pv.visited_at DESC 
         LIMIT :limit'
    );
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function visits_get_user_last_visit(int $userId): ?string
{
    $pdo = get_pdo();
    $stmt = $pdo->prepare(
        'SELECT MAX(visited_at) as last_visit FROM page_visits WHERE user_id = :user_id'
    );
    $stmt->execute(['user_id' => $userId]);
    $result = $stmt->fetch();
    return $result['last_visit'] ?? null;
}

function visits_get_all_users_last_visits(): array
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT u.id, u.email, MAX(pv.visited_at) as last_visit 
         FROM users u 
         LEFT JOIN page_visits pv ON u.id = pv.user_id 
         GROUP BY u.id, u.email 
         ORDER BY last_visit DESC'
    );
    return $stmt->fetchAll();
}
