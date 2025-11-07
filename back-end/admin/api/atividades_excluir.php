<?php
// Exclui uma ou mais atividades
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();

    $raw = file_get_contents('php://input');
    $payload = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $payload = $_POST;
    }

    $ids = [];
    if (isset($payload['ids']) && is_array($payload['ids'])) {
        $ids = array_map('intval', $payload['ids']);
    } elseif (isset($payload['id'])) {
        $ids = [ (int)$payload['id'] ];
    }

    if (empty($ids)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Informe um ou mais IDs.']);
        exit;
    }

    $in  = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("DELETE FROM atividade WHERE id_atividade IN ($in)");
    $stmt->execute($ids);

    echo json_encode(['ok' => true, 'deleted' => $stmt->rowCount()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Erro ao excluir atividade(s).']);
}
