<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

require_once '../config/auth.php';
require_once '../include/discussao_helpers.php';

if (!isLoggedIn() || !isAdmin()) {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado.']);
    exit();
}

$usuarioId = (int)($_SESSION['id_usuario'] ?? 0);

try {
    $discussoes = gepea_listar_discussoes_usuario($usuarioId);
    echo json_encode($discussoes);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao listar discussões.']);
}
