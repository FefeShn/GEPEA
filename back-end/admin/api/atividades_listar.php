<?php
// Lista atividades para o FullCalendar
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();
    $stmt = $pdo->query("SELECT id_atividade, descricao_atividade, data_hora FROM atividade ORDER BY data_hora ASC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $events = array_map(function($r) {
        $title = $r['descricao_atividade'];
        $className = null;
        $endIso = null;
        // Extrai meta no fim da descrição: [meta:chave=valor;chave2=valor2]
        if (preg_match('/\s\[meta:([^\]]+)\]$/', $title, $m)) {
            $metaStr = $m[1];
            $title = preg_replace('/\s\[meta:[^\]]+\]$/', '', $title);
            foreach (explode(';', $metaStr) as $pair) {
                $parts = array_map('trim', array_pad(explode('=', $pair, 2), 2, ''));
                $k = $parts[0];
                $v = $parts[1];
                if ($k === 'cor' && $v !== '') $className = $v;
                if ($k === 'fim' && $v !== '') {
                    $ts = strtotime($v);
                    if ($ts !== false) $endIso = date('c', $ts);
                }
            }
        }

        $event = [
            'id' => (int)$r['id_atividade'],
            'title' => $title,
            'start' => date('c', strtotime($r['data_hora'])),
            'allDay' => false
        ];
        if ($endIso) { $event['end'] = $endIso; }
        if ($className) { $event['className'] = $className; }
        return $event;
    }, $rows);

    echo json_encode($events);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao listar atividades']);
}
