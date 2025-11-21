<?php
$paginaAtiva = 'forum'; 
$fotoPerfil  = "../imagens/estrela.jpg"; 
$linkPerfil  = "../membro/biografia-membro.php"; 
require '../include/navbar.php';
require '../include/menu-membro.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<body>
  <div class="container-scroller">

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="chat-header-with-back">
          <a href="forum.php" class="btn-voltar">
            <i class="fas fa-arrow-left"></i> Voltar
          </a>
          <div class="chat-header-info">
            <h3>Chat Geral</h3>
            <p>Criado por Fernanda Sehn </p>
          </div>
        </div>

        <div class="chat-container">
          <div class="chat-messages">
            <!-- Mensagens da discussão -->
            <div class="message message-other">
              <div class="message-header">
                <img src="../imagens/computer.jpg" alt="Fernanda Sehn" class="message-avatar">
                <div class="message-sender bolsista">Fernanda Sehn</div>
                <div class="message-actions">
                <button class="reply-btn" title="Responder"><i class="fas fa-reply"></i></button>
            </div>
              </div>
              <div class="message-text">Teste de mensagens! Oiiii =D </div>
              <div class="message-time">10/07/2025 19:02</div>
            </div>
            
            <div class="message message-other">
              <div class="message-header">
                <img src="../imagens/roque.jpg" alt="Danieri Ribeiro" class="message-avatar">
                <div class="message-sender membro">Danieri Ribeiro</div>
                <div class="message-actions">
                <button class="reply-btn" title="Responder"><i class="fas fa-reply"></i></button>
            </div>
              </div>
              <div class="message-text">Oiii</div>
              <div class="message-time">10/07/2025 19:03</div>
            </div>
            
            <div class="message message-other">
              <div class="message-header">
                <img src="../imagens/dino.jpg" alt="Dr. Luciano Corsino" class="message-avatar">
                <div class="message-sender coordenador">Dr. Luciano Corsino</div>
                <div class="message-actions">
                <button class="reply-btn" title="Responder"><i class="fas fa-reply"></i></button>
            </div>
              </div>
              <div class="message-text">Oiii</div>
              <div class="message-time">10/07/2025 19:04</div>
            </div>
            
            <div class="message message-self">
              <div class="message-header">
                <img src="../imagens/estrela.jpg" alt="Dr. Daniel Santana" class="message-avatar">
                <div class="message-sender vice-coordenador">Você</div>
                <div class="message-actions">
                <button class="reply-btn" title="Responder"><i class="fas fa-reply"></i></button>
            </div>
              </div>
              <div class="message-text">Oiii</div>
              <div class="message-time">10/07/2025 19:05</div>
            </div>
          
            >
          </div>

          </div>
        </div>

          <div class="reply-container" style="display: none;">
              <div class="reply-content">
                  <span class="reply-label">Respondendo a:</span>
                  <span class="reply-text"></span>
                  <button class="cancel-reply"><i class="fas fa-times"></i></button>
              </div>
          </div>

          <div class="chat-input-container">
            <div class="chat-input">
              <textarea placeholder="Digite sua mensagem..."></textarea>
            </div>
            <div class="chat-actions">
              <button type="button" class="btn-emoji">
                <img src="../../site-front/imagens/emoji.png" alt="emoji" class="emoji-button">
              </button>
              <button type="button" class="btn-enviar">
                <img src="../imagens/enviar.png" alt="enviar" class="enviar-button"> 
              </button>
            </div>
          </div>
        </div>
      </div>

    <?php
      include"../include/footer.php";
    ?>
  </div>
  
  <script src="../script.js"></script>
</body>
</html>