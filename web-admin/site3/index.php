<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($path !== '/api/users') {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
    exit;
}

if ($method !== 'GET') {
    http_response_code(405);
    header('Allow: GET');
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

function parseDatabaseUrl(string $databaseUrl): array
{
    $parts = parse_url($databaseUrl);

    if ($parts === false) {
        throw new RuntimeException('DATABASE_URL invalide');
    }

    return [
        'host' => $parts['host'] ?? 'db',
        'port' => $parts['port'] ?? 5432,
        'dbname' => isset($parts['path']) ? ltrim($parts['path'], '/') : '',
        'user' => $parts['user'] ?? '',
        'password' => $parts['pass'] ?? '',
    ];
}

try {
    $databaseUrl = getenv('DATABASE_URL');

    if ($databaseUrl !== false && $databaseUrl !== '') {
        $config = parseDatabaseUrl($databaseUrl);
    } else {
        $config = [
            'host' => getenv('POSTGRES_HOST') ?: 'db',
            'port' => (int) (getenv('POSTGRES_PORT') ?: 5432),
            'dbname' => getenv('POSTGRES_DB') ?: 'appdb',
            'user' => getenv('POSTGRES_USER') ?: 'admin',
            'password' => getenv('POSTGRES_PASSWORD') ?: 'admin',
        ];
    }

    if ($config['dbname'] === '') {
        throw new RuntimeException('Nom de base de donnees manquant');
    }

    $dsn = sprintf(
        'pgsql:host=%s;port=%d;dbname=%s',
        $config['host'],
        (int) $config['port'],
        $config['dbname']
    );

    $pdo = new PDO($dsn, $config['user'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $stmt = $pdo->query('SELECT id, nom, email, created_at FROM users ORDER BY id');
    $users = $stmt->fetchAll();

    echo json_encode($users, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erreur interne',
        'message' => $e->getMessage(),
    ]);
}
