<?php
$paginaAtiva = 'suporte'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<body>
  <div class="body-login">
  <div class="container-scroller">

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="support-container">
      
      <div class="support-form-container">
        <form id="supportForm">
          <div class="support-header">
        <h1 class="page-title">Suporte</h1>
        <p class="page-subtitle">Preencha o formulário abaixo para entrar em contato com nossa equipe</p>
      </div>
          <div class="form-group">
            <label for="nome">Seu Nome</label>
            <input type="text" id="nome" placeholder="Digite seu nome completo" required>
          </div>
          
          <div class="form-group">
            <label for="email">Seu E-mail</label>
            <input type="email" id="email" placeholder="seu@email.com" required>
          </div>
          
          <div class="form-group">
            <label for="mensagem">Descrição do Problema/Dúvida</label>
            <textarea id="mensagem" rows="6" placeholder="Descreva detalhadamente seu problema ou dúvida..." required></textarea>
          </div>
          
          <div class="form-actions">
            <button type="submit" class="submit-button">
              <i class="ti-send"></i> Enviar Mensagem
            </button>
          </div>
        </form>
      </div>
    </main>

          <!-- Modal de Confirmação -->
      <div class="modal-overlay" id="modalConfirmacao">
        <div class="modal-container">
          <div class="modal-header">
            <h3>Mensagem Enviada!</h3>
            <button class="close-modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="success-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
              </svg>
            </div>
            <p>Sua mensagem foi enviada com sucesso!</p>
            <p class="confirmation-text">Nossa equipe entrará em contato pelo e-mail fornecido em breve.</p>
          </div>
          <div class="modal-actions">
            <button class="submit-button" id="fecharConfirmacao">OK</button>
          </div>
        </div>
      </div>

<!-- FOOTER -->
        <?php
          include'../include/footer.php';
        ?>
  
  <script src="../script.js"></script>
  </div>
</body>
</html>