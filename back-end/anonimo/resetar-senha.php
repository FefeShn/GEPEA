<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

$pdo = getConexao();

$error = '';
$success = false;
$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['password'] ?? '';
    $conf  = $_POST['password_confirm'] ?? '';

    if ($senha === '' || $senha !== $conf) {
        $error = 'As senhas não conferem.';
    } elseif (strlen($senha) < 6) {
        $error = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        $tokenHash = hash('sha256', $token);
        // Find reset record (unused, not expired)
        $stmt = $pdo->prepare('SELECT pr.id, pr.id_usuario, u.email_user FROM password_reset pr JOIN usuarios u ON u.id_usuario = pr.id_usuario WHERE pr.token_hash = ? AND pr.used_at IS NULL AND pr.expires_at > NOW() LIMIT 1');
        $stmt->execute([$tokenHash]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (strcasecmp($row['email_user'], $email) !== 0) {
                $error = 'E-mail não corresponde ao token.';
            } else {
                // Update password
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $up = $pdo->prepare('UPDATE usuarios SET senha_user = ? WHERE id_usuario = ?');
                $up->execute([$hash, (int)$row['id_usuario']]);
                // Mark token used
                $pdo->prepare('UPDATE password_reset SET used_at = NOW() WHERE id = ?')->execute([(int)$row['id']]);
                $success = true;
            }
        } else {
            $error = 'Token inválido ou expirado.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redefinir senha</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    /* Evita qualquer overlay genérico nesta tela de reset */
    .modal-overlay { display: none !important; }
  </style>
  <link rel="shortcut icon" href="../imagens/gepea.png" />
  <?php require '../include/head.php'; ?>
</head>
<body>
<?php require '../include/navbar.php'; require '../include/menu-anonimo.php'; ?>
<div class="container-scroller">
  <main class="support-container" style="max-width:720px;margin:24px auto;padding:24px;">
    <?php if ($success): ?>
      <h1 class="page-title">Senha alterada!</h1>
      <p class="page-subtitle">Você já pode acessar com sua nova senha.</p>
      <a href="login.php" class="btn btn-secondary" style="margin-top:12px;display:inline-block;">Ir para o login</a>
    <?php else: ?>
      <h1 class="page-title">Redefinir senha</h1>
      <p class="page-subtitle">Informe seu e-mail, nova senha e confirme.</p>
      <?php if ($error): ?><div class="login-error" style="margin-bottom:12px;"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="seu@email.com" required>
        </div>
        <div class="form-group">
          <label for="password">Nova senha</label>
          <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
        <div class="form-group">
          <label for="password_confirm">Confirmar senha</label>
          <input type="password" id="password_confirm" name="password_confirm" placeholder="••••••••" required>
        </div>
        <div class="form-actions">
          <button type="submit" class="login-button">Salvar nova senha</button>
        </div>
      </form>
    <?php endif; ?>
  </main>
</div>
</body>
</html>
