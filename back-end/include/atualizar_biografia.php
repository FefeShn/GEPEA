<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../config/conexao.php';
require_once '../config/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'msg' => 'Método não permitido']);
    exit;
}

$id = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
$bio = isset($_POST['bio']) ? trim((string)$_POST['bio']) : '';

if (!$id) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'msg' => 'ID inválido']);
    exit;
}

if (!isLoggedIn() || (!isAdmin() && (int)$_SESSION['id_usuario'] !== (int)$id)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'msg' => 'Não autorizado']);
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare('UPDATE usuarios SET bio_user = ? WHERE id_usuario = ?');
    $stmt->execute([$bio !== '' ? $bio : null, $id]);
    echo json_encode(['ok' => true, 'bio' => $bio]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'msg' => 'Erro ao salvar biografia']);
}
