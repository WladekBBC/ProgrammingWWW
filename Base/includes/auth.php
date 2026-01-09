<?php
require_once __DIR__ . '/db.php';

/**
 *
 * CREATE TABLE users (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   email VARCHAR(255) UNIQUE NOT NULL,
 *   password_hash VARCHAR(255) NOT NULL,
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */

function auth_register(string $email, string $password, string $password_confirm, ?string &$error): bool
{
    $error = null;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Nieprawidłowy adres e-mail.';
        return false;
    }
    if (strlen($password) < 6) {
        $error = 'Hasło musi mieć co najmniej 6 znaków.';
        return false;
    }
    if ($password !== $password_confirm) {
        $error = 'Hasła nie są identyczne.';
        return false;
    }

    $pdo = get_pdo();

    // Sprawdź, czy użytkownik już istnieje
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        $error = 'Użytkownik z takim adresem e-mail już istnieje.';
        return false;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare('INSERT INTO users (email, password_hash) VALUES (:email, :hash)');
        $stmt->execute([
            'email' => $email,
            'hash'  => $hash,
        ]);
    } catch (PDOException $e) {
        // Na wszelki wypadek jeśli zadziała constraint UNIQUE (wyścig, itp.)
        if ((int)$e->getCode() === 23000) {
            $error = 'Użytkownik z takim adresem e-mail już istnieje.';
            return false;
        }
        $error = 'Błąd bazy danych przy rejestracji.';
        return false;
    }

    return true;
}

function auth_login(string $email, string $password, bool $remember, ?string &$error): bool
{
    $error = null;

    $pdo = get_pdo();
    $stmt = $pdo->prepare('SELECT id, email, password_hash FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        $error = 'Nieprawidłowy e-mail lub hasło.';
        return false;
    }

    // Logowanie OK – ustaw sesję
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];

    // Ciasteczko „remember me” – zachowawczo tylko e-mail (do wstępnego wypełnienia formularza)
    if ($remember) {
        setcookie('remember_email', $user['email'], time() + 60 * 60 * 24 * 30, '/');
    } else {
        setcookie('remember_email', '', time() - 3600, '/');
    }

    return true;
}

function auth_logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

function auth_is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function auth_current_user_email(): ?string
{
    return $_SESSION['user_email'] ?? null;
}


