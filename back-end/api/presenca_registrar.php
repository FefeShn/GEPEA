<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/auth.php';
requireLogin();
require_once __DIR__ . '/../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();
    $raw = file_get_contents('php://input');
    $data = [];
    if ($raw) {
        $tmp = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE) { $data = $tmp; }
    }
    if (empty($data)) { $data = $_POST; }

    $atividadeId = isset($data['atividade_id']) ? (int)$data['atividade_id'] : 0;
    $status = $data['status'] ?? null; // 'presente' | 'ausente'

    if ($atividadeId <= 0 || !in_array($status, ['presente','ausente'], true)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Parâmetros inválidos.']);
        exit;
    }

    $usuarioId = $_SESSION['id_usuario'] ?? null;
    $isAdmin = isset($_SESSION['eh_adm']) && $_SESSION['eh_adm'];
    if (!$usuarioId) {
        http_response_code(401);
        echo json_encode(['ok' => false, 'error' => 'Não autenticado.']);
        exit;
    }
    if ($isAdmin) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'Admin não registra presença.']);
        exit;
    }

    // Confirmacao: 1 = presente, 0 = ausente.
    $confirmacao = $status === 'presente' ? 1 : 0;

    // Verifica se existe registro de presenca (unico por usuario/atividade)
    $stmt = $pdo->prepare('SELECT id_presenca FROM presenca WHERE id_usuario = ? AND id_atividade = ? LIMIT 1');
    $stmt->execute([$usuarioId, $atividadeId]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $upd = $pdo->prepare('UPDATE presenca SET confirmacao = ?, data_confirmacao = NOW() WHERE id_presenca = ?');
        $upd->execute([$confirmacao, $row['id_presenca']]);
    } else {
        $ins = $pdo->prepare('INSERT INTO presenca (confirmacao, data_confirmacao, id_usuario, id_atividade) VALUES (?, NOW(), ?, ?)');
        $ins->execute([$confirmacao, $usuarioId, $atividadeId]);
    }

    echo json_encode(['ok' => true, 'status' => $status]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Erro ao registrar presença.']);
}
