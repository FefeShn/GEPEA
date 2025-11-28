<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
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

$titulo = trim($_POST['tituloEvento'] ?? '');
$resumo = trim($_POST['resumoEvento'] ?? '');
if ($titulo === '') {
    if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
        jsonResponse(['ok' => false, 'error' => 'Título obrigatório'], 400);
    }
    header('Location: ../admin/eventos-admin.php');
    exit;
}

$imgRelPath = '../imagens/emoji.png';
if (isset($_FILES['imagemEvento']) && $_FILES['imagemEvento']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['imagemEvento']['error'] !== UPLOAD_ERR_OK) {
        $err = $_FILES['imagemEvento']['error'];
        $msg = 'Falha no upload da imagem.';
        if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) { $msg = 'Imagem excede o limite do servidor.'; }
        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            jsonResponse(['ok' => false, 'error' => $msg], 400);
        }
        header('Location: ../admin/eventos-admin.php');
        exit;
    }
    $uploadDir = __DIR__ . '/../imagens/eventos';
    if (!is_dir($uploadDir)) { mkdir($uploadDir, 0775, true); }
    $tmp = $_FILES['imagemEvento']['tmp_name'];
    $ext = pathinfo($_FILES['imagemEvento']['name'], PATHINFO_EXTENSION);
    $ext = $ext ? ('.' . strtolower($ext)) : '';
    $fileName = 'evt_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . $ext;
    $dest = $uploadDir . '/' . $fileName;
    if (!is_uploaded_file($tmp) || !move_uploaded_file($tmp, $dest)) {
        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            jsonResponse(['ok' => false, 'error' => 'Falha ao salvar imagem'], 500);
        }
        header('Location: ../admin/eventos-admin.php');
        exit;
    }
    $imgRelPath = '../imagens/eventos/' . $fileName;
}

$dataEvento = date('Y-m-d H:i:s');
$idUsuario = (int)($_SESSION['id_usuario'] ?? 0);
$conteudo = $resumo !== '' ? $resumo : '';

$stmt = $pdo->prepare('INSERT INTO evento (titulo_evento, conteudo_evento, data_evento, foto_evento, id_usuario) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$titulo, $conteudo, $dataEvento, $imgRelPath, $idUsuario]);
$id = (int)$pdo->lastInsertId();

if ($imgRelPath && $imgRelPath !== '../imagens/emoji.png') {
    $insImg = $pdo->prepare('INSERT INTO evento_imagens (evento_id, caminho, ordem) VALUES (?, ?, 1)');
    $insImg->execute([$id, $imgRelPath]);
}

$redirect = '../admin/editar-evento.php?id=' . $id;

if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
    jsonResponse(['ok' => true, 'id' => $id, 'redirect' => $redirect]);
}

header('Location: ' . $redirect);
exit;
