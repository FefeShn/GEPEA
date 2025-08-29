<?php
$paginaAtiva = 'index'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include"../include/head.php"?>
<body>
  <div class="container-scroller">
      <!-- CONTEÚDO PRINCIPAL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <div class="titulo-publicacoes"> 
                    <h3 class="font-weight-bold">Publicações</h3>
                    <h6 class="font-weight-normal mb-0">Últimas atualizações do grupo</h6>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="row" id="publicacoes-container">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/reuniaogepea.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">13/03/2025</small>
                  </div>
                  <h5 class="card-title">Reunião de Leitura</h5>
                  <p class="card-text">Reunião de leitura para discutir o capítulo do livro "Pensamento Feminista Negro", de Patricia Hill Collins.</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../publicacoes/publicacao1.php" class="btn btn-success">Ver detalhes</a>
                    
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/showgepea.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">10/03/2025</small>
                  </div>
                  <h5 class="card-title">Inauguração de Espaços Afrocentrados</h5>
                  <p class="card-text">Evento de inauguração que contou com a presença de artistas locais.</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../publicacoes/publicacao2.php" class="btn btn-success">Ver detalhes</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/gepeaalvorada.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">25/03/2025</small>
                  </div>
                  <h5 class="card-title">Reunião presencial em Alvorada</h5>
                  <p class="card-text">Membros do GEPEA e bolsistas do grupo se reuniram em Alvorada para planejar próximos passos.</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../publicacoes/publicacao3.php" class="btn btn-success">Ver detalhes</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        <!-- FOOTER -->
        <?php include '../include/footer.php'; ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>