<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEPEA</title>
    <link rel="shortcut icon" href="imagens/gepea.png" />
    <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="body-login">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="index-button" href="index.php">
        <img src="../imagens/gepea.png" alt="logo-gepea" class="logo-nav">
      </a>
        <p class="titulo-logo">GEPEA</p>
      
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        
        

        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <div class="profile-img">
                <a href="login.php">
                  <img src="../imagens/user-foto.png" alt="profile" class="profile-img">
                </a>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Configurações
              </a>
              <a class="dropdown-item" id="logout-btn">
                <i class="ti-power-off text-primary"></i>
                Sair
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>


    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-container">
                <img src="../imagens/gepea.png" alt="logo-gepea" class="logo-icon">
            </div>
            
            <h2 class="welcome-title">Bem vindo(a) ao GEPEA!</h2>
            <p class="welcome-subtitle">Faça login para acessar sua conta</p>

            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="username">Nome de Usuário</label>
                    <input type="text" id="username" name="username" placeholder="Digite seu nome de usuário" required>
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
                  <a href="../admin/index-admin.php" class="login-button-adm">Acessar ADMIN</a>
                    <a href="../membro/index-membro.php" class="login-button">Acessar</a>
                    

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