<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../include/discussao_helpers.php';

if (!isLoggedIn() || !isAdmin()) {
    http_response_code(403);
    echo json_encode(['error' => 'Apenas administradores.']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$messageId = (int)($input['message_id'] ?? 0);
$restore = (int)($input['restore'] ?? 0) === 1;

if ($messageId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Mensagem inválida.']);
    exit();
}

$pdo = getConexao();
$userId = (int)($_SESSION['id_usuario'] ?? 0);

try {
    $stmt = $pdo->prepare('SELECT chat_id FROM chat_messages WHERE id = ? LIMIT 1');
    $stmt->execute([$messageId]);
    $chatId = (int)$stmt->fetchColumn();

    if (!$chatId) {
        http_response_code(404);
        echo json_encode(['error' => 'Mensagem não encontrada.']);
        exit();
    }

    if (!gepea_usuario_participa_discussao($chatId, $userId, $pdo)) {
        http_response_code(403);
        echo json_encode(['error' => 'Acesso negado a este chat.']);
        exit();
    }

    $update = $pdo->prepare('UPDATE chat_messages SET is_deleted = ? WHERE id = ?');
    $update->execute([$restore ? 0 : 1, $messageId]);

    echo json_encode(['ok' => true, 'restored' => $restore]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao excluir mensagem.']);
}
