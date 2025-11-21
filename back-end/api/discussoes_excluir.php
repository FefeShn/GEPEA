<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

require_once '../config/auth.php';
require_once '../config/conexao.php';

if (!isLoggedIn() || !isAdmin()) {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado.']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$ids = $input['ids'] ?? [];
$ids = array_map('intval', (array)$ids);
$ids = array_values(array_filter($ids, fn($id) => $id > 0));

if (empty($ids)) {
    http_response_code(400);
    echo json_encode(['error' => 'Selecione ao menos uma discussão.']);
    exit();
}

$usuarioId = (int)($_SESSION['id_usuario'] ?? 0);
$pdo = getConexao();

try {
    $pdo->beginTransaction();

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $params = array_merge([$usuarioId], $ids);
    $sqlPermitidas = "
        SELECT DISTINCT d.id_discussao
        FROM discussao d
        JOIN discussao_participante dp ON dp.id_discussao = d.id_discussao
        WHERE dp.id_usuario = ? AND d.id_discussao IN ($placeholders)
    ";
    $stmt = $pdo->prepare($sqlPermitidas);
    $stmt->execute($params);
    $permitidas = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if (empty($permitidas)) {
        $pdo->rollBack();
        http_response_code(403);
        echo json_encode(['error' => 'Você não pode excluir essas discussões.']);
        exit();
    }

    $placeholdersDelete = implode(',', array_fill(0, count($permitidas), '?'));
    $del = $pdo->prepare("DELETE FROM discussao WHERE id_discussao IN ($placeholdersDelete)");
    $del->execute($permitidas);

    $pdo->commit();
    echo json_encode(['ok' => true, 'removidas' => count($permitidas)]);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao excluir discussões.']);
}
