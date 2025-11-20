<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../config/email.php';

$pdo = getConexao();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');

// Always respond success to avoid user enumeration
$ok = true;

if ($email !== '') {
    // Ensure table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS password_reset (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        token_hash CHAR(64) NOT NULL,
        expires_at DATETIME NOT NULL,
        used_at DATETIME DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (id_usuario),
        INDEX (token_hash)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    // Lookup user by email
    $stmt = $pdo->prepare('SELECT id_usuario, nome_user, email_user FROM usuarios WHERE email_user = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);
        $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');
        $ins = $pdo->prepare('INSERT INTO password_reset (id_usuario, token_hash, expires_at) VALUES (?, ?, ?)');
        $ins->execute([(int)$user['id_usuario'], $tokenHash, $expiresAt]);

        // Build reset link
        $resetUrl = gepea_base_url('anonimo/resetar-senha.php') . '?token=' . urlencode($token);

        $subject = 'GEPEA - Redefinição de senha';
        $html = '<p>Olá,</p>'
              . '<p>Recebemos uma solicitação para redefinir sua senha no GEPEA.</p>'
              . '<p>Clique no link abaixo para criar uma nova senha (válido por 1 hora):</p>'
              . '<p><a href="' . htmlspecialchars($resetUrl) . '">' . htmlspecialchars($resetUrl) . '</a></p>'
              . '<p>Se você não solicitou, ignore este e-mail.</p>';

        gepea_send_mail($user['email_user'], $user['nome_user'] ?? '', $subject, $html);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redefinição de senha</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    /* Evita qualquer overlay genérico nesta tela */
    .modal-overlay { display: none !important; }
  </style>
  <link rel="shortcut icon" href="../imagens/gepea.png" />
  <?php require '../include/head.php'; ?>
</head>
<body>
<?php require '../include/navbar.php'; require '../include/menu-anonimo.php'; ?>
<div class="container-scroller">
  <main class="support-container" style="max-width:720px;margin:24px auto;padding:24px;">
    <h1 class="page-title">Verifique seu e-mail</h1>
    <p class="page-subtitle">Se o e-mail informado estiver cadastrado, você receberá em breve um link para redefinir a senha.</p>
    <p>Você pode fechar esta página e aguardar a mensagem.</p>
    <a href="login.php" class="btn btn-secondary" style="margin-top:12px;display:inline-block;">Voltar ao login</a>
  </main>
</div>
</body>
</html>
