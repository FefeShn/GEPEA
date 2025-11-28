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
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$lattes = isset($_POST['lattes']) ? trim((string)$_POST['lattes']) : '';

if (!$id) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'msg' => 'ID inválido']);
    exit;
}

// permissões: somente o próprio usuário ou admin
if (!isLoggedIn() || (!isAdmin() && (int)$_SESSION['id_usuario'] !== (int)$id)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'msg' => 'Não autorizado']);
    exit;
}

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'msg' => 'Email inválido']);
    exit;
}

if ($lattes !== '' && !preg_match('#^(https?://)#i', $lattes)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'msg' => 'URL do Lattes inválida']);
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare('UPDATE usuarios SET email_user = ?, lattes_user = ? WHERE id_usuario = ?');
    $stmt->execute([$email, $lattes !== '' ? $lattes : null, $id]);

    if ((int)$_SESSION['id_usuario'] === (int)$id) {
        $_SESSION['email_user'] = $email;
    }

    echo json_encode(['ok' => true, 'email' => $email, 'lattes' => $lattes]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'msg' => 'Erro ao salvar']);
}
