<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
requireAdmin();

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método não permitido']);
    exit;
}

$html = $_POST['html'] ?? '';
if (!is_string($html) || $html === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Conteúdo inválido']);
    exit;
}

$file = __DIR__ . '/sobre_conteudo.html';

$ok = @file_put_contents($file, $html);
if ($ok === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Falha ao salvar o conteúdo']);
    exit;
}

echo json_encode(['success' => true]);
