<?php
// Lightweight .env loader + PDO factory for support module (movido para back-end/src)
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function support_env_load($path)
{
    if (!is_file($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$k, $v] = array_map('trim', array_pad(explode('=', $line, 2), 2, ''));
        if ($k === '') continue;
        $v = trim($v, "\"' ");
        if (!array_key_exists($k, $_SERVER) && !array_key_exists($k, $_ENV)) {
            putenv("$k=$v");
            $_ENV[$k] = $v;
        }
    }
}

function envv($key, $default = null) {
    $val = getenv($key);
    return $val !== false ? $val : $default;
}

// Tenta carregar .env tanto na raiz do projeto quanto em back-end/
$roots = [
    dirname(__DIR__, 2), // raiz do projeto (..\..)
    dirname(__DIR__),    // back-end
];
foreach ($roots as $root) {
    $envPath = $root . DIRECTORY_SEPARATOR . '.env';
    if (is_file($envPath)) { support_env_load($envPath); break; }
}

function support_db(): PDO
{
    $host = envv('DB_HOST', '127.0.0.1');
    $port = (int) envv('DB_PORT', 3306);
    $name = envv('DB_NAME', 'bd_gepea');
    $user = envv('DB_USER', 'root');
    $pass = envv('DB_PASS', '');

    $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $pdo;
}
