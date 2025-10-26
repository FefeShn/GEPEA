<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../../config/conexao.php';

try {
    $pdo = getConexao();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) { throw new Exception('ID inválido'); }

    $stmt = $pdo->prepare('SELECT nome_arquivo, url_arquivo, tipo_arquivo, tamanho_arquivo FROM arquivo WHERE id_arquivo = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) { throw new Exception('Arquivo não encontrado'); }

    // Se for link externo, redireciona
    if (preg_match('#^https?://#i', $row['url_arquivo'])) {
        header('Location: ' . $row['url_arquivo']);
        exit;
    }

    $base = realpath(__DIR__ . '/../../');
    $abs = realpath($base . DIRECTORY_SEPARATOR . $row['url_arquivo']);
    if (!$abs || strpos($abs, $base) !== 0 || !is_file($abs)) {
        throw new Exception('Arquivo não disponível');
    }

    $filename = $row['nome_arquivo'];
    $pathExt = strtolower(pathinfo($abs, PATHINFO_EXTENSION));
    if ($pathExt && strtolower(substr($filename, -strlen($pathExt)-1)) !== '.' . $pathExt) {
        $filename .= '.' . $pathExt;
    }
    $filesize = (int)$row['tamanho_arquivo'];

    // Detecta MIME real, mas mantém fallback do banco
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeDetected = finfo_file($finfo, $abs);
    finfo_close($finfo);
    $mime = $mimeDetected ?: ($row['tipo_arquivo'] ?: 'application/octet-stream');

    header('Content-Description: File Transfer');
    header('Content-Type: ' . $mime);
    header('Content-Disposition: attachment; filename="' . str_replace('"','',$filename) . '"');
    header('Content-Length: ' . filesize($abs));
    header('Cache-Control: no-cache');
    header('Pragma: public');

    readfile($abs);
    exit;
} catch (Throwable $e) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Erro: ' . $e->getMessage();
    exit;
}
