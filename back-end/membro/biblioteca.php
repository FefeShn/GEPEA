<?php
$paginaAtiva = 'biblioteca'; 
$fotoPerfil  = "../imagens/estrela.jpg"; 
$linkPerfil  = "../membro/biografia-membro.php"; 
require '../include/navbar.php';
require '../include/menu-membro.php';
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
        <p class="page-subtitle">Materiais disponíveis para download</p>
      </div>
      
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
        </div>

      </div>
    </main>

    <!-- FOOTER-->
     <?php
      include"../include/footer.php";
     ?>
      </div>
  </div>
  <script src="../script.js"></script>
</body>
</html>