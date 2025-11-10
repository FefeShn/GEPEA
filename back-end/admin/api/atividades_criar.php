<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();

    $raw = file_get_contents('php://input');
    $data = [];
    if ($raw) {
        $try = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE) { $data = $try; }
    }

    $descricao = $data['descricao'] ?? ($_POST['descricao'] ?? null);
    $dataHora  = $data['data_hora'] ?? ($_POST['data_hora'] ?? null);
    $dataFim   = $data['data_fim'] ?? ($_POST['data_fim'] ?? null);
    $cor       = $data['cor'] ?? ($_POST['cor'] ?? null);

    if (!$descricao || !$dataHora) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Descrição e data/hora são obrigatórios.']);
        exit;
    }

    $userId = $_SESSION['id_usuario'] ?? null;
    if (!$userId) {
        http_response_code(401);
        echo json_encode(['ok' => false, 'error' => 'Não autenticado.']);
        exit;
    }

    $ts = strtotime($dataHora);
    if ($ts === false) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Data/hora inválida.']);
        exit;
    }
    $dataHoraSql = date('Y-m-d H:i:s', $ts);

    $descricaoComMeta = $descricao;
    $metas = [];
    if ($cor) { $metas['cor'] = preg_replace('/[^a-zA-Z0-9_-]/', '', $cor); }
    if ($dataFim) {
        $tsFim = strtotime($dataFim);
        if ($tsFim !== false) {
            $metas['fim'] = date('Y-m-d\TH:i', $tsFim);
        }
    }
    if (!empty($metas)) {
        $pairs = [];
        foreach ($metas as $k => $v) { $pairs[] = $k.'='.$v; }
        $descricaoComMeta .= ' [meta:'.implode(';', $pairs).']';
    }

    $stmt = $pdo->prepare("INSERT INTO atividade (descricao_atividade, data_hora, id_usuario) VALUES (?, ?, ?)");
    $stmt->execute([$descricaoComMeta, $dataHoraSql, $userId]);

    echo json_encode(['ok' => true, 'id' => (int)$pdo->lastInsertId()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Erro ao criar atividade.']);
}
