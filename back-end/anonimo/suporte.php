<?php
$paginaAtiva = 'suporte'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
require '../include/navbar.php';
require '../include/menu-dinamico.php';
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
        <div class="support-header">
          <h1 class="page-title">Suporte</h1>
          <p class="page-subtitle">Estamos aqui para ajudar.</p>
        </div>
        <section class="support-info">
          <div class="support-text">
            <p>Para dúvidas, problemas de acesso ou sugestões, envie um e-mail diretamente para nossa equipe de suporteaa:</p>
            <p class="support-email-line">
              <span class="label">E-mail de suporte oficial:</span>
              <a class="support-email" href="mailto:suporte.gepea@gmail.com">suporte.gepea@gmail.com</a>
            </p>
            <ul class="support-guidelines">
              <li>Inclua seu nome completo.</li>
              <li>Descreva o problema.</li>
              <li>Se possível, envie capturas de tela.</li>
              <li>Informe o dispositivo (PC, celular) e navegador utilizado.</li>
            </ul>
          </div>
          <div class="support-actions">
            <a class="support-btn-primary" href="mailto:suporte.gepea@gmail.com?subject=Suporte%20GEPEA">
              <i class="ti-email" aria-hidden="true"></i>
              <span>Enviar E-mail</span>
            </a>
            <button type="button" class="support-btn-secondary" onclick="window.location.href='login.php'">
              Ir para Login
            </button>
          </div>
        </section>
      </div>
    </main>

  <script src="../script.js"></script>
  </div>
</body>
</html>