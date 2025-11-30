<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/conexao.php';

try {
    $pdo = getConexao();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) { throw new Exception('ID inválido'); }

    // Busca informações do arquivo
    $stmt = $pdo->prepare('SELECT nome_arquivo, url_arquivo, tipo_arquivo, tamanho_arquivo FROM arquivo WHERE id_arquivo = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) { throw new Exception('Arquivo não encontrado'); }

    // Redireciona se for URL externa
    if (preg_match('#^https?://#i', $row['url_arquivo'])) {
        header('Location: ' . $row['url_arquivo']);
        exit;
    }

    // Caminho absoluto do arquivo
    $base = realpath(__DIR__ . '/..');
    $abs = realpath($base . DIRECTORY_SEPARATOR . $row['url_arquivo']);
    if (!$abs || strpos($abs, $base) !== 0 || !is_file($abs)) {
        throw new Exception('Arquivo não disponível'); }

    // Ajusta nome do arquivo para download
    $filename = $row['nome_arquivo'];
    $pathExt = strtolower(pathinfo($abs, PATHINFO_EXTENSION));
    if ($pathExt && strtolower(substr($filename, -strlen($pathExt)-1)) !== '.' . $pathExt) {
        $filename .= '.' . $pathExt; }

    // Define o tipo MIME corretamente
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeDetected = finfo_file($finfo, $abs);
    finfo_close($finfo);
    $mime = $mimeDetected ?: ($row['tipo_arquivo'] ?: 'application/octet-stream');

    // Envia cabeçalhos para download
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $mime);
    header('Content-Disposition: attachment; filename="' . str_replace('"','',$filename) . '"');
    header('Content-Length: ' . filesize($abs));
    header('Cache-Control: no-cache');
    header('Pragma: public');

    // Envia o arquivo
    readfile($abs);
    exit;
    // Tratamento de erros
} catch (Throwable $e) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Erro: ' . $e->getMessage();
    exit;
}
