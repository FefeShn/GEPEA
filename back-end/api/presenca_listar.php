<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();
    $atividadeId = isset($_GET['atividade_id']) ? (int)$_GET['atividade_id'] : 0;
    if ($atividadeId <= 0) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Atividade inválida.']);
        exit;
    }

    // Lista todos os usuários e junta presença para a atividade
        $sql = 'SELECT u.id_usuario, u.nome_user, u.email_user,
                                     p.confirmacao, u.eh_adm
                        FROM usuarios u
                        LEFT JOIN presenca p
                            ON p.id_usuario = u.id_usuario AND p.id_atividade = ?
                        WHERE u.eh_adm = 0
                        ORDER BY u.nome_user ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$atividadeId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lista = array_map(function($r) {
        $status = 'nao_informado';
        if ($r['confirmacao'] !== null) {
            $status = ((int)$r['confirmacao'] === 1) ? 'presente' : 'ausente';
        }
        return [
            'id' => (int)$r['id_usuario'],
            'nome' => $r['nome_user'],
            'email' => $r['email_user'],
            'status' => $status
        ];
    }, $rows);

    echo json_encode(['ok' => true, 'membros' => $lista]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Erro ao listar presenças.']);
}
