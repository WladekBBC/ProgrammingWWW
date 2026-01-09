<?php
require_once __DIR__ . '/config.php';


function get_pdo(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf('mysql:host=127.0.0.1;dbname=PAWWW;charset=utf8mb4');
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die('Błąd połączenia z bazą danych: ' . htmlspecialchars($e->getMessage()));
        }
    }

    return $pdo;
}




