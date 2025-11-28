<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data) || !isset($data['ids']) || !is_array($data['ids'])) {
        throw new Exception('JSON inválido.');
    }
    $ids = array_values(array_filter(array_map('intval', $data['ids'])));
    if (empty($ids)) { throw new Exception('Nenhum ID informado.'); }

    $storageBase = realpath(__DIR__ . '/..');
    $deleted = [];
    $notFound = [];

    $sel = $pdo->prepare('SELECT id_arquivo, url_arquivo FROM arquivo WHERE id_arquivo = ?');
    $del = $pdo->prepare('DELETE FROM arquivo WHERE id_arquivo = ?');

    foreach ($ids as $id) {
        $sel->execute([$id]);
        $row = $sel->fetch(PDO::FETCH_ASSOC);
        if (!$row) { $notFound[] = $id; continue; }
        $url = $row['url_arquivo'];
        $abs = realpath($storageBase . DIRECTORY_SEPARATOR . $url);
        if ($abs && strpos($abs, $storageBase) === 0 && is_file($abs)) {
            @unlink($abs);
        }
        $del->execute([$id]);
        $deleted[] = $id;
    }

    echo json_encode(['ok' => true, 'deleted' => $deleted, 'notFound' => $notFound]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
