<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/auth.php';
requireLogin();
require_once __DIR__ . '/../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();
    $atividadeId = isset($_GET['atividade_id']) ? (int)$_GET['atividade_id'] : 0;
    if ($atividadeId <= 0) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Atividade inválida.']);
        exit;
    }
    $usuarioId = $_SESSION['id_usuario'] ?? null;
    if (!$usuarioId) {
        http_response_code(401);
        echo json_encode(['ok' => false, 'error' => 'Não autenticado.']);
        exit;
    }
    $stmt = $pdo->prepare('SELECT confirmacao FROM presenca WHERE id_usuario = ? AND id_atividade = ? LIMIT 1');
    $stmt->execute([$usuarioId, $atividadeId]);
    $status = 'nao_informado';
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $status = $row['confirmacao'] == 1 ? 'presente' : 'ausente';
    }
    echo json_encode(['ok' => true, 'status' => $status]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Erro ao obter presença.']);
}
