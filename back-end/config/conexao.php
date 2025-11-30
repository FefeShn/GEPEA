<?php
function getConexao() {
    $host = 'db';
    $db   = 'bd_gepea';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        // erro se não conseguir conectar
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        // fetch como array associativo por padrão
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // desativa a emulação de prepared statements do PDO
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // cria uma nova conexão PDO
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die('Erro de conexão: ' . $e->getMessage());
    }
}
?>
