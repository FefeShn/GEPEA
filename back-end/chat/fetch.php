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

// Lê parâmetros de consulta
$chatId = isset($_GET['chat_id']) ? (int)$_GET['chat_id'] : 0;
$sinceId = isset($_GET['since_id']) ? (int)$_GET['since_id'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Validações básicas
if ($chatId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Chat inválido.']);
    exit();
}

// Limita valores de limite e offset
$limit = max(1, min(200, $limit));
$offset = max(0, $offset);

$pdo = getConexao();
$userId = (int)($_SESSION['id_usuario'] ?? 0);
$viewerIsAdmin = isAdmin();

if (!gepea_usuario_participa_discussao($chatId, $userId, $pdo)) {
    http_response_code(403);
    echo json_encode(['error' => 'Você não participa deste chat.']);
    exit();
}

// Busca mensagens
try {
    $params = [$chatId];
    $where = 'cm.chat_id = ?';

    if ($sinceId > 0) {
        $where .= ' AND cm.id > ?';
        $params[] = $sinceId;
    }

    $where .= ' ORDER BY cm.id ASC LIMIT ? OFFSET ?';
    $params[] = $limit;
    $params[] = $offset;

    // Monta e executa a consulta
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
        WHERE $where
    ";

    // Executa a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Transforma os resultados
    $messages = array_map(fn($row) => chat_transform_row($row, $viewerIsAdmin), $rows);
    echo json_encode(['messages' => $messages]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar mensagens.']);
}
