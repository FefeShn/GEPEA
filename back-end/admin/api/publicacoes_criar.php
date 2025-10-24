<?php
session_start();
require_once __DIR__ . '/../../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../../config/conexao.php';

function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
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

// Tabela de imagens da publicação (para carrossel)
$pdo->exec("CREATE TABLE IF NOT EXISTS publicacao_imagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    publicacao_id INT NOT NULL,
    caminho VARCHAR(512) NOT NULL,
    ordem INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (publicacao_id) REFERENCES publicacoes(id) ON DELETE CASCADE
)");

$title = trim($_POST['tituloPublicacao'] ?? '');
$resumo = trim($_POST['resumoPublicacao'] ?? '');

if ($title === '') {
    if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
        jsonResponse(['ok' => false, 'error' => 'Título obrigatório'], 400);
    }
    header('Location: ../index-admin.php');
    exit;
}

// Upload da imagem
$imgRelPath = '../imagens/emoji.png';
if (isset($_FILES['imagemPublicacao']) && $_FILES['imagemPublicacao']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['imagemPublicacao']['error'] !== UPLOAD_ERR_OK) {
        $err = $_FILES['imagemPublicacao']['error'];
        $msg = 'Falha no upload da imagem.';
        if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) { $msg = 'Imagem excede o limite do servidor.'; }
        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            jsonResponse(['ok' => false, 'error' => $msg], 400);
        }
        header('Location: ../index-admin.php');
        exit;
    }
    $uploadDir = __DIR__ . '/../../imagens/publicacoes';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }
    $tmp = $_FILES['imagemPublicacao']['tmp_name'];
    $ext = pathinfo($_FILES['imagemPublicacao']['name'], PATHINFO_EXTENSION);
    $ext = $ext ? ('.' . strtolower($ext)) : '';
    $fileName = 'pub_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . $ext;
    $dest = $uploadDir . '/' . $fileName;
    if (!is_uploaded_file($tmp) || !move_uploaded_file($tmp, $dest)) {
        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            jsonResponse(['ok' => false, 'error' => 'Falha ao salvar imagem'], 500);
        }
        header('Location: ../index-admin.php');
        exit;
    }
    // Caminho relativo utilizável tanto por admin quanto pela página de publicação
    $imgRelPath = '../imagens/publicacoes/' . $fileName;
}

// Data padrão: hoje
$dataPub = date('Y-m-d');

$stmt = $pdo->prepare('INSERT INTO publicacoes (titulo, resumo, imagem, arquivo, data_publicacao) VALUES (?, ?, ?, ?, ?)');
$arquivoPlan = null; // será definido após a tela de edição gerar o arquivo
$stmt->execute([$title, $resumo, $imgRelPath, $arquivoPlan, $dataPub]);
$id = (int)$pdo->lastInsertId();

// Se houver imagem enviada, cadastrar como primeira imagem do carrossel
if ($imgRelPath && $imgRelPath !== '../imagens/emoji.png') {
    $insImg = $pdo->prepare('INSERT INTO publicacao_imagens (publicacao_id, caminho, ordem) VALUES (?, ?, 1)');
    $insImg->execute([$id, $imgRelPath]);
}

$redirect = './editar-publicacao.php?id=' . $id;

if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
    jsonResponse(['ok' => true, 'id' => $id, 'redirect' => $redirect]);
}

header('Location: ' . $redirect);
exit;
