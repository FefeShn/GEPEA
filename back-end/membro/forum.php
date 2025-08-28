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
        <div class="titulo-forum">
          <h3><i class="fas fa-comments"></i> Fórum de Discussões</h3>
          <button class="btn btn-nova-discussao">
            <i class="fas fa-plus"></i> Nova Discussão
          </button>
        </div>

        <div class="discussoes-container" id="discussoes-container">
          <div class="discussao-card">
            <div class="discussao-info">
              <h4>Chat Geral</h4>
              <div class="discussao-meta">
                <span><i class="fas fa-user"></i> Fernanda Sehn</span>
                <span><i class="fas fa-calendar-alt"></i> 10/07/2025</span>
                <span><i class="fas fa-comment"></i> 4 mensagens</span>
              </div>
            </div>

            <div class="discussao-acoes">
              
              <a href="discussao-membros-ex.php" class="btn-acessar">
                <i class="fas fa-comments"></i> Acessar
              </a>
            
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Nova Discussão para Membros -->
<div class="modal-overlay" id="modalNovaDiscussaoMembro">
  <div class="modal-container">
    <div class="modal-header">
      <h3><i class="fas fa-plus-circle"></i> Criar Nova Discussão</h3>
      <button class="modal-close">&times;</button>
    </div>
    <div class="modal-body">
      <form id="formNovaDiscussaoMembro">
        <div class="form-group">
          <label for="tituloDiscussaoMembro"><i class="fas fa-heading"></i> Título*</label>
          <input type="text" id="tituloDiscussaoMembro" placeholder="Dê um título claro para sua discussão" required>
        </div>
        
        <div class="form-group">
          <label for="mensagemDiscussaoMembro"><i class="fas fa-comment-dots"></i> Mensagem (opcional)</label>
          <textarea id="mensagemDiscussaoMembro" placeholder="Descreva sua discussão com detalhes..."></textarea>
        </div>
        
        <div class="modal-actions">
          <button type="button" class="cancel-button">Cancelar</button>
          <button type="submit" class="submit-button">Criar Discussão</button>
        </div>
      </form>
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