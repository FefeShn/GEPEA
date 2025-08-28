<?php
$paginaAtiva = 'biblioteca-admin'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../admin/biografia-admin.php"; 
require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<body>
  <div class="container-scroller">
   
    <!-- CONTEÚDO PRINCIPAL -->
    <main class="library-container">
      <div class="library-header">
        <h1 class="page-title">Biblioteca</h1>
        <div class="library-actions">
            <button id="openUploadModal" class="add-file-button">
                Upload de Arquivo
            </button>
            <button id="openDeleteModal" class="delete-file-button">
                Excluir Arquivo
            </button>
        </div>
        <p class="page-subtitle">Materiais disponíveis para download</p>
      
      <div class="library-grid">
        <!-- Item 1 -->
        <div class="document-card">
          
          <div class="document-info document-content" >
            <h3>Livro de Exemplo</h3>
            <p class="document-description">Versão 2025 - Atualizado</p>
            <p class="document-date">Postado em: 05/07/2025</p>
          </div>
          <a href="#" class="download-button" download>
            <i class="ti ti-download"></i> Baixar
          </a>
<input type="checkbox" class="file-checkbox" data-file-id="1">
</div>

        <!-- Item 2 -->
        <div class="document-card">
          
          <div class="document-info document-content">
            <h3>Artigo de exemplo</h3>
            <p class="document-description">Artigo sobre pipipipopopo</p>
            <p class="document-date">Postado em: 03/07/2025</p>
          </div>
          <a href="#" class="download-button" download>
            <i class="ti ti-download"></i> Baixar
          </a>
          <input type="checkbox" class="file-checkbox" data-file-id="2">
        </div>

        <!-- 3 -->
        <div class="document-card">
          
          <div class="document-info document-content">
            <h3>Exemplo</h3>
            <p class="document-description">pipipipopopo</p>
            <p class="document-date">Postado em: 03/07/2025</p>
          </div>
          <a href="#" class="download-button" download>
            <i class="ti ti-download"></i> Baixar
          </a>
          <input type="checkbox" class="file-checkbox" data-file-id="3">
        </div>

        <!-- 4 -->
        <div class="document-card">
          
          <div class="document-info document-content">
            <h3>Outro Exemplo</h3>
            <p class="document-description">pipipipopopopoppipipopopopipipipipopo</p>
            <p class="document-date">Postado em: 07/07/2025</p>
          </div>
          <a href="#" class="download-button" download>
            <i class="ti ti-download"></i> Baixar
          </a>
            <input type="checkbox" class="file-checkbox" data-file-id="4">        
        </div>

      </div>
    </main>
    <!-- Modal de Upload -->
<div class="modal-overlay" id="modalUpload">
  <div class="modal-container">
    <div class="modal-header">
      <h3>Upload de Arquivo</h3>
      <button class="close-modal">&times;</button>
    </div>
    <div class="modal-body">
      <form id="uploadForm">
        <div class="form-group">
          <label for="fileTitle">Título do Arquivo</label>
          <input type="text" id="fileTitle" placeholder="Ex: Fighting Words - Patricia Hill Collins" required>
        </div>
        <div class="form-group">
          <label for="fileDescription">Descrição</label>
          <textarea id="fileDescription" rows="3" placeholder="Descreva o conteúdo do arquivo..."></textarea>
        </div>
        <div class="form-group">
          <label for="fileUpload">Selecione o arquivo</label>
          <input type="file" id="fileUpload" accept=".pdf,.doc,.docx" required>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-button">Cancelar</button>
          <button type="submit" class="submit-button">Enviar Arquivo</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
    <div class="modal-overlay" id="modalExcluirMembro" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalExcluirTitle">
    <div class="modal-container confirm-modal">
        <div class="modal-header">
            <h3 id="modalExcluirTitle">Confirmar Exclusão</h3>
            <button class="modal-close" aria-label="Fechar modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Tem certeza que deseja excluir o(s) arquivo(s) selecionado(s)? Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-actions">
            <button class="btn btn-secondary" id="cancelarExclusao">Não, cancelar</button>
            <button class="btn btn-danger" id="confirmarExclusao">Sim, excluir</button>
        </div>
    </div>
</div>
    <!-- FOOTER-->
     <?php
      include"../include/footer.php";
     ?>
      </div>
  </div>
  <script src="../script.js"></script>
</body>
</html>