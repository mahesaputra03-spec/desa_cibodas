<?php
declare(strict_types=1);
session_start();

const DB_HOST = '127.0.0.1';
const DB_NAME = 'desa_cibodas';
const DB_USER = 'root';
const DB_PASS = '';

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
    return $pdo;
}

function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419);
        exit('Permintaan tidak valid.');
    }
}
