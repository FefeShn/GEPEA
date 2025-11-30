<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getConexao();
    $userId = $_SESSION['id_usuario'] ?? null;
    if (!$userId) { throw new Exception('Usuário não autenticado.'); }

    // Processar upload de arquivo ou link
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tipoEntrada = trim($_POST['tipo'] ?? 'arquivo');

    if ($tipoEntrada === 'link') {
        $linkUrl = trim($_POST['link_url'] ?? '');
        if ($titulo === '') { throw new Exception('Informe um título.'); }
        if ($linkUrl === '' || !preg_match('#^https?://#i', $linkUrl)) {
            throw new Exception('Informe uma URL válida iniciando com http:// ou https://');
        }
        $stmt = $pdo->prepare('INSERT INTO arquivo (nome_arquivo, descricao_arquivo, url_arquivo, tipo_arquivo, tamanho_arquivo, id_usuario) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$titulo, $descricao, $linkUrl, 'link', null, $userId]);
        echo json_encode(['ok' => true, 'id' => (int)$pdo->lastInsertId(), 'tipo' => 'link']);
        return;
    }

    // Processar upload de arquivo
    if (!isset($_FILES['arquivo'])) { throw new Exception('Nenhum arquivo enviado.'); }
    $err = (int)($_FILES['arquivo']['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($err !== UPLOAD_ERR_OK) {
        // Verifica erros de upload
        $map = [
            UPLOAD_ERR_INI_SIZE => 'Arquivo maior que o permitido pelo servidor (upload_max_filesize).',
            UPLOAD_ERR_FORM_SIZE => 'Arquivo maior que o limite do formulário.',
            UPLOAD_ERR_PARTIAL => 'Upload incompleto. Tente novamente.',
            UPLOAD_ERR_NO_FILE => 'Nenhum arquivo foi enviado.',
            UPLOAD_ERR_NO_TMP_DIR => 'Pasta temporária ausente no servidor.',
            UPLOAD_ERR_CANT_WRITE => 'Falha ao gravar o arquivo no disco.',
            UPLOAD_ERR_EXTENSION => 'Upload bloqueado por extensão no servidor.'
        ];
        throw new Exception($map[$err] ?? 'Falha no upload do arquivo.');
    }

    // Validações básicas do arquivo
    $file = $_FILES['arquivo'];
    $originalName = $file['name'];
    $tmpPath = $file['tmp_name'];
    $size = (int)$file['size'];

    if ($size <= 0) { throw new Exception('Arquivo vazio.'); }
    if ($size > 20 * 1024 * 1024) { throw new Exception('Arquivo excede o limite de 20MB.'); }

    // Determina o tipo MIME do arquivo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmpPath);
    finfo_close($finfo);

    $allowedExts = ['pdf','doc','docx','ppt','pptx','xls','xlsx','txt','jpg','jpeg','png','gif','webp','csv','zip','rar','7z'];
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts, true)) { throw new Exception('Tipo de arquivo não permitido.'); }

    // Salva o arquivo no servidor 
    $safeName = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', basename($originalName));
    $unique = bin2hex(random_bytes(6));
    $finalName = $unique . '_' . $safeName;

    // Diretório de destino
    $targetDir = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . 'arquivos';
    if (!is_dir($targetDir)) { mkdir($targetDir, 0775, true); }

    $destPath = $targetDir . DIRECTORY_SEPARATOR . $finalName;
    if (!move_uploaded_file($tmpPath, $destPath)) { throw new Exception('Não foi possível salvar o arquivo.'); }

    $tituloDB = $titulo !== '' ? $titulo : $originalName;
    $urlRelativa = 'arquivos/' . $finalName;

    // Insere registro no banco de dados
    $stmt = $pdo->prepare('INSERT INTO arquivo (nome_arquivo, descricao_arquivo, url_arquivo, tipo_arquivo, tamanho_arquivo, id_usuario) VALUES (?,?,?,?,?,?)');
    $stmt->execute([$tituloDB, $descricao, $urlRelativa, $mime, $size, $userId]);

    echo json_encode(['ok' => true, 'id' => (int)$pdo->lastInsertId(), 'tipo' => 'arquivo']);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
