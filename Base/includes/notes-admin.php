<?php
require_once __DIR__ . '/db.php';

/**
 * Funkcje zarządzania notatkami dla administratora
 * 
 * CREATE TABLE notes (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   user_id INT NOT NULL,
 *   title VARCHAR(255) NOT NULL,
 *   body TEXT NOT NULL,
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */

function notes_get_all(): array
{
    $pdo = get_pdo();
    $stmt = $pdo->query(
        'SELECT n.id, n.user_id, n.title, n.body, n.created_at, u.email 
         FROM notes n 
         LEFT JOIN users u ON n.user_id = u.id 
         ORDER BY n.created_at DESC'
    );
    return $stmt->fetchAll();
}

function notes_get_user_notes(int $userId): array
{
    $pdo = get_pdo();
    $stmt = $pdo->prepare(
        'SELECT id, user_id, title, body, created_at 
         FROM notes 
         WHERE user_id = :user_id 
         ORDER BY created_at DESC'
    );
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}

function notes_delete_by_id(int $noteId, ?string &$error): bool
{
    $error = null;
    
    try {
        $pdo = get_pdo();
        $stmt = $pdo->prepare('DELETE FROM notes WHERE id = :id');
        $stmt->execute(['id' => $noteId]);
        return true;
    } catch (PDOException $e) {
        $error = 'Błąd bazy danych: ' . htmlspecialchars($e->getMessage());
        return false;
    }
}

function notes_get_by_id(int $noteId): ?array
{
    $pdo = get_pdo();
    $stmt = $pdo->prepare('SELECT id, user_id, title, body, created_at FROM notes WHERE id = :id');
    $stmt->execute(['id' => $noteId]);
    return $stmt->fetch() ?: null;
}

function notes_count(): int
{
    $pdo = get_pdo();
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM notes');
    $result = $stmt->fetch();
    return (int)($result['count'] ?? 0);
}

function notes_count_by_user(int $userId): int
{
    $pdo = get_pdo();
    $stmt = $pdo->prepare('SELECT COUNT(*) as count FROM notes WHERE user_id = :user_id');
    $stmt->execute(['user_id' => $userId]);
    $result = $stmt->fetch();
    return (int)($result['count'] ?? 0);
}
