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

if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'msg' => 'Arquivo de imagem obrigatório']);
    exit;
}

$file = $_FILES['foto'];
$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
if (!isset($allowed[$file['type']])) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'msg' => 'Formato inválido']);
    exit;
}

if ($file['size'] > 2 * 1024 * 1024) { // 2MB
    http_response_code(422);
    echo json_encode(['ok' => false, 'msg' => 'Imagem maior que 2MB']);
    exit;
}

$ext = $allowed[$file['type']];
$dir = realpath(__DIR__ . '/../imagens');
if ($dir === false) {
    $dir = __DIR__ . '/../imagens';
}
$subdir = $dir . DIRECTORY_SEPARATOR . 'usuarios';
if (!is_dir($subdir)) { @mkdir($subdir, 0775, true); }

$basename = 'user_' . $id . '_' . time() . '.' . $ext;
$destPath = $subdir . DIRECTORY_SEPARATOR . $basename;

if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'msg' => 'Falha ao salvar imagem']);
    exit;
}

// Caminho público relativo a partir das páginas membro (../imagens/usuarios/...)
$publicPath = '../imagens/usuarios/' . $basename;

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare('UPDATE usuarios SET foto_user = ? WHERE id_usuario = ?');
    $stmt->execute([$publicPath, $id]);

    if ((int)$_SESSION['id_usuario'] === (int)$id) {
        $_SESSION['foto_user'] = $publicPath;
    }

    echo json_encode(['ok' => true, 'foto' => $publicPath]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'msg' => 'Erro ao atualizar foto']);
}
