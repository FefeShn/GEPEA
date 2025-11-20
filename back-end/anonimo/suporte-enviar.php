<?php
session_start();
require_once __DIR__ . '/../config/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: suporte.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$assunto = trim($_POST['assunto'] ?? 'Suporte - GEPEA');
$mensagem = trim($_POST['mensagem'] ?? '');

// Monta o e-mail para a caixa de suporte
$subject = 'Suporte - ' . ($assunto !== '' ? $assunto : 'Mensagem');
$html = '<p><strong>Nome:</strong> ' . htmlspecialchars($nome) . '</p>'
      . '<p><strong>E-mail:</strong> ' . htmlspecialchars($email) . '</p>'
      . '<p><strong>Assunto:</strong> ' . htmlspecialchars($assunto) . '</p>'
      . '<p><strong>Mensagem:</strong><br>' . nl2br(htmlspecialchars($mensagem)) . '</p>';

// Envia para a caixa do suporte (definida em config/email.php)
gepea_send_mail(SUPPORT_INBOX, 'Suporte GEPEA', $subject, $html);

// Página de confirmação simples
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mensagem enviada</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="shortcut icon" href="../imagens/gepea.png" />
  <?php require '../include/head.php'; ?>
</head>
<body>
<?php require '../include/navbar.php'; require '../include/menu-anonimo.php'; ?>
<div class="container-scroller">
  <main class="support-container" style="max-width:720px;margin:24px auto;padding:24px;">
    <h1 class="page-title">Mensagem enviada!</h1>
    <p class="page-subtitle">Nossa equipe de suporte responderá em breve no e-mail informado.</p>
    <a href="suporte.php" class="btn btn-secondary" style="margin-top:12px;display:inline-block;">Voltar</a>
  </main>
</div>
</body>
</html>
