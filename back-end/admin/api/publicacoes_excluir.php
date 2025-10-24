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
$pdo->exec("CREATE TABLE IF NOT EXISTS publicacoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  resumo TEXT,
  imagem VARCHAR(512),
  arquivo VARCHAR(512),
  data_publicacao DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

// Buscar caminhos para excluir arquivos
$in = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, imagem, arquivo FROM publicacoes WHERE id IN ($in)");
$stmt->execute($ids);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Capturar imagens adicionais para apagar
$stmtImgs = $pdo->prepare("SELECT caminho FROM publicacao_imagens WHERE publicacao_id IN ($in)");
$stmtImgs->execute($ids);
$extraImgs = $stmtImgs->fetchAll(PDO::FETCH_COLUMN);

// Excluir do banco
$del = $pdo->prepare("DELETE FROM publicacoes WHERE id IN ($in)");
$del->execute($ids);

// Remover arquivos físicos (imagem e arquivo gerado)
foreach ($rows as $row) {
    foreach (['imagem', 'arquivo'] as $k) {
        $rel = $row[$k] ?? '';
        if (!$rel) continue;
        // Normalizar caminho absoluto
        $abs = realpath(__DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\'));
        if (!$abs) {
            // Tentar construir caminho manualmente
            $abs = __DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\');
        }
        if (is_file($abs)) {@unlink($abs);}    }
}

// Apagar imagens extras (carrossel)
foreach ($extraImgs as $rel) {
    if (!$rel) continue;
    $abs = realpath(__DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\'));
    if (!$abs) {
        $abs = __DIR__ . '/../../' . ltrim(str_replace(['..\\','../'], '', $rel), '/\\');
    }
    if (is_file($abs)) {@unlink($abs);}    
}

echo json_encode(['ok' => true, 'deleted' => count($rows)]);
exit;
