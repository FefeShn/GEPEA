<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../include/chat_helpers.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Autenticação requerida.']);
    exit();
}

// Lê dados de entrada
$input = json_decode(file_get_contents('php://input'), true);
$chatId = (int)($input['chat_id'] ?? 0);
$parentId = isset($input['parent_id']) ? (int)$input['parent_id'] : null;
$message = trim((string)($input['message'] ?? ''));

// Validações básicas
if ($chatId <= 0 || $message === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos.']);
    exit();
}

// Limite de tamanho da mensagem
if (strlen($message) > 2000) {
    http_response_code(400);
    echo json_encode(['error' => 'Mensagem excede o limite permitido.']);
    exit();
}

// Verifica participação no chat
$pdo = getConexao();
$userId = (int)($_SESSION['id_usuario'] ?? 0);
$viewerIsAdmin = isAdmin();

if (!gepea_usuario_participa_discussao($chatId, $userId, $pdo)) {
    http_response_code(403);
    echo json_encode(['error' => 'Você não participa deste chat.']);
    exit();
}

try {
    // Insere a mensagem
    $pdo->beginTransaction();

    // Valida parent_id se fornecido
    if ($parentId) {
        $stmtParent = $pdo->prepare('SELECT id FROM chat_messages WHERE id = ? AND chat_id = ? LIMIT 1');
        $stmtParent->execute([$parentId, $chatId]);
        if (!$stmtParent->fetchColumn()) {
            $parentId = null;
        }
    }

    // Normaliza o conteúdo da mensagem
    $normalized = chat_normalize_message($message);

    $stmt = $pdo->prepare('INSERT INTO chat_messages (chat_id, user_id, parent_id, message) VALUES (?, ?, ?, ?)');
    $stmt->execute([$chatId, $userId, $parentId, $normalized]);
    $newId = (int)$pdo->lastInsertId();

    // Recupera a mensagem inserida com detalhes
    $sql = "
        SELECT cm.id, cm.chat_id, cm.user_id, cm.parent_id, cm.message, cm.is_deleted,
               cm.created_at, cm.updated_at,
               u.nome_user, u.cargo_user, u.foto_user, u.eh_adm,
               parent.message AS parent_message,
               parent.is_deleted AS parent_is_deleted,
               parent_user.nome_user AS parent_user_name
        FROM chat_messages cm
        JOIN usuarios u ON u.id_usuario = cm.user_id
        LEFT JOIN chat_messages parent ON parent.id = cm.parent_id
        LEFT JOIN usuarios parent_user ON parent_user.id_usuario = parent.user_id
        WHERE cm.id = ?
        LIMIT 1
    ";
    // Fetch da mensagem recém-inserida
    $stmtFetch = $pdo->prepare($sql);
    $stmtFetch->execute([$newId]);
    $row = $stmtFetch->fetch(PDO::FETCH_ASSOC);

    $pdo->commit();

    if (!$row) {
        throw new RuntimeException('Falha ao recuperar mensagem.');
    }

    echo json_encode(['message' => chat_transform_row($row, $viewerIsAdmin)]);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao enviar mensagem.']);
}
