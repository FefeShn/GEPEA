<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    $ids = $data['ids'] ?? [];

    if (!is_array($ids) || empty($ids)) {
        echo json_encode(['ok' => false, 'error' => 'Nenhum ID informado']);
        exit;
    }

    $ids = array_values(array_filter(array_map('intval', $ids)));
    if (empty($ids)) {
        echo json_encode(['ok' => false, 'error' => 'IDs inválidos']);
        exit;
    }

    $pdo = getConexao();
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id_usuario INT AUTO_INCREMENT PRIMARY KEY,
        nome_user VARCHAR(255) NOT NULL,
        email_user VARCHAR(255) NOT NULL UNIQUE,
        senha_user VARCHAR(255) NOT NULL,
        foto_user VARCHAR(512),
        eh_adm TINYINT(1) NOT NULL DEFAULT 0,
        cargo_user VARCHAR(100),
        lattes_user VARCHAR(512)
    )");

    $in = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare('SELECT id_usuario, foto_user FROM usuarios WHERE id_usuario IN (' . $in . ')');
    $stmt->execute($ids);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $del = $pdo->prepare('DELETE FROM usuarios WHERE id_usuario IN (' . $in . ')');
    $del->execute($ids);

    foreach ($rows as $row) {
        $id = (int)$row['id_usuario'];
        $foto = $row['foto_user'] ?? '';
        if ($foto && strpos($foto, 'user-foto.png') === false) {
            $abs = realpath(__DIR__ . '/../' . ltrim(str_replace(['..\\','../'], '', $foto), '/\\'));
            if (!$abs) { $abs = __DIR__ . '/../' . ltrim(str_replace(['..\\','../'], '', $foto), '/\\'); }
            if (is_file($abs)) { @unlink($abs); }
        }
        $bioRel = '../biografias/biografia' . $id . '.php';
        $bioAbs = realpath(__DIR__ . '/../' . ltrim(str_replace(['..\\','../'], '', $bioRel), '/\\'));
        if (!$bioAbs) { $bioAbs = __DIR__ . '/../' . ltrim(str_replace(['..\\','../'], '', $bioRel), '/\\'); }
        if (is_file($bioAbs)) { @unlink($bioAbs); }
    }

    echo json_encode(['ok' => true, 'deleted' => count($rows)]);
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Erro interno', 'detail' => $e->getMessage()]);
    exit;
}
