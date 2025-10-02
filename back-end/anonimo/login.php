<?php
session_start();
require '../config/conexao.php';
require '../config/auth.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['password'] ?? '';

    $pdo = getConexao();
    $stmt = $pdo->prepare("SELECT id_usuario, nome_user, email_user, senha_user, eh_adm, foto_user FROM usuarios WHERE email_user = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($senha === $user['senha_user']) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nome_user'] = $user['nome_user'];
            $_SESSION['email_user'] = $user['email_user'];
            $_SESSION['eh_adm'] = (bool)$user['eh_adm'];
            $_SESSION['foto_user'] = $user['foto_user'];
            $_SESSION['logged_in'] = true;

            if ($_SESSION['eh_adm']) {
                header('Location: ../admin/index-admin.php');
                exit();
            } else {
                header('Location: ../membro/index-membro.php');
                exit();
            }
        } else {
            $erro = 'Usuário ou senha inválidos!';
        }
    } else {
        $erro = 'Usuário não cadastrado!';
    }
}

require '../include/navbar.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEPEA</title>
    <link rel="shortcut icon" href="../imagens/gepea.png" />
    <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="body-login">

    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-container">
                <img src="../imagens/gepea.png" alt="logo-gepea" class="logo-icon">
            </div>
            
            <h2 class="welcome-title">Bem vindo(a) ao GEPEA!</h2>
            <p class="welcome-subtitle">Faça login para acessar sua conta</p>

            <?php if ($erro): ?>
                <div class="login-error"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>

            <form id="loginForm" class="login-form" method="POST" action="">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="form-group">
                    <div class="password-header">
                        <label for="password">Senha</label>
                        <a href="esqueceu-senha.html" class="forgot-password">Esqueceu a senha?</a>
                    </div>
                    <div class="password-input">
                        <input type="password" id="password" name="password" placeholder="••••••••••••" required>
                        <button type="button" class="toggle-password" aria-label="Mostrar senha">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Lembre de mim</label>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="login-button">Acessar</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal Esqueceu a Senha -->
      <div id="modalEsqueceuSenha" class="modal-overlay">
          <div class="modal-content">
              <button class="close-modal">&times;</button>
              <h3>Recuperar Senha</h3>
              <p>Digite seu e-mail cadastrado para receber as instruções de recuperação de senha.</p>
              <form id="formEsqueceuSenha">
                  <div class="form-group">
                      <label for="emailRecuperacao">E-mail</label>
                      <input type="email" id="emailRecuperacao" name="email" placeholder="Digite seu e-mail" required>
                  </div>
                  <div class="form-actions">
                      <button type="submit" class="login-button">Enviar Instruções</button>
                  </div>
              </form>
          </div>
      </div>
    <script src="../script.js"></script>
    </div>
</body>
</html>