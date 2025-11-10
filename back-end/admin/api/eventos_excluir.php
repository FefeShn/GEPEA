<?php
session_start();
require_once __DIR__ . '/../../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

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
$pdo->exec("CREATE TABLE IF NOT EXISTS evento (
  id_evento INT AUTO_INCREMENT PRIMARY KEY,
  titulo_evento VARCHAR(255) NOT NULL,
  conteudo_evento TEXT NOT NULL,
  data_evento DATETIME NOT NULL,
  foto_evento VARCHAR(512) DEFAULT NULL,
  id_usuario INT NOT NULL
)");
$pdo->exec("CREATE TABLE IF NOT EXISTS evento_imagens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  evento_id INT NOT NULL,
  caminho VARCHAR(512) NOT NULL,
  ordem INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (evento_id) REFERENCES evento(id_evento) ON DELETE CASCADE
)");

$in = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id_evento, foto_evento FROM evento WHERE id_evento IN ($in)");
$stmt->execute($ids);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtImgs = $pdo->prepare("SELECT caminho FROM evento_imagens WHERE evento_id IN ($in)");
$stmtImgs->execute($ids);
$extraImgs = $stmtImgs->fetchAll(PDO::FETCH_COLUMN);

// excluir do banco 
$del = $pdo->prepare("DELETE FROM evento WHERE id_evento IN ($in)");
$del->execute($ids);

// Remover arquivos 
foreach ($rows as $row) {
    // Capa
    $rel = $row['foto_evento'] ?? '';
    if ($rel) {
        $abs = realpath(__DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\'));
        if (!$abs) { $abs = __DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\'); }
        if (is_file($abs)) { @unlink($abs); }
    }
    // Arquivo gerado
    $fileRel = '../eventos/evento' . (int)$row['id_evento'] . '.php';
    $absF = realpath(__DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $fileRel), '/\\'));
    if (!$absF) { $absF = __DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $fileRel), '/\\'); }
    if (is_file($absF)) { @unlink($absF); }
}

foreach ($extraImgs as $rel) {
    if (!$rel) continue;
    $abs = realpath(__DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\'));
    if (!$abs) { $abs = __DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\'); }
    if (is_file($abs)) { @unlink($abs); }
}

echo json_encode(['ok' => true, 'deleted' => count($rows)]);
exit;
